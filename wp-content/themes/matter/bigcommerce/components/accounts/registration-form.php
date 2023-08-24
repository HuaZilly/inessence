<?php
/**
 * @var array    $defaults
 * @var array    $countries
 * @var string[] $errors
 */

$error_class = 'bc-form__control--error';
?>

<section class="bc-account-page">



	<!-- data-js="bc-dynamic-fields" is required -->
	<form class="bc-form  bc-account-form--register <?php if ( ! empty( $errors ) ) { echo 'bc-form--has-errors'; } ?>" onsubmit='$(".loader-wrapper").show();' action="" enctype="multipart/form-data" method="post" data-js="bc-dynamic-fields">
		<div class="intro">
			<p>Already have an account? <a href="<?php echo get_site_url(); ?>/login">Log in</a></p>
		</div>

        <?php if ( ! empty( $errors ) ) {  global $wp_session;

            $bc_error    = filter_var_array( $_REQUEST, [ 'bc-error' => FILTER_SANITIZE_STRING ] );
            $stored_data = get_transient( $bc_error[ 'bc-error' ] );
            foreach ($stored_data['error']->errors as $error) { ?>
        <div class="error-message" style="padding: 24px; margin-bottom: 38px; border: 2px red solid; color: red; font-weight: 500;"> <?php echo $error[0];?> </div>
         <?php } ?>
            <?php } ?>

		<?php wp_nonce_field( 'register-account' ); ?>
		<input type="hidden" name="bc-action" value="register-account"/>
		<label class="bc-form__control bc-form-2col__control bc-form-2col__control--full <?php if ( in_array( 'email', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-email">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'Email Address', 'bigcommerce' ) ); ?></span>
			<input type="email" required name="bc-register[email]" id="bc-account-register-email" value="<?php echo esc_html( $defaults[ 'email' ] ); ?>" data-form-field="bc-form-field-email">
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'new_password', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-password">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'Password', 'bigcommerce' ) ); ?></span>
			<input type="password" required name="bc-register[new_password]" id="bc-account-register-password" value=""  data-form-field="bc-form-field-new_password">
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'confirm_password', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-confirm-password">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'Confirm Password', 'bigcommerce' ) ); ?></span>
			<input type="password" required name="bc-register[confirm_password]" id="bc-account-register-confirm-password" value=""  data-form-field="bc-form-field-confirm_password">
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'first_name', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-firstname">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'First Name', 'bigcommerce' ) ); ?></span>
			<input type="text" required name="bc-register[first_name]" id="bc-account-register-firstname" value="<?php echo esc_html( $defaults[ 'first_name' ] ); ?>"  data-form-field="bc-form-field-first_name">
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'last_name', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-lastname">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'Last Name', 'bigcommerce' ) ); ?></span>
			<input type="text" required name="bc-register[last_name]" id="bc-account-register-lastname" value="<?php echo esc_html( $defaults[ 'last_name' ] ); ?>"  data-form-field="bc-form-field-last_name">
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'street_1', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-street1">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'Address Line 1', 'bigcommerce' ) ); ?></span>
			<input type="text" required name="bc-register[street_1]" id="bc-account-register-street1" value="<?php echo esc_html( $defaults[ 'street_1' ] ); ?>"  data-form-field="bc-form-field-street_1">
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'street_2', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-street2">
			<span class="bc-form__label bc-account-register__form-label "><?php echo esc_html( __( 'Address Line 2', 'bigcommerce' ) ); ?></span>
			<input type="text"  name="bc-register[street_2]" id="bc-account-register-street2" value="<?php echo esc_html( $defaults[ 'street_2' ] ); ?>" data-form-field="bc-form-field-street_2">
		</label>

<!--
		<label class="bc-form__control  <?php if ( in_array( 'company', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-company">
			<span class="bc-form__label bc-account-register__form-label"><?php echo esc_html( __( 'Company Name', 'bigcommerce' ) ); ?></span>
			<input type="text" name="bc-register[company]" id="bc-account-register-company" value="<?php echo esc_html( $defaults[ 'company' ] ); ?>" data-form-field="bc-form-field-company">
		</label>
-->

		<label class="bc-form__control  <?php if ( in_array( 'city', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-city">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'Suburb/City', 'bigcommerce' ) ); ?></span>
			<input type="text" required name="bc-register[city]" id="bc-account-register-city" value="<?php echo esc_html( $defaults[ 'city' ] ); ?>" data-form-field="bc-form-field-city">
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'state', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-state" data-js="bc-dynamic-state">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'State/Province', 'bigcommerce' ) ); ?></span>
			<?php if ( ! empty( $states ) ) { ?>
				<select id="bc-account-register-state" required name="bc-register[state]" data-js="bc-dynamic-state-control"  data-form-field="bc-form-field-state">
					<?php foreach ( $states as $state_abbr => $state_name ) { ?>
						<option value="<?php echo esc_attr( $state_name ); ?>" data-state-abbr="<?php echo esc_attr( $state_abbr ); ?>" <?php selected( $state_name, $defaults[ 'state' ] ); ?>>
							<?php echo esc_html( $state_name ); ?>
						</option>
					<?php } ?>
				</select>
			<?php } else { ?>
				<input type="text" id="bc-account-register-state" required name="bc-register[state]" value="<?php echo esc_attr( $defaults[ 'state' ] ); ?>" data-js="bc-dynamic-state-control"  data-form-field="bc-form-field-state" />
			<?php } ?>
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'zip', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-zip">
			<span class="bc-form__label bc-account-register-label bc-form-control-required"><?php echo esc_html( __( 'Zip/Postcode', 'bigcommerce' ) ); ?></span>
			<input type="text" required name="bc-register[zip]" id="bc-account-register-zip" value="<?php echo esc_html( $defaults[ 'zip' ] ); ?>"  data-form-field="bc-form-field-zip">
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'country', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-country">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'Country', 'bigcommerce' ) ); ?></span>
			<select name="bc-register[country]" required id="bc-account-register-country" data-js="bc-dynamic-country-select"  data-form-field="bc-form-field-country">
				<?php foreach ( $countries as $iso => $value ) { ?>
					<option value="<?php echo esc_attr( $value ); ?>" data-country-iso="<?php echo esc_attr( $iso ); ?>"<?php selected( $value, $defaults[ 'country' ] ); ?>>
						<?php echo esc_html( $value ); ?>
					</option>
				<?php } ?>
			</select>
		</label>

		<label class="bc-form__control  <?php if ( in_array( 'phone', $errors ) ) { echo esc_attr( $error_class ); } ?>" for="bc-account-register-phone">
			<span class="bc-form__label bc-account-register__form-label bc-form-control-required"><?php echo esc_html( __( 'Phone:', 'bigcommerce' ) ); ?></span>
			<input type="tel" required name="bc-register[phone]" id="bc-account-register-phone" value="<?php echo esc_html( $defaults[ 'phone' ] ); ?>"  data-form-field="bc-form-field-phone">
		</label>

		<div class="bc-form__actions bc-account-register__actions">
			<button class="bc-btn bc-btn--register" aria-label="<?php esc_html_e( 'Register', 'bigcommerce' ); ?>" type="submit"><?php esc_html_e( 'Register', 'bigcommerce' ); ?></button>
		</div>
	</form>
</section>

<div class="loader-wrapper" style="display: none;">
    <div class="loader"></div>
</div>

<style>
    .loader-wrapper {
        display: flex;
        z-index: 90000;
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        overflow: auto;
        background-color: rgba(20, 20, 20, 0.6);
    }

    .loader {
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #000;
        width: 40px;
        height: 40px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
