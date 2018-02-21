<?php
ESSBOptionsStructureHelper::menu_item('readymade', 'popular', __('Popular Styles', 'essb'), 'refresh ti-palette');
ESSBOptionsStructureHelper::menu_item('readymade', 'new', __('<div class="essb-new" style="margin-right: 5px;"><span></span></div>New Styles', 'essb'), 'refresh ti-palette');
ESSBOptionsStructureHelper::menu_item('readymade', 'width', __('Width Based Styles', 'essb'), 'refresh ti-palette');
ESSBOptionsStructureHelper::menu_item('readymade', 'style', __('Various Button Styles', 'essb'), 'refresh ti-palette');
ESSBOptionsStructureHelper::menu_item('readymade', 'mobile', __('Mobile Styles', 'essb'), 'refresh ti-mobile');

ESSBOptionsStructureHelper::field_func('readymade', 'popular', 'essb3_readymade_code', '', '');
ESSBOptionsStructureHelper::field_func('readymade', 'new', 'essb3_readymade_new', '', '');
ESSBOptionsStructureHelper::field_func('readymade', 'width', 'essb3_readymade_code_width', '', '');
ESSBOptionsStructureHelper::field_func('readymade', 'style', 'essb3_readymade_code_style', '', '');
ESSBOptionsStructureHelper::field_func('readymade', 'mobile', 'essb3_readymade_code_mobile', '', '');

global $ready_positions, $ready_made;
$ready_positions = array();
$ready_positions['top'] = __('Top of content', 'essb');
$ready_positions['bottom'] = __('Bottom of content', 'essb');
$ready_positions['float'] = __('Float from top', 'essb');
$ready_positions['topbar'] = __('Top bar', 'essb');
$ready_positions['bottombar'] = __('Bottom bar', 'essb');
$ready_positions['sidebar'] = __('Sidebar', 'essb');
$ready_positions['postfloat'] = __('Post Vertical Float', 'essb');
$ready_positions['popup'] = __('Pop up', 'essb');
$ready_positions['flyin'] = __('Fly In', 'essb');
$ready_positions['mobile'] = __('Mobile display', 'essb');
$ready_positions['followme'] = __('Follow Me Bar', 'essb');

if (defined('PB_VERSION')) {
	$ready_positions['pbtop'] = __('Passion Blogger: Above Post Content', 'passionblogger');
	$ready_positions['pbbottom'] = __('Passion Blogger: Below Post Content', 'passionblogger');
	$ready_positions['pbexcerpt'] = __('Passion Blogger: List of Articles Display', 'passionblogger');
	$ready_positions['pbexcerpt2'] = __('Passion Blogger: Excerpt End', 'passionblogger');	
}

$ready_made = array();

$ready_made['group3'] = array('name' => __('Various Button Styles', 'essb'), 'type' => 'heading', 'group' => 'style');

$ready_made['buttonstyle1'] = array('name' => __('Icons with network name appearing on hover (including total counter)', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar,popup,flyin,sidebar,postfloat',
		'preview' => 'ready_made/buttonstyle1.png',
		'template' => false,
		'networks' => false, 'group' => 'style');

$ready_made['buttonstyle2'] = array('name' => __('Icons with network name appearing on hover', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar,popup,flyin,sidebar,postfloat',
		'preview' => 'ready_made/buttonstyle2.png',
		'template' => false,
		'networks' => false, 'group' => 'style');


$ready_made['buttonstyle3'] = array('name' => __('Share buttons with icons only', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar,popup,flyin,sidebar,postfloat',
		'preview' => 'ready_made/buttonstyle3.png',
		'template' => false,
		'networks' => false, 'group' => 'style');

$ready_made['buttonstyle4'] = array('name' => __('Share buttons with network name only', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar,popup,flyin,sidebar,postfloat',
		'preview' => 'ready_made/buttonstyle4.png',
		'template' => false,
		'networks' => false, 'group' => 'style');

$ready_made['group2'] = array('name' => __('Width Based Styles', 'essb'), 'type' => 'heading' , 'group' => 'width');

$ready_made['full3'] = array('name' => __('Full width share buttons', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/full3.png',
		'template' => false,
		'networks' => false, 'group' => 'width');

$ready_made['columns'] = array('name' => __('Display in columns', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,flyin,popup',
		'preview' => 'ready_made/columns.png',
		'template' => false,
		'networks' => false, 'group' => 'width');

$ready_made['full4'] = array('name' => __('Full width share buttons with counters', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/full4.png',
		'template' => false,
		'networks' => false, 'group' => 'width');

$ready_made['fixed'] = array('name' => __('Fixed width buttons with counters', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/fixed.png',
		'template' => false,
		'networks' => false, 'group' => 'width');

$ready_made['group1'] = array('name' => __('Popular Styles', 'essb'), 'type' => 'heading', 'group' => 'popular');
$ready_made['mashable'] = array('name' => __('Mashable style', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/mashable.png',
		'template' => true,
		'networks' => true, 'group' => 'popular',
		'bestfor' => 'top,bottom,followme');

$ready_made['upworthy'] = array('name' => __('Upworthy style', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/upworthy.png',
		'template' => true,
		'networks' => true, 'group' => 'popular',
		'bestfor' => 'top,bottom');

$ready_made['essb1'] = array('name' => __('Demo from our site', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar,sidebar,postfloat,flyin,popup',
		'preview' => 'ready_made/essb1.png',
		'template' => false,
		'networks' => false, 'group' => 'popular');

$ready_made['copyblogger'] = array('name' => __('Copy Blogger style', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar,sidebar,postfloat,flyin,popup',
		'preview' => 'ready_made/copyblogger.png',
		'template' => true,
		'networks' => true, 'group' => 'popular',
		'bestfor' => 'top,bottom');

$ready_made['sidebar1'] = array('name' => __('Icons without space with more button', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar,flyin,popup',
		'preview' => 'ready_made/sidebar1.png',
		'template' => true,
		'networks' => true, 'group' => 'popular',
		'bestfor' => 'sidebar,postfloat');

$ready_made['sidebar2'] = array('name' => __('Icons without space with more button including counter', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar,flyin,popup',
		'preview' => 'ready_made/sidebar2.png',
		'template' => true,
		'networks' => false, 'group' => 'popular',
		'bestfor' => 'sidebar,postfloat');

$ready_made['new41_1'] = array('name' => __('New in 4.1 More button style inline icon pop', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/new41_1.png',
		'template' => false,
		'networks' => true, 'group' => 'new');

$ready_made['new41_2'] = array('name' => __('New in 4.1 More button style inline names pop', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/new41_2.png',
		'template' => false,
		'networks' => true, 'group' => 'new');

$ready_made['new41_3'] = array('name' => __('New in 4.1 Modern style of more pop up', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/new41_3.png',
		'template' => false,
		'networks' => true, 'group' => 'new');


$ready_made['full1'] = array('name' => __('Fancy full width share buttons', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/full1.png',
		'template' => false,
		'networks' => true, 'group' => 'new');

$ready_made['full2'] = array('name' => __('Flexible full width share buttons', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/full2.png',
		'template' => true,
		'networks' => true, 'group' => 'new');

$ready_made['full5'] = array('name' => __('Flexible full width share buttons with name appear on button hover', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/full5.png',
		'template' => false,
		'networks' => false, 'group' => 'new');

$ready_made['full6'] = array('name' => __('Flexible full width share buttons with name appear on button hover and total counter', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/full6.png',
		'template' => false,
		'networks' => false, 'group' => 'new');

$ready_made['full7'] = array('name' => __('Flexible full width share buttons with name appear on button hover, button counter and total counter', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/full7.png',
		'template' => false,
		'networks' => false, 'group' => 'new');


$ready_made['essb2'] = array('name' => __('Inline buttons from our demo site', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/essb2.png',
		'template' => true,
		'networks' => true, 'group' => 'popular');

$ready_made['massive'] = array('name' => __('Massive share buttons', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar,flyin,popup',
		'preview' => 'ready_made/massive.png',
		'template' => true,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'top,bottom');

$ready_made['massive2'] = array('name' => __('Massive share buttons version 2', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar,flyin,popup',
		'preview' => 'ready_made/massive2.png',
		'template' => true,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'top,bottom');

$ready_made['share1'] = array('name' => __('Share button with text', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/share1.png',
		'template' => false,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'top,bottom');

$ready_made['share2'] = array('name' => __('Share button with text and counter', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/share2.png',
		'template' => false,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'top,bottom');

$ready_made['share3'] = array('name' => __('Share button with text and counter #2', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/share3.png',
		'template' => true,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'top,bottom');

$ready_made['share4'] = array('name' => __('Share button with text and counter #3', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/share4.png',
		'template' => true,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'top,bottom');

$ready_made['share5'] = array('name' => __('Share button with text #4', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/share5.png',
		'template' => true,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'top,bottom');

$ready_made['share6'] = array('name' => __('Share button with text and counter #5', 'essb'),
		'type' => 'style',
		'applyon' => 'top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/share6.png',
		'template' => false,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'top,bottom');

$ready_made['share7'] = array('name' => __('Share button with text and counter #6', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/share7.png',
		'template' => true,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'sidebar,postfloat');


$ready_made['sidebar3'] = array('name' => __('Fixed width buttons with total counter', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/bar1.png',
		'template' => true,
		'networks' => true, 'group' => 'popular',
		'bestfor' => 'sidebar,postfloat');

$ready_made['sidebar4'] = array('name' => __('Vertical buttons', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/bar2.png',
		'template' => true,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'sidebar,postfloat');

$ready_made['sidebar5'] = array('name' => __('Vertical buttons 2', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/bar3.png',
		'template' => true,
		'networks' => true, 'group' => 'new',
		'bestfor' => 'sidebar,postfloat');

$ready_made['sidebar6'] = array('name' => __('Sidebar from our demo site', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/sidebar3.png',
		'template' => true,
		'networks' => true, 'group' => 'popular',
		'bestfor' => 'sidebar,postfloat');

$ready_made['sidebar7'] = array('name' => __('Round icons with counter and name appear on hover', 'essb'),
		'type' => 'style',
		'applyon' => 'sidebar,postfloat,top,bottom,followme,float,topbar,bottombar',
		'preview' => 'ready_made/sidebar4.png',
		'template' => true,
		'networks' => false, 'group' => 'new',
		'bestfor' => 'sidebar,postfloat,top,bottom');


$ready_made['mobile1'] = array('name' => __('Mobile Share Bar', 'essb'),
		'type' => 'style',
		'applyon' => 'mobile',
		'preview' => 'ready_made/mobile1.png',
		'template' => true,
		'networks' => true, 'group' => 'mobile');

$ready_made['mobile2'] = array('name' => __('Mobile Share Point', 'essb'),
		'type' => 'style',
		'applyon' => 'mobile',
		'preview' => 'ready_made/mobile2.png',
		'template' => true,
		'networks' => true, 'group' => 'mobile');

$ready_made['mobile3'] = array('name' => __('Mobile Buttons Bar', 'essb'),
		'type' => 'style',
		'applyon' => 'mobile',
		'preview' => 'ready_made/mobile3.png',
		'template' => true,
		'networks' => true, 'group' => 'mobile');

$ready_made['mobile4'] = array('name' => __('Mobile Buttons Bar With Total Counter', 'essb'),
		'type' => 'style',
		'applyon' => 'mobile',
		'preview' => 'ready_made/mobile4.png',
		'template' => true,
		'networks' => true, 'group' => 'mobile');

$ready_made['mobile5'] = array('name' => __('Mobile Buttons Bar With Total Counter & Text', 'essb'),
		'type' => 'style',
		'applyon' => 'mobile',
		'preview' => 'ready_made/mobile5.png',
		'template' => true,
		'networks' => true, 'group' => 'mobile');

$ready_made['mobile6'] = array('name' => __('Mobile Buttons Bar With Text', 'essb'),
		'type' => 'style',
		'applyon' => 'mobile',
		'preview' => 'ready_made/mobile6.png',
		'template' => true,
		'networks' => true, 'group' => 'mobile');

function essb3_add_passionblogger_to_readymade($ready_made = array()) {
	$extra_options = 'pbtop,pbbottom,pbexcerpt,pbexcerpt2';
	
	foreach ($ready_made as $key => $data) {
		$applyon = isset($data['applyon']) ? $data['applyon'] : '';
		
		if (strpos($applyon, 'top') !== false) {
			$ready_made[$key]['applyon'] .= ','.$extra_options;
		}
	}
	
	return $ready_made;
}

if (defined('PB_VERSION')) {
	$ready_made = essb3_add_passionblogger_to_readymade($ready_made);
}

function essb3_apply_readymade_style() {
	global $ready_made, $ready_positions;
	
	$present = isset($_REQUEST['present']) ? $_REQUEST['present'] : '';
	$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
	
	if ($present != '' && $location != '') {
		include (ESSB3_PLUGIN_ROOT . 'lib/admin/ready-made-presents/essb-present-'.$present.'.php');
		$present_settings = essb_get_present_settings($location);
	
		global $essb_options;
		foreach ($present_settings as $key => $value) {
			$essb_options[$key] = $value;
		}
	
		update_option ( ESSB3_OPTIONS_NAME, $essb_options );
		
		$style_name = isset($ready_made[$present]) ? $ready_made[$present]['name'] : $ready_made;
		$position_name = isset($ready_positions[$location]) ? $ready_positions[$location] : $location;
	
		essb_display_status_message(__( 'Easy Social Share Buttons: Ready made style', 'essb' ), '<b>'.$style_name.'</b>' . __(' is applied on position', 'essb'). ' <b>'.$position_name.'</b>.'.__(' Please check and if needed activate display of chosen position from Social Sharing -> Where to display -> Positions', 'essb'), 'fa fa-info-circle');
		
		//printf ( '<div class="essb-information-box"><div class="icon"><i class="fa fa-info-circle"></i></div><div class="inner">%1$s %2$s %3$s %4$s. %5$s</div></div>', __ ( 'Easy Social Share Buttons: Ready made style', 'essb' ), '<b>'.$style_name.'</b>', __('is applied on position', 'essb'), '<b>'.$position_name.'</b>', __('Please check and if needed activate display of chosen position from Social Sharing -> Where to display -> Positions') );
		
		//printf ( '<div class="essb-information-box"><div class="icon"><i class="fa fa-info-circle"></i></div><div class="inner">%1$s</div></div>', __ ( 'Easy Social Share Buttons: Ready made style is loaded to selected position ' . $location, 'essb' ) );
	
	}
}

function essb3_display_readymades($group = '') {
	global $ready_positions, $ready_made;
	
	foreach ($ready_made as $key => $data) {
		
		if ($data['group'] != $group) { continue; }
	
		if ($data['type'] == 'heading') {
			//ESSBOptionsFramework::draw_options_row_start_full('inner-row');
			ESSBOptionsFramework::draw_heading($data['name'], '4');
			//ESSBOptionsFramework::draw_options_row_end();
		}
		else {
			$additional_text = "";
			if ($data['template'] || $data['networks']) {
					
				if ($data['networks']) {
					$additional_text .= '<span style="margin-right: 10px;"><b>'.__('INCLUDES NETWORK SELECTION', 'essb').'</b></span>';
				}
				if ($data['template']) {
					$additional_text .= '<span style="margin-right: 10px;"><b>'.__('INCLUDES TEMPLATE SELECTION', 'essb').'</b></span>';
				}
					
			}
	
			ESSBOptionsFramework::draw_options_row_start_full('inner-row grey-title');
			ESSBOptionsFramework::draw_title($data['name'], __('Can be used on: ', 'essb').$data['applyon'].'. '.$additional_text);
			ESSBOptionsFramework::draw_options_row_end();
	
			ESSBOptionsFramework::draw_structure_row_start('');
	
			ESSBOptionsFramework::draw_structure_section_start('c6');
			if ($data['preview']) {
				echo '<img src="'.ESSB3_PLUGIN_URL.'/assets/images/'.$data['preview'].'"/>';
			}
			ESSBOptionsFramework::draw_structure_section_end();
	
			// install column
			ESSBOptionsFramework::draw_structure_section_start('c6');
	
			echo '<div class="bold" style="font-weight: 700;">'.__('Choose position where you wish to install the ready made present', 'essb').'</div>';
			echo '<div style="margin-top: 5px; margin-bottom: 5px;" class="label">'.__('Loading a ready made present will overwrite position settings you have made till now. If you wish to assign the ready made style to more than one location you need to do this location by location.', 'essb').'</div>';
	
			$applyon = explode(',', $data['applyon']);
			echo '<div>';
			echo '<select class="input-element essb-present-'.$key.'" data-present="'.$key.'" style="margin-right:10px;">';
			foreach ($applyon as $position) {
				echo '<option value="'.$position.'">'.(isset($ready_positions[$position]) ? $ready_positions[$position] : $position).'</option>';
			}
			echo '</select>';
			echo '<a href="#" class="essb-btn essb-btn-blue" data-present="'.$key.'" onclick="essb_call_apply_present(\''.$key.'\'); return false;">'.__('Apply ready made style to selected location', 'essb').'</a>';
			echo '</div>';
	
			ESSBOptionsFramework::draw_structure_section_end();
	
	
			ESSBOptionsFramework::draw_structure_row_end();
		}
	
	}
}

function essb3_display_readymade_presents($group = '') {
	global $ready_made, $ready_positions;
	
	if (!ESSBAdminActivate::is_activated()) {
		if (!ESSBActivationManager::isThemeIntegrated()) {
			ESSBOptionsFramework::draw_hint(__('Unlock the full power of ready made styles!', 'essb'), 'Hello! Please <a href="admin.php?page=essb_redirect_update&tab=update">activate your copy</a> of Easy Social Share Buttons for WordPress to unlock all 35+ ready made presents that you will be able to install on your site.', 'fa fa-lock', 'status essb-status-activate essb-status-activate-presents');
		}
		else {
			ESSBOptionsFramework::draw_hint(__('Direct Customer Benefit ', 'essb'), sprintf(__('Access to one click ready made styles install is benefit for direct plugin customers. <a href="%s" target="_blank"><b>See all direct customer benefits</b></a>', 'essb'), ESSBActivationManager::getBenefitURL()), 'fa21 fa fa-lock', 'addonhint');				
		}
		
	}
	
	ESSBOptionsFramework::draw_options_row_start_full('');
	/*ESSBOptionsFramework::draw_hint(__('Welcome to ready made styles!<br/><br/>', 'essb'),
			__('With ready made styles wizard allows you to easy configure designs to selected location. Each ready made style has set of positions where it can be used. If you wish to apply it on more than one location than all you need to apply it separately on each.<br/><br/>
					For some styles you can see recommended locations. This does not mean that you cannot use them on others but for that locations you will see the best visual effect. Those locations we mark using this style <span class="essb-location essb-featured-location">SIDEBAR</span><br/><br/>
					Some ready made styles contain preconfigured networks or template which is made to ensure same design output will be generated. You can see them marked as <span class="essb-location essb-featured-location2">networks</span> or <span class="essb-location essb-featured-location2">template</span>.
					Once you apply such present you can change template or active networks using position settings (Social Sharing -> Where to display). All styles that does not contain such marks will use the default social networks and template you have set.<br/><br/>
					Important! Please ensure that location you choose and apply style for is active in Social Buttons -> Where to display -> Positions. Each ready made present has example settings that will configure location you choose to apply on - you can change options at any time for it by visiting Social Sharing -> Where to display -> Positions -> (Position Name).', 'essb'));
	*/
	ESSBOptionsFramework::draw_hint(__('Welcome to ready made styles!<br/><br/>', 'essb'),
			__('With ready made styles you can easy apply design to any location (it is just one click). Read more <a href="http://go.appscreo.com/ready-made-styles" target="_blank"><b>here</b></a> on how to activate or deactivate ready made styles.', 'essb'));
	
	ESSBOptionsFramework::draw_options_row_end();
	
	echo '<div class="wp-list-table widefat plugin-install essb-presents-table">';
	echo '<div id="the-list">';
	
	foreach ($ready_made as $key => $data) {
	
		if ($data['group'] != $group) {
			continue;
		}
		
		if ($data['type'] == 'heading') {
			//ESSBOptionsFramework::draw_heading($data['name'], '4');
		}
		else {
			echo '<div class="plugin-card">';
			echo '<div class="plugin-card-top">';
			echo '<h4><a href="#" onclick="return false;">'.$data['name'].'</a></h4>';
			echo '<div class="essb-present-preview"><img src="'.ESSB3_PLUGIN_URL.'/assets/images/'.$data['preview'].'" style="max-width: 100%;"/></div>';
			
			echo '<div class="essb-present-description">';
			echo '<p class="bold">'.__('This ready made style can be used for following locations: ', 'essb').'<br/>';
			$applyon = explode(',', $data['applyon']);
			$is_first = true;
			foreach ($applyon as $position) {
				//if (!$is_first) echo ', ';
				echo '<span class="essb-location">';
				echo isset($ready_positions[$position]) ? $ready_positions[$position] : $position;
				$is_first = false;
				echo '</span>';
			}
			echo '</p>';
			
			if (isset($data['bestfor'])) {
				$bestfor = explode(',', $data['bestfor']);
				
				echo '<p class="bold">'.__('Recommended for usage at: ', 'essb').'<br/>';
				foreach ($bestfor as $position) {
					//if (!$is_first) echo ', ';
					echo '<span class="essb-location essb-featured-location">';
					echo isset($ready_positions[$position]) ? $ready_positions[$position] : $position;
					$is_first = false;
					echo '</span>';
				}
				echo '</p>';
			}
			
			if ($data['networks'] || $data['template']) {
				echo '<p class="bold">'.__('This style also includes preconfigured: ', 'essb').'<br/>';
				if ($data['networks']) {
					echo '<span class="essb-location essb-featured-location2">';
					echo __('Networks', 'essb');
					echo '</span>';
				}
				if ($data['template']) {
					echo '<span class="essb-location essb-featured-location2">';
					echo __('Template', 'essb');
					echo '</span>';
				}
				echo '</p>';
			}
			
			echo '</div>';
			
			// end top
			echo '</div>';
			
			echo '<div class="plugin-card-bottom">';
			echo '<div style="margin-bottom: 10px;"><strong>';
			echo __('Select location where you wish to apply this style');
			echo '</strong></div>';
			echo '<select class="input-element essb-present-'.$key.'" data-present="'.$key.'" style="margin-right:10px;">';
			foreach ($applyon as $position) {
				echo '<option value="'.$position.'">'.(isset($ready_positions[$position]) ? $ready_positions[$position] : $position).'</option>';
			}
			echo '</select>';
			
			if (!ESSBAdminActivate::is_activated()) {
			//if (!ESSBAdminActivate::is_activated() && $group != 'popular') {
				//echo '<a href="#" class="button" disabled="disabled" style="float: right;" data-present="'.$key.'" onclick="return false;">'.__('Activate plugin to use this style', 'essb').'</a>';
				echo ESSBAdminActivate::activateToUnlock('', 'float:right;');
			}
			else {
				echo '<a href="#" class="essb-btn essb-btn-blue" style="float: right;" data-present="'.$key.'" onclick="essb_call_apply_present(\''.$key.'\'); return false;">'.__('Apply on selected location', 'essb').'</a>';
			}
			
			echo '</div>';
			echo '</div>';
		}
	}
	
	echo '</div></div>';
}

function essb3_readymade_code_style() {
	global $ready_positions, $ready_made;



	essb3_display_readymade_presents('style');
	//essb3_display_readymades('style');
	
}

function essb3_readymade_code_mobile() {
	global $ready_positions, $ready_made;



	essb3_display_readymade_presents('mobile');
}


function essb3_readymade_code_width() {
	global $ready_positions, $ready_made;
	
	
	essb3_display_readymade_presents('width');
	//essb3_display_readymades('width');
	
		echo '<script type="text/javascript">';
		echo '
		
		function essb_call_apply_present(present) {
			var sender_position = jQuery(".essb-present-"+present);
			if (!sender_position.length) return;
			
			window.location.href = "admin.php?page=essb_redirect_readymade&tab=readymade&present="+present+"&location="+jQuery(sender_position).val();
		}
		
		jQuery(document).ready(function($){
			$(".essb-presents-table").find(".essb-present-preview1").each(function() {
				$(this).hover(function() {
					var image = $(this).find("img");
					var scroll_length = $(image).length ? $(image).height() : $(this).height();
					var scroll_duration = 800;
					if (scroll_length > 300) scroll_duration = 1000;
					if (scroll_length > 400) scroll_duration = 1200;
					if (scroll_length > 500) scroll_duration = 1400; 
					$(this).animate({ scrollTop: scroll_length}, 2500);
				});
				
				//$(this).mouseout(function() {
				//	$(this).animate({ scrollTop: 0}, 1000);
				//});
			});
		});
		';
		echo '</script>';
}

function essb3_readymade_code() {
	global $ready_made, $ready_positions;
	

	essb3_display_readymade_presents('popular');
	
	//essb3_display_readymades('popular');

}

function essb3_readymade_new() {
	global $ready_made, $ready_positions;


	essb3_display_readymade_presents('new');

	//essb3_display_readymades('popular');

}