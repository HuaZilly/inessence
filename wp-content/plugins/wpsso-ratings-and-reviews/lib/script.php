<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRarScript' ) ) {

	class WpssoRarScript {

		private $p;	// Wpsso class object.
		private $a;	// WpssoRar class object.

		/**
		 * Instantiated by WpssoRar->init_objects().
		 */
		public function __construct( &$plugin, &$addon ) {

			$this->p =& $plugin;
			$this->a =& $addon;

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), WPSSO_ADMIN_SCRIPTS_PRIORITY );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		public function admin_enqueue_scripts( $hook_name ) {

			$plugin_version = WpssoRarConfig::get_version();

			/**
			 * Don't load our javascript where we don't need it.
			 */
			switch ( $hook_name ) {

				case 'edit.php':

					wp_enqueue_script( 'wpsso-rar-admin-script',
						WPSSORAR_URLPATH . 'js/admin-script.min.js',
							array( 'jquery' ), $plugin_version, $in_footer = true );

					break;	// Stop here.
			}

		}

		public function enqueue_scripts() {

			if ( ! WpssoRarComment::is_rating_enabled( get_the_ID() ) ) {

				return;
			}

			$plugin_version = WpssoRarConfig::get_version();

			wp_enqueue_script( 'wpsso-rar-script',
				WPSSORAR_URLPATH . 'js/script.min.js',
					array( 'jquery' ), $plugin_version );

			wp_localize_script( 'wpsso-rar-script',
				'wpsso_rar_script', $this->get_script_data() );
		}

		public function get_script_data() {

			$is_reply = empty( $_GET[ 'replytocom' ] ) ? false : true;

			return array(
				'_required_rating_transl' => esc_attr__( 'Please select a rating before submitting.', 'wpsso-ratings-and-reviews' ),
				'_required_review_transl' => esc_attr__( 'Please write a review before submitting.', 'wpsso-ratings-and-reviews' ),
				'_rating_required'        => empty( $this->p->options[ 'rar_rating_required' ] ) || $is_reply ? false : true,
			);
		}
	}
}
