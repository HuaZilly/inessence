	<?php if(is_page( 'the-finest-harvest' )) {?>
		<div class="row  product-row">
			
				<?php
					$args = array(
						'post_type' => 'source',
						'posts_per_page' => 3
					);
				
					$custom_posts = new WP_Query($args);
				
					if($custom_posts->have_posts()) : 
						while($custom_posts->have_posts()) : 
							$custom_posts->the_post();
				?>
				
				
							<div class="col-md-6 col-lg-6 col-xxl-4 columns">	
								<div class="square-rollover">
									<span class="heading"><?php the_title() ?></span>
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

		</div>
	
	<?php } ?>	
