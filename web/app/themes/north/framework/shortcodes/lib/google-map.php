<?php

// Google Map Shortcode


function vntd_gmap($atts, $content = null) {
	extract(shortcode_atts(array(
		"height" => '400',
		"zoom" 	=> '15',		
		"label" => '',
		"fullscreen" => '',	
		"lat" 	=> '41.862274',
		"long" 	=> '-87.701328',
		"marker1_title"	=> 'Office 1',
		"marker1_text"	=> 'Your description goes here.',
		"marker1_location"	=> 'center',
		"marker1_location_custom"	=> '',
		"marker2_title"	=> '',
		"marker2_text"	=> '',
		"marker2_location"	=> '41.858774,-87.685328',
	), $atts));
	
	$rand_id = rand(1,99999);
	
	wp_enqueue_script('google-map-sensor', '', '', '', true);
	
	if(!$lat || !$long) {
		return 'Error: no location lat and/or long data found';
	}
	
	$map_center = $lat.','.$long;
	
	$marker1_center = $map_center;
	
	if($marker1_location == 'custom') {
		$marker1_center = $marker1_location_custom;
	}		

	ob_start();	
	?>
	<script type="text/javascript">
	
	jQuery(document).ready(function() {
	
		'use strict';

		// Map Coordination

		var latlng = new google.maps.LatLng(<?php echo $map_center; ?>);

		// Map Options
		var myOptions = {
			zoom: <?php echo $zoom; ?>,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true,
			scrollwheel: false,
			// Google Map Color Styles
			styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},
			{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},
			{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]/**/},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}
			]/**/},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}]
		};

		var map = new google.maps.Map(document.getElementById('google-map-<?php echo $rand_id; ?>'), myOptions);

		// Marker Image
		var image = '<?php echo get_template_directory_uri() . '/img/marker.png'; ?>';
		
	  	/* ========= First Marker ========= */

	  	// First Marker Coordination
		
		var myLatlng = new google.maps.LatLng(<?php echo $marker1_center; ?>);

		// Your Texts 

		 var contentString = '<div id="content">'+
		  '<div id="siteNotice">'+
		  '</div>'+
		  '<h4>' +

		  '<?php echo $marker1_title; ?>'+

		  '</h4>'+
		  <?php if($marker1_text) { ?>
		  	
		  '<p>' +
		 		
  		  '<?php echo $marker1_text; ?>' +
  
  		  '</p>'+
		  	
		  <?php	} ?>
		  
		  '</div>';
		

		var marker = new google.maps.Marker({
			  position: myLatlng,
			  map: map,
			  title: '<?php echo $marker1_title; ?>',
			  icon: image
		  });


		var infowindow = new google.maps.InfoWindow({
		  content: contentString
		  });

		  
		 google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		  });

		 /* ========= End First Marker ========= */



		<?php if($marker2_title) { ?>

		 /* ========= Second Marker ========= */

		 // Second Marker Coordination

		 var myLatlngSecond = new google.maps.LatLng(<?php echo $marker2_location; ?>);

		 // Your Texts

		 var contentStringSecond = '<div id="content">'+
		  '<div id="siteNotice">'+
		  '</div>'+
		  '<h4>' +

		  '<?php echo $marker2_title; ?>'+

		  '</h4>'+
		  <?php if($marker2_text) { ?>
		  		  	
  		  '<p>' +
  		 		
  		  '<?php echo $marker2_text; ?>' +
  
  		  '</p>'+
  		  	
  		  <?php	} ?>
		  '</div>';

		  var infowindowSecond = new google.maps.InfoWindow({
			  content: contentStringSecond,
			  });

		 var markerSecond = new google.maps.Marker({
			  position: myLatlngSecond,
			  map: map,
			  title: '<?php echo $marker2_title; ?>',
			  icon: image
		  });

		 google.maps.event.addListener(markerSecond, 'click', function() {
			infowindowSecond.open(map,markerSecond);
		  });
		  
		  

		 /* ========= End Second Marker ========= */
	
		<?php } ?>
	});
	
	</script>
	<div class="vntd-gmap">	

	    <div id="google-map-<?php echo $rand_id; ?>" style="height:<?php echo str_replace('px','',$height); ?>px;"></div>
	    
	</div>
	<?php
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('gmap');
add_shortcode('gmap', 'vntd_gmap');