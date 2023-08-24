	<div class="row breadcrumbs_wrap">
		<div class="col-md-12 columns">	
			<span class="breadcrumbs"><a href="<?php echo get_site_url(); ?>">Home</a>  
			
			<?php $pageID = get_option( 'page_for_posts' ); ?>
			
			<?php if(is_home()){ ?>
				> <span class="active">IE Collective.</span></span>


			<?php } elseif(is_singular('post')) { ?>
				> <a href="<?php echo get_permalink( $pageID); ?>">IE Collective.</a> > <span class="active"><?php the_title(  ); ?></span></span>			


			<?php } elseif(is_singular('bigcommerce_product')) { ?>
				> <a href="<?php echo get_site_url() ?>/products">Shop</a> > <span class="active"><?php the_title(  ); ?></span></span>			


			<?php } elseif(is_post_type_archive('bigcommerce_product')){ ?>
				> <a href="<?php echo get_site_url() ?>/products">Shop</a>			



			<?php } elseif(is_post_type_archive()){ ?>
				> <span class="active"><?php post_type_archive_title('', true); ?></span>		


			<?php } elseif(is_tax( '' )) { ?>
				> <a href="<?php echo get_site_url() ?>/products">Shop</a> > <span class="active"><?php single_cat_title(); ?></span></span>			


			<?php }  ?>

		</div>
	</div>