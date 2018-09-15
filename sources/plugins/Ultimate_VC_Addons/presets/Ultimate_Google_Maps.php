<?php
$array = array(
	'base' => 'ultimate_google_map', // shortcode base
	'presets' => array( // presets array
		//1
		array(
			'title' => 'Onclick open Info Window', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
					'height' => '250px',
					'lat' => '37.8090329',
					'lng' => '-122.2823462',
					'zoom' => '12',
					'map_override' => '1',
					'pancontrol' => 'false',
					'content' => 'Lorem Ipsum Doller sit amet  Lorem Ipsum Doller sit amet Lorem Ipsum Doller sit amet Lorem Ipsum Doller sit amet Lorem Ipsum Doller sit amet',
			)
		), // end of preset
		//2
		array(
			'title' => 'Satelite Map - Opened Info Window', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'height' => '300px',
				'map_type' => 'SATELLITE',
				'lat' => '24.483582',
				'lng' => '54.607053',
				'zoom' => '15',
				'infowindow_open' => 'off',
				'map_override' => '1',
				'pancontrol' => 'false',
			)
		), // end of preset
		//3
		array(
			'title' => 'Custom styled', // Title of preset
			'default' => false, // set true if if want to load this preset on newly created element
			'settings' => array(
				'height' => '250px',
				'map_type' => 'HYBRID',
				'lat' => '40.692778',
				'lng' => '-73.990278',
				'zoom' => '12',
				'map_override' => '1',
				'map_style' => 'JTVCJTBBJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJsYW5kc2NhcGUubWFuX21hZGUlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjJlbGVtZW50VHlwZSUyMiUzQSUyMCUyMmdlb21ldHJ5JTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCU3QiUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvbiUyMiUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCU3QiUyMCUyMmNvbG9yJTIyJTNBJTIwJTIyJTIzOWI5NTk1JTIyJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTdEJTJDJTdCJTBBJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJyb2FkLmhpZ2h3YXklMjIlMkMlMEElMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTIwJTIyY29sb3IlMjIlM0ElMjAlMjIlMjNlMWUxNDMlMjIlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlN0IlMjAlMjJ3ZWlnaHQlMjIlM0ElMjAwLjYlMjAlN0QlMEElMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlN0QlMkMlN0IlMEElMjAlMjAlMjAlMjAlMjJmZWF0dXJlVHlwZSUyMiUzQSUyMCUyMnJvYWQuYXJ0ZXJpYWwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjJlbGVtZW50VHlwZSUyMiUzQSUyMCUyMmdlb21ldHJ5LmZpbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTIwJTIyZ2FtbWElMjIlM0ElMjAxLjUlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlN0IlMjAlMjJ2aXNpYmlsaXR5JTIyJTNBJTIwJTIyb24lMjIlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlN0IlMjAlMjJjb2xvciUyMiUzQSUyMCUyMiUyM2U5MWIwMiUyMiUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCU3QiUyMCUyMndlaWdodCUyMiUzQSUyMDAuMyUyMCU3RCUwQSUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCU3RCUwQSU1RA==',
				'pancontrol' => 'false',
			)
		), // end of preset
	)
);
