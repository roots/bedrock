<?php
/*
Reference - https://wpbakery.atlassian.net/wiki/display/VC/Control+Default+Presets+in+Content+Elements
*/
$array = array(
	'base' => 'just_icon', // shortcode base
	'presets' => array( // presets array
		//1
		array(
			'title' => 'Simple Circle Background',
			'default' => false,
			'settings' => array(
							'icon' => 'Defaults-mobile mobile-phone',
							'icon_size' => '42',
							'icon_color' => '#f6653c',
							'icon_style' => 'circle',
							'icon_color_bg' => '#f4f4f4',
						)
		),
		//2
		array(
			'title' => 'Simple Square Background',
			'default' => false,
			'settings' =>array(
					'icon' => 'Defaults-trophy',
					'icon_size' => '42',
					'icon_color' => '#f6653c',
					'icon_style' => 'square',
					'icon_color_bg' => '#f4f4f4',
				)
			),
		//3
		array(
			'title' => 'Dotted Border with circle',
			'default' => false,
			'settings' =>array(
					'icon' => 'Defaults-flag',
					'icon_size' => '42',
					'icon_color' => '#f6653c',
					'icon_style' => 'advanced',
					'icon_color_bg' => '#f4f4f4',
					'icon_border_style' => 'dashed',
					'icon_border_size' => '1',
					'icon_border_radius' => '500',
					'icon_border_spacing' => '80',
				)
			),
		//4
		array(
			'title' => 'Simple with right tooltip',
			'default' => false,
			'settings' =>array(
						'icon' => 'Defaults-check-circle-o',
						'icon_size' => '100',
						'icon_color' => '#444444',
						'tooltip_disp' => 'right',
						'tooltip_text' => 'Lorem ipsum',
					)
			),
		//5
		array(
			'title' => 'Simple  with left tooltip',
			'default' => false,
			'settings' =>array(
					'icon' => 'Defaults-search',
					'icon_size' => '100',
					'icon_color' => '#444444',
					'tooltip_disp' => 'left',
					'tooltip_text' => 'Lorem ipsum',
				)
			),
		//6
		array(
			'title' => 'Simple with top tooltip',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-user',
				'icon_size' => '100',
				'icon_color' => '#444444',
				'tooltip_disp' => 'top',
				'tooltip_text' => 'Lorem ipsum',
				)
			),
		//7
		array(
			'title' => 'Icon with simple border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-venus',
				'icon_size' => '42',
				'icon_color' => '#ee6019',
				'icon_style' => 'advanced',
				'icon_color_bg' => '#f8f8f8',
				'icon_border_style' => 'solid',
				'icon_color_border' => '#e6e6e6',
				'icon_border_size' => '3',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				)
			),
		//8
		array(
			'title' => 'Simple  with bottom tooltip',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-mars',
				'icon_size' => '42',
				'icon_color' => '#ee6019',
				'icon_style' => 'advanced',
				'icon_color_bg' => '#f8f8f8',
				'icon_border_style' => 'solid',
				'icon_color_border' => '#e6e6e6',
				'icon_border_size' => '3',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				'tooltip_disp' => 'bottom',
				'tooltip_text' => 'Lorem ipsum',
				)
			),
		//9
		array(
			'title' => 'Icon With Fadein Animation',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-mars-stroke',
				'icon_size' => '42',
				'icon_color' => '#ee6019',
				'icon_style' => 'advanced',
				'icon_color_bg' => '#f8f8f8',
				'icon_border_style' => 'solid',
				'icon_color_border' => '#e6e6e6',
				'icon_border_size' => '3',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				'icon_animation' => 'fadeInLeft',
				)
			),
		//10
		array(
			'title' => 'Icon with larger border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-heart',
				'icon_size' => '42',
				'icon_color' => '#ffffff',
				'icon_style' => 'advanced',
				'icon_color_bg' => '#e84a52',
				'icon_border_style' => 'solid',
				'icon_color_border' => '#f0f0f0',
				'icon_border_size' => '12',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				)
			),
		//11
			array(
			'title' => 'Icon with Tranperent Background',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-lightbulb-o',
				'icon_size' => '42',
				'icon_color' => '#ff2d2d',
				'icon_style' => 'advanced',
				'icon_color_bg' => 'rgba(232,74,82,0.01)',
				'icon_border_style' => 'solid',
				'icon_color_border' => '#f0f0f0',
				'icon_border_size' => '12',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				)
			),
			//12
			array(
			'title' => 'Icon with Tranperent Border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-hand-o-up',
				'icon_size' => '42',
				'icon_color' => '#ffffff',
				'icon_style' => 'advanced',
				'icon_color_bg' => '',
				'icon_border_style' => 'solid',
				'icon_color_border' => 'rgba(127,127,127,0.31)',
				'icon_border_size' => '12',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				)
			),
			//13
			array(
			'title' => 'Icon with Inset Border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-bullhorn',
				'icon_size' => '42',
				'icon_color' => '#303030',
				'icon_style' => 'advanced',
				'icon_border_style' => 'inset',
				'icon_color_border' => '#e8e8e8',
				'icon_border_size' => '8',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				'icon_link' => 'url:%23||',
				'icon_animation' => 'pulse',
				)
			),
			//14
			array(
			'title' => 'Icon with outset Border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-signal',
				'icon_size' => '42',
				'icon_color' => '#303030',
				'icon_style' => 'advanced',
				'icon_border_style' => 'outset',
				'icon_color_border' => '#e8e8e8',
				'icon_border_size' => '8',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				'icon_link' => 'url:%23||',
				'icon_animation' => 'fadeInLeft',
				)
			),
			//15
			array(
			'title' => 'Icon with Inside Border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-tags',
				'icon_size' => '42',
				'icon_color' => '#303030',
				'icon_style' => 'advanced',
				'icon_border_style' => 'inset',
				'icon_color_border' => '#e8e8e8',
				'icon_border_size' => '8',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				'icon_link' => 'url:%23||',
				'icon_animation' => 'fadeInLeft',
				)
			),
			//16
			array(
			'title' => 'Icon with Square Border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-map-marker',
				'icon_size' => '42',
				'icon_style' => 'advanced',
				'icon_border_style' => 'dashed',
				'icon_border_size' => '1',
				'icon_border_radius' => '10',
				'icon_border_spacing' => '100',
				)
			),
			//17
			array(
			'title' => 'Icon with Border radius',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-tint',
				'icon_size' => '42',
				'icon_style' => 'advanced',
				'icon_border_style' => 'dashed',
				'icon_border_size' => '1',
				'icon_border_radius' => '10',
				'icon_border_spacing' => '100',
				)
			),
			//18
			array(
			'title' => 'Icon with Double Border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-location-arrow',
				'icon_size' => '42',
				'icon_style' => 'advanced',
				'icon_border_style' => 'double',
				'icon_border_size' => '10',
				'icon_border_radius' => '10',
				'icon_border_spacing' => '100',
				)
			),
			//19
			array(
			'title' => 'Simple Facebook Icon',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-facebook facebook-f',
				'icon_size' => '42',
				'icon_color' => '#ffffff',
				'icon_style' => 'advanced',
				'icon_color_bg' => '#1e73be',
				'icon_border_style' => 'solid',
				'icon_border_size' => '0',
				'icon_border_radius' => '15',
				'icon_border_spacing' => '100',
				)
			),
			//20
			array(
			'title' => 'Simple Pintrest Icon',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-pinterest-p',
				'icon_size' => '42',
				'icon_color' => '#ffffff',
				'icon_style' => 'advanced',
				'icon_color_bg' => '#dd3333',
				'icon_border_style' => 'solid',
				'icon_border_size' => '0',
				'icon_border_radius' => '15',
				'icon_border_spacing' => '100',
				)
			),
			//21
			array(
			'title' => 'Simple Twitter Icon',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-twitter',
				'icon_size' => '42',
				'icon_color' => '#ffffff',
				'icon_style' => 'advanced',
				'icon_color_bg' => '#5ea9dd',
				'icon_border_style' => 'solid',
				'icon_border_size' => '0',
				'icon_border_radius' => '15',
				'icon_border_spacing' => '100',
				)
			),
			//22
			array(
			'title' => 'Simple Dotted Border Circle',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-cloud-upload',
				'icon_size' => '42',
				'icon_color' => '#542ccb',
				'icon_style' => 'advanced',
				'icon_border_style' => 'dotted',
				'icon_color_border' => '#e7e7ef',
				'icon_border_size' => '4',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				)
			),
			//23
			array(
			'title' => 'Simple Dotted Border Square',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-cloud-download',
				'icon_size' => '42',
				'icon_color' => '#542ccb',
				'icon_style' => 'advanced',
				'icon_color_bg' => 'rgba(255,255,255,0.01)',
				'icon_border_style' => 'dotted',
				'icon_border_size' => '3',
				'icon_border_radius' => '',
				'icon_border_spacing' => '100',
				)
			),
			//24
			array(
			'title' => 'Simple Dotted Border',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-soundcloud',
				'icon_size' => '42',
				'icon_color' => '#542ccb',
				'icon_style' => 'advanced',
				'icon_border_style' => 'dotted',
				'icon_color_border' => '#e7e7ef',
				'icon_border_size' => '4',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				)
			),
			//25
			array(
			'title' => 'Icon Double Border Circle',
			'default' => false,
			'settings' =>array(
				'icon' => 'Defaults-map-marker',
				'icon_size' => '42',
				'icon_color' => '#dd3333',
				'icon_style' => 'advanced',
				'icon_color_bg' => '#f3f3f3',
				'icon_border_style' => 'double',
				'icon_color_border' => '#ffffff',
				'icon_border_size' => '12',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '100',
				'icon_animation' => 'fadeInRight',
				)
			),
	)
);