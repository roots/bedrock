<?php

class ESSBShortcodeGenerator3 {
	
	public $shortcodeOptions;
	public $shortcode = "";
	public $shortcodeTitle = "";
	
	public $optionsGroup = "shortcode";
	private $counterPositions;
	private $templates;
	private $totalCounterPosition;
	private $buttonStyle;
	
	function __construct() {
		
		$this->shortcodeOptions = array();
		
		$this->templates = essb_available_tempaltes4(true);
		
		
		$this->counterPositions = array();
		$this->counterPositions[''] = "Default counter position";
		/*$this->counterPositions['left'] = "Left";
		$this->counterPositions['right'] = "Right";
		$this->counterPositions['inside'] = "Inside button";
		$this->counterPositions['insidename'] = "Inside button with Network Names";
		$this->counterPositions['insidebeforename'] = "Inside button before Network Names";		
		$this->counterPositions['hidden'] = "Hidden";
		$this->counterPositions['leftm'] = "Left Modern";
		$this->counterPositions['rightm'] = "Right Modern";
		$this->counterPositions['top'] = "Top Modern";
		$this->counterPositions['topm'] = "Top Mini";
		$this->counterPositions['bottom'] = "Bottom";*/
		foreach (essb_avaliable_counter_positions() as $key => $value) {
			$this->counterPositions[$key] = $value;
		}
		
		$this->totalCounterPosition = array();
		$this->totalCounterPosition[''] = "Default counter position";
		/*$this->totalCounterPosition['left'] = "Left";
		$this->totalCounterPosition['right'] = "Right";
		$this->totalCounterPosition['leftbig'] = "Left Big Number";
		$this->totalCounterPosition['rightbig'] = "Right Big Number";
		$this->totalCounterPosition['before'] = "Before social share buttons";
		$this->totalCounterPosition['after'] = "After social share buttons";
		
		$this->totalCounterPosition['none'] = "Hidden";*/
		foreach (essb_avaiable_total_counter_position() as $key => $value) {
			$this->totalCounterPosition[$key] = $value;
		}
		
		$this->buttonStyle = essb_avaiable_button_style();
	}
	
	/*
	 * @$param : the shortcode param
	 * @$options : shortcode param options to be provided in following structure
	 *    array("type" => "",
	 *          "text" => "",
	 *          "comment" => "",
	 *          "value" => "",
	 *          "sourceOptions" => "",
	 *          "fullwidth" => ""
	 */
	function register($param, $options) {
		$this->shortcodeOptions[$param] = $options;
	}
	
	function getTitleNavigation() {
		if ($this->shortcodeTitle != '') {
			return ': '.$this->shortcodeTitle;
		}
		else {
			return  '';
		}
	}
	
	function renderNavigation() {
		echo '<li id="essb-menu-1" class="essb-menu-item"><a href="#"
						onclick="return false;">'.$this->shortcodeTitle.'</a></li>';
		
		$sectionCount = 1;
		
		foreach ($this->shortcodeOptions as $param => $settings) {
			$type = isset($settings['type']) ? $settings['type'] : 'textbox';
			
			if ($type == "section") {
				$text = isset($settings['text']) ? $settings['text'] : '';
				echo '<li id="essb-menu-1-'.$sectionCount.'" class="essb-submenu-item"><a href="#"
						onclick="essb_submenu_execute(\''.$sectionCount.'\'); return false;">'.$text.'</a></li>';
				$sectionCount++;
			}
		}
	}
	
	function render() {
		
		$required_js = "";
		
		echo '<table border="0" cellpadding="5" cellspacing="0" width="100%">
						<col width="25%" />
						<col width="75%" />';
		
		//echo '<tr class="table-border-bottom">';
		//echo '<td colspan="2" class="sub">'.$this->shortcodeTitle.'</td>';
		//echo '</tr>';
		
		$cnt = 0;
		$sectionCount = 1;
		
		foreach ($this->shortcodeOptions as $param => $settings) {
			$type = isset($settings['type']) ? $settings['type'] : 'textbox';
			switch ($type) {
				case "section":
					$this->renderSection($param, $settings, $sectionCount);
					$sectionCount++;
					break;
				case "subsection":
					$this->renderSubSection($param, $settings);
					break;
				case "textbox" :
					$this->renderTextbox($param, $settings, $cnt);
					break;
				case "checkbox":
					$this->renderCheckbox($param, $settings, $cnt);
					break; 
				case "dropdown":
					$this->renderDropDown($param, $settings, $cnt);
					break;
				case "networks":
					$this->renderNetworkSelection($param, $settings, $cnt);
					break;
				case "networks_sp":
					$this->renderNetworkSelectionSP($param, $settings, $cnt);
					break;
				case "networks_sfce":
					$this->renderNetworkSelectionSFCE($param, $settings, $cnt);
					break;
				case "network_names":
					$this->renderNetworkNames($param, $settings, $cnt);
					break;
			}
			
			$cnt++;
		}
		
		echo '</table>';
		
	}

	function renderSection($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		
		echo '<tr class="table-border-bottom">';
		
		echo '<td class="sub4" colspan="2" id="essb-submenu-'.$cnt.'"><div>'.$text.'</div></td>';
		
		echo '</tr>';
	}
	
	function renderSubSection($param, $settings) {
		$text = isset($settings['text']) ? $settings['text'] : '';
	
		echo '<tr class="table-border-bottom">';
	
		echo '<td class="sub5" colspan="2"><div>'.$text.'</div></td>';
	
		echo '</tr>';
	}
	
	function renderTextbox($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<input id="'.$param.'" type="text" name="'.$this->optionsGroup.'['.$param.']" value="' . $default_value . '" class="input-element '.($fullwidth == "true" ? "stretched" : "").'" />';
		echo '</td>';
		echo '</tr>';		
	}
	
	function renderCheckbox($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<input id="'.$param.'" type="checkbox" name="'.$this->optionsGroup.'['.$param.']" value="' . $default_value . '" />';
		echo '</td>';
		echo '</tr>';
	}
	
	function renderDropDown($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		$values = isset($settings['sourceOptions']) ? $settings['sourceOptions'] : array();
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<select id="'.$param.'" name="'.$this->optionsGroup.'['.$param.']" class="input-element '.($fullwidth == "true" ? "stretched" : "").'">';
		
		foreach ($values as $key => $single) {
				printf('<option value="%s" %s>%s</option>',
							$key,
							($key == $value ? 'selected' : ''),
							$single
					);
		}
		
		echo '</select>';
		echo '</td>';
		echo '</tr>';
	}
	
	function renderNetworkNames($param, $settings, $cnt) {
		global $essb_networks;
	$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		$values = isset($settings['sourceOptions']) ? $settings['sourceOptions'] : array();
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<ul id="'.$param.'">';
		$y = $n = '';
		$network_list = "";
		if (is_array ( $essb_networks )) {
			foreach ( $essb_networks as $k => $v ) {
				
				if ($network_list !='') {
					$network_list .= ',';
				}
				$network_list .= $k;
				
				$is_checked = "";
				$network_name = isset ( $v ['name'] ) ? $v ['name'] : $k;
					
				echo '<li><p style="margin: .2em 5% .2em 0;">
						<input id="network__name_' . $k . '" name="'.$this->optionsGroup.'[' . $k . '_text]" type="text"
								class="input-element" />
						<label for="network_name_' . $k . '"><span class="essb_icon essb-icon-' . $k . '"></span>' . $network_name . '</label>
						</p></li>';
			}
		
		}
		echo '</ul>';
		echo '<input type="hidden" name="'.$this->optionsGroup.'['.$param.']" value="'.$network_list.'"/>';
	}
	
	function renderNetworkSelection($param, $settings, $cnt) {
		global $essb_networks;
		
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		$values = isset($settings['sourceOptions']) ? $settings['sourceOptions'] : array();
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<ul id="'.$param.'">';
		$y = $n = '';
		
		if (is_array ( $essb_networks )) {
			foreach ( $essb_networks as $k => $v ) {
					
				$is_checked = "";
				$network_name = isset ( $v ['name'] ) ? $v ['name'] : $k;
				
				
				echo '<li><p style="margin: .2em 5% .2em 0;">
				<input id="network_selection_' . $k . '" value="' . $k . '" name="'.$this->optionsGroup.'['.$param.'][]" type="checkbox"
				' . $is_checked . ' /><input name="'.$this->optionsGroup.'[sort][]" value="' . $k . '" type="checkbox" checked="checked" style="display: none; " />
				<label for="network_selection_' . $k . '"><span class="essb_icon essb_icon_' . $k . '"></span>' . $network_name . '</label>
				</p></li>';
			}
		
		}
		echo '</ul>';
		
		
		
		echo '<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery(\'#'.$param.'\').sortable();
});
</script>';
		
		echo '</td>';
		echo '</tr>';
	}

	function renderNetworkSelectionSFCE($param, $settings, $cnt) {
		$list_of_networks = array();
		
		if (class_exists('ESSBSocialFansCounterExtendedHelper')) {
			$list_of_networks = ESSBSocialFansCounterExtendedHelper::list_of_all_available_networks();	
		}
		
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		$values = isset($settings['sourceOptions']) ? $settings['sourceOptions'] : array();
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<ul id="'.$param.'">';
		$y = $n = '';
		
		if (is_array ( $list_of_networks )) {
			foreach ( $list_of_networks as $k => $v ) {
					
				if ($k == "total") { continue; }
				
				$is_checked = "";
				$network_name = isset ( $v ) ? $v  : $k;
		
		
				echo '<li><p style="margin: .2em 5% .2em 0;">
				<input id="network_selection_' . $k . '" value="' . $k . '" name="'.$this->optionsGroup.'['.$param.'][]" type="checkbox"
				' . $is_checked . ' /><input name="'.$this->optionsGroup.'[sort][]" value="' . $k . '" type="checkbox" checked="checked" style="display: none; " />
				<label for="network_selection_' . $k . '">' . $network_name . '</label>
				</p></li>';
			}
		
		}
		echo '</ul>';
		
		
		
		echo '<script type="text/javascript">
		jQuery(document).ready(function(){
		jQuery(\'#'.$param.'\').sortable();
		});
		</script>';
		
		echo '</td>';
		echo '</tr>';
	}
	
	function renderNetworkSelectionSP($param, $settings, $cnt) {
	
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		$values = isset($settings['sourceOptions']) ? $settings['sourceOptions'] : array();
	
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
	
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<ul id="'.$param.'">';
		$y = $n = '';
	
		if (is_array ( essb_available_social_profiles() )) {
			foreach ( essb_available_social_profiles() as $k => $v ) {
					
				$is_checked = "";
				$network_name = isset ( $v ) ? $v  : $k;
	
	
				echo '<li><p style="margin: .2em 5% .2em 0;">
				<input id="network_selection_' . $k . '" value="' . $k . '" name="'.$this->optionsGroup.'['.$param.'][]" type="checkbox"
				' . $is_checked . ' /><input name="'.$this->optionsGroup.'[sort][]" value="' . $k . '" type="checkbox" checked="checked" style="display: none; " />
				<label for="network_selection_' . $k . '">' . $network_name . '</label>
				</p></li>';
			}
	
		}
		echo '</ul>';
	
	
	
		echo '<script type="text/javascript">
		jQuery(document).ready(function(){
		jQuery(\'#'.$param.'\').sortable();
	});
	</script>';
	
		echo '</td>';
		echo '</tr>';
	}
	
	public function generate($options) {
		$output = "";
		//print_r($options);
		$output .= '['.$this->shortcode;
		
		$exist_url = false;
		
		foreach ($this->shortcodeOptions as $param => $settings) {
			$value = isset($options[$param]) ? $options[$param] : '';
			$type = isset($settings['type']) ? $settings['type'] : 'textbox';
			if ($type == "section") { continue; }
			
			if ($type == "networks" || $type == "networks_sp" || $type == "networks_sfce") {
				
				if (count($value) > 0 && $value != '') {
				$network_list = "";
				foreach ( $value as $nw ) {
					if ($network_list != '') {
						$network_list .= ",";
					}
					$network_list .= $nw;
				}
				
				if ($network_list == "") {
					$network_list = "no";
				}
				
				$value = $network_list;
				}
			}
			
			if ($type == "network_names") {
				$networks = preg_split('#[\s+,\s+]#', $value);
				$network_list = "";
				
				foreach ($networks as $k) {
					$text_for_network = isset($options[$k.'_text'])	? $options[$k.'_text'] : '';
					
					if ($text_for_network != '') {
						if ($network_list != '' ) { $network_list .= ' '; }
						$network_list .= $k.'_text="'.$text_for_network.'"';
					}
				}
				
				$value = $network_list;
			}
			
			if ($param == "counters" && $value == '') { $value = '0'; }
			if ($param == "url" && trim($value) != '') { $exist_url = true; }
			
			if ($value != '') {
				
				if ($param == "counters") {
					$output .= ' '.$param.'='.$value.'';
				}
				else if ($param == "network_names") {
					$output .= ' '.$value;
				}
				else {
					$output .= ' '.$param.'="'.$value.'"';
				}
			}
		}
		
		$output .= ']';
		
		echo '<div class="essb-shortcode-title">Your generated shortcode is</div>';
		echo '<div class="essb-shortcode">';
		echo $output;
		echo '</div>';
		
		echo '<div class="essb-shortcode-title">Include your shortcode into template files using this sample code</div>';
		echo '<div class="essb-shortcode-code"><code>';
		echo '&lt;?php&nbsp;';
		echo 'echo do_shortcode(\''.$output.'\');&nbsp;';
		echo '?&gt;&nbsp;</code>';

		if (($this->shortcode == "easy-social-share" || $this->shortcode == "easy-social-share-popup" || $this->shortcode == "easy-social-share-flyin") && !$exist_url) {
		
			echo '<br/><br/>To get the current post/page title and permalink you can use the following code: <br/><code>$url = get_permalink($post->ID);<br/> 
			&nbsp;$title = get_the_title($post->ID);</code><br/><br/> A completed shortcode that uses those variables added will look like this:<br/>
			<code>';
			
			$output = str_replace("]", ' url="\'.$url.\'" text="\'.$title.\'"]', $output);
			
			echo '&lt;?php&nbsp;<br/>';
			echo '$url = get_permalink($post->ID);<br/> 
			$title = get_the_title($post->ID);<br/>';
			echo 'echo do_shortcode(\''.$output.'\');&nbsp;<br/>';
			echo '?&gt;&nbsp;</code>';
			
		}
		if ($this->shortcode == "easy-total-shares" && !$exist_url) {
			echo '<br/><br/>To get the current post/page permalink you can use the following code: <br/><code>$url = get_permalink($post->ID);</code><br/><br/> A completed shortcode that uses those variables added will look like this:<br/>
			<code>';
				
			$output = str_replace("]", ' url="\'.$url.\'"]', $output);
				
			echo '&lt;?php&nbsp;<br/>';
			echo '$url = get_permalink($post->ID);<br/>';			
			echo 'echo do_shortcode(\''.$output.'\');&nbsp;<br/>';
			echo '?&gt;&nbsp;</code>';
				
		}
	}
	
	// initialize shortcodes
	public function activate($shortcode = 'easy-social-share') {
		$this->shortcodeOptions = array();
		if ($shortcode == 'easy-social-share') {
			$this->includeOptionsForEasyShare();
		}
		
		if ($shortcode == 'easy-social-like') {
			$this->includeOptionsForEasyLike();
		}
		
		if ($shortcode == 'easy-total-shares') {
			$this->includeOptionsForTotalShares();
		}
		
		if ($shortcode == 'easy-social-share-popup') {
			$this->includeOptionsForEasySharePopup();
		}
		if ($shortcode == 'easy-social-share-flyin') {
			$this->includeOptionsForEasyShareFlyin();
		}
		
		if ($shortcode == 'easy-profiles') {
			$this->includeOptionsForEasyProfiles();
		}
		if ($shortcode == 'easy-fans' || $shortcode == 'easy-followers') {
			$this->includeOptionsForEasyFans();
		}
		
		
		// @since 3.4
		if ($shortcode == 'easy-total-fans' || $shortcode == 'easy-total-followers') {
			$this->includeOptionsForTotalFollowers();
		}
		
		if ($shortcode == 'easy-popular-posts') {
			$this->includePopularPosts();
		}
		if ($shortcode == 'easy-subscribe') {
			$this->includeSubscribe();
		}
	}
	
	private function includeSubscribe() {
		$this->shortcode = 'easy-subscribe';
		$this->shortcodeTitle = '[easy-subscribe] Shortcode';
	
		$listOfTypes = array("" => "Subscribe form with service integration (MailChimp, GetReponse, myMail, MailPoet)", "form" => "Custom code subscribe form");
		$this->register("mode", array("type" => "dropdown", "text" => "Form type", "comment" => "Choose form generation type", "sourceOptions" => $listOfTypes));
		$listOfTypes = array("" => "Default subscribe button design", "design1" => "Design #1", "design2" => "Design #2", "design3" => "Design #3", "design4" => "Design #4", "design5" => "Design #5", "design6" => "Design #6", "design7" => "Design #7", "design8" => "Design #8");
		$this->register("design", array("type" => "dropdown", "text" => "Design", "comment" => "Choose your form design style", "sourceOptions" => $listOfTypes));
		$this->register("twostep", array("type" => "checkbox", "text" => "Two step optin form", "comment" => "Two step optin forms will open form when you click on link (text or image)", "value" => "true"));
		$this->register("twostep_text", array("type" => "textbox", "text" => "Two step link content", "comment" => "Put here your two step content open link", "value" => "", "fullwidth" => "true"));
		$this->register("twostep_inline", array("type" => "checkbox", "text" => "Two step form open inline", "comment" => "Open your two step form inline - default mode is as popup", "value" => "true"));
	}
	
	private function includePopularPosts() {
		$this->shortcode = 'easy-popular-posts';
		$this->shortcodeTitle = '[easy-popular-posts] Shortcode';
		
		$this->register("title", array("type" => "textbox", "text" => "Title of widget", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("number", array("type" => "textbox", "text" => "Number of posts to display", "comment" => "", "value" => "", "fullwidth" => "false"));
		$this->register("show_num", array("type" => "checkbox", "text" => "Show value number for selected source", "comment" => "Display numeric value representic selected source (shares, loves, views)", "value" => "yes"));
		$this->register("show_num_text", array("type" => "textbox", "text" => "Text after numeric value", "comment" => "Enter text that you wish to appear after numeric value (shares, loves, views, reads)", "value" => "", "fullwidth" => "false"));
		$listOfTypes = array("shares" => "Total shares (require cache counters to be active)", "loves" => "Post loves (require Love this button to be active)", "views" => "Require Post Views Add-on to be active");
		$this->register("source", array("type" => "dropdown", "text" => "Display value from", "comment" => "Choose source of your values. Each value has requirements that should be met to view correctly number and posts", "sourceOptions" => $listOfTypes));
		$this->register("same_cat", array("type" => "checkbox", "text" => "Display posts from same category only", "comment" => "Choose this if you wish to see post from same category only. This option is not suitable if you plan to use shortcode on list of posts, archive pages or homepage", "value" => "yes"));
	}
	
	private function includeOptionsForTotalFollowers() {
		$this->shortcode = 'easy-total-followers';
		$this->shortcodeTitle = '[easy-total-followers] Shortcode - shortcode does not have additional options';
		
		
	}
	
	private function includeOptionsForEasyFans() {
		$this->shortcode = 'easy-followers';
		$this->shortcodeTitle = '[easy-followers] Shortcode';

		if (!class_exists('ESSBSocialFollowersCounterHelper')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/essb-social-followers-counter-helper.php');
		}
		
		$default_shortcode_setup = ESSBSocialFollowersCounterHelper::default_instance_settings();
		$shortcode_settings = ESSBSocialFollowersCounterHelper::default_options_structure(true, $default_shortcode_setup);
		foreach ($shortcode_settings as $field => $options) {
			$description = isset($options['description']) ? $options['description'] : '';
			$options['comment'] = $description;
			$title = isset($options['title']) ? $options['title'] : '';
			$options['text'] = $title;
			
			$type = isset($options['type']) ? $options['type'] : '';
			if ($type == "textbox") { 
				$options['fullwidth'] = 'true';
			}
			if ($type == "separator") { 
				$options['type'] = "subsection";
			}
			
			$values = isset($options['values']) ? $options['values'] : array();
			
			if ($type == "select") {
				$options['type'] = "dropdown";
				$options['sourceOptions'] = $values;
			}
			
			$default_value = isset($options['default_value']) ? $options['default_value'] : '';
			if (!empty($default_value) && $type != 'checkbox') { 
				$options['value'] = $default_value;
			}
			else {
				if ($type == 'checkbox') {
					$options['value'] = '1';
				}
			}
			
			$this->register($field, $options);
		}
		
		
	}
	
	
	private function includeOptionsForEasyProfiles() {
		$this->shortcode = 'easy-profiles';
		$this->shortcodeTitle = '[easy-profiles] Shortcode';
		
		//$listOfType = array("square" => "Square buttons", "round" => "Round buttons", "edge" => "Round edges");
		//$listOfFill = array("fill" => "White icons on colored background", "colored" => "Colored icons");
		
		//$listOfSize = array("small" => "Small", "medium" => "Medium", "large" => "Large");
		if (!class_exists('ESSBSocialProfilesHelper')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles-helper.php');
		}
		
		$this->register("template", array("type" => "dropdown", "text" => "Template:", "comment" => "", "sourceOptions" => ESSBSocialProfilesHelper::available_templates()));
		$this->register("animation", array("type" => "dropdown", "text" => "Animation:", "comment" => "", "sourceOptions" => ESSBSocialProfilesHelper::available_animations()));
		$this->register("nospace", array("type" => "checkbox", "text" => "Remove space between buttons:", "comment" => "", "value" => "true"));
		$this->register('networks', array("type" => "networks_sp", "text" => "Select Social Networks:", "comment" => "Provide list of networks that will be included"));
		
		foreach (essb_available_social_profiles() as $key => $value) {
			$this->register("profile_".$key, array("type" => "textbox", "text" => $value, "comment" => "", "value" => "", "fullwidth" => "true"));
				
		}
	}
	
	private function includeOptionsForTotalShares() {
		$this->shortcode = 'easy-total-shares';
		$this->shortcodeTitle = '[easy-total-shares] Shortcode';
		
		$this->register("message", array("type" => "textbox", "text" => "Message before the total counter:", "comment" => "Custom message before the share counter", "value" => "", "fullwidth" => "true"));
		$this->register("url", array("type" => "textbox", "text" => "Custom URL to extract total counter for:", "comment" => "Provide only if you wish get counter for different page then the shortcode is used", "value" => "", "fullwidth" => "true"));
		$this->register("align", array("type" => "dropdown", "text" => "Align:", "comment" => "", "sourceOptions" => array("left" => "Left", "center" => "Center", "right" => "Right")));
		$this->register("share_text", array("type" => "textbox", "text" => "Text for shares after the number:", "comment" => "Provide custom text if you wish to display after share number value", "value" => "", "fullwidth" => "true"));
		$this->register("fullnumber", array("type" => "checkbox", "text" => "Display full number (not short syntax):", "comment" => "This will display 100 000 instead of 100k", "value" => "yes"));
		$this->register('networks', array("type" => "networks", "text" => "Select Social Networks:", "comment" => "Provide list of networks that will be included. Select none for all."));
		
	}
	
	private function includeOptionsForEasyShare() {
		$this->shortcode = 'easy-social-share';
		$this->shortcodeTitle = '[easy-social-share] Shortcode';

		$this->register('section5', array("type" => "section", "text" => "Social Share Buttons"));
		$this->register('buttons', array("type" => "networks", "text" => "Social Networks:", "comment" => "Select and reorder networks that you want to add shortcode. If you wish to include only native social buttons don't select options here."));
		
		$this->register("morebutton", array("type" => "dropdown", "text"=> "More button function:", "comment" => "Choose the more button function", "sourceOptions" => array (""=>"", "1" => "Display all active networks after more button", "2" => "Display all social networks as popup", "3" => "Display only active social networks as popup" )));
		$this->register("morebutton_icon", array("type" => "dropdown", "text"=> "More button icon:", "comment" => "Choose the more button icon", "sourceOptions" => array (""=>"", "plus" => "Plus icon", "dots" => "Dots icon")));

		
		$this->register("sharebtn_func", array("type" => "dropdown", "text"=> "Share button function:", "comment" => "Choose the share button function", "sourceOptions" => array (""=>"", "1" => "Display all active networks after share button", "2" => "Display all social networks as popup", "3" => "Display only active social networks as popup" )));
		$this->register("sharebtn_style", array("type" => "dropdown", "text"=> "Share button style:", "comment" => "Choose share button style", "sourceOptions" => array ("" => "", "icon"=> "Icon", "button" => "Button", "text" => "Text")));
		$this->register("sharebtn_icon", array("type" => "dropdown", "text"=> "Share button icon:", "comment" => "Choose the share button icon", "sourceOptions" => array (""=> "", "plus" => "Plus", "dots" => "Dots", "share" => "Share icon #1", "share-alt-square" => "Share icon #2", "share-alt" => "Share icon #3", "share-tiny" => "Share icon #4", "share-outline" => "Share icon #5" )));
		$this->register("sharebtn_counter", array("type" => "dropdown", "text"=> "Share button counter position:", "comment" => "Choose share button counter display. This option require to have counters active not in real time", "sourceOptions" => array (""=>"", "hidden" => "No counter", "inside" => "Inside button without text", "insidename" => "Inside button after text", "insidebeforename" => "Inside button before text", "topn" => "Top", "bottom" => "Bottom")));
		
		
		$this->register('section1', array("type" => "section", "text" => "Counters"));
		
		$this->register("counters", array("type" => "checkbox", "text" => "Include Counters:", "comment" => "Activate display of share counters", "value" => "1"));
		$this->register("counter_pos", array("type" => "dropdown", "text"=> "Counter position", "comment" => "Choose poistion of counters", "sourceOptions" => $this->counterPositions));
		$this->register("total_counter_pos", array("type" => "dropdown", "text"=> "Total counter position", "comment" => "Choose poistion of total counters", "sourceOptions" => $this->totalCounterPosition));
		
		$this->register('section2', array("type" => "section", "text" => "Button Style"));
		$this->register("style", array("type" => "dropdown", "text"=> "Button style:", "comment" => "Choose your button style for shortcode", "sourceOptions" => $this->buttonStyle));
		$this->register("message", array("type" => "checkbox", "text" => "Display message above buttons:", "comment" => "This will display the message that you provide in options", "value" => "yes"));
		$this->register("template", array("type" => "dropdown", "text"=> "Template", "comment" => "Choose different template for buttons in shortcode", "sourceOptions" => $this->templates));
		$this->register("nospace", array("type" => "checkbox", "text" => "Remove space between buttons:", "comment" => "Activate this option to remove button space", "value" => "yes"));
		$this->register("native", array("type" => "checkbox", "text" => "Native buttons:", "comment" => "Include activated from settings native buttons", "value" => "yes"));
		
		$animations_container = array ();
		$animations_container[""] = "Default value from settings";
		foreach (essb_available_animations() as $key => $text) {
			if ($key != '') {
				$animations_container[$key] = $text;
			}
			else {
				$animations_container['no'] = 'No amination';
			}
		}
		
		$this->register('subsection1', array("type" => "subsection", "text" => "Full width share buttons"));
		$this->register("fullwidth", array("type" => "checkbox", "text" => "Activate full width share buttons:", "comment" => "Activate display of full width share buttons", "value" => "yes"));
		$this->register("fullwidth_fix", array("type" => "textbox", "text" => "Single element width correction:", "comment" => "Correct width of single share button (between 0 and 100)", "value" => ""));
		$this->register("fullwidth_first", array("type" => "textbox", "text" => "First element width:", "comment" => "Correct width of first share button (between 0 and 100)", "value" => ""));
		$this->register("fullwidth_second", array("type" => "textbox", "text" => "Second element width:", "comment" => "Correct width of second share button (between 0 and 100)", "value" => ""));
		
		$this->register('subsection2', array("type" => "subsection", "text" => "Fixed width share buttons"));
		$this->register("fixedwidth", array("type" => "checkbox", "text" => "Activate fixed width share buttons:", "comment" => "Activate display of fixed width share buttons", "value" => "yes"));
		$this->register("fixedwidth_px", array("type" => "textbox", "text" => "Single button width:", "comment" => "Provide width of element in px without the px mark (example 120)", "value" => ""));
		$this->register("fixedwidth_align", array("type" => "dropdown", "text" => "Choose alignment of network name when fixed width is used:", "comment" => "Provide different alignment of network name (counter when position inside or inside name) when fixed button width is activated. Default value is center.", "sourceOptions" => array (""=>"Center", "left" => "Left", "right" => "Right" )));

		$this->register('subsection3', array("type" => "subsection", "text" => "Display in columns"));
		$this->register("column", array("type" => "checkbox", "text" => "Activate display in columns:", "comment" => "Activate display of buttons in columns", "value" => "yes"));
		$this->register("columns", array("type" => "textbox", "text" => "Number of columns:", "comment" => "Provide number of button columns", "value" => ""));		
		
		$this->register('subsection4', array("type" => "subsection", "text" => "Flexible full width"));
		$this->register("flex", array("type" => "checkbox", "text" => "Activate flexible full width:", "comment" => "Flexible full width is enchanced full width option where you can use counters, more button and etc.", "value" => "yes"));
		
		$this->register('section3', array("type" => "section", "text" => "Customize shared message"));
		$this->register("url", array("type" => "textbox", "text" => "Share URL:", "comment" => "Provide custom share url. If nothing is filled the page/post address where buttons are displayed will be used", "value" => "", "fullwidth" => "true"));
		$this->register("text", array("type" => "textbox", "text" => "Share Message:", "comment" => "Provide custom share message. If nothid is filled the page/post title where buttons are displayed will be used", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_user", array("type" => "textbox", "text" => "Twitter username:", "comment" => "Provide custom twitter username to include into tweet message", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_hashtags", array("type" => "textbox", "text" => "Twitter hashtags:", "comment" => "Provide custom hashtags for that message", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_tweet", array("type" => "textbox", "text" => "Tweet message:", "comment" => "Provide custom tweet message", "value" => "", "fullwidth" => "true"));
		
		$this->register('section4', array("type" => "section", "text" => "Additional display options"));
		$this->register("sidebar", array("type" => "checkbox", "text" => "Display social buttons as sidebar:", "comment" => "", "value" => "yes"));
		$this->register("sidebar_pos", array("type" => "dropdown", "text"=> "Choose sidebar position", "comment" => "", "sourceOptions" => array(""=>"", "left" => "Left", "right" => "Right")));
		$this->register("popup", array("type" => "checkbox", "text" => "Display social buttons as popup:", "comment" => "", "value" => "yes"));
		$this->register("popafter", array("type" => "textbox", "text" => "Display popup window after about of seconds:", "comment" => "If you wish popup to be displayed after amount of time fill the value here", "value" => ""));
		$this->register("float", array("type" => "checkbox", "text" => "Display social buttons as float from top:", "comment" => "", "value" => "yes"));
		$this->register("postfloat", array("type" => "checkbox", "text" => "Display social buttons as post vertical float:", "comment" => "", "value" => "yes"));
		$this->register("topbar", array("type" => "checkbox", "text" => "Display social buttons as top bar:", "comment" => "", "value" => "yes"));
		$this->register("bottombar", array("type" => "checkbox", "text" => "Display social buttons as bottom bar:", "comment" => "", "value" => "yes"));
		$this->register("hide_mobile", array("type" => "checkbox", "text" => "Hide this shortcode display on mobile devices:", "comment" => "", "value" => "yes"));
		$this->register("only_mobile", array("type" => "checkbox", "text" => "Display shortcode only on mobile devices:", "comment" => "", "value" => "yes"));
		$this->register("mobilebar", array("type" => "checkbox", "text" => "Display social buttons as mobile bottom bar:", "comment" => "", "value" => "yes"));
		$this->register("mobilebuttons", array("type" => "checkbox", "text" => "Display social buttons as mobile buttons bar:", "comment" => "", "value" => "yes"));
		$this->register("mobilepoint", array("type" => "checkbox", "text" => "Display social buttons as mobile point:", "comment" => "", "value" => "yes"));
		
		$this->register("point", array("type" => "checkbox", "text" => "Display social buttons as point:", "comment" => "", "value" => "yes"));
		$this->register("point_type", array("type" => "dropdown", "text"=> "Choose point style", "comment" => "", "sourceOptions" => array("simple"=>"Simple buttons", "advanced" => "Advanced Content")));
		
		$this->register('section6', array("type" => "section", "text" => "Social Share Button Texts"));
		$this->register('network_names', array("type" => "network_names", "text" => "Social Network Names:", "comment" => "Provide custom network names instead of default. For example instead of Facebook you can use Share on Facebook"));
		
	}
	
	private function includeOptionsForEasyLike() {
		$this->shortcode = 'easy-social-like';
		$this->shortcodeTitle = '[easy-social-like] Shortcode';
		
		$this->register('section1', array("type" => "section", "text" => "Facebook Like Button"));
		$this->register("facebook", array("type" => "checkbox", "text" => "Include Facebook Like Button:", "comment" => "", "value" => "true"));
		$this->register("facebook_url", array("type" => "textbox", "text" => "Facebook Like Button URL:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("facebook_width", array("type" => "textbox", "text" => "Width of button:", "comment" => "Provide custom width of button only if it is not fully rendered", "value" => ""));
		$this->register("facebook_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("facebook_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section2', array("type" => "section", "text" => "Facebook Follow Button"));
		$this->register("facebook_follow", array("type" => "checkbox", "text" => "Include Facebook Follow Button:", "comment" => "", "value" => "true"));
		$this->register("facebook_follow_url", array("type" => "textbox", "text" => "Facebook Profile URL:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("facebook_follow_width", array("type" => "textbox", "text" => "Width of button:", "comment" => "Provide custom width of button only if it is not fully rendered", "value" => ""));
		$this->register("facebook_follow_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("facebook_follow_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section3', array("type" => "section", "text" => "Twitter Follow Button"));
		$this->register("twitter_follow", array("type" => "checkbox", "text" => "Include Twitter Follow Button:", "comment" => "", "value" => "true"));
		$this->register("twitter_follow_user", array("type" => "textbox", "text" => "Twitter username:", "comment" => "Without the @", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_follow_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_follow_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section4', array("type" => "section", "text" => "Twitter Tweet Button"));
		$this->register("twitter_tweet", array("type" => "checkbox", "text" => "Include Twitter Tweet Button:", "comment" => "", "value" => "true"));
		$this->register("twitter_tweet_message", array("type" => "textbox", "text" => "Tweet Message:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_tweet_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_tweet_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section5', array("type" => "section", "text" => "Google +1 Button"));
		$this->register("google", array("type" => "checkbox", "text" => "Include Google +1 Button:", "comment" => "", "value" => "true"));
		$this->register("google_url", array("type" => "textbox", "text" => "URL users to give +1:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("google_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("google_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section6', array("type" => "section", "text" => "Google +1 Button"));
		$this->register("google_follow", array("type" => "checkbox", "text" => "Include Google Follow Button:", "comment" => "", "value" => "true"));
		$this->register("google_follow_url", array("type" => "textbox", "text" => "URL to Google+ Profile:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("google_follow_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("google_follow_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section7', array("type" => "section", "text" => "YouTube Channel Subsribe"));
		$this->register("youtube", array("type" => "checkbox", "text" => "Include Youtube Channel Subscribe Button:", "comment" => "", "value" => "true"));
		$this->register("youtube_chanel", array("type" => "textbox", "text" => "Youtube Channel ID:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("youtube_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("youtube_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section8', array("type" => "section", "text" => "Pinterest Pin Button"));
		$this->register("pinterest_pin", array("type" => "checkbox", "text" => "Include Pinterest Pin Button:", "comment" => "", "value" => "true"));
		$this->register("pinterest_pin_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("pinterest_pin_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section9', array("type" => "section", "text" => "Pinterest Follow Button"));
		$this->register("pinterest_follow", array("type" => "checkbox", "text" => "Include Pinterest Follow Button:", "comment" => "", "value" => "true"));
		$this->register("pinterest_follow_display", array("type" => "textbox", "text" => "Text to display in button:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("pinterest_follow_url", array("type" => "textbox", "text" => "URL to Pinterest Profile:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("pinterest_follow_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("pinterest_follow_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section10', array("type" => "section", "text" => "LinkedIn Company Follow"));
		$this->register("linkedin", array("type" => "checkbox", "text" => "Include LinkedIn Company Follow Button:", "comment" => "", "value" => "true"));
		$this->register("linkedin_company", array("type" => "textbox", "text" => "LinkedIn Company ID:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("linkedin_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("linkedin_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section10', array("type" => "section", "text" => "VK.com button"));
		$this->register("vk", array("type" => "checkbox", "text" => "Include VK.com button:", "comment" => "", "value" => "true"));
		$this->register("vk_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("vk_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section11', array("type" => "section", "text" => "Visual Options"));
		$this->register("skinned", array("type" => "checkbox", "text" => "Skinned Native Buttons:", "comment" => "", "value" => "true"));
		$this->register("skin", array("type" => "dropdown", "text" => "Skin:", "comment" => "", "sourceOptions" => array("metro" => "Metro", "flat" => "Flat")));
		$this->register("counters", array("type" => "checkbox", "text" => "Counters for Native Buttons:", "comment" => "", "value" => "true"));
		$this->register("align", array("type" => "dropdown", "text" => "Align:", "comment" => "", "sourceOptions" => array("left" => "Left", "center" => "Center", "right" => "Right")));
	}
	
	private function includeOptionsForEasySharePopup() {
		$this->shortcode = 'easy-social-share-popup';
		$this->shortcodeTitle = '[easy-social-share-popup] Shortcode';
	
		$this->register('section5', array("type" => "section", "text" => "Social Share Buttons"));
		$this->register('buttons', array("type" => "networks", "text" => "Social Networks:", "comment" => "Select and reorder networks that you want to add shortcode. If you wish to include only native social buttons don't select options here."));
	
		$this->register("morebutton", array("type" => "dropdown", "text"=> "More button function:", "comment" => "Choose the more button function", "sourceOptions" => array (""=>"", "1" => "Display all active networks after more button", "2" => "Display all social networks as popup", "3" => "Display only active social networks as popup" )));
		$this->register("morebutton_icon", array("type" => "dropdown", "text"=> "More button icon:", "comment" => "Choose the more button icon", "sourceOptions" => array (""=>"", "plus" => "Plus icon", "dots" => "Dots icon")));
	
		$this->register('section1', array("type" => "section", "text" => "Counters"));
	
		$this->register("counters", array("type" => "checkbox", "text" => "Include Counters:", "comment" => "Activate display of share counters", "value" => "1"));
		$this->register("counter_pos", array("type" => "dropdown", "text"=> "Counter position", "comment" => "Choose poistion of counters", "sourceOptions" => $this->counterPositions));
		$this->register("total_counter_pos", array("type" => "dropdown", "text"=> "Total counter position", "comment" => "Choose poistion of total counters", "sourceOptions" => $this->totalCounterPosition));
	
		$this->register('section2', array("type" => "section", "text" => "Button Style"));
		$this->register("style", array("type" => "dropdown", "text"=> "Button style:", "comment" => "Choose your button style for shortcode", "sourceOptions" => $this->buttonStyle));
		$this->register("message", array("type" => "checkbox", "text" => "Display message above buttons:", "comment" => "This will display the message that you provide in options", "value" => "yes"));
		$this->register("template", array("type" => "dropdown", "text"=> "Template", "comment" => "Choose different template for buttons in shortcode", "sourceOptions" => $this->templates));
		$this->register("nospace", array("type" => "checkbox", "text" => "Remove space between buttons:", "comment" => "Activate this option to remove button space", "value" => "yes"));
		
		$this->register('section4', array("type" => "section", "text" => "Customize popup"));
		$this->register("popup_title", array("type" => "textbox", "text" => "Popup window title:", "comment" => "Provide custom title of popup window", "value" => "", "fullwidth" => "true"));
		$this->register("popup_message", array("type" => "textbox", "text" => "Popup user message:", "comment" => "Provide custom user message into popup window", "value" => "", "fullwidth" => "true"));
		$this->register("popup_percent", array("type" => "textbox", "text" => "Display popup after amount of content is viewed:", "comment" => "Provde custom percent which will make popup to appear after that content is viewed (for example 50)", "value" => "", "fullwidth" => "false"));
		$this->register("popup_end", array("type" => "checkbox", "text" => "Display popup at the end of content:", "comment" => "Display popup when user reaches the end of content", "value" => "yes"));
		
		$this->register('section3', array("type" => "section", "text" => "Customize shared message"));
		$this->register("url", array("type" => "textbox", "text" => "Share URL:", "comment" => "Provide custom share url. If nothing is filled the page/post address where buttons are displayed will be used", "value" => "", "fullwidth" => "true"));
		$this->register("text", array("type" => "textbox", "text" => "Share Message:", "comment" => "Provide custom share message. If nothid is filled the page/post title where buttons are displayed will be used", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_user", array("type" => "textbox", "text" => "Twitter username:", "comment" => "Provide custom twitter username to include into tweet message", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_hashtags", array("type" => "textbox", "text" => "Twitter hashtags:", "comment" => "Provide custom hashtags for that message", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_tweet", array("type" => "textbox", "text" => "Tweet message:", "comment" => "Provide custom tweet message", "value" => "", "fullwidth" => "true"));
	
		$this->register("only_mobile", array("type" => "checkbox", "text" => "Display shortcode only on mobile devices:", "comment" => "", "value" => "yes"));
	
		$this->register('section6', array("type" => "section", "text" => "Social Share Button Texts"));
		$this->register('network_names', array("type" => "network_names", "text" => "Social Network Names:", "comment" => "Provide custom network names instead of default. For example instead of Facebook you can use Share on Facebook"));
	
	}
	
	private function includeOptionsForEasyShareFlyin() {
		$this->shortcode = 'easy-social-share-flyin';
		$this->shortcodeTitle = '[easy-social-share-flyin] Shortcode';
	
		$this->register('section5', array("type" => "section", "text" => "Social Share Buttons"));
		$this->register('buttons', array("type" => "networks", "text" => "Social Networks:", "comment" => "Select and reorder networks that you want to add shortcode. If you wish to include only native social buttons don't select options here."));
	
		$this->register("morebutton", array("type" => "dropdown", "text"=> "More button function:", "comment" => "Choose the more button function", "sourceOptions" => array (""=>"", "1" => "Display all active networks after more button", "2" => "Display all social networks as popup", "3" => "Display only active social networks as popup" )));
		$this->register("morebutton_icon", array("type" => "dropdown", "text"=> "More button icon:", "comment" => "Choose the more button icon", "sourceOptions" => array (""=>"", "plus" => "Plus icon", "dots" => "Dots icon")));
	
		$this->register('section1', array("type" => "section", "text" => "Counters"));
	
		$this->register("counters", array("type" => "checkbox", "text" => "Include Counters:", "comment" => "Activate display of share counters", "value" => "1"));
		$this->register("counter_pos", array("type" => "dropdown", "text"=> "Counter position", "comment" => "Choose poistion of counters", "sourceOptions" => $this->counterPositions));
		$this->register("total_counter_pos", array("type" => "dropdown", "text"=> "Total counter position", "comment" => "Choose poistion of total counters", "sourceOptions" => $this->totalCounterPosition));
	
		$this->register('section2', array("type" => "section", "text" => "Button Style"));
		$this->register("style", array("type" => "dropdown", "text"=> "Button style:", "comment" => "Choose your button style for shortcode", "sourceOptions" => $this->buttonStyle));
		$this->register("message", array("type" => "checkbox", "text" => "Display message above buttons:", "comment" => "This will display the message that you provide in options", "value" => "yes"));
		$this->register("template", array("type" => "dropdown", "text"=> "Template", "comment" => "Choose different template for buttons in shortcode", "sourceOptions" => $this->templates));
		$this->register("nospace", array("type" => "checkbox", "text" => "Remove space between buttons:", "comment" => "Activate this option to remove button space", "value" => "yes"));
	
		$this->register('section4', array("type" => "section", "text" => "Customize fly in"));
		$this->register("flyin_title", array("type" => "textbox", "text" => "Fly In window title:", "comment" => "Provide custom title of fly in window", "value" => "", "fullwidth" => "true"));
		$this->register("flyin_message", array("type" => "textbox", "text" => "Fly In user message:", "comment" => "Provide custom user message into fly in window", "value" => "", "fullwidth" => "true"));
		$this->register("flyin_percent", array("type" => "textbox", "text" => "Display fly in after amount of content is viewed:", "comment" => "Provde custom percent which will make fly in to appear after that content is viewed (for example 50)", "value" => "", "fullwidth" => "false"));
		$this->register("flyin_end", array("type" => "checkbox", "text" => "Display fly in at the end of content:", "comment" => "Display fly in when user reaches the end of content", "value" => "yes"));
	
		$this->register('section3', array("type" => "section", "text" => "Customize shared message"));
		$this->register("url", array("type" => "textbox", "text" => "Share URL:", "comment" => "Provide custom share url. If nothing is filled the page/post address where buttons are displayed will be used", "value" => "", "fullwidth" => "true"));
		$this->register("text", array("type" => "textbox", "text" => "Share Message:", "comment" => "Provide custom share message. If nothid is filled the page/post title where buttons are displayed will be used", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_user", array("type" => "textbox", "text" => "Twitter username:", "comment" => "Provide custom twitter username to include into tweet message", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_hashtags", array("type" => "textbox", "text" => "Twitter hashtags:", "comment" => "Provide custom hashtags for that message", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_tweet", array("type" => "textbox", "text" => "Tweet message:", "comment" => "Provide custom tweet message", "value" => "", "fullwidth" => "true"));
	
		$this->register("only_mobile", array("type" => "checkbox", "text" => "Display shortcode only on mobile devices:", "comment" => "", "value" => "yes"));
	
		$this->register('section6', array("type" => "section", "text" => "Social Share Button Texts"));
		$this->register('network_names', array("type" => "network_names", "text" => "Social Network Names:", "comment" => "Provide custom network names instead of default. For example instead of Facebook you can use Share on Facebook"));
	
	}
}

?>