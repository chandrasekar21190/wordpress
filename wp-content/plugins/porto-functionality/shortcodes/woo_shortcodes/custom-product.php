<?php
/**
 * Add shortcodes for single product page
 *
 * @author   Porto Themes
 * @category Library
 * @since    5.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PortoCustomProduct {

	protected $shortcodes = array(
		'image',
		'title',
		'rating',
		'actions',
		'price',
		'excerpt',
		'description',
		'add_to_cart',
		'meta',
		'tabs',
		'upsell',
		'related',
		'next_prev_nav',
	);

	protected $display_product_page_elements = false;

	protected $edit_post = null;

	protected $edit_product = null;

	protected $is_product = false;

	public function __construct() {
		$this->init();
	}

	protected function init() {
		remove_action( 'porto_after_content_bottom', 'porto_woocommerce_output_related_products', 10 );

		if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
			add_filter( 'body_class', array( $this, 'filter_body_class' ) );
			add_filter( 'porto_is_product', array( $this, 'filter_is_product' ) );
		}

		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( 'porto_single_product_' . $shortcode, array( $this, 'shortcode_single_product_' . $shortcode ) );
		}

		if ( is_admin() || ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) ) {
			add_action( 'vc_after_init', array( $this, 'load_custom_product_shortcodes' ) );
		}

		if ( is_admin() ) {
			add_action( 'save_post', array( $this, 'add_shortcodes_css' ), 99, 2 );
		}
	}

	public function filter_body_class( $classes ) {
		global $post;
		if ( $post && 'product_layout' == $post->post_type ) {
			$classes[] = 'single-product';
		}
		return $classes;
	}

	public function filter_is_product( $is_product ) {
		if ( $this->is_product ) {
			return true;
		}
		$post_id = (int) vc_get_param( 'vc_post_id' );
		if ( $post_id ) {
			$post = get_post( $post_id );
			if ( $post && 'product_layout' == $post->post_type ) {
				$this->is_product = true;
				return true;
			}
		}
		return $is_product;
	}

	private function restore_global_product_variable() {
		if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
			global $post, $porto_settings;
			if ( ! $this->edit_product && $post && 'product_layout' == $post->post_type/* && isset( $porto_settings['product-single-content-builder'] ) && $porto_settings['product-single-content-builder']*/ ) {
				$query = new WP_Query( array (
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'posts_per_page'      => 1,
					'numberposts'         => 1,
					'ignore_sticky_posts' => true,
				) );
				if ( $query->have_posts() ) {
					$the_post           = $query->next_post();
					$this->edit_post    = $the_post;
					$this->edit_product = wc_get_product( $the_post );
				}
			}
			if ( $this->edit_product ) {
				global $post, $product;
				$post = $this->edit_post;
				setup_postdata( $this->edit_post );
				$product = $this->edit_product;
				return true;
			}
		}
		return false;
	}

	private function reset_global_product_variable() {
		if ( $this->edit_product ) {
			wp_reset_postdata();
		}
	}

	public function shortcode_single_product_image( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		extract( shortcode_atts( array(
			'style' => '',
		), $atts ) );

		if ( 'transparent' == $style ) {
			wp_enqueue_script( 'jquery-slick' );
		}
		ob_start();
		echo '<div class="product-layout-image' . ( $style ? ' product-layout-' . esc_attr( $style ) : '' ) . '">';
			echo '<div class="summary-before">';
				woocommerce_show_product_sale_flash();
			echo '</div>';
		if ( $style ) {
			global $porto_product_layout;
			$porto_product_layout = $style;
		}
		wc_get_template_part( 'single-product/product-image' );
		echo '</div>';
		if ( $style ) {
			$porto_product_layout = 'builder';
		}

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_title( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		extract( shortcode_atts( array(
			'font_size'   => '',
			'font_weight' => '',
			'color'       => '',
			'el_class'    => '',
		), $atts ) );

		global $porto_settings;

		$result  = '<h2 class="product_title entry-title' . ( ! $porto_settings['product-nav'] ? '' : ' show-product-nav' ) . ( $el_class ? ' ' . esc_attr( trim( $el_class ) ) : '' ) . '">';
		$result .= esc_html( get_the_title() );
		$result .= '</h2>';

		$this->reset_global_product_variable();

		return $result;
	}

	public function shortcode_single_product_rating( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		ob_start();
		woocommerce_template_single_rating();

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_actions( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		extract( shortcode_atts( array(
			'action' => 'woocommerce_single_product_summary',
		), $atts ) );

		ob_start();
		do_action( $action );

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_price( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}
		if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' ) ) {
			return null;
		}

		ob_start();
		if ( ! empty( $atts ) ) {
			echo '<div class="single-product-price">';
		}
		woocommerce_template_single_price();
		if ( ! empty( $atts ) ) {
			echo '</div>';
		}

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_excerpt( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		ob_start();
		woocommerce_template_single_excerpt();

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_description( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		ob_start();
		the_content();

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_add_to_cart( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		ob_start();
		echo '<div class="product-summary-wrap">';
		woocommerce_template_single_add_to_cart();

		if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
			echo '<script>theme.WooQtyField.initialize();</script>';
		}
		echo '</div>';

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_meta( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		ob_start();
		woocommerce_template_single_meta();

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_tabs( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		extract( shortcode_atts( array(
			'style' => '', // tabs or accordion
		), $atts ) );

		ob_start();
		if ( 'vertical' == $style ) {
			echo '<style>.woocommerce-tabs .resp-tabs-list { display: none; }
.woocommerce-tabs h2.resp-accordion { display: block; }
.woocommerce-tabs h2.resp-accordion:before { font-size: 20px; font-weight: 400; position: relative; top: -4px; }
.woocommerce-tabs .tab-content { border-top: none; padding-' . ( is_rtl() ? 'right' : 'left' ) . ': 20px; }</style>';
		}
		wc_get_template_part( 'single-product/tabs/tabs' );

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_upsell( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		global $product, $porto_settings;
		if ( ! $porto_settings['product-upsells'] ) {
			return;
		}
		$upsells = $product->get_upsell_ids();
		if ( sizeof( $upsells ) === 0 ) {
			return;
		}
		if ( in_array( $product->get_id(), $upsells ) ) {
			$upsells = array_diff( $upsells, array( $product->get_id() ) );
		}

		if ( ! empty( $atts['columns'] ) ) {
			$columns = $atts['columns'];
		} else {
			$columns = isset( $porto_settings['product-upsells-cols'] ) ? $porto_settings['product-upsells-cols'] : $porto_settings['product-cols'];
		}
		if ( ! $columns ) {
			$columns = 4;
		}
		$args = array(
			'posts_per_page' => empty( $atts['count'] ) ? $porto_settings['product-upsells-count'] : $atts['count'],
			'columns'        => $columns,
			'orderby'        => empty( $atts['orderby'] ) ? 'rand' : $atts['orderby'], // @codingStandardsIgnoreLine.
		);

		$args     = apply_filters( 'porto_woocommerce_upsell_display_args', $args );
		$str_atts = 'ids="' . esc_attr( implode( ',', $upsells ) ) . '" count="' . intval( $args['posts_per_page'] ) . '" columns="' . intval( $args['columns'] ) . '" orderby="' . esc_attr( $args['orderby'] ) . '" pagination="1" navigation="" dots_pos="show-dots-title-right"';
		if ( is_array( $atts ) ) {
			foreach ( $atts as $key => $val ) {
				if ( in_array( $key, array( 'count', 'columns', 'orderby' ) ) ) {
					continue;
				}
				$str_atts .= ' ' . esc_html( $key ) . '="' . esc_attr( $val ) . '"';
			}
		}
		if ( empty( $atts['view'] ) ) {
			$str_atts .= ' view="products-slider"';
		}

		ob_start();

		echo '<div class="upsells products">';
		echo '<h2 class="slider-title"><span class="inline-title">' . esc_html__( 'You may also like&hellip;', 'woocommerce' ) . '</span><span class="line"></span></h2>';
		echo do_shortcode( '[porto_products ' . $str_atts . ']' );
		echo '</div>';

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_related( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}
		global $product, $porto_settings;
		$related = wc_get_related_products( $product->get_id(), $porto_settings['product-related-count'] );
		if ( sizeof( $related ) === 0 || ! $porto_settings['product-related'] ) {
			return;
		}
		if ( in_array( $product->get_id(), $related ) ) {
			$related = array_diff( $related, array( $product->get_id() ) );
		}

		if ( ! empty( $atts['columns'] ) ) {
			$columns = $atts['columns'];
		} else {
			$columns = isset( $porto_settings['product-related-cols'] ) ? $porto_settings['product-related-cols'] : $porto_settings['product-cols'];
		}
		if ( ! $columns ) {
			$columns = 4;
		}
		$args = array(
			'posts_per_page' => empty( $atts['count'] ) ? $porto_settings['product-related-count'] : $atts['count'],
			'columns'        => $columns,
			'orderby'        => empty( $atts['orderby'] ) ? 'rand' : $atts['orderby'], // @codingStandardsIgnoreLine.
		);

		$args     = apply_filters( 'woocommerce_related_products_args', $args );
		$str_atts = 'ids="' . esc_attr( implode( ',', $related ) ) . '" count="' . intval( $args['posts_per_page'] ) . '" columns="' . intval( $args['columns'] ) . '" orderby="' . esc_attr( $args['orderby'] ) . '" pagination="1" navigation="" dots_pos="show-dots-title-right"';
		if ( is_array( $atts ) ) {
			foreach ( $atts as $key => $val ) {
				if ( in_array( $key, array( 'count', 'columns', 'orderby' ) ) ) {
					continue;
				}
				$str_atts .= ' ' . esc_html( $key ) . '="' . esc_attr( $val ) . '"';
			}
		}
		if ( empty( $atts['view'] ) ) {
			$str_atts .= ' view="products-slider"';
		}

		ob_start();

		echo '<div class="related products">';
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );
		if ( $heading ) {
			echo '<h2 class="slider-title">' . esc_html( $heading ) . '</h2>';
		}
		echo do_shortcode( '[porto_products ' . $str_atts . ']' );
		echo '</div>';

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	public function shortcode_single_product_next_prev_nav( $atts ) {
		if ( ! is_product() && ! $this->restore_global_product_variable() ) {
			return null;
		}

		ob_start();
		porto_woocommerce_product_nav();

		$this->reset_global_product_variable();

		return ob_get_clean();
	}

	function load_custom_product_shortcodes() {
		if ( ! $this->display_product_page_elements ) {
			if ( 'post-new.php' == $GLOBALS['pagenow'] && isset( $_GET['post_type'] ) && 'product_layout' == $_GET['post_type'] ) {
				$this->display_product_page_elements = true;
			} elseif ( 'post.php' == $GLOBALS['pagenow'] && isset( $_GET['post'] ) ) {
				$post = get_post( intval( $_GET['post'] ) );
				if ( is_object( $post ) && 'product_layout' == $post->post_type ) {
					$this->display_product_page_elements = true;
				}
			} elseif ( porto_is_ajax() && isset( $_REQUEST['post_id'] ) ) {
				$post = get_post( intval( $_REQUEST['post_id'] ) );
				if ( is_object( $post ) && ( 'product_layout' == $post->post_type || 'product' == $post->post_type ) ) {
					$this->display_product_page_elements = true;
				}
			} elseif ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
				if ( is_admin() && isset( $_GET['post_type'] ) && 'product_layout' == $_GET['post_type'] ) {
					$this->display_product_page_elements = true;
				} elseif ( ! is_admin() ) {
					$post_id = (int) vc_get_param( 'vc_post_id' );
					if ( $post_id ) {
						$post = get_post( $post_id );
						if ( is_object( $post ) && 'product_layout' == $post->post_type ) {
							$this->display_product_page_elements = true;
						}
					}
				}
			}
		}

		if ( ! $this->display_product_page_elements ) {
			return;
		}

		$order_by_values  = porto_vc_woo_order_by();
		$order_way_values = porto_vc_woo_order_way();
		$custom_class     = porto_vc_custom_class();
		$products_args    = array(
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'View mode', 'porto-functionality' ),
				'param_name'  => 'view',
				'value'       => porto_sh_commons( 'products_view_mode' ),
				'std'         => 'products-slider',
				'admin_label' => true,
			),
			array(
				'type'       => 'porto_image_select',
				'heading'    => __( 'Grid Layout', 'porto-functionality' ),
				'param_name' => 'grid_layout',
				'dependency' => array(
					'element' => 'view',
					'value'   => array( 'creative' ),
				),
				'std'        => '1',
				'value'      => porto_sh_commons( 'masonry_layouts' ),
			),
			array(
				'type'       => 'number',
				'heading'    => __( 'Grid Height (px)', 'porto-functionality' ),
				'param_name' => 'grid_height',
				'dependency' => array(
					'element' => 'view',
					'value'   => array( 'creative' ),
				),
				'suffix'     => 'px',
				'std'        => 600,
			),
			array(
				'type'        => 'number',
				'heading'     => __( 'Column Spacing (px)', 'porto-functionality' ),
				'description' => __( 'Leave blank if you use theme default value.', 'porto-functionality' ),
				'param_name'  => 'spacing',
				'dependency'  => array(
					'element' => 'view',
					'value'   => array( 'grid', 'creative', 'products-slider' ),
				),
				'suffix'      => 'px',
				'std'         => '',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Columns', 'porto-functionality' ),
				'param_name' => 'columns',
				'dependency' => array(
					'element' => 'view',
					'value'   => array( 'products-slider', 'grid', 'divider' ),
				),
				'std'        => '4',
				'value'      => porto_sh_commons( 'products_columns' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Columns on mobile ( <= 575px )', 'porto-functionality' ),
				'param_name' => 'columns_mobile',
				'dependency' => array(
					'element' => 'view',
					'value'   => array( 'products-slider', 'grid', 'divider', 'list' ),
				),
				'std'        => '',
				'value'      => array(
					__( 'Default', 'porto-functionality' ) => '',
					'1'                                    => '1',
					'2'                                    => '2',
					'3'                                    => '3',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Pagination Style', 'porto-functionality' ),
				'param_name' => 'pagination_style',
				'dependency' => array(
					'element' => 'view',
					'value'   => array( 'list', 'grid', 'divider' ),
				),
				'std'        => '',
				'value'      => array(
					__( 'No pagination', 'porto-functionality' ) => '',
					__( 'Default' )   => 'default',
					__( 'Load more' ) => 'load_more',
				),
			),
			array(
				'type'        => 'number',
				'heading'     => __( 'Number of Products per page', 'porto-functionality' ),
				'description' => __( 'Leave blank if you use default value.', 'porto-functionality' ),
				'param_name'  => 'count',
				'admin_label' => true,
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Order by', 'js_composer' ),
				'param_name'  => 'orderby',
				'value'       => $order_by_values,
				/* translators: %s: Wordpress codex page */
				'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Order way', 'js_composer' ),
				'param_name'  => 'order',
				'value'       => $order_way_values,
				/* translators: %s: Wordpress codex page */
				'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Product Layout', 'porto-functionality' ),
				'description' => __( 'Select position of add to cart, add to wishlist, quickview.', 'porto-functionality' ),
				'param_name'  => 'addlinks_pos',
				'value'       => porto_sh_commons( 'products_addlinks_pos' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Use simple layout?', 'porto-functionality' ),
				'description' => __( 'If you check this option, it will display product title and price only.', 'porto-functionality' ),
				'param_name'  => 'use_simple',
				'std'         => 'no',
			),
			array(
				'type'       => 'number',
				'heading'    => __( 'Overlay Background Opacity (%)', 'porto-functionality' ),
				'param_name' => 'overlay_bg_opacity',
				'dependency' => array(
					'element' => 'addlinks_pos',
					'value'   => array( 'onimage2', 'onimage3' ),
				),
				'suffix'     => '%',
				'std'        => '30',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Image Size', 'porto-functionality' ),
				'param_name' => 'image_size',
				'dependency' => array(
					'element' => 'view',
					'value'   => array( 'products-slider', 'grid', 'divider', 'list' ),
				),
				'value'      => porto_sh_commons( 'image_sizes' ),
				'std'        => '',
			),
		);

		vc_map(
			array(
				'name'     => __( 'Product Image', 'porto-functionality' ),
				'base'     => 'porto_single_product_image',
				'icon'     => 'porto_vc_woocommerce',
				'category' => __( 'Product Page', 'porto-functionality' ),
				'params'   => array(
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Style', 'porto-functionality' ),
						'param_name'  => 'style',
						'value'       => array(
							__( 'Default', 'porto-functionality' ) => '',
							__( 'Extended', 'porto-functionality' ) => 'extended',
							__( 'Grid Images', 'porto-functionality' ) => 'grid',
							__( 'Thumbs on Image', 'porto-functionality' ) => 'full_width',
							__( 'List Images', 'porto-functionality' ) => 'sticky_info',
							__( 'Left Thumbs 1', 'porto-functionality' ) => 'transparent',
							__( 'Left Thumbs 2', 'porto-functionality' ) => 'centered_vertical_zoom',
						),
						'admin_label' => true,
					),
				),
			)
		);
		vc_map(
			array(
				'name'     => __( 'Product Title', 'porto-functionality' ),
				'base'     => 'porto_single_product_title',
				'icon'     => 'porto_vc_woocommerce',
				'category' => __( 'Product Page', 'porto-functionality' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => __( 'Font Size', 'porto-functionality' ),
						'param_name'  => 'font_size',
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Font Weight', 'porto-functionality' ),
						'param_name'  => 'font_weight',
						'value'       => array(
							__( 'Default', 'porto-functionality' ) => '',
							'100' => '100',
							'200' => '200',
							'300' => '300',
							'400' => '400',
							'500' => '500',
							'600' => '600',
							'700' => '700',
							'800' => '800',
							'900' => '900',
						),
						'admin_label' => true,
					),
					array(
						'type'       => 'colorpicker',
						'class'      => '',
						'heading'    => __( 'Color', 'porto-functionality' ),
						'param_name' => 'color',
						'value'      => '',
					),
					$custom_class,
				),
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Product Description', 'porto-functionality' ),
				'base'                    => 'porto_single_product_description',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Product Rating', 'porto-functionality' ),
				'base'                    => 'porto_single_product_rating',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
			)
		);
		vc_map(
			array(
				'name'     => __( 'Product Hooks', 'porto-functionality' ),
				'base'     => 'porto_single_product_actions',
				'icon'     => 'porto_vc_woocommerce',
				'category' => __( 'Product Page', 'porto-functionality' ),
				'params'   => array(
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'action', 'porto-functionality' ),
						'param_name'  => 'style',
						'value'       => array(
							'woocommerce_before_single_product_summary'       => 'woocommerce_before_single_product_summary',
							'woocommerce_single_product_summary'              => 'woocommerce_single_product_summary',
							'woocommerce_after_single_product_summary'        => 'woocommerce_after_single_product_summary',
							'porto_woocommerce_before_single_product_summary' => 'porto_woocommerce_before_single_product_summary',
							'porto_woocommerce_single_product_summary2'       => 'porto_woocommerce_single_product_summary2',
						),
						'admin_label' => true,
					),
				),
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Product Price', 'porto-functionality' ),
				'base'                    => 'porto_single_product_price',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
				'params'                  => array(
					array(
						'type'        => 'textfield',
						'heading'     => __( 'Font Size', 'porto-functionality' ),
						'param_name'  => 'font_size',
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Font Weight', 'porto-functionality' ),
						'param_name'  => 'font_weight',
						'value'       => array(
							__( 'Default', 'porto-functionality' ) => '',
							'100' => '100',
							'200' => '200',
							'300' => '300',
							'400' => '400',
							'500' => '500',
							'600' => '600',
							'700' => '700',
							'800' => '800',
							'900' => '900',
						),
						'admin_label' => true,
					),
					array(
						'type'       => 'colorpicker',
						'class'      => '',
						'heading'    => __( 'Color', 'porto-functionality' ),
						'param_name' => 'color',
						'value'      => '',
					),
				)
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Product Excerpt', 'porto-functionality' ),
				'base'                    => 'porto_single_product_excerpt',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Product Add To Cart', 'porto-functionality' ),
				'base'                    => 'porto_single_product_add_to_cart',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Product Meta', 'porto-functionality' ),
				'base'                    => 'porto_single_product_meta',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
			)
		);
		vc_map(
			array(
				'name'     => __( 'Product Tabs', 'porto-functionality' ),
				'base'     => 'porto_single_product_tabs',
				'icon'     => 'porto_vc_woocommerce',
				'category' => __( 'Product Page', 'porto-functionality' ),
				'params'   => array(
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Style', 'porto-functionality' ),
						'param_name'  => 'style',
						'value'       => array(
							__( 'Default', 'porto-functionality' ) => '',
							__( 'Vetical', 'porto-functionality' ) => 'vertical',
						),
						'admin_label' => true,
					),
				),
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Upsells', 'porto-functionality' ),
				'base'                    => 'porto_single_product_upsell',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
				'params'                  => $products_args,
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Related Products', 'porto-functionality' ),
				'base'                    => 'porto_single_product_related',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
				'params'                  => $products_args,
			)
		);
		vc_map(
			array(
				'name'                    => __( 'Prev and Next Navigation', 'porto-functionality' ),
				'base'                    => 'porto_single_product_next_prev_nav',
				'icon'                    => 'porto_vc_woocommerce',
				'category'                => __( 'Product Page', 'porto-functionality' ),
				'show_settings_on_create' => false,
			)
		);
	}

	public function add_shortcodes_css( $post_id, $post ) {
		if ( ! $post || ! isset( $post->post_type ) || 'product_layout' != $post->post_type || ! $post->post_content ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) ) {
			return;
		}

		$css = '';
		preg_match_all( '/' . get_shortcode_regex() . '/', $post->post_content, $shortcodes );
		foreach ( $shortcodes[2] as $index => $tag ) {
			if ( ! in_array( $tag, array( 'porto_single_product_title', 'porto_single_product_price' ) ) ) {
				continue;
			}

			$attr_array    = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
			$shortcode_css = '';
			if ( 'porto_single_product_title' == $tag || 'porto_single_product_price' == $tag ) {
				if ( ! empty( $attr_array['font_size'] ) ) {
					$unit = trim( preg_replace( '/[0-9.]/', '', $attr_array['font_size'] ) );
					if ( ! $unit ) {
						$attr_array['font_size'] .= 'px';
					}
					$shortcode_css .= 'font-size:' . esc_html( $attr_array['font_size'] ) . ';';
				}
				if ( ! empty( $attr_array['font_weight'] ) ) {
					$shortcode_css .= 'font-weight:' . esc_html( $attr_array['font_weight'] ) . ';';
				}
				if ( ! empty( $attr_array['color'] ) ) {
					$shortcode_css .= 'color:' . esc_html( $attr_array['color'] ) . ';';
				}
				if ( $shortcode_css ) {
					if ( 'porto_single_product_title' == $tag ) {
						$css .= '.single-product .product_title{' . $shortcode_css . '}';
					} else {
						$css .= '.single-product-price .price{' . $shortcode_css . '}';
					}
				}
			}
		}
		update_post_meta( $post_id, 'porto_product_layout_css', $css );
	}
}

new PortoCustomProduct();
