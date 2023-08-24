<?php get_header(); ?>

<?php if(get_field( 'mission' )) { ?>

	<div class="wrapper background-color-paleslate mission-statement-wrap">
		<div class="row">
			<div class="col-md-12 columns">
				
				<div class="mission-statement">		
					<h2 class="heading"><?php echo get_field( 'mission' )['heading']; ?></h2> <p><?php echo get_field( 'mission' )['body']; ?></p>
				</div>
			</div>
		</div>			
	</div>			

<?php } ?>	





<?php if(get_field( '3_x_3_grid' )) { ?>

		<div class="wrapper">
			<div class="row">
				<div class="col-md-12 columns">
					<h2 class="h3 feature-swiper-title"><?php echo get_field( 'grid_heading' ); ?></h2>

					<div class="feature-grid">
						<?php 
							$cc = 0;
							
							foreach(get_field( '3_x_3_grid' ) as $field){ 
								$cc++;
								
							?>
							<div class="text addclass-on-focus fadeinstill" style="transition-delay:<?php echo $cc/3; ?>s">
								<p><?php echo $field['text']; ?></p>
							</div>

			
							<?php 
								if($field['image']){
									
								
								$featuredimage_url = wp_get_attachment_image_src($field['image']['ID'], 'full' , true)[0];
							?>
								<div class="img addclass-on-focus fadeinstill" style="transition-delay:<?php echo $cc/2; ?>s">
									<div class="lazyload lazy fillparent background-cover" data-background-image-url="<?php echo $featuredimage_url; ?>" >
									</div>		
								</div>
							<?php } ?>

						<?php } ?>
					</div>			
				</div>
			</div>
		</div>
<?php } ?>	




<?php if(get_field( 'features_boxes' )) { ?>


	<?php if(get_field( 'features_boxes' )['intro']['heading']){ ?>
		<div class="wrapper background-color-paleslate features_boxes_header">
			<div class="row">
				<div class="col-md-12 columns">
	
					<h2><?php echo get_field( 'features_boxes' )['intro']['heading']; ?>.</h2>
					<?php if(isset(get_field( 'features_boxes' )['intro']['paragraph'])){ ?>
						<?php echo get_field( 'features_boxes' )['intro']['paragraph']; ?>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php 
	if(get_field( 'features_boxes' )['boxes']){ 
		$cc = 0;
		
		if(is_page( 'meet-our-expert' )){
			$cc = 1;
			
		}	
		
		foreach(get_field( 'features_boxes' )['boxes'] as $featurebox) { 
			$cc++;

			if(sizeof(get_field( 'features_boxes' )['boxes']) > 1){
				$alternatecolors = true;
				
			}

		?>
		
		<div class="box-image-<?php 
			
			if($cc % 2 == 0){ 
				echo 'left'; 
			} else { 
				echo 'right'; 
				if($alternatecolors){ 
					echo ' background-color-white ';
				}

			} 
				
			?> ">
			<div class="row ">
				<div class="col-md-12 columns">	
					<div>
						<article class="inner  style-bullets">
							<?php if($featurebox['heading']) { ?>
								<h2 class="heading addclass-on-focus fadeinandup waitafterimg"><?php echo $featurebox['heading']; ?>.</h2>
							<?php } ?>
							<div class="addclass-on-focus fadeinandup waitafterimg">
								<?php echo $featurebox['body']; ?>
							</div>
							<?php if($featurebox['button']) { ?>
								<a href="<?php echo $featurebox['button']['url']; ?>" class="btn btn-standard"><?php echo $featurebox['button']['title']; ?></a>
							<?php } ?>
						</article>
					</div>
					<?php 
						$featuredimage_url = wp_get_attachment_image_src($featurebox['image']['ID'], 'full' , true)[0];
					?>
					<div class="img addclass-on-focus fadeinfrom<?php if($cc % 2 == 0){ echo 'right'; } else { echo 'left'; } ?>">
						<div class="lazyload lazy fillparent background-cover" data-background-image-url="<?php echo $featuredimage_url; ?>" >
						</div>		
					</div>

				</div>
			</div>
		</div>	

	
	<?php } ?>
	
	
				<?php if(sizeof(get_field( 'features_boxes' )['boxes']) > 1){ ?>
					<div class="row aligncenter">
						<div class="col-md-12 columns">	
							<a href="#top" class="btn btn-standard btn-backtotop">Back to top</a>
						</div>
					</div>
				
				<?php } ?>

	
	<?php 
		}
	?>	
	
<?php } ?>	
	






<?php if(get_field( 'carousel' )) { ?>

	<?php 
		
		if(get_field( 'carousel' )['title'] != ''){ ?>
		<div class="row">
			<div class="col-md-12 columns">

				<h3 class="feature-swiper-title"><?php echo get_field( 'carousel' )['title']; ?></h3>
			</div>
		</div>
	<?php } ?>


	<?php 
		if(get_field( 'carousel' )['slides']){ ?>
			




			<div class="swiper-container feature-swiper">
				<div class="swiper-wrapper">
				
					<?php 
						$cc = 0;
						foreach(get_field( 'carousel' )['slides'] as $featurebox) { 
							$cc++;
							
						?>

						<div class="swiper-slide" data-slidenumber="<?php echo $cc; ?>">
							<div class="box-image-left">
								<div class="row ">
									<div class="col-md-12 columns">	
										<article>
											<div class="inner">
												<h2 class="heading"><?php echo $featurebox['heading']; ?>.</h2>
												<?php echo $featurebox['body']; ?>
											</div>
										</article>
										<?php 
											$featuredimage_url = wp_get_attachment_image_src($featurebox['image']['ID'], 'full' , true)[0];
										?>
										<div class="img">
											<div class="lazyload lazy fillparent background-cover" data-background-image-url="<?php echo $featuredimage_url; ?>" >
											</div>		
										</div>
					
									</div>
								</div>
							</div>	
						</div>


					
					<?php } ?>

				</div>
		
			</div>



		<div class="generic-page-menu">
			<ul class="">
				<?php 
					$cc = 0;
					foreach(get_field( 'carousel' )['slides'] as $featurebox) { 
						$cc++;
					?>
		
						<li class=""><a href="#" data-slidenumber="<?php echo $cc; ?>" class=" changeslide"><?php echo $featurebox['heading']; ?></a></li>
		
		
			
				<?php } ?>	
	
			</ul>			
		</div>		
	<?php } ?>	

<?php } ?>	
	
	
	
	


<?php if(get_field( 'steps' )) { ?>

	

		<div class="wrapper">
			<div class="row">
				<div class="col-md-12 columns">

					<h2 class="h3 feature-swiper-title"><?php echo get_field( 'steps' )['heading']; ?></h2>
					<p><?php echo get_field( 'steps' )['lead_paragraph']; ?></p>


					<ul class=" symbol-list">


							<?php 
							$cc = 0;
								foreach( get_field( 'steps' )['steps'] as $step ){ 
								$cc++;
							?>
									
									<li class="li addclass-on-focus fadeinandup" style="transition-delay: <?php echo $cc/3; ?>s">
										<img src="<?php echo $step['icon']['url']; ?>" alt="<?php echo $step['icon']['alt']; ?>"/>
										<h4 class="heading"><?php echo $step['heading']; ?>.</h4>
										<p><?php echo $step['body']; ?></p>
									</li>
							
							<?php } ?>
					</ul>


					<div class="swiper-container symbol-list">
						<div class="swiper-wrapper">
						
							<?php foreach( get_field( 'steps' )['steps'] as $step ){ ?>
									<div class="swiper-slide">
										<img src="<?php echo $step['icon']['url']; ?>" alt="<?php echo $step['icon']['alt']; ?>"/>
										<h4 class="heading"><?php echo $step['heading']; ?>.</h4>
										<p><?php echo $step['body']; ?></p>
									</div>
							
							<?php } ?>

						</div>
					    <div class="swiper-pagination"></div>
				
					</div>

					<?php 
				$general_content = get_field( 'general_content' );

				if($general_content) { 
					
				?>
				<div class="">
					<?php echo $general_content; ?>	
				</div>

				<?php } ?>



					
				</div>
				
				
			</div>
		</div>


<?php } ?>	







	
	
	
	<?php if(is_page( 'the-finest-harvest' )) {?>
		<div class="row  product-row">
			
				
				
				<?php
					
					foreach(get_field( 'source_selection' ) as $source){
						
						$sourceID = $source->ID;
						
				?>
				
				
							<div class="col-md-6 col-lg-6 col-xxl-4 columns">	
								<div class="square-rollover">
									<span class="heading"><?php echo get_the_title($sourceID); ?></span>
									<div class="content">
										<div class="inner">
											<h3 class="heading"><?php echo get_the_title($sourceID); ?></h3>
											<?php 
												echo get_post( $sourceID )->post_content; ?>
										</div>
									</div>
									<div class="img">
					
										<?php 
											
											$featuredimage_id = get_post_thumbnail_id($sourceID);
							
											$featuredimage_urlarray = wp_get_attachment_image_src($featuredimage_id, 'full' , true);
											$featuredimage_url = $featuredimage_urlarray[0];
											
										?>
							
										<div class="lazyload lazy fillparent background-cover" data-background-image-url="<?php echo $featuredimage_url; ?>" >
										</div>		
									</div>
								</div>
							</div>
				      
				<?php } ?>

		</div>
	
	<?php } ?>	

	
	<?php if(get_the_content( )) { ?>



		<?php 

		if(
			is_page( 'account-profile' )
			|| is_page( 'addresses' )
			|| is_page( 'order-history' )
			|| is_page( 'wish-lists' )
		){ ?>
			

			<div class="wrapper  ">
				<div class="row">
					<article class="col-md-12 columns bc-account-pages-restyled">
						
			
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
								
					
								<?php the_content(); ?>
					
						<?php endwhile; endif; ?>
					</article>
				</div>
			</div>
				
			

		<?php } else { ?>
	
			<div class="wrapper background-color-paleslate ">
				<div class="row">
					<article class="col-md-12 columns style-bullets client-entry">
						
			
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
								
					
								<?php the_content(); ?>
					
						<?php endwhile; endif; ?>
					</article>
				</div>
			</div>

		<?php } ?>	
	<?php } ?>	

<?php get_footer(); ?>
