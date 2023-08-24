<?php get_header(); ?>


<?php include (TEMPLATEPATH . '/breadcrumbs.php' ); ?>

<div class="background-color-paleslate">
	<div class="row">

		<article class="columns col-lg-12 style-bullets client-entry">
			

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
					
					<h1><?php the_title(); ?></h1>
					
		
					<?php the_content(); ?>
					
			<?php endwhile; endif; ?>

			
		</article>
	</div>
</div>
	
<?php get_footer(); ?>
