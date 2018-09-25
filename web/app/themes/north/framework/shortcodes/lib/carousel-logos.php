<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Testimonials Carousel
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_logos($atts, $content = null) {
	extract(shortcode_atts(array(
		"images" => '',
		"onclick" => 'link_no',
		"custom_links" => ''
	), $atts));
	
	wp_enqueue_script('owl-carousel', '', '', '', true);
	wp_enqueue_style('owl-carousel');
	
	ob_start();		
    
    ?>
    
	<div class="vntd-logos-carousel">
	
		<div class="client-logos">		
			
			<div class="logos boxed">
	
	<?php 
	
	$link_href = '';
	
	if($onclick == 'custom_link') {
		$custom_links = explode(',',$custom_links);
	}
					 			
	$images = explode( ',', $images );
	$i = - 1;	
	
	foreach ( $images as $attach_id ) {
		$i ++;
		$link_href = '';
		if($onclick == 'custom_link') {
			$link_href = ' href="'.$custom_links[$i].'"';
		}
		$img = wp_get_attachment_image_src($attach_id, 'full');
		
		echo '<a'.$link_href.' class="item"><img src="'.$img[0].'" alt></a>';
	}
	
			
	echo '</div></div></div>';
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('logos_carousel');
add_shortcode('logos_carousel', 'vntd_logos');