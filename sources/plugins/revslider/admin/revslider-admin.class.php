<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderAdmin extends RevSliderBaseAdmin{

	const VIEW_SLIDER = "slider";
	const VIEW_SLIDER_TEMPLATE = "slider_template"; //obsolete
	const VIEW_SLIDERS = "sliders";
	const VIEW_SLIDES = "slides";
	const VIEW_SLIDE = "slide";
	
	/**
	 * the constructor
	 */
	public function __construct(){

		parent::__construct($this);

		//set table names
		RevSliderGlobals::$table_sliders = self::$table_prefix.RevSliderGlobals::TABLE_SLIDERS_NAME;
		RevSliderGlobals::$table_slides = self::$table_prefix.RevSliderGlobals::TABLE_SLIDES_NAME;
		RevSliderGlobals::$table_static_slides = self::$table_prefix.RevSliderGlobals::TABLE_STATIC_SLIDES_NAME;
		RevSliderGlobals::$table_settings = self::$table_prefix.RevSliderGlobals::TABLE_SETTINGS_NAME;
		RevSliderGlobals::$table_css = self::$table_prefix.RevSliderGlobals::TABLE_CSS_NAME;
		RevSliderGlobals::$table_layer_anims = self::$table_prefix.RevSliderGlobals::TABLE_LAYER_ANIMS_NAME;
		RevSliderGlobals::$table_navigation = self::$table_prefix.RevSliderGlobals::TABLE_NAVIGATION_NAME;

		RevSliderGlobals::$filepath_backup = RS_PLUGIN_PATH.'backup/';
		RevSliderGlobals::$filepath_captions = RS_PLUGIN_PATH.'public/assets/css/captions.css';
		RevSliderGlobals::$urlCaptionsCSS = RS_PLUGIN_URL.'public/assets/css/captions.php';
		RevSliderGlobals::$filepath_dynamic_captions = RS_PLUGIN_PATH.'public/assets/css/dynamic-captions.css';
		RevSliderGlobals::$filepath_captions_original = RS_PLUGIN_PATH.'public/assets/css/captions-original.css';
		
		$wp_upload_dir = wp_upload_dir();
		$wp_upload_dir = $wp_upload_dir['basedir'].'/';
		RevSliderGlobals::$uploadsUrlExportZip = $wp_upload_dir.'export.zip';

		$this->init();
	}


	/**
	 * init all actions
	 */
	private function init(){
		global $revSliderAsTheme;
		global $pagenow;
		
		$template = new RevSliderTemplate();
		$operations = new RevSliderOperations();
		$obj_library = new RevSliderObjectLibrary();
		$general_settings = $operations->getGeneralSettingsValues();
		
		$role = RevSliderBase::getVar($general_settings, 'role', 'admin');
		$force_activation_box = RevSliderBase::getVar($general_settings, 'force_activation_box', 'off');
		
		if($force_activation_box == 'on'){ //force the notifications and more
			$revSliderAsTheme = false;
		}
		
		self::setMenuRole($role);

		self::addMenuPage('Slider Revolution', "adminPages");
		
		self::addSubMenuPage(__('Navigation Editor', 'revslider'), 'display_plugin_submenu_page_navigation', 'revslider_navigation');
		

		$this->addSliderMetaBox();

		//ajax response to save slider options.
		self::addActionAjax("ajax_action", "onAjaxAction");
		
		$upgrade = new RevSliderUpdate( GlobalsRevSlider::SLIDER_REVISION );
		
		$temp_active = get_option('revslider-temp-active', 'false');
		
		if($temp_active == 'true'){ //check once an hour
			$temp_force = (isset($_GET['checktempactivate'])) ? true : false;
			$upgrade->add_temp_active_check($temp_force);
		}
		
		//add common scripts there
		$validated = get_option('revslider-valid', 'false');
		$notice = get_option('revslider-valid-notice', 'true');
		$latestv = RevSliderGlobals::SLIDER_REVISION;
		$stablev = get_option('revslider-stable-version', '0');
		
		if(!$revSliderAsTheme || version_compare($latestv, $stablev, '<')){
			if($validated === 'false' && $notice === 'true'){
				add_action('admin_notices', array($this, 'addActivateNotification'));
			}

			if(isset($_GET['checkforupdates']) && $_GET['checkforupdates'] == 'true')
				$upgrade->_retrieve_version_info(true);
			
			if($validated === 'true' || version_compare($latestv, $stablev, '<')) {
				$upgrade->add_update_checks();
			}
		}
		
		
		if(isset($_REQUEST['update_shop'])){
			$template->_get_template_list(true);
		}else{
			$template->_get_template_list();
		}
		
		if(isset($_REQUEST['update_object_library'])){
			$obj_library->_get_list(true);
		}else{
			$obj_library->_get_list();
		}
		
		$upgrade->_retrieve_version_info();
		add_action('admin_notices', array($this, 'add_notices'));
		
		add_action('admin_enqueue_scripts', array('RevSliderAdmin', 'enqueue_styles'));
		
		add_action('admin_enqueue_scripts', array('RevSliderAdmin', 'enqueue_all_admin_scripts'));
		
		add_action('wp_ajax_revslider_ajax_call_front', array('RevSliderAdmin', 'onFrontAjaxAction'));
		add_action('wp_ajax_nopriv_revslider_ajax_call_front', array('RevSliderAdmin', 'onFrontAjaxAction')); //for not logged in users
		
		add_action( 'admin_head', array('RevSliderAdmin', 'include_custom_css' ));
		
		if(isset($pagenow) && $pagenow == 'plugins.php'){
			add_action('admin_notices', array('RevSliderAdmin', 'add_plugins_page_notices'));
		}
		
		// Add-on Admin
		$addon_admin = new Rev_addon_Admin( 'rev_addon', RevSliderGlobals::SLIDER_REVISION );
		add_action( 'admin_enqueue_scripts', array( $addon_admin, 'enqueue_styles') );
		add_action( 'admin_enqueue_scripts', array( $addon_admin, 'enqueue_scripts') );
		add_action( 'admin_menu', array( $addon_admin, 'add_plugin_admin_menu'), 11 );
		// Add-on Admin Button Ajax Actions
		add_action( 'wp_ajax_activate_plugin', array( $addon_admin, 'activate_plugin') );
		//add_action( 'wp_ajax_nopriv_activate_plugin', array( $addon_admin, 'activate_plugin') );
		add_action( 'wp_ajax_deactivate_plugin', array( $addon_admin, 'deactivate_plugin'));
		//add_action( 'wp_ajax_nopriv_deactivate_plugin', array( $addon_admin, 'deactivate_plugin') );
		add_action( 'wp_ajax_install_plugin', array( $addon_admin, 'install_plugin'));
		//add_action( 'wp_ajax_nopriv_install_plugin', array( $addon_admin, 'install_plugin') );
		
		
		//add_filter('plugin_action_links', array('RevSliderAdmin', 'plugin_action_links' ), 10, 2);
	}
	
	
	public static function add_plugins_page_notices(){
		$plugins = get_plugins();
        
        foreach($plugins as $plugin_id => $plugin){
            
            $slug = dirname($plugin_id);
            if(empty($slug)) continue;
			if($slug !== 'revslider') continue;
            
			//check version, latest updates and if registered or not
			$validated = get_option('revslider-valid', 'false');
			$latestv = get_option('revslider-latest-version', RevSliderGlobals::SLIDER_REVISION);
			
			if($validated == 'false'){ //activate for updates and support
				add_action( "after_plugin_row_" . $plugin_id, array('RevSliderAdmin', 'show_purchase_notice'), 10, 3);
			}
			
			if(version_compare($latestv, $plugin['Version'], '>')){
				add_action( "after_plugin_row_" . $plugin_id, array('RevSliderAdmin', 'show_update_notice'), 10, 3);
			}
		}   
	}
	
	
	public static function show_purchase_notice(){
		$wp_list_table = _get_list_table('WP_Plugins_List_Table');
        ?>
        <tr class="plugin-update-tr"><td colspan="<?php echo $wp_list_table->get_column_count(); ?>" class="plugin-update colspanchange">
            <div class="update-message installer-q-icon">
            <?php _e('Activate Slider Revolution for <a href="http://revolution.themepunch.com/direct-customer-benefits/" target="_blank">Premium Benefits (e.g. Live Updates)</a>.', 'revslider'); ?>
            </div>
        </tr>
        <?php 
	}
	
	
	public static function show_update_notice(){
		$wp_list_table = _get_list_table('WP_Plugins_List_Table');
        ?>
        <tr class="plugin-update-tr"><td colspan="<?php echo $wp_list_table->get_column_count(); ?>" class="plugin-update colspanchange">
            <div class="update-message">
            <?php _e('A new version of Slider Revolution is available.', 'revslider'); ?>
            </div>
        </tr>
        <?php 
	}
	
	
	public static function plugin_action_links($links, $file){
		if ($file == plugin_basename(RS_PLUGIN_FILE_PATH)){
			$rs_enabled = get_option('revslider-valid', 'false');
			
			if($rs_enabled == 'true'){
				krsort($links);
				end($links);
				$key = key($links);
				$links[$key] .= '';
			}
		}
		
		return $links;
	}
	
	
	public static function enqueue_styles(){
		wp_enqueue_style('rs-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,300,700,600,800');
		wp_enqueue_style('revslider-global-styles', RS_PLUGIN_URL . 'admin/assets/css/global.css', array(), GlobalsRevSlider::SLIDER_REVISION );
	}

	
	public static function include_custom_css(){
		
		$type = (isset($_GET['view'])) ? $_GET['view'] : '';
		$page = (isset($_GET['page'])) ? $_GET['page'] : '';
		
		if($page !== 'slider' && $page !== 'revslider_navigation') return false; //showbiz fix
		
		$sliderID = '';
		
		switch($type){
			case 'slider':
				
				$sliderID = (isset($_GET['id'])) ? $_GET['id'] : '';
			break;
			case 'slide':
				$slideID = (isset($_GET['id'])) ? $_GET['id'] : '';
				if($slideID == 'new') break;
				
				$slide = new RevSlide();
				$slide->initByID($slideID);
				$sliderID = $slide->getSliderID();
			break;
			default:
				if(isset($_GET['slider'])){
					$sliderID = $_GET['slider'];
				}
			break;
		}

		$arrFieldsParams = array();

		if(!empty($sliderID)){
			$slider = new RevSlider();
			$slider->initByID($sliderID);
			$settingsFields = $slider->getSettingsFields();
			$arrFieldsMain = $settingsFields['main'];
			$arrFieldsParams = $settingsFields['params'];			
			$custom_css = @stripslashes($arrFieldsParams['custom_css']);
			$custom_css = RevSliderCssParser::compress_css($custom_css);
			echo '<style>'.$custom_css.'</style>';
		}
	}
	
	
	public static function enqueue_all_admin_scripts() {
		wp_localize_script('unite_admin', 'rev_lang', self::get_javascript_multilanguage()); //Load multilanguage for JavaScript
		
		wp_enqueue_style(array('wp-color-picker'));
		wp_enqueue_script(array('wp-color-picker'));
		
		
		//enqueue in all pages / posts in backend
		$screen = get_current_screen();
		
		$post_types = get_post_types( '', 'names' ); 
		foreach($post_types as $post_type) {
			if($post_type == $screen->id){
				wp_enqueue_script('revslider-tinymce-shortcode-script', RS_PLUGIN_URL . 'admin/assets/js/tinymce-shortcode-script.js', array('jquery'), RevSliderGlobals::SLIDER_REVISION );
			}
		}
	}
	

	/**
	 * Include wanted submenu page
	 */
	public function display_plugin_submenu_page_navigation() {
		self::display_plugin_submenu('navigation-editor');
	}
	

	/**
	 * Include wanted submenu page
	 */
	public function display_plugin_submenu_page_google_fonts() {
		self::display_plugin_submenu('themepunch-google-fonts');
	}

	
	public static function display_plugin_submenu($subMenu){

		parent::adminPages();

		self::setMasterView('master-view');
		self::requireView($subMenu);
	}
	
	
	/**
	 * Create Multilanguage for JavaScript
	 */
	protected static function get_javascript_multilanguage(){
		$lang = array(
			'wrong_alias' => __('-- wrong alias -- ', 'revslider'),
			'nav_bullet_arrows_to_none' => __('Navigation Bullets and Arrows are now set to none.', 'revslider'),
			'create_template' => __('Create Template', 'revslider'),
			'really_want_to_delete' => __('Do you really want to delete', 'revslider'),
			'sure_to_replace_urls' => __('Are you sure to replace the urls?', 'revslider'),
			'set_settings_on_all_slider' => __('Set selected settings on all Slides of this Slider? (This will be saved immediately)', 'revslider'),
			'select_slide_img' => __('Select Slide Image', 'revslider'),
			'select_layer_img' => __('Select Layer Image', 'revslider'),
			'select_slide_video' => __('Select Slide Video', 'revslider'),
			'show_slide_opt' => __('Show Slide Options', 'revslider'),
			'hide_slide_opt' => __('Hide Slide Options', 'revslider'),
			'close' => __('Close', 'revslider'),
			'really_update_global_styles' => __('Really update global styles?', 'revslider'),
			'global_styles_editor' => __('Global Styles Editor', 'revslider'),
			'select_image' => __('Select Image', 'revslider'),
			'video_not_found' => __('No Thumbnail Image Set on Video / Video Not Found / No Valid Video ID', 'revslider'),
			'handle_at_least_three_chars' => __('Handle has to be at least three character long', 'revslider'),
			'really_change_font_sett' => __('Really change font settings?', 'revslider'),
			'really_delete_font' => __('Really delete font?', 'revslider'),
			'class_exist_overwrite' => __('Class already exists, overwrite?', 'revslider'),
			'class_must_be_valid' => __('Class must be a valid CSS class name', 'revslider'),
			'really_overwrite_class' => __('Really overwrite Class?', 'revslider'),
			'relly_delete_class' => __('Really delete Class', 'revslider'),
			'class_this_cant_be_undone' => __('? This can\'t be undone!', 'revslider'),
			'this_class_does_not_exist' => __('This class does not exist.', 'revslider'),
			'making_changes_will_probably_overwrite_advanced' => __('Making changes to these settings will probably overwrite advanced settings. Continue?', 'revslider'),
			'select_static_layer_image' => __('Select Static Layer Image', 'revslider'),
			'select_layer_image' => __('Select Layer Image', 'revslider'),
			'really_want_to_delete_all_layer' => __('Do you really want to delete all the layers?', 'revslider'),
			'layer_animation_editor' => __('Layer Animation Editor', 'revslider'),
			'animation_exists_overwrite' => __('Animation already exists, overwrite?', 'revslider'),
			'really_overwrite_animation' => __('Really overwrite animation?', 'revslider'),
			'default_animations_cant_delete' => __('Default animations can\'t be deleted', 'revslider'),
			'must_be_greater_than_start_time' => __('Must be greater than start time', 'revslider'),
			'sel_layer_not_set' => __('Selected layer not set', 'revslider'),
			'edit_layer_start' => __('Edit Layer Start', 'revslider'),
			'edit_layer_end' => __('Edit Layer End', 'revslider'),
			'default_animations_cant_rename' => __('Default Animations can\'t be renamed', 'revslider'),
			'anim_name_already_exists' => __('Animationname already existing', 'revslider'),
			'css_name_already_exists' => __('CSS classname already existing', 'revslider'),
			'css_orig_name_does_not_exists' => __('Original CSS classname not found', 'revslider'),
			'enter_correct_class_name' => __('Enter a correct class name', 'revslider'),
			'class_not_found' => __('Class not found in database', 'revslider'),
			'css_name_does_not_exists' => __('CSS classname not found', 'revslider'),
			'delete_this_caption' => __('Delete this caption? This may affect other Slider', 'revslider'),
			'this_will_change_the_class' => __('This will update the Class with the current set Style settings, this may affect other Sliders. Proceed?', 'revslider'),
			'unsaved_changes_will_not_be_added' => __('Template will have the state of the last save, proceed?', 'revslider'),
			'please_enter_a_slide_title' => __('Please enter a Slide title', 'revslider'),
			'please_wait_a_moment' => __('Please Wait a Moment', 'revslider'),
			'copy_move' => __('Copy / Move', 'revslider'),
			'preset_loaded' => __('Preset Loaded', 'revslider'),
			'add_bulk_slides' => __('Add Bulk Slides', 'revslider'),
			'select_image' => __('Select Image', 'revslider'),
			'arrows' => __('Arrows', 'revslider'),
			'bullets' => __('Bullets', 'revslider'),
			'thumbnails' => __('Thumbnails', 'revslider'),
			'tabs' => __('Tabs', 'revslider'),
			'delete_navigation' => __('Delete this Navigation?', 'revslider'),
			'could_not_update_nav_name' => __('Navigation name could not be updated', 'revslider'),
			'name_too_short_sanitize_3' => __('Name too short, at least 3 letters between a-zA-z needed', 'revslider'),
			'nav_name_already_exists' => __('Navigation name already exists, please choose a different name', 'revslider'),
			'remove_nav_element' => __('Remove current element from Navigation?', 'revslider'),
			'create_this_nav_element' => __('This navigation element does not exist, create one?', 'revslider'),
			'overwrite_animation' => __('Overwrite current animation?', 'revslider'),
			'cant_modify_default_anims' => __('Default animations can\'t be changed', 'revslider'),
			'anim_with_handle_exists' => __('Animation already existing with given handle, please choose a different name.', 'revslider'),
			'really_delete_anim' => __('Really delete animation:', 'revslider'),
			'this_will_reset_navigation' => __('This will reset the navigation, continue?', 'revslider'),
			'preset_name_already_exists' => __('Preset name already exists, please choose a different name', 'revslider'),
			'delete_preset' => __('Really delete this preset?', 'revslider'),
			'update_preset' => __('This will update the preset with the current settings. Proceed?', 'revslider'),
			'maybe_wrong_yt_id' => __('No Thumbnail Image Set on Video / Video Not Found / No Valid Video ID', 'revslider'),
			'preset_not_found' => __('Preset not found', 'revslider'),
			'cover_image_needs_to_be_set' => __('Cover Image need to be set for videos', 'revslider'),
			'remove_this_action' => __('Really remove this action?', 'revslider'),
			'layer_action_by' => __('Layer is triggered by ', 'revslider'),
			'due_to_action' => __(' due to action: ', 'revslider'),
			'layer' => __('layer:', 'revslider'),
			'start_layer_in' => __('Start Layer "in" animation', 'revslider'),
			'start_layer_out' => __('Start Layer "out" animation', 'revslider'),
			'start_video' => __('Start Media', 'revslider'),
			'stop_video' => __('Stop Media', 'revslider'),
			'mute_video' => __('Mute Media', 'revslider'),
			'unmute_video' => __('Unmute Media', 'revslider'),
			'toggle_layer_anim' => __('Toggle Layer Animation', 'revslider'),
			'toggle_video' => __('Toggle Media', 'revslider'),
			'toggle_mute_video' => __('Toggle Mute Media', 'revslider'),
			'toggle_global_mute_video' => __('Toggle Mute All Media', 'revslider'),
			'last_slide' => __('Last Slide', 'revslider'),
			'simulate_click' => __('Simulate Click', 'revslider'),
			'togglefullscreen' => __('Toggle FullScreen', 'revslider'),
			'gofullscreen' => __('Go FullScreen', 'revslider'),
			'exitfullscreen' => __('Exit FullScreen', 'revslider'),
			'toggle_class' => __('Toogle Class', 'revslider'),
			'copy_styles_to_hover_from_idle' => __('Copy hover styles to idle?', 'revslider'),
			'copy_styles_to_idle_from_hover' => __('Copy idle styles to hover?', 'revslider'),
			'select_at_least_one_device_type' => __('Please select at least one device type', 'revslider'),
			'please_select_first_an_existing_style' => __('Please select an existing Style Template', 'revslider'),
			'cant_remove_last_transition' => __('Can not remove last transition!', 'revslider'),
			'name_is_default_animations_cant_be_changed' => __('Given animation name is a default animation. These can not be changed.', 'revslider'),
			'override_animation' => __('Animation exists, override existing animation?', 'revslider'),
			'this_feature_only_if_activated' => __('This feature is only available if you activate Slider Revolution for this installation', 'revslider'),
			'unsaved_data_will_be_lost_proceed' => __('Unsaved data will be lost, proceed?', 'revslider'),
			'is_loading' => __('is Loading...', 'revslider'),
			'google_fonts_loaded' => __('Google Fonts Loaded', 'revslider'),
			'delete_layer' => __('Delete Layer?', 'revslider'),
			'this_template_requires_version' => __('This template requires at least version', 'revslider'),
			'of_slider_revolution' => __('of Slider Revolution to work.', 'revslider'),
			'slider_revolution_shortcode_creator' => __('Slider Revolution Shortcode Creator', 'revslider'),
			'slider_informations_are_missing' => __('Slider informations are missing!', 'revslider'),
			'shortcode_generator' => __('Shortcode Generator', 'revslider'),
			'please_add_at_least_one_layer' => __('Please add at least one Layer.', 'revslider'),
			'choose_image' => __('Choose Image', 'revslider'),
			'shortcode_parsing_successfull' => __('Shortcode parsing successfull. Items can be found in step 3', 'revslider'),
			'shortcode_could_not_be_correctly_parsed' => __('Shortcode could not be parsed.', 'revslider'),
			'background_video' => __('Background Video', 'revslider'),
			'active_video' => __('Video in Active Slide', 'revslider'),
			'empty_data_retrieved_for_slider' => __('Data could not be fetched for selected Slider', 'revslider'),
			'import_selected_layer' => __('Import Selected Layer?', 'revslider'),
			'import_all_layer_from_actions' => __('Layer Imported! The Layer has actions which include other Layers. Import all connected layers?', 'revslider'),
            'not_available_in_demo' => __('Not available in Demo Mode', 'revslider'),
            'leave_not_saved' => __('By leaving now, all changes since the last saving will be lost. Really leave now?', 'revslider'),
            'static_layers' => __('--- Static Layers ---', 'revslider'),
            'objects_only_available_if_activated' => __('Only available if plugin is activated', 'revslider')
		);

		return $lang;
	}

	
	public function addActivateNotification(){
		$nonce = wp_create_nonce("revslider_actions");
		?>
		<div class="updated below-h2 rs-update-notice-wrap" id="message"><a href="javascript:void(0);" style="float: right;padding-top: 9px;" id="rs-dismiss-notice"><?php _e('(never show this message again)&nbsp;&nbsp;<b>X</b>','revslider'); ?></a><p><?php _e('Hi! Would you like to activate your version of Revolution Slider to receive live updates & get premium support? This is optional and not needed if the slider came bundled with a theme. ','revslider'); ?></p></div>
		<script type="text/javascript">
			jQuery('#rs-dismiss-notice').click(function(){
				var objData = {
							action:"revslider_ajax_action",
							client_action: 'dismiss_notice',
							nonce:'<?php echo $nonce; ?>',
							data:''
							};

				jQuery.ajax({
					type:"post",
					url:ajaxurl,
					dataType: 'json',
					data:objData
				});

				jQuery('.rs-update-notice-wrap').hide();
			});
		</script>
		<?php
	}
	
	
	/**
	 * add notices from ThemePunch
	 * @since: 4.6.8
	 */
	public function add_notices(){
		$operations = new RevSliderOperations();
		$general_settings = $operations->getGeneralSettingsValues();
		
		//check permissions here
		if(!current_user_can('administrator')) return true;

		$enable_newschannel = RevSliderBase::getVar($general_settings, 'enable_newschannel', 'on');
		
		$enable_newschannel = apply_filters('revslider_set_notifications', $enable_newschannel);
		
		if($enable_newschannel == 'on'){
			
			$nonce = wp_create_nonce("revslider_actions");
			
			$notices = get_option('revslider-notices', false);
			
			$vn = get_option('revslider-deact-notice', false);
			
			if($vn == true){
				$notices[99999] = new stdClass();
				$notices[99999]->code = 'DISCARD';
				$notices[99999]->version = '99.99';
				$notices[99999]->is_global = false;
				$notices[99999]->color = 'error';
				$notices[99999]->text = '<p>'.__('Hi, your Purchase Code for Slider Revolution has been deregistered manually through <a href="https://www.themepunch.com/purchase-code-deactivation" target="_blank">https://www.themepunch.com/purchase-code-deactivation</a> and is no longer active for this installation.', 'revslider').'</p>';
				$notices[99999]->disable = false;
				$notices[99999]->additional = array();
			}
			
			$tmp = get_option('revslider-temp-active-notice', 'false');
			
			if($tmp == 'true'){
				$notices[99998] = new stdClass();
				$notices[99998]->code = 'DISCARDTEMPACT';
				$notices[99998]->version = '99.99';
				$notices[99998]->is_global = false;
				$notices[99998]->color = 'error';
				$notices[99998]->text = '<p>'.__('Hi, your Purchase Code for Slider Revolution has been deregistered as it was not a valid Slider Revolution Purchase Code', 'revslider').'</p>';
				$notices[99998]->disable = false;
				$notices[99998]->additional = array();
			}
			
			if(!empty($notices) && is_array($notices)){
				global $revslider_screens;
				
				$notices_discarded = get_option('revslider-notices-dc', array());
				
				$screen = get_current_screen();
				foreach($notices as $notice){
					if($notice->is_global !== true && !in_array($screen->id, $revslider_screens)) continue; //check if global or just on plugin related pages
						
					if(!in_array($notice->code, $notices_discarded) && version_compare($notice->version, GlobalsRevSlider::SLIDER_REVISION, '>=')){
						$text = '<div style="text-align:right;vertical-align:middle;display:table-cell; min-width:225px;border-left:1px solid #ddd; padding-left:15px;"><a href="javascript:void(0);"  class="rs-notices-button rs-notice-'. esc_attr($notice->code) .'">'. __('Close & don\'t show again<b>X</b>','revslider') .'</a></div>';
						if($notice->disable == true) $text = '';
						?>
							<style>
						.rs-notices-button			{	color:#999; text-decoration: none !important; font-size:14px;font-weight: 400;}
						.rs-notices-button:hover 	{	color:#3498DB !important;}

						.rs-notices-button b 		{	font-weight:800; vertical-align:bottom;line-height:15px;font-size:10px;margin-left:10px;margin-right:10px;border:2px solid #999; display:inline-block; width:15px;height:15px; text-align: center; border-radius: 50%; -webkit-border-radius: 50%; -moz-border-radius: 50%;}
						.rs-notices-button:hover b  { 	border-color:#3498DB;}
						</style>
						<div class="<?php echo $notice->color; ?> below-h2 rs-update-notice-wrap" id="message" style="clear:both;display: block;position:relative;margin:35px 20px 25px 0px"><div style="display:table;width:100%;"><div style="vertical-align:middle;display:table-cell;min-width:100%;padding-right:15px;"><?php echo $notice->text; ?></div><?php echo $text; ?></div></div>

						<?php
					}
				}
				?>
				<script type="text/javascript">
					jQuery('.rs-notices-button').click(function(){
						
						var notice_id = jQuery(this).attr('class').replace('rs-notices-button', '').replace('rs-notice-', '');
						
						var objData = {
										action:"revslider_ajax_action",
										client_action: 'dismiss_dynamic_notice',
										nonce:'<?php echo $nonce; ?>',
										data:{'id':notice_id}
										};

						jQuery.ajax({
							type:"post",
							url:ajaxurl,
							dataType: 'json',
							data:objData
						});

						jQuery(this).closest('.rs-update-notice-wrap').slideUp(200);
					});
				</script>
				<?php
			}
		}
	}
	
	
	/**
	 *
	 * add wildcards metabox variables to posts
	 */
	private function addSliderMetaBox($postTypes = null){ //null = all, post = only posts
		try{
			self::addMetaBox("Revolution Slider Options",'',array("RevSliderAdmin","customPostFieldsOutput"),$postTypes);
		}catch(Exception $e){}
	}


	/**
	 *  custom output function
	 */
	public static function customPostFieldsOutput(){
		
		$meta = get_post_meta(get_the_ID(), 'slide_template', true);
		if($meta == '') $meta = 'default';
		
		$slider = new RevSlider();
		$arrOutput = array();
		$arrOutput["default"] = "default";

		$arrSlides = $slider->getArrSlidersWithSlidesShort(RevSlider::SLIDER_TYPE_TEMPLATE);
		$arrOutput = $arrOutput + $arrSlides;	//union arrays
		
		?>
		<ul class="revslider_settings">
			<li id="slide_template_row">
				<div title="" class="setting_text" id="slide_template_text"><?php _e('Choose Slide Template', 'revslider'); ?></div>
				<div class="setting_input">
					<select name="slide_template" id="slide_template">
						<?php
						foreach($arrOutput as $handle => $name){
							echo '<option '.selected($handle, $meta).' value="'.$handle.'">'.$name.'</option>';
						}
						?>
					</select>
				</div>
				<div class="clear"></div>
			</li>
		</ul>
		<?php
	}


	/**
	 * a must function. please don't remove it.
	 * process activate event - install the db (with delta).
	 */
	public static function onActivate(){
		RevSliderFront::createDBTables();
	}


	/**
	 * a must function. adds scripts on the page
	 * add all page scripts and styles here.
	 * pelase don't remove this function
	 * common scripts even if the plugin not load, use this function only if no choise.
	 */
	public static function onAddScripts(){
		global $wp_version;
		
		$style_pre = '';
		$style_post = '';
		if($wp_version < 3.7){
			$style_pre = '<style type="text/css">';
			$style_post = '</style>';
		}
		
		wp_enqueue_style('edit_layers', RS_PLUGIN_URL .'admin/assets/css/edit_layers.css', array(), RevSliderGlobals::SLIDER_REVISION);
		
		wp_enqueue_script('unite_layers_timeline', RS_PLUGIN_URL .'admin/assets/js/edit_layers_timeline.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('unite_context_menu', RS_PLUGIN_URL .'admin/assets/js/context_menu.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('unite_layers', RS_PLUGIN_URL .'admin/assets/js/edit_layers.js', array('jquery-ui-mouse'), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('unite_css_editor', RS_PLUGIN_URL .'admin/assets/js/css_editor.js', array(), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('rev_admin', RS_PLUGIN_URL .'admin/assets/js/rev_admin.js', array(), RevSliderGlobals::SLIDER_REVISION );
		
		wp_enqueue_script('tp-tools', RS_PLUGIN_URL .'public/assets/js/jquery.themepunch.tools.min.js', array(), RevSliderGlobals::SLIDER_REVISION );

		//include all media upload scripts
		self::addMediaUploadIncludes();

		//add rs css:
		wp_enqueue_style('rs-plugin-settings', RS_PLUGIN_URL .'public/assets/css/settings.css', array(), RevSliderGlobals::SLIDER_REVISION);
		
		//add icon sets
		wp_enqueue_style('rs-icon-set-fa-icon-', RS_PLUGIN_URL .'public/assets/fonts/font-awesome/css/font-awesome.css', array(), RevSliderGlobals::SLIDER_REVISION);
		wp_enqueue_style('rs-icon-set-pe-7s-', RS_PLUGIN_URL .'public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css', array(), RevSliderGlobals::SLIDER_REVISION);
		
		add_filter('revslider_mod_icon_sets', array('RevSliderBase', 'set_icon_sets'));
		
		$db = new RevSliderDB();

		$styles = $db->fetch(RevSliderGlobals::$table_css);
		$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
		$styles = RevSliderCssParser::compress_css($styles);
		wp_add_inline_style( 'rs-plugin-settings', $style_pre.$styles.$style_post );

		$custom_css = RevSliderOperations::getStaticCss();
		$custom_css = RevSliderCssParser::compress_css($custom_css);
		wp_add_inline_style( 'rs-plugin-settings', $style_pre.$custom_css.$style_post );
		
	}


	/**
	 *
	 * admin main page function.
	 */
	public static function adminPages(){

		parent::adminPages();

		self::setMasterView('master-view');
		self::requireView(self::$view);
		
	}
	

	/**
	 *
	 * import slideer handle (not ajax response)
	 */
	private static function importSliderHandle($viewBack = null, $updateAnim = true, $updateStatic = true, $updateNavigation = true){

		dmp(__("importing slider settings and data...",'revslider'));

		$slider = new RevSlider();
		$response = $slider->importSliderFromPost($updateAnim, $updateStatic, false, false, false, $updateNavigation);
		
		$sliderID = intval($response["sliderID"]);

		if(empty($viewBack)){
			$viewBack = self::getViewUrl(self::VIEW_SLIDER,"id=".$sliderID);
			if(empty($sliderID))
				$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
		}
		
		//handle error
		if($response["success"] == false){
			$message = $response["error"];
			dmp("<b>Error: ".$message."</b>");
			echo RevSliderFunctions::getHtmlLink($viewBack, __("Go Back",'revslider'));
		}
		else{	//handle success, js redirect.
			//check here to create a page or not
			if(!empty($sliderID)){
				$page_id = 0;
				$page_creation = esc_attr(RevSliderFunctions::getPostVariable('page-creation'));
				if($page_creation === 'true'){
					$operations = new RevSliderOperations();
					$page_id = $operations->create_slider_page((array)$sliderID);
				}
				if($page_id > 0){
					echo '<script>window.open("'.get_permalink($page_id).'", "_blank");</script>';
				}
			}
			dmp(__('Slider Import Success, redirecting in 3 seconds...','revslider'));
			echo "<script>
			setTimeout(function () {
				location.href='".$viewBack."'
			}, 3000);
			</script>";
		}
		exit();
	}
	
	
	/**
	 * import slider from TP servers
	 * @since: 5.0.5
	 */
	private static function importSliderOnlineTemplateHandle($viewBack = null, $updateAnim = true, $updateStatic = true, $single_slide = false){
		dmp(__("downloading template slider from server...", 'revslider'));
		
		$uid = esc_attr(RevSliderFunctions::getPostVariable('uid'));
		
		$added = array();
		
		if($uid == ''){
			dmp(__("ID missing, something went wrong. Please try again!", 'revslider'));
			echo RevSliderFunctions::getHtmlLink($viewBack, __("Go Back",'revslider'));
			exit;
		}else{
			$tmp = new RevSliderTemplate();
			
			$package = esc_attr(RevSliderFunctions::getPostVariable('package'));
			$package = ($package == 'true') ? true : false;
			
			//get all in the same package as the uid
			if($package === true){
				$uids = $tmp->get_package_uids($uid);
			}else{
				$uids = (array)$uid;
			}
			
			if(!empty($uids)){
				foreach($uids as $uid){
					set_time_limit(60); //reset the time limit
			
					$filepath = $tmp->_download_template($uid); //can be single or multiple, depending on $package beeing false or true
					
					//send request to TP server and download file
					if(is_array($filepath) && isset($filepath['error'])){
						dmp($filepath['error']);
						echo RevSliderFunctions::getHtmlLink($viewBack, __("Go Back",'revslider'));
						exit;
					}
					
					if($filepath !== false){
						//check if Slider Template was already imported. If yes, remove the old Slider Template as we now do an "update" (in reality we delete and insert again)
						//get all template sliders
						$tmp_slider = $tmp->getThemePunchTemplateSliders();
						
						foreach($tmp_slider as $tslider){
							if(isset($tslider['uid']) && $uid == $tslider['uid']){
								if(!isset($tslider['installed'])){ //slider is installed
									//delete template Slider!
									$mSlider = new RevSlider();
									$mSlider->initByID($tslider['id']);
									
									$mSlider->deleteSlider();
									//remove the update flag from the slider
									
									$tmp->remove_is_new($uid);
								}
								break;
							}
						}
						
						
						$slider = new RevSlider();
						$response = $slider->importSliderFromPost($updateAnim, $updateStatic, $filepath, $uid, $single_slide);
						
						$tmp->_delete_template($uid);
						
						if($single_slide === false){
							if(empty($viewBack)){
								$sliderID = $response["sliderID"];
								$viewBack = self::getViewUrl(self::VIEW_SLIDER,"id=".$sliderID);
								if(empty($sliderID))
									$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
							}
						}
						
						if(isset($response["sliderID"])){
							$added[] = $response["sliderID"];
						}
						//handle error
						if($response["success"] == false){
							$message = $response["error"];
							dmp("<b>Error: ".$message."</b>");
							echo RevSliderFunctions::getHtmlLink($viewBack, __("Go Back",'revslider'));
						}else{	//handle success, js redirect.
							if(count($uids) > 1){
								dmp(__("Slider Import Success", 'revslider'));
							}else{
								dmp(__("Slider Import Success, redirecting in 3 seconds...",'revslider'));
							}
						}
						
					}else{
						if(is_array($filepath)){
							dmp($filepath['error']);
						}else{
							dmp(__("Could not download from server. Please try again later!", 'revslider'));
						}
						echo RevSliderFunctions::getHtmlLink($viewBack, __("Go Back",'revslider'));
						exit;
					}
				}
				
				//check here to create a page or not
				if(!empty($added)){
					$page_creation = esc_attr(RevSliderFunctions::getPostVariable('page-creation'));
					if($page_creation === 'true'){
						$operations = new RevSliderOperations();
						$page_id = $operations->create_slider_page($added);
					}
					if($page_id > 0){
						echo '<script>window.open("'.get_permalink($page_id).'", "_blank");</script>';
					}
				}
				
				echo "<script>
				setTimeout(function () {
					location.href='".$viewBack."'
				}, 3000);
				</script>";
			}else{
				dmp(__("Could not download package. Please try again later!", 'revslider'));
				exit;
			}
		}
		
		exit;
	}
	
	
	/**
	 *
	 * import slider handle (not ajax response)
	 */
	private static function importSliderTemplateHandle($viewBack = null, $updateAnim = true, $updateStatic = true, $single_slide = false){
		
		dmp(__("importing template slider settings and data...", 'revslider'));
		
		$uid = esc_attr(RevSliderFunctions::getPostVariable('uid'));
		if($uid == ''){
			dmp(__("ID missing, something went wrong. Please try again!", 'revslider'));
			echo RevSliderFunctions::getHtmlLink($viewBack, __("Go Back",'revslider'));
			exit;
		}
		
		//check if the filename is correct
		//import to templates, then duplicate Slider
		
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost($updateAnim, $updateStatic, false, $uid, $single_slide);
		
		if($single_slide === false){
			$sliderID = $response["sliderID"];
			if(empty($viewBack)){
				$viewBack = self::getViewUrl(self::VIEW_SLIDER,"id=".$sliderID);
				if(empty($sliderID))
					$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
			}
		}

		//handle error
		if($response["success"] == false){
			$message = $response["error"];
			dmp("<b>Error: ".$message."</b>");
			echo RevSliderFunctions::getHtmlLink($viewBack, __("Go Back",'revslider'));
		}else{	//handle success, js redirect.
			//check here to create a page or not
			if(isset($sliderID) && !empty($sliderID)){
				$page_creation = esc_attr(RevSliderFunctions::getPostVariable('page-creation'));
				if($page_creation === 'true'){
					$operations = new RevSliderOperations();
					$page_id = $operations->create_slider_page((array)$sliderID);
				}
				if($page_id > 0){
					echo '<script>window.open("'.get_permalink($page_id).'", "_blank");</script>';
				}
			}
			
			dmp(__("Slider Import Success, redirecting in 3 seconds...",'revslider'));
			echo "<script>
			setTimeout(function () {
				location.href='".$viewBack."'
			}, 3000);
			</script>";
		}
		
		exit();
	}

	/**
	 * Get url to secific view.
	 */
	public static function getFontsUrl(){

		$link = admin_url('admin.php?page=themepunch-google-fonts');
		return($link);
	}
	
	
	/**
	 * Toggle Favorite State of Slider
	 * @since: 5.0
	 */
	public static function toggle_favorite_by_id($id){
		$id = intval($id);
		if($id === 0) return false;
		
		global $wpdb;
		
		$table_name = $wpdb->prefix . RevSliderGlobals::TABLE_SLIDERS_NAME;
		
		//check if ID exists
		$slider = $wpdb->get_row($wpdb->prepare("SELECT settings FROM $table_name WHERE id = %s", $id), ARRAY_A);
		
		if(empty($slider))
			return __('Slider not found', 'revslider');
			
		$settings = json_decode($slider['settings'], true);
		
		if(!isset($settings['favorite']) || $settings['favorite'] == 'false' || $settings['favorite'] == false){
			$settings['favorite'] = 'true';
		}else{
			$settings['favorite'] = 'false';
		}
		
		$response = $wpdb->update($table_name, array('settings' => json_encode($settings)), array('id' => $id));
		
		if($response === false) return __('Slider setting could not be changed', 'revslider');
		
		return true;
	}

	/**
	 *
	 * onAjax action handler
	 */
	public static function onAjaxAction(){
		
		$role = self::getMenuRole(); //add additional security check and allow for example import only for admin
		
		$slider = new RevSlider();
		$slide = new RevSlide();
		$operations = new RevSliderOperations();

		$action = self::getPostGetVar("client_action");
		$data = self::getPostGetVar("data");
		$nonce = self::getPostGetVar("nonce");
		if(empty($nonce))
			$nonce = self::getPostGetVar("rs-nonce");
		
		try{
			
			if(RS_DEMO){
				switch($action){
					case 'import_slider_online_template_slidersview':
					case 'duplicate_slider':
					case 'preview_slider':
					case 'get_static_css':
					case 'get_dynamic_css':
					case 'preview_slide':
						//these are all okay in demo mode
					break;
					default:
						RevSliderFunctions::throwError(__('Function Not Available in Demo Mode', 'revslider'));
						exit;
					break;
				}
			}
			
			if(!RevSliderFunctionsWP::isAdminUser() && apply_filters('revslider_restrict_role', true)){
				switch($action){
					case 'change_specific_navigation':
					case 'change_navigations':
					case 'update_static_css':
					case 'add_new_preset':
					case 'update_preset':
					case 'import_slider':
					case 'import_slider_slidersview':
					case 'import_slider_template_slidersview':
					case 'import_slide_template_slidersview':
					case 'fix_database_issues':
						RevSliderFunctions::throwError(__('Function Only Available for Adminstrators', 'revslider'));
						exit;
					break;
					default:
						$return = apply_filters('revslider_admin_onAjaxAction_user_restriction', true, $action, $data, $slider, $slide, $operations);
						if($return !== true){
							RevSliderFunctions::throwError(__('Function Only Available for Adminstrators', 'revslider'));
							exit;
						}
					break;
				}
			}
			
			//verify the nonce
			$isVerified = wp_verify_nonce($nonce, "revslider_actions");

			if($isVerified == false)
				RevSliderFunctions::throwError("Wrong request");

			switch($action){
				case 'add_new_preset':
					
					if(!isset($data['settings']) || !isset($data['values'])) self::ajaxResponseError(__('Missing values to add preset', 'revslider'), false);
					
					$result = $operations->add_preset_setting($data);
					
					if($result === true){
						
						$presets = $operations->get_preset_settings();
						
						self::ajaxResponseSuccess(__('Preset created', 'revslider'), array('data' => $presets));
					}else{
						self::ajaxResponseError($result, false);
					}
					
					exit;
				break;
				case 'update_preset':
					
					if(!isset($data['name']) || !isset($data['values'])) self::ajaxResponseError(__('Missing values to update preset', 'revslider'), false);
					
					$result = $operations->update_preset_setting($data);
					
					if($result === true){
						
						$presets = $operations->get_preset_settings();
						
						self::ajaxResponseSuccess(__('Preset created', 'revslider'), array('data' => $presets));
					}else{
						self::ajaxResponseError($result, false);
					}
					
					exit;
				break;
				case 'remove_preset':
					
					if(!isset($data['name'])) self::ajaxResponseError(__('Missing values to remove preset', 'revslider'), false);
					
					$result = $operations->remove_preset_setting($data);
					
					if($result === true){
						
						$presets = $operations->get_preset_settings();
						
						self::ajaxResponseSuccess(__('Preset deleted', 'revslider'), array('data' => $presets));
					}else{
						self::ajaxResponseError($result, false);
					}
					
					exit;
				break;
				case "export_slider":
					$sliderID = self::getGetVar("sliderid");
					$dummy = self::getGetVar("dummy");
					$slider->initByID($sliderID);
					$slider->exportSlider($dummy);
				break;
				case "import_slider":
					$updateAnim = self::getPostGetVar("update_animations");
					$updateNav = self::getPostGetVar("update_navigations");
					$updateStatic = self::getPostGetVar("update_static_captions");
					self::importSliderHandle(null, $updateAnim, $updateStatic, $updateNav);
				break;
				case "import_slider_slidersview":
					$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
					$updateAnim = self::getPostGetVar("update_animations");
					$updateNav = self::getPostGetVar("update_navigations");
					$updateStatic = self::getPostGetVar("update_static_captions");
					self::importSliderHandle($viewBack, $updateAnim, $updateStatic, $updateNav);
				break;
				case "import_slider_online_template_slidersview":
					$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
					self::importSliderOnlineTemplateHandle($viewBack, 'true', 'none');
				break;
				case "import_slide_online_template_slidersview":
					$redirect_id = esc_attr(self::getPostGetVar("redirect_id"));
					$viewBack = self::getViewUrl(self::VIEW_SLIDE,"id=$redirect_id");
					$slidenum = intval(self::getPostGetVar("slidenum"));
					$sliderid = intval(self::getPostGetVar("slider_id"));
					
					self::importSliderOnlineTemplateHandle($viewBack, 'true', 'none', array('slider_id' => $sliderid, 'slide_id' => $slidenum));
				break;
				case "import_slider_template_slidersview":
					$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
					$updateAnim = self::getPostGetVar("update_animations");
					$updateStatic = self::getPostGetVar("update_static_captions");
					self::importSliderTemplateHandle($viewBack, $updateAnim, $updateStatic);
				break;
				case "import_slide_template_slidersview":
					
					$redirect_id = esc_attr(self::getPostGetVar("redirect_id"));
					$viewBack = self::getViewUrl(self::VIEW_SLIDE,"id=$redirect_id");
					$updateAnim = self::getPostGetVar("update_animations");
					$updateStatic = self::getPostGetVar("update_static_captions");
					$slidenum = intval(self::getPostGetVar("slidenum"));
					$sliderid = intval(self::getPostGetVar("slider_id"));
					
					self::importSliderTemplateHandle($viewBack, $updateAnim, $updateStatic, array('slider_id' => $sliderid, 'slide_id' => $slidenum));
				break;
				case "create_slider":
					$data = $operations->modifyCustomSliderParams($data);
					$newSliderID = $slider->createSliderFromOptions($data);
					self::ajaxResponseSuccessRedirect(__("Slider created",'revslider'), self::getViewUrl(self::VIEW_SLIDE, 'id=new&slider='.esc_attr($newSliderID))); //redirect to slide now

				break;
				case "update_slider":
					$data = $operations->modifyCustomSliderParams($data);
					$slider->updateSliderFromOptions($data);
					self::ajaxResponseSuccess(__("Slider updated",'revslider'));
				break;
				case "delete_slider":
				case "delete_slider_stay":

					$isDeleted = $slider->deleteSliderFromData($data);

					if(is_array($isDeleted)){
						$isDeleted = implode(', ', $isDeleted);
						self::ajaxResponseError(__("Template can't be deleted, it is still being used by the following Sliders: ", 'revslider').$isDeleted);
					}else{
						if($action == 'delete_slider_stay'){
							self::ajaxResponseSuccess(__("Slider deleted",'revslider'));
						}else{
							self::ajaxResponseSuccessRedirect(__("Slider deleted",'revslider'), self::getViewUrl(self::VIEW_SLIDERS));
						}
					}
				break;
				case "duplicate_slider":

					$slider->duplicateSliderFromData($data);

					self::ajaxResponseSuccessRedirect(__("Success! Refreshing page...",'revslider'), self::getViewUrl(self::VIEW_SLIDERS));
				break;
				case "duplicate_slider_package":

					$ret = $slider->duplicateSliderPackageFromData($data);
					
					if($ret !== true){
						RevSliderFunctions::throwError($ret);
					}else{
						self::ajaxResponseSuccessRedirect(__("Success! Refreshing page...",'revslider'), self::getViewUrl(self::VIEW_SLIDERS));
					}
				break;
				case "add_slide":
				case "add_bulk_slide":
					$numSlides = $slider->createSlideFromData($data);
					$sliderID = $data["sliderid"];

					if($numSlides == 1){
						$responseText = __("Slide Created",'revslider');
					}else{
						$responseText = $numSlides . " ".__("Slides Created",'revslider');
					}

					$urlRedirect = self::getViewUrl(self::VIEW_SLIDE,"id=new&slider=$sliderID");
					self::ajaxResponseSuccessRedirect($responseText,$urlRedirect);

				break;
				case "add_slide_fromslideview":
					$slideID = $slider->createSlideFromData($data,true);
					$urlRedirect = self::getViewUrl(self::VIEW_SLIDE,"id=$slideID");
					$responseText = __("Slide Created, redirecting...",'revslider');
					self::ajaxResponseSuccessRedirect($responseText,$urlRedirect);
				break;
				case 'copy_slide_to_slider':
					$slideID = (isset($data['redirect_id'])) ? $data['redirect_id'] : -1;
					
					if($slideID === -1) RevSliderFunctions::throwError(__('Missing redirect ID!', 'revslider'));
					
					$return = $slider->copySlideToSlider($data);
					
					if($return !== true) RevSliderFunctions::throwError($return);
					
					$urlRedirect = self::getViewUrl(self::VIEW_SLIDE,"id=$slideID");
					$responseText = __("Slide copied to current Slider, redirecting...",'revslider');
					self::ajaxResponseSuccessRedirect($responseText,$urlRedirect);
				break;
				case 'update_slide':
					if(isset($data['obj_favorites'])){
						$obj_favorites = $data['obj_favorites'];
						unset($data['obj_favorites']);
						//save object favourites
						$objlib = new RevSliderObjectLibrary();
						$objlib->save_favorites($obj_favorites);
					}
					$slide->updateSlideFromData($data);
					self::ajaxResponseSuccess(__("Slide updated",'revslider'));
				break;
				case "update_static_slide":
					if(isset($data['obj_favorites'])){
						$obj_favorites = $data['obj_favorites'];
						unset($data['obj_favorites']);
						//save object favourites
						$objlib = new RevSliderObjectLibrary();
						$objlib->save_favorites($obj_favorites);
					}
					$slide->updateStaticSlideFromData($data);
					self::ajaxResponseSuccess(__("Static Global Layers updated",'revslider'));
				break;
				case "delete_slide":
				case "delete_slide_stay":
					$isPost = $slide->deleteSlideFromData($data);
					if($isPost)
						$message = __("Post deleted",'revslider');
					else
						$message = __("Slide deleted",'revslider');

					$sliderID = RevSliderFunctions::getVal($data, "sliderID");
					if($action == 'delete_slide_stay'){
						self::ajaxResponseSuccess($message);
					}else{
						self::ajaxResponseSuccessRedirect($message, self::getViewUrl(self::VIEW_SLIDE,"id=new&slider=$sliderID"));
					}
				break;
				case "duplicate_slide":
				case "duplicate_slide_stay":
					$return = $slider->duplicateSlideFromData($data);
					if($action == 'duplicate_slide_stay'){
						self::ajaxResponseSuccess(__("Slide duplicated",'revslider'), array('id' => $return[1]));
					}else{
						self::ajaxResponseSuccessRedirect(__("Slide duplicated",'revslider'), self::getViewUrl(self::VIEW_SLIDE,"id=new&slider=".$return[0]));
					}
				break;
				case "copy_move_slide":
				case "copy_move_slide_stay":
					$sliderID = $slider->copyMoveSlideFromData($data);
					if($action == 'copy_move_slide_stay'){
						self::ajaxResponseSuccess(__("Success!",'revslider'));
					}else{
						self::ajaxResponseSuccessRedirect(__("Success! Refreshing page...",'revslider'), self::getViewUrl(self::VIEW_SLIDE,"id=new&slider=$sliderID"));
					}
				break;
				case "add_slide_to_template":
					$template = new RevSliderTemplate();
					if(!isset($data['slideID']) || intval($data['slideID']) == 0){
						RevSliderFunctions::throwError(__('No valid Slide ID given', 'revslider'));
						exit;
					}
					if(!isset($data['title']) || strlen(trim($data['title'])) < 3){
						RevSliderFunctions::throwError(__('No valid title given', 'revslider'));
						exit;
					}
					if(!isset($data['settings']) || !isset($data['settings']['width']) || !isset($data['settings']['height'])){
						RevSliderFunctions::throwError(__('No valid title given', 'revslider'));
						exit;
					}
					
					$return = $template->copySlideToTemplates($data['slideID'], $data['title'], $data['settings']);
					
					if($return == false){
						RevSliderFunctions::throwError(__('Could not save Slide as Template', 'revslider'));
						exit;
					}
					
					//get HTML for template section
					ob_start();
					
					$rs_disable_template_script = true; //disable the script output of template selector file
					
					include(RS_PLUGIN_PATH.'admin/views/templates/template-selector.php');
					
					$html = ob_get_contents();
					
					ob_clean();
					ob_end_clean();
					
					self::ajaxResponseSuccess(__('Slide added to Templates', 'revslider'),array('HTML' => $html));
					exit;
				break;
				break;
				case "get_static_css":
					$contentCSS = $operations->getStaticCss();
					self::ajaxResponseData($contentCSS);
				break;
				case "get_dynamic_css":
					$contentCSS = $operations->getDynamicCss();
					self::ajaxResponseData($contentCSS);
				break;
				case "insert_captions_css":
					
					$arrCaptions = $operations->insertCaptionsContentData($data);
					
					if($arrCaptions !== false){
						$db = new RevSliderDB();
						$styles = $db->fetch(RevSliderGlobals::$table_css);
						$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
						$styles = RevSliderCssParser::compress_css($styles);
						$custom_css = RevSliderOperations::getStaticCss();
						$custom_css = RevSliderCssParser::compress_css($custom_css);
						
						$arrCSS = $operations->getCaptionsContentArray();
						$arrCssStyles = RevSliderFunctions::jsonEncodeForClientSide($arrCSS);
						$arrCssStyles = $arrCSS;
						
						self::ajaxResponseSuccess(__("CSS saved",'revslider'),array("arrCaptions"=>$arrCaptions,'compressed_css'=>$styles.$custom_css,'initstyles'=>$arrCssStyles));
					}
					
					RevSliderFunctions::throwError(__('CSS could not be saved', 'revslider'));
					exit();
				break;
				case "update_captions_css":
					
					$arrCaptions = $operations->updateCaptionsContentData($data);
					
					if($arrCaptions !== false){
						$db = new RevSliderDB();
						$styles = $db->fetch(RevSliderGlobals::$table_css);
						$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
						$styles = RevSliderCssParser::compress_css($styles);
						$custom_css = RevSliderOperations::getStaticCss();
						$custom_css = RevSliderCssParser::compress_css($custom_css);
						
						$arrCSS = $operations->getCaptionsContentArray();
						$arrCssStyles = RevSliderFunctions::jsonEncodeForClientSide($arrCSS);
						$arrCssStyles = $arrCSS;
						
						self::ajaxResponseSuccess(__("CSS saved",'revslider'),array("arrCaptions"=>$arrCaptions,'compressed_css'=>$styles.$custom_css,'initstyles'=>$arrCssStyles));
					}
					
					RevSliderFunctions::throwError(__('CSS could not be saved', 'revslider'));
					exit();
				break;
				case "update_captions_advanced_css":
					
					$arrCaptions = $operations->updateAdvancedCssData($data);
					if($arrCaptions !== false){
						$db = new RevSliderDB();
						$styles = $db->fetch(RevSliderGlobals::$table_css);
						$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
						$styles = RevSliderCssParser::compress_css($styles);
						$custom_css = RevSliderOperations::getStaticCss();
						$custom_css = RevSliderCssParser::compress_css($custom_css);
						
						$arrCSS = $operations->getCaptionsContentArray();
						$arrCssStyles = RevSliderFunctions::jsonEncodeForClientSide($arrCSS);
						$arrCssStyles = $arrCSS;
						
						self::ajaxResponseSuccess(__("CSS saved",'revslider'),array("arrCaptions"=>$arrCaptions,'compressed_css'=>$styles.$custom_css,'initstyles'=>$arrCssStyles));
					}
					
					RevSliderFunctions::throwError(__('CSS could not be saved', 'revslider'));
					exit();
				break;
				case "rename_captions_css":
					//rename all captions in all sliders with new handle if success
					$arrCaptions = $operations->renameCaption($data);
					
					$db = new RevSliderDB();
					$styles = $db->fetch(RevSliderGlobals::$table_css);
					$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
					$styles = RevSliderCssParser::compress_css($styles);
					$custom_css = RevSliderOperations::getStaticCss();
					$custom_css = RevSliderCssParser::compress_css($custom_css);
					
					$arrCSS = $operations->getCaptionsContentArray();
					$arrCssStyles = RevSliderFunctions::jsonEncodeForClientSide($arrCSS);
					$arrCssStyles = $arrCSS;
					
					self::ajaxResponseSuccess(__("Class name renamed",'revslider'),array("arrCaptions"=>$arrCaptions,'compressed_css'=>$styles.$custom_css,'initstyles'=>$arrCssStyles));
				break;
				case "delete_captions_css":
					$arrCaptions = $operations->deleteCaptionsContentData($data);
					
					$db = new RevSliderDB();
					$styles = $db->fetch(RevSliderGlobals::$table_css);
					$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
					$styles = RevSliderCssParser::compress_css($styles);
					$custom_css = RevSliderOperations::getStaticCss();
					$custom_css = RevSliderCssParser::compress_css($custom_css);
					
					$arrCSS = $operations->getCaptionsContentArray();
					$arrCssStyles = RevSliderFunctions::jsonEncodeForClientSide($arrCSS);
					$arrCssStyles = $arrCSS;
					
					self::ajaxResponseSuccess(__("Style deleted!",'revslider'),array("arrCaptions"=>$arrCaptions,'compressed_css'=>$styles.$custom_css,'initstyles'=>$arrCssStyles));
				break;
				case "update_static_css":
					$staticCss = $operations->updateStaticCss($data);
					
					$db = new RevSliderDB();
					$styles = $db->fetch(RevSliderGlobals::$table_css);
					$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
					$styles = RevSliderCssParser::compress_css($styles);
					$custom_css = RevSliderOperations::getStaticCss();
					$custom_css = RevSliderCssParser::compress_css($custom_css);
					
					self::ajaxResponseSuccess(__("CSS saved",'revslider'),array("css"=>$staticCss,'compressed_css'=>$styles.$custom_css));
				break;
				case "insert_custom_anim":
					$arrAnims = $operations->insertCustomAnim($data); //$arrCaptions =
					self::ajaxResponseSuccess(__("Animation saved",'revslider'), $arrAnims); //,array("arrCaptions"=>$arrCaptions)
				break;
				case "update_custom_anim":
					$arrAnims = $operations->updateCustomAnim($data);
					self::ajaxResponseSuccess(__("Animation saved",'revslider'), $arrAnims); //,array("arrCaptions"=>$arrCaptions)
				break;
				case "update_custom_anim_name":
					$arrAnims = $operations->updateCustomAnimName($data);
					self::ajaxResponseSuccess(__("Animation saved",'revslider'), $arrAnims); //,array("arrCaptions"=>$arrCaptions)
				break;
				case "delete_custom_anim":
					$arrAnims = $operations->deleteCustomAnim($data);
					self::ajaxResponseSuccess(__("Animation deleted",'revslider'), $arrAnims); //,array("arrCaptions"=>$arrCaptions)
				break;
				case "update_slides_order":
					$slider->updateSlidesOrderFromData($data);
					self::ajaxResponseSuccess(__("Order updated",'revslider'));
				break;
				case "change_slide_title":
					$slide->updateTitleByID($data);
					self::ajaxResponseSuccess(__('Title updated','revslider'));
				break;
				case "change_slide_image":
					$slide->updateSlideImageFromData($data);
					$sliderID = RevSliderFunctions::getVal($data, "slider_id");
					self::ajaxResponseSuccessRedirect(__("Slide changed",'revslider'), self::getViewUrl(self::VIEW_SLIDE,"id=new&slider=$sliderID"));
				break;
				case "preview_slide":
					$operations->putSlidePreviewByData($data);
					exit;
				break;
				case "preview_slider":
					$sliderID = RevSliderFunctions::getPostGetVariable("sliderid");
					$do_markup = RevSliderFunctions::getPostGetVariable("only_markup");

					if($do_markup == 'true')
						$operations->previewOutputMarkup($sliderID);
					else
						$operations->previewOutput($sliderID);
					
					exit;
				break;
				case "get_import_slides_data":
					$slides = array();
					if(!is_array($data)){
						$slider->initByID(intval($data));
						
						$full_slides = $slider->getSlides(); //static slide is missing
						
						if(!empty($full_slides)){
							foreach($full_slides as $slide_id => $mslide){
								$slides[$slide_id]['layers'] = $mslide->getLayers();
								foreach($slides[$slide_id]['layers'] as $k => $l){ //remove columns as they can not be imported
									if(isset($l['type']) && ($l['type'] == 'column' || $l['type'] == 'row' || $l['type'] == 'group')) unset($slides[$slide_id]['layers'][$k]);
								}
								$slides[$slide_id]['params'] = $mslide->getParams();
							}
						}
						
						$staticID = $slide->getStaticSlideID($slider->getID());
						if($staticID !== false){
							$msl = new RevSliderSlide();
							if(strpos($staticID, 'static_') === false){
								$staticID = 'static_'.$slider->getID();
							}
							$msl->initByID($staticID);
							if($msl->getID() !== ''){
								$slides[$msl->getID()]['layers'] = $msl->getLayers();
								foreach($slides[$msl->getID()]['layers'] as $k => $l){ //remove columns as they can not be imported
									if(isset($l['type']) && ($l['type'] == 'column' || $l['type'] == 'row' || $l['type'] == 'group')) unset($slides[$msl->getID()]['layers'][$k]);
								}
								$slides[$msl->getID()]['params'] = $msl->getParams();
								$slides[$msl->getID()]['params']['title'] = __('Static Slide', 'revslider');
							}
						}
					}
					if(!empty($slides)){
						self::ajaxResponseData(array('slides' => $slides));
					}else{
						self::ajaxResponseData('');
					}
				break;
				case "create_navigation_preset":
					$nav = new RevSliderNavigation();
					
					$return = $nav->add_preset($data);
					
					if($return === true){
						self::ajaxResponseSuccess(__('Navigation preset saved/updated', 'revslider'), array('navs' => $nav->get_all_navigations()));
					}else{
						if($return === false) $return = __('Preset could not be saved/values are the same', 'revslider');
						self::ajaxResponseError($return);
					}
				break;
				case "delete_navigation_preset":
					$nav = new RevSliderNavigation();
					
					$return = $nav->delete_preset($data);
					
					if($return){
						self::ajaxResponseSuccess(__('Navigation preset deleted', 'revslider'), array('navs' => $nav->get_all_navigations()));
					}else{
						if($return === false) $return = __('Preset not found', 'revslider');
						self::ajaxResponseError($return);
					}
				break;
				case "toggle_slide_state":
					$currentState = $slide->toggleSlideStatFromData($data);
					self::ajaxResponseData(array("state"=>$currentState));
				break;
				case "toggle_hero_slide":
					$currentHero = $slider->setHeroSlide($data);
					self::ajaxResponseSuccess(__('Slide is now the new active Hero Slide', 'revslider'));
				break;
				case "slide_lang_operation":
					$responseData = $slide->doSlideLangOperation($data);
					self::ajaxResponseData($responseData);
				break;
				case "update_general_settings":
					$operations->updateGeneralSettings($data);
					self::ajaxResponseSuccess(__("General settings updated",'revslider'));
				break;
				case "fix_database_issues":
					update_option('revslider_change_database', true);
					RevSliderFront::createDBTables();
					
					self::ajaxResponseSuccess(__('Database structure creation/update done','revslider'));
				break;
				case "update_posts_sortby":
					$slider->updatePostsSortbyFromData($data);
					self::ajaxResponseSuccess(__("Sortby updated",'revslider'));
				break;
				case "replace_image_urls":
					$slider->replaceImageUrlsFromData($data);
					self::ajaxResponseSuccess(__("All Urls replaced",'revslider'));
				break;
				case "reset_slide_settings":
					$slider->resetSlideSettings($data);
					self::ajaxResponseSuccess(__("Settings in all Slides changed",'revslider'));
				break;
				case "activate_purchase_code":
					$result = false;
					if(!empty($data['code'])){ // && !empty($data['email'])
						$result = $operations->checkPurchaseVerification($data);
					}else{
						RevSliderFunctions::throwError(__('The Purchase Code and the E-Mail address need to be set!', 'revslider'));
						exit();
					}

					if($result === true){
						self::ajaxResponseSuccessRedirect(__("Purchase Code Successfully Activated",'revslider'), self::getViewUrl(self::VIEW_SLIDERS));
					}elseif($result === false){
						RevSliderFunctions::throwError(__('Purchase Code is invalid', 'revslider'));
					}else{
						if($result == 'temp'){
							self::ajaxResponseSuccessRedirect(__("Purchase Code Temporary Activated",'revslider'), self::getViewUrl(self::VIEW_SLIDERS));
						}
						if($result == 'exist'){
							self::ajaxResponseData(array('error'=>$result,'msg'=> __('Purchase Code already registered!', 'revslider')));
						}
						/*elseif($result == 'bad_email'){
							RevSliderFunctions::throwError(__('Please add an valid E-Mail Address', 'revslider'));
						}elseif($result == 'email_used'){
							RevSliderFunctions::throwError(__('E-Mail already in use, please choose a different E-Mail', 'revslider'));
						}*/
						RevSliderFunctions::throwError(__('Purchase Code could not be validated', 'revslider'));
					}
				break;
				case "deactivate_purchase_code":
					$result = $operations->doPurchaseDeactivation($data);

					if($result){
						self::ajaxResponseSuccessRedirect(__("Successfully removed validation",'revslider'), self::getViewUrl(self::VIEW_SLIDERS));
					}else{
						RevSliderFunctions::throwError(__('Could not remove Validation!', 'revslider'));
					}
				break;
				case 'dismiss_notice':
					update_option('revslider-valid-notice', 'false');
					self::ajaxResponseSuccess(__(".",'revslider'));
				break;
				case 'dismiss_dynamic_notice':
					if(trim($data['id']) == 'DISCARD'){
						update_option('revslider-deact-notice', false);
					}elseif(trim($data['id']) == 'DISCARDTEMPACT'){
						update_option('revslider-temp-active-notice', 'false');
					}else{
						$notices_discarded = get_option('revslider-notices-dc', array());
						$notices_discarded[] = esc_attr(trim($data['id']));
						update_option('revslider-notices-dc', $notices_discarded);
					}
					
					self::ajaxResponseSuccess(__(".",'revslider'));
				break;
				case 'toggle_favorite':
					if(isset($data['id']) && intval($data['id']) > 0){
						$return = self::toggle_favorite_by_id($data['id']);
						if($return === true){
							self::ajaxResponseSuccess(__('Setting Changed!', 'revslider'));
						}else{
							$error = $return;
						}	
					}else{
						$error = __('No ID given', 'revslider');
					}
					self::ajaxResponseError($error);
				break;
				case "subscribe_to_newsletter":
					if(isset($data['email']) && !empty($data['email'])){
						$return = ThemePunch_Newsletter::subscribe($data['email']);
						
						if($return !== false){
							if(!isset($return['status']) || $return['status'] === 'error'){
								$error = (isset($return['message']) && !empty($return['message'])) ? $return['message'] : __('Invalid Email', 'revslider');
								self::ajaxResponseError($error);
							}else{
								self::ajaxResponseSuccess(__("Success! Please check your Emails to finish the subscription", 'revslider'), $return);
							}
						}else{
							self::ajaxResponseError(__('Invalid Email/Could not connect to the Newsletter server', 'revslider'));
						}	
					}else{
						self::ajaxResponseError(__('No Email given', 'revslider'));
					}
				break;
				case "unsubscribe_to_newsletter":
					if(isset($data['email']) && !empty($data['email'])){
						$return = ThemePunch_Newsletter::unsubscribe($data['email']);
						
						if($return !== false){
							if(!isset($return['status']) || $return['status'] === 'error'){
								$error = (isset($return['message']) && !empty($return['message'])) ? $return['message'] : __('Invalid Email', 'revslider');
								self::ajaxResponseError($error);
							}else{
								self::ajaxResponseSuccess(__("Success! Please check your Emails to finish the process", 'revslider'), $return);
							}
						}else{
							self::ajaxResponseError(__('Invalid Email/Could not connect to the Newsletter server', 'revslider'));
						}	
					}else{
						self::ajaxResponseError(__('No Email given', 'revslider'));
					}
				break;
				case 'change_specific_navigation':
					$nav = new RevSliderNavigation();
					
					$found = false;
					$navigations = $nav->get_all_navigations();
					foreach($navigations as $navig){
						if($data['id'] == $navig['id']){
							$found = true;
							break;
						}
					}
					if($found){
						$nav->create_update_navigation($data, $data['id']);
					}else{
						$nav->create_update_navigation($data);
					}
					
					self::ajaxResponseSuccess(__('Navigation saved/updated', 'revslider'), array('navs' => $nav->get_all_navigations()));
					
				break;
				case 'change_navigations':
					$nav = new RevSliderNavigation();
					
					$nav->create_update_full_navigation($data);
					
					self::ajaxResponseSuccess(__('Navigations updated', 'revslider'), array('navs' => $nav->get_all_navigations()));
				break;
				case 'delete_navigation':
					$nav = new RevSliderNavigation();
					
					if(isset($data) && intval($data) > 0){
						$return = $nav->delete_navigation($data);
						
						if($return !== true){
							self::ajaxResponseError($return);
						}else{
							self::ajaxResponseSuccess(__('Navigation deleted', 'revslider'), array('navs' => $nav->get_all_navigations()));
						}
					}
					
					self::ajaxResponseError(__('Wrong ID given', 'revslider'));
				break;
				case "get_facebook_photosets":
					if(!empty($data['url'])){
						$facebook = new RevSliderFacebook();
						$return = $facebook->get_photo_set_photos_options($data['url'],$data['album'],$data['app_id'],$data['app_secret']);
						if(!empty($return)){
							self::ajaxResponseSuccess(__('Successfully fetched Facebook albums', 'revslider'), array('html'=>implode(' ', $return)));
						}
						else{
							$error = __('Could not fetch Facebook albums', 'revslider');
							self::ajaxResponseError($error);	
						}
					}
					else {
						self::ajaxResponseSuccess(__('Cleared Albums', 'revslider'), array('html'=>implode(' ', $return)));
					}
				break;
				case "get_flickr_photosets":
					if(!empty($data['url']) && !empty($data['key'])){
						$flickr = new RevSliderFlickr($data['key']);
						$user_id = $flickr->get_user_from_url($data['url']);
						$return = $flickr->get_photo_sets($user_id,$data['count'],$data['set']);
						if(!empty($return)){
							self::ajaxResponseSuccess(__('Successfully fetched flickr photosets', 'revslider'), array("data"=>array('html'=>implode(' ', $return))));
						}
						else{
							$error = __('Could not fetch flickr photosets', 'revslider');
							self::ajaxResponseError($error);
						}
					}
					else {
						if(empty($data['url']) && empty($data['key'])){
							self::ajaxResponseSuccess(__('Cleared Photosets', 'revslider'), array('html'=>implode(' ', $return)));
						}
						elseif(empty($data['url'])){
							$error = __('No User URL - Could not fetch flickr photosets', 'revslider');
							self::ajaxResponseError($error);
						}
						else{
							$error = __('No API KEY - Could not fetch flickr photosets', 'revslider');
							self::ajaxResponseError($error);
						}
					}
				break;
				case "get_youtube_playlists":
					if(!empty($data['id'])){
						$youtube = new RevSliderYoutube(trim($data['api']),trim($data['id']));
						$return = $youtube->get_playlist_options($data['playlist']);
						self::ajaxResponseSuccess(__('Successfully fetched YouTube playlists', 'revslider'), array("data"=>array('html'=>implode(' ', $return))));
					}
					else {
						$error = __('Could not fetch YouTube playlists', 'revslider');
						self::ajaxResponseError($error);
					}
				break;
				case 'rs_get_store_information': 
					global $wp_version;
					
					$code = get_option('revslider-code', '');
					$shop_version = RevSliderTemplate::SHOP_VERSION;
					
					$validated = get_option('revslider-valid', 'false');
					if($validated == 'false'){
						$api_key = '';
						$username = '';
						$code = '';
					}
					
					$rattr = array(
						'code' => urlencode($code),
						'product' => urlencode('revslider'),
						'shop_version' => urlencode($shop_version),
						'version' => urlencode(RevSliderGlobals::SLIDER_REVISION)
					);
					
					$request = wp_remote_post('http://templates.themepunch.tools/revslider/store.php', array(
						'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
						'body' => $rattr
					));
					
					$response = '';
					
					if(!is_wp_error($request)) {
						$response = json_decode(@$request['body'], true);
					}
					
					self::ajaxResponseData(array("data"=>$response));
				break;
				case 'load_library_object': 
					$obj_library = new RevSliderObjectLibrary();
					
					$thumbhandle = $data['handle'];
					$type = $data['type'];
					if($type == 'thumb'){
						$thumb = $obj_library->_get_object_thumb($thumbhandle, 'thumb');
					}elseif($type == 'orig'){
						$thumb = $obj_library->_get_object_thumb($thumbhandle, 'original');
					}
					if($thumb['error']){
						self::ajaxResponseError(__('Object could not be loaded', 'revslider'));
					}else{
						self::ajaxResponseData(array('url'=> $thumb['url'], 'width' => $thumb['width'], 'height' => $thumb['height']));
					}
				break;
				case 'load_template_store_sliders': 
					$tmpl = new RevSliderTemplate();

					$tp_template_slider = $tmpl->getThemePunchTemplateSliders();
					
					ob_start();
					$tmpl->create_html_sliders($tp_template_slider);
					$html = ob_get_contents();
					ob_clean();
					ob_end_clean();
					
					self::ajaxResponseData(array('html'=> $html));
					
				break;
				case 'load_template_store_slides': 
					$tmpl = new RevSliderTemplate();

					$templates = $tmpl->getTemplateSlides();
					$tp_template_slider = $tmpl->getThemePunchTemplateSliders();

					$tmp_slider = new RevSlider();
					$all_slider = apply_filters('revslider_slide_templates', $tmp_slider->getArrSliders());
					
					ob_start();
					$tmpl->create_html_slides($tp_template_slider, $all_slider, $templates);
					$html = ob_get_contents();
					ob_clean();
					ob_end_clean();
					
					self::ajaxResponseData(array('html'=> $html));
					
				break;
				case 'load_object_library': 
					$html = '';
					$obj = new RevSliderObjectLibrary();
					$data = $obj->retrieve_all_object_data();
					
					self::ajaxResponseData(array('data'=> $data));
					
				break;
				default:
					$return = apply_filters('revslider_admin_onAjaxAction_switch', false, $action, $data, $slider, $slide, $operations);
					if($return === false)
						self::ajaxResponseError("wrong ajax action: ".esc_attr($action));
					
					exit;
				break;
			}
			
			
			$role = self::getMenuRole(); //add additional security check and allow for example import only for admin
		}
		catch(Exception $e){

			$message = $e->getMessage();
			if($action == "preview_slide" || $action == "preview_slider"){
				echo $message;
				exit();
			}

			self::ajaxResponseError($message);
		}

		//it's an ajax action, so exit
		self::ajaxResponseError("No response output on $action action. please check with the developer.");
		exit();
	}
	
	/**
	 * Set the option to add a delay to the revslider javascript output
	 */
	public static function rev_set_js_delay($do_delay){
		return '300';
	}
	
	/**
	 * onAjax action handler
	 */
	public static function onFrontAjaxAction(){
		$db = new RevSliderDB();
		$slider = new RevSlider();
		$slide = new RevSlide();
		$operations = new RevSliderOperations();
		
		$token = self::getPostVar("token", false);
		
		//verify the token
		$isVerified = wp_verify_nonce($token, 'RevSlider_Front');
		
		$error = false;
		if($isVerified){
			$data = self::getPostVar('data', false);
			switch(self::getPostVar('client_action', false)){
				case 'get_slider_html':
					$id = intval(self::getPostVar('id', 0));
					if($id > 0){
						$html = '';
						add_filter('revslider_add_js_delay', array('RevSliderAdmin', 'rev_set_js_delay'));
						ob_start();
						$slider_class = RevSliderOutput::putSlider($id);
						$html = ob_get_contents();
						
						//add styling
						$custom_css = RevSliderOperations::getStaticCss();
						$custom_css = RevSliderCssParser::compress_css($custom_css);
						$styles = $db->fetch(RevSliderGlobals::$table_css);
						$styles = RevSliderCssParser::parseDbArrayToCss($styles, "\n");
						$styles = RevSliderCssParser::compress_css($styles);
						
						$html .= '<style type="text/css">'.$custom_css.'</style>';
						$html .= '<style type="text/css">'.$styles.'</style>';
						
						ob_clean();
						ob_end_clean();
						
						$result = (!empty($slider_class) && $html !== '') ? true : false;
						
						if(!$result){
							$error = __('Slider not found', 'revslider');
						}else{
							
							if($html !== false){
								self::ajaxResponseData($html);
							}else{
								$error = __('Slider not found', 'revslider');
							}
						}
					}else{
						$error = __('No Data Received', 'revslider');
					}
				break;
			}
			
		}else{
			$error = true;
		}
		
		if($error !== false){
			$showError = __('Loading Error', 'revslider');
			if($error !== true)
				$showError = __('Loading Error: ', 'revslider').$error;
			
			self::ajaxResponseError($showError, false);
		}
		exit();
	}
	
}
?>