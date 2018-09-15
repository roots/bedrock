<?php
$array = array(
	'base' => 'stat_counter', // shortcode base
	'presets' => array( // presets array
		//1
		array(
			'title' => 'Counter With Icon Circle Background', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
					'icon_type' => 'selector',
					'icon' => 'Defaults-group users',
					'icon_img' => '',
					'img_width' => '48',
					'icon_size' => '60',
					'icon_color' => '#db325c',
					'icon_style' => 'advanced',
					'icon_color_bg' => '#ffffff',
					'icon_color_border' => '#db325c',
					'icon_border_style' => 'solid',
					'icon_border_size' => '5',
					'icon_border_radius' => '90',
					'icon_border_spacing' => '120',
					'icon_link' => '',
					'icon_animation' => 'bounceIn',
					'counter_title' => 'Users',
					'counter_value' => '8642',
					'speed' => '4',
					'font_size_title' => '13',
					'font_size_counter' => '30',
			)
		), // end of preset
	)
);