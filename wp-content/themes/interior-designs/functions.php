<?php
/**
 * Interior Designs functions and definitions
 *
 * @package Interior Designs
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */

/* Theme Setup */
if ( ! function_exists( 'interior_designs_setup' ) ) :

function interior_designs_setup() {

	$GLOBALS['content_width'] = apply_filters( 'interior_designs_content_width', 640 );

	load_theme_textdomain( 'interior-designs', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );
	add_image_size('interior-designs-homepage-thumb',240,145,true);
	
       register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'interior-designs' ),
	) );

	add_theme_support( 'custom-background', array(
		'default-color' => 'f1f1f1'
	) );
	/*
	* Enable support for Post Formats.
	*
	* See: https://codex.wordpress.org/Post_Formats
	*/
	add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

	/* Selective refresh for widgets */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/* Starter Content */
	add_theme_support( 'starter-content', array(
		'widgets' => array(
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),
			'sidebar-2' => array(
				'text_business_info',
			),
			'sidebar-3' => array(
				'text_about',
				'search',
			),
			'footer-1' => array(
				'text_about',
			),
			'footer-2' => array(
				'archives',
			),
			'footer-3' => array(
				'text_business_info',
			),
			'footer-4' => array(
				'search',
			),
		),

		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
		),

		'theme_mods' => array(
			'interior_designs_text' => __('Welcome to Interior Designs.', 'interior-designs' ),
			'interior_designs_call_text' => __('987456321', 'interior-designs' ),
			'interior_designs_call' => __('example@gmail.com', 'interior-designs' ),
			'interior_designs_location_text' => __('Location', 'interior-designs' ),
			'interior_designs_location' => __('Your City, Country', 'interior-designs' ),
			'interior_designs_time' => __('8:00am - 5:00pm', 'interior-designs' ),
			'interior_designs_day' => __('Mon to Fri', 'interior-designs' ),
			'interior_designs_facebook_url' => 'www.facebook.com',
			'interior_designs_twitter_url' => 'www.twitter.com',
			'interior_designs_google_url' => 'www.googleplus.com',
			'interior_designs_insta_url' => 'www.instagram.com',
			'interior_designs_linkdin_url' => 'www.linkedin.com',
			'interior_designs_youtube_url' => 'www.youtube.com',
			'interior_designs_footer_copy' => __('Copyright 2018', 'interior-designs' )
		),

		'nav_menus' => array(
			'primary' => array(
				'name' => __( 'Primary Menu', 'interior-designs' ),
				'items' => array(
					'page_home',
					'page_about',
					'page_blog',
					'page_contact',
				),
			),
		),
    ));

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', interior_designs_font_url() ) );

}

endif;
add_action( 'after_setup_theme', 'interior_designs_setup' );

/* Theme Widgets Setup */
function interior_designs_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'interior-designs' ),
		'description'   => __( 'Appears on blog page sidebar', 'interior-designs' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'interior-designs' ),
		'description'   => __( 'Appears on page sidebar', 'interior-designs' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Thid Column Sidebar', 'interior-designs' ),
		'description'   => __( 'Appears on page sidebar', 'interior-designs' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	//Footer widget areas
	$widget_areas = get_theme_mod('interior_designs_footer_widget_layout', '4');
	for ($i=1; $i<=$widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer Nav ', 'interior-designs' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'interior_designs_widgets_init' );

/* Theme Font URL */
function interior_designs_font_url() {
	$font_url = '';
	$font_family = array();
	$font_family[] = 'Montserrat:500,600,700,800,900';
	$font_family[] = 'Ubuntu:300,300i,400,400i,500';
	$font_family[] = 'Kavoon';
	$font_family[] = 'Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600';
	$font_family[] = 'Playfair+Display:400,400i,700,700i,900,900i';
	$font_family[] = 'PT Sans:300,400,600,700,800,900';
	$font_family[] = 'Roboto:400,700';
	$font_family[] = 'Roboto Condensed:400,700';
	$font_family[] = 'Open Sans';
	$font_family[] = 'Overpass';
	$font_family[] = 'Montserrat:300,400,600,700,800,900';
	$font_family[] = 'Playball:300,400,600,700,800,900';
	$font_family[] = 'Alegreya:300,400,600,700,800,900';
	$font_family[] = 'Julius Sans One';
	$font_family[] = 'Arsenal';
	$font_family[] = 'Slabo';
	$font_family[] = 'Lato';
	$font_family[] = 'Overpass Mono';
	$font_family[] = 'Source Sans Pro';
	$font_family[] = 'Raleway';
	$font_family[] = 'Merriweather';
	$font_family[] = 'Droid Sans';
	$font_family[] = 'Rubik';
	$font_family[] = 'Lora';
	$font_family[] = 'Ubuntu';
	$font_family[] = 'Cabin';
	$font_family[] = 'Arimo';
	$font_family[] = 'Playfair Display';
	$font_family[] = 'Quicksand';
	$font_family[] = 'Padauk';
	$font_family[] = 'Muli';
	$font_family[] = 'Inconsolata';
	$font_family[] = 'Bitter';
	$font_family[] = 'Pacifico';
	$font_family[] = 'Indie Flower';
	$font_family[] = 'VT323';
	$font_family[] = 'Dosis';
	$font_family[] = 'Frank Ruhl Libre';
	$font_family[] = 'Fjalla One';
	$font_family[] = 'Oxygen';
	$font_family[] = 'Arvo';
	$font_family[] = 'Noto Serif';
	$font_family[] = 'Lobster';
	$font_family[] = 'Crimson Text';
	$font_family[] = 'Yanone Kaffeesatz';
	$font_family[] = 'Anton';
	$font_family[] = 'Libre Baskerville';
	$font_family[] = 'Bree Serif';
	$font_family[] = 'Gloria Hallelujah';
	$font_family[] = 'Josefin Sans';
	$font_family[] = 'Abril Fatface';
	$font_family[] = 'Varela Round';
	$font_family[] = 'Vampiro One';
	$font_family[] = 'Shadows Into Light';
	$font_family[] = 'Cuprum';
	$font_family[] = 'Rokkitt';
	$font_family[] = 'Vollkorn';
	$font_family[] = 'Francois One';
	$font_family[] = 'Orbitron';
	$font_family[] = 'Patua One';
	$font_family[] = 'Acme';
	$font_family[] = 'Satisfy';
	$font_family[] = 'Josefin Slab';
	$font_family[] = 'Quattrocento Sans';
	$font_family[] = 'Architects Daughter';
	$font_family[] = 'Russo One';
	$font_family[] = 'Monda';
	$font_family[] = 'Righteous';
	$font_family[] = 'Lobster Two';
	$font_family[] = 'Hammersmith One';
	$font_family[] = 'Courgette';
	$font_family[] = 'Permanent Marker';
	$font_family[] = 'Cherry Swash';
	$font_family[] = 'Cormorant Garamond';
	$font_family[] = 'Poiret One';
	$font_family[] = 'BenchNine';
	$font_family[] = 'Economica';
	$font_family[] = 'Handlee';
	$font_family[] = 'Cardo';
	$font_family[] = 'Alfa Slab One';
	$font_family[] = 'Averia Serif Libre';
	$font_family[] = 'Cookie';
	$font_family[] = 'Chewy';
	$font_family[] = 'Great Vibes';
	$font_family[] = 'Coming Soon';
	$font_family[] = 'Philosopher';
	$font_family[] = 'Days One';
	$font_family[] = 'Kanit';
	$font_family[] = 'Shrikhand';
	$font_family[] = 'Tangerine';
	$font_family[] = 'IM Fell English SC';
	$font_family[] = 'Boogaloo';
	$font_family[] = 'Bangers';
	$font_family[] = 'Fredoka One';
	$font_family[] = 'Bad Script';
	$font_family[] = 'Volkhov';
	$font_family[] = 'Shadows Into Light Two';
	$font_family[] = 'Marck Script';
	$font_family[] = 'Sacramento';
	$font_family[] = 'Unica One';

	$query_args = array(
		'family'	=> rawurlencode(implode('|',$font_family)),
	);
	$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	return $font_url;
}
	
/* Theme enqueue scripts */
function interior_designs_scripts() {
	wp_enqueue_style( 'interior-designs-font', interior_designs_font_url(), array() );	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css' );
	wp_enqueue_style( 'interior-designs-basic-style', get_stylesheet_uri() );
	wp_style_add_data( 'interior-designs-style', 'rtl', 'replace' );
	wp_enqueue_style( 'interior-designs-effect', get_template_directory_uri().'/css/effect.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/fontawesome-all.css' );

	// Paragraph
	    $interior_designs_paragraph_color = get_theme_mod('interior_designs_paragraph_color', '');
	    $interior_designs_paragraph_font_family = get_theme_mod('interior_designs_paragraph_font_family', '');
	    $interior_designs_paragraph_font_size = get_theme_mod('interior_designs_paragraph_font_size', '');
	// "a" tag
		$interior_designs_atag_color = get_theme_mod('interior_designs_atag_color', '');
	    $interior_designs_atag_font_family = get_theme_mod('interior_designs_atag_font_family', '');
	// "li" tag
		$interior_designs_li_color = get_theme_mod('interior_designs_li_color', '');
	    $interior_designs_li_font_family = get_theme_mod('interior_designs_li_font_family', '');
	// H1
		$interior_designs_h1_color = get_theme_mod('interior_designs_h1_color', '');
	    $interior_designs_h1_font_family = get_theme_mod('interior_designs_h1_font_family', '');
	    $interior_designs_h1_font_size = get_theme_mod('interior_designs_h1_font_size', '');
	// H2
		$interior_designs_h2_color = get_theme_mod('interior_designs_h2_color', '');
	    $interior_designs_h2_font_family = get_theme_mod('interior_designs_h2_font_family', '');
	    $interior_designs_h2_font_size = get_theme_mod('interior_designs_h2_font_size', '');
	// H3
		$interior_designs_h3_color = get_theme_mod('interior_designs_h3_color', '');
	    $interior_designs_h3_font_family = get_theme_mod('interior_designs_h3_font_family', '');
	    $interior_designs_h3_font_size = get_theme_mod('interior_designs_h3_font_size', '');
	// H4
		$interior_designs_h4_color = get_theme_mod('interior_designs_h4_color', '');
	    $interior_designs_h4_font_family = get_theme_mod('interior_designs_h4_font_family', '');
	    $interior_designs_h4_font_size = get_theme_mod('interior_designs_h4_font_size', '');
	// H5
		$interior_designs_h5_color = get_theme_mod('interior_designs_h5_color', '');
	    $interior_designs_h5_font_family = get_theme_mod('interior_designs_h5_font_family', '');
	    $interior_designs_h5_font_size = get_theme_mod('interior_designs_h5_font_size', '');
	// H6
		$interior_designs_h6_color = get_theme_mod('interior_designs_h6_color', '');
	    $interior_designs_h6_font_family = get_theme_mod('interior_designs_h6_font_family', '');
	    $interior_designs_h6_font_size = get_theme_mod('interior_designs_h6_font_size', '');
	    $interior_designs_theme_color_first = get_theme_mod('interior_designs_theme_color_first', '');
	    $interior_designs_theme_color_second = get_theme_mod('interior_designs_theme_color_second', '');

		$custom_css ='
			p,span{
			    color:'.esc_html($interior_designs_paragraph_color).'!important;
			    font-family: '.esc_html($interior_designs_paragraph_font_family).'!important;
			    font-size: '.esc_html($interior_designs_paragraph_font_size).'!important;
			}
			a{
			    color:'.esc_html($interior_designs_atag_color).'!important;
			    font-family: '.esc_html($interior_designs_atag_font_family).';
			}
			li{
			    color:'.esc_html($interior_designs_li_color).'!important;
			    font-family: '.esc_html($interior_designs_li_font_family).';
			}
			h1{
			    color:'.esc_html($interior_designs_h1_color).'!important;
			    font-family: '.esc_html($interior_designs_h1_font_family).'!important;
			    font-size: '.esc_html($interior_designs_h1_font_size).'!important;
			}
			h2{
			    color:'.esc_html($interior_designs_h2_color).'!important;
			    font-family: '.esc_html($interior_designs_h2_font_family).'!important;
			    font-size: '.esc_html($interior_designs_h2_font_size).'!important;
			}
			h3{
			    color:'.esc_html($interior_designs_h3_color).'!important;
			    font-family: '.esc_html($interior_designs_h3_font_family).'!important;
			    font-size: '.esc_html($interior_designs_h3_font_size).'!important;
			}
			h4{
			    color:'.esc_html($interior_designs_h4_color).'!important;
			    font-family: '.esc_html($interior_designs_h4_font_family).'!important;
			    font-size: '.esc_html($interior_designs_h4_font_size).'!important;
			}
			h5{
			    color:'.esc_html($interior_designs_h5_color).'!important;
			    font-family: '.esc_html($interior_designs_h5_font_family).'!important;
			    font-size: '.esc_html($interior_designs_h5_font_size).'!important;
			}
			h6{
			    color:'.esc_html($interior_designs_h6_color).'!important;
			    font-family: '.esc_html($interior_designs_h6_font_family).'!important;
			    font-size: '.esc_html($interior_designs_h6_font_size).'!important;
			}
			.top-header,#comments input[type="submit"].submit,.footertown .tagcloud a,#comments a.comment-reply-link, .metabox,.search-box,li.woocommerce-MyAccount-navigation-link.woocommerce-MyAccount-navigation-link, .primary-navigation ul ul a, .service-btn a, .toggle-menu, .disc-btn a, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .footertown input[type="submit"],input[type="submit"], .footertown th, #sidebar th, .page-links a:hover, .pagination .current,.page-links .current, .woocommerce span.onsale, #footer, #sidebar .tagcloud a:hover, #sidebar input[type="submit"], .primary-navigation a:hover, a.button, .woocommerce-product-search button[type="submit"], .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle{
			    background-color:'.esc_html($interior_designs_theme_color_first).';
			}
			@media screen and (max-width:1000px){
				.sidebar{
				    background-color:'.esc_html($interior_designs_theme_color_first).';
				}
			}

			.logo p,.textwidget a,.pagination a,.tags a:hover, a,.woocommerce a.button:hover, .call i,.location i,#discover h1,.time i, #discover h3, .woocommerce ul.products li.product .price,  .footertown .widget h3, #slider .carousel-control-prev-icon, #slider .carousel-control-next-icon, .services-box:hover i,.topbox i:hover, #header .nav ul li:hover > ul li a:hover,h3.widget-title a,  .woocommerce-MyAccount-content a, .woocommerce-info a, span.entry-author a, form.woocommerce-cart-form a, #comments a.comment-reply-link:hover, .pagination span, .footertown .tagcloud a:hover, .primary-navigation ul ul a:hover {
			    color:'.esc_html($interior_designs_theme_color_first).';
			}
			.woocommerce a.button:hover, .primary-navigation ul ul a:hover, .primary-navigation ul li a:hover{
				color:'.esc_html($interior_designs_theme_color_first).'!important;
			}
			#header .nav ul li:hover > ul{
			    border-top-color:'.esc_html($interior_designs_theme_color_first).';
			}
			.footertown input.search-field{
				border-color:'.esc_html($interior_designs_theme_color_first).';
			}
			.services-box:hover, .full-header, .serach_inner form.search-form{
			    border-color:'.esc_html($interior_designs_theme_color_first).'!important;
			}
			.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover.woocommerce a.button:hover.woocommerce a.button:hover,.woocommerce button.button:hover, .service-btn a:hover, #header, #comments a.comment-reply-link:hover, .footertown, .primary-navigation ul ul a:hover, #slider .carousel-control-prev-icon, #slider .carousel-control-next-icon, #discover, .pagination span, .fixed-header, .woocommerce a.button:hover{
				background-color:'.esc_html($interior_designs_theme_color_second).';
			}
			
			#header, #discover, #slider .carousel-control-prev-icon, #slider .carousel-control-next-icon, .footertown, .primary-navigation ul ul a:hover,
			.primary-navigation ul ul a:hover, .primary-navigation ul li a:hover{
			    background-color:'.esc_html($interior_designs_theme_color_second).'!important;
			}
			.tags a{
				border-color:'.esc_html($interior_designs_theme_color_second).'!important;
			}
			a.showcoupon,.woocommerce #respond input#submit, .woocommerce button.button, .woocommerce input.button, .woocommerce button.button,span.entry-author a, .logo p, .services-box:hover i, .topbox i:hover, #services h2, #sidebar th, .primary-navigation a:hover, .primary-navigation ul ul a, .woocommerce .product p.price, .woocommerce div.product span.price,.product_meta a, form.woocommerce-cart-form a, #sidebar ul li a, .woocommerce a.button, .toggle-menu i{
			    color:'.esc_html($interior_designs_theme_color_second).';
			}
			.woocommerce #respond input#submit, .woocommerce button.button, .woocommerce input.button{
			    color:'.esc_html($interior_designs_theme_color_second).' !important;
			}
			@media screen and (max-width: 1000px){
				.primary-navigation ul li a{
					color:'.esc_html($interior_designs_theme_color_second).';
				}
			}
			.service-btn a, .middle-align h1,code,h1.entry-title,.pagination .current,.page-links a:hover,.tags a,span.post-title,span.meta-nav,.metabox a,#sidebar input[type="submit"],.footertown th,.footertown input[type="submit"], input[type="submit"],.woocommerce span.onsale,.metabox .entry-author a,.entry-content a,.logo p a ,.upper-box a,span.entry-author a, .metabox .entry-author a,.metabox,.metabox .entry-author a, h1.product_title.entry-title,#tab-description h2,#reviews h2,h2#reply-title, .site-text span, .social-media i, .logo h1 a, p.infotext, .call p,.location p,.time p, #services h3, h1.woocommerce-products-header__title.page-title, .services-box h2 a, #sidebar h3,  #comments a.comment-reply-link, #sidebar h3 a, #sidebar caption, #sidebar td#prev a, .primary-navigation ul li a:hover, .sidebar .closebtn, .woocommerce-product-search button[type="submit"], .footertown .tagcloud a{
			    color:'.esc_html($interior_designs_theme_color_second).';
			}
			';

	/*---------------------------Width Layout -------------------*/
	$theme_lay = get_theme_mod( 'interior_designs_width_options','Full Layout');
    if($theme_lay == 'Full Layout'){
		$custom_css .='body{';
			$custom_css .='max-width: 100%;';
		$custom_css .='}';
	}else if($theme_lay == 'Contained Layout'){
		$custom_css .='body{';
			$custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$custom_css .='}';
	}else if($theme_lay == 'Boxed Layout'){
		$custom_css .='body{';
			$custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$custom_css .='}';
	}

	wp_add_inline_style( 'interior-designs-basic-style',$custom_css );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js' );
	wp_enqueue_script( 'interior-designs-custom-jquery', get_template_directory_uri() . '/js/custom.js', array('jquery') );
	wp_enqueue_script( 'jquery-superfish', get_template_directory_uri() . '/js/jquery.superfish.js', array('jquery') ,'',true);
	wp_enqueue_script( 'jquery.min', get_template_directory_uri() . '/js/jquery.min.js', array('jquery') );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'interior_designs_scripts' );

/*radio button sanitization*/

function interior_designs_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function interior_designs_sanitize_dropdown_pages( $page_id, $setting ) {
  	// Ensure $input is an absolute integer.
  	$page_id = absint( $page_id );

  	// If $page_id is an ID of a published page, return it; otherwise, return the default.
  	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/* Excerpt Limit Begin */
function interior_designs_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'interior_designs_loop_columns');
	if (!function_exists('interior_designs_loop_columns')) {
	function interior_designs_loop_columns() {
	return 3; // 3 products per row
	}
}

// URL DEFINES
define('INTERIOR_DESIGNS_SITE_URL',__('https://www.themescaliber.com/themes/free-interior-design-wordpress-theme/', 'interior-designs'));
function interior_designs_credit_link() {
    echo "<a href=".esc_url(INTERIOR_DESIGNS_SITE_URL)." target='_blank'>".esc_html__('Interior WordPress Theme','interior-designs')."</a>";
}

/* Custom template tags for this theme. */
require get_template_directory() . '/inc/template-tags.php';

/* Implement the Custom Header feature. */
require get_template_directory() . '/inc/custom-header.php';

/* Customizer additions. */
require get_template_directory() . '/inc/customizer.php';