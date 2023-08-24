							
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


	<?php
		$badge_string = null;
		foreach($product->custom_fields as $cf){
			if($cf->name == 'badge' && !empty($cf->value)){
				$badge_string = $cf->value;
			}
		}
		if($badge_string !== null){
	?>
		<span class="badge"><?php echo ucfirst($badge_string); ?></span>
	<?php } ?>

	<?php //if($product->condition == "New"){?>
		<!-- <span class="badge">New</span> -->
	<?php //} ?>



	<a href="<?php the_permalink(  ); ?>" class="img">



		<?php

			if(

				($product->images != null)
				&&
				(sizeof($product->images) != 0 )

			){


				$imagethumbnail = 0;

				foreach($product->images as $key=>$value) {
					$cc++;

					if($value->is_thumbnail == true){
						$imagethumbnail = $key;

					}
				}



		?>
		<img 	class="lazyload lazy"
				src="<?php echo $product->images[$imagethumbnail]->url_thumbnail; ?>"
				data-src="<?php echo $product->images[$imagethumbnail]->url_standard; ?>"
				data-srcset="<?php echo $product->images[$imagethumbnail]->url_standard; ?> 1x"
				alt="<?php echo $product->name; ?>"
				width="386"
				height="386"

		>
		<?php } else { ?>

		<img 	class="lazyload lazy"
				src="<?php echo get_template_directory_uri( ); ?>/images/placeholder-386x386.gif"
				data-src="<?php echo get_template_directory_uri( ); ?>/images/placeholder-386x386.gif"
				data-srcset="<?php echo get_template_directory_uri( ); ?>/images/placeholder-386x386.gif 1x"
				alt="<?php echo $product->name; ?>"
				width="386"
				height="386"

		>


		<?php } ?>



	</a>	<div class="details">
		<h3 class="product-title"><a href="<?php the_permalink(  ); ?>"><?php echo $product->name; ?> </a></h3>
		<div class="product-price">

			<?php echo $price; ?>


		</div>


		<?php if($product->inventory_level == 0){ ?>
			<a href="#" class="btn btn-checkout btn-disabled">Out of stock</a>

		<?php } else { ?>


			<?php if ( ! empty( $form ) ) { ?>
				<!-- data-js="bc-product-group-actions" is required -->
				<div class="bc-product__actions" data-js="bc-product-group-actions">
					<?php echo $form; ?>
				</div>
			<?php } ?>
		<?php } ?>

	</div>

	<div class="roll">
		<div class="roll-header">
			<h3 class="product-title"><a href="<?php the_permalink(  ); ?>"><?php echo $product->name; ?> </a></h3>

			<div class="product-price">

				<?php //if($product->sale_price){ ?>
					<!-- <strong><?php //echo formatAsPrice($product->sale_price); ?></strong> <del><?php //echo formatAsPrice($product->price); ?></del> -->
				<?php //} else { ?>
					<!-- <strong><?php //echo formatAsPrice($product->price); ?></strong> -->
				<?php //} ?>

				<?php echo $price; ?>

			</div>

		</div>





		<div class="rating">
            <div class="yotpo bottomLine"
                 data-yotpo-product-id="<?= $product->bc_id() ?>">
            </div>
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


		<div class="product-button-wrap">

			<?php if($product->inventory_level == 0 && $product->type !=='digital'){ ?>
				<a href="#" class="btn btn-checkout btn-disabled">Out of stock</a>


				<?php } else { ?>


					<?php if ( ! empty( $form ) ) { ?>
						<!-- data-js="bc-product-group-actions" is required -->
						<div class="bc-product__actions" data-js="bc-product-group-actions">
							<?php echo $form; ?>
						</div>
					<?php } else { ?>
						<div class="bc-product__actions" >
							<a href="<?php the_permalink(  ); ?>" class="btn btn-checkout">View Product</a>
						</div>
				<?php } ?>

			<?php } ?>
		</div>

	</div>

