<?php

ini_set('display_errors', 1);

/**
 * Theme only works in WordPress 5.0 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
	exit("Update Wordpress to 5.0 or later to use this theme.");
}

class Functions {
    function __construct() {
        add_action( 'admin_menu',                   array( $this, 'menu_organisation'));
        add_action( 'after_setup_theme',            array( $this, 'init' ) );
        add_action( 'init',                         array( $this, 'register'));
        add_action( 'init',                         array( $this, 'rewrite_rules'));
        add_filter( 'query_vars',                   array( $this, 'custom_query_vars' ));
        add_action( 'template_redirect',            array( $this, 'change_search_url' ));
        add_action( 'wp_enqueue_scripts',           array( $this, 'scripts' ) );
        add_filter( 'get_search_form',              array( $this, 'search_form' ) );
		add_filter( 'wp_die_handler',          array( $this, 'custom_wp_die_handler' ));
    }

	/**
     * Customize logout confirmation template
     *
     * @param $message
     * @param string $title
     * @param array $args
     */
    function custom_wp_die_handler ( $message, $title = '', $args = array() ) {
        $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
        $title = __( 'Log Out.' );
        $message       = sprintf(
            __( '<p>You are attempting to log out of your In Essence Account.</p><p> Are you sure you would like to <a href="%s">log out</a>?</p>' ),
            wp_logout_url( $redirect_to )
        );
        list( $message, $title, $parsed_args ) = _wp_die_process_input( $message, $title, $args );

        if ( is_string( $message ) ) {
            if ( ! empty( $parsed_args['additional_errors'] ) ) {
                $message = array_merge(
                    array( $message ),
                    wp_list_pluck( $parsed_args['additional_errors'], 'message' )
                );
                $message = "<ul>\n\t\t<li>" . join( "</li>\n\t\t<li>", $message ) . "</li>\n\t</ul>";
            }

            $message = sprintf(
                '<div class="wp-die-message">%s</div>',
                $message
            );
        }

        $have_gettext = function_exists( '__' );

        if ( ! empty( $parsed_args['link_url'] ) && ! empty( $parsed_args['link_text'] ) ) {
            $link_url = $parsed_args['link_url'];
            if ( function_exists( 'esc_url' ) ) {
                $link_url = esc_url( $link_url );
            }
            $link_text = $parsed_args['link_text'];
            $message  .= "\n<p><a href='{$link_url}'>{$link_text}</a></p>";
        }

        if ( isset( $parsed_args['back_link'] ) && $parsed_args['back_link'] ) {
            $back_text = $have_gettext ? __( '&laquo; Back' ) : '&laquo; Back';
            $message  .= "\n<p><a href='javascript:history.back()'>$back_text</a></p>";
        }

        if ( ! did_action( 'admin_head' ) ) :
            if ( ! headers_sent() ) {
                header( "Content-Type: text/html; charset={$parsed_args['charset']}" );
                status_header( $parsed_args['response'] );
                nocache_headers();
            }

            $text_direction = $parsed_args['text_direction'];
            if ( function_exists( 'language_attributes' ) && function_exists( 'is_rtl' ) ) {
                $dir_attr = get_language_attributes();
            } else {
                $dir_attr = "dir='$text_direction'";
            }
            ?>
            <!DOCTYPE html>
            <html xmlns="http://www.w3.org/1999/xhtml" <?php echo $dir_attr; ?>>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $parsed_args['charset']; ?>" />
                <meta name="viewport" content="width=device-width">
                <?php
                if ( function_exists( 'wp_no_robots' ) ) {
                    wp_no_robots();
                }
                ?>
                <title><?php echo $title; ?></title>
                <style type="text/css">
                    body {
                        color: #2C2A29;
                        font-family: 'Roboto', sans-serif;
                        font-size: 15px;
                        margin: 0;
                    }

                    .account-page-title {
                        margin: 1.75em 0;
                    }

                    h1 {
                        clear: both;
                        font-family: 'Georgia', serif;
                        font-size: 2.25em;
                        font-weight: 700;
                        color: #2C2A29;
                    }
                    .wp-die-message {
                        line-height: 1.5;
                        padding: 30px 150px;
                        height: 100%;
                    }
                    ul li {
                        margin-bottom: 10px;
                        font-size: 14px ;
                    }
                    a {
                        color: #2C2A29;
                    }

                    .logo-wrap img{
                        min-width: 270px;
                    }

                    .wrapper {
                        max-width: 1345px;
                        margin: 50px auto;
                        padding: 0 2.4rem;
                    }

                    .background-color-paleslate {
                        background-color: #F6F9FC;
                        display: flex;
                        justify-content: center;
                    }

                    .header-logo {
                        margin-bottom: 100px;
                    }

                    .wp-die-message {
                        margin: 60px;
                        background: #FFF;
                        border: solid .5px #B8B8B8;
                        margin: 90px auto;
                        padding: 70px 185px;
                        text-align: center;
                    }

                    .wp-die-message p {
                        margin: 0;
                    }

                    @media (max-width: 767px) {
                        .wp-die-message {
                            padding: 70px;
                        }
                    }
                </style>
            </head>
            <body id="error-page" class="custom-wp-die-handle">
        <?php endif; // ! did_action( 'admin_head' ) ?>
        <div class="header-logo wrapper">
            <a href="<?php echo get_site_url(); ?>" class="logo-wrap">
                <img src="<?php echo get_template_directory_uri(  ); ?>/images/inessence-logo.svg" alt="inessence-logo" >
            </a>
        </div>
        <div class="page-title wrapper">
            <h1 class="account-page-title">Log Out.</h1>
        </div>
        <div class="background-color-paleslate">
            <?php echo $message; ?>
        </div>
    </body>
        </html>
        <?php
        if ( $parsed_args['exit'] ) {
            die();
        }
    }
	
    /***
     * REWRITE RULES
     */

    function rewrite_rules() {
        add_rewrite_rule('^search/([^/]*)/?', 'index.php?s=$matches[1]', 'top');
    }

    /***
     *  CUSTOM QUERY VARS
     */

    function custom_query_vars( $vars ){
        $vars[] = "section";
        return $vars;
    }

    /***
     *  INIT THEME SETTINGS
     */
    
    public function init() {
        /*
         *  THEME SUPPORT
         */
        add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
        );

        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 1568, 9999 );
        
        add_theme_support( 'title-tag' );


		add_image_size( '386x386', 386, 386, true );
		add_image_size( 'fullsize', 1568, 9999, false );

        
        /*
         *  REGISTER MENUS
         */ 
        register_nav_menus(
			array(
                'header' => __( 'Header Menu', 'oilgarden' ),
                'footer' => __( 'Footer Menu', 'oilgarden' )
			)
        );

        /*
         *  ADD OPTIONS PAGE
         */
        if( function_exists('acf_add_options_page') ) {
	
            acf_add_options_page(array(
                'page_title' 	=> 'Theme Settings',
                'menu_title'	=> 'Theme Settings',
                'menu_slug' 	=> 'theme-settings',
                'capability'	=> 'edit_posts',
            ));

            acf_add_options_sub_page(array(
                'page_title' 	=> 'General',
                'menu_title'	=> 'General',
                'parent_slug'	=> 'theme-settings',
            ));

            acf_add_options_sub_page(array(
                'page_title' 	=> 'Shop',
                'menu_title'	=> 'Shop',
                'parent_slug'	=> 'theme-settings',
            ));
        }
    }


    /***
     *  ENQUEUE SCRIPTS FOR SITE
     */

    public function scripts() {


		if (!is_admin()) {
		
			//add in my own script
			function my_scripts() {
				wp_register_script('swiper', get_template_directory_uri().'/js/swiper.js', array(), '1', true);
				wp_enqueue_script('swiper', get_template_directory_uri().'/js/swiper.js', array(), '1', true);
	
	
				wp_register_script('myscripts', get_template_directory_uri().'/js/scripts.js', array('jquery'), '1.5', true);
				wp_enqueue_script('myscripts', get_template_directory_uri().'/js/scripts.js', array('jquery'), '1.5', true);
		
			}
			add_action( 'wp_enqueue_scripts', 'my_scripts', 50, 1);
	
		} 

		wp_enqueue_script( 'insider',  "//inessence.api.useinsider.com/ins.js?id=10003108", array(), '3.4.1', true );

		wp_enqueue_script( 'zendesk',  get_template_directory_uri() . '/js/zendesk.js', array(), '2.0', true );

		if(
			is_page( 'account-profile' )
			|| is_page( 'addresses' )
			|| is_page( 'order-history' )
			|| is_page( 'wish-lists' )
			|| is_page( 'login' )
		){ 


			function my_accountscripts() {
				wp_register_script('account', get_template_directory_uri().'/js/account.js', array('myscripts'), '1', true);
				wp_enqueue_script('account', get_template_directory_uri().'/js/account.js', array('myscripts'), '1', true);
		
			}
			add_action( 'wp_enqueue_scripts', 'my_accountscripts', 50, 1);

	

		}

    }















    /***
     * CUSTOM POST TYPES AND TAXONOMIES
     */
    
    function register() {
        
    }

    /*** 
     *  ADMIN MENU ORGANISATION 
     */

    function menu_organisation() {
        global $menu;
        global $submenu;
    }

    /***
     *  RESOURCES SEARCH URL CHANGE
     */
    
    function change_search_url() {
        if ( is_search() && ! empty( $_GET['s'] ) ) {
            wp_redirect( home_url( "/search/" ) . urlencode( strtolower( get_query_var( 's' ) ) ) . "/" );
            exit();
        }   
    }

    /***
     *  GET COMPONENT FUNCTION
     */

    function get_component($component) {
        include get_template_directory()."/components/".$component.".php";
    }

    /***
     *  SUPPORTIVE FUNCTIONS
     */

     function clean_string($string) {
         return strtolower(trim(preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $string))), '-'));
     }
}

$func = new Functions();



function slug($z){
    $z = strtolower($z);
    $z = preg_replace('/[^a-z0-9 -]+/', '', $z);
    $z = str_replace(' ', '-', $z);
    return trim($z, '-');
}

function formatAsPrice($number){
	return '$'.number_format((float)$number, 2, '.', '');	
}





function my_custom_post_source() {
	$type_singular = 'Source';
	$type_plural = 'Source';
	$type_slug = 'source';

	$labels = array(
		'name'               => _x( $type_singular, 'post type general name' ),
		'singular_name'      => _x( $type_singular, 'post type singular name' ),
		'add_new'            => _x( 'Add New', $type_singular ),
		'add_new_item'       => __( 'Add New '.$type_singular ),
		'edit_item'          => __( 'Edit '.$type_singular ),
		'new_item'           => __( 'New '.$type_singular ),
		'all_items'          => __( 'All ' . $type_plural ),
		'view_item'          => __( 'View '.$type_singular ),
		'search_items'       => __( 'Search '.$type_plural ),
		'not_found'          => __( 'No '.$type_plural.' found' ),
		'not_found_in_trash' => __( 'No '.$type_plural.' found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => $type_plural,
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our ' . $type_plural,
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'   => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true
	);
	register_post_type( $type_slug, $args ); 
}
add_action( 'init', 'my_custom_post_source' );





function my_custom_post_region() {
	$type_singular = 'Region';
	$type_plural = 'Regions';
	$type_slug = 'region';

	$labels = array(
		'name'               => _x( $type_singular, 'post type general name' ),
		'singular_name'      => _x( $type_singular, 'post type singular name' ),
		'add_new'            => _x( 'Add New', $type_singular ),
		'add_new_item'       => __( 'Add New '.$type_singular ),
		'edit_item'          => __( 'Edit '.$type_singular ),
		'new_item'           => __( 'New '.$type_singular ),
		'all_items'          => __( 'All ' . $type_plural ),
		'view_item'          => __( 'View '.$type_singular ),
		'search_items'       => __( 'Search '.$type_plural ),
		'not_found'          => __( 'No '.$type_plural.' found' ),
		'not_found_in_trash' => __( 'No '.$type_plural.' found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => $type_plural,
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our ' . $type_plural,
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'   => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true
	);
	register_post_type( $type_slug, $args ); 
}
add_action( 'init', 'my_custom_post_region' );


function my_custom_post_feature() {
	$type_singular = 'Feature';
	$type_plural = 'Features';
	$type_slug = 'feature';

	$labels = array(
		'name'               => _x( $type_singular, 'post type general name' ),
		'singular_name'      => _x( $type_singular, 'post type singular name' ),
		'add_new'            => _x( 'Add New', $type_singular ),
		'add_new_item'       => __( 'Add New '.$type_singular ),
		'edit_item'          => __( 'Edit '.$type_singular ),
		'new_item'           => __( 'New '.$type_singular ),
		'all_items'          => __( 'All ' . $type_plural ),
		'view_item'          => __( 'View '.$type_singular ),
		'search_items'       => __( 'Search '.$type_plural ),
		'not_found'          => __( 'No '.$type_plural.' found' ),
		'not_found_in_trash' => __( 'No '.$type_plural.' found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => $type_plural,
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our ' . $type_plural,
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'thumbnail' ),
		'has_archive'   => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true
	);
	register_post_type( $type_slug, $args ); 
}
add_action( 'init', 'my_custom_post_feature' );




function searchproductsonly($query) {
	if (!$query->is_admin && $query->is_search) {
		$query->set('post_type', array('bigcommerce_product','post', 'page'));

		$query->set('posts_per_page', -1);
	}
	return $query;
}
add_filter('pre_get_posts', 'searchproductsonly');


function showallproducts($query) {
	if (!$query->is_admin) {
		$query->set('posts_per_page', -1);
	
		return $query;
	}
}
add_filter('pre_get_posts', 'showallproducts');



add_filter('wpseo_title', 'filter_product_wpseo_title');
function filter_product_wpseo_title($title) {
	
	$taxonomySlug = get_queried_object()->slug;
	foreach(get_field( 'banners', 'options' ) as $banner){ 
		if($banner['slug'] == $taxonomySlug){
			if($banner['seo_title'] <> "")
				$title = $banner['seo_title'];
		}
	}

    return $title;
}

add_filter('wpseo_metadesc', 'filter_product_wpseo_metadesc');
function filter_product_wpseo_metadesc($description) {
	
	$taxonomySlug = get_queried_object()->slug;
	foreach(get_field( 'banners', 'options' ) as $banner){ 
		if($banner['slug'] == $taxonomySlug){
			if($banner['seo_description'] <> "")
				$description = $banner['seo_description'];
		}
	}

    return $description;
}


// add_filter('upload_dir', 'fetch_live_upload_files');;
function fetch_live_upload_files( $param ){
    $mydir = '/uploads';
    $path = '/var/www/inessence/wp-content';
    $url = 'https://www.inessence.com.au/';
  
    $param['path'] = $path . $mydir . $param['subdir'];
    $param['url'] = $url . '/wp-content' . $mydir . $param['subdir'];
    $param['basedir'] = $path . $mydir;
    $param['baseurl'] = $url .'/wp-content' . $mydir;

    return $param;
}

add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}




	/* 	Search SKU 
	================================================ */

	function list_searcheable(){
	  $list_searcheable = array(  
		"bigcommerce_sku",
		"full_description"
	);

	return $list_searcheable;
	}

	function advanced_custom_search( $where, $wp_query ) {
	    global $wpdb;
	
	    if ( empty( $where ))
	        return $where;
	
	    // get search expression
	    $terms = $wp_query->query_vars[ 's' ];
	
	    // explode search expression to get search terms
	    $exploded = explode( ' ', $terms );
	    if( $exploded === FALSE || count( $exploded ) == 0 )
	        $exploded = array( 0 => $terms );
	
	    // reset search in order to rebuilt it as we whish
	    $where = '';
	
	    // get searcheable_acf, a list of advanced custom fields you want to search content in
	    $list_searcheable = list_searcheable();
	    foreach( $exploded as $tag ) :
	        $where .= " 
	          AND (
	            (wp_posts.post_title LIKE '%$tag%')
	            OR (wp_posts.post_content LIKE '%$tag%')
	            OR EXISTS (
	              SELECT * FROM wp_postmeta
	                  WHERE post_id = wp_posts.ID
	                    AND (";
	        foreach ($list_searcheable as $searcheable_acf) :
	          if ($searcheable_acf == $list_searcheable[0]):
	            $where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
	          else :
	            $where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
	          endif;
	        endforeach;
	            $where .= ")
	            )
	            OR EXISTS (
	              SELECT * FROM wp_comments
	              WHERE comment_post_ID = wp_posts.ID
	                AND comment_content LIKE '%$tag%'
	            )
	            OR EXISTS (
	              SELECT * FROM wp_terms
	              INNER JOIN wp_term_taxonomy
	                ON wp_term_taxonomy.term_id = wp_terms.term_id
	              INNER JOIN wp_term_relationships
	                ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
	              WHERE (
	                taxonomy = 'post_tag'
	                    OR taxonomy = 'category'                
	                    OR taxonomy = 'myCustomTax'
	                )
	                AND object_id = wp_posts.ID
	                AND wp_terms.name LIKE '%$tag%'
	            )
	        )";
	    endforeach;
	    return $where;
	}
	
	add_filter( 'posts_search', 'advanced_custom_search', 500, 2 );

	add_action('user_register', function($user_id){
		
		$user = get_user_by('id', $user_id);
	
		$user_login = stripslashes($user->user_login);
		$user_email = stripslashes($user->user_email);
	
		$message  = __('Hi there,') . "\r\n\r\n";
		$message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
		$message .= wp_login_url() . "\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n";
		$message .= sprintf(__('Password: %s'), "Password you specified in the form") . "\r\n\r\n";
		$message .= sprintf(__('If you have any problems, please contact me at %s.'), 'customer.service@inessence.com.au') . "\r\n\r\n";
	
		wp_mail($user_email, sprintf(__('[%s] -  New User Registration'), get_option('blogname')) , $message);
		
	});

// Set to -1 to not set a default customer group for visibility 
// (using 0 will pull in the first customer group from BC) -
const DEFAULT_CUSTOMER_GROUP_ID = 8;

function set_default_customer_group($group, $customer) {
 if ($customer->get_customer_id() === 0) {
  return DEFAULT_CUSTOMER_GROUP_ID;
 }
	return $group;
}
add_filter('bigcommerce/customer/group_id', 'set_default_customer_group', 10, 2);

function truncate_number( $number, $precision = 2) {
    // Zero causes issues, and no need to truncate
    if ( 0 == (int)$number ) {
        return $number;
    }
    // Are we negative?
    $negative = $number / abs($number);
    // Cast the number to a positive to solve rounding
    $number = abs($number);
    // Calculate precision number for dividing / multiplying
    $precision = pow(10, $precision);
    // Run the math, re-applying the negative value to ensure returns correctly negative / positive
    return floor( $number * $precision ) / $precision * $negative;
}


// function set_default_customer_group_pricing() {
// 	return DEFAULT_CUSTOMER_GROUP_ID;
// }
// add_filter('bigcommerce/pricing/customer_group_id', 'set_default_customer_group_pricing', 10, 2);

function disable_emojis() {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
}
 
add_action( 'init', 'disable_emojis' );