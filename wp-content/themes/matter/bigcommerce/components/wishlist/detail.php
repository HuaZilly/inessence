<?php

use BigCommerce\Accounts\Wishlists\Wishlist;

/**
 * @var Wishlist $wishlist   The wishlist to display
 * @var string[] $products   The rendered product rows
 * @var string   $breadcrumb The rendered breadcrumb HTML
 * @var string   $header     The rendered header HTML
 */

?>
<?php echo $breadcrumb; ?>
<?php echo $header; ?>

	<div class="row nomaxwidth">
		<div class="col-sm-12 columns">	
			

			<div class="product-link-direct-wrap wishlist-details">
				<?php foreach ( $products as $product ) { ?>
						<?php echo $product; ?>
				<?php } ?>
											
			
			</div>


		</div>
	</div>





