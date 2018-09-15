<?php
/*
Plugin Name: Veented Twitter
Description: Integrate Wordpress with Twitter API (v1 & v1.1)
Version: 1.1.0
Author: Michael Strong
Changes: Veented
*/


if(session_id() == "" && !headers_sent())
    session_start();
    
// Include Twitter library
require_once("PHPTwitter/Twitter.php");

// Enable widgets
require_once("code/Widgets.php");

// Add plugin options
add_option("oauthtwitter", array(
    "consumer_key" => "",
    "consumer_secret" => "",
    "access_token" => "",
    "access_secret" => ""
));

// Register the new admin menu
//add_action('admin_init', 'oauthtwitter_init' );
add_action("admin_menu", "oauthtwitter_menu");

// Add admin menu
function oauthtwitter_menu() {
    add_options_page("Twitter Settings", "Twitter", "manage_options", "oauthtwitter", "oauthtwitter_options");
    
    $page = isset($_GET['page']) ? $_GET['page'] : null;
    if($page == "oauthtwitter") {
        wp_register_style('admincss', plugins_url('css/admin.css', __FILE__));
        wp_enqueue_style('admincss');
    }
}


// Add oauth twitter options
function oauthtwitter_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	
	// Deal with form submission/authentication
	$success = false;
	$errors = array();
	$submission = oauthtwitter_form_submit();
	if($submission) {
	    if(isset($submission['Success']))
	        $success = 'Access tokens updated.';
	}
	
	// Extract options to variables
	$options = get_option("oauthtwitter");
	if(!is_array($options))
	    $options = unserialize($options);
    
    $consumer_key = isset($options['consumer_key']) ? trim($options['consumer_key']) : "";
    $consumer_secret = isset($options['consumer_secret']) ? trim($options['consumer_secret']) : "";
    $access_token = isset($options['access_token']) ? trim($options['access_token']) : "";
    $access_secret = isset($options['access_secret']) ? trim($options['access_secret']) : "";
    $loginURL = false;
		
	$twitter = new Twitter($consumer_key, $consumer_secret, $access_token, $access_secret);

    if($access_token == "" || $access_secret == "") {
            
        if(isset($_SESSION['oauthtwitter_request'])) {
            $twitter->setRequest(unserialize($_SESSION['oauthtwitter_request']));
            unset($_SESSION['oauthtwitter_request']);
        }
    
	    if(!$twitter->hasAccess()) {
            // Attempt to get access
            if($access = $twitter->getAccessToken()) {
                // Update the access tokens.
                $access_token = $access->token;
                $access_secret = $access->secret;


                $update = update_option("oauthtwitter", serialize(array(
                    "consumer_key" => $consumer_key,
                    "consumer_secret" => $consumer_secret,
                    "access_token" => $access_token,
                    "access_secret" => $access_secret
                )));

                // Set the new access token.
                $twitter->setAccess(new OAuthToken($access_token, $access_secret));
                
                // Check to see if we've updated.
                if($update)
                    $success = 'Your Twitter account has been connected.';
                else
                    $errors[] = 'Unable to connect your twitter account.';
                    
            } else if($request = $twitter->getRequestToken()) {
                $_SESSION['oauthtwitter_request'] = serialize($request);
                // Set the login URL
	            $loginURL = $twitter->getLoginURL();
            }
            
	    }
    }
    
    // Render the form.
    include ("template/oauthtwitter_form.php");
}


// Deal with the form submission
function oauthtwitter_form_submit() {
    if(isset($_POST['submitted'])) {
        unset($_POST['submitted']);
        $data = array (
            "consumer_key" => isset($_POST['consumer_key']) ? $_POST['consumer_key'] : "",
            "consumer_secret" => isset($_POST['consumer_secret']) ? $_POST['consumer_secret'] : "",
            "access_token" => isset($_POST['access_token']) ? $_POST['access_token'] : "",
            "access_secret" => isset($_POST['access_secret']) ? $_POST['access_secret'] : ""
        );
        update_option("oauthtwitter", serialize($data));
        array("Success" => true);
    }
    return false;
}


/**
 * Shortcodes
**/

if(class_exists('Vc_Manager')) {

	wpb_map( array(
	   "name" => __("Twitter Feed", "veented_backed"),
	   "base" => "vntd_twitter",
	   "icon" => "fa-twitter",
	   "class" => "font-awesome",
	   "category" => array("Carousels"),
	   "description" => "Display latest tweets",
	   "params" => array(  
			array(	      
			 "type" => "textfield",
			 "class" => "hidden-label",
			 "heading" => __("Twitter Account ID", "veented_backed"),
			 "param_name" => "account_id",
			 "value" => "envato"
			),
			array(	      
			 "type" => "textfield",
			 "class" => "hidden-label",
			 "heading" => __("Number of tweets to show", "veented_backed"),
			 "param_name" => "count",
			 "value" => "5"
			)
	   )
	));
}


// Twitter feed shortcode.
function vntd_twitter($atts, $content = null)
{
	extract(shortcode_atts(array(
		"count" => 4,
		"account_id" => '',
		"style" => 'simple'
	), $atts));
        
    $data = unserialize(get_option("oauthtwitter"));
    if(isset($data['consumer_key'], $data['consumer_secret'], $data['access_token'], $data['access_secret'])) {
        $twitter = new Twitter(trim($data['consumer_key']), trim($data['consumer_secret']), trim($data['access_token']), trim($data['access_secret']));
        if($twitter->hasAccess()) {
            $default_count = 1;
            
            // Short code attributes
            $count = (isset($atts['count']) && is_numeric($atts['count'])) ? (int) $atts['count'] : $default_count;
            $class = (isset($atts['class'])) ? htmlentities($atts['class'], ENT_QUOTES, "UTF-8") : "oauthtwitter_twitterfeed";
            $id = (isset($atts['account_id'])) ? htmlentities($atts['account_id'], ENT_QUOTES, "UTF-8") : "";
            $showdate = (isset($atts['showdate']) && $atts['showdate'] != "false" && $atts['showdate'] != "0") ? $atts['showdate'] : false;
            
            $result = $twitter->api("1.1/statuses/user_timeline.json", "GET", array(
                "screen_name" => $id,
                "count" => ($count > 0) ? $count : $default_count
            ));
            
            $return = "";
            if($result->statusCode() == 200) {
                $tweets = json_decode($result->body(), true);
                if(count($tweets) > 0) {
                
                    $classNames = explode(" ", $class);
                    if(in_array("oauthtwitter_twitterfeed", $classNames)) {
                        wp_register_style('shortcodes', plugins_url('css/shortcodes.css', __FILE__));
                        wp_enqueue_style('shortcodes');
                    }

                    ob_start();		
                    
                    ?>
                    
                    <div class="vntd-twitter-feed vntd-testimonial-carousel">
                    
                    	<div class="testimonials t-center">
                    
                    	<a class="t-arrow"></a>
                    
                    <?php
                    				 			
                    wp_reset_postdata();
                    
                    $args = array(
                    	'posts_per_page' => $posts_nr,
                    	'post_type' => 'testimonials'
                    );
                    $the_query = new WP_Query($args); 	
                    
	                $i = 0;    
	                    
	                foreach($tweets as $tweet) {
                        if($i == count($tweets)) $class .= ' last';
                        if((bool) ($i == 1)) $class .= ' first';
                        
                        if($i == 0) {
                        	?>
                        	<a href="http://www.twitter.com/<?php echo rawurlencode($tweet['user']['screen_name']); ?>" target="_blank" class="quote white twitter-feed-icon">			
                        		<i class="fa fa-twitter"></i>
                        	</a>	
                        	
                        	<ul class="text-slider clearfix">
                        	<?php
                        }
                        $i++;
                        
                        // Parse tweet links, users and hashtags.
                        $parsed = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" target=\"_blank\">\\2</a>'", $tweet['text']);
                        $parsed = preg_replace("#(^|[\n ])@([A-Za-z0-9\_]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" target=\"_blank\">@\\2</a>'", $parsed);
                        $parsed = preg_replace("#(^|[\n ])\#([A-Za-z0-9]*)#ise", "'\\1<a href=\"http://www.twitter.com/search?q=\\2\" target=\"_blank\">#\\2</a>'", $parsed);
                        
                        echo '<li class="text normal"><h1 class="white">'.$parsed.'</h1>';
                        echo '<p class="author uppercase">'.$tweet['user']['screen_name'].' '.human_time_diff(strtotime($tweet['created_at'])) .' '.__('ago','vntd_north').'</p></li>';
                    }
                    
                    
                    //endwhile; endif; wp_reset_postdata();
                    
                    echo '</ul></div>';
                    		
                    echo '</div>';
                    
                    $return = ob_get_contents();
                    ob_end_clean();
                    
                }
            }
            return $return;
        }
    }
}

remove_shortcode('vntd_twitter');
add_shortcode('vntd_twitter', 'vntd_twitter');

?>
