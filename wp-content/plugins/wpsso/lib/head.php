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

if ( ! class_exists( 'WpssoHead' ) ) {

	class WpssoHead {

		private $p;	// Wpsso class object.

		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			add_action( 'wp_head', array( $this, 'show_head' ), WPSSO_HEAD_PRIORITY );

			/**
			 * If an AMP plugin is active, hook 'amp_post_template_head' to add head markup for AMP pages.
			 */
			if ( ! empty( $this->p->avail[ 'amp' ][ 'any' ] ) ) {

				add_action( 'amp_post_template_head', array( $this, 'show_head' ), WPSSO_HEAD_PRIORITY );

				if ( $this->p->avail[ 'p' ][ 'schema' ] ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'disabling amp_post_template_metadata' );
					}

					add_filter( 'amp_post_template_metadata', '__return_empty_array', PHP_INT_MAX );
				}
			}

			/**
			 * If a caching plugin or service is active, reduce the head markup cache expiration.
			 */
			if ( ! empty( $this->p->avail[ 'cache' ][ 'any' ] ) ) {

				$this->p->util->add_plugin_filters( $this, array(
					'cache_expire_head_markup' => '__return_hour_in_seconds',
				) );
			}
		}

		public function add_vary_user_agent_header( $headers ) {

			$headers [ 'Vary' ] = 'User-Agent';

			return $headers;
		}

		/**
		 * Can return an empty string if $mixed and $sharing_rul are false.
		 *
		 * $mixed = 'default' | 'current' | post ID | $mod array
		 */
		public function get_head_cache_index( $mixed = 'current', $canonical_url = false ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$cache_index = '';

			if ( false !== $mixed ) {

				$cache_index .= '_locale:' . SucomUtil::get_locale( $mixed );
			}

			if ( false !== $canonical_url ) {

				$cache_index .= '_url:' . $canonical_url;
			}

			if ( SucomUtil::is_amp() ) {	// Returns null, true, or false.

				$cache_index .= '_amp:true';
			}

			$cache_index = trim( $cache_index, '_' );	// Cleanup leading underscores.

			$cache_index = apply_filters( 'wpsso_head_cache_index', $cache_index, $mixed, $canonical_url );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'returned cache index is "' . $cache_index . '"' );
			}

			return $cache_index;
		}

		/**
		 * Called by 'wp_head' and 'amp_post_template_head' actions.
		 */
		public function show_head() {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( function_exists( 'current_action' ) ) {	// Since WP v3.9.

				$current  = current_action();

			} else {

				$current  = current_filter();
			}

			$use_post = apply_filters( 'wpsso_use_post', false );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'required call to WpssoPage->get_mod()' );
			}

			$mod = $this->p->page->get_mod( $use_post );	// Get post/term/user ID, module name, and module object reference.

			$add_head_html = apply_filters( 'wpsso_add_head_html', true, $mod );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'home url = ' . get_option( 'home' ) );
				$this->p->debug->log( 'locale default = ' . SucomUtil::get_locale( 'default' ) );
				$this->p->debug->log( 'locale current = ' . SucomUtil::get_locale( 'current' ) );
				$this->p->debug->log( 'locale mod = ' . SucomUtil::get_locale( $mod ) );
				$this->p->debug->log( 'add head html = ' . ( $add_head_html ? 'true' : 'false' ) );

				$this->p->util->log_is_functions();
			}

			if ( $add_head_html ) {

				echo $this->get_head_html( $use_post, $mod, $read_cache = true );

			} else {

				echo "\n\n" . '<!-- wpsso head html is disabled -->' . "\n\n";
			}
		}

		/**
		 * Extract certain key fields for display and sanity checks.
		 *
		 * Save meta tag values for later sorting in list tables.
		 */
		public function extract_head_info( array $mod, array $head_mt ) {

			$head_info = array();

			foreach ( $head_mt as $mt ) {

				if ( ! isset( $mt[ 2 ] ) || ! isset( $mt[ 3 ] ) ) {

					continue;
				}

				$mt_match = $mt[ 2 ] . '-' . $mt[ 3 ];

				switch ( $mt_match ) {

					case 'property-og:url':
					case 'property-og:type':
					case 'property-og:title':
					case 'property-og:description':
					case 'property-article:author:name':
					case ( strpos( $mt_match, 'name-schema:' ) === 0 ? true : false ):
					case ( strpos( $mt_match, 'name-twitter:' ) === 0 ? true : false ):

						if ( ! isset( $head_info[ $mt[ 3 ] ] ) ) {	// Only save the first meta tag value.

							$head_info[ $mt[ 3 ] ] = $mt[ 5 ];
						}

						break;

					case ( preg_match( '/^property-((og|p):(image|video))(:secure_url|:url)?$/', $mt_match, $m ) ? true : false ):

						if ( ! empty( $mt[ 5 ] ) ) {

							$has_media[ $m[ 1 ] ] = true;	// Optimize media loop.
						}

						break;
				}
			}

			/**
			 * Save the first image and video information found. Assumes array key order defined by
			 * SucomUtil::get_mt_image_seed() and SucomUtil::get_mt_video_seed().
			 */
			foreach ( array( 'og:image', 'og:video', 'p:image' ) as $mt_pre ) {

				if ( empty( $has_media[ $mt_pre ] ) ) {

					continue;
				}

				$is_first = false;

				foreach ( $head_mt as $mt ) {

					if ( ! isset( $mt[ 2 ] ) || ! isset( $mt[ 3 ] ) ) {

						continue;
					}

					if ( strpos( $mt[ 3 ], $mt_pre ) !== 0 ) {

						$is_first = false;

						/**
						 * If we already found media, then skip to the next media prefix.
						 */
						if ( ! empty( $head_info[ $mt_pre ] ) ) {

							continue 2;

						} else {

							continue;	// Skip meta tags without matching prefix.
						}
					}

					$mt_match = $mt[ 2 ] . '-' . $mt[ 3 ];

					switch ( $mt_match ) {

						case ( preg_match( '/^property-' . $mt_pre . '(:secure_url|:url)?$/', $mt_match, $m ) ? true : false ):

							if ( ! empty( $head_info[ $mt_pre ] ) ) {	// Only save the media URL once.

								continue 2;				// Get the next meta tag.
							}

							if ( ! empty( $mt[ 5 ] ) ) {

								$head_info[ $mt_pre ] = $mt[ 5 ];	// Save the media URL.

								$is_first = true;
							}

							break;

						case ( preg_match( '/^property-' . $mt_pre . ':(width|height|cropped|id|title|description)$/', $mt_match, $m ) ? true : false ):

							if ( true !== $is_first ) {	// Only save for first media found.

								continue 2;		// Get the next meta tag.
							}

							$head_info[ $mt[ 3 ] ] = $mt[ 5 ];

							break;
					}
				}
			}

			/**
			 * Save meta tag values for later sorting in list tables.
			 */
			$sortable_cols = WpssoWpMeta::get_sortable_columns();

			foreach ( $sortable_cols as $col_key => $col_info ) {

				if ( empty( $col_info[ 'meta_key' ] ) || strpos( $col_info[ 'meta_key' ], '_wpsso_head_info_' ) !== 0 ) {

					continue;
				}

				$meta_value = 'none';

				if ( ! empty( $col_info[ 'mt_name' ]  ) ) {

					if ( 'og:image' === $col_info[ 'mt_name' ] ) {	// Get the image thumbnail HTML.

						if ( $media_html = $mod[ 'obj' ]->get_head_info_thumb_bg_img( $head_info, $mod ) ) {

							/**
							 * Example:
							 *
							 *	<div class="wp-thumb-bg-img" style="background-image:url(https://.../thumbnail.jpg);"></div>
							 */
							$meta_value = $media_html;
						}

					} elseif ( isset( $head_info[ $col_info[ 'mt_name' ] ] ) ) {

						$meta_value = $head_info[ $col_info[ 'mt_name' ] ];
					}
				}

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'updating meta for ' . $mod[ 'name' ] . ' id ' . $mod[ 'id' ] . ' ' . $col_key . ' = ' . $meta_value );
				}

				$mod[ 'obj' ]->update_sortable_meta( $mod[ 'id' ], $col_key, $meta_value );
			}

			return $head_info;
		}

		/**
		 * Deprecated on 2021/07/04.
		 */
		public function get_mt_mark( $type ) {

			return $this->get_mt_data( $type );
		}

		/**
		 * Called by WpssoHead->get_head_html() with $type = 'begin' and 'end'.
		 *
		 * Called by WpssoPost->check_post_head() and WpssoSsmFilters->strip_schema_microdata() with $type = 'preg'.
		 */
		public function get_mt_data( $type, $args = null ) {

			switch ( $type ) {

				case 'added':

					$total_secs = sprintf( '%f secs', $args );
					$home_url   = SucomUtilWP::raw_get_home_url();
					$home_path  = preg_replace( '/^[a-z]+:\/\//i', '', $home_url );	// Remove the protocol prefix.

					return '<meta name="wpsso-' . $type . '" content="' . date( 'c' ) . ' in ' . $total_secs .  ' for ' . $home_path . '">' . "\n";

				case 'begin':
				case 'end':

					return '<meta name="wpsso-' . $type . '" content="' . WPSSO_DATA_ID . ' ' . $type . '"/>' . "\n";

				case 'cached':

					return '<meta name="wpsso-' . $type . '" content="' . ( $args ? date( 'c' ) : 'no cache' ) . '">' . "\n";

				/**
				 * Used by WpssoPost->check_post_head() and WpssoSsmFilters->strip_schema_microdata().
				 */
				case 'preg':

					/**
					 * Some HTML optimization plugins or services may remove the double-quotes from the name
					 * attribute, along with the trailing space and slash characters, so make these optional in
					 * the regex.
					 */
					$preg_prefix = '<(meta[\s\n\r]+name="?wpsso-(begin|end)"?[\s\n\r]+content=")';
					$preg_suffix = '("[\s\n\r]*\/?)>';

					/**
					 * U = Invert greediness of quantifiers, so they are NOT greedy by default, but become greedy if followed by ?.
					 * u = Modifier to handle UTF-8 in subject strings.
					 * m = The "^" and "$" constructs match newlines and the complete subject string.
					 * s = A dot metacharacter in the pattern matches all characters, including newlines.
					 */
					return '/' . $preg_prefix . WPSSO_DATA_ID . ' begin' . $preg_suffix . '.*' .
						$preg_prefix . WPSSO_DATA_ID . ' end' . $preg_suffix . '/Uums';

				default:

					return '';
			}
		}

		public function get_head_html( $use_post = false, $mod = false, $read_cache = true ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$mtime_start = microtime( $get_float = true );
			$indent_num  = 0;

			/**
			 * The $mod array argument is preferred but not required.
			 */
			if ( ! is_array( $mod ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'optional call to WpssoPage->get_mod()' );
				}

				$mod = $this->p->page->get_mod( $use_post );
			}

			$html = "\n\n";

			$head_tags = $this->get_head_array( $use_post, $mod, $read_cache );

			foreach ( $head_tags as $mt ) {

				if ( ! empty( $mt[ 0 ] ) ) {

					if ( $indent_num && 0 === strpos( $mt[ 0 ], '</noscript' ) ) {

						$indent_num = 0;
					}

					$html .= str_repeat( "\t", (int) $indent_num ) . $mt[0];

					if ( 0 === strpos( $mt[ 0 ], '<noscript' ) ) {	// Indent meta tags within a noscript container.

						$indent_num = 1;
					}
				}
			}

			$mtime_total = microtime( $get_float = true ) - $mtime_start;

			$html .= $this->get_mt_data( 'added', $mtime_total ) . "\n";

			return $html;
		}

		/**
		 * $read_cache is false when called by the post/term/user load_meta_page() method.
		 */
		public function get_head_array( $use_post = false, $mod = false, $read_cache = true ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark( 'build head array' );	// Begin timer.
			}

			/**
			 * The $mod array argument is preferred but not required.
			 */
			if ( ! is_array( $mod ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'optional call to WpssoPage->get_mod()' );
				}

				$mod = $this->p->page->get_mod( $use_post );
			}

			/**
			 * The canonical URL is optional for SucomUtil::get_mod_salt().
			 */
			$canonical_url = $this->p->util->get_canonical_url( $mod, $add_page = true );

			if ( empty( $canonical_url ) ) {	// Just in case.

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: get_canonical_url() returned an empty string' );
				}

				return array();

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'canonical url = ' . $canonical_url );
			}

			/**
			 * Disable head and content cache if the request URL contains an unknown/extra query string.
			 */
			if ( ! is_admin() ) {

				$request_url = SucomUtil::get_url( $remove_tracking = true );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'request url = ' . $request_url );
				}

				if ( $request_url !== $canonical_url && false !== strpos( $request_url, '?' ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'extra query in request url - disabling head and content cache' );
					}

					$this->p->util->add_plugin_filters( $this, array(
						'cache_expire_head_markup' => '__return_zero',	// Used by WpssoHead->get_head_array().
						'cache_expire_the_content' => '__return_zero',	// Used by WpssoPage->get_the_content().
					) );
				}
			}

			/**
			 * Setup variables for transient cache.
			 *
			 * Note that get_cache_exp_secs() will return 0 for some pre-defined conditions in the $mod array (404,
			 * attachment, date, and search).
			 */
			$cache_md5_pre  = 'wpsso_h_';	// Transient prefix for head markup.
			$cache_exp_secs = $this->p->util->get_cache_exp_secs( $cache_md5_pre, $cache_type = 'transient', $mod );
			$cache_salt     = __METHOD__ . '(' . SucomUtil::get_mod_salt( $mod, $canonical_url ) . ')';
			$cache_id       = $cache_md5_pre . md5( $cache_salt );
			$cache_index    = $this->get_head_cache_index( $mod, $canonical_url );	// Includes locale, url, etc.
			$cache_array    = array();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'cache expire = ' . $cache_exp_secs );
				$this->p->debug->log( 'cache salt = ' . $cache_salt );
				$this->p->debug->log( 'cache id = ' . $cache_id );
				$this->p->debug->log( 'cache index = ' . $cache_index );
			}

			if ( $cache_exp_secs > 0 ) {

				if ( $read_cache ) {	// False when called by the post/term/user load_meta_page() method.

					$cache_array = SucomUtil::get_transient_array( $cache_id );

					if ( isset( $cache_array[ $cache_index ] ) ) {

						if ( is_array( $cache_array[ $cache_index ] ) ) {	// Just in case.

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log( 'cache index found in transient cache' );

								$this->p->debug->mark( 'build head array' );	// End timer.
							}

							return $cache_array[ $cache_index ];	// Stop here.

						} elseif ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'cache index is not an array' );
						}

					} else {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'cache index not in transient cache' );
						}

						if ( ! is_array( $cache_array ) ) {

							$cache_array = array();
						}
					}

				} elseif ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'read cache for head is disabled' );
				}
			}

			/**
			 * Set a general reference value for admin notices.
			 */
			$this->p->util->maybe_set_ref( $canonical_url, $mod );

			/**
			 * Define the author_id (if one is available).
			 */
			$author_id = WpssoUser::get_author_id( $mod );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'author_id = ' . ( false === $author_id ? 'false' : $author_id ) );
			}

			/**
			 * Open Graph - define first to pass the mt_og array to other methods.
			 */
			$this->p->util->maybe_set_ref( $canonical_url, $mod, __( 'adding open graph meta tags', 'wpsso' ) );

			$mt_og = $this->p->og->get_array( $mod );

			$this->p->util->maybe_unset_ref( $canonical_url );

			/**
			 * Twitter Cards.
			 */
			$this->p->util->maybe_set_ref( $canonical_url, $mod, __( 'adding twitter card meta tags', 'wpsso' ) );

			$mt_tc = $this->p->tc->get_array( $mod, $mt_og, $author_id );

			$this->p->util->maybe_unset_ref( $canonical_url );

			/**
			 * Name / SEO meta tags.
			 */
			$this->p->util->maybe_set_ref( $canonical_url, $mod, __( 'adding meta name meta tags', 'wpsso' ) );

			$mt_name = $this->p->meta_name->get_array( $mod, $mt_og, $author_id );

			$this->p->util->maybe_unset_ref( $canonical_url );

			/**
			 * Link relation tags.
			 */
			$this->p->util->maybe_set_ref( $canonical_url, $mod, __( 'adding link relation tags', 'wpsso' ) );

			$link_rel = $this->p->link_rel->get_array( $mod, $mt_og, $author_id );

			$this->p->util->maybe_unset_ref( $canonical_url );

			/**
			 * Schema json scripts.
			 */
			if ( empty( $this->p->avail[ 'p' ][ 'schema' ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'schema markup is disabled' );
				}

				$schema_scripts = array();

			} else {

				$this->p->util->maybe_set_ref( $canonical_url, $mod, __( 'adding schema json-ld markup', 'wpsso' ) );

				$schema_scripts = $this->p->schema->get_array( $mod, $mt_og );

				$this->p->util->maybe_unset_ref( $canonical_url );
			}

			/**
			 * Generator meta tags.
			 */
			$mt_gen = array( 'generator' => $this->p->check->get_ext_gen_list() );

			/**
			 * Combine and return all meta tags.
			 */
			$mt_og = $this->p->og->sanitize_mt_array( $mt_og );	// Unset mis-matched og_type meta tags.

			$cache_array[ $cache_index ] = array_merge(
				array(
					array( $this->get_mt_data( 'begin' ) ),
				),
				$this->get_mt_array( $tag = 'meta', $type = 'name', $mt_gen, $mod ),
				$this->get_mt_array( $tag = 'link', $type = 'rel', $link_rel, $mod ),
				$this->get_mt_array( $tag = 'meta', $type = 'property', $mt_og, $mod ),
				$this->get_mt_array( $tag = 'meta', $type = 'name', $mt_tc, $mod ),
				$this->get_mt_array( $tag = 'meta', $type = 'name', $mt_name, $mod ),	// SEO description is last.
				$schema_scripts,
				array(
					array( $this->get_mt_data( 'end' ) ),
					array( $this->get_mt_data( 'cached', $cache_exp_secs ) ),
				)
			);

			if ( $cache_exp_secs > 0 ) {

				/**
				 * Update the cached array and maintain the existing transient expiration time.
				 */
				$expires_in_secs = SucomUtil::update_transient_array( $cache_id, $cache_array, $cache_exp_secs );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'head array saved to transient cache (expires in ' . $expires_in_secs . ' secs)' );
				}
			}

			/**
			 * Unset the general reference value for admin notices.
			 */
			$this->p->util->maybe_unset_ref( $canonical_url );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark( 'build head array' );	// End timer.
			}

			return $cache_array[ $cache_index ];
		}

		private function get_mt_array( $tag, $type, array $mixed, array $mod ) {

			$mt_array = array();

			$this->add_mt_array( $mt_array, $tag, $type, $name = '', $mixed, $cmt = '', $mod, $use_image = true );

			return $mt_array;
		}

		/**
		 * Loops through the arrays and calls self->add_mt_singles() for each.
		 *
		 * The $name argument is required for numeric arrays.
		 *
		 * $mixed can be a null, boolean, a string, numeric, a numeric array, or an associative array.
		 */
		private function add_mt_array( array &$mt_array, $tag, $type, $name = '', $mixed, $cmt = '', $mod = false, $use_image = true ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( $mixed );
			}

			if ( is_array( $mixed ) ) {

				if ( SucomUtil::is_assoc( $mixed ) ) {

					if ( isset( $mixed[ 'og:video:type' ] ) ) {

						if ( empty( $mixed[ 'og:video:has_image' ] ) ) {

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log( 'ignoring video preview images' );
							}

							$use_image = false;
						}
					}

					foreach ( $mixed as $key => $value ) {

						if ( ! $use_image && 0 === strpos( $key, 'og:image' ) ) {

							continue;

						}

						if ( is_array( $value ) ) {

							$this->add_mt_array( $mt_array, $tag, $type, $key, $value, $cmt, $mod, $use_image );

						} else {

							$this->add_mt_singles( $mt_array, $tag, $type, $key, $value, $cmt, $mod );
						}

					}

				} else {

					foreach ( $mixed as $num => $value ) {

						$cmt_num = ltrim( $cmt . ':' . $name . ':' . ( $num + 1 ), ':' );

						if ( is_array( $value ) ) {

							$this->add_mt_array( $mt_array, $tag, $type, $name, $value, $cmt_num, $mod, $use_image );

						} else {

							$this->add_mt_singles( $mt_array, $tag, $type, $name, $value, $cmt_num, $mod );
						}
					}
				}

			} else {

				$this->add_mt_singles( $mt_array, $tag, $type, $name, $mixed, $cmt, $mod );

			}

			return $mt_array;
		}

		public function add_mt_singles( &$mt_array, $tag, $type, $name, $value, $cmt = '', $mod = false ) {

			/**
			 * Check for known exceptions for the "property" $type.
			 */
			if ( 'meta' === $tag ) {

				if ( 'property' === $type ) {

					/**
					 * Double-check the name to make sure its an open graph meta tag.
					 */
					switch ( $name ) {

						/**
						 * These names are not open graph meta tag names.
						 */
						case ( strpos( $name, 'twitter:' ) === 0 ? true : false ):
						case ( strpos( $name, 'schema:' ) === 0 ? true : false ):	// Internal meta tags.
						case ( strpos( $name, ':' ) === false ? true : false ):		// No colon in $name.

							$type = 'name';

							break;
					}

				} elseif ( 'itemprop' === $type ) {

					/**
					 * If an "itemprop" contains a url, then make sure it's a "link".
					 */
					if ( $tag !== 'link' && false !== filter_var( $value, FILTER_VALIDATE_URL ) ) {

						$tag = 'link';
					}
				}
			}

			/**
			 * Sanitation check for both "link rel href" and "link itemprop href" - all other meta tags use a "content"
			 * attribute name.
			 */
			if ( 'link' === $tag ) {

				$attr = 'href';

			} else {

				$attr = 'content';
			}

			$log_prefix = $tag . ' ' . $type . ' ' . $name;

			static $charset = null;

			if ( null === $charset  ) {

				$charset = get_bloginfo( 'charset' );
			}

			if ( is_array( $value ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( $log_prefix . ' value is an array (skipped)' );
				}

				return $mt_array;

			} elseif ( is_object( $value ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( $log_prefix . ' value is an object (skipped)' );
				}

				return $mt_array;
			}

			/**
			 * Expand inline variables.
			 */
			if ( false !== strpos( $value, '%%' ) ) {

				$value = $this->p->util->replace_inline_variables( $value, $mod );
			}

			static $last_secure_url = null;
			static $last_url        = null;

			$singles = array();

			switch ( $name ) {

				case 'og:image:secure_url':
				case 'og:video:secure_url':

					/**
					 * The secure url meta tag should always come first, but just in case it doesn't, make sure
					 * the url value has not already been added.
					 */
					if ( $last_url !== $value ) {	// Just in case.

						if ( $value ) {

							$name_secure_url = $name;
							$name_url        = str_replace( ':secure_url', ':url', $name );
							$name_no_url     = str_replace( ':secure_url', '', $name );

							if ( SucomUtil::is_https( $value ) ) {

								$singles[] = array( '', $tag, $type, $name_secure_url, $attr, $value, $cmt );
							}

							$singles[] = array( '', $tag, $type, $name_url, $attr, $value, $cmt );

							$singles[] = array( '', $tag, $type, $name_no_url, $attr, $value, $cmt );

							$last_secure_url = $value;

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log_arr( 'singles', $singles );
							}
						}
					}

					$last_url = null;

					break;

				case 'og:image:url':
				case 'og:video:url':

					/**
					 * The previous switch block would have set all three meta tags already, so only proceed if
					 * the last secure url (empty or not) is not equal to the current url value (empty or not).
					 */
					if ( $last_secure_url !== $value ) {	// Just in case.

						if ( $value ) {

							$name_secure_url = str_replace( ':url', ':secure_url', $name );
							$name_url        = $name;
							$name_no_url     = str_replace( ':url', '', $name );

							if ( SucomUtil::is_https( $value ) ) {

								$singles[] = array( '', $tag, $type, $name_secure_url, $attr, $value, $cmt );
							}

							$singles[] = array( '', $tag, $type, $name_url, $attr, $value, $cmt );

							$singles[] = array( '', $tag, $type, $name_no_url, $attr, $value, $cmt );

							$last_url = $value;

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log_arr( 'singles', $singles );
							}
						}
					}

					$last_secure_url = null;

					break;

				case 'og:image':
				case 'og:video':

					/**
					 * The previous two switch blocks would have set all three meta tags aready, so only
					 * proceed if we have a value, and it does not match the last secure url (empty or not) or
					 * the last insecure url (empty or not).
					 */
					if ( empty( $value ) || $value === $last_secure_url || $value === $last_url ) {

						break;
					}

					// No break.

				default:

					$singles[] = array( '', $tag, $type, $name, $attr, $value, $cmt );

					break;
			}


			/**
			 * $parts = array( $html, $tag, $type, $name, $attr, $value, $cmt );
			 */
			foreach ( $singles as $num => $parts ) {

				if ( ! array_key_exists( 6, $parts ) ) {	// Just in case - check for missing $value element.

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'parts array is incomplete (skipped)' );

						$this->p->debug->log_arr( '$parts', $parts );
					}

					continue;
				}

				$log_prefix = $parts[ 1 ] . ' ' . $parts[ 2 ] . ' ' . $parts[ 3 ];

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( $log_prefix . ' = "' . $parts[ 5 ] . '"' );
				}

				if ( '' === $parts[ 5 ] || null === $parts[ 5 ] ) {	// Allow for 0.

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( $log_prefix . ' skipped: value is empty' );
					}

					$singles[ $num ][ 5 ] = '';	// Avoid null values in REST API output.

					continue;

				} elseif ( $parts[ 5 ] === WPSSO_UNDEF || $parts[ 5 ] === (string) WPSSO_UNDEF ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( $log_prefix . ' skipped: value is ' . WPSSO_UNDEF );
					}

					continue;
				}

				/**
				 * Encode and escape all values, regardless if the head tag is enabled or not. If the head tag is
				 * enabled, HTML will be created and saved in $parts[ 0 ].
				 */
				if ( 'itemprop' === $parts[ 2 ] && 0 !== strpos( $parts[ 3 ], '.' ) ) {

					$match_name = preg_replace( '/^.*\./', '', $parts[ 3 ] );

				} else {

					$match_name = $parts[ 3 ];
				}

				/**
				 * Boolean values are converted to their string equivalent.
				 */
				if ( is_bool( $parts[ 5 ] ) ) {

					$parts[ 5 ] = $parts[ 5 ] ? 'true' : 'false';
				}

				switch ( $match_name ) {

					/**
					 * Description values that may include emoji.
					 */
					case 'og:title':
					case 'og:description':
					case 'og:image:alt':
					case 'twitter:title':
					case 'twitter:description':
					case 'twitter:image:alt':
					case 'description':
					case 'name':

						$parts[ 5 ] = SucomUtil::encode_html_emoji( $parts[ 5 ] );	// Does not double-encode.

						break;

					/**
					 * URL values that must be URL encoded.
					 */
					case 'og:secure_url':
					case 'og:url':
					case 'og:image:secure_url':
					case 'og:image:url':
					case 'og:image':
					case 'og:video:embed_url':
					case 'og:video:secure_url':
					case 'og:video:url':
					case 'og:video':
					case 'place:business:menu_url':
					case 'place:business:order_url':
					case 'twitter:image':
					case 'twitter:player':
					case 'canonical':
					case 'shortlink':
					case 'image':
					case 'hasmenu':	// Food establishment menu url.
					case 'url':

						$parts[ 5 ] = SucomUtil::esc_url_encode( $parts[ 5 ] );

						if ( $parts[ 2 ] === 'itemprop' ) {	// An itemprop URL must be a 'link'.

							$parts[ 1 ] = 'link';
							$parts[ 4 ] = 'href';
						}

						break;

					/**
					 * Allow for mobile app / non-standard protocols.
					 */
					case 'al:android:url':
					case 'al:ios:url':
					case 'al:web:url':
					case 'twitter:app:url:iphone':
					case 'twitter:app:url:ipad':
					case 'twitter:app:url:googleplay':

						$parts[ 5 ] = SucomUtil::esc_url_encode( $parts[ 5 ], $esc_url = false );

						break;

					/**
					 * Encode html entities for everything else.
					 */
					default:

						$parts[ 5 ] = htmlentities( $parts[ 5 ], ENT_QUOTES, $charset, $double_encode = false );

						break;
				}

				/**
				 * Convert mixed case itemprop names (for example) to lower case to determine the option key value.
				 */
				$opt_key = strtolower( 'add_' . $parts[ 1 ] . '_' . $parts[ 2 ] . '_' . $parts[ 3 ] );

				if ( ! empty( $this->p->options[ $opt_key ] ) ) {

					$parts[ 0 ] = ( empty( $parts[ 6 ] ) ? '' : '<!-- ' . $parts[ 6 ] . ' -->' ) . 
						'<' . $parts[ 1 ] . ' ' . $parts[ 2 ] . '="' . $match_name . '" ' . $parts[ 4 ] . '="' . $parts[ 5 ] . '"/>' . "\n";

				} elseif ( $this->p->debug->enabled ) {

					$this->p->debug->log( $log_prefix . ' skipped: option is disabled' );
				}

				$mt_array[] = $parts;	// Save the HTML and encoded value.
			}

			return $mt_array;
		}
	}
}
