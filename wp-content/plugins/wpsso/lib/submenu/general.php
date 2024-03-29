<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2012-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoSubmenuGeneral' ) && class_exists( 'WpssoAdmin' ) ) {

	class WpssoSubmenuGeneral extends WpssoAdmin {

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

			$this->maybe_show_language_notice();

			$metabox_id      = 'og';
			$metabox_title   = _x( 'General Settings', 'metabox title', 'wpsso' );
			$metabox_screen  = $this->pagehook;
			$metabox_context = 'normal';
			$metabox_prio    = 'default';
			$callback_args   = array(	// Second argument passed to the callback function / method.
			);

			add_meta_box( $this->pagehook . '_' . $metabox_id, $metabox_title,
				array( $this, 'show_metabox_' . $metabox_id ), $metabox_screen,
					$metabox_context, $metabox_prio, $callback_args );

			$metabox_id      = 'social_and_search';
			$metabox_title   = _x( 'Social and Search Sites', 'metabox title', 'wpsso' );
			$metabox_screen  = $this->pagehook;
			$metabox_context = 'normal';
			$metabox_prio    = 'default';
			$callback_args   = array(	// Second argument passed to the callback function / method.
			);

			add_meta_box( $this->pagehook . '_' . $metabox_id, $metabox_title,
				array( $this, 'show_metabox_' . $metabox_id ), $metabox_screen,
					$metabox_context, $metabox_prio, $callback_args );

			$this->p->media->get_default_images( $size_name = 'wpsso-opengraph' );
		}

		public function show_metabox_og() {

			$metabox_id = 'og';

			$tabs = apply_filters( 'wpsso_general_' . $metabox_id . '_tabs', array(
				'site'    => _x( 'Site Information', 'metabox tab', 'wpsso' ),
				'content' => _x( 'Titles / Descriptions', 'metabox tab', 'wpsso' ),
				'images'  => _x( 'Images', 'metabox tab', 'wpsso' ),
				'videos'  => _x( 'Videos', 'metabox tab', 'wpsso' ),
			) );

			$table_rows = array();

			foreach ( $tabs as $tab_key => $title ) {

				$filter_name = SucomUtil::sanitize_hookname( 'wpsso_' . $metabox_id . '_' . $tab_key . '_rows' );

				$table_rows[ $tab_key ] = $this->get_table_rows( $metabox_id, $tab_key );

				$table_rows[ $tab_key ] = apply_filters( $filter_name, $table_rows[ $tab_key ], $this->form, $network = false );
			}

			$this->p->util->metabox->do_tabbed( $metabox_id, $tabs, $table_rows );
		}

		public function show_metabox_social_and_search() {

			$metabox_id = 'pub';

			$tabs = apply_filters( 'wpsso_general_' . $metabox_id . '_tabs', array(
				'facebook'    => _x( 'Facebook', 'metabox tab', 'wpsso' ),
				'google'      => _x( 'Google / Schema', 'metabox tab', 'wpsso' ),
				'pinterest'   => _x( 'Pinterest', 'metabox tab', 'wpsso' ),
				'twitter'     => _x( 'Twitter', 'metabox tab', 'wpsso' ),
				'other_sites' => _x( 'Other Sites', 'metabox tab', 'wpsso' ),
			) );

			$table_rows = array();

			foreach ( $tabs as $tab_key => $title ) {

				$filter_name = SucomUtil::sanitize_hookname( 'wpsso_' . $metabox_id . '_' . $tab_key . '_rows' );

				$table_rows[ $tab_key ] = $this->get_table_rows( $metabox_id, $tab_key );

				$table_rows[ $tab_key ] = apply_filters( $filter_name, $table_rows[ $tab_key ], $this->form, $network = false );
			}

			$this->p->util->metabox->do_tabbed( $metabox_id, $tabs, $table_rows );
		}

		protected function get_table_rows( $metabox_id, $tab_key ) {

			$table_rows      = array();
			$max_media_items = $this->p->cf[ 'form' ][ 'max_media_items' ];
			$user_contacts   = $this->p->user->get_form_contact_fields();

			switch ( $metabox_id . '-' . $tab_key ) {

				case 'og-site':

					$def_site_name      = get_bloginfo( 'name' );
					$def_site_desc      = get_bloginfo( 'description' );
					$article_sections   = $this->p->util->get_article_sections();
					$product_categories = $this->p->util->get_google_product_categories();

					$table_rows[ 'site_name' ] = '' . 
						$this->form->get_th_html_locale( _x( 'WebSite Name', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'site_name' ) . 
						'<td>' . $this->form->get_input_locale( 'site_name', $css_class = 'long_name', $css_id = '',
							$len = 0, $def_site_name ) . '</td>';

					$table_rows[ 'site_name_alt' ] = '' .
						$this->form->get_th_html_locale( _x( 'WebSite Alternate Name', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'site_name_alt' ) . 
						'<td>' . $this->form->get_input_locale( 'site_name_alt', $css_class = 'long_name' ) . '</td>';

					$table_rows[ 'site_desc' ] = '' . 
						$this->form->get_th_html_locale( _x( 'WebSite Description', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'site_desc' ) . 
						'<td>' . $this->form->get_textarea_locale( 'site_desc', $css_class = '', $css_id = '',
							$len = 0, $def_site_desc ) . '</td>';

					$table_rows[ 'og_def_article_section' ] = '' . 
						$this->form->get_th_html( _x( 'Default Article Section', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_def_article_section' ) . 
						'<td>' .
						$this->form->get_select( 'og_def_article_section', $article_sections, $css_class = '', $css_id = '',
							$is_assoc = true, $is_disabled = false, $selected = false, $event_names = array( 'on_focus_load_json' ),
								$event_args = array(
									'json_var'  => 'article_sections',
									'exp_secs'  => WPSSO_CACHE_SELECT_JSON_EXP_SECS,	// Create and read from a javascript URL.
									'is_transl' => true,					// No label translation required.
									'is_sorted' => true,					// No label sorting required.
								)
							) .
						'</td>';

					$table_rows[ 'og_def_product_category' ] = '' . 
						$this->form->get_th_html( _x( 'Default Product Type', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_def_product_category' ) . 
						'<td>' .
						$this->form->get_select( 'og_def_product_category', $product_categories, $css_class = 'wide', $css_id = '',
							$is_assoc = true, $is_disabled = false, $selected = false, $event_names = array( 'on_focus_load_json' ),
								$event_args = array(
									'json_var'  => 'product_categories',
									'exp_secs'  => WPSSO_CACHE_SELECT_JSON_EXP_SECS,	// Create and read from a javascript URL.
									'is_transl' => true,					// No label translation required.
									'is_sorted' => true,					// No label sorting required.
								)
							) .
						'</td>';

					$table_rows[ 'og_def_country' ] = '' . 
						$this->form->get_th_html( _x( 'Default Country', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_def_country' ) . 
						'<td>' . $this->form->get_select_country( 'og_def_country' ) . '</td>';

					$table_rows[ 'og_def_timezone' ] = '' . 
						$this->form->get_th_html( _x( 'Default Timezone', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_def_timezone' ) . 
						'<td>' . $this->form->get_select_timezone( 'og_def_timezone' ) . '</td>';

					$table_rows[ 'og_def_currency' ] = '' .
						$this->form->get_th_html( _x( 'Default Currency', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_def_currency' ) .
						'<td>' . $this->form->get_select( 'og_def_currency', SucomUtil::get_currencies() ) . '</td>';

					break;

				case 'og-content':

					$table_rows[ 'og_title_sep' ] = '' . 
						$this->form->get_th_html( _x( 'Title Separator', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_title_sep' ) . 
						'<td>' . $this->form->get_input( 'og_title_sep', 'xshort' ) . '</td>';

					$table_rows[ 'og_title_max_len' ] = '' . 
						$this->form->get_th_html( _x( 'Title Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_title_max_len' ) . 
						'<td>' . 
						$this->form->get_input( 'og_title_max_len', $css_class = 'chars' ) . ' ' . 
						_x( 'characters or less (hard limit), and warn at', 'option comment', 'wpsso' ) . ' ' . 
						$this->form->get_input( 'og_title_warn_len', $css_class = 'chars' ) . ' ' . 
						_x( 'characters (soft limit)', 'option comment', 'wpsso' ) . 
						'</td>';

					$table_rows[ 'og_desc_max_len' ] = '' . 
						$this->form->get_th_html( _x( 'Description Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_desc_max_len' ) . 
						'<td>' . 
						$this->form->get_input( 'og_desc_max_len', $css_class = 'chars' ) . ' ' . 
						_x( 'characters or less (hard limit), and warn at', 'option comment', 'wpsso' ) . ' ' . 
						$this->form->get_input( 'og_desc_warn_len', $css_class = 'chars' ) . ' ' . 
						_x( 'characters (soft limit)', 'option comment', 'wpsso' ) . 
						'</td>';

					$table_rows[ 'og_desc_hashtags' ] = '' .
						$this->form->get_th_html( _x( 'Description Hashtags', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_desc_hashtags' ) . 
						'<td>' . $this->form->get_select( 'og_desc_hashtags', range( 0, $this->p->cf[ 'form' ][ 'max_hashtags' ] ),
							$css_class = 'short', $css_id = '', $is_assoc = true ) . ' ' . 
						_x( 'tag names', 'option comment', 'wpsso' ) . '</td>';

					break;

				case 'og-images':

					$table_rows[ 'og_img_max' ] = $this->form->get_tr_hide( 'basic', 'og_img_max' ) . 
						$this->form->get_th_html( _x( 'Maximum Images to Include', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_img_max' ) . 
						'<td>' .
						$this->form->get_select( 'og_img_max', range( 0, $max_media_items ),
							$css_class = 'short', $css_id = '', $is_assoc = true ) . 
						$this->p->msgs->maybe_preview_images_first() .
						'</td>';

					$table_rows[ 'og_def_img_id' ] = '' . 
						$this->form->get_th_html_locale( _x( 'Default Image ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_def_img_id' ) . 
						'<td>' . $this->form->get_input_image_upload( 'og_def_img' ) . '</td>';

					$table_rows[ 'og_def_img_url' ] = '' . 
						$this->form->get_th_html_locale( _x( 'or Default Image URL', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'og_def_img_url' ) . 
						'<td>' . $this->form->get_input_image_url( 'og_def_img' ) . '</td>';

					break;

				case 'og-videos':

					break;

				case 'pub-facebook':

					$table_rows[ 'fb_site_verify' ] = '' .
						$this->form->get_th_html( _x( 'Facebook Domain Verification ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'fb_site_verify' ) . 
						'<td>' . $this->form->get_input( 'fb_site_verify', $css_class = 'api_key' ) . '</td>';

					$table_rows[ 'fb_publisher_url' ] = '' . 
						$this->form->get_th_html_locale( _x( 'Facebook Business Page URL', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'fb_publisher_url' ) . 
						'<td>' . $this->form->get_input_locale( 'fb_publisher_url', $css_class = 'wide' ) . '</td>';

					$table_rows[ 'fb_author_field' ] = $this->form->get_tr_hide( 'basic', 'fb_author_field' ) . 
						$this->form->get_th_html( _x( 'Author Profile URL Field', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'fb_author_field' ) . 
						'<td>' . $this->form->get_select( 'fb_author_field', $user_contacts ) . '</td>';

					$table_rows[ 'fb_app_id' ] = $this->form->get_tr_hide( 'basic', 'fb_app_id' ) .
						$this->form->get_th_html( _x( 'Facebook Application ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'fb_app_id' ) . 
						'<td>' . $this->form->get_input( 'fb_app_id', $css_class = 'api_key' ) . '</td>';

					$table_rows[ 'fb_locale' ] = $this->form->get_tr_hide( 'basic', 'fb_locale' ) . 
						$this->form->get_th_html_locale( _x( 'Facebook Locale', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'fb_locale' ) . 
						'<td>' . $this->form->get_select_locale( 'fb_locale', SucomUtil::get_pub_lang( 'facebook' ) ) . '</td>';

					break;

				case 'pub-google':

					if ( empty( $this->p->avail[ 'p' ][ 'schema' ] ) ) {

						return $this->p->msgs->get_schema_disabled_rows( $table_rows );
					}

					/**
					 * Google / Schema settings.
					 */
					$table_rows[ 'g_site_verify' ] = '' .
						$this->form->get_th_html( _x( 'Google Website Verification ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'g_site_verify' ) . 
						'<td>' . $this->form->get_input( 'g_site_verify', $css_class = 'api_key' ) . '</td>';

					/**
					 * Schema settings.
					 */
					$this->add_schema_publisher_type_table_rows( $table_rows, $this->form );	// Also used in the Essential Settings page.

					$table_rows[ 'schema_img_max' ] = $this->form->get_tr_hide( 'basic', 'schema_img_max' ) . 
						$this->form->get_th_html( _x( 'Schema Max. Images to Include', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'schema_img_max' ) . 
						'<td>' .
						$this->form->get_select( 'schema_img_max', range( 0, $max_media_items ),
							$css_class = 'short', $css_id = '', $is_assoc = true ) .
						$this->p->msgs->maybe_preview_images_first() .
						'</td>';

					$table_rows[ 'schema_aggr_offers' ] = $this->form->get_tr_hide( 'basic', 'schema_aggr_offers' ) .
						$this->form->get_th_html( _x( 'Aggregate Offers by Currency', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'schema_aggr_offers' ) . 
						'<td>' . $this->form->get_checkbox( 'schema_aggr_offers' ) . ' ' .
						sprintf( _x( 'incompatible with <a href="%s">price drop appearance</a>', 'option comment', 'wpsso' ),
							'https://developers.google.com/search/docs/data-types/product#price-drop' ) . '</td>';

					$table_rows[ 'schema_add_text_prop' ] = $this->form->get_tr_hide( 'basic', 'schema_add_text_prop' ) .
						$this->form->get_th_html( _x( 'Add Text / Article Body Properties', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'schema_add_text_prop' ) . 
						'<td>' . $this->form->get_checkbox( 'schema_add_text_prop' ) . '</td>';

					$table_rows[ 'schema_text_max_len' ] = $this->form->get_tr_hide( 'basic', 'schema_text_max_len' ) . 
						$this->form->get_th_html( _x( 'Text / Article Body Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'schema_text_max_len' ) . 
						'<td>' . $this->form->get_input( 'schema_text_max_len', $css_class = 'chars' ) . ' ' .
						_x( 'characters or less', 'option comment', 'wpsso' ) . '</td>';

					$table_rows[ 'schema_desc_max_len' ] = $this->form->get_tr_hide( 'basic', 'schema_desc_max_len' ) . 
						$this->form->get_th_html( _x( 'Schema Description Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'schema_desc_max_len' ) . 
						'<td>' . $this->form->get_input( 'schema_desc_max_len', 'chars' ) . ' ' .
						_x( 'characters or less', 'option comment', 'wpsso' ) . '</td>';

					/**
					 * SEO settings.
					 */
					$seo_desc_disabled = empty( $this->p->options[ 'add_meta_name_description' ] ) ? true : false;

					$table_rows[ 'seo_desc_max_len' ] = $this->form->get_tr_hide( 'basic', 'seo_desc_max_len' ) . 
						$this->form->get_th_html( _x( 'Description Meta Tag Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'seo_desc_max_len' ) . 
						'<td>' . $this->form->get_input( 'seo_desc_max_len',
							$css_class = 'chars', $css_id = '', $len = 0, $holder = false, $seo_desc_disabled ) . ' ' .
						_x( 'characters or less', 'option comment', 'wpsso' ) . '</td>';

					/**
					 * Robots settings.
					 */
					$robots_disabled = empty( $this->p->options[ 'add_meta_name_robots' ] ) ? true : false;

					$table_rows[ 'robots_max_snippet' ] = $this->form->get_tr_hide( 'basic', 'robots_max_snippet' ) .
						$this->form->get_th_html( _x( 'Robots Snippet Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'robots_max_snippet' ) . 
						'<td>' . $this->form->get_input( 'robots_max_snippet',
							$css_class = 'chars', $css_id = '', $len = 0, $holder = false, $robots_disabled ) . ' ' .
						_x( 'characters or less', 'option comment', 'wpsso' ) . ' (' . _x( '-1 for no limit', 'option comment', 'wpsso' ) . ')</td>';

					$table_rows[ 'robots_max_image_preview' ] = $this->form->get_tr_hide( 'basic', 'robots_max_image_preview' ) .
						$this->form->get_th_html( _x( 'Robots Image Preview Size', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'robots_max_image_preview' ) . 
						'<td>' . $this->form->get_select( 'robots_max_image_preview', $this->p->cf[ 'form' ][ 'robots_max_image_preview' ],
							$css_class = '', $css_id = '', $is_assoc = true, $robots_disabled ) . '</td>';

					$table_rows[ 'robots_max_video_preview' ] = $this->form->get_tr_hide( 'basic', 'robots_max_video_preview' ) .
						$this->form->get_th_html( _x( 'Robots Video Max. Previews', 'option label', 'wpsso' ),
							$css_class = 'medium', $css_id = 'robots_max_video_preview' ) . 
						'<td>' . $this->form->get_input( 'robots_max_video_preview',
							$css_class = 'chars', $css_id = '', $len = 0, $holder = false, $robots_disabled ) .
						_x( 'seconds', 'option comment', 'wpsso' ) . ' (' . _x( '-1 for no limit', 'option comment', 'wpsso' ) . ')</td>';

					break;

				case 'pub-pinterest':

					$table_rows[ 'pin_site_verify' ] = '' .
						$this->form->get_th_html( _x( 'Pinterest Website Verification ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'pin_site_verify' ) . 
						'<td>' . $this->form->get_input( 'pin_site_verify', 'api_key' ) . '</td>';

					$table_rows[ 'pin_publisher_url' ] = '' . 
						$this->form->get_th_html_locale( _x( 'Pinterest Company Page URL', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'pin_publisher_url' ) . 
						'<td>' . $this->form->get_input_locale( 'pin_publisher_url', $css_class = 'wide' ) . '</td>';

					$table_rows[ 'pin_add_nopin_header_img_tag' ] = $this->form->get_tr_hide( 'basic', 'pin_add_nopin_header_img_tag' ) . 
						$this->form->get_th_html( _x( 'Add "nopin" to Site Header Image', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'pin_add_nopin_header_img_tag' ) . 
						'<td>' . $this->form->get_checkbox( 'pin_add_nopin_header_img_tag' ) .' ' .
						_x( 'recommended', 'option comment', 'wpsso' ) . '</td>';

					$table_rows[ 'pin_add_nopin_media_img_tag' ] = '' . 
						$this->form->get_th_html( _x( 'Add Pinterest "nopin" to Images', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'pin_add_nopin_media_img_tag' ) . 
						'<td>' . $this->form->get_checkbox( 'pin_add_nopin_media_img_tag' ) . ' ' .
						_x( 'recommended', 'option comment', 'wpsso' ) . '</td>';

					$table_rows[ 'pin_add_img_html' ] = '' . 
						$this->form->get_th_html( _x( 'Add Hidden Image for Pinterest', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'pin_add_img_html' ) . 
						'<td>' . $this->form->get_checkbox( 'pin_add_img_html' ) . ' ' .
						_x( 'recommended (see help text for caveats)', 'option comment', 'wpsso' ) . '</td>';

					$table_rows[ 'pin_img_desc_max_len' ] = $this->form->get_tr_hide( 'basic', 'pin_img_desc_max_len' ) . 
						$this->form->get_th_html( _x( 'Image Description Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'pin_img_desc_max_len' ) . 
						'<td>' .
						$this->form->get_input( 'pin_img_desc_max_len', $css_class = 'chars' ) . ' ' . 
						_x( 'characters or less (hard limit), and warn at', 'option comment', 'wpsso' ) . ' ' . 
						$this->form->get_input( 'pin_img_desc_warn_len', $css_class = 'chars' ) . ' ' . 
						_x( 'characters (soft limit)', 'option comment', 'wpsso' ) . 
						'</td>';

					break;

				case 'pub-twitter':

					$tc_types = array(
						'summary'             => _x( 'Summary', 'option value', 'wpsso' ),
						'summary_large_image' => _x( 'Summary Large Image', 'option value', 'wpsso' ),
					);

					$table_rows[ 'tc_site' ] = '' . 
						$this->form->get_th_html_locale( _x( 'Twitter Business @username', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'tc_site' ) . 
						'<td>' . $this->form->get_input_locale( 'tc_site' ) . '</td>';

					$table_rows[ 'tc_title_max_len' ] = $this->form->get_tr_hide( 'basic', 'tc_title_max_len' ) . 
						$this->form->get_th_html( _x( 'Twitter Card Title Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'tc_title_max_len' ) . 
						'<td>' . $this->form->get_input( 'tc_title_max_len', $css_class = 'chars' ) . ' ' . 
						_x( 'characters or less', 'option comment', 'wpsso' ) . '</td>';

					$table_rows[ 'tc_desc_max_len' ] = $this->form->get_tr_hide( 'basic', 'tc_desc_max_len' ) . 
						$this->form->get_th_html( _x( 'Twitter Card Description Max. Length', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'tc_desc_max_len' ) . 
						'<td>' . $this->form->get_input( 'tc_desc_max_len', $css_class = 'chars' ) . ' ' . 
						_x( 'characters or less', 'option comment', 'wpsso' ) . '</td>';

					$table_rows[ 'tc_type_singular' ] = '' .
						$this->form->get_th_html( _x( 'Twitter Card for Singular with Image', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'tc_type_singular' ) . 
						'<td>' . $this->form->get_select( 'tc_type_singular', $tc_types ) . '</td>';

					$table_rows[ 'tc_type_default' ] = '' .
						$this->form->get_th_html( _x( 'Twitter Card Type by Default', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'tc_type_default' ) . 
						'<td>' . $this->form->get_select( 'tc_type_default', $tc_types ) . '</td>';

					break;

				case 'pub-other_sites':

					$table_rows[ 'ahrefs_site_verify' ] = '' .
						$this->form->get_th_html( _x( 'Ahrefs Website Verification ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'ahrefs_site_verify' ) . 
						'<td>' . $this->form->get_input( 'ahrefs_site_verify', 'api_key' ) . '</td>';

					$table_rows[ 'baidu_site_verify' ] = '' .
						$this->form->get_th_html( _x( 'Baidu Website Verification ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'baidu_site_verify' ) . 
						'<td>' . $this->form->get_input( 'baidu_site_verify', 'api_key' ) . '</td>';

					$table_rows[ 'bing_site_verify' ] = '' .
						$this->form->get_th_html( _x( 'Bing Website Verification ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'bing_site_verify' ) . 
						'<td>' . $this->form->get_input( 'bing_site_verify', 'api_key' ) . '</td>';

					$table_rows[ 'yandex_site_verify' ] = '' .
						$this->form->get_th_html( _x( 'Yandex Website Verification ID', 'option label', 'wpsso' ),
							$css_class = '', $css_id = 'yandex_site_verify' ) . 
						'<td>' . $this->form->get_input( 'yandex_site_verify', 'api_key' ) . '</td>';

					break;
			}

			return $table_rows;
		}
	}
}
