<?php

if (!function_exists('essb_rs_css_popular_posts')) {
	function essb_rs_css_popular_posts() {
		$snippet = '';
		
		$snippet .= '.essb-popular-posts ul, .essb-popular-posts li, .essb-popular-posts ul li {list-style: none; margin: 0;}';
		$snippet .= '.widget_essb_popular_posts ul, .widget_essb_popular_posts li, .widget_essb_popular_posts ul li {list-style: none; margin: 0;}';
		$snippet .= '.essb-popular-posts li, .widget_essb_popular_posts li { padding-top: 4px; padding-bottom: 4px; }';
		$snippet .= '.essb-popular-posts a, .widget_essb_popular_posts a {
	font-weight: bold;
	text-decoration: none;	
}';
		$snippet .= '.essb-popular-posts .essb-widget-popular-posts-number, .widget_essb_popular_posts .essb-widget-popular-posts-number {
	font-size: 12px;
	font-weight: normal;
	display: block;
}';
		
		$snippet .= '.essb-popular-posts .essb-widget-popular-posts-number-text, .widget_essb_popular_posts .essb-widget-popular-posts-number-text { margin-left: 4px; text-transform: uppercase; }';
		
		$snippet .= '.essbasc-popup-content .essb-popular-posts ul { width: 100%; }';
		$snippet .= '.essbasc-popup-content .essb-popular-posts li { width: 45%; display: inline-block; margin-bottom: 15px; text-align: left; }';
		$snippet .= '.essbasc-popup-content .essb-popular-posts h3 { background: none; text-align: left; }';
		$snippet .= '.essbasc-popup-content .essb-popular-posts .entry-image { margin-bottom: 10px; }';
		
		return $snippet;
	}
}

if (! function_exists ( 'essb_popular_posts' )) {
	//add_shortcode ( 'easy-popular-posts', 'essb_popular_posts_code' );
	
	function essb_popular_posts_code($atts) {
		return essb_popular_posts($atts);
	}
	
	function essb_popular_posts($atts, $is_widget = false, $args = array()) {
		
		$attributes = shortcode_atts ( array (
				'title' => '', 
				'number' => '', 
				'show_num' => 'false', 
				'source' => '', 
				'show_num_text' => '',
				'same_cat' => 'false',
				'show_thumb' => 'false',
				'thumb_size' => '',
				'nothumb' => '',
				'date_range' => '',
				'only_pt' => '' 
				), $atts );
		
				
		$title = (! empty ( $attributes ['title'] )) ? $attributes ['title'] : '';
		$number = (! empty ( $attributes ['number'] )) ? absint ( $attributes ['number'] ) : 5;
		if (! $number)
			$number = 5;
		$show_num = isset ( $attributes ['show_num'] ) ? $attributes ['show_num'] : 'false';
		
		$source = (! empty ( $attributes ['source'] )) ? $attributes ['source'] : '';
		if (empty ( $source ))
			$source = 'shares';
		
		$show_num_text = (! empty ( $attributes ['show_num_text'] )) ? $attributes ['show_num_text'] : '';
		if (empty ( $show_num_text ))
			$show_num_text = 'shares';
		
		$same_cat = isset ( $attributes ['same_cat'] ) ? $attributes ['same_cat'] : 'false';
		if ($same_cat == 'yes') {
			$same_cat = 'true';
		}
		
		$show_thumb = isset($attributes['show_thumb']) ? $attributes ['show_thumb'] : 'false';
		$thumb_size = isset($attributes['thumb_size']) ? $attributes ['thumb_size'] : 'full';
		$nothumb = isset($attributes['nothumb']) ? $attributes['nothumb'] : '';
		$date_range = isset($attributes['date_range']) ? $attributes['date_range'] : '';
		$only_pt = isset($attributes['only_pt']) ? $attributes['only_pt'] : '';
		
		if ($nothumb == 'true') {
			$show_thumb = '';
		}
				
		$sort_meta = "";
		if ($source == "shares")
			$sort_meta = "essb_c_total";
		elseif ($source == "loves")
			$sort_meta = "_essb_love";
		elseif ($source == "views")
			$sort_meta = "essb_views";
		
		if ($same_cat == 'true') {
			global $post;
			
			$post_type = get_post_type($post->ID);
			$post_categories = get_the_category($post->ID);
			$post_category = '';
			if ($post_categories) {
				$post_category = $post_categories[0]->cat_ID;
			}
			
			$args_query = apply_filters( 'widget_posts_args', array(
					'posts_per_page'      => $number,
					'no_found_rows'       => true,
					'orderby' => 'meta_value_num',
					'meta_key' => $sort_meta,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'post_type' => $post_type,
					'cat' => $post_category
			) );
			
			if ($date_range != '') {
				$args_query['date_query'] = array(
						array(
								'after' => $date_range
						)
				);
			}
			
			$r = new WP_Query( $args_query );
		}
		else {
			
			$args_query =  apply_filters( 'widget_posts_args', array(
	  				'posts_per_page'      => $number,
	  				'no_found_rows'       => true,
	  				'orderby' => 'meta_value_num',
	  				'meta_key' => $sort_meta,
	  				'post_status'         => 'publish',
	  				'ignore_sticky_posts' => true,
	  				'post_type' => 'any'
	  		) );
			
			if ($date_range != '') {
				$args_query['date_query'] = array(
						array(
								'after' => $date_range
						)
				);
			}
			
			if ($only_pt != '') {
				$args_query['post_type'] = $only_pt;
			}
			
			
			$r = new WP_Query($args_query );
		}
		
		ob_start();
		
		if (!$is_widget) {
			$args = array();
			$args ['before_title'] = '<h3>';
			$args ['after_title'] = '</h3>';
			
			$args ['before_widget'] = '<div class="essb-popular-posts">';
			$args ['after_widget'] = '</div>';
		}
		if ($r->have_posts()) :			
  		?>
  				<?php echo $args['before_widget']; ?>
  				<?php if ( $title ) {
  					echo $args['before_title'] . $title . $args['after_title'];
  				} ?>
  				<ul>
  				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
  				
  					<?php 
  					
  					$post_number_value = get_post_meta(get_the_ID(), $sort_meta, true);
  					
  					$post_number_value = essb_kilomega($post_number_value);
  					
  					?>
  				
  					<li>
  					
  					<?php if (current_theme_supports('post-thumbnails') && $show_thumb && has_post_thumbnail()) : ?>
			              <div class="entry-image">
			                <a href="<?php the_permalink(); ?>" rel="bookmark">
			                  <?php the_post_thumbnail($thumb_size); ?>
			                </a>
			              </div>
		            <?php endif; ?>
  						<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?>
  					<?php if ( $show_num && $show_num == 'yes' ) : ?>
				<span class="essb-widget-popular-posts-number"><?php echo $post_number_value; ?><span class="essb-widget-popular-posts-number-text"><?php echo $show_num_text; ?></span></span>
  					<?php endif; ?>
  					</a>
  					</li>
  				<?php endwhile; ?>
  				</ul>
  				<?php echo $args['after_widget']; ?>
  				<?php
  				// Reset the global $the_post as this query will have stomped on it
  				wp_reset_postdata();
  				essb_resource_builder()->add_css(essb_rs_css_popular_posts(), 'essb-popular-posts-style', 'footer');
  				endif;
  				$html = ob_get_contents();
  				ob_end_clean();
  				
  				if (!$is_widget) {
  					return $html;
  				}
  				else {
  					print $html;
  				}
	}
}


class ESSBPopularPostsWidget extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array('classname' => 'widget_essb_popular_posts', 'description' => __( "Your site&#8217;s most popular posts.") );
		parent::__construct('essb-popular-posts', __('Easy Social Share Buttons: Popular Posts'), $widget_ops);
		$this->alt_option_name = 'widget_essb_popular_posts';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		
		essb_popular_posts($instance, true, $args);
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['source'] = sanitize_text_field( $new_instance['source'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_num'] = isset( $new_instance['show_num'] ) ? (bool) $new_instance['show_num'] : false;
		$instance['same_cat'] = isset( $new_instance['same_cat'] ) ? (bool) $new_instance['same_cat'] : false;
		$instance['show_num_text'] = sanitize_text_field( $new_instance['show_num_text'] );
		$instance['show_thumb'] = isset( $new_instance['show_thumb'] ) ? (bool) $new_instance['show_thumb'] : false;
		$instance['thumb_size'] = sanitize_text_field( $new_instance['thumb_size'] );
		$instance['date_range'] = sanitize_text_field( $new_instance['date_range'] );
		$instance['only_pt'] = sanitize_text_field( $new_instance['only_pt'] );
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		global $wp_post_types;
		
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_num = isset( $instance['show_num'] ) ? (bool) $instance['show_num'] : false;
		$same_cat = isset( $instance['same_cat'] ) ? (bool) $instance['same_cat'] : false;
		$source    = isset( $instance['source'] ) ? esc_attr( $instance['source'] ) : '';
		$show_num_text     = isset( $instance['show_num_text'] ) ? esc_attr( $instance['show_num_text'] ) : '';
		$show_thumb = isset( $instance['show_thumb'] ) ? (bool) $instance['show_thumb'] : false;
		$thumb_size    = isset( $instance['thumb_size'] ) ? esc_attr( $instance['thumb_size'] ) : '';
		$date_range    = isset( $instance['date_range'] ) ? esc_attr( $instance['date_range'] ) : '';
		$only_pt = isset($instance['only_pt']) ? esc_attr( $instance['only_pt'] ) : '';
		
		$date_ranges = array("" => __('Any time', 'essb'), '1 week ago' => __('Last 7 days', 'essb'), '2 weeks ago' => __('Last 14 days', 'essb'), '1 month ago' => __('Last month', 'essb'), '1 year ago' => __('Last year', 'essb'));		
		
		$sizes = get_intermediate_image_sizes();
		
		$pts	 = get_post_types( array('show_ui' => true, '_builtin' => true) );
		$cpts	 = get_post_types( array('show_ui' => true, '_builtin' => false) );
		$list_of_pts = array();
		$list_of_pts[""] = __('All', 'essb');
		foreach ( $pts as $pt ) { 
			$list_of_pts[$pt] = $wp_post_types [$pt]->label;
		}
		foreach ( $cpts as $pt ) {
			$list_of_pts[$pt] = $wp_post_types [$pt]->label;
		}
		
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_num ); ?> id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e( 'Display value for selected source?' ); ?></label></p>

		<p><label for="<?php echo $this->get_field_id( 'show_num_text' ); ?>"><?php _e( 'Display text after value:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_num_text' ); ?>" name="<?php echo $this->get_field_name( 'show_num_text' ); ?>" type="text" value="<?php echo $show_num_text; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'source' ); ?>"><?php _e( 'Display value from:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'source' ); ?>" name="<?php echo $this->get_field_name( 'source' ); ?>">
			<option value="shares" <?php if ($source == "shares") { echo "selected"; } ?>>Total number of shares (require cache counters to be active)</option>
			<option value="loves" <?php if ($source == "loves") { echo "selected"; } ?>>Total number of loves (data is generated from Love button)</option>
			<option value="views" <?php if ($source == "views") { echo "selected"; }?>>Number of views (require Post Views Add-on to be installed)</option>
		</select>
		</p>
		
		<p><input class="checkbox" type="checkbox"<?php checked( $same_cat ); ?> id="<?php echo $this->get_field_id( 'same_cat' ); ?>" name="<?php echo $this->get_field_name( 'same_cat' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'same_cat' ); ?>"><?php _e( 'Display posts from same category only?' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_thumb ); ?> id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php _e( 'Include featured image of post?', 'essb' ); ?></label></p>
		<p><label for="<?php echo $this->get_field_id( 'thumb_size' ); ?>"><?php _e( 'Featured image size:', 'essb' ); ?></label>
		<select id="<?php echo $this->get_field_id('thumb_size'); ?>" name="<?php echo $this->get_field_name('thumb_size'); ?>" class="widefat">
              <?php foreach ($sizes as $size) : ?>
                <option value="<?php echo $size; ?>"<?php if ($thumb_size == $size) echo ' selected'; ?>><?php echo $size; ?></option>
              <?php endforeach; ?>
              <option value="full"<?php if ($thumb_size == $size) echo ' selected'; ?>><?php _e('full'); ?></option>
            </select>
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'date_range' ); ?>"><?php _e( 'Date range filter:', 'essb' ); ?></label>
		<select id="<?php echo $this->get_field_id('date_range'); ?>" name="<?php echo $this->get_field_name('date_range'); ?>" class="widefat">
              <?php foreach ($date_ranges as $size => $name) : ?>
                <option value="<?php echo $size; ?>"<?php if ($date_range == $size) echo ' selected'; ?>><?php echo $name; ?></option>
              <?php endforeach; ?>
            </select>
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'only_pt' ); ?>"><?php _e( 'Display Post Types:', 'essb' ); ?></label>
		<select id="<?php echo $this->get_field_id('only_pt'); ?>" name="<?php echo $this->get_field_name('only_pt'); ?>" class="widefat">
              <?php foreach ($list_of_pts as $pt => $name) : ?>
                <option value="<?php echo $pt; ?>"<?php if ($only_pt == $pt) echo ' selected'; ?>><?php echo $name; ?></option>
              <?php endforeach; ?>
            </select>
		</p>
		
		
		<?php
	}
}

  function init_wp_widget_essb_popular_posts() {
    register_widget( 'ESSBPopularPostsWidget' );
    
  }

  add_action( 'widgets_init', 'init_wp_widget_essb_popular_posts' );