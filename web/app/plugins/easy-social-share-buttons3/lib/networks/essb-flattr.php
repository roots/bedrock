<?php

class ESSBNetworks_Flattr {
	const version = "1.0.0";
	
	protected static $instance;
	
	public static function getInstance() {
		if (! isset ( self::$instance )) {
			try {
				self::$instance = new self ();
			} catch ( Exception $e ) {				
				self::$instance = false;
			}
		}
		return self::$instance;
	}
	
	protected static $languages;
	public static function getLanguages() {
		if (empty(self::$languages)) {
			self::$languages['sq_AL'] = 'Albanian';
			self::$languages['ar_DZ'] = 'Arabic';
			self::$languages['be_BY'] = 'Belarusian';
			self::$languages['bg_BG'] = 'Bulgarian';
			self::$languages['ca_ES'] = 'Catalan';
			self::$languages['zh_CN'] = 'Chinese';
			self::$languages['hr_HR'] = 'Croatian';
			self::$languages['cs_CZ'] = 'Czech';
			self::$languages['da_DK'] = 'Danish';
			self::$languages['nl_NL'] = 'Dutch';
			self::$languages['en_GB'] = 'English';
			self::$languages['et_EE'] = 'Estonian';
			self::$languages['fi_FI'] = 'Finnish';
			self::$languages['fr_FR'] = 'French';
			self::$languages['de_DE'] = 'German';
			self::$languages['el_GR'] = 'Greek';
			self::$languages['iw_IL'] = 'Hebrew';
			self::$languages['hi_IN'] = 'Hindi';
			self::$languages['hu_HU'] = 'Hungarian';
			self::$languages['is_IS'] = 'Icelandic';
			self::$languages['in_ID'] = 'Indonesian';
			self::$languages['ga_IE'] = 'Irish';
			self::$languages['it_IT'] = 'Italian';
			self::$languages['ja_JP'] = 'Japanese';
			self::$languages['ko_KR'] = 'Korean';
			self::$languages['lv_LV'] = 'Latvian';
			self::$languages['lt_LT'] = 'Lithuanian';
			self::$languages['mk_MK'] = 'Macedonian';
			self::$languages['ms_MY'] = 'Malay';
			self::$languages['mt_MT'] = 'Maltese';
			self::$languages['no_NO'] = 'Norwegian';
			self::$languages['pl_PL'] = 'Polish';
			self::$languages['pt_PT'] = 'Portuguese';
			self::$languages['ro_RO'] = 'Romanian';
			self::$languages['ru_RU'] = 'Russian';
			self::$languages['sr_RS'] = 'Serbian';
			self::$languages['sk_SK'] = 'Slovak';
			self::$languages['sl_SI'] = 'Slovenian';
			self::$languages['es_ES'] = 'Spanish';
			self::$languages['sv_SE'] = 'Swedish';
			self::$languages['th_TH'] = 'Thai';
			self::$languages['tr_TR'] = 'Turkish';
			self::$languages['uk_UA'] = 'Ukrainian';
			self::$languages['vi_VN'] = 'Vietnamese';
		}
	
		return self::$languages;
	}
	
	protected static $categories;
	public static function getCategories() {
		if (empty(self::$categories)) {
			self::$categories = array('text', 'images', 'audio', 'video', 'software', 'rest');
		}
		return self::$categories;
	}
	
	public static function getStaticFlattrUrl($share = array()) {
		global $post, $essb_options;
		
		$options = $essb_options;
		
		$id = $post->ID;
		$md5 = md5($share['title']);
		
		$flattr_username = isset($options['flattr_username']) ? $options['flattr_username'] : '';
		$flattr_tags = isset($options['flattr_tags']) ? $options['flattr_tags'] : '';
		$flattr_cat = isset($options['flattr_cat']) ? $options['flattr_cat'] : 'text';
		$flattr_lang = isset($options['flattr_lang']) ? $options['flattr_lang'] : 'en_GB';
		
		$flattr_url = "";
		
		$url = $share['url'];
		$tagsA = get_the_tags($post->ID);
		$tags = "";
		if (!empty($tagsA)) {
			foreach ($tagsA as $tag) {
				if (strlen($tags)>0){
					$tags .=",";
				}
				$tags .= $tag->name;
			}
		}
		
		if ($flattr_tags != '') { $tags .= ",".$flattr_tags; }
		$tags = trim($tags, ', ');
		
		
		$content = preg_replace(array('/\<br\s*\/?\>/i',"/\n/","/\r/", "/ +/"), " ", self::getExcerpt($post));
		$content = strip_tags($content);
		
		if (strlen(trim($content)) == 0) {
			$content = "(no content provided...)";
		}
		
		$title = strip_tags($share['title']);
		$hidden = "0";
		
		$flattr_domain = 'flattr.com';
		
		$location = "https://" . $flattr_domain . "/submit/auto?user_id=".urlencode($flattr_username).
		"&url=".urlencode($url).
		"&title=".urlencode($title).
		"&description=".urlencode($content).
		"&language=".  urlencode($flattr_lang).
		"&tags=". urlencode($tags).
		"&hidden=". $hidden.
		"&category=".  urlencode($flattr_cat);
		
		return $location;
	}
	
	public static function getExcerpt($post, $excerpt_max_length = 1024) {
	
		$excerpt = $post->post_excerpt;
		if (trim($excerpt) == "") {
			$excerpt = $post->post_content;
		}
	
		$excerpt = strip_shortcodes($excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
	
		// Hacks for various plugins
		$excerpt = preg_replace('/httpvh:\/\/[^ ]+/', '', $excerpt); // hack for smartyoutube plugin
		$excerpt = preg_replace('%httpv%', 'http', $excerpt); // hack for youtube lyte plugin
	
		// Try to shorten without breaking words
		if ( strlen($excerpt) > $excerpt_max_length ) {
			$pos = strpos($excerpt, ' ', $excerpt_max_length);
			if ($pos !== false) {
				$excerpt = substr($excerpt, 0, $pos);
			}
		}
	
		// If excerpt still too long
		if (strlen($excerpt) > $excerpt_max_length) {
			$excerpt = substr($excerpt, 0, $excerpt_max_length);
		}
	
		return $excerpt;
	}
	
}

?>