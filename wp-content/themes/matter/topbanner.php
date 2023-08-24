		<?php 
						
			$pageParent = $post->post_parent;
			
			if($pageParent == 1137){
				$pageID = 1137;

			}else {
				$pageID = get_the_ID();
			}
			
			if(is_singular( 'post' )){
				$pageID = get_option( 'page_for_posts' );
				
			}

			if(is_home(  )){ 
				$pageID = get_option( 'page_for_posts' );
			}

			
			if(get_field( 'top_banner', $pageID )) { ?>

			<section class="wrapper category-banner">
				<div class="row products ">
					<div class="col-sm-9 col-xl-6 columns content">	
						<h1 class="heading <?php if(isset(get_field( 'top_banner', $pageID )['text_color'])) { echo 'txt-color-'.strtolower(get_field( 'top_banner', $pageID )['text_color']); } ?>"><?php 
							if(get_field( 'top_banner', $pageID )['title']){
								echo get_field( 'top_banner', $pageID )['title'];
							}else {
								echo get_the_title(  );
							}
							 ?>.</h1>
						<p class="<?php if(isset(get_field( 'top_banner', $pageID )['text_color'])) { echo 'txt-color-'.strtolower(get_field( 'top_banner', $pageID )['text_color']); } ?>"><?php echo get_field( 'top_banner', $pageID )['lead_paragraph']; ?></p>
					</div>
				</div>

				<?php 
					$featuredimage_url = wp_get_attachment_image_src(get_field('top_banner' , $pageID)['background_image']['ID'], 'full' , true)[0];
		
					$featuredimage_url_mobile = wp_get_attachment_image_src(get_field('top_banner' , $pageID)['background_image_mobile']['ID'], 'full' , true)[0];
		
				?>
				<div class="img">
					<div class="lazyload lazy fillparent background-cover desktop" data-background-image-url="<?php echo $featuredimage_url; ?>" >
					</div>		
					<div class="lazyload lazy fillparent background-cover mobile" data-background-image-url="<?php echo $featuredimage_url_mobile; ?>" >
					</div>		
				</div>
			</section>
	
			
		<?php } ?>



