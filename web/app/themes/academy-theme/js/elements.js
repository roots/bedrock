	
 /* ==============================================
ALERT CLOSE
=============================================== */

	$(".alert .close").click(function(){
		$(this).parent().animate({'opacity' : '0'}, 300).slideUp(300);
		return false;
	});