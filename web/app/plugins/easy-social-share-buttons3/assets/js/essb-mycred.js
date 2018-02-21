/**
 * ESSB myCRED Points for Link Clicks
 * @contributors appscreo
 * @since 2.0
 */
jQuery(function($) {
	var mycred_click = function( href, title, target, skey, ctype ) {
		$.ajax({
			type : "POST",
			data : {
				action : 'mycred-click-points',
				url    : href,
				token  : ESSBmyCREDlink.token,
				etitle : title,
				ctype  : ctype,
				key    : skey
			},
			dataType : "JSON",
			url : ESSBmyCREDlink.ajaxurl,
			success    : function( data ) {
				console.log(ESSBmyCREDlink.ajaxurl);
				console.log( data );
			}
		});
	};
	
	$('.essb_links a').click(function(){
		var target = $(this).attr( 'target' );
		console.log( target );
		
		mycred_click( $(this).attr( 'title' ) + ' ' + window.location.href, $(this).text(), target, $(this).attr( 'data-token' ), $(this).attr( 'data-type' ) );
		
		if ( target == 'self' || target == '_self' ) return false;
	});
});