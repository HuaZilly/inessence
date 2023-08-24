<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRarSubmenuRarGeneral' ) && class_exists( 'WpssoAdmin' ) ) {

	class WpssoRarSubmenuRarGeneral extends WpssoAdmin {

		public function __construct( &$plugin, $id, $name, $lib, $ext ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$this->menu_id   = $id;
			$this->menu_name = $name;
			$this->menu_lib  = $lib;
			$this->menu_ext  = $ext;
		}

		/**
		 * Called by the extended WpssoAdmin class.
		 */
		protected function add_meta_boxes() {

			$metabox_id      = 'rar';
			$metabox_title   = _x( 'Ratings and Reviews', 'metabox title', 'wpsso-ratings-and-reviews' );
			$metabox_screen  = $this->pagehook;
			$metabox_context = 'normal';
			$metabox_prio    = 'default';
			$callback_args   = array(	// Second argument passed to the callback function / method.
			);

			add_meta_box( $this->pagehook . '_' . $metabox_id, $metabox_title,
				array( $this, 'show_metabox_' . $metabox_id ), $metabox_screen,
					$metabox_context, $metabox_prio, $callback_args );
		}

		public function show_metabox_rar() {

			$metabox_id = 'rar';

			$tab_key = 'general';

			$filter_name = SucomUtil::sanitize_hookname( 'wpsso_' . $metabox_id . '_' . $tab_key . '_rows' );

			$table_rows = $this->get_table_rows( $metabox_id, $tab_key );

			$table_rows = apply_filters( $filter_name, $table_rows, $this->form, $network = false );

			$this->p->util->metabox->do_table( $table_rows, 'metabox-' . $metabox_id . '-' . $tab_key );
		}

		protected function get_table_rows( $metabox_id, $tab_key ) {

			$table_rows = array();

			switch ( $metabox_id . '-' . $tab_key ) {

				case 'rar-general':

					$table_rows[ 'rar_star_color_selected' ] = '' .
						$this->form->get_th_html( _x( 'Selected Star Rating Color', 'option label', 'wpsso-ratings-and-reviews' ),
							$css_class = '', $css_id = 'rar_star_color_selected' ) . 
						'<td>' . $this->form->get_input_color( 'rar_star_color_selected' ) . '</td>';

					$table_rows[ 'rar_star_color_default' ] = '' .
						$this->form->get_th_html( _x( 'Unselected Star Rating Color', 'option label', 'wpsso-ratings-and-reviews' ),
							$css_class = '', $css_id = 'rar_star_color_default' ) . 
						'<td>' . $this->form->get_input_color( 'rar_star_color_default' ) . '</td>';

					$table_rows[ 'rar_add_to' ] = '' .
						$this->form->get_th_html( _x( 'Show Rating Form for Post Types', 'option label', 'wpsso-ratings-and-reviews' ),
							$css_class = '', $css_id = 'rar_add_to' ) . 
						'<td>' . $this->form->get_checklist_post_types( $name_prefix = 'rar_add_to' ) . '</td>';

					$table_rows[ 'rar_rating_required' ] = '' .
						$this->form->get_th_html( _x( 'Rating Required to Submit Review', 'option label', 'wpsso-ratings-and-reviews' ),
							$css_class = '', $css_id = 'rar_rating_required' ) . 
						'<td>' . $this->form->get_checkbox( 'rar_rating_required' ) . '</td>';

					break;
			}

			return $table_rows;
		}
	}
}
