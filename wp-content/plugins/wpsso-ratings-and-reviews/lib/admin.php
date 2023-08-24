<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRarAdmin' ) ) {

	class WpssoRarAdmin {

		private $p;
		private $a;	// WpssoRar class object.

		private static $allow_ratings_opt_key = 'rar_allow_ratings';

		/**
		 * Instantiated by WpssoRar->init_objects().
		 */
		public function __construct( &$plugin, &$addon ) {

			$this->p =& $plugin;
			$this->a =& $addon;

			$this->p->util->add_plugin_filters( $this, array(
				'get_sortable_columns' => 1,
			) );

			add_action( 'admin_enqueue_scripts', array( $this->a->style, 'enqueue_styles' ), WPSSO_ADMIN_SCRIPTS_PRIORITY );
			add_action( 'post_comment_status_meta_box-options', array( $this, 'show_comment_metabox_option' ), 10, 1 );
			add_action( 'quick_edit_custom_box', array( $this, 'show_quick_edit_option' ), 10, 2 );
            		add_action( 'save_post', array( $this, 'save_rating_meta_option' ), 10, 3 );
		}

		public function filter_get_sortable_columns( $columns ) {

			return array_merge( array( 
				'avg_rating' => array(
					'header'         => 'Rating',
					'meta_key'       => WPSSORAR_META_AVERAGE_RATING,
					'post_callbacks' => array(	// An array of callback functions / methods.
						array( $this, 'post_callback_rating_enabled' ),
					),
					'orderby' => 'meta_value',
					'width'   => '75px',
					'height'  => 'auto',
				)
			), $columns );
		}

		public function post_callback_rating_enabled( $value, $post_id ) {

			$rating_enabled = WpssoRarComment::is_rating_enabled( $post_id );

			$input_hidden = '<input name="' . self::$allow_ratings_opt_key . '" type="hidden" value="' . $rating_enabled . '" readonly="readonly" />';

			return $value . "\n" . $input_hidden;
		}

		public function show_quick_edit_option( $column_name, $post_type ) {

			if ( $column_name !== 'wpsso_avg_rating' ) {

				return;
			}

			if ( isset( $this->p->options[ 'rar_add_to_' . $post_type . ':is' ] ) &&
				$this->p->options[ 'rar_add_to_' . $post_type . ':is' ] === 'disabled' ) {

				return;
			}

			static $nonce_added = null;

			if ( $nonce_added === null ) {

				wp_nonce_field( WpssoAdmin::get_nonce_action(), WPSSO_NONCE_NAME );	// WPSSO_NONCE_NAME is an md5() string

				$nonce_added = true;
			}

			$enable_ratings_label = __( 'Enable ratings and reviews', 'wpsso-ratings-and-reviews' );

			echo '<fieldset class="inline-edit-col-right quick-edit-ratings-and-reviews">';
			echo '<div class="inline-edit-col quick-edit-' . $column_name . '">';
			echo '<div class="inline-edit-group">';
			echo '<label class="alignleft">';

			printf( '<input type="hidden" name="is_checkbox_%1$s" value="1"/>' .
				'<input type="checkbox" name="%1$s" class="selectit"/>', self::$allow_ratings_opt_key );

			echo '<span class="checkbox-title">' . $enable_ratings_label . '</span>';

			echo '</label>';
			echo '</div>';
			echo '</div>';
			echo '</fieldset>';
		}

		public function show_comment_metabox_option( $post_obj ) {

			if ( ! is_object( $post_obj ) ) {	// just in case

				return;
			}

			$post_type = get_post_type( $post_obj->ID );

			if ( isset( $this->p->options[ 'rar_add_to_' . $post_type . ':is' ] ) &&
				$this->p->options[ 'rar_add_to_' . $post_type . ':is' ] === 'disabled' ) {

				return;
			}

			static $nonce_added = null;

			if ( $nonce_added === null ) {

				wp_nonce_field( WpssoAdmin::get_nonce_action(), WPSSO_NONCE_NAME );	// WPSSO_NONCE_NAME is an md5() string

				$nonce_added = true;
			}

			$enable_ratings_label = __( 'Enable ratings and reviews', 'wpsso-ratings-and-reviews' );

			$allow_ratings = WpssoRarComment::is_rating_enabled( $post_obj->ID );	// get current setting

			printf( '<br /><label for="%1$s"><input type="hidden" name="is_checkbox_%1$s" value="1"/>' .
				'<input type="checkbox" name="%1$s" class="selectit" %2$s/> %3$s</label>',
					self::$allow_ratings_opt_key, checked( $allow_ratings, 1, false ), $enable_ratings_label );
		}

        	public function save_rating_meta_option( $post_id, $post_obj, $update ) {

			if ( ! isset ( $_POST[ 'post_type' ] ) ) {

				return;

			} elseif ( ! current_user_can( 'edit_' . $_POST[ 'post_type' ], $post_id ) ) {

				return;

			} elseif ( empty( $_POST[ WPSSO_NONCE_NAME ] ) ) {	// WPSSO_NONCE_NAME is an md5() string.

				return;

			} elseif ( ! wp_verify_nonce( $_POST[ WPSSO_NONCE_NAME ], WpssoAdmin::get_nonce_action() ) ) {

				return;

			} elseif ( empty( $_POST[ 'is_checkbox_' . self::$allow_ratings_opt_key ] ) ) {

				return;

			} elseif ( isset( $_POST[ self::$allow_ratings_opt_key ] ) && strtolower( $_POST[ self::$allow_ratings_opt_key ] ) === 'on' ) {

				update_post_meta( $post_id, WPSSORAR_META_ALLOW_RATINGS, 1 );

			} else {

				update_post_meta( $post_id, WPSSORAR_META_ALLOW_RATINGS, 0 );
			}
		}
	}
}
