<?php
/**
 * Clients widget
 *
 * @package Astrid-Child
 */

class Atframework_Map extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'atframework_fp_map_widget', 'description' => __( 'Displays a Google Map and supports Contact Form 7', 'astrid') );
        parent::__construct(false, $name = __('Astrid Child: Contact', 'astrid'), $widget_ops);
		$this->alt_option_name = 'atframework_fp_map_widget';
			
		add_action('wp_footer',array(&$this,'load_map_api'));
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$address  		= isset( $instance['address'] ) ? esc_html( $instance['address'] ) : 'New York';
		$cf7  			= isset( $instance['cf7'] ) ? esc_html( $instance['cf7'] ) : '';
		$icon			= isset( $instance['icon'] ) ? esc_html( $instance['icon'] ) : 'https://www.google.com/mapfiles/marker.png';

	?>

	<p><em>Make sure you go to Customize > Google Maps and add your Google Maps API key</em></p>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
    <p><label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Your address for the map', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo $address; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('cf7'); ?>"><?php _e('Your Contact Form 7 ID (the number, not the whole shortcode)', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'cf7' ); ?>" name="<?php echo $this->get_field_name( 'cf7' ); ?>" type="text" value="<?php echo $cf7; ?>" size="3" /></p>
	<p><em>If you need a template for the contact form you can use the one from our demo page. Get it <a target="_blank" href="http://pastebin.com/76FqE10i">here</a>.</em></p>
	<p>
	<label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon URL (only if you want to change the default icon [50 x 50px])', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" type="text" value="<?php echo $icon; ?>" />
	</p>

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['address'] 	= strip_tags($new_instance['address']);		
		$instance['cf7'] 		= strip_tags($new_instance['cf7']);
		$instance['icon'] 		= esc_url_raw($new_instance['icon']);

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['atframework_map']) )
			delete_option('atframework_map');		  
		  
		return $instance;
	}
	
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'atframework_map', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$address 		= isset( $instance['address'] ) ? esc_html($instance['address']) : 'New York';		
		$cf7 			= isset( $instance['cf7'] ) ? esc_html($instance['cf7']) : '';	
		$icon			= isset( $instance['icon'] ) ? esc_html($instance['icon']) : 'https://www.google.com/mapfiles/marker.png';	

		echo $args['before_widget'];
?>

	<div class="astrid-contact-map">
		<div class="map-contact" data-address="<?php echo $address; ?>" data-icon="<?php echo $icon; ?>"></div>
		<?php if ($cf7) : ?>
		<div class="map-contact-overlay row-overlay"></div>
		<div class="toggle-map"><i class="fa fa-map-o"></i></div>
		<div class="contact-data"><?php echo do_shortcode('[contact-form-7 id="' . $cf7 . '"]'); ?></div>
		<?php endif; ?>
	</div>

<?php 
		echo $args['after_widget'];

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'atframework_map', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	function load_map_api() {

		$api_key 	= get_theme_mod('astrid_child_maps_api');
		$disable_api = get_theme_mod('astrid_child_disable_api');

		if ( $disable_api ) {
			return;
		}

		if ( $api_key ) {
			echo '<script src="//maps.googleapis.com/maps/api/js?key=' . $api_key . '" type="text/javascript"></script>';
		} else {
			echo '<script src="//maps.googleapis.com/maps/api/js" type="text/javascript"></script>';
		}
	}

}