<div class="oauthtwitter_holder">

    <h1>OAuth Twitter Settings</h1>
    <?php
    
    // Display success
    if($success)
        echo '<div class="oauthtwitter_success"><p>'.htmlentities($success, ENT_QUOTES).'</p></div>';
    
    // Display errors
    if(!empty($errors)) {
        echo '<div class="oauthtwitter_error"><p>';
        foreach ($errors as $error) {
            echo htmlentities($error, ENT_QUOTES).'<br />';
        }
        echo '</p></div>';
    }
    ?>
    <p>
        To enable Twitter to authenticate your API requests, you must first <a href="https://dev.twitter.com/apps/new">create 
        an application</a> which will provide you with the information needed to fill in the form below. 
    </p>
    <p>
        It is very important that you setup a Callback URL when you setup your application. For this, you can simply enter the URL of your 
        wordpress blog. The authentication process will not work without it.
    </p>

    <form action="<?php htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES); ?>" method="POST" class="oauthtwitter_form">
        <h3>Consumer</h3>
        <fieldset>
            <label for="oauthtwitter-consumer_key">Consumer Key</label>
            <input type="text" name="consumer_key" id="oauthtwitter-consumer_key" value="<?php echo htmlentities($consumer_key, ENT_QUOTES); ?>" />
            
            <label for="oauthtwitter-consumer_secret">Consumer Secret</label>
            <input type="text" name="consumer_secret" id="oauthtwitter-consumer_secret" value="<?php echo htmlentities($consumer_secret, ENT_QUOTES); ?>" />        
        </fieldset>
        
        <h3>Access<?php if($loginURL) echo '<small><a href="'.$loginURL.'" title="Authenticate">Autofill</a></small>'; ?></h3>
        <fieldset>
            <label for="oauthtwitter-access_token">Access Token</label>
            <input type="text" name="access_token" id="oauthtwitter-access_token" value="<?php echo htmlentities($access_token, ENT_QUOTES); ?>" />
            
            <label for="oauthtwitter-access_secret">Access Secret</label>
            <input type="text" name="access_secret" id="oauthtwitter-access_secret" value="<?php echo htmlentities($access_secret, ENT_QUOTES); ?>" />
        </fieldset>
        
        <fieldset class="actions">
            <input type="hidden" name="submitted" value="true" />
            <button class="button" type="submit">Save</button>
        </fieldset>
    </form>
    
    
    <div class="oauthtwitter_tweet">
        <h3>Latest Tweets</h3>
        <?php
        if($twitter->hasAccess()) {
            $user = $twitter->getUser();
            if($user)
            {
                $result = $twitter->api("1.1/statuses/user_timeline.json", "GET", array(
                    "screen_name" => $user['screen_name'],
                    "count" => 4
                ));
                
                if($result->statusCode() == 200) {
                    $tweets = json_decode($result->body(), true);
                    if(count($tweets) > 0) {
                        foreach($tweets as $tweet) {
                        
                            // Parse tweet links, users and hashtags.
                            $parsed = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" target=\"_blank\">\\2</a>'", $tweet['text']);
                            $parsed = preg_replace("#(^|[\n ])@([A-Za-z0-9\_]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" target=\"_blank\">@\\2</a>'", $parsed);
                            $parsed = preg_replace("#(^|[\n ])\#([A-Za-z0-9]*)#ise", "'\\1<a href=\"http://www.twitter.com/search?q=\\2\" target=\"_blank\">#\\2</a>'", $parsed);
                            
                            echo '<div class="tweet">
                                <p>
                                    <a href="http://www.twitter.com/'.$tweet['user']['screen_name'].'">@'.$tweet['user']['screen_name'].'</a>: '.$parsed.' 
                                    <span class="date"><a href="http://www.twitter.com/'.rawurlencode($tweet['user']['screen_name']).'/status/'.rawurlencode($tweet['id_str']).'">'.$tweet['created_at'].'</span>
                                </p>    
                            </div>';
                        }
                    }
                } else {
                    echo '<p>Unable to fetch your latest tweets.</p>';
                }
            } else {
                echo '<p>Unable to fetch your profile.</p>';
            }
        } else {
            echo '<p>You need to provide access tokens before we can fetch your tweets.</p>';
        }
        ?>
    </div>
    
    <div class="clear-both"></div>
</div>
