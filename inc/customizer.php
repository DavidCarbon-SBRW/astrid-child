<?php
/**
 * Astrid Child Theme Customizer.
 *
 * @package Astrid-Child
 */

function astrid_child_customizer( $wp_customize ) {

	if ( !function_exists('astrid_setup') ) {
		return;
	}

    $wp_customize->get_control( 'front_header_type' )->choices =  array('image' => __('Image', 'astrid'),'shortcode' => __('Shortcode', 'astrid'),'video' => __('Video', 'astrid'),'nothing' => __('Only menu', 'astrid') );
    $wp_customize->get_control( 'site_header_type' )->choices =  array('image' => __('Image', 'astrid'),'shortcode' => __('Shortcode', 'astrid'),'video' => __('Video', 'astrid'),'nothing' => __('Only menu', 'astrid') );


    //Shortcode
    $wp_customize->add_setting(
        'astrid_shortcode',
        array(
            'default' => '',
            'sanitize_callback' => 'astrid_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'astrid_shortcode',
        array(
            'label' => __( 'Add your shortcode here', 'west' ),
            'section' => 'astrid_header_type',
            'type' => 'text',
            'priority' => 29
        )
    ); 
    
    //___Buttons___//
    $wp_customize->add_section(
        'astrid_buttons',
        array(
            'title'     => __('Buttons', 'astrid'),
            'priority'  => 15
        )
    );
    //Type
    $wp_customize->add_setting(
        'buttons_type',
        array(
            'default'           => 'bordered',
            'sanitize_callback' => 'astrid_sanitize_buttons',
        )
    );
    $wp_customize->add_control(
        'buttons_type',
        array(
            'type'        => 'radio',
            'label'       => __('Buttons style', 'astrid'),
            'section'     => 'astrid_buttons',
            'priority'    => 10,
            'choices' => array(
                'bordered'              => __('Bordered', 'astrid'),
                'solid'                 => __('Solid', 'astrid'),
            ),
        )
    );
    //Padding
    $wp_customize->add_setting(
        'buttons_tb_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '12',
            'transport'     => 'postMessage'            
        )       
    );
    $wp_customize->add_control( 'buttons_tb_padding', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'astrid_buttons',
        'label'       => __('Top/bottom button padding', 'astrid'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 40,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    $wp_customize->add_setting(
        'buttons_lr_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '30',
            'transport'     => 'postMessage'            
        )       
    );
    $wp_customize->add_control( 'buttons_lr_padding', array(
        'type'        => 'number',
        'priority'    => 12,
        'section'     => 'astrid_buttons',
        'label'       => __('Left/right button padding', 'astrid'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 50,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //Font size
    $wp_customize->add_setting(
        'buttons_font_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '14',
            'transport'     => 'postMessage'            
        )       
    );
    $wp_customize->add_control( 'buttons_font_size', array(
        'type'        => 'number',
        'priority'    => 12,
        'section'     => 'astrid_buttons',
        'label'       => __('Button font size', 'astrid'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 40,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) ); 
    //Border radius
    $wp_customize->add_setting(
        'buttons_radius',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '0',
            'transport'     => 'postMessage'            
        )       
    );
    $wp_customize->add_control( 'buttons_radius', array(
        'type'        => 'number',
        'priority'    => 13,
        'section'     => 'astrid_buttons',
        'label'       => __('Button border radius', 'astrid'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 50,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    //___Footer___//
    $wp_customize->add_setting(
        'footer_credits',
        array(
            'default' => '',
            'sanitize_callback' => 'astrid_sanitize_text',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        'footer_credits',
        array(
            'label' => __( 'Footer credits [HTML allowed]', 'astrid' ),
            'section' => 'astrid_footer',
            'type' => 'text',
            'priority' => 10
        )
    );
    //Footer Background
    $wp_customize->add_setting(
        'footer_background_img',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'footer_background_img',
            array(
               'label'          => __( 'Footer background image', 'west' ),
               'type'           => 'image',
               'section'        => 'astrid_footer',
               'priority'       => 11,
            )
        )
    );  

    //___Colors___// 
    $wp_customize->add_setting(
        'ap_menu_items',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'ap_menu_items',
            array(
                'label'         => __('Menu items', 'astrid'),
                'section'       => 'colors',
                'priority'      => 10
            )
        )
    );
    $wp_customize->add_setting(
        'ap_submenu_items',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'ap_submenu_items',
            array(
                'label'         => __('Submenu items', 'astrid'),
                'section'       => 'colors',
                'priority'      => 10
            )
        )
    );
    $wp_customize->add_setting(
        'ap_submenu_bg',
        array(
            'default'           => '#1C1E21',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'ap_submenu_bg',
            array(
                'label'         => __('Submenu background', 'astrid'),
                'section'       => 'colors',
                'priority'      => 10
            )
        )
    );
    $wp_customize->add_setting(
        'ap_header_overlay',
        array(
            'default'           => '#252E35',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'ap_header_overlay',
            array(
                'label'         => __('Header overlay', 'astrid'),
                'section'       => 'colors',
                'priority'      => 10
            )
        )
    );
    $wp_customize->add_setting(
        'ap_header_text',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'ap_header_text',
            array(
                'label'         => __('Header text', 'astrid'),
                'section'       => 'colors',
                'priority'      => 10
            )
        )
    );
    $wp_customize->add_setting(
        'ap_footer_color',
        array(
            'default'           => '#a3aaaa',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'ap_footer_color',
            array(
                'label'         => __('Footer text', 'astrid'),
                'section'       => 'colors',
                'priority'      => 10
            )
        )
    );
    $wp_customize->add_setting(
        'ap_footer_wt_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'ap_footer_wt_color',
            array(
                'label'         => __('Footer widgets title', 'astrid'),
                'section'       => 'colors',
                'priority'      => 10
            )
        )
    );

    $wp_customize->add_setting(
        'ap_row_overlay',
        array(
            'default'           => '#252E35',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'ap_row_overlay',
            array(
                'label'         => __('Row overlay', 'astrid'),
                'section'       => 'colors',
                'priority'      => 10
            )
        )
    ); 

    //___Single templates___//
    $wp_customize->add_section(
        'astrid_child_templates',
        array(
            'title'     => __('Single templates', 'astrid'),
            'priority'  => 20,
            'description' => __('Here you can adjust the layouts for all theme-defined page templates (Single Service, Single Project etc.)', 'astrid')
        )
    );       
    //Employees
    $wp_customize->add_setting('astrid_options[info]', array(
            'type'              => 'info_control',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Astrid_Info( $wp_customize, 'employee_template', array(
        'label' => __('Employees', 'astrid'),
        'section'   => 'astrid_child_templates',
        'settings' => 'astrid_options[info]',
        'priority' => 10
        ) )
    ); 
    $wp_customize->add_setting(
        'ap_emp_fullwidth',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_emp_fullwidth',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width employees?', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 11,
        )
    );
    $wp_customize->add_setting(
        'ap_emp_center',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_emp_center',
        array(
            'type'      => 'checkbox',
            'label'     => __('Center all the content?', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 12,
        )
    );  

    $wp_customize->add_setting(
        'ap_emp_sidebyside',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_emp_sidebyside',
        array(
            'type'      => 'checkbox',
            'label'     => __('Side-by-side image and content? (useful in full width mode)', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 13,
        )
    ); 
    //Services
    $wp_customize->add_setting('astrid_options[info]', array(
            'type'              => 'info_control',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Astrid_Info( $wp_customize, 'service_template', array(
        'label' => __('Services', 'astrid'),
        'section'   => 'astrid_child_templates',
        'settings' => 'astrid_options[info]',
        'priority' => 14
        ) )
    ); 
    $wp_customize->add_setting(
        'ap_service_fullwidth',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_service_fullwidth',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width services?', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 15,
        )
    );
    $wp_customize->add_setting(
        'ap_service_center',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_service_center',
        array(
            'type'      => 'checkbox',
            'label'     => __('Center all the content?', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 16,
        )
    );  

    $wp_customize->add_setting(
        'ap_service_sidebyside',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_service_sidebyside',
        array(
            'type'      => 'checkbox',
            'label'     => __('Side-by-side image and content? (useful in full width mode)', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 17,
        )
    );
    //Project
    $wp_customize->add_setting('astrid_options[info]', array(
            'type'              => 'info_control',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Astrid_Info( $wp_customize, 'project_template', array(
        'label' => __('Projects', 'astrid'),
        'section'   => 'astrid_child_templates',
        'settings' => 'astrid_options[info]',
        'priority' => 18
        ) )
    ); 
    $wp_customize->add_setting(
        'ap_project_fullwidth',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_project_fullwidth',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width projects?', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 19,
        )
    );
    $wp_customize->add_setting(
        'ap_project_center',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_project_center',
        array(
            'type'      => 'checkbox',
            'label'     => __('Center all the content?', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 20,
        )
    );  

    $wp_customize->add_setting(
        'ap_project_sidebyside',
        array(
            'sanitize_callback' => 'astrid_sanitize_checkbox',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control(
        'ap_project_sidebyside',
        array(
            'type'      => 'checkbox',
            'label'     => __('Side-by-side image and content? (useful in full width mode)', 'astrid'),
            'section'   => 'astrid_child_templates',
            'priority'  => 21,
        )
    );


    //Maps API key
    $wp_customize->add_section(
        'astrid_child_maps',
        array(
            'title'     => __('Google Maps', 'astrid'),
            'priority'  => 20
        )
    );
    $wp_customize->add_setting(
        'astrid_child_maps_api',
        array(
            'default' => '',
            'sanitize_callback' => 'astrid_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'astrid_child_maps_api',
        array(
            'label' => __( 'Google Maps API key', 'astrid' ),
            'section' => 'astrid_child_maps',
            'type' => 'text',
            'priority' => 10,
            'description' => __('You can obtain a free API key ', 'astrid') . '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a>. You need to add your key in case you want to use the built-in contact widget.'
        )
    );

    $wp_customize->add_setting(
        'astrid_child_disable_api',
        array(
            'default'           => '',
            'sanitize_callback' => 'astrid_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'astrid_child_disable_api',
        array(
            'type'      => 'checkbox',
            'label'     => __('Disable Google Maps API?', 'astrid'),
            'section'   => 'astrid_child_maps',
            'priority'  => 11,
            'description'       => __('You can disable the Google Maps API from being loaded in Astrid in case you\'re already loading it from a plugin.')
        )
    );
}
add_action( 'customize_register', 'astrid_child_customizer', 21 );


//Buttons
function astrid_sanitize_buttons( $input ) {
    $valid = array(
        'bordered'              => __('Bordered', 'astrid'),
        'solid'                 => __('Solid', 'astrid'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}