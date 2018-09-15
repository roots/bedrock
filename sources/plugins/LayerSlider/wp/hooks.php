<?php

// Private filters, can change at any time
add_filter('ls_slider_title', 'ls_filter_slider_title', 10, 2);
add_filter('ls_preview_for_slider', 'ls_preview_for_slider', 10, 1);
add_filter('ls_get_thumbnail', 'ls_get_thumbnail', 10, 3);
add_filter('ls_get_image', 'ls_get_image', 10, 2);

// Public filters
add_filter('ls_parse_defaults', 'ls_parse_defaults', 10, 2);

function ls_filter_slider_title($sliderName = '', $maxLength = 50) {
	$name = empty($sliderName) ? 'Unnamed' : htmlspecialchars(stripslashes($sliderName));
	return isset($name[$maxLength]) ? substr($name, 0, $maxLength) . ' ...' : $name;
}

function ls_preview_for_slider( $slider = array() ) {

	// Attempt to find pre-defined slider banner
	if( ! empty($slider['data']['meta']) && ! empty($slider['data']['meta']['preview']) ) {
		return $slider['data']['meta']['preview'];
	}


	// Find an image
	if( isset($slider['data']['layers']) ) {
		foreach( $slider['data']['layers'] as $layer) {
			if( !empty($layer['properties']['background']) && $layer['properties']['background'] !== '[image-url]' ) {
				$image = $layer['properties']['background'];

				if( ! empty($layer['properties']['backgroundId'] ) ) {
					$src = wp_get_attachment_image_src( $layer['properties']['backgroundId'], 'medium');
					if( ! empty( $src[0] ) ) {
						$image = $src[0];
					}
				}

				break;
			}
		}
	}

	return ! empty( $image ) ? $image : '';
}


function ls_get_thumbnail($id = null, $url = null, $blankPlaceholder = false) {

	// Image ID
	if(!empty($id)) {
		if($image = wp_get_attachment_thumb_url($id, 'thumbnail')) {
			return $image;
		}
	}

	if(!empty($url)) {

		$thumb = substr_replace($url, '-150x150.', strrpos($url,'.'), 1);
		$file = LS_ROOT_PATH.'/sampleslider/'.basename($thumb);

		if(file_exists($file)) { return $thumb; } else { return $url; }
	}

	return LS_ROOT_URL.'/static/admin/img/blank.gif';
}

function ls_get_image($id = null, $url = null) {

	if( ! empty( $id )) {
		if($image = wp_get_attachment_url($id, 'thumbnail')) {
			return $image;
		}
	} elseif( ! empty( $url ) ) {
		return $url;
	}

	return LS_ROOT_URL.'/static/admin/img/blank.gif';
}


function ls_parse_defaults($defaults = array(), $raw = array()) {


	$activated = get_option('layerslider-authorized-site', false);
	$permission = current_user_can('publish_posts');
	$ret = array();

	foreach($defaults as $key => $default) {

		// Check premium features
		$isPremium = false;
		if( ! empty( $default['premium'] ) && ! $activated ) {
			if( ! $permission ) {
				continue;
			}
			// var_dump($default);
			$isPremium = true;
		}

		$phpKey = is_string($default['keys']) ? $default['keys'] : $default['keys'][0];
		$jsKey  = is_string($default['keys']) ? $default['keys'] : $default['keys'][1];
		$retKey = isset($default['props']['meta']) ? 'props' : 'attrs';

		if( isset($default['props']['forceoutput']) ) {
			if( ! isset($raw[$phpKey]) ) {
				$ret[$retKey][$jsKey] = $default['value'];
			} else {
				$ret[$retKey][$jsKey] = $raw[$phpKey];
			}

		} elseif(isset($raw[$phpKey]) && isset($default['props']['output']) ) {
			$ret[$retKey][$jsKey] = $raw[$phpKey];

		} elseif(isset($raw[$phpKey]) && is_array($raw[$phpKey])) {
			$ret[$retKey][$jsKey] = $raw[$phpKey];

		} elseif(isset($raw[$phpKey]) && is_bool($default['value'])) {
			if($default['value'] == true && empty($raw[$phpKey])) {
				$ret[$retKey][$jsKey] = false;
			} elseif($default['value'] == false && !empty($raw[$phpKey])) {
				$ret[$retKey][$jsKey] = true;
			}

		} elseif(isset($raw[$phpKey])) {

			if(
				isset($default['props']['meta']) ||
				(
					(string)$default['value'] !== (string)$raw[$phpKey] &&
					(string)$raw[$phpKey] !== '')
				)
			{
				$raw[$phpKey] = isset($default['props']['raw']) ? addslashes($raw[$phpKey]) : $raw[$phpKey];
				$ret[$retKey][$jsKey] = stripslashes($raw[$phpKey]);
			}
		}

		if( ! $activated && empty($GLOBALS['lsPremiumNotice']) ) {
			if( $isPremium && isset($ret[$retKey][$jsKey]) ) {
				$GLOBALS['lsPremiumNotice'] = true;
			}
		}
	}

	return $ret;
}

function ls_array_to_attr($arr, $mode = '') {
	if(!empty($arr) && is_array($arr)) {
		$ret = array();
		foreach($arr as $key => $val) {
			if($mode == 'css' && is_numeric($val) ) {
				$ret[] = ''.$key.':'.layerslider_check_unit($val, $key).';';
			} elseif(is_bool($val)) {
				$bool = $val ? 'true' : 'false';
				$ret[] = "$key:$bool;";
			} else {
				$ret[] = "$key:$val;";
			}
		}
		return implode('', $ret);
	}
}

function layerslider_loaded() {
	if(has_action('layerslider_ready')) {
		do_action('layerslider_ready');
	}
}

?>
