<?php

$data = unserialize(get_option("oauthtwitter"));
$consumer_key = trim($data['consumer_key']);
$consumer_secret = trim($data['consumer_secret']);
$access_token = trim($data['access_token']);
$access_secret = trim($data['access_secret']);

if($consumer_key && $consumer_secret && $access_token && $access_secret) {

    require_once(dirname(__FILE__)."/../PHPTwitter/Twitter.php");
    $twitter = new Twitter($consumer_key, $consumer_secret, $access_token, $access_secret);

    if($twitter->hasAccess()) {

        $result = $twitter->api("1.1/statuses/user_timeline.json", "GET", array(
            "screen_name" => $instance['screen_name'],
            "count" => $instance['count']
        ));
                
        if($result->statusCode() == 200) {
            $tweets = json_decode($result->body(), true);
            if(count($tweets) > 0) {
                echo $before_widget;
                echo $before_title . $title . $after_title;
                echo '<ul class="tweet">';
                foreach($tweets as $tweet) {
                
                    // Parse tweet links, users and hashtags.
                    $parsed = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" target=\"_blank\">\\2</a>'", $tweet['text']);
                    $parsed = preg_replace("#(^|[\n ])@([A-Za-z0-9\_]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" target=\"_blank\">@\\2</a>'", $parsed);
                    $parsed = preg_replace("#(^|[\n ])\#([A-Za-z0-9]*)#ise", "'\\1<a href=\"http://www.twitter.com/search?q=\\2\" target=\"_blank\">#\\2</a>'", $parsed);

                    if($instance['showdate']) {
                        $link = "http://www.twitter.com/".rawurlencode($tweet['user']['screen_name'])."/status/".rawurlencode($tweet['id_str']);
                        $date = human_time_diff(strtotime($tweet['created_at'])) .' ago';
                    }
                    
                    echo '<li>
                    		<div class="twitter-content">
                            <p>
                                <a href="http://www.twitter.com/'.$tweet['user']['screen_name'].'">@'.$tweet['user']['screen_name'].'</a>: '.$parsed;
                            echo '</p></div><div class="quote">';
                    if($instance['showdate']) {
                        echo '<a href="'.$link.'"><span> 
                            '.$date.'
                        </span></a>';
                    }
                    echo '</div>';
                    
                    echo '
                        </li>';
                }
                echo '</ul>';
                echo $after_widget;
            }
        }
    }
}

?>
