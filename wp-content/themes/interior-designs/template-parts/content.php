<?php
/**
 * The template part for displaying single-post
 *
 * @package Interior Designs
 * @subpackage interior_designs
 * @since Interior Designs 1.0
 */
?>
<?php 
  $archive_year  = get_the_time('Y'); 
  $archive_month = get_the_time('m'); 
  $archive_day   = get_the_time('d'); 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="services-box">
    <div class="upper-box">
      <h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
      <?php if( get_theme_mod( 'interior_designs_date_hide',true) != '') { ?>
        <span class="entry-date"><i class="far fa-calendar-alt"></i><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date() ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a></span>
      <?php } ?>
    </div>      
    <div class="service-image">
      <a href="<?php echo esc_url( get_permalink() ); ?>"><?php 
        if(has_post_thumbnail()) { 
          the_post_thumbnail(); 
        }
      ?><span class="screen-reader-text"><?php the_title(); ?></span></a>
      <div class="middle">
        <div class="text"><i class="fas fa-th-large"></i></div>
      </div>
    </div>
    <div class="lower-box">
      <?php if(get_theme_mod( 'interior_designs_comment_hide',true) != '' || get_theme_mod( 'interior_designs_author_hide',true) != '') { ?>
        <div class="metabox">
          <?php if( get_theme_mod( 'interior_designs_author_hide',true) != '') { ?>
            <span class="entry-author"><i class="fas fa-user"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?><span class="screen-reader-text"><?php the_author(); ?></span></a></span>
          <?php } ?>

          <?php if( get_theme_mod( 'interior_designs_comment_hide',true) != '') { ?>
            <span class="entry-comments"><i class="fa fa-comments" aria-hidden="true"></i><?php comments_number( __('0 Comment', 'interior-designs'), __('0 Comments', 'interior-designs'), __('% Comments', 'interior-designs') ); ?> </span>
          <?php } ?>
        </div>
      <?php } ?>
      <div class="entry-content"><p><?php the_excerpt();?></p></div>
      <div class="service-btn">
        <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Read More','interior-designs'); ?>"><?php esc_html_e('Read More','interior-designs'); ?><span class="screen-reader-text"><?php esc_html_e( 'Read More','interior-designs' );?></span></a>
      </div>
    </div>
  </div>
</article>