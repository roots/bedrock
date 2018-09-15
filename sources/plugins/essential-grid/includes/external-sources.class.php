<?php
/**
 * External Sources Input Classes for Back and Front End
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 * @since: 2.0.9
 **/

if( !defined( 'ABSPATH') ) die();

/**
 * Facebook
 *
 * with help of the API this class delivers album images from Facebook
 *
 * @package    socialstreams
 * @subpackage socialstreams/facebook
 * @author     ThemePunch <info@themepunch.com>
 */

class Essential_Grid_Facebook {
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	* Transient seconds
	*
	* @since    3.0
	* @access   private
	* @var      number    $transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	* oauth
	*
	* @since    3.0
	* @access   private
	* @var      number    $transient Transient time in seconds
	*/
	private $oauth;

	public function __construct($transient_sec = 86400) {
	    $this->transient_sec = 	$transient_sec;
	} 



	/**
	 * Get User ID from its URL
	 *
	 * @since    3.0
	 * @param    string    $user_url URL of the Page
	 */
	public function get_user_from_url($user_url){
		$theid = str_replace("https", "", $user_url);
		$theid = str_replace("http", "", $theid);
		$theid = str_replace("://", "", $theid);
		$theid = str_replace("www.", "", $theid);
		$theid = str_replace("facebook", "", $theid);
		$theid = str_replace(".com", "", $theid);
		$theid = str_replace("/", "", $theid);
		$theid = explode("?", $theid);
		return trim($theid[0]);
	}

	/**
	 * Get Photosets List from User
	 *
	 * @since    3.0
	 * @param    string    $user_id 	Facebook User id (not name)
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_photo_sets($user_id,$item_count=10,$app_id,$app_secret){
		//photoset params
		$oauth = wp_remote_fopen("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=".$app_id."&client_secret=".$app_secret);
		$this->oauth = $oauth;
		$url = "https://graph.facebook.com/$user_id/albums?".$oauth;
		$photo_sets_list = json_decode(wp_remote_fopen($url));
		return $photo_sets_list->data;
	}

	/**
	 * Get Photoset Photos
	 *
	 * @since    3.0
	 * @param    string    $photo_set_id 	Photoset ID
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_photo_set_photos($photo_set_id,$item_count=10,$app_id,$app_secret){
		$oauth = wp_remote_fopen("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=".$app_id."&client_secret=".$app_secret);
		$this->oauth = $oauth;
		$url = "https://graph.facebook.com/".$photo_set_id."/photos?fields=photos&".$oauth."&fields=id,from,message,picture,images,link,name,icon,privacy,type,status_type,object_id,application,created_time,updated_time,is_hidden,is_expired,comments.limit(1).summary(true),likes.limit(1).summary(true)";

		$transient_name = 'essgrid_' . md5($url."&limit=".$item_count);

		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);
		

		if($item_count<=25){
			//call the API and decode the response
			$photo_set_photos = json_decode(wp_remote_fopen($url."&limit=".$item_count));
			if(!isset($photo_set_photos->error->message)){
				$this->facebook_output_array($photo_set_photos->data,$item_count);
			}
			else {
				if(empty($error_message)){
					$error_message = __("Facebook reports: ",EG_TEXTDOMAIN).$photo_set_photos->error->message;
					echo $error_message;
					return false;
				}
			}
		}
		else {
			$runs = ceil($item_count / 25);
			$original_count = $item_count;
			$supervisor_count = 0;
			for ($i=0; $i < $runs && sizeof($this->stream) < $original_count && $supervisor_count < 20 ; $i++) { 
				$nextpage = empty($page_rsp->paging->next) ? $url : $page_rsp->paging->next;
				$supervisor_count++;

				$maxResults =  25;
				$page_rsp = json_decode( wp_remote_fopen( $nextpage ) );
				$nextpage = empty($page_rsp->paging->next) ? '' : $page_rsp->paging->next;

				if(!isset($page_rsp->error->message)){
					$item_count = $this->facebook_output_array($page_rsp->data,$item_count);
					if( empty($nextpage) ) $i = $runs;
				}
				else {
					if(empty($error_message)){
						$error_message = __("Facebook reports: ",EG_TEXTDOMAIN).$page_rsp->error->message;
						echo $error_message;
						return false;
					}
				}
			}

		}

		set_transient( $transient_name, $this->stream, $this->transient_sec );
		return $this->stream;	
	}

	/**
	 * Get Photosets List from User as Options for Selectbox
	 *
	 * @since    3.0
	 * @param    string    $user_url 	Facebook User id (not name)
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_photo_set_photos_options($user_url,$current_album,$app_id,$app_secret,$item_count=99){
		$user_id = $this->get_user_from_url($user_url);
		$photo_sets = $this->get_photo_sets($user_id,999,$app_id,$app_secret);
		if(empty($current_album)) $current_album = "";
		$return = array();
		foreach($photo_sets as $photo_set){
			$return[] = '<option title="'.$photo_set->name.'" '.selected( $photo_set->id , $current_album , false ).' value="'.$photo_set->id.'">'.$photo_set->name.'</option>"';
		}
		return $return;
	}
	

	/**
	 * Get Feed
	 *
	 * @since    3.0
	 * @param    string    $user 	User ID
	 * @param    int       $item_count 	number of itmes to pull
	 */
	public function get_photo_feed($user,$app_id,$app_secret,$item_count=10){
		$oauth = wp_remote_fopen("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=".$app_id."&client_secret=".$app_secret);
		$this->oauth = $oauth;
		
		$url = "https://graph.facebook.com/$user/feed?".$oauth."&fields=id,from,message,picture,full_picture,link,name,icon,privacy,type,status_type,object_id,application,created_time,updated_time,is_hidden,is_expired,comments.limit(1).summary(true),likes.limit(1).summary(true)";
		
		$transient_name = 'essgrid' . md5($url."&limit=".$item_count);

		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);



		if($item_count<=25){
			//call the API and decode the response
			$feed = json_decode(wp_remote_fopen($url."&limit=".$item_count));
			if(!isset($feed->error->message)){
				$this->facebook_feed_output_array($feed->data,$user,$item_count);
			}
			else {
				if(empty($error_message)){
					$error_message = __("Facebook reports: ",EG_TEXTDOMAIN).$feed->error->message;
					echo $error_message;
					return false;
				}
			}
		}
		else {
			$runs = ceil($item_count / 25);
			$original_count = $item_count;
			$supervisor_count = 0;
			for ($i=0; $i < $runs && sizeof($this->stream) < $original_count && $supervisor_count < 20; $i++) { 
				$nextpage = empty($page_rsp->paging->next) ? $url : $page_rsp->paging->next;
				$supervisor_count++;

				$maxResults =  25;
				$page_rsp = json_decode( wp_remote_fopen( $nextpage ) );
				$nextpage = empty($page_rsp->paging->next) ? '' : $page_rsp->paging->next;


				if(!isset($page_rsp->error->message)){
					$item_count = $this->facebook_feed_output_array($page_rsp->data,$user,$item_count);
					if( empty($nextpage) ) $i = $runs;
				}
				else {
					if(empty($error_message)){
						$error_message = __("Facebook reports: ",EG_TEXTDOMAIN).$page_rsp->error->message;
						echo $error_message;
						return false;
					}
				}
			}

		}

		set_transient( $transient_name, $this->stream, $this->transient_sec );
		return $this->stream;		
	}

	/**
	 * Prepare output array $stream for Album
	 *
	 * @since    3.0
	 * @param    string    $photos 	facebook Output Data
	 */
	private function facebook_output_array($photos,$item_count){
		foreach ($photos as $photo) {
			$stream = array();
			if($item_count-- === 0) return;

			$stream['custom-image'] = "";
			if (!empty($photo->id)) {
				$stream['id'] = $photo->id;
				$image_url = array(
					'thumbnail' => 	array(
						$photo->picture,
						130,
						130
					),
					'normal' 	=> 	array(
						$photo->images[0]->source,
						$photo->images[0]->width,
						$photo->images[0]->height
					),
				);
			}
			$stream['custom-image-url'] = $image_url;

			$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
			if(!empty($photo->name)){
				$stream['title'] = $photo->name;
				$stream['content'] = $photo->name;	
			}
			$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $photo->updated_time ) );
			$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $photo->updated_time ) );
			$stream['author_name'] = $photo->from->name;
			if(!empty($photo->comments->data))
				$stream['num_comments'] = sizeof($photo->comments->data);

			//Link To
			$stream['post-link'] = $photo->link;
			$stream['likes'] = $photo->likes->summary->total_count;
			$stream['likes_short'] = Essential_Grid_Base::thousandsViewFormat($photo->likes->summary->total_count);
			$this->stream[] = $stream;
		}
		return $item_count;
	}

	/**
	 * Prepare output array $stream from Timeline
	 *
	 * @since    3.0
	 * @param    string    $feed 	facebook Output Data
	 */
	private function facebook_feed_output_array($feed,$user,$item_count){
		foreach ($feed as $photo) {

			if(!in_array($photo->status_type,array("wall_post"))){
				$stream = array();

				if($item_count-- === 0) return;

				if($photo->type !="video"){
					if(!empty($photo->object_id)){
						$image_url = array(
							'thumbnail' => 	array(
								$photo->picture,
								130,
								130
							),
							'normal' 	=> 	array(
								$photo->full_picture,
								720,
								720
							),
						);
					}
					elseif (!empty($photo->picture)) {
						$image_url = $this->decode_facebook_url($photo->picture);
						$image_url = parse_str(parse_url($image_url, PHP_URL_QUERY), $array);
						if(isset($array['url'])) {
							$image_url_final = explode('&', $array['url']);
							//$image_normal_sizes = getimagesize($image_url_final[0]);
							$image_url = array(
								'thumbnail' => 	array(
									$photo->picture,
									130,
									130
								),
								'normal' 	=> 	array(
									$image_url_final[0],
									720,
									720
								),
							);
						}
						else{
							$image_url = array(
								'thumbnail' => 	array(
									$photo->picture,
									130,
									130
								),
								'normal' 	=> 	array(
									$photo->picture,
									130,
									130
								),
							);
						}
					}
					$stream['custom-type'] = empty($photo->picture) ? 'html' : 'image'; //image, vimeo, youtube, soundcloud, html
				}

				if($photo->type =="video" ){

					$video_url = explode("videos", $photo->link);

					if(strpos($video_url[0], 'youtu') ){
						$stream['custom-type'] = 'youtube';
						$vid_url = $video_url[0];
						$stream['custom-youtube'] = $vid_url;
					}
					else{
						$stream['custom-type'] = 'html5';
						
						$video_id = str_replace("/", "", $video_url[1]);
						$vid_url = "http://graph.facebook.com/".$video_id;
						$video_json = json_decode(wp_remote_fopen(stripslashes($vid_url)));

						$max_format = sizeof($video_json->format);

						$max_format = $max_format-1;
	
						$image_url = array(
							'thumbnail' => 	array(
								$video_json->format[0]->picture,
								$video_json->format[0]->width,
								$video_json->format[0]->height
							),
							'normal' 	=> 	array(
								$video_json->format[$max_format]->picture,
								$video_json->format[$max_format]->width,
								$video_json->format[$max_format]->height
							),
						);
						$stream['custom-html5-mp4'] = $video_json->source;
					}
				}
				

				$stream['custom-image-url'] = $image_url;
				$stream['id'] = $photo->id;

				$post_url = explode('_',$photo->id);
				$stream['post-link'] = 'https://www.facebook.com/'.$user.'/posts/'.$post_url[1];
				
				if(!empty($photo->message)){
					$stream['title'] = $photo->message;
					$stream['content'] = $photo->message;
				}	
				$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $photo->updated_time ) );
				$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $photo->updated_time ) );
				$stream['author_name'] = $photo->from->name;
				if(!empty($photo->comments->data))
					$stream['num_comments'] = sizeof($photo->comments->data);

				$stream['likes'] = $photo->likes->summary->total_count;
				$stream['likes_short'] = Essential_Grid_Base::thousandsViewFormat($photo->likes->summary->total_count);
			
				$this->stream[] = $stream;
			}
		}
		return $item_count;
	}

	/**
	 * Decode URL from feed
	 *
	 * @since    3.0
	 * @param    string    $url 	facebook Output Data
	 */
	private function decode_facebook_url($url) {
		$url = str_replace('u00253A',':',$url);
		$url = str_replace('\u00255C\u00252F','/',$url);
		$url = str_replace('u00252F','/',$url);
		$url = str_replace('u00253F','?',$url);
		$url = str_replace('u00253D','=',$url);
		$url = str_replace('u002526','&',$url);
		return $url;
	}
}


/**
 * Twitter
 *
 * with help of the API this class delivers all kind of tweeted images from twitter
 *
 * @package    socialstreams
 * @subpackage socialstreams/twitter
 * @author     ThemePunch <info@themepunch.com>
 */

class Essential_Grid_Twitter {

  /**
   * Consumer Key
   *
   * @since    3.0
   * @access   private
   * @var      string    $consumer_key    Consumer Key
   */
  private $consumer_key;

  /**
   * Consumer Secret
   *
   * @since    3.0
   * @access   private
   * @var      string    $consumer_secret    Consumer Secret
   */
  private $consumer_secret;

  /**
   * Access Token
   *
   * @since    3.0
   * @access   private
   * @var      string    $access_token    Access Token
   */
  private $access_token;

  /**
   * Access Token Secret
   *
   * @since    3.0
   * @access   private
   * @var      string    $access_token_secret    Access Token Secret
   */
  private $access_token_secret;

  /**
   * Twitter Account
   *
   * @since    3.0
   * @access   private
   * @var      string    $twitter_account    Account User Name
   */
  private $twitter_account;

  /**
   * Stream Array
   *
   * @since    3.0
   * @access   private
   * @var      array    $stream    Stream Data Array
   */
  private $stream;

  /**
   * Transient seconds
   *
   * @since    3.0
   * @access   private
   * @var      number    $transient Transient time in seconds
   */
  private $transient_sec;


  /**
   * Initialize the class and set its properties.
   *
   * @since    3.0
   * @param      string    $consumer_key Twitter App Registration Consomer Key
   * @param      string    $consumer_secret Twitter App Registration Consomer Secret
   * @param      string    $access_token Twitter App Registration Access Token
   * @param      string    $access_token_secret Twitter App Registration Access Token Secret
   */
  public function __construct($consumer_key,$consumer_secret,$access_token,$access_token_secret,$transient_sec = 86400) {
    $this->consumer_key         =   $consumer_key;
    $this->consumer_secret      =   $consumer_secret;
    $this->access_token         =   $access_token;
    $this->access_token_secret  =   $access_token_secret;
    $this->transient_sec		= 	0;//$transient_sec;
  }

  /**
   * Get Tweets
   *
   * @since    3.0
   * @param    string    $twitter_account   Twitter account without trailing @ char
   */
  public function get_public_photos($twitter_account,$include_rts,$exclude_replies,$count,$imageonly){
    $credentials = array(
	  'consumer_key'    =>  $this->consumer_key,
	  'consumer_secret' =>    $this->consumer_secret 
	);

    $this->twitter_account = $twitter_account;

	// Let's instantiate our class with our credentials
	$twitter_api = new EssGridTwitterApi( $credentials , $this->transient_sec);
	
    $include_rts = $include_rts=="on" ? "true" : "false"; 
    $exclude_replies = $exclude_replies=="on" ? "true" : "false"; 

	$query = 'count=150&include_entities=true&include_rts='.$include_rts.'&exclude_replies='.$exclude_replies.'&screen_name='.$twitter_account;
	$security = 50;
	$supervisor_count = 0;

	while($count > 0 && $security > 0 && $supervisor_count < 20) {

		//get last stream array element and insert ID with max_id parameter
		$supervisor_count++;

		if(is_array($this->stream)){
			$current_query = $query."&max_id=".$this->stream[sizeof($this->stream)-1]["tweet_id"];
		}
		else{
			$current_query = $query;	
		}

		$tweets = $twitter_api->query( $current_query );
		$count = $this->twitter_output_array($tweets,$count,$imageonly);

		$security--;
	}
    
    return $this->stream;
  }


  /**
   * Find Key in array and return value (multidim array possible)
   *
   * @since    3.0
   * @param    string    $key   Needle
   * @param    array     $form  Haystack
   */
  public function array_find_element_by_key($key, $form) {
	  if (is_array($form) &&  array_key_exists($key, $form)) {
	    $ret = $form[$key];
	    return $ret;
	  }
	  if(is_array($form))
	      foreach ($form as $k => $v) {
	        if (is_array($v)) {
	          $ret = $this->array_find_element_by_key($key, $form[$k]);
	          if ($ret) {
	            return $ret;
	          }
	        }
	      }
	  return FALSE;
  }

  /**
   * Prepare output array $stream
   *
   * @since    3.0
   * @param    string    $tweets  Twitter Output Data
   */
  private function twitter_output_array($tweets,$count,$imageonly){
	if(is_array($tweets)){
	  	foreach ($tweets as $tweet) {

	  	  $stream = array();
	      $image_url = array();
	      if( $count < 1) break;
	   
	      $image_url_array = $this->array_find_element_by_key("media",$tweet);
	      $image_url_large = $this->array_find_element_by_key("large",$image_url_array);

	      if(isset($tweet->entities->media[0])) {
	      	$image_url = array($tweet->entities->media[0]->media_url_https,$tweet->entities->media[0]->sizes->large->w,$tweet->entities->media[0]->sizes->large->h);
	      }

	      $stream['custom-image-url'] = $image_url; //image for entry
	      $stream['custom-image-url-full'] = $image_url; //image for entry
	      $stream['custom-type'] = isset($image_url[0]) ? 'image' : 'html';
	      if($imageonly=="true" && $stream['custom-type'] == 'html') continue;
	      $stream['custom-type'] = 'image';

	      $stream['title'] = $tweet->text;
	      $stream['content'] = $tweet->text;
	      $stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $tweet->created_at ) );
	      $stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $tweet->created_at ) );
	      $stream['author_name'] = $tweet->user->screen_name;
	      $stream['post-link'] = 'https://twitter.com/'.$this->twitter_account.'/status/'.$tweet->id_str;

	      $stream['retweets'] = $tweet->retweet_count;
	      $stream['retweets_short'] = Essential_Grid_Base::thousandsViewFormat($tweet->retweet_count);
	      $stream['likes'] = $tweet->favorite_count;
	      $stream['likes_short'] = Essential_Grid_Base::thousandsViewFormat($tweet->favorite_count);
	      $stream['tweet_id'] = $tweet->id;
	      $stream['id'] = $tweet->id;
	      $this->stream[] = $stream;
	      $count--;
	    }
	    return $count;
	}
	else {
		return false;
	}
  }
}

/**
* Class WordPress Twitter API
*
* https://github.com/micc83/Twitter-API-1.1-Client-for-Wordpress/blob/master/class-wp-twitter-api.php
* @version 1.0.0
* @since   3.0
*/
class EssGridTwitterApi {
  
        var $bearer_token,
                
        // Default credentials
        $args = array(
                'consumer_key'       =>        'default_consumer_key',
                'consumer_secret'    =>        'default_consumer_secret'
        ),
        
        // Default type of the resource and cache duration
        $query_args = array(
                'type'               =>        'statuses/user_timeline',
                'cache'              =>        1800
        ),

        $has_error = false;
        
        /**
         * WordPress Twitter API Constructor
         *
         * @param array $args
         */
        public function __construct( $args = array() , $transient_sec = 0 ) {
                
                if ( is_array( $args ) && !empty( $args ) )
                        $this->args = array_merge( $this->args, $args );
                
                if ( ! $this->bearer_token = get_option( 'twitter_bearer_token' ) )
                        $this->bearer_token = $this->get_bearer_token();
                
               $this->query_args['cache'] = $transient_sec;
        }
        
        /**
         * Get the token from oauth Twitter API
         *
         * @return string Oauth Token
         */
        private function get_bearer_token() {
                
                $bearer_token_credentials = $this->args['consumer_key'] . ':' . $this->args['consumer_secret'];
                $bearer_token_credentials_64 = base64_encode( $bearer_token_credentials );
                
                $args = array(
                        'method'                =>         	'POST',
                        'timeout'               =>         	5,
                        'redirection'        	=>         	5,
                        'httpversion'        	=>         	'1.0',
                        'blocking'              =>         	true,
                        'headers'               =>         	array(
                                'Authorization'       =>        'Basic ' . $bearer_token_credentials_64,
                                'Content-Type'        =>        'application/x-www-form-urlencoded;charset=UTF-8',
                                'Accept-Encoding'     =>        'gzip'
                        ),
                        'body'                  => 			array( 'grant_type'      =>        'client_credentials' ),
                        'cookies'               =>    		array()
                );
                
                $response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );
                
                if ( is_wp_error( $response ) || 200 != $response['response']['code'] )
                        return $this->bail( __( 'Twitter reports: Please check your credentials (keys)', 'wp_twitter_api' ), $response );
                
                $result = json_decode( $response['body'] );
                
                update_option( 'twitter_bearer_token', $result->access_token );
                
                return $result->access_token;
                
        }
        
        /**
         * Query twitter's API
         *
         * @uses $this->get_bearer_token() to retrieve token if not working
         *
         * @param string $query Insert the query in the format "count=1&include_entities=true&include_rts=true&screen_name=micc1983!
         * @param array $query_args Array of arguments: Resource type (string) and cache duration (int)
         * @param bool $stop Stop the query to avoid infinite loop
         *
         * @return bool|object Return an object containing the result
         */
        public function query( $query, $query_args = array(), $stop = false ) {
                
                if ( $this->has_error )
                        return false;
                
                if ( is_array( $query_args ) && !empty( $query_args ) )
                        $this->query_args = array_merge( $this->query_args, $query_args );
                
                $transient_name = 'wta_' . md5( $query );

                if ($this->query_args['cache'] > 0 && false !== ( $data = get_transient( $transient_name ) ) )
                	return json_decode( $data );
                
                $args = array(
                        'method'             =>         'GET',
                        'timeout'            =>         5,
                        'redirection'        =>         5,
                        'httpversion'        =>         '1.0',
                        'blocking'           =>         true,
                        'headers'            =>         array(
                                'Authorization'		=>        'Bearer ' . $this->bearer_token,
                                'Accept-Encoding'   =>        'gzip'
                        ),
                        'body'               =>         null,
                        'cookies'            =>         array()
                );
                
                $response = wp_remote_get( 'https://api.twitter.com/1.1/' . $this->query_args['type'] . '.json?' . $query, $args );
                if ( is_wp_error( $response ) || 200 != $response['response']['code'] ){
                
                        if ( !$stop ){
                                $this->bearer_token = $this->get_bearer_token();
                                return $this->query( $query, $this->query_args, true );
                        } else {
                                return $this->bail( __( 'Twitter reports: Please check account name', 'wp_twitter_api' ), $response );
                        }
                        
                }
                set_transient( $transient_name, $response['body'], $this->query_args['cache'] );
                return json_decode( $response['body'] );
                
        }
        
        /**
         * Let's manage errors
         *
         * WP_DEBUG has to be set to true to show errors
         *
         * @param string $error_text Error message
         * @param string $error_object Server response or wp_error
         */
        private function bail( $error_text, $error_object = '' ) {
                
                $this->has_error = true;
                
                if ( is_wp_error( $error_object ) ){
                        $error_text .= ' - Wp Error: ' . $error_object->get_error_message();
                } elseif ( !empty( $error_object ) && isset( $error_object['response']['message'] ) ) {
                        $error_text .= ' ( Response: ' . $error_object['response']['message'] . ' )';
                }
                
                echo $error_text;
                return false;
               // trigger_error( $error_text , E_USER_NOTICE );
                
        }
        
}


/**
 * Instagram
 *
 * with help of the API this class delivers all kind of Images from instagram
 *
 * @package    socialstreams
 * @subpackage socialstreams/instagram
 * @author     ThemePunch <info@themepunch.com>
 */

class Essential_Grid_Instagram {

	/**
	 * API key
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string    $api_key    Instagram API key
	 */
	private $api_key;

	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
    * Transient seconds
    *
    * @since    3.0
    * @access   private
    * @var      number    $transient Transient time in seconds
    */
    private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 * @param      string    $api_key	Instagram API key.
	 */
	public function __construct($transient_sec=86400) {
		$this->transient_sec = $transient_sec;
	}

	/**
	 * Get Instagram Pictures
	 *
	 * @since    3.0
	 * @param    string    $user_id 	Instagram User id (not name)
	 */
	public function get_public_photos($search_user_id,$count){
		//call the API and decode the response
		$url = "https://www.instagram.com/".$search_user_id."/media/";



		$transient_name = 'essgrid_' . md5($url."count=".$count);
		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);

		if($count<=20){
			//call the API and decode the response
			$rsp = json_decode(wp_remote_fopen($url));
			$this->instagram_output_array($rsp->items,$count);
		}
		else {
			$runs = ceil($count / 20);
			$original_count = $count;
			$supervisor_count = 0;
			for ($i=0; $i < $runs && sizeof($this->stream) < $original_count && $supervisor_count < 20; $i++) {
				$supervisor_count++;
				if(isset($page_rsp->more_available) &&  $page_rsp->more_available == true){
					$last_item = end($page_rsp->items);
					$max_id_url = 'https://api.instagram.com/oembed/?url=http://instagram.com/p/'.$last_item->code.'/';
					$max_id_rsp = json_decode(wp_remote_fopen($max_id_url));
					$max_id = "?max_id=" . $max_id_rsp->media_id;
				}
				else{
					$max_id = "";
				}
				
				if(isset($page_rsp->more_available) &&  $page_rsp->more_available == false){
					$i = $runs;
					continue;
				}
				
				$page_rsp = json_decode( wp_remote_fopen( $url.$max_id ) );
				$count = @$this->instagram_output_array($page_rsp->items,$count);
			}
		}
		
		if(!empty($this->stream)){
			set_transient( $transient_name, $this->stream, $this->transient_sec );
			return $this->stream;
		}
		else {
			_e('Instagram reports: Please check the username',EG_TEXTDOMAIN);
			return false;
		}
	
	}

	/**
	 * Prepare output array $stream
	 *
	 * @since    3.0
	 * @param    string    $photos 	Instagram Output Data
	 */
	private function instagram_output_array($photos,$count){
		foreach ($photos as $photo) {

			if($count > 0){
				$count--;
				$stream = array();

				$image_url = array(
					'Low Resolution' 		=> 	array(str_replace("150x150", "320x320", $photo->images->thumbnail->url),
							320,
							320
					),
					'Thumbnail' 			=> 	array($photo->images->thumbnail->url,$photo->images->thumbnail->width,$photo->images->thumbnail->height),
					'Standard Resolution' 	=>	array(str_replace("150x150", "640x640", $photo->images->thumbnail->url),
							640,
							640,
					)
				);

				$text = empty($photo->caption->text) ? '' : $photo->caption->text;

				$stream['id'] = $photo->id;
				$stream['custom-image-url'] = $image_url; //image for entry
				
				if(!isset($photo->videos->standard_resolution)){
					$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				}
				else{
					$stream['custom-type'] = 'html5'; //image, vimeo, youtube, soundcloud, html	
					$stream['custom-html5-mp4'] = $photo->videos->standard_resolution->url;
				}
				
				$stream['post-link'] = $photo->link;
				$stream['title'] = $text;
				$stream['content'] = $text;
				$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $photo->created_time ) ) ;
				$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $photo->created_time ) ) ;
				$stream['author_name'] = $photo->user->username;
				
				if(isset($photo->tags))	$stream['tags'] = implode(',', $photo->tags);

				$stream['likes'] = $photo->likes->count;
				$stream['likes_short'] = Essential_Grid_Base::thousandsViewFormat($photo->likes->count);
				$stream['num_comments'] = $photo->comments->count;


				$this->stream[] = $stream;
			}
		}
		return $count;
	}
}

/**
 * Flickr
 *
 * with help of the API this class delivers all kind of Images from flickr
 *
 * @package    socialstreams
 * @subpackage socialstreams/flickr
 * @author     ThemePunch <info@themepunch.com>
 */

class Essential_Grid_Flickr {

	/**
	 * API key
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string    $api_key    flickr API key
	 */
	private $api_key;

	/**
	 * API params
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array    $api_param_defaults    Basic params to call with API
	 */
	private $api_param_defaults;

	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	 * Basic URL
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string    $flickr_url    Url to fetch user from
	 */
	private $flickr_url;

	/**
	 * Error Message
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string    $flickr_message    Url to fetch user from
	 */
	private $flickr_message;

	/**
	* Transient seconds
	*
	* @since    3.0
	* @access   private
	* @var      number    $transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 * @param      string    $api_key	flickr API key.
	 */
	public function __construct($api_key,$transient_sec=86400) {
		$this->api_key = $api_key;
		$this->api_param_defaults = array(
		  'api_key' => $this->api_key,
		  'format' => 'json',
		  'nojsoncallback' => 1,
		);
		$this->transient_sec = $transient_sec;
	}

	/**
	 * Calls Flicker API with set of params, returns json
	 *
	 * @since    3.0
	 * @param    array    $params 	Parameter build for API request
	 */
	private function call_flickr_api($params){
		//build url
		$encoded_params = array();
		foreach ($params as $k => $v){
		  $encoded_params[] = urlencode($k).'='.urlencode($v);
		}

		//call the API and decode the response
		$url = "https://api.flickr.com/services/rest/?".implode('&', $encoded_params);

		$transient_name = 'revslider_' . md5($url);
		
		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);

		$rsp = json_decode(wp_remote_fopen($url));
		
		
		if(isset($rsp->stat) && $rsp->stat == "fail"){
			if(empty($this->flickr_message)){
				$this->flickr_message = __('flickr reports: ', EG_TEXTDOMAIN).$rsp->message ;
				echo $this->flickr_message;
			} 
			return '';	
		}
		else {
			set_transient( $transient_name, $rsp, $this->transient_sec );
			return $rsp;
		} 
	}

	/**
	 * Get User ID from its URL
	 *
	 * @since    3.0
	 * @param    string    $user_url URL of the Gallery
	 */
	public function get_user_from_url($user_url){
		//gallery params
		$user_params = $this->api_param_defaults + array(
			'method'  => 'flickr.urls.lookupUser',
  			'url' => $user_url,
		);
		
		//set User Url
		$this->flickr_url = $user_url;

		//get gallery info
		$user_info = $this->call_flickr_api($user_params);
		if(isset($user_info->user->id) )
			return $user_info->user->id;
		else
			return false;
	}

	/**
	 * Get Group ID from its URL
	 *
	 * @since    3.0
	 * @param    string    $group_url URL of the Gallery
	 */
	public function get_group_from_url($group_url){
		//gallery params
		$group_params = $this->api_param_defaults + array(
			'method'  => 'flickr.urls.lookupGroup',
  			'url' => $group_url,
		);
		
		//set User Url
		$this->flickr_url = $group_url;

		//get gallery info
		$group_info = $this->call_flickr_api($group_params);
		if(isset($group_info->group->id))
			return $group_info->group->id;
		else
			return false;
	}

	/**
	 * Get Public Photos
	 *
	 * @since    3.0
	 * @param    string    $user_id 	flicker User id (not name)
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_public_photos($user_id,$item_count=10){
		//public photos params
		$public_photo_params = $this->api_param_defaults + array(
			'method'  => 'flickr.people.getPublicPhotos',
  			'user_id' => $user_id,
  			'extras'  => 'description, license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o',
  			'per_page'=> $item_count,
  			'page' => 1
		);
		
		//get photo list
		$public_photos_list = $this->call_flickr_api($public_photo_params);
		if(isset($public_photos_list->photos->photo))
			$this->flickr_output_array($public_photos_list->photos->photo);
		//return $public_photos_list->photos->photo;
		return $this->stream;
	}

	/**
	 * Get Photosets List from User
	 *
	 * @since    3.0
	 * @param    string    $user_id 	flicker User id (not name)
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_photo_sets($user_id,$item_count=10,$current_photoset){
		//photoset params
		$photo_set_params = $this->api_param_defaults + array(
			'method'  => 'flickr.photosets.getList',
  			'user_id' => $user_id,
  			'per_page'=> $item_count,
  			'page'    => 1
		);
		
		//get photoset list
		$photo_sets_list = $this->call_flickr_api($photo_set_params);
		
		foreach($photo_sets_list->photosets->photoset as $photo_set){
			if(empty($photo_set->title->_content)) $photo_set->title->_content = "";
			if(empty($photo_set->photos))  $photo_set->photos = 0;

			$return[] = '<option title="'.$photo_set->description->_content.'" '.selected( $photo_set->id , $current_photoset , false ).' value="'.$photo_set->id.'">'.$photo_set->title->_content.' ('.$photo_set->photos.' photos)</option>"';
		}

		return $return;
	}

	/**
	 * Get Photoset Photos
	 *
	 * @since    3.0
	 * @param    string    $photo_set_id 	Photoset ID
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_photo_set_photos($photo_set_id,$item_count=10){
		//photoset photos params
		$this->stream = array();
		$photo_set_params = $this->api_param_defaults + array(
			'method'  		=> 'flickr.photosets.getPhotos',
  			'photoset_id' 	=> $photo_set_id,
  			'per_page'		=> $item_count,
  			'page'    		=> 1,
  			'extras'		=> 'license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o'
		);
		
		//get photo list
		$photo_set_photos = $this->call_flickr_api($photo_set_params);
		$this->flickr_output_array($photo_set_photos->photoset->photo);
		//return $photo_set_photos;
		return $this->stream;
	}

	/**
	 * Get Groop Pool Photos
	 *
	 * @since    3.0
	 * @param    string    $group_id 	Photoset ID
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_group_photos($group_id,$item_count=10){
		//photoset photos params
		$group_pool_params = $this->api_param_defaults + array(
			'method'  		=> 'flickr.groups.pools.getPhotos',
  			'group_id' 	=> $group_id,
  			'per_page'		=> $item_count,
  			'page'    		=> 1,
  			'extras'		=> 'license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o'
		);
		
		//get photo list
		$group_pool_photos = $this->call_flickr_api($group_pool_params);
		if(isset($group_pool_photos->photos->photo))
			$this->flickr_output_array($group_pool_photos->photos->photo);
		//return $group_pool_photos;
		return $this->stream;
	}

	/**
	 * Get Gallery ID from its URL
	 *
	 * @since    3.0
	 * @param    string    $gallery_url URL of the Gallery
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_gallery_from_url($gallery_url){
		//gallery params
		$gallery_params = $this->api_param_defaults + array(
			'method'  => 'flickr.urls.lookupGallery',
  			'url' => $gallery_url,
		);
		
		//get gallery info
		$gallery_info = $this->call_flickr_api($gallery_params);
		if(isset($gallery_info->gallery->id))
			return $gallery_info->gallery->id;
	}

	/**
	 * Get Gallery Photos
	 *
	 * @since    3.0
	 * @param    string    $gallery_id 	flicker Gallery id (not name)
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_gallery_photos($gallery_id,$item_count=10){
		//gallery photos params
		$gallery_photo_params = $this->api_param_defaults + array(
			'method'  => 'flickr.galleries.getPhotos',
  			'gallery_id' => $gallery_id,
  			'extras'  => 'description, license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o',
  			'per_page'=> $item_count,
  			'page' => 1
		);
		
		//get photo list
		$gallery_photos_list = $this->call_flickr_api($gallery_photo_params);
		if(isset($gallery_photos_list->photos->photo))
			$this->flickr_output_array($gallery_photos_list->photos->photo);
		//return $gallery_photos_list->photos->photo;
		return $this->stream;
	}

	/**
	 * Prepare output array $stream
	 *
	 * @since    3.0
	 * @param    string    $photos 	flickr Output Data
	 */
	private function flickr_output_array($photos){
		foreach ($photos as $photo) {
			$stream = array();

			$image_url = @array(
				'Square' 		=> 	array($photo->url_sq,$photo->width_sq,$photo->height_sq),
				'Large Square' 	=> 	array($photo->url_q,$photo->width_q,$photo->height_q),
				'Thumbnail' 	=> 	array($photo->url_t,$photo->width_t,$photo->height_t),
				'Small' 		=> 	array($photo->url_s,$photo->width_s,$photo->height_s),
				'Small 320' 	=> 	array($photo->url_n,$photo->width_n,$photo->height_n),
				'Medium' 		=> 	array($photo->url_m,$photo->width_m,$photo->height_m),
				'Medium 640' 	=> 	array($photo->url_z,$photo->width_z,$photo->height_z),
				'Medium 800' 	=> 	array($photo->url_c,$photo->width_c,$photo->height_c),
				'Large' 		=>	array($photo->url_l,$photo->width_l,$photo->height_l),
				'Original'		=>	array($photo->url_o,$photo->width_o,$photo->height_o),
			);

			$stream['id'] = $photo->id;
			$stream['custom-image-url'] = $image_url; //image for entry
			$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
			$stream['title'] = $photo->title;
			if(!empty($photo->description->_content))	
				$stream['content'] = $photo->description->_content;
			$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $photo->datetaken ) ) ;
			$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $photo->datetaken ) ) ;
			$stream['author_name'] = $photo->ownername;
			
			$stream['views'] = $photo->views;
			$stream['views_short'] = Essential_Grid_Base::thousandsViewFormat($photo->views);
			$stream['tag_list'] = str_replace(" ", ",", $photo->tags);

			$stream['post-link'] = 'http://flic.kr/p/'.$this->base_encode($photo->id);

			//get favorites
			$photo_fovorites_params = $this->api_param_defaults + array(
				'method'  => 'flickr.photos.getFavorites',
	  			'photo_id' => $photo->id,
	  			'per_page' => 1,
	  			'page' => 1
			);
			$photo_favorites = $this->call_flickr_api($photo_fovorites_params);
			if(!empty($photo_favorites->photo->total)){
				$stream['favorites'] = $photo_favorites->photo->total;
				$stream['favorites_short'] = Essential_Grid_Base::thousandsViewFormat($photo_favorites->photo->total);
			}

			//get comments
			$photo_info_params = $this->api_param_defaults + array(
				'method'  => 'flickr.photos.getInfo',
	  			'photo_id' => $photo->id,
	  			'per_page' => 1,
	  			'page' => 1
			);
			$photo_infos = $this->call_flickr_api($photo_info_params);

			$stream['num_comments'] = $photo_infos->photo->comments->_content;

			$this->stream[] = $stream;
		}
	}

	/**
	 * Encode the flickr ID for URL (base58)
	 *
	 * @since    3.0
	 * @param    string    $num 	flickr photo id
	 */
	private function base_encode($num, $alphabet='123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ') {
		$base_count = strlen($alphabet);
		$encoded = '';
		while ($num >= $base_count) {
			$div = $num/$base_count;
			$mod = ($num-($base_count*intval($div)));
			$encoded = $alphabet[$mod] . $encoded;
			$num = intval($div);
		}
		if ($num) $encoded = $alphabet[$num] . $encoded;
		return $encoded;
	}
}

/**
 * Youtube
 *
 * with help of the API this class delivers all kind of Images/Videos from youtube
 *
 * @package    socialstreams
 * @subpackage socialstreams/youtube
 * @author     ThemePunch <info@themepunch.com>
 */

class Essential_Grid_Youtube {

	/**
	 * API key
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string    $api_key    Youtube API key
	 */
	private $api_key;

	/**
	 * Channel ID
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string    $channel_id    Youtube Channel ID
	 */
	private $channel_id;

	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	* Transient seconds
	*
	* @since    3.0
	* @access   private
	* @var      number    $transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 * @param      string    $api_key	Youtube API key.
	 */
	public function __construct($api_key,$channel_id,$transient_sec=86400) {
		$this->api_key = $api_key;
		$this->channel_id = $channel_id;
		$this->transient_sec = $transient_sec;
	}


	/**
	 * Get Youtube Playlists
	 *
	 * @since    3.0
	 */
	public function get_playlists(){
		//call the API and decode the response
		$url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId=".$this->channel_id."&maxResults=50&key=".$this->api_key;
		$rsp = json_decode(wp_remote_fopen($url));
		return $rsp->items;
	}

	/**
	 * Get Youtube Playlist Items
	 *
	 * @since    3.0
	 * @param    string    $playlist_id 	Youtube Playlist ID
	 * @param    integer    $count 	Max videos count
	 */
	public function show_playlist_videos($playlist_id,$count=50){
		$maxResults = 50;
		$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$playlist_id."&key=".$this->api_key;

		$transient_name = 'essgrid_' . md5($url).'&count='.$count;

		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);

		if($count<=$maxResults){
			//call the API and decode the response
			$url .= "&maxResults=".$count;

			$rsp = json_decode(wp_remote_fopen($url));

			$this->youtube_playlist_output_array($rsp->items,$count);
		}
		else {
			$runs = ceil($count / 50);
			$original_count = $count;
			$supervisor_count = 0;
			for ($i=0; $i < $runs && sizeof($this->stream) < $original_count && $supervisor_count < 20; $i++) { 
				$nextpage = empty($page_rsp->nextPageToken) ? '' : "&pageToken=".$page_rsp->nextPageToken;
				$supervisor_count++;
				
				$maxResults =  50;
				$page_rsp = json_decode( wp_remote_fopen( $url."&maxResults=".$maxResults.$nextpage ) );
				$nextpage = empty($page_rsp->nextPageToken) ? '' : "&pageToken=".$page_rsp->nextPageToken;

				
				if(!empty($page_rsp) && !isset($page_rsp->error->message) ){
					$count = $this->youtube_playlist_output_array($page_rsp->items,$count);
					if( empty($nextpage) ) $i = $runs;
				}
				else {
					echo __("YouTube reports: ",EG_TEXTDOMAIN).$page_rsp->error->message;
					return false;
				}
			}
		}

		set_transient( $transient_name, $this->stream, $this->transient_sec );
		return $this->stream;
	}

	public function show_playlist_overview($count=50){
		$maxResults = 50;
		$url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&channelId=".$this->channel_id."&key=".$this->api_key;

		//echo $url;

		$transient_name = 'essgrid_' . md5($url).'&count='.$count;

		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);

		if($count<=$maxResults){
			//call the API and decode the response
			$url .= "&maxResults=".$count;

			$rsp = json_decode(wp_remote_fopen($url));
			$this->youtube_playlist_overview_output_array($rsp->items,$count);
		}
		else {
			$runs = ceil($count / 50);
			$original_count = $count;
			$supervisor_count = 0;
			for ($i=0; $i < $runs && sizeof($this->stream) < $original_count && $supervisor_count < 20; $i++) { 
				$nextpage = empty($page_rsp->nextPageToken) ? '' : "&pageToken=".$page_rsp->nextPageToken;
				$supervisor_count++;
				
				$maxResults =  50;
				$page_rsp = json_decode( wp_remote_fopen( $url."&maxResults=".$maxResults.$nextpage ) );
				$nextpage = empty($page_rsp->nextPageToken) ? '' : "&pageToken=".$page_rsp->nextPageToken;

				
				if(!empty($page_rsp) && !isset($page_rsp->error->message) ){
					$count = $this->youtube_playlist_overview_output_array($page_rsp->items,$count);
					if( empty($nextpage) ) $i = $runs;
				}
				else {
					echo __("YouTube reports: ",EG_TEXTDOMAIN).$page_rsp->error->message;
					return false;
				}
			}
		}

		set_transient( $transient_name, $this->stream, $this->transient_sec );
		return $this->stream;
	}

	/**
	 * Get Youtube Channel Items
	 *
	 * @since    3.0
	 * @param    integer    $count 	Max videos count
	 */
	public function show_channel_videos($count=50){
		$maxResults = 50;

		$url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=".$this->channel_id."&key=".$this->api_key."&order=date";	
		$transient_name = 'essgrid_' . md5($url).'&count='.$count;

		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);

		if($count<=$maxResults){
			//call the API and decode the response
			$url .= "&maxResults=".$count;

			$rsp = json_decode(wp_remote_fopen($url));
			$this->youtube_channel_output_array($rsp->items,$count);
		}
		else {
			$runs = ceil($count / 50);
			$original_count = $count;
			$supervisor_count = 0;
			for ($i=0; $i < $runs && sizeof($this->stream) < $original_count && $supervisor_count < 20; $i++) { 
				$nextpage = empty($page_rsp->nextPageToken) ? '' : "&pageToken=".$page_rsp->nextPageToken;
				$supervisor_count++;
				
				$maxResults =  50;
				$page_rsp = json_decode( wp_remote_fopen( $url."&maxResults=".$maxResults.$nextpage ) );

				if(!empty($page_rsp) && !isset($page_rsp->error->message) ){
					
					$count = $this->youtube_channel_output_array($page_rsp->items,$count);
					if( empty($nextpage) ) $i = $runs;
				}
				else {
					echo __("YouTube reports: ",EG_TEXTDOMAIN).$page_rsp->error->message;
					return false;
				}
			}
		}

		set_transient( $transient_name, $this->stream, $this->transient_sec );
		return $this->stream;
	}

	/**
	 * Get Playlists from Channel as Options for Selectbox
	 *
	 * @since    3.0
	 */
	public function get_playlist_options($current_playlist=""){
		$return = array();
		$playlists = $this->get_playlists();
		if(!empty($playlists)){
			foreach($playlists as $playlist){
				$return[] = '<option title="'.$playlist->snippet->description.'" '.selected( $playlist->id , $current_playlist , false ).' value="'.$playlist->id.'">'.$playlist->snippet->title.'</option>"';
			}
		}
		return $return;
	}

	/**
	 * Prepare output array $stream for Youtube Playlist Overview
	 *
	 * @since    3.0
	 * @param    string    $videos 	Youtube Output Data
	 */
	private function youtube_playlist_overview_output_array($videos,$count){
		
		foreach ($videos as $video) {
			$stream = array();

			if($count > 0){
				$count--;
				$image_url = @array(
					'default' 	=> 	array($video->snippet->thumbnails->default->url,$video->snippet->thumbnails->default->width,$video->snippet->thumbnails->default->height),
					'medium' 	=> 	array($video->snippet->thumbnails->medium->url,$video->snippet->thumbnails->medium->width,$video->snippet->thumbnails->medium->height),
					'high'		=>	array($video->snippet->thumbnails->high->url,$video->snippet->thumbnails->high->width,$video->snippet->thumbnails->high->height),
					'standard'	=>	array($video->snippet->thumbnails->standard->url,$video->snippet->thumbnails->standard->width,$video->snippet->thumbnails->standard->height),
					'maxres'	=>	array(str_replace('hqdefault', 'maxresdefault', $video->snippet->thumbnails->high->url),1500,900)
				);
				$stream['id'] = $video->id;
				$stream['custom-image-url'] = $image_url; //image for entry
				$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				$stream['post-link'] = 'https://www.youtube.com/playlist?list='.$video->id;
				$stream['title'] = $video->snippet->title;
				$stream['content'] = $video->snippet->description;
			
				$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $video->snippet->publishedAt ) );
				$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $video->snippet->publishedAt ) );

				$stream['author_name'] = $video->snippet->channelTitle;
				
				$stream['itemCount'] = $video->contentDetails->itemCount; 

				$this->stream[] = $stream;
			}
		}
		return $count;
	}

	/**
	 * Prepare output array $stream for Youtube Playlist
	 *
	 * @since    3.0
	 * @param    string    $videos 	Youtube Output Data
	 */
	private function youtube_playlist_output_array($videos,$count){
		
		foreach ($videos as $video) {
			$stream = array();

			if($count > 0){
				$count--;
				$image_url = @array(
					'default' 	=> 	array($video->snippet->thumbnails->default->url,$video->snippet->thumbnails->default->width,$video->snippet->thumbnails->default->height),
					'medium' 	=> 	array($video->snippet->thumbnails->medium->url,$video->snippet->thumbnails->medium->width,$video->snippet->thumbnails->medium->height),
					'high'		=>	array($video->snippet->thumbnails->high->url,$video->snippet->thumbnails->high->width,$video->snippet->thumbnails->high->height),
					'standard'	=>	array($video->snippet->thumbnails->standard->url,$video->snippet->thumbnails->standard->width,$video->snippet->thumbnails->standard->height),
					'maxres'	=>	array(str_replace('hqdefault', 'maxresdefault', $video->snippet->thumbnails->high->url),1500,900)
				);

				$stream['id'] = $video->snippet->resourceId->videoId;
				$stream['custom-image-url'] = $image_url; //image for entry
				$stream['custom-type'] = 'youtube'; //image, vimeo, youtube, soundcloud, html
				$stream['custom-youtube'] = $video->snippet->resourceId->videoId;
				$stream['post-link'] = 'https://www.youtube.com/watch?v='.$video->snippet->resourceId->videoId;
				$stream['title'] = $video->snippet->title;
				$stream['channel_title'] = $video->snippet->channelTitle;
				$stream['content'] = $video->snippet->description;
				
				$stream['date'] = $video->snippet->publishedAt ;
				$stream['date_modified'] = $video->snippet->publishedAt ;
/*				
				$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $video->snippet->publishedAt ) );
				$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $video->snippet->publishedAt ) );
*/
				$stream['author_name'] = $video->snippet->channelTitle;

				$video_stats = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=".$video->snippet->resourceId->videoId."&key=".$this->api_key);
				$video_stats = json_decode($video_stats);
				$stream['views'] = $video_stats->items[0]->statistics->viewCount;
				$stream['views_short'] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->viewCount);
		        $stream["likes"] = $video_stats->items[0]->statistics->likeCount;
		        $stream["likes_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->likeCount);
		        $stream["dislikes"] = $video_stats->items[0]->statistics->dislikeCount;
		        $stream["dislikes_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->dislikeCount);
		        $stream["favorites"] = $video_stats->items[0]->statistics->favoriteCount;
		        $stream["favorites_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->favoriteCount);
		        $stream["num_comments"] = $video_stats->items[0]->statistics->commentCount;
		        $stream["num_comments_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->commentCount);
				
				$this->stream[] = $stream;
			}
		}
		return $count;
	}

	/**
	 * Prepare output array $stream for Youtube channel
	 *
	 * @since    3.0
	 * @param    string    $videos 	Youtube Output Data
	 */
	private function youtube_channel_output_array($videos,$count){
		foreach ($videos as $video) {
			if(!empty($video->id->videoId) && $count > 0){
				$stream = array();

				$count--;

				$image_url = @array(
					'default' 	=> 	array($video->snippet->thumbnails->default->url,$video->snippet->thumbnails->default->width,$video->snippet->thumbnails->default->height),
					'medium' 	=> 	array($video->snippet->thumbnails->medium->url,$video->snippet->thumbnails->medium->width,$video->snippet->thumbnails->medium->height),
					'high'		=>	array($video->snippet->thumbnails->high->url,$video->snippet->thumbnails->high->width,$video->snippet->thumbnails->high->height),
					'standard'	=>	array($video->snippet->thumbnails->standard->url,$video->snippet->thumbnails->standard->width,$video->snippet->thumbnails->standard->height),
					'maxres'	=>	array(str_replace('hqdefault', 'maxresdefault', $video->snippet->thumbnails->high->url),1500,900),
				);



				$stream['id'] = $video->id->videoId;
				$stream['custom-image-url'] = $image_url; //image for entry
				$stream['custom-type'] = 'youtube'; //image, vimeo, youtube, soundcloud, html
				$stream['custom-youtube'] = $video->id->videoId;
				$stream['post-link'] = 'https://www.youtube.com/watch?v='.$video->id->videoId;
				$stream['title'] = $video->snippet->title;
				$stream['channel_title'] = $video->snippet->channelTitle;
				$stream['content'] = $video->snippet->description;
				$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $video->snippet->publishedAt ) );
				$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $video->snippet->publishedAt ) );
				$stream['author_name'] = $video->snippet->channelTitle;

				$video_stats = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=".$video->id->videoId."&key=".$this->api_key);
				$video_stats = json_decode($video_stats);
				$stream['views'] = $video_stats->items[0]->statistics->viewCount;
				$stream['views_short'] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->viewCount);
		        $stream["likes"] = $video_stats->items[0]->statistics->likeCount;
		        $stream["likes_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->likeCount);
		        $stream["dislikes"] = $video_stats->items[0]->statistics->dislikeCount;
		        $stream["dislikes_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->dislikeCount);
		        $stream["favorites"] = $video_stats->items[0]->statistics->favoriteCount;
		        $stream["favorites_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->favoriteCount);
		        $stream["num_comments"] = $video_stats->items[0]->statistics->commentCount;
				
				$this->stream[] = $stream;
			}
		}
		return $count;
	}
}

/**
 * Vimeo
 *
 * with help of the API this class delivers all kind of Images/Videos from Vimeo
 *
 * @package    socialstreams
 * @subpackage socialstreams/vimeo
 * @author     ThemePunch <info@themepunch.com>
 */

class Essential_Grid_Vimeo {
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	* Transient seconds
	*
	* @since    1.0.0
	* @access   private
	* @var      number    $transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 * @param      string    $api_key	Youtube API key.
	 */
	public function __construct($transient_sec=86400) {
		$this->transient_sec = $transient_sec;
	}

	/**
	 * Get Vimeo User Videos
	 *
	 * @since    3.0
	 */
	public function get_vimeo_videos($type,$value,$count){
		//call the API and decode the response
		if($type=="user"){
			$url = "https://vimeo.com/api/v2/".$value."/videos.json?count=".$count;
		}
		else{
			$url = "https://vimeo.com/api/v2/".$type."/".$value."/videos.json?count=".$count;
		}
		
		$transient_name = 'essgrid_' . md5($url);

		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);

		$rsp = json_decode(wp_remote_fopen($url));
		
		if($count > 20){
			$runs = ceil($count / 20);
			$supervisor_count = 0;
			for ($i=0; $i < $runs && $supervisor_count < 20; $i++) { 
				$page_rsp = json_decode( wp_remote_fopen( $url."&page=".($i+1) ) );
				$supervisor_count++;
				if(!empty($page_rsp)){
					$count = $count - 20;
					$this->vimeo_output_array($page_rsp,$count);
				}
				else {
					if($i==0){
						_e("Vimeo reports: Please check your Data!", EG_TEXTDOMAIN);
						return false;
					}
				}
			}
		}
		else {
			$rsp = json_decode(wp_remote_fopen($url));

			if(!empty($rsp)){
				$this->vimeo_output_array($rsp,$count);
			}
			else {
				_e("Vimeo reports: Please check your Data!", EG_TEXTDOMAIN);
				return false;
			}
		}
			
		set_transient( $transient_name, $this->stream, $this->transient_sec );
		return $this->stream;
		
			
	}

	/**
	 * Prepare output array $stream for Vimeo videos
	 *
	 * @since    3.0
	 * @param    string    $videos 	Vimeo Output Data
	 */
	private function vimeo_output_array($videos,$count){
	  if(is_array($videos))	
		foreach ($videos as $video) {
			if($count-- == 0) break;

			$stream = array();

			$image_url = @array(
				'thumbnail_small' 	=> 	array($video->thumbnail_small),
				'thumbnail_medium' 	=> 	array($video->thumbnail_medium),
				'thumbnail_large' 	=> 	array($video->thumbnail_large),
			);

			$stream['custom-image-url'] = $image_url; //image for entry
			$stream['custom-type'] = 'vimeo'; //image, vimeo, youtube, soundcloud, html
			$stream['custom-vimeo'] = $video->id;
			$stream['id'] = $video->id;
			$stream['post-link'] = $video->url;
			$stream['title'] = $video->title;
			$stream['content'] = $video->description;
			$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $video->upload_date) );
			$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $video->upload_date) );
			$stream['author_name'] = $video->user_name;
			/*$stream['user_url'] = $video->user_url ;
			$stream['user_portrait_huge'] = $video->user_portrait_huge ;*/
			$minutes = floor($video->duration / 60);
			$seconds = $video->duration % 60;
			$seconds = $seconds < 10 ? '0'.$seconds : $seconds;
			$stream['duration'] = $minutes . ':' . $seconds ;
			/*$stream['width'] = $video->width ;
			$stream['height'] = $video->height ;*/
			$stream['tag_list'] = $video->tags ;
			$stream["likes"] = isset($video->stats_number_of_likes)? $video->stats_number_of_likes : 0 ;
			$stream["likes_short"] = isset($video->stats_number_of_likes)? Essential_Grid_Base::thousandsViewFormat($video->stats_number_of_likes) : 0 ;
  			$stream["views"] = isset($video->stats_number_of_plays)? $video->stats_number_of_plays : 0 ;
  			$stream["views_short"] = isset($video->stats_number_of_plays)? Essential_Grid_Base::thousandsViewFormat($video->stats_number_of_plays) : 0 ;
  			$stream["num_comments"] = isset($video->stats_number_of_comments)? $video->stats_number_of_comments : 0;

			$this->stream[] = $stream;
		}
	}
}

/**
 * Behance
 *
 * with help of the API this class delivers all kind of Images/Projects from Behance
 *
 * @package    socialstreams
 * @subpackage socialstreams/behance
 * @author     ThemePunch <info@themepunch.com>
 */

class Essential_Grid_Behance {
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	 * API key
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string    $api_key    Youtube API key
	 */
	private $api_key;

	/**
	 * User ID
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string    $user_id    Behance User ID
	 */
	private $user_id;

	/**
	* Transient seconds
	*
	* @since    3.0
	* @access   private
	* @var      number    $transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 * @param      string    $api_key	Youtube API key.
	 */
	public function __construct($api_key,$user_id,$transient_sec=0) {
		$this->api_key = $api_key;
		$this->user_id = $user_id;
		$this->transient_sec = 0;//$transient_sec;
		$this->stream = array();
	}

	/**
	 * Get Behance User Projects
	 *
	 * @since    3.0
	 */
	public function get_behance_projects($count=100){
		//call the API and decode the response
		$url = "https://www.behance.net/v2/users/".$this->user_id."/projects?api_key=".$this->api_key."&per_page=".$count;

		$transient_name = 'essgrid_' . md5($url);

		if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
			return ($data);

		$rsp = json_decode(wp_remote_fopen($url));

		if(!empty($rsp)){
			$this->behance_output_array($rsp);
			set_transient( $transient_name, $this->stream, $this->transient_sec );
			return $this->stream;
		}
	}

	/**
	 * Get Playlists from Channel as Options for Selectbox
	 *
	 * @since    3.0
	 */
	public function get_behance_projects_options($current_project = ""){
		//call the API and decode the response
		$url = "https://www.behance.net/v2/users/".$this->user_id."/projects?api_key=".$this->api_key;

		/*$transient_name = 'essgrid_' . md5($url);
		if (false !== ($data = get_transient( $transient_name)))
			$rsp = $data;
		else {*/
			$rsp = json_decode(wp_remote_fopen($url));
			/*set_transient( $transient_name, $rsp, 86400 );
		}*/

		$return = array();

		if(isset($rsp->projects))
			foreach ($rsp->projects as $project) {
				$return[] = '<option '.selected( $project->id , $current_project , false ).' value="'.$project->id.'">'.$project->name.'</option>"';
			}
		else
			$return = var_dump($rsp);
		return $return;
	}

	/**
	 * Get Images from single Project
	 *
	 * @since    3.0
	 */
	public function get_behance_project_images($project="",$count=100){
		//call the API and decode the response
		if(!empty($project) ){
			$url = "https://www.behance.net/v2/projects/".$project."?api_key=".$this->api_key."&per_page=".$count;

			$transient_name = 'essgrid_' . md5($url);

			if ($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name)))
				return ($data);

			$rsp = json_decode( wp_remote_fopen($url) );

			if(!empty($rsp)){
				$this->behance_images_output_array($rsp,$count);
				set_transient( $transient_name, $this->stream, $this->transient_sec );
				return $this->stream;
			}
		}	
	}

	/**
	 * Prepare output array $stream for Behance images
	 *
	 * @since    3.0
	 * @param    string    $videos 	Behance Output Data
	 */
	private function behance_images_output_array($images,$count){
		if(is_object($images)){
			foreach ($images->project->modules as $image) {
				if(!$count--) break;
				$stream = array();

				$image_url = @array(
					'disp' 		=> 	array($image->sizes->disp),
					'max_86400' 	=> 	array($image->sizes->max_86400),
					'max_1240' 	=> 	array($image->sizes->max_1240),
					'original' 	=> 	array($image->sizes->original),
				);

				$stream['custom-image-url'] = $image_url;
				$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				$stream['post-link'] = $images->project->url;
				$stream['title'] = $images->project->name;
				$stream['content'] = $images->project->name;
				$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $images->project->modified_on ) ) ;
				$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $images->project->modified_on ) ) ;
				$stream['author_name'] = $images->project->owners[0]->first_name;
				$this->stream[] = $stream;
			}
		}
	}

	/**
	 * Prepare output array $stream for Behance Projects
	 *
	 * @since    3.0
	 * @param    string    $videos 	Behance Output Data
	 */
	private function behance_output_array($images){
		if(is_object($images)){
			foreach ($images->projects as $image) {
				$stream = array();

				$image_url = @array(
					'115' 		=> 	array($image->covers->{'115'}),
					'202' 		=> 	array($image->covers->{'202'}),
					'230' 		=> 	array($image->covers->{'230'}),
					'404' 		=> 	array($image->covers->{'404'}),
					'original' 	=> 	array($image->covers->original),
				);
				$stream['custom-image-url'] = $image_url;

				$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				$stream['post-link'] = $image->url;
				$stream['title'] = $image->name;
				$stream['content'] = $image->name;
				$stream['date'] = $image->modified_on;
				$stream['date_modified'] = $image->modified_on;
				$stream['author_name'] = 'dude';
				$this->stream[] = $stream;
			}
		}
	}
}

/**
 * NextGen
 *
 * show images from NextGen Albums and Galleries
 *
 * @package    socialstreams
 * @subpackage socialstreams/nextgen
 * @author     ThemePunch <info@themepunch.com>
 */

class Essential_Grid_Nextgen {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 */
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	public function __construct() {
			
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_album_list($current_album){
		global $nggdb; //nextgen basic class
		
		// Galleries in Albums
		$albums = $nggdb->find_all_album();
		
		// Build <option>s for <select>
		$return = array();
		foreach ($albums as $album) {
			$album_details = $nggdb->find_album($album->id);
			$return[] = '<option value="'.$album_details->id.'" '.selected( $album_details->id , $current_album , false ).'>'.$album_details->name.'</option> ';  
		}

		return $return;
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_gallery_list($current_gallery){
		global $nggdb; //nextgen basic class
		
		// Galleries
		$gallerys = $nggdb->find_all_galleries();
		
		// Build <option>s for <select>
		$return = array();
		foreach ($gallerys as $gallery) {
			//$gallery_details = $nggdb->find_gallery($gallery->id);
			$return[] = '<option value="'.$gallery->gid.'" '.selected( $gallery->gid , $current_gallery , false ).'>'.$gallery->title.'</option> ';  
			
		}

		return $return;
	}

	/**
	 * Prepare list of Tags options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_tag_list($current_tags){
		global $nggdb; //nextgen basic class
		
		// Tags
		$tags= nggTags::find_all_tags(); 
		
		// Build <option>s for <select>
		$return = array();
		foreach ($tags as $tag) {
			//$gallery_details = $nggdb->find_gallery($gallery->id);
			$return[] = '<option value="'.$tag->term_id.'" '.selected( $tag->term_id , $current_tags , false ).'>'.$tag->name.'</option> ';  
			
		}

		return $return;
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_album_images($album_id){
		global $nggdb; //nextgen basic class
		$galleries = $nggdb->find_album($album_id);
		$return = $this->get_gallery_images($galleries->gallery_ids);	
		return $return;	
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_tags_images($tags){
		global $nggdb; //nextgen basic class
		// Find by Tags
		$images = @nggTags::find_images_for_tags($tags);
		foreach ( $images as $image ){
			//if ( $image->hidden ) continue;
		   	$image = nggdb::find_image($image->pid);

		    $image_url = @array(
				'thumb' 	=> 	array($image->thumbnailURL),
				'original' 	=> 	array($image->imageURL),
			);
			$stream['custom-image-url'] = $image_url;

			$stream['custom-type'] = 'image';
			$stream['post-link'] = $image->imageURL;
			$stream['title'] = $image->alttext;
			$stream['content'] = $image->description;
			$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $image->imagedate ) ) ;
			$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $image->imagedate ) ) ;
			$this->stream[] = $stream;
		}

		return $this->stream;	
	}

	public function get_gallery_images($gallery_ids){
		global $nggdb;
		$counter = 0;

		foreach($gallery_ids as $gallery_id){

			if( !is_numeric($gallery_id) && $counter < 25){
				$counter++;
				$galleries_inside = $nggdb->find_album( preg_replace("/[^0-9]/", "", $gallery_id) );
				$return = $this->get_gallery_images( $galleries_inside->gallery_ids );
			}
			else{
				$this->nextgen_output_array($gallery_id);	
			}
		}
		return $this->stream;
	}

	public function nextgen_output_array($gallery_id){
		$images = nggdb::get_gallery($gallery_id);
		foreach ( $images as $image ){
			if ( $image->hidden ) continue;
		    $image_url = @array(
				'thumb' 	=> 	array($image->thumbnailURL),
				'original' 	=> 	array($image->imageURL),
			);
			$stream['custom-image-url'] = $image_url;

			$stream['custom-type'] = 'image';
			$stream['post-link'] = $image->imageURL;
			$stream['title'] = $image->alttext;
			$stream['content'] = $image->description;
			$stream['date'] = date_i18n( get_option( 'date_format' ), strtotime( $image->imagedate ) ) ;
			$stream['date_modified'] = date_i18n( get_option( 'date_format' ), strtotime( $image->imagedate ) ) ;
			$this->stream[] = $stream;
		}
	}

}
?>