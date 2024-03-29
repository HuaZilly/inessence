<?php

use BigCommerce\Post_Types\Product\Product;

/**
 * @var Product  $product  The product the review is for
 * @var string[] $options  Key/Value pairs for the rating drop-down
 * @var array    $defaults Default values to use to populate the form
 * @var string   $messages Rendered form feedback messages
 */

// TODO: Add conditionals for review requirements. Disabled, must be verified purchaser, must be logged in.

$error_class = 'bc-form__control--error'; // REQUIRED
?>


<?php echo $messages; ?>

<!-- class="bc-product-review-form" is required -->
<div class="bc-product-review-form bc-account-pages-restyled">
	<h3 class="h3 bc-product-review-form__title"> <?php echo esc_html( 'Write A Review', 'bigcommerce' ); ?>.</h3>
	<form action="" enctype="multipart/form-data" method="post" class="bc-form">
		<?php wp_nonce_field( 'product-review' . $product->post_id() ); ?>
		<input type="hidden" name="bc-action" value="product-review"/>
		<input
				type="hidden"
				name="bc-review[post_id]"
				value="<?php echo esc_attr( (int) $product->post_id() ); ?>"
		/>
		<label
				for="bc-review-rating"
				class="bc-form__control <?php if ( in_array( 'rating', $errors ) ) { echo esc_attr( $error_class ); } ?>"
		>
			<span class="bc-form__label bc-review-rating__form-label bc-form-control-required"><?php echo esc_html( __( 'Rating:', 'bigcommerce' ) ); ?></span>
			<select name="bc-review[rating]" id="bc-review-rating" data-form-field="bc-form-field-rating">
				<option value="0"><?php echo esc_html( __( 'Select Rating', 'bigcommerce' ) ); ?></option>
				<?php foreach ( $options as $key => $value ) { ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $defaults['rating'], $value, true ); ?>><?php echo esc_html( $value ); ?></option>
				<?php } ?>
			</select>
		</label>
		<label
				for="bc-review-name"
				class="bc-form__control <?php if ( in_array( 'name', $errors ) ) { echo esc_attr( $error_class );} ?>"
		>
			<span class="bc-form__label bc-review-name__form-label bc-form-control-required"><?php echo esc_html( __( 'Name', 'bigcommerce' ) ); ?></span>
			<input
					type="text"
					name="bc-review[name]"
					id="bc-review-name"
					value="<?php echo esc_attr( $defaults['name'] ); ?>"
					data-form-field="bc-form-field-name"
			/>
		</label>
		<label
				for="bc-review-email"
				class="bc-form__control <?php if ( in_array( 'email', $errors ) ) { echo esc_attr( $error_class ); } ?>"
		>
			<span class="bc-form__label bc-review-email__form-label bc-form-control-required"><?php echo esc_html( __( 'Email Address', 'bigcommerce' ) ); ?></span>
			<input
					type="text"
					name="bc-review[email]"
					id="bc-review-email"
					value="<?php echo esc_attr( $defaults['email'] ); ?>"
					data-form-field="bc-form-field-email"
			/>
		</label>
		<label
				for="bc-review-subject"
				class="bc-form__control <?php if ( in_array( 'subject', $errors ) ) { echo esc_attr( $error_class ); } ?>"
		>
			<span class="bc-form__label bc-review-subject__form-label bc-form-control-required"><?php echo esc_html( __( 'Subject', 'bigcommerce' ) ); ?></span>
			<input
					type="text"
					name="bc-review[subject]"
					id="bc-review-subject"
					value="<?php echo esc_attr( $defaults['subject'] ); ?>"
					data-form-field="bc-form-field-subject"
			/>
		</label>
		<label
				for="bc-review-content"
				class="bc-form__control <?php if ( in_array( 'content', $errors ) ) { echo esc_attr( $error_class ); } ?>"
		>
			<span class="bc-form__label bc-review-content__form-label bc-form-control-required"><?php echo esc_html( __( 'Comments', 'bigcommerce' ) ); ?></span>
			<textarea
					name="bc-review[content]"
					id="bc-review-content"
					data-form-field="bc-form-field-content"
			><?php echo esc_textarea( $defaults['content'] ); ?></textarea>
		</label>

		<div class="bc-form__actions bc-form__actions--review">
			<button
					class="btn btn-standard"
					aria-label="<?php esc_html_e( 'Submit', 'bigcommerce' ); ?>"
					type="submit"
			><?php esc_html_e( 'Submit', 'bigcommerce' ); ?></button>
		</div>
	</form>
</div>

