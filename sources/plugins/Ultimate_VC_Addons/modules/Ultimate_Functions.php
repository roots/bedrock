<?php
if(!function_exists('ultimate_get_icon_position_json')){
	function ultimate_get_icon_position_json(){
		$json = '{
			"Display Text and Icon - Always":{
				"Icon_at_Left":"ubtn-sep-icon-at-left",
				"Icon_at_Right":"ubtn-sep-icon-at-right"
			},
			"Display Icon With Text - On_Hover":{
				"Bring_in_Icon_from_Left":"ubtn-sep-icon-left",
				"Bring_in_Icon_from_Right":"ubtn-sep-icon-right",
				"Push_Icon_to_Left":"ubtn-sep-icon-left-rev",
				"Push_Icon_to_Right":"ubtn-sep-icon-right-rev"
			},
			"Replace Text by Icon - On Hover":{
				"Push_out_Text_to_Top":"ubtn-sep-icon-bottom-push",
				"Push_out_Text_to_Bottom":"ubtn-sep-icon-top-push",
				"Push_out_Text_to_Left":"ubtn-sep-icon-right-push",
				"Push_out_Text_to_Right‏":"ubtn-sep-icon-left-push"
			}
		}';
		return $json;
	}
}

function ultimate_get_banner2_json(){
	$json = '{
		"Long_Text":{
			"Style_1":"style1",
			"Style_2":"style5",
			"Style_3":"style13"
		},
		"Medium_Text":{
			"Style_4":"style2",
			"Style_5":"style4",
			"Style_6":"style6",
			"Style_7":"style7",
			"Style_8":"style10",
			"Style_9":"style14"
		},
		"Short_Description":{
			"Style_10":"style9",
			"Style_11":"style11",
			"Style_12":"style15"
		}
	}';
	return $json;
}
if(!function_exists('ultimate_get_animation_json')){
	function ultimate_get_animation_json(){
		$json = '{
		  "attention_seekers": {
			"No Animation": true,
			"bounce": true,
			"flash": true,
			"pulse": true,
			"rubberBand": true,
			"shake": true,
			"swing": true,
			"tada": true,
			"wobble": true
		  },
		  "bouncing_entrances": {
			"bounceIn": true,
			"bounceInDown": true,
			"bounceInLeft": true,
			"bounceInRight": true,
			"bounceInUp": true
		  },
		  "bouncing_exits": {
			"bounceOut": true,
			"bounceOutDown": true,
			"bounceOutLeft": true,
			"bounceOutRight": true,
			"bounceOutUp": true
		  },
		  "fading_entrances": {
			"fadeIn": true,
			"fadeInDown": true,
			"fadeInDownBig": true,
			"fadeInLeft": true,
			"fadeInLeftBig": true,
			"fadeInRight": true,
			"fadeInRightBig": true,
			"fadeInUp": true,
			"fadeInUpBig": true
		  },
		  "fading_exits": {
			"fadeOut": true,
			"fadeOutDown": true,
			"fadeOutDownBig": true,
			"fadeOutLeft": true,
			"fadeOutLeftBig": true,
			"fadeOutRight": true,
			"fadeOutRightBig": true,
			"fadeOutUp": true,
			"fadeOutUpBig": true
		  },
		  "flippers": {
			"flip": true,
			"flipInX": true,
			"flipInY": true,
			"flipOutX": true,
			"flipOutY": true
		  },
		  "lightspeed": {
			"lightSpeedIn": true,
			"lightSpeedOut": true
		  },
		  "rotating_entrances": {
			"rotateIn": true,
			"rotateInDownLeft": true,
			"rotateInDownRight": true,
			"rotateInUpLeft": true,
			"rotateInUpRight": true
		  },
		  "rotating_exits": {
			"rotateOut": true,
			"rotateOutDownLeft": true,
			"rotateOutDownRight": true,
			"rotateOutUpLeft": true,
			"rotateOutUpRight": true
		  },
		  "sliders": {
			"slideInDown": true,
			"slideInLeft": true,
			"slideInRight": true,
			"slideOutLeft": true,
			"slideOutRight": true,
			"slideOutUp": true,
			"slideInUp": true,
			"slideOutDown": true
		  },
		  "specials": {
			"hinge": true,
			"rollIn": true,
			"rollOut": true
		  },
		  "zooming_entrances": {
			"zoomIn": true,
			"zoomInDown": true,
			"zoomInLeft": true,
			"zoomInRight": true,
			"zoomInUp": true
		  },
		  
		  "zooming_exits": {
			"zoomOut": true,
			"zoomOutDown": true,
			"zoomOutLeft": true,
			"zoomOutRight": true,
			"zoomOutUp": true
		  },
		  
		  "infinite_animations": {
			"InfiniteRotate": true,
			"InfiniteRotateCounter": true,
			"InfiniteDangle": true,
			"InfiniteSwing": true,
			"InfinitePulse": true,	
			"InfiniteHorizontalShake": true,
			"InfiniteVericalShake": true,
			"InfiniteBounce": true,
			"InfiniteFlash": true,
			"InfiniteTADA": true,	
			"InfiniteRubberBand": true,
			"InfiniteHorizontalFlip": true,
			"InfiniteVericalFlip": true,
			"InfiniteHorizontalScaleFlip": true,
			"InfiniteVerticalScaleFlip": true
		  }
		}';
		return $json;
	}
}