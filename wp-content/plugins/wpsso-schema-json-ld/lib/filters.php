<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2014-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoJsonFilters' ) ) {

	class WpssoJsonFilters {

		private $p;		// Wpsso class object.
		private $a;		// WpssoJson class object.
		private $upg;		// WpssoJsonFiltersUpgrade class object.

		/**
		 * Instantiated by WpssoJson->init_objects().
		 */
		public function __construct( &$plugin, &$addon ) {

			static $do_once = null;

			if ( true === $do_once ) {

				return;	// Stop here.
			}

			$do_once = true;

			$this->p =& $plugin;
			$this->a =& $addon;

			require_once WPSSOJSON_PLUGINDIR . 'lib/filters-upgrade.php';

			$this->upg = new WpssoJsonFiltersUpgrade( $plugin, $addon );
		}
	}
}
