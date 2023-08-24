<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRarFiltersOptions' ) ) {

	class WpssoRarFiltersOptions {

		private $p;	// Wpsso class object.
		private $a;	// WpssoRar class object.

		/**
		 * Instantiated by WpssoRarFilters->__construct().
		 */
		public function __construct( &$plugin, &$addon ) {

			$this->p =& $plugin;
			$this->a =& $addon;

			$this->p->util->add_plugin_filters( $this, array( 
				'get_defaults' => 1,
			), $prio = 1000 );	// Run before rating or review API service.
		}

		public function filter_get_defaults( $defs ) {

			/**
			 * Add options using a key prefix array and post type names.
			 */
			$this->p->util->add_post_type_names( $defs, array(
				'rar_add_to' => 0,
			) );

			return $defs;
		}
	}
}
