jQuery(document).ready(function(){	
	jQuery('form#contactForm').submit(function() {
		jQuery('form#contactForm .error').remove();
		var hasError = false;
		jQuery('.requiredField').each(function() {
			if(jQuery.trim(jQuery(this).val()) == '') {
				var labelText = jQuery(this).prev('label').text();
				jQuery(this).addClass('hightlight').effect('shake', { times: 3 }, 100);
								
				hasError = true;
			} else if(jQuery(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
					var labelText = jQuery(this).prev('label').text();
					jQuery(this).addClass('hightlight').css('color','#e2a7a7').effect('shake', { times: 3 }, 100);
					hasError = true;
				}else {
					jQuery(this).removeClass('hightlight').css('color','#666');		
				}
			} else {
				jQuery(this).removeClass('hightlight').css('color','#666');	
			}
		});
		if(!hasError) {
			jQuery('.loading').fadeIn();
			jQuery('form#contactForm li.buttons button').fadeOut('normal');
			
			var formInput = jQuery(this).serialize();
			jQuery.post(jQuery(this).attr('action'),formInput, function(data){
				jQuery('.content #contactForm').hide(600);	
				jQuery('.content .form-success').fadeIn();			   
			});
		}
		
		return false;
		
	});
});