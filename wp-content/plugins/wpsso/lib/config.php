<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2012-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoConfig' ) ) {

	class WpssoConfig {

		public static $cf = array(
			'dist' => array(
				'pro' => 'Premium',
				'std' => 'Standard',
			),
			'plugin' => array(
				'wpsso' => array(			// Plugin acronym.
					'version'     => '9.3.0',	// Plugin version.
					'opt_version' => '829',		// Increment when changing default option values.
					'short'       => 'WPSSO Core',	// Short plugin name.
					'name'        => 'WPSSO Core',
					'desc'        => 'Present your content at its best in search results and on social sites - no matter how URLs are shared, reshared, messaged, posted, embedded, or crawled.',
					'slug'        => 'wpsso',
					'base'        => 'wpsso/wpsso.php',
					'update_auth' => 'tid',
					'text_domain' => 'wpsso',
					'domain_path' => '/languages',

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso/assets/banner-1544x500.jpg',
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
						'home'   => 'https://wordpress.org/plugins/wpsso/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso',
						'review' => 'https://wordpress.org/support/plugin/wpsso/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso/master/readme.txt',
						'setup_html' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso/master/html/setup.html',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso/installation/',
						'faqs'      => 'https://wpsso.com/docs/plugins/wpsso/faqs/',
						'notes'     => 'https://wpsso.com/docs/plugins/wpsso/notes/',
						'support'   => 'https://surniaulula.com/support/create_ticket/',	// Premium support ticket.
						'purchase'  => 'https://wpsso.com/extend/plugins/wpsso/',		// Purchase page.
						'info'      => 'https://wpsso.com/extend/plugins/wpsso/info/',		// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso/update/',
						'latest'    => '',	// Optional.
					),
					'lib' => array(
						'json-filters' => array(
							'type' => array(
								'article'             => '(code) Schema Type Article [schema_type:article]',
								'audiobook'           => '(code) Schema Type Audiobook [schema_type:book.audio]',
								'blog'                => '(code) Schema Type Blog [schema_type:blog]',
								'book'                => '(code) Schema Type Book [schema_type:book]',
								'brand'               => '(code) Schema Type Brand [schema_type:brand]',
								'claimreview'         => '(code) Schema Type Claim Review [schema_type:review.claim]',
								'collectionpage'      => '(code) Schema Type Collection Page [schema_type:webpage.collection]',
								'course'              => '(code) Schema Type Course [schema_type:course]',
								'creativework'        => '(code) Schema Type CreativeWork [schema_type:creative.work]',
								'event'               => '(code) Schema Type Event [schema_type:event]',
								'faqpage'             => '(code) Schema Type FAQPage [schema_type:webpage.faq]',
								'foodestablishment'   => '(code) Schema Type Food Establishment [schema_type:food.establishment]',
								'howto'               => '(code) Schema Type How-To [schema_type:how.to]',
								'itemlist'            => '(code) Schema Type ItemList [schema_type:item.list]',
								'jobposting'          => '(code) Schema Type Job Posting [schema_type:job.posting]',
								'localbusiness'       => '(code) Schema Type Local Business [schema_type:local.business]',
								'movie'               => '(code) Schema Type Movie [schema_type:movie]',
								'organization'        => '(code) Schema Type Organization [schema_type:organization]',
								'person'              => '(code) Schema Type Person [schema_type:person]',
								'place'               => '(code) Schema Type Place [schema_type:place]',
								'product'             => '(code) Schema Type Product [schema_type:product]',
								'profilepage'         => '(code) Schema Type Profile Page [schema_type:webpage.profile]',
								'qapage'              => '(code) Schema Type QAPage [schema_type:webpage.qa]',
								'question'            => '(code) Schema Type Question and Answer [schema_type:question]',
								'recipe'              => '(code) Schema Type Recipe [schema_type:recipe]',
								'review'              => '(code) Schema Type Review [schema_type:review]',
								'searchresultspage'   => '(code) Schema Type Search Results Page [schema_type:webpage.search.results]',
								'softwareapplication' => '(code) Schema Type Software Application [schema_type:software.application]',
								'thing'               => '(code) Schema Type Thing [schema_type:thing]',
								'webpage'             => '(code) Schema Type WebPage [schema_type:webpage]',
								'website'             => '(code) Schema Type WebSite [schema_type:website]',
							),
							'prop' => array(
								'aggregaterating' => '(plus) Schema Property aggregateRating',
								'haspart'         => '(plus) Schema Property hasPart',
								'review'          => '(plus) Schema Property review',
							),
						),
						'pro' => array(
							'admin' => array(
								'advanced' => 'Advanced Settings Filters',
								'edit'     => 'SSO Metabox Edit Filters',
								'general'  => 'General Settings Filters',
							),
							'ecom' => array(
								'edd'                           => '(plugin) Easy Digital Downloads',
								'jck-wssv'                      => '(plugin) WooCommerce Show Single Variations',
								'perfect-woocommerce-brands'    => '(plugin) Perfect WooCommerce Brands',
								'woocommerce'                   => '(plugin) WooCommerce',
								'woocommerce-brands'            => '(plugin) WooCommerce Brands',
								'woocommerce-currency-switcher' => '(plugin) WooCommerce Currency Switcher',
								'woo-add-gtin'                  => '(plugin) WooCommerce UPC, EAN, and ISBN',
								'wpm-product-gtin-wc'           => '(plugin) Product GTIN for WooCommerce',
								'yith-woocommerce-brands'       => '(plugin) YITH WooCommerce Brands Add-on',
							),
							'event' => array(
								'the-events-calendar' => '(plugin) The Events Calendar',
							),
							'form' => array(
								'gravityview' => '(plugin) GravityView',
							),
							'forum' => array(
								'bbpress' => '(plugin) bbPress',
							),
							'job' => array(
								'simplejobboard' => '(plugin) Simple Job Board',
								'wpjobmanager'   => '(plugin) WP Job Manager',
							),
							'lang' => array(
								'polylang' => '(plugin) Polylang',
								'wpml'     => '(plugin) WPML',
							),
							'media' => array(
								'facebook'   => '(api) Facebook Video API',
								'gravatar'   => '(api) Gravatar Image API',
								'ngg'        => '(plugin) NextGEN Gallery, NextCellent Gallery',
								'slideshare' => '(api) Slideshare API',
								'soundcloud' => '(api) Soundcloud API',
								'upscale'    => '(feature) Upscale Media Library Images',
								'vimeo'      => '(api) Vimeo Video API',
								'wistia'     => '(api) Wistia Video API',
								'wpvideo'    => '(api) WP Video Shortcode API',
								'youtube'    => '(api) YouTube Video / Playlist API',
							),
							'rating' => array(
								'rate-my-post'  => '(plugin) Rate my Post',
								'wppostratings' => '(plugin) WP-PostRatings',
							),
							'recipe' => array(
								'wprecipemaker' => '(plugin) WP Recipe Maker',
							),
							'review' => array(
								'shopperapproved' => '(api) Shopper Approved API',
								'stamped'         => '(api) Stamped.io API',
								'wpproductreview' => '(plugin) WP Product Review',
								'yotpowc'         => '(plugin) Yotpo Social Reviews for WooCommerce',
							),
							'seo' => array(
								'aioseop'      => '(plugin) All in One SEO Pack',
								'rank-math'    => '(plugin) Rank Math SEO',
								'seoframework' => '(plugin) The SEO Framework',
								'seopress'     => '(plugin) SEOPress',
								'wpmetaseo'    => '(plugin) WP Meta SEO',
								'wpseo'        => '(plugin) Yoast SEO',
							),
							'social' => array(
								'buddypress' => '(plugin) BuddyPress',
							),
							'util' => array(
								'check-img-dims' => '(feature) Enforce Image Dimension Checks',
								'coauthors'      => '(plugin) Co-Authors Plus',
								'shorten'        => '(feature) URL Shortening Service',
								'wpseo-meta'     => '(feature) Import Yoast SEO Social Meta',
							),
						),
						'profile' => array(
							'your-sso' => 'Profile SSO (Social and Search Optimization)',
						),
						'sitesubmenu' => array(
							'site-advanced' => 'Advanced Settings',
							'site-licenses' => 'Premium Licenses',
							'site-addons'   => 'Complementary Add-ons',
						),
						'std' => array(
							'admin' => array(
								'advanced' => 'Advanced Settings Filters',
								'edit'     => 'SSO Metabox Edit Filters',
								'general'  => 'General Settings Filters',
							),
							'social' => array(
								'buddypress' => '(plugin) BuddyPress',
							),
						),
						'submenu' => array(
							'essential'      => 'Essential Settings',
							'social-pages'   => 'Social Pages',
							'setup'          => 'Setup Guide',
							'dashboard'      => 'Dashboard',
							'general'        => 'General Settings',
							'advanced'       => 'Advanced Settings',
							'addons'         => 'Complementary Add-ons',
							'licenses'       => 'Premium Licenses',
							'tools'          => 'Tools and Actions',
						),
						'users' => array(
							'add-person' => 'Add Person',
						),
					),
				),
				'wpssoam' => array(			// Plugin acronym.
					'short'       => 'WPSSO AM',	// Short plugin name.
					'name'        => 'WPSSO Mobile App Meta Tags',
					'desc'        => 'Apple Store / iTunes and Google Play App meta tags for Apple\'s mobile Safari banner and Twitter\'s App Card.',
					'slug'        => 'wpsso-am',
					'base'        => 'wpsso-am/wpsso-am.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-am/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-am/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-am/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-am/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-am/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-am',
						'review' => 'https://wordpress.org/support/plugin/wpsso-am/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-am/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-am/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-am/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-am/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-am/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssobc' => array(			// Plugin acronym.
					'short'       => 'WPSSO BC',	// Short plugin name.
					'name'        => 'WPSSO Schema Breadcrumbs Markup',
					'desc'        => 'Schema BreadcrumbList markup in JSON-LD format for Google Rich Results.',
					'slug'        => 'wpsso-breadcrumbs',
					'base'        => 'wpsso-breadcrumbs/wpsso-breadcrumbs.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-breadcrumbs/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-breadcrumbs/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-breadcrumbs/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-breadcrumbs/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-breadcrumbs/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-breadcrumbs',
						'review' => 'https://wordpress.org/support/plugin/wpsso-breadcrumbs/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-breadcrumbs/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-breadcrumbs/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-breadcrumbs/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-breadcrumbs/installation/',
						'faqs'      => 'https://wpsso.com/docs/plugins/wpsso-breadcrumbs/faqs/',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-breadcrumbs/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssofaq' => array(			// Plugin acronym.
					'short'       => 'WPSSO FAQ',	// Short plugin name.
					'name'        => 'WPSSO FAQ Manager',
					'desc'        => 'Create FAQ and Question / Answer Pages with optional shortcodes to include FAQs and Questions / Answers in your content.',
					'slug'        => 'wpsso-faq',
					'base'        => 'wpsso-faq/wpsso-faq.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-faq/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-faq/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-faq/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-faq/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-faq/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-faq',
						'review' => 'https://wordpress.org/support/plugin/wpsso-faq/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-faq/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-faq/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-faq/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-faq/installation/',
						'faqs'      => 'https://wpsso.com/docs/plugins/wpsso-faq/faqs/',
						'notes'     => 'https://wpsso.com/docs/plugins/wpsso-faq/notes/',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-faq/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssoipm' => array(			// Plugin acronym.
					'short'       => 'WPSSO IPM',	// Short plugin name.
					'name'        => 'WPSSO Inherit Parent Metadata',
					'desc'        => 'Inherit featured and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.',
					'slug'        => 'wpsso-inherit-parent-meta',
					'base'        => 'wpsso-inherit-parent-meta/wpsso-inherit-parent-meta.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-inherit-parent-meta/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-inherit-parent-meta',
						'review' => 'https://wordpress.org/support/plugin/wpsso-inherit-parent-meta/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-inherit-parent-meta/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-inherit-parent-meta/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-inherit-parent-meta/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-inherit-parent-meta/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-inherit-parent-meta/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssoorg' => array(			// Plugin acronym.
					'short'       => 'WPSSO ORG',	// Short plugin name.
					'name'        => 'WPSSO Organization Markup',
					'desc'        => 'Customize the Schema Organization markup for your website and create additional Schema Organizations (publisher, organizer, etc.).',
					'slug'        => 'wpsso-organization',
					'base'        => 'wpsso-organization/wpsso-organization.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-organization/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-organization/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-organization/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-organization/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-organization/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-organization',
						'review' => 'https://wordpress.org/support/plugin/wpsso-organization/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-organization/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-organization/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-organization/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-organization/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-organization/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssoplm' => array(			// Plugin acronym.
					'short'       => 'WPSSO PLM',		// Short plugin name.
					'name'        => 'WPSSO Place and Local SEO Markup',
					'desc'        => 'Manage Schema Places and Local SEO for Facebook / Open Graph, Pinterest, and Google Local Business.',
					'slug'        => 'wpsso-plm',
					'base'        => 'wpsso-plm/wpsso-plm.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-plm/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-plm/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-plm/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-plm/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-plm/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-plm',
						'review' => 'https://wordpress.org/support/plugin/wpsso-plm/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-plm/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-plm/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-plm/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-plm/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-plm/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssorar' => array(			// Plugin acronym.
					'short'       => 'WPSSO RAR',	// Short plugin name.
					'name'        => 'WPSSO Ratings and Reviews',
					'desc'        => 'Ratings and Reviews for WordPress Comments with Schema Aggregate Rating and Schema Review Markup.',
					'slug'        => 'wpsso-ratings-and-reviews',
					'base'        => 'wpsso-ratings-and-reviews/wpsso-ratings-and-reviews.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-ratings-and-reviews/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-ratings-and-reviews',
						'review' => 'https://wordpress.org/support/plugin/wpsso-ratings-and-reviews/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-ratings-and-reviews/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-ratings-and-reviews/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/',
						'faqs'      => '',
						'notes'     => 'https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-ratings-and-reviews/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssorest' => array(			// Plugin acronym.
					'short'       => 'WPSSO REST',	// Short plugin name.
					'name'        => 'WPSSO REST API',
					'desc'        => 'Extends the WordPress REST API post, term, and user query results with an array of meta tags and Schema JSON-LD markup.',
					'slug'        => 'wpsso-rest-api',
					'base'        => 'wpsso-rest-api/wpsso-rest-api.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-rest-api/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-rest-api/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-rest-api/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-rest-api/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-rest-api/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-rest-api',
						'review' => 'https://wordpress.org/support/plugin/wpsso-rest-api/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-rest-api/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-rest-api/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-rest-api/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-rest-api/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-rest-api/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssorrssb' => array(			// Plugin acronym.
					'short'       => 'WPSSO RRSSB',	// Short plugin name.
					'name'        => 'WPSSO Ridiculously Responsive Social Sharing Buttons',
					'desc'        => 'Ridiculously Responsive (SVG) Social Sharing Buttons for your content, excerpts, CSS sidebar, widget, shortcode, templates, and editor.',
					'slug'        => 'wpsso-rrssb',
					'base'        => 'wpsso-rrssb/wpsso-rrssb.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-rrssb/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-rrssb/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-rrssb/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-rrssb/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-rrssb/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-rrssb',
						'review' => 'https://wordpress.org/support/plugin/wpsso-rrssb/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-rrssb/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-rrssb/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-rrssb/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-rrssb/installation/',
						'faqs'      => '',
						'notes'     => 'https://wpsso.com/docs/plugins/wpsso-rrssb/notes/',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-rrssb/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssossm' => array(			// Plugin acronym.
					'short'       => 'WPSSO SSM',	// Short plugin name.
					'name'        => 'WPSSO Strip Schema Microdata',
					'desc'        => 'Remove Schema Microdata and RDFa from the webpage for better Google Rich Results using Schema JSON-LD markup.',
					'slug'        => 'wpsso-strip-schema-microdata',
					'base'        => 'wpsso-strip-schema-microdata/wpsso-strip-schema-microdata.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-strip-schema-microdata/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-strip-schema-microdata/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-strip-schema-microdata/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-strip-schema-microdata/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-strip-schema-microdata/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-strip-schema-microdata',
						'review' => 'https://wordpress.org/support/plugin/wpsso-strip-schema-microdata/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-strip-schema-microdata/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-strip-schema-microdata/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-strip-schema-microdata/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-strip-schema-microdata/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-strip-schema-microdata/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssotie' => array(			// Plugin acronym.
					'short'       => 'WPSSO TIE',	// Short plugin name.
					'name'        => 'WPSSO Tune WP Image Editors',
					'desc'        => 'Improves the appearance of WordPress images for better click through rates from social and search sites.',
					'slug'        => 'wpsso-tune-image-editors',
					'base'        => 'wpsso-tune-image-editors/wpsso-tune-image-editors.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-tune-image-editors/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-tune-image-editors/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-tune-image-editors/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-tune-image-editors/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-tune-image-editors/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-tune-image-editors',
						'review' => 'https://wordpress.org/support/plugin/wpsso-tune-image-editors/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-tune-image-editors/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-tune-image-editors/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-tune-image-editors/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-tune-image-editors/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-tune-image-editors/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssoul' => array(			// Plugin acronym.
					'short'       => 'WPSSO UL',	// Short plugin name.
					'name'        => 'WPSSO User Locale Selector',
					'desc'        => 'Quick and easy locale / language / region selector for the WordPress admin toolbar.',
					'slug'        => 'wpsso-user-locale',
					'base'        => 'wpsso-user-locale/wpsso-user-locale.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-user-locale/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-user-locale/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-user-locale/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-user-locale/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-user-locale/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-user-locale',
						'review' => 'https://wordpress.org/support/plugin/wpsso-user-locale/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-user-locale/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-user-locale/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-user-locale/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-user-locale/installation/',
						'faqs'      => '',
						'notes'     => 'https://wpsso.com/docs/plugins/wpsso-user-locale/notes/',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-user-locale/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssoum' => array(			// Plugin acronym.
					'short'       => 'WPSSO UM',	// Short plugin name.
					'name'        => 'WPSSO Update Manager',
					'desc'        => 'Update Manager for the WPSSO Core Premium plugin and its Premium complementary add-ons.',
					'slug'        => 'wpsso-um',
					'base'        => 'wpsso-um/wpsso-um.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-um/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-um/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-um/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-um/assets/icon-256x256.png',
						),
					),
					'hosts' => array(
						'wp_org' => false,	// Add-on is not available on wordpress.org.
						'github' => true,
						'wpsso'  => true,
					),
					'url' => array(

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-um/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'home'      => 'https://wpsso.com/extend/plugins/wpsso-um/',
						'forum'     => '',
						'review'    => '',
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-um/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-um/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-um/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-um/update/',
						'latest'    => 'https://wpsso.com/extend/plugins/wpsso-um/latest/',
					),
				),
				'wpssowcmd' => array(			// Plugin acronym.
					'short'       => 'WPSSO WCMD',	// Short plugin name.
					'name'        => 'WPSSO Product Metadata for WooCommerce SEO',
					'desc'        => 'GTIN, GTIN-8, GTIN-12 (UPC), GTIN-13 (EAN), GTIN-14, ISBN, MPN, depth, and volume for WooCommerce products and variations.',
					'slug'        => 'wpsso-wc-metadata',
					'base'        => 'wpsso-wc-metadata/wpsso-wc-metadata.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-wc-metadata/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-wc-metadata/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-wc-metadata/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-wc-metadata/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-wc-metadata/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-wc-metadata',
						'review' => 'https://wordpress.org/support/plugin/wpsso-wc-metadata/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' => 'https://raw.githubusercontent.com/SurniaUlula/wpsso-wc-metadata/master/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-wc-metadata/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-wc-metadata/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-wc-metadata/installation/',
						'faqs'      => '',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-wc-metadata/update/',
						'latest'    => '',	// Optional.
					),
				),
				'wpssowcsdt' => array(			// Plugin acronym.
					'short'       => 'WPSSO WCSDT',	// Short plugin name.
					'name'        => 'WPSSO Shipping Delivery Time for WooCommerce SEO',
					'desc'        => 'Shipping delivery time estimates for WooCommerce shipping zones, methods, and classes.',
					'slug'        => 'wpsso-wc-shipping-delivery-time',
					'base'        => 'wpsso-wc-shipping-delivery-time/wpsso-wc-shipping-delivery-time.php',
					'update_auth' => '',		// No premium version.

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(

						/**
						 * Banner image array keys are 'low' and 'high'.
						 */
						'banners' => array(
							'low'  => 'https://surniaulula.github.io/wpsso-wc-shipping-delivery-time/assets/banner-772x250.jpg',
							'high' => 'https://surniaulula.github.io/wpsso-wc-shipping-delivery-time/assets/banner-1544x500.jpg',
						),

						/**
						 * Icon image array keys are '1x' and '2x'.
						 */
						'icons' => array(
							'1x' => 'https://surniaulula.github.io/wpsso-wc-shipping-delivery-time/assets/icon-128x128.png',
							'2x' => 'https://surniaulula.github.io/wpsso-wc-shipping-delivery-time/assets/icon-256x256.png',
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
						'home'   => 'https://wordpress.org/plugins/wpsso-wc-shipping-delivery-time/',
						'forum'  => 'https://wordpress.org/support/plugin/wpsso-wc-shipping-delivery-time',
						'review' => 'https://wordpress.org/support/plugin/wpsso-wc-shipping-delivery-time/reviews/?rate=5#new-post',

						/**
						 * GitHub.com.
						 */
						'readme_txt' =>	'https://raw.githubusercontent.com/SurniaUlula/wpsso-wc-shipping-delivery-time/main/readme.txt',
						'setup_html' => '',

						/**
						 * WPSSO.com.
						 */
						'changelog' => 'https://wpsso.com/extend/plugins/wpsso-wc-shipping-delivery-time/changelog/',
						'docs'      => 'https://wpsso.com/docs/plugins/wpsso-wc-shipping-delivery-time/',
						'install'   => 'https://wpsso.com/docs/plugins/wpsso-wc-shipping-delivery-time/installation/',
						'faqs'      => 'https://wpsso.com/docs/plugins/wpsso-wc-shipping-delivery-time/faqs/',
						'notes'     => '',
						'support'   => '',	// Premium support ticket.
						'purchase'  => '',	// Purchase page.
						'info'      => '',	// License information.
						'update'    => 'https://wpsso.com/extend/plugins/wpsso-wc-shipping-delivery-time/update/',
						'latest'    => '',	// Optional.
					),
				),
			),
			'opt' => array(
				'defaults' => array(
					'options_version'  => '',	// Example: -wpsso512pro-wpssoum3gpl
					'options_filtered' => 0,

					/**
					 * Site options.
					 */
					'site_name'            => '',			// WebSite Name (localized).
					'site_name_alt'        => '',			// WebSite Alternate Name (localized).
					'site_desc'            => '',			// WebSite Description (localized).
					'home_url'             => '',			// WebSite URL (localized).
					'site_org_logo_url'    => '',			// Organization Logo URL (localized)
					'site_org_banner_url'  => '',			// Organization Banner URL (localized).
					'site_org_schema_type' => 'organization',	// Organization Schema Type.
					'site_org_place_id'    => 'none',		// Organization Location.
					'site_pub_person_id'   => 'none',		// WebSite Publisher Person.
					'site_pub_schema_type' => 'organization',	// WebSite Publisher Type.

					/**
					 * Facebook options.
					 */
					'fb_publisher_url' => '',			// Facebook Business Page URL (localized).
					'fb_author_field'  => 'facebook',		// Author Profile URL Field.
					'fb_app_id'        => '966242223397117',	// Facebook Application ID.
					'fb_locale'        => 'en_US',			// Facebook Locale.

					/**
					 * Open Graph options.
					 */
					'og_def_article_section'  => 'none',	// Default Article Section.
					'og_def_img_id'           => '',	// Default Image ID.
					'og_def_img_id_lib'       => 'wp',
					'og_def_img_url'          => '',	// or Default Image URL.
					'og_def_product_category' => 'none',	// Default Product Type.
					'og_def_country'          => 'none',	// Default Country.
					'og_def_timezone'         => 'UTC',	// Default Timezone.
					'og_def_currency'         => 'USD',	// Default Currency.
					'og_img_width'            => 1200,
					'og_img_height'           => 630,
					'og_img_crop'             => 1,
					'og_img_crop_x'           => 'center',
					'og_img_crop_y'           => 'center',
					'og_img_max'              => 1,		// Maximum Images to Include.
					'og_title_sep'            => '-',
					'og_title_max_len'        => 70,
					'og_title_warn_len'       => 40,
					'og_desc_max_len'         => 300,
					'og_desc_warn_len'        => 160,
					'og_desc_hashtags'        => 0,
					'og_vid_max'              => 1,
					'og_vid_autoplay'         => 1,
					'og_vid_prev_img'         => 1,		// Include Video Preview Images.

					/**
					 * Advanced Settings > Document Types > Open Graph tab.
					 *
					 * Standard WordPress taxonomy and post types.
					 */
					'og_type_for_archive_page'      => 'website',
					'og_type_for_attachment'        => 'website',
					'og_type_for_home_page'         => 'website',
					'og_type_for_home_posts'        => 'website',
					'og_type_for_page'              => 'article',
					'og_type_for_post'              => 'article',
					'og_type_for_post_archive'      => 'website',
					'og_type_for_question'          => 'article',
					'og_type_for_search_page'       => 'website',
					'og_type_for_tax_category'      => 'website',
					'og_type_for_tax_link_category' => 'website',
					'og_type_for_tax_post_tag'      => 'website',
					'og_type_for_user_page'         => 'profile',

					/**
					 * Advanced Settings > Document Types > Open Graph tab.
					 *
					 * Custom taxonomy and post types.
					 */
					'og_type_for_article'                => 'article',
					'og_type_for_book'                   => 'book',
					'og_type_for_download'               => 'product',	// For Easy Digital Downloads.
					'og_type_for_organization'           => 'website',
					'og_type_for_place'                  => 'place',
					'og_type_for_product'                => 'product', 	// For WooCommerce etc.
					'og_type_for_question'               => 'article',
					'og_type_for_tax_faq_category'       => 'website',
					'og_type_for_tax_product_brand'      => 'website',	// For WooCommerce Brands.
					'og_type_for_tax_product_cat'        => 'website',	// For WooCommerce.
					'og_type_for_tax_product_tag'        => 'website',	// For WooCommerce.
					'og_type_for_tax_pwb-brand'          => 'website',	// For Perfect WooCommerce Brands Add-on.
					'og_type_for_tax_yith_product_brand' => 'website',	// For YITH WooCommerce Brands Add-on.
					'og_type_for_tc_events'              => 'article',	// For Tickera.
					'og_type_for_tribe_events'           => 'article',	// For The Events Calendar.
					'og_type_for_website'                => 'website',

					/**
					 * Pinterest options.
					 */
					'pin_publisher_url'            => '',
					'pin_add_nopin_header_img_tag' => 1,		// Add "nopin" to Site Header Image.
					'pin_add_nopin_media_img_tag'  => 0,		// Add Pinterest "nopin" to Images.
					'pin_add_img_html'             => 0,		// Add Hidden Image for Pinterest.
					'pin_img_width'                => 1200,
					'pin_img_height'               => 1800,
					'pin_img_crop'                 => 0,
					'pin_img_crop_x'               => 'center',
					'pin_img_crop_y'               => 'center',
					'pin_img_desc_max_len'         => 300,		// Image Description Max. Length (hard limit).
					'pin_img_desc_warn_len'        => 100,		// Image Description Max. Length (soft limit).

					/**
					 * Robots options.
					 */
					'robots_max_snippet'       => -1,
					'robots_max_image_preview' => 'large',
					'robots_max_video_preview' => -1,

					/**
					 * Schema options.
					 */
					'schema_1x1_img_width'   => 1200,
					'schema_1x1_img_height'  => 1200,
					'schema_1x1_img_crop'    => 1,
					'schema_1x1_img_crop_x'  => 'center',
					'schema_1x1_img_crop_y'  => 'center',
					'schema_4x3_img_width'   => 1200,
					'schema_4x3_img_height'  => 900,
					'schema_4x3_img_crop'    => 1,
					'schema_4x3_img_crop_x'  => 'center',
					'schema_4x3_img_crop_y'  => 'center',
					'schema_16x9_img_width'  => 1200,
					'schema_16x9_img_height' => 675,
					'schema_16x9_img_crop'   => 1,
					'schema_16x9_img_crop_x' => 'center',
					'schema_16x9_img_crop_y' => 'center',
					'schema_img_max'         => 1,		// Schema Max. Images to Include.
					'schema_aggr_offers'     => 0,		// Aggregate Offers by Currency.
					'schema_add_text_prop'   => 1,		// Add Text / Article Body Properties.
					'schema_text_max_len'    => 10000,	// Text / Article Body Max. Length.
					'schema_desc_max_len'    => 300,	// Schema Description Max. Length (hard limit).

					/**
					 * Advanced Settings > Document Types > Schema tab.
					 *
					 * Standard WordPress taxonomy and post types.
					 */
					'schema_type_for_archive_page'      => 'item.list',
					'schema_type_for_attachment'        => 'webpage',
					'schema_type_for_home_page'         => 'website',
					'schema_type_for_home_posts'        => 'blog',
					'schema_type_for_page'              => 'article',
					'schema_type_for_post'              => 'blog.posting',
					'schema_type_for_post_archive'      => 'item.list',
					'schema_type_for_search_page'       => 'webpage.search.results',
					'schema_type_for_tax_category'      => 'item.list',
					'schema_type_for_tax_link_category' => 'item.list',
					'schema_type_for_tax_post_tag'      => 'item.list',
					'schema_type_for_user_page'         => 'webpage.profile',

					/**
					 * Advanced Settings > Document Types > Schema tab.
					 *
					 * Custom taxonomy and post types.
					 */
					'schema_type_for_article'                => 'article',
					'schema_type_for_book'                   => 'book',
					'schema_type_for_blog'                   => 'blog',
					'schema_type_for_business'               => 'local.business',
					'schema_type_for_download'               => 'product',		// For Easy Digital Downloads.
					'schema_type_for_event'                  => 'event',
					'schema_type_for_howto'                  => 'how.to',
					'schema_type_for_job_listing'            => 'job.posting',	// For WP Job Manager.
					'schema_type_for_jobpost'                => 'job.posting',	// For Simple Job Board.
					'schema_type_for_organization'           => 'organization',
					'schema_type_for_other'                  => 'other',
					'schema_type_for_person'                 => 'person',
					'schema_type_for_place'                  => 'place',
					'schema_type_for_product'                => 'product',		// For WooCommerce etc.
					'schema_type_for_qa'                     => 'webpage.qa',
					'schema_type_for_question'               => 'question',		// For WPSSO FAQ.
					'schema_type_for_review'                 => 'review',		// For WP Product Review.
					'schema_type_for_tax_faq_category'       => 'webpage.faq',	// For WPSSO FAQ.
					'schema_type_for_tax_product_brand'      => 'item.list',	// For WooCommerce Brands.
					'schema_type_for_tax_product_cat'        => 'item.list',	// For WooCommerce.
					'schema_type_for_tax_product_tag'        => 'item.list',	// For WooCommerce.
					'schema_type_for_tax_pwb-brand'          => 'item.list',	// For Perfect WooCommerce Brands Add-on.
					'schema_type_for_tax_yith_product_brand' => 'item.list',	// For YITH WooCommerce Brands Add-on.
					'schema_type_for_tc_events'              => 'event',		// For Tickera.
					'schema_type_for_tribe_events'           => 'event',		// For The Events Calendar.
					'schema_type_for_webpage'                => 'webpage',
					'schema_type_for_website'                => 'website',

					/**
					 * Advanced Settings > Schema Defaults metabox.
					 */
					'schema_def_family_friendly'           => 'none',		// Default Family Friendly.
					'schema_def_pub_org_id'                => 'none',		// Default Publisher Org.
					'schema_def_pub_person_id'             => 'none',		// Default Publisher Person.
					'schema_def_prov_org_id'               => 'none',		// Default Service Prov. Org.
					'schema_def_prov_person_id'            => 'none',		// Default Service Prov. Person.
					'schema_def_event_location_id'         => 'none',		// Default Physical Venue.
					'schema_def_event_organizer_org_id'    => 'none',		// Default Organizer Org.
					'schema_def_event_organizer_person_id' => 'none',		// Default Organizer Person.
					'schema_def_event_performer_org_id'    => 'none',		// Default Performer Org.
					'schema_def_event_performer_person_id' => 'none',		// Default Performer Person.
					'schema_def_job_hiring_org_id'         => 'none',		// Default Hiring Org.
					'schema_def_job_location_id'           => 'none',		// Default Job Location.
					'schema_def_job_location_type'         => 'none',		// Default Job Location Type.
					'schema_def_review_item_type'          => 'creative.work',	// Default Subject Webpage Type.

					/**
					 * SEO options.
					 */
					'seo_desc_max_len' => 180,	// Description Meta Tag Max. Length (hard limit).

					/**
					 * Twitter Card options.
					 */
					'tc_site'           => '',			// Twitter Business @username (localized).
					'tc_title_max_len'  => 70,			// Twitter Card Title Max. Length (hard limit).
					'tc_desc_max_len'   => 200,			// Twitter Card Description Max. Length (hard limit).
					'tc_type_singular'  => 'summary_large_image',	// Twitter Card for Post / Page Image.
					'tc_type_default'   => 'summary',		// Twitter Card Type by Default.
					'tc_sum_img_width'  => 1200,
					'tc_sum_img_height' => 630,
					'tc_sum_img_crop'   => 1,
					'tc_sum_img_crop_x' => 'center',
					'tc_sum_img_crop_y' => 'center',
					'tc_lrg_img_width'  => 1200,
					'tc_lrg_img_height' => 1800,
					'tc_lrg_img_crop'   => 0,
					'tc_lrg_img_crop_x' => 'center',
					'tc_lrg_img_crop_y' => 'center',

					/**
					 * Schema thumbnail image size.
					 */
					'thumb_img_width'  => 1200,
					'thumb_img_height' => 630,
					'thumb_img_crop'   => 1,
					'thumb_img_crop_x' => 'center',
					'thumb_img_crop_y' => 'center',

					/**
					 * Other publisher page URLs.
					 */
					'instagram_publisher_url' => '',	// Instagram Business Page URL (localized).
					'linkedin_publisher_url'  => '',	// LinkedIn Company Page URL (localized).
					'medium_publisher_url'    => '',	// Medium Business Page URL (localized).
					'myspace_publisher_url'   => '',	// Myspace Business Page URL (localized).
					'sc_publisher_url'        => '',	// Soundcloud Business Page URL (localized).
					'tiktok_publisher_url'    => '',	// TikTok Business Page URL (localized).
					'tumblr_publisher_url'    => '',	// Tumblr Business Page URL (localized).
					'wikipedia_publisher_url' => '',	// Wikipedia Organization Page URL (localized).
					'yt_publisher_url'        => '',	// YouTube Business Channel URL (localized).

					/**
					 * Website verification IDs.
					 */
					'ahrefs_site_verify' => '',	// Ahrefs Website Verification ID.
					'baidu_site_verify'  => '',	// Baidu Website Verification ID.
					'fb_site_verify'     => '',	// Facebook Domain Verification ID.
					'g_site_verify'      => '',	// Google Website Verification ID.
					'bing_site_verify'   => '',	// Microsoft Bing Website Verification ID.
					'pin_site_verify'    => '',	// Pinterest Website Verification ID.
					'yandex_site_verify' => '',	// Yandex Website Verification ID.

					/**
					 * Enable / disable individual head HTML tags.
					 */
					'add_link_rel_author'                               => 0,	// Deprecated - no longer used by Google.
					'add_link_rel_canonical'                            => 0,
					'add_link_rel_publisher'                            => 0,	// Deprecated - no longer used by Google.
					'add_link_rel_shortlink'                            => 1,
					'add_meta_property_fb:admins'                       => 1,
					'add_meta_property_fb:app_id'                       => 1,
					'add_meta_property_al:android:app_name'             => 1,
					'add_meta_property_al:android:package'              => 1,
					'add_meta_property_al:android:url'                  => 1,
					'add_meta_property_al:ios:app_name'                 => 1,
					'add_meta_property_al:ios:app_store_id'             => 1,
					'add_meta_property_al:ios:url'                      => 1,
					'add_meta_property_al:web:url'                      => 1,
					'add_meta_property_al:web:should_fallback'          => 1,
					'add_meta_property_og:altitude'                     => 1,
					'add_meta_property_og:description'                  => 1,
					'add_meta_property_og:image:secure_url'             => 0,	// Use og:image instead.
					'add_meta_property_og:image:url'                    => 0,	// Use og:image instead.
					'add_meta_property_og:image'                        => 1,
					'add_meta_property_og:image:width'                  => 1,
					'add_meta_property_og:image:height'                 => 1,
					'add_meta_property_og:image:alt'                    => 1,
					'add_meta_property_og:latitude'                     => 1,
					'add_meta_property_og:locale'                       => 1,
					'add_meta_property_og:longitude'                    => 1,
					'add_meta_property_og:site_name'                    => 1,
					'add_meta_property_og:title'                        => 1,
					'add_meta_property_og:type'                         => 1,
					'add_meta_property_og:updated_time'                 => 1,
					'add_meta_property_og:url'                          => 1,
					'add_meta_property_og:video:secure_url'             => 0,	// Use og:video instead.
					'add_meta_property_og:video:url'                    => 0,	// Use og:video instead.
					'add_meta_property_og:video'                        => 1,
					'add_meta_property_og:video:type'                   => 1,
					'add_meta_property_og:video:width'                  => 1,
					'add_meta_property_og:video:height'                 => 1,
					'add_meta_property_og:video:tag'                    => 0,	// Disabled by default.
					'add_meta_property_article:author'                  => 1,
					'add_meta_property_article:publisher'               => 1,
					'add_meta_property_article:published_time'          => 1,
					'add_meta_property_article:modified_time'           => 1,
					'add_meta_property_article:expiration_time'         => 1,
					'add_meta_property_article:section'                 => 1,
					'add_meta_property_article:tag'                     => 1,
					'add_meta_property_book:author'                     => 1,
					'add_meta_property_book:isbn'                       => 1,
					'add_meta_property_book:release_date'               => 1,
					'add_meta_property_book:tag'                        => 1,
					'add_meta_property_music:album'                     => 1,
					'add_meta_property_music:album:disc'                => 1,
					'add_meta_property_music:album:track'               => 1,
					'add_meta_property_music:creator'                   => 1,
					'add_meta_property_music:duration'                  => 1,
					'add_meta_property_music:musician'                  => 1,
					'add_meta_property_music:release_date'              => 1,
					'add_meta_property_music:song'                      => 1,
					'add_meta_property_music:song:disc'                 => 1,
					'add_meta_property_music:song:track'                => 1,
					'add_meta_property_place:location:altitude'         => 1,
					'add_meta_property_place:location:latitude'         => 1,
					'add_meta_property_place:location:longitude'        => 1,
					'add_meta_property_place:street_address'            => 1,
					'add_meta_property_place:locality'                  => 1,
					'add_meta_property_place:region'                    => 1,
					'add_meta_property_place:postal_code'               => 1,
					'add_meta_property_place:country_name'              => 1,
					'add_meta_property_product:age_group'               => 1,
					'add_meta_property_product:availability'            => 1,
					'add_meta_property_product:brand'                   => 1,
					'add_meta_property_product:category'                => 1,
					'add_meta_property_product:color'                   => 1,
					'add_meta_property_product:condition'               => 1,
					'add_meta_property_product:ean'                     => 1,
					'add_meta_property_product:expiration_time'         => 1,
					'add_meta_property_product:is_product_shareable'    => 1,
					'add_meta_property_product:isbn'                    => 1,
					'add_meta_property_product:material'                => 1,
					'add_meta_property_product:mfr_part_no'             => 1,
					'add_meta_property_product:original_price:amount'   => 1,
					'add_meta_property_product:original_price:currency' => 1,
					'add_meta_property_product:pattern'                 => 1,
					'add_meta_property_product:plural_title'            => 1,
					'add_meta_property_product:pretax_price:amount'     => 1,
					'add_meta_property_product:pretax_price:currency'   => 1,
					'add_meta_property_product:price:amount'            => 1,
					'add_meta_property_product:price:currency'          => 1,
					'add_meta_property_product:product_link'            => 1,
					'add_meta_property_product:purchase_limit'          => 1,
					'add_meta_property_product:retailer'                => 1,
					'add_meta_property_product:retailer_category'       => 1,
					'add_meta_property_product:retailer_item_id'        => 1,
					'add_meta_property_product:retailer_part_no'        => 1,
					'add_meta_property_product:retailer_title'          => 1,
					'add_meta_property_product:sale_price:amount'       => 1,
					'add_meta_property_product:sale_price:currency'     => 1,
					'add_meta_property_product:sale_price_dates:start'  => 1,
					'add_meta_property_product:sale_price_dates:end'    => 1,
					'add_meta_property_product:shipping_cost:amount'    => 1,
					'add_meta_property_product:shipping_cost:currency'  => 1,
					'add_meta_property_product:shipping_weight:value'   => 1,
					'add_meta_property_product:shipping_weight:units'   => 1,
					'add_meta_property_product:size'                    => 1,
					'add_meta_property_product:target_gender'           => 1,
					'add_meta_property_product:upc'                     => 1,
					'add_meta_property_product:weight:value'            => 1,
					'add_meta_property_product:weight:units'            => 1,
					'add_meta_name_ahrefs-site-verification'            => 1,	// Ahrefs Website Verification ID.
					'add_meta_name_author'                              => 1,
					'add_meta_name_baidu-site-verification'             => 1,	// Baidu Website Verification ID.
					'add_meta_name_description'                         => 1,
					'add_meta_name_generator'                           => 1,
					'add_meta_name_google-site-verification'            => 1,	// Google Website Verification ID.
					'add_meta_name_msvalidate.01'                       => 1,	// Microsoft Bing Website Verification ID.
					'add_meta_name_p:domain_verify'                     => 1,	// Pinterest Website Verification ID.
					'add_meta_name_robots'                              => 1,
					'add_meta_name_thumbnail'                           => 1,
					'add_meta_name_twitter:card'                        => 1,
					'add_meta_name_twitter:creator'                     => 1,
					'add_meta_name_twitter:domain'                      => 1,
					'add_meta_name_twitter:site'                        => 1,
					'add_meta_name_twitter:title'                       => 1,
					'add_meta_name_twitter:description'                 => 1,
					'add_meta_name_twitter:image'                       => 1,
					'add_meta_name_twitter:image:width'                 => 1,
					'add_meta_name_twitter:image:height'                => 1,
					'add_meta_name_twitter:image:alt'                   => 1,
					'add_meta_name_twitter:player'                      => 1,
					'add_meta_name_twitter:player:stream'               => 1,
					'add_meta_name_twitter:player:stream:content_type'  => 1,
					'add_meta_name_twitter:player:width'                => 1,
					'add_meta_name_twitter:player:height'               => 1,
					'add_meta_name_twitter:app:name:iphone'             => 1,
					'add_meta_name_twitter:app:id:iphone'               => 1,
					'add_meta_name_twitter:app:url:iphone'              => 1,
					'add_meta_name_twitter:app:name:ipad'               => 1,
					'add_meta_name_twitter:app:id:ipad'                 => 1,
					'add_meta_name_twitter:app:url:ipad'                => 1,
					'add_meta_name_twitter:app:name:googleplay'         => 1,
					'add_meta_name_twitter:app:id:googleplay'           => 1,
					'add_meta_name_twitter:app:url:googleplay'          => 1,
					'add_meta_name_twitter:label1'                      => 1,
					'add_meta_name_twitter:data1'                       => 1,
					'add_meta_name_twitter:label2'                      => 1,
					'add_meta_name_twitter:data2'                       => 1,
					'add_meta_name_yandex-verification'                 => 1,	// Yandex Website Verification ID.

					/**
					 * Advanced Settings > Plugin Admin tab.
					 */
					'plugin_clean_on_uninstall' => 0,	// Remove Settings on Uninstall.
					'plugin_cache_disable'      => 0,	// Disable Cache for Debugging.
					'plugin_debug_html'         => 0,	// Add HTML Debug Messages.
					'plugin_load_mofiles'       => 0,	// Use Local Plugin Translations.

					/**
					 * Advanced Settings > Interface tab.
					 */
					'plugin_show_opts'                     => 'basic',	// Options to Show by Default.
					'plugin_show_validate_toolbar'         => 1,		// Show Validators Toolbar Menu.
					'plugin_add_to_article'                => 1,
					'plugin_add_to_attachment'             => 1,
					'plugin_add_to_download'               => 1,		// For Easy Digital Downloads.
					'plugin_add_to_organization'           => 1,
					'plugin_add_to_page'                   => 1,
					'plugin_add_to_place'                  => 1,
					'plugin_add_to_post'                   => 1,
					'plugin_add_to_product'                => 1,		// For WooCommerce and other e-commerce plugins.
					'plugin_add_to_question'               => 1,
					'plugin_add_to_reply'                  => 0,		// For Bbpress
					'plugin_add_to_tax_category'           => 1,
					'plugin_add_to_tax_faq_category'       => 1,
					'plugin_add_to_tax_link_category'      => 1,
					'plugin_add_to_tax_post_tag'           => 1,
					'plugin_add_to_tax_product_brand'      => 1,		// For WooCommerce Brands.
					'plugin_add_to_tax_product_cat'        => 1,		// For WooCommerce.
					'plugin_add_to_tax_product_tag'        => 1,		// For WooCommerce.
					'plugin_add_to_tax_pwb-brand'          => 1,		// For Perfect WooCommerce Brands Add-on.
					'plugin_add_to_tax_yith_product_brand' => 1,		// For YITH WooCommerce Brands Add-on.
					'plugin_add_to_topic'                  => 0,		// For Bbpress
					'plugin_add_to_tribe_events'           => 1,		// For The Events Calendar.
					'plugin_add_to_tribe-ea-record'        => 1,		// For The Events Calendar.
					'plugin_add_to_user_page'              => 1,
					'plugin_schema_type_col_media'         => 0,		// Additional List Table Columns.
					'plugin_schema_type_col_post'          => 0,
					'plugin_schema_type_col_term'          => 0,
					'plugin_schema_type_col_user'          => 0,
					'plugin_og_type_col_media'             => 0,
					'plugin_og_type_col_post'              => 0,
					'plugin_og_type_col_term'              => 0,
					'plugin_og_type_col_user'              => 0,
					'plugin_og_img_col_media'              => 0,
					'plugin_og_img_col_post'               => 1,
					'plugin_og_img_col_term'               => 1,
					'plugin_og_img_col_user'               => 1,
					'plugin_og_desc_col_media'             => 1,
					'plugin_og_desc_col_post'              => 0,
					'plugin_og_desc_col_term'              => 0,
					'plugin_og_desc_col_user'              => 0,

					/**
					 * Advanced Settings > Integration tab.
					 */
					'plugin_document_title'       => 'wp_title',		// Webpage Document Title.
					'plugin_filter_title'         => 0,			// Use Filtered "SEO" Title.
					'plugin_filter_content'       => 0,			// Use Filtered Content.
					'plugin_filter_excerpt'       => 0,			// Use Filtered Excerpt.
					'plugin_page_excerpt'         => 0,			// Enable Excerpt for Pages.
					'plugin_page_tags'            => 0,			// Enable Tags for Pages.
					'plugin_new_user_is_person'   => 0,			// Add Person Role for New Users.
					'plugin_clear_post_terms'     => 1,			// Clear Term Cache when Publishing.
					'plugin_clear_for_comment'    => 1,			// Clear Post Cache for New Comment.
					'plugin_check_img_dims'       => 0,			// Enforce Image Dimension Checks.
					'plugin_upscale_images'       => 0,			// Upscale Media Library Images.
					'plugin_upscale_img_max'      => 33,			// Maximum Image Upscale Percent.
					'plugin_img_alt_prefix'       => 'Image:',		// Content Image Alt Prefix.
					'plugin_img_alt_prefix#es_ES' => 'Imagen:',		// Content Image Alt Prefix (es_ES).
					'plugin_img_alt_prefix#fr_BE' => 'Image:',		// Content Image Alt Prefix (fr_BE).
					'plugin_img_alt_prefix#fr_CA' => 'Image:',		// Content Image Alt Prefix (fr_CA).
					'plugin_img_alt_prefix#fr_FR' => 'Image:',		// Content Image Alt Prefix (fr_FR).
					'plugin_p_cap_prefix'         => 'Caption:',		// WP Caption Text Prefix.
					'plugin_p_cap_prefix#es_ES'   => 'Leyenda:',		// WP Caption Text Prefix (es_ES).
					'plugin_p_cap_prefix#fr_BE'   => 'Légende:',		// WP Caption Text Prefix (fr_BE).
					'plugin_p_cap_prefix#fr_CA'   => 'Légende:',		// WP Caption Text Prefix (fr_CA).
					'plugin_p_cap_prefix#fr_FR'   => 'Légende:',		// WP Caption Text Prefix (fr_FR).
					'plugin_no_title_text'        => 'No Title',		// No Title Text.
					'plugin_no_title_text#es_ES'  => 'Sin título',		// No Title Text (es_ES).
					'plugin_no_title_text#fr_BE'  => 'Aucun titre',		// No Title Text (fr_BE).
					'plugin_no_title_text#fr_CA'  => 'Aucun titre',		// No Title Text (fr_CA).
					'plugin_no_title_text#fr_FR'  => 'Aucun titre',		// No Title Text (fr_FR).
					'plugin_no_desc_text'         => 'No Description.',	// No Description Text.
					'plugin_no_desc_text#es_ES'   => 'Sin descripción.',	// No Description Text (es_ES).
					'plugin_no_desc_text#fr_BE'   => 'Aucune description.',	// No Description Text (fr_BE).
					'plugin_no_desc_text#fr_CA'   => 'Aucune description.',	// No Description Text (fr_CA).
					'plugin_no_desc_text#fr_FR'   => 'Aucune description.',	// No Description Text (fr_FR).

					/**
					 * Advanced Settings > Integration tab (Plugin and Theme Integration).
					 */
					'plugin_check_head'          => 1,	// Check for Duplicate Meta Tags.
					'plugin_product_include_vat' => 0,	// Include VAT in Product Prices.
					'plugin_wpseo_social_meta'   => 0,	// Import Yoast SEO Social Meta.
					'plugin_wpseo_show_import'   => 1,	// Show Yoast SEO Import Details.

					/**
					 * Advanced Settings > Media Services tab.
					 */
					'plugin_gravatar_api'   => 1,		// Gravatar is Default Author Image.
					'plugin_gravatar_size'  => 1200,	// Gravatar Image Size.
					'plugin_facebook_api'   => 1,		// Check for Embedded Media: Facebook Videos.
					'plugin_slideshare_api' => 1,		// Check for Embedded Media: Slideshare Presentations.
					'plugin_soundcloud_api' => 1,		// Check for Embedded Media: Soundcloud Tracks.
					'plugin_vimeo_api'      => 1,		// Check for Embedded Media: Vimeo Videos.
					'plugin_wistia_api'     => 1,		// Check for Embedded Media: Wistia Videos.
					'plugin_wpvideo_api'    => 1,		// Check for Embedded Media: WordPress Video Shortcode.
					'plugin_youtube_api'    => 1,		// Check for Embedded Media: Youtube Videos and Playlists.

					/**
					 * Advanced Settings > Shortening Services tab.
					 */
					'plugin_shortener'          => 'none',	// URL Shortening Service.
					'plugin_min_shorten'        => 23,	// Minimum URL Length to Shorten.
					'plugin_clear_short_urls'   => 0,	// Clear Short URLs on Clear Cache.
					'plugin_wp_shortlink'       => 1,	// Use Short URL for WP Shortlink.
					'plugin_bitly_access_token' => '',	// Bitly Generic Access Token.
					'plugin_bitly_domain'       => '',	// Bitly Short Domain (Optional).
					'plugin_bitly_group_name'   => '',	// Bitly Group Name (Optional).
					'plugin_dlmyapp_api_key'    => '',	// DLMY.App API Key.
					'plugin_owly_api_key'       => '',	// Ow.ly API Key.
					'plugin_yourls_api_url'     => '',	// YOURLS API URL.
					'plugin_yourls_username'    => '',	// YOURLS Username.
					'plugin_yourls_password'    => '',	// YOURLS Password.
					'plugin_yourls_token'       => '',	// YOURLS Token.

					/**
					 * Advanced Settings > Ratings and Reviews tab.
					 */
					'plugin_ratings_reviews_svc'          => 'none',	// Ratings and Reviews Service.
					'plugin_ratings_reviews_num_max'      => 100,		// Maximum Number of Reviews.
					'plugin_ratings_reviews_age_max'      => 60,		// Maximum Age of Reviews.
					'plugin_ratings_reviews_for_download' => 1,		// For Easy Digital Downloads.
					'plugin_ratings_reviews_for_product'  => 1,		// For WooCommerce, etc.
					'plugin_shopperapproved_site_id'      => '',		// Shopper Approved Site ID.
					'plugin_shopperapproved_token'        => '',		// Shopper Approved API Token.
					'plugin_stamped_store_hash'           => '',		// Stamped Store Hash.
					'plugin_stamped_key_public'           => '',		// Stamped API Key Public.

					/**
					 * Advanced Settings > Custom Contacts tab.
					 */
					'plugin_cm_behance_name'      => 'behance',
					'plugin_cm_behance_label'     => 'Behance Profile URL',
					'plugin_cm_behance_enabled'   => 1,
					'plugin_cm_fb_name'           => 'facebook',
					'plugin_cm_fb_label'          => 'Facebook User URL',
					'plugin_cm_fb_enabled'        => 1,
					'plugin_cm_instagram_name'    => 'instagram',
					'plugin_cm_instagram_label'   => 'Instagram URL',
					'plugin_cm_instagram_enabled' => 1,
					'plugin_cm_linkedin_name'     => 'linkedin',
					'plugin_cm_linkedin_label'    => 'LinkedIn URL',
					'plugin_cm_linkedin_enabled'  => 1,
					'plugin_cm_medium_name'       => 'medium',
					'plugin_cm_medium_label'      => 'Medium URL',
					'plugin_cm_medium_enabled'    => 1,
					'plugin_cm_myspace_name'      => 'myspace',
					'plugin_cm_myspace_label'     => 'Myspace URL',
					'plugin_cm_myspace_enabled'   => 1,
					'plugin_cm_pin_name'          => 'pinterest',
					'plugin_cm_pin_label'         => 'Pinterest URL',
					'plugin_cm_pin_enabled'       => 1,
					'plugin_cm_sc_name'           => 'soundcloud',
					'plugin_cm_sc_label'          => 'Soundcloud URL',
					'plugin_cm_sc_enabled'        => 1,
					'plugin_cm_skype_name'        => 'skype',
					'plugin_cm_skype_label'       => 'Skype Username',
					'plugin_cm_skype_enabled'     => 1,
					'plugin_cm_tiktok_name'       => 'tiktok',
					'plugin_cm_tiktok_label'      => 'TikTok URL',
					'plugin_cm_tiktok_enabled'    => 1,
					'plugin_cm_tumblr_name'       => 'tumblr',
					'plugin_cm_tumblr_label'      => 'Tumblr URL',
					'plugin_cm_tumblr_enabled'    => 1,
					'plugin_cm_twitter_name'      => 'twitter',
					'plugin_cm_twitter_label'     => 'Twitter @username',
					'plugin_cm_twitter_enabled'   => 1,
					'plugin_cm_wikipedia_name'    => 'wikipedia',
					'plugin_cm_wikipedia_label'   => 'Wikipedia Page URL',
					'plugin_cm_wikipedia_enabled' => 1,
					'plugin_cm_yt_name'           => 'youtube',
					'plugin_cm_yt_label'          => 'YouTube Channel URL',
					'plugin_cm_yt_enabled'        => 1,

					/**
					 * Advanced Settings > Default Contacts tab.
					 */
					'wp_cm_aim_name'       => 'aim',
					'wp_cm_aim_label'      => 'AIM',
					'wp_cm_aim_enabled'    => 1,
					'wp_cm_jabber_name'    => 'jabber',
					'wp_cm_jabber_label'   => 'Google Talk',
					'wp_cm_jabber_enabled' => 1,
					'wp_cm_yim_name'       => 'yim',
					'wp_cm_yim_label'      => 'Yahoo Messenger',
					'wp_cm_yim_enabled'    => 1,

					/**
					 * Advanced Settings > About the User metabox.
					 */
					'plugin_user_about_job_title'        => 1,	// Job Title.
					'plugin_user_about_honorific_prefix' => 1,	// Honorific Prefix.
					'plugin_user_about_honorific_suffix' => 1,	// Honorific Suffix.
					'plugin_user_about_additional_name'  => 1,	// Middle or Additional Name.

					/**
					 * Advanced Settings > Product Attributes tab.
					 */
					'plugin_attr_product_brand'              => 'Brand',		// Brand Attribute Name.
					'plugin_attr_product_color'              => 'Color',		// Color Attribute Name.
					'plugin_attr_product_condition'          => 'Condition',	// Condition Attribute Name.
					'plugin_attr_product_depth_value'        => 'Depth',		// Depth Attribute Name.
					'plugin_attr_product_fluid_volume_value' => 'Volume',		// Fluid Volume Attribute Name.
					'plugin_attr_product_gtin14'             => 'GTIN-14',		// GTIN-14 Attribute Name.
					'plugin_attr_product_gtin13'             => 'GTIN-13',		// GTIN-13 (EAN) Attribute Name.
					'plugin_attr_product_gtin12'             => 'GTIN-12',		// GTIN-12 (UPC) Attribute Name.
					'plugin_attr_product_gtin8'              => 'GTIN-8',		// GTIN-8 Attribute Name.
					'plugin_attr_product_gtin'               => 'GTIN',		// GTIN Attribute Name.
					'plugin_attr_product_isbn'               => 'ISBN',		// ISBN Attribute Name.
					'plugin_attr_product_material'           => 'Material',		// Material Attribute Name.
					'plugin_attr_product_mfr_part_no'        => 'MPN',		// MPN Attribute Name.
					'plugin_attr_product_size'               => 'Size',		// Size Attribute Name.
					'plugin_attr_product_target_gender'      => 'Gender',		// Target Gender Attribute Name.

					/**
					 * Advanced Settings > Custom Fields tab.
					 */
					'plugin_cf_addl_type_urls'             => '',	// Microdata Type URLs Custom Field.
					'plugin_cf_book_isbn'                  => '',	// Book ISBN Custom Field.
					'plugin_cf_howto_steps'                => '',	// How-To Steps Custom Field.
					'plugin_cf_howto_supplies'             => '',	// How-To Supplies Custom Field.
					'plugin_cf_howto_tools'                => '',	// How-To Tools Custom Field.
					'plugin_cf_img_url'                    => '',	// Image URL Custom Field.
					'plugin_cf_product_avail'              => '',	// Product Availability Custom Field.
					'plugin_cf_product_brand'              => '',	// Product Brand Custom Field.
					'plugin_cf_product_category'           => '',	// Product Type ID Custom Field.
					'plugin_cf_product_color'              => '',	// Product Color Custom Field.
					'plugin_cf_product_condition'          => '',	// Product Condition Custom Field.
					'plugin_cf_product_currency'           => '',	// Product Currency Custom Field.
					'plugin_cf_product_depth_value'        => '',	// Product Depth Custom Field.
					'plugin_cf_product_fluid_volume_value' => '',	// Product Fluid Volume Custom Field.
					'plugin_cf_product_gtin14'             => '',	// Product GTIN-14 Custom Field.
					'plugin_cf_product_gtin13'             => '',	// Product GTIN-13 (EAN) Custom Field.
					'plugin_cf_product_gtin12'             => '',	// Product GTIN-12 (UPC) Custom Field.
					'plugin_cf_product_gtin8'              => '',	// Product GTIN-8 Custom Field.
					'plugin_cf_product_gtin'               => '',	// Product GTIN Custom Field.
					'plugin_cf_product_height_value'       => '',	// Product Height Custom Field.
					'plugin_cf_product_isbn'               => '',	// Product ISBN Custom Field.
					'plugin_cf_product_length_value'       => '',	// Product Length Custom Field.
					'plugin_cf_product_material'           => '',	// Product Material Custom Field.
					'plugin_cf_product_mfr_part_no'        => '',	// Product MPN Custom Field.
					'plugin_cf_product_price'              => '',	// Product Price Custom Field.
					'plugin_cf_product_retailer_part_no'   => '',	// Product SKU Custom Field.
					'plugin_cf_product_size'               => '',	// Product Size Custom Field.
					'plugin_cf_product_target_gender'      => '',	// Product Target Gender Custom Field.
					'plugin_cf_product_weight_value'       => '',	// Product Weight Custom Field.
					'plugin_cf_product_width_value'        => '',	// Product Width Custom Field.
					'plugin_cf_recipe_ingredients'         => '',	// Recipe Ingredients Custom Field.
					'plugin_cf_recipe_instructions'        => '',	// Recipe Instructions Custom Field.
					'plugin_cf_sameas_urls'                => '',	// Same-As URLs Custom Field.
					'plugin_cf_vid_url'                    => '',	// Video URL Custom Field.
					'plugin_cf_vid_embed'                  => '',	// Video Embed HTML Custom Field.

					/**
					 * Advanced Settings > WordPress Sitemaps metabox.
					 */
					'plugin_sitemaps_for_article'                => 1,
					'plugin_sitemaps_for_attachment'             => 0,
					'plugin_sitemaps_for_download'               => 1,	// For Easy Digital Downloads.
					'plugin_sitemaps_for_organization'           => 1,
					'plugin_sitemaps_for_page'                   => 1,
					'plugin_sitemaps_for_place'                  => 1,
					'plugin_sitemaps_for_post'                   => 1,
					'plugin_sitemaps_for_product'                => 1,	// For WooCommerce, etc.
					'plugin_sitemaps_for_question'               => 1,
					'plugin_sitemaps_for_reply'                  => 0,	// For Bbpress
					'plugin_sitemaps_for_tax_category'           => 1,
					'plugin_sitemaps_for_tax_faq_category'       => 1,
					'plugin_sitemaps_for_tax_link_category'      => 1,
					'plugin_sitemaps_for_tax_post_tag'           => 1,
					'plugin_sitemaps_for_tax_product_brand'      => 1,	// For WooCommerce Brands.
					'plugin_sitemaps_for_tax_product_cat'        => 1,	// For WooCommerce.
					'plugin_sitemaps_for_tax_product_tag'        => 1,	// For WooCommerce.
					'plugin_sitemaps_for_tax_pwb-brand'          => 1,	// For Perfect WooCommerce Brands Add-on.
					'plugin_sitemaps_for_tax_yith_product_brand' => 1,	// For YITH WooCommerce Brands Add-on.
					'plugin_sitemaps_for_topic'                  => 0,	// For Bbpress
					'plugin_sitemaps_for_tribe_events'           => 1,	// For The Events Calendar.
					'plugin_sitemaps_for_tribe-ea-record'        => 1,	// For The Events Calendar.
					'plugin_sitemaps_for_user_page'              => 1,
				),

				/**
				 * Multisite options.
				 *
				 * Automatically includes all advanced plugin options. 
				 *
				 * See the WpssoOptions->get_site_defaults() method.
				 */
				'site_defaults' => array(
					'options_version'  => '',	// Example: -wpsso512pro-wpssoum3gpl
					'options_filtered' => 0,
				),

				/**
				 * Contact method and social options prefix.
				 *
				 * The options prefix is used for contact method options (for example, 'plugin_cm_fb_enabled') and
				 * social sharing buttons options (for example, 'fb_utm_source').
				 */
				'cm_prefix' => array(
					'behance'     => 'behance',
					'email'       => 'email',
					'facebook'    => 'fb',
					'twitter'     => 'twitter',
					'instagram'   => 'instagram',
					'linkedin'    => 'linkedin',
					'medium'      => 'medium',
					'myspace'     => 'myspace',
					'pinterest'   => 'pin',
					'pocket'      => 'pocket',
					'buffer'      => 'buffer',
					'reddit'      => 'reddit',
					'managewp'    => 'managewp',
					'soundcloud'  => 'sc',
					'tiktok'      => 'tiktok',
					'tumblr'      => 'tumblr',
					'skype'       => 'skype',
					'vk'          => 'vk',
					'whatsapp'    => 'wa',
					'wikipedia'   => 'wikipedia',
					'youtube'     => 'yt',
				),

				/**
				 * Custom field to meta data index.
				 */
				'cf_md_index' => array(
					'plugin_cf_addl_type_urls'             => 'schema_addl_type_url',	// Microdata Type URLs Custom Field.
					'plugin_cf_book_isbn'                  => 'book_isbn',
					'plugin_cf_howto_steps'                => 'schema_howto_step',		// How-To Steps Custom Field.
					'plugin_cf_howto_supplies'             => 'schema_howto_supply',	// How-To Supplies Custom Field.
					'plugin_cf_howto_tools'                => 'schema_howto_tool',		// How-To Tools Custom Field.
					'plugin_cf_img_url'                    => 'og_img_url',
					'plugin_cf_product_avail'              => 'product_avail',
					'plugin_cf_product_brand'              => 'product_brand',		// Product Brand Custom Field.
					'plugin_cf_product_category'           => 'product_category',		// Product Type ID Custom Field.
					'plugin_cf_product_color'              => 'product_color',
					'plugin_cf_product_condition'          => 'product_condition',
					'plugin_cf_product_currency'           => 'product_currency',
					'plugin_cf_product_depth_value'        => 'product_depth_value',	// Product Depth Custom Field.
					'plugin_cf_product_fluid_volume_value' => 'product_fluid_volume_value',	// Product Fluid Volume Custom Field.
					'plugin_cf_product_gtin14'             => 'product_gtin14',
					'plugin_cf_product_gtin13'             => 'product_gtin13',
					'plugin_cf_product_gtin12'             => 'product_gtin12',
					'plugin_cf_product_gtin8'              => 'product_gtin8',
					'plugin_cf_product_gtin'               => 'product_gtin',
					'plugin_cf_product_height_value'       => 'product_height_value',	// Product Height Custom Field.
					'plugin_cf_product_isbn'               => 'product_isbn',
					'plugin_cf_product_length_value'       => 'product_length_value',	// Product Length Custom Field.
					'plugin_cf_product_material'           => 'product_material',
					'plugin_cf_product_mfr_part_no'        => 'product_mfr_part_no',
					'plugin_cf_product_price'              => 'product_price',
					'plugin_cf_product_size'               => 'product_size',
					'plugin_cf_product_retailer_part_no'   => 'product_retailer_part_no',
					'plugin_cf_product_target_gender'      => 'product_target_gender',
					'plugin_cf_product_weight_value'       => 'product_weight_value',	// Product Weight Custom Field.
					'plugin_cf_product_width_value'        => 'product_width_value',	// Product Width Custom Field.
					'plugin_cf_recipe_ingredients'         => 'schema_recipe_ingredient',
					'plugin_cf_recipe_instructions'        => 'schema_recipe_instruction',
					'plugin_cf_sameas_urls'                => 'schema_sameas_url',
					'plugin_cf_vid_embed'                  => 'og_vid_embed',
					'plugin_cf_vid_url'                    => 'og_vid_url',
				),

				/**
				 * Read and split custom field values into numbered meta keys.
				 */
				'cf_md_multi' => array(
					'schema_addl_type_url'      => true,	// Microdata Type URLs.
					'schema_howto_step'         => array(	// How-To Name.
						'schema_howto_step_section',	// How-To Step or Group / Section.
						'schema_howto_step_text',	// How-To Description.
						'schema_howto_step_img_id',	// How-To Image ID.
						'schema_howto_step_img_id_lib',
					),
					'schema_howto_supply'       => true,	// How-To Supplies.
					'schema_howto_tool'         => true,	// How-To Tools.
					'schema_recipe_ingredient'  => true,	// Recipe Ingredients.
					'schema_recipe_instruction' => array(	// Recipe Instructions.
						'schema_recipe_instruction_section',	// How-To Instruction or Group / Section.
						'schema_recipe_instruction_text',	// How-To Description.
						'schema_recipe_instruction_img_id',	// How-To Image ID.
						'schema_recipe_instruction_img_id_lib',
					),
					'schema_sameas_url'         => true,	// Same-As URLs.
				),

				/**
				 * Additional fields for the user profile About Yourself / About the user sections.
				 */
				'user_about' => array(
					'job_title'        => 'Job Title',
					'honorific_prefix' => 'Honorific Prefix',
					'honorific_suffix' => 'Honorific Suffix',
					'additional_name'  => 'Middle or Additional Name',
				),

				'site_verify_meta_names' => array(
					'ahrefs_site_verify' => 'ahrefs-site-verification',	// Ahrefs Website Verification ID.
					'baidu_site_verify'  => 'baidu-site-verification',	// Baidu Website Verification ID.
					'fb_site_verify'     => 'facebook-domain-verification',	// Facebook Domain Verification ID.
					'g_site_verify'      => 'google-site-verification',	// Google Website Verification ID.
					'bing_site_verify'   => 'msvalidate.01',		// Microsoft Bing Website Verification ID.
					'pin_site_verify'    => 'p:domain_verify',		// Pinterest Website Verification ID.
					'yandex_site_verify' => 'yandex-verification',		// Yandex Website Verification ID.
				),
			),

			/**
			 * Update manager config.
			 */
			'um' => array(
				'rec_version' => '4.9.0',	// Minimum update manager version (soft limit).
				'check_hours' => array(
					24  => 'Every day',
					48  => 'Every two days',
					72  => 'Every three days',
					96  => 'Every four days',
					120 => 'Every five days',
					144 => 'Every six days',
					168 => 'Every week',
					336 => 'Every two weeks',
				),
				'version_filter' => array(
					'dev'    => 'Development and Up',
					'alpha'  => 'Alpha and Up',
					'beta'   => 'Beta and Up',
					'rc'     => 'Release Candidate and Up',
					'stable' => 'Stable / Production',
				),
				'version_regex' => array(
					'dev'    => '/^[0-9][0-9\.\-]+((dev|a|alpha|b|beta|rc)[0-9\.\-]+)?$/',
					'alpha'  => '/^[0-9][0-9\.\-]+((a|alpha|b|beta|rc)[0-9\.\-]+)?$/',
					'beta'   => '/^[0-9][0-9\.\-]+((b|beta|rc)[0-9\.\-]+)?$/',
					'rc'     => '/^[0-9][0-9\.\-]+((rc)[0-9\.\-]+)?$/',
					'stable' => '/^[0-9][0-9\.\-]+$/',
				),
			),

			/**
			 * PHP config.
			 */
			'php' => array(
				'label'       => 'PHP',
				'min_version' => '7.0',		// Hard limit - deactivate the plugin when activating.
				'rec_version' => '7.2.34',	// Soft limit - issue warning if lower version found.
				'version_url' => 'https://www.php.net/supported-versions.php',
				'extensions'  => array(
					'curl' => array(	// PHP extension name.
						'label' => 'Client URL Library (cURL)',
						'url'   => 'https://www.php.net/manual/en/book.curl.php',
					),
					'dom' => array(		// PHP extension name.
						'label' => 'Document Object Model',
						'url'   => 'https://www.php.net/manual/en/book.dom.php',
						'classes' => array(	// Extra checks to make sure the PHP extension is complete.
							'DOMDocument',
						),
					),
					'gd' => array(		// PHP extension name.
						'label' => 'Image Processing (GD)',
						'url'   => 'https://www.php.net/manual/en/book.image.php',
						'wp_image_editor' => array(
							'class' => 'WP_Image_Editor_GD',
							'url'   => 'https://developer.wordpress.org/reference/classes/wp_image_editor_gd/',
						),
					),
					'json' => array(	// PHP extension name.
						'label' => 'JavaScript Object Notation (JSON)',
						'url'   => 'https://www.php.net/manual/en/book.json.php',
					),
					'libxml' => array(	// PHP extension name.
						'label' => 'libxml',
						'url'   => 'https://www.php.net/manual/en/book.libxml.php',
						'functions' => array(	// Extra checks to make sure the PHP extension is complete.
							'libxml_use_internal_errors',
						),
					),
					'mbstring' => array(	// PHP extension name.
						'label' => 'Multibyte String',
						'url'   => 'https://www.php.net/manual/en/book.mbstring.php',
						'functions' => array(	// Extra checks to make sure the PHP extension is complete.
							'mb_convert_encoding',
							'mb_decode_numericentity',
							'mb_detect_encoding',
							'mb_strlen',
							'mb_strtolower',
							'mb_substr',
						),
					),
					'simplexml' => array(	// PHP extension name.
						'label' => 'SimpleXML',
						'url'   => 'https://www.php.net/manual/en/book.simplexml.php',
						'functions' => array(	// Extra checks to make sure the PHP extension is complete.
							'simplexml_load_string',
						),
					),
					'xml' => array(		// PHP extension name.
						'label' => 'XML Parser',
						'url'   => 'https://www.php.net/manual/en/book.xml.php',
						'functions' => array(	// Extra checks to make sure the PHP extension is complete.
							'utf8_encode',
						),
					),
				),
			),

			/**
			 * WordPress config.
			 *
			 * Requires: WordPress v5.0 (December 6, 2018).
			 * Recommends: WordPress v5.7.2 (May 12, 2021).
			 */
			'wp' => array(
				'label'       => 'WordPress',
				'min_version' => '5.0',		// Hard limit - deactivate the plugin when activating.
				'rec_version' => '5.7.2',	// Soft limit - issue warning if lower version found.
				'version_url' => 'https://codex.wordpress.org/Supported_Versions?nocache=1',
				'tb_iframe'   => array(		// Thickbox iframe.
					'width'  => 772,	// Url query argument.
					'height' => 550,	// Url query argument.
				),
				'cm_names' => array(
					'aim'    => 'AIM',
					'jabber' => 'Google Talk',
					'yim'    => 'Yahoo Messenger',
				),
				'admin' => array(
					'dashboard' => array(
						'page' => 'index.php',
						'cap'  => 'manage_options',
					),
					'plugins' => array(
						'page' => 'plugins.php',
						'cap'  => 'install_plugins',
					),
					'profile' => array(
						'page' => 'profile.php',
						'cap'  => 'publish_posts',
					),
					'settings' => array(
						'page' => 'options-general.php',
						'cap'  => 'manage_options',
					),
					'sitesubmenu' => array(
						'page' => 'admin.php',
						'cap'  => 'manage_options',
					),
					'submenu' => array(
						'page' => 'admin.php',
						'cap'  => 'manage_options',
					),
					'tools' => array(
						'page' => 'tools.php',
						'cap'  => 'manage_options',
					),
					'users' => array(
						'page' => 'users.php',
						'cap'  => 'list_users',
						'sub'  => array(
							'add-person' => array(
								'cap' => 'create_users',
								'pos' => 2,
							),
						),
					),
				),
				'roles' => array(
					'all' => array(
						'administrator',
						'editor',
						'author',
						'contributor',
						'subscriber',
					),
					'creator' => array(	// Users that can create content.
						'administrator',
						'editor',
						'author',
						'contributor',
					),
					'publisher' => array(	// Users that can publish content.
						'administrator',
						'editor',
						'author',
					),
					'owner' => array(	// Users that can manage content (edit, publish, delete, etc.).
						'administrator',
						'editor',
					),
					'admin' => array(
						'administrator',
					),
					'person' => array(	// Users for Schema Person select.
						'person',
					),
				),
				'transient' => array(

					/**
					 * Preserved on clear cache.
					 */
					'wpsso_!_' => array(
					),
					'wpsso_h_' => array(
						'label'  => 'Head Markup',
						'value'  => WEEK_IN_SECONDS,
						'filter' => 'wpsso_cache_expire_head_markup',

						/**
						 * If one of these $mod array conditions is true, then use the associated value.
						 */
						'conditional_values' => array(
							'is_404'        => 0,
							'is_attachment' => 0,
							'is_date'       => 0,
							'is_search'     => 0,
						),
					),
					'wpsso_i_' => array(
						'label'  => 'Image URL Info',
						'value'  => DAY_IN_SECONDS,
						'filter' => 'wpsso_cache_expire_image_info',
					),
					'wpsso_r_' => array(
						'label'  => 'API Response',
						'value'  => HOUR_IN_SECONDS,
						'filter' => 'wpsso_cache_expire_api_response',
					),
					'wpsso_s_' => array(
						'label'  => 'Short URLs',
						'value'  => YEAR_IN_SECONDS,
						'filter' => 'wpsso_cache_expire_short_url',
					),
					'wpsso_t_' => array(
						'label'  => 'Schema Indexes',
						'value'  => MONTH_IN_SECONDS,
						'filter' => 'wpsso_cache_expire_schema_types',
					),
					'wpsso_' => array(
						'label' => 'All Transients',
					),
				),
				'wp_cache' => array(
					'wpsso_c_' => array(
						'label'   => 'Filtered Content',
						'value'   => HOUR_IN_SECONDS,
						'filter'  => 'wpsso_cache_expire_the_content',
					),
					'wpsso_' => array(
						'label' => 'All WP Objects',
					),
				),
			),
			'jquery-qtip' => array(			// http://qtip2.com/download
				'label'   => 'jQuery qTip',
				'version' => '3.0.3',
			),
			'jquery-ui' => array(			// https://developers.google.com/speed/libraries/
				'label'   => 'jQuery UI',
				'version' => '1.12.1',
			),
			'menu' => array(
				'title'     => 'SSO (Social and Search Optimization)',	// Menu title.
				'icon-font' => 'WpssoIcons',				// Icon font family.
				'icon-code' => '\e81e',					// Icon CSS code.
				'dashicons' => array(
					'add-person'     => 'admin-users',
					'addons'         => 'admin-plugins',
					'advanced'       => 'superhero',
					'essential'      => 'star-filled',
					'features'       => 'yes-alt',
					'general'        => 'admin-settings',
					'licenses'       => 'admin-network',
					'dashboard'      => 'dashboard',
					'setup'          => 'welcome-learn-more',
					'social-pages'   => 'share',
					'tools'          => 'admin-tools',
					'site-addons'    => 'admin-plugins',
					'site-licenses'  => 'admin-network',
					'site-setup'     => 'welcome-learn-more',
					'your-sso'       => 'id-alt',
					'*'              => 'admin-generic',	// Default icon.
				),
			),
			'notice' => array(
				'title'     => 'SSO',					// Notice title.
				'icon-font' => 'WpssoIcons',				// Icon font family.
				'icon-code' => '\e81d',					// Icon CSS code.
				'css-class' => array(					// Used by WpssoStyle->add_admin_page_style().
					'update-nag' => array(				// CSS class name.
						'color'            => '#144e14',	// CSS property name and value.
						'border-width'     => '1px',
						'border-style'     => 'solid',
						'border-color'     => '#33cc33',
						'background-color' => '#e0f7e0',
					),
					'update-nag a' => array(
						'color' => '#1f7e1f',
					),
					'update-nag a:active' => array(
						'color' => '#279d27',
					),
					'update-nag a:hover' => array(
						'color' => '#279d27',
					),
				),
			),
			'meta' => array(			// Post, term, user add_meta_box() settings.
				'id'    => 'sso',
				'title' => 'Document SSO',
			),
			'edit' => array(			// Post, term, user lists.
				'columns' => array(
					'schema_type' => array(
						'header'   => 'Schema',
						'mt_name'  => 'schema:type:id',
						'meta_key' => '_wpsso_head_info_schema_type',
						'orderby'  => 'meta_value',
						'width'    => '8em',
						'height'   => 'auto',
					),
					'og_type' => array(
						'header'   => 'Open Graph',
						'mt_name'  => 'og:type',
						'meta_key' => '_wpsso_head_info_og_type',
						'orderby'  => 'meta_value',
						'width'    => '8em',
						'height'   => 'auto',
					),
					'og_img' => array(
						'header'    => 'SSO Image',
						'mt_name'   => 'og:image',
						'meta_key'  => '_wpsso_head_info_og_img_thumb',
						'localized' => true,
						'orderby'   => false,	// Do not offer column sorting.
						'width'     => '75px',
						'height'    => '40px',
					),
					'og_desc' => array(
						'header'   => 'SSO Description',
						'mt_name'  => 'og:description',
						'meta_key' => '_wpsso_head_info_og_desc',
						'localized' => true,
						'orderby'  => false,	// Do not offer column sorting.
						'width'    => '160px',
						'height'   => 'auto',
					),
				),
			),
			'form' => array(
				'max_hashtags'    => 5,
				'max_media_items' => 10,
				'tooltip_class'   => 'sucom-tooltip',
				'yes_no' => array(
					1 => 'Yes',
					0 => 'No',
				),
				'true_false' => array(
					1 => 'True',
					0 => 'False',
				),
				'on_off' => array(
					1 => 'On',
					0 => 'Off',
				),
				'weekdays' => array(
					'sunday'         => 'Sunday',
					'monday'         => 'Monday',
					'tuesday'        => 'Tuesday',
					'wednesday'      => 'Wednesday',
					'thursday'       => 'Thursday',
					'friday'         => 'Friday',
					'saturday'       => 'Saturday',
					'publicholidays' => 'Public Holidays',
				),
				'time_seconds' => array(
					'hour'  => HOUR_IN_SECONDS,
					'day'   => DAY_IN_SECONDS,
					'week'  => WEEK_IN_SECONDS,
					'month' => MONTH_IN_SECONDS,
					'year'  => YEAR_IN_SECONDS,
				),
				'time_text' => array(
					'hour'  => 'Hour',
					'day'   => 'Day',
					'week'  => 'Week',
					'month' => 'Month',
					'year'  => 'Year',
				),
				'qualifiers' => array(
					'default'    => '(default)',
					'no_images'  => '(no images)',
					'no_videos'  => '(no videos)',
					'settings'   => '(settings value)',
					'disabled'   => '(option disabled)',
					'default_is' => 'default is %s',
					'checked'    => 'checked',
					'unchecked'  => 'unchecked',
					'at'         => 'at',
					'tz'         => 'tz',
				),
				'document_title' => array(	// Webpage Document Title.
					'wp_title'         => '[WordPress Title]',
					'og_title'         => 'Document SSO Default Title',
					'schema_title'     => 'Document SSO Schema Name / Title',
					'schema_title_alt' => 'Document SSO Schema Alternate Name',
				),
				'notice_systems' => array(
					'toolbar_notices' => 'SSO Toolbar Notices',
					'admin_notices'   => 'WP Admin Notices',
				),
				'show_options' => array(
					'basic' => 'Basic Options',
					'all'   => 'All Options',
				),
				'site_option_use' => array(
					'default' => 'New Activation',
					'empty'   => 'If Empty',
					'force'   => 'Always',
				),
				'script_locations' => array(
					'none'   => '[None]',
					'header' => 'Header',
					'footer' => 'Footer',
				),
				'caption_types' => array(
					'none'    => '[None]',
					'title'   => 'Title Only',
					'excerpt' => 'Excerpt Only',
					'both'    => 'Title and Excerpt',
				),
				'author_types' => array(
					'none'         => '[None]',
					'organization' => 'Organization',
					'person'       => 'Person',
				),
				'publisher_types' => array(
					'organization' => 'Organization',
					'person'       => 'Person',
				),
				'user_name_fields' => array(
					'none'         => '[None]',
					'fullname'     => 'First and Last Names',
					'display_name' => 'Display Name',
					'nickname'     => 'Nickname',
				),
				'addr_select' => array(
					'none'   => '[None]',
					'custom' => '[Custom Address]',
					'new'    => '[New Address]',
				),
				'org_select' => array(
					'none' => '[None]',
					'new'  => '[New Organization]',
					'site' => '[WebSite Organization]',
				),
				'place_select' => array(
					'none'   => '[None]',
					'custom' => '[Custom Place]',
					'new'    => '[New Place]',
				),

				/**
				 * Image preferred cropping.
				 */
				'position_crop_x' => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				),
				'position_crop_y' => array(
					'top' => 'Top',
					'center' => 'Center',
					'bottom' => 'Bottom',
				),

				/**
				 * Robots meta.
				 */
				'robots_max_image_preview' => array(
					'none'     => '[None]',
					'standard' => 'Standard',
					'large'    => 'Large',
				),

				/**
				 * Breadcrumbs settings.
				 */
				'breadcrumbs_for_posts' => array(	// Breadcrumbs by Post Type.
					'none'        => '[No Breadcrumbs]',
					'categories'  => 'Home Page(s) and Categories',
					'ancestors'   => 'Home Page(s) and Parents',
					'primary_cat' => 'Home Page(s) and Primary Category',
				),
				'breadcrumbs_for_terms' => array(	// Breadcrumbs by Taxonomy.
					'none'      => '[No Breadcrumbs]',
					'ancestors' => 'Home Page(s) and Parents',
				),

				/**
				 * Shortening service.
				 */
				'shorteners' => array(
					'none'    => '[None]',
					'bitly'   => 'Bitly',		// Requires lib/pro/com/bitly.php.
					'dlmyapp' => 'DLMY.App',	// Requires lib/pro/ext/dlmy.php.
					'owly'    => 'Ow.ly',		// Requires lib/pro/ext/owly.php.
					'tinyurl' => 'TinyURL',		// Requires lib/pro/ext/tinyurl.php.
					'yourls'  => 'YOURLS',		// Requires lib/pro/ext/yourls.php.
				),

				/**
				 * Ratings and reviews services.
				 */
				'ratings_reviews' => array(
					'none'            => '[None]',
					'shopperapproved' => 'Shopper Approved',
					'stamped'         => 'Stamped.io',
				),

				/**
				 * Social account keys and labels for Organization SameAs.
				 */
				'social_accounts' => array(
					'behance_publisher_url'   => 'Behance Business Profile URL',
					'fb_publisher_url'        => 'Facebook Business Page URL',
					'instagram_publisher_url' => 'Instagram Business Profile URL',
					'linkedin_publisher_url'  => 'LinkedIn Business Page URL',
					'medium_publisher_url'    => 'Medium Business Page URL',
					'myspace_publisher_url'   => 'Myspace Business Page URL',
					'pin_publisher_url'       => 'Pinterest Business Page URL',
					'sc_publisher_url'        => 'Soundcloud Business Page URL',
					'tiktok_publisher_url'    => 'TikTok Business Page URL',
					'tumblr_publisher_url'    => 'Tumblr Business Page URL',
					'tc_site'                 => 'Twitter Business @username',
					'wikipedia_publisher_url' => 'Wikipedia Organization Page URL',
					'yt_publisher_url'        => 'YouTube Business Channel URL',
				),

				'embed_media_apis' => array(
					'plugin_facebook_api'   => 'Facebook Videos',
					'plugin_slideshare_api' => 'Slideshare Presentations',
					'plugin_soundcloud_api' => 'Soundcloud Tracks',
					'plugin_vimeo_api'      => 'Vimeo Videos',
					'plugin_wistia_api'     => 'Wistia Videos',
					'plugin_wpvideo_api'    => 'WordPress Video Shortcode',
					'plugin_youtube_api'    => 'YouTube Videos and Playlists',
				),

				/**
				 * Custom field option labels.
				 */
				'cf_labels' => array(
					'plugin_cf_addl_type_urls'             => 'Microdata Type URLs Custom Field',
					'plugin_cf_book_isbn'                  => 'Book ISBN Custom Field',
					'plugin_cf_howto_steps'                => 'How-To Steps Custom Field',
					'plugin_cf_howto_supplies'             => 'How-To Supplies Custom Field',
					'plugin_cf_howto_tools'                => 'How-To Tools Custom Field',
					'plugin_cf_img_url'                    => 'Image URL Custom Field',
					'plugin_cf_product_avail'              => 'Product Availability Custom Field',
					'plugin_cf_product_brand'              => 'Product Brand Custom Field',
					'plugin_cf_product_category'           => 'Product Type ID Custom Field',
					'plugin_cf_product_color'              => 'Product Color Custom Field',
					'plugin_cf_product_condition'          => 'Product Condition Custom Field',
					'plugin_cf_product_currency'           => 'Product Currency Custom Field',
					'plugin_cf_product_depth_value'        => 'Product Depth Custom Field',
					'plugin_cf_product_fluid_volume_value' => 'Product Fluid Volume Custom Field',
					'plugin_cf_product_gtin14'             => 'Product GTIN-14 Custom Field',
					'plugin_cf_product_gtin13'             => 'Product GTIN-13 (EAN) Custom Field',
					'plugin_cf_product_gtin12'             => 'Product GTIN-12 (UPC) Custom Field',
					'plugin_cf_product_gtin8'              => 'Product GTIN-8 Custom Field',
					'plugin_cf_product_gtin'               => 'Product GTIN Custom Field',
					'plugin_cf_product_height_value'       => 'Product Height Custom Field',
					'plugin_cf_product_isbn'               => 'Product ISBN Custom Field',
					'plugin_cf_product_length_value'       => 'Product Length Custom Field',
					'plugin_cf_product_material'           => 'Product Material Custom Field',
					'plugin_cf_product_mfr_part_no'        => 'Product MPN Custom Field',
					'plugin_cf_product_price'              => 'Product Price Custom Field',
					'plugin_cf_product_size'               => 'Product Size Custom Field',
					'plugin_cf_product_retailer_part_no'   => 'Product SKU Custom Field',
					'plugin_cf_product_target_gender'      => 'Product Target Gender Custom Field',
					'plugin_cf_product_weight_value'       => 'Product Weight Custom Field',
					'plugin_cf_product_width_value'        => 'Product Width Custom Field',
					'plugin_cf_recipe_ingredients'         => 'Recipe Ingredients Custom Field',
					'plugin_cf_recipe_instructions'        => 'Recipe Instructions Custom Field',
					'plugin_cf_sameas_urls'                => 'Same-As URLs Custom Field',
					'plugin_cf_vid_url'                    => 'Video URL Custom Field',
					'plugin_cf_vid_embed'                  => 'Video Embed HTML Custom Field',
				),

				/**
				 * Attribute option labels.
				 */
				'attr_labels' => array(
					'plugin_attr_product_brand'              => 'Brand Attribute Name',
					'plugin_attr_product_color'              => 'Color Attribute Name',
					'plugin_attr_product_condition'          => 'Condition Attribute Name',
					'plugin_attr_product_depth_value'        => 'Depth Attribute Name',
					'plugin_attr_product_fluid_volume_value' => 'Fluid Volume Attribute Name',
					'plugin_attr_product_gtin14'             => 'GTIN-14 Attribute Name',
					'plugin_attr_product_gtin13'             => 'GTIN-13 (EAN) Attribute Name',
					'plugin_attr_product_gtin12'             => 'GTIN-12 (UPC) Attribute Name',
					'plugin_attr_product_gtin8'              => 'GTIN-8 Attribute Name',
					'plugin_attr_product_gtin'               => 'GTIN Attribute Name',
					'plugin_attr_product_isbn'               => 'ISBN Attribute Name',
					'plugin_attr_product_material'           => 'Material Attribute Name',
					'plugin_attr_product_mfr_part_no'        => 'MPN Attribute Name',
					'plugin_attr_product_size'               => 'Size Attribute Name',
					'plugin_attr_product_target_gender'      => 'Target Gender Attribute Name',
				),

				/**
				 * Validated on 2020/08/17.
				 *
				 * See https://developers.facebook.com/docs/marketing-api/catalog/reference/#og-tags.
				 *
				 * Optional for dynamic ads. N/A for commerce. Age group associated to the item. Accepted values:
				 * adult, all ages, teen, kids, toddler, infant, newborn.
				 */
				'age_group' => array(
					'none'     => '[None]',
					'adult'    => 'Adult',
					'all ages' => 'All Ages',
					'teen'     => 'Teen',
					'kids'     => 'Kids',
					'toddler'  => 'Toddler',
					'infant'   => 'Infant',
					'newborn'  => 'Newborn',
				),

				/**
				 * Validated on 2020/08/17.
				 *
				 * See https://schema.org/suggestedGender.
				 *
				 * See https://developers.facebook.com/docs/marketing-api/catalog/reference/#og-tags.
				 *
				 * Optional for dynamic ads. Required for commerce. Determines gender for sizing. Supported values:
				 * female, male, unisex.
				 */
				'audience_gender' => array(
					'none'   => '[None]',
					'male'   => 'Male',
					'female' => 'Female',
					'unisex' => 'Unisex',
				),

				/**
				 * A Schema enumerated value.
				 *
				 * See https://schema.org/BookFormatType.
				 */
				'book_format' => array(
					'none'                               => '[None]',
					'https://schema.org/AudiobookFormat' => 'Audiobook',
					'https://schema.org/EBook'           => 'eBook',
					'https://schema.org/GraphicNovel'    => 'Graphic Novel',
					'https://schema.org/Hardcover'       => 'Hardcover',
					'https://schema.org/Paperback '      => 'Paperback',
				),

				/**
				 * Validated on 2020/08/17.
				 *
				 * See https://developers.google.com/search/docs/data-types/job-postings.
				 */
				'employment_type' => array(
					'none'       => '[None]',
					'FULL_TIME'  => 'Full Time',
					'PART_TIME'  => 'Part Time',
					'CONTRACTOR' => 'Contractor',
					'TEMPORARY'  => 'Temporary',
					'INTERN'     => 'Intern',
					'VOLUNTEER'  => 'Volunteer',
					'PER_DIEM'   => 'Per Diem',
					'OTHER'      => 'Other',
				),

				/**
				 * A Schema enumerated value.
				 *
				 * See https://schema.org/EventAttendanceModeEnumeration.
				 */
				'event_attendance' => array(
					'none'                                          => '[None]',
					'https://schema.org/MixedEventAttendanceMode'   => 'Mixed',
					'https://schema.org/OnlineEventAttendanceMode'  => 'Online',
					'https://schema.org/OfflineEventAttendanceMode' => 'Physical Location',	// Default.
				),

				/**
				 * A Schema enumerated value.
				 *
				 * See https://schema.org/EventStatusType.
				 */
				'event_status' => array(	
					'none'                                => '[None]',
					'https://schema.org/EventCancelled'   => 'Cancelled',
					'https://schema.org/EventMovedOnline' => 'Moved Online',
					'https://schema.org/EventPostponed'   => 'Postponed',
					'https://schema.org/EventRescheduled' => 'Rescheduled',
					'https://schema.org/EventScheduled'   => 'Scheduled',	// Default.
				),

				/**
				 * A Schema enumerated value.
				 *
				 * See https://schema.org/ItemAvailability.
				 */
				'item_availability' => array(
					'none'                                   => '[None]',
			 		'https://schema.org/BackOrder'           => 'Back Order',	// Indicates that the item is available on back order.
			 		'https://schema.org/Discontinued'        => 'Discontinued',
			 		'https://schema.org/InStock'             => 'In Stock',
			 		'https://schema.org/InStoreOnly'         => 'In Store Only',
			 		'https://schema.org/LimitedAvailability' => 'Limited Availability',
			 		'https://schema.org/OnlineOnly'          => 'Online Only',
			 		'https://schema.org/OutOfStock'          => 'Out Of Stock',
			 		'https://schema.org/PreOrder'            => 'Pre-Order',
			 		'https://schema.org/PreSale'             => 'Pre-Sale',
			 		'https://schema.org/SoldOut'             => 'Sold Out',
				),

				/**
				 * A Schema enumerated value.
				 *
				 * See https://schema.org/OfferItemCondition.
				 */
				'item_condition' => array(
					'none'                                    => '[None]',
					'https://schema.org/DamagedCondition'     => 'Damaged',
					'https://schema.org/NewCondition'         => 'New',
					'https://schema.org/RefurbishedCondition' => 'Refurbished',
					'https://schema.org/UsedCondition'        => 'Used',
				),

				/**
				 * Validated on 2021/04/15.
				 *
				 * See https://developers.google.com/search/docs/data-types/job-postings.
				 */
				'job_location_type' => array(
					'none'        => '[None]',
					'TELECOMMUTE' => 'Telecommute (100% Remote)',
				),
			),
			'head' => array(
				'limit' => array(
					'schema_1x1_img_ratio'  => 1.000,
					'schema_4x3_img_ratio'  => 1.333,
					'schema_16x9_img_ratio' => 1.778,
				),
				'limit_min' => array(
					'og_desc_len'            => 160,
					'og_img_width'           => 200,
					'og_img_height'          => 200,
					'schema_1x1_img_width'   => 1200,
					'schema_1x1_img_height'  => 1200,
					'schema_4x3_img_width'   => 1200,
					'schema_4x3_img_height'  => 900,
					'schema_16x9_img_width'  => 1200,
					'schema_16x9_img_height' => 675,
					'schema_desc_len'        => 156,
					'seo_desc_len'           => 156,
					'tc_desc_len'            => 160,
					'thumb_img_width'        => 300,
					'thumb_img_height'       => 200,
				),
				'limit_max' => array(
					'og_img_ratio'        => 3.000,
					'schema_headline_len' => 110,
				),

				/**
				 * Hard-code the Open Graph type based on the WordPress post type.
				 *
				 * Example, if the post type is 'product', hard-code the Open Graph type to 'product'.
				 */
				'og_type_by_post_type' => array(
					'book'         => 'book',
					'download'     => 'product',
					'organization' => 'website',
					'place'        => 'place',
					'product'      => 'product',
					'profile'      => 'profile',
					'question'     => 'article',
				),

				/**
				 * Hard-code the Open Graph type based on the Schema type.
				 *
				 * Example, if the Schema type is 'product', hard-code the Open Graph type to 'product'.
				 */
				'og_type_by_schema_type' => array(
					'article'              => 'article',
					'book'                 => 'book',
					'place'                => 'place',	// Check for Schema place before Schema organization.
					'organization'         => 'website',	// Check for Schema place before Schema organization.
					'product'              => 'product',
					'question'             => 'article',
					'review'               => 'article',
					'software.application' => 'product',
					'webpage.profile'      => 'profile',
				),

				'og_type_ns' => array(		// See https://ogp.me/#types.
					'article'             => 'https://ogp.me/ns/article#',
					'book'                => 'https://ogp.me/ns/book#',
					'books.author'        => 'https://ogp.me/ns/books#',
					'books.book'          => 'https://ogp.me/ns/books#',
					'books.genre'         => 'https://ogp.me/ns/books#',
					'business.business'   => 'https://ogp.me/ns/business#',
					'music.album'         => 'https://ogp.me/ns/music#',
					'music.playlist'      => 'https://ogp.me/ns/music#',
					'music.radio_station' => 'https://ogp.me/ns/music#',
					'music.song'          => 'https://ogp.me/ns/music#',
					'place'               => 'https://ogp.me/ns/place#',	// Supported by Facebook and Pinterest.
					'product'             => 'https://ogp.me/ns/product#',	// Supported by Facebook and Pinterest.
					'profile'             => 'https://ogp.me/ns/profile#',
					'video.episode'       => 'https://ogp.me/ns/video#',
					'video.movie'         => 'https://ogp.me/ns/video#',
					'video.other'         => 'https://ogp.me/ns/video#',
					'video.tv_show'       => 'https://ogp.me/ns/video#',
					'website'             => 'https://ogp.me/ns/website#',
				),
				'og_type_ns_compat' => array(
					'article'             => 'https://ogp.me/ns/article#',
					'book'                => 'https://ogp.me/ns/book#',
					'place'               => 'https://ogp.me/ns/place#',	// Supported by Facebook and Pinterest.
					'product'             => 'https://ogp.me/ns/product#',	// Supported by Facebook and Pinterest.
					'profile'             => 'https://ogp.me/ns/profile#',
					'website'             => 'https://ogp.me/ns/website#',
				),

				/**
				 * See https://developers.facebook.com/docs/reference/opengraph/.
				 */
				'og_type_mt' => array(

					/**
					 * See https://developers.facebook.com/docs/reference/opengraph/object-type/article/.
					 */
					'article' => array(
						'article:author'          => '',		// An array of Facebook profile URLs or IDs of the authors for this article.
						'article:publisher'       => '',		// A Facebook page URL or ID of the publishing entity.
						'article:published_time'  => '',
						'article:modified_time'   => '',
						'article:expiration_time' => '',
						'article:section'         => 'article_section',
						'article:tag'             => '',		// An array of keywords relevant to the article.
					),
					'book' => array(
						'book:author'       => '',
						'book:isbn'         => 'book_isbn',
						'book:release_date' => '',
						'book:tag'          => '',
					),
					'books.author' => array(
						'books:book'          => '',
						'books:gender'        => '',
						'books:genre'         => '',
						'books:official_site' => '',
					),
					'books.book' => array(
						'books:author'                  => '',
						'books:genre'                   => '',
						'books:initial_release_date'    => '',
						'books:isbn'                    => '',
						'books:language:locale'         => '',
						'books:language:alternate'      => '',
						'books:page_count'              => '',
						'books:rating:value'            => '',
						'books:rating:scale'            => '',
						'books:rating:normalized_value' => '',
						'books:release_date'            => '',
						'books:sample'                  => '',
					),
					'books.genre' => array(
						'books:author'         => '',
						'books:book'           => '',
						'books:canonical_name' => '',
					),
					'business.business' => array(
						'business:contact_data:street_address' => '',
						'business:contact_data:locality'       => '',
						'business:contact_data:region'         => '',
						'business:contact_data:postal_code'    => '',
						'business:contact_data:country_name'   => '',
						'business:contact_data:email'          => '',
						'business:contact_data:phone_number'   => '',
						'business:contact_data:phone_number'   => '',
						'business:contact_data:website'        => '',
						'business:hours:day'                   => '',
						'business:hours:start'                 => '',
						'business:hours:end'                   => '',
					),
					'music.album' => array(
						'music:song'         => '',
						'music:song:disc'    => '',
						'music:song:track'   => '',
						'music:musician'     => '',
						'music:release_date' => '',
					),
					'music.playlist' => array(
						'music:creator'    => '',
						'music:song'       => '',
						'music:song:disc'  => '',
						'music:song:track' => '',
					),
					'music.radio_station' => array(
						'music:creator' => '',
					),
					'music.song' => array(
						'music:album'       => '',
						'music:album:disc'  => '',
						'music:album:track' => '',
						'music:duration'    => '',
						'music:musician'    => '',
					),
					'place' => array(
						'place:location:latitude'  => '',
						'place:location:longitude' => '',
						'place:location:altitude'  => '',
						'place:street_address'     => '',
						'place:locality'           => '',
						'place:region'             => '',
						'place:postal_code'        => '',
						'place:country_name'       => '',
					),

					/**
					 * See https://developers.facebook.com/docs/marketing-api/catalog/reference/.
					 */
					'product' => array(
						'product:age_group'               => '',
						'product:availability'            => 'product_avail',
						'product:brand'                   => 'product_brand',
						'product:category'                => 'product_category',
						'product:color'                   => 'product_color',
						'product:condition'               => 'product_condition',
						'product:depth:value'             => 'product_depth_value',	// Non-standard / internal meta tag.
						'product:depth:units'             => '',			// Non-standard / internal meta tag.
						'product:ean'                     => 'product_gtin13',
						'product:expiration_time'         => '',
						'product:gtin14'                  => 'product_gtin14',		// Non-standard / internal meta tag.
						'product:gtin13'                  => 'product_gtin13',		// Non-standard / internal meta tag.
						'product:gtin12'                  => 'product_gtin12',		// Non-standard / internal meta tag.
						'product:gtin8'                   => 'product_gtin8',		// Non-standard / internal meta tag.
						'product:gtin'                    => 'product_gtin',		// Non-standard / internal meta tag.
						'product:height:value'            => 'product_height_value',	// Non-standard / internal meta tag.
						'product:height:units'            => '',			// Non-standard / internal meta tag.
						'product:is_product_shareable'    => '',
						'product:isbn'                    => 'product_isbn',
						'product:length:value'            => 'product_length_value',	// Non-standard / internal meta tag.
						'product:length:units'            => '',			// Non-standard / internal meta tag.
						'product:material'                => 'product_material',
						'product:mfr_part_no'             => 'product_mfr_part_no',	// Product MPN.
						'product:original_price:amount'   => '',			// Used by WooCommerce module.
						'product:original_price:currency' => '',			// Used by WooCommerce module.
						'product:pattern'                 => '',
						'product:plural_title'            => '',
						'product:pretax_price:amount'     => '',			// Used by WooCommerce module.
						'product:pretax_price:currency'   => '',			// Used by WooCommerce module.
						'product:price:amount'            => 'product_price',
						'product:price:currency'          => 'product_currency',
						'product:product_link'            => '',
						'product:purchase_limit'          => '',
						'product:retailer'                => '',
						'product:retailer_category'       => '',
						'product:retailer_item_id'        => '',				// Product ID. 
						'product:retailer_part_no'        => 'product_retailer_part_no',	// Product SKU.
						'product:retailer_title'          => '',
						'product:sale_price:amount'       => '',			// Used by WooCommerce module.
						'product:sale_price:currency'     => '',			// Used by WooCommerce module.
						'product:sale_price_dates:start'  => '',			// Used by WooCommerce module.
						'product:sale_price_dates:end'    => '',			// Used by WooCommerce module.
						'product:shipping_cost:amount'    => '',
						'product:shipping_cost:currency'  => '',
						'product:shipping_weight:value'   => '',
						'product:shipping_weight:units'   => '',
						'product:size'                    => 'product_size',
						'product:target_gender'           => 'product_target_gender',
						'product:upc'                     => 'product_gtin12',
						'product:fluid_volume:value'      => 'product_fluid_volume_value',	// Non-standard / internal meta tag.
						'product:fluid_volume:units'      => '',				// Non-standard / internal meta tag.
						'product:weight:value'            => 'product_weight_value',
						'product:weight:units'            => '',
						'product:width:value'             => 'product_width_value',	// Non-standard / internal meta tag.
						'product:width:units'             => '',			// Non-standard / internal meta tag.
					),
					'profile' => array(
						'profile:first_name' => '',
						'profile:last_name'  => '',
						'profile:username'   => '',
						'profile:gender'     => '',
					),
					'video.episode' => array(
						'video:actor'        => '',
						'video:actor:role'   => '',
						'video:director'     => '',
						'video:writer'       => '',
						'video:duration'     => '',
						'video:release_date' => '',
						'video:tag'          => '',
						'video:series'       => '',
					),
					'video.movie' => array(
						'video:actor'        => '',
						'video:actor:role'   => '',
						'video:director'     => '',
						'video:writer'       => '',
						'video:duration'     => '',
						'video:release_date' => '',
						'video:tag'          => '',
					),
					'video.other' => array(
						'video:actor'        => '',
						'video:actor:role'   => '',
						'video:director'     => '',
						'video:writer'       => '',
						'video:duration'     => '',
						'video:release_date' => '',
						'video:tag'          => '',
					),
					'video.tv_show' => array(
						'video:actor'        => '',
						'video:actor:role'   => '',
						'video:director'     => '',
						'video:writer'       => '',
						'video:duration'     => '',
						'video:release_date' => '',
						'video:tag'          => '',
					),
				),
				'og_content_map' => array(	// Element of 'head' array.

					/**
					 * Validated on 2021/07/22.
					 *
					 * See https://developers.facebook.com/docs/marketing-api/catalog/reference/#og-tags.
					 *
					 * Required. Current availability of the item: in stock, out of stock, available for order,
					 * discontinued. Supports pixel-based catalogs.
					 */
					'product:availability' => array(
				 		'https://schema.org/BackOrder'           => 'available for order',
				 		'https://schema.org/Discontinued'        => 'discontinued',
				 		'https://schema.org/InStock'             => 'in stock',
				 		'https://schema.org/InStoreOnly'         => 'in stock',
				 		'https://schema.org/LimitedAvailability' => 'in stock',
				 		'https://schema.org/OnlineOnly'          => 'in stock',
				 		'https://schema.org/OutOfStock'          => 'out of stock',
				 		'https://schema.org/PreOrder'            => 'available for order',
			 			'https://schema.org/PreSale'             => 'available for order',
				 		'https://schema.org/SoldOut'             => 'available for order',
					),

					/**
					 * Validated on 2020/08/17.
					 *
					 * See https://developers.facebook.com/docs/marketing-api/catalog/reference/#og-tags.
					 *
					 * Required. Current condition of the item: new, refurbished, used. Supports pixel-based
					 * catalogs.
					 */
					'product:condition' => array(
						'https://schema.org/DamagedCondition'     => 'used',
						'https://schema.org/NewCondition'         => 'new',
						'https://schema.org/RefurbishedCondition' => 'refurbished',
						'https://schema.org/UsedCondition'        => 'used',
					),
				),
				'schema_type' => array(				// Element of 'head' array.
					'thing' => array(			// Most generic type.
						'creative.work' => array(	// Creative work, including books, movies, photographs, software programs, etc.
							'answer'  => 'https://schema.org/Answer',
							'article' => array(
								'article'                    => 'https://schema.org/Article',
								'article.advertiser.content' => 'https://schema.org/AdvertiserContentArticle',
								'article.news'               => array(
									'article.news'            => 'https://schema.org/NewsArticle',
									'article.news.analysis'   => 'https://schema.org/AnalysisNewsArticle',
									'article.news.ask.public' => 'https://schema.org/AskPublicNewsArticle',
									'article.news.background' => 'https://schema.org/BackgroundNewsArticle',
									'article.news.opinion'    => 'https://schema.org/OpinionNewsArticle',
									'article.news.reportage'  => 'https://schema.org/ReportageNewsArticle',
									'article.news.review'     => 'https://schema.org/ReviewNewsArticle',
								),
								'article.satirical' => 'https://schema.org/SatiricalArticle',
								'article.scholarly' => array(
									'article.scholarly'         => 'https://schema.org/ScholarlyArticle',
									'article.scholarly.medical' => 'https://schema.org/MedicalScholarlyArticle',
								),
								'article.tech' => array(
									'article.tech'               => 'https://schema.org/TechArticle',
									'article.tech.reference.api' => 'https://schema.org/APIReference',
								),
								'report'               => 'https://schema.org/Report',
								'social.media.posting' => array(
									'blog.posting' => array(
										'blog.posting'      => 'https://schema.org/BlogPosting',
										'blog.posting.live' => 'https://schema.org/LiveBlogPosting',
									),
									'discussion.forum.posting' => 'https://schema.org/DiscussionForumPosting',
									'social.media.posting'     => 'https://schema.org/SocialMediaPosting',
								),
							),
							'blog' => 'https://schema.org/Blog',
							'book' => array(
								'book'       => 'https://schema.org/Book',
								'book.audio' => 'https://schema.org/Audiobook',
							),
							'claim'                => 'https://schema.org/Claim',
							'clip'                 => 'https://schema.org/Clip',
							'comment'              => 'https://schema.org/Comment',
							'conversation'         => 'https://schema.org/Conversation',
							'course'               => 'https://schema.org/Course',
							'creative.work'        => 'https://schema.org/CreativeWork',
							'creative.work.season' => 'https://schema.org/CreativeWorkSeason',
							'creative.work.series' => 'https://schema.org/CreativeWorkSeries',
							'data.catalog'         => 'https://schema.org/DataCatalog',
							'data.set'             => 'https://schema.org/DataSet',
							'digital.document'     => 'https://schema.org/DigitalDocument',
							'episode'              => array(
								'episode'         => 'https://schema.org/Episode',
								'episode.podcast' => 'https://schema.org/PodcastEpisode',
								'episode.radio'   => 'https://schema.org/RadioEpisode',
								'episode.tv'      => 'https://schema.org/TVEpisode',
							),
							'game'                 => array(
								'game'       => 'https://schema.org/Game',
								'video.game' => 'https://schema.org/VideoGame',
							),
							'how.to' => array(
								'how.to'  => 'https://schema.org/HowTo',
								'recipe' => 'https://schema.org/Recipe',	// Recipe is a sub-type of HowTo.
							),
							'map'          => 'https://schema.org/Map',
							'media.object' => array(
								'audio.object'       => array(
									'audio.object' => 'https://schema.org/AudioObject',
									'book.audio'   => 'https://schema.org/Audiobook',
								),
								'data.download'      => 'https://schema.org/DataDownload',
								'image.object'       => 'https://schema.org/ImageObject',
								'media.object'       => 'https://schema.org/MediaObject',
								'music.video.object' => 'https://schema.org/MusicVideoObject',
								'video.object'       => 'https://schema.org/VideoObject',
							),
							'menu'              => 'https://schema.org/Menu',
							'menu.section'      => 'https://schema.org/MenuSection',
							'message'           => 'https://schema.org/Message',
							'movie'             => 'https://schema.org/Movie',
							'music.composition' => 'https://schema.org/MusicComposition',
							'music.playlist'    => array(
								'music.album'    => 'https://schema.org/MusicAlbum',
								'music.playlist' => 'https://schema.org/MusicPlaylist',
								'music.release'  => 'https://schema.org/MusicRelease',
							),
							'music.recording'    => 'https://schema.org/MusicRecording',
							'painting'           => 'https://schema.org/Painting',
							'photograph'         => 'https://schema.org/Photograph',
							'publication.issue'  => 'https://schema.org/PublicationIssue',
							'publication.volume' => 'https://schema.org/PublicationVolume',
							'question'           => 'https://schema.org/Question',
							'review'             => array(
								'review'                => 'https://schema.org/Review',
								'review.claim'          => 'https://schema.org/ClaimReview',
								'review.critic'         => array(
									'review.critic'       => 'https://schema.org/CriticReview',
									'article.news.review' => 'https://schema.org/ReviewNewsArticle',
								),
								'review.employer'       => 'https://schema.org/EmployerReview',
								'review.media'          => 'https://schema.org/MediaReview',
								'review.recommendation' => 'https://schema.org/Recommendation',
								'review.user'           => 'https://schema.org/UserReview',
							),
							'sculpture'            => 'https://schema.org/Sculpture',
							'series'               => 'https://schema.org/Series',
							'software.application' => array( 
								'software.application'            => 'https://schema.org/SoftwareApplication',
								'software.application.mobile'     => 'https://schema.org/MobileApplication',
								'software.application.video.game' => 'https://schema.org/VideoGame',
								'software.application.web'        => 'https://schema.org/WebApplication',
							),
							'software.source.code' => 'https://schema.org/SoftwareSourceCode',
							'special.announcement' => 'https://schema.org/SpecialAnnouncement',
							'tv.season'            => 'https://schema.org/TVSeason',
							'tv.series'            => 'https://schema.org/TVSeries',
							'visual.artwork'       => 'https://schema.org/VisualArtwork',
							'webpage'              => array(
								'webpage'                => 'https://schema.org/WebPage',
								'webpage.about'          => 'https://schema.org/AboutPage',
								'webpage.checkout'       => 'https://schema.org/CheckoutPage',
								'webpage.collection'     => array(
									'webpage.collection'    => 'https://schema.org/CollectionPage',
									'webpage.gallery.image' => 'https://schema.org/ImageGallery',
									'webpage.gallery.video' => 'https://schema.org/VideoGallery',
								),
								'webpage.contact'             => 'https://schema.org/ContactPage',
								'webpage.faq'                 => 'https://schema.org/FAQPage',
								'webpage.item'                => 'https://schema.org/ItemPage',
								'webpage.medical'             => 'https://schema.org/MedicalWebPage',
								'webpage.profile'             => 'https://schema.org/ProfilePage',
								'webpage.qa'                  => 'https://schema.org/QAPage',
								'webpage.real.estate.listing' => 'https://schema.org/RealEstateListing',
								'webpage.search.results'      => 'https://schema.org/SearchResultsPage',
							),
							'webpage.element' => 'https://schema.org/WebPageElement',
							'website'         => 'https://schema.org/WebSite',
						),
						'event' => array(
							'event'             => 'https://schema.org/Event',
							'event.business'    => 'https://schema.org/BusinessEvent',
							'event.childrens'   => 'https://schema.org/ChildrensEvent',
							'event.comedy'      => 'https://schema.org/ComedyEvent',
							'event.dance'       => 'https://schema.org/DanceEvent',
							'event.delivery'    => 'https://schema.org/DeliveryEvent',
							'event.education'   => 'https://schema.org/EducationEvent',
							'event.exhibition'  => 'https://schema.org/ExhibitionEvent',
							'event.festival'    => 'https://schema.org/Festival',
							'event.food'        => 'https://schema.org/FoodEvent',
							'event.literary'    => 'https://schema.org/LiteraryEvent',
							'event.music'       => 'https://schema.org/MusicEvent',
							'event.publication' => 'https://schema.org/PublicationEvent',
							'event.sale'        => 'https://schema.org/SaleEvent',
							'event.screening'   => 'https://schema.org/ScreeningEvent',
							'event.social'      => 'https://schema.org/SocialEvent',
							'event.sports'      => 'https://schema.org/SportsEvent',
							'event.theater'     => 'https://schema.org/TheaterEvent',
							'event.visual.arts' => 'https://schema.org/VisualArtsEvent',
						),
						'intangible' => array(
							'alignment.object' => 'https://schema.org/AlignmentObject',
							'audience'         => array(
								'audience'             => 'https://schema.org/Audience',
								'audience.business'    => 'https://schema.org/BusinessAudience',
								'audience.educational' => 'https://schema.org/EducationalAudience',
								'audience.medical'     => 'https://schema.org/MedicalAudience',
								'audience.people'      => 'https://schema.org/PeopleAudience',
							),
							'bed.details'                 => 'https://schema.org/BedDetails',
							'brand'                       => 'https://schema.org/Brand',
							'broadcast.channel'           => 'https://schema.org/BroadcastChannel',
							'computer.language'           => 'https://schema.org/ComputerLanguage',
							'data.feed.item'              => 'https://schema.org/DataFeedItem',
							'demand'                      => 'https://schema.org/Demand',
							'digital.document.permission' => 'https://schema.org/DigitalDocumentPermission',
							'entry.point'                 => 'https://schema.org/EntryPoint',
							'enumeration'                 => array(
								'action.status.type'               => 'https://schema.org/ActionStatusType',
								'boarding.policy.type'             => 'https://schema.org/BoardingPolicyType',
								'book.format.type'                 => 'https://schema.org/BookFormatType',
								'business.entity.type'             => 'https://schema.org/BusinessEntityType',
								'business.function'                => 'https://schema.org/BusinessFunction',
								'contact.point.option'             => 'https://schema.org/ContactPointOption',
								'day.of.week'                      => 'https://schema.org/DayOfWeek',
								'delivery.method'                  => 'https://schema.org/DeliveryMethod',
								'digital.document.permission.type' => 'https://schema.org/DigitalDocumentPermissionType',
								'enumeration'                      => 'https://schema.org/Enumeration',
								'event.status.type'                => 'https://schema.org/EventStatusType',
								'game.play.mode'                   => 'https://schema.org/GamePlayMode',
								'game.server.status'               => 'https://schema.org/GameServerStatus',
								'gender.type'                      => 'https://schema.org/GenderType',
								'item.availability'                => 'https://schema.org/ItemAvailability',
								'item.list.order.type'             => 'https://schema.org/ItemListOrderType',
								'map.category.type'                => 'https://schema.org/MapCategoryType',
								'medical.enumeration' => array(
									'audience.medical'    => 'https://schema.org/MedicalAudience',
									'medical.enumeration' => 'https://schema.org/MedicalEnumeration',
									'medical.specialty'   => array( 
										'anesthesia.specialty'           => 'https://schema.org/Anesthesia',
										'cardiovascular.specialty'       => 'https://schema.org/Cardiovascular',
										'community.health.specialty'     => 'https://schema.org/CommunityHealth',
										'dentistry.specialty'            => 'https://schema.org/Dentistry',
										'dermatologic.specialty'         => 'https://schema.org/Dermatologic',
										'dermatology.specialty'          => 'https://schema.org/Dermatology',
										'diet.nutrition.specialty'       => 'https://schema.org/DietNutrition',
										'emergency.specialty'            => 'https://schema.org/Emergency',
										'endocrine.specialty'            => 'https://schema.org/Endocrine',
										'gastroenterologic.specialty'    => 'https://schema.org/Gastroenterologic',
										'genetic.specialty'              => 'https://schema.org/Genetic',
										'geriatric.specialty'            => 'https://schema.org/Geriatric',
										'gynecologic.specialty'          => 'https://schema.org/Gynecologic',
										'hematologic.specialty'          => 'https://schema.org/Hematologic',
										'infectious.specialty'           => 'https://schema.org/Infectious',
										'laboratory.science.specialty'   => 'https://schema.org/LaboratoryScience',
										'medical.specialty'              => 'https://schema.org/MedicalSpecialty',
										'midwifery.specialty'            => 'https://schema.org/Midwifery',
										'musculoskeletal.specialty'      => 'https://schema.org/Musculoskeletal',
										'neurologic.specialty'           => 'https://schema.org/Neurologic',
										'nursing.specialty'              => 'https://schema.org/Nursing',
										'obstetric.specialty'            => 'https://schema.org/Obstetric',
										'occupational.therapy.specialty' => 'https://schema.org/OccupationalTherapy',
										'oncologic.specialty'            => 'https://schema.org/Oncologic',
										'optometric.specialty'           => 'https://schema.org/Optometric',
										'otolaryngologic.specialty'      => 'https://schema.org/Otolaryngologic',
										'pathology.specialty'            => 'https://schema.org/Pathology',
										'pediatric.specialty'            => 'https://schema.org/Pediatric',
										'pharmacy.specialty'             => 'https://schema.org/PharmacySpecialty',
										'physiotherapy.specialty'        => 'https://schema.org/Physiotherapy',
										'plastic.surgery.specialty'      => 'https://schema.org/PlasticSurgery',
										'podiatric.specialty'            => 'https://schema.org/Podiatric',
										'primary.care.specialty'         => 'https://schema.org/PrimaryCare',
										'psychiatric.specialty'          => 'https://schema.org/Psychiatric',
										'public.health.specialty'        => 'https://schema.org/PublicHealth',
										'pulmonary.specialty'            => 'https://schema.org/Pulmonary',
										'radiography.specialty'          => 'https://schema.org/Radiography',
										'renal.specialty'                => 'https://schema.org/Renal',
										'respiratory.therapy.specialty'  => 'https://schema.org/RespiratoryTherapy',
										'rheumatologic.specialty'        => 'https://schema.org/Rheumatologic',
										'speech.pathology.specialty'     => 'https://schema.org/SpeechPathology',
										'surgical.specialty'             => 'https://schema.org/Surgical',
										'toxicologic.specialty'          => 'https://schema.org/Toxicologic',
										'urologic.specialty'             => 'https://schema.org/Urologic',
									),
									'medicine.system' => array(
										'ayurvedic.system'            => 'https://schema.org/Ayurvedic',
										'chiropractic.system'         => 'https://schema.org/Chiropractic',
										'homeopathic.system'          => 'https://schema.org/Homeopathic',
										'medicine.system'             => 'https://schema.org/MedicineSystem',
										'osteopathic.system'          => 'https://schema.org/Osteopathic',
										'traditional.chinese.system'  => 'https://schema.org/TraditionalChinese',
										'western.conventional.system' => 'https://schema.org/WesternConventional',
									),
								),
								'music.album.production.type'      => 'https://schema.org/MusicAlbumProductionType',
								'music.album.release.type'         => 'https://schema.org/MusicAlbumReleaseType',
								'music.release.format.type'        => 'https://schema.org/MusicReleaseFormatType',
								'offer.item.condition'             => 'https://schema.org/OfferItemCondition',
								'order.status'                     => 'https://schema.org/OrderStatus',
								'payment.method'                   => array(
									'payment.card' => array(
										'credit.card'  => 'https://schema.org/CreditCard',
										'payment.card' => 'https://schema.org/PaymentCard',
									),
									'payment.method' => 'https://schema.org/PaymentMethod',
								),
								'payment.status.type'              => 'https://schema.org/PaymentStatusType',
								'qualitative.value'                => 'https://schema.org/QualitativeValue',
								'reservation.status.type'          => 'https://schema.org/ReservationStatusType',
								'restricted.diet'                  => 'https://schema.org/RestrictedDiet',
								'rsvp.response.type'               => 'https://schema.org/RsvpResponseType',
								'specialty'                        => array(
									// 'medical.specialty' array added by WpssoSchema::add_schema_type_xrefs().
									'specialty'                 => 'https://schema.org/Specialty',
								),
								'warranty.scope' => 'https://schema.org/WarrantyScope',
							),
							'game.server' => 'https://schema.org/GameServer',
							'intangible'  => 'https://schema.org/Intangible',
							'invoice'     => 'https://schema.org/Invoice',
							'item.list'   => array(
								'breadcrumb.list' => 'https://schema.org/BreadcrumbList',
								'how.to.section'  => 'https://schema.org/HowToSection',
								'how.to.step'     => 'https://schema.org/HowToStep',
								'item.list'       => 'https://schema.org/ItemList',
								'offer.catalog'   => 'https://schema.org/OfferCatalog',
							),
							'job.posting'                  => 'https://schema.org/JobPosting',
							'language'                     => 'https://schema.org/Language',
							'list.item'                    => array(
								'how.to.direction' => 'https://schema.org/HowToDirection',
								'how.to.item'      => array(
									'how.to.item'      => 'https://schema.org/HowToItem',
									'how.to.supply'    => 'https://schema.org/HowToSupply',
									'how.to.tool'      => 'https://schema.org/HowToTool',
								),
								'how.to.section'   => 'https://schema.org/HowToSection',
								'how.to.step'      => 'https://schema.org/HowToStep',
								'how.to.tip'       => 'https://schema.org/HowToTip',
								'list.item'        => 'https://schema.org/ListItem',
							),
							'menu.item'                    => 'https://schema.org/MenuItem',
							'offer'                        => array(
								'offer'                        => 'https://schema.org/Offer',
								'offer.aggregate'              => 'https://schema.org/AggregateOffer',
							),
							'order'                        => 'https://schema.org/Order',
							'order.item'                   => 'https://schema.org/OrderItem',
							'parcel.delivery'              => 'https://schema.org/ParcelDelivery',
							'permit'                       => 'https://schema.org/Permit',
							'program.membership'           => 'https://schema.org/ProgramMembership',
							'property.value.specification' => 'https://schema.org/PropertyValueSpecification',
							'quantity'                     => 'https://schema.org/Quantity',
							'rating'                       => array(
								'rating'           => 'https://schema.org/Rating',
								'rating.aggregate' => 'https://schema.org/AggregateRating',
							),
							'reservation' => 'https://schema.org/Reservation',
							'role'        => 'https://schema.org/Role',
							'seat'        => 'https://schema.org/Seat',

							/**
							 * A service provided by an organization, e.g. delivery service, print services, etc.
							 */
							'service' => array(
								'service'                    => 'https://schema.org/Service',
								'service.broadcast'          => 'https://schema.org/BroadcastService',
								'service.cable.or.satellite' => 'https://schema.org/CableOrSatelliteService',
								'service.financial.product'  => array(
									'bank.account' => array(
										'bank.account'    => 'https://schema.org/BankAccount',
										'deposit.account' => 'https://schema.org/DepositAccount',
									),
									'service.currency.conversion'   => 'https://schema.org/CurrencyConversionService',
									'service.financial.product'     => 'https://schema.org/FinancialProduct',
									'service.investment.or.deposit' => array(
										'brokerage.account'             => 'https://schema.org/BrokerageAccount',
										'deposit.account'               => 'https://schema.org/DepositAccount',
										'service.investment.or.deposit' => 'https://schema.org/InvestmentOrDeposit',
										'service.investment.fund'       => 'https://schema.org/InvestmentFund',
									),
									'service.loan.or.credit' => array(
										'credit.card'            => 'https://schema.org/CreditCard',
										'mortgage.loan'          => 'https://schema.org/MortgageLoan',
										'service.loan.or.credit' => 'https://schema.org/LoanOrCredit',
									),
									// 'payment.card' array added by WpssoSchema::add_schema_type_xrefs().
									'service.payment' => 'https://schema.org/PaymentService',
								),
								'service.food'       => 'https://schema.org/FoodService',
								'service.government' => 'https://schema.org/GovernmentService',
								'service.taxi'       => 'https://schema.org/TaxiService',
							),
							'service.channel'  => 'https://schema.org/ServiceChannel',
							'structured.value' => 'https://schema.org/StructuredValue',
							'ticket'           => 'https://schema.org/Ticket',
							'trip'             => array(
								'trip'         => 'https://schema.org/Trip',
								'trip.bus'     => 'https://schema.org/BusTrip',
								'trip.flight'  => 'https://schema.org/Flight',
								'trip.train'   => 'https://schema.org/TrainTrip',
								'trip.tourist' => 'https://schema.org/TouristTrip',
							),
							'virtual.location' => 'https://schema.org/VirtualLocation',
						),
						'medical.entity' => array(
							'medical.anatomical.structure'    => 'https://schema.org/AnatomicalStructure',
							'medical.anatomical.systems'      => 'https://schema.org/AnatomicalSystem',
							'medical.cause'                   => 'https://schema.org/MedicalCause',
							'medical.condition'               => array(
								'medical.condition'          => 'https://schema.org/MedicalCondition',
								'medical.infectious.disease' => 'https://schema.org/InfectiousDisease',
								'medical.sign.or.symptom'    => array(
									'medical.sign.or.symptom' => 'https://schema.org/MedicalSignOrSymptom',
									'medical.sign'            => array(
										'medical.sign'       => 'https://schema.org/MedicalSign',
										'medical.sign.vital' => 'https://schema.org/MedicalVitalSign',
									),
									'medical.symptom' => 'https://schema.org/MedicalSymptom',
								),
							),
							'medical.contraindication'        => 'https://schema.org/MedicalContraindication',
							'medical.device'                  => 'https://schema.org/MedicalDevice',
							'medical.entity'                  => 'https://schema.org/MedicalEntity',
							'medical.guideline'               => 'https://schema.org/MedicalGuideline',
							'medical.indication'              => 'https://schema.org/MedicalIndication',
							'medical.intangible'              => 'https://schema.org/MedicalIntangible',
							'medical.lifestyle.modifications' => 'https://schema.org/LifestyleModification',
							'medical.procedure'               => 'https://schema.org/MedicalProcedure',
							'medical.risk.estimator'          => 'https://schema.org/MedicalRiskEstimator',
							'medical.risk.factor'             => 'https://schema.org/MedicalRiskFactor',
							'medical.study'                   => 'https://schema.org/MedicalStudy',
							'medical.substance'               => 'https://schema.org/Substance',
							'medical.superficial.anatomy'     => 'https://schema.org/SuperficialAnatomy',
							'medical.test'                    => 'https://schema.org/MedicalTest',
						),
						'organization' => array(
							'airline'                  => 'https://schema.org/Airline',
							'corporation'              => 'https://schema.org/Corporation',
							// 'educational.organization' array added by WpssoSchema::add_schema_type_xrefs().
							'government.organization' => 'https://schema.org/GovernmentOrganization',
							// 'local.business' array added by WpssoSchema::add_schema_type_xrefs().
							'medical.organization'    => array(
								'dentist.organization'        => 'https://schema.org/Dentist',
								'diagnostic.lab.organization' => 'https://schema.org/DiagnosticLab',
								'hospital'                    => 'https://schema.org/Hospital',
								'medical.clinic'              => array(
									'medical.clinic'         => 'https://schema.org/MedicalClinic',
									'covid.testing.facility' => 'https://schema.org/CovidTestingFacility',
								),
								'pharmacy.organization'       => 'https://schema.org/Pharmacy',
								'physician.organization'      => 'https://schema.org/Physician',
								'veterinary.care'         => 'https://schema.org/VeterinaryCare',
							),
							'non-governmental.organization' => 'https://schema.org/NGO',
							'organization'                  => 'https://schema.org/Organization',
							'performing.group'              => array(
								'dance.group'      => 'https://schema.org/DanceGroup',
								'music.group'      => 'https://schema.org/MusicGroup',
								'performing.group' => 'https://schema.org/PerformingGroup',
								'theater.group'    => 'https://schema.org/TheaterGroup',
							),
							'sports.organization' => array(
								'sports.team'         => 'https://schema.org/SportsTeam',
								'sports.organization' => 'https://schema.org/SportsOrganization',
							),
						),
						'person' => 'https://schema.org/Person',
						'place'  => array(
							'accommodation' => array(
								'accommodation' => 'https://schema.org/Accommodation',
								'apartment'     => 'https://schema.org/Apartment',
								'camping.pitch' => 'https://schema.org/CampingPitch',
								'house'         => array(
									'house'               => 'https://schema.org/House',
									'house.single.family' => 'https://schema.org/SingleFamilyResidence',
								),
								'room' => array(
									'room'         => 'https://schema.org/Room',
									'room.hotel'   => 'https://schema.org/HotelRoom',
									'room.meeting' => 'https://schema.org/MeetingRoom',
								),
								'suite' => 'https://schema.org/Suite',
							),
							'administrative.area' => array(
								'administrative.area' => 'https://schema.org/AdministrativeArea',
								'city'                => 'https://schema.org/City',
								'country'             => 'https://schema.org/Country',
								'state'               => 'https://schema.org/State',
							),
							'civic.structure' => array(
								'airport'                 => 'https://schema.org/Airport',
								'aquarium'                => 'https://schema.org/Aquarium',
								'beach'                   => 'https://schema.org/Beach',
								'boat.terminal'           => 'https://schema.org/BoatTerminal',
								'bridge'                  => 'https://schema.org/Bridge',
								'bus.station'             => 'https://schema.org/BusStation',
								'bus.stop'                => 'https://schema.org/BusStop',
								'campground'              => 'https://schema.org/Campground',
								'cemetary'                => 'https://schema.org/Cemetery',
								'civic.structure'         => 'https://schema.org/CivicStructure',
								'crematorium'             => 'https://schema.org/Crematorium',
								'educational.organization' => array(
									'college.or.university'    => 'https://schema.org/CollegeOrUniversity',
									'educational.organization' => 'https://schema.org/EducationalOrganization',
									'elementary.school'        => 'https://schema.org/ElementarySchool',
									'high.school'              => 'https://schema.org/HighSchool',
									'middle.school'            => 'https://schema.org/MiddleSchool',
									'preschool'                => 'https://schema.org/Preschool',
									'school'                   => 'https://schema.org/School',
								),
								'event.venue'             => 'https://schema.org/EventVenue',
								'fire.station'            => 'https://schema.org/FireStation',
								'government.building'     => 'https://schema.org/GovernmentBuilding',
								'hospital'                => 'https://schema.org/Hospital',
								'movie.theater'           => 'https://schema.org/MovieTheater',
								'museum'                  => 'https://schema.org/Museum',
								'music.venue'             => 'https://schema.org/MusicVenue',
								'park'                    => 'https://schema.org/Park',
								'parking.facility'        => 'https://schema.org/ParkingFacility',
								'performing.arts.theatre' => 'https://schema.org/PerformingArtsTheater',
								'place.of.worship'        => 'https://schema.org/PlaceOfWorship',
								'playground'              => 'https://schema.org/Playground',
								'rv.park'                 => 'https://schema.org/RVPark',
								'police.station'          => 'https://schema.org/PoliceStation',
								'public.toilet'           => 'https://schema.org/PublicToilet',
								'stadium.or.arena'        => 'https://schema.org/StadiumOrArena',
								'subway.station'          => 'https://schema.org/SubwayStation',
								'taxi.stand'              => 'https://schema.org/TaxiStand',
								'train.station'           => 'https://schema.org/TrainStation',
								'zoo'                     => 'https://schema.org/Zoo',
							),
							'landform'                          => 'https://schema.org/Landform',
							'landmarks.or.historical.buildings' => 'https://schema.org/LandmarksOrHistoricalBuildings',
							'local.business'                    => array(
								'animal.shelter'      => 'https://schema.org/AnimalShelter',
								'automotive.business' => array(
									'auto.body.shop'      => 'https://schema.org/AutoBodyShop',
									'auto.dealer'         => 'https://schema.org/AutoDealer',
									'auto.parts.store'    => 'https://schema.org/AutoPartsStore',
									'auto.rental'         => 'https://schema.org/AutoRental',
									'auto.repair'         => 'https://schema.org/AutoRepair',
									'auto.wash'           => 'https://schema.org/AutoWash',
									'automotive.business' => 'https://schema.org/AutomotiveBusiness',
									'gas.station'         => 'https://schema.org/GasStation',
									'motorcycle.dealer'   => 'https://schema.org/MotorcycleDealer',
									'motorcycle.repair'   => 'https://schema.org/MotorcycleRepair',
								),
								'child.care'                   => 'https://schema.org/ChildCare',
								'dentist.organization'         => 'https://schema.org/Dentist',
								'dry.cleaning.or.laundry'      => 'https://schema.org/DryCleaningOrLaundry',
								'emergency.service'            => array(
									'emergency.service' => 'https://schema.org/EmergencyService',
									'fire.station'      => 'https://schema.org/FireStation',
									'hospital'          => 'https://schema.org/Hospital',
									'police.station'    => 'https://schema.org/PoliceStation',
								),
								'employment.agency'      => 'https://schema.org/EmploymentAgency',
								'entertainment.business' => array(
									'adult.entertainment'    => 'https://schema.org/AdultEntertainment',
									'amusement.park'         => 'https://schema.org/AmusementPark',
									'art.gallery'            => 'https://schema.org/ArtGallery',
									'casino'                 => 'https://schema.org/Casino',
									'comedy.club'            => 'https://schema.org/ComedyClub',
									'entertainment.business' => 'https://schema.org/EntertainmentBusiness',
									'movie.theater'          => 'https://schema.org/MovieTheater',
									'night.club'             => 'https://schema.org/NightClub',
								),
								'financial.service'  => 'https://schema.org/FinancialService',
								'food.establishment' => array(
									'bakery'               => 'https://schema.org/Bakery',
									'bar.or.pub'           => 'https://schema.org/BarOrPub',
									'brewery'              => 'https://schema.org/Brewery',
									'cafe.or.coffee.shop'  => 'https://schema.org/CafeOrCoffeeShop',
									'fast.food.restaurant' => 'https://schema.org/FastFoodRestaurant',
									'food.establishment'   => 'https://schema.org/FoodEstablishment',
									'ice.cream.shop'       => 'https://schema.org/IceCreamShop',
									'restaurant'           => 'https://schema.org/Restaurant',
									'winery'               => 'https://schema.org/Winery',
								),
								'government.office'          => 'https://schema.org/GovernmentOffice',
								'health.and.beauty.business' => array(
									'beauty.salon'               => 'https://schema.org/BeautySalon',
									'day.spa'                    => 'https://schema.org/DaySpa',
									'health.and.beauty.business' => 'https://schema.org/HealthAndBeautyBusiness',
									'hair.salon'                 => 'https://schema.org/HairSalon',
									'health.club'                => 'https://schema.org/HealthClub',
									'nail.salon'                 => 'https://schema.org/NailSalon',
									'tattoo.parlor'              => 'https://schema.org/TattooParlor',
								),
								'home.and.construction.business' => array(
									'electrician'                    => 'https://schema.org/Electrician',
									'general.contractor'             => 'https://schema.org/GeneralContractor',
									'hvac.business'                  => 'https://schema.org/HVACBusiness',
									'home.and.construction.business' => 'https://schema.org/HomeAndConstructionBusiness',
									'house.painter'                  => 'https://schema.org/HousePainter',
									'locksmith'                      => 'https://schema.org/Locksmith',
									'moving.company'                 => 'https://schema.org/MovingCompany',
									'plumber'                        => 'https://schema.org/Plumber',
									'roofing.contractor'             => 'https://schema.org/RoofingContractor',
								),
								'internet.cafe' => 'https://schema.org/InternetCafe',
								'legal.service' => array(
									'attorney'      => 'https://schema.org/Attorney',
									'legal.service' => 'https://schema.org/LegalService',
									'notary'        => 'https://schema.org/Notary',
								),
								'library'          => 'https://schema.org/Library',
								'local.business'   => 'https://schema.org/LocalBusiness',
								'lodging.business' => array(
									'bed.and.breakfast' => 'https://schema.org/BedAndBreakfast',
									'campground'        => 'https://schema.org/Campground',
									'lodging.business'  => 'https://schema.org/LodgingBusiness',
									'hostel'            => 'https://schema.org/Hostel',
									'hotel'             => 'https://schema.org/Hotel',
									'motel'             => 'https://schema.org/Motel',
									'resort'            => 'https://schema.org/Resort',
								),
								'medical.business' => array(
									'community.health.business' => 'https://schema.org/CommunityHealth',
									'dentist.business'          => 'https://schema.org/Dentist',
									'dermatology.business'      => 'https://schema.org/Dermatology',
									'diet.nutrition.business'   => 'https://schema.org/DietNutrition',
									'emergency.business'        => 'https://schema.org/Emergency',
									'geriatric.business'        => 'https://schema.org/Geriatric',
									'gynecologic.business'      => 'https://schema.org/Gynecologic',
									'medical.business'          => 'https://schema.org/MedicalBusiness',
									'medical.clinic'   => array(
										'medical.clinic'         => 'https://schema.org/MedicalClinic',
										'covid.testing.facility' => 'https://schema.org/CovidTestingFacility',
									),
									'midwifery.business'        => 'https://schema.org/Midwifery',
									'nursing.business'          => 'https://schema.org/Nursing',
									'obstetric.business'        => 'https://schema.org/Obstetric',
									'oncologic.business'        => 'https://schema.org/Oncologic',
									'optician.business'         => 'https://schema.org/Optician',
									'optometric.business'       => 'https://schema.org/Optometric',
									'otolaryngologic.business'  => 'https://schema.org/Otolaryngologic',
									'pediatric.business'        => 'https://schema.org/Pediatric',
									'pharmacy.business'         => 'https://schema.org/Pharmacy',
									'physician.business'        => 'https://schema.org/Physician',
									'physiotherapy.business'    => 'https://schema.org/Physiotherapy',
									'plastic.surgery.business'  => 'https://schema.org/PlasticSurgery',
									'podiatric.business'        => 'https://schema.org/Podiatric',
									'primary.care.business'     => 'https://schema.org/PrimaryCare',
									'psychiatric.business'      => 'https://schema.org/Psychiatric',
									'public.health.business'    => 'https://schema.org/PublicHealth',
								),
								'professional.service'     => 'https://schema.org/ProfessionalService',
								'radio.station'            => 'https://schema.org/RadioStation',
								'real.estate.agent'        => 'https://schema.org/RealEstateAgent',
								'recycling.center'         => 'https://schema.org/RecyclingCenter',
								'self.storage'             => 'https://schema.org/SelfStorage',
								'shopping.center'          => 'https://schema.org/ShoppingCenter',
								'sports.activity.location' => array(
									'sports.activity.location' => 'https://schema.org/SportsActivityLocation',
									'stadium.or.arena'         => 'https://schema.org/StadiumOrArena',
								),
								'store' => array(
									'auto.parts.store'       => 'https://schema.org/AutoPartsStore',
									'bike.store'             => 'https://schema.org/BikeStore',
									'book.store'             => 'https://schema.org/BookStore',
									'clothing.store'         => 'https://schema.org/ClothingStore',
									'computer.store'         => 'https://schema.org/ComputerStore',
									'convenience.store'      => 'https://schema.org/ConvenienceStore',
									'department.store'       => 'https://schema.org/DepartmentStore',
									'electronics.store'      => 'https://schema.org/ElectronicsStore',
									'florist'                => 'https://schema.org/Florist',
									'flower.shop'            => 'https://schema.org/Florist',
									'furniture.store'        => 'https://schema.org/FurnitureStore',
									'garden.store'           => 'https://schema.org/GardenStore',
									'grocery.store'          => 'https://schema.org/GroceryStore',
									'hardware.store'         => 'https://schema.org/HardwareStore',
									'hobby.shop'             => 'https://schema.org/HobbyShop',
									'home.goods.store'       => 'https://schema.org/HomeGoodsStore',
									'jewelry.store'          => 'https://schema.org/JewelryStore',
									'liquor.store'           => 'https://schema.org/LiquorStore',
									'mens.clothing.store'    => 'https://schema.org/MensClothingStore',
									'mobile.phone.store'     => 'https://schema.org/MobilePhoneStore',
									'movie.rental.store'     => 'https://schema.org/MovieRentalStore',
									'music.store'            => 'https://schema.org/MusicStore',
									'office.equipment.store' => 'https://schema.org/OfficeEquipmentStore',
									'outlet.store'           => 'https://schema.org/OutletStore',
									'pawn.shop'              => 'https://schema.org/PawnShop',
									'pet.store'              => 'https://schema.org/PetStore',
									'shoe.store'             => 'https://schema.org/ShoeStore',
									'sporting.goods.store'   => 'https://schema.org/SportingGoodsStore',
									'store'                  => 'https://schema.org/Store',
									'tire.shop'              => 'https://schema.org/TireShop',
									'toy.store'              => 'https://schema.org/ToyStore',
									'wholesale.store'        => 'https://schema.org/WholesaleStore',
								),
								'television.station'         => 'https://schema.org/TelevisionStation',
								'tourist.information.center' => 'https://schema.org/TouristInformationCenter',
								'travel.agency'              => 'https://schema.org/TravelAgency',
							),
							'place'     => 'https://schema.org/Place',
							'residence' => array(
								'residence'                   => 'https://schema.org/Residence',
								'residence.apartment.complex' => 'https://schema.org/ApartmentComplex',
								'residence.gated.community'   => 'https://schema.org/GatedResidenceCommunity',
							),
							'tourist.attraction'  => 'https://schema.org/TouristAttraction',
							'tourist.destination' => 'https://schema.org/TouristDestination',
						),
						'product' => array(
							'individual.product' => 'https://schema.org/IndividualProduct',	// Individual product with unique serial number.
							'product'            => 'https://schema.org/Product',
							'product.model'      => 'https://schema.org/ProductModel',
							'some.products'      => 'https://schema.org/SomeProducts',
							'vehicle'            => array(
								'bus.or.coach'      => 'https://auto.schema.org/BusOrCoach',
								'car'               => 'https://auto.schema.org/Car',
								'motorcycle'        => 'https://auto.schema.org/Motorcycle',
								'motorized.bicycle' => 'https://auto.schema.org/MotorizedBicycle',
								'vehicle'           => 'https://auto.schema.org/Vehicle',
							),
						),
						'thing' => 'https://schema.org/Thing',
					),
				),
				'schema_renamed' => array(	// Element of 'head' array.
					'anesthesia'              => 'anesthesia.specialty',
					'cardiovascular'          => 'cardiovascular.specialty',
					'community.health'        => 'community.health.specialty',
					'dentist'                 => 'dentist.organization',
					'dentistry'               => 'dentistry.specialty',
					'dermatologic'            => 'dermatologic.specialty',
					'dermatology'             => 'dermatology.specialty',
					'diet.nutrition'          => 'diet.nutrition.specialty',
					'emergency'               => 'emergency.specialty',
					'endocrine'               => 'endocrine.specialty',
					'event.venu'              => 'event.venue',
					'gastroenterologic'       => 'gastroenterologic.specialty',
					'genetic'                 => 'genetic.specialty',
					'geriatric'               => 'geriatric.specialty',
					'gynecologic'             => 'gynecologic.specialty',
					'hematologic'             => 'hematologic.specialty',
					'howto'                   => 'how.to',
					'infectious'              => 'infectious.specialty',
					'laboratory.science'      => 'laboratory.science.specialty',
					'medical.clinic.business' => 'medical.clinic',
					'medical.audience'        => 'audience.medical',
					'midwifery'               => 'midwifery.specialty',
					'movie.theatre'           => 'movie.theater',
					'musculoskeletal'         => 'musculoskeletal.specialty',
					'music.venu'              => 'music.venue',
					'neurologic'              => 'neurologic.specialty',
					'nursing'                 => 'nursing.specialty',
					'obstetric'               => 'obstetric.specialty',
					'occupational.therapy'    => 'occupational.therapy.specialty',
					'oncologic'               => 'oncologic.specialty',
					'optometric'              => 'optometric.specialty',
					'otolaryngologic'         => 'otolaryngologic.specialty',
					'pathology'               => 'pathology.specialty',
					'pediatric'               => 'pediatric.specialty',
					'pharmacy'                => 'pharmacy.organization',
					'physician'               => 'physician.organization',
					'physiotherapy'           => 'physiotherapy.specialty',
					'plastic.surgery'         => 'plastic.surgery.specialty',
					'podiatric'               => 'podiatric.specialty',
					'primary.care'            => 'primary.care.specialty',
					'psychiatric'             => 'psychiatric.specialty',
					'public.health'           => 'public.health.specialty',
					'pulmonary'               => 'pulmonary.specialty',
					'radiography'             => 'radiography.specialty',
					'renal'                   => 'renal.specialty',
					'respiratory.therapy'     => 'respiratory.therapy.specialty',
					'rheumatologic'           => 'rheumatologic.specialty',
					'service.bank.account'    => 'bank.account',
					'service.credit.card'     => 'credit.card',
					'service.deposit.account' => 'deposit.account',
					'residence.single.family' => 'house.single.family',
					'speech.pathology'        => 'speech.pathology.specialty',
					'surgical'                => 'surgical.specialty',
					'toxicologic'             => 'toxicologic.specialty',
					'train.trip'              => 'trip.train',
					'urologic'                => 'urologic.specialty',
				),

				/**
				 * See http://wiki.goodrelations-vocabulary.org/Documentation/UN/CEFACT_Common_Codes.
				 */
				'schema_units' => array(	// Element of 'head' array.
					'depth' => array(	// Unitcode index value.
						'depth' => array(	// Schema property name.
							'@context' => 'https://schema.org',
							'@type'    => 'QuantitativeValue',
							'name'     => 'Depth',
							'unitText' => 'cm',
							'unitCode' => 'CMT',
						),
					),
					'height' => array(	// Unitcode index value.
						'height' => array(	// Schema property name.
							'@context' => 'https://schema.org',
							'@type'    => 'QuantitativeValue',
							'name'     => 'Height',
							'unitText' => 'cm',
							'unitCode' => 'CMT',
						),
					),
					'length' => array(	// Unitcode index value.
						'additionalProperty' => array(	// Schema property name.
							'@context'   => 'https://schema.org',
							'@type'      => 'PropertyValue',
							'propertyID' => 'length',
							'name'       => 'Length',
							'unitText'   => 'cm',
							'unitCode'   => 'CMT',
						),
					),
					'size' => array(	// Unitcode index value.
						'additionalProperty' => array(	// Schema property name.
							'@context'   => 'https://schema.org',
							'@type'      => 'PropertyValue',
							'propertyID' => 'size',
							'name'       => 'Size',
						),
					),
					'fluid_volume' => array(	// Unitcode index value.
						'additionalProperty' => array(	// Schema property name.
							'@context'   => 'https://schema.org',
							'@type'      => 'PropertyValue',
							'propertyID' => 'fluid_volume',
							'name'       => 'Fluid Volume',
							'unitText'   => 'ml',
							'unitCode'   => 'MLT',
						),
					),
					'weight' => array(	// Unitcode index value.
						'weight' => array(	// Schema property name.
							'@context' => 'https://schema.org',
							'@type'    => 'QuantitativeValue',
							'name'     => 'Weight',
							'unitText' => 'kg',
							'unitCode' => 'KGM',
						),
					),
					'width' => array(	// Unitcode index value.
						'width' => array(	// Schema property name.
							'@context' => 'https://schema.org',
							'@type'    => 'QuantitativeValue',
							'name'     => 'Width',
							'unitText' => 'cm',
							'unitCode' => 'CMT',
						),
					),
				),

				/**
				 * The Schema standard provides 'aggregateRating' and 'review' properties for these types:
				 *
				 * 	Brand
				 * 	CreativeWork
				 * 	Event
				 * 	Offer
				 * 	Organization
				 * 	Place
				 * 	Product
				 * 	Service 
				 *
				 * Unfortunately Google allows the 'aggregateRating' property only for these types:
				 *
				 *	Book
				 *	Course
				 *	Event
				 *	HowTo (includes Recipe)
				 *	LocalBusiness
				 *	Movie
				 *	Product
				 *	SoftwareApplication
				 *
				 * And the 'review' property only for these types:
				 *
				 *	Book
				 *	Course
				 *	CreativeWorkSeason
				 *	CreativeWorkSeries
				 *	Episode
				 *	Event
				 *	Game
				 *	HowTo (includes Recipe)
				 *	LocalBusiness
				 *	MediaObject
				 *	Movie
				 *	MusicPlaylist
				 * 	MusicRecording
				 *	Organization
				 *	Product
				 *	SoftwareApplication
				 */
				'schema_aggregate_rating_parents' => array(	// Element of 'head' array.
					'book',
					'course',
					'event',
					'how.to',
					'local.business',
					'movie',
					'product',
					'software.application',
				),
				'schema_review_parents' => array(	// Element of 'head' array.
					'book',
					'course',
					'creative.work.season',
					'creative.work.series',
					'episode',
					'event',
					'game',
					'how.to',
					'local.business',
					'media.object',
					'movie',
					'music.playlist',
					'music.recording',
					'organization',
					'product',
					'software.application',
				),

				/**
				 * Good Relations.
				 */
				'schema_gr' => array(			// Element of 'head' array.
					'DeliveryMethod' => array( 
						'Download' => 'http://purl.org/goodrelations/v1#DeliveryModeDirectDownload',
						'Freight'  => 'http://purl.org/goodrelations/v1#DeliveryModeFreight',
						'Mail'     => 'http://purl.org/goodrelations/v1#DeliveryModeMail',
						'Fleet'    => 'http://purl.org/goodrelations/v1#DeliveryModeOwnFleet',
						'PickUp'   => 'http://purl.org/goodrelations/v1#DeliveryModePickUp',
						'DHL'      => 'http://purl.org/goodrelations/v1#DHL',
						'FedEx'    => 'http://purl.org/goodrelations/v1#FederalExpress',
						'UPS'      => 'http://purl.org/goodrelations/v1#UPS',
					),
				),
			),
			'extend' => array(
				'https://wpsso.com/extend/plugins/',
			),
		);

		public static function get_version( $add_slug = false ) {

			$info =& self::$cf[ 'plugin' ][ 'wpsso' ];

			return $add_slug ? $info[ 'slug' ] . '-' . $info[ 'version' ] : $info[ 'version' ];
		}

		public static function get_config( $read_cache = true ) {

			if ( $read_cache ) {

				if ( ! empty( self::$cf[ 'config_filtered' ] ) ) {	// Only if already filtered.

					return self::$cf;
				}
			}

			self::$cf[ '*' ] = array(
				'base' => array(),
				'lib'  => array(
					'pro' => array(),
					'std' => array(),
				),
				'version' => '',	// -wpsso3.29.0pro-wpssoplm1.5.1pro-wpssoum1.4.0gpl
			);

			self::$cf[ 'opt' ][ 'version' ] = '';	// -wpsso416pro-wpssoplm8pro

			self::$cf[ 'config_filtered' ] = false;

			/**
			 * Wpsso->__construct() calls WpssoConfig::get_config() before WpssoConfig::set_constants(), which defines
			 * 'WPSSO_VERSION', so use 'WPSSO_VERSION' as a signal to skip applying filters until later.
			 */
			if ( ! defined( 'WPSSO_VERSION' ) ) {
			
				return self::$cf;
			}

			/**
			 * Apply filters to have add-ons include their config.
			 */
			if ( empty( self::$cf[ 'config_filtered' ] ) ) {

				self::$cf = apply_filters( 'wpsso_get_config', self::$cf );
			}

			self::$cf[ 'config_filtered' ] = true;

			$pro_disable = defined( 'WPSSO_PRO_DISABLE' ) && WPSSO_PRO_DISABLE ? true : false;

			foreach ( self::$cf[ 'plugin' ] as $ext => $info ) {

				$pkg_dir = 'std';

				if ( ! $pro_disable ) {
				
					$ext_dir = self::get_ext_dir( $ext, $read_cache );

					if ( is_dir( $ext_dir . 'lib/pro/' ) ) {

						$pkg_dir = 'pro';
					}
				}

				if ( isset( $info[ 'slug' ] ) ) {

					self::$cf[ '*' ][ 'slug' ][ $info[ 'slug' ] ] = $ext;
				}

				if ( isset( $info[ 'base' ] ) ) {

					self::$cf[ '*' ][ 'base' ][ $info[ 'base' ] ] = $ext;
				}

				if ( isset( $info[ 'lib' ] ) && is_array( $info[ 'lib' ] ) ) {

					self::$cf[ '*' ][ 'lib' ] = SucomUtil::array_merge_recursive_distinct( self::$cf[ '*' ][ 'lib' ], $info[ 'lib' ] );
				}

				if ( isset( $info[ 'version' ] ) ) {

					self::$cf[ '*' ][ 'version' ] .= '-' . $ext . $info[ 'version' ] . $pkg_dir;
				}

				if ( isset( $info[ 'opt_version' ] ) ) {

					self::$cf[ 'opt' ][ 'version' ] .= '-' . $ext . $info[ 'opt_version' ] . $pkg_dir;
				}

				/**
				 * Maybe complete relative paths in the image arrays.
				 */
				$plugins_url_base = trailingslashit( plugins_url( '', $info[ 'base' ] ) );

				array_walk_recursive( self::$cf[ 'plugin' ][ $ext ][ 'assets' ], array( __CLASS__, 'maybe_prefix_base_url' ), $plugins_url_base );
			}

			return self::$cf;
		}

		private static function maybe_prefix_base_url( &$url, $key, $plugins_url_base ) {

			if ( ! empty( $url ) && false === strpos( $url, '//' ) ) {

				$url = $plugins_url_base . $url;
			}
		}

		public static function set_constants( $plugin_file ) {

			if ( defined( 'WPSSO_VERSION' ) ) {	// Define constants only once.

				return;
			}

			$info =& self::$cf[ 'plugin' ][ 'wpsso' ];

			/**
			 * Define fixed constants.
			 */
			define( 'WPSSO_FILEPATH', $plugin_file );
			define( 'WPSSO_PLUGINBASE', $info[ 'base' ] );	// Example: wpsso/wpsso.php.
			define( 'WPSSO_PLUGINDIR', trailingslashit( realpath( dirname( $plugin_file ) ) ) );
			define( 'WPSSO_PLUGINSLUG', $info[ 'slug' ] );	// Example: wpsso.
			define( 'WPSSO_UNDEF', -1 );			// Default undefined image width / height value.
			define( 'WPSSO_URLPATH', trailingslashit( plugins_url( '', $plugin_file ) ) );
			define( 'WPSSO_VERSION', $info[ 'version' ] );
			define( 'WPSSO_DATA_ID', 'wpsso meta tags and schema markup' );

			define( 'WPSSO_INIT_CONFIG_PRIORITY', -10 );
			define( 'WPSSO_INIT_OPTIONS_PRIORITY', 9 );
			define( 'WPSSO_INIT_OBJECTS_PRIORITY', 10 );
			define( 'WPSSO_INIT_JSON_FILTERS_PRIORITY', 11 );
			define( 'WPSSO_INIT_SHORTCODES_PRIORITY', 11 );
			define( 'WPSSO_INIT_PLUGIN_PRIORITY', 12 );

			/**
			 * Define variable constants.
			 */
			self::set_variable_constants();
		}

		public static function set_variable_constants( $var_const = null ) {

			if ( ! is_array( $var_const ) ) {

				$var_const = (array) self::get_variable_constants();
			}

			/**
			 * Define the variable constants, if not already defined.
			 */
			foreach ( $var_const as $name => $value ) {

				if ( ! defined( $name ) ) {

					define( $name, $value );
				}
			}
		}

		public static function get_variable_constants() {

			$var_const = array();

			/**
			 * Create a unique md5 query name from the config array and the local wp nonce key.
			 */
			$var_const[ 'WPSSO_NONCE_NAME' ] = md5( var_export( self::$cf[ 'plugin' ][ 'wpsso' ], $return = true ) .
				( defined( 'NONCE_KEY' ) ? NONCE_KEY : '' ) );

			if ( defined( 'WPSSO_PLUGINDIR' ) ) {

				$var_const[ 'WPSSO_ARTICLE_SECTIONS_LIST' ]   = WPSSO_PLUGINDIR . 'share/article-sections.txt';
				$var_const[ 'WPSSO_PRODUCT_CATEGORIES_LIST' ] = WPSSO_PLUGINDIR . 'share/product-categories.txt';
			}

			$var_const[ 'WPSSO_CACHE_DIR' ] = self::get_cache_dir();
			$var_const[ 'WPSSO_CACHE_URL' ] = self::get_cache_url();

			/**
			 * Deprecated on 2020/12/23.
			 */
			$var_const[ 'WPSSO_CACHEDIR' ] = $var_const[ 'WPSSO_CACHE_DIR' ];
			$var_const[ 'WPSSO_CACHEURL' ] = $var_const[ 'WPSSO_CACHE_URL' ];

			$var_const[ 'WPSSO_MENU_ORDER' ]                  = '80.0';		// Position of the SSO settings menu item.
			$var_const[ 'WPSSO_TB_NOTICE_MENU_ORDER' ]        = '55';		// Position of the SSO notices toolbar menu item.
			$var_const[ 'WPSSO_TB_LOCALE_MENU_ORDER' ]        = '56';		// Position of the user locale toolbar menu item.
			$var_const[ 'WPSSO_TB_VALIDATE_MENU_ORDER' ]      = '57';		// Position of the validate menu item.
			$var_const[ 'WPSSO_JSON_PRETTY_PRINT' ]           = true;		// Allows for better visual cues in the Google validator.
			$var_const[ 'WPSSO_CACHE_CLEAR_MAX_TIME' ]        = 3600;		// 1 hour.
			$var_const[ 'WPSSO_CACHE_REFRESH_MAX_TIME' ]      = 10800;		// 3 hours.
			$var_const[ 'WPSSO_CACHE_REFRESH_SLEEP_TIME' ]    = 0.30;		// Seconds to sleep between requests when refreshing the cache.
			$var_const[ 'WPSSO_CACHE_SELECT_JSON_EXP_SECS' ]  = MONTH_IN_SECONDS;	// Javascript URLs for Schema types, article sections, and product categories.
			$var_const[ 'WPSSO_CONTENT_BLOCK_FILTER_OUTPUT' ] = true;		// Monitor and fix incorrectly coded filter hooks.
			$var_const[ 'WPSSO_CONTENT_FILTERS_MAX_TIME' ]    = 1.00;		// Issue a warning if the content filter takes longer than 1 second.
			$var_const[ 'WPSSO_CONTENT_IMAGES_MAX_LIMIT' ]    = 5;			// Maximum number of images extracted from the content.
			$var_const[ 'WPSSO_CONTENT_VIDEOS_MAX_LIMIT' ]    = 5;			// Maximum number of videos extracted from the content.
			$var_const[ 'WPSSO_DUPE_CHECK_HEADER_COUNT' ]     = 3;			// Maximum number of times to check for duplicates.
			$var_const[ 'WPSSO_DUPE_CHECK_TIMEOUT_TIME' ]     = 3.00;		// Hard-limit - most crawlers time-out after 3 seconds.
			$var_const[ 'WPSSO_DUPE_CHECK_WARNING_TIME' ]     = 2.50;		// Issue a warning if getting shortlink took more than 2.5 seconds.
			$var_const[ 'WPSSO_GET_POSTS_MAX_TIME' ]          = 0.20;		// Send error to trigger_error() if get_posts() takes longer.
			$var_const[ 'WPSSO_IMAGE_MAKE_SIZE_MAX_TIME' ]    = 1.50;		// Send error to trigger_error() if image_make_intermediate_size() takes longer.
			$var_const[ 'WPSSO_PHP_GETIMGSIZE_MAX_TIME' ]     = 1.50;		// Send an error to trigger_error() if getimagesize() takes longer.
			$var_const[ 'WPSSO_SELECT_PERSON_NAMES_MAX' ]     = 100;		// Maximum number of persons to include in a form select.
			$var_const[ 'WPSSO_GRAVATAR_IMAGE_SIZE_MAX' ]     = 2048;		// Maximum available width of images from Gravatar.com.
			$var_const[ 'WPSSO_READING_WORDS_PER_MIN' ]       = 200;		// Estimated reading words per minute.

			/**
			 * Schema limits.
			 */
			$var_const[ 'WPSSO_SCHEMA_ADDL_TYPE_URL_MAX' ]       = 5;
			$var_const[ 'WPSSO_SCHEMA_COMMENTS_MAX' ]            = 50;		// Maximum number of comments when "Break comments into pages" is unchecked.
			$var_const[ 'WPSSO_SCHEMA_HOWTO_STEPS_MAX' ]         = 40;
			$var_const[ 'WPSSO_SCHEMA_HOWTO_SUPPLIES_MAX' ]      = 30;
			$var_const[ 'WPSSO_SCHEMA_HOWTO_TOOLS_MAX' ]         = 20;
			$var_const[ 'WPSSO_SCHEMA_ISPARTOF_URL_MAX' ]        = 20;
			$var_const[ 'WPSSO_SCHEMA_JOB_LOCATIONS_MAX' ]       = 5;
			$var_const[ 'WPSSO_SCHEMA_METADATA_OFFERS_MAX' ]     = 5;
			$var_const[ 'WPSSO_SCHEMA_MOVIE_ACTORS_MAX' ]        = 15;
			$var_const[ 'WPSSO_SCHEMA_MOVIE_DIRECTORS_MAX' ]     = 5;
			$var_const[ 'WPSSO_SCHEMA_PRODUCT_VALID_MAX_TIME' ]  = 3 * MONTH_IN_SECONDS;	// Used for Schema 'priceValidUntil' property default.
			$var_const[ 'WPSSO_SCHEMA_RECIPE_INGREDIENTS_MAX' ]  = 40;
			$var_const[ 'WPSSO_SCHEMA_RECIPE_INSTRUCTIONS_MAX' ] = 40;
			$var_const[ 'WPSSO_SCHEMA_REVIEWS_MAX' ]             = 100;
			$var_const[ 'WPSSO_SCHEMA_SAMEAS_URL_MAX' ]          = 5;

			/**
			 * Setting and meta array names.
			 */
			$var_const[ 'WPSSO_DISMISS_NAME' ]          = 'wpsso_dismissed';
			$var_const[ 'WPSSO_META_NAME' ]             = '_wpsso_meta';
			$var_const[ 'WPSSO_META_ATTACHED_NAME' ]    = '_wpsso_meta_attached';
			$var_const[ 'WPSSO_PREF_NAME' ]             = '_wpsso_pref';
			$var_const[ 'WPSSO_OPTIONS_NAME' ]          = 'wpsso_options';
			$var_const[ 'WPSSO_REG_TS_NAME' ]           = 'wpsso_timestamps';
			$var_const[ 'WPSSO_SITE_OPTIONS_NAME' ]     = 'wpsso_site_options';
			$var_const[ 'WPSSO_POST_CHECK_COUNT_NAME' ] = 'wpsso_post_check_count';
			$var_const[ 'WPSSO_TMPL_HEAD_CHECK_NAME' ]  = 'wpsso_tmpl_head_check';
			$var_const[ 'WPSSO_WP_CONFIG_CHECK_NAME' ]  = 'wpsso_wp_config_check';
			$var_const[ 'WPSSO_REVIEW_IMAGE_IDS_NAME' ] = 'reviews-images';
			$var_const[ 'WPSSO_PAGE_TAG_TAXONOMY' ]     = 'page_tag';

			/**
			 * Hook priorities.
			 */
			$var_const[ 'WPSSO_ADD_MENU_PRIORITY' ]      = -20;	// 'admin_menu' hook priority.
			$var_const[ 'WPSSO_ADD_SUBMENU_PRIORITY' ]   = -10;	// 'admin_menu' hook priority.
			$var_const[ 'WPSSO_ADD_COLUMN_PRIORITY' ]    = 100;
			$var_const[ 'WPSSO_ADMIN_SCRIPTS_PRIORITY' ] = -1000;	// 'admin_enqueue_scripts' hook priority.
			$var_const[ 'WPSSO_BLOCK_ASSETS_PRIORITY' ]  = -1000;	// 'enqueue_block_editor_assets' hook priority.
			$var_const[ 'WPSSO_HEAD_PRIORITY' ]          = 10;
			$var_const[ 'WPSSO_META_SAVE_PRIORITY' ]     = -100;	// Save our custom post/term/user meta before clearing the cache.
			$var_const[ 'WPSSO_META_CACHE_PRIORITY' ]    = -10;	// Clear our cache before priority 10 (where most caching plugins are hooked).
			$var_const[ 'WPSSO_SEO_SEED_PRIORITY' ]      = 100;

			/**
			 * PHP cURL library settings.
			 */
			$var_const[ 'WPSSO_PHP_CURL_CAINFO' ]               = ABSPATH . WPINC . '/certificates/ca-bundle.crt';
			$var_const[ 'WPSSO_PHP_CURL_USERAGENT' ]            = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:70.0) Gecko/20100101 Firefox/70.0';
			$var_const[ 'WPSSO_PHP_CURL_USERAGENT_FACEBOOK' ]   = 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)';

			/**
			 * Maybe override the default constant value with a pre-defined constant value.
			 */
			foreach ( $var_const as $name => $value ) {

				if ( defined( $name ) ) {

					$var_const[ $name ] = constant( $name );
				}
			}

			return $var_const;
		}

		/**
		 * Load all essential library files.
		 *
		 * Avoid calling is_admin() here as it can be unreliable this early in the load process - some plugins that operate
		 * outside of the standard WordPress load process do not define WP_ADMIN as they should (which is required to by
		 * is_admin() this early in the WordPress load process).
		 */
		public static function require_libs( $plugin_file ) {

			require_once WPSSO_PLUGINDIR . 'lib/com/cache.php';
			require_once WPSSO_PLUGINDIR . 'lib/com/nodebug.php';	// Always load the debug fallback class.
			require_once WPSSO_PLUGINDIR . 'lib/com/nonotice.php';	// Always load the notice fallback class.
			require_once WPSSO_PLUGINDIR . 'lib/com/plugin.php';
			require_once WPSSO_PLUGINDIR . 'lib/com/util.php';
			require_once WPSSO_PLUGINDIR . 'lib/com/util-wp.php';

			require_once WPSSO_PLUGINDIR . 'lib/check.php';
			require_once WPSSO_PLUGINDIR . 'lib/compat.php';	// Third-party plugin and theme compatibility actions and filters.
			require_once WPSSO_PLUGINDIR . 'lib/exception.php';	// Extends ErrorException.
			require_once WPSSO_PLUGINDIR . 'lib/functions.php';
			require_once WPSSO_PLUGINDIR . 'lib/head.php';
			require_once WPSSO_PLUGINDIR . 'lib/media.php';
			require_once WPSSO_PLUGINDIR . 'lib/options.php';
			require_once WPSSO_PLUGINDIR . 'lib/page.php';
			require_once WPSSO_PLUGINDIR . 'lib/register.php';
			require_once WPSSO_PLUGINDIR . 'lib/script.php';
			require_once WPSSO_PLUGINDIR . 'lib/style.php';
			require_once WPSSO_PLUGINDIR . 'lib/util.php';		// Extends SucomUtil.

			/**
			 * Comment, post, term, user modules.
			 */
			require_once WPSSO_PLUGINDIR . 'lib/abstracts/wp-meta.php';
			require_once WPSSO_PLUGINDIR . 'lib/comment.php';	// Extends WpssoWpMeta.
			require_once WPSSO_PLUGINDIR . 'lib/post.php';		// Extends WpssoWpMeta.
			require_once WPSSO_PLUGINDIR . 'lib/term.php';		// Extends WpssoWpMeta.
			require_once WPSSO_PLUGINDIR . 'lib/user.php';		// Extends WpssoWpMeta.

			/**
			 * Meta tags and markup.
			 */
			require_once WPSSO_PLUGINDIR . 'lib/link-rel.php';
			require_once WPSSO_PLUGINDIR . 'lib/meta-name.php';
			require_once WPSSO_PLUGINDIR . 'lib/oembed.php';
			require_once WPSSO_PLUGINDIR . 'lib/opengraph.php';
			require_once WPSSO_PLUGINDIR . 'lib/pinterest.php';
			require_once WPSSO_PLUGINDIR . 'lib/schema.php';
			require_once WPSSO_PLUGINDIR . 'lib/twittercard.php';
			require_once WPSSO_PLUGINDIR . 'lib/wp-sitemaps.php';

			/**
			 * Module library loader.
			 */
			require_once WPSSO_PLUGINDIR . 'lib/loader.php';

			/**
			 * Add-ons library.
			 */
			require_once WPSSO_PLUGINDIR . 'lib/abstracts/add-on.php';	// Extends SucomAddOn.

			add_filter( 'wpsso_load_lib', array( 'WpssoConfig', 'load_lib' ), 10, 3 );
		}

		public static function load_lib( $success = false, $filespec = '', $classname = '' ) {

			if ( false === $success && ! empty( $filespec ) ) {

				$file_path = WPSSO_PLUGINDIR . 'lib/' . $filespec . '.php';

				if ( file_exists( $file_path ) ) {

					require_once $file_path;

					if ( empty( $classname ) ) {

						return SucomUtil::sanitize_classname( 'wpsso' . $filespec, $allow_underscore = false );

					}

					return $classname;
				}
			}

			return $success;
		}

		/**
		 * Since WPSSO Core v4.18.1.
		 */
		public static function get_cache_dir() {

			if ( defined( 'WPSSO_CACHE_DIR' ) ) {

				return WPSSO_CACHE_DIR;
			}

			if ( defined( 'WP_CONTENT_DIR' ) ) {

				$content_dir = trailingslashit( WP_CONTENT_DIR );

				if ( self::is_cache_dir( $content_dir . 'cache/wpsso/' ) ) {

					return $content_dir . 'cache/wpsso/';
				}
			}

			if ( defined( 'WPSSO_PLUGINDIR' ) ) {

				if ( self::is_cache_dir( WPSSO_PLUGINDIR . 'cache/' ) ) {

					return WPSSO_PLUGINDIR . 'cache/';
				}
			}

			return false;
		}

		/**
		 * Since WPSSO Core v4.18.1.
		 */
		public static function get_cache_url() {

			if ( defined( 'WPSSO_CACHE_URL' ) ) {

				return WPSSO_CACHE_URL;
			}

			if ( defined( 'WP_CONTENT_DIR' ) ) {

				$content_dir = trailingslashit( WP_CONTENT_DIR );

				if ( self::is_cache_dir( $content_dir . 'cache/wpsso/' ) ) {

					return content_url( 'cache/wpsso/' );
				}
			}

			if ( defined( 'WPSSO_PLUGINDIR' ) ) {

				if ( self::is_cache_dir( WPSSO_PLUGINDIR . 'cache/' ) ) {

					if ( defined( 'WPSSO_URLPATH' ) ) {	// Just in case.

						return WPSSO_URLPATH . 'cache/';
					}
				}
			}

			return false;
		}

		/**
		 * Since WPSSO Core v4.18.1.
		 */
		private static function is_cache_dir( $dir ) {

			$dir = trailingslashit( $dir );		// Just in case.

			$index_file  = $dir . 'index.php';
			$access_file = $dir . '.htaccess';

			if ( file_exists( $index_file ) ) {	// Assume directory permissions are good.

				return true;
			}

			$index_str  = '<?php // These aren\'t the droids you\'re looking for.' . "\n";
			$access_str = '<FilesMatch "\.(php|pl|cgi|shtml)$">
	# Apache 2.2
	<IfModule !mod_authz_core.c>
		Order	deny,allow
		Deny	from all
	</IfModule>
	# Apache 2.4
	<IfModule mod_authz_core.c>
		Require all denied
	</IfModule>
</FilesMatch>' . "\n";

			if ( is_dir( $dir ) || @mkdir( $dir, $mode = 0755, $recursive = true ) ) {

				if ( ( $index_fh = @fopen( $index_file, $mode = 'wb' ) ) &&
					( $access_fh = @fopen( $access_file, $mode = 'wb' ) ) ) {

					if ( @fwrite( $index_fh, $index_str ) && @fwrite( $access_fh, $access_str ) ) {

						fclose( $index_fh );
						fclose( $access_fh );

						@chmod( $index_file, $mode = 0644 );
						@chmod( $access_file, $mode = 0644 );

						return true;
					}
				}
			}

			return false;
		}

		/**
		 * Since WPSSO Core v3.38.3.
		 */
		public static function get_ext_sorted() {

			$cf = self::get_config();

			/**
			 * Sort the array by plugin name and maintain index association.
			 */
			uasort( $cf[ 'plugin' ], array( 'self', 'sort_plugin_by_name_key' ) );

			reset( $cf[ 'plugin' ] );	// Just in case.

			$first_key = key( $cf[ 'plugin' ] );

			/**
			 * Make sure the core plugin is listed first.
			 */
			if ( 'wpsso' !== $first_key ) {

				SucomUtil::move_to_front( $cf[ 'plugin' ], 'wpsso' );
			}

			return $cf[ 'plugin' ];
		}

		private static function sort_plugin_by_name_key( $a, $b ) {

			if ( isset( $a[ 'name' ] ) && isset( $b[ 'name' ] ) ) {

				return strnatcmp( $a[ 'name' ], $b[ 'name' ] );
			}

			return 0;	// No change.
		}

		/**
		 * Since WPSSO Core v7.8.0.
		 *
		 * Returns false or a slashed directory path.
		 */
		public static function get_ext_dir( $ext, $read_cache = true ) {

			static $local_cache = array();

			if ( $read_cache ) {

				if ( isset( $local_cache[ $ext ] ) ) {

					return $local_cache[ $ext ];
				}
			}

			/**
			 * Check for active plugin constant first.
			 */
			$ext_dir_const = strtoupper( $ext ) . '_PLUGINDIR';

			if ( defined( $ext_dir_const ) && is_dir( $ext_dir = constant( $ext_dir_const ) ) ) {

				return $local_cache[ $ext ] = trailingslashit( $ext_dir );
			}

			/**
			 * Fallback to checking for inactive plugin folder.
			 */
			$cf = self::get_config();

			if ( isset( $cf[ 'plugin' ][ $ext ][ 'slug' ] ) ) {

				$slug = $cf[ 'plugin' ][ $ext ][ 'slug' ];

				if ( defined ( 'WPMU_PLUGIN_DIR' ) && is_dir( $ext_dir = trailingslashit( WPMU_PLUGIN_DIR ) . $slug . '/' ) ) {

					return $local_cache[ $ext ] = $ext_dir;
				}

				if ( defined ( 'WP_PLUGIN_DIR' ) && is_dir( $ext_dir = trailingslashit( WP_PLUGIN_DIR ) . $slug . '/' ) ) {

					return $local_cache[ $ext ] = $ext_dir;
				}
			}

			return $local_cache[ $ext ] = false;
		}

		/**
		 * Since WPSSO Core v7.8.0.
		 *
		 * Returns false, a slashed directory path, or the file name path.
		 *
		 * Use $is_dir = true when specifically checking for a sub-folder path.
		 */
		public static function get_ext_file_path( $ext, $file_name = '', $is_dir = false ) {

			if ( $ext_dir = self::get_ext_dir( $ext ) ) {	// Returns false or a slashed directory path.

				if ( $is_dir ) {	// Must be a directory.

					if ( is_dir( $sub_dir = trailingslashit( $ext_dir . $file_name ) ) ) {

						return $sub_dir;
					}

				} else {

					if ( file_exists( $file_path = $ext_dir . $file_name ) ) {

						return $file_path;
					}
				}
			}

			return false;
		}

		/**
		 * Since WPSSO Core v9.0.0.
		 */
		public static function get_social_accounts( $key = false ) {

			static $local_cache = null;

			if ( null === $local_cache ) {

				$local_cache = (array) apply_filters( 'wpsso_social_accounts', self::$cf[ 'form' ][ 'social_accounts' ] );

				foreach ( $local_cache as $k => $label ) {

					$local_cache[ $k ] = _x( $label, 'option value', 'wpsso' );
				}

				uasort( $local_cache, 'strnatcmp' );	// Sort associative array by value (ie. the translated label).
			}

			if ( false !== $key ) {

				if ( isset( $local_cache[ $key ] ) ) {	// Just in case.

					return $local_cache[ $key ];
				}

				return null;
			}

			return $local_cache;
		}
	}
}
