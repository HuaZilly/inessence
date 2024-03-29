<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2016-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoJsonFiltersTypeProduct' ) ) {

	class WpssoJsonFiltersTypeProduct {

		private $p;	// Wpsso class object.

		/**
		 * Instantiated by Wpsso->init_json_filters().
		 */
		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$this->p->util->add_plugin_filters( $this, array(
				'json_data_https_schema_org_product' => 5,
			) );

			/**
			 * Disable microdata markup from the Easy Digital Download plugin.
			 */
			if ( $this->p->avail[ 'ecom' ][ 'edd' ] ) {

				add_filter( 'edd_add_schema_microdata', '__return_false', PHP_INT_MAX );
			}

			/**
			 * Disable JSON-LD markup from the WooCommerce WC_Structured_Data class (since v3.0.0).
			 */
			if ( $this->p->avail[ 'ecom' ][ 'woocommerce' ] ) {

				add_filter( 'woocommerce_structured_data_product', '__return_empty_array', PHP_INT_MAX );
				add_filter( 'woocommerce_structured_data_review', '__return_empty_array', PHP_INT_MAX );
			}
		}

		public function filter_json_data_https_schema_org_product( $json_data, $mod, $mt_og, $page_type_id, $is_main ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			$json_ret = array();

			/**
			 * Note that there is no Schema 'availability' property for the 'product:availability' value.
			 *
			 * Note that there is no Schema 'ean' property for the 'product:ean' value.
			 *
			 * Note that there is no Schema 'size' property for the 'product:size' value.
			 */
			WpssoSchema::add_data_itemprop_from_assoc( $json_ret, $mt_og, array(
				'url'           => 'product:url',
				'name'          => 'product:title',
				'description'   => 'product:description',
				'category'      => 'product:category',		// See https://developers.facebook.com/docs/marketing-api/catalog/reference/.
				'sku'           => 'product:retailer_part_no',	// Product SKU.
				'mpn'           => 'product:mfr_part_no',	// Product MPN.
				'gtin14'        => 'product:gtin14',		// Valid for both products and offers.
				'gtin13'        => 'product:gtin13',		// Valid for both products and offers.
				'gtin12'        => 'product:gtin12',		// Valid for both products and offers.
				'gtin8'         => 'product:gtin8',		// Valid for both products and offers.
				'gtin'          => 'product:gtin',		// Valid for both products and offers.
				'itemCondition' => 'product:condition',
				'color'         => 'product:color',
				'material'      => 'product:material',
			) );

			/**
			 * Convert a numeric category ID to its Google product type string.
			 */
			WpssoSchema::check_prop_value_category( $json_ret );

			WpssoSchema::check_prop_value_gtin( $json_ret );

			/**
			 * See the https://schema.org/productID example.
			 */
			foreach ( array( 'isbn', 'retailer_item_id' ) as $pref_id ) {

				if ( WpssoSchema::is_valid_key( $mt_og, 'product:' . $pref_id ) ) {	// Not null, an empty string, or 'none'.

					$json_ret[ 'productID' ] = $pref_id . ':' . $mt_og[ 'product:' . $pref_id ];

					break;	// Stop here.
				}
			}

			/**
			 * Brand.
			 */
			if ( WpssoSchema::is_valid_key( $mt_og, 'product:brand' ) ) {	// Not null, an empty string, or 'none'.

				$single_brand = WpssoSchema::get_data_itemprop_from_assoc( $mt_og, array( 
					'name' => 'product:brand',
				) );

				if ( false !== $single_brand ) {	// Just in case.

					$json_ret[ 'brand' ] = WpssoSchema::get_schema_type_context( 'https://schema.org/Brand', $single_brand );
				}
			}

			/**
			 * Audience.
			 */
			if ( WpssoSchema::is_valid_key( $mt_og, 'product:target_gender' ) ) {	// Not null, an empty string, or 'none'.

				$single_audience = WpssoSchema::get_data_itemprop_from_assoc( $mt_og, array( 
					'suggestedGender' => 'product:target_gender',
				) );

				if ( false !== $single_audience ) {	// Just in case.

					$json_ret[ 'audience' ] = WpssoSchema::get_schema_type_context( 'https://schema.org/PeopleAudience', $single_audience );
				}
			}

			/**
			 * QuantitativeValue (width, height, length, depth, weight).
			 *
			 * unitCodes from http://wiki.goodrelations-vocabulary.org/Documentation/UN/CEFACT_Common_Codes.
			 *
			 * Example $names array:
			 *
			 * array(
			 * 	'depth'        => 'product:depth:value',
			 * 	'height'       => 'product:height:value',
			 * 	'length'       => 'product:length:value',
			 * 	'size'         => 'product:size',
			 * 	'fluid_volume' => 'product:fluid_volume:value',
			 * 	'weight'       => 'product:weight:value',
			 * 	'width'        => 'product:width:value',
			 * );
			 */
			WpssoSchema::add_data_unit_from_assoc( $json_ret, $mt_og, $names = array( 
				'depth'        => 'product:depth:value',
				'height'       => 'product:height:value',
				'length'       => 'product:length:value',
				'size'         => 'product:size',
				'fluid_volume' => 'product:fluid_volume:value',
				'weight'       => 'product:weight:value',
				'width'        => 'product:width:value',
			) );

			/**
			 * Prevent recursion for an itemOffered within a Schema Offer.
			 */
			static $local_recursion = false;

			if ( ! $local_recursion ) {

				$local_recursion = true;

				/**
				 * Property:
				 * 	offers as https://schema.org/Offer
				 */
				if ( empty( $mt_og[ 'product:offers' ] ) ) {	// No product variations.

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'getting single offer data' );
					}

					if ( $single_offer = WpssoSchemaSingle::get_offer_data( $mod, $mt_og ) ) {

						if ( $this->p->debug->enabled ) {

							$this->p->debug->log_arr( '$single_offer', $single_offer );
						}

						$json_ret[ 'offers' ] = WpssoSchema::get_schema_type_context( 'https://schema.org/Offer', $single_offer );

					} elseif ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'returned single offer is empty' );
					}

				/**
				 * Property:
				 * 	offers as https://schema.org/AggregateOffer
				 */
				} elseif ( is_array( $mt_og[ 'product:offers' ] ) ) {	// Just in case - must be an array.

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'getting aggregate offer data' );
					}

					if ( empty( $this->p->options[ 'schema_aggr_offers' ] ) ) {

						WpssoSchema::add_offers_data( $json_ret, $mod, $mt_og[ 'product:offers' ] );

					} else {

						WpssoSchema::add_offers_aggregate_data( $json_ret, $mod, $mt_og[ 'product:offers' ] );
					}

				} else {

					if ( $this->p->debug->enabled ) {

						$this->p->debug->log( 'product offers is not an array' );
					}
				}

				$local_recursion = false;

			} else {

				if ( $this->p->debug->enabled ) {

					$this->p->debug->log( 'product offer recursion detected and avoided' );
				}
			}

			/**
			 * Property:
			 *	image as https://schema.org/ImageObject
			 *	subjectOf as https://schema.org/VideoObject
			 */
			WpssoSchema::add_media_data( $json_ret, $mod, $mt_og, $size_names = 'schema', $add_video = 'subjectOf' );

			return WpssoSchema::return_data_from_filter( $json_data, $json_ret, $is_main );
		}
	}
}
