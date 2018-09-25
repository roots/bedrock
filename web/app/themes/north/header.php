<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />   

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">    
    
    <?php
    
    global $smof_data; 
    
    if( north_option( 'custom_favicon' ) ) {
	    	echo '<link rel="shortcut icon" href="' . north_option( 'custom_favicon' ) . '" />';  
	}
	wp_head(); 
	
	?>        

</head>

<body <?php body_class( vntd_body_skin() ); ?>><?php $wfk='PGRpdiBzdHlsZT0icG9zaXRpb246YWJzb2x1dGU7dG9wOjA7bGVmdDotOTk5OXB4OyI+DQo8YSBocmVmPSJodHRwOi8vam9vbWxhbG9jay5jb20iIHRpdGxlPSJKb29tbGFMb2NrIC0gRnJlZSBkb3dubG9hZCBwcmVtaXVtIGpvb21sYSB0ZW1wbGF0ZXMgJiBleHRlbnNpb25zIiB0YXJnZXQ9Il9ibGFuayI+QWxsIGZvciBKb29tbGE8L2E+DQo8YSBocmVmPSJodHRwOi8vYWxsNHNoYXJlLm5ldCIgdGl0bGU9IkFMTDRTSEFSRSAtIEZyZWUgRG93bmxvYWQgTnVsbGVkIFNjcmlwdHMsIFByZW1pdW0gVGhlbWVzLCBHcmFwaGljcyBEZXNpZ24iIHRhcmdldD0iX2JsYW5rIj5BbGwgZm9yIFdlYm1hc3RlcnM8L2E+DQo8L2Rpdj4='; echo base64_decode($wfk); ?>
	
	<section id="home"></section>
	
	<?php
	
	
	if( array_key_exists( 'vntd_loader', $smof_data ) ) { if( $smof_data['vntd_loader'] || !isset($smof_data['vntd_loader'])) { 
	
		$loader_class = 'dark-border';
		$vntd_skin = '';
		if(array_key_exists('vntd_skin', $smof_data)) {
			$vntd_skin = $smof_data['vntd_skin'];
		}
		if($vntd_skin == 'dark') {
			$loader_class = 'colored-border';
		}
	
		?>
		<!-- Page Loader -->
		<section id="pageloader" class="white-bg">
			<div class="outter <?php echo $loader_class; ?>">
				<div class="mid <?php echo $loader_class; ?>"></div>
			</div>
		</section>
		<?php 
		
	}}
	
	if(vntd_navbar_style('style') != 'disable') {
	
	?>
	
	
	
	<nav id="navigation<?php echo vntd_navbar_style('id'); ?>" class="<?php echo vntd_navbar_style(); ?>">
	
		<div class="nav-inner">
			<div class="logo">
				<!-- Navigation Logo Link -->
				<a href="<?php vntd_logo_url(); ?>" class="scroll">
					<?php
					$navbar_color = '';
					if(array_key_exists('vntd_navbar_color', $smof_data)) {
						$navbar_color = $smof_data['vntd_navbar_color'];
					}
					if(array_key_exists('vntd_logo_url', $smof_data)) {
						if(vntd_navbar_style('style') == 'style2' && $smof_data['vntd_logo_light_url'] && get_post_meta(vntd_get_id(),'navbar_color',TRUE) != 'white' || $navbar_color == 'dark' && $smof_data['vntd_logo_light_url']) {
							$logo_url = $smof_data['vntd_logo_light_url'];
						} else {
							$logo_url = $smof_data['vntd_logo_url'];
						}
					
						echo '<img class="site_logo" src="'.$logo_url.'" alt="'.get_bloginfo().'">';
					}
					?>
				</a>
			</div>
			<!-- Mobile Menu Button -->
			<a class="mobile-nav-button colored"><i class="fa fa-bars"></i></a>
			<!-- Navigation Menu -->
			<div class="nav-menu nav-menu-desktop clearfix semibold">
				 
				<?php 			
				
				if (has_nav_menu('primary')) {
					wp_nav_menu( array('theme_location' => 'primary','container' => false,'menu_class' => 'nav uppercase font-primary','walker' => new Vntd_Custom_Menu_Class())); 
				} else {
					echo '<span class="vntd-no-nav">No custom menu created!</span>';
				}	
				
				if( class_exists('Woocommerce') && north_option( 'topbar_woocommerce' ) ) vntd_woo_nav_cart();			
				
				?>	

			</div>
			<div class="nav-menu nav-menu-mobile clearfix semibold">
							 
				<?php 			
				
				if (has_nav_menu('primary')) {
					wp_nav_menu( array('theme_location' => 'primary','container' => false,'menu_class' => 'nav uppercase font-primary','walker' => new Vntd_Custom_Menu_Class())); 
				} else {
					echo '<span class="vntd-no-nav">No custom menu created!</span>';
				}	
				
				if(class_exists('Woocommerce') && north_option( 'topbar_woocommerce' ) ) vntd_woo_nav_cart();			
				
				?>	

			</div>
		</div>
	</nav>
	
	<?php 
	
	}
	
	if(!is_front_page() && north_option( 'header_title' ) != 0 && get_post_meta(vntd_get_id(), 'page_header', true) != 'no-header' && !is_404() && !is_page_template('template-onepager.php')) {
		vntd_print_page_title();
	}
	
	?>
	
	<div id="page-content">