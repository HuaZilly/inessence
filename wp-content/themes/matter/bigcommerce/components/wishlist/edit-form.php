<?php

use BigCommerce\Accounts\Wishlists\Wishlist;

/**
 * @var Wishlist $wishlist    The wishlist to display
 * @var string   $nonce_field The nonce field for the edit form
 */

?>
<div class="bc-wish-list-dialog-content">
	<h2 class="bc-wish-list-dialog-title"><?php _e( 'Edit Wish List', 'bigcommerce' ); ?></h2>
	<p class="bc-wish-list-dialog-description">
		<?php _e( 'Rename your Wish List or change the public visibility of your Wish List.', 'bigcommerce' ); ?>
	</p>
	<form action="<?php echo esc_url( $wishlist->edit_url() ); ?>" method="post" class="bc-wish-list-dialog-form">
		<?php echo $nonce_field; ?>



		<div class="field-wrap">
			<div class="smartplaceholder field">

	
				<label for="wish-list-name-<?php echo esc_attr( $wishlist->list_id() ); ?>"><?php _e( 'Wish List Name', 'bigcommerce' ); ?></label>
				<input
					type="text"
					id="wish-list-name-<?php echo esc_attr( $wishlist->list_id() ); ?>"
					class="bc-wish-list-name-field"
					name="name"
					value="<?php echo esc_attr( $wishlist->name() ); ?>"
					data-default-value="<?php echo esc_attr( $wishlist->name() ); ?>"
				>
			</div>
	
			<div class="field">
	
				<input type="checkbox" name="public" value="1" id="wish-list-public-<?php echo esc_attr( $wishlist->list_id() ); ?>" class="bc-wish-list-public-field" <?php checked( $wishlist->is_public() ); ?>>
				<label for="wish-list-public-<?php echo esc_attr( $wishlist->list_id() ); ?>" class="bc-wish-list-public-label"><?php _e( 'Make this Wish List shareable with a public link?', 'bigcommerce' ); ?></label>
			</div>
		</div>

		<button type="submit" class="bc-btn bc-btn--form-submit">
			<?php _e( 'Update Wish List', 'bigcommerce' ); ?>
		</button>
	</form>
</div>
