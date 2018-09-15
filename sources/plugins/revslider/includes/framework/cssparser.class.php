<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderCssParser{
	
	private $cssContent;
	
	public function __construct(){
		
	}
	
	/**
	 * 
	 * init the parser, set css content
	 */
	public function initContent($cssContent){
		$this->cssContent = $cssContent;
	}		
	
	
	/**
	 * 
	 * get array of slide classes, between two sections.
	 */
	public function getArrClasses($startText = "",$endText="",$explodeonspace=false){
		
		$content = $this->cssContent;
		
		//trim from top
		if(!empty($startText)){
			$posStart = strpos($content, $startText);
			if($posStart !== false)
				$content = substr($content, $posStart,strlen($content)-$posStart);
		}
		
		//trim from bottom
		if(!empty($endText)){
			$posEnd = strpos($content, $endText);
			if($posEnd !== false)
				$content = substr($content,0,$posEnd);
		}
		
		//get styles
		$lines = explode("\n",$content);
		$arrClasses = array();
		foreach($lines as $key=>$line){
			$line = trim($line);
			if(strpos($line, "{") === false)
				continue;
			//skip unnessasary links
			if(strpos($line, ".caption a") !== false)
				continue;
				
			if(strpos($line, ".tp-caption a") !== false)
				continue;
				
			//get style out of the line
			$class = str_replace("{", "", $line);
			$class = trim($class);
			
			//skip captions like this: .tp-caption.imageclass img
			if(strpos($class," ") !== false){
				if(!$explodeonspace){
					continue;
				}else{
					$class = explode(',', $class);
					$class = $class[0];
				}
			}
			//skip captions like this: .tp-caption.imageclass:hover, :before, :after
			if(strpos($class,":") !== false)
				continue;
			
			$class = str_replace(".caption.", ".", $class);
			$class = str_replace(".tp-caption.", ".", $class);
			
			$class = str_replace(".", "", $class);
			$class = trim($class);
			$arrWords = explode(" ", $class);
			$class = $arrWords[count($arrWords)-1];
			$class = trim($class);
			
			$arrClasses[] = $class;	
		}
		
		sort($arrClasses);
		
		return($arrClasses);
	}
	
	
	public static function parseCssToArray($css){
		
		while(strpos($css, '/*') !== false){
			if(strpos($css, '*/') === false) return false;
			$start = strpos($css, '/*');
			$end = strpos($css, '*/') + 2;
			$css = str_replace(substr($css, $start, $end - $start), '', $css);
		}
		
		//preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@]+)\{([^\}]*)\}/', $css, $arr);
		preg_match_all( '/(?ims)([a-z0-9\,\s\.\:#_\-@]+)\{([^\}]*)\}/', $css, $arr);

		$result = array();
		foreach ($arr[0] as $i => $x){
			$selector = trim($arr[1][$i]);
			if(strpos($selector, '{') !== false || strpos($selector, '}') !== false) return false;
			$rules = explode(';', trim($arr[2][$i]));
			$result[$selector] = array();
			foreach ($rules as $strRule){
				if (!empty($strRule)){
					$rule = explode(":", $strRule);
					if(strpos($rule[0], '{') !== false || strpos($rule[0], '}') !== false || strpos($rule[1], '{') !== false || strpos($rule[1], '}') !== false) return false;
					
					//put back everything but not $rule[0];
					$key = trim($rule[0]);
					unset($rule[0]);
					$values = implode(':', $rule);
					
					$result[$selector][trim($key)] = trim(str_replace("'", '"', $values));
				}
			}
		}   
		return($result);
	}
	
	
	public static function parseDbArrayToCss($cssArray, $nl = "\n\r"){
		$css = '';
		$deformations = self::get_deformation_css_tags();
		
		$transparency = array(
			'color' => 'color-transparency',
			'background-color' => 'background-transparency',
			'border-color' => 'border-transparency'
		);
		
		$check_parameters = array(
			'border-width' => 'px',
			'border-radius' => 'px',
			'padding' => 'px',
			'font-size' => 'px',
			'line-height' => 'px'
		);
		
		foreach($cssArray as $id => $attr){
			$stripped = '';
			if(strpos($attr['handle'], '.tp-caption') !== false){
				$stripped = trim(str_replace('.tp-caption', '', $attr['handle']));
			}
			
			$attr['advanced'] = json_decode($attr['advanced'], true);
			
			$styles = json_decode(str_replace("'", '"', $attr['params']), true);
			$styles_adv = $attr['advanced']['idle'];
			
			
			$css.= $attr['handle'];
			if(!empty($stripped)) $css.= ', '.$stripped;
			$css.= " {".$nl;
			if(is_array($styles) || is_array($styles_adv)){
				if(is_array($styles)){
					foreach($styles as $name => $style){
						if(in_array($name, $deformations) && $name !== 'css_cursor') continue;
						
						if(!is_array($name) && isset($transparency[$name])){ //the style can have transparency!
							if(isset($styles[$transparency[$name]]) && $style !== 'transparent'){
								$style = RevSliderFunctions::hex2rgba($style, $styles[$transparency[$name]] * 100);
							}
						}
						if(!is_array($name) && isset($check_parameters[$name])){
							$style = RevSliderFunctions::add_missing_val($style, $check_parameters[$name]);
						}
						if(is_array($style) || is_object($style)) $style = implode(' ', $style);
						
						$ret = self::check_for_modifications($name, $style);
						if($ret['name'] == 'cursor' && $ret['style'] == 'auto') continue;
						
						$css.= $ret['name'].':'.$ret['style'].";".$nl;
					}
				}
				if(is_array($styles_adv)){
					foreach($styles_adv as $name => $style){
						if(in_array($name, $deformations) && $name !== 'css_cursor') continue;
						
						if(is_array($style) || is_object($style)) $style = implode(' ', $style);
						$ret = self::check_for_modifications($name, $style);
						if($ret['name'] == 'cursor' && $ret['style'] == 'auto') continue;
						$css.= $ret['name'].':'.$ret['style'].";".$nl;
					}
				}
			}
			$css.= "}".$nl.$nl;
			
			//add hover
			$setting = json_decode($attr['settings'], true);
			if(isset($setting['hover']) && $setting['hover'] == 'true'){
				$hover = json_decode(str_replace("'", '"', $attr['hover']), true);
				$hover_adv = $attr['advanced']['hover'];
				
				if(is_array($hover) || is_array($hover_adv)){
					$css.= $attr['handle'].":hover";
					if(!empty($stripped)) $css.= ', '.$stripped.':hover';
					$css.= " {".$nl;
					if(is_array($hover)){
						foreach($hover as $name => $style){
							if(in_array($name, $deformations) && $name !== 'css_cursor') continue;
							
							if(!is_array($name) && isset($transparency[$name])){ //the style can have transparency!
								if(isset($hover[$transparency[$name]]) && $style !== 'transparent'){
									$style = RevSliderFunctions::hex2rgba($style, $hover[$transparency[$name]] * 100);
								}
							}
							if(!is_array($name) && isset($check_parameters[$name])){
								$style = RevSliderFunctions::add_missing_val($style, $check_parameters[$name]);
							}
							if(is_array($style)|| is_object($style)) $style = implode(' ', $style);
							
							$ret = self::check_for_modifications($name, $style);
							if($ret['name'] == 'cursor' && $ret['style'] == 'auto') continue;
								
							$css.= $ret['name'].':'.$ret['style'].";".$nl;
						}
					}
					if(is_array($hover_adv)){
						foreach($hover_adv as $name => $style){
							
							if(in_array($name, $deformations) && $name !== 'css_cursor') continue;
							if(is_array($style)|| is_object($style)) $style = implode(' ', $style);
							$ret = self::check_for_modifications($name, $style);
							if($ret['name'] == 'cursor' && $ret['style'] == 'auto') continue;
							$css.= $ret['name'].':'.$ret['style'].";".$nl;
						}
					}
					$css.= "}".$nl.$nl;
				}
			}
		}
		return $css;
	}
	
	
	/**
	 * Check for Modifications like with css_cursor
	 * @since: 5.1.3
	 **/
	public static function check_for_modifications($name, $style){
		if($name == 'css_cursor'){
			if($style == 'zoom-in') $style = 'zoom-in; -webkit-zoom-in; cursor: -moz-zoom-in';
			if($style == 'zoom-out') $style = 'zoom-out; -webkit-zoom-out; cursor: -moz-zoom-out';
			$name = 'cursor';
		}
		
		return array('name' => $name, 'style' => $style);
	}
	
	
	public static function parseArrayToCss($cssArray, $nl = "\n\r", $adv = false){
		$deformations = self::get_deformation_css_tags();
		
		$css = '';
		foreach($cssArray as $id => $attr){
			$setting = (array)$attr['settings'];
			
			$advanced = (array)$attr['advanced'];
			$stripped = '';
			if(strpos($attr['handle'], '.tp-caption') !== false){
				$stripped = trim(str_replace('.tp-caption', '', $attr['handle']));
			}
			$styles = (array)$attr['params'];
			$css.= $attr['handle'];
			if(!empty($stripped)) $css.= ', '.$stripped;
			$css.= " {".$nl;
			
			if($adv && isset($advanced['idle'])){
				$styles = array_merge($styles, (array)$advanced['idle']);
				if(isset($setting['type'])){
					$styles['type'] = $setting['type'];
				}
			}
			
			if(is_array($styles) && !empty($styles)){
				foreach($styles as $name => $style){
					if(in_array($name, $deformations) && $name !== 'css_cursor') continue;
					
					if($name == 'background-color' && strpos($style, 'rgba') !== false){ //rgb && rgba
						$rgb = explode(',', str_replace('rgba', 'rgb', $style));
						unset($rgb[count($rgb)-1]);
						$rgb = implode(',', $rgb).')';
						$css.= $name.':'.$rgb.";".$nl;
					}
					
					$style = (is_array($style) || is_object($style)) ? implode(' ', $style) : $style;
					$css.= $name.':'.$style.";".$nl;
				}
			}
			
			$css.= "}".$nl.$nl;
			
			//add hover
			if(isset($setting['hover']) && $setting['hover'] == 'true'){
				$hover = (array)$attr['hover'];
				if($adv && isset($advanced['hover'])){
					$styles = array_merge($styles, (array)$advanced['hover']);
				}
				
				if(is_array($hover)){
					$css.= $attr['handle'].":hover";
					if(!empty($stripped)) $css.= ', '.$stripped.":hover";
					$css.= " {".$nl;
					foreach($hover as $name => $style){
						if($name == 'background-color' && strpos($style, 'rgba') !== false){ //rgb && rgba
							$rgb = explode(',', str_replace('rgba', 'rgb', $style));
							unset($rgb[count($rgb)-1]);
							$rgb = implode(',', $rgb).')';
							$css.= $name.':'.$rgb.";".$nl;
						}
						$style = (is_array($style) || is_object($style)) ? implode(' ', $style) : $style;
						$css.= $name.':'.$style.";".$nl;
					}
					$css.= "}".$nl.$nl;
				}
			}
		}
		return $css;
	}
	
	
	public static function parseStaticArrayToCss($cssArray, $nl = "\n"){
		$css = '';
		foreach($cssArray as $class => $styles){
			$css.= $class." {".$nl;
			if(is_array($styles) && !empty($styles)){
				foreach($styles as $name => $style){
					$style = (is_array($style) || is_object($style)) ? implode(' ', $style) : $style;
					$css.= $name.':'.$style.";".$nl;
				}
			}
			$css.= "}".$nl.$nl;
		}
		return $css;
	}
	
	
	public static function parseDbArrayToArray($cssArray, $handle = false){
		
		if(!is_array($cssArray) || empty($cssArray)) return false;
		
		foreach($cssArray as $key => $css){
			if($handle != false){
				if($cssArray[$key]['handle'] == '.tp-caption.'.$handle){
					$cssArray[$key]['params'] = json_decode(str_replace("'", '"', $css['params']));
					$cssArray[$key]['hover'] = json_decode(str_replace("'", '"', $css['hover']));
					$cssArray[$key]['advanced'] = json_decode(str_replace("'", '"', $css['advanced']));
					$cssArray[$key]['settings'] = json_decode(str_replace("'", '"', $css['settings']));
					return $cssArray[$key];
				}else{
					unset($cssArray[$key]);
				}
			}else{
				$cssArray[$key]['params'] = json_decode(str_replace("'", '"', $css['params']));
				$cssArray[$key]['hover'] = json_decode(str_replace("'", '"', $css['hover']));
				$cssArray[$key]['advanced'] = json_decode(str_replace("'", '"', $css['advanced']));
				$cssArray[$key]['settings'] = json_decode(str_replace("'", '"', $css['settings']));
			}
		}
		
		return $cssArray;
	}
	
	
	public static function compress_css($buffer){
		/* remove comments */
		$buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer) ;
		/* remove tabs, spaces, newlines, etc. */
		$arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ");
		$rep = array("", "", "", "", " ", " ", " ");
		$buffer = str_replace($arr, $rep, $buffer);
		/* remove whitespaces around {}:, */
		$buffer = preg_replace("/\s*([\{\}:,])\s*/", "$1", $buffer);
		/* remove last ; */
		$buffer = str_replace(';}', "}", $buffer);
		
		return $buffer;
	}
	
	
	/**
	 * Defines the default CSS Classes, can be given a version number to order them accordingly
	 * @since: 5.0
	 **/
	public static function default_css_classes(){
		
		$default = array(
			'.tp-caption.medium_grey' => '4',
			'.tp-caption.small_text' => '4',
			'.tp-caption.medium_text' => '4',
			'.tp-caption.large_text' => '4',
			'.tp-caption.very_large_text' => '4',
			'.tp-caption.very_big_white' => '4',
			'.tp-caption.very_big_black' => '4',
			'.tp-caption.modern_medium_fat' => '4',
			'.tp-caption.modern_medium_fat_white' => '4',
			'.tp-caption.modern_medium_light' => '4',
			'.tp-caption.modern_big_bluebg' => '4',
			'.tp-caption.modern_big_redbg' => '4',
			'.tp-caption.modern_small_text_dark' => '4',
			'.tp-caption.boxshadow' => '4',
			'.tp-caption.black' => '4',
			'.tp-caption.noshadow' => '4',
			'.tp-caption.thinheadline_dark' => '4',
			'.tp-caption.thintext_dark' => '4',
			'.tp-caption.largeblackbg' => '4',
			'.tp-caption.largepinkbg' => '4',
			'.tp-caption.largewhitebg' => '4',
			'.tp-caption.largegreenbg' => '4',
			'.tp-caption.excerpt' => '4',
			'.tp-caption.large_bold_grey' => '4',
			'.tp-caption.medium_thin_grey' => '4',
			'.tp-caption.small_thin_grey' => '4',
			'.tp-caption.lightgrey_divider' => '4',
			'.tp-caption.large_bold_darkblue' => '4',
			'.tp-caption.medium_bg_darkblue' => '4',
			'.tp-caption.medium_bold_red' => '4',
			'.tp-caption.medium_light_red' => '4',
			'.tp-caption.medium_bg_red' => '4',
			'.tp-caption.medium_bold_orange' => '4',
			'.tp-caption.medium_bg_orange' => '4',
			'.tp-caption.grassfloor' => '4',
			'.tp-caption.large_bold_white' => '4',
			'.tp-caption.medium_light_white' => '4',
			'.tp-caption.mediumlarge_light_white' => '4',
			'.tp-caption.mediumlarge_light_white_center' => '4',
			'.tp-caption.medium_bg_asbestos' => '4',
			'.tp-caption.medium_light_black' => '4',
			'.tp-caption.large_bold_black' => '4',
			'.tp-caption.mediumlarge_light_darkblue' => '4',
			'.tp-caption.small_light_white' => '4',
			'.tp-caption.roundedimage' => '4',
			'.tp-caption.large_bg_black' => '4',
			'.tp-caption.mediumwhitebg' => '4',
			'.tp-caption.MarkerDisplay' => '5.0',
			'.tp-caption.Restaurant-Display' => '5.0',
			'.tp-caption.Restaurant-Cursive' => '5.0',
			'.tp-caption.Restaurant-ScrollDownText' => '5.0',
			'.tp-caption.Restaurant-Description' => '5.0',
			'.tp-caption.Restaurant-Price' => '5.0',
			'.tp-caption.Restaurant-Menuitem' => '5.0',
			'.tp-caption.Furniture-LogoText' => '5.0',
			'.tp-caption.Furniture-Plus' => '5.0',
			'.tp-caption.Furniture-Title' => '5.0',
			'.tp-caption.Furniture-Subtitle' => '5.0',
			'.tp-caption.Gym-Display' => '5.0',
			'.tp-caption.Gym-Subline' => '5.0',
			'.tp-caption.Gym-SmallText' => '5.0',
			'.tp-caption.Fashion-SmallText' => '5.0',
			'.tp-caption.Fashion-BigDisplay' => '5.0',
			'.tp-caption.Fashion-TextBlock' => '5.0',
			'.tp-caption.Sports-Display' => '5.0',
			'.tp-caption.Sports-DisplayFat' => '5.0',
			'.tp-caption.Sports-Subline' => '5.0',
			'.tp-caption.Instagram-Caption' => '5.0',
			'.tp-caption.News-Title' => '5.0',
			'.tp-caption.News-Subtitle' => '5.0',
			'.tp-caption.Photography-Display' => '5.0',
			'.tp-caption.Photography-Subline' => '5.0',
			'.tp-caption.Photography-ImageHover' => '5.0',
			'.tp-caption.Photography-Menuitem' => '5.0',
			'.tp-caption.Photography-Textblock' => '5.0',
			'.tp-caption.Photography-Subline-2' => '5.0',
			'.tp-caption.Photography-ImageHover2' => '5.0',
			'.tp-caption.WebProduct-Title' => '5.0',
			'.tp-caption.WebProduct-SubTitle' => '5.0',
			'.tp-caption.WebProduct-Content' => '5.0',
			'.tp-caption.WebProduct-Menuitem' => '5.0',
			'.tp-caption.WebProduct-Title-Light' => '5.0',
			'.tp-caption.WebProduct-SubTitle-Light' => '5.0',
			'.tp-caption.WebProduct-Content-Light' => '5.0',
			'.tp-caption.FatRounded' => '5.0',
			'.tp-caption.NotGeneric-Title' => '5.0',
			'.tp-caption.NotGeneric-SubTitle' => '5.0',
			'.tp-caption.NotGeneric-CallToAction' => '5.0',
			'.tp-caption.NotGeneric-Icon' => '5.0',
			'.tp-caption.NotGeneric-Menuitem' => '5.0',
			'.tp-caption.MarkerStyle' => '5.0',
			'.tp-caption.Gym-Menuitem' => '5.0',
			'.tp-caption.Newspaper-Button' => '5.0',
			'.tp-caption.Newspaper-Subtitle' => '5.0',
			'.tp-caption.Newspaper-Title' => '5.0',
			'.tp-caption.Newspaper-Title-Centered' => '5.0',
			'.tp-caption.Hero-Button' => '5.0',
			'.tp-caption.Video-Title' => '5.0',
			'.tp-caption.Video-SubTitle' => '5.0',
			'.tp-caption.NotGeneric-Button' => '5.0',
			'.tp-caption.NotGeneric-BigButton' => '5.0',
			'.tp-caption.WebProduct-Button' => '5.0',
			'.tp-caption.Restaurant-Button' => '5.0',
			'.tp-caption.Gym-Button' => '5.0',
			'.tp-caption.Gym-Button-Light' => '5.0',
			'.tp-caption.Sports-Button-Light' => '5.0',
			'.tp-caption.Sports-Button-Red' => '5.0',
			'.tp-caption.Photography-Button' => '5.0',
			'.tp-caption.Newspaper-Button-2' => '5.0'
		);
		
		$default = apply_filters('revslider_mod_default_css_handles', $default);
		
		return $default;
	}
	
	
	/**
	 * Defines the deformation CSS which is not directly usable as pure CSS
	 * @since: 5.0
	 **/
	public static function get_deformation_css_tags(){
		
		return array(
			'x' => 'x',
			'y' => 'y',
			'z' => 'z',
			'skewx' => 'skewx',
			'skewy' => 'skewy',
			'scalex' => 'scalex',
			'scaley' => 'scaley',
			'opacity' => 'opacity',
			'xrotate' => 'xrotate',
			'yrotate' => 'yrotate',
			'2d_rotation' => '2d_rotation',
			'layer_2d_origin_x' => 'layer_2d_origin_x',
			'layer_2d_origin_y' => 'layer_2d_origin_y',
			'2d_origin_x' => '2d_origin_x',
			'2d_origin_y' => '2d_origin_y',
			'pers' => 'pers',
			
			'color-transparency' => 'color-transparency',
			'background-transparency' => 'background-transparency',
			'border-transparency' => 'border-transparency',
			'css_cursor' => 'css_cursor',
			'speed' => 'speed',
			'easing' => 'easing',
			'corner_left' => 'corner_left',
			'corner_right' => 'corner_right',
			'parallax' => 'parallax',
			'type' => 'type',
			'padding' => 'padding',
			'margin' => 'margin',
			'text-align' => 'text-align'
		);
		
	}
	
	
	public static function get_captions_sorted(){
		$db = new RevSliderDB();
		$styles = $db->fetch(RevSliderGlobals::$table_css, '', 'handle ASC');
		
		$arr = array('5.0' => array(), 'Custom' => array(), '4' => array());
		
		foreach($styles as $style){
			$setting = json_decode($style['settings'], true);
			
			if(!isset($setting['type'])) $setting['type'] = 'text';
			
			if(array_key_exists('version', $setting) && isset($setting['version'])) $arr[ucfirst($setting['version'])][] = array('label' => trim(str_replace('.tp-caption.', '', $style['handle'])), 'type' => $setting['type']);
		}

		$sorted = array();
		foreach($arr as $version => $class){
			foreach($class as $name){
				$sorted[] = array('label' => $name['label'], 'version' => $version, 'type' => $name['type']);
			}
		}
		
		return $sorted;
	}
	
	
	/**
	 * Handles media queries
	 * @since: 5.2.0
	 **/
	public static function parse_media_blocks($css){
		$mediaBlocks = array();

		$start = 0;
		while(($start = strpos($css, '@media', $start)) !== false){
			$s = array();
			
			$i = strpos($css, '{', $start);
			
			if ($i !== false){
				
				$block = trim(substr($css, $start, $i - $start));
				
				array_push($s, $css[$i]);

				$i++;

				while(!empty($s)){
					if ($css[$i] == '{'){
						array_push($s, '{');
					}elseif ($css[$i] == '}'){
						array_pop($s);
					}else{
						//broken css?
					}
					$i++;
				}
				
				$mediaBlocks[$block] = substr($css, $start, ($i + 1) - $start);
				$start = $i;
			}
		}

		return $mediaBlocks;
	}
	
	
	/**
	 * removes @media { ... } queries from CSS
	 * @since: 5.2.0
	 **/
	public static function clear_media_block($css){
		
		$start = 0;
		if($start = strpos($css, '@media', $start) !== false){
			$i = strpos($css, '{', $start) + 1;
			
			//remove @media ... first {
			$remove = substr($css, $start - 1, $i - $start + 1);
			$css = str_replace($remove, '', $css);
			
			//remove last }
			$css = preg_replace('/}$/', '', $css);
			
		}
		
		return $css;
	}
	
}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteCssParserRev extends RevSliderCssParser {}
?>