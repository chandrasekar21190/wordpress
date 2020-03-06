<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content-ma">
 *
 * @package Interior Designs
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <link rel="profile" href="<?php echo esc_url( __( 'http://gmpg.org/xfn/11', 'interior-designs' ) ); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> class="main-bodybox">
	<?php wp_body_open(); ?>
	
	<header role="banner" class="full-header">
		<a class="screen-reader-text skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'interior-designs' ); ?></a>
		<?php if( get_theme_mod('interior_designs_topbar_hide',true) != ''){ ?>
		  	<div class="top-header">
			  	<div class="container">
			    	<div class="row">
			      		<div class="col-lg-7 col-md-7">
			        		<div class="site-text">
			          			<?php if( get_theme_mod( 'interior_designs_text','' ) != '') { ?>
			            			<span class="phone"><?php echo esc_html( get_theme_mod('interior_designs_text','' )); ?></span>
			           			<?php } ?>
			        		</div>
			      		</div>
			      		<div class="col-lg-5 col-md-5">
			        		<div class="social-media">
			          			<?php if( get_theme_mod( 'interior_designs_facebook_url' ) != '') { ?>
			            			<a href="<?php echo esc_url( get_theme_mod( 'interior_designs_facebook_url','' ) ); ?>"><i class="fab fa-facebook-f"></i>
										<span class="screen-reader-text"><?php esc_attr_e( 'Facebook','interior-designs' );?></span>
									</a>
			          			<?php } ?>
			          			<?php if( get_theme_mod( 'interior_designs_twitter_url') != '') { ?>
			            			<a href="<?php echo esc_url( get_theme_mod( 'interior_designs_twitter_url','' ) ); ?>"><i class="fab fa-twitter"></i>
										<span class="screen-reader-text"><?php esc_attr_e( 'Twitter','interior-designs' );?></span>
									</a>
			          			<?php } ?>
			          			<?php if( get_theme_mod( 'interior_designs_google_url' ) != '') { ?>
			            			<a href="<?php echo esc_url( get_theme_mod( 'interior_designs_google_url','' ) ); ?>"><i class="fab fa-google-plus-g"></i>
										<span class="screen-reader-text"><?php esc_attr_e( 'Google Plus','interior-designs' );?></span>
									</a>
			          			<?php } ?>
			          			<?php if( get_theme_mod( 'interior_designs_insta_url' ) != '') { ?>
			            			<a href="<?php echo esc_url( get_theme_mod( 'interior_designs_insta_url','' ) ); ?>"><i class="fab fa-instagram"></i>
										<span class="screen-reader-text"><?php esc_attr_e( 'Instagram','interior-designs' );?></span>
									</a>
			          			<?php } ?>
			          			<?php if( get_theme_mod( 'interior_designs_linkdin_url') != '') { ?>
			            			<a href="<?php echo esc_url( get_theme_mod( 'interior_designs_linkdin_url','' ) ); ?>"><i class="fab fa-linkedin-in"></i>
										<span class="screen-reader-text"><?php esc_attr_e( 'Linkedin','interior-designs' );?></span>
									</a>
			          			<?php } ?>
			          			<?php if( get_theme_mod( 'interior_designs_youtube_url' ) != '') { ?>
			            			<a href="<?php echo esc_url( get_theme_mod( 'interior_designs_youtube_url','' ) ); ?>"><i class="fab fa-youtube"></i>
										<span class="screen-reader-text"><?php esc_attr_e( 'Youtube','interior-designs' );?></span>
									</a>
			          			<?php } ?>
			        		</div>
			      		</div>
			      		<div class="clearfix"></div>
			    	</div>
			  	</div>
			</div>
		<?php }?>
	  	<div class="site_header">
		  	<div class="container">
		  		<div class="row">
				    <div class="col-lg-4 col-md-4">
				    	<div class="logo">
							<?php if ( has_custom_logo() ) : ?>
								<div class="site-logo"><?php the_custom_logo(); ?></div>
							<?php else: ?>
								<?php $blog_info = get_bloginfo( 'name' ); ?>
								<?php if ( ! empty( $blog_info ) ) : ?>
									<?php if ( is_front_page() && is_home() ) : ?>
										<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php else : ?>
										<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php endif; ?>
								<?php endif; ?>
								<?php
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) :
								?>
									<p class="site-description">
									<?php echo esc_html($description); ?>
									</p>
								<?php endif; ?>
							<?php endif; ?>
					    </div>
				    </div>
				    <div class="col-lg-8 col-md-8 row">
				        <div class="call col-lg-4 col-md-4">
				          	<?php if( get_theme_mod( 'interior_designs_call','' ) != '') { ?>
				          		<div class="row">
					            	<div class="col-lg-2 col-md-2 col-4 pl-0"><i class="fas fa-phone"></i></div>
				            		<div class="col-lg-10 col-md-10 col-8 ">
					             		<p class="infotext"><?php echo esc_html( get_theme_mod('interior_designs_call_text','') ); ?></p>
					              		<p><?php echo esc_html( get_theme_mod('interior_designs_call','') ); ?></p>
					            	</div>
					            </div>
				          	<?php } ?>
				        </div>
				        <div class="location col-lg-4 col-md-4 ">
				         	<?php if( get_theme_mod( 'interior_designs_location','' ) != '') { ?>
				         		<div class="row">
						            <div class="col-lg-2 col-md-2 col-4 pl-0"><i class="fas fa-location-arrow"></i></div>
						            <div class="col-lg-10 col-md-10 col-8">
						              	<p class="infotext"><?php echo esc_html( get_theme_mod('interior_designs_location_text','') ); ?></p>
						              	<p><?php echo esc_html( get_theme_mod('interior_designs_location','') ); ?></p>
						            </div>
						        </div>
				          	<?php } ?>
				        </div>
				        <div class="time col-lg-4 col-md-4">
				         	<?php if( get_theme_mod( 'interior_designs_day','' ) != '') { ?>
				         		<div class="row">
						            <div class="col-lg-2 col-md-2 col-4 pl-0"><i class="far fa-clock"></i></div>
						            <div class="col-lg-10 col-md-10 col-8 ">
						              	<p class="infotext"><?php echo esc_html( get_theme_mod('interior_designs_time','') ); ?></p>
						              	<p><?php echo esc_html( get_theme_mod('interior_designs_day','') ); ?></p>
						            </div>
						        </div>
				          	<?php } ?>
				        </div>
			      	</div>
				</div>
		    </div>		
		</div>	
		<div class="<?php if( get_theme_mod( 'interior_designs_sticky_header') != '') { ?> sticky-header"<?php } else { ?>close-sticky <?php } ?>">
			<div class="container">
				<div id="header" class="row">
					<div class="menubox nav  col-lg-11 col-md-11 col-6">
					    <div class="toggle-menu responsive-menu">
			              <button role="tab" onclick="resMenu_open()"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Menu','interior-designs'); ?></span></button>
			            </div>
			            <div id="menu-sidebar" class="nav sidebar">
			             <nav id="primary-site-navigation" class="primary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'interior-designs' ); ?>">
			                <a href="javascript:void(0)" class="closebtn responsive-menu" onclick="resMenu_close()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Menu','interior-designs'); ?></span></a>
			                <?php 
			                  wp_nav_menu( array( 
			                    'theme_location' => 'primary',
			                    'container_class' => 'main-menu-navigation clearfix' ,
			                    'menu_class' => 'clearfix',
			                    'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
			                    'fallback_cb' => 'wp_page_menu',
			                  ) ); 
			                ?>
			             </nav>
			            </div>
						<div class="clear"></div>
					</div>
					<div class="search-box col-lg-1 col-md-1 col-6">
				       <span class="search-icon"><a href="#" onclick="search_open()"><i class="fas fa-search"></i><span class="screen-reader-text"><?php the_title(); ?></span></a></span>
				    </div>
					<div class="serach_outer">
			          <div class="closepop"><a href="#" onclick="search_close()"><i class="far fa-window-close"></i><span class="screen-reader-text"><?php the_title(); ?></span></a></div>
			          <div class="serach_inner">
			            <?php get_search_form(); ?>
			          </div>
			        </div>
				</div>
			</div>
		</div>
	</header>