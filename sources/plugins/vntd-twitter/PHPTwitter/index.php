<?php

require_once("Twitter.php");
session_start();

$twitter = new Twitter("CONSUMER KEY", "CONSUMER SECRET"/*, "ACCESS_TOKEN", "ACCESS_SECRET"*/);

// Reset tokens if requested.
if(isset($_GET['reset'])) {
    unset($_SESSION['request']);
    unset($_SESSION['access']);

    header("Location: index.php", true, 301);
    die('<a href="index.php">Back to the start</a>');
}

// Set previously retreived tokens.
if(isset($_SESSION['request'])) $twitter->setRequest(unserialize($_SESSION['request']));
if(isset($_SESSION['access']))  $twitter->setAccess(unserialize($_SESSION['access']));


// Check to see if we have access tokens.
if(!$twitter->hasAccess()) {
    // We don't yet have access. Let's see if we can get it.
    if(isset($_GET['denied'])) {
        echo 'The user has denied access to your application.';
    } else {
        // Check to see if we can get an access token.
        if($access = $twitter->getAccessToken()) {
            $_SESSION['access'] = serialize($access);
            header("Location: ".$twitter->getOAuthCallback(), true, 301);
            die('<a href="'.$twitter->getOAuthCallback().'">Complete Login</a>');
        } else {
            // Unable to get access token. We'll settle for a request token instead.
            $request = $twitter->getRequestToken();
            if($request) {
                $_SESSION['request'] = serialize($request);
                // Display or redirect to user to their login URL.
                echo '<a href="'.$twitter->getLoginURL().'">'.$twitter->getLoginURL().'</a>';
            } else {
                // Problems.
                echo 'Unable to get request token.';
            }
        }
    }
} else {
    // The user has authorized access to the application.

    // Get the current user.
    $user = $twitter->getUser();

    /**
     * The above call is the same as doing the following:
     *
     * $result = $twitter->api("1.1/account/verify_credentials.json");
     * if($result->statusCode() == 200)
     *      $user = json_decode($result->body(), true);
     * else
     *      $user = false;
    **/

    if($user)
        echo "Hello, " . $user['screen_name'] . "<br />".
        "<a href=\"?reset=1\">Log out</a>";
    else
        echo "Unable to fetch the users' data.";

}
?>
