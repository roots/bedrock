<?php
/**
 * Quick Setup Wizard Helper Styles & Javascript code
 * 
 * @package EasySocialShareButtons
 * @author appscore
 * @since 5.0
 * 
 */

?>

<style type="text/css">
.essb-version {
	background: rgba(0, 0, 0, 0.3);
	display: block;
	position: absolute;
	padding: 5px 0px;
	width: 100%;
	bottom: 0;
	left: 0;
	font-size: 13px;
}
.essb-page-welcome .wp-badge {
	padding-top: 70px;
	width: 100px;
	background-size: 48px;
	background-position: center 20px;
	border-radius: 5px;
	-webkit-border-radius: 5px;
}

.about-wrap { max-width: 100%; }
.about-wrap .wp-badge { right: 20px; }
.about-wrap h1 { font-size: 24px; }
.about-wrap img { border: 0px; }
.about-wrap .about-text { margin: 1em 180px 1em 0; font-size: 16px; }

/** wizard tabs **/
.essb-wizard-menu li { display: inline-block; padding: 10px; border-radius: 3px; }
.essb-wizard-menu li a { color: #aaa; text-decoration: none; text-align: center; font-size: 11px; text-transform: uppercase; }
.essb-wizard-menu li a i { font-size: 21px; display: block; margin-bottom: 5px; }
.essb-wizard-menu li.passed a { color: #333; }
.essb-wizard-menu li.active {
	box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.2);
	background-color: #2B6A94;
	color: #fff;
	background: linear-gradient(to bottom,  #2b6a94 1%,#23577a 100%);
}

.essb-wizard-menu li.active a { color: #fff; }

.essb-wizard-buttons { 
	margin: 20px 0px;

		
}

.essb-wizard-buttons.scroll-to-fixed-fixed {
	background: #fff;
	padding-left: 20px;
	padding-right: 20px;
	margin: 0 !important;
}

#essb-btn-updatew {
	margin-right: 30px;
}

.essb-data-container {
	box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
	padding: 30px 20px;
	margin-bottom: 30px;
}

</style>

<script type="text/javascript">
jQuery(document).ready(function($){
	$(".essb-wizard-menu").find(".essb-menu-item").each(function() {
		
		$(this).click(function(e) {
			$(".essb-wizard-menu").find(".essb-menu-item").each(function(){
				if ($(this).hasClass('active')) {
					$(this).removeClass('active');
					$(this).addClass('passed');
				}
			});

			if (!$(this).prev().length) 
				$('#prevbutton').hide();
			else
				$('#prevbutton').show();

			if (!$(this).next().length) 
				$('#nextbutton').hide();
			else
				$('#nextbutton').show();
			
			
			$(this).addClass('active');

			var lookupHolder = $(this).attr('data-menu') || '';

			if (lookupHolder != '') {
				$(".essb-options-container").find(".essb-data-container").each(function(){
					if ($(this).hasClass('active')) {
						$(this).removeClass('active');
						$(this).fadeOut('fast');
					}
				});

				if ($('#essb-container-'+lookupHolder).length) {
					$('#essb-container-'+lookupHolder).addClass('active');
					$('#essb-container-'+lookupHolder).fadeIn('fast');
				}

			}
		});
	});

	$('#nextbutton').click(function(e) {
		var triggerOn;
		$(".essb-wizard-menu").find(".essb-menu-item").each(function(){
			if ($(this).hasClass('active')) {
				if ($(this).next().length) {
					triggerOn = $(this).next();					
				}
			}
		});

		if ($(triggerOn).length)
			$(triggerOn).trigger('click');
	});

	$('#prevbutton').click(function(e) {
		var triggerOn;
		$(".essb-wizard-menu").find(".essb-menu-item").each(function(){
			if ($(this).hasClass('active')) {
				if ($(this).prev().length) {
					triggerOn = $(this).prev();					
				}
			}
		});

		if ($(triggerOn).length)
			$(triggerOn).trigger('click');
	});
	
	
	$(".essb-wizard-menu").find(".essb-menu-item").first().trigger('click');

	$('#essb_options_functions_mode_mobile').change(function(e) {
		var selectedMode = $(this).val();

		if (selectedMode == 'auto' || selectedMode == 'deactivate') {
			$('#essb-wizard-mobile-auto').show();
			$('#essb-wizard-mobile-manual').hide();
		}
		else {
			$('#essb-wizard-mobile-auto').hide();
			$('#essb-wizard-mobile-manual').show();
		}
	});

	$('#essb_options_functions_mode').change(function(e) {
		var selectedMode = $(this).val();

		if (selectedMode == 'light') {
			$('#essb-wizard-subscribe-auto').show();
			$('#essb-wizard-subscribe-manual').hide();
		}
		else {
			$('#essb-wizard-subscribe-auto').hide();
			$('#essb-wizard-subscribe-manual').show();
		}

		if (selectedMode == 'light' || selectedMode == 'medium' || selectedMode == 'advanced') {
			$('#essb-wizard-follow-auto').show();
			$('#essb-wizard-follow-manual').hide();
		}
		else {
			$('#essb-wizard-follow-auto').hide();
			$('#essb-wizard-follow-manual').show();
		}
	});

	$('#essb_options_functions_mode_mobile').trigger('change');
	$('#essb_options_functions_mode').trigger('change');

	$('.essb-wizard-buttons').scrollToFixed( {marginTop: 30 });
});

var wizardTab = true;
</script>

<div class="essb-page-welcome essb-wizard-holder about-wrap">
	<h1><?php echo sprintf( __( 'Welcome to Quick Setup Wizard of Easy Social Share Buttons for WordPress %s', 'essb' ), preg_replace( '/^(\d+)(\.\d+)?(\.\d)?/', '$1$2', ESSB3_VERSION ) ) ?></h1>

	<div class="about-text">
		<?php _e( 'Thank you for choosing the best social sharing plugin for WordPress. The quick setup wizard will guide you through the setup of most common used functions of plugin and let you make a quick start. For additional detailed settings you can use later the plugin options screen.', 'essb' )?>
	</div>
	<div class="wp-badge essb-page-logo essb-logo">
		<span class="essb-version"><?php echo sprintf( __( 'Version %s', 'essb' ), ESSB3_VERSION )?></span>
	</div>

</div>
<div class="clear"></div>
<?php 
$options = $essb_section_options [$current_tab];
$section = $essb_sidebar_sections [$current_tab];

/* Drawing Wizard Tabs */

//ESSBOptionsInterface::draw_sidebar ( $section ['fields'] );
essb_wizard_draw_tabs($section['fields']);

ESSBOptionsInterface::draw_form_start (false, '', $tab_has_nomenu);	
$update_button_text = __('Save Settings', 'essb');
$next_prev_buttons = '<a name="prevbutton" id="prevbutton" class="essb-btn essb-wizard-prev">< Previous</a>&nbsp;<a name="nextbutton" id="nextbutton" class="essb-btn essb-wizard-next">Next ></a>&nbsp;&nbsp;&nbsp;';

echo '<div class="essb-wizard-buttons">
<input type="Submit" name="Submit" value="' . $update_button_text . '" class="essb-btn essb-btn-red" id="essb-btn-updatew" />
'.$next_prev_buttons.'
</div>';
	
ESSBOptionsInterface::draw_content ( $options );




ESSBOptionsInterface::draw_form_end ();

ESSBOptionsFramework::register_color_selector ();


/** Helper Additional Code **/

function essb_wizard_draw_tabs($options = array()) {
	echo '<div class="essb-wizard-tabs" id="essb-wizard-tabs">';
	
	echo '<ul class="essb-wizard-menu">';
	
	foreach ($options as $single) {
		$type = $single['type'];
		$field_id = isset($single['field_id']) ? $single['field_id'] : '';
		$title = isset($single['title']) ? $single['title'] : '';
		$sub_menuaction = isset($single['action']) ? $single['action'] : '';
		$default_child = isset($single['default_child']) ? $single['default_child'] : '';
		$icon = isset($single['icon']) ? $single['icon'] : '';
			
		$level2 = isset($single['level2']) ? $single['level2'] : '';
			
		if ($icon == 'default') {
			//$icon = 'gear';
			$icon = 'circle essb-navigation-small-icon';
		}
			
		if ($level2 == 'true') {
			$icon = 'circle essb-navigation-small-icon';
		}
			
		if ($icon != '') {
			if (strpos($icon, 'ti-') !== false ) {
				$icon = sprintf('<i class="essb-sidebar-icon %1$s"></i>', $icon);
			}
			else {
				$icon = sprintf('<i class="essb-sidebar-icon fa fa-%1$s"></i>', $icon);
			}
		}
			
		$css_class = "";
		switch ($type) {
			case "menu_item":
				$css_class = "essb-menu-item";
					
				if ($sub_menuaction == "activate_first") {
					$css_class .= " essb-activate-first";
				}
				break;
			case "sub_menu_item":
				$css_class = "essb-submenu-item";
					
				if ($sub_menuaction == 'menu') {
					$css_class .= " essb-submenu-menuitem";
				}
					
				if ($level2 == 'true') {
					$css_class .= " level2";
				}
					
				if ($level2 != 'title') {
					$css_class .= ' essb-submenu-with-action';
				}
				if ($level2 == 'title') {
					$css_class .= ' essb-submenu-title';
				}
					
				break;
			case "heading":
				$css_class = "essb-title";
				break;
			default:
				$css_class = "essb-menu-item";
				break;
		}
			
		printf('<li class="%1$s essb-menuid-%2$s" data-menu="%2$s" data-activate-child="%4$s" id="essb-menu-%2$s"><a href="#">%5$s%3$s</a></li>', $css_class, $field_id, $title, $default_child, $icon);
	}
	
	echo '</ul>';
	
	echo '</div>';
}
?>