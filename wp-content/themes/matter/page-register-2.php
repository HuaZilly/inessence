<?php get_header(); ?>

	



		<div class="wrapper">
			<div class="row">
				<div class="col-md-12 columns ">
					<h1 class="account-page-title">Sign Up.</h1>
				</div>
			</div>
		</div>


	
		<div class="wrapper background-color-paleslate ">
			<div class="row">
				<article class="col-md-12 columns style-bullets client-entry">
					
						
						
						<div class="bc-account-page " id="registration-part1">
							<section class="bc-account-login">
								<div class="bc-account-login__form">
									<div class="bc-account-login__form-inner">
										<div class="intro">
											<p>Already have an account? <a href="<?php echo get_site_url(); ?>/login">Log in</a></p>
										</div>					
						
														
										<form name="startregsterform" action="" method="post">
											
											<p class="login-username smartplaceholder">
												<label for="part1email">Email Address</label>
												<input type="text" name="log" id="part1email" class="input" value="" size="20" />
											</p>
											<p class="login-password smartplaceholder">
												<label for="part1pass">Password</label>
												<input type="password" name="pwd" id="part1pass" class="input" value="" size="20" />
											</p>
											<br>
											<p class="login-submit">
												<a id="part2btn" class="btn btn-checkout">Sign up</a>
											</p>
											
										</form>				
									</div>
								</div>
							</section>
						</div>
						
						

						<div class="bc-account-pages-restyled full-registration-form-wrap hide" id="registration-part2">
			
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
												
								<?php echo do_shortcode( '[bigcommerce_registration_form]' ); ?>
					
						<?php endwhile; endif; ?>

						</div>
				</article>
			</div>
		</div>



<?php get_footer(); ?>
