<?php get_header(); ?>


	<div class="wrapper ">

		<div class="row">
			<div class="col-xl-12 columns">
				
				<div class="subscribe-form-wrap client-entry">

					<div class="klaviyo-form-PsGjGA"></div>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php the_content(); ?>
					<?php endwhile; endif; ?>

				</div>
			</div>
		</div>
	</div>	


<?php get_footer(); ?>
