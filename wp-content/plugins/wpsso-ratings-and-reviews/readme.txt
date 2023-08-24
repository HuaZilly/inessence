=== WPSSO Ratings and Reviews ===
Plugin Name: WPSSO Ratings and Reviews
Plugin Slug: wpsso-ratings-and-reviews
Text Domain: wpsso-ratings-and-reviews
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/
Tags: star rating, aggregate rating, review, google, schema, comment, knowledge graph, product rating, product review, meta tags, schema review, schema markup, woocommerce
Contributors: jsmoriss
Requires PHP: 7.0
Requires At Least: 5.0
Tested Up To: 5.8.1
WC Tested Up To: 5.8.0
Stable Tag: 2.15.2

Ratings and Reviews for WordPress Comments with Schema Aggregate Rating and Schema Review Markup.

== Description ==

<!-- about -->

**The WPSSO Ratings and Reviews add-on extends the WordPress comment system:**

* The star ratings can be enabled/disabled by post type or individual post.
* A rating value can be required (or not) before reviews are accepted.
* The color of star ratings can be customized from the add-on settings page.
* The theme template review form is correctly labeled as a "Review".
* The theme template review reply form is correctly labeled as a "Reply".

**Compatible with WooCommerce product ratings.**

**Provides [Schema Aggregate Rating](https://schema.org/aggregateRating) markup.**

**Provides [Schema Review](https://schema.org/Review) markup,** including information about the review (author name, creation time, excerpt, rating) and threaded replies / comments for each review.

<h3>No templates to modify or update!</h3>

Simply activate / deactivate the plugin to enable / disable the addition of ratings and reviews.

<!-- /about -->

<h3>WPSSO Core Required</h3>

WPSSO Ratings and Reviews (WPSSO RAR) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/).

== Installation ==

<h3 class="top">Install and Uninstall</h3>

* [Install the WPSSO Ratings and Reviews add-on](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/install-the-plugin/).
* [Uninstall the WPSSO Ratings and Reviews add-on](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/uninstall-the-plugin/).

== Frequently Asked Questions ==

<h3 class="top">Frequently Asked Questions</h3>

* None.

<h3>Notes and Documentation</h3>

* [Developer Resources](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/developer/)
	* [Get Average Rating](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/developer/get-average-rating/)

== Screenshots ==

01. The WPSSO RAR settings page to enable ratings by post type and select colors for the star ratings. 
02. The WPSSO RAR review submission - note the customized labels (Your Rating, Your Review, etc.).

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Standard Version Repositories</h3>

* [GitHub](https://surniaulula.github.io/wpsso-ratings-and-reviews/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wpsso-ratings-and-reviews/)

<h3>Development Version Updates</h3>

<p><strong>WPSSO Core Premium customers have access to development, alpha, beta, and release candidate version updates:</strong></p>

<p>Under the SSO &gt; Update Manager settings page, select the "Development and Up" (for example) version filter for the WPSSO Core plugin and/or its add-ons. Save the plugin settings and click the "Check for Plugin Updates" button to fetch the latest version information. When new development versions are available, they will automatically appear under your WordPress Dashboard &gt; Updates page. You can always reselect the "Stable / Production" version filter at any time to reinstall the latest stable version.</p>

<h3>Changelog / Release Notes</h3>

**Version 2.15.2 (2021/10/18)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* Fixed an extra newline character, that was converted to a line-break, in comment text.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v9.2.0.

**Version 2.15.1 (2021/10/06)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Standardized `get_table_rows()` calls and filters in 'submenu' and 'sitesubmenu' classes.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v9.1.0.

**Version 2.15.0 (2021/09/24)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* Fixed saving star rating colors in the SSO &gt; Ratings / Reviews settings page.
* **Developer Notes**
	* Updated the 'wpsso_og_add_mt_reviews' default value for WPSSO Core v9.0.0.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v9.0.0.

**Version 2.14.2 (2021/06/27)**

* **New Features**
	* None.
* **Improvements**
	* Added a conflict check for the new "Ratings and Reviews Service" option in WPSSO Core v8.33.0.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v8.34.0.

**Version 2.14.1 (2021/06/18)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Updated the 'wpsso-rar-script' localized variable names.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.31.0.

**Version 2.14.0 (2021/06/08)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Updated the 'wpsso_get_sortable_columns' filter for WPSSO Core v8.30.0.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.30.0.

**Version 2.13.1 (2021/02/25)**

* **New Features**
	* None.
* **Improvements**
	* Updated the banners and icons of WPSSO Core and its add-ons.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.25.2.

**Version 2.13.0 (2021/01/21)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Changed `jQuery( document ).on( 'ready' )` event handlers to `jQuery()` for jQuery v3.0.
	* Renamed 'get_og_type_reviews()' to 'get_mt_reviews()' for WPSSO v8.20.0.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.20.0.

**Version 2.12.0 (2020/12/04)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Included the `$addon` argument for library class constructors.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.16.0.

**Version 2.11.1 (2020/10/17)**

* **New Features**
	* None.
* **Improvements**
	* Refactored the add-on class to extend a new WpssoAddOn abstract class.
* **Bugfixes**
	* Fixed backwards compatibility with older 'init_objects' and 'init_plugin' action arguments.
* **Developer Notes**
	* Added a new WpssoAddOn class in lib/abstracts/add-on.php.
	* Added a new SucomAddOn class in lib/abstracts/com/add-on.php.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.4.
	* WPSSO Core v8.13.0.

== Upgrade Notice ==

= 2.15.2 =

(2021/10/18) Fixed an extra newline character, that was converted to a line-break, in comment text.

= 2.15.1 =

(2021/10/06) Standardized `get_table_rows()` calls and filters in 'submenu' and 'sitesubmenu' classes.

= 2.15.0 =

(2021/09/24) Fixed saving star rating colors in the SSO &gt; Ratings / Reviews settings page.

= 2.14.2 =

(2021/06/27) Added a conflict check for the new "Ratings and Reviews Service" option in WPSSO Core v8.33.0.

= 2.14.1 =

(2021/06/18) Updated the 'wpsso-rar-script' localized variable names.

= 2.14.0 =

(2021/06/08) Updated the 'wpsso_get_sortable_columns' filter for WPSSO Core v8.30.0.

= 2.13.1 =

(2021/02/25) Updated the banners and icons of WPSSO Core and its add-ons.

= 2.13.0 =

(2021/01/21) Changed `jQuery( document ).on( 'ready' )` event handlers to `jQuery()` for jQuery v3.0.

= 2.12.0 =

(2020/12/04) Included the `$addon` argument for library class constructors.

= 2.11.1 =

(2020/10/17) Refactored the add-on class to extend a new WpssoAddOn abstract class.

