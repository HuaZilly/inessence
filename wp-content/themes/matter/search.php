<?php get_header(); ?>

	<div class="wrapper">
		<div class="row ">
			<div class="col-sm-12 columns">	
				<h1 class="search-resuls-title">Search results for: <?php echo get_search_query(); ?></h1>
			</div>
		</div>
	</div>



	<div class="wrapper">
		<div class="row ">
			<div class="col-sm-12 columns">	
				
	
				<div class="search-results-page" >



			
					<?php 
						$searchTerm = get_search_query();
						
						
						
						
						while (have_posts()) : the_post(); 
						
						
						?>
					
						<a href="<?php the_permalink(  ); ?>" class="search-result-card <?php 
							
								if(  strpos(  strtolower(get_the_title(  )) , strtolower($searchTerm) ) > -1  ){ 
									echo 'high-priority'; 
								}?>">
							
							
							<?php 
								
								if(get_post_type(  ) == "bigcommerce_product"){



                                    $product = new \BigCommerce\Post_Types\Product\Product( get_the_ID() );								
								
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


												<?php if(  strpos(  strtolower(get_the_title(  )) , strtolower($searchTerm) ) > -1  ){ ?>

													<div class="img">
														<img 	class=""
																src="<?php echo $product->images[$imagethumbnail]->url_standard; ?>"
																alt="<?php echo $product->name; ?>"
																width="386"
																height="386"
													
														>
													</div>

												<?php }else { ?>


													<div class="img">
														<img 	class="lazyload lazy"
																src="<?php echo $product->images[$imagethumbnail]->url_thumbnail; ?>"
																data-src="<?php echo $product->images[$imagethumbnail]->url_standard; ?>"
																data-srcset="<?php echo $product->images[$imagethumbnail]->url_standard; ?> 1x"
																alt="<?php echo $product->name; ?>"
																width="386"
																height="386"
													
														>
													</div>
												<?php } ?>


									<?php } else { ?>
									<div class="img">
							
										<img 	class="lazyload lazy"
												src="<?php echo get_template_directory_uri( ); ?>/images/placeholder-386x386.gif"
												data-src="<?php echo get_template_directory_uri( ); ?>/images/placeholder-386x386.gif"
												data-srcset="<?php echo get_template_directory_uri( ); ?>/images/placeholder-386x386.gif 1x"
												alt="<?php echo $product->name; ?>"
												width="386"
												height="386"
									
										>
									</div>
							
								<?php } ?>

							<?php } else {  ?>
						
									<?php if(has_post_thumbnail(  )) { ?>
										<?php 
											
											$featuredimage_id = get_post_thumbnail_id(get_the_ID());
											$featuredimage_url = wp_get_attachment_image_src($featuredimage_id, '386x386' , true)[0];
										?>
										<div class="img">
											<img 	class="lazyload lazy"
													src="<?php echo get_template_directory_uri( ); ?>/images/placeholder-386x386.gif"
													data-src="<?php echo $featuredimage_url; ?>"
													data-srcset="<?php echo $featuredimage_url; ?> 1x"
													alt="<?php echo get_the_title(); ?>"
													width="386"
													height="386"
											>
										</div>



									<?php } ?>


							<?php } ?>
					


							<div class="content">
							
								<h2 class="heading"><?php the_title( ); ?></h2>
								<?php the_excerpt(  ); ?>
								
								<span class="post_type"><?php 
									
									if( get_post_type(  ) == "bigcommerce_product" ){
										echo 'Product';
									}elseif ( get_post_type(  ) == "post" ) {
										echo 'Blog';
									}elseif ( get_post_type(  ) == "page" ) {
										echo 'Page';
									}
									
									 ?></span>
							</div>
						</a>
					

					<?php endwhile; ?>


					
				</div>
			</div>
		</div>
	</div>
	


<?php get_footer(); ?>
