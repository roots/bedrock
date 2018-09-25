<?php
$output = $title =  $onclick = $custom_links = $img_size = $img_size_custom = $custom_links_target = $images = $el_class = $partial_view = '';

extract(shortcode_atts(array(
    'img_size' => 'thumbnail',
    'img_size_custom' => '',
    'images' => '',
    'captions' => '',
    'custom_captions' => '',
    'fullscreen' => ''
), $atts));

$gal_images = '';
$el_start = '';
$el_end = '';

$random_id = 'fullscreen-'.rand(1,9999);

if ( $images == '' ) $images = '-1,-2,-3';

$images = explode( ',', $images);
$i = -1;

if($img_size == 'custom' && $img_size_custom) {
	$slider_width = $this->getSliderWidth($img_size_custom);
	$img_size = $img_size_custom;
}	

// Captions

if($captions == 'custom') {
	$captions_arr = explode(',',$custom_captions);	
}

//$img_desc = $attachment->post_content;

echo '<div id="image-carousel-'.$random_id.'" class="vntd-image-carousel home_project fullscreen">';

if($fullscreen != 'yes') {

wp_enqueue_script('magnific-popup', '', '', '', true);
wp_enqueue_style('magnific-popup');

?>

<div class="custom_slider">
	<ul class="image_slider clearfix mp-gallery">
	
		<?php 
		
		foreach($images as $attach_id) { 
			$i++;
			if ($attach_id > 0) {
			    $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ));
			} else {
			    $post_thumbnail = array();
			    $post_thumbnail['thumbnail'] = '<img src="'.$this->assetUrl('vc/no_image.png').'" />';
			    $post_thumbnail['p_img_large'][0] = $this->assetUrl('vc/no_image.png');
			}
			
			$thumbnail = $post_thumbnail['thumbnail'];
			$p_img_large = $post_thumbnail['p_img_large'];
			
			if($captions == 'library') {
				$attachment = get_post($attach_id);
				$img_caption = $attachment->post_excerpt;	
				$img_desc = $attachment->post_content;	
			} elseif($captions == 'custom' && $captions_arr) {
				$caption = explode('|',$captions_arr[$i]);
				if($caption[0]) $img_caption = $caption[0];
				if($caption[1]) $img_desc = $caption[1];
			}
			
			echo '<li class="slide">';			
			
			if($img_caption) {
				echo '<div class="texts absolute t-left"><h2 class="white uppercase font-primary">'.$img_caption.'</h2>';				
				if($img_desc) {				
					echo '<p class="white semibold">'.$img_desc.'</p>';
				}
				echo '</div>';
			}
			
			echo '<a href="'.$p_img_large[0].'" title="Description Here">'.$thumbnail.'</a></li>';
			
		} 
			
		?>
		
		
	</ul>
</div>

<?php 
} else {
wp_enqueue_script('superslides');
?>

<style type="text/css">

<?php


$i = 0;
foreach($images as $attach_id) {
	$img = wp_get_attachment_image_src($attach_id, 'full');
	echo '#image-carousel-'.$random_id.' .slides-container .m_slide'.$i.' { background-image:url('.$img[0].'); }';
	$i++;
}

?>					

</style>

<div id="project">
	<!-- Slides -->
	<div class="slides-container">

		<?php 
		$i = 0;
		foreach($images as $attach_id) { 			
			
			if ($attach_id > 0) {
			    $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ));
			} else {
			    $post_thumbnail = array();
			    $post_thumbnail['thumbnail'] = '<img src="'.$this->assetUrl('vc/no_image.png').'" />';
			    $post_thumbnail['p_img_large'][0] = $this->assetUrl('vc/no_image.png');
			}
			
			$thumbnail = $post_thumbnail['thumbnail'];
			$p_img_large = $post_thumbnail['p_img_large'];
			
			$attachment = get_post($attach_id);
			$img_caption = $attachment->post_excerpt;
			
			echo '<div class="m_slide'.$i.'"><div class="slide-inner t-center">';
			
			
			if($captions == 'library') {
				$attachment = get_post($attach_id);
				$img_caption = $attachment->post_excerpt;	
				$img_desc = $attachment->post_content;
			} elseif ($captions == 'custom' && $captions_arr) {
				$caption = explode('|',$captions_arr[$i]);
				if($caption[0]) $img_caption = $caption[0];
				if($caption[1]) $img_desc = $caption[1];
			}
			
			if($img_caption) {
				echo '<h1 class="white uppercase semibold animated font-primary" data-animation="fadeInDown" data-animation-delay="300">'.$img_caption.'</h1>';				
				if($img_desc) {				
					echo '<p class="white t-center animated" data-animation="fadeInUp" data-animation-delay="300">'.$img_desc.'</p>';
				}
			}
			
			echo '</div></div>';
			$i++;
		
		}
		if($captions != 'none') { 
		
		?>
		
		<?php } ?>
	</div>
	<!-- End Slider -->	

	<!-- Slider Controls -->
	<nav class="slides-navigation">
		<a href="#" class="next"></a>
		<a href="#" class="prev"></a>
	</nav>
</div>

<?php } ?>

</div>