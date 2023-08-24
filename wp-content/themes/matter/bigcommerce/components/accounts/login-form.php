<?php
/**
 * @var string $form
 * @var string $register_link
 * @var string $message
 */
 
 
?>


<div class="bc-account-page">
	<section class="bc-account-login">			
		<div class="bc-account-login__form">
			<div class="bc-account-login__form-inner">
				<div class="intro">
					<p>Don’t have an account? <a href="<?php echo get_site_url(  ); ?>/register-2">Sign up</a></p>
				</div>					

				<?php echo $message; ?>
				<?php echo $form; ?>
				<a href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>"
					 title="<?php echo esc_attr( 'Forgot Password', 'bigcommerce' ); ?>">
					<?php esc_html_e( 'Forgot your password?', 'bigcommerce' ); ?>
				</a>
			</div>
		</div>
	</section>
</div>

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