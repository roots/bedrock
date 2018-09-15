<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderBaseAdmin extends RevSliderBase {
	
	protected static $master_view;
	protected static $view;
	
	private static $arrSettings = array();
	private static $arrMenuPages = array();
	private static $arrSubMenuPages = array();
	private static $tempVars = array();
	private static $startupError = '';
	private static $menuRole = 'admin';
	private static $arrMetaBoxes = array();		//option boxes that will be added to post
	
	private static $allowed_views = array('master-view', 'system/validation', 'system/dialog-video', 'system/dialog-update', 'system/dialog-global-settings', 'sliders', 'slider', 'slider_template', 'slides', 'slide', 'navigation-editor', 'slide-editor', 'slide-overview', 'slide-editor', 'slider-overview', 'themepunch-google-fonts');
	
	/**
	 * 
	 * main constructor		 
	 */
	public function __construct($t){
		
		parent::__construct($t);
		
		//set view
		self::$view = self::getGetVar("view");
		if(empty(self::$view))
			self::$view = 'sliders';
			
		//add internal hook for adding a menu in arrMenus
		add_action('admin_menu', array('RevSliderBaseAdmin', 'addAdminMenu'));
		add_action('add_meta_boxes', array('RevSliderBaseAdmin', 'onAddMetaboxes'));
		add_action('save_post', array('RevSliderBaseAdmin', 'onSavePost'));
		
		//if not inside plugin don't continue
		if($this->isInsidePlugin() == true){
			add_action('admin_enqueue_scripts', array('RevSliderBaseAdmin', 'addCommonScripts'));
			add_action('admin_enqueue_scripts', array('RevSliderAdmin', 'onAddScripts'));
		}else{
			add_action('admin_enqueue_scripts', array('RevSliderBaseAdmin', 'addGlobalScripts'));
		}
		
		//a must event for any admin. call onActivate function.
		$this->addEvent_onActivate();
		$this->addAction_onActivate();
		
		self::addActionAjax('show_image', 'onShowImage');
	}		
	
	/**
	 * 
	 * add some meta box
	 * return metabox handle
	 */
	public static function addMetaBox($title,$content = null, $customDrawFunction = null,$location="post"){
		
		$box = array();
		$box['title'] = $title;
		$box['location'] = $location;
		$box['content'] = $content;
		$box['draw_function'] = $customDrawFunction;
		
		self::$arrMetaBoxes[] = $box;			
	}
	
	
	/**
	 * 
	 * on add metaboxes
	 */
	public static function onAddMetaboxes(){
		
		foreach(self::$arrMetaBoxes as $index=>$box){
			
			$title = $box['title'];
			$location = $box['location'];
			
			$boxID = 'mymetabox_revslider_'.$index;
			$function = array(self::$t, "onAddMetaBoxContent");
			
			if(is_array($location)){
				foreach($location as $loc)
					add_meta_box($boxID,$title,$function,$loc,'normal','default');
			}else
				add_meta_box($boxID,$title,$function,$location,'normal','default');
		}
	}
	
	/**
	 * 
	 * on save post meta. Update metaboxes data from post, add it to the post meta 
	 */
	public static function onSavePost(){
		
		//protection against autosave
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			$postID = RevSliderFunctions::getPostVariable("ID");
			return $postID;
		}
		
		$postID = RevSliderFunctions::getPostVariable("ID");
		if(empty($postID))
			return(false);
			
			
		foreach(self::$arrMetaBoxes as $box){
			
			$arrSettingNames = array('slide_template');
			foreach($arrSettingNames as $name){
				$value = RevSliderFunctions::getPostVariable($name);
				update_post_meta( $postID, $name, $value );
			}	//end foreach settings

		} //end foreach meta
		
	}
	
	/**
	 * 
	 * on add metabox content
	 */
	public static function onAddMetaBoxContent($post,$boxData){
		
		$postID = $post->ID;
		
		$boxID = RevSliderFunctions::getVal($boxData, "id");
		$index = str_replace('mymetabox_revslider_',"",$boxID);
		
		$arrMetabox = self::$arrMetaBoxes[$index];
		

		//draw element
		$drawFunction = RevSliderFunctions::getVal($arrMetabox, "draw_function");
		if(!empty($drawFunction))
			call_user_func($drawFunction);
		
	}
	
	
	/**
	 * 
	 * set the menu role - for viewing menus
	 */
	public static function setMenuRole($menuRole){
		self::$menuRole = $menuRole;
	}
	
	
	/**
	 * get the menu role - for viewing menus
	 */
	public static function getMenuRole(){
		return self::$menuRole;
	}
	
	/**
	 * 
	 * set startup error to be shown in master view
	 */
	public static function setStartupError($errorMessage){
		self::$startupError = $errorMessage;
	}
	
	
	/**
	 * 
	 * tells if the the current plugin opened is this plugin or not 
	 * in the admin side.
	 */
	private function isInsidePlugin(){
		$page = self::getGetVar("page");
		
		if($page == 'revslider' || $page == 'themepunch-google-fonts' || $page == 'revslider_navigation')
			return(true);
		return(false);
	} 
	
	
	/**
	 * add global used scripts
	 * @since: 5.1.1
	 */
	public static function addGlobalScripts(){
		wp_enqueue_script(array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'wpdialogs'));
		wp_enqueue_style(array('wp-jquery-ui', 'wp-jquery-ui-dialog', 'wp-jquery-ui-core'));
	}
	
	
	/**
	 * add common used scripts
	 */
	public static function addCommonScripts(){
		
		if(function_exists("wp_enqueue_media"))
			wp_enqueue_media();
		
		wp_enqueue_script(array('jquery', 'jquery-ui-core', 'jquery-ui-mouse', 'jquery-ui-accordion', 'jquery-ui-datepicker', 'jquery-ui-dialog', 'jquery-ui-slider', 'jquery-ui-autocomplete', 'jquery-ui-sortable', 'jquery-ui-droppable', 'jquery-ui-tabs', 'jquery-ui-widget', 'wp-color-picker'));
		
		wp_enqueue_style(array('wp-jquery-ui', 'wp-jquery-ui-core', 'wp-jquery-ui-dialog', 'wp-color-picker'));
		
		wp_enqueue_script('unite_settings', RS_PLUGIN_URL .'admin/assets/js/settings.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('unite_admin', RS_PLUGIN_URL .'admin/assets/js/admin.js', array(), RevSliderGlobals::SLIDER_REVISION );
		
		wp_enqueue_style('unite_admin', RS_PLUGIN_URL .'admin/assets/css/admin.css', array(), RevSliderGlobals::SLIDER_REVISION);
		
		//add tipsy
		wp_enqueue_script('tipsy', RS_PLUGIN_URL .'admin/assets/js/jquery.tipsy.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_style('tipsy', RS_PLUGIN_URL .'admin/assets/css/tipsy.css', array(), RevSliderGlobals::SLIDER_REVISION);
		
		//include codemirror
		wp_enqueue_script('codemirror_js', RS_PLUGIN_URL .'admin/assets/js/codemirror/codemirror.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('codemirror_js_highlight', RS_PLUGIN_URL .'admin/assets/js/codemirror/util/match-highlighter.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('codemirror_js_searchcursor', RS_PLUGIN_URL .'admin/assets/js/codemirror/util/searchcursor.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('codemirror_js_css', RS_PLUGIN_URL .'admin/assets/js/codemirror/css.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('codemirror_js_html', RS_PLUGIN_URL .'admin/assets/js/codemirror/xml.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_style('codemirror_css', RS_PLUGIN_URL .'admin/assets/js/codemirror/codemirror.css', array(), RevSliderGlobals::SLIDER_REVISION);
		
	}
	
	
	
	/**
	 * 
	 * admin pages parent, includes all the admin files by default
	 */
	public static function adminPages(){
		//self::validateAdminPermissions();
	}
	
	
	/**
	 * 
	 * validate permission that the user is admin, and can manage options.
	 */
	protected static function isAdminPermissions(){
		
		if( is_admin() && current_user_can("manage_options") )
			return(true);
			
		return(false);
	}
	
	/**
	 * 
	 * validate admin permissions, if no pemissions - exit
	 */
	protected static function validateAdminPermissions(){
		if(!self::isAdminPermissions()){
			echo "access denied";
			return(false);
		}			
	}
	
	/**
	 * 
	 * set view that will be the master
	 */
	protected static function setMasterView($masterView){
		self::$master_view = $masterView;
	}
	
	/**
	 * 
	 * inlcude some view file
	 */
	protected static function requireView($view){
		try{
			//require master view file, and 
			if(!empty(self::$master_view) && !isset(self::$tempVars["is_masterView"]) ){
				$masterViewFilepath = self::$path_views.self::$master_view.".php";
				RevSliderFunctions::validateFilepath($masterViewFilepath,"Master View");
				
				self::$tempVars["is_masterView"] = true;
				require $masterViewFilepath;
			}else{		//simple require the view file.
				if(!in_array($view, self::$allowed_views)) UniteFunctionsRev::throwError(__('Wrong Request', 'revslider'));
				
				switch($view){ //switch URLs to corresponding php files
					case 'slide':
						$view = 'slide-editor';
					break;
					case 'slider':
						$view = 'slider-editor';
					break;
					case 'sliders':
						$view = 'slider-overview';
					break;
					case 'slides':
						$view = 'slide-overview';
					break;
				}
				
				$viewFilepath = self::$path_views.$view.".php";
				
				RevSliderFunctions::validateFilepath($viewFilepath,"View");
				require $viewFilepath;
			}
			
		}catch (Exception $e){
			echo "<br><br>View (".esc_attr($view).") Error: <b>".esc_attr($e->getMessage())."</b>";
		}
	}
	
	/**
	 * require some template from "templates" folder
	 */
	protected static function getPathTemplate($templateName){
		$pathTemplate = self::$path_templates.$templateName.'.php';
		RevSliderFunctions::validateFilepath($pathTemplate,'Template');
		
		return($pathTemplate);
	}
	
	
	/**
	 * 
	 * add all js and css needed for media upload
	 */
	protected static function addMediaUploadIncludes(){
		
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_style('thickbox');
		
	}
	
	
	/**
	 * add admin menus from the list.
	 */
	public static function addAdminMenu(){
		global $revslider_screens;
		
		$role = "manage_options";
		
		switch(self::$menuRole){
			case 'author':
				$role = "edit_published_posts";
			break;
			case 'editor':
				$role = "edit_pages";
			break;		
			default:		
			case 'admin':
				$role = "manage_options";
			break;
		}
		
		foreach(self::$arrMenuPages as $menu){
			$title = $menu["title"];
			$pageFunctionName = $menu["pageFunction"];
			$revslider_screens[] = add_menu_page( $title, $title, $role, 'revslider', array(self::$t, $pageFunctionName), 'dashicons-update' );
		}
		
		foreach(self::$arrSubMenuPages as $menu){
			$title = $menu["title"];
			$pageFunctionName = $menu["pageFunction"];
			$pageSlug = $menu["pageSlug"];
			$revslider_screens[] = add_submenu_page( 'revslider', $title, $title, $role, $pageSlug, array(self::$t, $pageFunctionName) );
		}
		
	}
	
	
	/**
	 * 
	 * add menu page
	 */
	protected static function addMenuPage($title,$pageFunctionName){
		
		self::$arrMenuPages[] = array("title"=>$title,"pageFunction"=>$pageFunctionName);
		
	}
	
	
	/**
	 * 
	 * add menu page
	 */
	protected static function addSubMenuPage($title,$pageFunctionName,$pageSlug){
		
		self::$arrSubMenuPages[] = array("title"=>$title,"pageFunction"=>$pageFunctionName,"pageSlug"=>$pageSlug);
		
	}

	/**
	 * 
	 * get url to some view.
	 */
	public static function getViewUrl($viewName,$urlParams=""){
		$params = "&view=".$viewName;
		if(!empty($urlParams))
			$params .= "&".$urlParams;
		
		$link = admin_url( 'admin.php?page=revslider'.$params);
		return($link);
	}
	
	/**
	 * 
	 * register the "onActivate" event
	 */
	protected function addEvent_onActivate($eventFunc = "onActivate"){
		register_activation_hook( RS_PLUGIN_FILE_PATH, array(self::$t, $eventFunc) );
	}
	
	
	protected function addAction_onActivate(){
		register_activation_hook( RS_PLUGIN_FILE_PATH, array(self::$t, 'onActivateHook') );
	}
	
	
	public static function onActivateHook(){
		
		$options = array();
		
		$options = apply_filters('revslider_mod_activation_option', $options);
		
		
		$operations = new RevSliderOperations();
		$options_exist = $operations->getGeneralSettingsValues();
		$options = array_merge($options_exist, $options);
		
		$operations->updateGeneralSettings($options);
		
	}
	
	
	/**
	 * 
	 * store settings in the object
	 */
	protected static function storeSettings($key,$settings){
		self::$arrSettings[$key] = $settings;
	}
	
	
	/**
	 * 
	 * get settings object
	 */
	protected static function getSettings($key){
		if(!isset(self::$arrSettings[$key]))
			RevSliderFunctions::throwError("Settings $key not found");
		$settings = self::$arrSettings[$key];
		return($settings);
	}
	
	
	/**
	 * 
	 * add ajax back end callback, on some action to some function.
	 */
	protected static function addActionAjax($ajaxAction,$eventFunction){
		add_action('wp_ajax_revslider_'.$ajaxAction, array('RevSliderAdmin', $eventFunction));
	}
	
	
	/**
	 * 
	 * echo json ajax response
	 */
	private static function ajaxResponse($success,$message,$arrData = null){
		
		$response = array();			
		$response["success"] = $success;				
		$response["message"] = $message;
		
		if(!empty($arrData)){
			
			if(gettype($arrData) == "string")
				$arrData = array("data"=>$arrData);				
			
			$response = array_merge($response,$arrData);
		}
			
		$json = json_encode($response);
		
		echo $json;
		exit();
	}

	
	/**
	 * 
	 * echo json ajax response, without message, only data
	 */
	protected static function ajaxResponseData($arrData){
		if(gettype($arrData) == "string")
			$arrData = array("data"=>$arrData);
		
		self::ajaxResponse(true,"",$arrData);
	}
	
	
	/**
	 * 
	 * echo json ajax response
	 */
	protected static function ajaxResponseError($message,$arrData = null){
		
		self::ajaxResponse(false,$message,$arrData,true);
	}
	
	
	/**
	 * echo ajax success response
	 */
	protected static function ajaxResponseSuccess($message,$arrData = null){
		
		self::ajaxResponse(true,$message,$arrData,true);
		
	}
	
	
	/**
	 * echo ajax success response
	 */
	protected static function ajaxResponseSuccessRedirect($message,$url){
		$arrData = array("is_redirect"=>true,"redirect_url"=>$url);
		
		self::ajaxResponse(true,$message,$arrData,true);
	}
	

}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteBaseAdminClassRev extends RevSliderBaseAdmin {}
?>