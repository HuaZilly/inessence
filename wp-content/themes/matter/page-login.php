<?php get_header(); ?>
		<div class="wrapper">
			<div class="row">
				<div class="col-md-12 columns ">
					<h1 class="account-page-title">Log In.</h1>
				</div>
			</div>
		</div>
		<div class="wrapper background-color-paleslate">
			<div class="row">
				<article class="col-md-12 columns style-bullets client-entry">
					
		
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
							
				
							<?php the_content(); ?>
				
					<?php endwhile; endif; ?>
				</article>
			</div>
		</div>


<?php get_footer(); ?>
