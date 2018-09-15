<?php
$array = array(
	'base' => 'ult_createlink', // shortcode base
	'presets' => array( // presets array
		//1
		array(
			'title' => 'Square bracket on hover', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'title' => 'TIMELINE',
				'btn_link' => 'url:%23|title:HIGHLIGHT%20BOX|',
				'link_hover_style' => 'Style_1',
				'text_color' => '#1485a8',
				'text_hovercolor' => '#0c0e5b',
				'el_class' => 'style-effect-one',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//2
		array(
			'title' => 'Flip link', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'title' => 'COUNTDOWN',
				'btn_link' => 'url:%23|title:JUST%20ICON|',
				'link_hover_style' => 'Style_2',
				'text_color' => '#ffffff',
				'text_hovercolor' => '#ffffff',
				'background_color' => '#dd7373',
				'bghovercolor' => '#f92525',
				'el_class' => 'style-second',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//3
		array(
			'title' => 'Pull in bottom border', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'title' => 'INTERACTIVE1',
				'btn_link' => 'url:%23|title:INTERACTIVE%20BANNER|',
				'link_hover_style' => 'Style_3',
				'text_color' => '#dcef0b',
				'text_hovercolor' => '#870000',
				'border_color' => '#870000',
				'border_size' => '2',
				'el_class' => 'style-second',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//4
		array(
			'title' => 'Pull out bottom border', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'title' => 'BCKGROUND',
				'btn_link' => 'url:%23|title:IMAGE%20BACKGROUND|',
				'link_hover_style' => 'Style_4',
				'text_color' => '#d748ea',
				'text_hovercolor' => '#991d9b',
				'border_color' => '#860f91',
				'border_size' => '3',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//5
		array(
			'title' => 'Pull out top and expand bottom border', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'title' => 'CAROUSEL',
				'btn_link' => 'url:%23|title:ADVANCED%20CAROUSEL|',
				'link_hover_style' => 'Style_5',
				'text_color' => '#eeee22',
				'text_hovercolor' => '#eeee22',
				'border_color' => '#eded02',
				'border_size' => '1',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//6
		array(
			'title' => 'Three dots effect', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'btn_link' => 'url:%23|title:ADVANCED%20CAROUSEL|',
				'link_hover_style' => 'Style_6',
				'text_color' => '#1e73be',
				'text_hovercolor' => '#110a59',
				'dot_color' => '#110a59',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//7
		array(
			'title' => 'Box move effect', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'btn_link' => 'url:%23|title:VIDEO%20TUTORIALS|',
				'link_hover_style' => 'Style_8',
				'text_color' => '#b921d1',
				'text_hovercolor' => '#b921d1',
				'border_color' => 'rgba(169,6,65,0.51)',
				'border_hovercolor' => '#b921d1',
				'border_size' => '2',
				'el_class' => 'border-style',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//8
		array(
			'title' => 'Cross effect', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'btn_link' => 'url:%23|title:HEADING|',
				'link_hover_style' => 'Style_9',
				'text_color' => '#1e73be',
				'text_hovercolor' => '#35478c',
				'border_color' => '#add5f7',
				'border_size' => '2',
				'el_class' => 'border-style',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//9
		array(
			'title' => 'Vertical door flip effect', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'btn_link' => 'url:%23|title:UNIQUE%20ELEMENTS|',
				'link_hover_style' => 'Style_10',
				'text_color' => '#000000',
				'text_hovercolor' => '#7a7a7a',
				'background_color' => '#3e606f',
				'bghovercolor' => '#dbdbdb',
				'border_color' => '#193441',
				'border_size' => '2',
				'el_class' => 'border-style',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
		//10
		array(
			'title' => 'Push to right', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'btn_link' => 'url:%23|title:TEST%20DRIVE|',
				'link_hover_style' => 'Style_11',
				'text_color' => '#000000',
				'text_hovercolor' => '#ffffff',
				'background_color' => '#0f7c67',
				'bghovercolor' => '#b2b2b2',
				'el_class' => 'style-ten',
				'title_font_size' => 'desktop:22px;',
				'title_line_ht' => 'desktop:34px;',
			)
		), // end of preset
	)
);