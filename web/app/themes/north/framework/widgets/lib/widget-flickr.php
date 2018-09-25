<?php

/*

Plugin Name: Flickr
Plugin URI: http://themeforest.net/user/Tauris/
Description: Display images from Flickr.
Version: 1.0
Author: Tauris
Author URI: http://themeforest.net/user/Tauris/

*/


/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'vntd_widget_flickr' );

/* Function that registers our widget. */
function vntd_widget_flickr()
{
	register_widget( 'Vntd_Widget_Flickr' );
}

// Widget class.
class Vntd_Widget_Flickr extends WP_Widget
{
	
	
	function __construct()
	{
		/* Widget settings. */
		$widget_ops = array(
			 'classname' => 'pr_widget_flickr',
			'description' => 'Display a selected number of Flickr images.' 
		);
		
		/* Create the widget. */
		//$this->WP_Widget( 'vntd_widget_flickr', 'Veented Flickr', $widget_ops );
		
		parent::__construct( 'vntd_widget_flickr', 'Veented Flickr', $widget_ops );
	}
	
	
	function widget( $args, $instance )
	{
		extract( $args );
		
		/* User-selected settings. */
		$title   = apply_filters( 'widget_title', $instance['title'] );
		$userid  = $instance['userid'];
		$display = $instance['display'];
		$number  = $instance['number'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		/* Display name from widget settings. */
?>
        
        <div class="flickr-badge">
        	<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php
		echo $number;
?>&amp;display=<?php
		echo $display;
?>&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php
		echo $userid;
?>"></script>
        </div> 
                 
                        
        <?php
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['userid']  = strip_tags( $new_instance['userid'] );
		$instance['display'] = strip_tags( $new_instance['display'] );
		$instance['number']  = strip_tags( $new_instance['number'] );
		
		return $instance;
	}
	
	
	function form( $instance )
	{
		
		/* Set up some default widget settings. */
		$defaults = array(
			 'title' => 'Flickr',
			'userid' => '10133335@N08',
			'display' => 'latest',
			'number' => '8' 
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
        
    	<p>
		<label for="<?php
		echo $this->get_field_id( 'title' );
?>">Title:</label>
		<input id="<?php
		echo $this->get_field_id( 'title' );
?>" name="<?php
		echo $this->get_field_name( 'title' );
?>" type="text" value="<?php
		echo $instance['title'];
?>" style="width:100%;" />
		</p>  
        
        <p>
        <label for="<?php
		echo $this->get_field_id( 'userid' );
?>">Flickr User ID:</label>
		<input id="<?php
		echo $this->get_field_id( 'userid' );
?>" name="<?php
		echo $this->get_field_name( 'userid' );
?>" type="text" value="<?php
		echo $instance['userid'];
?>" style="width:100%;" />
        </p> 
        
        <p>
        <label for="<?php
		echo $this->get_field_id( 'display' );
?>">Display type:</label>
        <select id="<?php
		echo $this->get_field_id( 'display' );
?>" name="<?php
		echo $this->get_field_name( 'display' );
?>">
            <option <?php
		if ( $instance['display'] == "Latest" )
			echo 'selected="selected"';
?>>Latest</option>
            <option <?php
		if ( $instance['display'] == "Random" )
			echo 'selected="selected"';
?>>Random</option>
		</select>
        </p>
        
        <p>
        <label for="<?php
		echo $this->get_field_id( 'number' );
?>">Number of images:</label>
		<input id="<?php
		echo $this->get_field_id( 'number' );
?>" name="<?php
		echo $this->get_field_name( 'number' );
?>" type="text" value="<?php
		echo $instance['number'];
?>" size="3" />
        </p>
        
        
        <?php
	}
}

