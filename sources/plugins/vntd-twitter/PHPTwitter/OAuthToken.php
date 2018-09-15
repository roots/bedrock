<?php

/**
 * Base structure for an OAuth Token.
 * @package PHPTwitter
**/
class OAuthToken {
    /**
     * OAuth token
     * @var string
    **/
    public $token = null;
    
    /**
     * OAuth token secret
     * @var string
    **/
    public $secret = null;
    
    /**
     * Setup the oauth token.
     * @param $token string - default null
     * @param $secret string - default null
    **/
    public function __construct($token = null, $secret = null) {
        $this->token = (string) $token;
        $this->secret = (string) $secret;
    }
}

?>
