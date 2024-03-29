<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2014-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoJsonFiltersUpgrade' ) ) {

	class WpssoJsonFiltersUpgrade {

		private $p;	// Wpsso class object.
		private $a;	// WpssoJson class object.

		/**
		 * Instantiated by WpssoJsonFilters->__construct().
		 */
		public function __construct( &$plugin, &$addon ) {

			$this->p =& $plugin;
			$this->a =& $addon;

			$this->p->util->add_plugin_filters( $this, array(
				'rename_options_keys'    => 1,
				'rename_md_options_keys' => 1,
			) );
		}

		public function filter_rename_options_keys( $options_keys ) {

			$options_keys[ 'wpssojson' ] = array(
				16 => array(
					'schema_def_course_provider_id' => 'schema_def_prov_org_id',
				),
			);

			return $options_keys;
		}

		public function filter_rename_md_options_keys( $options_keys ) {

			$options_keys[ 'wpssojson' ] = array(
				11 => array(
					'schema_event_org_id'  => 'schema_event_organizer_org_id',
					'schema_event_perf_id' => 'schema_event_performer_org_id',
					'schema_org_org_id'    => 'schema_organization_id',
				),
				14 => array(
					'schema_event_place_id' => 'schema_event_location_id',
					'schema_job_org_id'     => 'schema_job_hiring_org_id',
				),
				16 => array(
					'schema_course_provider_id' => 'schema_prov_org_id',
				),
				20 => array(
					'schema_question_desc' => 'schema_qa_desc',
				),
				26 => array(
					'schema_part_of_url' => 'schema_ispartof_url_0',
				),
				32 => array(
					'schema_review_claim_author_type'   => 'schema_review_item_cw_author_type',
					'schema_review_claim_author_name'   => 'schema_review_item_cw_author_name',
					'schema_review_claim_author_url'    => 'schema_review_item_cw_author_url',
					'schema_review_claim_made_date'     => 'schema_review_item_cw_pub_date',
					'schema_review_claim_made_time'     => 'schema_review_item_cw_pub_time',
					'schema_review_claim_made_timezone' => 'schema_review_item_cw_pub_timezone',
				),
				34 => array(
					'schema_review_item_book_isbn' => 'schema_review_item_cw_book_isbn',
				),
				35 => array(
					'schema_review_item_product_img_id'     => 'schema_review_item_img_id',
					'schema_review_item_product_img_id_pre' => 'schema_review_item_img_id_lib',
					'schema_review_item_product_img_url'    => 'schema_review_item_img_url',
				),
				37 => array(
					'schema_review_item_product_mpn' => 'schema_review_item_product_mfr_part_no',
					'schema_review_item_product_sku' => 'schema_review_item_product_retailer_part_no',
				),
				51 => array(
					'schema_howto_step_img_id_pre'         => 'schema_howto_step_img_id_lib',
					'schema_recipe_instruction_img_id_pre' => 'schema_recipe_instruction_img_id_lib',
					'schema_review_item_img_id_pre'        => 'schema_review_item_img_id_lib',
				),
				52 => array(
					'schema_organization_org_id' => 'schema_organization_id',
				),
			);

			return $options_keys;
		}
	}
}
