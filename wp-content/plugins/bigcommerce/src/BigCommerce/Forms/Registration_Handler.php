<?php


namespace BigCommerce\Forms;

use BigCommerce\Accounts\Customer;
use BigCommerce\Accounts\Login;
use BigCommerce\Accounts\Roles\Customer as Customer_Role;
use BigCommerce\Accounts\User_Profile_Settings;
use BigCommerce\Pages\Account_Page;
use BigCommerce\Compatibility\Spam_Checker;
use BigCommerce\Settings\Sections\Account_Settings;
use BigCommerce\Api\Store_Api;
use BigCommerce\Merchant\Onboarding_Api;
use BigCommerce\Settings\Sections\Api_Credentials;
use BigCommerce\Taxonomies\Channel\Channel;
use BigCommerce\Taxonomies\Channel\Connections;
use BigCommerce\Exceptions\Channel_Not_Found_Exception;
use BigCommerce\Merchant\Models\Customer_Login_Request;

class Registration_Handler implements Form_Handler {

	const ACTION = 'register-account';
	const PROD_BC_MY_ACCOUNT_PAGE_LINK = 'https://shop.inessence.com.au/account.php?action=account_details';

	/**
	 * @var Spam_Checker
	 */
	private $spam_checker;

    /**
     * @var Onboarding_Api
     */
    private $onboarding;

    /**
     * @var Store_Api
     */
    private $store;

	public function __construct( Spam_Checker $spam_checker, Onboarding_Api $onboarding, Store_Api $store ) {
		$this->spam_checker = $spam_checker;
        $this->onboarding = $onboarding;
        $this->store = $store;
    }
	
	/**
     * @param int $userId
     */
    public function set_login_token_for_redirect($userId = 0, $registrationUrl = '')
    {
        $registrationUrl = $registrationUrl ?: 'https://shop.inessence.com.au/account.php?action=account_details';
        $userId = $userId ?: get_current_user_id();
        $customer_id = (int) ( is_user_logged_in() || $userId ? get_user_option( Login::CUSTOMER_ID_META, $userId ) : 0 );
        $hash = $this->get_store_hash();
        $store_id = get_option( Onboarding_Api::STORE_ID, '' );
        $channel_id = $this->get_channel_id();

        if ( ! $customer_id || ! $hash ) {
            return $registrationUrl;
        }

        try {
            if ( $store_id ) {
                // for accounts created through the onboarding process
                $request = new Customer_Login_Request( $hash, $registrationUrl, $channel_id );
                $token = $this->onboarding->customer_login_token( $store_id, $customer_id, $request );
            } else {
                // for customers that set their own API keys in constants
                $token = $this->store->getCustomerLoginToken( $customer_id, $registrationUrl, '', $channel_id );
            }
        } catch ( \Exception $e ) {
        }

        try {
            $store        = $this->store->getStore();
            $registrationUrl = $store->secure_url . '/login/token/' . $token;
        } catch ( \Exception $e ) {
        }
        
        return $registrationUrl;
    }

	/**
     * Get the store hash from the API URL
     *
     * @return string
     */
    private function get_store_hash() {
        $url = get_option( Api_Credentials::OPTION_STORE_URL, '' );
        if ( empty( $url ) ) {
            return '';
        }
        preg_match( '#stores/([^\/]+)/#', $url, $matches );
        if ( empty( $matches[ 1 ] ) ) {
            return '';
        } else {
            return $matches[ 1 ];
        }
    }
	
	private function get_channel_id() {
        try {
            $connections = new Connections();
            $current = $connections->current();
            return (int) get_term_meta( $current->term_id, Channel::CHANNEL_ID, true );
        } catch ( Channel_Not_Found_Exception $e ) {
            return 0;
        }
    }
	
	public function handle_request( $submission ) {

		if ( ! $this->should_handle_request( $submission ) ) {
			return;
		}

		$errors = $this->validate_submission( $submission );


		$password = $submission[ 'bc-register' ][ 'new_password' ];
		// prevent logging sensitive information in plain text
		unset( $submission[ 'bc-register' ][ 'new_password' ] );
		unset( $submission[ 'bc-register' ][ 'confirm_password' ] );

		if ( count( $errors->get_error_codes() ) > 0 ) {

			/**
			 * Triggered when a form has errors that prevent completion.
			 *
			 * @param \WP_Error $errors     The message that will display to the user
			 * @param array     $submission The data submitted to the form
			 */
			do_action( 'bigcommerce/form/error', $errors, $submission );

			return;
		}

		$profile = $this->get_profile( $submission[ 'bc-register' ] );

		$address = $this->get_address( $submission[ 'bc-register' ] );

		// create the user
		// be sure to trim the email down to 60 characters to meet WP table limits for username
		$user_id = wp_create_user( mb_substr( $profile[ 'email' ], 0, 60 ), $password, $profile[ 'email' ] );

		if ( is_wp_error( $user_id ) ) {
			switch ( $user_id->get_error_code() ) {
				case 'existing_user_email':
					$errors->add( 'email', $user_id->get_error_message() );
					break;
				case 'existing_user_login':
					$errors->add( 'email', __( 'Sorry, that email address is already used!', 'bigcommerce' ) );
					break;
				case 'empty_user_login':
				case 'user_login_too_long':
				case 'invalid_username':
					$errors->add( 'email', __( 'Please verify that you have submitted a valid email address.', 'bigcommerce' ) );
					break;
				default:
					$errors->add( $user_id->get_error_code(), $user_id->get_error_message() );
					break;
			}
			do_action( 'bigcommerce/form/error', $errors, $submission );

			return;
		}


		/**
		 * Log the user in, automatically connecting the user with BigCommerce
		 * and setting up the profile with the submitted data
		 *
		 * @see \BigCommerce\Accounts\Login::connect_customer_id()
		 */
		$profile_filter = function ( $data ) use ( $profile, $password ) {
			$data = $profile;

			$data[ '_authentication' ][ 'password' ] = $password;

			return $data;
		};
		add_filter( 'bigcommerce/customer/create/args', $profile_filter, 10, 1 );

		wp_signon( [
			'user_login'    => $profile[ 'email' ],
			'user_password' => $password,
			'remember'      => true,
		] );

		remove_filter( 'bigcommerce/customer/create/args', $profile_filter, 10 );

		$user = new \WP_User( $user_id );

		/** This filter is documented in src/BigCommerce/Accounts/Login.php */
		$role = apply_filters( 'bigcommerce/user/default_role', Customer_Role::NAME );
		$user->set_role( $role );
		// all future password validation will be against the API for this user
		update_user_meta( $user_id, User_Profile_Settings::SYNC_PASSWORD, true );

		wp_set_current_user( $user_id );

		$customer = new Customer( $user_id );
		$customer->add_address( $address );

		$profile_page = get_option( Account_Page::NAME, 0 );

		$url = $profile_page ? get_permalink( $profile_page ) : home_url();

		/**
		 * The message to display when an account is created
		 *
		 * @param string $message
		 */
		$message = apply_filters( 'bigcommerce/form/registration/success_message', __( 'Account created!', 'bigcommerce' ) );

		// custom function redirect to BigCommerce page after register
        $this->set_login_token_for_redirect();
		
		/**
		 * Triggered when a form is successfully processed.
		 *
		 * @param string $message The message that will display to the user
		 * @param array  $submission The data submitted with the form
		 * @param string $url     The URL to redirect the user to
		 * @param array  $data    Optional data about the submission
		 */
		do_action( 'bigcommerce/form/success', $message, $submission, $url, [ 'key' => 'account_created' ] );
	}

	private function should_handle_request( $submission ) {
		if ( is_user_logged_in() ) {
			return false;
		}
		if ( ! get_option( 'users_can_register' ) ) {
			return false;
		}
		if ( empty( $submission[ 'bc-action' ] ) || $submission[ 'bc-action' ] !== self::ACTION ) {
			return false;
		}
		if ( empty( $submission[ '_wpnonce' ] ) || empty( $submission[ 'bc-register' ] ) ) {
			return false;
		}

		return true;
	}

	private function validate_submission( $submission ) {
		$errors = new \WP_Error();

		if ( ! wp_verify_nonce( $submission[ '_wpnonce' ], self::ACTION ) ) {
			$errors->add( 'invalid_nonce', __( 'There was an error validating your request. Please try again.', 'bigcommerce' ) );
		}

		// Required for customer creation
		if ( empty( $submission[ 'bc-register' ][ 'first_name' ] ) ) {
			$errors->add( 'first_name', __( 'First Name is required.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'last_name' ] ) ) {
			$errors->add( 'last_name', __( 'Last Name is required.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'email' ] ) ) {
			$errors->add( 'email', __( 'Email Address is required.', 'bigcommerce' ) );
		} elseif ( ! is_email( $submission[ 'bc-register' ][ 'email' ] ) ) {
			$errors->add( 'email', __( 'Please verify that you have submitted a valid email address.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'new_password' ] ) ) {
			$errors->add( 'new_password', __( 'Please set your password.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'confirm_password' ] ) ) {
			$errors->add( 'confirm_password', __( 'Please confirm your password.', 'bigcommerce' ) );
		} elseif ( $submission[ 'bc-register' ][ 'new_password' ] !== $submission[ 'bc-register' ][ 'confirm_password' ] ) {
			$errors->add( 'confirm_password', __( 'Passwords do not match.', 'bigcommerce' ) );
		}
		if ( ! $this->validate_password( $submission[ 'bc-register' ][ 'new_password' ] ) ) {
			$errors->add( 'new_password', __( 'Your new password must be a minimum of 8 characters and contain an uppercase letter, a lowercase letter, a number, and a punctuation mark or symbol.', 'bigcommerce' ) );
		}

		// Required for address creation
		if ( empty( $submission[ 'bc-register' ][ 'phone' ] ) ) {
			$errors->add( 'phone', __( 'Phone number is required.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'street_1' ] ) ) {
			$errors->add( 'street_1', __( 'Address Line 1 is required.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'city' ] ) ) {
			$errors->add( 'city', __( 'City is required.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'state' ] ) ) {
			$errors->add( 'state', __( 'State/Province is required.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'zip' ] ) ) {
			$errors->add( 'zip', __( 'Zip/Postcode is required.', 'bigcommerce' ) );
		}
		if ( empty( $submission[ 'bc-register' ][ 'country' ] ) ) {
			$errors->add( 'country', __( 'Country is required.', 'bigcommerce' ) );
		}

		if ( ! count( $errors->get_error_codes() ) && $this->is_spam( $submission[ 'bc-register' ] ) ) {
			$errors->add( 'is_spam', __( 'This user registration was flagged as spam. Please try registering again with different information.', 'bigcommerce' ) );
		}

		/**
		 * Filters update registration form errors.
		 *
		 * @param \WP_Error $errors     WP error.
		 * @param array     $submission Submitted data.
		 */
		$errors = apply_filters( 'bigcommerce/form/registration/errors', $errors, $submission );

		return $errors;
	}

	private function is_spam( $submission ) {
		$spam_check_enabled = (bool) get_option( Account_Settings::REGISTRATION_SPAM_CHECK );
		if ( ! $spam_check_enabled ) {
			return false;
		}

		return $this->spam_checker->is_spam( [
			'first_name' => $submission['first_name'],
			'last_name'  => $submission['last_name'],
			'email'      => $submission['email'],
		] );
	}

	private function validate_password( $password ) {
		if ( strlen( $password ) < 8 ) {
			return false;
		}

		if ( ! preg_match( '/\d/', $password ) ) {
			return false;
		}

		$has_punct = false;
		$has_lower = false;
		$has_upper = false;
		foreach ( str_split( $password ) as $char) {
			if ( ctype_punct( $char ) ) {
				$has_punct = true;
			}
			if ( ctype_lower( $char ) ) {
				$has_lower = true;
			}
			if ( ctype_upper( $char ) ) {
				$has_upper = true;
			}
		}

		return $has_punct && $has_lower && $has_upper;
	}

	private function get_profile( $submitted_profile ) {
		$defaults          = [
			'first_name' => '',
			'last_name'  => '',
			'company'    => '',
			'email'      => '',
			'phone'      => '',
		];
		$submitted_profile = array_filter( $submitted_profile, function ( $key ) use ( $defaults ) {
			return array_key_exists( $key, $defaults );
		}, ARRAY_FILTER_USE_KEY );

		$profile = wp_parse_args( $submitted_profile, $defaults );

		foreach ( $profile as $key => &$value ) {
			if ( $key === 'email' ) {
				$value = sanitize_email( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
		}

		return $profile;
	}

	private function get_address( $submitted_address ) {
		$defaults          = [
			'first_name' => '',
			'last_name'  => '',
			'company'    => '',
			'street_1'   => '',
			'street_2'   => '',
			'city'       => '',
			'state'      => '',
			'zip'        => '',
			'country'    => '',
			'phone'      => '',
		];
		$submitted_address = array_filter( $submitted_address, function ( $key ) use ( $defaults ) {
			return array_key_exists( $key, $defaults );
		}, ARRAY_FILTER_USE_KEY );
		$address           = wp_parse_args( $submitted_address, $defaults );
		$address = array_map( 'sanitize_text_field', $address );

		return $address;
	}
}