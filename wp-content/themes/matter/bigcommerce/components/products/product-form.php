<?php
/**
 * Product Single Form Actions
 *
 * @package BigCommerce
 *
 * @var Product $product
 * @var string  $options
 * @var string  $modifiers @deprecated
 * @var string  $button
 * @var string  $message
 * @var int     $min_quantity
 * @var int     $max_quantity
 * @var bool    $ajax_add_to_cart
 * @var string  $quantity_field_type
 */

use BigCommerce\Post_Types\Product\Product;

?>

<form action="<?php echo esc_url( $product->purchase_url() ); ?>" method="post" enctype="multipart/form-data"
      class="bc-form bc-product-form">
	<?php echo $options; ?>

	<!-- data-js="bc-product-message" is required. -->
	<div class="bc-product-form__product-message" data-js="bc-product-message"></div>

	<!-- data-js="variant_id" is required. -->
	<input type="hidden" name="variant_id" class="variant_id" data-js="variant_id" value="">

	<?php if(is_single( )){ ?>

		<div class="bc-product-form__quantity quantity-selector">
			<?php if ( $quantity_field_type !== 'hidden' ) { ?>
			<label class="bc-product-form__quantity-label">
				<span class="bc-product-single__meta-label"><?php esc_html_e( 'Quantity', 'bigcommerce' ); ?>:</span>
			</label>
			<?php } ?>
			<div class="decrease-qty">–</div>
			<input class="bc-product-form__quantity-input"
				type="<?php echo esc_attr( $quantity_field_type ); ?>"
				name="quantity"
				value="<?php echo absint( $min_quantity ); ?>"
				min="<?php echo absint( $min_quantity ); ?>"
				<?php if ( $max_quantity > 0 ) { ?>max="<?php echo absint( $max_quantity ); ?>"<?php } ?>
			/>
			<div class="increase-qty">+</div>
			<input type="hidden" name="product_id" value="<?php echo $product->bc_id(); ?>">
		</div>
	
	
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
					<fast-checkout-button app_id="39fa1a29-ed01-49cc-a4b3-b443ffcf1699"/>
				</div>
				<style>
					.fast-wrapper {
						padding-bottom: 20px;
						margin-bottom: 20px;
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
					@media only screen and (max-width: 767px) {
						.fast-wrapper {
							border-bottom: 1px solid #dfdfdf;
							border-radius: none;
							padding-right: 1%;
							padding-left: 1%;
						}
					}
					@media only screen and (min-width: 768px) {
						.fast-wrapper {
							border: 1px solid #dfdfdf;
							border-radius: 5px;
							padding-right: 20%;
							padding-left: 20%;
						}
					}
				</style>
				<script src="https://js.fast.co/fast-bigcommerce.js"></script>
				<script type="text/javascript">

				var fastText = document.querySelectorAll('fast-checkout-button');
				fastText.forEach(el => {
					el.shadowRoot.lastElementChild.lastElementChild.setAttribute('style', 'font-size: 17px; border-radius: 0;');
				});

				</script>
				<!------ FAST CHECKOUT BUTTON END ----------->

		<?php endif; ?>
				
	
	<?php } ?>

	<?php if ( $message ) { ?>
		<span class="bc-product-form__purchase-message"><?php echo wp_strip_all_tags( $message ); ?></span>
	<?php } ?>

	<?php echo $button; ?>
	<?php if ( $ajax_add_to_cart ) { ?>
		<!-- data-js="bc-ajax-add-to-cart-message" is required. -->
		<div class="bc-ajax-add-to-cart__message-wrapper" data-js="bc-ajax-add-to-cart-message"></div>
	<?php } ?>
</form>
