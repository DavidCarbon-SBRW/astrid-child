<?php
/**
 * Pricing tables widget
 *
 * @package Astrid-Child
 */

class Atframework_Pricing extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'atframework_pricing_widget', 'description' => __( 'Show what pricing you are able to provide.', 'astrid') );
        parent::__construct(false, $name = __('Astrid Child: Pricing Tables', 'astrid'), $widget_ops);
		$this->alt_option_name = 'atframework_pricing_widget';
			
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
		$offset    		= isset( $instance['offset'] ) ? intval( $instance['offset'] ) : 0;
		$see_all   		= isset( $instance['see_all'] ) ? esc_url_raw( $instance['see_all'] ) : '';		
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';
	?>

	<p><?php _e('This widget displays all pages that have the Single Pricing Table page template assigned to them.', 'astrid'); ?></p>
	<p><em><?php _e('Tip: to rearrange the pricing order, edit each pricing page and add a value in Page Attributes > Order', 'astrid'); ?></em></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of pricing tables to show (-1 shows all of them):', 'astrid' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Offset (number of pricing tables needs to be different than -1 for this option to work):', 'astrid' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo $offset; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('The URL for your button [In case you want a button below your pricing block]', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our plans</em> if left empty]', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>	
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['number'] 		= strip_tags($new_instance['number']);
		$instance['offset'] 		= strip_tags($new_instance['offset']);
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	
		$instance['see_all_text'] 	= strip_tags($new_instance['see_all_text']);		
		    			
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['atframework_pricing']) )
			delete_option('atframework_pricing');		  
		  
		return $instance;
	}
	
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'atframework_pricing', 'widget' );
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
		$see_all 		= isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';
		$see_all_text 	= isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : '';		
		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
		if ( ! $number )
			$number 	= -1;				
		$offset 		= ( ! empty( $instance['offset'] ) ) ? intval( $instance['offset'] ) : 0;


		$pricing = new WP_Query( array(
			'post_type'			=> 'page',
			'no_found_rows' 	=> true,
			'post_status'   	=> 'publish',
			'orderby' 			=> 'menu_order',
			'order'   			=> 'ASC',
			'posts_per_page' 	=> $number,
			'offset'			=> $offset,
	        'meta_query' => array(
	            array(
	                'key' => '_wp_page_template',
	                'value' => 'single-pricing.php',
	            )
	        )			
		) );

		echo $args['before_widget'];

		if ($pricing->have_posts()) :
?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>

				<div class="plan-area clearfix">
					<?php while ( $pricing->have_posts() ) : $pricing->the_post(); ?>

						<?php global $post; ?>
						<?php $features = get_post_meta($post->ID, '_astrid_child_pricing_key', true); ?>
						<?php $price = get_post_meta( $post->ID, '_astrid_child_pricing_price_key', true ); ?>
						<?php $text = get_post_meta( $post->ID, '_astrid_child_pricing_text_key', true ); ?>
						<?php $link = get_post_meta( $post->ID, '_astrid_child_pricing_link_key', true );	?>					
						<?php $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>


						<div class="pricing-table astrid-3col">
							<div class="plan-header" style="background-image:url(<?php echo $image; ?>);background-size:cover;">
								<h3 class="plan-title"><?php the_title(); ?></h3>

								<?php if ( $price ) : ?>
									<span class="plan-price"><?php echo esc_html($price); ?></span>
								<?php endif; ?>

								<?php echo the_content(); ?>
							</div>

							<div class="plan-features">
							<?php foreach ( $features as $feature ) : ?>
								<div class="table-feature"><?php echo esc_html($feature['name']); ?></div>
							<?php endforeach; ?>

							<?php if ( $link ) : ?>
							<div class="plan-buy"><a class="button" href="<?php echo esc_url($link); ?>"><?php echo esc_html($text); ?></a></div>
							<?php endif; ?>

							</div>

						</div>
					<?php endwhile; ?>
				</div>

				<?php if ($see_all != '') : ?>
					<a href="<?php echo esc_url($see_all); ?>" class="button centered-button">
						<?php if ($see_all_text) : ?>
							<?php echo $see_all_text; ?>
						<?php else : ?>
							<?php echo __('See all our plans', 'astrid'); ?>
						<?php endif; ?>
					</a>
				<?php endif; ?>				
	<?php
		wp_reset_postdata();
		endif;
		echo $args['after_widget'];

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'atframework_pricing', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}