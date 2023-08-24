<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2014-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoJsonConfig' ) ) {

	class WpssoJsonConfig {

		public static $cf = array(
			'plugin' => array(
				'wpssojson' => array(			// Plugin acronym.
					'version'     => '5.2.0',	// Plugin version.
					'opt_version' => '53',		// Increment when changing default option values.
					'short'       => 'WPSSO JSON',	// Short plugin name.
					'name'        => 'WPSSO Schema JSON-LD Markup',
					'desc'        => 'Discontinued / deprecated add-on: The features of this plugin were merged into WPSSO Core v9.0.0.',
					'slug'        => 'wpsso-schema-json-ld',
					'base'        => 'wpsso-schema-json-ld/wpsso-schema-json-ld.php',
					'update_auth' => 'tid',
					'text_domain' => 'wpsso-schema-json-ld',
					'domain_path' => '/languages',

					/**
					 * Required plugin and its version.
					 */
					'req' => array(
						'wpsso' => array(
							'name'          => 'WPSSO Core',
							'home'          => 'https://wordpress.org/plugins/wpsso/',
							'plugin_class'  => 'Wpsso',
							'version_const' => 'WPSSO_VERSION',
							'min_version'   => '9.2.1',
						),
					),

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-schema-json-ld/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-schema-json-ld/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'images/icon-128x128.png',
							'2x' => 'images/icon-256x256.png',
						),
					),
					'hosts' => array(
						'wp_org' => true,
						'github' => true,
						'wpsso'  => true,
					),
					'url' => array(

						/**
						 * WordPress.org.
						 */
						'home'   => 'https://wordpress.org/plugins/wpsso-schema-json-ld/',
						'forum'  => '',
						'review' => '',

						/**
						 * GitHub.com.
						 */
						'readme_txt'     => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-schema-json-ld/master/readme.txt',
						'setup_html'     => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-schema-json-ld/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-schema-json-ld/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-schema-json-ld/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => 'https://surniaulula.com/support/create_ticket/',		// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => 'https://wpsso.com/extend/plugins/wpsso-schema-json-ld/info/',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-schema-json-ld/update/',
						'latest'    => '',	// Optional.
					),

					/**
					 * Library files loaded and instantiated by WPSSO.
					 */
					'lib' => array(
						'pro' => array(
							'admin' => array(
								'edit' => 'SSO Metabox Edit Filters',
							),
						),
					),
				),
			),
		);

		public static function get_version( $add_slug = false ) {

			$info =& self::$cf[ 'plugin' ][ 'wpssojson' ];

			return $add_slug ? $info[ 'slug' ] . '-' . $info[ 'version' ] : $info[ 'version' ];
		}

		public static function set_constants( $plugin_file ) {

			if ( defined( 'WPSSOJSON_VERSION' ) ) {	// Define constants only once.

				return;
			}

			$info =& self::$cf[ 'plugin' ][ 'wpssojson' ];

			/**
			 * Define fixed constants.
			 */
			define( 'WPSSOJSON_FILEPATH', $plugin_file );
			define( 'WPSSOJSON_PLUGINBASE', $info[ 'base' ] );	// Example: wpsso-schema-json-ld/wpsso-schema-json-ld.php.
			define( 'WPSSOJSON_PLUGINDIR', trailingslashit( realpath( dirname( $plugin_file ) ) ) );
			define( 'WPSSOJSON_PLUGINSLUG', $info[ 'slug' ] );	// Example: wpsso-schema-json-ld.
			define( 'WPSSOJSON_URLPATH', trailingslashit( plugins_url( '', $plugin_file ) ) );
			define( 'WPSSOJSON_VERSION', $info[ 'version' ] );
		}

		public static function require_libs( $plugin_file ) {

			require_once WPSSOJSON_PLUGINDIR . 'lib/filters.php';
			require_once WPSSOJSON_PLUGINDIR . 'lib/register.php';

			add_filter( 'wpssojson_load_lib', array( 'WpssoJsonConfig', 'load_lib' ), 10, 3 );
		}

		public static function load_lib( $success = false, $filespec = '', $classname = '' ) {

			if ( false === $success && ! empty( $filespec ) ) {

				$file_path = WPSSOJSON_PLUGINDIR . 'lib/' . $filespec . '.php';

				if ( file_exists( $file_path ) ) {

					require_once $file_path;

					if ( empty( $classname ) ) {

						$classname = SucomUtil::sanitize_classname( 'wpssojson' . $filespec, $allow_underscore = false );
					}

					return $classname;
				}
			}

			return $success;
		}
	}
}
