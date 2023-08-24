<?php
	require '../../../wp-load.php';

	$searchTerm = $_GET['s'];

// 	echo $searchTerm;


	$args = array(
		'posts_per_page' => -1,
		's' => $searchTerm
	);

	$custom_posts = new WP_Query($args);

	$count = $custom_posts->found_posts;

	$cc = 0;

	if($custom_posts->have_posts()) : 
		while($custom_posts->have_posts()) : 
			$custom_posts->the_post();
			
			if(
				(get_post_type(  ) == "bigcommerce_product") 
			){
				
				$cc++;
			

?>

						<a href="<?php the_permalink(  ); ?>" class="search-result <?php if(  strpos(strtolower(get_the_title(  )), strtolower( $searchTerm )) > -1  ){ echo 'high-priority'; }?>">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
							<span class="product-title"><?php the_title() ?></span>
							
				
							<span class="product-price">
								<?php $product = new \BigCommerce\Post_Types\Product\Product( $post->ID ); ?>
				
					
					
								<?php if($product->sale_price){ ?>
									<span><?php echo formatAsPrice($product->sale_price); ?></span> <del><?php echo formatAsPrice($product->price); ?></del>
								<?php } else { ?>
									<span><?php echo formatAsPrice($product->price); ?></span>
								<?php } ?>
				
							</span>
				
				
						</a>


<?php 
			}
			
	endwhile; ?>
	

<?php


	else: 
?>
	<p>Sorry, no search results</p>

<?php endif; ?>

<?php 
	if($cc >= 3){ ?>
	
	<a href="<?php echo get_site_url(); ?>/search/<?php echo $searchTerm; ?>/" class="btn btn-standard" id="viewallsearchresults">View all</a>

<?php } ?>

<?php wp_reset_query(); ?>
