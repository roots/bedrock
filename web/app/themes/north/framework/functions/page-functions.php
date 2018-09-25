<?php
//
// Blog Post Settings
//


add_action("admin_init", "vntd_page_layout");   

function vntd_page_layout(){    
    add_meta_box("vntd_page_settings", "Page Settings", "vntd_page_settings_config", "page", "side", "low");
    add_meta_box("vntd_page_settings", "Page Settings", "vntd_page_settings_config", "post", "side", "low");
    add_meta_box("vntd_page_settings", "Page Settings", "vntd_page_settings_config", "portfolio", "side", "low");

}   

function vntd_page_settings_config() {
        global $post,$smof_data;	
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $page_header = $page_subtitle = $navbar_style = $navbar_color = $page_layout = $page_sidebar = $page_width = $footer_color = $footer_widgets = '';
        if(array_key_exists("page_header", $custom)) {
			$page_header = $custom["page_header"][0];
		}
		if(array_key_exists("page_subtitle", $custom)) {
			$page_subtitle = $custom["page_subtitle"][0];
		}
		if(array_key_exists("navbar_style", $custom)) {
			$navbar_style = $custom["navbar_style"][0];
		}
		if(array_key_exists("navbar_color", $custom)) {
			$navbar_color = $custom["navbar_color"][0];
		}
		if(array_key_exists("page_layout", $custom)) {
			$page_layout = $custom["page_layout"][0];	
		}
		if(array_key_exists("page_sidebar", $custom)) {
			$page_sidebar = $custom["page_sidebar"][0];
		}
		if(array_key_exists("page_width", $custom)) {
			$page_width = $custom["page_width"][0];
		}
		if(array_key_exists("footer_color", $custom)) {
			$footer_color = $custom["footer_color"][0];
		}
		if(array_key_exists("footer_widgets", $custom)) {
			$footer_widgets = $custom["footer_widgets"][0];
		}
?>
    <div class="metabox-options form-table side-options">
  		
		<div id="page-header" class="label-radios">  		
			<h5><?php _e('Page Title','north'); ?>:</h5>
    	    <?php
    	    $headers = array(
    	    	'Enabled' => "default",
    	    	'No Page Title' => 'no-header'
    	    );
    	    
    	    vntd_create_dropdown('page_header',$headers,$page_header);
    	    
    	    ?>
    	    
    	</div>
    	
    	<div id="vntd_page_header_default" <?php if($page_header != "default" && $page_header) { echo 'class="hidden"'; } ?>>
    		<h5><?php _e('Page Tagline','north'); ?>:</h5>
    		<input type="text" name="page_subtitle" value="<?php echo $page_subtitle; ?>">
    	</div>
    	
    	<div id="navbar-style">  		
    		<h5><?php _e('Header Style','north'); ?>:</h5>
    	    <?php
    	    $navbar_styles = array(
    	    	'Default set in Theme Options' => "default",
    	    	'Style 1 - Classic' => 'style1',
    	    	'Style 2 - Transparent' => 'style2',
    	    	'Style 3 - Appear after section' => 'style3',
    	    	'Disable' => 'disable'
    	    );
    	    
    	    vntd_create_dropdown('navbar_style',$navbar_styles,$navbar_style);
    	    
    	    ?>
    	    
    	</div>
    	
    	<div id="navbar-color">  		
    		<h5><?php _e('Header Color','north'); ?>:</h5>
    	    <?php
    	    $navbar_colors = array(
    	    	'Default set in Theme Options' => "default",
    	    	'White' => 'white',
    	    	'Dark' => 'dark'
    	    );
    	    
    	    vntd_create_dropdown('navbar_color',$navbar_colors,$navbar_color);
    	    
    	    ?>
    	    
    	</div>
    	
    	<?php if(get_post_type(get_the_id()) == 'portfolio') { } else { ?>
    	
    	<div class="metabox-option">
			<h5><?php _e('Layout','north'); ?>:</h5>
			
			<?php 
			if(!$page_layout) $page_layout = $smof_data['vntd_default_layout'];
			$page_layout_arr = array('Right Sidebar' => 'sidebar_right', 'Left Sidebar' => 'sidebar_left', "Fullwidth" => 'fullwidth');  
			
			vntd_create_dropdown('page_layout',$page_layout_arr,$page_layout,true);
			
			?>
		</div>
		<div class="metabox-option fold fold-page_layout fold-sidebar_right fold-sidebar_left" <?php if($page_layout == "fullwidth" || !$page_layout) echo 'style="display:none;"'; ?>>
			<h5><?php _e('Page Sidebar','north'); ?>:</h5>
			<select name="page_sidebar" class="select"> 
                <option value="Default Sidebar"<?php if($page_sidebar == "Default Sidebar" || !$page_sidebar) echo "selected"; ?>>Default Sidebar</option>
            	<?php
            								
				// Retrieve custom sidebars
											
				$sidebars = $smof_data['sidebar_generator'];  
  
				if(isset($sidebars) && sizeof($sidebars) > 0)  
				{  
					foreach($sidebars as $sidebar)  
					{  
				?>                
				<option value="<?php echo $sidebar['title']; ?>"<?php if($page_sidebar == $sidebar['title']) echo "selected"; ?>><?php echo $sidebar['title']; ?></option>
                
				<?php
                	}  
				}	
				
				if(class_exists('Woocommerce')) {
				
					if($page_sidebar == "WooCommerce Shop Page") $selected_shop = "selected";
					if($page_sidebar == "WooCommerce Product Page") $selected_product = "selected";
					
					echo '<option value="WooCommerce Shop Page" '.$selected_shop.'>WooCommerce Shop Page</option>';
					echo '<option value="WooCommerce Product Page" '.$selected_product.'>WooCommerce Product Page</option>';
				}			
				?>            	

            </select>
		</div>
		
		<?php } ?>

		<?php if(get_post_type(get_the_id()) == 'post') { ?>
		<div class="metabox-option fold fold-page_layout fold-fullwidth" <?php if($page_layout != "fullwidth" && get_post_type(get_the_id()) != 'portfolio') echo 'style="display:none;"'; ?>>
			<h5><?php _e('Page Content Width','north'); ?>:</h5>
			
			<?php 
			if(!$page_layout) $page_layout = $smof_data['vntd_default_layout'];
			$page_width_arr = array('Container' => 'content', 'Fullwidth' => 'fullwidth');  
			
			vntd_create_dropdown('page_width',$page_width_arr,$page_width,true);
			
			?>
		</div>
		<?php } else { ?>
		<div class="metabox-option fold fold-page_layout fold-fullwidth" <?php if($page_layout != "fullwidth" && get_post_type(get_the_id()) != 'portfolio') echo 'style="display:none;"'; ?>>
			<h5><?php _e('Page Content Width','north'); ?>:</h5>
			
			<?php 
			if(!$page_layout) $page_layout = $smof_data['vntd_default_layout'];
			$page_width_arr = array('Fullwidth' => 'fullwidth', 'Container' => 'content');  
			
			vntd_create_dropdown('page_width',$page_width_arr,$page_width,true);
			
			?>
		</div>
		
		<?php } ?>
		
		<div id="footer-color">  		
			<h5><?php _e('Footer Color','north'); ?>:</h5>
		    <?php
		    $footer_colors = array(
		    	'Default set in Theme Options' => "default",
		    	'White' => 'white',
		    	'Dark' => 'dark'
		    );
		    
		    vntd_create_dropdown('footer_color',$footer_colors,$footer_color);
		    
		    ?>
		    
		</div>
		
		<div id="footer-color">  		
			<h5><?php _e('Footer Widgets Area','north'); ?>:</h5>
		    <?php
		    $footer_widgets_arr = array(
		    	'Default set in Theme Options' => "default",
		    	'Enabled' => 'enabled',
		    	'Disabled' => 'disabled'
		    );
		    
		    vntd_create_dropdown('footer_widgets',$footer_widgets_arr,$footer_widgets);
		    
		    ?>
		    
		</div>
        
    </div>
<?php

}	
	
// Save Custom Fields
	
add_action('save_post', 'vntd_save_page_settings'); 

function vntd_save_page_settings(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{		
	
		$post_metas = array('page_layout','page_sidebar','page_width','navbar_style','navbar_color','footer_color','page_header','page_title','page_subtitle','footer_widgets');
		
		foreach($post_metas as $post_meta) {
			if(isset($_POST[$post_meta])) update_post_meta($post->ID, $post_meta, $_POST[$post_meta]);
		}

    }

}

function north_fa_array() {
	$icons = array(
			'fa-glass'                               => 'f000',
			'fa-music'                               => 'f001',
			'fa-search'                              => 'f002',
			'fa-envelope-o'                          => 'f003',
			'fa-heart'                               => 'f004',
			'fa-star'                                => 'f005',
			'fa-star-o'                              => 'f006',
			'fa-user'                                => 'f007',
			'fa-film'                                => 'f008',
			'fa-th-large'                            => 'f009',
			'fa-th'                                  => 'f00a',
			'fa-th-list'                             => 'f00b',
			'fa-check'                               => 'f00c',
			'fa-times'                               => 'f00d',
			'fa-search-plus'                         => 'f00e',
			'fa-search-minus'                        => 'f010',
			'fa-power-off'                           => 'f011',
			'fa-signal'                              => 'f012',
			'fa-cog'                                 => 'f013',
			'fa-trash-o'                             => 'f014',
			'fa-home'                                => 'f015',
			'fa-file-o'                              => 'f016',
			'fa-clock-o'                             => 'f017',
			'fa-road'                                => 'f018',
			'fa-download'                            => 'f019',
			'fa-arrow-circle-o-down'                 => 'f01a',
			'fa-arrow-circle-o-up'                   => 'f01b',
			'fa-inbox'                               => 'f01c',
			'fa-play-circle-o'                       => 'f01d',
			'fa-repeat'                              => 'f01e',
			'fa-refresh'                             => 'f021',
			'fa-list-alt'                            => 'f022',
			'fa-lock'                                => 'f023',
			'fa-flag'                                => 'f024',
			'fa-headphones'                          => 'f025',
			'fa-volume-off'                          => 'f026',
			'fa-volume-down'                         => 'f027',
			'fa-volume-up'                           => 'f028',
			'fa-qrcode'                              => 'f029',
			'fa-barcode'                             => 'f02a',
			'fa-tag'                                 => 'f02b',
			'fa-tags'                                => 'f02c',
			'fa-book'                                => 'f02d',
			'fa-bookmark'                            => 'f02e',
			'fa-print'                               => 'f02f',
			'fa-camera'                              => 'f030',
			'fa-font'                                => 'f031',
			'fa-bold'                                => 'f032',
			'fa-italic'                              => 'f033',
			'fa-text-height'                         => 'f034',
			'fa-text-width'                          => 'f035',
			'fa-align-left'                          => 'f036',
			'fa-align-center'                        => 'f037',
			'fa-align-right'                         => 'f038',
			'fa-align-justify'                       => 'f039',
			'fa-list'                                => 'f03a',
			'fa-outdent'                             => 'f03b',
			'fa-indent'                              => 'f03c',
			'fa-video-camera'                        => 'f03d',
			'fa-picture-o'                           => 'f03e',
			'fa-pencil'                              => 'f040',
			'fa-map-marker'                          => 'f041',
			'fa-adjust'                              => 'f042',
			'fa-tint'                                => 'f043',
			'fa-pencil-square-o'                     => 'f044',
			'fa-share-square-o'                      => 'f045',
			'fa-check-square-o'                      => 'f046',
			'fa-arrows'                              => 'f047',
			'fa-step-backward'                       => 'f048',
			'fa-fast-backward'                       => 'f049',
			'fa-backward'                            => 'f04a',
			'fa-play'                                => 'f04b',
			'fa-pause'                               => 'f04c',
			'fa-stop'                                => 'f04d',
			'fa-forward'                             => 'f04e',
			'fa-fast-forward'                        => 'f050',
			'fa-step-forward'                        => 'f051',
			'fa-eject'                               => 'f052',
			'fa-chevron-left'                        => 'f053',
			'fa-chevron-right'                       => 'f054',
			'fa-plus-circle'                         => 'f055',
			'fa-minus-circle'                        => 'f056',
			'fa-times-circle'                        => 'f057',
			'fa-check-circle'                        => 'f058',
			'fa-question-circle'                     => 'f059',
			'fa-info-circle'                         => 'f05a',
			'fa-crosshairs'                          => 'f05b',
			'fa-times-circle-o'                      => 'f05c',
			'fa-check-circle-o'                      => 'f05d',
			'fa-ban'                                 => 'f05e',
			'fa-arrow-left'                          => 'f060',
			'fa-arrow-right'                         => 'f061',
			'fa-arrow-up'                            => 'f062',
			'fa-arrow-down'                          => 'f063',
			'fa-share'                               => 'f064',
			'fa-expand'                              => 'f065',
			'fa-compress'                            => 'f066',
			'fa-plus'                                => 'f067',
			'fa-minus'                               => 'f068',
			'fa-asterisk'                            => 'f069',
			'fa-exclamation-circle'                  => 'f06a',
			'fa-gift'                                => 'f06b',
			'fa-leaf'                                => 'f06c',
			'fa-fire'                                => 'f06d',
			'fa-eye'                                 => 'f06e',
			'fa-eye-slash'                           => 'f070',
			'fa-exclamation-triangle'                => 'f071',
			'fa-plane'                               => 'f072',
			'fa-calendar'                            => 'f073',
			'fa-random'                              => 'f074',
			'fa-comment'                             => 'f075',
			'fa-magnet'                              => 'f076',
			'fa-chevron-up'                          => 'f077',
			'fa-chevron-down'                        => 'f078',
			'fa-retweet'                             => 'f079',
			'fa-shopping-cart'                       => 'f07a',
			'fa-folder'                              => 'f07b',
			'fa-folder-open'                         => 'f07c',
			'fa-arrows-v'                            => 'f07d',
			'fa-arrows-h'                            => 'f07e',
			'fa-bar-chart'                           => 'f080',
			'fa-twitter-square'                      => 'f081',
			'fa-facebook-square'                     => 'f082',
			'fa-camera-retro'                        => 'f083',
			'fa-key'                                 => 'f084',
			'fa-cogs'                                => 'f085',
			'fa-comments'                            => 'f086',
			'fa-thumbs-o-up'                         => 'f087',
			'fa-thumbs-o-down'                       => 'f088',
			'fa-star-half'                           => 'f089',
			'fa-heart-o'                             => 'f08a',
			'fa-sign-out'                            => 'f08b',
			'fa-linkedin-square'                     => 'f08c',
			'fa-thumb-tack'                          => 'f08d',
			'fa-external-link'                       => 'f08e',
			'fa-sign-in'                             => 'f090',
			'fa-trophy'                              => 'f091',
			'fa-github-square'                       => 'f092',
			'fa-upload'                              => 'f093',
			'fa-lemon-o'                             => 'f094',
			'fa-phone'                               => 'f095',
			'fa-square-o'                            => 'f096',
			'fa-bookmark-o'                          => 'f097',
			'fa-phone-square'                        => 'f098',
			'fa-twitter'                             => 'f099',
			'fa-facebook'                            => 'f09a',
			'fa-github'                              => 'f09b',
			'fa-unlock'                              => 'f09c',
			'fa-credit-card'                         => 'f09d',
			'fa-rss'                                 => 'f09e',
			'fa-hdd-o'                               => 'f0a0',
			'fa-bullhorn'                            => 'f0a1',
			'fa-bell'                                => 'f0f3',
			'fa-certificate'                         => 'f0a3',
			'fa-hand-o-right'                        => 'f0a4',
			'fa-hand-o-left'                         => 'f0a5',
			'fa-hand-o-up'                           => 'f0a6',
			'fa-hand-o-down'                         => 'f0a7',
			'fa-arrow-circle-left'                   => 'f0a8',
			'fa-arrow-circle-right'                  => 'f0a9',
			'fa-arrow-circle-up'                     => 'f0aa',
			'fa-arrow-circle-down'                   => 'f0ab',
			'fa-globe'                               => 'f0ac',
			'fa-wrench'                              => 'f0ad',
			'fa-tasks'                               => 'f0ae',
			'fa-filter'                              => 'f0b0',
			'fa-briefcase'                           => 'f0b1',
			'fa-arrows-alt'                          => 'f0b2',
			'fa-users'                               => 'f0c0',
			'fa-link'                                => 'f0c1',
			'fa-cloud'                               => 'f0c2',
			'fa-flask'                               => 'f0c3',
			'fa-scissors'                            => 'f0c4',
			'fa-files-o'                             => 'f0c5',
			'fa-paperclip'                           => 'f0c6',
			'fa-floppy-o'                            => 'f0c7',
			'fa-square'                              => 'f0c8',
			'fa-bars'                                => 'f0c9',
			'fa-list-ul'                             => 'f0ca',
			'fa-list-ol'                             => 'f0cb',
			'fa-strikethrough'                       => 'f0cc',
			'fa-underline'                           => 'f0cd',
			'fa-table'                               => 'f0ce',
			'fa-magic'                               => 'f0d0',
			'fa-truck'                               => 'f0d1',
			'fa-pinterest'                           => 'f0d2',
			'fa-pinterest-square'                    => 'f0d3',
			'fa-google-plus-square'                  => 'f0d4',
			'fa-google-plus'                         => 'f0d5',
			'fa-money'                               => 'f0d6',
			'fa-caret-down'                          => 'f0d7',
			'fa-caret-up'                            => 'f0d8',
			'fa-caret-left'                          => 'f0d9',
			'fa-caret-right'                         => 'f0da',
			'fa-columns'                             => 'f0db',
			'fa-sort'                                => 'f0dc',
			'fa-sort-desc'                           => 'f0dd',
			'fa-sort-asc'                            => 'f0de',
			'fa-envelope'                            => 'f0e0',
			'fa-linkedin'                            => 'f0e1',
			'fa-undo'                                => 'f0e2',
			'fa-gavel'                               => 'f0e3',
			'fa-tachometer'                          => 'f0e4',
			'fa-comment-o'                           => 'f0e5',
			'fa-comments-o'                          => 'f0e6',
			'fa-bolt'                                => 'f0e7',
			'fa-sitemap'                             => 'f0e8',
			'fa-umbrella'                            => 'f0e9',
			'fa-clipboard'                           => 'f0ea',
			'fa-lightbulb-o'                         => 'f0eb',
			'fa-exchange'                            => 'f0ec',
			'fa-cloud-download'                      => 'f0ed',
			'fa-cloud-upload'                        => 'f0ee',
			'fa-user-md'                             => 'f0f0',
			'fa-stethoscope'                         => 'f0f1',
			'fa-suitcase'                            => 'f0f2',
			'fa-bell-o'                              => 'f0a2',
			'fa-coffee'                              => 'f0f4',
			'fa-cutlery'                             => 'f0f5',
			'fa-file-text-o'                         => 'f0f6',
			'fa-building-o'                          => 'f0f7',
			'fa-hospital-o'                          => 'f0f8',
			'fa-ambulance'                           => 'f0f9',
			'fa-medkit'                              => 'f0fa',
			'fa-fighter-jet'                         => 'f0fb',
			'fa-beer'                                => 'f0fc',
			'fa-h-square'                            => 'f0fd',
			'fa-plus-square'                         => 'f0fe',
			'fa-angle-double-left'                   => 'f100',
			'fa-angle-double-right'                  => 'f101',
			'fa-angle-double-up'                     => 'f102',
			'fa-angle-double-down'                   => 'f103',
			'fa-angle-left'                          => 'f104',
			'fa-angle-right'                         => 'f105',
			'fa-angle-up'                            => 'f106',
			'fa-angle-down'                          => 'f107',
			'fa-desktop'                             => 'f108',
			'fa-laptop'                              => 'f109',
			'fa-tablet'                              => 'f10a',
			'fa-mobile'                              => 'f10b',
			'fa-circle-o'                            => 'f10c',
			'fa-quote-left'                          => 'f10d',
			'fa-quote-right'                         => 'f10e',
			'fa-spinner'                             => 'f110',
			'fa-circle'                              => 'f111',
			'fa-reply'                               => 'f112',
			'fa-github-alt'                          => 'f113',
			'fa-folder-o'                            => 'f114',
			'fa-folder-open-o'                       => 'f115',
			'fa-smile-o'                             => 'f118',
			'fa-frown-o'                             => 'f119',
			'fa-meh-o'                               => 'f11a',
			'fa-gamepad'                             => 'f11b',
			'fa-keyboard-o'                          => 'f11c',
			'fa-flag-o'                              => 'f11d',
			'fa-flag-checkered'                      => 'f11e',
			'fa-terminal'                            => 'f120',
			'fa-code'                                => 'f121',
			'fa-reply-all'                           => 'f122',
			'fa-star-half-o'                         => 'f123',
			'fa-location-arrow'                      => 'f124',
			'fa-crop'                                => 'f125',
			'fa-code-fork'                           => 'f126',
			'fa-chain-broken'                        => 'f127',
			'fa-question'                            => 'f128',
			'fa-info'                                => 'f129',
			'fa-exclamation'                         => 'f12a',
			'fa-superscript'                         => 'f12b',
			'fa-subscript'                           => 'f12c',
			'fa-eraser'                              => 'f12d',
			'fa-puzzle-piece'                        => 'f12e',
			'fa-microphone'                          => 'f130',
			'fa-microphone-slash'                    => 'f131',
			'fa-shield'                              => 'f132',
			'fa-calendar-o'                          => 'f133',
			'fa-fire-extinguisher'                   => 'f134',
			'fa-rocket'                              => 'f135',
			'fa-maxcdn'                              => 'f136',
			'fa-chevron-circle-left'                 => 'f137',
			'fa-chevron-circle-right'                => 'f138',
			'fa-chevron-circle-up'                   => 'f139',
			'fa-chevron-circle-down'                 => 'f13a',
			'fa-html5'                               => 'f13b',
			'fa-css3'                                => 'f13c',
			'fa-anchor'                              => 'f13d',
			'fa-unlock-alt'                          => 'f13e',
			'fa-bullseye'                            => 'f140',
			'fa-ellipsis-h'                          => 'f141',
			'fa-ellipsis-v'                          => 'f142',
			'fa-rss-square'                          => 'f143',
			'fa-play-circle'                         => 'f144',
			'fa-ticket'                              => 'f145',
			'fa-minus-square'                        => 'f146',
			'fa-minus-square-o'                      => 'f147',
			'fa-level-up'                            => 'f148',
			'fa-level-down'                          => 'f149',
			'fa-check-square'                        => 'f14a',
			'fa-pencil-square'                       => 'f14b',
			'fa-external-link-square'                => 'f14c',
			'fa-share-square'                        => 'f14d',
			'fa-compass'                             => 'f14e',
			'fa-caret-square-o-down'                 => 'f150',
			'fa-caret-square-o-up'                   => 'f151',
			'fa-caret-square-o-right'                => 'f152',
			'fa-eur'                                 => 'f153',
			'fa-gbp'                                 => 'f154',
			'fa-usd'                                 => 'f155',
			'fa-inr'                                 => 'f156',
			'fa-jpy'                                 => 'f157',
			'fa-rub'                                 => 'f158',
			'fa-krw'                                 => 'f159',
			'fa-btc'                                 => 'f15a',
			'fa-file'                                => 'f15b',
			'fa-file-text'                           => 'f15c',
			'fa-sort-alpha-asc'                      => 'f15d',
			'fa-sort-alpha-desc'                     => 'f15e',
			'fa-sort-amount-asc'                     => 'f160',
			'fa-sort-amount-desc'                    => 'f161',
			'fa-sort-numeric-asc'                    => 'f162',
			'fa-sort-numeric-desc'                   => 'f163',
			'fa-thumbs-up'                           => 'f164',
			'fa-thumbs-down'                         => 'f165',
			'fa-youtube-square'                      => 'f166',
			'fa-youtube'                             => 'f167',
			'fa-xing'                                => 'f168',
			'fa-xing-square'                         => 'f169',
			'fa-youtube-play'                        => 'f16a',
			'fa-dropbox'                             => 'f16b',
			'fa-stack-overflow'                      => 'f16c',
			'fa-instagram'                           => 'f16d',
			'fa-flickr'                              => 'f16e',
			'fa-adn'                                 => 'f170',
			'fa-bitbucket'                           => 'f171',
			'fa-bitbucket-square'                    => 'f172',
			'fa-tumblr'                              => 'f173',
			'fa-tumblr-square'                       => 'f174',
			'fa-long-arrow-down'                     => 'f175',
			'fa-long-arrow-up'                       => 'f176',
			'fa-long-arrow-left'                     => 'f177',
			'fa-long-arrow-right'                    => 'f178',
			'fa-apple'                               => 'f179',
			'fa-windows'                             => 'f17a',
			'fa-android'                             => 'f17b',
			'fa-linux'                               => 'f17c',
			'fa-dribbble'                            => 'f17d',
			'fa-skype'                               => 'f17e',
			'fa-foursquare'                          => 'f180',
			'fa-trello'                              => 'f181',
			'fa-female'                              => 'f182',
			'fa-male'                                => 'f183',
			'fa-gratipay'                            => 'f184',
			'fa-sun-o'                               => 'f185',
			'fa-moon-o'                              => 'f186',
			'fa-archive'                             => 'f187',
			'fa-bug'                                 => 'f188',
			'fa-vk'                                  => 'f189',
			'fa-weibo'                               => 'f18a',
			'fa-renren'                              => 'f18b',
			'fa-pagelines'                           => 'f18c',
			'fa-stack-exchange'                      => 'f18d',
			'fa-arrow-circle-o-right'                => 'f18e',
			'fa-arrow-circle-o-left'                 => 'f190',
			'fa-caret-square-o-left'                 => 'f191',
			'fa-dot-circle-o'                        => 'f192',
			'fa-wheelchair'                          => 'f193',
			'fa-vimeo-square'                        => 'f194',
			'fa-try'                                 => 'f195',
			'fa-plus-square-o'                       => 'f196',
			'fa-space-shuttle'                       => 'f197',
			'fa-slack'                               => 'f198',
			'fa-envelope-square'                     => 'f199',
			'fa-wordpress'                           => 'f19a',
			'fa-openid'                              => 'f19b',
			'fa-university'                          => 'f19c',
			'fa-graduation-cap'                      => 'f19d',
			'fa-yahoo'                               => 'f19e',
			'fa-google'                              => 'f1a0',
			'fa-reddit'                              => 'f1a1',
			'fa-reddit-square'                       => 'f1a2',
			'fa-stumbleupon-circle'                  => 'f1a3',
			'fa-stumbleupon'                         => 'f1a4',
			'fa-delicious'                           => 'f1a5',
			'fa-digg'                                => 'f1a6',
			'fa-pied-piper-pp'                       => 'f1a7',
			'fa-pied-piper-alt'                      => 'f1a8',
			'fa-drupal'                              => 'f1a9',
			'fa-joomla'                              => 'f1aa',
			'fa-language'                            => 'f1ab',
			'fa-fax'                                 => 'f1ac',
			'fa-building'                            => 'f1ad',
			'fa-child'                               => 'f1ae',
			'fa-paw'                                 => 'f1b0',
			'fa-spoon'                               => 'f1b1',
			'fa-cube'                                => 'f1b2',
			'fa-cubes'                               => 'f1b3',
			'fa-behance'                             => 'f1b4',
			'fa-behance-square'                      => 'f1b5',
			'fa-steam'                               => 'f1b6',
			'fa-steam-square'                        => 'f1b7',
			'fa-recycle'                             => 'f1b8',
			'fa-car'                                 => 'f1b9',
			'fa-taxi'                                => 'f1ba',
			'fa-tree'                                => 'f1bb',
			'fa-spotify'                             => 'f1bc',
			'fa-deviantart'                          => 'f1bd',
			'fa-soundcloud'                          => 'f1be',
			'fa-database'                            => 'f1c0',
			'fa-file-pdf-o'                          => 'f1c1',
			'fa-file-word-o'                         => 'f1c2',
			'fa-file-excel-o'                        => 'f1c3',
			'fa-file-powerpoint-o'                   => 'f1c4',
			'fa-file-image-o'                        => 'f1c5',
			'fa-file-archive-o'                      => 'f1c6',
			'fa-file-audio-o'                        => 'f1c7',
			'fa-file-video-o'                        => 'f1c8',
			'fa-file-code-o'                         => 'f1c9',
			'fa-vine'                                => 'f1ca',
			'fa-codepen'                             => 'f1cb',
			'fa-jsfiddle'                            => 'f1cc',
			'fa-life-ring'                           => 'f1cd',
			'fa-circle-o-notch'                      => 'f1ce',
			'fa-rebel'                               => 'f1d0',
			'fa-empire'                              => 'f1d1',
			'fa-git-square'                          => 'f1d2',
			'fa-git'                                 => 'f1d3',
			'fa-hacker-news'                         => 'f1d4',
			'fa-tencent-weibo'                       => 'f1d5',
			'fa-qq'                                  => 'f1d6',
			'fa-weixin'                              => 'f1d7',
			'fa-paper-plane'                         => 'f1d8',
			'fa-paper-plane-o'                       => 'f1d9',
			'fa-history'                             => 'f1da',
			'fa-circle-thin'                         => 'f1db',
			'fa-header'                              => 'f1dc',
			'fa-paragraph'                           => 'f1dd',
			'fa-sliders'                             => 'f1de',
			'fa-share-alt'                           => 'f1e0',
			'fa-share-alt-square'                    => 'f1e1',
			'fa-bomb'                                => 'f1e2',
			'fa-futbol-o'                            => 'f1e3',
			'fa-tty'                                 => 'f1e4',
			'fa-binoculars'                          => 'f1e5',
			'fa-plug'                                => 'f1e6',
			'fa-slideshare'                          => 'f1e7',
			'fa-twitch'                              => 'f1e8',
			'fa-yelp'                                => 'f1e9',
			'fa-newspaper-o'                         => 'f1ea',
			'fa-wifi'                                => 'f1eb',
			'fa-calculator'                          => 'f1ec',
			'fa-paypal'                              => 'f1ed',
			'fa-google-wallet'                       => 'f1ee',
			'fa-cc-visa'                             => 'f1f0',
			'fa-cc-mastercard'                       => 'f1f1',
			'fa-cc-discover'                         => 'f1f2',
			'fa-cc-amex'                             => 'f1f3',
			'fa-cc-paypal'                           => 'f1f4',
			'fa-cc-stripe'                           => 'f1f5',
			'fa-bell-slash'                          => 'f1f6',
			'fa-bell-slash-o'                        => 'f1f7',
			'fa-trash'                               => 'f1f8',
			'fa-copyright'                           => 'f1f9',
			'fa-at'                                  => 'f1fa',
			'fa-eyedropper'                          => 'f1fb',
			'fa-paint-brush'                         => 'f1fc',
			'fa-birthday-cake'                       => 'f1fd',
			'fa-area-chart'                          => 'f1fe',
			'fa-pie-chart'                           => 'f200',
			'fa-line-chart'                          => 'f201',
			'fa-lastfm'                              => 'f202',
			'fa-lastfm-square'                       => 'f203',
			'fa-toggle-off'                          => 'f204',
			'fa-toggle-on'                           => 'f205',
			'fa-bicycle'                             => 'f206',
			'fa-bus'                                 => 'f207',
			'fa-ioxhost'                             => 'f208',
			'fa-angellist'                           => 'f209',
			'fa-cc'                                  => 'f20a',
			'fa-ils'                                 => 'f20b',
			'fa-meanpath'                            => 'f20c',
			'fa-buysellads'                          => 'f20d',
			'fa-connectdevelop'                      => 'f20e',
			'fa-dashcube'                            => 'f210',
			'fa-forumbee'                            => 'f211',
			'fa-leanpub'                             => 'f212',
			'fa-sellsy'                              => 'f213',
			'fa-shirtsinbulk'                        => 'f214',
			'fa-simplybuilt'                         => 'f215',
			'fa-skyatlas'                            => 'f216',
			'fa-cart-plus'                           => 'f217',
			'fa-cart-arrow-down'                     => 'f218',
			'fa-diamond'                             => 'f219',
			'fa-ship'                                => 'f21a',
			'fa-user-secret'                         => 'f21b',
			'fa-motorcycle'                          => 'f21c',
			'fa-street-view'                         => 'f21d',
			'fa-heartbeat'                           => 'f21e',
			'fa-venus'                               => 'f221',
			'fa-mars'                                => 'f222',
			'fa-mercury'                             => 'f223',
			'fa-transgender'                         => 'f224',
			'fa-transgender-alt'                     => 'f225',
			'fa-venus-double'                        => 'f226',
			'fa-mars-double'                         => 'f227',
			'fa-venus-mars'                          => 'f228',
			'fa-mars-stroke'                         => 'f229',
			'fa-mars-stroke-v'                       => 'f22a',
			'fa-mars-stroke-h'                       => 'f22b',
			'fa-neuter'                              => 'f22c',
			'fa-genderless'                          => 'f22d',
			'fa-facebook-official'                   => 'f230',
			'fa-pinterest-p'                         => 'f231',
			'fa-whatsapp'                            => 'f232',
			'fa-server'                              => 'f233',
			'fa-user-plus'                           => 'f234',
			'fa-user-times'                          => 'f235',
			'fa-bed'                                 => 'f236',
			'fa-viacoin'                             => 'f237',
			'fa-train'                               => 'f238',
			'fa-subway'                              => 'f239',
			'fa-medium'                              => 'f23a',
			'fa-y-combinator'                        => 'f23b',
			'fa-optin-monster'                       => 'f23c',
			'fa-opencart'                            => 'f23d',
			'fa-expeditedssl'                        => 'f23e',
			'fa-battery-full'                        => 'f240',
			'fa-battery-three-quarters'              => 'f241',
			'fa-battery-half'                        => 'f242',
			'fa-battery-quarter'                     => 'f243',
			'fa-battery-empty'                       => 'f244',
			'fa-mouse-pointer'                       => 'f245',
			'fa-i-cursor'                            => 'f246',
			'fa-object-group'                        => 'f247',
			'fa-object-ungroup'                      => 'f248',
			'fa-sticky-note'                         => 'f249',
			'fa-sticky-note-o'                       => 'f24a',
			'fa-cc-jcb'                              => 'f24b',
			'fa-cc-diners-club'                      => 'f24c',
			'fa-clone'                               => 'f24d',
			'fa-balance-scale'                       => 'f24e',
			'fa-hourglass-o'                         => 'f250',
			'fa-hourglass-start'                     => 'f251',
			'fa-hourglass-half'                      => 'f252',
			'fa-hourglass-end'                       => 'f253',
			'fa-hourglass'                           => 'f254',
			'fa-hand-rock-o'                         => 'f255',
			'fa-hand-paper-o'                        => 'f256',
			'fa-hand-scissors-o'                     => 'f257',
			'fa-hand-lizard-o'                       => 'f258',
			'fa-hand-spock-o'                        => 'f259',
			'fa-hand-pointer-o'                      => 'f25a',
			'fa-hand-peace-o'                        => 'f25b',
			'fa-trademark'                           => 'f25c',
			'fa-registered'                          => 'f25d',
			'fa-creative-commons'                    => 'f25e',
			'fa-gg'                                  => 'f260',
			'fa-gg-circle'                           => 'f261',
			'fa-tripadvisor'                         => 'f262',
			'fa-odnoklassniki'                       => 'f263',
			'fa-odnoklassniki-square'                => 'f264',
			'fa-get-pocket'                          => 'f265',
			'fa-wikipedia-w'                         => 'f266',
			'fa-safari'                              => 'f267',
			'fa-chrome'                              => 'f268',
			'fa-firefox'                             => 'f269',
			'fa-opera'                               => 'f26a',
			'fa-internet-explorer'                   => 'f26b',
			'fa-television'                          => 'f26c',
			'fa-contao'                              => 'f26d',
			'fa-500px'                               => 'f26e',
			'fa-amazon'                              => 'f270',
			'fa-calendar-plus-o'                     => 'f271',
			'fa-calendar-minus-o'                    => 'f272',
			'fa-calendar-times-o'                    => 'f273',
			'fa-calendar-check-o'                    => 'f274',
			'fa-industry'                            => 'f275',
			'fa-map-pin'                             => 'f276',
			'fa-map-signs'                           => 'f277',
			'fa-map-o'                               => 'f278',
			'fa-map'                                 => 'f279',
			'fa-commenting'                          => 'f27a',
			'fa-commenting-o'                        => 'f27b',
			'fa-houzz'                               => 'f27c',
			'fa-vimeo'                               => 'f27d',
			'fa-black-tie'                           => 'f27e',
			'fa-fonticons'                           => 'f280',
			'fa-reddit-alien'                        => 'f281',
			'fa-edge'                                => 'f282',
			'fa-credit-card-alt'                     => 'f283',
			'fa-codiepie'                            => 'f284',
			'fa-modx'                                => 'f285',
			'fa-fort-awesome'                        => 'f286',
			'fa-usb'                                 => 'f287',
			'fa-product-hunt'                        => 'f288',
			'fa-mixcloud'                            => 'f289',
			'fa-scribd'                              => 'f28a',
			'fa-pause-circle'                        => 'f28b',
			'fa-pause-circle-o'                      => 'f28c',
			'fa-stop-circle'                         => 'f28d',
			'fa-stop-circle-o'                       => 'f28e',
			'fa-shopping-bag'                        => 'f290',
			'fa-shopping-basket'                     => 'f291',
			'fa-hashtag'                             => 'f292',
			'fa-bluetooth'                           => 'f293',
			'fa-bluetooth-b'                         => 'f294',
			'fa-percent'                             => 'f295',
			'fa-gitlab'                              => 'f296',
			'fa-wpbeginner'                          => 'f297',
			'fa-wpforms'                             => 'f298',
			'fa-envira'                              => 'f299',
			'fa-universal-access'                    => 'f29a',
			'fa-wheelchair-alt'                      => 'f29b',
			'fa-question-circle-o'                   => 'f29c',
			'fa-blind'                               => 'f29d',
			'fa-audio-description'                   => 'f29e',
			'fa-volume-control-phone'                => 'f2a0',
			'fa-braille'                             => 'f2a1',
			'fa-assistive-listening-systems'         => 'f2a2',
			'fa-american-sign-language-interpreting' => 'f2a3',
			'fa-deaf'                                => 'f2a4',
			'fa-glide'                               => 'f2a5',
			'fa-glide-g'                             => 'f2a6',
			'fa-sign-language'                       => 'f2a7',
			'fa-low-vision'                          => 'f2a8',
			'fa-viadeo'                              => 'f2a9',
			'fa-viadeo-square'                       => 'f2aa',
			'fa-snapchat'                            => 'f2ab',
			'fa-snapchat-ghost'                      => 'f2ac',
			'fa-snapchat-square'                     => 'f2ad',
			'fa-pied-piper'                          => 'f2ae',
			'fa-first-order'                         => 'f2b0',
			'fa-yoast'                               => 'f2b1',
			'fa-themeisle'                           => 'f2b2',
			'fa-google-plus-official'                => 'f2b3',
			'fa-font-awesome'                        => 'f2b4',
			'fa-address-card-o' => 'fa-address-card-o',
			'fa-handshake-o' => 'fa-handshake-o',
			'fa-id-badge' => 'fa-id-badge',
			'fa-meetup' => 'fa-meetup',
			'fa-podcast' => 'fa-podcast',
			'fa-snowflake-o' => 'fa-snowflake-o',
			'fa-telegram' => 'fa-telegram',
			'fa-thermometer-1' => 'fa-thermometer-1',
			'fa-thermometer-empty' => 'fa-thermometer-empty',
			'fa-times-rectangle-o' => 'fa-times-rectangle-o',
			'fa-window-close' => 'fa-window-close',
			'fa-window-restore' => 'fa-window-restore',
			'fa-wpexplorer' => 'fa-wpexplorer',
			'fa-window-close-o' => 'fa-window-close-o',
			'fa-user-o' => 'fa-user-o',
			'fa-thermometer-full' => 'fa-thermometer-full',
			'fa-thermometer-2' => 'fa-thermometer-2',
			'fa-id-card' => 'fa-id-card',
			'fa-imdb' => 'fa-imdb',
			'fa-drivers-license' => 'fa-drivers-license',
			'fa-bath' => 'fa-bath',
			'fa-address-book' => 'fa-address-book',
			'fa-address-book-o' => 'fa-address-book-o',
			'fa-bathtub' => 'fa-bathtub',
			'fa-envelope-open' => 'fa-envelope-open',
			'fa-id-card-o' => 'fa-id-card-o',
			'fa-quora' => 'fa-quora',
			'fa-s15' => 'fa-s15',
			'fa-superpowers' => 'fa-superpowers',
			'fa-thermometer-half' => 'fa-thermometer-half',
			'fa-user-circle' => 'fa-user-circle',
			'fa-vcard' => 'fa-vcard',
			'fa-window-maximize' => 'fa-window-maximize',
			'fa-window-minimize' => 'fa-window-minimize',
			'fa-user-secret' => 'fa-user-secret',
			'fa-user-circle-o' => 'fa-user-circle-o',
			'fa-times-rectangle' => 'fa-times-rectangle',
			'fa-thermometer-quarter' => 'fa-thermometer-quarter',
			'fa-shower' => 'fa-shower',
			'fa-ravelry' => 'fa-ravelry',
			'fa-microchip' => 'fa-microchip',
			'fa-grav' => 'fa-grav',
			'fa-free-code-camp' => 'fa-free-code-camp',
			'fa-etsy' => 'fa-etsy',
			'fa-envelope-open-o' => 'fa-envelope-open-o',
			'fa-eercast' => 'fa-eercast',
			'fa-bandcamp' => 'fa-bandcamp',
			'fa-address-card' => 'fa-address-card'
		);
		
		ksort( $icons );
		
		//echo 'Icons: ' . $icons_sorted[0];
		
		return $icons;
}