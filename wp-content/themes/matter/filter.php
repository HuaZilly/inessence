<div class="wrapper filter-wrap <?php if(!empty($_GET)) { echo 'open'; }?>" id="filter_menu">
	
	<div class="row">
		<div class="col-md-12 columns">	
			<nav class="">
				
				
				
				<a href="" class="open-filter <?php if(!empty($_GET)) { echo 'open'; }?>" id="openfilter">Filter by</a>

				<div class="sort-filter">
					<label value="">Sort by</label>
					<select id="sort-results">
						<option value="latest">Latest</option>
						<option value="popular">Best sellers</option>
						<option value="pricelowtohigh">Price (low to high)</option>
						<option value="pricehightolow">Price (high to low)</option>
					</select>
				</div>


				<?php
					
					
				/**
				 * The template for rendering the search/sort/filter form
				 *
				 * @var string   $action  The form action URL
				 * @var string   $search  The search box HTML
				 * @var string   $sort    The sort box HTML
				 * @var string[] $filters HTML for each of the filter selects
				 */



				?>
				
				<form action="<?php echo esc_url( $action ); ?>" method="get" class="filter">
					<div class="ul">
						<?php 
					
						if( is_tax( 'bigcommerce_brand' ) || is_post_type_archive( 'bigcommerce_product' ) || is_search(  ) ){ 
					
							$obj = get_queried_object();
							
							$bc_cat = '0';
							$bc_price = "";
							$bc_size = "";
							$current_cat = $bc_cat;
							if (isset($_GET['bigcommerce_category'])) $bc_cat = $_GET['bigcommerce_category'];
							if (isset($_GET['fwp_price'])) $bc_price = $_GET['fwp_price'];
							if (isset($_GET['fwp_size'])) $bc_size = $_GET['fwp_size'];
					
							$args = array(
								'taxonomy' => 'bigcommerce_category',
								'hide_empty' => true, // Set to true to avoid
								'parent' => 0,
								'exclude' => array(6,33, 8, 36)
							);
							
							if($obj != null){
								
								if (get_class($obj) === "WP_Term") {
									// Get category children
									$args = array_merge( $args, array(
										'parent' => $obj->term_id,
										'exclude' => array(6,33, 8, 36)
	
									) );
						
									if ($bc_cat === '0') $bc_cat = $obj->slug;
									$current_cat = $obj->slug;
								}
							}
							$categories = get_terms( $args );
							if (count($categories) > 0) : 
							
							
						?>
						
							<div class="li menu-item-has-children">
								<span class="heading">Products</span>
								<div class="ul radio-list">
									<div class="li"><input type="checkbox" name="bigcommerce_category" onclick="this.form.submit()" id="bigcommerce_category_<?php echo $current_cat ?>" class="shopall" value="<?php echo $current_cat ?>"<?php if ($bc_cat === $current_cat) { echo " checked"; } ?> /> <label for="bigcommerce_category_<?php echo $current_cat ?>">All</label></div>


									<?php foreach ($categories as $c) :  ?>
									
									<div data-value="<?php echo $c->slug ?>"]><input type="checkbox" name="bigcommerce_category" onclick="this.form.submit()" id="bigcommerce_category_<?php echo $c->slug ?>" value="<?php echo $c->slug ?>"<?php if ($bc_cat === $c->slug) echo " checked"; ?> /> <label for="bigcommerce_category_<?php echo $c->slug ?>"><?php echo esc_html($c->name) ?></label></div>

									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; 
							
							}
						?>

					


					<?php if(is_tax( 'bigcommerce_category' ) || is_post_type_archive( 'bigcommerce_product' ) || is_search(  ) ){  ?>

						<div class="li menu-item-has-children">
							<span class="heading">Collections</span>
							<div class="ul radio-list">
								<div class="li"><input type="checkbox" name="fwp_price" onclick="this.form.submit()" id="fwp_price_all" class="shopall" value="" <?php 
								
								
									if ($_GET['fwp_collections'] === null) {
										echo " checked"; 
										
									}
									
								?> 
								data-name="collections"
								
								/> <label for="fwp_price_all">All</label></div>
								<?php echo do_shortcode('[facetwp facet="collections"]'); ?>
							</div>
						</div>


					<?php } ?>



				
					<div class="li menu-item-has-children">
						<span class="heading">Size</span>
						<div class="ul radio-list">
							<div class="li"><input type="checkbox" name="fwp_categories" onclick="this.form.submit()" id="fwp_size_all" class="shopall" value="" <?php 
								
								
									if ($_GET['fwp_categories'] === null) {
										echo " checked"; 
										
									}
									
								?>  
								data-name="categories"
								/> <label for="fwp_size_all">All</label></div>
							<?php echo do_shortcode('[facetwp facet="categories"]'); ?>




						</div>
					</div>
				

				
					</div>

				</form>






			</nav>

		</div>
	</div>
</div>






