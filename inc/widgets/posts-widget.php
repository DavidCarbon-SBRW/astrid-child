<?php
/**
 * Posts widget
 *
 * @package Astrid-Child
 */

class Atframework_Posts_Carousel extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'atframework_posts_carousel_widget', 'description' => __( 'Show the latest news in a carousel.', 'astrid') );
        parent::__construct(false, $name = __('Astrid Child: Latest News Carousel', 'astrid'), $widget_ops);
		$this->alt_option_name = 'atframework_posts_carousel_widget';
		
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$category  		= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : 4;
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';											
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of employees to show (-1 shows all of them):', 'astrid' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show posts from all categories.', 'astrid' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>	

    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('Add the text for the button here if you want to change the default <em>See all our news</em>', 'astrid'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>		

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['number'] 		= strip_tags($new_instance['number']);
		$instance['category'] 		= strip_tags($new_instance['category']);
		$instance['see_all_text'] 	= strip_tags($new_instance['see_all_text']);						

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['atframework_posts_carousel']) )
			delete_option('atframework_posts_carousel');		  
		  
		return $instance;
	}
		
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'atframework_posts_carousel', 'widget' );
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$category = isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		$see_all_text = isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : __( 'See all our news', 'astrid' );
		if ($see_all_text == '') {
			$see_all_text = __( 'See all our news', 'astrid' );
		}
		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : 4;
		if ( ! $number )
			$number 	= 4;

		$r = new WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page'	  => $number,
			'category_name'		  => $category
		) );

		echo $args['before_widget'];

		if ($r->have_posts()) :
?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<div class="ap-carousel">
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<div class="blog-post">
				<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('astrid-small-thumb'); ?>
					</a>			
				</div>	
				<?php endif; ?>							
				<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
				<div class="entry-meta">
					<?php astrid_posted_on(); ?>
				</div>	
				<div class="entry-summary"><?php the_excerpt(); ?></div>
			</div>
		<?php endwhile; ?>
		</div>

		<?php $cat = get_term_by('slug', $category, 'category') ?>
		<?php if ($category) : //Link to the category page instead of blog page if a category is selected ?>
			<a href="<?php echo esc_url(get_category_link(get_cat_ID($cat -> name))); ?>" class="button centered-button"><?php echo $see_all_text; ?></a>
		<?php else : ?>
			<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="button centered-button"><?php echo $see_all_text; ?></a>
		<?php endif; ?>		
	<?php
		echo $args['after_widget'];
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'atframework_posts_carousel', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}