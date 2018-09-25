<?php

// Blog Posts Carousel

function vntd_fullscreen_slider($atts, $content = null) {
	extract(shortcode_atts(array(
		"button1_label"	=> 'Purchase',
		"button1_url"	=> '#',
		"button2_label"	=> '',
		"button2_url"	=> '',
		"buttons_color"	=> 'dark',
		"images"		=> '',
		"text_static"	=> 'Hello there',
		"text_dynamic"	=> 'Welcome to North,We are Designers,We love to Design',
		"posts_nr" 		=> '6',
		"style"			=> 'style1',
		"animated"		=> 'no',
		"plus_url"		=> '',
		"bg_overlay"	=> 'dark1',
		"service_icons"  => 'no'
	), $atts));
	
	wp_enqueue_script('superslides', '', '', '', true);
	
	wp_enqueue_script('owl-carousel', '', '', '', true);
	wp_enqueue_style('owl-carousel');	
	
	$random_id = 'fullscreen-'.rand(1,9999);
	
	$animated_class = $animation_delay1 = $animation_delay2 = $animation_effect1 = $animation_effect2 = '';
	if($animated == 'yes') {
		$animated_class = North::get_animated_class();
		$animation_delay1 = ' data-animation-delay="600"';
		$animation_delay2 = ' data-animation-delay="300"';
		$animation_effect1 = ' data-animation="fadeInDown"';
		$animation_effect2 = ' data-animation="fadeInUp"';
	}
	
	$button_class = 'home-button-1';
	
	if($buttons_color == 'light') $button_class = 'slide-button';
	
	$bg_overlay_class = '';
	
	if($bg_overlay == 'dark1') {
		$bg_overlay_class = 'soft-bg-grade';
	}elseif($bg_overlay == 'dark2') {
		$bg_overlay_class = 'soft-black-bg';
	}elseif($bg_overlay == 'dots') {
		$bg_overlay_class = 'pattern-black soft-black-bg';
	}elseif($bg_overlay == 'dots_white') {
		$bg_overlay_class = 'pattern-white';
	}
		
	ob_start();	
	
	
	echo '<div id="'.$random_id.'" class="vntd-fullscreen-slider fullscreen-slider-'.$style.'">';	

	?>
	
	<style type="text/css">
	
	<?php
	$none = false;
	if ( $images == '' ) {
		$none = true;
	}
	$images = explode( ',', $images);
	
	$i = 1;
	foreach($images as $attach_id) {
	
		$img = wp_get_attachment_image_src($attach_id, 'bg-image');
		
		if ($img == 1690) {
			$img_url = $img[0];
		} else {
			$img = wp_get_attachment_image_src($attach_id, 'full');
			$img_url = $img[0];
		}
		echo '#'.$random_id.' .slides-container .image'.$i.' { background-image:url('.$img_url.'); }';
		$i++;
	}
	?>					
	
	</style>
	<!-- Ful Screen Home -->
	<div class="fullscreen-slider">
		<!-- Slides -->
		<?php if($none == false) { ?>
		<div class="slides-container relative">
			<!-- Slider Images -->					
			
			<?php
			
			$i = 1;
			
			foreach($images as $image) {
				echo '<div class="image'.$i.' '.$bg_overlay_class.' parallax"></div>';
				$i++;
			}
			
			?>
			
			<!-- End Slider Images -->	 
		</div>
		
		<!-- End Slides -->

		<!-- Slider Controls -->
		<nav class="slides-navigation">
			<a href="#" class="next"></a>
			<a href="#" class="prev"></a>
		</nav>
<?php } ?>
	</div>
	<!-- End Ful Screen Home -->

	<!-- Home Elements v1 -->
	<div class="home-elements">
		<!-- Home Inner -->
		
		<?php if($style == 'style2') { ?>
		
		<div class="home-inner v1">
			<!-- Home Fixed Text -->
			<h1 class="home-fixed-text font-primary uppercase"><?php echo $text_static; ?></h1>
			<!-- Home Text Slider -->
			<div class="home-text-slider relative">
				<div class="text-slider clearfix">
					<!-- Home Text Slides -->
					<ul class="home-texts clearfix">
						<?php 
						
						$dynamic_lines = explode( ',', $text_dynamic );
						
						foreach($dynamic_lines as $dynamic_line) {
							$dynamic_line = str_replace(  ';;', ',' , $dynamic_line );
							echo '<li class="slide white font-primary uppercase">'.$dynamic_line.'</li>';
						}
						?>
					</ul>
					<!-- End Home Text Slides -->
				</div>
			</div>
			<!-- End Home Text Slider -->

			<!-- Home Soft Strip -->
			<div class="home-strip"></div>

			<!-- Home Boxes -->
			<div class="home-boxes clearfix">
			
				<?php
				
				wp_reset_postdata();
						
						$args = array(
							'posts_per_page' => $posts_nr,
							'post_type' => 'services'
						);
						
						$the_query = new WP_Query($args);
						
						$i = 1;
						
						if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
						?>
						
						<!-- Box -->
						<div class="home-box">
							<!-- Box Header -->
							<h1 class="uppercase font-primary">
								<!-- Box Number -->
								<span class="box-number">
								<?php
								
								if( $service_icons == 'yes' ) {
									echo '<i class="fa ' . esc_attr( get_post_meta( get_the_ID(), "icon", TRUE ) ) . '"></i>';
								} else {
									echo '0' . $i;
								}
								
								?>
								</span>
								<?php echo get_post_meta(get_the_ID(),"title",TRUE); ?>										
							</h1>
							<!-- Box Description -->
							<p class="box-description normal">
								<?php echo get_post_meta(get_the_ID(),"desc",TRUE); ?>
							</p>
						</div><!-- End Box -->		
											
						<?php		 
						
						$i++;
						endwhile; endif; wp_reset_postdata();						
				
				?>

			</div><!-- End Home Boxes -->
		</div><!-- End Home Inner -->
		
		<!-- Home Button -->
		<div class="fullwidth t-center home-button-inner">
			<a href="<?php echo $button1_url; ?>" class="scroll home-button uppercase font-primary semibold soft-bg-icons gray">
				<!-- Button Text -->
				<?php echo $button1_label; ?>
				<!-- Button Icon -->
				<i class="fa fa-angle-down"></i>
			</a>
		</div><!-- End Home Button -->	
		
		<?php } else { ?>		
		
		<!-- Home Inner -->
		<div class="home-inner v2 t-center">
		
			<?php
			
			if($plus_url) {
				echo '<a href="'.$plus_url.'" class="plus-button round ex-link'.$animated.'"'.$animation_effect1.$animation_delay1.'></a>';
			}
			
			$slider_class = '';
			if (strpos($text_dynamic,',') !== false) {
			    $slider_class = 'text-slider ';
			}
			
			?>
			
			<!-- Home Text Slider -->
			<div class="home-text-slider relative<?php echo $animated_class; ?>" <?php echo $animation_effect1.$animation_delay2; ?>>
				<div class="<?php echo $slider_class; ?>clearfix">
					<!-- Home Text Slides -->
					<ul class="home-texts clearfix t-center semibold">
						<?php 
						
						$dynamic_lines = explode(',',$text_dynamic);
						
						foreach($dynamic_lines as $dynamic_line) {
							$dynamic_line = str_replace(  ';;', ',' , $dynamic_line );
							echo '<li class="slide white uppercase">'.$dynamic_line.'</li>';
						}
						?>
					</ul>
					<!-- End Home Text Slides -->
					<!-- Home Fixed Text -->
			<h1 class="home-fixed-text t-center<?php echo $animated_class; ?>"<?php echo $animation_effect2.$animation_delay2; ?>><?php echo $text_static; ?></h1>
				</div>
			</div>
			<!-- End Home Text Slider -->
			
			<?php if($button1_label) { ?>
			<!-- Home Button -->
			<a href="<?php echo $button1_url; ?>" target="_blank" class="scroll <?php echo $button_class; ?> uppercase font-primary semibold gray<?php echo $animated; ?>"<?php echo $animation_effect1.$animation_delay2; ?>>
				<?php echo $button1_label; ?>
			</a>
			<?php } ?>
			
			<?php if($button2_label) { ?>
			<!-- Home Button -->
			<a href="<?php echo $button2_url; ?>" class="scroll <?php echo $button_class; ?> uppercase font-primary semibold gray">
				<?php echo $button2_label; ?>
			</a>
			<?php } ?>
		</div><!-- End Home Inner -->	
		
		<?php } ?>		
	</div><!-- End Home Elements -->
	
	<?php
	
	echo '</div>';
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('vntd_fullscreen_slider');
add_shortcode('vntd_fullscreen_slider', 'vntd_fullscreen_slider');