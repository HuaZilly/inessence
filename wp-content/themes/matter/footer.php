		<?php if(is_post_type_archive(  ) || is_search(  ) || is_home() || is_tax( 'bigcommerce_brand' ) || is_tax( 'bigcommerce_category' )) { ?>

		<a href="#top" class="btn btn-checkout backtotop">Back to top</a>
		<?php } ?>
		
		<?php if(!is_page( 'email-sign-up' )){ ?>
		
			<div class="wrapper subscribe-form-wrap addclass-on-focus fadeinandup" id="subscribe">
	
				<div class="row">
					<div class="col-xl-12 columns">
						<h3><?php echo get_field( 'subscribe', 'options')['heading']?>.</h3>
						<p><?php echo get_field( 'subscribe', 'options')['body']?></p>
						
						<div class="klaviyo-form-PsGjGA"></div>
						<div class="klaviyo-form-R3Jj78"></div>
						<?php 
							if(isset($_GET['status_subscribe'])){
								echo "<div class='subscribe-success'><p>You've Been Subscribed!</p></div>";
							}
						?>
						
					</div>
				</div>
			</div>	
		<?php } ?>
	
		<div class="footer-outer">

	
	
			<div class="wrapper">
				<div class="row">
					<div class="col-xl-12 columns">
	
	
						<ul class="footer-features">
	
	
							<?php
								$args = array(
									'posts_per_page' => -1,
									'post_type' => 'feature'
								);
							
								$custom_posts = new WP_Query($args);
							
								if($custom_posts->have_posts()) : 
									while($custom_posts->have_posts()) : 
										$custom_posts->the_post();
							?>
	
	
									<li class="addclass-on-focus fadeinandup" style="transition-delay: <?php echo $cc/3; ?>s">
		
										<?php
											$featuredimage_id = get_post_thumbnail_id(get_the_ID());
											$featuredimage_url_array = wp_get_attachment_image_src($featuredimage_id, 'full', true);
											$featuredimage_url = $featuredimage_url_array[0];
											
											$alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
									
										?>
										
										<img src="<?php echo $featuredimage_url; ?>" alt="<?php echo $alt; ?>" width="69" height="68" class=""/>
		
										<p><?php echo get_field( 'display_text' );?></p>
									</li>
	
							<?php
								endwhile;
								else: 
							?>
							
							<?php endif; ?>
							<?php wp_reset_query(); ?>
							
							
							
	
	
	
							
	
						</ul>
	
	
	
	
	
	
					</div>
				</div>
			</div>
	
	
	
	
			<div class="wrapper footer-wrapper background-color-paleslate">
	
				<div class="row reverse-row">
					<div class="col-xl-8 columns footer-menu-wrap">	
	
						<ul class="footer-menu">
	
						<?php foreach(wp_get_nav_menu_items(20) as $menuitem){ 
							
							
						?>
						
							<?php if( $menuitem->menu_item_parent == 0) { 
								
	// 							echo $menuitem->title .$menuitem->object_id . '/'. $menuitem->menu_item_parent. '<br><br>';
								
								
							?>
	
								<li><a href="<?php echo $menuitem->url; ?>" data-menu="<?php echo 'footer_submenu'.$menuitem->object_id; ?>" class="<?php if(in_array('has_children', $menuitem->classes)) { echo ' open-footer-submenu '; }?>"><?php echo $menuitem->title; ?></a></li>
	
							<?php } ?>
						<?php } ?>
	
						</ul>	
	
	
	
						<ul class="social-media-links">
							<li><a href="<?php echo get_field( 'facebook', 'options'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(  ); ?>/images/facebook.svg" alt="facebook" ></a></li>
							<li><a href="<?php echo get_field( 'youtube', 'options'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(  ); ?>/images/youtube.svg" alt="youtube" ></a></li>
							<li><a href="<?php echo get_field( 'instagram', 'options'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(  ); ?>/images/instagram.svg" alt="instagram" ></a></li>
						</ul>		
					</div>
					<div class="col-xl-4 columns">	
	
						<span class="copyright">&copy; <?php echo date("Y");?> <?php echo get_field( 'copyright', 'options');?></span>
					</div>
				</div>
	
				<?php foreach(wp_get_nav_menu_items(20) as $menuitem){ 
					
	/*
					var_dump($menuitem->title, $menuitem->menu_item_parent);
					
					echo '<br><br><br><br>';
	*/
					
					
				?>
					<?php if( $menuitem->menu_item_parent == 0) { 
						
	
	
	
						 ?>
	
							<ul class="footer-submenu" data-menu="<?php echo 'footer_submenu'.$menuitem->object_id; ?>">
								
								
								<?php
	/*
								echo $menuitem->title .$menuitem->object_id . '/'. $menuitem->menu_item_parent. '<br><br>';
									
									
											echo '--'.$parentID = $menuitem->object_id;
	*/
	// 								;
	
									$parentID =  str_replace('has_children,', '',  implode(',', $menuitem->classes) );
									
									
									
									 foreach(wp_get_nav_menu_items(20) as $menuitem){ 
										 
										 
										 
	// 									 echo $menuitem->menu_item_parent .'/'.$menuitem->object_id  .'/'.$menuitem->title .'<br>';
										 
	// 									 echo $menuitem->object_id.$menuitem->title;
										 
								?>
										<?php 
											
	/*
												echo ']]]' . $menuitem->title .$menuitem->object_id . '/'. $menuitem->menu_item_parent. '<br><br>';
												
	*/
	
	// 										var_dump($menuitem);
	
												
											if( $parentID == implode(',', $menuitem->classes))  {  
											
											
										
										?>
											<li><a href="<?php echo  $menuitem->url; ?>"><?php echo $menuitem->title; ?></a></li>
										<?php } ?>
								<?php } ?>
								
								
								
								
								
							</ul>	
					<?php } ?>
				<?php } ?>
	
				
			</div>


		</div>


		<?php wp_footer(); ?>


		<script>
			var siteURL = "<?php echo get_site_url(); ?>";
			var themeURL = "<?php echo get_template_directory_uri(); ?>";
		</script>

        <script
		async type="text/javascript"
		src="//static.klaviyo.com/onsite/js/klaviyo.js?company_id=NkQJdV"></script>

	

		<noscript>
			<span class="warning nojs-warn">
				<span>This website requires Javascript for optimum viewing purposes. Please <a href="http://enable-javascript.com" target="_blank">enable javascript</a> in your browser.</span>
			</span>
		</noscript>


		<span class="warning datedbrowser-warn">
			<span>It appears you're using an old version of Internet Explorer which is <a href="https://www.microsoft.com/en-au/windowsforbusiness/end-of-ie-support" target="_blank">no longer supported</a>, for safer and optimum browsing experience please upgrade your browser.</span>
		</span>



	</body>

</html>
