<?php get_header(); ?>


	<?php include (TEMPLATEPATH . '/breadcrumbs.php' ); ?>


	<div class="row products product-row">
			
		<?php while (have_posts()) : the_post(); ?>
			<div class="col-md-6 col-lg-4 columns">	
				<div class="product-link">
					<a href="<?php the_permalink(  ); ?>" class="img">


						<?php 
							$featuredimage_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full' , true)[0];
						?>


							<div class="lazyload lazy fillparent background-cover" data-background-image-url="<?php echo $featuredimage_url; ?>" >
							</div>		
						
					</a>
					<h2 class="heading"><?php echo get_the_title(); ?>.</h2>
					<a href="<?php the_permalink(  ); ?>" class="btn btn-standard">Read more</a>
				</div>
			</div>
		<?php endwhile; ?>
		<div class="pagination-numbered">
		<?php
			 echo paginate_links(  array(
					'prev_text' => __( 'Prev.', 'textdomain' ),
					'next_text' => __( 'Next', 'textdomain' ),
			 ) );
		?>
		</div>

	</div>
		
	


<?php get_footer(); ?>
