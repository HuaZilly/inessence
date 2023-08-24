<?php get_header(); ?>


	<div class="home-banner-wrap">
		<div class="swiper-container home-swiper">
			<div class="swiper-wrapper">
	
				<?php 
					$cc = 0;
					foreach(get_field( 'top_slider') as $slide ){  
						$cc++;
						
					?>
					<div class="swiper-slide" data-slidenumber="<?php echo $cc; ?>">
					
					
					
						<section class="wrapper home-banner home-banner-version-<?php echo strtolower( $slide['text_color'] ); ?>">
							<div class="row products ">
								<div class="col-xl-6 columns content">	
									<h1 class="heading"><?php echo $slide['heading']; ?></h1>

									


									<p><?php echo $slide['text']; ?></p>
									
									<?php if($slide['link']){?>
									
									
									
									
									
										<a href="<?php echo $slide['link']['url']; ?>" class="btn btn-standard 
											<?php if( $slide['text_color'] == "White" ) {
												echo ' btn-reverse ';
											}  ?>"><?php echo $slide['link']['title']; ?></a>
									<?php } ?>
									
									
									
								</div>
							</div>
					
					
					
							<?php 
								$featuredimage_url = wp_get_attachment_image_src($slide['background_image']['ID'], 'full' , true)[0];
					
								$featuredimage_url_mobile = wp_get_attachment_image_src($slide['background_image_mobile']['ID'], 'full' , true)[0];
					
					
					
							?>
					
					
							<div class="img">
								<div class="lazyload lazy fillparent background-cover desktop" data-background-image-url="<?php echo $featuredimage_url; ?>" >
								</div>		
								<div class="lazyload lazy fillparent background-cover mobile" data-background-image-url="<?php echo $featuredimage_url_mobile; ?>" >
								</div>		
							</div>
					
						</section>
					</div>
				
					
				
				<?php } ?>
			</div>
		</div>
	</div>
	
	
	
	
	
	
	<nav class="home-menu">
		<ul>
			<?php 
				
				$cc = 0;
				foreach(get_field( 'top_slider') as $slide ){ 
					$cc++;
					
				?>
				<li><a href="#" class="changeslide <?php if($cc == 1) { echo 'active'; }?>"  data-slidenumber="<?php echo $cc; ?>" >
					
					<img src="<?php echo $slide['icon']['url']; ?>" alt="<?php echo $slide['icon']['alt']; ?>" >
					<p><?php echo $slide['button_text']; ?></p>
				
					
				</a></li>

			<?php } ?>
			
			
		</ul>
	</nav>




	<div class="row products product-row">
			
		<?php foreach(get_field( 'main_links' ) as $mainlink ){ ?>
			<div class="col-md-6 col-lg-4 columns">	
				<div class="product-link">
					<a href="<?php echo $mainlink['link']['url']; ?>" class="img">


						<?php 
							$featuredimage_url = wp_get_attachment_image_src($mainlink['image']['ID'], 'full' , true)[0];
						?>


							<div class="lazyload lazy fillparent background-cover" data-background-image-url="<?php echo $featuredimage_url; ?>" >
							</div>		
						
					</a>
					<h2 class="heading"><?php echo $mainlink['heading']?>.</h2>
					<p><?php echo $mainlink['body']?></p>
					<a href="<?php echo $mainlink['link']['url']; ?>" class="btn btn-standard"><?php echo $mainlink['link']['title']; ?></a>
				</div>
			</div>
		<?php } ?>

	</div>

<?php
$video = get_field('video');
?>
<?php if ($video): ?>
    <div class="video-home">
        <video autoplay loop muted playsinline class="video-desktop">
            <source src="<?= $video['url'] ?>" type="video/mp4">
        </video>
    </div>
<?php endif; ?>
		
	


    


	<div class="box-image-right about_section_home">
		<div class="row ">
			<div class="col-md-12 columns">	
				<div>
					<article class="inner  style-bullets">
						<?php if(get_field( 'about_section' )['heading']) { ?>
							<h2 class="heading addclass-on-focus fadeinandup waitafterimg"><?php echo get_field( 'about_section' )['heading']; ?></h2>
						<?php } ?>
						<div class="addclass-on-focus fadeinandup waitafterimg">
							<?php echo get_field( 'about_section' )['body']; ?>

							<div class="expand" id="expand">
								<?php echo get_field( 'about_section' )['body_expanded']; ?>
	
								<?php 
									if(get_field( 'about_section' )['link']) { ?>
									<a href="<?php echo get_field( 'about_section' )['link']['url']; ?>" class="btn btn-standard"><?php echo get_field( 'about_section' )['link']['title']; ?></a>
								<?php } ?>
							</div>
							<a href="#expanded" class="btn btn-standard expand-btn">Read more</a>



						</div>
					</article>
				</div>
				<?php 
					$featuredimage_url = wp_get_attachment_image_src(get_field( 'about_section' )['image']['ID'], 'full' , true)[0];
				?>
				<div class="img addclass-on-focus fadeinfromleft">
					<div class="lazyload lazy fillparent background-cover" data-background-image-url="<?php echo $featuredimage_url; ?>" >
					</div>		
				</div>

			</div>
		</div>
	</div>

<?php $additionalContent = get_field('additional_content');?>
<?php if(get_field('additional_content')): ?>
    <?= $additionalContent ?>
<?php endif;?>

	
<?php get_footer(); ?>
