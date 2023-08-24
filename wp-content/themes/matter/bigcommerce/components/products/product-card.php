<?php
/**
 * Product Card used in loops and grids.
 *
 * @package BigCommerce
 * @since v1.7
 *
 * @var Product $product
 * @var string  $title
 * @var string  $brand
 * @var string  $image
 * @var string  $price
 * @var string  $quick_view @deprecated since 3.1, @see quick-view-image.php
 * @var string  $attributes @deprecated since 3.1, @see quick-view-image.php
 */

use BigCommerce\Post_Types\Product\Product;

?>

<?php include (TEMPLATEPATH . '/product-card.php' ); ?>


