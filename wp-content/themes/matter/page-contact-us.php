<?php get_header(); ?>


		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="wrapper background-color-paleslate">
			<div class="row">
				<div class="col-md-12 columns">
					
					<h2 class="contact-form-title"><?php the_title(  );?>.</h2>
				</div >
				<article class="col-lg-9 columns style-bullets client-entry">
					
					
					<?php echo do_shortcode('[contact-form-7 id="25198" title="Contact form 1"]'); ?>
				

				
				
				
				</article>
				<aside class="col-lg-3 columns style-bullets client-entry">
					<?php the_content(); ?>
				</aside>
			</div>
		</div>
		<?php endwhile; endif; ?>

<?php get_footer(); ?>
