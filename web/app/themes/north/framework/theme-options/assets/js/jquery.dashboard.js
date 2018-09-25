(function($) {
	"use strict";  
  
	 
	jQuery(document).ready(function($){
	
		// Color Picker
		
		$('.wp-color-picker').each(function(){  	 		
			
		  	$(this).wpColorPicker();
		  	
		});
	
		//	Page Header Fold
			
		
		function page_header_metabox() {
			var page_header = $('#page-header select').val();
			$('#vntd_page_header_'+page_header).fadeIn();
			
			$('#page-header select').live('change', function(){
				$("[id*='vntd_page_header_']").hide();
				$('#vntd_page_header_'+$(this).val()).fadeIn();				
			});
		}
		
		page_header_metabox();
		
		function select_menu_fold() {
			$('select.folds').live('change', function() {
				var current = $(this).attr('name');
//				alert('.fold.fold-'+current+'.fold-'+$(this).val());
				$('.fold.fold-'+current).hide();
				$('.fold.fold-'+current+'.fold-'+$(this).val()).show();
			});
		}
		
		select_menu_fold();
		
	});
  
	
})(jQuery);




jQuery(window).load(function($) {


	// Theme Customizer Tabs
	
	jQuery('.customizer-tabs-nav li:first-child').addClass('tab-current');
	jQuery('.customizer-tabs-nav li').click(function(){
		jQuery(this).addClass("tab-current").siblings().removeClass("tab-current");
	    jQuery('.customizer-tabs-content > div:eq(' + jQuery(this).index() + ')').fadeIn().siblings().hide();
	});
	
	// Dynamic Page/Post Settings
	
	jQuery('input[name=on_click]').live('change', function() {
		jQuery('.option-on-click').hide();
		jQuery('tr.option-'+jQuery(this).val()).fadeIn();
	});
	
//	jQuery('input[name=page_layout]').live('change', function() {
//	
//		var field = '.option-'+jQuery(this).attr('name');
//		
//		if(jQuery(this).val() != "fullwidth") {
//			jQuery(field).fadeIn();
//		} else {
//			jQuery(field).hide();
//		}
//	});
	
	jQuery('input.dynamic-change').live('change', function() {
	
		var field = jQuery(this).attr('name');
		
		if (jQuery(this).is(':checked')) {
		    jQuery('.option-'+field).fadeIn();
		} else {
		    jQuery('.option-'+field).hide();
		} 
		
	});
	
	jQuery('.select-preview-font-weight').bind('change', function() {
	
		var val = jQuery(this).find('option:selected').val();		
		var target = jQuery(this).data('dependency');
		
		jQuery("#theme-preview ."+target).css('font-weight',val);
		
	});	
	
	jQuery('.select-preview-font-transform').bind('change', function() {
	
		var val = jQuery(this).find('option:selected').val();		
		var target = jQuery(this).data('dependency');
		
		jQuery("#theme-preview ."+target).css('text-transform',val);
		
	});	
	
	jQuery('.of-toggle-heading').click(function() {
		jQuery(this).next('.of-toggle-content').slideToggle();
	});
	
	
	//
	// Blog Post Metaboxes
	//
	
	var post_format = jQuery('input[type=radio]:checked', '#formatdiv').val();
	
	jQuery('#blog_'+post_format+'_post_format').fadeIn();
	
	jQuery('#formatdiv input[name=post_format]').change(function(){
		jQuery("[id$='_post_format']").hide();
		jQuery('#blog_'+jQuery('input[type=radio]:checked', '#formatdiv').val()+'_post_format').fadeIn();
	});
	
	
	jQuery('.metabox-options .folds,.admin-form .fld').bind('change',function(){
		var inp = jQuery(this);
		var val = inp.val();
		//alert(".folded-"+inp.attr('name')+"-"+inp.attr('value'));
		jQuery(".folded-"+inp.attr('name')).slideUp();
		jQuery(".folded-"+inp.attr('name')+"-"+inp.attr('value')).slideDown();	
		
	});
	
	jQuery('#mymetabox_revslider_0,#vc_teaser').addClass('closed');



});

(function ($) {  
	
	$('.modal-body').live('mouseover', function() {
		document.body.style.overflow='hidden';
	}).live('mouseout', function() {
		document.body.style.overflow='scroll';
	});
	
	//
	// Shortcode Generator jQuery
	//
	
	function ShortcodeFunctions() {
		    
	    $('.select, .edit_form_line select').live('change', function () {
	      $(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
	    });
	    
	    $('.select, .edit_form_line select').bind($.browser.msie ? 'click' : 'change', function(event) {
	      $(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
	    }); 	    
	    
	    // Fields fold
	    
	    $('select[data-fold]').live('change', function() {	
	    	if($(this).val()==$(this).attr("data-fold")){		
	    		$(this).parent().next(".to-fold").slideDown();				
	    	} else {
	    		$(this).parent().next(".to-fold").slideUp();
	    	}
	    });
	    
	    // Tip box
	    
	    $('.tip-icon').live('click', function() {	
	    	var tip_box = $(this).closest('.caretta-cf').find(".tip-box");
	    	if($(tip_box).css('display') == 'none'){
		    	$(tip_box).slideDown();
		    } else {
				$(tip_box).slideUp();
		    };
	    });
	}
	
	ShortcodeFunctions();	
	
	
	
	
	//
	// Single Image Upload
	//
	
	var file_frame;
	
	jQuery('.add-single-image').live('click', function (event) {
	
		var button = $(this);
	
	    event.preventDefault();
	
	    // If the media frame already exists, reopen it.
	    if (file_frame) {
	        file_frame.open();
	        return;
	    }
	
	    // Create the media frame.
	
	    file_frame = wp.media({
	        state: "single-image",
	        multiple: false,
	    });
	
	    // Add the single image state.
	
	    file_frame.states.add([
	
	        new wp.media.controller.Library({
	            id: 'single-image',
	            button: "Insert Image",
	            title: "Insert Image",
	            filterable: 'uploaded',
	            library: wp.media.query({
	                type: 'image'
	            }),
	            displaySettings: true,
	        }),
	
	    ]);
	
	    // When an image is selected, run a callback.
	    file_frame.on('select', function () {
	
	        // Hide the no-image placeholder
	
	        $(".no-image").hide();
	        $(".insert-show").show();
	        $(".add-single-image").text("Change Image");	
	
			var the_image, thumbnail, state, attachment_url, the_image;
	        state = file_frame.state();
	
	        attachment_url = state.get('selection').map(function (attachment) {
	
	            display = state.display(attachment).toJSON();
	            attachment = attachment.toJSON();
	            
	            the_image = attachment.sizes[display.size].url;	                      
	           	
	           	// Check if thumbnail exists
	           	      	            
	            if(!attachment.sizes.thumbnail) {
	            	thumbnail = attachment.url;
	            }else{
	            	thumbnail = attachment.sizes.thumbnail.url
	            }
				
				var parent = button.closest('.image-upload');
				// Insert values
	            parent.find('.image-upload-data').val(attachment.id).change();
	            parent.find('.image-upload-data-src').val(the_image).change();
	            //$("input[name=image-size]").val(display.size);
	            parent.find('.image-upload-preview img').attr("src", thumbnail);
				//parent.find('.show-on-upload').show();
				button.closest('.image-upload-dep').find('.show-on-upload').show();
			});	
	
	    });
	
	    // Finally, open the modal
	
	    file_frame.open();
	});
	
	//
	// Single Image Remove
	//
	
	$('.remove-single-image').live('click', function () {
		var parent = $(this).closest('.image-upload');
		
		parent.find('.image-upload-data').val('');
		//parent.find('.show-on-upload').hide();
		$(this).closest('.image-upload-dep').find('.show-on-upload').hide();
		parent.find('.add-single-image').text("Select Image");
		$(this).hide();
		
	});
	
	//
	// Video Upload
	//
	
	var video_frame;
	
	jQuery('.add-video').live('click', function (event) {
	
	    event.preventDefault();
	
	    // If the media frame already exists, reopen it.
	    if (video_frame) {
	        video_frame.open();
	        return;
	    }
	
	    // Create the media frame.
	
	    video_frame = wp.media({
	        state: "video",
	        multiple: false,
	    });
	
	    // Add the single image state.
	
	    video_frame.states.add([
	
	        new wp.media.controller.Library({
	            id: 'video',
	            button: "Insert Video",
	            title: "Insert Video",
	            filterable: 'uploaded',
	            library: wp.media.query({
	                type: 'video'
	            }),
	            displaySettings: true,
	        }),
	
	    ]);
	
	    // When an image is selected, run a callback.
	    video_frame.on('select', function () {
	
	        // Hide the no-image placeholder
	
	        $(".no-image").hide();
	        $(".insert-show").show();
	        $(".add-media-single").text("Change Video");	
	
			var state, attachment_url;
	        state = video_frame.state();
	
	        attachment_url = state.get('selection').map(function (attachment) {
	
	            attachment = attachment.toJSON();
				
				// Insert values
				
	            $("input[name=self_hosted]").val("yes");
	            $("input[name=url]").val(attachment.url);
	            //$(".image-holder img").attr("src", thumbnail);
	
	        });	
	
	    });
	
	    // Finally, open the modal
	
	    video_frame.open();
	});
	
	// End Media
	//
  
})(jQuery);