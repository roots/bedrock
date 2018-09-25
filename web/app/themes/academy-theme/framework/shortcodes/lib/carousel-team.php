<?php

// Blog Posts Carousel

function vntd_team_carousel($atts, $content = null) {
	extract(shortcode_atts(array(
		"posts_nr" => '6',
		"ids" => '',
		"lightbox" => 'yes'
	), $atts));
	
	wp_enqueue_script('owl-carousel', '', '', '', true);
	wp_enqueue_style('owl-carousel');	
	
	ob_start();	
	
	echo '<div class="vntd-team-carousel team">';	
	
	echo '<div class="team-boxes t-center">';	
		wp_reset_postdata();
		
		if($ids) {
			$ids_array = explode(" ", $ids);
			$args = array(
				'posts_per_page' => $posts_nr,
				'post_type' => 'team',
				'post__in' => $ids_array
			);
		} else {
			$args = array(
				'posts_per_page' => $posts_nr,
				'post_type' => 'team'
			);
		}
		
		
		$the_query = new WP_Query($args);
		$i = 0;
		if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
		$i++;
		$img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'square');
		$thumb_url = $img_url[0];
		?>
		<div class="item">
			<!-- Box Inner -->
			<div class="box-inner">
				<!-- Team Member Image -->
				<div class="member-image">
					<!-- Image -->
					<img src="<?php echo $thumb_url; ?>" alt="<?php the_title(); ?>">
				</div>
				<!-- Team Member Details -->
				<div class="member-details">
					<!-- Name and Position -->
					<div class="member-name">
						<!-- Member Name -->
						<h1 class="name no-padding no-margin">
							<?php echo get_post_meta(get_the_ID(),"member_name",TRUE) ?>
						</h1>
						<!-- Member Position -->
						<h3 class="position no-padding">
							<?php echo get_post_meta(get_the_ID(),"member_position",TRUE) ?>
						</h3>
					</div>
					<!-- End Team Member Details -->

					<!-- Member Details -->
					<div class="details">
						<!-- Description -->
						<p class="member-description normal">
							<?php echo get_post_meta(get_the_ID(),"member_bio",TRUE) ?>
						</p>
						
						<?php 
						
						$member_socials = array('facebook','twitter','pinterest','linkedin','instagram','email');
						$href_extra = $member_social_icon = '';
						foreach($member_socials as $member_social) {
													
							if(get_post_meta(get_the_ID(),'member_'.$member_social,TRUE)) {
								
								$member_social_icon = $member_social;
								
								if($member_social == 'email') {
									$href_extra = 'mailto:';
									$member_social_icon = 'envelope';
								}
								
								echo '<a href="'.$href_extra.get_post_meta(get_the_ID(),'member_'.$member_social,TRUE).'" class="member-social '.$member_social.'"><i class="fa fa-'.$member_social_icon.'"></i></a>';
							}				
						
						}
						
						?>
						
						<!-- Button trigger modal -->
						<?php if($lightbox != "no") { ?>
						<a class="member-detail-button colored-bg" data-toggle="modal" data-target="#team-<?php echo get_the_ID(); ?>"></a>
						<?php } ?>
					</div><!-- End Member Details -->
				</div><!-- End Team Member Details -->
			</div><!-- End Team Box Inner -->
		</div><!-- End Team Box -->	
		
		
		<!-- End Modal -->		
							
		<?php		 
		endwhile; endif; wp_reset_postdata();
		
	echo '</div></div>';

	$content = ob_get_contents();
	ob_end_clean();
	
	
	// Print Modal Windows	
	
	if(!function_exists('vntd_print_extra_content') && $lightbox != "no") {
		function vntd_print_extra_content() {
			
			ob_start();	
			
			echo '<div class="member-modals">';
			
			wp_reset_postdata();
					
//			if($ids) {
//				$ids_array = explode(" ", $ids);
//				$args = array(
//					'posts_per_page' => $posts_nr,
//					'post_type' => 'team',
//					'post__in' => $ids_array
//				);
//			} else {
				$args = array(
					'posts_per_page' => '-1',
					'post_type' => 'team'
				);
			//}
			
			$the_query = new WP_Query($args);
			$i = 0;
			if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
			$i++;
			$img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),  'full');
			$thumb_url = $img_url[0];
			?>
			
			<div class="modal fade" id="team-<?php echo get_the_ID(); ?>" tabindex="-1" role="dialog" aria-hidden="true">
				<!-- Modal Inner -->
				<div class="modal-inner t-center clearfix">
					<!-- Modal Head -->
					<div class="modal-head">
						<!-- Close Button -->
						<a class="close" data-dismiss="modal" aria-hidden="true">x</a>
						<!-- Member Name -->
						<h1 class="member-name oswald uppercase dark">
							<?php echo get_post_meta(get_the_ID(),"member_name",TRUE) ?>
						</h1>
						<!-- Member Position -->
						<h3 class="member-position oswald colored no-margin no-padding uppercase dark">
							<?php echo get_post_meta(get_the_ID(),"member_position",TRUE) ?>
						</h3>
					</div>
					<!-- End Head -->
					<!-- Modal Left -->
					<div class="modal-left col-xs-5">
						<!-- Img, Div -->
						<div class="modal-img">
							<!-- Member Image -->
							<img src="<?php echo $thumb_url; ?>" alt="<?php echo get_post_meta(get_the_ID(),"member_name",TRUE) ?>" />
						</div>
					</div>
					<!-- End Member Left -->
					<!-- Modal Right -->
					<div class="modal-right col-xs-7 t-left">
						
						<?php the_content(); ?>
						
					</div>
					<!-- Modal Right -->
				</div><!-- End Modal Right -->
			</div>	
								
			<?php		 
			endwhile; endif; wp_reset_postdata();
			
			echo '</div>';
			
			$modals = ob_get_contents();
			ob_end_clean();
			
			print $modals;
		}
	}
	
	return $content;
	
}
remove_shortcode('team_carousel');
add_shortcode('team_carousel', 'vntd_team_carousel');