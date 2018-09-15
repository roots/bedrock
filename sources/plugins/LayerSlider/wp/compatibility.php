<?php


function layerslider_convert() {

	// Get old sliders if any
	$sliders = get_option('layerslider-slides', array());
	$sliders = is_array($sliders) ? $sliders : unserialize($sliders);

	// Create new storage in DB
	layerslider_create_db_table();

	// Iterate over them
	if(!empty($sliders) && is_array($sliders)) {
		foreach($sliders as $key => $slider) {
			LS_Sliders::add($slider['properties']['title'], $slider);
		}
	}

	// Remove old data and exit
	delete_option('layerslider-slides');
	header('Location: admin.php?page=layerslider');
	die();
}


function lsSliderById($id) {

	$args = is_numeric($id) ? (int) $id : array('limit' => 1);
	$slider = LS_Sliders::find($args);

	if($slider == null) {
		return false;
	}

	return $slider;
}

function lsSliders($limit = 50, $desc = true, $withData = false) {

	$args = array();
	$args['limit'] = $limit;
	$args['order'] = ($desc === true) ? 'DESC' : 'ASC';
	$args['data'] = ($withData === true) ? true : false;

	$sliders = LS_Sliders::find($args);

	// No results
	if($sliders == null) {
		return array();
	}

	return $sliders;
}

?>
