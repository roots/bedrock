<?php

/**
 * Social Share Optimization tags generator
 * @author appscreo
 * @deprecated 4.2
 *
 */

class ESSBSocialShareOptimization {
	private static $instance = null;
	
	public $default_image = "";
	public $apply_the_content = false;
	
	// Facebook additional
	public $ogtags_active = false;
	public $fbadmins = "";
	public $fbpage = "";
	public $fbapp = "";
	
	// Twitter Cards
	public $twitter_cards_active = false;
	public $card_type = "";
	public $twitter_user = "";
		
	// Google Schema.org
	public $google_authorship = false;
	public $google_markup = false;
	public $google_publisher = "";
	public $google_author = "";
	
	// Post defaults
	private $post_title = "";
	private $post_description = "";
	private $post_image = "";
	private $post_url = "";
	private $site_name = "";
	
	// Yoast SEO details: new from version 3.3
	private $yoast_og_title = "";
	private $yoast_og_description = "";
	private $yoast_og_image = "";
	private $yoast_seo_title = "";
	private $yoast_seo_description = "";
	
	public $fb_title = "";
	public $fb_description = "";
	private $fb_image = "";
	private $fb_video_url = "";
	private $fb_video_h = "";
	private $fb_video_w = "";
	private $fb_author_profile = "";
	
	private $fb_image1 = "";
	private $fb_image2 = "";
	private $fb_image3 = "";
	private $fb_image4 = "";
	
	private $fb_image_width = "";
	private $fb_image_height = "";
	
	private $twitter_title = "";
	private $twitter_description = "";
	private $twitter_image = "";
	
	private $google_title = "";
	private $google_description = "";
	private $google_image = "";
	
	private $sso_active = true;
	private $sso_fixhttps = false;
	private $sso_imagesize = false;	
	
	private $meta = array();
	
	private $optmization_data = array();
	
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	function __construct() {
		
		$this->loadDefaultFromOptions();
		
		if ($this->sso_active) {
			add_filter ( 'language_attributes', array ($this, 'insertLanguageAttributes' ) );
			add_action ( 'wp_head', array ($this, 'outputMeta' ), 1 );
				
			// stop Jetpack tags
			if (class_exists ( 'JetPack' )) {
				add_filter ( 'jetpack_enable_opengraph', '__return_false', 99 );
				add_filter ( 'jetpack_enable_open_graph', '__return_false', 99 );
			}
				
			// stop Yoast SEO from generating double tags
			if (defined('WPSEO_VERSION')) {
				global $wpseo_og;
				if (isset($wpseo_og)) {
					remove_action( 'wpseo_head', array( $wpseo_og, 'opengraph' ), 30 );
				}
			}
		}
	}
	
	private function loadDefaultFromOptions() {
		
		$this->default_image = essb_option_value('sso_default_image');
				
		if (essb_option_bool_value('sso_apply_the_content')) {
			$this->apply_the_content = true;
		}
		
		if (essb_option_bool_value('opengraph_tags')) {
			$this->ogtags_active = true;
			$this->fbadmins = essb_option_value('opengraph_tags_fbadmins');
			$this->fbpage = essb_option_value('opengraph_tags_fbpage');
			$this->fbapp = essb_option_value('opengraph_tags_fbapp');
			$this->fb_author_profile = essb_option_value('opengraph_tags_fbauthor');
			$this->sso_fixhttps = essb_option_bool_value('sso_httpshttp');
			$this->sso_imagesize= essb_option_bool_value('sso_imagesize');
		}
				
		if (essb_option_bool_value('twitter_card')) {
			$this->twitter_cards_active = true;
			$this->card_type = essb_option_value('twitter_card_type');
			$this->twitter_user = essb_option_value('twitter_card_user');
		}
				
		if ($this->ogtags_active || $this->twitter_cards_active) {
			$this->sso_active = true;
		}
	}
	
	private function loadPostSettings() {
		if (is_single () || is_page ()) {
			easy_share_deactivate();
			
			// loading post default data
			$this->post_title = trim( essb_core_convert_smart_quotes( htmlspecialchars_decode(get_the_title ())));;
			$this->site_name = get_bloginfo('name');
			$this->post_url = get_permalink(get_the_ID());
			
			
			$this->post_description = trim( essb_core_convert_smart_quotes( htmlspecialchars_decode(essb_core_get_post_excerpt(get_the_ID()))));
			
			if (defined('WPSEO_VERSION')) {
			
				// Collect their Social Descriptions as backups if they're not defined in ours
				$this->yoast_og_title 		= get_post_meta( get_the_ID(), '_yoast_wpseo_opengraph-title' , true );
				$this->yoast_og_description 	= get_post_meta( get_the_ID(), '_yoast_wpseo_opengraph-description' , true );
				$this->yoast_og_image 		= get_post_meta( get_the_ID(), '_yoast_wpseo_opengraph-image' , true );
				
				// Collect their SEO fields as 3rd string backups in case we need them
				$this->yoast_seo_title		= get_post_meta( get_the_ID(), '_yoast_wpseo_title' , true );
				$this->yoast_seo_description	= get_post_meta( get_the_ID(), '_yoast_wpseo_metadesc' , true );			
				
				if (empty($this->yoast_og_description)) {
					$this->yoast_og_description = $this->yoast_seo_description;
				}
				if (empty($this->yoast_og_title)) {
					$this->yoast_og_title = $this->yoast_seo_title;
				}
			}
			
			$this->post_image = essb_core_get_post_featured_image(get_the_ID());
				
			if ($this->post_image == "") {
				$this->post_image = $this->default_image;
			}
			
			// end loading post defaults
			
			if ($this->ogtags_active) {
				$this->fb_description = get_post_meta ( get_the_ID(), 'essb_post_og_desc', true );
				$this->fb_title = get_post_meta ( get_the_ID(), 'essb_post_og_title', true );
				$this->fb_image = get_post_meta ( get_the_ID(), 'essb_post_og_image', true );
				
				$this->fb_image1 = get_post_meta ( get_the_ID(), 'essb_post_og_image1', true );
				$this->fb_image2 = get_post_meta ( get_the_ID(), 'essb_post_og_image2', true );
				$this->fb_image3 = get_post_meta ( get_the_ID(), 'essb_post_og_image3', true );
				$this->fb_image4 = get_post_meta ( get_the_ID(), 'essb_post_og_image4', true );
				
				// since 2.0
				$this->fb_video_url = get_post_meta ( get_the_ID(), 'essb_post_og_video', true );
				$this->fb_video_h = get_post_meta ( get_the_ID(), 'essb_post_og_video_h', true );
				$this->fb_video_w = get_post_meta ( get_the_ID(), 'essb_post_og_w', true );
				
				$onpost_fb_authorship = get_post_meta (get_the_ID(), 'essb_post_og_author', true);
				
				if (!empty($onpost_fb_authorship)) {
					$this->fb_author_profile = get_post_meta ( get_the_ID(), 'essb_post_og_author', true);
				}
				
				if (empty($this->fb_description) && !empty($this->yoast_og_description)) {
					$this->fb_description = $this->yoast_og_description;
				} 

				if (empty($this->fb_title) && !empty($this->yoast_og_title)) {
					$this->fb_title = $this->yoast_og_title;
				}
				
				if (empty($this->fb_image) && !empty($this->yoast_og_image)) {
					$this->fb_image = $this->yoast_og_image;
				}
				
				if ($this->fb_description == "") {
					$this->fb_description = $this->post_description;
				}				
				if ($this->fb_title == "") {
					$this->fb_title = $this->post_title;
				}
				if ($this->fb_image == "") {
					$this->fb_image = $this->post_image;
				}
				
				if ($this->sso_imagesize) {
					if ( has_post_thumbnail( get_the_ID() ) ) {
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'original' );
					
						if ( $this->check_featured_image_size( $thumb ) ) {
					
							$this->fb_image_width  = $thumb[1];
							$this->fb_image_height = $thumb[2];
						}
					}
				}
			}
			
			if ($this->twitter_cards_active) {
				$this->twitter_description =  get_post_meta(get_the_ID(),'essb_post_twitter_desc',true);
				$this->twitter_title =  get_post_meta(get_the_ID(),'essb_post_twitter_title',true);
				$this->twitter_image =  get_post_meta(get_the_ID(),'essb_post_twitter_image',true);
				
				if ($this->twitter_description == "") {
					$this->twitter_description = $this->fb_description;
				}
				if ($this->twitter_title == "") {
					$this->twitter_title = $this->fb_title;
				}
				if ($this->twitter_image == "") {
					$this->twitter_image = $this->fb_image;
				}
				
				if (empty($this->twitter_description) && !empty($this->yoast_og_description)) {
					$this->twitter_description = $this->yoast_og_description;
				}
				
				if (empty($this->twitter_title) && !empty($this->yoast_og_title)) {
					$this->twitter_title = $this->yoast_og_title;
				}
				
				if (empty($this->twitter_image) && !empty($this->yoast_og_image)) {
					$this->twitter_image = $this->yoast_og_image;
				}
				
				if ($this->twitter_image == "") {
					$this->twitter_image = $this->post_image;
				}				
				
				if ($this->twitter_description == "") {
					$this->twitter_description = $this->post_description;
				}
				if ($this->twitter_title == "") {
					$this->twitter_title = $this->post_title;
				}
			}
			
			
			easy_share_reactivate();
		
		}
		
	}
	
	public function loadFrontpageTags() {
		if (is_front_page()) {
			$fp_title = essb_option_value('sso_frontpage_title');
			$fp_description = essb_option_value('sso_frontpage_description');
			$fp_image = essb_option_value('sso_frontpage_image');
			
			$this->fb_description = $fp_description;
			$this->fb_title = $fp_title;
			$this->fb_image = $fp_image;
			
			$this->twitter_description = $fp_description;
			$this->twitter_title = $fp_title;
			$this->twitter_image = $fp_image;
			
			// @updated in 4.2 to be get_bloginfo instead of get_site_url
			$this->post_url = get_bloginfo('url');
		}
	}
	
	public function insertLanguageAttributes($content) {
		if ($this->ogtags_active) {
			if ($this->fbadmins != '' || $this->fbapp != '') {
				$content .= ' prefix="og: http://ogp.me/ns#  fb: http://ogp.me/ns/fb#"';
			} else {
				$content .= ' prefix="og: http://ogp.me/ns#"';
			}
		}
		

		return $content;
	}
	
	public function outputMeta() {
		global $post;
		
		if (essb_is_module_deactivated_on('sso')) {
			return "";
		}
		
		$cache_key = "";
		if (isset($post)) {
			
			$cache_key = "essb_ogtags_".$post->ID;
			
			if (defined('ESSB_CACHE_ACTIVE')) {
				$cached_data = ESSBCache::get($cache_key);
					
				if ($cached_data != '') {
					echo "\r\n";
					echo $cached_data;
					echo "\r\n";
					return;
				}
			}
		}
		
		$this->loadPostSettings();
		
		// @since 3.3 front page optimization tags
		$this->loadFrontpageTags();
		
		if ($this->ogtags_active) {
			$this->buildFacebookMeta();
		}
		if ($this->twitter_cards_active) {
			$this->buildTwitterMeta();
		}
		
		
		$output_meta = "";
		
		echo "\r\n";
		foreach ($this->meta as $single) {
			$output_meta .= $single."\r\n";
		}
		echo $output_meta;
		echo "\r\n";
		
		if (defined('ESSB_CACHE_ACTIVE')) {
			if ($cache_key != '') {
				ESSBCache::put($cache_key, $output_meta);
			}
		}
	}
	
	// Twitter
	
	private function buildTwitterMeta() {
		if ($this->card_type == "") {
			$this->card_type = "summary";
		}
		else if ($this->card_type == "summaryimage") {
			$this->card_type = "summary_large_image";
		}
		
		$this->twitterMetaTagBuilder('card', $this->card_type);
		if ($this->twitter_user != '') { 
			$this->twitterMetaTagBuilder('site', '@'.$this->twitter_user);
		}
		$this->twitterMetaTagBuilder('title', $this->twitter_title, true);
		$this->twitterMetaTagBuilder('description', $this->twitter_description);
		//$this->twitterMetaTagBuilder('site', $this->card_type);
		$this->twitterMetaTagBuilder('url', $this->post_url);
		
		if ($this->card_type == "summary_large_image" && $this->twitter_image != '') {
			$this->twitterMetaTagBuilder('image:src', $this->twitter_image);
		}
		$this->twitterMetaTagBuilder('domain', $this->site_name, true);
	}
	
	private function twitterMetaTagBuilder($property = '', $value = '', $apply_filters = false, $prefix = 'twitter') {
		if ($apply_filters) {
			$value = str_replace ( '\'', "&#8217;", $value );
			$value = str_replace ( '"', "&qout;", $value );
			
			$value = addslashes(strip_tags($value));
		}
		
		if ($property != '' && $value != '') {
			$this->meta[] = '<meta property="'.$prefix.':'.$property.'" content="'.$value.'" />';
		}
	}
	
	// Facebook
	
	private function buildFacebookMeta() {
		$this->openGraphMetaTagBuilder('app_id', $this->fbapp, false, 'fb');
		$this->openGraphMetaTagBuilder('admins', $this->fbadmins, false, 'fb');
		
		$this->openGraphMetaTagBuilder('title', $this->fb_title, true);
		$this->openGraphMetaTagBuilder('description', $this->fb_description, true);
		
		if ($this->sso_fixhttps) {
			$this->post_url = str_replace('https://', 'http://', $this->post_url);
		}
		
		$this->openGraphMetaTagBuilder('url', $this->post_url);
		$this->openGraphMetaTagBuilder('image', $this->fb_image);
		
		if ($this->fb_image1 != '') {
			$this->openGraphMetaTagBuilder('image', $this->fb_image1);
		}
		if ($this->fb_image2 != '') {
			$this->openGraphMetaTagBuilder('image', $this->fb_image2);
		}
		if ($this->fb_image3 != '') {
			$this->openGraphMetaTagBuilder('image', $this->fb_image3);
		}
		if ($this->fb_image4 != '') {
			$this->openGraphMetaTagBuilder('image', $this->fb_image4);
		}
		
		// image width & height
		if ($this->sso_imagesize) {
			if ($this->fb_image_width != '') {
				$this->openGraphMetaTagBuilder('image:width', esc_attr(absint($this->fb_image_width)), false);
			}
			if ($this->fb_image_height != '') {
				$this->openGraphMetaTagBuilder('image:height', esc_attr(absint($this->fb_image_height)), false);
			}
		}
		
		$content_type = (is_single () || is_page ()) ? "article" : "website";
		$this->openGraphMetaTagBuilder('type', $content_type);
		$this->openGraphMetaTagBuilder('site_name', $this->site_name, true);
		
		// @since 2.0 output video meta tags
		if ($this->fb_video_url != '') {
			$this->openGraphMetaTagBuilder('video', esc_url($this->fb_video_url), false);
			$this->openGraphMetaTagBuilder('video:secure_url', esc_url($this->fb_video_url), false);
			$this->openGraphMetaTagBuilder('video:height', esc_attr($this->fb_video_h), false);
			$this->openGraphMetaTagBuilder('video:width', esc_attr($this->fb_video_w), false);
			//$this->openGraphMetaTagBuilder('video:type', 'application/x-shockwave-flash', false);
			$this->openGraphMetaTagBuilder('video:type', 'video/mp4', false);
		}
		
		if ($this->fb_author_profile != '') {
			$this->openGraphMetaTagBuilder('author', esc_attr($this->fb_author_profile), false, 'article');
		}
		
		// only for posts
		if (is_singular () && !is_front_page() ) {
			// @since 4.2 strip those tags as they are not really needed into Facebook sharing
			// anymore
			//$this->og_tags();
			//$this->og_category();
			$this->og_publish_date();
			if ($this->fbpage != '') {
				$this->openGraphMetaTagBuilder('publisher', $this->fbpage, false, 'article');
			}		
		}
	}
	
	private function openGraphMetaTagBuilder($property = '', $value = '', $apply_filters = false, $prefix = 'og') {
		if ($apply_filters) {
			
			$value = str_replace ( '\'', "&#8217;", $value );
			$value = str_replace ( '"', "&qout;", $value );
			$value = addslashes(strip_tags($value));
		}
		
		if ($property != '' && $value != '') {
			$this->meta[] = '<meta property="'.$prefix.':'.$property.'" content="'.$value.'" />';
		}
		
	}
	
	function og_tags() {
		if (! is_singular ()) {
			return;
		}
	
		$tags = get_the_tags ();
		if (! is_wp_error ( $tags ) && (is_array ( $tags ) && $tags !== array ())) {
			foreach ( $tags as $tag ) {
				$this->openGraphMetaTagBuilder('tag', $tag->name, false, 'article');
			}
		}
	}
	
	public function og_category() {
		if ( ! is_singular() ) {
			return;
		}
	
		$terms = get_the_category();
		if ( ! is_wp_error( $terms ) && ( is_array( $terms ) && $terms !== array() ) ) {
			foreach ( $terms as $term ) {
				$this->openGraphMetaTagBuilder('section', $term->name, false, 'article');
			}
		}
	}
	
	public function og_publish_date() {
		if ( ! is_singular() ) {
			return;
		}
	
		$pub = get_the_date( 'c' );
		$this->openGraphMetaTagBuilder('published_time', $pub, false, 'article');
	
		$mod = get_the_modified_date( 'c' );
		if ( $mod != $pub ) {
			$this->openGraphMetaTagBuilder('modified_time', $mod, false, 'article');
			$this->openGraphMetaTagBuilder('updated_time', $mod);
		}
	}
	
	private function check_featured_image_size( $img_data ) {
	
		if ( ! is_array( $img_data ) ) {
			return false;
		}
	
		// Get the width and height of the image.
		if ( $img_data[1] < 200 || $img_data[2] < 200 ) {
			return false;
		}
	
		return true;
	}
}

?>