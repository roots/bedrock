!function($) {
	$(document).ready(function(){
		if(typeof vc === 'undefined'|| typeof window.VcColumnView==='undefined')
			return false;
		window.ULTHotspotSingleView = vc.shortcode_view.extend({
			editElement: function(e) {
				_.isObject(e) && e.preventDefault(), window.ULTHotspotSingleView.__super__.editElement.call(this, e), this.model.get("params");
				var single_element = this.$el;
				var img_id = single_element.parent().attr("data-hotspot-image");

				if (single_element.attr("data-latest-img") == void 0 || single_element.attr("data-latest-img").length === 0)
					var new_img_id = img_id;
                else
					var new_img_id = single_element.attr("data-latest-img");
				if (single_element.attr("data-hotspot-image", img_id), void 0 == single_element.parent().attr("data-hotspot-link") || 0 == single_element.parent().attr("data-hotspot-link").length || new_img_id != img_id)
				$.ajax({
					type: "POST",
					url: window.ajaxurl,
					data: {
						action: "wpb_single_image_src",
						content: img_id,
						size: "full",
						_vcnonce: window.vcAdminNonce // due to vc 4.7.4 update
					},
					dataType: "html",
					success: function(response_img_link){
						ULT_H_img_ID = img_id;
						ULT_H_img_link = response_img_link;
						single_element.attr("data-hotspot-link", response_img_link);
						single_element.attr("data-latest-img", img_id);
					}
				});
				else {
					var img_link = single_element.parent().attr("data-hotspot-link");
					ULT_H_img_link = img_link;
					ULT_H_img_ID = single_element.parent().attr("data-hotspot-image");
				}
				ULT_H_Size = single_element.parent().attr("data-hotspot-size");
				ULT_H_custom_size = single_element.parent().attr("data-hotspot-custom");
				//vc.edit_element_block_view.render(this.model);
			}
		});
		var vc_shortcodes = vc.shortcodes;
		window.ULTHotspotContainerView = window.VcColumnView.extend({
			buildDesignHelpers: function() {
				var container_element_params = this.model.get("params");
				var container_element = this.$el;
				var	n = container_element.attr("data-model-id");
				var hotspot_image = container_element_params.main_img;
				var hotspot_size = container_element_params.main_img_size;
				var hotspot_custom_size = container_element_params.main_img_width;

				var t = hotspot_image.split('|');
				var id = '';
				var url = '';
				if( t != 'undefined' && t != null ) {
					jQuery.each( t , function(index, val) {

						//	Start with 'id:' or 'id^'
					    if ( val.startsWith("id:") ) {
							id = val.split("id:").pop();
					    }
					    if ( val.startsWith("id^") ) {
							id = val.split("id^").pop();
					    }
					    //	Start with 'url:' or 'url^'
					    if ( val.startsWith("url:") ) {
							url = val.split("url:").pop();
					    }
					    if ( val.startsWith("url^") ) {
							url = val.split("url^").pop();
					    }
					});
				}
				if( id != null && id != 'undefined' && url != null && url != 'undefined' ) {
					hotspot_image = id + '|' + url;
				}

				if(typeof container_element_params.main_img_width != 'undefined')
					hotspot_custom_size = container_element_params.main_img_width;

				vc_shortcodes.where({
					parent_id: this.model.id
				});

				_.isEmpty(hotspot_image) || ( container_element.find("> .wpb_element_wrapper .wpb_column_container").attr("data-hotspot-image", hotspot_image), container_element.find("> .wpb_element_wrapper .wpb_column_container").attr("data-hotspot-size", hotspot_size), container_element.find("> .wpb_element_wrapper .wpb_column_container").attr("data-hotspot-custom", hotspot_custom_size), container_element.attr("data-hotspot-image", hotspot_image), container_element.attr("data-hotspot-size", hotspot_size), container_element.attr("data-hotspot-custom", hotspot_custom_size), $.ajax({
					type: "POST",
					url: window.ajaxurl,
					data: {
						action: "wpb_single_image_src",
						content: hotspot_image,
						size: "full",
						_vcnonce: window.vcAdminNonce // due to vc 4.7.4 update
					},
					dataType: "html",
					success: function(img_link){
						container_element.find("> .wpb_element_wrapper .wpb_column_container").attr("data-hotspot-link", img_link);
						container_element.attr("data-hotspot-link", img_link);
					}
				}));
			},
			addElement: function(e) {
				_.isObject(e) && e.preventDefault();
				var img_id = this.$el.attr("data-hotspot-image");
				var img_link = this.$el.attr("data-hotspot-link");
				var img_size = this.$el.attr("data-hotspot-size");
				var img_custom_size = this.$el.attr("data-hotspot-custom");

				ULT_H_img_ID = img_id;
				ULT_H_img_link = img_link;
				ULT_H_Size = img_size;
				ULT_H_custom_size = img_custom_size;
				window.ULTHotspotContainerView.__super__.addElement.call(this, e);
			}
		});
	});
}(jQuery);