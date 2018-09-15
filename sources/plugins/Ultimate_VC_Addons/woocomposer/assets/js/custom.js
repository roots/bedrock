jQuery(document).ready(function(e) {
	// Do animation of animation block if present
	
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) 
	{
 		jQuery('.wcmp-product').addClass('wcmp-mobile');
	}
	/* product advanced note fix */
	jQuery('.wcmp-sale-circle').each(function(index, element) {
        var $span = jQuery('.wcmp-sale-circle').find('span');
		var span_width = $span.outerWidth();
		$span.css({'height':span_width+'px','line-height':span_width+'px'});
    });
	jQuery('body').append('<div class="quick-view-single-product"></div>');
	var container = jQuery('.woocomposer_grid > .woocomposer');
	var oldWrapPos = 0;
	var row = 0;
	jQuery('body').on('click', '.quick-view-loop', function(e){
		e.preventDefault();
		var parentProduct = jQuery(this).parent().parent().parent();
		var parentProduct = jQuery(this).closest('.wooproduct');
		var cls = parentProduct.find('selected').length;
		if(cls >=1 ){
			parentProduct.removeClass('selected'); 
			jQuery('.wcmp-view-wrap').slideUp( function() { jQuery(this).remove(); });
		} else {
			jQuery('.wcmp-view-wrap').remove();
			var elements = container.children();
			container.children().removeClass('selected'); // reset selected element
			parentProduct.addClass('selected'); // mark new selected element
			//parentProduct.next('.wcmp-quick-view-wrapper').slideUp( function() { jQuery(this).remove(); });
			jQuery('.wcmp-view-wrap').slideUp( function() { jQuery(this).remove(); });
			var elementHeight = parentProduct.height()-3;
			var elementWidth = parentProduct.outerWidth(true);
			var selectedPos = parentProduct.index()+1; // get selected position
			// find wrap element:
			//var containerWidth = container.width();
			//var elementsInRow = Math.floor(containerWidth / 100 );
			var elementsInRow = jQuery(".wcmp-quick-view-wrapper").data('columns'); // use this if container's width is fixed
			var calculatedRow = selectedPos / elementsInRow;
			var wrapPos = '';
			if( Math.floor(calculatedRow) == calculatedRow && jQuery.isNumeric(calculatedRow)){
				row = calculatedRow;
				wrapPos = (row * elementsInRow)-1;
			} else {
				row = Math.floor(selectedPos / elementsInRow)+1;
				wrapPos = (row * elementsInRow)-1;
			}
			// if selected is on last row, use as wrap the last element:
			var size = elements.length;
			if (wrapPos >= size){wrapPos = size-1;}
			//wrapPos = wrapPos - 1;
			var pointerPos = (elementWidth/2 - 5) + (((selectedPos-1) % elementsInRow) * elementWidth)
			//var pointerPos = 30 + (((selectedPos+1) * elementWidth)-(elementWidth/2));
			/*
			console.log(selectedPos);
			console.log(elementsInRow);
			console.log(selectedPos % elementsInRow);
			console.log((selectedPos % elementsInRow) * 110);
			console.log('left: '+pointerPos);
			*/
			//console.log(elementWidth); 
				elements.removeClass('edge');
				jQuery(elements[wrapPos]).addClass('edge');
				var quickView = parentProduct.children('.wcmp-quick-view-wrapper').html();
				jQuery('.edge').after('<div class="wcmp-view-wrap vc_span12 wpb_column column_container woocommerce" style="height:0px; margin-top: -20px; width:100%;"><div class="info-pc" style="left:'+pointerPos+'px; float:right; top:-10px;"></div><div class="wcmp-view-content product">'+quickView+'</div><div class="wcmp-close"><i class="wooicon-cross2"></i></div></div>');
				var contentHeight = jQuery('.wcmp-view-content').height();
				jQuery('.wcmp-view-wrap').animate(
					{
						height:contentHeight
					},{
							duration: 500,
							complete: function(){  
								jQuery( this ).css('overflow','visible');
								jQuery(this).trigger('viewLoaded');
						}
					}
				);
			}
		}
	);
	jQuery('body').click( function (e) {
		if ( e.target == this ){
			if(jQuery('.woocomposer_grid').find(".wcmp-view-wrap").length > 0)
			{
				jQuery(".wcmp-view-wrap").addClass('animated fadeInOut');
				setTimeout(function(){
					var contentHeightNew = jQuery('.wcmp-view-content').height();
					var wHeight = (jQuery(window).innerHeight() + (contentHeightNew)) / 2;
					var topMargin = jQuery(".wcmp-view-wrap").offset().top - wHeight;
					jQuery('.wcmp-view-wrap').slideUp( function() { jQuery(this).remove(); });		
					jQuery('html, body').animate(
						{
							scrollTop:topMargin
						},
						{
							duration: 500,
							complete:function(){
							//jQuery(this).trigger('viewLoaded');
						}
					});
				},500);
				container.children().removeClass('selected');
			}
		}
	});
	jQuery(document).ready(function($) {
		// script to woocomposer grid layput
    	$('.woocomposer_grid').each(function(index, element){
			var woo_col = $(this).find('.woocomposer').attr('data-columns');
			$(this).find('.wooproduct').each(function(pindex,product){
				var mod = pindex%woo_col;
				if(mod == 0)
					$(product).addClass('wooproduct-first');
				if(mod == (woo_col-1))
					$(product).addClass('wooproduct-last');
			});
		});
		//jQuery(".woocomposer_grid").eqHeight(".wooproduct", {equalize_interval: 500});
		$(".wcmp-img").unveil();
		var inline_vc = jQuery('.woocomposer_carousel').find('.wcmp_vc_inline').length;
		if(inline_vc == 1){
			var woo_carousel = jQuery(".woocomposer_carousel");
			woo_carousel.each(function(index, element) {
				var id = jQuery(this).attr('id');
				var carousel_opts = jQuery(this).attr('data-slick');
				jQuery("#"+id+" > .woocomposer").slick(carousel_opts);
				//console.log(id);
			});
		}
	});
	/**/
	jQuery('body').on('click', '.wcmp-close', function(e){
		e.preventDefault();
		var childs = jQuery('.woocomposer_grid').children('.wooproduct');
		childs.removeClass('selected'); 
		var contentHeightNew = jQuery('.wcmp-view-content').height();
		var wHeight = (jQuery(window).innerHeight() + (contentHeightNew)) / 2;
		var topMargin = jQuery(".wcmp-view-wrap").offset().top - wHeight;
		jQuery('.wcmp-view-wrap').slideUp( function() { jQuery(this).remove(); });		
		jQuery('html, body').animate(
			{
				scrollTop:topMargin
			},
			{
				duration: 500,
				complete:function(){
				//jQuery(this).trigger('viewLoaded');
			}
		});
	});
	/* Custom JS for Swatches Plugin*/
	jQuery('body').on('click','a.swatch-anchor',function(e){
		e.preventDefault();
		var variation = '';
		var attr_name = jQuery(this).parent().parent().data('attribute-name');
		var attr_value = jQuery(this).parent().data('value');
		var variations = jQuery(this).closest('.variations_form').data('product_variations');
		var variations_form = jQuery(this).closest('.variations_form');
		var img_source = jQuery(this).closest('.product').find('.wcmp-quickview-img');
		
		for (var p = 0; p < variations.length; p++) {
			var result = true;
			for (attribute in variations[p].attributes) {
				if (attr_name == attribute) {
					var v = variations[p].attributes[attribute];
					if (v != attr_value) {
						result = false;
					}
				}
			}
			if (result) {
				variation = variations[p];
			}
		}
		var img = variation.image_src;
		//img_source.attr('href',img);
		variations_form.find('.single_variation').html(variation.price_html + variation.availability_html);
		console.log(variation);
		img_source.find("img").attr('src',img);
		
		jQuery(this).parent().parent().find("#"+attr_name).val(attr_value);
		jQuery(this).parent().siblings('.swatch-wrapper').removeClass('selected');
		jQuery(this).parent().addClass('selected');
		jQuery('form input[name=variation_id]').val(variation.variation_id).change();
	});
	/* Single Product Quick View */
	jQuery(".woo-msg").css({'position':'fixed','width':'100%','left':'0','right':'0','z-index':'9999999','top':'0px'});
	jQuery(".woo-msg > .woocommerce-message").append('<a href="#" class="button wc-backward wcmp-continue" style="margin-right: 15px;">Continue Shopping</a>');
	jQuery(".wcmp-continue").click(function(){
		jQuery(".woocommerce-message").slideUp(500,function() { jQuery(this).remove(); });
	});
	jQuery(".quick-view-single").click(function(e){
		e.preventDefault();
		var single_container = jQuery(this).parent().parent().find('.wcmp-quick-view-wrapper');
		var html = single_container.html();
		jQuery(".quick-view-single-product").html(html);
		jQuery(".quick-view-single-product").fadeIn('fast');
		jQuery(".quick-view-single-product .wcmp-image-carousel").slick({
			arrows: true,
			infinite: true,
			speed: 500,
			slidesToShow: 1,
			slidesToScroll: 1,
		});
		var is_variation = jQuery(".quick-view-single-product").find('.variations_form').length;
		if(is_variation != 0)
		{
			jQuery( '.variations_form' ).wc_variation_form();
			jQuery( '.variations_form .variations select' ).change();
		}
		add_woocomposer_popupclass();
	});
	jQuery(".quick-view-loop-popup").click(function(e){
		e.preventDefault();
		// var single_container = jQuery(this).parent().parent().parent().find('.wcmp-quick-view-wrapper');
		var single_container = jQuery(this).closest('.wooproduct').find('.wcmp-quick-view-wrapper');
		var html = single_container.html();
		jQuery(".quick-view-single-product").html(html);
		jQuery(".quick-view-single-product").fadeIn('fast');
		jQuery(".quick-view-single-product .wcmp-image-carousel").slick({
			arrows: true,
			infinite: true,
			speed: 500,
			slidesToShow: 1,
			slidesToScroll: 1,
		});
		var is_variation = jQuery(".quick-view-single-product").find('.variations_form').length;
		if(is_variation != 0)
		{
			jQuery( '.variations_form' ).wc_variation_form();
			jQuery( '.variations_form .variations select' ).change();
		}
		add_woocomposer_popupclass();
	});
	jQuery('body').on('click','.wcmp-close-single',function(){
		jQuery(".quick-view-single-product").fadeOut(500);
		jQuery('html').removeClass('woocomposer-popup');
	});
	jQuery(".wcmp-single-image-carousel").slick({
		arrows: true,
		infinite: true,
		draggable: false,
		speed: 500,
		slidesToShow: 1,
  		slidesToScroll: 1,
	});
});
jQuery(document).on('viewLoaded',function(){
	jQuery(".wcmp-view-wrap .wcmp-image-carousel").slick({
		arrows: true,
		infinite: true,
		speed: 500,
		slidesToShow: 1,
  		slidesToScroll: 1,
	});
	var contentHeightNew = jQuery('.wcmp-view-content').height();
	jQuery(".wcmp-view-wrap").animate({height:contentHeightNew},{duration:500,complete:function(){
		var wHeight = (jQuery(window).innerHeight() - contentHeightNew) / 2;
		var topMargin = jQuery(".wcmp-view-wrap").offset().top - wHeight;
		jQuery('html, body').animate(
			{
				scrollTop:topMargin
			},
			{
				duration: 500,
				complete:function(){
				//jQuery(this).trigger('viewLoaded');
			}
		});
	}});
	var is_variation = jQuery(".wcmp-view-wrap").find('.variations_form').length;
	if(is_variation != 0)
	{
		jQuery( '.variations_form' ).wc_variation_form();
		jQuery( '.variations_form .variations select' ).change();
	}
});
jQuery(window).scroll(function(){
	animate_products();
});
jQuery(window).load(function(){
	animate_products();
	var inline_vc = jQuery('.woocomposer_carousel').find('.wcmp_vc_inline').length;
	if(inline_vc >= 1){
		var woo_carousel = jQuery(".woocomposer_carousel");
		woo_carousel.each(function(index, element) {
			var id = jQuery(this).attr('id');
			var carousel_opts = jQuery(this).attr('data-slick');
			jQuery("#"+id+" > .woocomposer").slick(carousel_opts);
			var products = jQuery("#"+id+" > .woocomposer").find(".wooproduct").length;
			jQuery("#"+id+" > .woocomposer").find("slick-track").css('width',300 * products);
			jQuery("#"+id+" > .woocomposer").find(".wooproduct").each(function(index, element) {
                jQuery(this).css('width',300+'px');
            });
			console.log(inline_vc);
		});
		jQuery(".quick-view-single-product .wcmp-image-carousel, .wcmp-single-image-carousel").each(function(index, element) {
           jQuery(this).slick({
				arrows: true,
				infinite: true,
				draggable: false,
				speed: 500,
				slidesToShow: 1,
				slidesToScroll: 1,
			}); 
        });
	}
});
jQuery(window).resize(function(e) {
    add_woocomposer_popupclass();
});
function animate_products(){
	jQuery(".wooproduct").each(function(index, element) {
		var id = jQuery(this).attr('id');
		var animate = jQuery(this).data('animation');
		if(animate !== "animated no-animation"){
//			if(isOnScreen("#"+id)){
				jQuery("#"+id).addClass(animate);
//			}
		}
	});
}
function isOnScreen(id){
    var win = jQuery(window);
    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
	var productHeight = jQuery(id).outerHeight()-80;
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height() - productHeight;
    var bounds = jQuery(id).offset();
    bounds.right = bounds.left + jQuery(id).outerWidth();
    bounds.bottom = bounds.top + jQuery(id).outerHeight();
    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
};
function add_woocomposer_popupclass()
{
	var xheight = jQuery('.quick-view-single-product > div').height();
	var wheight = jQuery(window).height();
	if(xheight >= wheight)
		jQuery('html').addClass('woocomposer-popup');
	else
		jQuery('html').removeClass('woocomposer-popup');
}
