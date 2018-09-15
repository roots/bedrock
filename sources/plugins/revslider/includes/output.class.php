<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderOutput {

	private static $sliderSerial = 0;
	
	private $sliderHtmlID;
	private $sliderHtmlID_wrapper;
	private $markup_export = false;
	private $oneSlideMode = false;
	private $oneSlideData;
	private $previewMode = false;	//admin preview mode
	private $slidesNumIndex;
	private $sliderLang = 'all';
	private $hasOnlyOneSlide = false;
	private $rev_inline_js = '';
	public $rev_custom_navigation_css = '';
	public $slider;
	public $static_slide = array();
	public $class_include = array();

	//START transfered from the layer add process and some of these are only filled if putSlides() is called
	public $zIndex = 5;
	public $in_class_usage = array();
	public $enabled_sizes = array();
	public $adv_resp_sizes = array();
	public $icon_sets = array();//RevSliderBase::set_icon_sets(array());
	public $ignore_styles = array('font-family', 'color', 'font-weight', 'font-style', 'text-decoration');
	public $customAnimations = array();//RevSliderOperations::getCustomAnimations('customin'); //get all custom animations
	public $customEndAnimations = array();//RevSliderOperations::getCustomAnimations('customout'); //get all custom animations
	public $startAnimations = array();//RevSliderOperations::getArrAnimations(false); //only get the standard animations
	public $endAnimations = array();//RevSliderOperations::getArrEndAnimations(false); //only get the standard animations
	public $slideID = 0;
	public $slide;
	public $layers;
	public $container_mode = '';
	public $row_zindex = 0;
	//END transfered from the layer add process and some of these are only filled if putSlides() is called
	
	/**
	 *
	 * check the put in string
	 * return true / false if the put in string match the current page.
	 */
	public static function isPutIn($putIn,$emptyIsFalse = false){
	
		$putIn = strtolower($putIn);
		$putIn = trim($putIn);

		if($emptyIsFalse && empty($putIn))
			return(false);
		
		if($putIn == 'homepage'){		//filter by homepage
			if(is_front_page() == false && is_home() == false)
				return(false);
		}else{//case filter by pages
			if(!empty($putIn)){
				$arrPutInPages = array();
				$arrPagesTemp = explode(",", $putIn);
				foreach($arrPagesTemp as $page){
					$page = trim($page);
					if(is_numeric($page) || $page == 'homepage')
						$arrPutInPages[] = $page;
				}
				if(!empty($arrPutInPages)){

					//get current page id
					$currentPageID = "";
					if(is_front_page() == true || is_home() == true){
						$currentPageID = 'homepage';
					}else{
						global $post;
						if(isset($post->ID))
							$currentPageID = $post->ID;
					}

					//do the filter by pages
					if(array_search($currentPageID, $arrPutInPages) === false)
						return(false);
				}
			}
		}

		return(true);
	}


	/**
	 * put the rev slider slider on the html page.
	 * @param $data - mixed, can be ID ot Alias.
	 */
	public static function putSlider($sliderID,$putIn="", $gal_ids = array(), $settings = array(), $order = array()){
		$settings = apply_filters('revslider_modify_slider_settings', $settings, $sliderID);
		
		$isPutIn = self::isPutIn($putIn);
		if($isPutIn == false)
			return(false);
		
		//check if on mobile and if option hide on mobile is set

		$output = new RevSliderOutput();

		$output->putSliderBase($sliderID, $gal_ids, false, $settings, $order);

		$slider = $output->getSlider();
		return($slider);
	}

	
	public function getSliderHtmlID(){
		return $this->sliderHtmlID;
	}
	
	
	/**
	 * set language
	 */
	public function setLang($lang){
		$this->sliderLang = $lang;
	}

	/**
	 *
	 * set one slide mode for preview
	 */
	public function setOneSlideMode($data){
		$this->oneSlideMode = true;
		$this->oneSlideData = $data;
	}

	/**
	 *
	 * set preview mode
	 */
	public function setPreviewMode(){
		$this->previewMode = true;
	}

	/**
	 *
	 * get the last slider after the output
	 */
	public function getSlider(){
		return($this->slider);
	}

	/**
	 *
	 * get slide full width video data
	 */
	private function getSlideFullWidthVideoData(RevSliderSlide $slide){

		$response = array('found' => false);

		//deal full width video:
		$enableVideo = $slide->getParam('enable_video', 'false');
		if($enableVideo != 'true')
			return($response);

		$videoID = $slide->getParam('video_id', '');
		$videoID = trim($videoID);

		if(empty($videoID))
			return($response);

		$response["found"] = true;

		$videoType = is_numeric($videoID) ? 'vimeo' : 'youtube';
		$videoAutoplay = $slide->getParam('video_autoplay', false);
		$videoCover = $slide->getParam('cover', false);
		$videoAutoplayOnlyFirstTime = $slide->getParam('autoplayonlyfirsttime', false);
		$previewimage = $slide->getParam('previewimage', '');
		$videoNextslide = $slide->getParam('video_nextslide', 'off');
		$mute = $slide->getParam('mute', false);

		$response['type'] = $videoType;
		$response['videoID'] = $videoID;
		$response['autoplay'] = RevSliderFunctions::strToBool($videoAutoplay);
		$response['cover'] = RevSliderFunctions::strToBool($videoCover);
		$response['autoplayonlyfirsttime'] = RevSliderFunctions::strToBool($videoAutoplayOnlyFirstTime);
		$response['previewimage'] = RevSliderFunctions::strToBool($previewimage);
		$response['nextslide'] = ($videoNextslide == 'on') ? true : false;
		$response['mute'] = RevSliderFunctions::strToBool($mute);

		return($response);
	}
	
	
	/**
	 * Get the Hero Slide of the Slider
	 * @since: 5.0
	 */
	private function getHeroSlide($slides){
		$hero_id = $this->slider->getParam('hero_active', -1);
		
		
		if(empty($slides)) return $slides;
		
		foreach($slides as $slide){
			$slideID = $slide->getID();
			
			if($slideID == $hero_id){
				return $slide;
			}
			if($this->sliderLang !== 'all'){
				if($slide->getParentSlideID() == $hero_id){
					return $slide;
				}
			}
		}
		
		//could not be found, use first slide
		foreach($slides as $slide){
			return $slide;
		}
	}
	
	/**
	 *
	 * filter the slides for one slide preview
	 */
	private function filterOneSlide($slides){

		$oneSlideID = $this->oneSlideData['slideid'];
		
		
		if(strpos($oneSlideID, 'static_') !== false){
			global $wpdb;
			$sliderID = str_replace('static_', '', $oneSlideID);
			
			$tmp_slides = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".RevSliderGlobals::$table_static_slides." WHERE slider_id = %s", array($sliderID)), ARRAY_A);
			
			if(!empty($tmp_slides)){
				$n_slides = new RevSliderSlide();
				$n_slides->initByData($tmp_slides[0]);
				
				$slides[0] = $n_slides;
				$oneSlideID = $n_slides->getID();
			}
		}

		$oneSlideParams = RevSliderFunctions::getVal($this->oneSlideData, 'params');
		$oneSlideLayers = RevSliderFunctions::getVal($this->oneSlideData, 'layers');
		
		if(gettype($oneSlideParams) == 'object')
			$oneSlideParams = (array)$oneSlideParams;

		if(gettype($oneSlideLayers) == 'object')
			$oneSlideLayers = (array)$oneSlideLayers;

		if(!empty($oneSlideLayers))
			$oneSlideLayers = RevSliderFunctions::convertStdClassToArray($oneSlideLayers);

		$newSlides = array();
		foreach($slides as $slide){
			$slideID = $slide->getID();
			
			if($slideID == $oneSlideID){

				if(!empty($oneSlideParams))
					$slide->setParams($oneSlideParams);

				if(!empty($oneSlideLayers))
					$slide->setLayers($oneSlideLayers);

				$newSlides[] = $slide;	//add 2 slides
				$newSlides[] = $slide;
			}
		}

		return($newSlides);
	}


	/**
	 *
	 * put the slider slides
	 */
	private function putSlides($gal_ids = array(), $order = array()){
		//go to template slider if post template
		$sliderType = $this->slider->getParam('slider_type');
		$slider_type = $this->slider->getParam('slider-type'); //standard, carousel or hero
		$source_type = $this->slider->getParam('source_type'); //vimeo, post ect.
		
		$publishedOnly = true;
		if($slider_type == 'hero' || !empty($order)){
			$publishedOnly = false; //take all, even unpublished ones
		}
		
		if($this->previewMode == true && $this->oneSlideMode == true){
			$previewSlideID = RevSliderFunctions::getVal($this->oneSlideData, 'slideid');
			$previewSlide = new RevSlide();
			$previewSlide->initByID($previewSlideID);
			$slides = array($previewSlide);
			
			$slides = $this->filterOneSlide($slides);
			
		}else{
			$slides = $this->slider->getSlidesForOutput($publishedOnly,$this->sliderLang,$gal_ids);
			
			if(!empty($gal_ids) && $gal_ids[0]){ //add slides from the images
				if(count($slides) > 0){ //check if we have at least one slide. If not, then it may result in errors here
					if(count($gal_ids) !== count($slides)){ //set slides to the same amount as
						if(count($gal_ids) < count($slides)){
							$slides = array_slice($slides, 0, count($gal_ids));
						}else{ // >
							while(count($slides) < count($gal_ids)){
								foreach($slides as $slide){
									$new_slide = clone $slide;
									array_push($slides, $new_slide);
									if(count($slides) >= count($gal_ids)) break;
								}
							}
							if(count($gal_ids) < count($slides)){
								$slides = array_slice($slides, 0, count($gal_ids));
							}
						}
					}
					
					$sliderSize = $this->slider->getParam('def-image_source_type', 'full');
					
					$isSlidesFromPosts = $this->slider->isSlidesFromPosts();
					
					$gi = 0;
					foreach($slides as $skey => $slide){ //add gallery images into slides
						//set post id to imageid
						
						//check if slider is Post Based, if yes use $slide->getID(); else use $gal_ids[$gi]
						if($isSlidesFromPosts){
							$ret = $slide->setImageByID($slide->getID(), $sliderSize);
						}else{
							$ret = $slide->setImageByID($gal_ids[$gi], $sliderSize);
						}
						if($ret === true){ //set slide type to image instead of for example external or transparent
							$slide->setBackgroundType('image');
						}else{
							unset($slides[$skey]);
						}
						
						$gi++;
					}
				}
			}elseif(!empty($order)){
				$tempSlides = $slides;
				$slides = array();
				
				foreach($order as $order_slideid){
					foreach($tempSlides as $tempSlide){
						if($tempSlide->getID() == $order_slideid){
							$tempSlide->setParam('state', 'published'); //set to published
							$slides[] = $tempSlide;
							break;
						}
					}
				}
				
				if(count($slides) == 1){ //remove navigation
					$this->slider->setParam('enable_arrows', 'off');
					$this->slider->setParam('enable_bullets', 'off');
					$this->slider->setParam('enable_tabs', 'off');
					$this->slider->setParam('enable_thumbnails', 'off');
				}
			}
		}
		
		$this->slidesNumIndex = $this->slider->getSlidesNumbersByIDs(true);
		
		if($slider_type == 'hero' && empty($order) && empty($gal_ids)){ //we are a hero Slider, show only one Slide!
			$hero = $this->getHeroSlide($slides);
			$slides = (!empty($hero)) ? array($hero) : array();
		}
		
		//check if mobile, if yes, then remove certain slides
		$usragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$mobile = (strstr($usragent,'Android') || strstr($usragent,'webOS') || strstr($usragent,'iPhone') ||strstr($usragent,'iPod') || strstr($usragent,'iPad') || strstr($usragent,'Windows Phone') || wp_is_mobile()) ? true : false;
		if($mobile && !empty($slides)){
			foreach($slides as $ss => $sv){
				$hsom = $sv->getParam('hideslideonmobile', 'off');
				if($hsom == 'on'){
					unset($slides[$ss]);
				}
			}
		}
		
		if(empty($slides)){
			?>
			<div class="no-slides-text">
				<?php
				if($this->slider->isSlidesFromPosts()){
					_e('No slides found, please add at least one Slide Template to the choosen language.', 'revslider');
				}else{
					_e('No slides found, please add some slides', 'revslider');
				}
				?>
			</div>
			<?php
		}

		//set that we are originally template slider
		$post_based_slider = false;
		if($this->slider->isSlidesFromPosts()){
			$post_based_slider = true;
		}
		
		$slideWidth = $this->slider->getParam('width',900);
		$slideHeight = $this->slider->getParam('height',300);
		
		$do_bullets = $this->slider->getParam('enable_bullets','off');
		$do_thumbnails = $this->slider->getParam('enable_thumbnails','off');
		$do_arrows = $this->slider->getParam('enable_arrows','off');
		$do_tabs = $this->slider->getParam('enable_tabs','off');
		$isThumbsActive = ($do_bullets == 'on' || $do_thumbnails == 'on' || $do_arrows == 'on' || $do_tabs == 'on') ? true : false;

		$lazyLoad = $this->slider->getParam('lazy_load_type', false);
		if($lazyLoad === false){ //do fallback checks to removed lazy_load value since version 5.0 and replaced with an enhanced version
			$old_ll = $this->slider->getParam('lazy_load', 'off');
			$lazyLoad = ($old_ll == 'on') ? 'all' : 'none';
		}
		
		//for one slide preview
		//if($this->oneSlideMode == true)
		//	$slides = $this->filterOneSlide($slides);

		echo "<ul>";

		$htmlFirstTransWrap = "";

		$startWithSlide = $this->slider->getStartWithSlideSetting();

		$firstTransActive = $this->slider->getParam('first_transition_active', 'false');
		
		if($firstTransActive == 'on' && $slider_type !== 'hero'){

			$firstTransition = $this->slider->getParam('first_transition_type', 'fade');
			$htmlFirstTransWrap .= ' data-fstransition="'.$firstTransition.'"';

			$firstDuration = $this->slider->getParam('first_transition_duration', '300');
			if(!empty($firstDuration) && is_numeric($firstDuration))
				$htmlFirstTransWrap .= ' data-fsmasterspeed="'.$firstDuration.'"';

			$firstSlotAmount = $this->slider->getParam('first_transition_slot_amount', '7');
			if(!empty($firstSlotAmount) && is_numeric($firstSlotAmount))
			$htmlFirstTransWrap .= ' data-fsslotamount="'.$firstSlotAmount.'"';

		}
		
		$oneSlideLoop = $this->slider->getParam("loop_slide","loop");
		
		if(($oneSlideLoop == 'loop' || $oneSlideLoop == 'on') && $slider_type !== 'hero'){
			if(count($slides) == 1 && $this->oneSlideMode == false){
				$new_slide = clone(reset($slides));
				$new_slide->ignore_alt = true;
				$new_slide->setID($new_slide->getID().'-1');

				$slides[] = $new_slide;
				$this->hasOnlyOneSlide = true;
			}
		}

		if(count($slides) == 0) return false; // No Slides added yet
		
		$def_transition = $this->slider->getParam('def-slide_transition', 'fade');
		$def_image_source_type = $this->slider->getParam('def-image_source_type', 'full');
		
		$do_static = apply_filters('revslider_enable_static_layers', true);
		
		if($do_static){
			$sliderID = $this->slider->getID();
			foreach($slides as $slide){
				$staticID = $slide->getStaticSlideID($sliderID);
				if($staticID !== false){
					$static_slide = new RevSlide();
					$static_slide->initByStaticID($staticID);
					$this->static_slide = $static_slide;
				}
				break;
			}
		}
		
		$index = 0;
		foreach($slides as $slide){
			
			$params = $slide->getParams();

			$navigation_arrow_stlye = $this->slider->getParam('navigation_arrow_style', 'round');
			$navigation_bullets_style = $this->slider->getParam('navigation_bullets_style', 'round');

			//check if date is set
			$date_from = $slide->getParam('date_from', '');
			$date_to = $slide->getParam('date_to', '');
			
			if($this->previewMode === false){ // do only if we are not in preview mode
				$ts = current_time('timestamp');
					
				if($date_from != ''){
					$date_from = strtotime($date_from);
					if($ts < $date_from) continue;
				}
				
				if($date_to != ''){
					$date_to = strtotime($date_to);
					if($ts > $date_to) continue;
				}
			}
			
			$transition = $slide->getParam('slide_transition', $def_transition);
			
			if(!is_array($transition)){
				$transition_arr = explode(',', $transition);
			}else{
				$transition_arr = $transition;
				$transition = implode(',', $transition);
			}
			
			
			$add_rand = '';
			if(is_array($transition_arr) && !empty($transition_arr)){
				foreach($transition_arr as $tkey => $trans){
					if($trans == 'random-selected'){
						$add_rand = ' data-randomtransition="on"';
						unset($transition_arr[$tkey]);
						$transition = implode(',', $transition_arr);
						break;
					}
				}
			}
			
			$slotAmount = $slide->getParam('slot_amount', '7');
			if(is_array($slotAmount)) $slotAmount = implode(',', $slotAmount);
			
			$imageAddParams = '';
			
			$isExternal = $slide->getParam('background_type', 'image');
			if($isExternal != 'external'){
				$urlSlideImage = $slide->getImageUrl();
				
				//get image alt
				$alt_type = $slide->getParam('alt_option', 'media_library');
				$title_type = $slide->getParam('title_option', 'media_library');
				
				$alt = '';
				$img_title = '';
				$img_id = $slide->getImageID();
				
				switch($alt_type){
					case 'media_library':
						$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
					break;
					case 'file_name':
						$imageFilename = $slide->getImageFilename();
						$info = pathinfo($imageFilename);
						$alt = $info['filename'];
					break;
					case 'custom':
						$alt = esc_attr($slide->getParam('alt_attr', ''));
					break;
				}
				
				switch($title_type){
					case 'media_library':
						$img_title = get_the_title($img_id);
					break;
					case 'file_name':
						$imageFilename = $slide->getImageFilename();
						$info = pathinfo($imageFilename);
						$img_title = $info['filename'];
					break;
					case 'custom':
						$img_title = esc_attr($slide->getParam('title_attr', ''));
					break;
				}
				
				$img_w = '';
				$img_h = '';
				
				$img_size = $slide->getParam('image_source_type', $def_image_source_type);
				
				if($img_id !== false){
					$img_data = wp_get_attachment_metadata( $img_id );
					if($img_data !== false && !empty($img_data)){
						if($img_size !== 'full'){
							if(isset($img_data['sizes']) && isset($img_data['sizes'][$img_size])){
								$img_w = (isset($img_data['sizes'][$img_size]['width'])) ? $img_data['sizes'][$img_size]['width'] : '';
								$img_h = (isset($img_data['sizes'][$img_size]['height'])) ? $img_data['sizes'][$img_size]['height'] : '';
							}
						}
						
						if($img_w == '' || $img_h == ''){
							$img_w = (isset($img_data['width'])) ? $img_data['width'] : '';
							$img_h = (isset($img_data['height'])) ? $img_data['height'] : '';
						}
						$imageAddParams .= ' width="'.$img_w.'" height="'.$img_h.'"';
					}
				}
				
			}else{
				$urlSlideImage = $slide->getParam('slide_bg_external', '');
				$alt = esc_attr($slide->getParam('alt_attr', ''));
				$img_title = esc_attr($slide->getParam('title_attr', ''));
				
				$img_w = $slide->getParam('ext_width', '1920');
				$img_h = $slide->getParam('ext_height', '1080');
				
				$imageAddParams .= ' width="'.$img_w.'" height="'.$img_h.'"';
			}
			
			if(isset($slide->ignore_alt)) $alt = '';

			$bgType = $slide->getParam('background_type', 'image');

			//get thumb url

			$is_special_nav = false;
			switch($navigation_arrow_stlye){ //generate also if we have a special navigation selected
				case 'preview1':
				case 'preview2':
				case 'preview3':
				case 'preview4':
				case 'custom':
					$is_special_nav = true;
			}
			switch($navigation_bullets_style){ //generate also if we have a special navigation selected
				case 'preview1':
				case 'preview2':
				case 'preview3':
				case 'preview4':
				case 'custom':
					$is_special_nav = true;
			}
			

			$htmlThumb = "";
			if($isThumbsActive == true || $is_special_nav == true){
				
				$urlThumb = null;

				if(empty($urlThumb)){
					$urlThumb = $slide->getParam('slide_thumb', '');
				}
				
				$thumb_do = $slide->getParam('thumb_dimension', 'slider');
				if($thumb_do == 'slider'){ //use the slider settings for width / height
				
					$th_width = intval($this->slider->getParam('previewimage_width', $this->slider->getParam('thumb_width', 100)));
					$th_height = intval($this->slider->getParam('previewimage_height', $this->slider->getParam('thumb_height', 50)));
					
					//$th_width = intval($this->slider->getParam('thumb_width', 100));
					//$th_height = intval($this->slider->getParam('thumb_height', 50));
					if($th_width == 0) $th_width = 100;
					if($th_height == 0) $th_height = 50;
					
					if($source_type == 'youtube' || $source_type == 'vimeo' || 
						$bgType == 'image' || $bgType == 'vimeo' || $bgType == 'youtube' || $bgType == 'html5' || 
						$bgType == 'streamvimeo' || $bgType == 'streamyoutube' || $bgType == 'streaminstagram' || $bgType == 'streamtwitter' ||
						$bgType == 'streamvimeoboth' || $bgType == 'streamyoutubeboth' || $bgType == 'streaminstagramboth' || $bgType == 'streamtwitterboth'){
						
						if(empty($urlThumb)){	//try to get resized thumb
							$url_img_link = $slide->getImageUrl();
							$urlThumb = rev_aq_resize($url_img_link, $th_width, $th_height, true, true, true);
						}else{
							$urlThumb = rev_aq_resize($urlThumb, $th_width, $th_height, true, true, true);
							if(empty($urlThumb)){
								$urlThumb = $slide->getImageUrl();
								$urlThumb = rev_aq_resize($urlThumb, $th_width, $th_height, true, true, true);
							}
							
						}
						
						//if not - put regular image:
						if(empty($urlThumb))
							$urlThumb = $slide->getImageUrl();
					}
				}else{
					//if not - put regular image:
					if(empty($urlThumb))
						$urlThumb = $slide->getImageUrl();
				}
				
				if(is_ssl()){
					$urlThumb = str_replace('http://', 'https://', $urlThumb);
				}else{
					$urlThumb = str_replace('https://', 'http://', $urlThumb);
				}
				
				$htmlThumb = ' data-thumb="'.$urlThumb.'" ';
				
			}

			//get link
			$htmlLink = '';
			$enableLink = $slide->getParam('enable_link', 'false');
			if($enableLink == 'true'){
				$linkType = $slide->getParam('link_type', 'regular');
				switch($linkType){

					//---- normal link
					default:
					case 'regular':
						$link = do_shortcode($slide->getParam('link', ''));
						$linkOpenIn = $slide->getParam('link_open_in', 'same');
						$htmlTarget = '';
						if($linkOpenIn == 'new')
							$htmlTarget = ' data-target="_blank"';
						$htmlLink = ' data-link="'.$link.'" '.$htmlTarget.' ';
					break;

					//---- link to slide
					case 'slide':
						$slideLink = RevSliderFunctions::getVal($params, 'slide_link');
						if(!empty($slideLink) && $slideLink != 'nothing'){
							//get slide index from id
							if(is_numeric($slideLink))
								$slideLink = RevSliderFunctions::getVal($this->slidesNumIndex, $slideLink);

							if(!empty($slideLink)){
								$htmlLink = ' data-link="slide" data-linktoslide="'.$slideLink.'" ';
							}
						}
					break;
				}

				//set link position:
				$linkPos = RevSliderFunctions::getVal($params, 'link_pos', 'front');
				if($linkPos == 'back')
					$htmlLink .= ' data-slideindex="back"';
			}

			//set delay
			$htmlDelay = '';
			$delay = $slide->getParam('delay', '');
			if(!empty($delay) && is_numeric($delay))
				$htmlDelay = ' data-delay="'.$delay.'" ';

			//set Stop Slide on Purpose
			$htmlStopPurpose= '';
			$stoponpurpose = $slide->getParam('stoponpurpose', '');
			if (!empty($stoponpurpose) && $stoponpurpose=="true")
				$htmlStopPurpose = ' data-ssop="true" ';

			//set Stop Slide on Purpose
			$htmlInvisibleSlide= '';
			$invisibleslide = $slide->getParam('invisibleslide', '');
			if (!empty($invisibleslide) && $invisibleslide=="true")
				$htmlInvisibleSlide = ' data-invisible="true" ';

			//get duration
			$htmlDuration = '';
			$duration = $slide->getParam('transition_duration', $this->slider->getParam('def-transition_duration', ''));
			
			if(is_array($duration)) $duration = implode(',', $duration);
			
			if(!empty($duration))
				$htmlDuration = ' data-masterspeed="'.$duration.'" ';

			//get performance
			$htmlPerformance = '';
			$performance = $slide->getParam('save_performance', 'off');
			if(!empty($performance) && ($performance == 'on' || $performance == 'off'))
				$htmlPerformance = ' data-saveperformance="'.$performance.'" ';



			//get rotation
			$htmlRotation = '';
			$rotation = (array) $slide->getParam('transition_rotation', '');
			if(!empty($rotation)){
				$rot_string = '';
				foreach($rotation as $rkey => $rot){
					$rot = (int)$rot;
					if($rot != 0){
						if($rot > 720 && $rot != 999)
							$rot = 720;
						if($rot < -720)
							$rot = -720;
					}
					if($rkey > 0) $rot_string .= ',';
					$rot_string .= $rot;
				}
				$htmlRotation = ' data-rotate="'.$rot_string.'" ';
			}
			
			$htmlEaseIn = '';
			$easein = $slide->getParam('transition_ease_in', 'default');
			if(!empty($easein) && is_array($easein)) $easein = implode(',', $easein);
			if($easein !== ''){
				//$frame_start['ease'] = $easein;
				$htmlEaseIn = ' data-easein="'.$easein.'"';
			}
			
			$htmlEaseOut = '';
			$easeout = $slide->getParam('transition_ease_out', 'default');
			
			if(!empty($easeout) && is_array($easeout)) $easeout = implode(',', $easeout);
			
			if($easeout !== ''){
				$frame_end['ease'] = $easeout;
				$htmlEaseOut = ' data-easeout="'.$easeout.'"';
			}
			
			$fullWidthVideoData = $this->getSlideFullWidthVideoData($slide);
			
			//set first slide transition
			$htmlFirstTrans = '';
			
			if($index == $startWithSlide && $slider_type !== 'hero'){
				$htmlFirstTrans = $htmlFirstTransWrap;
			}//first trans

			$htmlParams = $htmlEaseIn.$htmlEaseOut.$htmlDuration.$htmlLink.$htmlThumb.$htmlDelay.$htmlRotation.$htmlFirstTrans.$htmlPerformance.$htmlStopPurpose.$htmlInvisibleSlide;


			$styleImage = '';
			$urlImageTransparent = RS_PLUGIN_URL.'admin/assets/images/transparent.png';

			switch($bgType){
				case 'trans':
					$urlSlideImage = $urlImageTransparent;
				break;
				case 'solid':
					$urlSlideImage = $urlImageTransparent;
					$slideBGColor = $slide->getParam('slide_bg_color', '#d0d0d0');
					$styleImage = "style='background-color:".$slideBGColor."'";
				break;
				case 'streamvimeo':
				case 'streamyoutube':
				case 'streaminstagram':
				case 'streamtwitter':
					if($slide->getParam('stream_do_cover', 'on') == 'off'){
						$urlSlideImage = $urlImageTransparent;
					}
				break;
				case 'streamvimeoboth':
				case 'streamyoutubeboth':
				case 'streaminstagramboth':
				case 'streamtwitterboth':
					if($this->checkIfStreamVideoExists($slide)){
						if($slide->getParam('stream_do_cover_both', 'on') == 'off'){
							$urlSlideImage = $urlImageTransparent;
						}
					}
				break;
			}
			
			if(trim($urlSlideImage) == '') $urlSlideImage = $urlImageTransparent; //go back to transparent if img is empty
			
			//additional params
			if($lazyLoad != 'none'){
				$imageAddParams .= ' data-lazyload="'.$urlSlideImage.'"';
				$urlSlideImage = RS_PLUGIN_URL.'admin/assets/images/dummy.png';
			}
			
			//additional background params
			$bgFit = $slide->getParam('bg_fit', $this->slider->getParam('def-background_fit', 'cover'));
			$bgFitX = intval($slide->getParam('bg_fit_x', $this->slider->getParam('def-bg_fit_x', '100')));
			$bgFitY = intval($slide->getParam('bg_fit_y', $this->slider->getParam('def-bg_fit_y', '100')));

			$bgPosition = $slide->getParam('bg_position', $this->slider->getParam('def-bg_position', 'center center'));
			
			if($bgType == 'streamvimeoboth' || $bgType == 'streamyoutubeboth' || $bgType == 'streaminstagramboth' || $bgType == 'streamtwitterboth'){
				if($this->checkIfStreamVideoExists($slide)){
					$bgPosition = 'center center';
				}
			}else{
				if($bgType == 'youtube' || $bgType == 'vimeo' || $bgType == 'html5' || $bgType == 'streamvimeo' || $bgType == 'streamyoutube' || $bgType == 'streaminstagram' || $bgType == 'streamtwitter'){
					$bgPosition = 'center center';
				}
			}
			
			$bgPositionX = intval($slide->getParam('bg_position_x', $this->slider->getParam('def-bg_position_x', '0')));
			$bgPositionY = intval($slide->getParam('bg_position_y', $this->slider->getParam('def-bg_position_y', '0')));

			$bgRepeat = $slide->getParam('bg_repeat', $this->slider->getParam('def-bg_repeat', 'no-repeat'));

			if($bgPosition == 'percentage'){
				$imageAddParams .= ' data-bgposition="'.$bgPositionX.'% '.$bgPositionY.'%"';
			}else{
				$imageAddParams .= ' data-bgposition="'.$bgPosition.'"';
			}

			//check for kenburn & pan zoom
			$kenburn_effect = $slide->getParam('kenburn_effect', $this->slider->getParam('def-kenburn_effect', 'off'));
			$kb_duration = intval($slide->getParam('kb_duration', $this->slider->getParam('def-kb_duration', '10000')));
			$kb_ease = $slide->getParam('kb_easing', $this->slider->getParam('def-kb_easing', 'Linear.easeNone'));
			$kb_start_fit = $slide->getParam('kb_start_fit', $this->slider->getParam('def-kb_start_fit', '100'));
			$kb_end_fit = $slide->getParam('kb_end_fit', $this->slider->getParam('def-kb_end_fit', '100'));
			
			$kb_start_offset_x = $slide->getParam('kb_start_offset_x', $this->slider->getParam('def-kb_start_offset_x', '0'));
			$kb_start_offset_y = $slide->getParam('kb_start_offset_y', $this->slider->getParam('def-kb_start_offset_y', '0'));
			$kb_end_offset_x = $slide->getParam('kb_end_offset_x', $this->slider->getParam('def-kb_end_offset_x', '0'));
			$kb_end_offset_y = $slide->getParam('kb_end_offset_y', $this->slider->getParam('def-kb_end_offset_y', '0'));
			$kb_start_rotate = $slide->getParam('kb_start_rotate', $this->slider->getParam('def-kb_start_rotate', '0'));
			$kb_end_rotate = $slide->getParam('kb_end_rotate', $this->slider->getParam('def-kb_end_rotate', '0'));


			$kb_pz = '';


			
			if($kenburn_effect == "on" && ($bgType == 'image' || $bgType == 'external')){
				$kb_pz .= ' data-kenburns="on"';
				$kb_pz .= ' data-duration="'.$kb_duration.'"';
				$kb_pz .= ' data-ease="'.$kb_ease.'"';
				$kb_pz .= ' data-scalestart="'.$kb_start_fit.'"';
				$kb_pz .= ' data-scaleend="'.$kb_end_fit.'"';
				$kb_pz .= ' data-rotatestart="'.$kb_start_rotate.'"';
				$kb_pz .= ' data-rotateend="'.$kb_end_rotate.'"';
				$kb_pz .= ' data-offsetstart="'.$kb_start_offset_x.' '.$kb_start_offset_y.'"';
				$kb_pz .= ' data-offsetend="'.$kb_end_offset_x.' '.$kb_end_offset_y.'"';
				
			}else{ //only set if kenburner is off and not a background video
				if($bgType == 'youtube' || $bgType == 'html5' || $bgType == 'vimeo' || $bgType == 'streamvimeo' || $bgType == 'streamyoutube' || $bgType == 'streaminstagram' || $bgType == 'streamtwitter'){
					$imageAddParams .= ' data-bgfit="cover"';
				}else{
					if($bgFit == 'percentage'){
						$imageAddParams .= ' data-bgfit="'.$bgFitX.'% '.$bgFitY.'%"';
					}else{
						$imageAddParams .= ' data-bgfit="'.$bgFit.'"';
					}

					$imageAddParams .= ' data-bgrepeat="'.$bgRepeat.'"';
				}
			}
			$mediafilter = $slide->getParam('media-filter-type', 'none');

			if ($mediafilter !="none")
				$htmlParams .= ' data-mediafilter="'.$mediafilter.'"';

			//add Slide Title if we have special navigation type choosen
			$slide_title = '';

			$class_attr = $slide->getParam("class_attr","");
			if($class_attr !== '')
				$htmlParams .= ' class="'.$class_attr.'"';

			$id_attr = $slide->getParam('id_attr', '');
			if($id_attr !== '')
				$htmlParams .= ' id="'.$id_attr.'"';


			$data_attr = stripslashes($slide->getParam('data_attr', ''));
			if($data_attr !== '')
				$htmlParams .= ' '.$data_attr;
			
			if($post_based_slider){//check if we are post based or normal slider
				$the_post = get_post($slide->getID());
				$new_title = @get_the_title($slide->getID());
				$the_excerpt = strip_tags(strip_shortcodes($the_post->post_excerpt));
				
				$slide_title = ' data-title="'.stripslashes(esc_attr($new_title)).'"';
				$slide_description = ' data-description="'.str_replace(array("\'", '\"'), array("'", '"'), esc_attr($the_excerpt)).'"';
			}else{
				$slide_title = ' data-title="'.stripslashes(esc_attr($slide->getParam("title","Slide"))).'"';
				$slide_description = ' data-description="'.str_replace(array("\'", '\"'), array("'", '"'), esc_attr($slide->getParam('slide_description', ''))).'"';
			}
			
			$slide_id = $slide->getID();
			if($slide->getParam('slide_id','') !== '') $slide_id = esc_attr($slide_id);
			
			$add_params = '';
			for($mi=1;$mi<=10;$mi++){
				$pa = $slide->getParam('params_'.$mi,'');
				
				//add meta functionality here
				
				if($pa !== ''){
					$pa_limit = $slide->getParam('params_'.$mi.'_chars',10,RevSlider::FORCE_NUMERIC);
					$pa = strip_tags($pa);
					$pa = mb_substr($pa, 0, $pa_limit, 'utf-8');
				}
				$add_params .= ' data-param'.$mi.'="'.stripslashes(esc_attr($pa)).'"';
			}
			
			$use_parallax = $this->slider->getParam("use_parallax", $this->slider->getParam('use_parallax', 'off'));

			$parallax_attr = '';
			if($use_parallax == 'on'){
				$slide_level = $slide->getParam('slide_parallax_level', '-');
				if($slide_level == '-') $slide_level = 'off';
					
				$parallax_attr = ' data-bgparallax="'.$slide_level.'"';
			}
			
			$hideslideafter = $slide->getParam("hideslideafter",0);
			
			$hsom = $slide->getParam('hideslideonmobile', 'off');
			
			if($img_title !== '') $img_title = ' title="'.$img_title.'"';
			
			//Html rev-main-
			echo '	<!-- SLIDE  -->'."\n";
			echo '	<li data-index="rs-'.$slide_id.'" data-transition="'.$transition.'" data-slotamount="'. $slotAmount.'" data-hideafterloop="'.$hideslideafter.'" data-hideslideonmobile="'.$hsom.'" '.$add_rand.$htmlParams.$slide_title.$add_params.$slide_description;
			
			do_action('revslider_add_li_data', $this->slider, $slide);
			
			echo '>'."\n";
			
			echo '		<!-- MAIN IMAGE -->'."\n";
			echo '		<img src="'. $urlSlideImage .'" '. $styleImage.' alt="'. $alt . '"'. $img_title.' '. $imageAddParams. $kb_pz . $parallax_attr .' class="rev-slidebg" data-no-retina>'."\n";
			echo '		<!-- LAYERS -->'."\n";
			
			//START OF set values needed for the layers to be set before adding any of them to the stage
			$this->slideID = $slide->getID();
			$this->slide = $slide;
			$this->layers = $this->slide->getLayers();
			
			$enable_custom_size_notebook = $this->slider->getParam('enable_custom_size_notebook', 'off');
			$enable_custom_size_tablet = $this->slider->getParam('enable_custom_size_tablet', 'off');
			$enable_custom_size_iphone = $this->slider->getParam('enable_custom_size_iphone', 'off');
			$this->enabled_sizes = array('desktop' => 'on', 'notebook' => $enable_custom_size_notebook, 'tablet' => $enable_custom_size_tablet, 'mobile' => $enable_custom_size_iphone);
			$this->adv_resp_sizes = ($enable_custom_size_notebook == 'on' || $enable_custom_size_tablet == 'on' || $enable_custom_size_iphone == 'on') ? true : false;
			$this->icon_sets = RevSliderBase::set_icon_sets(array());
			$this->customAnimations = RevSliderOperations::getCustomAnimations('customin'); //get all custom animations
			$this->customEndAnimations = RevSliderOperations::getCustomAnimations('customout'); //get all custom animations
			$this->startAnimations = RevSliderOperations::getArrAnimations(false); //only get the standard animations
			$this->endAnimations = RevSliderOperations::getArrEndAnimations(false); //only get the standard animations
			//END OF set values needed for the layers to be set before adding any of them to the stage
			
			
			//check if we are youtube, vimeo or html5
			if($bgType == 'youtube' || $bgType == 'html5' || $bgType == 'vimeo' || $bgType == 'streamvimeo' || $bgType == 'streamyoutube' || $bgType == 'streaminstagram' || $bgType == 'streamtwitter'){
				$this->putBackgroundVideo($slide);
			}
			if($bgType == 'streamvimeoboth' || $bgType == 'streamyoutubeboth' || $bgType == 'streaminstagramboth' || $bgType == 'streamtwitterboth'){
				if($this->checkIfStreamVideoExists($slide)){
					$this->putBackgroundVideo($slide);
				}
			}
			
			$this->putCreativeZones();
			$this->putCreativeGroups();
			$this->putCreativeLayer();
			
			do_action('revslider_add_layer_html', $this->slider, $slide);
			
			echo "	</li>\n";
			
			
			$index++;
			
		}	//get foreach
		
		echo "</ul>\n";
		
		if($do_static && !empty($this->static_slide)){
			$layers = $this->static_slide->getLayers();
			$this->layers = $layers;
			if(!empty($layers)){
				$htmlstaticoverflow = '';
				$staticoverflow = $this->static_slide->getParam('staticoverflow', '');
				if (!empty($staticoverflow) && $staticoverflow=="hidden")
					$htmlstaticoverflow = 'overflow:hidden;width:100%;height:100%;top:0px;left:0px;';

				
				//check for static layers
				echo '<div style="'.$htmlstaticoverflow.'" class="tp-static-layers">'."\n";
				$this->slide = $this->static_slide;
				
				$this->putCreativeLayer(true);
				
				do_action('revslider_add_static_layer_html', $this->slider);
				
				echo '</div>'."\n";
			}
		}
		
		$this->add_custom_navigation_css($slides);
		
	}
	
	
	/**
	 * check if a stream video exists
	 * @since: 5.0
	 */
	public function checkIfStreamVideoExists($slide){
		$type = $slide->getParam('background_type', 'image');
		
		$vid = '';
		switch($type){
			case 'streamyoutubeboth'://youtube
				$vid = $slide->getParam('slide_bg_youtube', '');
			break;
			case 'streamvimeoboth'://vimeo
				$vid = $slide->getParam('slide_bg_vimeo', '');
			break;
			case 'streaminstagramboth'://instagram
				$vid = $slide->getParam('slide_bg_html_mpeg', '');
			break;
			case 'streamtwitterboth'://instagram
				$vid = $slide->getParam('slide_bg_html_mpeg', '');
					if($vid !== '') return true;
				$vid = $slide->getParam('slide_bg_youtube', '');
					if($vid !== '') return true;
				$vid = $slide->getParam('slide_bg_vimeo', '');
					if($vid !== '') return true;
			break;
		}
		
		return ($vid == '') ? false : true;
	}
	
	
	/**
	 * add background video layer
	 * @since: 5.0
	 */
	public function putBackgroundVideo($slide){
		
		$add_data = '';
		
		$videoType = $slide->getParam('background_type', 'image');
		
		$poster_url = $slide->getImageUrl();

		$cover = $slide->getParam('video_force_cover', 'on');
		$dotted_overlay = $slide->getParam('video_dotted_overlay', 'none');
		$ratio = $slide->getParam('video_ratio', 'none');
		$loop = $slide->getParam('video_loop', 'none');
		
		$nextslide = $slide->getParam('video_nextslide', 'off');
		$force_rewind = $slide->getParam('video_force_rewind', 'off');
		$mute_video = $slide->getParam('video_mute', 'on');
		$volume_video = $slide->getParam('video_volume', '100');
		
		$video_start_at = $slide->getParam('video_start_at', '');
		$video_end_at = $slide->getParam('video_end_at', '');
		
		//------------------------
		$videoWidth = '100%';
		$videoHeight = '100%';
		
		if($this->adv_resp_sizes == true){
			if(is_object($videoWidth)){
				$videoWidth = RevSliderFunctions::normalize_device_settings($videoWidth, $this->enabled_sizes, 'html-array');
			}
			if(is_object($videoHeight)){
				$videoHeight = RevSliderFunctions::normalize_device_settings($videoHeight, $this->enabled_sizes, 'html-array');
			}
		}else{
			if(is_object($videoWidth)) $videoWidth = RevSliderFunctions::get_biggest_device_setting($videoWidth, $this->enabled_sizes);
			if(is_object($videoHeight)) $videoHeight = RevSliderFunctions::get_biggest_device_setting($videoHeight, $this->enabled_sizes);
		}
		
		$add_data = ($force_rewind == 'on') ? '			data-forcerewind="on"'." \n" : '';
		$add_data .= ($mute_video == 'on') ? '			data-volume="mute"'." \n" : '';
		
		$setBase = (is_ssl()) ? 'https://' : 'http://';
		
		$video_added = false;
		
		switch($videoType){
			case 'streamtwitter':
			case 'streamtwitterboth':
			case 'twitter':
				$youtube_id = $slide->getParam('slide_bg_youtube', '');
				$vimeo_id = $slide->getParam('slide_bg_vimeo', '');
				$html_mpeg = $slide->getParam('slide_bg_html_mpeg', '');
				
				if($youtube_id !== ''){
					$arguments = $slide->getParam('video_arguments', RevSliderGlobals::DEFAULT_YOUTUBE_ARGUMENTS);
					$speed = $slide->getParam('video_speed', '1');
				
					if(empty($arguments))
						$arguments = RevSliderGlobals::DEFAULT_YOUTUBE_ARGUMENTS;
					
					if($mute_video == 'off'){
						$add_data .= '			data-volume="'.intval($volume_video).'"'." \n";
						$arguments = 'volume='.intval($volume_video).'&amp;'.$arguments;
					}
					
					$arguments.=';origin='.$setBase.$_SERVER['SERVER_NAME'].';';
					$add_data .= '			data-ytid="'.$youtube_id.'"'." \n";
					$add_data .= '			data-videoattributes="version=3&amp;enablejsapi=1&amp;html5=1&amp;'.$arguments.'"'." \n";
					$add_data .= '			data-videorate="'.$speed.'"'." \n";
					$add_data .= '			data-videowidth="'.$videoWidth.'"'." \n";
					$add_data .= '			data-videoheight="'.$videoHeight.'"'." \n";
					$add_data .= '			data-videocontrols="none"'." \n";
					
					$video_added = true;
				}elseif($vimeo_id !== ''){
					$arguments = $slide->getParam('video_arguments_vim', RevSliderGlobals::DEFAULT_VIMEO_ARGUMENTS);
				
					if(empty($arguments))
						$arguments = RevSliderGlobals::DEFAULT_VIMEO_ARGUMENTS;
					
					if($mute_video == 'off'){
						$add_data .= '			data-volume="'.intval($volume_video).'"'." \n";
					}
					
					//check if full URL
					if(strpos($vimeo_id, 'http') !== false){
						//we have full URL, split it to ID
						$video_id = explode('vimeo.com/', $vimeo_id);
						$vimeo_id = $video_id[1];
					}
					
					$add_data .= '			data-vimeoid="'.$vimeo_id.'"'." \n";
					$add_data .= '			data-videoattributes="'.$arguments.'"'." \n";
					$add_data .= '			data-videowidth="'.$videoWidth.'"'." \n";
					$add_data .= '			data-videoheight="'.$videoHeight.'"'." \n";
					$add_data .= '			data-videocontrols="none"'." \n";
					
					$video_added = true;
				}elseif($html_mpeg !== ''){
					$add_data .=  '			data-videowidth="'.$videoWidth.'"'." \n";
					$add_data .= '			data-videoheight="'.$videoHeight.'"'." \n";
					
					if(!empty($html_mpeg)) $add_data .= '			data-videomp4="'.$html_mpeg.'"'." \n";
					
					$add_data .= '			data-videopreload="auto"'." \n";
					
					$video_added = true;
				}
			break;
			case 'streamyoutube':
			case 'streamyoutubeboth':
			case 'youtube':
				$arguments = $slide->getParam('video_arguments', RevSliderGlobals::DEFAULT_YOUTUBE_ARGUMENTS);
				$speed = $slide->getParam('video_speed', '1');
				
				if(empty($arguments))
					$arguments = RevSliderGlobals::DEFAULT_YOUTUBE_ARGUMENTS;
				
				if($mute_video == 'off'){
					$add_data .= '			data-volume="'.intval($volume_video).'"'." \n";
					$arguments = 'volume='.intval($volume_video).'&amp;'.$arguments;
				}
				
				$youtube_id = $slide->getParam('slide_bg_youtube', '');
				
				if($youtube_id == '') return false;
				
				//check if full URL
				if(strpos($youtube_id, 'http') !== false){
					//we have full URL, split it to ID
					parse_str( parse_url( $youtube_id, PHP_URL_QUERY ), $my_v_ret );
					$youtube_id = $my_v_ret['v'];
				}
				
				$arguments.=';origin='.$setBase.$_SERVER['SERVER_NAME'].';';
				$add_data .= '			data-ytid="'.$youtube_id.'"'." \n";
				$add_data .= '			data-videoattributes="version=3&amp;enablejsapi=1&amp;html5=1&amp;'.$arguments.'"'." \n";
				$add_data .= '			data-videorate="'.$speed.'"'." \n";
				$add_data .= '			data-videowidth="'.$videoWidth.'"'." \n";
				$add_data .= '			data-videoheight="'.$videoHeight.'"'." \n";
				$add_data .= '			data-videocontrols="none"'." \n";
				
				$video_added = true;
				
			break;
			case 'streamvimeo':
			case 'streamvimeoboth':
			case 'vimeo':
				$arguments = $slide->getParam('video_arguments_vim', RevSliderGlobals::DEFAULT_VIMEO_ARGUMENTS);
				
				if(empty($arguments))
					$arguments = RevSliderGlobals::DEFAULT_VIMEO_ARGUMENTS;
				
				$arguments ='background=1&'.$arguments;
				if($mute_video == 'off'){
					$add_data .= '			data-volume="'.intval($volume_video).'"'." \n";
				}
				
				$vimeo_id = $slide->getParam('slide_bg_vimeo', '');
				
				if($vimeo_id == '') return false;
				
				//check if full URL
				if(strpos($vimeo_id, 'http') !== false){
					//we have full URL, split it to ID
					$video_id = explode('vimeo.com/', $vimeo_id);
					$vimeo_id = $video_id[1];
				}
				
				$add_data .= '			data-vimeoid="'.$vimeo_id.'"'." \n";
				$add_data .= '			data-videoattributes="'.$arguments.'"'." \n";
				$add_data .= '			data-videowidth="'.$videoWidth.'"'." \n";
				$add_data .= '			data-videoheight="'.$videoHeight.'"'." \n";
				$add_data .= '			data-videocontrols="none"'." \n";
				
				$video_added = true;
			break;
			case 'streaminstagram':
			case 'streaminstagramboth':
			case 'html5':
				
				$html_mpeg = $slide->getParam('slide_bg_html_mpeg', '');
				$html_webm = $slide->getParam('slide_bg_html_webm', '');
				$html_ogv = $slide->getParam('slide_bg_html_ogv', '');
				
				if($videoType == 'streaminstagram' || $videoType == 'streaminstagramboth'){
					$html_webm = '';
					$html_ogv = '';
				}
				
				$add_data .=  '			data-videowidth="'.$videoWidth.'"'." \n";
				$add_data .= '			data-videoheight="'.$videoHeight.'"'." \n";
				
				if(!empty($html_ogv)) $add_data .= '			data-videoogv="'.$html_ogv.'"'." \n";
				if(!empty($html_webm)) $add_data .= '			data-videowebm="'.$html_webm.'"'." \n";
				if(!empty($html_mpeg)) $add_data .= '			data-videomp4="'.$html_mpeg.'"'." \n";
				
				$add_data .= '			data-videopreload="auto"'." \n";
				
				$video_added = true;
			break;
		}
		
		if($video_added == false) return false; // return here if no valid video was found.
		
		if($video_start_at !== '')
			$add_data .= '			data-videostartat="'.$video_start_at.'"'." \n";
		if($video_end_at !== '')
			$add_data .= '			data-videoendat="'.$video_end_at.'"'." \n";
		
		if($loop === true){ //fallback
			$add_data .= '			data-videoloop="loop"'." \n";
		}else{
			$add_data .= '			data-videoloop="'.$loop.'"'." \n";
		}
		
		if($cover == 'on'){
			if($dotted_overlay !== 'none')
				$add_data .= '			data-dottedoverlay="'.$dotted_overlay.'"'." \n";
				
			$add_data .=  '			data-forceCover="1"'." \n";
				
			
		}
		
		if(!empty($ratio))
			$add_data .= '			data-aspectratio="'.$ratio.'"'." \n";
			
		$add_data .= '			data-autoplay="true"'." \n";
		$add_data .= '			data-autoplayonlyfirsttime="false"'." \n";
		if($nextslide === 'on')
			$add_data .= '			data-nextslideatend="true"'." \n";
		
		echo "\n		<!-- BACKGROUND VIDEO LAYER -->\n";
		echo '		<div class="rs-background-video-layer" '."\n";
		echo $add_data;
		echo '></div>';
	}

	
	/**
	 * put creative layer
	 */
	private function putCreativeLayer($static_slide = false){
		if(empty($this->layers))
			return(false);
		
		$this->container_mode = '';
		
		foreach($this->layers as $layer){
			$this->putLayer($layer, false, $static_slide);
		}
	}
	
	
	/**
	 * Moved most code part from putCreativeLayer into putLayer
	 * @since: 5.3.0
	 */
	public function putLayer($layer, $row_group_uid = false, $static_slide = false, $special_type = false){
		$unique_id = RevSliderFunctions::getVal($layer, 'unique_id');
		
		$frame_data = array();
		
		if($unique_id == '')
			$unique_id = $this->zIndex - 4;
		
		//$visible = RevSliderFunctions::getVal($layer, 'visible', true);
		//if($visible == false) continue;
		
		$type = RevSliderFunctions::getVal($layer, 'type', 'text');
		$svg_val = '';

		//set if video full screen
		$videoclass = '';
		
		$htmlVideoAutoplay = '';
		$htmlVideoAutoplayOnlyFirstTime = '';
		$htmlVideoNextSlide = '';
		$htmlVideoThumbnail = '';
		$htmlMute = '';
		$htmlCover = '';
		$htmlDotted = '';
		$htmlRatio = '';
		$htmlRewind = '';
		$htmlStartAt = '';
		$htmlEndAt = '';
		$htmlCoverPause = '';
		$htmlDisableOnMobile = '';

		$ids = RevSliderFunctions::getVal($layer, 'attrID');
		$wrapper_ids = RevSliderFunctions::getVal($layer, 'attrWrapperID');
		$classes = RevSliderFunctions::getVal($layer, 'attrClasses');
		$wrapper_classes = RevSliderFunctions::getVal($layer, 'attrWrapperClasses');
		$title = RevSliderFunctions::getVal($layer, 'attrTitle');
		$rel = RevSliderFunctions::getVal($layer, 'attrRel');
		$frames = RevSliderFunctions::getVal($layer, 'frames', false);
		$frame_start = RevSliderFunctions::getVal($frames, 'frame_0', false);
		$frame_end = RevSliderFunctions::getVal($frames, 'frame_999', false);
		if(empty($frame_start) || $frame_start === false){
			$frame_start = array();
		}else{
			$frame_start = (array)$frame_start;
		}
		if(empty($frame_end) || $frame_end === false){
			$frame_end = array();
		}else{
			$frame_end = (array)$frame_end;
		}
		
		$frame_hover = array();
		
		if(!empty($frame_start)){
			$frame_start['frame'] = '0';
		}
		if(!empty($frame_end)){
			$frame_end['frame'] = '999';
		}
		
		$isFullWidthVideo = false;
		switch($type){
			case 'video':
				$videoclass = ' tp-videolayer';
				$videoData = RevSliderFunctions::getVal($layer, 'video_data');
				if(!empty($videoData)){
					$videoData = (array)$videoData;
					$isFullWidthVideo = RevSliderFunctions::getVal($videoData, 'fullwidth');
					$isFullWidthVideo = RevSliderFunctions::strToBool($isFullWidthVideo);
				}else
					$videoData = array();
			break;
			case 'audio':
				$videoclass = ' tp-audiolayer';
				$videoData = RevSliderFunctions::getVal($layer, 'video_data');
				if(!empty($videoData)){
					$videoData = (array)$videoData;
				}else
					$videoData = array();
			break;
			case 'row':
				if($special_type !== 'row'){
					return false;
				}
			break;
			case 'group':
				if($special_type !== 'group'){
					return false;
				}
				$classes .= ' rev_group';
				$group_overflow = RevSliderFunctions::getVal($layer['deformation'], 'overflow'); 

				if ($group_overflow==="hidden")
					$classes .= ' group_ov_hidden';
			break;
			case 'column':
				if($special_type !== 'column'){
					return false;
				}
			break;
		}
		
		if($row_group_uid == false && $this->is_in_group_or_row($layer)){
			return false; //if we are not in a row or group and the layer is in one, return false
		}
		
		$class = RevSliderFunctions::getVal($layer, 'style');
		
		if(trim($class) !== ''){
			$this->class_include['.'.trim($class)] = true; //add classname for style inclusion
			//get class styles for further compare usage
			
			if(!isset($this->in_class_usage[trim($class)])) $this->in_class_usage[trim($class)] = RevSliderOperations::getCaptionsContentArray(trim($class));
		}
		
		//set defaults for stylings
		$dff = '';
		//$dta = 'left';
		$dttr = 'none';
		$dfs = 'normal';
		$dtd = 'none';
		//$dpa = '0px 0px 0px 0px';
		$dbs = 'none';
		$dbw = '0px 0px 0px 0px';
		$dbr = '0px 0px 0px 0px';
		$dc = 'auto';
		
		$dfos = false;
		$dlh = false;
		$dfw = false;
		
		$dco = false;
		$dcot = 1;
		$dbc = 'transparent';
		$dbt = 1;
		$dboc = 'transparent';
		$dbot = 1;
		
		/**
		* remove this following to get back to 5.0.4.1 in terms of output styling
		**/
		$do_remove_inline = apply_filters('revslider_remove_inline', true);
		
		if($do_remove_inline){
			if(isset($this->in_class_usage[trim($class)]) && isset($this->in_class_usage[trim($class)]['params'])){//defaults get set here

				$dfos = (isset($this->in_class_usage[trim($class)]['params']->{'font-size'})) ? $this->in_class_usage[trim($class)]['params']->{'font-size'} : $dfos;
				$dlh = (isset($this->in_class_usage[trim($class)]['params']->{'line-height'})) ? $this->in_class_usage[trim($class)]['params']->{'line-height'} : $dlh;
				$dfw = (isset($this->in_class_usage[trim($class)]['params']->{'font-weight'})) ? $this->in_class_usage[trim($class)]['params']->{'font-weight'} : $dfw;
				
				$dco = (isset($this->in_class_usage[trim($class)]['params']->{'color'})) ? $this->in_class_usage[trim($class)]['params']->{'color'} : $dco;
				$dcot = (isset($this->in_class_usage[trim($class)]['params']->{'color-transparency'})) ? $this->in_class_usage[trim($class)]['params']->{'color-transparency'} : $dcot;
				$dbc = (isset($this->in_class_usage[trim($class)]['params']->{'background-color'})) ? $this->in_class_usage[trim($class)]['params']->{'background-color'} : $dbc;
				$dbt = (isset($this->in_class_usage[trim($class)]['params']->{'background-transparency'})) ? $this->in_class_usage[trim($class)]['params']->{'background-transparency'} : $dbt;
				$dboc = (isset($this->in_class_usage[trim($class)]['params']->{'border-color'})) ? $this->in_class_usage[trim($class)]['params']->{'border-color'} : $dboc;
				$dbot = (isset($this->in_class_usage[trim($class)]['params']->{'border-transparency'})) ? $this->in_class_usage[trim($class)]['params']->{'border-transparency'} : $dbot;
				
				
				$dff = (isset($this->in_class_usage[trim($class)]['params']->{'font-family'})) ? $this->in_class_usage[trim($class)]['params']->{'font-family'} : $dff;
				//$dta =  (isset($this->in_class_usage[trim($class)]['params']->{'text-align'})) ?     $this->in_class_usage[trim($class)]['params']->{'text-align'} : $dta;
				$dttr = (isset($this->in_class_usage[trim($class)]['params']->{'text-transform'})) ? $this->in_class_usage[trim($class)]['params']->{'text-transform'} : $dttr;
				$dfs = (isset($this->in_class_usage[trim($class)]['params']->{'font-styles'})) ? $this->in_class_usage[trim($class)]['params']->{'font-styles'} : $dfs;
				$dtd = (isset($this->in_class_usage[trim($class)]['params']->{'text-decoration'})) ? $this->in_class_usage[trim($class)]['params']->{'text-decoration'} : $dtd;
				//$dpa = (isset($this->in_class_usage[trim($class)]['params']->{'padding'})) ? $this->in_class_usage[trim($class)]['params']->{'padding'} : $dpa;
				//if(is_array($dpa)) $dpa = implode(' ', $dpa);
				$dbs = (isset($this->in_class_usage[trim($class)]['params']->{'border-style'})) ? $this->in_class_usage[trim($class)]['params']->{'border-style'} : $dbs;
				$dbw = (isset($this->in_class_usage[trim($class)]['params']->{'border-width'})) ? $this->in_class_usage[trim($class)]['params']->{'border-width'} : $dbw;
				$dbr = (isset($this->in_class_usage[trim($class)]['params']->{'border-radius'})) ? $this->in_class_usage[trim($class)]['params']->{'border-radius'} : $dbr;
				if(is_array($dbr)) $dbr = implode(' ', $dbr);
				$dc = (isset($this->in_class_usage[trim($class)]['params']->{'css_cursor'})) ? $this->in_class_usage[trim($class)]['params']->{'css_cursor'} : $dc;
				
			}
		}
		
		$animation = RevSliderFunctions::getVal($frame_start, 'animation', RevSliderFunctions::getVal($layer, 'animation', 'tp-fade'));

		if(!array_key_exists($animation, $this->startAnimations) && array_key_exists($animation, $this->customAnimations)){ //if true, add custom animation
			//check with custom values, if same, we do not need to write all down and just refer
		}
		
		$tcin = RevSliderOperations::parseCustomAnimationByArray($layer, 'start', $frame_start);
		if($tcin !== ''){
			$frame_start['from'] = $tcin;
		}
		
		$do_mask_in = RevSliderFunctions::getVal($layer, 'mask_start',false);
		if($do_mask_in){
			$tmask = RevSliderOperations::parseCustomMaskByArray($layer, 'start');
			if($tmask !== ''){
				$frame_start['mask'] = $tmask;
			}
		}

		//set output class:

		$layer_2d_rotation = intval(RevSliderFunctions::getVal($layer, '2d_rotation', '0'));
		
		$internal_class = RevSliderFunctions::getVal($layer, 'internal_class', '');

		$layer_selectable = RevSliderFunctions::getVal($layer, 'layer-selectable', 'default');
		
		$outputClass = 'tp-caption '. trim($class);
		
		$outputClass = trim($outputClass) . ' ' . $internal_class . ' ';
		if ($layer_selectable !== "default"){
			if($layer_selectable == 'on'){
				$outputClass = trim($outputClass) . ' tp-layer-selectable ';
			}
		}else{
			if($this->slider->getParam('def-layer_selection', 'off') == 'on'){
				$outputClass = trim($outputClass) . ' tp-layer-selectable ';
			}
		}
		
		//if($type == 'button') $outputClass .= ' ';
		
		
		//$speed = RevSliderFunctions::getVal($frame_start, 'speed',RevSliderFunctions::getVal($layer, 'speed', 300));
		$time = RevSliderFunctions::getVal($frame_start, 'time', RevSliderFunctions::getVal($layer, 'time', 0));
		$time_relative = RevSliderFunctions::getVal($frame_start, 'time_relative', RevSliderFunctions::getVal($layer, 'timedelay', 'none'));
		if($time_relative !== 'none'){
			$time = ($time_relative !== $time) ? '+'.$time_relative : $time_relative;
		}
		
		$frame_start['speed'] = RevSliderFunctions::getVal($frame_start, 'speed', RevSliderFunctions::getVal($layer, 'speed', '300')); //fallback
		$frame_start['easing'] = RevSliderFunctions::getVal($frame_start, 'easing', RevSliderFunctions::getVal($layer, 'easing', 'easeOutExpo')); //fallback
		
		$randomRotate = RevSliderFunctions::getVal($layer, 'random_rotation', 'false');
		$randomRotate = RevSliderFunctions::boolToStr($randomRotate);

		$splitin = RevSliderFunctions::getVal($frame_start, 'split', RevSliderFunctions::getVal($layer, 'split', 'none'));
		$splitout = RevSliderFunctions::getVal($frame_end, 'endsplit', RevSliderFunctions::getVal($layer, 'endsplit', 'none'));
		$elementdelay = intval(RevSliderFunctions::getVal($frame_start, 'splitdelay', RevSliderFunctions::getVal($layer, 'splitdelay', 0)));
		$endelementdelay = intval(RevSliderFunctions::getVal($frame_end, 'splitdelay', RevSliderFunctions::getVal($layer, 'endsplitdelay', 0)));
		
		$basealign = RevSliderFunctions::getVal($layer, 'basealign', 'grid');
		
		if($elementdelay > 0) $elementdelay /= 100;
		if($endelementdelay > 0) $endelementdelay /= 100;


		$text = RevSliderFunctions::getVal($layer, 'text');
		if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate
			$text = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}elseif(function_exists('ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate plus
			$text = ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}elseif(function_exists('qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate X
			$text = qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}

		$text_toggle = RevSliderFunctions::getVal($layer, 'texttoggle');
		if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate
			$text_toggle = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text_toggle);
		}elseif(function_exists('ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate plus
			$text_toggle = ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text_toggle);
		}elseif(function_exists('qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate X
			$text_toggle = qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage($text_toggle);
		}
		
		if(trim($ids) == ''){
			if($static_slide){
				$ids = 'slider-'.preg_replace("/[^\w]+/", "", $this->slider->getID()).'-layer-'.$unique_id;
			}else{
				$ids = 'slide-'.preg_replace("/[^\w]+/", "", $this->slideID).'-layer-'.$unique_id;
			}
		}
		
		$ids = ($ids != '') ? ' id="'.$ids.'"' : '';
		$classes = ($classes != '') ? ' '.$classes : '';
		$title = ($title != '') ? ' title="'.$title.'"' : '';
		$rel = ($rel != '') ? ' rel="'.$rel.'"' : '';

		$inline_styles = '';
		$do_rotation = false;
		$add_data = '';
		$videoType = '';
		$cover = false;
		$toggle_allow = RevSliderFunctions::getVal($layer, 'toggle',false);
		$toggle_inverse_content = RevSliderFunctions::getVal($layer, 'toggle_inverse_content', false);
		
		//set html:
		$html = '';
		$html_toggle='';
		
		$htmlPosX = '';
		$htmlPosY = '';
		$static_data = '';
		$extra_data = '';
		
		
		$background_image = '';
		//check for background images
		switch($type){
			case 'text':
			case 'button':
			case 'shape':
			case 'row':
			case 'group':
			case 'column':
				$urlImage = RevSliderFunctions::getVal($layer, 'bgimage_url', '');
				//add background image 
				if($urlImage !== ''){
					
					$imglibsize = (array)RevSliderFunctions::getVal($layer, 'image_librarysize');
					
					$objlib = new RevSliderObjectLibrary();
					$objlib->_check_object_exist($urlImage);
					$urlImage = $objlib->get_correct_size_url($urlImage, array('SET', 'SET'), $imglibsize); //check for size to be used
					
					$layer_bg_size = RevSliderFunctions::getVal($layer, 'layer_bg_size', 'cover');
					$layer_bg_position = RevSliderFunctions::getVal($layer, 'layer_bg_position', 'center center');
					$layer_bg_repeat = RevSliderFunctions::getVal($layer, 'layer_bg_repeat', 'no-repeat');
					
					$def_val = (array) RevSliderFunctions::getVal($layer, 'deformation', array());
					$bg_trans = RevSliderFunctions::getVal($def_val, 'background-transparency', '1');
					
					$bg_info = " background: url('".$urlImage."') ".$layer_bg_repeat." ".$layer_bg_position."; background-size: ".$layer_bg_size.";"; // opacity: ".$bg_trans.";
					switch($type){
						case 'group':
						case 'shape':
						case 'row':
							$background_image .= " background: url('".$urlImage."') ".$layer_bg_repeat." ".$layer_bg_position."; background-size: ".$layer_bg_size."; opacity: ".$bg_trans.";";
							break;
						case 'column':
							//add data opacity
							$add_data .= '			data-bgopacity="'.$bg_trans.'"'."\n";
							//go now to default to add the background image
						default:
							$inline_styles .= " background: url('".$urlImage."') ".$layer_bg_repeat." ".$layer_bg_position."; background-size: ".$layer_bg_size.";";
							break;
					}
				}
			break;
		}
		
		switch($type){
			case 'shape':
			break;
			case 'svg':
				$max_width = RevSliderFunctions::getVal($layer, 'max_width', 'auto');
				$max_height = RevSliderFunctions::getVal($layer, 'max_height', 'auto');										
				$max_width = (is_object($max_width)) ? RevSliderFunctions::get_biggest_device_setting($max_width, $this->enabled_sizes) : $max_width;
				$max_height = (is_object($max_height)) ? RevSliderFunctions::get_biggest_device_setting($max_height, $this->enabled_sizes) : $max_height;
				
				if($max_width !== 'auto'){
					$max_width = ($max_width !== 'none') ? RevSliderFunctions::add_missing_val($max_width) : $max_width;
					$inline_styles .= ' min-width: '.$max_width.'; max-width: '.$max_width.';';
				}
				if($max_height !== 'auto'){
					$max_height = ($max_height !== 'none') ? RevSliderFunctions::add_missing_val($max_height) : $max_height;
					$inline_styles .= ' max-width: '.$max_height.'; max-width: '.$max_height.';';
				}

				$svg_val = RevSliderFunctions::getVal($layer, 'svg', false);

				$static_styles = RevSliderFunctions::getVal($layer, 'static_styles', array());
				
				if(!empty($static_styles)){
					$static_styles = (array)$static_styles;
					
					if(!empty($static_styles['color'])){
						if(is_object($static_styles['color'])){
							$use_color = RevSliderFunctions::get_biggest_device_setting($static_styles['color'], $this->enabled_sizes);
						}else{
							$use_color = $static_styles['color'];
						}
						
						$def_val = (array) RevSliderFunctions::getVal($layer, 'deformation', array());
						
						$color_trans = RevSliderFunctions::getVal($def_val, 'color-transparency', 1);
						
						if($color_trans != $dcot || $use_color != $dco){							
							if($color_trans > 0) $color_trans *= 100;
							$color_trans = intval($color_trans);
							$use_color = RevSliderFunctions::hex2rgba($use_color, $color_trans);
							
							$inline_styles .= ' color: '.$use_color.';';
						}
						
					}
				}

				

			break;
			default:
			//case 'no_edit':
			case 'text':
			case 'button':
				$html = $text;
				$html = do_shortcode(stripslashes($html));
				$html_toggle = $text_toggle;
				$html_toggle = do_shortcode(stripslashes($html_toggle));
				
				global $fa_icon_var, $pe_7s_var;
				foreach($this->icon_sets as $is){
					if(strpos($html, $is) !== false){ //include default Icon Sets if used
						$font_var = str_replace("-", "_", $is)."var";
						$$font_var = true;
						//wp_enqueue_style('rs-icon-set-'.$is);
					}
				}
				
				$max_width = RevSliderFunctions::getVal($layer, 'max_width', 'auto');
				$max_height = RevSliderFunctions::getVal($layer, 'max_height', 'auto');
				$white_space = RevSliderFunctions::getVal($layer, 'whitespace', 'nowrap');
				
				$max_width = (is_object($max_width)) ? RevSliderFunctions::get_biggest_device_setting($max_width, $this->enabled_sizes) : $max_width;
				$max_height = (is_object($max_height)) ? RevSliderFunctions::get_biggest_device_setting($max_height, $this->enabled_sizes) : $max_height;
				$white_space = (is_object($white_space)) ? RevSliderFunctions::get_biggest_device_setting($white_space, $this->enabled_sizes) : $white_space;
				
				if($max_width !== 'auto'){
					$max_width = ($max_width !== 'none') ? RevSliderFunctions::add_missing_val($max_width) : $max_width;
					$inline_styles .= ' min-width: '.$max_width.'; max-width: '.$max_width.';';
				}
				if($max_height !== 'auto'){
					$max_height = ($max_height !== 'none') ? RevSliderFunctions::add_missing_val($max_height) : $max_height;
					$inline_styles .= ' max-width: '.$max_height.'; max-width: '.$max_height.';';
				}
				
				$inline_styles .= ' white-space: '.$white_space.';';
				
				//$inline_styles .= ' min-width: '.$max_width.'; min-height: '.$max_height.'; white-space: '.$white_space.';';
				//$inline_styles .= ' max-width: '.$max_width.'; max-height: '.$max_height.';';
				
				//add more inline styling
				$static_styles = RevSliderFunctions::getVal($layer, 'static_styles', array());
				
				if(!empty($static_styles)){
					$static_styles = (array)$static_styles;
					if(!empty($static_styles['font-size'])){
						$static_styles['font-size'] = RevSliderFunctions::add_missing_val($static_styles['font-size'], 'px');
						if(is_object($static_styles['font-size'])){
							$mcfs = RevSliderFunctions::get_biggest_device_setting($static_styles['font-size'], $this->enabled_sizes);
						}else{
							$mcfs = $static_styles['font-size'];
						}
						if($mcfs !== $dfos) $inline_styles .= ' font-size: '.$mcfs.';';
						
					}
					if(!empty($static_styles['line-height'])){
						$static_styles['line-height'] = RevSliderFunctions::add_missing_val($static_styles['line-height'], 'px');
						if(is_object($static_styles['line-height'])){
							$mclh = RevSliderFunctions::get_biggest_device_setting($static_styles['line-height'], $this->enabled_sizes);
						}else{
							$mclh = $static_styles['line-height'];
						}
						if($mclh !== $dlh) $inline_styles .= ' line-height: '.$mclh.';';
					}
					if(!empty($static_styles['font-weight'])){
						if(is_object($static_styles['font-weight'])){
							$mcfw = RevSliderFunctions::get_biggest_device_setting($static_styles['font-weight'], $this->enabled_sizes);
						}else{
							$mcfw = $static_styles['font-weight'];
						}
						if($mcfw !== $dfw) $inline_styles .= ' font-weight: '.$mcfw.';';
					}
					if(!empty($static_styles['color'])){
						if(is_object($static_styles['color'])){
							$use_color = RevSliderFunctions::get_biggest_device_setting($static_styles['color'], $this->enabled_sizes);
						}else{
							$use_color = $static_styles['color'];
						}
						
						$def_val = (array) RevSliderFunctions::getVal($layer, 'deformation', array());
						
						$color_trans = RevSliderFunctions::getVal($def_val, 'color-transparency', 1);
						
						if($color_trans != $dcot || $use_color != $dco){							
							if($color_trans > 0) $color_trans *= 100;
							$color_trans = intval($color_trans);
							$use_color = RevSliderFunctions::hex2rgba($use_color, $color_trans);
							
							$inline_styles .= ' color: '.$use_color.';';
						}
						
					}
				}
				
				if($layer_2d_rotation !== 0)
					$do_rotation = true;
			break;
			case 'image':
				$additional = '';
				
				$cover_mode = RevSliderFunctions::getVal($layer, 'cover_mode', array());
				
				if(is_string($cover_mode)){
					$cover_mode = array('desktop' => $cover_mode, 'notebook' => $cover_mode, 'tablet' => $cover_mode, 'mobile' => $cover_mode);
				}else{ //change to array
					$cover_mode = (array) $cover_mode;
				}
				
				$scaleX = RevSliderFunctions::getVal($layer, 'scaleX');
				$scaleY = RevSliderFunctions::getVal($layer, 'scaleY');
				
				if($this->adv_resp_sizes == true){
					$y_is_single = true;
					$x_is_single = true;
					
					if($scaleX !== ''){
						if(!is_object($scaleX)){
							if(trim($scaleX) == '' || $scaleX == 'NaNpx') $scaleX = 'auto';
							$myScaleX = $scaleX;
							foreach($cover_mode as $cvmk => $cvmv){
								if($cvmv == 'fullwidth' || $cvmv == 'cover') $myScaleX = 'full';
								if($cvmv == 'cover-proportional') $myScaleX = 'full-proportional';
								break;
							}
						}else{
							foreach($cover_mode as $cvmk => $cvmv){
								if($cvmv == 'fullwidth' || $cvmv == 'cover') $scaleX->$cvmk = 'full';
								if($cvmv == 'cover-proportional') $scaleX->$cvmk = 'full-proportional';
							}
							$myScaleX = RevSliderFunctions::normalize_device_settings($scaleX, $this->enabled_sizes, 'html-array', array('NaNpx' => '', 'auto' => ''));
							if($myScaleX == "['','','','']") $myScaleX = '';
							
							if(strpos($myScaleX, '[') !== false) $y_is_single = false;
						}
						if($y_is_single){ //force to array if voffset is also array
							if(!isset($myScaleX)) $myScaleX = RevSliderFunctions::get_biggest_device_setting($scaleX, $this->enabled_sizes);
							if(trim($myScaleX) == '' || $myScaleX == 'NaNpx' || $myScaleX == 'auto'){
								$myScaleX = '';
							}else{
								$myScaleX = "['".$myScaleX."','".$myScaleX."','".$myScaleX."','".$myScaleX."']";
							}
						}
					}
					if($scaleY !== ''){
						if(!is_object($scaleY)){
							if(trim($scaleY) == '' || $scaleY == 'NaNpx') $scaleY = 'auto';
							$myScaleY = $scaleY;
							foreach($cover_mode as $cvmk => $cvmv){
								if($cvmv == 'fullheight' || $cvmv == 'cover') $myScaleY = 'full';
								if($cvmv == 'cover-proportional') $myScaleY = 'full-proportional';
								break;
							}
						}else{
							foreach($cover_mode as $cvmk => $cvmv){
								if($cvmv == 'fullheight' || $cvmv == 'cover') $scaleY->$cvmk = 'full';
								if($cvmv == 'cover-proportional') $scaleY->$cvmk = 'full-proportional';
							}
							
							$myScaleY = RevSliderFunctions::normalize_device_settings($scaleY, $this->enabled_sizes, 'html-array', array('NaNpx' => '', 'auto' => ''));
							if($myScaleY == "['','','','']") $myScaleY = '';
							
							if(strpos($myScaleY, '[') !== false) $y_is_single = false;
						}
						if($y_is_single){ //force to array if voffset is also array
							if(!isset($myScaleY)) $myScaleY = RevSliderFunctions::get_biggest_device_setting($scaleY, $this->enabled_sizes);
							if(trim($myScaleY) == '' || $myScaleY == 'NaNpx' || $myScaleY == 'auto'){
								$myScaleY = '';
							}else{
								$myScaleY = "['".$myScaleY."','".$myScaleY."','".$myScaleY."','".$myScaleY."']";
							}
						}
					}
					
					
				}else{
					$myScaleX = (is_object($scaleX)) ? RevSliderFunctions::get_biggest_device_setting($scaleX, $this->enabled_sizes) : $scaleX;
					if(trim($myScaleX) == '' || $myScaleX == 'NaNpx') $myScaleX = 'auto';
					
					$myScaleY = (is_object($scaleY)) ? RevSliderFunctions::get_biggest_device_setting($scaleY, $this->enabled_sizes) : $scaleY;
					if(trim($myScaleY) == '' || $myScaleY == 'NaNpx') $myScaleY = 'auto';
					
					foreach($cover_mode as $cvmk => $cvmv){
						if($cvmv == 'fullwidth' || $cvmv == 'cover') $myScaleX = 'full';
						if($cvmv == 'fullheight' || $cvmv == 'cover') $myScaleY = 'full';
						if($cvmv == 'cover-proportional') $myScaleX = 'full-proportional';
						if($cvmv == 'cover-proportional') $myScaleY = 'full-proportional';
						break;
					}
					
				}
				
				if($scaleX != '') $additional .= ' data-ww="'.$myScaleX.'"';
				if($scaleY != '') $additional .= ' data-hh="'.$myScaleY.'"';
				
				
				$urlImage = RevSliderFunctions::getVal($layer, 'image_url');
				
				$do_image_change = RevSliderFunctions::getVal($layer, 'image-size', 'auto');
				
				$img_size = 'full';
				switch($do_image_change){
					case 'auto':
						$img_size = $this->slider->getParam('def-image_source_type', 'full');
					break;
					default:
						$img_size = $do_image_change;
					break;
				}
				
				$cur_img_id = RevSliderFunctionsWP::get_image_id_by_url($urlImage);
				
				if($img_size !== 'full'){
					if($cur_img_id !== false && !empty($cur_img_id)){
						$urlImage = wp_get_attachment_image_src($cur_img_id, $img_size);
						$urlImage = $urlImage[0];
					}
				}
				
				$img_w = '';
				$img_h = '';

				if($cur_img_id !== false && !empty($cur_img_id)){
					$img_data = wp_get_attachment_metadata( $cur_img_id );
					if($img_data !== false && !empty($img_data)){
						if($img_size !== 'full'){
							if(isset($img_data['sizes']) && isset($img_data['sizes'][$img_size])){
								$img_w = $img_data['sizes'][$img_size]['width'];
								$img_h = $img_data['sizes'][$img_size]['height'];
							}
						}
						
						if($img_w == '' || $img_h == ''){
							$img_w = $img_data['width'];
							$img_h = $img_data['height'];
						}
						$additional.= ' width="'.$img_w.'" height="'.$img_h.'"';
					}
				}else{ //we might be from image library
					$msx = RevSliderFunctions::get_biggest_device_setting($scaleX, $this->enabled_sizes);
					$msy = RevSliderFunctions::get_biggest_device_setting($scaleY, $this->enabled_sizes);
					$imglibsize = (array)RevSliderFunctions::getVal($layer, 'image_librarysize');
					
					$objlib = new RevSliderObjectLibrary();
					
					//redownload if possible
					$objlib->_check_object_exist($urlImage);
					$urlImage = $objlib->get_correct_size_url($urlImage, array($msx, $msy), $imglibsize); //check for size to be used
				}
				
				$alt = '';
				$alt_option = RevSliderFunctions::getVal($layer, 'alt_option', 'media_library');
				
				switch($alt_option){
					case 'media_library':
						if($cur_img_id !== false){
							$alt = get_post_meta( $cur_img_id, '_wp_attachment_image_alt', true );
						}
					break;
					case 'file_name':
						$info = pathinfo($urlImage);
						$alt = $info['filename'];
					break;
					case 'custom':
						$alt = RevSliderFunctions::getVal($layer, 'alt');
					break;
				}
				
				if(isset($this->slide->ignore_alt)) $alt = '';
				
				
				if(is_ssl()){
					$urlImage = str_replace("http://", "https://", $urlImage);
				}
				
				$do_ll = RevSliderFunctions::getVal($layer, "lazy-load", 'auto');
				
				$imageAddParams = "";
				$lazyLoad = $this->slider->getParam('lazy_load_type', false);
				if($lazyLoad === false){ //do fallback checks to removed lazy_load value since version 5.0 and replaced with an enhanced version
					$old_ll = $this->slider->getParam('lazy_load', 'off');
					$lazyLoad = ($old_ll == 'on') ? 'all' : 'none';
				}
				
				if($lazyLoad != 'none' || $do_ll == 'force' && $do_ll !== 'ignore'){
					$seo_opti = RevSliderFunctions::getVal($layer, 'seo-optimized', false);
					if($seo_opti === 'false' || $seo_opti === false){
						$imageAddParams .= ' data-lazyload="'.$urlImage.'"';
						$urlImage = RS_PLUGIN_URL."admin/assets/images/dummy.png";
					}else{
						$additional .= ' class="forceseo"';
					}
				}
				
				$html = '<img src="'.$urlImage.'" alt="'.$alt.'"'.$additional.$imageAddParams.' data-no-retina>';
				$imageLink = RevSliderFunctions::getVal($layer, "link","");
				
				//add more inline styling
				$static_styles = RevSliderFunctions::getVal($layer, 'static_styles', array());
				
				if(!empty($static_styles) && trim($class) !== ''){
					$static_styles = (array)$static_styles;
					if(!empty($static_styles['line-height'])){
						$static_styles['line-height'] = RevSliderFunctions::add_missing_val($static_styles['line-height'], 'px');
						if(is_object($static_styles['line-height'])){
							$mclh = RevSliderFunctions::get_biggest_device_setting($static_styles['line-height'], $this->enabled_sizes);
						}else{
							$mclh = $static_styles['line-height'];
						}
						if($mclh !== $dlh) $inline_styles .= ' line-height: '.$mclh.';';
					}
				}
				
				if($layer_2d_rotation !== 0)
					$do_rotation = true;
			break;
			case 'audio':
				$videoType = trim(RevSliderFunctions::getVal($layer, 'video_type'));
				$videoWidth = RevSliderFunctions::getVal($layer, 'video_width');
				$videoHeight = RevSliderFunctions::getVal($layer, 'video_height');
				$videoArgs = trim(RevSliderFunctions::getVal($videoData, 'args'));
				$v_controls = RevSliderFunctions::getVal($videoData, 'controls');
				$v_controls = RevSliderFunctions::strToBool($v_controls);
				$v_visible = RevSliderFunctions::getVal($videoData, 'video_show_visibility');
				$v_visible = RevSliderFunctions::strToBool($v_visible);
				$videopreload = RevSliderFunctions::getVal($videoData, "preload_audio");
				$videopreloadwait = RevSliderFunctions::getVal($videoData, "preload_wait");
				
				$start_at = RevSliderFunctions::getVal($videoData, 'start_at');
				$htmlStartAt = ($start_at !== '') ? ' data-videostartat="'.$start_at.'"' : '';
				$end_at = RevSliderFunctions::getVal($videoData, 'end_at');
				$htmlEndAt = ($end_at !== '') ? ' data-videoendat="'.$end_at.'"' : '';
				
				$rewind = RevSliderFunctions::getVal($videoData, 'forcerewind');
				$rewind = RevSliderFunctions::strToBool($rewind);
				$htmlRewind = ($rewind == true) ? ' data-forcerewind="on"' : '';
				
				$volume = RevSliderFunctions::getVal($videoData, "volume", '100');
				$htmlMute = '			data-volume="'.intval($volume).'"';
				
				if($v_visible === true){
					$videoclass.= ' tp-hiddenaudio';
				}
				
				if($this->adv_resp_sizes == true){
					if(is_object($videoWidth)){
						$videoWidth = RevSliderFunctions::normalize_device_settings($videoWidth, $this->enabled_sizes, 'html-array');
					}
					if(is_object($videoHeight)){
						$videoHeight = RevSliderFunctions::normalize_device_settings($videoHeight, $this->enabled_sizes, 'html-array');
					}
				}else{
					if(is_object($videoWidth)) $videoWidth = RevSliderFunctions::get_biggest_device_setting($videoWidth, $this->enabled_sizes);
					if(is_object($videoHeight)) $videoHeight = RevSliderFunctions::get_biggest_device_setting($videoHeight, $this->enabled_sizes);
				}
				
				$videoloop = RevSliderFunctions::getVal($videoData, "videoloop");
				
				$add_data .= ($v_controls) ? ' data-videocontrols="none"' : ' data-videocontrols="controls"';
				$add_data .= ' data-videowidth="'.$videoWidth.'" data-videoheight="'.$videoHeight.'"';
				
				if(!empty($videopreload)){
					$add_data .= ' data-videopreload="'.$videopreload.'"';
					$add_data .= ' data-videopreloadwait="'.intval($videopreloadwait).'"';
				}
				
				$add_data .= ' data-audio="html5"';
				$urlAudio = esc_attr(RevSliderFunctions::getVal($videoData, 'urlAudio'));
				if(!empty($urlAudio)) $add_data .= ' data-videomp4="'.$urlAudio.'"';
				
				
				if(RevSliderFunctions::strToBool($videoloop) == true){ //fallback
					$add_data .= ' data-videoloop="loop"';
				}else{
					$add_data .= ' data-videoloop="'.$videoloop.'"';
				}
				
				$videoAutoplay = false;
				
				if(array_key_exists("autoplayonlyfirsttime", $videoData)){
					$autoplayonlyfirsttime = RevSliderFunctions::strToBool(RevSliderFunctions::getVal($videoData, "autoplayonlyfirsttime"));
					if($autoplayonlyfirsttime == true) $videoAutoplay = '1sttime';
				}
				
				if($videoAutoplay == false){
					if(array_key_exists("autoplay", $videoData))
						$videoAutoplay = RevSliderFunctions::getVal($videoData, "autoplay");
					else	//backword compatability
						$videoAutoplay = RevSliderFunctions::getVal($layer, "video_autoplay");
				}
				
				if($videoAutoplay !== false && $videoAutoplay !== 'false'){
					if($videoAutoplay === true || $videoAutoplay === 'true') $videoAutoplay = 'on';
					
					$htmlVideoAutoplay = '			data-autoplay="'.$videoAutoplay.'"'." \n";
				}else{
					$htmlVideoAutoplay = '			data-autoplay="off"'." \n";
				}
				
				$videoNextSlide = RevSliderFunctions::getVal($videoData, "nextslide");
				$videoNextSlide = RevSliderFunctions::strToBool($videoNextSlide);

				if($videoNextSlide == true)
					$htmlVideoNextSlide = '			data-nextslideatend="true"'." \n";

				$stopallvideo = RevSliderFunctions::getVal($videoData, "stopallvideo");
				$stopallvideo = RevSliderFunctions::strToBool($stopallvideo);
				$htmlDisableOnMobile .= ($stopallvideo)	? '			data-stopallvideos="true"'." \n" : '';
				
			break;
			case 'video':
				$videoType = trim(RevSliderFunctions::getVal($layer, 'video_type'));
				$videoID = trim(RevSliderFunctions::getVal($layer, 'video_id'));
				$videoWidth = RevSliderFunctions::getVal($layer, 'video_width');
				$videoHeight = RevSliderFunctions::getVal($layer, 'video_height');
				$videoArgs = trim(RevSliderFunctions::getVal($layer, 'video_args'));
				$v_controls = RevSliderFunctions::getVal($videoData, 'controls');
				$v_controls = RevSliderFunctions::strToBool($v_controls);
				
				$start_at = RevSliderFunctions::getVal($videoData, 'start_at');
				$htmlStartAt = ($start_at !== '') ? ' data-videostartat="'.$start_at.'"' : '';
				$end_at = RevSliderFunctions::getVal($videoData, 'end_at');
				$htmlEndAt = ($end_at !== '') ? ' data-videoendat="'.$end_at.'"' : '';
				
				$show_cover_pause = RevSliderFunctions::getVal($videoData, 'show_cover_pause');
				$show_cover_pause = RevSliderFunctions::strToBool($show_cover_pause);
				$htmlCoverPause = ($show_cover_pause == true) ? ' data-showcoveronpause="on"' : '';
				
				$rewind = RevSliderFunctions::getVal($videoData, 'forcerewind');
				$rewind = RevSliderFunctions::strToBool($rewind);
				$htmlRewind = ($rewind == true) ? ' data-forcerewind="on"' : '';
				
				$only_poster_on_mobile = (isset($layer['video_data']->use_poster_on_mobile)) ? $layer['video_data']->use_poster_on_mobile : '';
				$only_poster_on_mobile = RevSliderFunctions::strToBool($only_poster_on_mobile);
				
				if($isFullWidthVideo == true){ // || $cover == true
					$videoWidth = '100%';
					$videoHeight = '100%';
				}
				
				if($this->adv_resp_sizes == true){
					if(is_object($videoWidth)){
						$videoWidth = RevSliderFunctions::normalize_device_settings($videoWidth, $this->enabled_sizes, 'html-array');
					}
					if(is_object($videoHeight)){
						$videoHeight = RevSliderFunctions::normalize_device_settings($videoHeight, $this->enabled_sizes, 'html-array');
					}
				}else{
					if(is_object($videoWidth)) $videoWidth = RevSliderFunctions::get_biggest_device_setting($videoWidth, $this->enabled_sizes);
					if(is_object($videoHeight)) $videoHeight = RevSliderFunctions::get_biggest_device_setting($videoHeight, $this->enabled_sizes);
				}

				$setBase = (is_ssl()) ? 'https://' : 'http://';
				
				$cover = RevSliderFunctions::getVal($videoData, 'cover');
				$cover = RevSliderFunctions::strToBool($cover);
				
				$videoloop = RevSliderFunctions::getVal($videoData, "videoloop");
				
				$mute = RevSliderFunctions::getVal($videoData, "mute");
				$mute = RevSliderFunctions::strToBool($mute);
				
				$htmlMute = ($mute)	? '			data-volume="mute"' : '';
				
				switch($videoType){
					case 'streamyoutube':
					case 'streamyoutubeboth':
					case 'youtube':
						if($videoType == 'streamyoutube' || $videoType == 'streamyoutubeboth'){ //change $videoID to the stream!
							$videoID = $this->slide->getParam('slide_bg_youtube', '');
						}
						
						if(empty($videoArgs))
							$videoArgs = RevSliderGlobals::DEFAULT_YOUTUBE_ARGUMENTS;
						
						if(!$mute){
							$volume = RevSliderFunctions::getVal($videoData, "volume", '100');
							$htmlMute = '			data-volume="'.intval($volume).'"';
							$videoArgs = 'volume='.intval($volume).'&'.$videoArgs;
						}
						
						if($start_at !== ''){
							$start_raw = explode(':', $start_at);
							if(count($start_raw) == 2){
								if(intval($start_raw[0]) > 0){
									$start_at = $start_raw[0]*60 + $start_raw[1];
								}else{
									$start_at = $start_raw[1];
								}
							}
							$videoArgs .= ($start_at !== '') ? '&start='.$start_at : '';
						}
						if($end_at !== ''){
							$end_raw = explode(':', $end_at);
							if(count($end_raw) == 2){
								if(intval($end_raw[0]) > 0){
									$end_at = $end_raw[0]*60 + $end_raw[1];
								}else{
									$end_at = $end_raw[1];
								}
							}
							$videoArgs .= ($end_at !== '') ? '&end='.$end_at : '';
						}
						
						//check if full URL
						if(strpos($videoID, 'http') !== false){
							//we have full URL, split it to ID
							parse_str( parse_url( $videoID, PHP_URL_QUERY ), $my_v_ret );
							$videoID = $my_v_ret['v'];
						}
						
						$videospeed = RevSliderFunctions::getVal($videoData, 'videospeed', '1');
						$play_inline = RevSliderFunctions::getVal($videoData, 'video_play_inline', false);
						$play_inline = RevSliderFunctions::strToBool($play_inline);
						
						$videoArgs.=';origin='.$setBase.$_SERVER['SERVER_NAME'].';';
						
						$add_data = ' data-ytid="'.$videoID.'" data-videoattributes="version=3&amp;enablejsapi=1&amp;html5=1&amp;'.$videoArgs.'" data-videorate="'.$videospeed.'" data-videowidth="'.$videoWidth.'" data-videoheight="'.$videoHeight.'"';
						$add_data .= ($v_controls) ? ' data-videocontrols="none"' : ' data-videocontrols="controls"';
						if($play_inline){
							$add_data .= ' data-videoinline="true"';
						}
						
					break;
					case 'streamvimeo':
					case 'streamvimeoboth':
					case 'vimeo':
						if($videoType == 'streamvimeo' || $videoType == 'streamvimeoboth'){ //change $videoID
							$videoID = $this->slide->getParam('slide_bg_vimeo', '');
						}
						
						if(empty($videoArgs))
							$videoArgs = RevSliderGlobals::DEFAULT_VIMEO_ARGUMENTS;

						if ($v_controls)
							$videoArgs = 'background=1&'.$videoArgs;

						//check if full URL
						if(strpos($videoID, 'http') !== false){
							//we have full URL, split it to ID
							$videoID = (int) substr(parse_url($videoID, PHP_URL_PATH), 1);
						}
						
						if(!$mute){
							$volume = RevSliderFunctions::getVal($videoData, "volume", '100');
							$htmlMute = '			data-volume="'.intval($volume).'"';
						}
						
						$add_data = ' data-vimeoid="'.$videoID.'" data-videoattributes="'.$videoArgs.'" data-videowidth="'.$videoWidth.'" data-videoheight="'.$videoHeight.'"';
						
						
					break;
					case 'streaminstagram':
					case 'streaminstagramboth':
					case 'html5':
						$urlPoster = RevSliderFunctions::getVal($videoData, "urlPoster");
						$urlMp4 = RevSliderFunctions::getVal($videoData, "urlMp4");
						$urlWebm = RevSliderFunctions::getVal($videoData, "urlWebm");
						$urlOgv = RevSliderFunctions::getVal($videoData, "urlOgv");
						$videopreload = RevSliderFunctions::getVal($videoData, "preload");
						$leave_on_pause = RevSliderFunctions::getVal($videoData, "leave_on_pause");
						$leave_on_pause = RevSliderFunctions::strToBool($leave_on_pause);
						
						if(!$leave_on_pause){
							$add_data .= ' data-exitfullscreenonpause="off"'; //nur wenn off, standard on
						}
						
						if($videoType == 'streaminstagram' || $videoType == 'streaminstagramboth'){ //change $videoID
							$urlMp4 = $this->slide->getParam('slide_bg_instagram', '');
							$urlWebm = '';
							$urlOgv = '';
						}
						
						$add_data .= ($v_controls) ? ' data-videocontrols="none"' : ' data-videocontrols="controls"';
						$add_data .= ' data-videowidth="'.$videoWidth.'" data-videoheight="'.$videoHeight.'"';
						
						if(is_ssl()){
							$urlPoster = str_replace("http://", "https://", $urlPoster);
						}
						
						if(!empty($urlPoster)) $add_data .= ' data-videoposter="'.$urlPoster.'"';
						if(!empty($urlOgv)) $add_data .= ' data-videoogv="'.$urlOgv.'"';
						if(!empty($urlWebm)) $add_data .= ' data-videowebm="'.$urlWebm.'"';
						if(!empty($urlMp4)) $add_data .= ' data-videomp4="'.$urlMp4.'"';
						
						if(!empty($urlPoster)){
							if($only_poster_on_mobile === true){
								//$add_data .= ' data-posterOnMobile="on"';
								$add_data .= ' data-noposteronmobile="on"';
							}else{
								//$add_data .= ' data-posterOnMobile="off"';
								$add_data .= ' data-noposteronmobile="off"';
							}
						}

						if(!empty($videopreload)) $add_data .= ' data-videopreload="'.$videopreload.'"';
						
						$large_controls = RevSliderFunctions::strToBool(RevSliderFunctions::getVal($videoData, "large_controls"));
						if(!$large_controls){
							//$add_data .= ' data-viodelargecontrols="off"';
							$classes .= ' disabled_lc';
						}
					break;
					default:
						RevSliderFunctions::throwError("wrong video type: $videoType");
					break;
				}
				
				if(RevSliderFunctions::strToBool($videoloop) == true){ //fallback
					$add_data .= ' data-videoloop="loop"';
				}else{
					$add_data .= ' data-videoloop="'.$videoloop.'"';
				}
				
				if($cover == true){
					$dotted = RevSliderFunctions::getVal($videoData, "dotted");
					if($dotted !== 'none')
						$add_data .= ' data-dottedoverlay="'.$dotted.'"';
						
					$add_data .=  ' data-forceCover="1"';
						
					$ratio = RevSliderFunctions::getVal($videoData, "ratio");
						if(!empty($ratio))
							$add_data .= ' data-aspectratio="'.$ratio.'"';
				}
				
				$videoAutoplay = false;
				
				if(array_key_exists("autoplayonlyfirsttime", $videoData)){
					$autoplayonlyfirsttime = RevSliderFunctions::strToBool(RevSliderFunctions::getVal($videoData, "autoplayonlyfirsttime"));
					if($autoplayonlyfirsttime == true) $videoAutoplay = '1sttime';
				}
				
				if($videoAutoplay == false){
					if(array_key_exists("autoplay", $videoData))
						$videoAutoplay = RevSliderFunctions::getVal($videoData, "autoplay");
					else	//backword compatability
						$videoAutoplay = RevSliderFunctions::getVal($layer, "video_autoplay");
				}
				
				if($videoAutoplay !== false && $videoAutoplay !== 'false'){
					if($videoAutoplay === true || $videoAutoplay === 'true') $videoAutoplay = 'on';
					
					$htmlVideoAutoplay = '			data-autoplay="'.$videoAutoplay.'"'." \n";
				}else{
					$htmlVideoAutoplay = '			data-autoplay="off"'." \n";
				}
				
				$videoNextSlide = RevSliderFunctions::getVal($videoData, "nextslide");
				$videoNextSlide = RevSliderFunctions::strToBool($videoNextSlide);

				if($videoNextSlide == true)
					$htmlVideoNextSlide = '			data-nextslideatend="true"'." \n";

				$videoThumbnail = (isset($videoData["previewimage"])) ? $videoData["previewimage"] : '';
				if(is_ssl()){
					$videoThumbnail = str_replace("http://", "https://", $videoThumbnail);
				}else{
					$videoThumbnail = str_replace("https://", "http://", $videoThumbnail);
				}

				if(trim($videoThumbnail) !== '') $htmlVideoThumbnail = '			data-videoposter="'.$videoThumbnail.'"'." \n";
				if(!empty($videoThumbnail)){
					if($only_poster_on_mobile === true){
						//$htmlVideoThumbnail .= '			data-posterOnMobile="on"'." \n";
						$htmlVideoThumbnail .= '			data-noposteronmobile="on"'." \n";
					}else{
						//$htmlVideoThumbnail .= '			data-posterOnMobile="off"'." \n";
						$htmlVideoThumbnail .= '			data-noposteronmobile="off"'." \n";
					}
				}
				
				$disable_on_mobile = RevSliderFunctions::getVal($videoData, "disable_on_mobile");
				$disable_on_mobile = RevSliderFunctions::strToBool($disable_on_mobile);
				$htmlDisableOnMobile = ($disable_on_mobile)	? '			data-disablevideoonmobile="1"'." \n" : '';
				$stopallvideo = RevSliderFunctions::getVal($videoData, "stopallvideo");
				$stopallvideo = RevSliderFunctions::strToBool($stopallvideo);
				$allowfullscreenvideo = RevSliderFunctions::getVal($videoData, "allowfullscreen");
				$allowfullscreenvideo = RevSliderFunctions::strToBool($allowfullscreenvideo);
				$htmlDisableOnMobile .= ($stopallvideo)	? '			data-stopallvideos="true"'." \n" : '';
				$htmlDisableOnMobile .= ($allowfullscreenvideo)	? '			data-allowfullscreenvideo="true"'." \n" : '';
			break;
			case 'column':
				$size_raw = explode('/', RevSliderFunctions::getVal($layer, 'column_size'));
				$size = (count($size_raw) !== 2) ? '100' : round(100 * ($size_raw[0] / $size_raw[1]), 2);
				$inline_styles .= ' width: 100%;';
				$add_data .= ' data-columnwidth="'.esc_attr($size).'%"'."\n";
			break;
		}
		
		//add margin data attributes
		if($type == 'row' || $type == 'column' || $row_group_uid !== false){
			$margins = RevSliderFunctions::getVal($layer, 'margin');
			$rl_margin = array();
			if(is_object($margins)){
				$margin_vals = RevSliderFunctions::normalize_device_settings($margins, $this->enabled_sizes, 'obj');
				
				$margins = (array) $margins;
				foreach($margin_vals as $margin){
					if(!empty($margin)){
						foreach($margin as $mkey => $mar){
							$rl_margin[$mkey][] = str_replace(array('px', '%'), '', $mar);
						}
					}
				}
			}
			if(!empty($rl_margin)){
				$mnames = array('margintop', 'marginright', 'marginbottom', 'marginleft');
				for($i=0;$i<4;$i++){
					if(isset($rl_margin[$i])){
						$add_data .= '			data-'.$mnames[$i].'="['.implode(',', $rl_margin[$i]).']"'."\n";
					}
				}
			}
		}
		
		$text_align = RevSliderFunctions::getVal($layer, 'text-align');
		if(empty($text_align)){ //backwards compatability, get the info from deformation
			$text_align = (object)$text_align;
			$text_align->desktop = RevSliderFunctions::getVal($layer['deformation'], 'text-align'); 
		}
		
		if(is_object($text_align)){
			$text_align_vals = RevSliderFunctions::normalize_device_settings($text_align, $this->enabled_sizes, 'obj');
			
			$text_align_vals = (array) $text_align_vals;
			if(!empty($text_align_vals)){
				$add_data .= '			data-textAlign="[\''.implode("','", $text_align_vals).'\']"'."\n";
			}
		}
		
		
		$paddings = RevSliderFunctions::getVal($layer, 'padding');
		if(empty($paddings)){ //backwards compatability, get the info from deformation
			$paddings = (object)$paddings;
			$paddings->desktop = RevSliderFunctions::getVal($layer['deformation'], 'padding'); 
		}
		
		$rl_padding = array();
		if(is_object($paddings)){
			$padding_vals = RevSliderFunctions::normalize_device_settings($paddings, $this->enabled_sizes, 'obj');
			
			$paddings = (array) $paddings;
			foreach($padding_vals as $padding){
				if(!empty($padding)){
					foreach($padding as $mkey => $mar){
						$rl_padding[$mkey][] = str_replace(array('px', '%'), '', $mar);
					}
				}
			}
		}
		if(!empty($rl_padding)){
			$mnames = array('paddingtop', 'paddingright', 'paddingbottom', 'paddingleft');
			for($i=0;$i<4;$i++){
				if(isset($rl_padding[$i])){
					$add_data .= '			data-'.$mnames[$i].'="['.implode(',', $rl_padding[$i]).']"'."\n";
				}
			}
		}

		$blendmode = RevSliderFunctions::getVal($layer, "layer_blend_mode", 'normal');
		if ($blendmode!=="normal") {
			$add_data .= '			data-blendmode="'.$blendmode.'"'."\n";
	}
		
		switch($this->container_mode){
			case 'column': // we are a layer inside of a container, so add the display: block/inline-block
				$inline_styles.= (RevSliderFunctions::getVal($layer, 'displaymode')) ? ' display: block;' : ' display: inline-block;';
				//$classes .= ' rev_layer_in_column';
			break;
			case 'row':
			break;
			case 'group':
				//$classes .= ' rev_layer_in_group';
			break;
		}
		
		$has_trigger = false;
		foreach($this->layers as $cl){
			if($has_trigger) break;
			$all_actions = RevSliderFunctions::getVal($cl, 'layer_action', array());
			if(!empty($all_actions)){
				$a_action = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'action', array()));
				$a_layer_target = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'layer_target', array()));
				foreach($a_action as $ak => $aa){
					switch($aa){
						case 'start_in':
						case 'start_out':
						case 'toggle_layer':
						/*case 'stop_video':
						case 'start_video':
						case 'toggle_video':*/
							if($unique_id == $a_layer_target[$ak]){
								$has_trigger = true;
								break;
							}
						break;
					}
				}
			}
		}
		
		$last_trigger_state = '';
		$animation_overwrite = 'default';
		$trigger_memory = 'keep';
		$endWithSlide = false;
		
		if($has_trigger){
			$animation_overwrite = RevSliderFunctions::getVal($layer, 'animation_overwrite', 'wait');
			$trigger_memory = RevSliderFunctions::getVal($layer, 'trigger_memory', 'keep');
			
			$last_trigger_state = '			data-lasttriggerstate="'.esc_attr($trigger_memory).'"';
			
		}
		if($animation_overwrite == 'waitin' || $animation_overwrite == 'wait'){
			$time = 'bytrigger';
		}
		
		if($animation_overwrite == 'waitout' || $animation_overwrite == 'wait'){
			$frame_end['delay'] = 'bytrigger';
		}else{
			//handle end transitions:
			$endTime = trim(RevSliderFunctions::getVal($frame_end, 'time', RevSliderFunctions::getVal($layer, 'endtime', 0)));
			$end_time_relative = RevSliderFunctions::getVal($frame_end, 'time_relative', RevSliderFunctions::getVal($layer, 'endtimedelay', 'none'));
			if($end_time_relative !== 'none'){
				$endTime = ($endTime !== $end_time_relative) ? '+'.$end_time_relative : $end_time_relative;
			}
			
			$endWithSlide = RevSliderFunctions::getVal($layer, 'endWithSlide', false);			
			$version = RevSliderFunctions::getVal($layer, 'version', false);
			
			
			if($version === false || intval($version) < 530) {
				//backwards compatibility
				$realEndTime = UniteFunctionsRev::getVal($layer, "realEndTime", false);
				
				if($realEndTime !== false){
					$endSpeed = trim(RevSliderFunctions::getVal($frame_end, 'speed', UniteFunctionsRev::getVal($layer, 'endspeed')));
					$speed = UniteFunctionsRev::getVal($frame_start, 'speed', RevSliderFunctions::getVal($layer, 'speed', 300));
					$calcSpeed = (!empty($endSpeed)) ? $endSpeed : $speed;
					
					if(!empty($calcSpeed) && $realEndTime - $calcSpeed !== $endTime){
						$endTime = $realEndTime - $calcSpeed;
					}
				}
				//backwards compatibility end
				
				//endtime - endspeed
				$es = RevSliderFunctions::getVal($frame_end, 'speed', RevSliderFunctions::getVal($layer, 'endspeed', 0));
				
				if(!empty($endTime) && $endTime - $es < 0){
					$endTime = 0;
				}else{
					$endTime = $endTime - $es;
				}
				
				
				//end - start + speed
				$speed = UniteFunctionsRev::getVal($frame_start, 'speed', RevSliderFunctions::getVal($layer, 'speed', 300));
				$time = UniteFunctionsRev::getVal($frame_start, 'time', RevSliderFunctions::getVal($layer, 'time', 0));
				
				$endTime = $endTime - ($time + $speed);
			} else {
				/*
				timedelay && enddelay
				*/
				
				//$enddelay = UniteFunctionsRev::getVal($layer, 'enddelay', 'none');
				//if($enddelay !== 'none') $endTime = $enddelay;
				
			}
		}
		
		$show_on_hover = RevSliderFunctions::getVal($layer, 'show-on-hover', false);
		if($show_on_hover === 'show-on-hover' || is_array($show_on_hover) && $show_on_hover[0] == 'show-on-hover') $show_on_hover = false;//fix for layers that occured in version 5.2.2 and 5.2.3

		if($show_on_hover == true){
			$time = 'sliderenter';
			$frame_end['delay'] = 'sliderleave';
		}else{
			if(!empty($endTime) && $endWithSlide !== true){
				$frame_end['delay'] = $endTime;
			}
			if($endWithSlide){
				$frame_end['delay'] = 'wait';
			}
		}
		
		$columnbreak = '';
		if ($type==="row") {
			$columnbreak = RevSliderFunctions::getVal($layer, 'column_break_at');			
			if ($columnbreak==="desktop") $columnbreak = 0;
			if ($columnbreak==="notebook") $columnbreak = 1;
			if ($columnbreak==="tablet") $columnbreak = 2;
			if ($columnbreak==="mobile") $columnbreak = 3;			
		}

		
		//add animation to class
		$endAnimation = trim(RevSliderFunctions::getVal($frame_end, 'animation', RevSliderFunctions::getVal($layer, 'endanimation')));
		if($endAnimation == "fade") $endAnimation = "tp-fade";

		if(!array_key_exists($endAnimation, $this->endAnimations) && array_key_exists($endAnimation, $this->customEndAnimations)){ //if true, add custom animation
			//check with custom values, if same, we do not need to write all down and just refer
		}
		
		$tcout = '';
		
		if($endAnimation !== 'auto'){
			$tcout = RevSliderOperations::parseCustomAnimationByArray($layer, 'end', $frame_end);
		}else{ //automatic reverse
			$tcout .= 'auto:auto;';
		}
		
		$es = RevSliderFunctions::getVal($frame_end, 'speed', RevSliderFunctions::getVal($layer, 'endspeed'));
		$ee = trim(RevSliderFunctions::getVal($frame_end, 'easing', RevSliderFunctions::getVal($layer, 'endeasing')));
		$frame_end['speed'] = $es;
		$frame_end['easing'] = $ee;
		
		if($tcout !== ''){
			$frame_end['to'] = $tcout;
		}
		
		$do_mask_out = RevSliderFunctions::getVal($layer, 'mask_end',false);
		if($do_mask_out){
			$tmask = RevSliderOperations::parseCustomMaskByArray($layer, 'end');
			if($tmask !== ''){
				$frame_end['mask'] = $tmask;
			}
		}

		//slide link
		$html_simple_link = '';
		
		//hidden under resolution
		$htmlHidden = '';
		$layerHidden = RevSliderFunctions::getVal($layer, 'hiddenunder');
		if($layerHidden == 'true' || $layerHidden == '1')
			$htmlHidden = '			data-captionhidden="on"'." \n";
		
		$toggle_use_hover = RevSliderFunctions::getVal($layer, 'toggle_use_hover', false);
		if($toggle_use_hover === true){
			$add_data .= '			data-toggleusehover="true"';
		}
		
		$htmlParams = $add_data.$last_trigger_state.$htmlVideoAutoplay.$htmlVideoNextSlide.$htmlVideoThumbnail.$htmlHidden.$htmlMute.$htmlDisableOnMobile.$htmlCover.$htmlDotted.$htmlRatio.$htmlRewind.$htmlStartAt.$htmlEndAt.$htmlCoverPause."\n"; //.$htmlVideoAutoplayOnlyFirstTime $htmlEnd.

		//set positioning options
		$alignHor = RevSliderFunctions::getVal($layer, 'align_hor', 'left');
		$alignVert = RevSliderFunctions::getVal($layer, 'align_vert', 'top');
		$left = RevSliderFunctions::getVal($layer, 'left', 0);
		$top = RevSliderFunctions::getVal($layer, 'top', 0);
		
		if($this->adv_resp_sizes == true){
			$do_x_full = false;
			$do_y_full = false;
			$x_is_single = true;
			$y_is_single = true;
			if(!is_object($left) ){
				$myLeft = $left;
				$myLeft = "['".$myLeft."','".$myLeft."','".$myLeft."','".$myLeft."']";
			}else{
				$myLeft = RevSliderFunctions::normalize_device_settings($left, $this->enabled_sizes, 'html-array');
				if(strpos($myLeft, '[') !== false){
					$do_x_full = true;
				}else{
					$myLeft = "['".$myLeft."','".$myLeft."','".$myLeft."','".$myLeft."']";
				}
			}
			if(!is_object($top)){
				$myTop = $top;
				$myTop = "['".$myTop."','".$myTop."','".$myTop."','".$myTop."']";
			}else{
				$myTop = RevSliderFunctions::normalize_device_settings($top, $this->enabled_sizes, 'html-array');
				if(strpos($myTop, '[') !== false){
					$do_y_full = true;
				}else{
					$myTop = "['".$myTop."','".$myTop."','".$myTop."','".$myTop."']";
				}
			}
			
			if(!is_object($alignHor)){
				$myHor = $alignHor;
				$myHor = "['".$myHor."','".$myHor."','".$myHor."','".$myHor."']";
			}else{
				$myHor = RevSliderFunctions::normalize_device_settings($alignHor, $this->enabled_sizes, 'html-array');
				if(strpos($myHor, '[') !== false){
					$x_is_single = false;
				}else{
					$myHor = "['".$myHor."','".$myHor."','".$myHor."','".$myHor."']";
				}
			}

			
			if(!is_object($alignVert)){
				$myVer = $alignVert;
				$myVer = "['".$myVer."','".$myVer."','".$myVer."','".$myVer."']";
			}else{
				$myVer = RevSliderFunctions::normalize_device_settings($alignVert, $this->enabled_sizes, 'html-array');
				if(strpos($myVer, '[') !== false){
					$y_is_single = false;
				}else{
					$myVer = "['".$myVer."','".$myVer."','".$myVer."','".$myVer."']";
				}
			}

			
			$htmlPosX = ' data-x="'.$myHor.'" data-hoffset="'.$myLeft.'"';
			$htmlPosY = ' data-y="'.$myVer.'" data-voffset="'.$myTop.'"';


			
			$static_styles = RevSliderFunctions::getVal($layer, 'static_styles', array());
			if(!empty($static_styles)){
				$static_styles = (array)$static_styles;
				if(!empty($static_styles['font-size'])){
					if(is_object($static_styles['font-size'])){
						$ss_fs = RevSliderFunctions::normalize_device_settings($static_styles['font-size'], $this->enabled_sizes, 'html-array');
						if(strpos($ss_fs, '[') !== false) $static_data .= str_replace('px', '', '			data-fontsize="'.$ss_fs.'"')."\n";
					}
				}
				if(!empty($static_styles['line-height'])){
					if(is_object($static_styles['line-height'])){
						$ss_lh = RevSliderFunctions::normalize_device_settings($static_styles['line-height'], $this->enabled_sizes, 'html-array');
						if(strpos($ss_lh, '[') !== false) $static_data .= str_replace('px', '', '			data-lineheight="'.$ss_lh.'"')."\n";
					}
				}
				if(!empty($static_styles['font-weight'])){
					if(is_object($static_styles['font-weight'])){
						$ss_fw = RevSliderFunctions::normalize_device_settings($static_styles['font-weight'], $this->enabled_sizes, 'html-array');
						if(strpos($ss_fw, '[') !== false) $static_data .= str_replace('px', '', '			data-fontweight="'.$ss_fw.'"')."\n";
					}
				}
				if(!empty($static_styles['color'])){
					if(is_object($static_styles['color'])){
						$def_val = (array) RevSliderFunctions::getVal($layer, 'deformation', array());
						
						foreach($static_styles['color'] as $sk => $sv){
							if(strpos($sv, 'rgb') !== false)
								$static_styles['color']->$sk = RevSliderFunctions::rgba2hex($sv);
							
							$color_trans = RevSliderFunctions::getVal($def_val, 'color-transparency', 1);
							if($color_trans > 0) $color_trans *= 100;
							$color_trans = intval($color_trans);
							
							$static_styles['color']->$sk = RevSliderFunctions::hex2rgba($static_styles['color']->$sk, $color_trans);
						}
						
						
						
						
						$ss_c = RevSliderFunctions::normalize_device_settings($static_styles['color'], $this->enabled_sizes, 'html-array');
						if(strpos($ss_c, '[') !== false){
							$static_data .= '			data-color="'.$ss_c.'"'."\n";
						}
					}
				}
			}
			
			$max_width = RevSliderFunctions::getVal($layer, 'max_width', 'auto');
			$max_height = RevSliderFunctions::getVal($layer, 'max_height', 'auto');
			$white_space = RevSliderFunctions::getVal($layer, 'whitespace', 'nowrap');
			
			$cover_mode = RevSliderFunctions::getVal($layer, 'cover_mode', array());
			
			if(is_string($cover_mode)){
				$cover_mode = array('desktop' => $cover_mode, 'notebook' => $cover_mode, 'tablet' => $cover_mode, 'mobile' => $cover_mode);
			}else{ //change to array
				$cover_mode = (array) $cover_mode;
			}
			
			if(is_object($max_width)){
				$max_width = RevSliderFunctions::normalize_device_settings($max_width, $this->enabled_sizes);
				
				if($max_width->desktop == 'auto') $max_width->desktop = 'none';
				if($max_width->notebook == 'auto') $max_width->notebook = 'none';
				if($max_width->tablet == 'auto') $max_width->tablet = 'none';
				if($max_width->mobile == 'auto') $max_width->mobile = 'none';
				if($max_width->desktop == $max_width->notebook && $max_width->desktop == $max_width->tablet && $max_width->desktop == $max_width->mobile) $max_width = $max_width->desktop;
			}
			if(is_object($max_height)){
				$max_height = RevSliderFunctions::normalize_device_settings($max_height, $this->enabled_sizes);
				
				if($max_height->desktop == 'auto') $max_height->desktop = 'none';
				if($max_height->notebook == 'auto') $max_height->notebook = 'none';
				if($max_height->tablet == 'auto') $max_height->tablet = 'none';
				if($max_height->mobile == 'auto') $max_height->mobile = 'none';
				if($max_height->desktop == $max_height->notebook && $max_height->desktop == $max_height->tablet && $max_height->desktop == $max_height->mobile) $max_height = $max_height->desktop;
			}
			if(is_object($white_space)){
				$white_space = RevSliderFunctions::normalize_device_settings($white_space, $this->enabled_sizes);
				
				if($white_space->desktop == $white_space->notebook && $white_space->desktop == $white_space->tablet && $white_space->desktop == $white_space->mobile) $white_space = $white_space->desktop;
			}
			
			switch($type){
				case 'shape':
				case 'image':
					if(is_object($max_width)){
						foreach($cover_mode as $cvmk => $cvmv){
							if($cvmv == 'fullwidth' || $cvmv == 'cover'){
								$max_width->$cvmk = 'full';
							}elseif($cvmv == 'cover-proportional'){
								$max_width->$cvmk = 'full-proportional';
							}else{
								if($type == 'image') $max_width->$cvmk = 'none';
							}
						}
					}else{
						foreach($cover_mode as $cvmk => $cvmv){
							if($type == 'image'){
								if($cvmv == 'fullwidth' || $cvmv == 'cover'){
									$max_width = 'full';
								}elseif($cvmv == 'cover-proportional'){
									$max_width = 'full-proportional';
								}else{
									$max_width = 'none';
								}
							}else{
								if($cvmv == 'fullwidth' || $cvmv == 'cover'){
									$max_width = 'full';
								}elseif($cvmv == 'cover-proportional'){
									$max_width = 'full-proportional';
								}
							}
							break;
						}
					}
					if(is_object($max_height)){
						foreach($cover_mode as $cvmk => $cvmv){
							if($cvmv == 'fullheight' || $cvmv == 'cover'){
								$max_height->$cvmk = 'full';
							}elseif($cvmv == 'cover-proportional'){
								$max_height->$cvmk = 'full-proportional';
							}else{
								if($type == 'image') $max_height->$cvmk = 'none';
							}
						}
					}else{
						foreach($cover_mode as $cvmk => $cvmv){
							if($type == 'image'){
								if($cvmv == 'fullheight' || $cvmv == 'cover'){
									$max_height = 'full';
								}elseif($cvmv == 'cover-proportional'){
									$max_height = 'full-proportional';
								}else{
									$max_height = 'none';
								}
							}else{
								if($cvmv == 'fullheight' || $cvmv == 'cover'){
									$max_height = 'full';
								}elseif($cvmv == 'cover-proportional'){
									$max_height = 'full-proportional';
								}
							}
							break;
						}
					}
				break;
				case 'svg':
				break;
			}
			
			if($type !== 'video'){
				//$static_data .= (is_object($max_width)) ? str_replace('px', '', "			data-minwidth=\"['".implode("','", (array)$max_width)."']\"")."\n" : str_replace('px', '', '			data-minwidth="'.$max_width.'"')."\n";
				$static_data .= (is_object($max_width)) ? str_replace('px', '', "			data-width=\"['".implode("','", (array)$max_width)."']\"")."\n" : str_replace('px', '', '			data-width="'.$max_width.'"')."\n";
				//$static_data .= (is_object($max_height)) ? str_replace('px', '', "			data-minheight=\"['".implode("','", (array)$max_height)."']\"")."\n" : str_replace('px', '', '			data-minheight="'.$max_height.'"')."\n";
				$static_data .= (is_object($max_height)) ? str_replace('px', '', "			data-height=\"['".implode("','", (array)$max_height)."']\"")."\n" : str_replace('px', '', '			data-height="'.$max_height.'"')."\n";
			}
			$static_data .= (is_object($white_space)) ? str_replace('px', '', "			data-whitespace=\"['".implode("','", (array)$white_space)."']\"")."\n" : str_replace('px', '', '			data-whitespace="'.$white_space.'"')."\n";
			
		}else{
			if(is_object($alignHor)) $alignHor = RevSliderFunctions::get_biggest_device_setting($alignHor, $this->enabled_sizes);
			if(is_object($alignVert)) $alignVert = RevSliderFunctions::get_biggest_device_setting($alignVert, $this->enabled_sizes);
			if(is_object($left)) $left = RevSliderFunctions::get_biggest_device_setting($left, $this->enabled_sizes);
			if(is_object($top)) $top = RevSliderFunctions::get_biggest_device_setting($top, $this->enabled_sizes);
			
			switch($alignHor){
				default:
				case 'left':
					$htmlPosX = ' data-x="'.$left.'"';
				break;
				case 'center':
					$htmlPosX = ' data-x="center" data-hoffset="'.$left.'"';
				break;
				case 'right':
					//$left = (int)$left*-1;
					$htmlPosX = ' data-x="right" data-hoffset="'.$left.'"';
				break;
			}
			
			switch($alignVert){
				default:
				case 'top':
					$htmlPosY = ' data-y="'.$top.'"';
				break;
				case 'middle':
					$htmlPosY = ' data-y="center" data-voffset="'.$top.'"';
				break;
				case 'bottom':
					//$top = (int)$top*-1;
					$htmlPosY = ' data-y="bottom" data-voffset="'.$top.'"';
				break;
			}
			
			
			$max_width = RevSliderFunctions::getVal($layer, 'max_width', 'auto');
			$max_height = RevSliderFunctions::getVal($layer, 'max_height', 'auto');
			$cover_mode = RevSliderFunctions::getVal($layer, 'cover_mode', array());
			
			if(is_string($cover_mode)){
				$cover_mode = array('desktop' => $cover_mode, 'notebook' => $cover_mode, 'tablet' => $cover_mode, 'mobile' => $cover_mode);
			}else{ //change to array
				$cover_mode = (array) $cover_mode;
			}
			
			switch($type){
				case 'shape':
				case 'image':
					if(is_object($max_width)){
						foreach($cover_mode as $cvmk => $cvmv){
							if($cvmv == 'fullwidth' || $cvmv == 'cover'){
								$max_width->$cvmk = 'full';
							}elseif($cvmv == 'cover-proportional'){
								$max_width->$cvmk = 'full-proportional';
							}else{
								if($type == 'image') $max_width->$cvmk = 'none';
							}
						}
					}else{
						foreach($cover_mode as $cvmk => $cvmv){
							if($type == 'image'){
								if($cvmv == 'fullwidth' || $cvmv == 'cover'){
									$max_width = 'full';
								}elseif($cvmv == 'cover-proportional'){
									$max_width = 'full-proportional';
								}else{
									$max_width = 'none';
								}
							}else{
								if($cvmv == 'fullwidth' || $cvmv == 'cover'){
									$max_width = 'full';
								}elseif($cvmv == 'cover-proportional'){
									$max_width = 'full-proportional';
								}
							}
							break;
						}
					}
					if(is_object($max_height)){
						foreach($cover_mode as $cvmk => $cvmv){
							if($cvmv == 'fullheight' || $cvmv == 'cover'){
								$max_height->$cvmk = 'full';
							}elseif($cvmv == 'cover-proportional'){
								$max_height->$cvmk = 'full-proportional';
							}else{
								if($type == 'image') $max_height->$cvmk = 'none';
							}
						}
					}else{
						foreach($cover_mode as $cvmk => $cvmv){
							if($type == 'image'){
								if($cvmv == 'fullheight' || $cvmv == 'cover'){
									$max_height = 'full';
								}elseif($cvmv == 'cover-proportional'){
									$max_height = 'full-proportional';
								}else{
									$max_height = 'none';
								}
							}else{
								if($cvmv == 'fullheight' || $cvmv == 'cover'){
									$max_height = 'full';
								}elseif($cvmv == 'cover-proportional'){
									$max_height = 'full-proportional';
								}
							}
							break;
						}
					}
				break;
				case 'svg':						
					
				break;
			}
			
			if($type !== 'video'){
				$static_data .= (is_object($max_width)) ? str_replace('px', '', "			data-width=\"['".implode("','", (array)$max_width)."']\"")."\n" : str_replace('px', '', '			data-width="'.$max_width.'"')."\n";
				$static_data .= (is_object($max_height)) ? str_replace('px', '', "			data-height=\"['".implode("','", (array)$max_height)."']\"")."\n" : str_replace('px', '', '			data-height="'.$max_height.'"')."\n";
			}
		}
		
		$style_string = '';
		
		$vis_desktop = RevSliderFunctions::getVal($layer, 'visible-desktop', true);
		$vis_notebook = RevSliderFunctions::getVal($layer, 'visible-notebook', true);
		$vis_tablet = RevSliderFunctions::getVal($layer, 'visible-tablet', true);
		$vis_mobile = RevSliderFunctions::getVal($layer, 'visible-mobile', true);
		$vis_notebook = ($vis_notebook === true) ? 'on' : 'off';
		$vis_desktop = ($vis_desktop === true) ? 'on' : 'off';
		$vis_tablet = ($vis_tablet === true) ? 'on' : 'off';
		$vis_mobile = ($vis_mobile === true) ? 'on' : 'off';
		
		if($vis_notebook == 'off' || $vis_desktop == 'off' || $vis_tablet == 'off' || $vis_mobile == 'off')
			$static_data .= "			data-visibility=\"['".$vis_desktop."','".$vis_notebook."','".$vis_tablet."','".$vis_mobile."']\"\n";
		
		$il_style = (array)RevSliderFunctions::getVal($layer, 'inline', array());
		$adv_style = (array)RevSliderFunctions::getVal($layer, 'advanced', array());
		
		//add deformation and hover deformation to the layers
		$def_val = (array) RevSliderFunctions::getVal($layer, 'deformation', array());
		$def = array();
		$st_idle = array();
		$def['o'] = array(RevSliderFunctions::getVal($def_val, 'opacity', '0'), '0');
		$def['sX'] = array(RevSliderFunctions::getVal($def_val, 'scalex', '1'), '1');
		$def['sY'] = array(RevSliderFunctions::getVal($def_val, 'scaley', '1'), '1');
		$def['skX'] = array(RevSliderFunctions::getVal($def_val, 'skewx', '0'), '0');
		$def['skY'] = array(RevSliderFunctions::getVal($def_val, 'skewy', '0'), '0');
		$def['rX'] = array(RevSliderFunctions::getVal($def_val, 'xrotate', '0'), '0');
		$def['rY'] = array(RevSliderFunctions::getVal($def_val, 'yrotate', '0'), '0');
		$def['rZ'] = array(RevSliderFunctions::getVal($layer, '2d_rotation', '0'), '0');
		$orix = RevSliderFunctions::getVal($def_val, '2d_origin_x', '50%');
		if(strpos($orix, '%') === false) $orix .= '%';
		$oriy = RevSliderFunctions::getVal($def_val, '2d_origin_y', '50%');
		if(strpos($oriy, '%') === false) $oriy .= '%';
		$def['tO'] = array($orix . ' ' . $oriy, '50% 50%');
		$def['tP'] = array(RevSliderFunctions::getVal($def_val, 'pers', '600'), '600');
		$def['z'] = array(RevSliderFunctions::getVal($def_val, 'z', '0'), '0');
		
		$st_idle['font-family'] = array(str_replace('"', "'", RevSliderFunctions::getVal($def_val, 'font-family', '')), str_replace('"', "'", $dff));
		//$st_idle['text-align'] 		= array(RevSliderFunctions::getVal($def_val, 'text-align', 'inherit'), 'ALWAYS'); //$dta
		$st_idle['text-transform'] 	= array(RevSliderFunctions::getVal($def_val, 'text-transform', 'left'), $dttr);
		
		//styling
		$mfs = RevSliderFunctions::getVal($def_val, 'font-style', 'off');
		$font_style = ($mfs == 'on' || $mfs == 'italic') ? 'italic' : 'normal';
		
		$st_idle['font-style'] = array($font_style, $dfs);
		$st_idle['text-decoration'] = array(RevSliderFunctions::getVal($def_val, 'text-decoration', 'none'), $dtd);
		
		$bg_color = RevSliderFunctions::getVal($def_val, 'background-color', $dbc);
		if($bg_color !== 'transparent'){
			$bg_trans = RevSliderFunctions::getVal($def_val, 'background-transparency', $dbt);
			if($bg_trans > 0) $bg_trans *= 100;
			if($dbt > 0) $dbt *= 100;
			$bg_trans = intval($bg_trans);
			$dbt = intval($dbt);
			$st_idle['background-color'] = array(RevSliderFunctions::hex2rgba($bg_color, $bg_trans), RevSliderFunctions::hex2rgba($dbc, $dbt)); //'ALWAYS'
		}
		
		/*$my_padding = RevSliderFunctions::getVal($def_val, 'padding', array('0px','0px','0px','0px'));
		if(!empty($my_padding)){
			if(is_array($my_padding))
				$my_padding = implode(' ', $my_padding);
			
			if(trim($my_padding) != '')
				$st_idle['padding'] = array($my_padding, $dpa);
		}*/
		
		$border_color = RevSliderFunctions::getVal($def_val, 'border-color', $dboc);
		if($border_color !== 'transparent'){
			$border_trans = RevSliderFunctions::getVal($def_val, 'border-transparency', $dbot);
			if($border_trans > 0) $border_trans *= 100;
			if($dbot > 0) $dbot *= 100;
			$border_trans = intval($border_trans);
			$dbot = intval($dbot);
			$st_idle['border-color'] = array(RevSliderFunctions::hex2rgba($border_color, $border_trans), RevSliderFunctions::hex2rgba($dboc, $dbot)); //'ALWAYS'
		}
		
		$st_idle['border-style'] = array(RevSliderFunctions::getVal($def_val, 'border-style', 'none'), $dbs);
		
		$bdw = RevSliderFunctions::getVal($def_val, 'border-width', '0px');
		$bdw = RevSliderFunctions::add_missing_val($bdw, 'px');
		if($bdw == '0px' || $bdw == '0px 0px 0px 0px') unset($st_idle['border-style']);
		$st_idle['border-width'] = array($bdw, $dbw);
		
		$my_border = RevSliderFunctions::getVal($def_val, 'border-width', array('0px','0px','0px','0px'));
		if(!empty($my_border) && is_array($my_border)){
			$my_border = RevSliderFunctions::add_missing_val($bdw, 'px');
			if(is_array($my_border)){
				$my_border = implode(' ', $my_border);
			}
			if($my_border == '0px' || $my_border == '0px 0px 0px 0px') unset($st_idle['border-style']);
			if(trim($my_border) != ''){
				$st_idle['border-width'] = array($my_border, $dbw);
			}
		}else{ //fallback
			$bdw = RevSliderFunctions::add_missing_val($bdw, 'px');
			if($bdw == '0px' || $bdw == '0px 0px 0px 0px') unset($st_idle['border-style']);
			$st_idle['border-width'] = array($bdw, $dbw);
		}
		
		$my_border = RevSliderFunctions::getVal($def_val, 'border-radius', array('0px','0px','0px','0px'));
		if(!empty($my_border)){
			$my_border = implode(' ', $my_border);
			if(trim($my_border) != '')
				$st_idle['border-radius'] = array($my_border, $dbr);
		}
		
		
		//Advanced Styles here:
		if(isset($adv_style['idle'])){
			$adv_style['idle'] = (array)$adv_style['idle'];
			if(!empty($adv_style['idle'])){
				foreach($adv_style['idle'] as $n => $v){
					$st_idle[$n] = array($v, 'ALWAYS');
				}
			}
		}
		
		//Advanced Styles here:
		if(isset($il_style['idle'])){
			$il_style['idle'] = (array)$il_style['idle'];
			if(!empty($il_style['idle'])){
				foreach($il_style['idle'] as $n => $v){
					$st_idle[$n] = array($v, 'ALWAYS');
				}
			}
		}
		
		//get hover stuff, because of css_cursor
		$def_val = (array) RevSliderFunctions::getVal($layer, 'deformation-hover', array());
		
		//add the css_cursor to the idle styles
		$css_cursor = RevSliderFunctions::getVal($def_val, 'css_cursor', 'auto');
		
		if(trim($css_cursor) !== '' && $css_cursor !== 'auto'){
			if($css_cursor == 'zoom-in') $css_cursor = '-webkit-zoom-in; cursor: -moz-zoom-in';
			if($css_cursor == 'zoom-out') $css_cursor = '-webkit-zoom-out; cursor: -moz-zoom-out';
			$st_idle['cursor']  =  array($css_cursor, 'auto');
		}
		
		$def_string = '';
		foreach($def as $key => $value){
			if(trim($value[0]) == '' || $value[0] == $value[1]) continue;
			if(str_replace('px', '', $value[0]) == str_replace('px', '', $value[1])) continue;
			$def_string .= $key.':'.$value[0].';';
		}
		
		foreach($st_idle as $key => $value){
			if($type == 'image' || $type == 'video'){ //do not print unneeded styles
				if(in_array($key, $this->ignore_styles)) continue;
			}
			if(trim($value[0]) == '' || $value[0] == $value[1]) continue;
			if(str_replace('px', '', $value[0]) == str_replace('px', '', $value[1])) continue;
			$style_string .= $key.':'.$value[0].';';
		}
		
		$frame_start['to'] = str_replace('"', "'", $def_string);
		
		$idle_style = $style_string;
		
		//check if hover is active for the layer
		$is_hover_active = RevSliderFunctions::getVal($layer, 'hover', '0');
		
		$def = array();
		
		$st_h_string = '';
		
		if($is_hover_active){
			
			$def['o'] = array(RevSliderFunctions::getVal($def_val, 'opacity', '0'), '0');
			$def['sX'] = array(RevSliderFunctions::getVal($def_val, 'scalex', '1'), '1');
			$def['sY'] = array(RevSliderFunctions::getVal($def_val, 'scaley', '1'), '1');
			$def['skX'] = array(RevSliderFunctions::getVal($def_val, 'skewx', '0'), '0');
			$def['skY'] = array(RevSliderFunctions::getVal($def_val, 'skewy', '0'), '0');
			$def['rX'] = array(RevSliderFunctions::getVal($def_val, 'xrotate', '0'), '0');
			$def['rY'] = array(RevSliderFunctions::getVal($def_val, 'yrotate', '0'), '0');
			$def['rZ'] = array(RevSliderFunctions::getVal($def_val, '2d_rotation', '0'), 'inherit');
			$def['z'] = array(RevSliderFunctions::getVal($def_val, 'z', '0'), '0');
			
			$frame_hover['frame'] = 'hover';
			$frame_hover['speed'] = RevSliderFunctions::getVal($def_val, 'speed', '300');
			$frame_hover['ease'] = RevSliderFunctions::getVal($def_val, 'easing', 'easeOutExpo');
			
			$fr_force_hover = RevSliderFunctions::getVal($layer, 'force_hover', '');
			if($fr_force_hover !== ''){
				$frame_hover['force'] = $fr_force_hover;
			}
			
			//style
			$st_hover = array();
			$font_color = RevSliderFunctions::getVal($def_val, 'color', '#000');
			if($font_color !== 'transparent'){
				$font_trans = RevSliderFunctions::getVal($def_val, 'color-transparency', 1);
				if($font_trans > 0) $font_trans *= 100;
				$font_trans = intval($font_trans);
				$st_hover['c'] = array(RevSliderFunctions::hex2rgba($font_color, $font_trans), 'ALWAYS');
			}else{
				$st_hover['c'] = array($font_color, 'ALWAYS');
			}
			$mfs = RevSliderFunctions::getVal($def_val, 'font-style', 'off');
			$font_style = ($mfs == 'on' || $mfs == 'italic') ? 'italic' : 'normal';
			$st_hover['fs'] = array($font_style, 'normal');
			$st_hover['td'] = array(RevSliderFunctions::getVal($def_val, 'text-decoration', 'none'), 'none');
			$bg_color = RevSliderFunctions::getVal($def_val, 'background-color', 'transparent');
			if($bg_color !== 'transparent'){
				$bg_trans = RevSliderFunctions::getVal($def_val, 'background-transparency', 1);
				if($bg_trans > 0) $bg_trans *= 100;
				$bg_trans = intval($bg_trans);
				$st_hover['bg'] = array(RevSliderFunctions::hex2rgba($bg_color, $bg_trans), 'ALWAYS');
			}
			
			$st_hover['zi'] = array(RevSliderFunctions::getVal($def_val, 'zindex', 'auto'), 'auto'); 
			
			$border_color = RevSliderFunctions::getVal($def_val, 'border-color', 'transparent');
			if($border_color !== 'transparent'){
				$border_trans = RevSliderFunctions::getVal($def_val, 'border-transparency', 1);
				if($border_trans > 0) $border_trans *= 100;
				$border_trans = intval($border_trans);
				$st_hover['bc'] = array(RevSliderFunctions::hex2rgba($border_color, $border_trans), 'ALWAYS');
			}
			
			$st_hover['bs'] = array(RevSliderFunctions::getVal($def_val, 'border-style', 'none'), 'none');
			$my_border_width = RevSliderFunctions::getVal($def_val, 'border-width', array('0px','0px','0px','0px'));
			if(!empty($my_border_width) && is_array($my_border_width)){
				$my_border_width = implode(' ', $my_border_width);
				
				if(trim($my_border_width) != ''){
					$brsthoverdw = (isset($st_hover['border-width']) && $st_hover['border-width'] !== '0px 0px 0px 0px') ? 'ALWAYS' : '0px 0px 0px 0px';
					$st_hover['bw'] = array($my_border_width, $brsthoverdw);
				}
			}else{
				$my_border_width = RevSliderFunctions::add_missing_val($my_border_width, 'px');
				$brsthoverdw = (isset($st_hover['border-width']) && $st_hover['border-width'] !== '0px 0px 0px 0px') ? 'ALWAYS' : '0px 0px 0px 0px';
				$st_hover['bw'] = array($my_border_width.' '.$my_border_width.' '.$my_border_width.' '.$my_border_width, $brsthoverdw);
			}
			
			
			$my_border = RevSliderFunctions::getVal($def_val, 'border-radius', array('0px','0px','0px','0px'));
			if(!empty($my_border)){
				$my_border = implode(' ', $my_border);
				
				if(trim($my_border) != ''){
					$brsthoverdw = (isset($st_idle['border-radius']) && $st_idle['border-radius'] !== '0px 0px 0px 0px') ? 'ALWAYS' : '0px 0px 0px 0px';
					$st_hover['br'] = array($my_border, $brsthoverdw);
				}
			}
			
			$st_trans = array( 
				'c' => 'color',
				'fs' => 'font-style',
				'td' => 'text-decoration',
				'bg' => 'background-color',
				//'p' => 'padding',
				'bc' => 'border-color',
				'bs' => 'border-style',
				'bw' => 'border-width',
				'br' => 'border-radius',
				'zi' => 'zIndex'
			);
			
			foreach($st_hover as $sk => $sv){ //do not write values for hover if idle is the same value					
				if(isset($st_idle[$st_trans[$sk]]) && $st_idle[$st_trans[$sk]][0] == $sv[0]) 
					unset($st_hover[$sk]);
			}
			
			
			//Advanced Styles here:
			if(isset($adv_style['hover'])){
				$adv_style['hover'] = (array)$adv_style['hover'];
				if(!empty($adv_style['hover'])){
					foreach($adv_style['hover'] as $n => $v){
						$st_hover[$n] = array($v, 'ALWAYS');
					}
				}
			}
			
			//Advanced Styles here:
			if(isset($il_style['hover'])){
				$il_style['hover'] = (array)$il_style['hover'];
				if(!empty($il_style['hover'])){
					foreach($il_style['hover'] as $n => $v){
						$st_hover[$n] = array($v, 'ALWAYS');
					}
				}
			}
			
			$def_string = '';
			foreach($def as $key => $value){
				if(trim($value[0]) == '' || $value[0] === $value[1]) continue;
				$def_string .= $key.':'.$value[0].';';
			}
			
			
			foreach($st_hover as $key => $value){
				if(trim($value[0]) == '' || $value[0] === $value[1]) continue;
				$st_h_string .= $key.':'.$value[0].';';
			}
			
			
			$frame_hover['to'] = $def_string;
			if($st_h_string !== ''){
				$frame_hover['style'] = $st_h_string;
			}
		}
		
		
		//set corners
		$htmlCorners = "";
		
		
		if($type == "text" || $type == "button"){
			$cornerdef = RevSliderFunctions::getVal($layer, "deformation");
			$cornerLeft = RevSliderFunctions::getVal($cornerdef, "corner_left");
			$cornerRight = RevSliderFunctions::getVal($cornerdef, "corner_right");
			switch($cornerLeft){
				case "curved":
					$htmlCorners .= "<div class='frontcorner'></div>";
				break;
				case "reverced":
					$htmlCorners .= "<div class='frontcornertop'></div>";
				break;
			}

			switch($cornerRight){
				case "curved":
					$htmlCorners .= "<div class='backcorner'></div>";
				break;
				case "reverced":
					$htmlCorners .= "<div class='backcornertop'></div>";
				break;
			}

		}
		
		//add resizeme class
		$resize_full = RevSliderFunctions::getVal($layer, "resize-full", true);
		if($resize_full === true || $resize_full == 'true' || $resize_full == '1'){
			$resizeme = RevSliderFunctions::getVal($layer, "resizeme", true);
			if($resizeme == "true" || $resizeme == "1")
				$outputClass .= ' tp-resizeme';

		}else{//end text related layer
			$extra_data .= '			data-responsive="off"';
		}
		
		//make some modifications for the full screen video
		if($isFullWidthVideo == true){
			$htmlPosX = ' data-x="0"';
			$htmlPosY = ' data-y="0"';
			$outputClass .= ' fullscreenvideo';
			
		}

		//parallax part
		$use_parallax = $this->slider->getParam('use_parallax', $this->slider->getParam('use_parallax', 'off'));

		$parallax_class = '';
		if($use_parallax == 'on'){
			$ldef = RevSliderFunctions::getVal($layer, 'deformation', array());
			$slide_level = RevSliderFunctions::getVal($ldef, 'parallax', '-');				
			$parallax_ddd = $this->slider->getParam("ddd_parallax","off");
			
			$parallax_ddd_bgfreeze=$this->slider->getParam("ddd_parallax_bgfreeze","off");
			$ddd_z = RevSliderFunctions::getVal($layer, 'parallax_layer_ddd_zlevel', ''); //bg , layers 

			if ($parallax_ddd=="on" && $slide_level=="-" && $ddd_z==="bg") $slide_level = "tobggroup";
			
			if($slide_level !== '-')
				$parallax_class = ' rs-parallaxlevel-'.$slide_level;
		}
		
		//check for actions
		$all_actions = RevSliderFunctions::getVal($layer, 'layer_action', array());
		
		$a_tooltip_event = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'tooltip_event', array()));
		$a_action = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'action', array()));
		$a_image_link = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'image_link', array()));
		$a_link_open_in = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'link_open_in', array()));
		$a_jump_to_slide = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'jump_to_slide', array()));
		$a_scrolloffset = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'scrollunder_offset', array()));
		$a_actioncallback = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'actioncallback', array()));
		$a_target = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'layer_target', array()));
		$a_action_delay = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'action_delay', array()));
		$a_link_type = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'link_type', array()));
		$a_toggle_layer_type = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'toggle_layer_type', array()));
		$a_toggle_class = RevSliderFunctions::cleanStdClassToArray(RevSliderFunctions::getVal($all_actions, 'toggle_class', array()));
		
		$a_html = '';
		$a_events = array();
		if(!empty($a_action)){
			$a_html .= "			data-actions='";
			foreach($a_action as $num => $action){
				$layer_attrID = '';
				switch($action){
					case 'start_in':
					case 'start_out':
					case 'start_video':
					case 'stop_video':
					case 'toggle_layer':
					case 'toggle_video':
					case 'simulate_click':
					case 'toggle_class':
					case 'toggle_mute_video':						
					case 'mute_video':
					case 'unmute_video':
						//get the ID of the layer with the unique_id that is $a_target[$num]
						$layer_attrID = $this->slide->getLayerID_by_unique_id($a_target[$num], $this->static_slide);
						if($a_target[$num] == 'backgroundvideo' || $a_target[$num] == 'firstvideo'){
							$layer_attrID = $a_target[$num];
						}elseif(trim($layer_attrID) == ''){
							if(strpos($a_target[$num], 'static-') !== false || $static_slide){
								$layer_attrID = 'slider-'.preg_replace("/[^\w]+/", "", $this->slider->getID()).'-layer-'.str_replace('static-', '', $a_target[$num]);
							}else{
								$layer_attrID = 'slide-'.preg_replace("/[^\w]+/", "", $this->slideID).'-layer-'.$a_target[$num];
							}
						}
					break;
				}
				
				switch($action){
					case 'none':
						continue;
					break;
					case 'link':
						//if post based, replace {{}} with correct info
						//a_image_link
						if(isset($a_image_link[$num])) $a_image_link[$num] = do_shortcode($a_image_link[$num]);
						if(isset($a_link_type[$num]) && $a_link_type[$num] == 'jquery'){
							/*
							$setBase = (is_ssl()) ? "https://" : "http://";
							if(strpos($a_image_link[$num], 'http') === false)
								$a_image_link[$num] = $setBase .$a_image_link[$num];
							*/
							$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
							$a_link_open_in[$num] = (isset($a_link_open_in[$num])) ? $a_link_open_in[$num] : '';
							$a_image_link[$num] = (isset($a_image_link[$num])) ? $a_image_link[$num] : '';
							$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
							
							$a_events[] = array(
								'event' => $a_tooltip_event[$num],
								'action' => 'simplelink',
								'target' => $a_link_open_in[$num],
								'url' => $a_image_link[$num],
								'delay' => $a_action_delay[$num]
							);
						}else{
							if($html_simple_link == ''){ //adds the link to the layer
								/*
								$setBase = (is_ssl()) ? "https://" : "http://";
								if(strpos($a_image_link[$num], 'http') === false)
									$a_image_link[$num] = $setBase .$a_image_link[$num];
								*/
								$a_image_link[$num] = (isset($a_image_link[$num])) ? $a_image_link[$num] : '';
								$a_link_open_in[$num] = (isset($a_link_open_in[$num])) ? $a_link_open_in[$num] : '';
								
								$html_simple_link = ' href="'.$a_image_link[$num].'"';
								$html_simple_link .=' target="'.$a_link_open_in[$num].'"';
							}
						}
					break;
					case 'jumpto':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_jump_to_slide[$num] = (isset($a_jump_to_slide[$num])) ? $a_jump_to_slide[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'jumptoslide',
							'slide' => 'rs-'.$a_jump_to_slide[$num],
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'next':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'jumptoslide',
							'slide' => 'next',
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'gofullscreen':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'gofullscreen',								
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'toggle_global_mute_video':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'toggle_global_mute_video',								
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'exitfullscreen':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'exitfullscreen',								
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'togglefullscreen':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'togglefullscreen',								
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'prev':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'jumptoslide',
							'slide' => 'previous',
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'pause':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'pauseslider',
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'resume':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'playslider',
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'toggle_slider':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'toggleslider',
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'callback':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_actioncallback[$num] = (isset($a_actioncallback[$num])) ? $a_actioncallback[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'callback',
							'callback' => $a_actioncallback[$num],
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'scroll_under': //ok
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_scrolloffset[$num] = (isset($a_scrolloffset[$num])) ? $a_scrolloffset[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'scrollbelow',
							'offset' => RevSliderFunctions::add_missing_val($a_scrolloffset[$num], 'px'),
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'start_in':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'startlayer',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'start_out':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'stoplayer',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'toggle_layer':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_toggle_layer_type[$num] = (isset($a_toggle_layer_type[$num])) ? $a_toggle_layer_type[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'togglelayer',
							'layerstatus' => $a_toggle_layer_type[$num],
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'start_video':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'playvideo',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'stop_video':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'stopvideo',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'mute_video':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'mutevideo',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'unmute_video':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'unmutevideo',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'toggle_video':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'togglevideo',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'toggle_mute_video':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'toggle_mute_video',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'simulate_click':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'simulateclick',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num]
						);
					break;
					case 'toggle_class':
						$a_tooltip_event[$num] = (isset($a_tooltip_event[$num])) ? $a_tooltip_event[$num] : '';
						$a_action_delay[$num] = (isset($a_action_delay[$num])) ? $a_action_delay[$num] : '';
						$a_toggle_class[$num] = (isset($a_toggle_class[$num])) ? $a_toggle_class[$num] : '';
						
						$a_events[] = array(
							'event' => $a_tooltip_event[$num],
							'action' => 'toggleclass',
							'layer' => $layer_attrID,
							'delay' => $a_action_delay[$num],
							'classname' => $a_toggle_class[$num]
						);
					break;
				}

				// Filter the Actions
				$a_events = apply_filters( 'rs_action_output_layer_action', $a_events, $action, $all_actions, $num, $this->slide);

			}
			if(!empty($a_events)){
				$a_html .= json_encode($a_events);
			}
			$a_html .= "'\n";
		}
		
		//check for loop animation here
		$do_loop = RevSliderFunctions::getVal($layer, 'loop_animation', 'none');
		$loop_data = '';
		$loop_class = '';
		
		if($do_loop !== 'none'){
			$loop_class = ' '.$do_loop;
			switch($do_loop){
				case 'rs-pendulum':
					$loop_data.= ' data-easing="'.RevSliderFunctions::getVal($layer, 'loop_easing', 'Power3.easeInOut').'"';
					$loop_data.= ' data-startdeg="'.RevSliderFunctions::getVal($layer, 'loop_startdeg', '-20').'"';
					$loop_data.= ' data-enddeg="'.RevSliderFunctions::getVal($layer, 'loop_enddeg', '20').'"';
					$loop_data.= ' data-speed="'.RevSliderFunctions::getVal($layer, 'loop_speed', '2').'"';
					$loop_data.= ' data-origin="'.RevSliderFunctions::getVal($layer, 'loop_xorigin', '50').'% '.RevSliderFunctions::getVal($layer, 'loop_yorigin', '50').'%"';
				break;
				case 'rs-rotate':
					$loop_data.= ' data-easing="'.RevSliderFunctions::getVal($layer, 'loop_easing', 'Power3.easeInOut').'"';
					$loop_data.= ' data-startdeg="'.RevSliderFunctions::getVal($layer, 'loop_startdeg', '-20').'"';
					$loop_data.= ' data-enddeg="'.RevSliderFunctions::getVal($layer, 'loop_enddeg', '20').'"';
					$loop_data.= ' data-speed="'.RevSliderFunctions::getVal($layer, 'loop_speed', '2').'"';
					$loop_data.= ' data-origin="'.RevSliderFunctions::getVal($layer, 'loop_xorigin', '50').'% '.RevSliderFunctions::getVal($layer, 'loop_yorigin', '50').'%"';
				break;
				
				case 'rs-slideloop':
					$loop_data.= ' data-easing="'.RevSliderFunctions::getVal($layer, 'loop_easing', 'Power3.easeInOut').'"';
					$loop_data.= ' data-speed="'.RevSliderFunctions::getVal($layer, 'loop_speed', '1').'"';
					$loop_data.= ' data-xs="'.RevSliderFunctions::getVal($layer, 'loop_xstart', '0').'"';
					$loop_data.= ' data-xe="'.RevSliderFunctions::getVal($layer, 'loop_xend' ,'0').'"';
					$loop_data.= ' data-ys="'.RevSliderFunctions::getVal($layer, 'loop_ystart', '0').'"';
					$loop_data.= ' data-ye="'.RevSliderFunctions::getVal($layer, 'loop_yend', '0').'"';
				break;
				case 'rs-pulse':
					$loop_data.= ' data-easing="'.RevSliderFunctions::getVal($layer, 'loop_easing', 'Power3.easeInOut').'"';
					$loop_data.= ' data-speed="'.RevSliderFunctions::getVal($layer, 'loop_speed', '1').'"';
					$loop_data.= ' data-zoomstart="'.RevSliderFunctions::getVal($layer, 'loop_zoomstart', '1').'"';
					$loop_data.= ' data-zoomend="'.RevSliderFunctions::getVal($layer, 'loop_zoomend', '1').'"';
				break;
				case 'rs-wave':
					$loop_data.= ' data-speed="'.RevSliderFunctions::getVal($layer, 'loop_speed', '1').'"';
					$loop_data.= ' data-angle="'.RevSliderFunctions::getVal($layer, 'loop_angle', '0').'"';
					$loop_data.= ' data-radius="'.RevSliderFunctions::getVal($layer, 'loop_radius', '10').'"';
					$loop_data.= ' data-origin="'.RevSliderFunctions::getVal($layer, 'loop_xorigin', '50').'% '.RevSliderFunctions::getVal($layer, 'loop_yorigin', '50').'%"';
				break;
			}
		}
		
		if (!empty($svg_val) &&  sizeof($svg_val)>0) $outputClass .=' tp-svg-layer'; 
		
		$layer_id = $this->zIndex - 4;
		
		$use_tag = RevSliderFunctions::getVal($layer, 'html_tag', 'div');
		
		if($html_simple_link !== '') $use_tag = 'a';
		
		if($special_type !== false){ //if we are special type, only allow div to be the structure, as we will close with a div outside of this function
			$use_tag = 'div';
		}
		
		echo "\n		<!-- LAYER NR. ";
		echo $layer_id;
		echo " -->\n";
		echo '		<'.$use_tag.' class="'.$outputClass;
		echo ($classes != '') ? ' '.$classes : '';
		echo $parallax_class;
		if($static_slide) echo ' tp-static-layer';
		
		echo $videoclass;
		
		echo "\" \n";
		echo $html_simple_link;
		echo ($ids != '') ? '			'.$ids." \n" : '';
		echo ($title != '') ? '			'.$title." \n" : '';
		echo ($rel != '') ? '			'.$rel." \n" : '';
		if($htmlPosX != '') echo '			'.$htmlPosX." \n";
		if($htmlPosY != '') echo '			'.$htmlPosY." \n";
		if($static_data != '') echo '			'.$static_data." \n";
		
		$frame_start['delay'] = $time; 
		
		echo '			data-type="'.esc_attr($type).'"'." \n";
		if ($columnbreak != '') echo '			data-columnbreak="'.$columnbreak.'"'." \n";
		
		if($type == 'text' || $type == 'button'){ //only output if we are a text layer
			$frame_start['split'] = $splitin;
			$frame_end['split'] = $splitout;
		}
		
		do_action('revslider_add_layer_attributes', $layer, $this->slide, $this->slider);
		
		echo $a_html;
		
		// SVG OUTPUT
		if (!empty($svg_val) && sizeof($svg_val)>0) {				
			echo '			data-svg_src="'.$svg_val->{'src'}.'"'." \n";
			echo '			data-svg_idle="sc:'.$svg_val->{'svgstroke-color'}.';sw:'.$svg_val->{'svgstroke-width'}.';sda:'.$svg_val->{'svgstroke-dasharray'}.';sdo:'.$svg_val->{'svgstroke-dashoffset'}.';"'." \n";
			if($is_hover_active){
				echo '			data-svg_hover="sc:'.$svg_val->{'svgstroke-hover-color'}.';sw:'.$svg_val->{'svgstroke-hover-width'}.';sda:'.$svg_val->{'svgstroke-hover-dasharray'}.';sdo:'.$svg_val->{'svgstroke-hover-dashoffset'}.';"'." \n";
			}
		}

		if($basealign !== 'grid'){
			echo '			data-basealign="'.$basealign.'"'." \n";
		}
		$ro = RevSliderFunctions::getVal($layer, 'responsive_offset', true);
		
		if($ro!=1){
			echo '			data-responsive_offset="off"'." \n";
		} else {
			echo '			data-responsive_offset="on"'." \n";
		}
		
		if($wrapper_ids !== ''){
			echo '			data-wrapper_id="'.$wrapper_ids.'"'." \n";
		}
		if($wrapper_classes !== ''){
			echo '			data-wrapper_class="'.$wrapper_classes.'"'." \n";
		}
		
		echo $extra_data."\n";
		//check if static layer and if yes, set values for it.
		if($static_slide){
			if($this->slider->getParam('template', 'false') != "true" && $this->slider->getParam('slider-type') !== 'hero'){
				$start_on_slide = intval(RevSliderFunctions::getVal($layer,"static_start",1)) - 1;
				$end_on_slide = RevSliderFunctions::getVal($layer,"static_end",2);
				if($end_on_slide !== 'last'){
					$end_on_slide = intval($end_on_slide) - 1;
				}else{ //change number to the last slide number
					$end_on_slide = count($this->slider->getArrSlideNames()) - 1;
				}
			}else{
				$start_on_slide = '-1';
				$end_on_slide = '-1';
			}
			
			echo '			data-startslide="'.$start_on_slide.'"'." \n";
			echo '			data-endslide="'.$end_on_slide.'"'." \n";
		}
		if($splitin !== 'none'){
			$frame_start['splitdelay'] = $elementdelay;
		}
		if($splitout !== 'none'){
			$frame_end['splitdelay'] = $endelementdelay;
		}
		
		if(!empty($frame_start)){
			//remove unneeded things in output
			unset($frame_start['time']);
			unset($frame_end['time']);
			unset($frame_start['split_extratime']);
			unset($frame_end['split_extratime']);
			unset($frame_start['animation']);
			unset($frame_end['animation']);
			unset($frame_start['time_relative']);
			unset($frame_end['time_relative']);
			if(isset($frame_start['easing'])){
				$frame_start['ease'] = $frame_start['easing'];
				unset($frame_start['easing']);
			}
			
			if(isset($frame_end['easing'])){
				$frame_end['ease'] = $frame_end['easing'];
				unset($frame_end['easing']);
			}
			
			if(empty($frame_start['split']) || $frame_start['split'] == 'none'){
				unset($frame_start['split']);
				unset($frame_start['splitdelay']);
			}
			if(empty($frame_end['split']) || $frame_end['split'] == 'none'){
				unset($frame_end['split']);
				unset($frame_end['splitdelay']);
			}
			
			echo "			data-frames='[";
			echo json_encode($frame_start);
			echo ',';
			echo json_encode($frame_end);
			if(!empty($frame_hover)){
				echo ',';
				echo json_encode($frame_hover);
			}
			echo "]'\n";
		}
		
		if($htmlParams != "") echo $htmlParams;
		
		$zi = RevSliderFunctions::getVal($layer, 'zIndex', false);
		$zi = ($zi === false) ? $this->zIndex : $zi;
		
		echo '			style="z-index: '.$zi.';'.$inline_styles. $idle_style.'"';
		
		echo '>';
		
		if($background_image !== ''){
			echo "\n".'<div class="tp-element-background" style="'.$background_image.'"></div>';
		}
		
		if($do_loop !== 'none'){
			echo "\n".'<div class="rs-looped '.trim($loop_class).'" '.$loop_data.'>';
		}
		
		if ($toggle_allow!=false) {
			echo '<div class="';
			echo ($toggle_inverse_content === true) ? 'rs-toggled-content' : 'rs-untoggled-content';
			echo '">';
		}
		if($special_type === false){
			echo apply_filters('revslider_layer_content', stripslashes($html), $html, $this->slider->getID(), $this->slide, $layer)." ";
		}
		if ($toggle_allow!=false) {
			echo '</div>';
			echo '<div class="';
			echo ($toggle_inverse_content === true) ? 'rs-untoggled-content' : 'rs-toggled-content';
			echo '">'.stripslashes($html_toggle).'</div>';
		}
		if($htmlCorners != ""){
			echo $htmlCorners." ";
		}
		if($do_loop !== 'none'){
			echo "</div>";
		}
		
		if($special_type === false){ //the closing will be written later, after all layers/columns are added
			echo '</'.$use_tag.'>'."\n";
		}
		$this->zIndex++;
		
	}
	
	
	/**
	 * Add Groups with columns and the layers of it
	 * @since: 5.3.0
	 */
	public function putCreativeZones(){
		$layers = $this->slide->getLayers();
		
		if(empty($layers)){
			return false;
		}
		
		$this->container_mode = '';
		
		$zones = array('t' => 'top', 'm' => 'middle', 'b' => 'bottom');
		$enabled_sizes = array('desktop' => 'on', 'notebook' => 'off', 'tablet' => 'off', 'mobile' => 'off');
		
		foreach($zones as $zs => $zone){ //go through all three zones
			$lzone = array();
			foreach($layers as $layer){
				if(RevSliderFunctions::getVal($layer, 'type', 'text') !== 'row') continue; //we only want to handle rows here to get the zones we need to create
				
				$this->row_zindex = 0;
				
				$layer_zone = RevSliderFunctions::getVal($layer, 'align_vert');
				$layer_zone = (is_object($layer_zone)) ? RevSliderFunctions::get_biggest_device_setting($layer_zone, $enabled_sizes) : $layer_zone;
				
				if($layer_zone !== $zone) continue; //wrong zones, so continue
				
				//we have found a zone, now fill it with rows, columns, layers
				ob_start(); //fetch the data, as we need to set the z-index on the rows
				$this->putCreativeRows($layers, $layer_zone);
				$row_layers = ob_get_contents();
				ob_clean();
				ob_end_clean();
				
				echo '		<div id="rrz'.$zs.'_'.$this->slide->getID().'" class="rev_row_zone rev_row_zone_'.$zone.'" style="z-index: '.$this->row_zindex.';">'."\n";
				echo $row_layers;
				echo '		</div>'."\n";
				
				break; //zone is written, go to the next one
			}
		}
	}
	
	
	/**
	 * Add Groups with columns and the layers of it
	 * @since: 5.3.0
	 */
	public function putCreativeRows($layers, $current_zone){
		
		if(empty($layers)){
			return false;
		}
		
		$enabled_sizes = array('desktop' => 'on', 'notebook' => 'off', 'tablet' => 'off', 'mobile' => 'off');
		
		$row_layer = array();
		$go = 9999;
		foreach($layers as $layer){
			if(RevSliderFunctions::getVal($layer, 'type', 'text') !== 'row') continue; //we only want to handle rows here of the current zone and add them as a rows
			
			$layer_zone = RevSliderFunctions::getVal($layer, 'align_vert');
			$layer_zone = (is_object($layer_zone)) ? RevSliderFunctions::get_biggest_device_setting($layer_zone, $enabled_sizes) : $layer_zone;
			
			if($layer_zone !== $current_zone) continue; //wrong zones, so continue
			
			$groupOrder = RevSliderFunctions::getVal($layer, 'groupOrder');
			if($groupOrder === ''){
				$groupOrder = $go;
				$go++;
			}
			
			$zi = RevSliderFunctions::getVal($layer, 'zIndex', false); // set the z-index so that the wrapper gains the highest one
			$zi = ($zi === false) ? $this->zIndex : $zi;
			if($zi > $this->row_zindex){
				$this->row_zindex = $zi;
			}
			
			$row_layer[$groupOrder] = $layer;
		}
		
		if(!empty($row_layer)){
			ksort($row_layer); //sort the rows
			
			foreach($row_layer as $layer){
				$unique_id = RevSliderFunctions::getVal($layer, 'unique_id');
				
				$this->putLayer($layer, true, false, 'row');
				
				$this->container_mode = 'row';
				
				$this->putCreativeColumn($layers, $unique_id);
				
				echo '			</div>'."\n"; //as we have used 'row' in the putLayer() function, it does not print the closing </div> and we have to do it here
			}
		}
	}
	
	
	/**
	 * Add Columns with the layers
	 * @since: 5.3.0
	 */
	public function putCreativeColumn($layers, $unique_id){
		
		if(empty($layers)){
			return false;
		}
		
		foreach($layers as $layer){
			
			$this->container_mode = 'row';
			
			if(RevSliderFunctions::getVal($layer, 'type', 'text') !== 'column') continue; //we only want to handle columns here of the current row
			if(RevSliderFunctions::getVal($layer, 'p_uid', -1) !== $unique_id) continue; //has the wrong row ID
			
			$this->putLayer($layer, true, false, 'column');
			$cuid = RevSliderFunctions::getVal($layer, 'unique_id', -1);
			
			//add layers here
			$group_layers = array();
			$go = 9999;
			foreach($layers as $nlayer){
				$uid = RevSliderFunctions::getVal($nlayer, 'p_uid', -1);
				if($uid !== $cuid) continue;
				
				$groupOrder = RevSliderFunctions::getVal($nlayer, 'groupOrder');
				if($groupOrder === ''){
					$groupOrder = $go;
					$go++;
				}
				
				$group_layers[$groupOrder] = $nlayer;
			}
			
			$this->container_mode = 'column';
			
			//sort now the $group_layers
			if(!empty($group_layers)){
				ksort($group_layers);
				
				foreach($group_layers as $nlayer){
					$this->putLayer($nlayer, true);
				}
			}
			
			echo '				</div>'."\n"; //as we have used 'column' in the putLayer() function, it does not print the closing </div> and we have to do it here
		}
		
	}
	
	
	/**
	 * Add Groups with columns and the layers of it
	 * @since: 5.3.0
	 */
	public function putCreativeGroups(){
		$layers = $this->slide->getLayers();
		
		if(empty($layers)){
			return false;
		}
		
		
		
		$enabled_sizes = array('desktop' => 'on', 'notebook' => 'off', 'tablet' => 'off', 'mobile' => 'off');
		
		foreach($layers as $layer){
			if(RevSliderFunctions::getVal($layer, 'type', 'text') !== 'group') continue; //we only want to handle groups here to get the zones we need to create
			
			$this->container_mode = '';
			
			$unique_id = RevSliderFunctions::getVal($layer, 'unique_id');
			
			$this->putLayer($layer, true, false, 'group'); //add the group layer
			
			$this->container_mode = 'group';
		
			$this->putCreativeGroupLayer($layers, $unique_id); //add all layers that are in the group
			
			echo '		</div>'."\n";

		}
	}
	
	
	/**
	 * Add all Layers that are in the group with $u_id
	 * @since: 5.3.0
	 */
	public function putCreativeGroupLayer($layers, $u_id){
		
		foreach($layers as $layer){
			$unique_id = RevSliderFunctions::getVal($layer, 'p_uid');
			
			if($u_id !== $unique_id) continue;
			
			$this->putLayer($layer, true); //add the layer into the group
		}
	}
	
	
	/**
	 * put slider javascript
	 */
	private function putJS($markup_export = false){

		$params = $this->slider->getParams();
		$sliderType = $this->slider->getParam('slider_type');
		$force_fullwidth = $this->slider->getParam('force_full_width','on');

		if($sliderType == 'fixed' || $sliderType == 'responsitive' || ($sliderType == 'fullwidth' && $force_fullwidth=="off")) $sliderType = 'auto';

		$optFullWidth = ($sliderType == 'fullwidth') ? 'on' : 'off';
		$optFullScreen = 'off';

		if($sliderType == 'fullscreen'){
			$optFullWidth = 'off';
			$optFullScreen = 'on';
		}

		$use_spinner = $this->slider->getParam('use_spinner', '0');
		$spinner_color = $this->slider->getParam('spinner_color', '#FFFFFF');

		$noConflict = $this->slider->getParam("jquery_noconflict","on");
		$debugmode = ($this->slider->getParam("jquery_debugmode","off")=='on') ? 'true' : 'false';
		

		//set thumb amount
		$numSlides = $this->slider->getNumSlides(true);

		//get stop slider options
		
		$stopSlider = $this->slider->getParam("stop_slider","off");
		$stopAfterLoops = $this->slider->getParam("stop_after_loops","0");
		$stopAtSlide = $this->slider->getParam("stop_at_slide","2");

		if($stopSlider == "off"){
			$stopAfterLoops = "-1";
			$stopAtSlide = "-1";
		}

		$oneSlideLoop = $this->slider->getParam("loop_slide","loop");
		if($oneSlideLoop == 'noloop' && $this->hasOnlyOneSlide == true){
			$stopAfterLoops = '0';
			$stopAtSlide = '1';
		}

		$sliderID = $this->slider->getID();

		//treat hide slider at limit
		$hideSliderAtLimit = $this->slider->getParam("hide_slider_under","0",RevSlider::VALIDATE_NUMERIC);
		if(!empty($hideSliderAtLimit))
			$hideSliderAtLimit++;

		$hideCaptionAtLimit = $this->slider->getParam("hide_defined_layers_under","0",RevSlider::VALIDATE_NUMERIC);;
		if(!empty($hideCaptionAtLimit))
			$hideCaptionAtLimit++;

		$hideAllCaptionAtLimit = $this->slider->getParam("hide_all_layers_under","0",RevSlider::VALIDATE_NUMERIC);;
		if(!empty($hideAllCaptionAtLimit))
			$hideAllCaptionAtLimit++;

		//start_with_slide
		$startWithSlide = $this->slider->getStartWithSlideSetting();

		//modify navigation type (backward compatability)
		//FALLBACK
		$enable_arrows = $this->slider->getParam('enable_arrows','off');
		$arrowsType = ($enable_arrows == 'on') ? 'solo' : 'none';
		

		//More Mobile Options
		$hideThumbsOnMobile = $this->slider->getParam("hide_thumbs_on_mobile","off");
		$enable_progressbar =  $this->slider->getParam('enable_progressbar','on');
		
		$disableKenBurnOnMobile =  $this->slider->getParam("disable_kenburns_on_mobile","off");

		$swipe_velocity = $this->slider->getParam("swipe_velocity","0.7",RevSlider::VALIDATE_NUMERIC);
		$swipe_min_touches = $this->slider->getParam("swipe_min_touches","1",RevSlider::VALIDATE_NUMERIC);
		$swipe_direction = $this->slider->getParam("swipe_direction", "horizontal");
		$drag_block_vertical = $this->slider->getParam("drag_block_vertical","false");

		$use_parallax = $this->slider->getParam("use_parallax",$this->slider->getParam('use_parallax', 'off'));
		$disable_parallax_mobile = $this->slider->getParam("disable_parallax_mobile","off");

		if($use_parallax == 'on'){
			$parallax_ddd = $this->slider->getParam("ddd_parallax","off");
			$parallax_type = $this->slider->getParam("parallax_type","mouse");
			$parallax_origo = $this->slider->getParam("parallax_origo","enterpoint");
			$parallax_speed = $this->slider->getParam("parallax_speed","400");

			if ($parallax_ddd=="on") {
				$parallax_type="3D";
				$parallax_origo="slidercenter";
				$parallax_ddd_shadow=$this->slider->getParam("ddd_parallax_shadow","on");
				$parallax_ddd_bgfreeze=$this->slider->getParam("ddd_parallax_bgfreeze","off");
				$parallax_ddd_overflow=$this->slider->getParam("ddd_parallax_overflow","off");
				$parallax_ddd_layer_overflow=$this->slider->getParam("ddd_parallax_layer_overflow","off");
				
				$parallax_ddd_overflow= $parallax_ddd_overflow == "off" ? "visible" : "hidden";
				$parallax_ddd_layer_overflow= $parallax_ddd_layer_overflow == "off" ? "visible" : "hidden";
				$parallax_ddd_zcorrection = $this->slider->getParam("ddd_parallax_zcorrection","400");
				//$parallax_ddd_path = $this->slider->getParam("ddd_parallax_path","mouse");
			}
			
			$parallax_level[] = intval($this->slider->getParam("parallax_level_1","5"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_2","10"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_3","15"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_4","20"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_5","25"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_6","30"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_7","35"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_8","40"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_9","45"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_10","45"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_11","46"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_12","47"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_13","48"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_14","49"));			
			$parallax_level[] = intval($this->slider->getParam("parallax_level_15","50"));
			$parallax_level[] = intval($this->slider->getParam("parallax_level_16","55"));
			$parallax_level = implode(',', $parallax_level);
		}

		$operations = new RevSliderOperations();
		$arrValues = $operations->getGeneralSettingsValues();
		
		$do_delay = $this->slider->getParam("start_js_after_delay","0");
		$do_delay = apply_filters('revslider_add_js_delay', $do_delay);
		$do_delay = intval($do_delay);
		
		$js_to_footer = (isset($arrValues['js_to_footer']) && $arrValues['js_to_footer'] == 'on') ? true : false;
		
		$slider_type = $this->slider->getParam('slider-type', 'standard');
		
		//add inline style into the footer
		if($js_to_footer && $this->previewMode == false && $markup_export == false){
			ob_start();
		}
		
		$nav_css = '';
		
		if($markup_export === true){
			echo '<!-- STYLE -->';
		}
		//ADD SCOPED INLINE STYLES 			
		$this->add_inline_styles();
		
		if($markup_export === true){
			echo '<!-- /STYLE -->';
		}
		$csizes = RevSliderFunctions::get_responsive_size($this);
		
		if($markup_export === true){
			echo '<!-- SCRIPT -->';
		}
		?>
		<script type="text/javascript">
			<?php if(!$markup_export){ //not needed for html markup export ?>
			/******************************************
				-	PREPARE PLACEHOLDER FOR SLIDER	-
			******************************************/

			var setREVStartSize=function(){
				try{var e=new Object,i=jQuery(window).width(),t=9999,r=0,n=0,l=0,f=0,s=0,h=0;
					e.c = jQuery('#<?php echo $this->sliderHtmlID;?>');
<?php if(isset($csizes['level']) && !empty($csizes['level'])){ ?>
					e.responsiveLevels = <?php echo '['. $csizes['level'] .']'; ?>;
					e.gridwidth = <?php echo '['. $csizes['width'] .']'; ?>;
					e.gridheight = <?php echo '['. $csizes['height'] .']'; ?>;
<?php } else {?>
					e.gridwidth = <?php echo '['. $csizes['width'] .']'; ?>;
					e.gridheight = <?php echo '['. $csizes['height'] .']'; ?>;
<?php } ?>							
<?php if($optFullScreen == 'on'){
						$sl_layout = 'fullscreen';
					}elseif($optFullWidth == 'on'){
						$sl_layout = 'fullwidth';
					}else{
						$sl_layout = 'auto';}?>
					e.sliderLayout = "<?php echo $sl_layout; ?>";
<?php if($this->slider->getParam("slider_type") == "fullscreen"){ ?>
					e.fullScreenAutoWidth='<?php echo esc_attr($this->slider->getParam("autowidth_force","off")); ?>';
					e.fullScreenAlignForce='<?php echo esc_attr($this->slider->getParam("full_screen_align_force","off")); ?>';
					e.fullScreenOffsetContainer= '<?php echo esc_attr($this->slider->getParam("fullscreen_offset_container","")); ?>';
					e.fullScreenOffset='<?php echo esc_attr($this->slider->getParam("fullscreen_offset_size","")); ?>';
<?php } ?>
<?php $minHeight = ($this->slider->getParam('slider_type') !== 'fullscreen') ? $this->slider->getParam('min_height', '0') : $this->slider->getParam('fullscreen_min_height', '0');
					if($minHeight > 0){ ?>
					e.minHeight = "<?php echo $minHeight; ?>";
<?php } ?>
					if(e.responsiveLevels&&(jQuery.each(e.responsiveLevels,function(e,f){f>i&&(t=r=f,l=e),i>f&&f>r&&(r=f,n=e)}),t>r&&(l=n)),f=e.gridheight[l]||e.gridheight[0]||e.gridheight,s=e.gridwidth[l]||e.gridwidth[0]||e.gridwidth,h=i/s,h=h>1?1:h,f=Math.round(h*f),"fullscreen"==e.sliderLayout){var u=(e.c.width(),jQuery(window).height());if(void 0!=e.fullScreenOffsetContainer){var c=e.fullScreenOffsetContainer.split(",");if (c) jQuery.each(c,function(e,i){u=jQuery(i).length>0?u-jQuery(i).outerHeight(!0):u}),e.fullScreenOffset.split("%").length>1&&void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0?u-=jQuery(window).height()*parseInt(e.fullScreenOffset,0)/100:void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0&&(u-=parseInt(e.fullScreenOffset,0))}f=u}else void 0!=e.minHeight&&f<e.minHeight&&(f=e.minHeight);e.c.closest(".rev_slider_wrapper").css({height:f})
					
				}catch(d){console.log("Failure at Presize of Slider:"+d)}
			};
			
			setREVStartSize();
			
			<?php } ?>
			var tpj=jQuery;
			<?php if($noConflict == "on"){ ?>tpj.noConflict();<?php } ?>

			var revapi<?php echo $sliderID; ?>;
			<?php

			echo 'tpj(document).ready(function() {'."\n";
			echo '				if(tpj("#'.$this->sliderHtmlID.'").revolution == undefined){'."\n";
			echo '					revslider_showDoubleJqueryError("#'.$this->sliderHtmlID.'");'."\n";
			echo '				}else{'."\n";
			echo '					revapi'. $sliderID.' = tpj("#'. $this->sliderHtmlID .'").show().revolution({'."\n";
			if($do_delay > 0){
				echo '						startDelay: '. esc_attr($do_delay) .','."\n";
			} 
			
			echo '						sliderType:"'. esc_attr($slider_type) .'",'."\n";
			
			$stripped_http = explode('://', RS_PLUGIN_URL);
			echo 'jsFileLocation:"//'. esc_attr( $stripped_http[1] .'public/assets/js/' ) .'",'."\n";

			if($optFullScreen == 'on'){
				$sl_layout = 'fullscreen';
			}elseif($optFullWidth == 'on'){
				$sl_layout = 'fullwidth';
			}else{
				$sl_layout = 'auto';
			}
			echo '						sliderLayout:"'.$sl_layout.'",'."\n";
			echo '						dottedOverlay:"'. esc_attr($this->slider->getParam("background_dotted_overlay","none")).'",'."\n";
			echo '						delay:'.esc_attr($this->slider->getParam("delay","9000",RevSlider::FORCE_NUMERIC)) .','."\n";
			
			do_action('revslider_fe_javascript_option_output', $this->slider);
			
			$enable_arrows = $this->slider->getParam('enable_arrows','off');
			$enable_bullets = $this->slider->getParam('enable_bullets','off');
			$enable_tabs = $this->slider->getParam('enable_tabs','off');
			$enable_thumbnails = $this->slider->getParam('enable_thumbnails','off');
			
			$rs_nav = new RevSliderNavigation();
			$all_navs = $rs_nav->get_all_navigations();
			$touch_enabled = $this->slider->getParam('touchenabled', 'on');
			$keyboard_enabled = $this->slider->getParam('keyboard_navigation', 'off');
			$keyboard_direction = $this->slider->getParam('keyboard_direction', 'horizontal');
			$mousescroll_enabled = $this->slider->getParam('mousescroll_navigation', 'off');
			$mousescroll_reverse = $this->slider->getParam('mousescroll_navigation_reverse', 'default');
			
			//no navigation if we are hero
			if($slider_type !== 'hero' && ($enable_arrows == 'on' || $enable_bullets == 'on' || $enable_tabs == 'on' || $enable_thumbnails == 'on' || $touch_enabled == 'on' || $keyboard_enabled == 'on' || $mousescroll_enabled != 'off')){
				echo '						navigation: {'."\n";
				echo '							keyboardNavigation:"'. esc_attr($keyboard_enabled) .'",'."\n";
				echo '							keyboard_direction: "'. esc_attr($keyboard_direction) .'",'."\n";
				echo '							mouseScrollNavigation:"'. esc_attr($mousescroll_enabled) .'",'."\n";
				echo ' 							mouseScrollReverse:"'. esc_attr($mousescroll_reverse) .'",'."\n";
				
				if($slider_type !== 'hero')
					echo '							onHoverStop:"'. esc_attr($this->slider->getParam("stop_on_hover","on")).'",'."\n";
				
				$add_comma = false;
				if($touch_enabled == 'on'){
					$add_comma = true;
					echo '							touch:{'."\n";
					echo '								touchenabled:"'. esc_attr($touch_enabled).'",'."\n";
					echo '								swipe_threshold: '. esc_attr($swipe_velocity) .','."\n";
					echo '								swipe_min_touches: '. esc_attr($swipe_min_touches) .','."\n";
					echo '								swipe_direction: "'. esc_attr($swipe_direction) .'",'."\n";
					echo '								drag_block_vertical: ';
					echo ($drag_block_vertical == 'true') ? 'true' : 'false';
					echo "\n";
					echo '							}'."\n";
				}
				
				if($enable_arrows == 'on'){
					$navigation_arrow_style = $this->slider->getParam('navigation_arrow_style','round');
					$arrows_always_on = ($this->slider->getParam('arrows_always_on','true') == 'true') ? 'true' : 'false';
					$hide_arrows_on_mobile = ($this->slider->getParam('hide_arrows_on_mobile','off') == 'on') ? 'true' : 'false';
					$hide_arrows_over = ($this->slider->getParam('hide_arrows_over','off') == 'on') ? 'true' : 'false';
					$arr_tmp = '';
					
					$ff = false;
					if(!empty($all_navs)){
						foreach($all_navs as $cur_nav){
							if($cur_nav['handle'] == $navigation_arrow_style){
								if(isset($cur_nav['markup']['arrows'])) $arr_tmp = $cur_nav['markup']['arrows'];
								if(isset($cur_nav['css']['arrows'])) $nav_css .= $rs_nav->add_placeholder_modifications($cur_nav['css']['arrows'], $cur_nav['handle'], 'arrows', $cur_nav['settings'], $this->slider, $this)."\n";
								$ff = true;
								break;
							}
						}
					}
					if($ff == false){
						$navigation_arrow_style = '';
					}
					
					$navigation_arrow_style = $rs_nav->translate_navigation($navigation_arrow_style);
					if($add_comma) echo '							,'."\n";
					$add_comma = true;
					echo '							arrows: {'."\n";
					echo '								style:"'. esc_attr($navigation_arrow_style).'",'."\n";
					echo '								enable:';
					echo ($this->slider->getParam('enable_arrows','off') == 'on') ? 'true' : 'false'; 
					echo ','."\n";
					echo ($this->slider->getParam('rtl_arrows','off') == 'on') ? '								rtl:true,'."\n" : '';
					echo '								hide_onmobile:'.$hide_arrows_on_mobile.','."\n";	
					
					if($hide_arrows_on_mobile === 'true') {
						echo '								hide_under:'. esc_attr($this->slider->getParam('arrows_under_hidden','0',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					if($hide_arrows_over === 'true') {
						echo '								hide_over:'. esc_attr($this->slider->getParam('arrows_over_hidden','0',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					echo '								hide_onleave:'.$arrows_always_on.','."\n";
					if($arrows_always_on === 'true'){
						echo '								hide_delay:'. esc_attr($this->slider->getParam('hide_arrows','200',RevSlider::FORCE_NUMERIC)).','."\n";
						echo '								hide_delay_mobile:'. esc_attr($this->slider->getParam('hide_arrows_mobile','1200',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					echo '								tmp:\'';
					echo preg_replace( "/\r|\n/", "", $arr_tmp);
					echo '\','."\n";
					echo '								left: {'."\n";
					echo (in_array($this->slider->getParam('leftarrow_position', 'slider'),array('layergrid','grid'))) ? '									container:"layergrid",'."\n" : '';
					echo '									h_align:"'. esc_attr($this->slider->getParam('leftarrow_align_hor','left')) .'",'."\n";
					echo '									v_align:"'. esc_attr($this->slider->getParam('leftarrow_align_vert','center')) .'",'."\n";
					echo '									h_offset:'. esc_attr($this->slider->getParam('leftarrow_offset_hor','20',RevSlider::FORCE_NUMERIC)) .','."\n";
					echo '									v_offset:'. esc_attr($this->slider->getParam('leftarrow_offset_vert','0',RevSlider::FORCE_NUMERIC))."\n";										
					echo '								},'."\n";
					echo '								right: {'."\n";
					echo (in_array($this->slider->getParam('rightarrow_position', 'slider'),array('layergrid','grid'))) ? '									container:"layergrid",'."\n" : '';
					echo '									h_align:"'. esc_attr($this->slider->getParam('rightarrow_align_hor','right')).'",'."\n";
					echo '									v_align:"'. esc_attr($this->slider->getParam('rightarrow_align_vert','center')).'",'."\n";
					echo '									h_offset:'. esc_attr($this->slider->getParam('rightarrow_offset_hor','20',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '									v_offset:'. esc_attr($this->slider->getParam('rightarrow_offset_vert','0',RevSlider::FORCE_NUMERIC))."\n";					
					echo '								}'."\n";
					echo '							}'."\n";
				}
				
				if($enable_bullets == 'on'){
					$navigation_bullets_style = $this->slider->getParam('navigation_bullets_style','round');
					$bullets_always_on = ($this->slider->getParam('bullets_always_on','true') == 'true') ? 'true' : 'false';
					$hide_bullets_on_mobile = ($this->slider->getParam('hide_bullets_on_mobile','off') == 'on') ? 'true' : 'false';
					$hide_bullets_over = ($this->slider->getParam('hide_bullets_over','off') == 'on') ? 'true' : 'false';
					$bul_tmp = '<span class="tp-bullet-image"></span><span class="tp-bullet-title"></span>';

					if(!empty($all_navs)){
						foreach($all_navs as $cur_nav){
							if($cur_nav['handle'] == $navigation_bullets_style){
								if(isset($cur_nav['markup']['bullets'])) $bul_tmp = $cur_nav['markup']['bullets'];
								if(isset($cur_nav['css']['bullets'])) $nav_css .= $rs_nav->add_placeholder_modifications($cur_nav['css']['bullets'], $cur_nav['handle'], 'bullets', $cur_nav['settings'], $this->slider, $this)."\n";
								break;
							}
						}
					}
					
					$navigation_bullets_style = $rs_nav->translate_navigation($navigation_bullets_style);
					
					if($add_comma) echo '							,'."\n";
					$add_comma = true;
					echo '							bullets: {'."\n";
					echo '								enable:';
					echo ($this->slider->getParam('enable_bullets','off') == 'on') ? 'true' : 'false';
					echo ','."\n";
					echo ($this->slider->getParam('rtl_bullets','off') == 'on') ? '								rtl:true,'."\n" : '';
					echo '								hide_onmobile:'.$hide_bullets_on_mobile.','."\n";
					if($hide_bullets_on_mobile === 'true'){
						echo '								hide_under:'. esc_attr($this->slider->getParam('bullets_under_hidden','0',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					if($hide_bullets_over === 'true'){
						echo '								hide_over:'. esc_attr($this->slider->getParam('bullets_over_hidden','0',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					echo '								style:"'. esc_attr($navigation_bullets_style).'",'."\n";
					echo '								hide_onleave:'.$bullets_always_on.','."\n";
					if($bullets_always_on === 'true'){
						echo '								hide_delay:'. esc_attr($this->slider->getParam('hide_bullets','200',RevSlider::FORCE_NUMERIC)).','."\n";
						echo '								hide_delay_mobile:'. esc_attr($this->slider->getParam('hide_bullets_mobile','1200',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					echo '								direction:"'. esc_attr($this->slider->getParam('bullets_direction','horizontal')).'",'."\n";
					echo (in_array($this->slider->getParam('bullets_position', 'slider'),array('layergrid','grid'))) ? '									container:"layergrid",'."\n" : '';
					echo '								h_align:"'. esc_attr($this->slider->getParam('bullets_align_hor','right')).'",'."\n";
					echo '								v_align:"'. esc_attr($this->slider->getParam('bullets_align_vert','center')).'",'."\n";
					echo '								h_offset:'. esc_attr($this->slider->getParam('bullets_offset_hor','20',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								v_offset:'. esc_attr($this->slider->getParam('bullets_offset_vert','0',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								space:'. esc_attr($this->slider->getParam('bullets_space','5',RevSlider::FORCE_NUMERIC)).','."\n";					
					echo '								tmp:\'';
					echo preg_replace( "/\r|\n/", "", $bul_tmp);
					echo '\''."\n";
					echo '							}'."\n";
				}
				if($enable_thumbnails == 'on'){
					$thumbnails_style = $this->slider->getParam('thumbnails_style','round');
					$thumbs_always_on = ($this->slider->getParam('thumbs_always_on','true') == 'true') ? 'true' : 'false';
					$hide_thumbs_on_mobile = ($this->slider->getParam('hide_thumbs_on_mobile','off') == 'on') ? 'true' : 'false';
					$hide_thumbs_over = ($this->slider->getParam('hide_thumbs_over','off') == 'on') ? 'true' : 'false';
					$thumbs_tmp = '<span class="tp-thumb-image"></span><span class="tp-thumb-title"></span>';
					
					if(!empty($all_navs)){
						foreach($all_navs as $cur_nav){
							if($cur_nav['handle'] == $thumbnails_style){
								if(isset($cur_nav['markup']['thumbs'])) $thumbs_tmp = $cur_nav['markup']['thumbs'];
								if(isset($cur_nav['css']['thumbs'])) $nav_css .= $rs_nav->add_placeholder_modifications($cur_nav['css']['thumbs'], $cur_nav['handle'], 'thumbs', $cur_nav['settings'], $this->slider, $this)."\n";
								break;
							}
						}
					}
					
					$thumbnails_style = $rs_nav->translate_navigation($thumbnails_style);
					
					if($add_comma) echo '							,'."\n";
					$add_comma = true;
					echo '							thumbnails: {'."\n";
					echo '								style:"'. esc_attr($thumbnails_style).'",'."\n";
					echo '								enable:';
					echo ($this->slider->getParam('enable_thumbnails','off') == 'on') ? 'true' : 'false';
					echo ','."\n";
					echo ($this->slider->getParam('rtl_thumbnails','off') == 'on') ? '								rtl:true,'."\n" : '';
					echo '								width:'. esc_attr($this->slider->getParam('thumb_width','100',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								height:'. esc_attr($this->slider->getParam('thumb_height','50',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								min_width:'. esc_attr($this->slider->getParam('thumb_width_min','100',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								wrapper_padding:'. esc_attr($this->slider->getParam('thumbnails_padding','5',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								wrapper_color:"'. esc_attr($this->slider->getParam('thumbnails_wrapper_color','transparent')).'",'."\n";
					echo '								wrapper_opacity:"'. esc_attr(round($this->slider->getParam('thumbnails_wrapper_opacity','100') / 100, 2)).'",'."\n";
					echo '								tmp:\'';
					echo preg_replace( "/\r|\n/", "", $thumbs_tmp);
					echo '\','."\n";
					echo '								visibleAmount:'. esc_attr($this->slider->getParam('thumb_amount','5',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								hide_onmobile:'.$hide_thumbs_on_mobile.','."\n";
					if($hide_thumbs_on_mobile === 'true'){
						echo '								hide_under:'. esc_attr($this->slider->getParam('thumbs_under_hidden','0',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					if($hide_thumbs_over === 'true'){
						echo '								hide_over:'. esc_attr($this->slider->getParam('thumbs_over_hidden','0',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					echo '								hide_onleave:'.$thumbs_always_on.','."\n";
					if($thumbs_always_on === 'true'){
						echo '								hide_delay:'. esc_attr($this->slider->getParam('hide_thumbs','200',RevSlider::FORCE_NUMERIC)).','."\n";
						echo '								hide_delay_mobile:'. esc_attr($this->slider->getParam('hide_thumbs_mobile','1200',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					echo '								direction:"'. esc_attr($this->slider->getParam('thumbnail_direction','horizontal')).'",'."\n";
					echo '								span:';
					echo ($this->slider->getParam('span_thumbnails_wrapper','off') == 'on') ? 'true' : 'false';
					echo ','."\n";
					echo '								position:"'. esc_attr($this->slider->getParam('thumbnails_inner_outer','inner')).'",'."\n";
					if($this->slider->getParam('thumbnails_inner_outer','inner') == 'inner'){
						echo (in_array($this->slider->getParam('thumbnails_position', 'slider'),array('layergrid','grid'))) ? '									container:"layergrid",'."\n" : '';					
					}
					echo '								space:'. esc_attr($this->slider->getParam('thumbnails_space','5',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								h_align:"'. esc_attr($this->slider->getParam('thumbnails_align_hor','left')).'",'."\n";
					echo '								v_align:"'. esc_attr($this->slider->getParam('thumbnails_align_vert','center')).'",'."\n";
					echo '								h_offset:'. esc_attr($this->slider->getParam('thumbnails_offset_hor','20',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								v_offset:'. esc_attr($this->slider->getParam('thumbnails_offset_vert','0',RevSlider::FORCE_NUMERIC))."\n";					
					echo '							}'."\n";
				}
				if($enable_tabs == 'on'){
					$tabs_style = $this->slider->getParam('tabs_style','round');
					$tabs_always_on = ($this->slider->getParam('tabs_always_on','true') == 'true') ? 'true' : 'false';
					$hide_tabs_on_mobile = ($this->slider->getParam('hide_tabs_on_mobile','off') == 'on') ? 'true' : 'false';
					$hide_tabs_over = ($this->slider->getParam('hide_tabs_over','off') == 'on') ? 'true' : 'false';
					$tabs_tmp = '<span class="tp-thumb-image"></span>';
					
					if(!empty($all_navs)){
						foreach($all_navs as $cur_nav){
							if($cur_nav['handle'] == $tabs_style){
								if(isset($cur_nav['markup']['tabs'])) $tabs_tmp = $cur_nav['markup']['tabs'];
								if(isset($cur_nav['css']['tabs'])) $nav_css .= $rs_nav->add_placeholder_modifications($cur_nav['css']['tabs'], $cur_nav['handle'], 'tabs', $cur_nav['settings'], $this->slider, $this)."\n";
								break;
							}
						}
					}
					
					$tabs_style = $rs_nav->translate_navigation($tabs_style);
					
					if($add_comma) echo '							,'."\n";
					$add_comma = true;
					echo '							tabs: {'."\n";
					echo '								style:"'. esc_attr($tabs_style).'",'."\n";
					echo '								enable:';
					echo ($this->slider->getParam('enable_tabs','off') == 'on') ? 'true' : 'false';
					echo ','."\n";
					echo ($this->slider->getParam('rtl_tabs','off') == 'on') ? '								rtl:true,'."\n" : '';
					echo '								width:'. esc_attr($this->slider->getParam('tabs_width','100',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								height:'. esc_attr($this->slider->getParam('tabs_height','50',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								min_width:'. esc_attr($this->slider->getParam('tabs_width_min','100',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								wrapper_padding:'. esc_attr($this->slider->getParam('tabs_padding','5',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								wrapper_color:"'. esc_attr($this->slider->getParam('tabs_wrapper_color','transparent')).'",'."\n";
					echo '								wrapper_opacity:"'. esc_attr(round($this->slider->getParam('tabs_wrapper_opacity','100') / 100, 2)).'",'."\n";
					echo '								tmp:\'';
					echo preg_replace( "/\r|\n/", "", $tabs_tmp);
					echo '\','."\n";
					echo '								visibleAmount: '. esc_attr($this->slider->getParam('tabs_amount','5',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								hide_onmobile: '.$hide_tabs_on_mobile.','."\n";
					if($hide_tabs_on_mobile === 'true'){
						echo '								hide_under:'. esc_attr($this->slider->getParam('tabs_under_hidden','0',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					if($hide_tabs_over === 'true'){
						echo '								hide_over:'. esc_attr($this->slider->getParam('tabs_over_hidden','0',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					echo '								hide_onleave:'.$tabs_always_on.','."\n";
					if($tabs_always_on === 'true'){
						echo '								hide_delay:'. esc_attr($this->slider->getParam('hide_tabs','200',RevSlider::FORCE_NUMERIC)).','."\n";
						echo '								hide_delay_mobile:'. esc_attr($this->slider->getParam('hide_tabs_mobile','1200',RevSlider::FORCE_NUMERIC)).','."\n";
					}
					echo '								hide_delay:'. esc_attr($this->slider->getParam('hide_tabs','200',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								direction:"'. esc_attr($this->slider->getParam('tabs_direction','horizontal')).'",'."\n";
					echo '								span:';
					echo ($this->slider->getParam('span_tabs_wrapper','off') == 'on') ? 'true' : 'false';
					echo ','."\n";
					echo '								position:"'. esc_attr($this->slider->getParam('tabs_inner_outer','inner')).'",'."\n";
					if($this->slider->getParam('tabs_inner_outer','inner') == 'inner'){
						echo (in_array($this->slider->getParam('tabs_position', 'slider'),array('layergrid','grid'))) ? '									container:"layergrid",'."\n" : '';					
					}
					echo '								space:'. esc_attr($this->slider->getParam('tabs_space','5',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								h_align:"'. esc_attr($this->slider->getParam('tabs_align_hor','left')).'",'."\n";
					echo '								v_align:"'. esc_attr($this->slider->getParam('tabs_align_vert','center')).'",'."\n";
					echo '								h_offset:'. esc_attr($this->slider->getParam('tabs_offset_hor','20',RevSlider::FORCE_NUMERIC)).','."\n";
					echo '								v_offset:'. esc_attr($this->slider->getParam('tabs_offset_vert','0',RevSlider::FORCE_NUMERIC))."\n";											
					echo '							}'."\n";
				}
				echo '						},'."\n";
			}else{ //maybe write navigation stuff still here
				echo '						navigation: {'."\n";
				if($slider_type !== 'hero'){
					echo '							onHoverStop:"'. esc_attr($this->slider->getParam("stop_on_hover","on")).'",'."\n";
				}
				echo '						},'."\n";
			}
			
			if($slider_type == 'carousel'){
				$car_inf = $this->slider->getParam('carousel_infinity','off');
				$car_space = $this->slider->getParam('carousel_space',0,RevSlider::FORCE_NUMERIC);
				$car_stretch = $this->slider->getParam('carousel_stretch','off');
				$car_maxitems = $this->slider->getParam('carousel_maxitems',5,RevSlider::FORCE_NUMERIC);
				$car_fadeout = $this->slider->getParam('carousel_fadeout','on');
				$car_varyfade = $this->slider->getParam('carousel_varyfade','off');
				
				$car_hpos = $this->slider->getParam('carousel_hposition','center');
				$car_vpos = $this->slider->getParam('carousel_vposition','center');
				
				$carousel_rotation = $this->slider->getParam('carousel_rotation','off');
				$car_maxrotation = $this->slider->getParam('carousel_maxrotation',90,RevSlider::FORCE_NUMERIC);
				$car_varyrotate = $this->slider->getParam('carousel_varyrotate','off');
				
				$carousel_scale = $this->slider->getParam('carousel_scale','off');
				$car_varyscale = $this->slider->getParam('carousel_varyscale','off');
				$car_scaledown = $this->slider->getParam('carousel_scaledown',50,RevSlider::FORCE_NUMERIC);
				if($car_scaledown > 100) $car_scaledown = 100;
				
				$car_borderr = $this->slider->getParam('carousel_borderr',0,RevSlider::FORCE_NUMERIC);
				$car_borderr_unit = $this->slider->getParam('carousel_borderr_unit','px');
				
				$car_padding_top = $this->slider->getParam('carousel_padding_top',0,RevSlider::FORCE_NUMERIC);
				$car_padding_bottom = $this->slider->getParam('carousel_padding_bottom',0,RevSlider::FORCE_NUMERIC);
				
				echo '						carousel: {'."\n";
				if($car_borderr > 0){
					echo '							border_radius: "'. esc_attr($car_borderr.$car_borderr_unit) .'",'."\n";
				}
				if($car_padding_top > 0){
					echo '							padding_top: "'. esc_attr($car_padding_top) .'",'."\n";
				}
				if($car_padding_bottom > 0){
					echo '							padding_bottom: "'. esc_attr($car_padding_bottom) .'",'."\n";
				}
				if($carousel_rotation == 'on'){
					echo '							maxRotation: '. esc_attr($car_maxrotation).','."\n";
					echo '							vary_rotation: "'. esc_attr($car_varyrotate).'",'."\n";
				}
				if($carousel_scale == 'on'){
					echo '							minScale: '. esc_attr($car_scaledown).','."\n";
					echo '							vary_scale: "'. esc_attr($car_varyscale).'",'."\n";
				}
				echo '							horizontal_align: "'. esc_attr($car_hpos).'",'."\n";
				echo '							vertical_align: "'. esc_attr($car_vpos).'",'."\n";
				echo '							fadeout: "'. esc_attr($car_fadeout).'",'."\n";
				if($car_fadeout == 'on'){
					echo '							vary_fade: "'. esc_attr($car_varyfade).'",'."\n";
				}
				echo '							maxVisibleItems: '. esc_attr($car_maxitems).','."\n";
				echo '							infinity: "'. esc_attr($car_inf).'",'."\n";
				echo '							space: '. esc_attr($car_space).','."\n";
				echo '							stretch: "'. esc_attr($car_stretch).'"'."\n";
				echo '						},'."\n";
			}
			
			$label_viewport = $this->slider->getParam('label_viewport', 'off');
			$label_presetheight = $this->slider->getParam('label_presetheight', 'off');
			$viewport_start = $this->slider->getParam('viewport_start', 'wait');
			$viewport_area = $this->slider->getParam('viewport_area', 80, RevSlider::FORCE_NUMERIC);
			if($label_viewport === 'on'){
				echo '						viewPort: {'."\n";
				echo '							enable:true,'."\n";
				echo '							outof:"'.esc_attr($viewport_start).'",'."\n";
				echo '							visible_area:"'.esc_attr($viewport_area).'%",'."\n";
				echo '							presize:';
				echo ($label_presetheight == 'off') ? 'false' : 'true';
				echo "\n";
				echo '						},'."\n";
			}
			
			if(isset($csizes['level']) && !empty($csizes['level'])){
				echo '						responsiveLevels:['. $csizes['level'] .'],'."\n";
				echo '						visibilityLevels:['. $csizes['level'] .'],'."\n";
				echo '						gridwidth:['. $csizes['width'] .'],'."\n";
				echo '						gridheight:['. $csizes['height'] .'],'."\n";
			}else{
				echo '						visibilityLevels:['. $csizes['visibilitylevel'] .'],'."\n";
				echo '						gridwidth:'. $csizes['width'].','."\n";
				echo '						gridheight:'. $csizes['height'].','."\n";
			}
			
			$lazyLoad = $this->slider->getParam('lazy_load_type', false);
			if($lazyLoad === false){ //do fallback checks to removed lazy_load value since version 5.0 and replaced with an enhanced version
				$old_ll = $this->slider->getParam('lazy_load', 'off');
				$lazyLoad = ($old_ll == 'on') ? 'all' : 'none';
			}
			echo '						lazyType:"'. esc_attr($lazyLoad).'",'."\n";
			
			$minHeight = ($this->slider->getParam('slider_type') !== 'fullscreen') ? $this->slider->getParam('min_height', '0') : $this->slider->getParam('fullscreen_min_height', '0');
			if($minHeight > 0){
				echo '						minHeight:"'. $minHeight.'",'."\n";
			}
			
			if($use_parallax == 'on'){
				echo '						parallax: {'."\n";
				echo '							type:"'. esc_attr($parallax_type) .'",'."\n";
				echo '							origo:"'. esc_attr($parallax_origo) .'",'."\n";
				echo '							speed:'. esc_attr($parallax_speed) .','."\n";
				echo '							levels:['. esc_attr($parallax_level) .'],'."\n";
				echo '							type:"'. esc_attr($parallax_type) .'",'."\n";
				if ($parallax_type == '3D') {
					echo '							ddd_shadow:"'. esc_attr($parallax_ddd_shadow) .'",'."\n";
					echo '							ddd_bgfreeze:"'. esc_attr($parallax_ddd_bgfreeze) .'",'."\n";
					echo '							ddd_overflow:"'. esc_attr($parallax_ddd_overflow) .'",'."\n";
					echo '							ddd_layer_overflow:"'. esc_attr($parallax_ddd_layer_overflow) .'",'."\n";
					echo '							ddd_z_correction:'. esc_attr($parallax_ddd_zcorrection) .','."\n";
					//echo '							ddd_path:"'. esc_attr($parallax_ddd_path) .'",'."\n";
				}				

				if($disable_parallax_mobile == 'on'){
					echo '							disable_onmobile:"on"'."\n";
				}
				echo '						},'."\n";
			}
			
			if ($use_parallax != 'on' || ($use_parallax == 'on' && $parallax_type !='3D'))
				echo '						shadow:'. esc_attr($this->slider->getParam("shadow_type","2")) .','."\n";
			
			if($use_spinner == '-1'){
				echo '						spinner:"off",'."\n";
			}else{
				echo '						spinner:"spinner'. esc_attr($use_spinner).'",'."\n";
			}
			
			if($slider_type !== 'hero'){
				echo '						stopLoop:"'. esc_attr($stopSlider) .'",'."\n";
				echo '						stopAfterLoops:'. esc_attr($stopAfterLoops) .','."\n";
				echo '						stopAtSlide:'. esc_attr($stopAtSlide) .','."\n";
				echo '						shuffle:"'. esc_attr($this->slider->getParam("shuffle","off")) .'",'."\n";
			}

			echo '						autoHeight:"'. esc_attr($this->slider->getParam("auto_height", 'off')). '",'."\n";
			
			if($this->slider->getParam("slider_type") == "fullscreen"){				
				echo '						fullScreenAutoWidth:"'. esc_attr($this->slider->getParam("autowidth_force","off")) .'",'."\n";
				echo '						fullScreenAlignForce:"'. esc_attr($this->slider->getParam("full_screen_align_force","off")) .'",'."\n";
				echo '						fullScreenOffsetContainer: "'. esc_attr($this->slider->getParam("fullscreen_offset_container","")) .'",'."\n";
				echo '						fullScreenOffset: "'. esc_attr($this->slider->getParam("fullscreen_offset_size","")) .'",'."\n";
			}
			if($enable_progressbar !== 'on' || $slider_type == 'hero'){
				echo '						disableProgressBar:"on",'."\n";
			}
			echo '						hideThumbsOnMobile:"'. esc_attr($hideThumbsOnMobile) .'",'."\n";
			echo '						hideSliderAtLimit:'. esc_attr($hideSliderAtLimit) .','."\n";
			echo '						hideCaptionAtLimit:'. esc_attr($hideCaptionAtLimit) .','."\n";
			echo '						hideAllCaptionAtLilmit:'. esc_attr($hideAllCaptionAtLimit) .','."\n";
			
			if($slider_type !== 'hero'){
				$start_with_slide_enable = $this->slider->getParam('start_with_slide_enable', 'off');
				if($start_with_slide_enable == 'on'){
					echo '						startWithSlide:'. esc_attr($startWithSlide).','."\n";
				}
			}
			
			echo '						debugMode:'.$debugmode.','."\n";
			if($this->slider->getParam('waitforinit', 'off') == 'on'){
				echo '						waitForInit:true,'."\n";
			}
			echo '						fallbacks: {'."\n";
			
			if($this->slider->getParam('ignore_height_changes', 'off') !== 'off'){
				echo '							ignoreHeightChanges:"'. esc_attr($this->slider->getParam('ignore_height_changes', 'off')).'",'."\n";
				echo '							ignoreHeightChangesSize:'. intval(esc_attr($this->slider->getParam('ignore_height_changes_px', '0'))).','."\n";
			}
			
			echo '							simplifyAll:"'. esc_attr($this->slider->getParam('simplify_ie8_ios4', 'off')).'",'."\n";
			
			if($slider_type !== 'hero')
				echo '							nextSlideOnWindowFocus:"'. esc_attr($this->slider->getParam('next_slide_on_window_focus', 'off')).'",'."\n";
			
			$dfl = ($this->slider->getParam('disable_focus_listener', 'off') == 'on') ? 'true' : 'false';
			echo '							disableFocusListener:'.$dfl.','."\n";
			
			if($disableKenBurnOnMobile == 'on'){
				echo '						panZoomDisableOnMobile:"on",'."\n";
			}
			echo '						}'."\n";
			
			echo '					});'."\n";

			if($this->slider->getParam("custom_javascript", '') !== ''){
				echo str_replace('var counter = {val:doctop};', 'var counter = {val:(window.pageYOffset || document.documentElement.scrollTop)  - (document.documentElement.clientTop || 0)};', stripslashes($this->slider->getParam("custom_javascript", '')));
			}
			echo '				}'."\n";
			
			do_action('revslider_fe_javascript_output', $this->slider, $this->sliderHtmlID);
			
			echo '			});	/*ready*/'."\n";
			?>
		</script>
		<?php
		if($js_to_footer && $this->previewMode == false && $markup_export == false){
			$js_content = ob_get_contents();
			ob_clean();
			ob_end_clean();

			$this->rev_inline_js = $js_content;

			add_action('wp_print_footer_scripts', array($this, 'add_inline_js'), 100);
		}
		
		if($markup_export === true){
			echo '<!-- /SCRIPT -->';
		}
		
		switch($use_spinner){
			case '1':
			case '2':
				if(!is_admin()){?><script>
					var htmlDivCss = ' #<?php echo $this->sliderHtmlID_wrapper;?> .tp-loader.spinner<?php echo $use_spinner;?>{ background-color: <?php echo $spinner_color;?> !important; } ';
					var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
					if(htmlDiv) {
						htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
					}
					else{
						var htmlDiv = document.createElement('div');
						htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
						document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
					}
					</script>
					<?php 
				}else{
					if($markup_export === true){
						echo '<!-- STYLE -->';
					}
					echo '<style type="text/css">	#'.$this->sliderHtmlID_wrapper.' .tp-loader.spinner'.$use_spinner.'{ background-color: '.$spinner_color.' !important; } </style>';
					if($markup_export === true){
						echo '<!-- /STYLE -->';
					}
				}
			break;
			case '3':
			case '4':
				if(!is_admin()){?><script>
					var htmlDivCss = '	#<?php echo $this->sliderHtmlID_wrapper;?> .tp-loader.spinner<?php echo $use_spinner;?> div { background-color: <?php echo $spinner_color;?> !important; } ';
					var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
					if(htmlDiv) {
						htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
					}
					else{
						var htmlDiv = document.createElement('div');
						htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
						document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
					}
					</script>
					<?php
				}else{
					if($markup_export === true){
						echo '<!-- STYLE -->';
					}
					echo '<style type="text/css">	#'.$this->sliderHtmlID_wrapper.' .tp-loader.spinner'.$use_spinner.'{ background-color: '.$spinner_color.' !important; } </style>';
					if($markup_export === true){
						echo '<!-- /STYLE -->';
					}
				}
			break;
			case '0':
			case '5':
			default:
			break;

		}

		if($this->slider->getParam("custom_css", '') !== ''){
			if(!is_admin()){
				?><script>
					var htmlDivCss = unescape("<?php echo RevSliderCssParser::compress_css(rawurlencode(stripslashes($this->slider->getParam('custom_css', ''))));?>");
					var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
					if(htmlDiv) {
						htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
					}
					else{
						var htmlDiv = document.createElement('div');
						htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
						document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
					}
				  </script><?php
			}else{
				if($markup_export === true){
					echo '<!-- STYLE -->';
				}
				?><style type="text/css"><?php echo RevSliderCssParser::compress_css(stripslashes($this->slider->getParam('custom_css', '')));?></style><?php	
				if($markup_export === true){
					echo '<!-- /STYLE -->';
				}
			}
		}
		
		
		//add custom Slide CSS here
		
		if(trim($nav_css) !== ''){
			if(!is_admin()){
				?><script>
					var htmlDivCss = unescape("<?php echo RevSliderCssParser::compress_css(rawurlencode($nav_css));?>");
					var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
					if(htmlDiv) {
						htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
					}
					else{
						var htmlDiv = document.createElement('div');
						htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
						document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
					}
				  </script>
				<?php
			}else{
				if($markup_export === true){
					echo '<!-- STYLE -->';
				}
				?>
				<style type="text/css"><?php echo RevSliderCssParser::compress_css(($nav_css));?></style>
				<?php
				if($markup_export === true){
					echo '<!-- /STYLE -->';
				}
			}
		}
		
		if(!$markup_export){ //not needed for html markup export
			if(has_action('wp_footer', array($this, 'add_inline_double_jquery_error')) === false){
				
				add_action('wp_footer', array($this, 'add_inline_double_jquery_error'));
				
				/*if(isset($_GET['pk'])){
					echo '<pre>';
					//global $wp_filter;
					//print_r($wp_filter['wp_footer']);
					var_dump(_wp_filter_build_unique_id('wp_footer', array($this, 'add_inline_double_jquery_error'), false));
					var_dump(has_action('wp_footer', array($this, 'add_inline_double_jquery_error')));
					var_dump((has_action('wp_footer', array($this, 'add_inline_double_jquery_error')) === false));
					echo '</pre>';
				}*/
			}
		}
	}

	/**
	 * Output Inline JS
	 */
	public function add_inline_js(){

		echo $this->rev_inline_js;

	}
	
	/**
	 * Output revslider_showDoubleJqueryError
	 */
	public function add_inline_double_jquery_error(){
		?>
		<script type="text/javascript">
			function revslider_showDoubleJqueryError(sliderID) {
				var errorMessage = "Revolution Slider Error: You have some jquery.js library include that comes after the revolution files js include.";
				errorMessage += "<br> This includes make eliminates the revolution slider libraries, and make it not work.";
				errorMessage += "<br><br> To fix it you can:<br>&nbsp;&nbsp;&nbsp; 1. In the Slider Settings -> Troubleshooting set option:  <strong><b>Put JS Includes To Body</b></strong> option to true.";
				errorMessage += "<br>&nbsp;&nbsp;&nbsp; 2. Find the double jquery.js include and remove it.";
				errorMessage = "<span style='font-size:16px;color:#BC0C06;'>" + errorMessage + "</span>";
					jQuery(sliderID).show().html(errorMessage);
			}
		</script>
		<?php
	}


	/**
	 * Output Dynamic Inline Styles
	 */
	public function add_inline_styles(){
	
		if(!is_admin()){
			echo '<script>var htmlDiv = document.getElementById("rs-plugin-settings-inline-css"); var htmlDivCss="';
		} 
		else echo "<style>";

		$db = new RevSliderDB();

		$styles = $db->fetch(RevSliderGlobals::$table_css);
		foreach($styles as $key => $style){
			$handle = str_replace('.tp-caption', '', $style['handle']);
			if(!isset($this->class_include[$handle])) unset($styles[$key]);
		}
		
		$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
		$styles = RevSliderCssParser::compress_css($styles);
		
		if(!is_admin()){
			echo addslashes($styles).'";
				if(htmlDiv) {
					htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
				}else{
					var htmlDiv = document.createElement("div");
					htmlDiv.innerHTML = "<style>" + htmlDivCss + "</style>";
					document.getElementsByTagName("head")[0].appendChild(htmlDiv.childNodes[0]);
				}
			</script>'."\n";
		} 
		else echo $styles.'</style>';

	}

	
	/**
	 * put inline error message in a box.
	 */
	public function putErrorMessage($message){
		?>
		<div style="width:800px;height:300px;margin-bottom:10px;margin:0px auto;">
			<div style="margin: auto; line-height: 40px; font-size: 14px; color: #FFF; padding: 15px; background: #E74C3C; margin: 20px 0px;">
				<?php _e("Revolution Slider Error",'revslider'); ?>: <?php echo $message; ?>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(".rev_slider").show();
			});
		</script>
		<?php
	}


	/**
	 *
	 * modify slider settings for preview mode
	 */
	private function modifyPreviewModeSettings(){
		$params = $this->slider->getParams();
		$params["js_to_body"] = "false";

		$this->slider->setParams($params);
	}
	
	
	/**
	 * modify slider settings through the shortcode directly
	 */
	private function modify_settings($settings){
		$params = $this->slider->getParams();
		
		foreach($settings as $name => $setting){
			$params[$name] = $setting;
		}
		
		$this->slider->setParams($params);
	}


	/**
	 *
	 * put html slider on the html page.
	 * @param $data - mixed, can be ID ot Alias.
	 */
	public function putSliderBase($sliderID, $gal_ids = array(), $markup_export = false, $settings = array(), $order = array()){
		
		$this->markup_export = $markup_export;
		
		try{
			$slver = apply_filters('revslider_remove_version', RevSliderGlobals::SLIDER_REVISION);
			
			self::$sliderSerial++;
			
			$this->slider = new RevSlider();
			if($sliderID !== '-99'){
				$this->slider->initByMixed($sliderID);
			}else{ //do default
				$this->slider->initByMixed($sliderID);
			}
			
			//modify settings if there are any special settings given through the shortcode
			if(!empty($settings))
				$this->modify_settings($settings);
			
			//modify settings for admin preview mode
			if($this->previewMode == true)
				$this->modifyPreviewModeSettings();

			//set slider language
			$isWpmlExists = RevSliderWpml::isWpmlExists();
			$useWpml = $this->slider->getParam("use_wpml","off");
			if(	$isWpmlExists && $useWpml == "on"){
				if($this->previewMode == false)
					$this->sliderLang = RevSliderFunctionsWP::getCurrentLangCode();
			}

			//edit html before slider
			$htmlBeforeSlider = "";
			
			if($markup_export === true){
				$htmlBeforeSlider .= '<!-- FONT -->';
			}
			if($this->slider->getParam("load_googlefont","false") == "true"){
				$googleFont = $this->slider->getParam("google_font");
				if(is_array($googleFont)){
					foreach($googleFont as $key => $font){
						
					}
				}else{
					$htmlBeforeSlider .= RevSliderOperations::getCleanFontImport($googleFont);
				}
			}
			
			/*$gfonts = $this->slider->getParam("google_font",array());
			if(!empty($gfonts) && is_array($gfonts)){
				foreach($gfonts as $gf){
					$gf = str_replace(array('"', '+'), array('', ' '), $gf);
					$htmlBeforeSlider .= RevSliderOperations::getCleanFontImport($gf);
				}
			}*/
			
			//add all google fonts of layers
			$gfsubsets = $this->slider->getParam("subsets",array());
			$gf = $this->slider->getUsedFonts(false);
			
			foreach($gf as $gfk => $gfv){
				$variants = array();
				if(!empty($gfv['variants'])){
					foreach($gfv['variants'] as $mgvk => $mgvv){
						$variants[] = $mgvk;
					}
				}
				
				$subsets = array();
				if(!empty($gfv['subsets'])){
					foreach($gfv['subsets'] as $ssk => $ssv){
						if(array_search(esc_attr($gfk.'+'.$ssv), $gfsubsets) !== false){
							$subsets[] = $ssv;
						}
					}
				}
				$htmlBeforeSlider .= RevSliderOperations::getCleanFontImport($gfk, '', '', $variants, $subsets);
			}
			
			if($markup_export === true){
				$htmlBeforeSlider .= '<!-- /FONT -->';
			}

			//pub js to body handle
			if($this->slider->getParam("js_to_body","false") == "true"){
				$operations = new RevSliderOperations();
				$arrValues = $operations->getGeneralSettingsValues();
				$enable_logs = RevSliderFunctions::getVal($arrValues, "enable_logs",'off');
				
				if($markup_export === true){
					$htmlBeforeSlider .= '<!-- SCRIPTINCLUDE -->';
				}
				
				if($enable_logs == 'on'){
					$urlIncludeJS = RS_PLUGIN_URL.'public/assets/js/jquery.themepunch.enablelog.js?rev='. $slver;
					$htmlBeforeSlider .= '<script type="text/javascript" src="'.$urlIncludeJS.'"></script>';
				}

				$urlIncludeJS = RS_PLUGIN_URL.'public/assets/js/jquery.themepunch.tools.min.js?rev='. $slver;
				$htmlBeforeSlider .= '<script type="text/javascript" src="'.$urlIncludeJS.'"></script>';
				$urlIncludeJS = RS_PLUGIN_URL.'public/assets/js/jquery.themepunch.revolution.min.js?rev='. $slver;
				$htmlBeforeSlider .= '<script type="text/javascript" src="'.$urlIncludeJS.'"></script>';
				
				if($markup_export === true){
					$htmlBeforeSlider .= '<!-- /SCRIPTINCLUDE -->';
				}
			}

			//the initial id can be alias
			$sliderID = $this->slider->getID();

			$bannerWidth = $this->slider->getParam("width",null,RevSlider::VALIDATE_NUMERIC,"Slider Width");
			$bannerHeight = $this->slider->getParam("height",null,RevSlider::VALIDATE_NUMERIC,"Slider Height");

			$sliderType = $this->slider->getParam("slider_type");
			$slider_type = $this->slider->getParam("slider-type");

			//set wrapper height
			$wrapperHeigh = 0;
			$wrapperHeigh += $this->slider->getParam("height");

			//add thumb height
			if($this->slider->getParam('enable_thumbnails', 'off') == 'on'){
				$wrapperHeigh += $this->slider->getParam('thumb_height');
			}
			
			$slider_id = $this->slider->getParam('slider_id', '');
			
			if(trim($slider_id) !== ''){
				$this->sliderHtmlID = $slider_id;
			}else{
				$this->sliderHtmlID = 'rev_slider_'.$sliderID.'_'.self::$sliderSerial;
			}
			$this->sliderHtmlID_wrapper = $this->sliderHtmlID.'_wrapper';
			$containerStyle = "";

			$sliderPosition = $this->slider->getParam("position","center");
			
			$do_overflow = '';
			
			//set position:
			if($sliderType != "fullscreen"){

				switch($sliderPosition){
					case "center":
					default:
						$containerStyle .= "margin:0px auto;";
					break;
					case "left":
						$containerStyle .= "float:left;";
					break;
					case "right":
						$containerStyle .= "float:right;";
					break;
				}
				
				if($this->slider->getParam('main_overflow_hidden','on') == 'on'){
					$do_overflow = ' tp-overflow-hidden';
				}

			}

			//add background color
			$backgroundColor = esc_attr(trim($this->slider->getParam('background_color')));
			if(!empty($backgroundColor))
				$containerStyle .= 'background-color:'.$backgroundColor.';';

			//set padding
			$containerStyle .= 'padding:'.esc_attr($this->slider->getParam('padding','0')).'px;';

			//set margin:
			if($sliderType != 'fullscreen'){

				if($sliderPosition != 'center'){
					$containerStyle .= 'margin-left:'.esc_attr($this->slider->getParam('margin_left', '0', RevSlider::FORCE_NUMERIC)).'px;';
					$containerStyle .= 'margin-right:'.esc_attr($this->slider->getParam('margin_right', '0', RevSlider::FORCE_NUMERIC)).'px;';
				}

				$containerStyle .= 'margin-top:'.esc_attr($this->slider->getParam('margin_top', '0', RevSlider::FORCE_NUMERIC)).'px;';
				$containerStyle .= 'margin-bottom:'.esc_attr($this->slider->getParam('margin_bottom', '0', RevSlider::FORCE_NUMERIC)).'px;';
			}

			//set height and width:
			$bannerStyle = 'display:none;';

			//add background image (to banner style)
			$showBackgroundImage = $this->slider->getParam('show_background_image', 'off');

			if($showBackgroundImage == 'true' || $showBackgroundImage == 'on'){
				$backgroundImage = esc_attr($this->slider->getParam('background_image'));
				$backgroundFit = esc_attr($this->slider->getParam('bg_fit', $this->slider->getParam('def-background_fit', 'cover')));
				$backgroundRepeat = esc_attr($this->slider->getParam('bg_repeat', $this->slider->getParam('def-bg_repeat', 'no-repeat')));
				$backgroundPosition = esc_attr($this->slider->getParam('bg_position', $this->slider->getParam('def-bg_position', 'center center')));
				
				if(!empty($backgroundImage))
					$containerStyle .= "background-image:url(".$backgroundImage.");background-repeat:".$backgroundRepeat.";background-size:".$backgroundFit.";background-position:".$backgroundPosition.";";
			}

			//set wrapper and slider class:
			$sliderWrapperClass = "rev_slider_wrapper";
			$sliderClass = "rev_slider";

			switch($sliderType){
				case "responsitive": //@since 5.0: obsolete now, was custom
				case "fixed":        //@since 5.0: obsolete now
				case 'auto':
				case 'fullwidth':
					$sliderWrapperClass .= " fullwidthbanner-container";
					$sliderClass .= " fullwidthabanner";
					// KRISZTIAN REMOVED SOME LINE
					//$bannerStyle .= "max-height:".$bannerHeight."px;height:".$bannerHeight."px;";
					//$containerStyle .= "max-height:".$bannerHeight."px;";
				break;
				case 'fullscreen':
					$sliderWrapperClass .= " fullscreen-container";
					$sliderClass .= " fullscreenbanner";
				break;
				default:
					$bannerStyle .= "height:".$bannerHeight."px;width:".$bannerWidth."px;";
					$containerStyle .= "height:".$bannerHeight."px;width:".$bannerWidth."px;";
				break;
			}
			
			$maxWidth = $this->slider->getParam('max_width', '0', RevSlider::FORCE_NUMERIC);
			if($maxWidth > 0 && $this->slider->getParam('slider_type') == 'auto'){
				$containerStyle.='max-width:'. $maxWidth.'px;';
			}

			$htmlTimerBar = "";

			$enable_progressbar =  $this->slider->getParam('enable_progressbar','on');
			$timerBar =  $this->slider->getParam('show_timerbar','top');
			$progress_height =  $this->slider->getParam('progress_height','5');
			$progress_opa =  $this->slider->getParam('progress_opa','15');
			$progressbar_color =  $this->slider->getParam('progressbar_color','#000000');
			
			if($enable_progressbar !== 'on' || $slider_type == 'hero')
				$timerBar = 'hide';
			
			$progress_style = ' style="height: '.esc_attr($progress_height).'px; background-color: '.RevSliderFunctions::hex2rgba($progressbar_color, $progress_opa).';"';
			
			switch($timerBar){
				case "top":
					$htmlTimerBar = '<div class="tp-bannertimer"'.$progress_style.'></div>';
				break;
				case "bottom":
					$htmlTimerBar = '<div class="tp-bannertimer tp-bottom"'.$progress_style.'></div>';
				break;
				case "hide":
					$htmlTimerBar = '<div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>';
				break;
			}
			

			//check inner / outer border
			$paddingType = $this->slider->getParam("padding_type","outer");
			if($paddingType == "inner")
				$sliderWrapperClass .= " tp_inner_padding";

			global $revSliderVersion;

			$add_alias = '';
			if(is_super_admin() || is_admin_bar_showing()){
				if(current_user_can('edit_theme_options')){
					$add_alias = ' data-alias="'.esc_attr($this->slider->getAlias()).'"';
				}
			}
			
			$source_type = ' data-source="'.$this->slider->getParam("source_type").'"';

			echo $htmlBeforeSlider."\n";
			echo '<div id="'.$this->sliderHtmlID_wrapper.'" class="'. $sliderWrapperClass .'"'.$add_alias.$source_type;
			
			$show_alternate = $this->slider->getParam("show_alternative_type","off");
			if($show_alternate !== 'off'){
				$show_alternate_image = $this->slider->getParam("show_alternate_image","");
				echo ' data-aimg="'.$show_alternate_image.'" ';
				if($show_alternate == 'mobile' || $show_alternate == 'mobile-ie8'){
					echo ' data-amobile="enabled" ';
				}else{
					echo ' data-amobile="disabled" ';
				}
				if($show_alternate == 'mobile-ie8' || $show_alternate == 'ie8'){
					echo ' data-aie8="enabled" ';
				}else{
					echo ' data-aie8="disabled" ';
				}
				
			}
			
			echo ' style="'. $containerStyle .'">'."\n";

			echo '<!-- START REVOLUTION SLIDER '. $revSliderVersion .' '. $sliderType .' mode -->'."\n";

			echo '	<div id="'. $this->sliderHtmlID .'"';
			echo ' class="'. $sliderClass . $do_overflow .'"';
			echo ' style="'. $bannerStyle .'"';
			echo ' data-version="'.$revSliderVersion.'">'."\n";

			echo $this->putSlides($gal_ids, $order);
			echo $htmlTimerBar;
			echo '	</div>'."\n";
			
			$this->putJS($markup_export);
			
			echo '</div>';
			echo '<!-- END REVOLUTION SLIDER -->';
		}catch(Exception $e){
			$message = $e->getMessage();
			$this->putErrorMessage($message);
		}

	}
	
	public function add_custom_navigation_css($slides){
		$rs_nav = new RevSliderNavigation();
		$all_navs = $rs_nav->get_all_navigations();
		$slider_type = $this->slider->getParam('slider-type');
		
		$enable_arrows = $this->slider->getParam('enable_arrows','off');
		$enable_bullets = $this->slider->getParam('enable_bullets','off');
		$enable_tabs = $this->slider->getParam('enable_tabs','off');
		$enable_thumbnails = $this->slider->getParam('enable_thumbnails','off');
		
		if($slider_type !== 'hero' && ($enable_arrows == 'on' || $enable_bullets == 'on' || $enable_tabs == 'on' || $enable_thumbnails == 'on')){
			if(!empty($slides)){
				foreach($slides as $slide){
					
					$navigation_arrow_style = $this->slider->getParam('navigation_arrow_style','round');
					$navigation_bullets_style = $this->slider->getParam('navigation_bullets_style','round');
					$tabs_style = $this->slider->getParam('tabs_style','round');
					$thumbnails_style = $this->slider->getParam('thumbnails_style','round');
					
					if(!empty($all_navs)){
						foreach($all_navs as $cur_nav){
							//get modifications out, wrap the class with slide class to be specific
							
							if($enable_arrows == 'on' && $cur_nav['handle'] == $navigation_arrow_style){
								$this->rev_custom_navigation_css .= $rs_nav->add_placeholder_sub_modifications($cur_nav['css']['arrows'], $cur_nav['handle'], 'arrows', $cur_nav['settings'], $slide, $this)."\n";
							}
							if($enable_bullets == 'on' && $cur_nav['handle'] == $navigation_bullets_style){
								$this->rev_custom_navigation_css .= $rs_nav->add_placeholder_sub_modifications($cur_nav['css']['bullets'], $cur_nav['handle'], 'bullets', $cur_nav['settings'], $slide, $this)."\n";
							}
							if($enable_tabs == 'on' && $cur_nav['handle'] == $tabs_style){
								$this->rev_custom_navigation_css .= $rs_nav->add_placeholder_sub_modifications($cur_nav['css']['tabs'], $cur_nav['handle'], 'tabs', $cur_nav['settings'], $slide, $this)."\n";
							}
							if($enable_thumbnails == 'on' && $cur_nav['handle'] == $thumbnails_style){
								$this->rev_custom_navigation_css .= $rs_nav->add_placeholder_sub_modifications($cur_nav['css']['thumbs'], $cur_nav['handle'], 'thumbs', $cur_nav['settings'], $slide, $this)."\n";
							}
						}
					}
				}
				
				if($this->markup_export === true){
					echo '<!-- STYLE -->';
				}
				if(!is_admin()){
					echo '<script>var htmlDiv = document.getElementById("rs-plugin-settings-inline-css"); var htmlDivCss="';
				} 
				else echo "<style>";

				if(!is_admin()){
					echo addslashes(RevSliderCssParser::compress_css($this->rev_custom_navigation_css)).'";
						if(htmlDiv) {
							htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
						}else{
							var htmlDiv = document.createElement("div");
							htmlDiv.innerHTML = "<style>" + htmlDivCss + "</style>";
							document.getElementsByTagName("head")[0].appendChild(htmlDiv.childNodes[0]);
						}
					</script>'."\n";
				} 
				else echo $this->rev_custom_navigation_css.'</style>';
				
				if($this->markup_export === true){
					echo '<!-- /STYLE -->';
				}
			}
		}
	}
	
	
	/**
	 * Check if the layer is on a group or a row
	 * @since: 5.3.0
	 **/
	public function is_in_group_or_row($layer){
		$puid = RevSliderFunctions::getVal($layer, 'p_uid');
		return (intval($puid) > 0) ? true : false;
	}

}
?>