<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Contact Block
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_contact_block($atts, $content = null) {
	extract(shortcode_atts(array(
		"phone" => '0123 456 789',
		"phone2" => '',
		"address" => 'North, Street Name 6901, Melbourne Australia',
		"email" => 'support@goldeyethemes.com',
		"facebook"	=> '',
		"twitter"	=> '',
		"linkedin"	=> '',
		"instagram"	=> '',
		"youtube"	=> '',
		"pinterest"	=> '',
		"googleplus" => '',
		"tumblr"	=> '',
		"dribbble"	=> '',
		"vimeo"		=> '',
		"soundcloud" => ''
	), $atts));
	
	$social_icons = array('facebook','twitter','linkedin','instagram','youtube','pinterest','vimeo','googleplus','tumblr','dribbble', 'soundcloud');
	
	ob_start();		
    
    ?>
    
	<div class="address-soft t-center">
	
		<?php if($phone) { ?>
		<a href="tel:<?php echo $phone; ?>" class="phone-button round white">
			<i class="fa fa-phone"></i>
		</a>
		<?php } ?>

		<h1 class="phone-text font-primary white">
			<?php echo esc_textarea($phone); ?>
		</h1>
		
		<?php if($phone2) { ?>
		<h1 class="phone-text font-primary white">
			<?php echo esc_textarea($phone2); ?>
		</h1>
		<?php } ?>

		<!-- Address -->
		<h2 class="phone-text font-primary uppercase">
			<?php echo $address; ?>
		</h2>

		<!-- E-Mail -->
		<a href="mailto:<?php echo $email; ?>" class="mail-text uppercase font-primary">
			<?php echo $email; ?>
		</a>
		
		<?php
		
		foreach($social_icons as $social_icon) {
			if(array_key_exists($social_icon,$atts)) {
				echo '<a href="'.$atts[$social_icon].'" target="_blank" class="social round dark-bg '.$social_icon.'"><i class="fa fa-'.$social_icon.'"></i></a>';
			}
		}
		
		?>

	</div>
	
	<?php 
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('contact_block');
add_shortcode('contact_block', 'vntd_contact_block');