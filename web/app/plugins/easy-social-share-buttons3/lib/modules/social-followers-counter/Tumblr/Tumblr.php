<?php

if( !class_exists( 'TumblrClientException' ) ) {
  /**
 * This exception will be thrown when the API returns an error code.
 */
  class TumblrClientException extends Exception { }
}

if( !class_exists( 'Tumblr') ) {
  /**
   * The main API class.
   */
  class Tumblr
  {
    protected $apiKey;
    protected $oauth;

    protected $host = 'http://api.tumblr.com/v2';

    protected $methods = array(
      'blogInfo' => array(
        'uri' => '/blog/%s/info',
        'auth' => 'api_key',
        'method' => 'get'
      ),
      'followers' => array(
        'uri' => '/blog/%s/followers',
        'auth' => 'oauth',
        'method' => 'get'
      ),
      'posts' => array(
        'uri' => '/blog/%s/posts',
        'auth' => 'api_key',
        'method' => 'get'
      ),
      'queue' => array(
        'uri' => '/blog/%s/posts/queue',
        'auth' => 'oauth',
        'method' => 'get'
      ),
      'drafts' => array(
        'uri' => '/blog/%s/posts/draft',
        'auth' => 'oauth',
        'method' => 'get'
      ),
      'submissions' => array(
        'uri' => '/blog/%s/posts/submission',
        'auth' => 'oauth',
        'method' => 'get'
      ),
      'createPost' => array(
        'uri' => '/blog/%s/post',
        'auth' => 'oauth',
        'method' => 'post'
      ),
      'editPost' => array(
        'uri' => '/blog/%s/post/edit',
        'auth' => 'oauth',
        'method' => 'post'
      ),
      'reblogPost' => array(
        'uri' => '/blog/%s/post/reblog',
        'auth' => 'oauth',
        'method' => 'post'
      ),
      'deletePost' => array(
        'uri' => '/blog/%s/post/delete',
        'auth' => 'oauth',
        'method' => 'post'
      ),
      'dashboard' => array(
        'uri' => '/user/dashboard',
        'auth' => 'oauth',
        'method' => 'get'
      ),
      'likes' => array(
        'uri' => '/user/likes',
        'auth' => 'oauth',
        'method' => 'get'
      ),
      'following' => array(
        'uri' => '/user/following',
        'auth' => 'oauth',
        'method' => 'get'
      ),
      'follow' => array(
        'uri' => '/user/follow',
        'auth' => 'oauth',
        'method' => 'post'
      ),
      'unfollow' => array(
        'uri' => '/user/unfollow',
        'auth' => 'oauth',
        'method' => 'get'
      ),
      'userInfo' => array(
        'uri' => '/user/info',
        'auth' => 'oauth',
        'method' => 'get'
      )
    );

    /**
     * You can choose to instantiate this API wrapper by passing an OAuth
     * instance and an API key. The OAuth instance should already have both the
     * consumer and token keys and secrets.
     *
     * @param OAuth $oauth
     * @param string $apiKey
     */
    public function __construct( $consumer_key , $consumer_secret , $oauth_token = NULL , $oauth_token_secret = NULL )
    {

      $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();

      $this->consumer    = new OAuthConsumer( $consumer_key , $consumer_secret );
      if ( !empty( $oauth_token ) && !empty( $oauth_token_secret ) ) {
        $this->token = new OAuthConsumer( $oauth_token , $oauth_token_secret );
      }
      else {
        $this->token = NULL;
      }

    }

    /**
     * Catch method calls and sort out the API call that has to be made, then
     * return the value or error that was returned by the API. If a method is
     * called that does not exist in the Tumblr API, returns an error.
     *
     * @param string $method
     * @param array $args
     */
    public function __call($method, $args)
    {
      // If method does not exist in the API, throw an exception.
      if (!array_key_exists($method, $this->methods))
      {
        throw new TumblrException("Unknown method [".$method."]");
      }

      // Get method info.
      $info = $this->methods[$method];

      // If this method needs an argument, check for validness. Only one
      // argument is accepted, and it should be a string.
      if (strstr($info['uri'], '%s'))
      {
        // Check if there are arguments at all, and check its validness.
        if (count($args) !== 1 || !is_string($args[0]))
        {
          throw new TumblrException("This method only accepts one argument, and it should be a string.");
        }
      }
      else
      {
        // Check for arguments.
        if (count($args) > 0)
        {
          throw new TumblrException("This method does not accept arguments.");
        }
      }

      // Handle it according to the method.
      if ('post' === $info['method'])
      {
        return $this->handlePostMethod($info, $args);
      }
      else
      {
        return $this->handleGetMethod($info, $args);
      }
    }

    /**
     * Set the API key for methods that require api_key authentication.
     *
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
      $this->apiKey = $apiKey;
    }

    /**
     * Get the API key.
     *
     * @return string
     */
    public function getApiKey()
    {
      return $this->apiKey;
    }

    /**
     * Set the OAuth instance for methods that require authentication through
     * OAuth.
     *
     * @param string $oauth
     */
    public function setOauth($oauth)
    {
      $this->oauth = $oauth;
    }

    /**
     * Get the OAuth instance.
     *
     * @return string
     */
    public function getOauth()
    {
      return $this->oath;
    }

    /**
     * Get tumblr host.
     *
     * @return string
     */
    public function getHost()
    {
      return $this->host;
    }

    /**
     * Handle a POST method.
     *
     * @param array $info
     * @param array $args
     */
    protected function handlePostMethod($info, $args)
    {
      // Handle authentication.

      // Post data to the API, wait for response.

      // Return response.
    }

    /**
     * Handle a GET method.
     *
     * @param array $info
     * @param array $args
     */
    protected function handleGetMethod($info, $args)
    {
      // Request the data according to the authentication method.
      if ('api_key' === $info['auth'])
      {
        $url = $this->prepareApiKeyUrl($info['uri'], $args[0]);

        // Get data.
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);
      }
      else
      {
        $url = $this->prepareUrl($info['uri'], !empty($args) ? $args[0] : false);

        // Get data.
        try
        {

          $response = @$this->oAuthRequest( $url , 'GET' );

          if ( $response ) {
            return @json_decode( $response );
          }
          return $response;

        }
        catch (OAuthException $ex)
        {
          throw new TumblrClientException(
            'The Tumblr API responded with an authentication error: ' . $ex->getMessage()
          );
        }
      }

      $responseData = json_decode($response);

      // Check for errors.
      if (200 !== $responseData->meta->status)
      {
        throw new TumblrClientExceptionException(
          $responseData->meta->msg,
          $responseData->meta->status
        );
      }

      return json_decode($response);
    }

    /**
     * Get an array with info for a particular API method.
     *
     * @return array
     */
    protected function getMethodInfo($methodName)
    {
      return $this->methods[$methodName];
    }

    /**
     * Prepare an url.
     *
     * @param string $uri
     * @param string $blog
     */
    protected function prepareUrl($uri, $blog)
    {
      $return = $this->getHost();

      // Add blogname.
      $return .= str_replace('%s', $blog, $uri);

      return $return;
    }

    /**
     * Prepare an API key url.
     *
     * @param string $uri
     * @param string $blog
     */
    protected function prepareApiKeyUrl($uri, $blog)
    {
      $return = $this->prepareUrl($uri, $blog);

      // Add api key.
      $apiKey = $this->getApiKey();
      if (strlen($apiKey) == 0)
      {
        return new TumblrException('No API key given');
      }

      $return .= '?api_key='.$apiKey;

      return $return;
    }

      /**
       * Format and sign an OAuth / API request
       */
      function oAuthRequest( $url , $method  ) {

        $request = OAuthRequest::from_consumer_and_token( $this->consumer , $this->token , $method , $url , array() );
        $request->sign_request( $this->sha1_method , $this->consumer , $this->token );
        switch ( $method ) {
          case 'GET':
            return $this->http( $request->to_url() , 'GET' );
          default:
            return $this->http( $request->get_normalized_http_url() , $method , $request->to_postdata() );
        }

      }

      /**
       * Make an HTTP request
       *
       * @return API results
       */
      function http( $url , $method , $postfields = NULL ) {
        $this->http_info = array( );
        $ci = curl_init();
        /* Curl settings */
        curl_setopt( $ci , CURLOPT_USERAGENT , $this->useragent );
        curl_setopt( $ci , CURLOPT_CONNECTTIMEOUT , $this->connecttimeout );
        curl_setopt( $ci , CURLOPT_TIMEOUT , $this->timeout );
        curl_setopt( $ci , CURLOPT_RETURNTRANSFER , TRUE );
        curl_setopt( $ci , CURLOPT_HTTPHEADER , array( 'Expect:' ) );
        curl_setopt( $ci , CURLOPT_SSL_VERIFYPEER , $this->ssl_verifypeer );
        curl_setopt( $ci , CURLOPT_HEADERFUNCTION , array( $this , 'getHeader' ) );
        curl_setopt( $ci , CURLOPT_HEADER , FALSE );

        switch ( $method ) {
          case 'POST':
            curl_setopt( $ci , CURLOPT_POST , TRUE );
            if ( !empty( $postfields ) ) {
              curl_setopt( $ci , CURLOPT_POSTFIELDS , $postfields );
            }
            break;
          case 'DELETE':
            curl_setopt( $ci , CURLOPT_CUSTOMREQUEST , 'DELETE' );
            if ( !empty( $postfields ) ) {
              $url = "{$url}?{$postfields}";
            }
        }

        curl_setopt( $ci , CURLOPT_URL , $url );
        $response        = curl_exec( $ci );
        $this->http_code = curl_getinfo( $ci , CURLINFO_HTTP_CODE );
        $this->http_info = array_merge( $this->http_info , curl_getinfo( $ci ) );
        $this->url       = $url;
        curl_close( $ci );
        return $response;

      }

      /**
       * Get the header info to store.
       */
      function getHeader( $ch , $header ) {
        $i = strpos( $header , ':' );
        if ( !empty( $i ) ) {
          $key                     = str_replace( '-' , '_' , strtolower( substr( $header , 0 , $i ) ) );
          $value                   = trim( substr( $header , $i + 2 ) );
          $this->http_header[$key] = $value;
        }
        return strlen( $header );

      }

  }
}