<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Interior Designs
 */
?>
    <footer role="contentinfo">
        <?php //Set widget areas classes based on user choice
            $widget_areas = get_theme_mod('interior_designs_footer_widget_layout', '4');
            if ($widget_areas == '3') {
                $cols = 'col-lg-4 col-md-4';
            } elseif ($widget_areas == '4') {
                $cols = 'col-lg-3 col-md-3';
            } elseif ($widget_areas == '2') {
                $cols = 'col-lg-6 col-md-6';
            } else {
                $cols = 'col-lg-12 col-md-12';
            }
        ?>
        <div class="footertown">
            <div class="container">
                <div class="row">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                      <div class="sidebar-column <?php echo esc_attr( $cols ); ?>">
                        <?php dynamic_sidebar( 'footer-1'); ?>
                      </div>
                    <?php endif; ?> 
                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                      <div class="sidebar-column <?php echo esc_attr( $cols ); ?>">
                        <?php dynamic_sidebar( 'footer-2'); ?>
                      </div>
                    <?php endif; ?> 
                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                      <div class="sidebar-column <?php echo esc_attr( $cols ); ?>">
                        <?php dynamic_sidebar( 'footer-3'); ?>
                      </div>
                    <?php endif; ?> 
                    <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                      <div class="sidebar-column <?php echo esc_attr( $cols ); ?>">
                        <?php dynamic_sidebar( 'footer-4'); ?>
                      </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="footer">
        	<div class="container">
                <p><?php echo esc_html(get_theme_mod('interior_designs_footer_copy',__('Copyright 2018','interior-designs'))); ?> <?php interior_designs_credit_link(); ?></p>
            </div>
        </div>

        <?php if( get_theme_mod( 'interior_designs_show_back_to_top',true) != '') { ?>
            <?php $scroll_lay = get_theme_mod( 'interior_designs_back_to_top_alignment','Right');
                if($scroll_lay == 'Left'){ ?>
                   <a href="#" class="scrollup left"><span><?php esc_html_e('Back to Top', 'interior-designs'); ?><i class="fas fa-arrow-right"></i></span><span class="screen-reader-text"><?php esc_html_e('Back to Top', 'interior-designs'); ?></span></a>
                <?php }else if($scroll_lay == 'Center'){ ?>
                  <a href="#" class="scrollup center"><span><?php esc_html_e('Back to Top', 'interior-designs'); ?><i class="fas fa-arrow-right"></i></span><span class="screen-reader-text"><?php esc_html_e('Back to Top', 'interior-designs'); ?></span></a>
                <?php }else{ ?>
                  <a href="#" class="scrollup right"><span><?php esc_html_e('Back to Top', 'interior-designs'); ?><i class="fas fa-arrow-right"></i></span><span class="screen-reader-text"><?php esc_html_e('Back to Top', 'interior-designs'); ?></span></a>
            <?php }?>
        <?php }?>
        <?php wp_footer(); ?>
    </footer>
</body>
</html>