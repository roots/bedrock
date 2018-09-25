<?php

// Shortcode init

function vntd_cs_person()
{
	add_action('cs_init_bilder', 'vntd_team_member_init_info');
	add_action('cs_init_shortcode','vntd_team_member_init_bilder');
}

add_action('wp_cs_init','vntd_cs_person');


// Shortcode Builder


function vntd_team_member_init_info()
{
	cs_show_bilder(
		'person',
		'Person',
		'',
		''
	);
}

function vntd_team_member_init_bilder($id)
{
	if($id == 'person'):
		$out = '';
		ob_start(); 
		vntd_team_member_builder();
		$out .= ob_get_contents(); 
		ob_end_clean();
		cs_show_shortcode($id,$out,"person");
	endif;
}
	
function vntd_team_member_builder()
{

?>


<style type="text/css">

.icons-wrap {
	max-width: 700px;
}

.single-icon-wrap {
	border: 1px solid #ddd;
	background-color: #eee;
	height: 30px;
}

.icons-wrap {
	
}

.no-icons-alert {
	text-align: center;
	color: #888;
}

.social-icon-list .icon-checked {
	background-color: #444;
}

.social-icon-list .icon-checked i {
	color: #fff;
}



</style>

<script type="text/javascript">

(function($){

	function imageCallback(){
		console.log('image Callback');
	}		
	carretaSetData('image','callback',imageCallback);
	
	$('.select_wrapper').each(function () {
	  $(this).prepend('<span>' + $(this).find('.select option:selected').text() + '</span>');
	});	
	
	$(".tabs-nav").sortable({
		placeholder: 'placeholder',
		forcePlaceholderSize: true
	});
	
	function tabs() {	
		jQuery('.tabs-nav li:first-child').addClass('tab-active');
		jQuery('.tabs-nav li').click(function(){
			jQuery(this).addClass("tab-active").siblings().removeClass("tab-active");
		    jQuery('.tabs-content > .tab-content:eq(' + jQuery(this).index() + ')').fadeIn().siblings().hide();
		});
	}
	
	tabs();
	
	$("input[name=social_icon]").live("change",function(){
	    var val = $(this).val();
	    
	    var index = $(this).closest('.tab-content').index()+1;
	    $('.tabs-nav').find('li:nth-child('+index+') i').attr('class','fa fa-'+val);
	    
	});
	
		    
    $(".social-icon-list span").live("click",function(){

		var val = $(this).attr("data-icon");
		
    	$(this).siblings().removeClass("icon-checked");
    	$(this).addClass("icon-checked");
    	$(this).closest(".social-icons-wrap").find(".member-icon").val(val);
    	
    	//var index = $(this).closest('.tab-content').index()+1;	
    	$('.tab-active i').attr('class','fa fa-'+val);
    });
	
	
	
	function rand(){
		var mn = 10;
		var mx = 9990;
		
		var r = mn + Math.floor(Math.random()*(mx+1-mn));
		return r;
	}
	
	$('.add-new-element').click(function() {		
		
		var new_tab = $('<div class="tab-content">\
			<div>\
				<label>URL</label>\
				<input type="text" class="icon-url" value="http://">\
			</div>\
			<div class="social-icons-wrap">\
				<label>Icon</label>\
				<input type="hidden" class="member-icon" value="twitter">\
				<div class="social-icon-list">\
					<?php
					
						$social_icons = array(
							'facebook',
							'twitter',
							'google-plus',
							'flickr',
							'youtube',
							'linkedin',
							'dribbble',
							'tumblr',
							'adn',
							'android',
							'apple',
							'bitbucket',
							'btc',
							'css3',							
							'dropbox',						
							'github',
							'github-alt',							
							'html5',
							'instagram',							
							'linux',
							'pinterest',
							'renren',
							'skype',
							'stack-exchange',
							'stack-overflow',
							'trello',														
							'vk',
							'windows',
							'xing',							
						
						);
						foreach($social_icons as $icon)
						{
							if($icon == "twitter") { $checked = 'class="icon-checked"'; }
							
							echo '<span data-icon="'.$icon.'" '.$checked.'><i class="fa fa-'.$icon.'"></i></span>\\';
							$checked = '';
						}
					?>
				</div>\
			</div>\
		</div>');
	    //append the new element with a fade animation
	    
	    $('<li><i class="fa fa-twitter"></i></li>').hide().appendTo(".tabs-nav").fadeIn(250);
	    new_tab.hide().appendTo(".tabs-content");
	    
	    var count = $(".tabs-nav li").size();
	    
	    if(count == 1){	
		    $(".no-icons-alert").remove();
		    jQuery('.tabs-nav li').addClass("tab-active");
		    jQuery('.tabs-content > .tab-content').fadeIn();
		}  
	    
	    $(".tabs-nav li").unbind('click');
	    tabs();
	    
	    $('.tab-title-input').unbind('on');    
	    	    
	    return false;
	});	
	
	$('.remove-element').click(function() {			
			
    	$(".tabs-nav li.tab-active, .tab-content:visible").remove();
    	$(".tabs-nav li:first-child").addClass("tab-active");
	    $(".tab-content:first-child").show();
	    
	    $(".tabs-nav li").unbind('click');
	    tabs();
	    		
	    var count = $(".tabs-nav li").size();
	        
		if(count == 0){			
	    	$(".tabs-content").append($('<div class="no-icons-alert">No icons. Click button above to add one!</div>'));	    	
	    }
	    return false;
	});	
	
					
})(jQuery);
	
</script>

<div>
<div class="image-right cs-c-right">
	
	<div class="cs-settings admin-form">		
			
		<div class="caretta-cf">
			<label>Name</label>			
			<input type="text" name="name" data-cs-name="name" placeholder="John Doe" value="">
		</div>
		
		<div class="caretta-cf">
			<label>Position <i class="icon-question-sign tip-icon" title="Click for more information"></i></label>
			<div class="tip-box">
				This is an optional field.
			</div>
			<input type="text" name="position" data-cs-name="position"  value="">
		</div>
		
		<div class="caretta-cf">
			<label>Description</label>
			<textarea name="description" rows="10" data-cs-name="description"></textarea>
		</div>
		
		<div class="caretta-cf image-upload">
			<label>Photo</label>			
			<div class="insert-show image-upload-preview">
				<img src="">
			</div>
			<a href="#" class="browser button add-single-image" data-upload-type="single-image">Select Image</a>
			<input type="hidden" class="image-upload-data-src" name="image_url" data-cs-name="image_url" value="">
		</div>
		
	</div>
	
</div>
<div class="image-left cs-c-left">

	<h3>Social icons:</h3>
	
	<span id="new-icon" class="button add-new-element">Add new icon</span>
	<span id="remove-icon" class="button remove-element">Remove current icon</span>

		<div class="tabs icons-wrap">
			<ul class="tabs-nav">				
			</ul>
			<div class="tabs-content">
				<div class="no-icons-alert">No icons. Click button above to add one!</div>				
			</div>
		</div>

	
</div>

<br clear="both"/>
</div>
<?php			
}

function vntd_team_member($atts, $content=null) {
	extract(shortcode_atts(array(
		"name" => 'John Doe',
		"description" => '',
		"position" => '',
		"img" => '',
		"facebook" => '',
		"twitter" => '',
		"googleplus" => '',
		"linkedin" => '',
		"pinterest" => '',
		"email" => '',
		"dribbble" => '',
		"instagram" => '',
		"youtube" => '',
		"tumblr" => '',
		"target" => '_blank'
	), $atts));
	
	$icon_arr = array('facebook','twitter','googleplus','tumblr','pinterest','instagram','dribbble','linkedin','youtube','email');
	
	$socials = '<div class="vntd-social-icons vntd-social-icons-default vntd-social-icons-small">';
	foreach($icon_arr as $icon_name) {
		if(isset($atts[$icon_name])) {
			$socials .= '<a href="'.$atts[$icon_name].'" class="vntd-social-icon vntd-icon vntd-not-accent vntd-icon-'.$icon_name.'" target="' . esc_attr( $target ) . '"></a>';
		}
	}
	$socials .= '</div>';
	
	if(is_numeric($img)) {
		$img = wp_get_attachment_image_src($img,'portfolio-square');
		$img = $img[0];
	} elseif(strpos($img,'http://') !== false) {
		$img = $img;
	} else {
		$img = "http://placehold.it/350x240";
	}
	
	return '<div class="vntd-person"><img class="vntd-person-pic" src="'.$img.'" title="'.$name.'"><h4 class="vntd-person-name">'.$name.'</h4><div class="vntd-person-role">'.$position.'</div><div class="vntd-person-text">'.$description.'</div><div class="vntd-person-social">'.$socials.'</div></div>';
}
remove_shortcode('team_member');
add_shortcode('team_member', 'vntd_team_member');