<?php get_header(); ?>



		<div class="wrapper">
			<div class="row">
				<div class="col-xl-12 columns ">
					<h1 class="account-page-title">Bag. <span class="heading-aside" id="cart-count"></span></h1>
				</div>
				<div class="col-xl-8 columns ">

<!--
					<div class="checkout-progress-wrap hide" id="checkoutprogresswrap">
						<div class="checkout-progress hide" id="checkoutprogress" data-amountrequired="<?php echo get_field( 'complimentary_shipping_price', 'options') ; ?>">
							
							<span id="freeshipping_msg" class="hide">You've achieved <strong>COMPLIMENTARY SHIPPING*</strong></span>
							<span id="amountleft_msg" class="hide">You are <strong id="amountleft"></strong> away from <strong>COMPLIMENTARY SHIPPING*</strong></span>
							
							<div class="progress-bar"><div class="bar" id="progressbar" style=""></div></div>
						</div>	
						
						<small class="disclaimer">*Before coupons have been applied</small>
					</div>
-->

						
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
						<?php the_content(); ?>

					<?php endwhile; endif; ?>


									

				</div>
				<div class="col-xl-4 columns ">

					<div class="order-summary">
						<div class="header">
							<h3>Order Summary.</h3>
						</div>			
						<div class="costs-summary">
							<div class="sub">
								<span class="lead">Subtotal:</span>
								<span class="product-price"><strong class="printtotal">$0</strong></span>								
							</div>

							<div class="sub">
								<span class="lead">Delivery:</span>
								<span class="product-price"><strong>Not yet calculated</strong></span>								
							</div>
							<div class="total">
								<span class="lead">Order Total:</span>
								
								 <span class="product-price"><strong class="printtotal">$0</strong></span>								
							</div>
							
						</div>
						
						
					</div>
					
					<div class="cart-buttons">
						
						<?php
						$customer_name = '';
						if ( class_exists( '\BigCommerce\Accounts\Customer' ) ) {
							$wp_user_id = get_current_user_id();
							$customer   = new \BigCommerce\Accounts\Customer( $wp_user_id );
							if ( ! empty( $customer ) ) {
								$profile = $customer->get_profile();
								if ( ! empty( $profile ) &&  ! empty( $profile['first_name'] ) ) {
									$customer_name = $profile['first_name'] . ' ' . $profile['last_name'];
								}
							}
						}
						?>

						<?php if ( 'Fast Testing' === $customer_name ) : ?>
						<!------ FAST CHECKOUT BUTTON START ----------->
						<div class="fast-wrapper">
						  <div class="fast-or">OR</div>
						  <fast-checkout-cart-button cart_id="<?php echo esc_attr( $cart_id ); ?>"
							app_id="39fa1a29-ed01-49cc-a4b3-b443ffcf1699" />
						</div>
						<style>
						  .fast-wrapper {
							clear: both;
							border-bottom: 1px solid #dfdfdf;
							border-radius: none;
							padding-bottom: 20px;
						  }

						  .fast-or {
							position: relative;
							top: 80px;
							background: white;
							width: 40px;
							text-align: center;
							margin-left: auto;
							margin-right: auto;
							color: #757575;
						  }

						  @media (min-width: 551px) {
							.fast-wrapper {
							  margin-left: auto;
							  margin-right: 0;
							  width: 100%;
							  border: 1px solid #dfdfdf;
							  padding-left: 10%;
							  padding-right: 10%;
							  padding-bottom: 20px;
							  border-radius: 5px;
							  width: 80%;
							}
						  }
						</style>
						<script src="https://js.fast.co/fast-bigcommerce.js"></script>
						<script type="text/javascript">

							var fastText = document.querySelectorAll('fast-checkout-cart-button');
							fastText.forEach(el => {
								el.shadowRoot.lastElementChild.lastElementChild.setAttribute('style', 'font-size: 17px; border-radius: 0;');
							});

						</script>
						<!------ FAST CHECKOUT BUTTON END ----------->
						
						<?php endif; ?>

						<a href="#" class="btn btn-checkout triggercheckout">Check out</a>
						
						<a href="<?php echo get_site_url(  ); ?>/products" class="btn btn-standard">Continue Shopping</a>
					</div>
				</div>
			</div>
		</div>




<?php get_footer(); ?>
