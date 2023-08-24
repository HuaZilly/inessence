<?php

use BigCommerce\Accounts\Wishlists\Wishlist;
use BigCommerce\Post_Types\Product\Product;

/**
 * Template for a single wishlist product row
 *
 * @var Product  $product
 * @var Wishlist $wishlist
 * @var string   $title
 * @var int      $image_id
 * @var string   $image
 * @var string   $price
 * @var string   $sku
 * @var string[] $bigcommerce_brand
 * @var string[] $bigcommerce_condition
 * @var string   $permalink
 * @var string   $delete URL to remove the product from the wishlist
 */

?>












							
	<div class="product-link-direct-wrap-classes" data-class="<?php 
		$post_id = $product->post_id();
		if(get_the_terms( $post_id, 'bigcommerce_brand' )){
			foreach(get_the_terms( $post_id, 'bigcommerce_brand' ) as $brand){
				echo ' ' . $brand->slug . ' ';
			}	
			
		}
		if(get_the_terms( $post_id, 'bigcommerce_category' )){
			foreach(get_the_terms( $post_id, 'bigcommerce_category' ) as $category){
				echo ' ' . $category->slug . ' ';
			}
			
		}

	?>" 
	
		data-rating="<?php
			
			
				$sum = $product->reviews_rating_sum;
				$count = $product->reviews_count;
			
				if ( $count < 1 ) {
					$percentage =  0;
				}else {
					$percentage = ( $sum / $count * 20 );
				}
				
				echo $percentage;
		?>"  
	
		data-date="<?php echo strtotime($product->date_modified); ?>"  
	
		data-price="<?php if($product->sale_price){ echo $product->sale_price; } else { echo $product->price; } ?>

	
	">
	
	
	
	</div>					
							
	
	<?php if($product->condition == "New"){?>
		<span class="badge">New</span>
	<?php } ?>
	
	

	<a href="<?php the_permalink(  ); ?>">
		
		
		
		<img 	class="lazyload lazy"
				src="<?php echo $product->images[0]->url_thumbnail; ?>"
				data-src="<?php echo $product->images[0]->url_standard; ?>"
				data-srcset="<?php echo $product->images[0]->url_standard; ?> 1x"
				alt="<?php echo $product->name; ?>"
				width="386"
				height="386"
	
		>
		
		
		
	</a>
	<div class="details">
		<h3 class="product-title"><?php echo $product->name; ?> </h3>
		<div class="product-price">
	
			<?php if($product->sale_price){ ?>
				<strong>$<?php echo $product->sale_price; ?></strong> <del>$<?php echo $product->price; ?></del>
			<?php } else { ?>
				<strong>$<?php echo $product->price; ?></strong>
			<?php } ?>
	
	
		</div>
		<?php if ( ! empty( $form ) ) { ?>
			<!-- data-js="bc-product-group-actions" is required -->
			<div class="bc-product__actions" data-js="bc-product-group-actions">
				<?php echo $form; ?>
			</div>
		<?php } ?>
	</div>
	
	<div class="roll">
		<div class="roll-header">
			<h3 class="product-title"><?php echo $product->name; ?></h3>
	
			<div class="product-price">
	
				<?php if($product->sale_price){ ?>
					<strong><?php echo formatAsPrice($product->sale_price); ?></strong> <del><?php echo formatAsPrice($product->price); ?></del>
				<?php } else { ?>
					<strong><?php echo formatAsPrice($product->price); ?></strong>
				<?php } ?>
	
			</div>
	
		</div>
		
	
	
	
	
		<div class="rating">
	
			
			<div class="bc-single-product__rating">
				<div class="bc-single-product__rating--mask" style="width: <?php echo intval( $percentage, 10 ); ?>%">
					<div class="bc-single-product__rating--top">
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
					</div>
				</div>
				<div class="bc-single-product__rating--bottom">
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
				</div>
			</div>
	
	
			<em>(<?php echo $product->reviews_count; ?>)</em>
		</div>
		<p>
			<?php 
				$string = strip_tags( $product->description );
				
				if(strlen($string) > 140){
					echo substr($string, 0, 140).'...';
				}else {
					echo $string;
				}
				?>
		</p>
	





		<div class="bc-product__actions" >
			<a href="<?php echo esc_url( $delete ); ?>" class="btn btn-checkout">Remove from Wishlist</a>
		</div>

		
	
	
	
			
			
			

	
	</div>
