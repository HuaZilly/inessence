<?php

function cbsb_new_free_trial() {

	$user = wp_get_current_user();
	$hash = md5($user->data->user_email . '_' . get_site_url() . '_' . time());

	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) { 
		$ip = $_SERVER['HTTP_CLIENT_IP']; 
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
	} else { 
		$ip = $_SERVER['REMOTE_ADDR']; 
	}

	$body = array_filter( array(
		'source'         => 'plugin',
		'channel_source' => 'wp',
		'login_hash'     => $hash,
		'website'        => get_site_url(),
		'timezone'       => sanitize_post( $_POST['timezone'] ),
		'ip'             => $ip
	) );

	$http_response = wp_remote_post( CBSB_APP_URL . 'api/v1/register', array( 'timeout' => 20, 'body' => $body ) );
	$http_body = wp_remote_retrieve_body( $http_response );
	$json = json_decode( $http_body );

	if ( property_exists( $json, 'error' ) ) {

		$response = array( 'status' => 'error', 'message' => $json->error, 'reload' => false );

	} else {

		if ( isset( $json->data ) ) {

			update_option( 'cbsb_connection', (array) $json->data->tokens );

			// If they don't have a booking page, create one
			if ( false == get_option( 'cbsb_booking_page' ) && !has_book_now_page()) {
				cbsb_create_booking_page( 'Book Now' );
			}

			update_option( 'cbsb_login_hash', $hash );
			
			update_option( 'cbsb_trial_ends_at', time() + (DAY_IN_SECONDS * 14) );

			$response = array( 'status' => 'success', 'message' => __('Processing', 'calendar-booking') . '...', 'reload' => false );

		} else {

			$response = array( 'status' => 'error', 'message' => __('Invalid response from startbooking.com.', 'calendar-booking'), 'reload' => false );
		}
	}

	wp_send_json( $response );
}
add_action( 'wp_ajax_cbsb_new_free_trial', 'cbsb_new_free_trial' );

function cbsb_check_free_trial() {
	$data = cbsb_api_request('register_check', $params = array(), $method = 'GET', $duration = 0);

	if ($data->ready) {
		$response = array( 'status' => $data->message, 'reload' => true);
	} else {
		$response = array( 'status' => $data->message, 'reload' => false);
	}

	wp_send_json( $response );
}
add_action( 'wp_ajax_cbsb_check_free_trial', 'cbsb_check_free_trial' );

function cbsb_app_connect_account() {

	global $wp_version;

	$email = sanitize_email( $_POST['email'] );
	$password = sanitize_post( $_POST['password'] );
	$account_id = ( isset( $_POST['account_id'] ) ) ? sanitize_text_field( $_POST['account_id'] ) : false;

	$user = wp_get_current_user();
	$hash = md5($user->data->user_email . '_' . get_site_url() . '_' . time());

	$body = array_filter( array(
		'email'       => $email,
		'password'    => $password,
		'website'     => get_site_url(),
		'account_id'  => $account_id,
		'hash'        => $hash,
		'scopes'      => ['booking-flow', 'wp-admin']
	) );

	$args = array(
		'user-agent'  => 'WP:BK:API/' . $wp_version . ':' . CBSB_VERSION . ':CBSB_Api; ' . home_url(),
		'blocking'    => true,
		'headers'     => array(
			'Accept'        => 'application/json',
			'Content-Type'  => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest'
		),
		'timeout'     => 20,
		'body' => json_encode( $body )
	);

	$http_response = wp_remote_post( CBSB_APP_URL . 'api/v1/initialize', $args );
	$http_body = wp_remote_retrieve_body( $http_response );
	$json = json_decode( $http_body );

	if ( property_exists( $json, 'error' ) && __('Invalid API Credentials', 'calendar-booking') == $json->error ) {
		$json->errors = array( 'password' => __('Invalid Password', 'calendar-booking') );
	}

	if ( property_exists( $json, 'errors' ) ) {

		$response = array(
			'status' => 'error',
			'message' => __('Invalid Authentication.', 'calendar-booking'),
			'reload' => false,
			'code' => 422,
			'errors' => $json->errors
		);

	} else {

		if ( isset( $json->tokens ) ) {

			update_option( 'cbsb_connection', (array) $json->tokens );

			// If they don't have a booking page, create one
			if ( false == get_option( 'cbsb_booking_page' ) && !has_book_now_page()) {
				cbsb_create_booking_page( 'Book Now' );
			}

			update_option( 'cbsb_login_hash', $hash );

			$response = array( 'status' => 'success', 'message' => __('Connection Established.', 'calendar-booking'), 'reload' => true );

		} else {

			$response = array( 'status' => 'error', 'message' => __('Invalid credentials. Contact Support at startbooking.com', 'calendar-booking'), 'reload' => false );
		}
	}

	wp_send_json( $response );
}
add_action( 'wp_ajax_cbsb_app_connect_account', 'cbsb_app_connect_account' );

function cbsb_access_account() {

	$hash = get_option('cbsb_login_hash');

	$body = array_filter( array(
		'website' => get_site_url(),
		'hash'    => $hash,
		'scopes'  => ['booking-flow', 'wp-admin']
	) );

	$http_response = wp_remote_post( CBSB_APP_URL . 'api/v1/initialize_access', array( 'timeout' => 20, 'body' => $body ) );
	$http_body = wp_remote_retrieve_body( $http_response );
	$json = json_decode( $http_body );

	if ( property_exists( $json, 'error' ) ) {

		$response = array( 'status' => 'error', 'message' => $json->error, 'reload' => false );

	} else {

		if ( isset( $json->tokens ) ) {

			update_option( 'cbsb_connection', (array) $json->tokens );

			$response = array( 'status' => 'success', 'message' => __('Connection Established.', 'calendar-booking'), 'reload' => true );

		} else {

			$response = array( 'status' => 'error', 'message' => __('Invalid response from startbooking.com.', 'calendar-booking'), 'reload' => false );
		}
	}

	wp_send_json( $response );
}
add_action( 'wp_ajax_cbsb_access_account', 'cbsb_access_account' );

function cbsb_get_booking_pages() {
	global $wpdb;
	$query = "SELECT ID, post_title, post_status, post_name FROM ".$wpdb->posts." WHERE (post_content LIKE '%[startbooking%' AND post_status = 'publish') OR (post_content LIKE '%wp:calendar-booking/%' AND post_status = 'publish')";
	$query_results = $wpdb->get_results($query);

	$query_results_as_array = array();
	foreach($query_results as $qr) {		
		$post = array();
		$post['id'] = (int) $qr->ID;
		$post['title'] = $qr->post_title;
		$post['slug'] = get_permalink($qr->ID);
		
		if ($post['slug'] === 'book-now') {
			$query_results_as_array = array_merge([$post], $query_results_as_array);
		} else {
			$query_results_as_array[] = $post;
		}
	}

	if (count($query_results_as_array) === 0) {
		$all_pages = get_pages(array('number' => 1));
		$p = array();
		$p['id'] = (int) $all_pages[0]->ID;
		$p['title'] = 'Book Now';
		$permalink = get_permalink($qr->ID);
		$p['slug'] = $permalink . '?cbsb_force=true';
		$query_results_as_array[] = $p;
	}

	$response = array( 
		'status' => 'success', 
		'pages' => $query_results_as_array
	);

	wp_send_json( $response );
}
add_action( 'wp_ajax_cbsb_get_booking_pages', 'cbsb_get_booking_pages' );

function has_book_now_page() {
     $page = get_page_by_path( 'book-now' , OBJECT );
     if ( isset($page) )
        return true;
     else
        return false;
}

function cbsb_disconnect_settings() {
	if ( isset( $_GET['startbooking-disconnect'] ) &&  $_GET['startbooking-disconnect'] ) {
		global $cbsb;
		delete_option( 'cbsb_connection' );
		delete_option( 'cbsb_service_type_map' );
		delete_option( 'widget_startbooking_hours_widget' );
		delete_option( 'widget_startbooking_address_widget' );
		delete_option( 'cbsb_connect_step' );
		delete_option( 'cbsb_onboard' );
		delete_option( 'cbsb_plan' );
		delete_option( 'cbsb_overview_step' );
		delete_option( 'cbsb_service_map' );
		$cbsb->clear_transients();
	}
}
add_action( 'admin_init', 'cbsb_disconnect_settings' );

function cbsb_migrate_token() {
	$hash = md5($user->data->user_email . '_' . get_site_url() . '_' . time());
	update_option( 'cbsb_login_hash', $hash );
	$data = (array) cbsb_api_request( 'migrations/wordpress/token-style', array( 'login_hash' => $hash ), 'GET', 0 );
	if ( is_array( $data ) && isset( $data['wp-admin'] ) && isset( $data['booking-flow'] ) ) {
		update_option( 'cbsb_connection', $data );
	}
}
add_action( 'cbsb_migrate_token_hook', 'cbsb_migrate_token', 10 );

function cbsb_token_check( $connection ) {
	if ( is_array( $connection ) && isset( $connection['token'] ) ) {
		$connection['wp-admin'] = $connection['token'];
		$connection['booking-flow'] = $connection['token'];
		$next = (int) wp_next_scheduled( 'cbsb_migrate_token_hook' );
		if ( $next < time() - 60 ) {
			wp_schedule_single_event( time(), 'cbsb_migrate_token_hook' );
		}
	}
	return $connection;
}
add_filter( 'option_cbsb_connection', 'cbsb_token_check' );