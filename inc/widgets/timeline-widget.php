<?php
/**
 * Timeline widget
 *
 * @package Astrid-Child
 */

class Atframework_Timeline extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'atframework_timeline_widget', 'description' => __( 'Show your timeline.', 'astrid') );
        parent::__construct(false, $name = __('Astrid Child: Timeline', 'astrid'), $widget_ops);
		$this->alt_option_name = 'atframework_timeline_widget';
			
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
		$offset    		= isset( $instance['offset'] ) ? intval( $instance['offset'] ) : 0;
		$see_all   		= isset( $instance['see_all'] ) ? esc_url_raw( $instance['see_all'] ) : '';		
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';
	?>

	<p><?php _e('This widget displays 5 pages that have the Single Timeline Event page template assigned to them.', 'astrid'); ?></p>
	<p><em><?php _e('Tip: to rearrange the timeline order, edit each event page and add a value in Page Attributes > Order', 'astrid'); ?></em></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Offset:', 'astrid' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo $offset; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('The URL for your button [In case you want a button below your timeline block]', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See our whole timeline</em> if left empty]', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>	
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['offset'] 		= strip_tags($new_instance['offset']);
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	
		$instance['see_all_text'] 	= strip_tags($new_instance['see_all_text']);		
		    			
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['atframework_timeline']) )
			delete_option('atframework_timeline');		  
		  
		return $instance;
	}
	
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'atframework_timeline', 'widget' );
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
		$offset 		= ( ! empty( $instance['offset'] ) ) ? intval( $instance['offset'] ) : 0;


		$timeline = new WP_Query( array(
			'post_type'			=> 'page',
			'no_found_rows' 	=> true,
			'post_status'   	=> 'publish',
			'orderby' 			=> 'menu_order',
			'order'   			=> 'ASC',
			'posts_per_page' 	=> 5,
			'offset'			=> $offset,
	        'meta_query' => array(
	            array(
	                'key' => '_wp_page_template',
	                'value' => 'single-event.php',
	            )
	        )			
		) );

		echo $args['before_widget'];

		if ($timeline->have_posts()) :
?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>

				<div class="timeline-area clearfix">
					<?php while ( $timeline->have_posts() ) : $timeline->the_post(); ?>
						<?php global $post; ?>
						<?php $timeline_date = get_post_meta( $post->ID, '_astrid_child_timeline_key', true ); ?>
						<div class="t-event">
							<?php if ( has_post_thumbnail() ) : ?>
							<div class="service-thumb">
								<?php the_post_thumbnail('astrid-small-thumb'); ?>
							</div>
							<?php endif; ?>
							<?php if ($timeline_date) : ?>
							<span class="event-date-deco"></span>
							<div class="event-date"><?php echo esc_html($timeline_date); ?></div>
							<?php endif; ?>
							<div class="service-content">
								<h3 class="service-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php echo apply_filters( 'astrid_child_timeline_content', wp_trim_words( get_the_content(), 10 ) ); ?>
							</div>
							<span class="event-deco"></span>
						</div>
					<?php endwhile; ?>
				</div>

				<?php if ($see_all != '') : ?>
					<a href="<?php echo esc_url($see_all); ?>" class="button centered-button">
						<?php if ($see_all_text) : ?>
							<?php echo $see_all_text; ?>
						<?php else : ?>
							<?php echo __('See our whole timeline', 'astrid'); ?>
						<?php endif; ?>
					</a>
				<?php endif; ?>				
	<?php
		wp_reset_postdata();
		endif;
		echo $args['after_widget'];

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'atframework_timeline', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}