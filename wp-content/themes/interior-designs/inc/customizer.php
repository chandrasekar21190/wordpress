<?php
/**
 * Interior Designs Theme Customizer
 *
 * @package Interior Designs
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function interior_designs_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'blogname',
		array(
			'selector'        => '.site-title a',
			'render_callback' => 'interior_designs_customize_partial_blogname',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'blogdescription',
		array(
			'selector'        => '.site-description',
			'render_callback' => 'interior_designs_customize_partial_blogdescription',
		)
	);

	//add home page setting pannel
	$wp_customize->add_panel( 'interior_designs_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'interior-designs' ),
	    'description' => __( 'Description of what this panel does.', 'interior-designs' )
	) );

	//Layouts
	$wp_customize->add_section( 'interior_designs_left_right', array(
    	'title'      => __( 'Theme Layout Settings', 'interior-designs' ),
		'priority'   => 30,
		'panel' => 'interior_designs_panel_id'
	) );

	$wp_customize->add_setting('interior_designs_width_options',array(
        'default' => __('Full Layout','interior-designs'),
        'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control('interior_designs_width_options',array(
        'type' => 'select',
        'label' => __('Select Site Layout','interior-designs'),
        'section' => 'interior_designs_left_right',
        'choices' => array(
            'Full Layout' => __('Full Layout','interior-designs'),
            'Contained Layout' => __('Contained Layout','interior-designs'),
            'Boxed Layout' => __('Boxed Layout','interior-designs'),
        ),
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('interior_designs_theme_options',array(
	        'default' => __( 'Right Sidebar', 'interior-designs' ),
	        'sanitize_callback' => 'interior_designs_sanitize_choices'
	) );
	$wp_customize->add_control('interior_designs_theme_options',
	    array(
	        'type' => 'radio',
	        'label' => __( 'Do you want this section', 'interior-designs' ),
	        'section' => 'interior_designs_left_right',
	        'choices' => array(
	            'Left Sidebar' => __('Left Sidebar','interior-designs'),
	            'Right Sidebar' => __('Right Sidebar','interior-designs'),
	            'One Column' => __('One Column','interior-designs'),
	            'Three Columns' => __('Three Columns','interior-designs'),
	            'Four Columns' => __('Four Columns','interior-designs'),
	            'Grid Layout' => __('Grid Layout','interior-designs')
	        ),
	    )
    );

    $font_array = array(
        '' =>'No Fonts',
        'Abril Fatface' => 'Abril Fatface',
        'Acme' =>'Acme', 
        'Anton' => 'Anton', 
        'Architects Daughter' =>'Architects Daughter',
        'Arimo' => 'Arimo', 
        'Arsenal' =>'Arsenal',
        'Arvo' =>'Arvo',
        'Alegreya' =>'Alegreya',
        'Alfa Slab One' =>'Alfa Slab One',
        'Averia Serif Libre' =>'Averia Serif Libre', 
        'Bangers' =>'Bangers', 
        'Boogaloo' =>'Boogaloo', 
        'Bad Script' =>'Bad Script',
        'Bitter' =>'Bitter', 
        'Bree Serif' =>'Bree Serif', 
        'BenchNine' =>'BenchNine',
        'Cabin' =>'Cabin',
        'Cardo' =>'Cardo', 
        'Courgette' =>'Courgette', 
        'Cherry Swash' =>'Cherry Swash',
        'Cormorant Garamond' =>'Cormorant Garamond', 
        'Crimson Text' =>'Crimson Text',
        'Cuprum' =>'Cuprum', 
        'Cookie' =>'Cookie',
        'Chewy' =>'Chewy',
        'Days One' =>'Days One',
        'Dosis' =>'Dosis',
        'Droid Sans' =>'Droid Sans', 
        'Economica' =>'Economica', 
        'Fredoka One' =>'Fredoka One',
        'Fjalla One' =>'Fjalla One',
        'Francois One' =>'Francois One', 
        'Frank Ruhl Libre' => 'Frank Ruhl Libre', 
        'Gloria Hallelujah' =>'Gloria Hallelujah',
        'Great Vibes' =>'Great Vibes', 
        'Handlee' =>'Handlee', 
        'Hammersmith One' =>'Hammersmith One',
        'Inconsolata' =>'Inconsolata',
        'Indie Flower' =>'Indie Flower', 
        'IM Fell English SC' =>'IM Fell English SC',
        'Julius Sans One' =>'Julius Sans One',
        'Josefin Slab' =>'Josefin Slab',
        'Josefin Sans' =>'Josefin Sans',
        'Kanit' =>'Kanit',
        'Lobster' =>'Lobster',
        'Lato' => 'Lato',
        'Lora' =>'Lora', 
        'Libre Baskerville' =>'Libre Baskerville',
        'Lobster Two' => 'Lobster Two',
        'Merriweather' =>'Merriweather',
        'Monda' =>'Monda',
        'Montserrat' =>'Montserrat',
        'Muli' =>'Muli',
        'Marck Script' =>'Marck Script',
        'Noto Serif' =>'Noto Serif',
        'Open Sans' =>'Open Sans',
        'Overpass' => 'Overpass', 
        'Overpass Mono' =>'Overpass Mono',
        'Oxygen' =>'Oxygen',
        'Orbitron' =>'Orbitron',
        'Patua One' =>'Patua One',
        'Pacifico' =>'Pacifico',
        'Padauk' =>'Padauk',
        'Playball' =>'Playball',
        'Playfair Display' =>'Playfair Display',
        'PT Sans' =>'PT Sans',
        'Philosopher' =>'Philosopher',
        'Permanent Marker' =>'Permanent Marker',
        'Poiret One' =>'Poiret One',
        'Quicksand' =>'Quicksand',
        'Quattrocento Sans' =>'Quattrocento Sans',
        'Raleway' =>'Raleway',
        'Rubik' =>'Rubik',
        'Rokkitt' =>'Rokkitt',
        'Russo One' => 'Russo One', 
        'Righteous' =>'Righteous', 
        'Slabo' =>'Slabo', 
        'Source Sans Pro' =>'Source Sans Pro',
        'Shadows Into Light Two' =>'Shadows Into Light Two',
        'Shadows Into Light' =>  'Shadows Into Light',
        'Sacramento' =>'Sacramento',
        'Shrikhand' =>'Shrikhand',
        'Tangerine' => 'Tangerine',
        'Ubuntu' =>'Ubuntu',
        'VT323' =>'VT323',
        'Varela Round' =>'Varela Round',
        'Vampiro One' =>'Vampiro One',
        'Vollkorn' => 'Vollkorn',
        'Volkhov' =>'Volkhov',
        'Kavoon' =>'Kavoon',
        'Yanone Kaffeesatz' =>'Yanone Kaffeesatz'
    );

	//Color / Font Pallete
	$wp_customize->add_section( 'interior_designs_typography', array(
    	'title'      => __( 'Color / Font Pallete', 'interior-designs' ),
		'priority'   => 30,
		'panel' => 'interior_designs_panel_id'
	) );

	// Add the Theme Color Option section.
	$wp_customize->add_setting( 'interior_designs_theme_color_first', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_theme_color_first', array(
  		'label' => 'Theme Color Option 1',
	    'section' => 'interior_designs_typography',
	    'settings' => 'interior_designs_theme_color_first',
  	)));

  	$wp_customize->add_setting( 'interior_designs_theme_color_second', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_theme_color_second', array(
  		'label' => 'Theme Color Option 2',
	    'section' => 'interior_designs_typography',
	    'settings' => 'interior_designs_theme_color_second',
  	)));
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'interior_designs_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_paragraph_color', array(
		'label' => __('Paragraph Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('interior_designs_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_paragraph_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( 'Paragraph Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	$wp_customize->add_setting('interior_designs_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','interior-designs'),
		'section'	=> 'interior_designs_typography',
		'setting'	=> 'interior_designs_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'interior_designs_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_atag_color', array(
		'label' => __('"a" Tag Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('interior_designs_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_atag_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( '"a" Tag Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'interior_designs_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_li_color', array(
		'label' => __('"li" Tag Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('interior_designs_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_li_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( '"li" Tag Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'interior_designs_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_h1_color', array(
		'label' => __('h1 Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('interior_designs_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_h1_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( 'h1 Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('interior_designs_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_h1_font_size',array(
		'label'	=> __('h1 Font Size','interior-designs'),
		'section'	=> 'interior_designs_typography',
		'setting'	=> 'interior_designs_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'interior_designs_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_h2_color', array(
		'label' => __('h2 Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('interior_designs_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_h2_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( 'h2 Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('interior_designs_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_h2_font_size',array(
		'label'	=> __('h2 Font Size','interior-designs'),
		'section'	=> 'interior_designs_typography',
		'setting'	=> 'interior_designs_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'interior_designs_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_h3_color', array(
		'label' => __('h3 Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('interior_designs_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_h3_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( 'h3 Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('interior_designs_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_h3_font_size',array(
		'label'	=> __('h3 Font Size','interior-designs'),
		'section'	=> 'interior_designs_typography',
		'setting'	=> 'interior_designs_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'interior_designs_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_h4_color', array(
		'label' => __('h4 Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('interior_designs_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_h4_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( 'h4 Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('interior_designs_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_h4_font_size',array(
		'label'	=> __('h4 Font Size','interior-designs'),
		'section'	=> 'interior_designs_typography',
		'setting'	=> 'interior_designs_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'interior_designs_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_h5_color', array(
		'label' => __('h5 Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('interior_designs_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_h5_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( 'h5 Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('interior_designs_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_h5_font_size',array(
		'label'	=> __('h5 Font Size','interior-designs'),
		'section'	=> 'interior_designs_typography',
		'setting'	=> 'interior_designs_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'interior_designs_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_designs_h6_color', array(
		'label' => __('h6 Color', 'interior-designs'),
		'section' => 'interior_designs_typography',
		'settings' => 'interior_designs_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('interior_designs_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control(
	    'interior_designs_h6_font_family', array(
	    'section'  => 'interior_designs_typography',
	    'label'    => __( 'h6 Fonts','interior-designs'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('interior_designs_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_h6_font_size',array(
		'label'	=> __('h6 Font Size','interior-designs'),
		'section'	=> 'interior_designs_typography',
		'setting'	=> 'interior_designs_h6_font_size',
		'type'	=> 'text'
	));

    //topbar
	$wp_customize->add_section('interior_designs_topbar',array(
		'title'	=> __('Top Header','interior-designs'),
		'description'	=> __('Add Header Content here','interior-designs'),
		'priority'	=> null,
		'panel' => 'interior_designs_panel_id',
	));

	//Show /Hide Topbar
	$wp_customize->add_setting( 'interior_designs_topbar_hide',array(
		'default' => 'true',
      	'sanitize_callback'	=> 'sanitize_text_field'
    ) );
    $wp_customize->add_control('interior_designs_topbar_hide',array(
    	'type' => 'checkbox',
        'label' => __( 'Show / Hide Topbar','interior-designs' ),
        'section' => 'interior_designs_topbar'
    ));

	//Sticky Header
	$wp_customize->add_setting( 'interior_designs_sticky_header',array(
      	'sanitize_callback'	=> 'sanitize_text_field'
    ) );
    $wp_customize->add_control('interior_designs_sticky_header',array(
    	'type' => 'checkbox',
        'label' => __( 'Sticky Header','interior-designs' ),
        'section' => 'interior_designs_topbar'
    ));

    $wp_customize->selective_refresh->add_partial('interior_designs_text',array(
		'selector'        => '.site-text span',
		'render_callback' => 'interior_designs_customize_partial_interior_designs_text',
	));

    $wp_customize->add_setting('interior_designs_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('interior_designs_text',array(
		'label'	=> __('Site Text','interior-designs'),
		'section'	=> 'interior_designs_topbar',
		'setting'	=> 'interior_designs_text',
		'type'	=> 'text'
	));

	$wp_customize->selective_refresh->add_partial(
		'interior_designs_facebook_url',
		array(
			'selector'        => '.social-media',
			'render_callback' => 'interior_designs_customize_partial_interior_designs_facebook_url',
		)
	);

	$wp_customize->add_setting('interior_designs_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('interior_designs_facebook_url',array(
		'label'	=> __('Add Facebook link','interior-designs'),
		'section'	=> 'interior_designs_topbar',
		'setting'	=> 'interior_designs_facebook_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('interior_designs_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('interior_designs_twitter_url',array(
		'label'	=> __('Add Twitter link','interior-designs'),
		'section'	=> 'interior_designs_topbar',
		'setting'	=> 'interior_designs_twitter_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('interior_designs_google_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('interior_designs_google_url',array(
		'label'	=> __('Add Google link','interior-designs'),
		'section'	=> 'interior_designs_topbar',
		'setting'	=> 'interior_designs_google_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('interior_designs_insta_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('interior_designs_insta_url',array(
		'label'	=> __('Add Instagram link','interior-designs'),
		'section'	=> 'interior_designs_topbar',
		'setting'	=> 'interior_designs_insta_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('interior_designs_linkdin_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('interior_designs_linkdin_url',array(
		'label'	=> __('Add Linkdin link','interior-designs'),
		'section'	=> 'interior_designs_topbar',
		'setting'	=> 'interior_designs_linkdin_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('interior_designs_youtube_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('interior_designs_youtube_url',array(
		'label'	=> __('Add Youtube link','interior-designs'),
		'section'	=> 'interior_designs_topbar',
		'setting'	=> 'interior_designs_youtube_url',
		'type'		=> 'url'
	));

	//Header
	$wp_customize->add_section('interior_designs_header',array(
		'title'	=> __('Header','interior-designs'),
		'description'	=> __('Add Header Content here','interior-designs'),
		'priority'	=> null,
		'panel' => 'interior_designs_panel_id',
	));

	$wp_customize->selective_refresh->add_partial(
		'interior_designs_call_text',
		array(
			'selector'        => '.call',
			'render_callback' => 'interior_designs_customize_partial_interior_designs_call_text',
		)
	);

    $wp_customize->add_setting('interior_designs_call_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('interior_designs_call_text',array(
		'label'	=> __('Call Text','interior-designs'),
		'section'	=> 'interior_designs_header',
		'setting'	=> 'interior_designs_call_text',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('interior_designs_call',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('interior_designs_call',array(
		'label'	=> __('Call No.','interior-designs'),
		'section'	=> 'interior_designs_header',
		'setting'	=> 'interior_designs_call',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('interior_designs_location_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('interior_designs_location_text',array(
		'label'	=> __('Street Details','interior-designs'),
		'section'	=> 'interior_designs_header',
		'setting'	=> 'interior_designs_location_text',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('interior_designs_location',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('interior_designs_location',array(
		'label'	=> __('City Details','interior-designs'),
		'section'	=> 'interior_designs_header',
		'setting'	=> 'interior_designs_location',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('interior_designs_time',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('interior_designs_time',array(
		'label'	=> __('Time','interior-designs'),
		'section'	=> 'interior_designs_header',
		'setting'	=> 'interior_designs_time',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('interior_designs_day',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('interior_designs_day',array(
		'label'	=> __('Day','interior-designs'),
		'section'	=> 'interior_designs_header',
		'setting'	=> 'interior_designs_day',
		'type'	=> 'text'
	));

	//home page slider
	$wp_customize->add_section( 'interior_designs_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'interior-designs' ),
		'priority'   => null,
		'panel' => 'interior_designs_panel_id'
	) );

	$wp_customize->selective_refresh->add_partial(
		'interior_designs_slider_arrows',
		array(
			'selector'        => '#slider .carousel-control-prev-icon',
			'render_callback' => 'interior_designs_customize_partial_interior_designs_slider_arrows',
		)
	);

	$wp_customize->add_setting('interior_designs_slider_arrows',array(
      'default' => 'false',
      'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_slider_arrows',array(
	      'type' => 'checkbox',
	      'label' => __('Show / Hide slider','interior-designs'),
	      'section' => 'interior_designs_slidersettings',
	));

	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'interior_designs_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'interior_designs_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'interior_designs_slider_page' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'interior-designs' ),
			'section'  => 'interior_designs_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	//Discover More
	$wp_customize->add_section('interior_designs_discover',array(
		'title'	=> __('Discover Section','interior-designs'),
		'description'	=> __('Add About sections below.','interior-designs'),
		'panel' => 'interior_designs_panel_id',
	));

	$wp_customize->selective_refresh->add_partial(
		'interior_designs_discover_post',
		array(
			'selector'        => '#discover h1',
			'render_callback' => 'interior_designs_customize_partial_interior_designs_discover_post',
		)
	);

	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$posts[]= 'select';
	foreach($post_list as $post){
		$posts[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('interior_designs_discover_post',array(
		'sanitize_callback' => 'interior_designs_sanitize_choices',
	));
	$wp_customize->add_control('interior_designs_discover_post',array(
		'type'    => 'select',
		'choices' => $posts,
		'label' => __('Select post','interior-designs'),
		'section' => 'interior_designs_discover',
	));

	//Services
	$wp_customize->add_section('interior_designs_services',array(
		'title'	=> __('Services Section','interior-designs'),
		'description'=> __('This section will appear below the slider.','interior-designs'),
		'panel' => 'interior_designs_panel_id',
	));	

	$wp_customize->selective_refresh->add_partial(
		'interior_designs_service_title',
		array(
			'selector'        => '#services h2',
			'render_callback' => 'interior_designs_customize_partial_interior_designs_service_title',
		)
	);
	
	$wp_customize->add_setting('interior_designs_service_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('interior_designs_service_title',array(
		'label'	=> __('Section Title','interior-designs'),
		'section'=> 'interior_designs_services',
		'setting'=> 'interior_designs_service_title',
		'type'=> 'text'
	));
	
	$wp_customize->add_setting('interior_designs_service_tag_line',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_service_tag_line',array(
		'label'	=> __('Section Sub-Title','interior-designs'),
		'section'=> 'interior_designs_services',
		'setting'=> 'interior_designs_service_tag_line',
		'type'=> 'text'
	));

	$categories = get_categories();
		$cats = array();
		$i = 0;
		$cats[]= 'select';
		foreach($categories as $category){
			if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cats[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('interior_designs_services_category',array(
		'default'	=> 'select',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('interior_designs_services_category',array(
		'type'    => 'select',
		'choices' => $cats,
		'label' => __('Select Category to display Latest Post','interior-designs'),
		'section' => 'interior_designs_services',
	));

	//Blog Post
	$wp_customize->add_section('interior_designs_blog_post',array(
		'title'	=> __('Post Settings','interior-designs'),
		'panel' => 'interior_designs_panel_id',
	));	

	$wp_customize->add_setting('interior_designs_date_hide',array(
       'default' => 'false',
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('interior_designs_date_hide',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Post Date','interior-designs'),
       'section' => 'interior_designs_blog_post'
    ));

    $wp_customize->add_setting('interior_designs_author_hide',array(
       'default' => 'false',
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('interior_designs_author_hide',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Post Author','interior-designs'),
       'section' => 'interior_designs_blog_post'
    ));

    $wp_customize->add_setting('interior_designs_comment_hide',array(
       'default' => 'false',
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('interior_designs_comment_hide',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Post Comments','interior-designs'),
       'section' => 'interior_designs_blog_post'
    ));

	//Footer
	$wp_customize->add_section('interior_designs_footer_section',array(
		'title'	=> __('Footer Section','interior-designs'),
		'description'	=> '',
		'priority'	=> null,
		'panel' => 'interior_designs_panel_id',
	));

	$wp_customize->selective_refresh->add_partial(
		'interior_designs_show_back_to_top',
		array(
			'selector'        => '.scrollup',
			'render_callback' => 'interior_designs_customize_partial_interior_designs_show_back_to_top',
		)
	);

	$wp_customize->add_setting('interior_designs_show_back_to_top',array(
        'default' => 'true',
        'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('interior_designs_show_back_to_top',array(
     	'type' => 'checkbox',
      	'label' => __('Show/Hide Back to Top Button','interior-designs'),
      	'section' => 'interior_designs_footer_section',
	));

	$wp_customize->add_setting('interior_designs_back_to_top_alignment',array(
        'default' => __('Right','interior-designs'),
        'sanitize_callback' => 'interior_designs_sanitize_choices'
	));
	$wp_customize->add_control('interior_designs_back_to_top_alignment',array(
        'type' => 'select',
        'label' => __('Back to Top Button Alignment','interior-designs'),
        'section' => 'interior_designs_footer_section',
        'choices' => array(
            'Left' => __('Left','interior-designs'),
            'Right' => __('Right','interior-designs'),
            'Center' => __('Center','interior-designs'),
        ),
	) );

	$wp_customize->add_setting('interior_designs_footer_widget_layout',array(
        'default'           => '4',
        'sanitize_callback' => 'interior_designs_sanitize_choices',
    ));
    $wp_customize->add_control('interior_designs_footer_widget_layout',array(
        'type'        => 'radio',
        'label'       => __('Footer widget layout', 'interior-designs'),
        'section'     => 'interior_designs_footer_section',
        'description' => __('Select the number of widget areas you want in the footer. After that, go to Appearance > Widgets and add your widgets.', 'interior-designs'),
        'choices' => array(
            '1'     => __('One', 'interior-designs'),
            '2'     => __('Two', 'interior-designs'),
            '3'     => __('Three', 'interior-designs'),
            '4'     => __('Four', 'interior-designs')
        ),
    ));

    $wp_customize->selective_refresh->add_partial(
		'interior_designs_footer_copy',
		array(
			'selector'        => '#footer p',
			'render_callback' => 'interior_designs_customize_partial_interior_designs_footer_copy',
		)
	);
	
	$wp_customize->add_setting('interior_designs_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field',
	));	
	$wp_customize->add_control('interior_designs_footer_copy',array(
		'label'	=> __('Copyright Text','interior-designs'),
		'section'	=> 'interior_designs_footer_section',
		'type'		=> 'text'
	));
	/** home page setions end here**/	
}
add_action( 'customize_register', 'interior_designs_customize_register' );

// logo resize
load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-width.php' );


/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Interior_Designs_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );
		
		// Register custom section types.
		$manager->register_section_type( 'Interior_Designs_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Interior_Designs_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority'   => 9,
					'title'    => esc_html__( 'Interior Pro Theme', 'interior-designs' ),
					'pro_text' => esc_html__( 'Go Pro', 'interior-designs' ),
					'pro_url'  => esc_url( 'https://www.themescaliber.com/themes/interior-design-wordpress-theme/' ),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'interior-designs-customize-controls', trailingslashit( get_template_directory_uri() ) . '/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'interior-designs-customize-controls', trailingslashit( get_template_directory_uri() ) . '/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Interior_Designs_Customize::get_instance();