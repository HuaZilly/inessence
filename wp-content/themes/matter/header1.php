<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<?php if (is_search()) { ?>
		   <meta name="robots" content="noindex, nofollow" /> 
		<?php } ?>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<meta name="msapplication-tap-highlight" content="no">

		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?v=1.11" type="text/css" />

        <?php
        $type = 'Content';
        if(is_page( 'home' )) {
            $type = 'Home';
        } else if(in_array('tax-bigcommerce_category',get_body_class())) {
            $type = 'Category';
        } else if(in_array('post-type-archive-bigcommerce_product',get_body_class())) { 
            $type = 'Category';
        } else if(in_array('single-bigcommerce_product',get_body_class())) {
            $type = 'Product';
        } else if(strpos($_SERVER['REQUEST_URI'], 'cart') !== false) {
            $type = 'Basket';
        } else if(strpos($_SERVER['REQUEST_URI'], 'search') !== false) {
            $type = 'Search';
        }
        ?>

            <script type="text/javascript">
                window.insider_object = {
                    "page": {
                        "type": "<?php echo $type; ?>"
                    }
                }
                <?php
                    if ( ! is_admin() && is_user_logged_in()) {
                        $loggedinUser = wp_get_current_user();
                        ?>
                        window.insider_object.user =  {
                                "uuid": "<?php  if(!empty( $loggedinUser->get( 'user_email' ) )) { echo $loggedinUser->get( 'user_email' ); } else { echo '';}?>",
                                "custom": {
                                    "membership_type": "<?php  if(isset( $loggedinUser->roles[0])) { echo $loggedinUser->roles[0]; } else { echo '';}?>",
                                },
                                "gdpr_optin": true,
                                "name": "<?php  if(!empty( $loggedinUser->get( 'display_name' ) )) { echo $loggedinUser->get( 'display_name' ); } else { echo '';}?>",
                                "email": "<?php  if(!empty( $loggedinUser->get( 'user_email' ) )) { echo $loggedinUser->get( 'user_email' ); } else { echo '';}?>",
                            }
                 <?php }?>
            </script>
        <script>
            //!function(t,n){function o(n){var o=t.getElementsByTagName("script")[0],i=t.createElement("script");i.src=n,i.crossOrigin="",o.parentNode.insertBefore(i,o)}if(!n.isLoyaltyLion){window.loyaltylion=n,void 0===window.lion&&(window.lion=n),n.version=2,n.isLoyaltyLion=!0;var i=new Date,e=i.getFullYear().toString()+i.getMonth().toString()+i.getDate().toString();o("https://sdk.loyaltylion.net/static/2/loader.js?t="+e);var r=!1;n.init=function(t){if(r)throw new Error("Cannot call loyaltylion.init more than once");r=!0;var a=n._token=t.token;if(!a)throw new Error("Token must be supplied to loyaltylion.init");for(var l=[],s="_push configure bootstrap shutdown on removeListener authenticateCustomer".split(" "),c=0;c<s.length;c+=1)!function(t,n){t[n]=function(){l.push([n,Array.prototype.slice.call(arguments,0)])}}(n,s[c]);o("https://sdk.loyaltylion.net/sdk/start/"+a+".js?t="+e+i.getHours().toString()),n._initData=t,n._buffer=l}}}(document,window.loyaltylion||[]);
			!function(t,n){var e=n.loyaltylion||[];if(!e.isLoyaltyLion){n.loyaltylion=e,void 0===n.lion&&(n.lion=e),e.version=2,e.isLoyaltyLion=!0;var o=n.URLSearchParams,i=n.sessionStorage,r="ll_loader_revision",a=(new Date).toISOString().replace(/-/g,""),s="function"==typeof o?function(){try{var t=new o(n.location.search).get(r);return t&&i.setItem(r,t),i.getItem(r)}catch(t){return""}}():null;c("https://sdk.loyaltylion.net/static/2/"+a.slice(0,8)+"/loader"+(s?"-"+s:"")+".js");var l=!1;e.init=function(t){if(l)throw new Error("Cannot call lion.init more than once");l=!0;var n=e._token=t.token;if(!n)throw new Error("Token must be supplied to lion.init");var o=[];function i(t,n){t[n]=function(){o.push([n,Array.prototype.slice.call(arguments,0)])}}"_push configure bootstrap shutdown on removeListener authenticateCustomer".split(" ").forEach(function(t){i(e,t)}),c("https://sdk.loyaltylion.net/sdk/start/"+a.slice(0,11)+"/"+n+".js"),e._initData=t,e._buffer=o}}function c(n){var e=t.getElementsByTagName("script")[0],o=t.createElement("script");o.src=n,o.crossOrigin="",e.parentNode.insertBefore(o,e)}}(document,window);
			<?php
            if ( ! is_admin() && is_user_logged_in()) {
            $loggedinUser = wp_get_current_user();
			$date = date('c');
			$secret = '2ca5526e45d504b13af4e05aa327cee0';

			$auth_token = sha1( get_user_meta($loggedinUser->get( 'ID' ),'wp_bigcommerce_customer_id')[0] . $date . $loggedinUser->get( 'user_email' ) . $secret );
            ?>
            loyaltylion.init({
				token: 'd3ec126cbf6cf017812ab46fd08bb597', // site toke
				auth: {
					date: '<?php echo $date?>', // ISO 8601 timestamp, must be same as that used to create the token
					token: '<?php echo $auth_token; ?>', // token, generated server-side
				},	
                customer: {
                    id: "<?php  if(!empty( $loggedinUser->get( 'ID' ) )) { echo get_user_meta($loggedinUser->get( 'ID' ),'wp_bigcommerce_customer_id')[0]; } else { echo '';}?>",
                    email: "<?php  if(!empty( $loggedinUser->get( 'user_email' ) )) { echo $loggedinUser->get( 'user_email' ); } else { echo '';}?>"
                }
            });
            <?php } else {?>
            loyaltylion.init({ token: "d3ec126cbf6cf017812ab46fd08bb597" });

            <?php }?>
        </script>

		<?php wp_head(); ?>
		<?php
		// bigcommerce()->credentials_set() 
		//$cartApiClient  = bigcommerce()->api->register();
		//echo $cartApiClient->host;
		//$cartApiClient = new \BigCommerce\Api\v3\ApiClient();
		//$cartApi = new \BigCommerce\Api\v3\Api\CartApi($cartApiClient);
        //$cart = new \BigCommerce\Cart\Cart($cartApi);
		//$cartId = $cart->get_cart_id();
		//$cartItems = $cartApi->cartsCartIdGet($cartId);
        //$cartItems = $cartApi->cartsCartIdGet($cartId);
			//	$cartdata = bigcommerce()->cart();
		//echo   get_option( \Settings\Sections\Currency::CURRENCY_CODE, 'USD' );
		//$cartdata = bigcommerce()->cart->register(''); 

		try {
		$container = bigcommerce()->container();
		$cartApi = new \BigCommerce\Cart\Cart($container[\BigCommerce\Container\Api::FACTORY]->cart());
		//$cart = new \BigCommerce\Cart\Cart($cartApi);
	    $cartId =  $cartApi->get_cart_id();
		$include = [
			'line_items.physical_items.options',
			'line_items.digital_items.options',
			'redirect_urls',
		];
		if($cartId !='') {
		$cartItems = $container[\BigCommerce\Container\Api::FACTORY]->cart()->cartsCartIdGet($cartId, [ 'include' => $include ] )->getData();

		$mapper = new \BigCommerce\Cart\Cart_Mapper($cartItems);
		$itemCollect = $mapper->map();
        ?>
<script type="text/javascript">
    nostojs(api => {
        api.defaultSession()
            .setCart({
                items: [
                <?php foreach($itemCollect['items'] as $item) : ?>
                    <?php
                       // $productLoad = new \BigCommerce\Post_Types\Product\Product($item['post_id']);
                        $unitPrice = $item["list_price"]["raw"];
                        $productSku = $item["sku"]["product"];
                    ?>
                        {
                            name: '<?= $item["name"] ?>',
                            price_currency_code: 'AUD',
                            product_id: <?= $item["product_id"] ?>,
                            quantity: <?= $item["quantity"] ?>,
                            <?php if($productSku): ?>sku_id: <?= $productSku ?>, <?php endif;?>
                            <?php if($unitPrice): ?>unit_price: <?= $unitPrice ?> <?php endif;?>
                        },
                <?php endforeach; ?>
                    ]
            }).<?php if($post->post_name == 'cart'){?>viewCart().load()<?php } else{?>viewCart().update()<?php } ?> 
        });
</script>
<?php } ?>
<?php } catch ( \BigCommerce\Api\v3\ApiException $e ) {
			return [];
		}
		?>




		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(  ); ?>/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(  ); ?>/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(  ); ?>/favicon/favicon-16x16.png">
		<link rel="manifest" href="<?php echo get_template_directory_uri(  ); ?>/favicon/site.webmanifest">
		<link rel="mask-icon" href="<?php echo get_template_directory_uri(  ); ?>/favicon/safari-pinned-tab.svg" color="#000000">
		<meta name="msapplication-TileColor" content="#000000">
		<meta name="theme-color" content="#ffffff">


		
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(  ); ?>/favicon/favicon.ico" type="image/x-icon" />
		<script async="" type="text/javascript" src="https://apps.bazaarvoice.com/deployments/inessence-au/main_site/production/en_AU/bv.js"></script>
		
		<!-- START Rakuten Marketing Tracking -->
		  <script type="text/javascript">
			(function (url) {
			  /*Tracking Bootstrap Set Up DataLayer objects/properties here*/
			  if(!window.DataLayer){
				window.DataLayer = {};
			  }
			  if(!DataLayer.events){
				DataLayer.events = {};
			  }
			  DataLayer.events.SPIVersion = DataLayer.events.SPIVersion || "3.4.1";
			  DataLayer.events.SiteSection = "1";

			  var loc, ct = document.createElement("script");
			  ct.type = "text/javascript";
			  ct.async = true; ct.src = url; loc = document.getElementsByTagName('script')[0];
			  loc.parentNode.insertBefore(ct, loc);
			  }(document.location.protocol + "//tag.rmp.rakuten.com/122675.ct.js"));
		  </script>
		<!-- END Rakuten Marketing Tracking -->
		
		<style>
		<?php 
			$hiddenFromMenu = get_field( 'hide_categories', 'options' );

			foreach(get_terms('bigcommerce_category') as $cat){
				if(in_array(intval($cat->term_id), $hiddenFromMenu)){ ?>[data-value="<?php echo $cat->slug; ?>"] { display: none; }<?php
				}
			}
		?>
		</style>
		
		<?php if (is_user_logged_in()): ?>
            <?php
                $userId = get_current_user_id();
                $userEmail = get_userdata($userId)->user_email;
                $firstName = get_userdata($userId)->user_firstname;
                $lastName = get_userdata($userId)->user_lastname;
            ?>
            <script type="text/javascript">
                nostojs(api => {
                    api.defaultSession()
                        .setCustomer({
                            customer_reference: '<?= md5($userEmail) ?>',
                            email: '<?= $userEmail ?>',
                            first_name: '<?= $firstName ?>',
                            last_name: '<?= $lastName ?>',
                            newsletter: true,
                     })
                });
            </script>
        <?php endif;?>
	</head>
	<?php 
		if($post){
			$post_slug = "  fadein page-id-".$post->post_name;			
		}else {
			$post_slug = ' fadein ';
		}
		
		
		
	?>
	<body <?php body_class($post_slug); ?>>


		
		<div id="top" class="top"></div>
		
		
		
		<div class="wrapper header-wrapper" id="header">
			<div class="row">
				<header class="col-lg-12 columns header">
					<div class="left">
						<button class="hamburger-btn" id="open-menu">
							<em></em>
							<em></em>
							<em></em>
						</button>
						
						<a href="<?php echo get_site_url(); ?>" class="logo-wrap">
							<img src="<?php echo get_template_directory_uri(  ); ?>/images/inessence-logo.svg" alt="inessence-logo" >
						</a>
					</div>
					
					<nav class="desktop-menu" id="menu">

						<ul>
			
							<?php
							
							$defaults = array(
								'theme_location'  => '',
								'menu'            => 'Top',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => '',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => false,
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '%3$s',
								'depth'           => 0,
								'walker'          => ''
							);
							
							wp_nav_menu( $defaults );
							
							?>
						
							<li class="mobile-link my-account-link"><a href="<?php echo get_site_url(); ?>/account-profile">My Account</a></li>
							<li class="mobile-link"><a href="<?php echo get_site_url(); ?>/email-sign-up/">Email sign up</a></li>
							<li class="mobile-link"><a href="<?php echo get_site_url(); ?>/customer-service/contact-us/">Customer Service</a></li>

						</ul>


					</nav>

					<div class="search-form-wrap desktop-search-form-wrap">

	
						<form action="<?php echo get_site_url(); ?>" method="get" class="search-form " id="desktopsearch">
						    <input type="text" name="s" class="searchfield" placeholder="Search" autocomplete="off"/>
							<button class="search-btn-hidden"></button>

						</form>







					</div>


					<nav class="shop-nav">
						<div class="open-search-btn">
							<a href="" class="opensearch-btn" id="opensearch"><img src="<?php echo get_template_directory_uri(  ); ?>/images/search.svg" alt="search" class="search" ></a>
							<button class="search-btn desktop-search-btn trigger-search-btn"><img src="<?php echo get_template_directory_uri(  ); ?>/images/search.svg" alt="search" class="search"></button>
						</div>
						<a href="" class="close-search-btn" id="closesearch">
							<img src="<?php echo get_template_directory_uri(  ); ?>/images/close-search.svg" alt="search" class="close-search" >
							<span>Close Search</span>
						</a>
						<div class="hide-on-searchopen">
							<a href="<?php echo get_site_url(  ); ?>/wish-lists" class="open-wish-list"><img src="<?php echo get_template_directory_uri(  ); ?>/images/heart.svg" alt="heart" class="heart"></a>
	
							<a href="<?php echo get_site_url(); ?>/login/" class="account-link"><span class="word">My Account</span></a>
						</div>						
						
						


						
						<a href="<?php echo get_site_url(); ?>/cart" class="cart-icon">
							<span class="bigcommerce-cart__item-count" data-js="bc-cart-item-count"></span>
						</a>
							
							
					</nav>				

				</header>		
			</div>
		</div>
		
		<div class="search-form-wrap mobile-search-form-wrap">
			<form class="search-form" method="get" action="<?php echo get_site_url(  ); ?>">
				<input type="search" class="searchfield" placeholder="Search" name="s" autocomplete="off" />
				<button class="search-btn"><img src="<?php echo get_template_directory_uri(  ); ?>/images/search.svg" alt="search" class="search"></button>
			</form>
		</div>
		
		<div class="search-results-box" id="search-results-box">
		</div>



		<?php if(is_page( 'home' ) || is_page( 'register' )){ ?>
		<?php } else {?>
			<?php include (TEMPLATEPATH . '/topbanner.php' ); ?>
			<?php 
				$currentID = get_the_ID();
				
				if($pageParent != 0){ ?>
				
	
				<div class="generic-page-menu">
					<ul class="">
						<?php
							$args = array(
								'post_parent' => $pageParent,
								'posts_per_page' => 6,
								'post_type' => 'page'
							);
						
							$custom_posts = new WP_Query($args);
						
							if($custom_posts->have_posts()) : 
								while($custom_posts->have_posts()) : 
									$custom_posts->the_post();
						?>
		
							<li class=""><a href="<?php the_permalink(  ); ?>" class="<?php if(get_the_ID() == $currentID) { echo 'open'; }?>"><?php the_title( ); ?></a></li>
						      
						<?php
							endwhile;
							else: 
						?>
						<?php endif; ?>
						<?php wp_reset_query(); ?>
					</ul>			
				</div>		
				
	
				
			<?php } ?>
		<?php } ?>


