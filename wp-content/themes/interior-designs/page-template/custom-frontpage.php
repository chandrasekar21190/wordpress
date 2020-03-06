<?php
/**
 * The template for displaying home page.
 *
 * Template Name: Custom Home Page
 *
 * @package Interior Designs
 */
get_header(); ?>

<main id="main" role="main">
  <?php if( get_theme_mod('interior_designs_slider_arrows') != ''){ ?>
  <section id="slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"> 
      <?php $slider_pages = array();
        for ( $count = 1; $count <= 4; $count++ ) {
          $mod = intval( get_theme_mod( 'interior_designs_slider_page' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $slider_pages[] = $mod;
          }
        }
        if( !empty($slider_pages) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $slider_pages,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $i = 1;
      ?>     
      <div class="carousel-inner" role="listbox">
        <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
          <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a>
          </div>
        <?php $i++; endwhile; 
        wp_reset_postdata();?>
      </div>
      <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
      endif;?>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"><?php esc_html_e('Previous','interior-designs'); ?></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Previous','interior-designs' );?></span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"><?php esc_html_e('Next','interior-designs'); ?></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Next','interior-designs' );?></span>
      </a>
    </div>
    <div class="clearfix"></div>
  </section> 

  <?php do_action( 'interior_designs_after_slider' ); ?>

  <section id="discover">
  	<div class="container">
    	<div class="row">
  	    <?php
  	      $args = array( 'name' => get_theme_mod('interior_designs_discover_post',''));
  	      $query = new WP_Query( $args );
  	      if ( $query->have_posts() ) :
  	        while ( $query->have_posts() ) : $query->the_post(); ?>
  	    		<div class="col-md-8 col-lg-8">
              <h1><?php the_title(); ?></h1>
              <p><?php $excerpt = get_the_excerpt(); echo esc_html( interior_designs_string_limit_words( $excerpt,15 ) ); ?></p>
  		      </div>
            <div class ="disc-btn col-md-4 col-lg-4">
              <a href="<?php the_permalink(); ?>"><?php echo esc_html_e('Discover More','interior-designs') ?><span class="screen-reader-text"><?php esc_html_e( 'Discover More','interior-designs' );?></span></a>
            </div>
  	        <?php endwhile; 
  	        wp_reset_postdata();?>
  	        <?php else : ?>
  	          <div class="no-postfound"></div>
  	        <?php
  	    endif; ?>
  		</div>
  	</div>
  </section>
  <?php }?>

  <?php do_action( 'interior_designs_after_service' ); ?>

  <?php if( get_theme_mod( 'interior_designs_services_category','' ) != '') { ?>

  <section id="services">
  	<div class="container">
  		<?php if( get_theme_mod('interior_designs_service_title') != ''){ ?>     
      <h2><?php echo esc_html(get_theme_mod('interior_designs_service_title','')); ?></h2>
      <?php }?>
      <?php if( get_theme_mod('interior_designs_service_tag_line') != ''){ ?>     
        <p><?php echo esc_html(get_theme_mod('interior_designs_service_tag_line','')); ?></p>
      <?php }?>
      <div class="row">
        <?php 
         	$page_query = new WP_Query(array( 'category_name' => esc_html(get_theme_mod('interior_designs_services_category'),'theblog')));?>
        	<?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
      		<div class="col-md-3 col-lg-3">
            <?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h3>
          </div>
        	<?php endwhile;
        	wp_reset_postdata();
        ?>
      </div>
  	</div>
  </section>

  <?php }?>

  <?php do_action( 'interior_designs_after_product' ); ?>

  <div id="content-ma">
  	<div class="container">
    	<?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
  	</div>
  </div>
</main>

<?php get_footer(); ?>