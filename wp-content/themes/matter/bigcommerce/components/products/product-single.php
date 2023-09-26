<?php
/**
 * @var string $images
 * @var string $title
 * @var string $brand
 * @var string $price
 * @var string $rating
 * @var string $form
 * @var string $description
 * @var string $sku
 * @var string $specs
 * @var string $related
 * @var string $reviews
 */



?>




<div class="wrapper" itemscope itemtype="http://schema.org/Product">


	<?php include (TEMPLATEPATH . '/breadcrumbs.php' );





	?>




		<div class="row" itemid="<?php the_permalink(  ); ?>">


			<div class="col-lg-7 columns">



				<div class="image-switcher-wrap">
					<div class="badges">


						<?php
							$custom_fields = $product->get_custom_fields();


							if(!empty($custom_fields)){
							    $sourceArray = array();

								foreach( $custom_fields as $custom_field ) {


									if(
										(isset($custom_field['name'])) && ($custom_field['name']== "badge")
									){
											?>


																		<span class="badge"><?php echo $custom_field['value']; ?></span>

											<?php


									}
								} ?>

						<?php } ?>



						<?php
							$custom_fields = $product->get_custom_fields();


							if(!empty($custom_fields)){
							    $sourceArray = array();

								foreach( $custom_fields as $custom_field ) {
									if(
										(isset($custom_field['name'])) && ($custom_field['name']=="region")
									){
										$sources = explode(',',$custom_field['value']);

										foreach($sources as $source){

											$post = get_page_by_path($source, OBJECT, 'region');

											array_push($sourceArray,$post->ID);

										}
									}
								}

								if(!empty($sourceArray)){



									$args = array(
										'post_type' => 'region',
										'posts_per_page' => 3,
						 				'post__in' => $sourceArray
									);

									$custom_posts = new WP_Query($args);

									if($custom_posts->have_posts()) :
										while($custom_posts->have_posts()) :
											$custom_posts->the_post();


											$featuredimage_id = get_post_thumbnail_id(get_the_ID());

											$featuredimage_urlarray = wp_get_attachment_image_src($featuredimage_id, 'full' , true);
											$featuredimage_url = $featuredimage_urlarray[0]; ?>


											<img src="<?php echo $featuredimage_url; ?>" alt="region" />

								<?php
										endwhile;
										else:
								?>
								<?php endif; ?>
								<?php wp_reset_query(); ?>
						<?php }
							}
						?>







					</div>

					<div class="swiper-container image-switcher">
						<div class="swiper-wrapper">


							<?php

								$cc = 0;
								foreach(array_slice( $product->images, 0, 5 ) as $image){
									$cc++;
								?>
								<div class="swiper-slide <?php if($image->is_thumbnail){ echo 'main-image'; }?>" data-slidenumber="<?php echo $cc; ?>">
									<img <?php if($image->is_thumbnail){ echo "itemprop='image'"; }?> src="<?php echo $image->url_zoom;?>" />
								</div>
							<?php  }  ?>

						</div>
					</div>
					<div class="image-switcher-thumbnails">
						<?php
							$cc = 0;
							foreach(array_slice( $product->images, 0, 5 ) as $image){
								$cc++;
							?>

								<a href="" data-slidenumber="<?php echo $cc; ?>">
									<img src="<?php echo $image->url_thumbnail; ?>" />
								</a>
							<?php } ?>

					</div>
				</div>
			</div>


			<div class="col-lg-5 columns">
				<div class="product-page-description-spacer"></div>
				<article class="product-page-description show" data-js="bc-product-meta">





					<h1 class="bc-product__title" itemprop="name"><?php the_title(); ?></h1>


                    <?php
                        $starRating = get_field('star_rating_bottomline', 'options');
                    ?>
                    <div class="wishlist-container">
                        <div class="rating-star ">
                            <?php if ($starRating) :?>
                                <?php echo
                                str_replace('%product.id', $product->bc_id(), $starRating);
                                ?>
                            <?php endif; ?>
                        </div>

                        <div class="form-container">
                            <?php $wishlist = apply_filters('matter_bigcommerce_custom_wishlist', ['product' => $product], false, false); ?>
                            <?php echo $wishlist['form'];?>
                        </div>
                    </div>

					<meta itemprop="sku" content="<?php echo $product->sku; ?>">
					<meta itemprop="description" content="<?php echo strip_tags($product->description); ?>">

					<div class="truncate">

						<?php $string = $product->description; ?>

						<?php if(strlen($string) > 140){ ?>

							<div class="truncated">

								<?php

									echo substr($string, 0, 120).'...';
									?>
							</div>

							<div class="untruncated">
								<?php
									echo $string;


								?>
							</div>

							<a href="#" class="toggle-truncate">Read more</a>

						<?php } else {  ?>
							<div class="">
								<?php
									echo $string;


								?>
							</div>



						<?php } ?>

					</div>


					<span class="product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

						<?php echo $price; ?>

							<?php
								if($product->availability){
									if($product->availability === 'available'){
							?>
									<link itemprop="availability" href="http://schema.org/InStock" />
							<?php
									}else{
							?>
									<link itemprop="availability" href="http://schema.org/OutOfStock" />
							<?php
									}
								}
							?>

						<meta itemprop="price" content="<?php echo esc_html( floatval(ltrim($product->price_range(), '$')) ) ?>">
					</span>


					<div class="payment-options">
						<div class="option afterpay">
                            <span>or make 4 interest-free payments of $<?php echo number_format((floatval(ltrim($product->price_range(), '$'))/4), 2);
                                ?> fortnightly with <img src="https://www.inessence.com.au/wp-content/uploads/2020/12/afterpay-badge-blackonmint86x18.png" alt="afterpay" /></span>

					</div>
						<div class="option">
							<img src="<?php echo get_template_directory_uri(  )?>/images/zip-pay.png" alt="zip-pay" width="84" height="17" />
							<span>Own it now, pay later. <a href="https://help.zip.co/en/articles/41-how-does-it-all-work-zip-pay" target="_blank">Learn more</a></span>
						</div>
					</div>


					<?php if($product->inventory_level == 0 && $product->type !=='digital'){ ?>
						<a href="#" class="btn btn-checkout btn-disabled">Out of stock</a>


					<?php }?>
                    <div class="form-bottom">
					    <?php echo $form; ?>
                    </div>
				</article>



			</div>
			<div class="col-lg-7 columns">

				<?php if(get_field( 'features' )) { ?>
					<ul class="product-features">

						<?php


							$cc = 0;
							foreach(get_field( 'features' ) as $option) {
								$cc++;
							?>
							<li class="addclass-on-focus fadeinandup" style="transition-delay: <?php echo $cc/3; ?>s">


								<?php
									$featuredimage_id = get_post_thumbnail_id($option->ID);
									$featuredimage_url_array = wp_get_attachment_image_src($featuredimage_id, 'full', true);
									$featuredimage_url = $featuredimage_url_array[0];

									$alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

								?>

								<img src="<?php echo $featuredimage_url; ?>" alt="<?php echo $alt; ?>" width="69" height="68" class=""/>

								<p><?php echo get_field( 'display_text', $option->ID );?></p>


							</li>
						<?php } ?>

					</ul>
				<?php } ?>

				<div class="collapses">






					<?php if(get_field( 'full_description' )) { ?>
						<div class="collapse">
							<h4 class="collapse-btn default-open" data-collapse="description">Description</h4>
							<div class="collapse-content default-open" data-collapse="description">
								<?php the_field( 'full_description' ); ?>
							</div>
						</div>
					<?php } ?>




					<?php if(get_field( 'how_to' )) { ?>
						<div class="collapse">
							<h4 class="collapse-btn" data-collapse="howto">How to use this product</h4>
							<div class="collapse-content" data-collapse="howto">
								<?php echo get_field( 'how_to' ); ?>
							</div>
						</div>

					<?php } ?>

					<?php if(get_field( 'ingredients' )) { ?>
						<div class="collapse">
							<h4 class="collapse-btn" data-collapse="ingredients">Ingredients</h4>
							<div class="collapse-content" data-collapse="ingredients">
								<?php echo get_field( 'ingredients' ); ?>
							</div>
						</div>
					<?php } ?>


					<?php if(get_field( 'recipes' )) { ?>
						<div class="collapse">
							<h4 class="collapse-btn" data-collapse="recipes">Recipes</h4>
							<div class="collapse-content" data-collapse="recipes">
								<?php the_field( 'recipes' ); ?>
							</div>
						</div>
					<?php } ?>


					<?php if(get_field( 'faqs' )) { ?>
						<div class="collapse">
							<h4 class="collapse-btn" data-collapse="faqs">FAQs</h4>
							<div class="collapse-content" data-collapse="faqs">
								<?php echo get_field( 'faqs' ); ?>
							</div>
						</div>
					<?php } ?>


				</div>
			</div>
		</div>



		<div class="row " id="source-wrap">
		<?php
			$custom_fields = $product->get_custom_fields();

			if(!empty($custom_fields)){

			    $sourceArray = array();


				foreach( $custom_fields as $custom_field ) {

					if(
						(isset($custom_field['name'])) && ($custom_field['name']=="source")
					){

						$sources = explode(',',$custom_field['value']);

						foreach($sources as $source){


							$post = get_page_by_path($source, OBJECT, 'source');



							array_push($sourceArray,$post->ID);

						}
					}


				}

				if(!empty($sourceArray)){




					$args = array(
						'post_type' => 'source',
						'posts_per_page' => 3,
		 				'post__in' => $sourceArray
					);

					$custom_posts = new WP_Query($args);

					if($custom_posts->have_posts()) :
						while($custom_posts->have_posts()) :
							$custom_posts->the_post();
				?>


							<div class="col-md-6 col-lg-6 col-xxl-4 columns">
								<div class="square-rollover">
									<span  class="heading"><?php the_title() ?></span>


									<div class="content">
										<div class="inner">
											<h3 class="heading"><?php the_title() ?></h3>
											<?php the_content() ?>
										</div>
									</div>
									<div class="img">

										<?php

											$featuredimage_id = get_post_thumbnail_id(get_the_ID());

											$featuredimage_urlarray = wp_get_attachment_image_src($featuredimage_id, 'full' , true);
											$featuredimage_url = $featuredimage_urlarray[0];

										?>

										<div class="lazyload lazy fillparent background-cover" data-background-image-url="<?php echo $featuredimage_url; ?>" >
										</div>
									</div>
								</div>
							</div>

				<?php
					endwhile;
					else:
				?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php } ?>

			<?php } ?>
		</div>

<?php
    $yotpoWidget = get_field('review_widget','options');
    $productLink = get_permalink();
?>
		<div class="row" id="reviews" >
			<div class="col-lg-12 columns">
                <?php if ($yotpoWidget): ?>

                    <?php echo
                        str_replace(
                                array('%product.id', '%product.title', '%product.url', '%product.featured_image', '%product.price', '%product.description'),
                                array($product->bc_id(), $product->name, $productLink ,get_the_post_thumbnail_url() , $product->price_range(), strip_tags($product->description)),
                                $yotpoWidget
                        );
                    ?>
                <?php endif;?>
			</div>
		</div>


	</div>




	<?php
$productTag = get_field('product_tag','options');
$productId = esc_html( $product->bc_id() );
?>
<?php if ($productTag): ?>
    <div><?= str_replace('product-id', $productId, $productTag) ?></div>
<?php endif;?>



	<div id="addtocartsticky" class="addtocart-sticky">
		<div class="row">
			<div class="col-xl-12 columns">
				<div class="product-details">

					<img src="<?php echo $product->images[0]->url_thumbnail; ?>" />

					<span class="product-title"><?php echo $product->name; ?></span>
					<span class="product-price">
						<?php if($product->sale_price){ ?>
							<strong><?php echo formatAsPrice($product->sale_price); ?></strong> <del><?php echo formatAsPrice($product->price); ?></del>
							<?php $theprice = $product->sale_price; ?>
						<?php } else { ?>
							<strong><?php echo formatAsPrice($product->price); ?></strong>
							<?php $theprice = $product->price; ?>
						<?php } ?>



					</span>
				</div>

				<?php if($product->inventory_level == 0){ ?>
					<a href="#" class="btn btn-checkout btn-disabled">Out of stock</a>


				<?php } else { ?>

					<div class="quantity-selector-wrap">


						<div class="bc-form bc-product-form">
							<div class="quantity-selector">
								<label class="">
									<span class="bc-product-single__meta-label">Quantity:</span>
								</label>
								<span class="decrease-qty-clone">–</span>
								<input class="bc-product-form__quantity-input" type="number" name="quantity" value="1" min="1" id="quantity_input_clone">
								<span class="increase-qty-clone">+</span>
							</div>

							<a class="btn btn-checkout" id="addtobutton_clone">Add to Cart</a>

						</form>



					</div>
				<?php } ?>

			</div>
		</div>

	</div>

