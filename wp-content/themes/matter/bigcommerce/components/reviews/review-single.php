<?php

use BigCommerce\Post_Types\Product\Product;

/**
 * @var Product $product       The product the review is for
 * @var int     $review_id     The BigCommerce ID of the review
 * @var int     $post_id       The post ID of the product
 * @var int     $bc_id         The BigCommerce ID of the product
 * @var string  $title         The title of the review
 * @var string  $content       The body of the review
 * @var string  $status        The approval status of the review.
 * @var int     $rating        The star ating given to the product for this review
 * @var int     $percentage    The star rating converted to a percentage
 * @var string  $author_name   The name of the review's author
 * @var string  $author_email  The email address of the review's author
 * @var string  $date_reviewed The date the review was submitted, converted to the local timezone
 * @var int     $timestamp     Timestamp of the review date, converted to the local timezone
 */

?>

<div class="bc-product-review">

	<div class="bc-product-review__content">
		<?php echo $content; ?>
	</div>
</div>
