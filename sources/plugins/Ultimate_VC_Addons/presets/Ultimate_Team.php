<?php
$array = array(
	'base' => 'ult_team', // shortcode base
	'presets' => array( // presets array
		//1
		array(
			'title' => 'Team Preset', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_member_style' => 'style-2',
				'team_img_opacity' => '1',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_icon_url%22%3A%22%23%22%7D%2C%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-facebook%20facebook-f%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%5D',
				'divider_effect' => '',
				'team_member_name_color' => '#81d742',
				'team_member_position_font_style' => 'font-style:italic;',
				'team_member_org_color' => '#81d742',
				'team_member_description_font_style' => 'font-weight:bold;',
				'team_member_desc_color' => '#1e73be',
				'team_member_responsive_enable' => '',
				'image' => '80|http://localhost/fixes/wp-content/uploads/2016/01/ximg9.jpg',
				'name' => 'Catelyn',
				'pos_in_org' => 'Leader',
				'team_member_name_font_size' => 'desktop:25px;',
				'team_member_name_line_height' => 'desktop:30px;',
				'team_member_position_font_size' => 'desktop:20px;',
				'team_member_position_line_height' => 'desktop:30px;',
				'team_member_description_font_size' => 'desktop:20px;',
				'team_member_description_line_height' => 'desktop:30px;',
				'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley.',
			)
		), // end of preset
		//2
		array(
			'title' => 'Style one Circle Image', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_img_grayscale' => 'off',
				'img_border_style' => 'solid',
				'img_border_width' => '0',
				'img_border_radius' => '500',
				'img_hover_eft' => '',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => '',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:18px;',
				'team_member_name_line_height' => 'desktop:18px;',
				'team_member_description_font_size' => 'desktop:14px;',
				'team_member_description_line_height' => 'desktop:14px;',
				'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley.',
			)
		), // end of preset
		//3
		array(
			'title' => 'Style one Circle With Border Image', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_img_grayscale' => 'off',
				'img_border_style' => 'solid',
				'img_border_width' => '3',
				'img_border_color' => '#000000',
				'img_border_radius' => '500',
				'img_hover_eft' => 'on',
				'img_hover_color' => 'rgba(221,51,51,0.35)',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => '',
				'title_text_typography' => '',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:18px;',
				'team_member_name_line_height' => 'desktop:18px;',
				'team_member_description_font_size' => 'desktop:14px;',
				'team_member_description_line_height' => 'desktop:14px;',
				'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley.',
			)
		), // end of preset
		//4
		array(
			'title' => 'Style one Square Image', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_img_grayscale' => 'off',
				'img_hover_eft' => '',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => 'on',
				'team_member_divider_color' => '#a3a3a3',
				'team_member_divider_height' => '5',
				'team_member_divider_width' => '50',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:18px;',
				'team_member_name_line_height' => 'desktop:18px;',
				'team_member_description_font_size' => 'desktop:14px;',
				'team_member_description_line_height' => 'desktop:14px;',
				'pos_in_org' => 'Web Developer',
				'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy .',
			)
		), // end of preset
		//5
		array(
			'title' => 'Style one With Image Border', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_img_grayscale' => 'off',
				'img_border_style' => 'solid',
				'img_border_width' => '2',
				'img_border_color' => '#000000',
				'img_border_radius' => '5',
				'img_hover_eft' => 'on',
				'img_hover_color' => 'rgba(221,51,51,0.42)',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => 'on',
				'team_member_divider_color' => '#a3a3a3',
				'team_member_divider_height' => '5',
				'team_member_divider_width' => '50',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:18px;',
				'team_member_name_line_height' => 'desktop:18px;',
				'team_member_description_font_size' => 'desktop:14px;',
				'team_member_description_line_height' => 'desktop:14px;',
				'pos_in_org' => 'Web Developer',
				'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy .',
			)
		), // end of preset
		//6
		array(
			'title' => 'Style Two With Image Border', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
			'team_member_style' => 'style-2',
			'img_border_style' => 'solid',
			'img_border_width' => '2',
			'img_border_color' => '#000000',
			'img_border_radius' => '5',
			'team_img_opacity' => '1',
			'social_icon_effect' => 'on',
			'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
			'social_icon_size' => '25',
			'divider_effect' => 'on',
			'team_member_divider_color' => '#a3a3a3',
			'team_member_divider_height' => '5',
			'team_member_divider_width' => '50',
			'title_text_typography' => '',
			'team_member_responsive_enable' => '',
			'link_switch' => 'on',
			'staff_link' => 'url:%23||',
			'name' => 'Josh Hinden',
			'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
			'title_box_padding' => 'padding:15px;',
			'team_member_name_font_size' => 'desktop:18px;',
			'team_member_name_line_height' => 'desktop:18px;',
			'team_member_description_font_size' => 'desktop:14px;',
			'team_member_description_line_height' => 'desktop:14px;',
			'pos_in_org' => 'Web Developer',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy .',
			)
		), // end of preset
		//7
		array(
			'title' => 'Style Two With Border Radius', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_member_style' => 'style-2',
				'img_border_style' => 'solid',
				'img_border_width' => '0',
				'img_border_color' => '#000000',
				'img_border_radius' => '',
				'team_img_bg_color' => '#dd3333',
				'team_img_opacity' => '1',
				'team_img_hover_opacity' => '0.5',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => 'on',
				'team_member_divider_color' => '#a3a3a3',
				'team_member_divider_height' => '5',
				'team_member_divider_width' => '50',
				'team_member_name_color' => '#ffffff',
				'team_member_org_color' => '#ffffff',
				'team_member_desc_color' => '#ffffff',
				'team_member_responsive_enable' => '',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:22px;',
				'team_member_name_line_height' => 'desktop:22px;',
				'team_member_description_font_size' => 'desktop:14px;',
				'team_member_description_line_height' => 'desktop:14px;',
				'pos_in_org' => 'Web Developer',
				'team_member_position_font_size' => 'desktop:16px;',
				'team_member_position_line_height' => 'desktop:16px;',
				'team_css' => '.vc_custom_1453895623554{border-radius: 35px !important;}',
				'content' => 'Lorem Ipsum is simply dummy text of the printing.',
			)
		), // end of preset
		//8
		array(
			'title' => 'Style Two With circular Image', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_member_style' => 'style-2',
				'img_border_style' => 'solid',
				'img_border_width' => '0',
				'img_border_color' => '#000000',
				'img_border_radius' => '500',
				'team_img_opacity' => '1',
				'team_img_hover_opacity' => '0.8',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => 'on',
				'team_member_divider_color' => '#a3a3a3',
				'team_member_divider_height' => '5',
				'team_member_divider_width' => '50',
				'team_member_name_color' => '#ffffff',
				'team_member_org_color' => '#ffffff',
				'team_member_desc_color' => '#ffffff',
				'team_member_responsive_enable' => '',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:22px;',
				'team_member_name_line_height' => 'desktop:22px;',
				'team_member_description_font_size' => 'desktop:16px;',
				'team_member_description_line_height' => 'desktop:16px;',
				'team_css' => '.vc_custom_1453896083819{border-radius: 35px !important;}',
				'content' => 'Web Developer',
			)
		), // end of preset
		//9
		array(
			'title' => 'Style Two With circular Border', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_member_style' => 'style-2',
				'img_border_style' => 'solid',
				'img_border_width' => '2',
				'img_border_color' => '#000000',
				'img_border_radius' => '500',
				'team_img_opacity' => '1',
				'team_img_hover_opacity' => '0.8',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => 'on',
				'team_member_divider_color' => '#a3a3a3',
				'team_member_divider_height' => '5',
				'team_member_divider_width' => '50',
				'team_member_name_color' => '#ffffff',
				'team_member_org_color' => '#ffffff',
				'team_member_desc_color' => '#ffffff',
				'team_member_responsive_enable' => '',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:22px;',
				'team_member_name_line_height' => 'desktop:22px;',
				'team_member_description_font_size' => 'desktop:16px;',
				'team_member_description_line_height' => 'desktop:16px;',
				'team_css' => '.vc_custom_1453896240100{border-radius: 35px !important;}',
				'content' => 'Web Developer',
			)
		), // end of preset
		//10
		array(
			'title' => 'Style Three With Circle Image', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_member_style' => 'style-3',
				'img_border_style' => 'solid',
				'img_border_width' => '2',
				'img_border_color' => '#000000',
				'img_border_radius' => '500',
				'team_img_bg_color' => '#8224e3',
				'team_img_hover_opacity_style3' => '0.6',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => 'on',
				'team_member_divider_color' => '#a3a3a3',
				'team_member_divider_height' => '5',
				'team_member_divider_width' => '50',
				'team_member_name_color' => '#474747',
				'team_member_org_color' => '#ffffff',
				'team_member_desc_color' => '#ffffff',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:22px;',
				'team_member_name_line_height' => 'desktop:22px;',
				'team_member_description_font_size' => 'desktop:16px;',
				'team_member_description_line_height' => 'desktop:16px;',
				'team_css' => '.vc_custom_1453896856240{border-radius: 35px !important;}',
				'content' => 'Web Developer',
			)
		), // end of preset
		//11
		array(
			'title' => 'Style Three With Square Image', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_member_style' => 'style-3',
				'img_border_style' => 'solid',
				'img_border_width' => '2',
				'img_border_color' => '#000000',
				'img_border_radius' => '',
				'team_img_bg_color' => '#8224e3',
				'team_img_hover_opacity_style3' => '0.6',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => 'on',
				'team_member_divider_color' => '#a3a3a3',
				'team_member_divider_height' => '5',
				'team_member_divider_width' => '50',
				'team_member_name_color' => '#474747',
				'team_member_org_color' => '#ffffff',
				'team_member_desc_color' => '#ffffff',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:22px;',
				'team_member_name_line_height' => 'desktop:22px;',
				'team_member_description_font_size' => 'desktop:16px;',
				'team_member_description_line_height' => 'desktop:16px;',
				'content' => 'Web Developer',
			)
		), // end of preset
		//12
		array(
			'title' => 'Style Three With Square Image', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'team_member_style' => 'style-3',
				'img_border_style' => 'solid',
				'img_border_width' => '2',
				'img_border_color' => '#000000',
				'img_border_radius' => '',
				'team_img_bg_color' => '#8224e3',
				'team_img_hover_opacity_style3' => '0.6',
				'social_icon_effect' => 'on',
				'social_links' => '%5B%7B%22social_link_title%22%3A%22Facebook%22%2C%22social_icon_url%22%3A%22www.facebook.com%22%2C%22selected_team_icon%22%3A%22Defaults-facebook-square%22%2C%22social_icon_color%22%3A%22%231e73be%22%7D%2C%7B%22social_link_title%22%3A%22Instagram%22%2C%22social_icon_url%22%3A%22%23%22%2C%22selected_team_icon%22%3A%22Defaults-instagram%22%2C%22social_icon_color%22%3A%22%231e9cbc%22%7D%2C%7B%22social_link_title%22%3A%22Twitter%22%2C%22social_icon_url%22%3A%22www.twitter.com%22%2C%22selected_team_icon%22%3A%22Defaults-twitter-square%22%2C%22social_icon_color%22%3A%22%235ea9dd%22%7D%2C%7B%22social_link_title%22%3A%22Google%22%2C%22social_icon_url%22%3A%22www.google.com%22%2C%22selected_team_icon%22%3A%22Defaults-pinterest-square%22%2C%22social_icon_color%22%3A%22%23dd3333%22%7D%5D',
				'social_icon_size' => '25',
				'divider_effect' => 'on',
				'team_member_divider_color' => '#a3a3a3',
				'team_member_divider_height' => '5',
				'team_member_divider_width' => '50',
				'title_text_typography' => '',
				'team_member_name_color' => '#474747',
				'team_member_org_color' => '#5b5b5b',
				'team_member_desc_color' => '#ffffff',
				'link_switch' => 'on',
				'staff_link' => 'url:%23||',
				'name' => 'Josh Hinden',
				'image' => '4812|http://presets.sharkz.in/wp-content/uploads/2015/01/clie-image3.jpg',
				'title_box_padding' => 'padding:15px;',
				'team_member_name_font_size' => 'desktop:22px;',
				'team_member_name_line_height' => 'desktop:22px;',
				'team_member_description_font_size' => 'desktop:14px;',
				'team_member_description_line_height' => 'desktop:14px;',
				'pos_in_org' => 'Web Developer',
				'team_member_position_font_size' => 'desktop:16px;',
				'team_member_position_line_height' => 'desktop:16px;',
				'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy .',
			)
		), // end of preset
	)
);