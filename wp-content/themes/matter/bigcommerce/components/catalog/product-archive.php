
	<section class="wrapper category-banner">




				<?php 
					$taxonomySlug = get_queried_object()->slug;
					
					$cc = 0;
					
					
					foreach(get_field( 'banners', 'options' ) as $banner){ 
						

							
						if($banner['slug'] == $taxonomySlug){ 
							$cc++;
							
							
						?>
		
		
								<div class="row products ">
									<div class="col-xl-6 columns content">	
										<h1 class="heading <?php if(isset($banner['text_color'])) { echo 'txt-color-'.strtolower($banner['text_color']); } ?>"><?php 
											
											echo $banner['title']; ?>.</h1>
										<p class="<?php if(isset($banner['text_color'])) { echo 'txt-color-'.strtolower($banner['text_color']); } ?>"><?php echo $banner[ 'description' ]; ?></p>
									</div>
								</div>
					
								<?php 
									$featuredimage_url = wp_get_attachment_image_src($banner['background_image']['ID'], 'full' , true)[0];
									$featuredimage_url_mobile = wp_get_attachment_image_src($banner['background_image_mobile']['ID'], 'full' , true)[0];
						
								?>
								<div class="img">
									<div class="lazyload lazy fillparent background-cover desktop" data-background-image-url="<?php echo $featuredimage_url; ?>" >
									</div>		
									<div class="lazyload lazy fillparent background-cover mobile" data-background-image-url="<?php echo $featuredimage_url_mobile; ?>" >
									</div>		
								</div>

							
					<?php 
						break;
						}

					}
						
					if($cc == 0){
					 ?>
					
					<?php if(is_post_type_archive( 'bigcommerce_product' )){ ?>
					
					
						
					
						<div class="row products ">
							<div class="col-xl-6 columns content">	
								<h1 class="heading <?php if(isset(get_field( 'shop_banner', 'options' )['text_color'])) { echo 'txt-color-'.strtolower(get_field( 'shop_banner', 'options' )['text_color']); } ?>"><?php echo get_field( 'shop_banner', 'options' )['title']; ?>.</h1>
								<p class="<?php if(isset(get_field( 'shop_banner', 'options' )['text_color'])) { echo 'txt-color-'.strtolower(get_field( 'shop_banner', 'options' )['text_color']); } ?>"><?php echo get_field( 'shop_banner', 'options' )['decription']; ?></p>
							</div>
						</div>


						<?php 
							$featuredimage_url = wp_get_attachment_image_src(get_field( 'shop_banner', 'options' )['background_image']['ID'], 'full' , true)[0];
							$featuredimage_url_mobile = wp_get_attachment_image_src(get_field( 'shop_banner', 'options' )['background_image_mobile']['ID'], 'full' , true)[0];
				
						?>
						<div class="img">
							<div class="lazyload lazy fillparent background-cover desktop" data-background-image-url="<?php echo $featuredimage_url; ?>" >
							</div>		
							<div class="lazyload lazy fillparent background-cover mobile" data-background-image-url="<?php echo $featuredimage_url_mobile; ?>" >
							</div>		
						</div>



					<?php } else {   ?>
						<div class="row products ">
							<div class="col-xl-6 columns content">	
								<h1 class="heading"><?php 
									echo str_replace('Category: ', '', $title); ?>.</h1>
								<p><?php echo esc_html( $description ); ?></p>
							</div>
						</div>
						<div class="img"></div>
					
					<?php }  ?>

				<?php }  ?>

		

	</section>


	<div class="wrapper">
		<?php include (TEMPLATEPATH . '/breadcrumbs.php' );  ?>
	</div>
	

	<?php include (TEMPLATEPATH . '/sub-categories.php' );  ?>
	<?php include (TEMPLATEPATH . '/filter.php' );  ?>

	
	
	<div class="wrapper facetwp-template">
		<div class="row ">
			<div class="col-sm-12 columns">	
				
	
				<div class="product-link-direct-wrap" id="filterresults">


                    <script type="text/javascript">
                        window.insider_object.listing = {
                                "items": []
                        }
                    </script>

						<?php
                        $itemsArray = [];
						if ( ! empty( $posts ) ) {
							foreach ( $posts as $post ) { 
								
								
							?>
				
				
				
				
											<div class="product-link-direct show">
												<?php echo $post;   ?>
											</div>
				
				
				
							<?php
							}

                            global $wp_session;
?>
                            <script type="text/javascript">
                                window.insider_object.listing.items = <?php echo substr(json_encode($wp_session['items']), 1, -1); ?>
                            </script>
<?php						} else {
							echo $no_results;
						}
						?>

	
				</div>
	
	
			</div>
			<div class="col-sm-12 columns">	

				<?php //echo $pagination; ?>


				<div class="pagination-numbered">
				<?php
					 echo paginate_links(  array(
							'prev_text' => __( 'Prev.', 'textdomain' ),
							'next_text' => __( 'Next', 'textdomain' ),
					 ) );
				?>
				</div>
			


			</div>
		</div>
	</div>