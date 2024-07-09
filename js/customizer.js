/**
 * Theme Customizer enhancements for a better user experience.
 */

( function( $ ) {

	wp.customize( 'footer_credits', function( value ) {
		value.bind( function( to ) {
			$( '.site-copyright' ).text( to );
		} );
	} );

	wp.customize( 'buttons_tb_padding', function( value ) {
		value.bind( function( to ) {
			$( '.button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"]' ).css({'padding-top': to + 'px', 'padding-bottom': to + 'px'});
		} );
	} );

	wp.customize( 'buttons_lr_padding', function( value ) {
		value.bind( function( to ) {
			$( '.button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"]' ).css({'padding-left': to + 'px', 'padding-right': to + 'px'});
		} );
	} );

	wp.customize( 'buttons_font_size', function( value ) {
		value.bind( function( to ) {
			$( '.button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"]' ).css('font-size', to + 'px');
		} );
	} );

	wp.customize( 'buttons_radius', function( value ) {
		value.bind( function( to ) {
			$( '.button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"]' ).css('border-radius', to + 'px');
		} );
	} );	

	wp.customize( 'ap_submenu_bg', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation ul ul' ).css('background-color', to);
		} );
	} );

	wp.customize( 'ap_header_text', function( value ) {
		value.bind( function( to ) {
			$( '.header-text, .header-subtext' ).css('color', to);
		} );
	} );	

	wp.customize( 'ap_footer_color', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widgets, .footer-info, .site-footer, .footer-widgets a, .footer-info a, .site-footer a' ).css('color', to);
		} );
	} );

	wp.customize( 'ap_footer_wt_color', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widgets .widget-title' ).css('color', to);
		} );
	} );

	wp.customize( 'ap_emp_fullwidth', function( value ) {
		value.bind( function( to ) {
			if (to != '0') {
				$( '.page-template-single-employee .content-area' ).css('width', '100%');
				$( '.page-template-single-employee .widget-area' ).css('display', 'none');			
			} else {
				$( '.page-template-single-employee .content-area' ).css('width', '811px');
				$( '.page-template-single-employee .widget-area' ).css('display', 'block');				
			}	
		} );
	} );	

	wp.customize( 'ap_emp_center', function( value ) {
		value.bind( function( to ) {
			if (to != '0') {
				$( '.page-template-single-employee .content-area' ).css('text-align', 'center');
			} else {
				$( '.page-template-single-employee .content-area' ).css('text-align', 'left');
			}	
		} );
	} );			

	wp.customize( 'ap_emp_sidebyside', function( value ) {
		value.bind( function( to ) {
			if (to != '0') {
				$( '.page-template-single-employee .single-thumb' ).css({'width': '50%', 'float': 'left', 'padding-right': '30px'});
				$( '.page-template-single-employee .entry-content' ).css({'width': '50%', 'float': 'left'});
			} else {
				$( '.page-template-single-employee .single-thumb' ).css({'width': '100%', 'float': 'none', 'padding-right': '0'});
				$( '.page-template-single-employee .entry-content' ).css({'width': '100%', 'float': 'none'});
			}	
		} );
	} );		
    wp.customize( 'ap_service_fullwidth', function( value ) {
        value.bind( function( to ) {
            if (to != '0') {
                $( '.page-template-single-service .content-area' ).css('width', '100%');
                $( '.page-template-single-service .widget-area' ).css('display', 'none');          
            } else {
                $( '.page-template-single-service .content-area' ).css('width', '811px');
                $( '.page-template-single-service .widget-area' ).css('display', 'block');             
            }   
        } );
    } );    

    wp.customize( 'ap_service_center', function( value ) {
        value.bind( function( to ) {
            if (to != '0') {
                $( '.page-template-single-service .content-area' ).css('text-align', 'center');
            } else {
                $( '.page-template-single-service .content-area' ).css('text-align', 'left');
            }   
        } );
    } );            

    wp.customize( 'ap_service_sidebyside', function( value ) {
        value.bind( function( to ) {
            if (to != '0') {
                $( '.page-template-single-service .single-thumb' ).css({'width': '50%', 'float': 'left', 'padding-right': '30px'});
                $( '.page-template-single-service .entry-content' ).css({'width': '50%', 'float': 'left'});
            } else {
                $( '.page-template-single-service .single-thumb' ).css({'width': '100%', 'float': 'none', 'padding-right': '0'});
                $( '.page-template-single-service .entry-content' ).css({'width': '100%', 'float': 'none'});
            }   
        } );
    } ); 
    wp.customize( 'ap_project_fullwidth', function( value ) {
        value.bind( function( to ) {
            if (to != '0') {
                $( '.page-template-single-project .content-area' ).css('width', '100%');
                $( '.page-template-single-project .widget-area' ).css('display', 'none');          
            } else {
                $( '.page-template-single-project .content-area' ).css('width', '811px');
                $( '.page-template-single-project .widget-area' ).css('display', 'block');             
            }   
        } );
    } );    

    wp.customize( 'ap_project_center', function( value ) {
        value.bind( function( to ) {
            if (to != '0') {
                $( '.page-template-single-project .content-area' ).css('text-align', 'center');
            } else {
                $( '.page-template-single-project .content-area' ).css('text-align', 'left');
            }   
        } );
    } );            

    wp.customize( 'ap_project_sidebyside', function( value ) {
        value.bind( function( to ) {
            if (to != '0') {
                $( '.page-template-single-project .single-thumb' ).css({'width': '50%', 'float': 'left', 'padding-right': '30px'});
                $( '.page-template-single-project .entry-content' ).css({'width': '50%', 'float': 'left'});
            } else {
                $( '.page-template-single-project .single-thumb' ).css({'width': '100%', 'float': 'none', 'padding-right': '0'});
                $( '.page-template-single-project .entry-content' ).css({'width': '100%', 'float': 'none'});
            }   
        } );
    } );        


    
} )( jQuery );
