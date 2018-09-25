<?php

// - - - - - - - - - -
// FontAwesome Icon
// - - - - - - - - - -

function vntd_icon($atts, $content = null) {
	extract(shortcode_atts(array(
		"icon" => '',
		"color" => '',
		"style" => '',
		"float" => '',
		"size" => 'small'
	), $atts));
	
	$icon_class = $extra_styling = '';
	if($style == "bordered") {
		$icon_class .= ' vntd-icon-style-bordered';
		if(strpos($color,'#') !== false) {
			$extra_styling = 'style="color:'.$color.';border-color:'.$color.'"';
		} else {
			if(!$color) $color = "accent";
			$icon_class .= ' vntd-bordercolor-'.$color.' vntd-color-'.$color;
		}
	} elseif ($style == "colored") {
		$icon_class .= ' vntd-icon-style-colored';	

		if(strpos($color,'#') !== false) {
			$extra_styling .= 'style="background-color:'.$color.';"';
		} else {
			if(!$color) $color = "accent";
			$icon_class .= ' vntd-bgcolor-'.$color;
		}
		
	} elseif(strpos($color,'#') !== false) {
		$extra_styling .= 'style="color:'.$color.';"';
	} elseif($color) {
		$icon_class .= ' vntd-color-'.$color;
	}
	
	if($float) {
		$icon_class .= ' vntd-icon-float-'.$float;
	}
	
	return '<i class="fa fa-'.$icon.' vntd-icon vntd-icon-'.$size.$icon_class.'"'.$extra_styling.'></i>';
}
remove_shortcode('icon');
add_shortcode('icon', 'vntd_icon');


// Shortcode init

function vntd_sc_icon()
{
	add_action('cs_init_bilder', 'vntd_icon_init_info');
	add_action('cs_init_shortcode','vntd_icon_init_bilder');
}

add_action('wp_cs_init','vntd_sc_icon');


// Shortcode Builder


function vntd_icon_init_info()
{
	cs_show_bilder(
		'icon',
		'Icon',
		'',
		''
	);
}

function vntd_icon_init_bilder($id)
{
	if($id == 'icon'):
		$out = '';
		ob_start(); 
		vntd_icon_builder();
		$out .= ob_get_contents(); 
		ob_end_clean();
		cs_show_shortcode($id,$out,'short');
	endif;
}
	
function vntd_icon_builder()
{
wp_enqueue_script( 'scrolltofixed' , '', '', '', true);

global $smof_data;
$accent_color = $smof_data['vntd_accent_color'];

?>

<script type="text/javascript">
(function($){
	
	$('.select-size').change(function() {			
		$('.icon-preview i').removeClass (function (index, css) {
		    return (css.match (/\bvntd-icon-size-\S+/g) || []).join(' ');
		});			
		$('.icon-preview i').addClass("vntd-icon-size-"+$(this).val());
	});
	
	$('.select-style').change(function() {	
		$('.icon-preview i').removeClass (function (index, css) {
		    return (css.match (/\bvntd-icon-style-\S+/g) || []).join(' ');
		});		
		$('.icon-preview i').addClass('vntd-icon-style-'+$(this).val());
	});
	
	$("input[name=icon]").live("change",function(){
	    var val = $(this).val();
	    $('.icon-preview i').removeClass (function (index, css) {
	        return (css.match (/\bfa-\S+/g) || []).join(' ');
	    });	
	    $(".icon-preview i").addClass('fa-'+val);	
	});
	
	$('select.select-folds').change(function() {
		var val = $(this).val();
		var name = $(this).attr('name');
		$('.folds-'+name).hide();
		$('.folds-'+name+'.folds-'+name+'-'+val).fadeIn();		
	});
		
})(jQuery)	
</script>	

<style>

.vntd-icon {
	margin: 0 4px 5px 0;
}

.vntd-icon-size-medium {
	font-size: 24px;
	margin: 0 8px 8px 0;
}

.vntd-icon-size-large {
	font-size: 40px;
	margin: 0 12px 12px 0;	
}

	.vntd-icon-float-left {
		float: left;
		margin: 0 20px 20px 0;
	}
	
	.vntd-icon-float-right {
		float: right;
		margin: 0 0 20px 20px;
	}
	
	.vntd-icon-size-medium.vntd-icon-float-left {
		margin: 0 12px 12px 0;
	}
	
	.vntd-icon-size-medium.vntd-icon-float-right {
		margin: 0  0 12px 12px;
	}

.vntd-icon-style-bordered,
.vntd-icon-style-colored {
	border-radius: 50px;
	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	text-align: center;
}

.vntd-icon-style-colored {	
	color: #fff !important;	
	background-color: <?php echo $accent_color ?>;
}

.vntd-icon-style-bordered.vntd-icon-size-small,
.vntd-icon-style-colored.vntd-icon-size-small {
	width: 22px;
	height: 22px;
	line-height: 23px;	
	font-size: 14px;
}
.vntd-icon-style-colored.vntd-icon-size-small {
	width: 24px;
	height: 24px;
}
.vntd-icon-style-bordered.vntd-icon-size-medium,
.vntd-icon-style-colored.vntd-icon-size-medium {
	font-size: 24px;
	width: 42px;
	height: 42px;
	line-height: 43px;
}

.vntd-icon-style-colored.vntd-icon-size-medium {
	width: 44px;
	height: 44px;
}

.vntd-icon-style-bordered.vntd-icon-size-large,
.vntd-icon-style-colored.vntd-icon-size-large {
	font-size: 38px;
	width: 80px;
	height: 80px;
	line-height: 81px;
}

.vntd-icon-style-bordered {
	border: 1px solid #f1f1f1;
	background: none !important;
	border-color: <?php echo $accent_color ?>;
	color: <?php echo $accent_color ?>;
}

	
		
</style>

<div>
<div class="button-right cs-c-right">

	<div class="cs-settings admin-form">
		<div class="caretta-cf">
			<label>Icon size</label>
			<select name="size" data-cs-name="size" class="select select-size">
				<option value="small" selected="selected">Small</option>
				<option value="medium">Medium</option>					
				<option value="large">Large</option>
			</select>
		</div>
		<div class="caretta-cf">
			<label>Style</label>
			<select name="style" data-cs-name="style" class="select select-style select-folds">
				<option value="none" selected="selected">No Styling</option>
				<option value="colored">Colored</option>
				<option value="bordered">Bordered</option>								
			</select>
		</div>
	</div>
	
</div>
<div class="button-left cs-c-left">

	<h3>Icon Preview:</h3>
	<div class="element-preview">
		<div class="icon-preview"><i class="fa fa-twitter vntd-icon-size-small vntd-icon-style-none"></i></div>
	</div>
	
	<h3>Choose Icon:</h3>
	<div class="social-icons-container">
	<div class="social-icon-list">
		<?php
		
			$icons = array ('fa-glass' => 'fa-glass', 'fa-music' => 'fa-music', 'fa-search' => 'fa-search', 'fa-envelope-o' => 'fa-envelope-o', 'fa-heart' => 'fa-heart', 'fa-star' => 'fa-star', 'fa-star-o' => 'fa-star-o', 'fa-user' => 'fa-user', 'fa-film' => 'fa-film', 'fa-th-large' => 'fa-th-large', 'fa-th' => 'fa-th', 'fa-th-list' => 'fa-th-list', 'fa-check' => 'fa-check', 'fa-times' => 'fa-times', 'fa-search-plus' => 'fa-search-plus', 'fa-search-minus' => 'fa-search-minus', 'fa-power-off' => 'fa-power-off', 'fa-signal' => 'fa-signal', 'fa-cog' => 'fa-cog', 'fa-trash-o' => 'fa-trash-o', 'fa-home' => 'fa-home', 'fa-file-o' => 'fa-file-o', 'fa-clock-o' => 'fa-clock-o', 'fa-road' => 'fa-road', 'fa-download' => 'fa-download', 'fa-arrow-circle-o-down' => 'fa-arrow-circle-o-down', 'fa-arrow-circle-o-up' => 'fa-arrow-circle-o-up', 'fa-inbox' => 'fa-inbox', 'fa-play-circle-o' => 'fa-play-circle-o', 'fa-repeat' => 'fa-repeat', 'fa-refresh' => 'fa-refresh', 'fa-list-alt' => 'fa-list-alt', 'fa-lock' => 'fa-lock', 'fa-flag' => 'fa-flag', 'fa-headphones' => 'fa-headphones', 'fa-volume-off' => 'fa-volume-off', 'fa-volume-down' => 'fa-volume-down', 'fa-volume-up' => 'fa-volume-up', 'fa-qrcode' => 'fa-qrcode', 'fa-barcode' => 'fa-barcode', 'fa-tag' => 'fa-tag', 'fa-tags' => 'fa-tags', 'fa-book' => 'fa-book', 'fa-bookmark' => 'fa-bookmark', 'fa-print' => 'fa-print', 'fa-camera' => 'fa-camera', 'fa-font' => 'fa-font', 'fa-bold' => 'fa-bold', 'fa-italic' => 'fa-italic', 'fa-text-height' => 'fa-text-height', 'fa-text-width' => 'fa-text-width', 'fa-align-left' => 'fa-align-left', 'fa-align-center' => 'fa-align-center', 'fa-align-right' => 'fa-align-right', 'fa-align-justify' => 'fa-align-justify', 'fa-list' => 'fa-list', 'fa-outdent' => 'fa-outdent', 'fa-indent' => 'fa-indent', 'fa-video-camera' => 'fa-video-camera', 'fa-picture-o' => 'fa-picture-o', 'fa-pencil' => 'fa-pencil', 'fa-map-marker' => 'fa-map-marker', 'fa-adjust' => 'fa-adjust', 'fa-tint' => 'fa-tint', 'fa-pencil-square-o' => 'fa-pencil-square-o', 'fa-share-square-o' => 'fa-share-square-o', 'fa-check-square-o' => 'fa-check-square-o', 'fa-arrows' => 'fa-arrows', 'fa-step-backward' => 'fa-step-backward', 'fa-fast-backward' => 'fa-fast-backward', 'fa-backward' => 'fa-backward', 'fa-play' => 'fa-play', 'fa-pause' => 'fa-pause', 'fa-stop' => 'fa-stop', 'fa-forward' => 'fa-forward', 'fa-fast-forward' => 'fa-fast-forward', 'fa-step-forward' => 'fa-step-forward', 'fa-eject' => 'fa-eject', 'fa-chevron-left' => 'fa-chevron-left', 'fa-chevron-right' => 'fa-chevron-right', 'fa-plus-circle' => 'fa-plus-circle', 'fa-minus-circle' => 'fa-minus-circle', 'fa-times-circle' => 'fa-times-circle', 'fa-check-circle' => 'fa-check-circle', 'fa-question-circle' => 'fa-question-circle', 'fa-info-circle' => 'fa-info-circle', 'fa-crosshairs' => 'fa-crosshairs', 'fa-times-circle-o' => 'fa-times-circle-o', 'fa-check-circle-o' => 'fa-check-circle-o', 'fa-ban' => 'fa-ban', 'fa-arrow-left' => 'fa-arrow-left', 'fa-arrow-right' => 'fa-arrow-right', 'fa-arrow-up' => 'fa-arrow-up', 'fa-arrow-down' => 'fa-arrow-down', 'fa-share' => 'fa-share', 'fa-expand' => 'fa-expand', 'fa-compress' => 'fa-compress', 'fa-plus' => 'fa-plus', 'fa-minus' => 'fa-minus', 'fa-asterisk' => 'fa-asterisk', 'fa-exclamation-circle' => 'fa-exclamation-circle', 'fa-gift' => 'fa-gift', 'fa-leaf' => 'fa-leaf', 'fa-fire' => 'fa-fire', 'fa-eye' => 'fa-eye', 'fa-eye-slash' => 'fa-eye-slash', 'fa-exclamation-triangle' => 'fa-exclamation-triangle', 'fa-plane' => 'fa-plane', 'fa-calendar' => 'fa-calendar', 'fa-random' => 'fa-random', 'fa-comment' => 'fa-comment', 'fa-magnet' => 'fa-magnet', 'fa-chevron-up' => 'fa-chevron-up', 'fa-chevron-down' => 'fa-chevron-down', 'fa-retweet' => 'fa-retweet', 'fa-shopping-cart' => 'fa-shopping-cart', 'fa-folder' => 'fa-folder', 'fa-folder-open' => 'fa-folder-open', 'fa-arrows-v' => 'fa-arrows-v', 'fa-arrows-h' => 'fa-arrows-h', 'fa-bar-chart-o' => 'fa-bar-chart-o', 'fa-twitter-square' => 'fa-twitter-square', 'fa-facebook-square' => 'fa-facebook-square', 'fa-camera-retro' => 'fa-camera-retro', 'fa-key' => 'fa-key', 'fa-cogs' => 'fa-cogs', 'fa-comments' => 'fa-comments', 'fa-thumbs-o-up' => 'fa-thumbs-o-up', 'fa-thumbs-o-down' => 'fa-thumbs-o-down', 'fa-star-half' => 'fa-star-half', 'fa-heart-o' => 'fa-heart-o', 'fa-sign-out' => 'fa-sign-out', 'fa-linkedin-square' => 'fa-linkedin-square', 'fa-thumb-tack' => 'fa-thumb-tack', 'fa-external-link' => 'fa-external-link', 'fa-sign-in' => 'fa-sign-in', 'fa-trophy' => 'fa-trophy', 'fa-github-square' => 'fa-github-square', 'fa-upload' => 'fa-upload', 'fa-lemon-o' => 'fa-lemon-o', 'fa-phone' => 'fa-phone', 'fa-square-o' => 'fa-square-o', 'fa-bookmark-o' => 'fa-bookmark-o', 'fa-phone-square' => 'fa-phone-square', 'fa-twitter' => 'fa-twitter', 'fa-facebook' => 'fa-facebook', 'fa-github' => 'fa-github', 'fa-unlock' => 'fa-unlock', 'fa-credit-card' => 'fa-credit-card', 'fa-rss' => 'fa-rss', 'fa-hdd-o' => 'fa-hdd-o', 'fa-bullhorn' => 'fa-bullhorn', 'fa-bell' => 'fa-bell', 'fa-certificate' => 'fa-certificate', 'fa-hand-o-right' => 'fa-hand-o-right', 'fa-hand-o-left' => 'fa-hand-o-left', 'fa-hand-o-up' => 'fa-hand-o-up', 'fa-hand-o-down' => 'fa-hand-o-down', 'fa-arrow-circle-left' => 'fa-arrow-circle-left', 'fa-arrow-circle-right' => 'fa-arrow-circle-right', 'fa-arrow-circle-up' => 'fa-arrow-circle-up', 'fa-arrow-circle-down' => 'fa-arrow-circle-down', 'fa-globe' => 'fa-globe', 'fa-wrench' => 'fa-wrench', 'fa-tasks' => 'fa-tasks', 'fa-filter' => 'fa-filter', 'fa-briefcase' => 'fa-briefcase', 'fa-arrows-alt' => 'fa-arrows-alt', 'fa-users' => 'fa-users', 'fa-link' => 'fa-link', 'fa-cloud' => 'fa-cloud', 'fa-flask' => 'fa-flask', 'fa-scissors' => 'fa-scissors', 'fa-files-o' => 'fa-files-o', 'fa-paperclip' => 'fa-paperclip', 'fa-floppy-o' => 'fa-floppy-o', 'fa-square' => 'fa-square', 'fa-bars' => 'fa-bars', 'fa-list-ul' => 'fa-list-ul', 'fa-list-ol' => 'fa-list-ol', 'fa-strikethrough' => 'fa-strikethrough', 'fa-underline' => 'fa-underline', 'fa-table' => 'fa-table', 'fa-magic' => 'fa-magic', 'fa-truck' => 'fa-truck', 'fa-pinterest' => 'fa-pinterest', 'fa-pinterest-square' => 'fa-pinterest-square', 'fa-google-plus-square' => 'fa-google-plus-square', 'fa-google-plus' => 'fa-google-plus', 'fa-money' => 'fa-money', 'fa-caret-down' => 'fa-caret-down', 'fa-caret-up' => 'fa-caret-up', 'fa-caret-left' => 'fa-caret-left', 'fa-caret-right' => 'fa-caret-right', 'fa-columns' => 'fa-columns', 'fa-sort' => 'fa-sort', 'fa-sort-asc' => 'fa-sort-asc', 'fa-sort-desc' => 'fa-sort-desc', 'fa-envelope' => 'fa-envelope', 'fa-linkedin' => 'fa-linkedin', 'fa-undo' => 'fa-undo', 'fa-gavel' => 'fa-gavel', 'fa-tachometer' => 'fa-tachometer', 'fa-comment-o' => 'fa-comment-o', 'fa-comments-o' => 'fa-comments-o', 'fa-bolt' => 'fa-bolt', 'fa-sitemap' => 'fa-sitemap', 'fa-umbrella' => 'fa-umbrella', 'fa-clipboard' => 'fa-clipboard', 'fa-lightbulb-o' => 'fa-lightbulb-o', 'fa-exchange' => 'fa-exchange', 'fa-cloud-download' => 'fa-cloud-download', 'fa-cloud-upload' => 'fa-cloud-upload', 'fa-user-md' => 'fa-user-md', 'fa-stethoscope' => 'fa-stethoscope', 'fa-suitcase' => 'fa-suitcase', 'fa-bell-o' => 'fa-bell-o', 'fa-coffee' => 'fa-coffee', 'fa-cutlery' => 'fa-cutlery', 'fa-file-text-o' => 'fa-file-text-o', 'fa-building-o' => 'fa-building-o', 'fa-hospital-o' => 'fa-hospital-o', 'fa-ambulance' => 'fa-ambulance', 'fa-medkit' => 'fa-medkit', 'fa-fighter-jet' => 'fa-fighter-jet', 'fa-beer' => 'fa-beer', 'fa-h-square' => 'fa-h-square', 'fa-plus-square' => 'fa-plus-square', 'fa-angle-double-left' => 'fa-angle-double-left', 'fa-angle-double-right' => 'fa-angle-double-right', 'fa-angle-double-up' => 'fa-angle-double-up', 'fa-angle-double-down' => 'fa-angle-double-down', 'fa-angle-left' => 'fa-angle-left', 'fa-angle-right' => 'fa-angle-right', 'fa-angle-up' => 'fa-angle-up', 'fa-angle-down' => 'fa-angle-down', 'fa-desktop' => 'fa-desktop', 'fa-laptop' => 'fa-laptop', 'fa-tablet' => 'fa-tablet', 'fa-mobile' => 'fa-mobile', 'fa-circle-o' => 'fa-circle-o', 'fa-quote-left' => 'fa-quote-left', 'fa-quote-right' => 'fa-quote-right', 'fa-spinner' => 'fa-spinner', 'fa-circle' => 'fa-circle', 'fa-reply' => 'fa-reply', 'fa-github-alt' => 'fa-github-alt', 'fa-folder-o' => 'fa-folder-o', 'fa-folder-open-o' => 'fa-folder-open-o', 'fa-smile-o' => 'fa-smile-o', 'fa-frown-o' => 'fa-frown-o', 'fa-meh-o' => 'fa-meh-o', 'fa-gamepad' => 'fa-gamepad', 'fa-keyboard-o' => 'fa-keyboard-o', 'fa-flag-o' => 'fa-flag-o', 'fa-flag-checkered' => 'fa-flag-checkered', 'fa-terminal' => 'fa-terminal', 'fa-code' => 'fa-code', 'fa-reply-all' => 'fa-reply-all', 'fa-mail-reply-all' => 'fa-mail-reply-all', 'fa-star-half-o' => 'fa-star-half-o', 'fa-location-arrow' => 'fa-location-arrow', 'fa-crop' => 'fa-crop', 'fa-code-fork' => 'fa-code-fork', 'fa-chain-broken' => 'fa-chain-broken', 'fa-question' => 'fa-question', 'fa-info' => 'fa-info', 'fa-exclamation' => 'fa-exclamation', 'fa-superscript' => 'fa-superscript', 'fa-subscript' => 'fa-subscript', 'fa-eraser' => 'fa-eraser', 'fa-puzzle-piece' => 'fa-puzzle-piece', 'fa-microphone' => 'fa-microphone', 'fa-microphone-slash' => 'fa-microphone-slash', 'fa-shield' => 'fa-shield', 'fa-calendar-o' => 'fa-calendar-o', 'fa-fire-extinguisher' => 'fa-fire-extinguisher', 'fa-rocket' => 'fa-rocket', 'fa-maxcdn' => 'fa-maxcdn', 'fa-chevron-circle-left' => 'fa-chevron-circle-left', 'fa-chevron-circle-right' => 'fa-chevron-circle-right', 'fa-chevron-circle-up' => 'fa-chevron-circle-up', 'fa-chevron-circle-down' => 'fa-chevron-circle-down', 'fa-html5' => 'fa-html5', 'fa-css3' => 'fa-css3', 'fa-anchor' => 'fa-anchor', 'fa-unlock-alt' => 'fa-unlock-alt', 'fa-bullseye' => 'fa-bullseye', 'fa-ellipsis-h' => 'fa-ellipsis-h', 'fa-ellipsis-v' => 'fa-ellipsis-v', 'fa-rss-square' => 'fa-rss-square', 'fa-play-circle' => 'fa-play-circle', 'fa-ticket' => 'fa-ticket', 'fa-minus-square' => 'fa-minus-square', 'fa-minus-square-o' => 'fa-minus-square-o', 'fa-level-up' => 'fa-level-up', 'fa-level-down' => 'fa-level-down', 'fa-check-square' => 'fa-check-square', 'fa-pencil-square' => 'fa-pencil-square', 'fa-external-link-square' => 'fa-external-link-square', 'fa-share-square' => 'fa-share-square', 'fa-compass' => 'fa-compass', 'fa-caret-square-o-down' => 'fa-caret-square-o-down', 'fa-caret-square-o-up' => 'fa-caret-square-o-up', 'fa-caret-square-o-right' => 'fa-caret-square-o-right', 'fa-eur' => 'fa-eur', 'fa-gbp' => 'fa-gbp', 'fa-usd' => 'fa-usd', 'fa-inr' => 'fa-inr', 'fa-jpy' => 'fa-jpy', 'fa-rub' => 'fa-rub', 'fa-krw' => 'fa-krw', 'fa-btc' => 'fa-btc', 'fa-file' => 'fa-file', 'fa-file-text' => 'fa-file-text', 'fa-sort-alpha-asc' => 'fa-sort-alpha-asc', 'fa-sort-alpha-desc' => 'fa-sort-alpha-desc', 'fa-sort-amount-asc' => 'fa-sort-amount-asc', 'fa-sort-amount-desc' => 'fa-sort-amount-desc', 'fa-sort-numeric-asc' => 'fa-sort-numeric-asc', 'fa-sort-numeric-desc' => 'fa-sort-numeric-desc', 'fa-thumbs-up' => 'fa-thumbs-up', 'fa-thumbs-down' => 'fa-thumbs-down', 'fa-youtube-square' => 'fa-youtube-square', 'fa-youtube' => 'fa-youtube', 'fa-xing' => 'fa-xing', 'fa-xing-square' => 'fa-xing-square', 'fa-youtube-play' => 'fa-youtube-play', 'fa-dropbox' => 'fa-dropbox', 'fa-stack-overflow' => 'fa-stack-overflow', 'fa-instagram' => 'fa-instagram', 'fa-flickr' => 'fa-flickr', 'fa-adn' => 'fa-adn', 'fa-bitbucket' => 'fa-bitbucket', 'fa-bitbucket-square' => 'fa-bitbucket-square', 'fa-tumblr' => 'fa-tumblr', 'fa-tumblr-square' => 'fa-tumblr-square', 'fa-long-arrow-down' => 'fa-long-arrow-down', 'fa-long-arrow-up' => 'fa-long-arrow-up', 'fa-long-arrow-left' => 'fa-long-arrow-left', 'fa-long-arrow-right' => 'fa-long-arrow-right', 'fa-apple' => 'fa-apple', 'fa-windows' => 'fa-windows', 'fa-android' => 'fa-android', 'fa-linux' => 'fa-linux', 'fa-dribbble' => 'fa-dribbble', 'fa-skype' => 'fa-skype', 'fa-foursquare' => 'fa-foursquare', 'fa-trello' => 'fa-trello', 'fa-female' => 'fa-female', 'fa-male' => 'fa-male', 'fa-gittip' => 'fa-gittip', 'fa-sun-o' => 'fa-sun-o', 'fa-moon-o' => 'fa-moon-o', 'fa-archive' => 'fa-archive', 'fa-bug' => 'fa-bug', 'fa-vk' => 'fa-vk', 'fa-weibo' => 'fa-weibo', 'fa-renren' => 'fa-renren', 'fa-pagelines' => 'fa-pagelines', 'fa-stack-exchange' => 'fa-stack-exchange', 'fa-arrow-circle-o-right' => 'fa-arrow-circle-o-right', 'fa-arrow-circle-o-left' => 'fa-arrow-circle-o-left', 'fa-caret-square-o-left' => 'fa-caret-square-o-left', 'fa-dot-circle-o' => 'fa-dot-circle-o', 'fa-wheelchair' => 'fa-wheelchair', 'fa-vimeo-square' => 'fa-vimeo-square', 'fa-try' => 'fa-try', 'fa-plus-square-o' => 'fa-plus-square-o');
			
			$checked = '';
			foreach(array_keys($icons) as $icon)
			{
				if($icon == "twitter") { $checked = 'checked'; }
				$icon = str_replace('fa-','',$icon);				
				echo '<input type="radio" id="'.$icon.'" name="icon" value="'.$icon.'" data-cs-name="icon" '.$checked.'><label for="'.$icon.'"><i class="fa fa-'.$icon.'"></i></label>';
				$checked = '';
			}
		?>
	</div>
	</div>
	
</div>

<br clear="both"/>
</div>
<?php			
}