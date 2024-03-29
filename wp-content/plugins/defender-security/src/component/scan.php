<?php

namespace WP_Defender\Component;

use WP_Defender\Behavior\Scan\Core_Integrity;
use WP_Defender\Behavior\Scan\Gather_Fact;
use WP_Defender\Behavior\Scan\Known_Vulnerability;
use WP_Defender\Behavior\Scan\Malware_Scan;
use WP_Defender\Behavior\Scan\Plugin_Integrity;
use WP_Defender\Behavior\WPMUDEV;
use WP_Defender\Component;
use WP_Defender\Model\Scan_Item;
use WP_Defender\Model\Scan as Model_Scan;

class Scan extends Component {

	/**
	 * Cache the current scan.
	 *
	 * @var \WP_Defender\Model\Scan
	 */
	public $scan;

	/**
	 * @var \WP_Defender\Model\Setting\Scan
	 */
	public $settings;

	public function __construct() {
		$this->attach_behavior( WPMUDEV::class, WPMUDEV::class );
		$this->attach_behavior( Gather_Fact::class, Gather_Fact::class );
		$this->attach_behavior( Core_Integrity::class, Core_Integrity::class );
		$this->attach_behavior( Plugin_Integrity::class, Plugin_Integrity::class );
		if ( class_exists( Known_Vulnerability::class ) ) {
			$this->attach_behavior( Known_Vulnerability::class, new Known_Vulnerability() );
		}
		if ( class_exists( Malware_Scan::class ) ) {
			$this->attach_behavior( Malware_Scan::class, new Malware_Scan() );
		}
	}

	/**
	 * @param object $model
	 */
	public function advanced_scan_actions( $model ) {
		$this->reindex_ignored_issues( $model );
		$this->clean_up();
	}

	/**
	 * Process current scan.
	 *
	 * @return bool
	 * @throws \ReflectionException
	 */
	public function process() {
		$scan = Model_Scan::get_active();
		if ( ! is_object( $scan ) ) {
			// This case can be a scan get cancel.
			return - 1;
		}
		$this->scan     = $scan;
		$this->settings = new \WP_Defender\Model\Setting\Scan();
		$tasks          = $this->get_tasks();
		$runner         = new \ArrayIterator( $tasks );
		$task           = $this->scan->status;
		if ( Model_Scan::STATUS_INIT === $scan->status ) {
			// Get the first.
			$this->log( 'Prepare facts for a scan', 'scan' );
			$task                    = 'gather_fact';
			$this->scan->percent     = 0;
			$this->scan->total_tasks = $runner->count();
			$this->scan->save();
		}
		if (
			in_array(
				$this->scan->status,
				array(
					Model_Scan::STATUS_ERROR,
					Model_Scan::STATUS_IDLE
				),
				true
			)
		) {
			// Stop and return true to abort the process.
			return true;
		}
		// Find the current task.
		$offset = array_search( $task, array_values( $tasks ) );
		if ( false === $offset ) {
			$this->log( sprintf( 'offset is not found, search %s', $task ), 'scan' );

			return false;
		}
		// Reset the tasks to current.
		$runner->seek( $offset );
		$this->log( sprintf( 'Current task %s', $runner->current() ), 'scan' );
		if ( $this->has_method( $task ) ) {
			$this->log( sprintf( 'processing %s', $runner->key() ), 'scan' );
			$result = $this->$task();
			if ( true === $result ) {
				$this->log( sprintf( 'task %s processed', $runner->key() ), 'scan' );
				// Task is done, move to next.
				$runner->next();
				if ( $runner->valid() ) {
					$this->log( sprintf( 'queue %s for next', $runner->key() ), 'scan' );
					$this->scan->status          = $runner->key();
					$this->scan->task_checkpoint = '';
					$this->scan->date_end        = gmdate( 'Y-m-d H:i:s' );
					$this->scan->save();

					// Queue for next run.
					return false;
				}
				$this->log( 'All done!', 'scan' );
				// No more task in the queue, we are done.
				$this->scan->status = Model_Scan::STATUS_FINISH;
				$this->scan->save();
				$this->advanced_scan_actions( $this->scan );
				do_action( 'defender_notify', 'malware-notification', $this->scan );

				return true;
			}
			$this->scan->status = $task;
			$this->scan->save();
		}

		return false;
	}

	/**
	 * @param \WP_Defender\Model\Scan $model
	 */
	private function reindex_ignored_issues( $model ) {
		$issues       = $model->get_issues( null, Scan_Item::STATUS_IGNORE );
		$ignore_lists = [];
		foreach ( $issues as $issue ) {
			$data = $issue->raw_data;
			if ( isset( $data['file'] ) ) {
				$ignore_lists[] = $data['file'];
			} elseif ( isset( $data['slug'] ) ) {
				$ignore_lists[] = $data['slug'];
			}
		}
		$model->update_ignore_list( $ignore_lists );
	}

	/**
	 * Get a list of tasks will run in a scan.
	 *
	 * @return array
	 */
	public function get_tasks() {
		$tasks = [
			'gather_fact' => 'gather_fact',
		];
		if ( $this->settings->integrity_check ) {
			/**
			 * @since 2.4.7
			*/
			if ( $this->settings->check_core ) {
				$tasks['core_integrity_check'] = 'core_integrity_check';
			}
			if ( $this->settings->check_plugins ) {
				$tasks['plugin_integrity_check'] = 'plugin_integrity_check';
			}
		}
		if ( $this->is_pro() ) {
			if ( $this->settings->check_known_vuln ) {
				if ( $this->has_method( 'vuln_check' ) ) {
					$tasks['vuln_check'] = 'vuln_check';
				}
			}
			if ( $this->settings->scan_malware ) {
				if ( $this->has_method( 'suspicious_check' ) ) {
					$tasks['suspicious_check'] = 'suspicious_check';
				}
			}
		}

		return $tasks;
	}

	public function cancel_a_scan() {
		$scan = Model_Scan::get_active();
		if ( is_object( $scan ) ) {
			$scan->delete();
		}
		$this->clean_up();
		$this->remove_lock();
	}

	/**
	 * Clean up data generate by current scan.
	 */
	public function clean_up() {
		$this->delete_interim_data();

		$models = Model_Scan::get_last_all();
		if ( ! empty( $models ) ) {
			// Remove the latest. Don't remove code to find the first value.
			$current = array_shift( $models );
			foreach ( $models as $model ) {
				$model->delete();
			}
		}
	}

	/**
	 * Create a file lock, so we can check if a process already running.
	 */
	public function create_lock() {
		file_put_contents( $this->get_lock_path(), time(), LOCK_EX );
	}

	/**
	 * Delete file lock.
	 */
	public function remove_lock() {
		@unlink( $this->get_lock_path() );
	}

	/**
	 * Check if a lock is valid.
	 *
	 * @return bool
	 */
	public function has_lock() {
		if ( ! file_exists( $this->get_lock_path() ) ) {
			return false;
		}
		$time = file_get_contents( $this->get_lock_path() );
		if ( strtotime( '+90 seconds', $time ) < time() ) {
			// Usually a timeout window is 30 seconds, so we should allow lock at 1.30min for safe.
			return false;
		}

		return true;
	}

	/**
	 * Get the total scanning active issues.
	 * 
	 * @return integer $count
	 */
	public function indicator_issue_count() {
		$count = 0;
		$scan  = Model_Scan::get_last();
		if ( is_object( $scan ) && ! is_wp_error( $scan ) ) {
			// Only Scan issues.
			$count = count( $scan->get_issues( null, \WP_Defender\Model\Scan_Item::STATUS_ACTIVE ) );
		}

		return $count;
	}

	/**
	 * @param array $scan_settings
	 * @param bool  $is_pro
	 *
	 * @return bool
	 */
	public function is_any_scan_active( $scan_settings, $is_pro ) {
		if ( empty( $scan_settings['integrity_check'] ) ) {
			$integrity_check = false;
		} elseif (
			! empty( $scan_settings['integrity_check'] )
			&& empty( $scan_settings['check_core'] )
			&& empty( $scan_settings['check_plugins'] )
		) {
			$integrity_check = false;
		} else {
			$integrity_check = true;
		}

		if ( ! $integrity_check && ! $is_pro ) {

			return false;
		} elseif (
			! $integrity_check
			&& empty( $scan_settings['check_known_vuln'] )
			&& empty( $scan_settings['scan_malware'] )
			&& ! $is_pro
		) {

			return false;
		}

		return true;
	}

	/**
	 * Update the idle scan status.
	 *
	 * @since 2.6.1
	 */
	public function update_idle_scan_status() {
		$idle_scan = wd_di()->get( Model_Scan::class )->get_idle();

		if ( is_object( $idle_scan ) ) {
			$ready_to_send = false;
			if ( Model_Scan::STATUS_IDLE === $idle_scan->status) {
				$ready_to_send = true;
			}
			$this->delete_interim_data();

			as_unschedule_all_actions( 'defender/async_scan' );

			$idle_scan->status = Model_Scan::STATUS_IDLE;
			$idle_scan->save();

			$this->remove_lock();
			if ( $ready_to_send ) {
				do_action( 'defender_notify', 'malware-notification', $idle_scan );
			}
		}
	}

	/**
	 * Clear all temporary scan data.
	 *
	 * @since 2.6.1
	 */
	private function delete_interim_data() {
		delete_site_option( Gather_Fact::CACHE_CORE );
		delete_site_option( Gather_Fact::CACHE_CONTENT );
		delete_site_option( Malware_Scan::YARA_RULES );
		delete_site_option( Core_Integrity::CACHE_CHECKSUMS );
		delete_site_option( Plugin_Integrity::PLUGIN_SLUGS );
		delete_site_option( Plugin_Integrity::PLUGIN_PREMIUM_SLUGS );
	}
}
