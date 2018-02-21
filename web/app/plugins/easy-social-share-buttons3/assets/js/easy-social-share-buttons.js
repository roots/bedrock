jQuery(document).ready(function($){

	var basic_network_list = "twitter,linkedin,facebook,pinterest,google,stumbleupon,vk,reddit,buffer,love,ok,mwp,xing,pocket,mail,print,comments,yummly";
	var extended_network_list = "del,digg,weibo,flattr,tumblr,whatsapp,meneame,blogger,amazon,yahoomail,gmail,aol,newsvine,hackernews,evernote,myspace,mailru,viadeo,line,flipboard,sms,viber,telegram";
	
	var plugin_url = essb_settings.essb3_plugin_url;
	var fb_value = essb_settings.essb3_facebook_total;
	var counter_admin   = essb_settings.essb3_admin_ajax;
	var interal_counters_all = essb_settings.essb3_internal_counter;
	var button_counter_hidden = essb_settings.essb3_counter_button_min;
	var no_print_mail_counter = typeof(essb_settings.essb3_no_counter_mailprint) != "undefined" ? essb_settings.essb3_no_counter_mailprint : false;
	var force_single_ajax = typeof(essb_settings.essb3_single_ajax) != "undefined" ? essb_settings.essb3_single_ajax : false;
	var twitter_counter = typeof(essb_settings.twitter_counter) != "undefined" ? essb_settings.twitter_counter : "";
	var google_counter = typeof(essb_settings.google_counter) != 'undefined' ? essb_settings.google_counter : '';
	
	if (twitter_counter == "") { twitter_counter = "api"; }
	if (google_counter == '') google_counter = 'api';
 	
	var essb_shorten_number = function(n) {
	    if ('number' !== typeof n) n = Number(n);
	    var sgn      = n < 0 ? '-' : ''
	      , suffixes = ['k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y']
	      , overflow = Math.pow(10, suffixes.length * 3 + 3)
	      , suffix, digits;
	    n = Math.abs(Math.round(n));
	    if (n < 1000) return sgn + n;
	    if (n >= 1e100) return sgn + 'many';
	    if (n >= overflow) return (sgn + n).replace(/(\.\d*)?e\+?/i, 'e'); // 1e24
	 
	    do {
	      n      = Math.floor(n);
	      suffix = suffixes.shift();
	      digits = n % 1e6;
	      n      = n / 1000;
	      if (n >= 1000) continue; // 1M onwards: get them in the next iteration
	      if (n >= 10 && n < 1000 // 10k ... 999k
	       || (n < 10 && (digits % 1000) < 100) // Xk (X000 ... X099)
	         )
	        return sgn + Math.floor(n) + suffix;
	      return (sgn + n).replace(/(\.\d).*/, '$1') + suffix; // #.#k
	    } while (suffixes.length)
	    return sgn + 'many';
	}
	
	jQuery.fn.essb_get_counters = function(){
		return this.each(function(){
			
			// missing plugin settings - code cannot run from here
			if (typeof(essb_settings) == "undefined") { return; }
			
			var counter_pos     = $(this).attr("data-essb-counter-pos") || "";
			var post_self_count_id = $(this).attr("data-essb-postid") || "";
			
			var url 			= $(this).attr("data-essb-url") || "";
			var twitter_url     = $(this).attr("data-essb-twitter-url") || "";
			
			var instance_id = $(this).attr("data-essb-instance") || "";
			
			var ajax_url = essb_settings.ajax_url;
			if (essb_settings.ajax_type == "light") {
				ajax_url = essb_settings.blog_url;
			}
			
			// definy the counter API
			var nonapi_counts_url = (counter_admin) ? ajax_url+"?action=essb_counts&nonce="+essb_settings.essb3_nonce+"&" : essb_settings.essb3_plugin_url+"/public/get-noapi-counts.php?";
			var nonapi_internal_url = ajax_url+"?action=essb_counts&nonce="+essb_settings.essb3_nonce+"&"; 
			//console.log(nonapi_internal_url);
			var basic_networks = basic_network_list.split(",");
			var extended_networks = extended_network_list.split(",");
			
			var direct_access_networks = [];
			var nonapi_count_networks = [];
			var nonapi_internal_count_networks = [];
			for (var i=0;i<basic_networks.length;i++) {
				if ($(this).find('.essb_link_'+basic_networks[i]).length) {
					switch (basic_networks[i]) {
					//case "google":
					case "stumbleupon":
					case "vk":
					case "reddit":
					case "ok":
					case "mwp":
					case "xing":
					case "pocket":
					case "linkedin":
						if (counter_admin) {
							nonapi_internal_count_networks.push(basic_networks[i]);							
						}
						else {
							nonapi_count_networks.push(basic_networks[i]);
						}
						break;
					case "love":
					case "comments":
						nonapi_internal_count_networks.push(basic_networks[i]);
						break;
					case "mail":
					case "print":
						if (!no_print_mail_counter) {
							nonapi_internal_count_networks.push(basic_networks[i]);
						}
						break;
					case "twitter":
						if (twitter_counter == "api" || twitter_counter == "newsc") {
							direct_access_networks.push(basic_networks[i]);
						}
						else if (twitter_counter == "self") {
							nonapi_internal_count_networks.push(basic_networks[i]);
						}
						break;
					case "google":
						if (google_counter == 'self')
							nonapi_internal_count_networks.push(basic_networks[i]);
						else
							nonapi_count_networks.push(basic_networks[i]);
						break;
					default:						
						direct_access_networks.push(basic_networks[i]);
						break;
					}
				}
			}
			
			if (interal_counters_all) {
				for (var i=0;i<extended_networks.length;i++) {
					if ($(this).find('.essb_link_'+extended_networks[i]).length) {
						nonapi_internal_count_networks.push(extended_networks[i]);					
					}
				}
			}
			
			// start populating counters - direct access API counters
			var operating_elements = {};
			for (var i=0;i<direct_access_networks.length;i++) {
				var network = direct_access_networks[i];
				
				operating_elements[network+""+instance_id] = $(this).find('.essb_link_'+network);
				operating_elements[network+'_inside'+instance_id] = operating_elements[network+instance_id].find('.essb_network_name');
				
				switch (network) {
				case "facebook":
					//var facebook_url = "https://api.facebook.com/restserver.php?method=links.getStats&format=json&urls="+url;
					var facebook_url = "https://graph.facebook.com/?id="+url;
					$.getJSON(facebook_url)
					.done(function(data){
						if (fb_value) {
							counter_display(counter_pos, operating_elements['facebook'+instance_id], operating_elements['facebook_inside'+instance_id], data['share'].share_count);
						}
						else {
							counter_display(counter_pos, operating_elements['facebook'+instance_id], operating_elements['facebook_inside'+instance_id], data['share'].share_count);	
						}
					});
					break;
					
				case "twitter":
					var twitter_org_url = twitter_url;
					var twitter_url		= "https://cdn.api.twitter.com/1/urls/count.json?url=" + twitter_url + "&callback=?"; 

					if (twitter_counter == "newsc") {
						twitter_url = "https://public.newsharecounts.com/count.json?url=" + twitter_org_url;
					}
					$.getJSON(twitter_url)
					.done(function(data){
						console.log(data);
						counter_display(counter_pos, operating_elements['twitter'+instance_id], operating_elements['twitter_inside'+instance_id], data.count);						
					});
					break;
					
				case "linkedin":
					var linkedin_url	= "https://www.linkedin.com/countserv/count/share?format=jsonp&url=" + url + "&callback=?";
					console.log(linkedin_url);
					$.getJSON(linkedin_url)
					.done(function(data){
						counter_display(counter_pos, operating_elements['linkedin'+instance_id], operating_elements['linkedin_inside'+instance_id], data.count);						
					});
					break;
					
				case "pinterest":
					var pinterest_url   = "https://api.pinterest.com/v1/urls/count.json?callback=?&url=" + url;
					$.getJSON(pinterest_url)
					.done(function(data){
						counter_display(counter_pos, operating_elements['pinterest'+instance_id], operating_elements['pinterest_inside'+instance_id], data.count);						
					});
					break;
				case "buffer":
					var buffer_url   = "https://api.bufferapp.com/1/links/shares.json?url="+url+"&callback=?";
					$.getJSON(buffer_url)
					.done(function(data){
						counter_display(counter_pos, operating_elements['buffer'+instance_id], operating_elements['buffer_inside'+instance_id], data.shares);
					});
					break;
				case "yummly":
					var yummly_url   = "https://www.yummly.com/services/yum-count?callback=?&url="+url;
					$.getJSON(yummly_url)
					.done(function(data){
						counter_display(counter_pos, operating_elements['yummly'+instance_id], operating_elements['yummly_inside'+instance_id], data.count);
					});
					break;
				}
				
				
			}
			
			for (var i=0;i<nonapi_count_networks.length;i++) {
				var network = nonapi_count_networks[i];
				
				operating_elements[network+instance_id] = $(this).find('.essb_link_'+network);
				operating_elements[network+'_inside'+instance_id] = operating_elements[network+instance_id].find('.essb_network_name');
				
				var network_address = nonapi_counts_url + "nw="+network+"&url="+url+"&instance="+instance_id;
					$.getJSON(network_address)
					.done(function(data){
						var cache_key = data.network+"|"+data.url;
						counter_display(counter_pos, operating_elements[data.network+data.instance], operating_elements[data.network+'_inside'+data.instance], data.count);
					});
				
			}

			var post_network_list = [];
			
			for (var i=0;i<nonapi_internal_count_networks.length;i++) {
				var network = nonapi_internal_count_networks[i];
				
				post_network_list.push(network);
				operating_elements[network+instance_id] = $(this).find('.essb_link_'+network);
				operating_elements[network+'_inside'+instance_id] = operating_elements[network+instance_id].find('.essb_network_name');
				//console.log('internal networks =' + network);
				if (!force_single_ajax) {
					var network_address = nonapi_internal_url + "nw="+network+"&url="+url+"&instance="+instance_id+"&post="+post_self_count_id;
					
					$.getJSON(network_address)
					.done(function(data){
						var counter = data[data.network] || "0";
						counter_display(counter_pos, operating_elements[data.network+data.instance], operating_elements[data.network+'_inside'+data.instance], counter);
					});
				}
			}
			
			if (post_network_list.length > 0 && force_single_ajax) {
				var network_address = nonapi_internal_url + "nw="+post_network_list.join(",")+"&url="+url+"&instance="+instance_id+"&post="+post_self_count_id;
				//console.log(network_address);
				$.getJSON(network_address)
				.done(function(data){
					
					for (var i=0;i<post_network_list.length;i++) {
						var network_key = post_network_list[i];
						var counter = data[network_key] || "0";
						
						//console.log(network_key + " = " + counter);
						counter_display(counter_pos, operating_elements[network_key+data.instance], operating_elements[network_key+'_inside'+data.instance], counter);
					}
				});

			}
			
			var counter_display = function(counter_pos, $element, $element_inside, $cnt) {
				$css_hidden_negative = "";				
				
				if (button_counter_hidden != '') {
					if (parseInt(button_counter_hidden) > parseInt($cnt)) { $css_hidden_negative = ' style="display: none;"'; }
				}
				
				if (counter_pos == "right") {
					$element.append('<span class="essb_counter_right" cnt="' + $cnt + '"'+$css_hidden_negative+'>' + essb_shorten_number($cnt) + '</span>');
				}
				else if (counter_pos == "inside") {
					$element_inside.html('<span class="essb_counter_inside" cnt="' + $cnt + '"'+$css_hidden_negative+'>' + essb_shorten_number($cnt) + '</span>');
				}
				else if (counter_pos == "insidename") {
					$element_inside.append('<span class="essb_counter_insidename" cnt="' + $cnt + '"'+$css_hidden_negative+'>' + essb_shorten_number($cnt) + '</span>');
				}
				else if (counter_pos == "insidehover") {
					$element_inside.closest("a").append('<span class="essb_counter_insidehover" cnt="' + $cnt + '"'+$css_hidden_negative+'>' + essb_shorten_number($cnt) + '</span>');
					
					// fix width of new element
					var current_width = $element_inside.closest("a").find('.essb_network_name').innerWidth();
					$element_inside.closest("a").find('.essb_counter_insidehover').width(current_width);
				}
				else if (counter_pos == "insidebeforename") {
					$element_inside.prepend('<span class="essb_counter_insidebeforename" cnt="' + $cnt + '"'+$css_hidden_negative+'>' + essb_shorten_number($cnt) + '</span>');
				}
				else if (counter_pos == "bottom") {
					$element_inside.html('<span class="essb_counter_bottom" cnt="' + $cnt + '"'+$css_hidden_negative+'>' + essb_shorten_number($cnt) + '</span>');
				}
				else if (counter_pos == "hidden") {
					$element.append('<span class="essb_counter_hidden" cnt="' + $cnt + '"'+$css_hidden_negative+'></span>');
				}
				else if (counter_pos == "topn") {
					$element.find("a").prepend('<span class="essb_counter_topn" cnt="' + $cnt + '"'+$css_hidden_negative+'>' + essb_shorten_number($cnt) + '</span>');
				}
				else {
					$element.prepend('<span class="essb_counter" cnt="' + $cnt + '"'+$css_hidden_negative+'>' + essb_shorten_number($cnt) + '</span>');
				}
				
			}
			
			
		});
	}; 

	jQuery.fn.essb_update_counters = function(){
		return this.each(function(){

			var $group			= $(this).find(".essb_links_list");
			var current_button_counter_pos = $(this).attr("data-essb-counter-pos") || "";
			var $total_count 	= $group.find('.essb_totalcount');
			var $total_count_nb = $total_count.find('.essb_t_nb');
			var $total_count_item = $group.find('.essb_totalcount_item');
			
			var $total_counter_hidden = $total_count_item.attr('data-essb-hide-till') || "";
			
			var total_text = $total_count.attr('title') || "";
			var total_text_after = $total_count.attr('title_after') || "";
			var total_inside_text = $total_count.attr('data-shares-text') || "";
			if (typeof(total_text) == "undefined") { total_text = ""; }
			if (typeof(total_text_after) == "undefined") { total_text_after = ""; }
			if (total_text != '')
				$total_count.prepend('<span class="essb_total_text">'+total_text+'</span>');
			
			function count_total() {
				var total = 0;
				var counter_pos = current_button_counter_pos;
				
				var exist_data_counter_pos = $total_count_item.attr('data-counter-pos') || "";
//				alert(exist_data_counter_pos);
				if (exist_data_counter_pos != '') {
					counter_pos = exist_data_counter_pos;
				}
				var counter_element = "";
				switch (counter_pos) {
				case "rightm":
				case "right":
					counter_element = ".essb_counter_right";
					break;
				case "inside":
					counter_element = ".essb_counter_inside";
					break;
				case "bottom":
					counter_element = ".essb_counter_bottom";
					break;
				case "insidename":
					counter_element = ".essb_counter_insidename";
					break;
				case "insidebeforename":
					counter_element = ".essb_counter_insidebeforename";
					break;
				case "insidehover":
					counter_element = ".essb_counter_insidehover";
					break;
				case "hidden":
					counter_element = ".essb_counter_hidden";
					break;
				case "topn":
					counter_element = '.essb_counter_topn';
					break;
				default:
					counter_element = ".essb_counter";
					break;
				}
				
				
				
					$group.find(counter_element).each(function(){
						total += parseInt($(this).attr('cnt'));		
						
						var value = parseInt($(this).attr('cnt'));
						if (!$total_count_nb) {
						value = essb_shorten_number(value);
						$(this).text(value);
					}
						//alert(shortenNumber(total));
					});
					
				if (total_inside_text != '') {
					$total_count_nb.html(essb_shorten_number(total) + '<span class="essb_t_nb_after">'+total_inside_text+'</span>')
				}
				else {
					$total_count_nb.text(essb_shorten_number(total));
				}
				
				// show total counter when value is reached
				if ($total_counter_hidden != '') {
					//alert(parseInt($total_counter_hidden) + " - " + total);
					if (parseInt($total_counter_hidden) <= total) {
						$total_count_item.show();
					}
				}
 			}
			
			setInterval(count_total, 1200);

		});
	}; 
	
	
	$('.essb_links.essb_counters').essb_get_counters();
	$('.essb_links.essb_counters').essb_update_counters();
});