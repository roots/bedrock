<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class RevSliderFunctions{
	
	public static function throwError($message,$code=null){
		if(!empty($code)){
			throw new Exception($message,$code);
		}else{
			throw new Exception($message);
		}
	}
	
	
	/**
	 * set output for download
	 */
	public static function downloadFile($str,$filename="output.txt"){
		
		//output for download
		header('Content-Description: File Transfer');
		header('Content-Type: text/html; charset=UTF-8');
		header("Content-Disposition: attachment; filename=".$filename.";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".strlen($str));			
		echo $str;			
		exit();
	}
	
	
	
	/**
	 * turn boolean to string
	 */
	public static function boolToStr($bool){
		if(gettype($bool) == "string")
			return($bool);
		if($bool == true)
			return("true");
		else 
			return("false");
	}
	
	/**
	 * convert string to boolean
	 */
	public static function strToBool($str){
		if(is_bool($str))
			return($str);
			
		if(empty($str))
			return(false);
			
		if(is_numeric($str))
			return($str != 0);
			
		$str = strtolower($str);
		if($str == "true")
			return(true);
			
		return(false);
	}
	
	
	/**
	 * get value from array. if not - return alternative
	 */
	public static function getVal($arr,$key,$altVal=""){
		if(is_array($arr)){
			if(isset($arr[$key])){
				return($arr[$key]);
			}
		}elseif(is_object($arr)){
			if(isset($arr->$key)){
				return($arr->$key);
			}
		}
		return($altVal);
	}

	
	//------------------------------------------------------------
	// get variable from post or from get. post wins.
	public static function getPostGetVariable($name,$initVar = ""){
		$var = $initVar;
		if(isset($_POST[$name])) $var = $_POST[$name];
		else if(isset($_GET[$name])) $var = $_GET[$name];
		return($var);
	}
	
	
	//------------------------------------------------------------
	public static function getPostVariable($name,$initVar = ""){
		$var = $initVar;
		if(isset($_POST[$name])) $var = $_POST[$name];
		return($var);
	}
	
	
	//------------------------------------------------------------
	public static function getGetVar($name,$initVar = ""){
		$var = $initVar;
		if(isset($_GET[$name])) $var = $_GET[$name];
		return($var);
	}
	
	public static function sortByOrder($a, $b) {
		return $a['order'] - $b['order'];
	}
	
	/**
	 * validate that some file exists, if not - throw error
	 */
	public static function validateFilepath($filepath,$errorPrefix=null){
		if(file_exists($filepath) == true)
			return(false);
		if($errorPrefix == null)
			$errorPrefix = "File";
		$message = $errorPrefix." ".esc_attr($filepath)." not exists!";
		self::throwError($message);
	}
	
	/**
	 * validate that some value is numeric
	 */
	public static function validateNumeric($val,$fieldName=""){
		self::validateNotEmpty($val,$fieldName);
		
		if(empty($fieldName))
			$fieldName = "Field";
		
		if(!is_numeric($val))
			self::throwError("$fieldName should be numeric ");
	}
	
	/**
	 * validate that some variable not empty
	 */
	public static function validateNotEmpty($val,$fieldName=""){
		
		if(empty($fieldName))
			$fieldName = "Field";
			
		if(empty($val) && is_numeric($val) == false)
			self::throwError("Field <b>$fieldName</b> should not be empty");
	}

	
	//------------------------------------------------------------
	//get path info of certain path with all needed fields
	public static function getPathInfo($filepath){
		$info = pathinfo($filepath);
		
		//fix the filename problem
		if(!isset($info["filename"])){
			$filename = $info["basename"];
			if(isset($info["extension"]))
				$filename = substr($info["basename"],0,(-strlen($info["extension"])-1));
			$info["filename"] = $filename;
		}
		
		return($info);
	}
	
	/**
	 * Convert std class to array, with all sons
	 * @param unknown_type $arr
	 */
	public static function convertStdClassToArray($arr){
		$arr = (array)$arr;
		
		$arrNew = array();
		
		foreach($arr as $key=>$item){
			$item = (array)$item;
			$arrNew[$key] = $item;
		}
		
		return($arrNew);
	}
	
	public static function cleanStdClassToArray($arr){
		$arr = (array)$arr;
		
		$arrNew = array();
		
		foreach($arr as $key=>$item){
			$arrNew[$key] = $item;
		}
		
		return($arrNew);
	}
	
	
	/**
	 * encode array into json for client side
	 */
	public static function jsonEncodeForClientSide($arr){
		$json = "";
		if(!empty($arr)){
			$json = json_encode($arr);
			$json = addslashes($json);
		}

		if(empty($json)) $json = '{}';

		$json = "'".$json."'";
		
		return($json);
	}


	/**
	 * decode json from the client side
	 */
	public static function jsonDecodeFromClientSide($data){
	
		$data = stripslashes($data);
		$data = str_replace('&#092;"','\"',$data);
		$data = json_decode($data);
		$data = (array)$data;
		
		return($data);
	}
	
	
	/**
	 * do "trim" operation on all array items.
	 */
	public static function trimArrayItems($arr){
		if(gettype($arr) != "array")
			RevSliderFunctions::throwError("trimArrayItems error: The type must be array");
		
		foreach ($arr as $key=>$item){
			if(is_array($item)){
				foreach($item as $key => $value){
					$arr[$key][$key] = trim($value);
				}
			}else{
				$arr[$key] = trim($item);
			}
		}
		
		return($arr);
	}
	
	
	/**
	 * get link html
	 */
	public static function getHtmlLink($link,$text,$id="",$class=""){
		
		if(!empty($class))
			$class = " class='$class'";
		
		if(!empty($id))
			$id = " id='$id'";
			
		$html = "<a href=\"$link\"".$id.$class.">$text</a>";
		return($html);
	}
	
	/**
	 * get select from array
	 */
	public static function getHTMLSelect($arr,$default="",$htmlParams="",$assoc = false){
		
		$html = "<select $htmlParams>";
		foreach($arr as $key=>$item){				
			$selected = "";
			
			if($assoc == false){
				if($item == $default) $selected = " selected ";
			}else{ 
				if(trim($key) == trim($default)) $selected = " selected ";
			}
			
			
			if($assoc == true)
				$html .= "<option $selected value='$key'>$item</option>";
			else
				$html .= "<option $selected value='$item'>$item</option>";
		}
		$html.= "</select>";
		return($html);
	}
	
	
	/**
	 * convert assoc array to array
	 */
	public static function assocToArray($assoc){
		$arr = array();
		foreach($assoc as $item)
			$arr[] = $item;
		
		return($arr);
	}
	
	/**
	 * 
	 * strip slashes from textarea content after ajax request to server
	 */
	public static function normalizeTextareaContent($content){
		if(empty($content))
			return($content);
		$content = stripslashes($content);
		$content = trim($content);
		return($content);
	}
	
	
	/**
	 * get text intro, limit by number of words
	 */
	public static function getTextIntro($text, $limit){
		 
		$arrIntro = explode(' ', $text, $limit);
		 
		if (count($arrIntro)>=$limit) {
			array_pop($arrIntro);
			$intro = implode(" ",$arrIntro);
			$intro = trim($intro);
			if(!empty($intro))
				$intro .= '...';
		} else {
			$intro = implode(" ",$arrIntro);
		}
		  
		$intro = preg_replace('`\[[^\]]*\]`','',$intro);
		return($intro);
	}
	
	
	/**
	 * add missing px/% to value, do also for object and array
	 * @since: 5.0
	 **/
	public static function add_missing_val($obj, $set_to = 'px'){

		if(is_array($obj)){
			foreach($obj as $key => $value){
				if(strpos($value, $set_to) === false){
					$obj[$key] = $value.$set_to;
				}
			}
		}elseif(is_object($obj)){
			foreach($obj as $key => $value){
				if(strpos($value, $set_to) === false){
					$obj->$key = $value.$set_to;
				}
			}
		}else{
			if(strpos($obj, $set_to) === false){
				$obj .= $set_to;
			}
		}
		
		return $obj;
	}
	
	
	/**
	 * normalize object with device informations depending on what is enabled for the Slider
	 * @since: 5.0
	 **/
	public static function normalize_device_settings($obj, $enabled_devices, $return = 'obj', $set_to_if = array()){ //array -> from -> to
		/*desktop
		notebook
		tablet
		mobile*/
		
		if(!empty($set_to_if)){
			foreach($obj as $key => $value) {
				foreach($set_to_if as $from => $to){
					if(trim($value) == $from) $obj->$key = $to;
				}
			}
		}
		
		$inherit_size = self::get_biggest_device_setting($obj, $enabled_devices);
		if($enabled_devices['desktop'] == 'on'){
			if(!isset($obj->desktop) || $obj->desktop === ''){
				$obj->desktop = $inherit_size;
			}else{
				$inherit_size = $obj->desktop;
			}
		}else{
			$obj->desktop = $inherit_size;
		}
		
		if($enabled_devices['notebook'] == 'on'){
			if(!isset($obj->notebook) || $obj->notebook === ''){
				$obj->notebook = $inherit_size;
			}else{
				$inherit_size = $obj->notebook;
			}
		}else{
			$obj->notebook = $inherit_size;
		}
		
		if($enabled_devices['tablet'] == 'on'){
			if(!isset($obj->tablet) || $obj->tablet === ''){
				$obj->tablet = $inherit_size;
			}else{
				$inherit_size = $obj->tablet;
			}
		}else{
			$obj->tablet = $inherit_size;
		}
		
		if($enabled_devices['mobile'] == 'on'){
			if(!isset($obj->mobile) || $obj->mobile === ''){
				$obj->mobile = $inherit_size;
			}else{
				$inherit_size = $obj->mobile;
			}
		}else{
			$obj->mobile = $inherit_size;
		}
		
		switch($return){
			case 'obj':
				//order according to: desktop, notebook, tablet, mobile
				$new_obj = new stdClass();
				$new_obj->desktop = $obj->desktop;
				$new_obj->notebook = $obj->notebook;
				$new_obj->tablet = $obj->tablet;
				$new_obj->mobile = $obj->mobile;
				return $new_obj;
			break;
			case 'html-array':
				if($obj->desktop === $obj->notebook && $obj->desktop === $obj->mobile && $obj->desktop === $obj->tablet){
					return $obj->desktop;
				}else{
					return "['".@$obj->desktop."','".@$obj->notebook."','".@$obj->tablet."','".@$obj->mobile."']";
				}
			break;
		}
		
		return $obj;
	}
	
	
	/**
	 * return biggest value of object depending on which devices are enabled
	 * @since: 5.0
	 **/
	public static function get_biggest_device_setting($obj, $enabled_devices){
		
		if($enabled_devices['desktop'] == 'on'){
			if(isset($obj->desktop) && $obj->desktop != ''){
				return $obj->desktop;
			}
		}
		
		if($enabled_devices['notebook'] == 'on'){
			if(isset($obj->notebook) && $obj->notebook != ''){
				return $obj->notebook;
			}
		}
		
		if($enabled_devices['tablet'] == 'on'){
			if(isset($obj->tablet) && $obj->tablet != ''){
				return $obj->tablet;
			}
		}
		
		if($enabled_devices['mobile'] == 'on'){
			if(isset($obj->mobile) && $obj->mobile != ''){
				return $obj->mobile;
			}
		}
		
		return '';
	}
	
	
	/**
	 * change hex to rgba
	 */
    public static function hex2rgba($hex, $transparency = false, $raw = false, $do_rgb = false) {
        if($transparency !== false){
			$transparency = ($transparency > 0) ? number_format( ( $transparency / 100 ), 2, ".", "" ) : 0;
        }else{
            $transparency = 1;
        }

        $hex = str_replace("#", "", $hex);
		
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else if(self::isrgb($hex)){
			return $hex;
		} else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
		
		if($do_rgb){
			$ret = $r.', '.$g.', '.$b;
		}else{
			$ret = $r.', '.$g.', '.$b.', '.$transparency;
		}
		if($raw){
			return $ret;
		}else{
			return 'rgba('.$ret.')';
		}

    }
	

	public static function isrgb($rgba){
		if(strpos($rgba, 'rgb') !== false) return true;
		
		return false;
	}

	
	/**
	 * change rgba to hex
	 * @since: 5.0
	 */
	public static function rgba2hex($rgba){
		if(strtolower($rgba) == 'transparent') return $rgba;
		
		$temp = explode(',', $rgba);
		$rgb = array();
		if(count($temp) == 4) unset($temp[3]);
		foreach($temp as $val){
			$t = dechex(preg_replace('/[^\d.]/', '', $val));
			if(strlen($t) < 2) $t = '0'.$t;
			$rgb[] = $t;
		}
		
		return '#'.implode('', $rgb);
	}
	
	
	/**
	 * get transparency from rgba
	 * @since: 5.0
	 */
	public static function get_trans_from_rgba($rgba, $in_percent = false){
		if(strtolower($rgba) == 'transparent') return 100;
		
		$temp = explode(',', $rgba);
		if(count($temp) == 4){
			return ($in_percent) ? preg_replace('/[^\d.]/', '', $temp[3]) : preg_replace('/[^\d.]/', "", $temp[3]) * 100;
		}
		return 100;
	}
	
	
	public static function get_responsive_size($slider){
		$operations = new RevSliderOperations();
		$arrValues = $operations->getGeneralSettingsValues();
		
		$enable_custom_size_notebook = $slider->slider->getParam('enable_custom_size_notebook','off');
		$enable_custom_size_tablet = $slider->slider->getParam('enable_custom_size_tablet','off');
		$enable_custom_size_iphone = $slider->slider->getParam('enable_custom_size_iphone','off');
		$adv_resp_sizes = ($enable_custom_size_notebook == 'on' || $enable_custom_size_tablet == 'on' || $enable_custom_size_iphone == 'on') ? true : false;
		
		if($adv_resp_sizes == true){
			$width = $slider->slider->getParam("width", 1240, RevSlider::FORCE_NUMERIC);
			$width .= ','. $slider->slider->getParam("width_notebook", 1024, RevSlider::FORCE_NUMERIC);
			$width .= ','. $slider->slider->getParam("width_tablet", 778, RevSlider::FORCE_NUMERIC);
			$width .= ','. $slider->slider->getParam("width_mobile", 480, RevSlider::FORCE_NUMERIC);
			$height = $slider->slider->getParam("height", 868, RevSlider::FORCE_NUMERIC);
			$height .= ','. $slider->slider->getParam("height_notebook", 768, RevSlider::FORCE_NUMERIC);
			$height .= ','. intval($slider->slider->getParam("height_tablet", 960, RevSlider::FORCE_NUMERIC));
			$height .= ','. intval($slider->slider->getParam("height_mobile", 720, RevSlider::FORCE_NUMERIC));
						
			$responsive = (isset($arrValues['width'])) ? $arrValues['width'] : '1240';
			$def = (isset($arrValues['width'])) ? $arrValues['width'] : '1240';
			
			$responsive.= ',';
			if($enable_custom_size_notebook == 'on'){
				$responsive.= (isset($arrValues['width_notebook'])) ? $arrValues['width_notebook'] : '1024';
				$def = (isset($arrValues['width_notebook'])) ? $arrValues['width_notebook'] : '1024';
			}else{
				$responsive.= $def;
			}
			$responsive.= ',';
			if($enable_custom_size_tablet == 'on'){
				$responsive.= (isset($arrValues['width_tablet'])) ? $arrValues['width_tablet'] : '778';
				$def = (isset($arrValues['width_tablet'])) ? $arrValues['width_tablet'] : '778';
			}else{
				$responsive.= $def;
			}
			$responsive.= ',';
			if($enable_custom_size_iphone == 'on'){
				$responsive.= (isset($arrValues['width_mobile'])) ? $arrValues['width_mobile'] : '480';
				$def = (isset($arrValues['width_mobile'])) ? $arrValues['width_mobile'] : '480';
			}else{
				$responsive.= $def;
			}
			
			return array(
				'level' => $responsive,
				'height' => $height,
				'width' => $width
			);
		}else{
			
			$responsive = (isset($arrValues['width'])) ? $arrValues['width'] : '1240';
			$def = (isset($arrValues['width'])) ? $arrValues['width'] : '1240';
			$responsive.= ',';			
			$responsive.= (isset($arrValues['width_notebook'])) ? $arrValues['width_notebook'] : '1024';
			$responsive.= ',';	
			$responsive.= (isset($arrValues['width_tablet'])) ? $arrValues['width_tablet'] : '778';
			$responsive.= ',';			
			$responsive.= (isset($arrValues['width_mobile'])) ? $arrValues['width_mobile'] : '480';
			
			return array(
				'visibilitylevel' => $responsive,
				'height' => $slider->slider->getParam("height", "868", RevSlider::FORCE_NUMERIC),
				'width' => $slider->slider->getParam("width", "1240", RevSlider::FORCE_NUMERIC)
			);
		}
	}
	
	
}

if(!function_exists("dmp")){
	function dmp($str){
		echo "<div align='left'>";
		echo "<pre>";
		print_r($str);
		echo "</pre>";
		echo "</div>";
	}
}



/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteFunctionsRev extends RevSliderFunctions {}
?>