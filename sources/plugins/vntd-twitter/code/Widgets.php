<?php

add_action("widgets_init", "oauthtwitter_latesttweets_register");

function oauthtwitter_latesttweets_register() {
    register_widget( 'OAuthTwitter_LatestTweets' );  
}


class OAuthTwitter_LatestTweets extends WP_Widget
{
    function OAuthTwitter_LatestTweets()
    {
		$widget_ops = array( 'classname' => 'oauthtwitter-latesttweets', 'description' => 'Display the latest tweets for a given user' );
		$control_ops = array( 'id_base' => 'oauthtwitter-latesttweets' );
		$this->WP_Widget( 'oauthtwitter-latesttweets', 'Veented Twitter', $widget_ops, $control_ops );
    }
    
    
    function widget($args, $instance)
    {
		extract( $args );
		
		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$screen_name = $instance['screen_name'];
		$count = $instance['count'];
		$show_date = (isset($instance['showdate']) && $instance['showdate'] == true) ? true : false;

        require(dirname(__FILE__) . "/../template/oauthtwitter_latesttweets_widget.php");
    }
    
    function update($new_instance, $old_instance)
    {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['screen_name'] = strip_tags( $new_instance['screen_name'] );
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['showdate'] = isset($new_instance['showdate']) ? true : false;
		return $instance;
    }
    
    function form($instance)
    {
		//Set up some default widget settings.
		$defaults = array( 'title' => 'Latest Tweets', 'screen_name' => 'twitter', 'count' => 3);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	    $options = get_option("oauthtwitter");
	    if(!is_array($options))
	        $options = unserialize($options);
        $consumer_key = isset($options['consumer_key']) ? trim($options['consumer_key']) : "";
        $consumer_secret = isset($options['consumer_secret']) ? trim($options['consumer_secret']) : "";
        $access_token = isset($options['access_token']) ? trim($options['access_token']) : "";
        $access_secret = isset($options['access_secret']) ? trim($options['access_secret']) : "";
	
		require(dirname(__FILE__) . "/../template/oauthtwitter_latesttweets_form.php");
    }
}

?>
