<?php
/**
 * @package Astrid-Child
 */

//Converts hex colors to rgba for the menu background color
function astrid_child_hex2rgba($color, $opacity = false) {
		if ( !function_exists('astrid_setup') ) {
			return;
		}
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        $rgb =  array_map('hexdec', $hex);
        
        if($opacity){
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        return $output;
}


/**
* Styles
*/
function astrid_child_custom_styles($custom) {

		$custom = "";

        //Footer background
        $footer_image   = get_theme_mod('footer_background_img');
        $footer_bg      = get_theme_mod( 'footer_bg', '#202529' );
        $footer_rgba    = astrid_child_hex2rgba($footer_bg, 0.9);
        if ($footer_image) {
            $custom .= ".footer-wrapper { background:url(" . esc_url($footer_image) . ") no-repeat center;background-size:cover;}"."\n";
            $custom .= ".footer-widgets, .site-footer, .footer-info { background-color:" . esc_attr($footer_rgba) . "}"."\n";   
        }

		//Buttons
		$primary_color = get_theme_mod('primary_color', '#fcd088');
		$buttons_type = get_theme_mod('buttons_type','bordered');
		if ($buttons_type != 'bordered') {
			$custom .= ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { color: #333;background-color:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= ".button:hover,input[type=\"button\"]:hover, input[type=\"reset\"]:hover, input[type=\"submit\"]:hover { background-color: transparent;color:" . esc_attr($primary_color) . ";}"."\n";	
		}

		//Button sizes
		$buttons_tb_padding = get_theme_mod( 'buttons_tb_padding','12' );
		$buttons_lr_padding = get_theme_mod( 'buttons_lr_padding','30' );
		$buttons_font_size 	= get_theme_mod( 'buttons_font_size','14' );
		$buttons_rad 		= get_theme_mod( 'buttons_radius','0' );
		$custom .= ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { padding-top:" . intval($buttons_tb_padding) . "px;padding-bottom:" . intval($buttons_tb_padding) . "px; }"."\n";
		$custom .= ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"]{ padding-left:" . intval($buttons_lr_padding) . "px;padding-right:" . intval($buttons_lr_padding) . "px; }"."\n";
		$custom .= ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-size:" . intval($buttons_font_size) . "px; }"."\n";
		$custom .= ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { border-radius:" . intval($buttons_rad) . "px; }"."\n";

		//Colors
		$ap_menu_items 			= get_theme_mod( 'ap_menu_items', '#ffffff' );
		$ap_submenu_items 		= get_theme_mod( 'ap_submenu_items', '#ffffff' );
		$ap_submenu_bg 			= get_theme_mod( 'ap_submenu_bg', '#1C1E21' );
		$ap_header_overlay 		= get_theme_mod( 'ap_header_overlay', '#252E35' );
		$header_overlay_rgba 	= astrid_child_hex2rgba($ap_header_overlay, 0.8);
		$ap_header_text 		= get_theme_mod( 'ap_header_text', '#ffffff' );
		$ap_footer_color 		= get_theme_mod( 'ap_footer_color', '#a3aaaa' );
		$ap_footer_wt_color 	= get_theme_mod( 'ap_footer_wt_color', '#ffffff' );
		$ap_row_overlay 		= get_theme_mod( 'ap_row_overlay', '#252E35' );
		$row_overlay_rgba 		= astrid_child_hex2rgba($ap_row_overlay, 0.8);
		$custom .= ".main-navigation ul li a { color:" . esc_attr($ap_menu_items) . "}"."\n";
		$custom .= ".main-navigation ul ul li a { color:" . esc_attr($ap_submenu_items) . "}"."\n";
		$custom .= ".main-navigation ul ul { background-color:" . esc_attr($ap_submenu_bg) . "}"."\n";
		$custom .= ".header-image::after { background-color:" . esc_attr($header_overlay_rgba) . "}"."\n";
		$custom .= ".header-text, .header-subtext { color:" . esc_attr($ap_header_text) . "}"."\n";
		$custom .= ".footer-widgets, .footer-info, .site-footer, .footer-widgets a, .footer-info a, .site-footer a { color:" . esc_attr($ap_footer_color) . "}"."\n";
		$custom .= ".footer-widgets .widget-title { color:" . esc_attr($ap_footer_wt_color) . "}"."\n";
		$custom .= ".row-overlay { background-color:" . esc_attr($row_overlay_rgba) . "}"."\n";

		//Single templates
		$ap_emp_fullwidth = get_theme_mod( 'ap_emp_fullwidth', '0' );
		if ($ap_emp_fullwidth == 1) {
			$custom .= ".page-template-single-employee .content-area { width:100%;}"."\n";
			$custom .= ".page-template-single-employee .widget-area { display:none;}"."\n";
		}
		$ap_emp_center = get_theme_mod( 'ap_emp_center', '0' );
		if ($ap_emp_center == 1) {
			$custom .= ".page-template-single-employee .content-area { text-align:center;}"."\n";
		}
		$ap_emp_sidebyside = get_theme_mod( 'ap_emp_sidebyside', '0' );
		if ($ap_emp_sidebyside == 1) {
			$custom .= "@media screen and (min-width:991px) { .page-template-single-employee .single-thumb { width:50%;float:left;padding-right:30px;} }"."\n";
			$custom .= "@media screen and (min-width:991px) { .page-template-single-employee .entry-content { width:50%;float:left;} }"."\n";
		}
        $ap_service_fullwidth = get_theme_mod( 'ap_service_fullwidth', '0' );
        if ($ap_service_fullwidth == 1) {
            $custom .= ".page-template-single-service .content-area { width:100%;}"."\n";
            $custom .= ".page-template-single-service .widget-area { display:none;}"."\n";
        }
        $ap_service_center = get_theme_mod( 'ap_service_center', '0' );
        if ($ap_service_center == 1) {
            $custom .= ".page-template-single-service .content-area { text-align:center;}"."\n";
        }
        $ap_service_sidebyside = get_theme_mod( 'ap_service_sidebyside', '0' );
        if ($ap_service_sidebyside == 1) {
            $custom .= "@media screen and (min-width:991px) { .page-template-single-service .single-thumb { width:50%;float:left;padding-right:30px;} }"."\n";
            $custom .= "@media screen and (min-width:991px) { .page-template-single-service .entry-content { width:50%;float:left;} }"."\n";
        }
        $ap_project_fullwidth = get_theme_mod( 'ap_project_fullwidth', '0' );
        if ($ap_project_fullwidth == 1) {
            $custom .= ".page-template-single-project .content-area { width:100%;}"."\n";
            $custom .= ".page-template-single-project .widget-area { display:none;}"."\n";
        }
        $ap_project_center = get_theme_mod( 'ap_project_center', '0' );
        if ($ap_project_center == 1) {
            $custom .= ".page-template-single-project .content-area { text-align:center;}"."\n";
        }
        $ap_project_sidebyside = get_theme_mod( 'ap_project_sidebyside', '0' );
        if ($ap_project_sidebyside == 1) {
            $custom .= "@media screen and (min-width:991px) { .page-template-single-project .single-thumb { width:50%;float:left;padding-right:30px;} }"."\n";
            $custom .= "@media screen and (min-width:991px) { .page-template-single-project .entry-content { width:50%;float:left;} }"."\n";
        }

	    global $post;
	    //Single styles
	    $single_body_background = get_post_meta( get_the_ID(), '_astrid_child_body_background_key', true );
	    $single_post_background = get_post_meta( get_the_ID(), '_astrid_child_post_background_key', true );
	    $single_text_color      = get_post_meta( get_the_ID(), '_astrid_child_text_color_key', true );
	    $hide_menu              = get_post_meta( get_the_ID(), '_astrid_child_hide_menu_key', true );
	    $hide_title             = get_post_meta( get_the_ID(), '_astrid_child_hide_title_key', true );
	    $hide_footer            = get_post_meta( get_the_ID(), '_astrid_child_hide_footer_key', true );

	    	if (is_single()) {
	       		$custom .= ".postid-" . $post->ID . " .site-content > .container { background-color:" . esc_attr($single_post_background) . " ;}"."\n";
	       		$custom .= ".postid-" . $post->ID . " .hentry { background-color:" . esc_attr($single_post_background) . " ;}"."\n";
	       		$custom .= ".postid-" . $post->ID . " .widget-area .widget { background-color:" . esc_attr($single_post_background) . " ;}"."\n";
	            $custom .= ".postid-" . $post->ID . " { color:" . esc_attr($single_text_color) . " ;}"."\n";   
	        } elseif (is_page()){
	       		$custom .= ".page-id-" . $post->ID . " .site-content > .container { background-color:" . esc_attr($single_post_background) . " ;}"."\n";
	       		$custom .= ".page-id-" . $post->ID . " .hentry { background-color:" . esc_attr($single_post_background) . " ;}"."\n";
	       		$custom .= ".page-id-" . $post->ID . " .widget-area .widget { background-color:" . esc_attr($single_post_background) . " ;}"."\n";
	            $custom .= ".page-id-" . $post->ID . " { color:" . esc_attr($single_text_color) . " ;}"."\n";    
	    	}
	    	if (is_single() && $single_body_background ) {
	       		$custom .= ".postid-" . $post->ID . " { background-color:" . esc_attr($single_body_background) . " !important; background-image: none !important;}"."\n";
	        } elseif (is_page() && $single_body_background ) {
	        	$custom .= ".page-id-" . $post->ID . " { background-color:" . esc_attr($single_body_background) . " !important; background-image: none !important;}"."\n";
	        }	    	

	        if ($hide_menu) {
	            if (is_single()) {
	                $custom .= ".postid-" . $post->ID . " .site-header,.header-clone { display: none;}"."\n";   
	            } elseif (is_page()){
	                $custom .= ".page-id-" . $post->ID . " .site-header,.header-clone { display: none;}"."\n";   
	            }            
	        }
	        if ($hide_title) {
	            if (is_single()) {
	                $custom .= ".postid-" . $post->ID . " .entry-header { display: none;}"."\n";   
	            } elseif (is_page()){
	                $custom .= ".page-id-" . $post->ID . " .entry-header { display: none;}"."\n";   
	            }            
	        }
	        if ($hide_footer) {
	            if (is_single()) {
	                $custom .= ".postid-" . $post->ID . " .footer-widgets,.postid-" . $post->ID . " .site-footer,.postid-" . $post->ID . " .footer-info { display: none;}"."\n";   
	            } elseif (is_page()){
	                $custom .= ".page-id-" . $post->ID . " .footer-widgets,.page-id-" . $post->ID . " .site-footer, .page-id-" . $post->ID . " .footer-info { display: none;}"."\n";   
	            }            
	        }



	wp_add_inline_style( 'astrid-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'astrid_child_custom_styles', 12 );