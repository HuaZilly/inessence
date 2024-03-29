<?php

/**
 * @var string $action_url  The form action URL
 * @var string $nonce_field The nonce field for the form
 * @var int[]  $products    The IDs of products to add to the new list
 */

?>
<div class="bc-wish-list-dialog-content">
	<h2 class="bc-wish-list-dialog-title"><?php _e( 'New Wish List', 'bigcommerce' ); ?></h2>
	<p class="bc-wish-list-dialog-description">
		<?php _e( 'Give your Wish List a name and set its public visibility.', 'bigcommerce' ); ?>
	</p>
	<form action="<?php echo esc_url( $action_url ); ?>" method="post" class="bc-wish-list-dialog-form">
		<?php echo $nonce_field; ?>
		<input type="hidden" name="items" value="<?php echo implode(',', array_map( 'intval', $products ) ); ?>" />


		<div class="field-wrap">
			<div class="smartplaceholder field">
				<label for="wish-list-name-new"><?php _e( 'Wish List Name', 'bigcommerce' ); ?></label>
				<input
					type="text"
					id="wish-list-name-new"
					class="bc-wish-list-name-field"
					name="name"
					value=""
					data-default-value=""
				/>
			</div><br>
			<div class="field">
		
				<input type="checkbox" name="public" value="1" id="wish-list-public-new" class="bc-wish-list-public-field" />
				<label for="wish-list-public-new" class="bc-wish-list-public-label"><?php _e( 'Make this Wish List shareable with a public link?', 'bigcommerce' ); ?></label>
			</div>
		</div>		
		
		<button type="submit" class="bc-btn bc-btn--form-submit">
			<?php _e( 'Create Wish List', 'bigcommerce' ); ?>
		</button>
	</form>
</div>
