<?php

function essb_apply_advanced_custom_share($share, $network) {
	$as_url = essb_options_value('as_'.$network.'_url');
	$as_text = essb_options_value('as_'.$network.'_text');
	$as_image = essb_options_value('as_'.$network.'_image');
	$as_desc = essb_options_value('as_'.$network.'_desc');
		
	if (!empty($as_url)) {
		$share['url'] = $as_url;
	}
	if (!empty($as_text)) {
		$as_text = preg_replace(array('#%title%#', '#%siteurl%#', '#%permalink%#', '#%image%#', '#%shorturl%#'), array($share['title'], get_site_url(), $share['url'], $share['image'], $share['short_url']), $as_text);
		$share['title'] = $as_text;
	}
	if (!empty($as_image)) {
		$share['image'] = $as_image;
	}
	if (!empty($as_desc)) {
		$as_desc = preg_replace(array('#%title%#', '#%siteurl%#', '#%permalink%#', '#%image%#', '#%shorturl%#'), array($share['title'], get_site_url(), $share['url'], $share['image'], $share['short_url']), $as_desc);
		$share['description'] = $as_desc;
	}
	
	return $share;
}