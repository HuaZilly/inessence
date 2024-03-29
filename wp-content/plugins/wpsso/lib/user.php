<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2012-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! defined( 'WPSSO_PLUGINDIR' ) ) {

	die( 'Do. Or do not. There is no try.' );
}

if ( ! class_exists( 'WpssoWpMeta' ) ) {

	require_once dirname( __FILE__ ) . '/abstracts/wp-meta.php';	// SucomAddOn class.
}

if ( ! class_exists( 'WpssoUser' ) ) {

	class WpssoUser extends WpssoWpMeta {

		private static $cache_user_prefs = array();	// Used by get_pref() and save_pref().

		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			add_action( 'wp_loaded', array( $this, 'add_wp_hooks' ) );
		}

		/**
		 * Add WordPress action and filters hooks.
		 */
		public function add_wp_hooks() {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$is_admin = is_admin();	// Only check once.

			$cm_fb_name = $this->p->options[ 'plugin_cm_fb_name' ];

			if ( ! SucomUtilWP::role_exists( 'person' ) ) {

				$role_label = _x( 'Person', 'user role', 'wpsso' );

				add_role( 'person', $role_label, array() );
			}

			if ( ! empty( $this->p->options[ 'plugin_new_user_is_person' ] ) ) {

				if ( is_multisite() ) {

					add_action( 'wpmu_new_user', array( __CLASS__, 'add_role_by_id' ), 20, 1 );

				} else {

					add_action( 'user_register', array( __CLASS__, 'add_role_by_id' ), 20, 1 );
				}
			}

			add_filter( 'user_contactmethods', array( $this, 'add_contact_methods' ), 20, 2 );

			add_filter( 'user_' . $cm_fb_name . '_label', array( $this, 'modify_fb_contact_label' ), 20, 1 );

			add_action( 'wpsso_add_person_role', array( $this, 'add_person_role' ), 10, 1 );	// For single scheduled task.

			add_action( 'wpsso_remove_person_role', array( $this, 'remove_person_role' ), 10, 1 );	// For single scheduled task.

			/**
			 * Hook a minimum number of admin actions to maximize performance. The user_id argument is 
			 * always present when we're editing a user, but missing when viewing our own profile page.
			 */
			if ( $is_admin ) {

				if ( ! empty( $_GET ) ) {

					/**
					 * Common to both profile and user editing pages.
					 */
					add_action( 'admin_init', array( $this, 'add_meta_boxes' ) );

					/**
					 * load_meta_page() priorities: 100 post, 200 user, 300 term.
					 *
					 * Sets the parent::$head_tags and parent::$head_info class properties.
					 */
					add_action( 'current_screen', array( $this, 'load_meta_page' ), 200, 1 );
				}

				add_filter( 'views_users', array( $this, 'add_person_view' ) );

				/**
				 * Add edit table columns.
				 */
				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'adding column filters for users' );
				}

				add_filter( 'manage_users_columns', array( $this, 'add_user_column_headings' ), WPSSO_ADD_COLUMN_PRIORITY, 1 );
				add_filter( 'manage_users_sortable_columns', array( $this, 'add_sortable_columns' ), 10, 1 );
				add_filter( 'manage_users_custom_column', array( $this, 'get_column_content' ), 10, 3 );

				/**
				 * The 'parse_query' action is hooked once in the WpssoPost class to set the column orderby for
				 * post, term, and user edit tables. This comment is only here as a reminder - do not uncomment the
				 * following 'parse_query' action hook.
				 *
				 * add_action( 'parse_query', array( $this, 'set_column_orderby' ), 10, 1 );
				 */

				/**
				 * Maybe create or update the user column content.
				 */
				add_action( 'get_user_metadata', array( $this, 'check_sortable_meta' ), 10, 4 );

				/**
				 * Hooks when editing a user.
				 */
				add_action( 'edit_user_profile', array( $this, 'show_metabox_section' ), 20, 1 );

				add_action( 'edit_user_profile_update', array( $this, 'save_about_section' ), -1000, 1 );
				add_action( 'edit_user_profile_update', array( $this, 'sanitize_submit_cm' ), -200, 1 );
				add_action( 'edit_user_profile_update', array( $this, 'save_options' ), WPSSO_META_SAVE_PRIORITY, 1 );	// Default is -100.
				add_action( 'edit_user_profile_update', array( $this, 'clear_cache' ), WPSSO_META_CACHE_PRIORITY, 1 );	// Default is -10.

				/**
				 * Hooks when editing personal profile.
				 */
				add_action( 'personal_options_update', array( $this, 'save_about_section' ), -1000, 1 );
				add_action( 'personal_options_update', array( $this, 'sanitize_submit_cm' ), -200, 1 );
				add_action( 'personal_options_update', array( $this, 'save_options' ), WPSSO_META_SAVE_PRIORITY, 1 );	// Default is -100.
				add_action( 'personal_options_update', array( $this, 'clear_cache' ), WPSSO_META_CACHE_PRIORITY, 1 );	// Default is -10.

				/**
				 * Use the 'show_password_fields' filter as an action to get more information about the user.
				 */
				add_filter( 'show_password_fields', array( $this, 'pre_password_fields' ), -1000, 2 );
			}
		}

		/**
		 * Get the $mod object for a user ID.
		 */
		public function get_mod( $user_id ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			static $local_cache = array();

			if ( isset( $local_cache[ $user_id ] ) ) {

				return $local_cache[ $user_id ];
			}

			$mod = self::get_mod_defaults();

			/**
			 * Common elements.
			 */
			$mod[ 'id' ]          = is_numeric( $user_id ) ? (int) $user_id : 0;	// Cast as integer.
			$mod[ 'name' ]        = 'user';
			$mod[ 'name_transl' ] = _x( 'user', 'module name', 'wpsso' );
			$mod[ 'obj' ]         =& $this;

			/**
			 * WpssoUser elements.
			 */
			$mod[ 'is_user' ] = true;

			return $local_cache[ $user_id ] = apply_filters( 'wpsso_get_user_mod', $mod, $user_id );
		}

		/**
		 * Option handling methods:
		 *
		 *	get_defaults()
		 *	get_options()
		 *	save_options()
		 *	delete_options()
		 */
		public function get_options( $user_id, $md_key = false, $filter_opts = true, $pad_opts = false ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log_args( array( 
					'user_id'     => $user_id,
					'md_key'      => $md_key,
					'filter_opts' => $filter_opts,
					'pad_opts'    => $pad_opts,	// Fallback to value in meta defaults.
				) );
			}

			$user_id = false === $user_id ? get_current_user_id() : $user_id;

			if ( empty( $user_id ) ) {

				if ( false !== $md_key ) {

					return null;
				}

				return array();
			}

			static $local_cache = array();

			/**
			 * Use $user_id and $filter_opts to create the cache ID string, but do not add $pad_opts.
			 */
			$cache_id = SucomUtil::get_assoc_salt( array( 'id' => $user_id, 'filter' => $filter_opts ) );

			/**
			 * Maybe initialize the cache.
			 */
			if ( ! isset( $local_cache[ $cache_id ] ) ) {

				$local_cache[ $cache_id ] = null;

			} elseif ( $this->md_cache_disabled ) {

				$local_cache[ $cache_id ] = null;
			}

			$md_opts =& $local_cache[ $cache_id ];	// Shortcut variable name.

			if ( null === $md_opts ) {

				$user_exists = SucomUtilWP::user_exists( $user_id );

				if ( $user_exists ) {

					$user_exists_id = $user_id;

					$md_opts = get_user_meta( $user_exists_id, WPSSO_META_NAME, $single = true );

					if ( ! is_array( $md_opts ) ) {

						$md_opts = array();
					}

				} else {

					$user_exists_id = 0;

					$md_opts = (array) apply_filters( 'wpsso_get_other_user_meta', array(), $user_id );
				}

				/**
				 * Check if options need to be upgraded and saved.
				 */
				if ( $this->is_upgrade_options_required( $md_opts ) ) {

					$md_opts = $this->upgrade_options( $md_opts, $user_exists_id );

					if ( $user_exists ) {

						update_user_meta( $user_exists_id, WPSSO_META_NAME, $md_opts );

					} else {

						apply_filters( 'wpsso_update_other_user_meta', $md_opts, $user_id );
					}

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'user_id ' . $user_id . ' settings upgraded' );
					}
				}

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log_arr( 'user_id ' . $user_id . ' meta options read', $md_opts );
				}
			}

			if ( $filter_opts ) {

				if ( empty( $md_opts[ 'options_filtered' ] ) ) {

					$md_opts[ 'options_filtered' ] = 1;	// Set before calling filter to prevent recursion.

					$mod = $this->get_mod( $user_id );

					/**
					 * Since WPSSO Core v7.1.0.
					 */
					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'applying get_md_options filters' );
					}

					$md_opts = (array) apply_filters( 'wpsso_get_md_options', $md_opts, $mod );

					/**
					 * Since WPSSO Core v4.31.0.
					 */
					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'applying get_user_options filters for user_id ' . $user_id . ' meta' );
					}

					$md_opts = (array) apply_filters( 'wpsso_get_user_options', $md_opts, $user_id, $mod );

					/**
					 * Since WPSSO Core v8.2.0.
					 */
					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'applying sanitize_md_options filters' );
					}

					$md_opts = apply_filters( 'wpsso_sanitize_md_options', $md_opts, $mod );
				}
			}

			return $this->return_options( $user_id, $md_opts, $md_key, $pad_opts );
		}

		public function save_options( $user_id, $rel_id = false ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			/**
			 * Make sure the current user can submit and same metabox options.
			 */
			if ( ! $this->user_can_save( $user_id, $rel_id ) ) {

				return;
			}

			$this->md_cache_disabled = true;	// Disable local cache for get_defaults() and get_options().

			$mod = $this->get_mod( $user_id );

			/**
			 * Merge and check submitted post, term, and user metabox options.
			 */
			$opts = $this->get_submit_opts( $mod );

			$opts = apply_filters( 'wpsso_save_md_options', $opts, $mod );

			$opts = apply_filters( 'wpsso_save_user_options', $opts, $user_id, $rel_id, $mod );

			if ( empty( $opts ) ) {

				return delete_user_meta( $user_id, WPSSO_META_NAME );
			}

			return update_user_meta( $user_id, WPSSO_META_NAME, $opts );
		}

		public function delete_options( $user_id, $rel_id = false ) {

			return delete_user_meta( $user_id, WPSSO_META_NAME );
		}

		/**
		 * Get all publicly accessible user IDs in the 'creator' array.
		 */
		public static function get_public_ids() {

			$wpsso =& Wpsso::get_instance();

			/**
			 * Default 'creator' roles are:
			 *
			 * 'creator' => array(	// Users that can write posts.
			 *	'administrator',
			 *	'editor',
			 *	'author',
			 *	'contributor',
			 * );
			 */
			$roles = $wpsso->cf[ 'wp' ][ 'roles' ][ 'creator' ];

			return SucomUtilWP::get_roles_user_ids( $roles );
		}

		/**
		 * Get post IDs authored by a user ID.
		 *
		 * Return an array of post IDs for a given $mod object.
		 *
		 * Called by WpssoWpMeta->get_posts_mods().
		 */
		public function get_posts_ids( array $mod, array $extra_args = array() ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$posts_args = array_merge( array(
				'has_password' => false,
				'order'        => 'DESC',		// Newest first.
				'orderby'      => 'date',
				'post_status'  => 'publish',		// Only 'publish', not 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', or 'trash'.
				'post_type'    => 'post',		// Return only posts authored by the user.
				'author'       => $mod[ 'id' ],
			), $extra_args, array( 'fields' => 'ids' ) );	// Return an array of post IDs.

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'calling get_posts() for posts authored by ' . $mod[ 'name' ] . ' ID ' . $mod[ 'id' ] );
			}

			$mtime_start = microtime( $get_float = true );
			$post_ids    = get_posts( $posts_args );
			$mtime_total = microtime( $get_float = true ) - $mtime_start;
			$mtime_max   = WPSSO_GET_POSTS_MAX_TIME;

			if ( $mtime_total > $mtime_max ) {

				$func_name   = 'get_posts()';
				$error_pre   = sprintf( __( '%s warning:', 'wpsso' ), __METHOD__ );
				$rec_max_msg = sprintf( __( 'longer than recommended max of %1$.3f secs', 'wpsso' ), $mtime_max );
				$error_msg   = sprintf( __( 'Slow WordPress function detected - %1$s took %2$.3f secs to get posts authored by user ID %3$d (%4$s).',
					'wpsso' ), '<code>' . $func_name . '</code>', $mtime_total, $mod[ 'id' ], $rec_max_msg );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( sprintf( 'slow WordPress function detected - %1$s took %2$.3f secs to get posts authored by user ID %3$d',
						$func_name, $mtime_total, $mod[ 'id' ] ) );
				}

				if ( $this->p->notice->is_admin_pre_notices() ) {

					$this->p->notice->warn( $error_msg );
				}

				SucomUtil::safe_error_log( $error_pre . ' ' . $error_msg, $strip_html = true );
			}

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( count( $post_ids ) . ' post IDs returned in ' . sprintf( '%0.3f secs', $mtime_total ) );
			}

			return $post_ids;
		}

		public function add_user_column_headings( $columns ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			return $this->add_column_headings( $columns, $list_type = 'user' );
		}

		/**
		 * Hooked into the current_screen action.
		 *
		 * Sets the parent::$head_tags and parent::$head_info class properties.
		 */
		public function load_meta_page( $screen = false ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			/**
			 * All meta modules set this property, so use it to optimize code execution.
			 */
			if ( false !== parent::$head_tags || ! isset( $screen->id ) ) {

				return;
			}

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'screen id = ' . $screen->id );
			}

			switch ( $screen->id ) {

				case ( 0 === strpos( $screen->id, 'users_page_wpsso-add-' ) ? true : false ):	// Add user page.

					$user_id = null;

					$mod = $this->get_mod( null );

					break;

				case 'profile':		// User profile page.
				case 'user-edit':	// User editing page.
				case ( 0 === strpos( $screen->id, 'profile_page_' ) ? true : false ):			// Your profile page.
				case ( 0 === strpos( $screen->id, 'users_page_' . $this->p->id ) ? true : false ):	// Users settings page.

					/**
					 * Get the user ID.
					 *
					 * Returns the current user ID if the 'user_id' query argument is empty.
					 */
					$user_id = SucomUtil::get_user_object( false, 'id' );

					$mod = $this->get_mod( $user_id );

					break;

				default:

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'exiting early: not a recognized user page' );
					}

					return;
			}

			/**
			 * Define parent::$head_tags and signal to other 'current_screen' actions that this is a valid user page.
			 */
			parent::$head_tags = array();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'user ID = ' . $user_id );
				$this->p->debug->log( 'home url = ' . get_option( 'home' ) );
				$this->p->debug->log( 'locale default = ' . SucomUtil::get_locale( 'default' ) );
				$this->p->debug->log( 'locale current = ' . SucomUtil::get_locale( 'current' ) );
				$this->p->debug->log( 'locale mod = ' . SucomUtil::get_locale( $mod ) );
				$this->p->debug->log( SucomUtil::pretty_array( $mod ) );
			}

			if ( $user_id && ! empty( $this->p->options[ 'plugin_add_to_user_page' ] ) ) {

				do_action( 'wpsso_admin_user_head', $mod, $screen->id );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'setting head_meta_info static property' );
				}

				/**
				 * $read_cache is false to generate notices etc.
				 */
				parent::$head_tags = $this->p->head->get_head_array( $use_post = false, $mod, $read_cache = false );

				parent::$head_info = $this->p->head->extract_head_info( $mod, parent::$head_tags );

				/**
				 * Check for missing open graph image and description values.
				 */
				if ( $mod[ 'is_public' ] ) {	// Since WPSSO Core v7.0.0.

					$ref_url = empty( parent::$head_info[ 'og:url' ] ) ? null : parent::$head_info[ 'og:url' ];

					$ref_url = $this->p->util->maybe_set_ref( $ref_url, $mod, __( 'checking meta tags', 'wpsso' ) );

					foreach ( array( 'image', 'description' ) as $mt_suffix ) {

						if ( empty( parent::$head_info[ 'og:' . $mt_suffix ] ) ) {

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log( 'og:' . $mt_suffix . ' meta tag is value empty and required' );
							}

							/**
							 * An is_admin() test is required to use the WpssoMessages class.
							 */
							if ( $this->p->notice->is_admin_pre_notices() ) {

								$notice_msg = $this->p->msgs->get( 'notice-missing-og-' . $mt_suffix );

								$notice_key = $mod[ 'name' ] . '-' . $mod[ 'id' ] . '-notice-missing-og-' . $mt_suffix;

								$this->p->notice->err( $notice_msg, null, $notice_key );
							}
						}
					}

					$this->p->util->maybe_unset_ref( $ref_url );
				}
			}

			$action_query = 'wpsso-action';

			if ( ! empty( $_GET[ $action_query ] ) ) {

				$action_name = SucomUtil::sanitize_hookname( $_GET[ $action_query ] );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'found action query: ' . $action_name );

				}

				if ( empty( $_GET[ WPSSO_NONCE_NAME ] ) ) {	// WPSSO_NONCE_NAME is an md5() string

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'nonce token query field missing' );
					}

				} elseif ( ! wp_verify_nonce( $_GET[ WPSSO_NONCE_NAME ], WpssoAdmin::get_nonce_action() ) ) {

					$this->p->notice->err( sprintf( __( 'Nonce token validation failed for %1$s action "%2$s".', 'wpsso' ), 'user', $action_name ) );

				} else {

					$_SERVER[ 'REQUEST_URI' ] = remove_query_arg( array( $action_query, WPSSO_NONCE_NAME ) );

					switch ( $action_name ) {

						default:

							do_action( 'wpsso_load_meta_page_user_' . $action_name, $user_id, $screen->id );

							break;
					}
				}
			}
		}

		public function add_meta_boxes() {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$user_id = SucomUtil::get_user_object( false, 'id' );

			if ( ! current_user_can( 'edit_user', $user_id ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: user cannot edit user id ' . $user_id );
				}

				return;
			}

			if ( empty( $this->p->options[ 'plugin_add_to_user_page' ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: cannot add metabox to user page' );
				}

				return;
			}

			$metabox_id      = $this->p->cf[ 'meta' ][ 'id' ];
			$metabox_title   = _x( $this->p->cf[ 'meta' ][ 'title' ], 'metabox title', 'wpsso' );
			$metabox_screen  = 'wpsso-user';
			$metabox_context = 'normal';
			$metabox_prio    = 'default';
			$callback_args   = array(	// Second argument passed to the callback.
				'__block_editor_compatible_meta_box' => true,
			);

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'adding metabox id wpsso_' . $metabox_id );
			}

			add_meta_box( 'wpsso_' . $metabox_id, $metabox_title,
				array( $this, 'show_metabox_document_meta' ), $metabox_screen,
					$metabox_context, $metabox_prio, $callback_args );
		}

		/**
		 * Show additional fields in the user profile About Yourself / About the user sections.
		 *
		 * Hooked to the 'show_password_fields' filter (not an action).
		 */
		public function pre_password_fields( $show_password_fields, $user_obj ) {

			if ( ! isset( $user_obj->ID ) ) {	// Just in case.

				/**
				 * This is a filter, so return the filter value unchanged.
				 */
				return $show_password_fields;
			}

			if ( ! current_user_can( 'edit_user', $user_obj->ID ) ) {	// Just in case.

				/**
				 * This is a filter, so return the filter value unchanged.
				 */
				return $show_password_fields;
			}

			$this->show_about_section( $user_obj->ID );	// Echo the additional input fields.

			/**
			 * This is a filter, so return the filter value unchanged.
			 */
			return $show_password_fields;
		}

		/**
		 * Called by the WpssoUser->pre_password_fields() and WpssoUsersAddPerson->show_post_body_setting_form() methods.
		 */
		public function show_about_section( $user_id = 0 ) {

			foreach ( $this->p->cf[ 'opt' ][ 'user_about' ] as $key => $label ) {

				if ( empty( $this->p->options[ 'plugin_user_about_' . $key ] ) ) {

					continue;
				}

				$val = '';

				if ( $user_id ) {	// 0 when adding a new user.

					$val = get_user_meta( $user_id, $key, $single = true );
				}

				echo '<tr>';

				echo '<th><label for="' . $key . '">' . esc_html( _x( $label, 'option label', 'wpsso' ) ) . '</label></th><td>';

				switch ( $key ) {

					/**
					 * Regular text input fields.
					 */
					default:

						echo '<input type="text" class="regular-text" name="' . $key . '" id="' . $key . '" value="' . esc_attr( $val ) . '">';

						break;
				}

				switch ( $key ) {

					case 'honorific_prefix':

						echo '<p class="description">' . __( 'Examples: Dr, Mrs, Mr.', 'wpsso' ) . '</p>';

						break;

					case 'honorific_suffix':

						echo '<p class="description">' . __( 'Examples: CPA, Esq., M.D., P.E., PhD., PMP, RN', 'wpsso' ) . '</p>';

						break;
				}

				echo '</td></tr>';
			}
		}

		public function show_metabox_section( $user_obj ) {

			if ( ! isset( $user_obj->ID ) ) {	// Just in case.

				return;
			}

			if ( ! current_user_can( 'edit_user', $user_obj->ID ) ) {	// Just in case.

				return;
			}

			if ( empty( $this->p->options[ 'plugin_add_to_user_page' ] ) ) {

				return;
			}

			$pkg_info        = $this->p->admin->get_pkg_info();	// Returns an array from cache.
			$metabox_screen  = 'wpsso-user';
			$metabox_context = 'normal';

			echo "\n" . '<!-- wpsso user metabox section begin -->' . "\n";
			echo '<h3>' . $pkg_info[ 'wpsso' ][ 'short_dist' ] . '</h3>' . "\n";
			echo '<div id="poststuff" class="wpsso-metaboxes metabox-holder">' . "\n";

			do_meta_boxes( $metabox_screen, $metabox_context, $user_obj );

			echo "\n" . '</div><!-- #poststuff -->' . "\n";
			echo '<!-- wpsso user metabox section end -->' . "\n";
		}

		public function ajax_get_metabox_document_meta() {

			die( -1 );	// Nothing to do.
		}

		public function get_metabox_document_meta( $user_obj ) {

			$metabox_id = $this->p->cf[ 'meta' ][ 'id' ];
			$mod        = $this->get_mod( $user_obj->ID );
			$tabs       = $this->get_document_meta_tabs( $metabox_id, $mod );
			$opts       = $this->get_options( $user_obj->ID );
			$def_opts   = $this->get_defaults( $user_obj->ID );

			$this->p->admin->get_pkg_info();	// Returns an array from cache.

			$this->form = new SucomForm( $this->p, WPSSO_META_NAME, $opts, $def_opts, $this->p->id );

			wp_nonce_field( WpssoAdmin::get_nonce_action(), WPSSO_NONCE_NAME );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark( $metabox_id . ' table rows' );	// start timer
			}

			$table_rows = array();

			foreach ( $tabs as $tab_key => $title ) {

				$mb_filter_name  = 'wpsso_metabox_' . $metabox_id . '_' . $tab_key . '_rows';
				$mod_filter_name = 'wpsso_' . $mod[ 'name' ] . '_' . $tab_key . '_rows';

				$table_rows[ $tab_key ] = (array) apply_filters( $mb_filter_name,
					array(), $this->form, parent::$head_info, $mod );

				$table_rows[ $tab_key ] = (array) apply_filters( $mod_filter_name,
					$table_rows[ $tab_key ], $this->form, parent::$head_info, $mod );
			}

			$tabbed_args = array( 'layout' => 'vertical' );

			$mb_container_id = 'wpsso_metabox_' . $metabox_id . '_inside';

			$metabox_html = "\n" . '<div id="' . $mb_container_id . '">';

			$metabox_html .= $this->p->util->metabox->get_tabbed( $metabox_id, $tabs, $table_rows, $tabbed_args );

			$metabox_html .= '<!-- ' . $mb_container_id . '_footer begin -->' . "\n";

			$metabox_html .= apply_filters( $mb_container_id . '_footer', '', $mod );

			$metabox_html .= '<!-- ' . $mb_container_id . '_footer end -->' . "\n";

			$metabox_html .= $this->get_metabox_javascript( $mb_container_id );

			$metabox_html .= '</div><!-- #'. $mb_container_id . ' -->' . "\n";

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark( $metabox_id . ' table rows' );	// End timer.
			}

			return $metabox_html;
		}

		public function get_form_contact_fields( $fields = array() ) {

			return array( 'none' => '[None]' ) + $this->add_contact_methods( array(
				'author' => 'Author Archive',
				'url'    => 'WebSite'
			) );
		}

		public function add_contact_methods( $fields = array(), $user = null ) {

			/**
			 * Unset built-in contact fields and/or update their labels.
			 */
			if ( ! empty( $this->p->cf[ 'wp' ][ 'cm_names' ] ) && is_array( $this->p->cf[ 'wp' ][ 'cm_names' ] ) ) {

				foreach ( $this->p->cf[ 'wp' ][ 'cm_names' ] as $id => $desc ) {

					$cm_enabled_key = 'wp_cm_' . $id . '_enabled';
					$cm_label_key   = 'wp_cm_' . $id . '_label';

					if ( isset( $this->p->options[ $cm_enabled_key ] ) ) {

						if ( ! empty( $this->p->options[ $cm_enabled_key ] ) ) {

							$cm_label_value = SucomUtil::get_key_value( $cm_label_key, $this->p->options );

							if ( ! empty( $cm_label_value ) ) {	// Just in case.

								$fields[ $id ] = $cm_label_value;
							}

						} else {

							unset( $fields[ $id ] );
						}
					}
				}
			}

			/**
			 * Loop through each social website option prefix.
			 */
			foreach ( $this->p->cf[ 'opt' ][ 'cm_prefix' ] as $id => $opt_pre ) {

				$cm_enabled_key = 'plugin_cm_' . $opt_pre . '_enabled';
				$cm_name_key    = 'plugin_cm_' . $opt_pre . '_name';
				$cm_label_key   = 'plugin_cm_' . $opt_pre . '_label';

				if ( ! empty( $this->p->options[ $cm_enabled_key ] ) && ! empty( $this->p->options[ $cm_name_key ] ) ) {

					$cm_label_value = SucomUtil::get_key_value( $cm_label_key, $this->p->options );

					if ( ! empty( $cm_label_value ) ) {

						$fields[ $this->p->options[ $cm_name_key ] ] = $cm_label_value;
					}
				}
			}

			uasort( $fields, 'strnatcmp' );	// Sort associative array by value.

			return $fields;
		}

		public function modify_fb_contact_label( $label ) {

			return $label . '<br/><span class="description" style="font-weight:normal;">' . 
				__( '(not a Facebook Pages URL)', 'wpsso' ) . '</span>';
		}

		/**
		 * Save the additional fields for the user profile About Yourself / About the user sections.
		 *
		 * Hooked to the 'edit_user_profile_update' and 'personal_options_update' actions.
		 *
		 * Also called by the WpssoUsersAddPerson->add_person() method.
		 */
		public function save_about_section( $user_id ) {

			if ( ! current_user_can( 'edit_user', $user_id ) ) {	// Just in case.

				return;
			}

			foreach ( $this->p->cf[ 'opt' ][ 'user_about' ] as $key => $label ) {

				if ( empty( $this->p->options[ 'plugin_user_about_' . $key ] ) ) {

					continue;
				}

				if ( isset( $_POST[ $key ] ) ) {

					switch ( $key ) {

						/**
						 * Regular text input fields.
						 *
						 * See https://developer.wordpress.org/themes/theme-security/data-sanitization-escaping/.
						 */
						default:

							update_user_meta( $user_id, $key, sanitize_text_field( $_POST[ $key ] ) );

							break;
					}
				}
			}
		}

		public function sanitize_submit_cm( $user_id ) {

			if ( ! current_user_can( 'edit_user', $user_id ) ) {	// Just in case.

				return;
			}

			foreach ( $this->p->cf[ 'opt' ][ 'cm_prefix' ] as $id => $opt_pre ) {

				/**
				 * Not all social websites have contact fields, so check.
				 */
				if ( isset( $this->p->options[ 'plugin_cm_' . $opt_pre . '_name' ] ) ) {

					$cm_enabled_value = $this->p->options[ 'plugin_cm_' . $opt_pre . '_enabled' ];
					$cm_name_value    = $this->p->options[ 'plugin_cm_' . $opt_pre . '_name' ];

					/**
					 * Sanitize values only for those enabled contact methods.
					 */
					if ( isset( $_POST[ $cm_name_value ] ) && ! empty( $cm_enabled_value ) && ! empty( $cm_name_value ) ) {

						$value = wp_filter_nohtml_kses( $_POST[ $cm_name_value ] );

						if ( ! empty( $value ) ) {

							switch ( $cm_name_value ) {

								case $this->p->options[ 'plugin_cm_skype_name' ]:

									/**
									 * No change.
									 */

									break;

								case $this->p->options[ 'plugin_cm_twitter_name' ]:

									$value = SucomUtil::get_at_name( $value );

									break;

								default:

									/**
									 * All other contact methods are assumed to be URLs.
									 */

									if ( false === strpos( $value, '://' ) ) {

										$value = '';
									}

									break;
							}
						}

						$_POST[ $cm_name_value ] = $value;
					}
				}
			}

			return $user_id;
		}

		/**
		 * Provides backwards compatibility for wp 3.0.
		 */
		public static function get_user_id_contact_methods( $user_id ) {

			$user_obj = get_user_by( 'ID', $user_id );

			if ( function_exists( 'wp_get_user_contact_methods' ) ) {	// Since WP v3.7.

				return wp_get_user_contact_methods( $user_obj );

			} else {

				$methods = array();

				if ( get_site_option( 'initial_db_version' ) < 23588 ) {

					$methods = array(
						'aim'    => __( 'AIM' ),
						'jabber' => __( 'Jabber / Google Talk' ),
						'yim'    => __( 'Yahoo Messenger' )
					);
				}

				return apply_filters( 'user_contactmethods', $methods, $user_obj );
			}
		}

		public static function get_author_id( array $mod ) {

			$author_id = false;

			if ( $mod[ 'is_post' ] ) {

				if ( $mod[ 'post_author' ] ) {

					$author_id = $mod[ 'post_author' ];
				}

			} elseif ( $mod[ 'is_user' ] ) {

				$author_id = $mod[ 'id' ];
			}

			return $author_id;
		}

		public function get_author_meta( $user_id, $meta_key ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log_args( array( 
					'user_id'  => $user_id,
					'meta_key' => $meta_key,
				) );
			}

			static $local_cache = array();

			if ( isset( $local_cache[ $user_id ] ) ) {

				if ( isset( $local_cache[ $user_id ][ $meta_key ] ) ) {

					return $local_cache[ $user_id ][ $meta_key ];
				}

			} else {

				$local_cache[ $user_id ] = array();
			}

			$user_exists = SucomUtilWP::user_exists( $user_id );

			$author_meta = '';

			if ( $user_exists ) {

				switch ( $meta_key ) {

					case 'none':

						break;

					case 'fullname':

						$author_meta = get_the_author_meta( 'first_name', $user_id ) . ' ' . get_the_author_meta( 'last_name', $user_id );

						break;

					case 'description':

						$author_meta = preg_replace( '/[\s\n\r]+/s', ' ', get_the_author_meta( $meta_key, $user_id ) );

						break;

					default:

						$author_meta = get_the_author_meta( $meta_key, $user_id );

						break;
				}

				$author_meta = trim( $author_meta );	// Just in case.

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'user ID ' . $user_id . ' is not a WordPress user' );
			}

			$author_meta = apply_filters( 'wpsso_get_author_meta', $author_meta, $user_id, $meta_key, $user_exists );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'user ID ' . $user_id . ' ' . $meta_key . ': ' . $author_meta );
			}

			return $local_cache[ $user_id ][ $meta_key ] = (string) $author_meta;
		}

		/**
		 * Deprecated on 2020/07/20.
		 */
		public static function reset_metabox_prefs( $pagehook, $box_ids = array(), $meta_name = '', $context = '', $force = false ) {

			_deprecated_function( __METHOD__ . '()', '2020/07/20', $replacement = '' );	// Deprecation message.
		}

		/**
		 * Called by the WpssoRegister::uninstall_plugin() method.
		 *
		 * Do not use Wpsso::get_instance() since the Wpsso class may not exist.
		 */
		public static function delete_metabox_prefs( $user_id = false, $slug_prefix = 'wpsso' ) {

			$cf = WpssoConfig::get_config();

			$user_id = empty( $user_id ) ? get_current_user_id() : $user_id;

			$parent_slug = 'options-general.php';

			if ( ! empty( $cf[ '*' ][ 'lib' ][ 'settings' ] ) ) {

				foreach ( array_keys( $cf[ '*' ][ 'lib' ][ 'settings' ] ) as $lib_id ) {

					$menu_slug = $slug_prefix . '-' . $lib_id;

					self::delete_metabox_pagehook( $user_id, $menu_slug, $parent_slug );
				}
			}

			if ( ! empty( $cf[ '*' ][ 'lib' ][ 'submenu' ] ) ) {

				$parent_slug = $slug_prefix . '-' . key( $cf[ '*' ][ 'lib' ][ 'submenu' ] );

				foreach ( array_keys( $cf[ '*' ][ 'lib' ][ 'submenu' ] ) as $lib_id ) {

					$menu_slug = $slug_prefix . '-' . $lib_id;

					self::delete_metabox_pagehook( $user_id, $menu_slug, $parent_slug );
				}
			}
		}

		private static function delete_metabox_pagehook( $user_id, $menu_slug, $parent_slug ) {

			$pagehook = get_plugin_page_hookname( $menu_slug, $parent_slug);

			foreach ( array( 'meta-box-order', 'metaboxhidden', 'closedpostboxes' ) as $mb_state ) {

				$meta_key = $mb_state . '_' . $pagehook;

				if ( false === $user_id ) {

					$users_args = array(
						'role'     => 'contributor',	// Contributors can delete_posts, edit_posts, read.
						'order'    => 'DESC',		// Newest user first.
						'orderby'  => 'ID',
						'meta_key' => $meta_key,	// The meta_key in the wp_usermeta table.
						'fields'   => array(		// Save memory and only return only specific fields.
							'ID',
						),
					);

					foreach ( get_users( $users_args ) as $user_obj ) {

						if ( ! empty( $user_obj->ID ) ) {	// Just in case.

							delete_user_option( $user_obj->ID, $meta_key, $global = false );

							delete_user_option( $user_obj->ID, $meta_key, $global = true );
						}
					}

				} elseif ( is_numeric( $user_id ) ) {

					delete_user_option( $user_id, $meta_key, $global = false );

					delete_user_option( $user_id, $meta_key, $global = true );
				}
			}
		}

		public static function get_pref( $pref_key = false, $user_id = false ) {

			$user_id = empty( $user_id ) ? get_current_user_id() : $user_id;

			if ( ! isset( self::$cache_user_prefs[ $user_id ][ 'prefs_filtered' ] ) || ! self::$cache_user_prefs[ $user_id ][ 'prefs_filtered' ] ) {

				$wpsso =& Wpsso::get_instance();

				self::$cache_user_prefs[ $user_id ] = get_user_meta( $user_id, WPSSO_PREF_NAME, $single = true );

				if ( ! is_array( self::$cache_user_prefs[ $user_id ] ) ) {

					self::$cache_user_prefs[ $user_id ] = array();
				}

				self::$cache_user_prefs[ $user_id ][ 'prefs_filtered' ] = true;	// Set before calling filter to prevent recursion.

				self::$cache_user_prefs[ $user_id ] = apply_filters( 'wpsso_get_user_pref', self::$cache_user_prefs[ $user_id ], $user_id );

				if ( ! isset( self::$cache_user_prefs[ $user_id ][ 'show_opts' ] ) ) {

					self::$cache_user_prefs[ $user_id ][ 'show_opts' ] = $wpsso->options[ 'plugin_show_opts' ];
				}

				if ( $wpsso->debug->enabled ) {

					$wpsso->debug->log_arr( '$cache_user_prefs', self::$cache_user_prefs[ $user_id ] );
				}
			}

			if ( false !== $pref_key ) {

				if ( isset( self::$cache_user_prefs[ $user_id ][ $pref_key ] ) ) {

					return self::$cache_user_prefs[ $user_id ][ $pref_key ];
				}

				return false;

			}

			return self::$cache_user_prefs[ $user_id ];
		}

		public static function save_pref( $user_prefs, $user_id = false ) {

			$user_id = empty( $user_id ) ? get_current_user_id() : $user_id;

			if ( ! current_user_can( 'edit_user', $user_id ) ) {

				return false;
			}

			if ( ! is_array( $user_prefs ) || empty( $user_prefs ) ) {

				return false;
			}

			$old_prefs = self::get_pref( false, $user_id );	// get all prefs for user

			$new_prefs = array_merge( $old_prefs, $user_prefs );

			/**
			 * Don't bother saving unless we have to.
			 */
			if ( $old_prefs !== $new_prefs ) {

				self::$cache_user_prefs[ $user_id ] = $new_prefs;	// update the pref cache

				unset( $new_prefs[ 'prefs_filtered' ] );

				update_user_meta( $user_id, WPSSO_PREF_NAME, $new_prefs );

				return true;
			}

			return false;
		}

		public static function is_show_all( $user_id = false ) {

			return self::show_opts( 'all', $user_id );
		}

		public static function get_show_val( $user_id = false ) {

			return self::show_opts( false, $user_id );
		}

		/**
		 * Returns the value for show_opts, or return true/false if a value to compare is provided.
		 */
		public static function show_opts( $compare = false, $user_id = false ) {

			$user_id = empty( $user_id ) ? get_current_user_id() : $user_id;

			$show_opts = self::get_pref( 'show_opts' );

			if ( $compare ) {

				return $compare === $show_opts ? true : false;
			}

			return $show_opts;
		}

		public function clear_cache( $user_id, $rel_id = false ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			static $do_once = array();

			if ( isset( $do_once[ $user_id ][ $rel_id ] ) ) {

				return;
			}

			$do_once[ $user_id ][ $rel_id ] = true;

			$mod = $this->get_mod( $user_id );

			$col_meta_keys = parent::get_column_meta_keys();

			foreach ( $col_meta_keys as $col_key => $meta_key ) {

				delete_user_meta( $user_id, $meta_key );
			}

			$this->clear_mod_cache( $mod );
		}

		public function user_can_save( $user_id, $rel_id = false ) {

			$user_can_save = false;

			if ( ! $this->verify_submit_nonce() ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: verify_submit_nonce failed' );
				}

				return $user_can_save;
			}

			if ( ! $user_can_save = current_user_can( 'edit_user', $user_id ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'insufficient privileges to save settings for user ID ' . $user_id );
				}

				/**
				 * Add notice only if the admin notices have not already been shown.
				 */
				if ( $this->p->notice->is_admin_pre_notices() ) {

					$this->p->notice->err( sprintf( __( 'Insufficient privileges to save settings for user ID %1$s.',
						'wpsso' ), $user_id ) );
				}
			}

			return $user_can_save;
		}

		/**
		 * Returns an array of single image associative arrays.
		 *
		 * $md_pre can be a text string or array of prefixes.
		 */
		public function get_og_images( $num, $size_names, $user_id, $check_dupes = true, $md_pre = 'og', $mt_pre = 'og' ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$mod = $this->get_mod( $user_id );

			/**
			 * Check if this is a valid WordPress user.
			 */
			$user_exists = SucomUtilWP::user_exists( $user_id );

			if ( $user_exists ) {

				return $this->get_md_images( $num, $size_names, $mod, $check_dupes, $md_pre, $mt_pre );
			}

			return apply_filters( 'wpsso_get_other_user_images', array(), $num, $size_names, $user_id, $check_dupes, $md_pre );
		}

		/**
		 * WpssoUser class specific methods.
		 *
		 * Called by WpssoOpenGraph->get_array() for a single post author and (possibly) several coauthors.
		 */
		public function get_authors_websites( $user_ids, $meta_key = 'url' ) {

			$urls = array();

			if ( empty( $user_ids ) ) {	// Just in case.

				return $urls;
			}

			if ( ! is_array( $user_ids ) ) {

				$user_ids = array( $user_ids );
			}

			if ( empty( $meta_key ) ) {

				$meta_key = $this->p->options[ 'fb_author_field' ];	// Provide a default value.
			}

			if ( ! empty( $meta_key ) && 'none' !== $meta_key ) {	// Just in case.

				foreach ( $user_ids as $user_id ) {

					if ( empty( $user_id ) ) {

						continue;
					}

					$value = $this->get_author_website( $user_id, $meta_key );	// Returns a single URL string.

					if ( ! empty( $value ) ) {	// Make sure we don't add empty values.

						$urls[] = $value;
					}
				}
			}

			return $urls;
		}

		public function get_author_website( $user_id, $meta_key = 'url' ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log_args( array( 
					'user_id'  => $user_id,
					'meta_key' => $meta_key,
				) );
			}

			static $local_cache = array();

			if ( isset( $local_cache[ $user_id ] ) ) {

				if ( isset( $local_cache[ $user_id ][ $meta_key ] ) ) {

					return $local_cache[ $user_id ][ $meta_key ];
				}

			} else {

				$local_cache[ $user_id ] = array();
			}

			$user_exists = SucomUtilWP::user_exists( $user_id );

			$website_url = '';

			if ( $user_exists ) {

				switch ( $meta_key ) {

					case 'none':

						break;

					case 'index':

						$website_url = get_author_posts_url( $user_id );

						break;

					case 'twitter':

						$website_url = get_the_author_meta( $meta_key, $user_id );

						if ( false === filter_var( $website_url, FILTER_VALIDATE_URL ) ) {

							$website_url = 'https://twitter.com/' . preg_replace( '/^@/', '', $website_url );
						}

						break;

					case 'url':
					case 'website':

						$website_url = get_the_author_meta( 'url', $user_id );

						break;

					default:

						$website_url = get_the_author_meta( $meta_key, $user_id );

						break;
				}

				$website_url = trim( $website_url );	// Just in case.

			} else {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'user ID ' . $user_id . ' is not a WordPress user' );
				}
			}

			$website_url = apply_filters( 'wpsso_get_author_website', $website_url, $user_id, $meta_key, $user_exists );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'user ID ' . $user_id . ' ' . $meta_key . ' = ' . $website_url );
			}

			return $local_cache[ $user_id ][ $meta_key ] = (string) $website_url;
		}

		/**
		 * Schedule the addition of user roles for self::get_public_ids().
		 */
		public function schedule_add_person_role( $user_id = null ) {

			$user_id    = $this->p->util->maybe_change_user_id( $user_id );	// Maybe change textdomain for user ID.
			$event_time = time() + 5;	// Add a 5 second event buffer.
			$event_hook = 'wpsso_add_person_role';
			$event_args = array( $user_id );

			$this->stop_add_person_role();	// Just in case.

			wp_schedule_single_event( $event_time, $event_hook, $event_args );
		}

		public function stop_add_person_role() {

			$cache_md5_pre  = 'wpsso_!_';				// Protect transient from being cleared.
			$cache_exp_secs = HOUR_IN_SECONDS;			// Prevent duplicate runs for max 1 hour.
			$cache_salt     = __CLASS__ . '::add_person_role';	// Use a common cache salt for start / stop.
			$cache_id       = $cache_md5_pre . md5( $cache_salt );
			$cache_stop_val = 'stop';

			if ( false !== get_transient( $cache_id ) ) {				// Another process is already running.

				set_transient( $cache_id, $cache_stop_val, $cache_exp_secs );	// Signal the other process to stop.
			}
		}

		public function add_person_role( $user_id = null ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$user_id    = $this->p->util->maybe_change_user_id( $user_id );	// Maybe change textdomain for user ID.
			$notice_key = 'add-user-roles-status';
			$role_label = _x( 'Person', 'user role', 'wpsso' );

			/**
			 * A transient is set and checked to limit the runtime and allow this process to be terminated early.
			 */
			$cache_md5_pre  = 'wpsso_!_';				// Protect transient from being cleared.
			$cache_exp_secs = HOUR_IN_SECONDS;			// Prevent duplicate runs for max 1 hour.
			$cache_salt     = __CLASS__ . '::add_person_role';	// Use a common cache salt for start / stop.
			$cache_id       = $cache_md5_pre . md5( $cache_salt );
			$cache_run_val  = 'running';
			$cache_stop_val = 'stop';

			/**
			 * Prevent concurrent execution.
			 */
			if ( false !== get_transient( $cache_id ) ) {	// Another process is already running.

				if ( $user_id ) {

					$notice_msg = sprintf( __( 'Aborting task to add the %1$s role to content creators - another identical task is still running.',
						'wpsso' ), $role_label );

					$this->p->notice->warn( $notice_msg, $user_id, $notice_key . '-abort' );
				}

				return;
			}

			set_transient( $cache_id, $cache_run_val, $cache_exp_secs );

			$mtime_start = microtime( $get_float = true );

			if ( $user_id ) {

				$notice_msg = sprintf( __( 'A task to add the %1$s role for content creators was started at %2$s.',
					'wpsso' ), $role_label, gmdate( 'c' ) );

				$this->p->notice->upd( $notice_msg, $user_id, $notice_key . '-begin' );
			}

			if ( 0 === get_current_user_id() ) {		// User is the scheduler.

				set_time_limit( HOUR_IN_SECONDS );	// Set maximum PHP execution time to one hour.
			}

			if ( defined( 'DOING_CRON' ) && DOING_CRON ) {

				/**
				 * Register image sizes and include WooCommerce front-end libs.
				 */
				do_action( 'wpsso_scheduled_task_started', $user_id );
			}

			$public_user_ids = self::get_public_ids();	// Aka 'administrator', 'editor', 'author', and 'contributor'.

			$count = 0;

			foreach ( $public_user_ids as $id ) {

				/**
				 * Check that we are allowed to continue. Stop if cache status is not 'running'.
				 */
				if ( get_transient( $cache_id ) !== $cache_run_val ) {

					delete_transient( $cache_id );

					return;	// Stop here.
				}

				$count += self::add_role_by_id( $id, $role = 'person' );
			}

			if ( $user_id ) {

				$mtime_total = microtime( $get_float = true ) - $mtime_start;

				$notice_msg = sprintf( __( 'The %1$s role has been added to %2$d content creators.', 'wpsso' ), $role_label, $count ) . ' ';

				$notice_msg .= sprintf( __( 'The total execution time for this task was %0.3f seconds.', 'wpsso' ), $mtime_total );

				$this->p->notice->upd( $notice_msg, $user_id, $notice_key . '-end' );
			}

			delete_transient( $cache_id );
		}

		/**
		 * Schedule the removal of user roles for self::get_public_ids().
		 */
		public function schedule_remove_person_role( $user_id = null ) {

			$user_id    = $this->p->util->maybe_change_user_id( $user_id );	// Maybe change textdomain for user ID.
			$event_time = time() + 5;	// Add a 5 second event buffer.
			$event_hook = 'wpsso_remove_person_role';
			$event_args = array( $user_id );

			wp_schedule_single_event( $event_time, $event_hook, $event_args );
		}

		public function remove_person_role( $user_id = null ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$user_id    = $this->p->util->maybe_change_user_id( $user_id );	// Maybe change textdomain for user ID.
			$notice_key = 'remove-user-roles-status';
			$role_label = _x( 'Person', 'user role', 'wpsso' );

			/**
			 * A transient is set and checked to limit the runtime and allow this process to be terminated early.
			 */
			$cache_md5_pre  = 'wpsso_!_';				// Protect transient from being cleared.
			$cache_exp_secs = HOUR_IN_SECONDS;			// Prevent duplicate runs for max 1 hour.
			$cache_salt     = __CLASS__ . '::remove_person_role';	// Use a common cache salt for start / stop.
			$cache_id       = $cache_md5_pre . md5( $cache_salt );
			$cache_run_val  = 'running';
			$cache_stop_val = 'stop';

			/**
			 * Prevent concurrent execution.
			 */
			if ( false !== get_transient( $cache_id ) ) {	// Another process is already running.

				if ( $user_id ) {

					$notice_msg = sprintf( __( 'Aborting task to remove the %1$s role from all users - another identical task is still running.',
						'wpsso' ), $role_label );

					$this->p->notice->warn( $notice_msg, $user_id, $notice_key . '-abort' );
				}

				return;
			}

			set_transient( $cache_id, $cache_run_val, $cache_exp_secs );

			$mtime_start = microtime( $get_float = true );

			if ( $user_id ) {

				$notice_msg = sprintf( __( 'A task to remove the %1$s role from all users was started at %2$s.',
					'wpsso' ), $role_label, gmdate( 'c' ) );

				$this->p->notice->upd( $notice_msg, $user_id, $notice_key . '-begin' );
			}

			$this->stop_add_person_role();	// Just in case.

			if ( 0 === get_current_user_id() ) {		// User is the scheduler.

				set_time_limit( HOUR_IN_SECONDS );	// Set maximum PHP execution time to one hour.
			}

			if ( defined( 'DOING_CRON' ) && DOING_CRON ) {

				/**
				 * Register image sizes and include WooCommerce front-end libs.
				 */
				do_action( 'wpsso_scheduled_task_started', $user_id );
			}

			$blog_id = get_current_blog_id();

			$count = 0;

			while ( $blog_user_ids = SucomUtil::get_user_ids( $blog_id, '', 1000 ) ) {	// Get a maximum of 1000 user IDs at a time.

				foreach ( $blog_user_ids as $id ) {

					$count += self::remove_role_by_id( $id, $role = 'person' );
				}
			}

			if ( $user_id ) {

				$mtime_total = microtime( $get_float = true ) - $mtime_start;

				$notice_msg = sprintf( __( 'The %1$s role has been removed from %2$d content creators.', 'wpsso' ), $role_label, $count ) . ' ';

				$notice_msg .= sprintf( __( 'The total execution time for this task was %0.3f seconds.', 'wpsso' ), $mtime_total );

				$this->p->notice->upd( $notice_msg, $user_id, $notice_key . '-end' );
			}

			delete_transient( $cache_id );
		}

		/**
		 * Hooked to the 'wpmu_new_user' and 'user_register' actions, which only provides a single argument.
		 */
		public static function add_role_by_id( $user_id, $role = 'person' ) {

			$user_obj = get_user_by( 'ID', $user_id );

			if ( ! in_array( $role, $user_obj->roles ) ) {

				$user_obj->add_role( $role );	// Method does not return anything - assume it worked.

				return 1;
			}

			return 0;
		}

		public static function remove_role_by_id( $user_id, $role = 'person' ) {

			$user_obj = get_user_by( 'ID', $user_id );

			if ( in_array( $role, $user_obj->roles ) ) {

				$user_obj->remove_role( $role );	// Method does not return anything - assume it worked.

				return 1;
			}

			return 0;
		}

		public static function get_person_names( $add_none = true ) {

			$wpsso =& Wpsso::get_instance();

			$roles = $wpsso->cf[ 'wp' ][ 'roles' ][ 'person' ];

			$limit = WPSSO_SELECT_PERSON_NAMES_MAX;	// Default is 100 user names.

			return SucomUtilWP::get_roles_user_select( $roles, $blog_id = null, $add_none, $limit );
		}

		public function add_person_view( $user_views ) {

			$user_views = array_reverse( $user_views );

			$all_view_link = $user_views[ 'all' ];

			unset( $user_views[ 'all' ], $user_views[ 'person' ] );

			$role_label = _x( 'Person', 'user role', 'wpsso' );

			$role_view  = add_query_arg( 'role', 'person', admin_url( 'users.php' ) );

			$user_query = new WP_User_Query( array( 'role' => 'person' ) );

			$user_count = $user_query->get_total();

			$user_views[ 'person' ] = '<a href="' . $role_view . '">' .  $role_label . '</a> (' . $user_count . ')';

			$user_views[ 'all' ] = $all_view_link;

			$user_views = array_reverse( $user_views );

			return $user_views;
		}

		/**
		 * Since WPSSO Core v8.4.0.
		 */
		public static function get_meta( $user_id, $meta_key, $single = false ) {

			return get_user_meta( $user_id, $meta_key, $single );
		}

		/**
		 * Since WPSSO Core v8.4.0.
		 */
		public static function update_meta( $user_id, $meta_key, $value ) {

			return update_user_meta( $user_id, $meta_key, $value );
		}

		/**
		 * Since WPSSO Core v8.4.0.
		 */
		public static function delete_meta( $user_id, $meta_key ) {

			return delete_user_meta( $user_id, $meta_key );
		}
	}
}
