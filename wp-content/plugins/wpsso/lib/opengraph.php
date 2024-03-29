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

if ( ! class_exists( 'WpssoOpenGraph' ) ) {

	class WpssoOpenGraph {

		private $p;	// Wpsso class object.
		private $ns;	// WpssoOpenGraphNS class object.

		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			/**
			 * Instantiate the WpssoOpenGraphNS class object.
			 */
			if ( ! class_exists( 'WpssoOpenGraphNS' ) ) {

				require_once WPSSO_PLUGINDIR . 'lib/opengraph-ns.php';
			}

			$this->ns = new WpssoOpenGraphNS( $plugin );

			$this->p->util->add_plugin_filters( $this, array(
				'plugin_image_sizes' => 1,
			) );

			$this->p->util->add_plugin_filters( $this, array(
				'get_post_options'  => 3,
				'save_post_options' => 4,
			), PHP_INT_MAX );
		}

		public function filter_plugin_image_sizes( array $sizes ) {

			$sizes[ 'og' ] = array(		// Option prefix.
				'name'         => 'opengraph',
				'label_transl' => _x( 'Open Graph (Facebook and oEmbed)', 'option label', 'wpsso' ),
			);

			return $sizes;
		}

		public function filter_get_post_options( $md_opts, $post_id, $mod ) {

			if ( is_admin() ) {	// Keep processing on the front-end to a minimum.

				/**
				 * If the Open Graph type isn't already hard-coded (ie. 'disabled' === 'og_type:is' ), then using
				 * the post type and the Schema type, check for a possible hard-coded Open Graph type.
				 */
				$md_opts = $this->maybe_update_post_og_type( $md_opts, $post_id, $mod );
			}

			return $md_opts;
		}

		public function filter_save_post_options( $md_opts, $post_id, $rel_id, $mod ) {

			/**
			 * If the Open Graph type isn't already hard-coded (ie. 'disabled' === 'og_type:is' ), then using the post
			 * type and the Schema type, check for a possible hard-coded Open Graph type.
			 */
			$md_opts = $this->maybe_update_post_og_type( $md_opts, $post_id, $mod );

			return $md_opts;
		}

		/**
		 * Returns the open graph type id or namespace value.
		 *
		 * Example: article, product, place, etc.
		 */
		public function get_mod_og_type( array $mod, $get_ns = false, $use_mod_opts = true ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			static $local_cache = array();

			$cache_salt = false;

			/**
			 * Optimize and cache post/term/user og type values.
			 */
			if ( ! empty( $mod[ 'name' ] ) && ! empty( $mod[ 'id' ] ) ) {

				$cache_salt = SucomUtil::get_mod_salt( $mod ) . '_ns:' . (string) $get_ns . '_opts:' . (string) $use_mod_opts;

				if ( isset( $local_cache[ $cache_salt ] ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'returning local cache value "' . $local_cache[ $cache_salt ] . '"' );
					}

					return $local_cache[ $cache_salt ];

				} elseif ( is_object( $mod[ 'obj' ] ) && $use_mod_opts ) {	// Check for a column og_type value in wp_cache.

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'checking for value from column wp_cache' );
					}

					if ( $col_info = WpssoWpMeta::get_sortable_columns( 'og_type' ) ) {

						$value = $mod[ 'obj' ]->get_column_wp_cache( $mod, $col_info );	// Can return 'none' or empty string.
					}

					if ( ! empty( $value ) ) {

						if ( $get_ns && $value !== 'none' ) {	// Return the og type namespace instead.

							$og_type_ns  = $this->p->cf[ 'head' ][ 'og_type_ns' ];

							if ( ! empty( $og_type_ns[ $value ] ) ) {

								$value = $og_type_ns[ $value ];

							} else {

								if ( $this->p->debug->enabled ) {

									$this->p->debug->log( 'columns wp_cache value "' . $value . '" not in og type ns' );
								}

								$value = '';
							}
						}

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'returning column wp_cache value "' . $value . '"' );
						}

						return $local_cache[ $cache_salt ] = $value;
					}
				}

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'no value found in local cache or column wp_cache' );
				}

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'skipped cache check: mod name and/or id value is empty' );
			}

			$default_key = apply_filters( 'wpsso_og_type_for_default', 'website', $mod );
			$og_type_ns  = $this->p->cf[ 'head' ][ 'og_type_ns' ];
			$type_id     = null;

			/**
			 * Get custom open graph type from post, term, or user meta.
			 */
			if ( $use_mod_opts ) {

				if ( ! empty( $mod[ 'obj' ] ) ) {	// Just in case.

					$type_id = $mod[ 'obj' ]->get_options( $mod[ 'id' ], 'og_type' );	// Returns null if index key not found.

					if ( empty( $type_id ) ) {	// Must be a non-empty string.

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'custom type id from meta is empty' );
						}

					} elseif ( $type_id === 'none' ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'custom type id is disabled with value none' );
						}

					} elseif ( empty( $og_type_ns[ $type_id ] ) ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'custom type id "' . $type_id . '" not in og types' );
						}

						$type_id = null;

					} elseif ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'custom type id "' . $type_id . '" from ' . $mod[ 'name' ] . ' meta' );
					}

				} elseif ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'skipping custom type id: mod object is empty' );
				}

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'skipping custom type id: use_mod_opts is false' );
			}

			if ( empty( $type_id ) ) {

				$is_custom = false;

			} else {

				$is_custom = true;
			}

			if ( empty( $type_id ) ) {	// If no custom of type, then use the default settings.

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'using plugin settings to determine og type' );
				}

				if ( $mod[ 'is_home' ] ) {	// Home page (static or blog archive).

					$type_id = $default_key;

					if ( $mod[ 'is_home_page' ] ) {	// Static front page (singular post).

						$type_id = $this->get_og_type_id_for_name( 'home_page' );

						$type_id = apply_filters( 'wpsso_og_type_for_home_page', $type_id, $mod );

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'using og type id "' . $type_id . '" for home page' );
						}

					} else {

						$type_id = $this->get_og_type_id_for_name( 'home_posts' );

						$type_id = apply_filters( 'wpsso_og_type_for_home_posts', $type_id, $mod );

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'using og type id "' . $type_id . '" for home posts' );
						}
					}

				} elseif ( $mod[ 'is_post' ] ) {

					if ( ! empty( $mod[ 'post_type' ] ) ) {

						if ( $mod[ 'is_post_type_archive' ] ) {

							$type_id = $this->get_og_type_id_for_name( 'post_archive' );

							$type_id = apply_filters( 'wpsso_og_type_for_post_type_archive_page', $type_id, $mod );

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log( 'using og type id "' . $type_id . '" for post_type_archive page' );
							}

						} elseif ( isset( $this->p->options[ 'og_type_for_' . $mod[ 'post_type' ] ] ) ) {

							$type_id = $this->get_og_type_id_for_name( $mod[ 'post_type' ] );

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log( 'using og type id "' . $type_id . '" from post type option value' );
							}

						} elseif ( ! empty( $og_type_ns[ $mod[ 'post_type' ] ] ) ) {

							$type_id = $mod[ 'post_type' ];

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log( 'using og type id "' . $type_id . '" from post type name' );
							}

						} else {	// Unknown post type.

							$type_id = $this->get_og_type_id_for_name( 'page' );

							$type_id = apply_filters( 'wpsso_og_type_for_post_type_unknown_type', $type_id, $mod );

							if ( $this->p->debug->enabled ) {

								$this->p->debug->log( 'using "page" og type for unknown post type ' . $mod[ 'post_type' ] );
							}
						}

					} else {	// Post objects without a post_type property.

						$type_id = $this->get_og_type_id_for_name( 'page' );

						$type_id = apply_filters( 'wpsso_og_type_for_post_type_empty_type', $type_id, $mod );

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'using "page" og type for empty post type' );
						}
					}

				} elseif ( $mod[ 'is_term' ] ) {

					if ( ! empty( $mod[ 'tax_slug' ] ) ) {

						$type_id = $this->get_og_type_id_for_name( 'tax_' . $mod[ 'tax_slug' ] );

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'using og type id "' . $type_id . '" from term option value' );
						}
					}

					if ( empty( $type_id ) ) {	// Just in case.

						$type_id = $this->get_og_type_id_for_name( 'archive_page' );
					}

				} elseif ( $mod[ 'is_user' ] ) {

					$type_id = $this->get_og_type_id_for_name( 'user_page' );

				} elseif ( $mod[ 'is_search' ] ) {

					$type_id = $this->get_og_type_id_for_name( 'search_page' );

				} elseif ( $mod[ 'is_archive' ] ) {

					$type_id = $this->get_og_type_id_for_name( 'archive_page' );

				} else {	// Everything else.

					$type_id = $default_key;

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'using default og type id "' . $default_key . '"' );
					}
				}
			}

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og type id before filter is "' . $type_id . '"' );
			}

			$type_id = apply_filters( 'wpsso_og_type', $type_id, $mod, $is_custom );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og type id after filter is "' . $type_id . '"' );
			}

			$get_value = false;

			if ( empty( $type_id ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'returning false: og type id is empty' );
				}

			} elseif ( $type_id === 'none' ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'returning false: og type id is disabled' );
				}

			} elseif ( ! isset( $og_type_ns[ $type_id ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'returning false: og type id "' . $type_id . '" is unknown' );
				}

			} elseif ( $get_ns ) {	// False by default.

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'returning og type namespace "' . $og_type_ns[ $type_id ] . '"' );
				}

				$get_value = $og_type_ns[ $type_id ];

			} else {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'returning og type id "' . $type_id . '"' );
				}

				$get_value = $type_id;
			}

			/**
			 * Optimize and cache post/term/user og type values.
			 */
			if ( $cache_salt ) {

				$local_cache[ $cache_salt ] = $get_value;
			}

			return $get_value;
		}

		/**
		 * $size_names can be a keyword (ie. 'opengraph' or 'schema'), a registered size name, or an array of size names.
		 *
		 * $size_name is passed as-is to $this->get_all_images().
		 */
		public function get_array( array $mod, $size_names = 'opengraph' ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$max_nums = $this->p->util->get_max_nums( $mod );

			/**
			 * 'wpsso_og_seed' is hooked by e-commerce modules to provide product meta tags.
			 */
			$mt_og = apply_filters( 'wpsso_og_seed', SucomUtil::get_mt_og_seed(), $mod );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log_arr( 'wpsso_og_seed filter returned:', $mt_og );
			}

			/**
			 * Facebook admins meta tag.
			 *
			 * Deprecated on 2020/10/23
			 */
			if ( ! isset( $mt_og[ 'fb:admins' ] ) ) {

				if ( ! empty( $this->p->options[ 'fb_admins' ] ) ) {

					foreach ( explode( ',', $this->p->options[ 'fb_admins' ] ) as $fb_admin ) {

						$mt_og[ 'fb:admins' ][] = trim( $fb_admin );
					}
				}
			}

			/**
			 * Facebook app id meta tag.
			 */
			if ( ! isset( $mt_og[ 'fb:app_id' ] ) ) {

				$mt_og[ 'fb:app_id' ] = $this->p->options[ 'fb_app_id' ];
			}

			/**
			 * Type id meta tag.
			 */
			if ( ! isset( $mt_og[ 'og:type' ] ) ) {

				$mt_og[ 'og:type' ] = $this->get_mod_og_type( $mod );

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og:type already defined = ' . $mt_og[ 'og:type' ] );
			}

			$type_id = $mt_og[ 'og:type' ];

			/**
			 * URL meta tag.
			 */
			if ( ! isset( $mt_og[ 'og:url' ] ) ) {

				$mt_og[ 'og:url' ] = $this->p->util->get_canonical_url( $mod, $add_page = true );

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og:url already defined = ' . $mt_og[ 'og:url' ] );
			}

			/**
			 * Locale meta tag.
			 */
			if ( ! isset( $mt_og[ 'og:locale' ] ) ) {

				$mt_og[ 'og:locale' ] = $this->get_fb_locale( $this->p->options, $mod );

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og:locale already defined = ' . $mt_og[ 'og:locale' ] );
			}

			/**
			 * Site name meta tag.
			 */
			if ( ! isset( $mt_og[ 'og:site_name' ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'getting site name for og:site_name meta tag' );
				}

				$mt_og[ 'og:site_name' ] = SucomUtil::get_site_name( $this->p->options, $mod );	// localized

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og:site_name already defined = ' . $mt_og[ 'og:site_name' ] );
			}

			/**
			 * Title meta tag.
			 */
			if ( ! isset( $mt_og[ 'og:title' ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'getting title for og:title meta tag' );
				}

				$mt_og[ 'og:title' ] = $this->p->page->get_title( $this->p->options[ 'og_title_max_len' ], '...', $mod );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'og:title value = ' . $mt_og[ 'og:title' ] );
				}

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og:title already defined = ' . $mt_og[ 'og:title' ] );
			}

			/**
			 * Description meta tag.
			 */
			if ( ! isset( $mt_og[ 'og:description' ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'getting description for og:description meta tag' );
				}

				$mt_og[ 'og:description' ] = $this->p->page->get_description( $this->p->options[ 'og_desc_max_len' ],
					'...', $mod, $read_cache = true, $this->p->options[ 'og_desc_hashtags' ] );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'og:description value = ' . $mt_og[ 'og:description' ] );
				}

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og:description already defined = ' . $mt_og[ 'og:description' ] );
			}

			/**
			 * Updated date / time meta tag.
			 */
			if ( ! isset( $mt_og[ 'og:updated_time' ] ) ) {

				if ( $mod[ 'post_modified_time' ] ) {	// ISO 8601 date or false.

					$mt_og[ 'og:updated_time' ] = $mod[ 'post_modified_time' ];
				}
			}

			/**
			 * Get all videos.
			 *
			 * Call before getting all images to find / use preview images.
			 */
			if ( ! isset( $mt_og[ 'og:video' ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'getting videos for og:video meta tag' );
				}

				if ( ! $this->p->check->pp() ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'no video modules available' );
					}

				} elseif ( $max_nums[ 'og_vid_max' ] > 0 ) {

					$mt_og[ 'og:video' ] = $this->get_all_videos( $max_nums[ 'og_vid_max' ], $mod );

					if ( empty( $mt_og[ 'og:video' ] ) ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'no videos returned' );
						}

						unset( $mt_og[ 'og:video' ] );

					} else {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'removing video images to avoid duplicates' );
						}

						foreach ( $mt_og[ 'og:video' ] as $key => $mt_single_video ) {

							if ( ! is_array( $mt_single_video ) ) {	// Just in case.

								if ( $this->p->debug->enabled ) {

									$this->p->debug->log( 'video ignored: $mt_single_video is not an array' );
								}

								continue;
							}

							$mt_og[ 'og:video' ][ $key ] = SucomUtil::preg_grep_keys( '/^og:image/', $mt_single_video, $invert = true );
						}
					}

				} else {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'videos disabled: maximum videos is 0 or less' );
					}
				}
			}

			/**
			 * Get all images.
			 */
			if ( ! isset( $mt_og[ 'og:image' ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'getting images for og:image meta tag' );
				}

				if ( $max_nums[ 'og_img_max' ] > 0 ) {

					$mt_og[ 'og:image' ] = $this->get_all_images( $max_nums[ 'og_img_max' ], $size_names, $mod );

					if ( empty( $mt_og[ 'og:image' ] ) ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'no images returned' );
						}

						unset( $mt_og[ 'og:image' ] );
					}

				} else {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'skipped getting images: maximum images is 0 or less' );
					}
				}
			}

			/**
			 * Pre-define some basic open graph meta tags for this og:type. If the meta tag has an associated meta
			 * option name, then read it's value from the meta options.
			 */
			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'checking og_type_mt array for known meta tags and md options' );
			}

			if ( isset( $this->p->cf[ 'head' ][ 'og_type_mt' ][ $type_id ] ) ) {	// Check if og:type is in config.

				/**
				 * Optimize and call get_options() only once. Returns an empty string if no meta found.
				 */
				$md_opts = empty( $mod[ 'obj' ] ) ? array() : (array) $mod[ 'obj' ]->get_options( $mod[ 'id' ] );

				/**
				 * Add post/term/user meta data to the Open Graph meta tags.
				 */
				$this->add_og_type_mt_md( $type_id, $mt_og, $md_opts );
			}

			/**
			 * If the module is a post object, define the author, publishing date, etc. These values may still be used
			 * by other non-article filters, and if the og:type is not an article, the meta tags will be sanitized (ie.
			 * non-valid meta tags removed) at the end of WpssoHead::get_head_array().
			 */
			if ( $mod[ 'is_post' ] && $mod[ 'id' ] ) {

				if ( ! isset( $mt_og[ 'article:author' ] ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'getting names / URLs for article:author meta tags' );
					}

					if ( $mod[ 'post_author' ] ) {

						/**
						 * Non-standard / internal meta tag used for display purposes.
						 */
						$mt_og[ 'article:author:name' ] = $this->p->user->get_author_meta( $mod[ 'post_author' ], 'display_name' );

						/**
						 * An array of author URLs.
						 */
						$mt_og[ 'article:author' ] = $this->p->user->get_authors_websites( $mod[ 'post_author' ],
							$this->p->options[ 'fb_author_field' ] );

					} else {

						$mt_og[ 'article:author' ] = array();
					}

					/**
					 * Add co-author URLs if available.
					 */
					if ( ! empty( $mod[ 'post_coauthors' ] ) ) {

						$og_profile_urls = $this->p->user->get_authors_websites( $mod[ 'post_coauthors' ],
							$this->p->options[ 'fb_author_field' ] );

						$mt_og[ 'article:author' ] = array_merge( $mt_og[ 'article:author' ], $og_profile_urls );
					}
				}

				if ( ! isset( $mt_og[ 'article:publisher' ] ) ) {

					$mt_og[ 'article:publisher' ] = SucomUtil::get_key_value( 'fb_publisher_url', $this->p->options, $mod );
				}

				if ( ! isset( $mt_og[ 'article:tag' ] ) ) {

					$mt_og[ 'article:tag' ] = $this->p->page->get_tag_names( $mod );
				}

				if ( ! isset( $mt_og[ 'article:published_time' ] ) ) {

					if ( $mod[ 'post_time' ] ) {	// ISO 8601 date or false.

						switch ( $mod[ 'post_status' ] ) {

							case 'auto-draft':
							case 'draft':
							case 'future':
							case 'inherit':	// Post revision.
							case 'pending':
							case 'trash':

								if ( $this->p->debug->enabled ) {

									$this->p->debug->log( 'skipping article published time for post status ' .  $mod[ 'post_status' ] );
								}

								break;

							case 'expired':	// Previously published.
							case 'private':
							case 'publish':
							default:	// Any other post status.

								$mt_og[ 'article:published_time' ] = $mod[ 'post_time' ];

								break;
						}
					}
				}

				if ( ! isset( $mt_og[ 'article:modified_time' ] ) ) {

					if ( $mod[ 'post_modified_time' ] ) {	// ISO 8601 date or false.

						$mt_og[ 'article:modified_time' ] = $mod[ 'post_modified_time' ];
					}
				}
			}

			if ( ! empty( $this->p->cf[ 'head' ][ 'og_type_ns' ][ $type_id ] ) ) {

				$og_ns = $this->p->cf[ 'head' ][ 'og_type_ns' ][ $type_id ];	// Example: https://ogp.me/ns/product#

				$filter_name = 'wpsso_og_data_' . SucomUtil::sanitize_hookname( $og_ns );

				$mt_og = (array) apply_filters( $filter_name, $mt_og, $mod );
			}

			$mt_og = (array) apply_filters( 'wpsso_og', $mt_og, $mod );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log_arr( 'wpsso_og filter returned:', $mt_og );
			}

			return $mt_og;
		}

		public function get_og_type_id_for_name( $type_name, $default_id = null ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log_args( array( 
					'type_name'  => $type_name,
					'default_id' => $default_id,
				) );
			}

			if ( empty( $type_name ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: og type name is empty' );
				}

				return $default_id;	// Just in case.
			}

			$og_type_ns = $this->p->cf[ 'head' ][ 'og_type_ns' ];

			$type_id = isset( $this->p->options[ 'og_type_for_' . $type_name] ) ?	// Just in case.
				$this->p->options[ 'og_type_for_' . $type_name] : $default_id;

			if ( empty( $type_id ) || $type_id === 'none' ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'og type id for ' . $type_name . ' is empty or disabled' );
				}

				$type_id = $default_id;

			} elseif ( empty( $og_type_ns[ $type_id ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'og type id "' . $type_id . '" for ' . $type_name . ' not in og type ns' );
				}

				$type_id = $default_id;

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'og type id for ' . $type_name . ' is ' . $type_id );
			}

			return $type_id;
		}

		public function get_og_types_select() {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			/**
			 * Use only supported (aka compat) Open Graph types.
			 */
			$og_type_ns = $this->p->cf[ 'head' ][ 'og_type_ns_compat' ];

			$select = array();

			foreach ( $og_type_ns as $type_id => $type_ns ) {

				$type_ns = preg_replace( '/(^.*\/\/|#$)/', '', $type_ns );

				$select[ $type_id ] = $type_id . ' | ' . $type_ns;
			}

			if ( defined( 'SORT_STRING' ) ) {	// Just in case.

				asort( $select, SORT_STRING );

			} else {

				asort( $select );
			}

			return $select;
		}

		public function get_all_previews( $num = 0, array $mod, $check_dupes = true, $md_pre = 'og', $force_prev = false ) {

			/**
			 * The get_all_videos() method uses the 'og_vid_max' argument as part of its caching salt, so re-use the
			 * original number to get all possible videos (from its cache), then maybe limit the number of preview
			 * images if necessary.
			 */
			$max_nums  = $this->p->util->get_max_nums( $mod );
			$mt_videos = $this->get_all_videos( $max_nums[ 'og_vid_max' ], $mod, $check_dupes, $md_pre, $force_prev );
			$mt_images = array();

			$this->p->util->clear_uniq_urls( array( 'preview' ) );

			foreach ( $mt_videos as $mt_single_video ) {

				$image_url = SucomUtil::get_first_mt_media_url( $mt_single_video );

				/**
				 * Check preview images for duplicates since the same videos may be available in different formats
				 * (application/x-shockwave-flash and text/html for example).
				 */
				if ( $image_url ) {

					if ( ! $check_dupes || $this->p->util->is_uniq_url( $image_url, 'preview' ) ) {

						$mt_single_image = SucomUtil::preg_grep_keys( '/^og:image/', $mt_single_video );

						if ( $this->p->util->push_max( $mt_images, $mt_single_image, $num ) ) {

							return $mt_images;
						}
					}
				}
			}

			return $mt_images;
		}

		/**
		 * Returns an array of single video associative arrays.
		 */
		public function get_all_videos( $num = 0, array $mod, $check_dupes = true, $md_pre = 'og', $force_prev = false ) {

			$cache_args = array(
				'num'         => $num,
				'mod'         => $mod,
				'check_dupes' => $check_dupes,
				'md_pre'      => $md_pre,
				'force_prev'  => $force_prev,
			);

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark( 'get all open graph videos' );	// Begin timer.

				$this->p->debug->log_args( $cache_args );
			}

			static $local_cache = array();

			$cache_salt = SucomUtil::pretty_array( $cache_args, $flatten = true );

			if ( isset( $local_cache[ $cache_salt ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'returning video data from local cache' );
				}

				return $local_cache[ $cache_salt ];

			}

			$local_cache[ $cache_salt ] = array();

			$mt_videos =& $local_cache[ $cache_salt ];

			if ( ! $this->p->check->pp() ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'no video modules available' );
				}

				return $mt_videos;	// Return an empty array.
			}

			$use_prev = $this->p->options[ 'og_vid_prev_img' ];

			$num_diff = SucomUtil::count_diff( $mt_videos, $num );

			$this->p->util->clear_uniq_urls( array( 'video', 'content_video', 'video_details' ) );

			/**
			 * Get video information and preview enable/disable option from the post/term/user meta.
			 */
			if ( ! empty( $mod[ 'obj' ] ) ) {

				/**
				 * Note that get_options() returns null if an index key is not found.
				 */
				if ( ( $mod_prev = $mod[ 'obj' ]->get_options( $mod[ 'id' ], 'og_vid_prev_img' ) ) !== null ) {

					$use_prev = $mod_prev;	// Use true/false/1/0 value from the custom option.

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'setting use_prev to ' . ( empty( $use_prev ) ? 'false' : 'true' ) . ' from meta data' );
					}
				}

				if ( $this->p->debug->enabled ) {

					$this->p->debug->mark( 'checking for custom videos in ' . $mod[ 'name' ] . ' options' );	// Begin timer.
				}

				/**
				 * get_og_videos() converts the $md_pre value to an array and always checks for 'og' metadata as a fallback.
				 */
				$mt_videos = array_merge( $mt_videos, $mod[ 'obj' ]->get_og_videos( $num_diff, $mod[ 'id' ], $check_dupes, $md_pre ) );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->mark( 'checking for custom videos in ' . $mod[ 'name' ] . ' options' );	// End timer.
				}

			}

			$num_diff = SucomUtil::count_diff( $mt_videos, $num );

			/**
			 * Optionally get more videos from the post content.
			 */
			if ( $mod[ 'is_post' ] && ! $this->p->util->is_maxed( $mt_videos, $num ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->mark( 'checking for additional videos in the post content' );	// Begin timer.
				}

				$mt_videos = array_merge( $mt_videos, $this->p->media->get_content_videos( $num_diff, $mod, $check_dupes ) );

				if ( $this->p->debug->enabled ) {

					$this->p->debug->mark( 'checking for additional videos in the post content' );	// End timer.
				}
			}

			$this->p->util->slice_max( $mt_videos, $num );

			/**
			 * Optionally remove the image meta tags (aka video preview).
			 */
			if ( empty( $use_prev ) && empty( $force_prev ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'use_prev and force_prev are false - removing video preview images' );
				}

				foreach ( $mt_videos as &$mt_single_video ) {	// Uses reference.

					$mt_single_video = SucomUtil::preg_grep_keys( '/^og:image/', $mt_single_video, $invert = true );

					$mt_single_video[ 'og:video:has_image' ] = false;
				}
			}

			/**
			 * Get custom video information from post/term/user meta data for the FIRST video.
			 *
			 * If $md_pre is 'none' (special index keyword), then don't load any custom video information. The
			 * og:video:title and og:video:description meta tags are not standard and their values will only appear in
			 * Schema markup.
			 */
			if ( ! empty( $mod[ 'obj' ] ) && $md_pre !== 'none' ) {

				foreach ( $mt_videos as &$mt_single_video ) {	// Uses reference.

					foreach ( array(
						'og_vid_width'  => 'og:video:width',
						'og_vid_height' => 'og:video:height',
						'og_vid_title'  => 'og:video:title',
						'og_vid_desc'   => 'og:video:description',
					) as $md_key => $mt_name ) {

						/**
						 * Note that get_options() returns null if an index key is not found.
						 */
						$value = $mod[ 'obj' ]->get_options( $mod[ 'id' ], $md_key );

						if ( ! empty( $value ) ) {	// Must be a non-empty string.

							$mt_single_video[ $mt_name ] = $value;
						}
					}

					break;	// Only do the first video.
				}
			}

			$mt_extend = array();

			foreach ( $mt_videos as &$mt_single_video ) {	// Uses reference.

				if ( ! is_array( $mt_single_video ) ) {	// Just in case.

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'video ignored: $mt_single_video is not an array' );
					}

					continue;
				}

				if ( 'text/html' !== $mt_single_video[ 'og:video:type' ] && ! empty( $mt_single_video[ 'og:video:embed_url' ] ) ) {

					/**
					 * Start with a fresh copy of all og meta tags.
					 */
					$og_single_embed = SucomUtil::get_mt_video_seed( 'og', $mt_single_video, false );

					/**
					 * Use only og meta tags, excluding the facebook applink meta tags.
					 */
					$og_single_embed = SucomUtil::preg_grep_keys( '/^og:/', $og_single_embed );

					unset( $og_single_embed[ 'og:video:secure_url' ] );	// Just in case.

					$og_single_embed[ 'og:video:url' ]  = $mt_single_video[ 'og:video:embed_url' ];
					$og_single_embed[ 'og:video:type' ] = 'text/html';

					/**
					 * Embedded videos may not have width / height information defined.
					 */
					foreach ( array( 'og:video:width', 'og:video:height' ) as $mt_name ) {

						if ( isset( $og_single_embed[ $mt_name ] ) && $og_single_embed[ $mt_name ] === '' ) {

							unset( $og_single_embed[ $mt_name ] );
						}
					}

					/**
					 * Add application/x-shockwave-flash video first and the text/html video second.
					 */
					if ( SucomUtil::get_first_mt_media_url( $mt_single_video, $media_pre = 'og:video', $mt_suffixes = array( ':secure_url', ':url', '' ) ) ) {

						$mt_extend[] = $mt_single_video;
					}

					$mt_extend[] = $og_single_embed;

				} else {

					$mt_extend[] = $mt_single_video;
				}
			}

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'returning ' . count( $mt_extend ) . ' videos' );

				$this->p->debug->log_arr( '$mt_extend', $mt_extend );

				$this->p->debug->mark( 'get all open graph videos' );	// End timer.
			}

			/**
			 * Update the local static cache and return the videos array.
			 */
			return $mt_videos = $mt_extend;
		}

		/**
		 * $size_names can be a keyword (ie. 'opengraph' or 'schema'), a registered size name, or an array of size names.
		 *
		 * $size_name is passed as-is to $this->get_all_images().
		 */
		public function get_thumbnail_url( $size_names = 'thumbnail', array $mod, $md_pre = 'og' ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$mt_ret = $this->get_all_images( $num = 1, $size_names, $mod, $check_dupes = true, $md_pre );

			return SucomUtil::get_first_mt_media_url( $mt_ret );
		}

		/**
		 * $size_names can be a keyword (ie. 'opengraph' or 'schema'), a registered size name, or an array of size names.
		 */
		public function get_all_images( $num, $size_names = 'opengraph', array $mod, $check_dupes = true, $md_pre = 'og' ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark( 'get all images' );	// Begin timer.

				$this->p->debug->log_args( array(
					'num'         => $num,
					'size_names'  => $size_names,
					'mod'         => $mod,
					'check_dupes' => $check_dupes,
					'md_pre'      => $md_pre,
				) );
			}

			$mt_ret = array();

			$size_names = $this->p->util->get_image_size_names( $size_names );	// Always returns an array.

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'getting all video preview images' );
			}

			$preview_images = $this->get_all_previews( $num, $mod );

			if ( empty( $preview_images ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'no video preview images' );
				}

			} else {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'merging video preview images' );
				}

				$mt_ret = array_merge( $mt_ret, $preview_images );
			}

			$num_diff = SucomUtil::count_diff( $mt_ret, $num );

			if ( $num_diff >= 1 ) {	// Just in case.

				foreach ( $size_names as $size_name ) {

					/**
					 * $size_name must be a string.
					 */
					$mt_images = $this->get_size_name_images( $num_diff, $size_name, $mod, $check_dupes, $md_pre );

					if ( empty( $mt_images ) ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'no images for size name ' . $size_name );
						}

					} else {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'merging ' . count( $mt_images ) . ' images for size name ' . $size_name );
						}

						$mt_ret = array_merge( $mt_ret, $mt_images );
					}
				}
			}

			return $mt_ret;
		}

		/**
		 * $size_name must be a string.
		 */
		public function get_size_name_images( $num, $size_name, array $mod, $check_dupes = true, $md_pre = 'og' ) {

			if ( ! is_string( $size_name ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: $size_name argument must be a string' );
				}

				return array();

			} elseif ( $num < 1 ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: $num argument must be 1 or more' );
				}

				return array();
			}

			$size_info = $this->p->util->get_size_info( $size_name );

			if ( empty( $size_info[ 'width' ] ) && empty( $size_info[ 'height' ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: missing size information for ' . $size_name );
				}

				return array();
			}

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'getting ' . $num . ' images for size name ' . $size_name );
			}

			$mt_ret = array();

			$this->p->util->clear_uniq_urls( $size_name );	// Clear cache for $size_name context.

			if ( $mod[ 'is_post' ] ) {

				if ( $mod[ 'is_attachment' ] && wp_attachment_is_image( $mod[ 'id' ] ) ) {

					/**
					 * $size_name must be a string.
					 */
					$mt_single_image = $this->p->media->get_attachment_image( $num, $size_name, $mod[ 'id' ], $check_dupes );

					if ( empty( $mt_single_image ) ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'exiting early: no attachment image' );
						}

						return $mt_ret;
					}

					return array_merge( $mt_ret, $mt_single_image );
				}

				/**
				 * Check for custom meta, featured, or attached image(s).
				 *
				 * Allow for empty post ID in order to execute featured / attached image filters for modules.
				 */
				$post_images = $this->p->media->get_post_images( $num, $size_name, $mod[ 'id' ], $check_dupes, $md_pre );

				if ( ! empty( $post_images ) ) {

					$mt_ret = array_merge( $mt_ret, $post_images );
				}

				/**
				 * Check for NGG query variables and shortcodes.
				 */
				if ( ! empty( $this->p->m[ 'media' ][ 'ngg' ] ) && ! $this->p->util->is_maxed( $mt_ret, $num ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'checking for NGG query variables and shortcodes' );
					}

					$ngg_obj =& $this->p->m[ 'media' ][ 'ngg' ];

					$num_diff = SucomUtil::count_diff( $mt_ret, $num );

					$query_images = $ngg_obj->get_query_og_images( $num_diff, $size_name, $mod[ 'id' ], $check_dupes );

					if ( count( $query_images ) > 0 ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'skipping NGG shortcode check: ' . count( $query_images ) . ' query image(s) returned' );
						}

						$mt_ret = array_merge( $mt_ret, $query_images );

					} elseif ( ! $this->p->util->is_maxed( $mt_ret, $num ) ) {

						$num_diff = SucomUtil::count_diff( $mt_ret, $num );

						$shortcode_images = $ngg_obj->get_shortcode_og_images( $num_diff, $size_name, $mod[ 'id' ], $check_dupes );

						if ( ! empty( $shortcode_images ) ) {

							$mt_ret = array_merge( $mt_ret, $shortcode_images );
						}
					}

				}

				/**
				 * If we haven't reached the limit of images yet, keep going and check the content text.
				 */
				if ( ! $this->p->util->is_maxed( $mt_ret, $num ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'checking the content text for images' );
					}

					$num_diff = SucomUtil::count_diff( $mt_ret, $num );

					$content_images = $this->p->media->get_content_images( $num_diff, $size_name, $mod, $check_dupes );

					if ( ! empty( $content_images ) ) {

						$mt_ret = array_merge( $mt_ret, $content_images );
					}
				}

			} else {

				/**
				 * get_og_images() provides filter hooks for additional image IDs and URLs.
				 *
				 * Unless $md_pre is 'none', get_og_images() will fallback to using the 'og' custom meta.
				 */
				if ( ! empty( $mod[ 'obj' ] ) ) {	// Term or user.

					$mt_images = $mod[ 'obj' ]->get_og_images( $num, $size_name, $mod[ 'id' ], $check_dupes, $md_pre );

					if ( ! empty( $mt_images ) ) {

						$mt_ret = array_merge( $mt_ret, $mt_images );
					}
				}
			}

			if ( empty( $mt_ret ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'no image(s) found - getting the default image' );
				}

				$mt_ret = $this->p->media->get_default_images( $size_name );

				if ( $this->p->debug->enabled ) {

					if ( empty( $mt_ret ) ) {

						$this->p->debug->log( 'no default image' );

					} else {

						$this->p->debug->log( 'default image found' );
					}
				}
			}

			$this->p->util->slice_max( $mt_ret, $num );

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'returning ' . count( $mt_ret ) . ' images' );

				$this->p->debug->log_arr( '$mt_ret', $mt_ret );
			}

			return $mt_ret;
		}

		/**
		 * The returned array can include a varying number of elements, depending on the $request value.
		 * 
		 * $md_pre may be 'none' when getting Open Graph option defaults (and not their custom values).
		 *
		 * $size_name should be a string, not an array.
		 */
		public function get_media_info( $size_name, array $request, array $mod, $md_pre = 'og', $mt_pre = 'og' ) {

			if ( ! is_string( $size_name ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: $size_name argument must be a string' );
				}

				return array();

			} elseif ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$media_info = array();
			$mt_images  = null;
			$mt_videos  = null;

			foreach ( $request as $key ) {

				switch ( $key ) {

					case 'pid':
					case ( preg_match( '/^(image|img)/', $key ) ? true : false ):

						/**
						 * Get images only once.
						 */
						if ( null === $mt_images ) {

							$mt_images = $this->get_size_name_images( $num = 1, $size_name, $mod, $check_dupes = true, $md_pre );
						}

						break;

					case ( preg_match( '/^(vid|prev)/', $key ) ? true : false ):

						/**
						 * Get videos only once.
						 */
						if ( null === $mt_videos ) {

							$mt_videos = $this->get_all_videos( $num = 1, $mod, $check_dupes = true, $md_pre );
						}

						break;
				}
			}

			foreach ( $request as $key ) {

				switch ( $key ) {

					case 'pid':

						if ( ! isset( $get_mt_name ) ) {

							$get_mt_name = $mt_pre . ':image:id';
						}

						// No break - fall through.

					case 'image':
					case 'img_url':

						if ( ! isset( $get_mt_name ) ) {

							$get_mt_name = $mt_pre . ':image';
						}

						// No break - fall through.

						if ( null !== $mt_videos ) {

							$media_info[ $key ] = $this->get_media_value( $mt_videos, $get_mt_name );
						}

						if ( empty( $media_info[ $key ] ) ) {

							$media_info[ $key ] = $this->get_media_value( $mt_images, $get_mt_name );
						}

						break;

					case 'img_alt':

						$media_info[ $key ] = $this->get_media_value( $mt_images, $mt_pre . ':image:alt' );

						break;

					case 'video':
					case 'vid_url':

						$media_info[ $key ] = $this->get_media_value( $mt_videos, $mt_pre . ':video' );

						break;

					case 'vid_type':

						$media_info[ $key ] = $this->get_media_value( $mt_videos, $mt_pre . ':video:type' );

						break;

					case 'vid_title':

						$media_info[ $key ] = $this->get_media_value( $mt_videos, $mt_pre . ':video:title' );

						break;

					case 'vid_desc':

						$media_info[ $key ] = $this->get_media_value( $mt_videos, $mt_pre . ':video:description' );

						break;

					case 'vid_width':

						$media_info[ $key ] = $this->get_media_value( $mt_videos, $mt_pre . ':video:width' );

						break;

					case 'vid_height':

						$media_info[ $key ] = $this->get_media_value( $mt_videos, $mt_pre . ':video:height' );

						break;

					case 'vid_prev':
					case 'prev_url':
					case 'preview':

						$media_info[ $key ] = $this->get_media_value( $mt_videos, $mt_pre . ':video:thumbnail_url' );

						break;

					default:

						$media_info[ $key ] = '';

						break;
				}

				unset( $get_mt_name );
			}

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( $media_info );
			}

			return $media_info;
		}

		/**
		 * Also used by the WpssoProMediaGravatar class to get the default image URL.
		 */
		public function get_media_value( $mt_og, $media_pre ) {

			if ( empty( $mt_og ) || ! is_array( $mt_og ) ) {	// Nothing to do.

				return '';
			}

			$og_media = reset( $mt_og );	// Only search the first media array.

			switch ( $media_pre ) {

				/**
				 * If we're asking for an image or video url, then search all three values sequentially.
				 */
				case ( preg_match( '/:(image|video)(:secure_url|:url)?$/', $media_pre ) ? true : false ):

					$mt_search = array(
						$media_pre . ':secure_url',	// og:image:secure_url
						$media_pre . ':url',		// og:image:url
						$media_pre,			// og:image
					);

					break;

				/**
				 * Otherwise, only search for that specific meta tag name.
				 */
				default:

					$mt_search = array( $media_pre );

					break;
			}

			foreach ( $mt_search as $key ) {

				if ( ! isset( $og_media[ $key ] ) ) {

					continue;

				} elseif ( '' === $og_media[ $key ] || null === $og_media[ $key ] ) {	// Allow for 0.

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( $og_media[ $key ] . ' value is empty (skipped)' );
					}

				} elseif ( WPSSO_UNDEF === $og_media[ $key ] || (string) WPSSO_UNDEF === $og_media[ $key ] ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( $og_media[ $key ] . ' value is ' . WPSSO_UNDEF . ' (skipped)' );
					}

				} else {

					return $og_media[ $key ];
				}
			}

			return '';
		}

		/**
		 * Returns an optional and customized locale value for the og:locale meta tag.
		 *
		 * $mixed = 'default' | 'current' | post ID | $mod array
		 */
		public function get_fb_locale( array $opts, $mixed = 'current' ) {

			/**
			 * Check for customized locale.
			 */
			if ( ! empty( $opts ) ) {

				$fb_locale_key = SucomUtil::get_key_locale( 'fb_locale', $opts, $mixed );

				if ( ! empty( $opts[ $fb_locale_key ] ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'returning "' . $opts[ $fb_locale_key ] . '" locale for "' . $fb_locale_key . '" option key' );
					}

					return $opts[ $fb_locale_key ];
				}
			}

			/**
			 * Get the locale requested in $mixed.
			 *
			 * $mixed = 'default' | 'current' | post ID | $mod array
			 */
			$locale = SucomUtil::get_locale( $mixed );

			if ( empty( $locale ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'exiting early: locale value is empty' );
				}

				return $locale;
			}

			/**
			 * Fix known exceptions.
			 */
			switch ( $locale ) {

				case 'de_DE_formal':

					$locale = 'de_DE';

					break;
			}

			/**
			 * Return the Facebook equivalent for this WordPress locale.
			 */
			$fb_pub_lang = SucomUtil::get_pub_lang( 'facebook' );

			if ( ! empty( $fb_pub_lang[ $locale ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'returning valid facebook locale "' . $locale . '"' );
				}

				return $locale;

			}

			/**
			 * Fallback to the default WordPress locale.
			 */
			$def_locale  = SucomUtil::get_locale( 'default' );

			if ( ! empty( $fb_pub_lang[ $def_locale ] ) ) {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'returning default locale "' . $def_locale . '"' );
				}

				return $def_locale;

			}

			/**
			 * Fallback to en_US.
			 */
			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'returning fallback locale "en_US"' );
			}

			return 'en_US';
		}

		/**
		 * Called by WpssoHead::get_head_array() before merging all meta tag arrays.
		 *
		 * Unset mis-matched og_type meta tags using the 'og_type_mt' array as a reference. For example, remove all
		 * 'article' meta tags if the og_type is 'website'. Removing only known meta tags (using the 'og_type_mt' array as
		 * a reference) protects internal meta tags that may be used later by WpssoHead->extract_head_info(). For example,
		 * the schema:type:id and p:image meta tags.
		 *
		 * The 'og_content_map' array is also checked for Schema values that need to be swapped for simpler Open Graph meta
		 * tag values.
		 */
		public function sanitize_mt_array( array $mt_og ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			/**
			 * Array of meta tags to allow, reject, and map.
			 */
			static $allow  = null;
			static $reject = null;
			static $map    = null;

			if ( null === $allow ) {	// Define the static variables once.

				/**
				 * The og:type is only needed when first run, to define the allow, reject, and map arrays.
				 */
				if ( empty( $mt_og[ 'og:type' ] ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'exiting early: og:type is empty and required for sanitation' );
					}

					return $mt_og;
				}

				$og_type = $mt_og[ 'og:type' ];

				$allow  = array();
				$reject = array();
				$map    = array();

				foreach ( $this->p->cf[ 'head' ][ 'og_type_mt' ] as $type_id => $og_type_mt_md ) {

					foreach ( $og_type_mt_md as $mt_name => $md_key ) {

						if (  $type_id === $og_type ) {

							$allow[ $mt_name ] = true;

							/**
							 * 'product:availability' => array(
				 			 * 	'https://schema.org/Discontinued'        => 'oos',
				 			 * 	'https://schema.org/InStock'             => 'instock',
				 			 * 	'https://schema.org/InStoreOnly'         => 'instock',
				 			 * 	'https://schema.org/LimitedAvailability' => 'instock',
				 			 * 	'https://schema.org/OnlineOnly'          => 'instock',
				 			 * 	'https://schema.org/OutOfStock'          => 'oos',
				 			 * 	'https://schema.org/PreOrder'            => 'pending',
				 			 * 	'https://schema.org/SoldOut'             => 'oos',
							 * ),
							 */
							if ( ! empty( $this->p->cf[ 'head' ][ 'og_content_map' ][ $mt_name ] ) ) {

								$map[ $mt_name ] = $this->p->cf[ 'head' ][ 'og_content_map' ][ $mt_name ];
							}

						} else {

							$reject[ $mt_name ] = true;
						}
					}
				}
			}

			/**
			 * Check the meta tag names and their values.
			 */
			foreach ( $mt_og as $key => $val ) {

				if ( ! empty( $allow[ $key ] ) ) {

					if ( isset( $map[ $key ][ $val ] ) ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'mapping content value for ' . $key );
						}

						$mt_og[ $key ] = $map[ $key ][ $val ];	// Example: 'OutOfStock' to 'oos'.
					}

				} elseif ( ! empty( $reject[ $key ] ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'removing extra meta tag ' . $key );
					}

					unset( $mt_og[ $key ] );

				} elseif ( is_array( $val ) ) {

					$mt_og[ $key ] = $this->sanitize_mt_array( $val );
				}
			}

			return $mt_og;
		}

		/**
		 * Add post/term/user meta data to the Open Graph meta tags.
		 */
		public function add_og_type_mt_md( $type_id, array &$mt_og, array $md_opts ) {	// Pass by reference is OK.

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( empty( $this->p->cf[ 'head' ][ 'og_type_mt' ][ $type_id ] ) ) {	// Just in case.

				return;
			}

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log( 'loading og_type_mt array for type id ' . $type_id );
			}

			/**
			 * Example $og_type_mt_md array:
			 *
			 *	'product' => array(
			 *		'product:age_group'               => '',
			 *		'product:availability'            => 'product_avail',
			 *		'product:brand'                   => 'product_brand',
			 *		'product:category'                => 'product_category',
			 *		'product:color'                   => 'product_color',
			 *		'product:condition'               => 'product_condition',
			 *		'product:depth:value'             => 'product_depth_value',
			 *		'product:depth:units'             => '',
			 *		'product:ean'                     => 'product_gtin13',
			 *		'product:expiration_time'         => '',
			 *		'product:gtin14'                  => 'product_gtin14',
			 *		'product:gtin13'                  => 'product_gtin13',
			 *		'product:gtin12'                  => 'product_gtin12',
			 *		'product:gtin8'                   => 'product_gtin8',
			 *		'product:gtin'                    => 'product_gtin',
			 *		'product:height:value'            => 'product_height_value',
			 *		'product:height:units'            => '',
			 *		'product:is_product_shareable'    => '',
			 *		'product:isbn'                    => 'product_isbn',
			 *		'product:length:value'            => 'product_length_value',
			 *		'product:length:units'            => '',
			 *		'product:material'                => 'product_material',
			 *		'product:mfr_part_no'             => 'product_mfr_part_no',
			 *		'product:original_price:amount'   => '',
			 *		'product:original_price:currency' => '',
			 *		'product:pattern'                 => '',
			 *		'product:plural_title'            => '',
			 *		'product:pretax_price:amount'     => '',
			 *		'product:pretax_price:currency'   => '',
			 *		'product:price:amount'            => 'product_price',
			 *		'product:price:currency'          => 'product_currency',
			 *		'product:product_link'            => '',
			 *		'product:purchase_limit'          => '',
			 *		'product:retailer'                => '',
			 *		'product:retailer_category'       => '',
			 *		'product:retailer_item_id'        => '',
			 *		'product:retailer_part_no'        => 'product_retailer_part_no',
			 *		'product:retailer_title'          => '',
			 *		'product:sale_price:amount'       => '',
			 *		'product:sale_price:currency'     => '',
			 *		'product:sale_price_dates:start'  => '',
			 *		'product:sale_price_dates:end'    => '',
			 *		'product:shipping_cost:amount'    => '',
			 *		'product:shipping_cost:currency'  => '',
			 *		'product:shipping_weight:value'   => '',
			 *		'product:shipping_weight:units'   => '',
			 *		'product:size'                    => 'product_size',
			 *		'product:target_gender'           => 'product_target_gender',
			 *		'product:upc'                     => 'product_gtin12',
			 *		'product:fluid_volume:value'      => 'product_fluid_volume_value',
			 *		'product:fluid_volume:units'      => '',
			 *		'product:weight:value'            => 'product_weight_value',
			 *		'product:weight:units'            => '',
			 *		'product:width:value'             => 'product_width_value',
			 *		'product:width:units'             => '',
			 *	)
			 */
			$og_type_mt_md = $this->p->cf[ 'head' ][ 'og_type_mt' ][ $type_id ];

			foreach ( $og_type_mt_md as $mt_name => $md_key ) {

				/**
				 * Use a custom value if one is available - ignore empty strings and 'none'.
				 */
				if ( ! empty( $md_key ) && isset( $md_opts[ $md_key ] ) && $md_opts[ $md_key ] !== '' ) {

					if ( $md_opts[ $md_key ] === 'none' ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'unsetting ' . $mt_name . ': ' . $md_key . ' metadata is "none"' );
						}

						unset( $mt_og[ $mt_name ] );

					/**
					 * Check for meta data and meta tags that require a unit value.
					 *
					 * Example: 
					 *
					 *	'product:depth:value'        => 'product_depth_value',
					 *	'product:height:value'       => 'product_height_value',
					 *	'product:length:value'       => 'product_length_value',
					 *	'product:fluid_volume:value' => 'product_fluid_volume_value',
					 *	'product:weight:value'       => 'product_weight_value',
					 *	'product:width:value'        => 'product_width_value',
					 */
					} elseif ( preg_match( '/^(.*):value$/', $mt_name, $mt_match ) && 
						preg_match( '/^[^_]+_(.*)_value$/', $md_key, $unit_match ) ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( $mt_name . ' from metadata = ' . $md_opts[ $md_key ] );
						}

						$mt_og[ $mt_name ] = $md_opts[ $md_key ];

						$mt_units = $mt_match[ 1 ] . ':units';

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( 'checking for ' . $mt_units . ' unit text' );
						}

						if ( isset( $og_type_mt_md[ $mt_units ] ) ) {

							if ( $unit_text = WpssoSchema::get_data_unit_text( $unit_match[ 1 ] ) ) {

								if ( $this->p->debug->enabled ) {

									$this->p->debug->log( $mt_units . ' from unit text = ' . $unit_text );
								}

								$mt_og[ $mt_units ] = $unit_text;
							}
						}

					/**
					 * Do not define units by themselves - define units when we define the value.
					 */
					} elseif ( preg_match( '/_units$/', $md_key ) ) {

						continue;	// Get the next meta data key.

					} else {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( $mt_name . ' from metadata = ' . $md_opts[ $md_key ] );
						}

						$mt_og[ $mt_name ] = $md_opts[ $md_key ];
					}

				} elseif ( isset( $mt_og[ $mt_name ] ) ) {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( $mt_name . ' value kept = ' . $mt_og[ $mt_name ] );
					}

				} elseif ( isset( $this->p->options[ 'og_def_' . $md_key ] ) ) {

					if ( $this->p->options[ 'og_def_' . $md_key ] !== 'none' ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log( $mt_name . ' from options default = ' .
								$this->p->options[ 'og_def_' . $md_key ] );
						}

						$mt_og[ $mt_name ] = $this->p->options[ 'og_def_' . $md_key ];
					}

				} else {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( $mt_name . ' = null' );
					}

					$mt_og[ $mt_name ] = null;	// Use null so isset() returns false.
				}
			}
		}

		/**
		 * If we have a GTIN number, try to improve the assigned property name.
		 *
		 * Pass $mt_og by reference to modify the array directly.
		 *
		 * A similar method exists as WpssoSchema::check_prop_value_gtin().
		 */
		public static function check_mt_value_gtin( &$mt_og, $mt_pre = 'product' ) {	// Pass by reference is OK.

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {

				$wpsso->debug->log( 'checking ' . $mt_pre . ' gtin value' );
			}

			if ( ! empty( $mt_og[ $mt_pre . ':gtin' ] ) ) {

				/**
				 * The value may come from a custom field, so trim it, just in case.
				 */
				$mt_og[ $mt_pre . ':gtin' ] = trim( $mt_og[ $mt_pre . ':gtin' ] );

				$gtin_len = strlen( $mt_og[ $mt_pre . ':gtin' ] );

				switch ( $gtin_len ) {

					case 13:

						if ( empty( $mt_og[ $mt_pre . ':ean' ] ) ) {

							$mt_og[ $mt_pre . ':ean' ] = $mt_og[ $mt_pre . ':gtin' ];
						}

						break;

					case 12:

						if ( empty( $mt_og[ $mt_pre . ':upc' ] ) ) {

							$mt_og[ $mt_pre . ':upc' ] = $mt_og[ $mt_pre . ':gtin' ];
						}

						break;
				}
			}
		}

		public static function check_mt_value_price( &$mt_og, $mt_pre = 'product' ) {	// Pass by reference is OK.

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {

				$wpsso->debug->log( 'checking ' . $mt_pre . ' price value' );
			}

			foreach ( array( 'original_price', 'pretax_price', 'price', 'sale_price', 'shipping_cost' ) as $price_name ) {

				if ( isset( $mt_og[ $mt_pre . ':' . $price_name . ':amount' ] ) ) {

					$amount_key   = $mt_pre . ':' . $price_name . ':amount';
					$currency_key = $mt_pre . ':' . $price_name . ':currency';

					if ( is_numeric( $mt_og[ $amount_key ] ) ) {	// Allow for price of 0.

						if ( empty( $mt_og[ $currency_key ] ) ) {

							$mt_og[ $currency_key ] = $wpsso->options[ 'og_def_currency' ];
						}

					} else {

						if ( ! empty( $mt_og[ $amount_key ] ) ) {	// Non-empty string, array, etc.

							if ( $wpsso->debug->enabled ) {

								$wpsso->debug->log( 'invalid ' . $amount_key . ' value = ' . print_r( $mt_og[ $amount_key ], true ) );
							}
						}

						unset( $mt_og[ $amount_key ] );
						unset( $mt_og[ $currency_key ] );
					}
				}
			}
		}

		/**
		 * If the Open Graph type isn't already hard-coded (ie. 'disabled' === 'og_type:is' ), then using the post type and
		 * the Schema type, check for a possible hard-coded Open Graph type.
		 */
		private function maybe_update_post_og_type( $md_opts, $post_id, $mod ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( empty( $md_opts[ 'og_type:is' ] ) ) {

				/**
				 * Check if the post type matches a pre-defined Open Graph type.
				 *
				 * For example, a post type of 'organization' would return 'website' for the Open Graph type.
				 *
				 * Returns false or an Open Graph type string.
				 */
				if ( $og_type = $this->p->post->get_post_type_og_type( $mod ) ) {

					$md_opts[ 'og_type' ]    = $og_type;
					$md_opts[ 'og_type:is' ] = 'disabled';

				} else {

					/**
					 * Use the saved Schema type or get the default Schema type.
					 */
					if ( isset( $md_opts[ 'schema_type' ] ) ) {

						$type_id = $md_opts[ 'schema_type' ];

					} else {

						$type_id = $this->p->schema->get_mod_schema_type_id( $mod, $use_mod_opts = false );
					}

					/**
					 * Check if the Schema type matches a pre-defined Open Graph type.
					 */
					if ( $og_type = $this->p->schema->get_schema_type_og_type( $type_id ) ) {

						$md_opts[ 'og_type' ]    = $og_type;
						$md_opts[ 'og_type:is' ] = 'disabled';
					}
				}
			}

			return $md_opts;
		}
	}
}
