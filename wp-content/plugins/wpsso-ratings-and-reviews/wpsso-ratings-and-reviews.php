<?php
/**
 * Plugin Name: WPSSO Ratings and Reviews
 * Plugin Slug: wpsso-ratings-and-reviews
 * Text Domain: wpsso-ratings-and-reviews
 * Domain Path: /languages
 * Plugin URI: https://wpsso.com/extend/plugins/wpsso-ratings-and-reviews/
 * Assets URI: https://jsmoriss.github.io/wpsso-ratings-and-reviews/assets/
 * Author: JS Morisset
 * Author URI: https://wpsso.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Ratings and Reviews for WordPress Comments with Schema Aggregate Rating and Schema Review Markup.
 * Requires PHP: 7.0
 * Requires At Least: 5.0
 * Tested Up To: 5.8.1
 * WC Tested Up To: 5.8.0
 * Version: 2.15.2
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2017-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoAddOn' ) ) {

	require_once dirname( __FILE__ ) . '/lib/abstracts/add-on.php';	// WpssoAddOn class.
}

if ( ! class_exists( 'WpssoRar' ) ) {

	class WpssoRar extends WpssoAddOn {

		public $admin;		// WpssoRarAdmin class object.
		public $comment;	// WpssoRarComment class object.
		public $filters;	// WpssoRarFilters class object.
		public $script;		// WpssoRarScript class object.
		public $style;		// WpssoRarStyle class object.

		protected $p;	// Wpsso class object.

		private static $instance  = null;	// WpssoRar class object.

		public function __construct() {

			parent::__construct( __FILE__, __CLASS__ );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init_textdomain() {

			load_plugin_textdomain( 'wpsso-ratings-and-reviews', false, 'wpsso-ratings-and-reviews/languages/' );
		}

		/**
		 * $is_admin, $doing_ajax, and $doing_cron available since WPSSO Core v8.8.0.
		 */
		public function init_objects( $is_admin = false, $doing_ajax = false, $doing_cron = false ) {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( $this->get_missing_requirements() ) {	// Returns false or an array of missing requirements.

				return;	// Stop here.
			}

			/**
			 * Make sure there are no conflicting settings.
			 */
			if ( ! empty( $this->p->options[ 'plugin_ratings_reviews_svc' ] ) ) {	// Since WPSSO Core v8.33.0.

				if ( 'none' !== $this->p->options[ 'plugin_ratings_reviews_svc' ] ) {

					$this->init_textdomain();	// If not already loaded, load the textdomain now.

					$info = $this->cf[ 'plugin' ][ $this->ext ];

					$addon_name  = $info[ 'name' ];

					// translators: Please ignore - translation uses a different text domain.
					$option_label = _x( 'Ratings and Reviews Service', 'option label', 'wpsso' );

					$option_link = $this->p->util->get_admin_url( 'advanced#sucom-tabset_services-tab_ratings_reviews', $option_label );

					$notice_msg = sprintf( __( 'The %1$s add-on is not compatible with the %2$s option.', 'wpsso-ratings-and-reviews' ),
						$addon_name, $option_link ) . ' ';

					$notice_msg .= sprintf( __( 'You must either deactivate the %1$s add-on or disable the %2$s option.', 'wpsso-ratings-and-reviews' ),
						$addon_name, $option_link );

					$this->p->notice->err( $notice_msg );

					return;	// Stop here.
				}
			}

			/**
			 * Disable reviews on products if competing feature exists.
			 */
			if ( $this->p->avail[ 'ecom' ][ 'woocommerce' ] ) {

				if ( 'yes' === get_option( 'woocommerce_enable_review_rating' ) ) {

					if ( ! empty( $this->p->options[ 'rar_add_to_product' ] ) ) {

						$this->p->options[ 'rar_add_to_product' ] = 0;

						$this->p->opt->save_options( WPSSO_OPTIONS_NAME, $this->p->options, $network = false );
					}

					/**
					 * Disable this post type option in the add-on settings.
					 */
					$this->p->options[ 'rar_add_to_product:is' ] = 'disabled';
				}
			}

			$this->comment = new WpssoRarComment( $this->p, $this );
			$this->filters = new WpssoRarFilters( $this->p, $this );
			$this->script  = new WpssoRarScript( $this->p, $this );
			$this->style   = new WpssoRarStyle( $this->p, $this );

			if ( is_admin() ) {

				$this->admin = new WpssoRarAdmin( $this->p, $this );
			}
		}
	}

	WpssoRar::get_instance();
}
