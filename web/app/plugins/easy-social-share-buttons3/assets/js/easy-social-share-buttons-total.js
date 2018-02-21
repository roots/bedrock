
jQuery(document).ready(function($){

	var basic_network_list = "twitter,linkedin,facebook,pinterest,google,stumbleupon,vk,reddit,buffer,love,ok,mwp,xing,pocket,mail,print,comments,yummly";
	var extended_network_list = "del,digg,weibo,flattr,tumblr,whatsapp,meneame,blogger,amazon,yahoomail,gmail,aol,newsvine,hackernews,evernote,myspace,mailru,viadeo,line,flipboard,sms,viber,telegram";
	
	var plugin_url = essb_settings.essb3_plugin_url;
	var fb_value = essb_settings.essb3_facebook_total;
	var counter_admin   = essb_settings.essb3_admin_ajax;
	var interal_counters_all = essb_settings.essb3_internal_counter;
	var button_counter_hidden = essb_settings.essb3_counter_button_min;
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
	
	jQuery.fn.essb_total_counters = function(){
		return this.each(function(){
			
			// missing plugin settings - code cannot run from here
			if (typeof(essb_settings) == "undefined") { return; }
			
			var post_self_count_id = $(this).attr("data-post") || "";
			
			var url 			= $(this).attr("data-url") || "";
			var twitter_url     = url;
			
			var instance_id = $(this).attr("data-essb-instance") || "";
			
			
			var ajax_url = essb_settings.ajax_url;
			if (essb_settings.ajax_type == "light") {
				ajax_url = essb_settings.blog_url;
			}
			
			var $network_list = $(this).attr('data-network-list');
			
			var $url = url;
			var $facebook_total = fb_value;
			var $post_id =  post_self_count_id;
			
			//var $root = $(this).find('.essb-total-value');
			var $value_element = $(this).find('.essb-total-value');
			var $root = $(this);
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
				if ($network_list.indexOf(basic_networks[i]) > -1) {
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
					case "mail":
					case "print":
					case "love":
					case "comments":
						nonapi_internal_count_networks.push(basic_networks[i]);
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
					if ($network_list.indexOf(extended_networks[i]) > -1) {
						nonapi_internal_count_networks.push(extended_networks[i]);					
					}
				}
			}
			
			// start populating counters - direct access API counters
			var operating_elements = {};
			for (var i=0;i<direct_access_networks.length;i++) {
				var network = direct_access_networks[i];
								
				switch (network) {

				case "facebook":
					//var facebook_url	= "https://graph.facebook.com/fql?q=SELECT%20like_count,%20total_count,%20share_count,%20click_count,%20comment_count%20FROM%20link_stat%20WHERE%20url%20=%20%22"+url+"%22";
					//var facebook_url = "https://api.facebook.com/restserver.php?method=links.getStats&format=json&urls="+url;
					var facebook_url = "https://graph.facebook.com/?id="+url;
					$.getJSON(facebook_url)
					.done(function(data){
						if (fb_value) {
							try {
								$root.attr('data-facebook', data['share'].share_count);
							}
							catch (e) {
								$root.attr('data-facebook', "0");
							}
						}
						else {
							try {
								$root.attr('data-facebook', data['share'].share_count);
							}
							catch (e) {
								$root.attr('data-facebook', "0");
							}
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
						$root.attr('data-twitter', data.count);						
					});
					break;
					
				case "linkedin":
					var linkedin_url	= "https://www.linkedin.com/countserv/count/share?format=jsonp&url=" + url + "&callback=essb";
					$.getJSON(linkedin_url)
					.done(function(data){
						$root.attr('data-linkedin', data.count);						
					});
					break;
					
				case "pinterest":
					var pinterest_url   = "https://api.pinterest.com/v1/urls/count.json?callback=?&url=" + url;
					$.getJSON(pinterest_url)
					.done(function(data){
						$root.attr('data-pinterest', data.count);						
					});
					break;
				case "buffer":
					var buffer_url   = "https://api.bufferapp.com/1/links/shares.json?url="+url+"&callback=?";
					$.getJSON(buffer_url)
					.done(function(data){
						$root.attr('data-buffer', data.shares);						
					});
					break;
				case "yummly":
					var yummly_url   = "https://www.yummly.com/services/yum-count?callback=?&url="+url;
					$.getJSON(yummly_url)
					.done(function(data){
						$root.attr('data-yummly', data.count);						
					});
					break;
				}
				
				
			}
			
			for (var i=0;i<nonapi_count_networks.length;i++) {
				var network = nonapi_count_networks[i];
								
				var network_address = nonapi_counts_url + "nw="+network+"&url="+url+"&instance="+instance_id;
					
					$.getJSON(network_address)
					.done(function(data){
						var cache_key = data.network+"|"+data.url;
						
						$root.attr('data-'+data.network, data.count);						
					});
				
			}

			var post_network_list = [];
			
			for (var i=0;i<nonapi_internal_count_networks.length;i++) {
				var network = nonapi_internal_count_networks[i];
				
				post_network_list.push(network);
				//console.log('internal networks =' + network);
				var network_address = nonapi_internal_url + "nw="+network+"&url="+url+"&instance="+instance_id+"&post="+post_self_count_id;
				$.getJSON(network_address)
				.done(function(data){
					var counter = data[data.network] || "0";
					$root.attr('data-'+data.network, counter);
				});
			}

			
		});
	}; 

	jQuery.fn.essb_update_total_counters = function(){
		return this.each(function(){
			var $network_list = $(this).attr('data-network-list');
			var $networkContainer = $network_list.split(",");
			var $value_element = $(this).find('.essb-total-value');
			var $full_number = $(this).attr('data-full-number');
			var $root = $(this);
			
			var $total_counter_hidden = $(this).attr('data-essb-hide-till') || "";
									
			function update_total() {
				var current_total = 0;
				var currnt_passed_networks = 0;

				for (var i=0;i<$networkContainer.length;i++) {
					var $singleNetwork = $networkContainer[i];
					
					var value = $root.attr('data-'+$singleNetwork);
					if (typeof(value) == "undefined") { value = 0; }
					else {
					}
					
					if (Number(value) <= 0) { value = 0; }
					
					//console.log($singleNetwork + ' | ' + value);
					current_total += parseInt(value);
					
					
				}
				
				if ($full_number == 'true') {
					$value_element.text(current_total);
				}
				else {
					$value_element.text(shortenNumber(current_total));
				}
				
				if ($total_counter_hidden != '') {
					if (parseInt($total_counter_hidden) <= current_total) {
						$root.show();
					}
				}
			}
			
			
			function shortenNumber(n) {
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
			
			setInterval(update_total, 1200);
		});
	};
	
	$('.essb-total').essb_total_counters();
	$('.essb-total').essb_update_total_counters();

});