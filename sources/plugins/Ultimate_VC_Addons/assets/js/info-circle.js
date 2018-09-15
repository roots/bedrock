var resizedd=0;
var time_f_arr =[];
jQuery(document).ready(function(){
	make_info_circle('.info-c-full-br',0);
	responsive_check('.info-c-full-br');
	calculate_clipped_circle();
	//make_info_circle('.info-c-semi-br',0);
	//responsive_check('.info-c-semi-br');
	//part_circle_icon('.info-c-full-br');
	//semi_circle_icon('.info-c-semi-br');

	jQuery('.clipped-info-circle').each(function(i,circle){
		var xh = jQuery(this).outerHeight();
		var xw = jQuery(this).outerWidth();
		jQuery(this).attr('data-first-width',xw);
		jQuery(this).attr('data-first-height',xh);
	});


	jQuery(window).resize(function(){
		resizedd++;
		make_info_circle('.info-c-full-br',resizedd);
		calculate_clipped_circle();
		//make_info_circle('.info-c-semi-br',resizedd);
	});
	jQuery(window).load(function(){
		resizedd++;
		make_info_circle('.info-c-full-br',resizedd);
		calculate_clipped_circle();
		//make_info_circle('.info-c-semi-br',resizedd);
	});
	jQuery(document).on('ultAdvancedTabClicked',function(){
		resizedd++;
		make_info_circle('.info-c-full-br',resizedd);
		calculate_clipped_circle();
	});
	jQuery('.info-c-full-br').each(function(){
		if(jQuery(this).data('focus-on')=="click"){
			jQuery(this).find('.icon-circle-list .info-circle-icons').click(function(){
				var obj = jQuery(this);
				jQuery(this).parents('.info-c-full-br').attr('data-slide-true','false');
				show_next_info_circle(obj);
			})
		}
		if(jQuery(this).data('focus-on')=="hover"){
			jQuery(this).find('.icon-circle-list .info-circle-icons').hover(function(){
				var obj = jQuery(this);
				jQuery(this).parents('.info-c-full-br').attr('data-slide-true','false');
				show_next_info_circle(obj);
			},function(){})
		}
	});



	/*jQuery('.info-c-semi-br .icon-circle-list .info-circle-icons').bind('click',function(){
		var txt = jQuery(this).find('.text').html();
		var highlight_style= jQuery(this).parents('.info-c-full-br').data('highlight-style');
		if(highlight_style==''){
			//console.warn("Info Circle Higlight style not defined")
		}else{
			jQuery('.'+highlight_style).removeClass(highlight_style).removeClass('info-cirlce-active');
			jQuery(this).addClass(highlight_style).addClass('info-cirlce-active');
		}
		jQuery(this).parents('.info-c-semi-br').find('.info-c-semi').html(txt);
	})
	*/
	//jQuery('.info-c-full-br').attr('data-slide-true','true');
	setTimeout(function() {
		jQuery('.info-c-full-br').each(function(){
			var slide_delay = jQuery(this).data('slide-duration');
			if(!slide_delay){
				slide_delay = 0.2;
			}
			jQuery(this).attr('data-slide-number','1');
			info_circle_slide((slide_delay*1000),jQuery(this));
			//if(jQuery(this).attr('data-slide-true')=='off'){
				var obj = jQuery(this).find('.info-circle-icons').eq(0);
				show_next_info_circle(obj);
			//}
		});
	}, 1000);
});

function calculate_clipped_circle()
{
	jQuery('.clipped-info-circle').each(function(){
		var circle_type = jQuery(this).data('circle-type');
		var percentage = jQuery(this).data('half-percentage');

		var responsive = jQuery(this).children().data('responsive-circle');
		if(responsive == 'on')
		{
			var breakpoint = jQuery(this).children().data('responsive-breakpoint');
			var win = jQuery(window).width();
			var circle_type = jQuery(this).data('circle-type');
			if(win > breakpoint)
			{
				var xh = jQuery(this).data('first-height');
				if(typeof xh != 'undefined' && xh != '')
					jQuery(this).height(xh);
				//if(circle_type == 'right-circle' || circle_type == 'left-circle')
					//console.log('hi');

				//var xw = jQuery(this).data('first-width');
				//if(typeof xw != 'undefined' && xw != '')
					jQuery(this).width('100%');
				make_info_circle('.info-c-full-br',resizedd);
			}
		}

		var icon_height = jQuery(this).find('.info-circle-icons').outerHeight();
		var icon_width = jQuery(this).find('.info-circle-icons').outerHeight();

		if(circle_type != 'full-circle')
		{
			var wrapper_height = jQuery(this).outerHeight();
			var wrapper_width = jQuery(this).outerWidth();
			var margin_top = jQuery(this).css('margin-top');
			var margin_bottom = jQuery(this).css('margin-bottom');

			var wrapper_inner_width = jQuery(this).children().outerWidth();

			var info_margin = parseInt(jQuery(this).find('.info-c-full').css('margin-top').replace(/[^-\d\.]/g, ''));
			var info_padding = parseInt(jQuery(this).find('.info-c-full').css('padding-top').replace(/[^-\d\.]/g, ''));

			if(circle_type == 'top-circle' || circle_type == 'bottom-circle')
			{
				jQuery(this).css({'overflow':'hidden'});

				var info_width = jQuery(this).find('.info-c-full').outerWidth();
				var info_width_inner = jQuery(this).find('.info-c-full').width();

				if(circle_type == 'top-circle')
				{
					var hidden_height = (percentage/100)*wrapper_height;
					jQuery(this).css({'padding-top':margin_top, 'height' : hidden_height, 'margin-bottom' : 0});

					var info_wrap_height = hidden_height - info_margin - parseInt(margin_top.replace(/[^-\d\.]/g, '')) - info_padding-(info_padding/2);
					//var info_wrap_height = hidden_height/2;
					jQuery(this).find('.info-c-full-wrap').css({'height':info_wrap_height});
				}
				else if(circle_type == 'bottom-circle')
				{
					var temp_hidden_height = ((100-percentage)/100)*wrapper_height;

					var hidden_height = wrapper_height-temp_hidden_height+10;

					jQuery(this).css({'padding-bottom':margin_bottom, 'height' : hidden_height, 'margin-top':0});
					jQuery(this).children().css({'margin-top':-(temp_hidden_height+(icon_height/2))});

					var info_wrap_height = hidden_height - info_margin - parseInt(margin_top.replace(/[^-\d\.]/g, '')) - info_padding-(info_padding/2);

					jQuery(this).find('.info-c-full-wrap').height(info_wrap_height);
					var calculate_info_margin = info_width_inner-info_wrap_height;
					jQuery(this).find('.info-c-full-wrap').css({'margin-top':calculate_info_margin+'px'});
				}
			}
			else if(circle_type == 'left-circle' || circle_type == 'right-circle')
			{
				jQuery(this).css({'overflow':'hidden','padding-top':margin_top, 'padding-bottom':margin_bottom});

				var info_width = jQuery(this).find('.info-c-full').outerWidth();
				var info_width_inner = jQuery(this).find('.info-c-full').width();

				if(circle_type == 'left-circle')
				{
					var hidden_width = (percentage/100)*wrapper_inner_width;
					jQuery(this).css({'width' : hidden_width, 'padding-left':margin_top});
					jQuery(this).children().css({'width' : wrapper_inner_width,'max-width':wrapper_inner_width});

					var cal_width = hidden_width-info_margin-(info_padding+(info_padding/2))-parseInt(margin_top.replace(/[^-\d\.]/g, ''));
					jQuery(this).find('.info-c-full-wrap').width(cal_width);
				}
				else if(circle_type == 'right-circle')
				{
					var temp_hidden_width = ((100-percentage)/100)*wrapper_inner_width;
					var hidden_width = parseInt(wrapper_inner_width-temp_hidden_width);
					jQuery(this).css({'width' : hidden_width, 'padding-right':margin_top});
					jQuery(this).children().css({'margin-left':-(temp_hidden_width+(icon_width/2)), 'max-width':wrapper_inner_width, 'width' : wrapper_inner_width});

					var gap = temp_hidden_width - info_margin;
					gap = gap + parseInt(margin_top.replace(/[^-\d\.]/g, '')) - info_padding;

					var cal_width = hidden_width-info_margin-parseInt(margin_top.replace(/[^-\d\.]/g, '')) - info_padding;
					var cal_left = gap;
					jQuery(this).find('.info-c-full-wrap').width(cal_width);
					jQuery(this).find('.info-c-full-wrap').css({'margin-left':cal_left+'px'});
				}
			}
		}
		if(responsive == 'on')
		{
			var breakpoint = jQuery(this).children().data('responsive-breakpoint');
			var win = jQuery(window).width();
			if(win <= breakpoint)
			{
				jQuery(this).css({'width':'auto','overflow':'visible', 'height' : 'auto', 'padding' : 0});
			}
		}
	});
}

function info_circle_slide (delay,identity) {
	identity.bsf_appear(function(){
		setInterval(function(){
			if(identity.attr('data-slide-true')=='on'){
				var myindex = identity.attr('data-slide-number')*1;
				//console.log('slideTo'+myindex);
				var len = identity.find('.info-circle-icons').length;
				if(identity.data('info-circle-angle')!='full'){
					if(len-1 == myindex)
						myindex=0;
				}else{
					if(len== myindex)
						myindex=0;
				}
				var obj = identity.find('.info-circle-icons').eq(myindex);
				identity.attr('data-slide-number',myindex+1);
				show_next_info_circle(obj);
			}
		},delay);
		/*
		clearTimeout(time_f_arr[identity.data('timeout-fn')]);
		var time_fn = 'tf'+(Math.random().toString(36).slice(2));
		identity.data('timeout-fn',time_fn);
		time_f_arr[time_fn] = setTimeout(function() {
			if(identity.attr('data-slide-true')=='true'){
				info_circle_slide(++myindex,delay,identity);
			}
		}, delay);*/
	});
}
function show_next_info_circle(obj){
	var highlight_style= obj.parents('.info-c-full-br').data('highlight-style');
	if(highlight_style!=''){
		obj.parents('.info-c-full-br').find('.'+highlight_style).removeClass(highlight_style).removeClass('info-cirlce-active');
		obj.addClass(highlight_style).addClass('info-cirlce-active');
	}
	var txt = obj.next();
	var cont_f_size =obj.parents('.info-c-full-br').data('icon-show-size');
	if(obj.parents('.info-c-full-br').data('icon-show')=='not-show'){
		txt.find('i').remove();
		txt.find('img').remove();
		obj.parents('.info-c-full-br').find('.info-c-full').addClass('cirlce-noicon');
	}
	txt = txt.html();
	//obj.parents('.icon-circle-list').find('.info-details').animate({opacity:0});
	//obj.next().animate({opacity:1});
	//obj.parents('.info-c-full-br').find('.info-details').animate({opacity:0},'slow');
	var size = obj.css('font-size');
	var bg_col = obj.attr('style')
	//var p = bg_col.indexOf('background-color');
	//bg_col = bg_col.substr(p);
	//bg_col = bg_col.split(';');
	//bg_col= bg_col[0];
	//bg_col = bg_col.substr(17);
	var obj_par = obj.parents('.info-c-full-br');
	obj_par.find('.info-c-full-wrap').stop().animate({opacity:0},'slow',function(){
	//obj.parents('.info-c-full-br').find('.info-c-full').animate({opacity:1},'fast',function(){
		//obj.parents('.info-c-full-br').find('.info-c-full').css('color',obj.css('color'));
		obj.parents('.info-c-full-br').find('.info-c-full .info-c-full-wrap').html(txt);
		//obj.parents('.info-c-full-br').find('.info-c-full i').css({'font-size':(parseInt(size)*2.5)+'px'});
		//obj.parents('.info-c-full-br').find('.info-c-full img').css({'width':(parseInt(size)*2.5)+'px','margin-top':'20px'});
		obj_par.find('.info-c-full i').css({'font-size':parseInt(cont_f_size)+'px'});
		obj_par.find('.info-c-full img').css({'width':parseInt(cont_f_size)+'px'});
		//obj.parents('.info-c-full-br').find('.info-c-full').css('background-color',bg_col);
		obj.parents('.info-c-full-br').find('.info-c-full-wrap').animate({opacity:1},'slow');
	});
}
function responsive_check(obj){
	jQuery(obj).each(function(){
		if(jQuery(this).data('responsive-circle')=='on'){
			var parent = jQuery(this).parent();
			var uniq = parent.data('uniqid');
			var breakpoint = jQuery(this).data('responsive-breakpoint');
			var wrapper_id = 'info-circle-wrapper-'+uniq;
			var css = '<style>@media(max-width:'+breakpoint+'px){ #'+wrapper_id+' .smile_icon_list_wrap{ display: block; margin-top: auto !important; } #'+wrapper_id+' .info-c-full-br{ display: none; } .smile_icon_list_wrap { margin-left:auto !important; max-width:inherit !important; width:auto !important; } .info-circle-responsive .info-circle-def { display: block; width: auto; height: auto; } .info-circle-responsive .info-circle-sub-def { display: block; vertical-align: top; } }</style>';
			jQuery('head').append(css);

			var circle_list = jQuery(this).parent().find('.smile_icon_list_wrap .smile_icon_list');
			var circle_list_item = circle_list.find('.icon_list_item').clone();
			circle_list.find('.icon_list_item').remove();
			var list_bg_col = jQuery(this).next().data('content_bg')
			var list_col = jQuery(this).next().data('content_color')
			jQuery(this).find('.icon-circle-list .info-details').each(function(){
				var icon_class = jQuery(this).attr('data-icon-class');
				var heading = jQuery(this).find('.info-circle-heading').html();
				var text = jQuery(this).find('.info-circle-text').html();
				var bg = jQuery(this).prev().css('background-color');
				var color = jQuery(this).prev().css('color');
				var border_style = jQuery(this).prev().css('border');
				var icon = jQuery(this).find('.info-circle-sub-def').children().eq(0).clone();
				circle_list_item.find('.icon_list_icon').html(icon.wrap("<div />").parent().html());
				circle_list_item.find('.icon_description').css('color',list_col);
				circle_list_item.find('.icon_description').css('background-color',list_bg_col);
				circle_list_item.find('.icon_description h3').html(heading);
				circle_list_item.find('.icon_description p').html(text);
				circle_list_item.find('.icon_list_icon').css({'background-color':bg,'color':color,'border':border_style});
				circle_list_item.addClass(icon_class);
				circle_list.append(circle_list_item.wrap("<div />").parent().html());
			});
		}
	})
}
function make_info_circle(selector,resized){
	jQuery(selector).each(function(k,circle_item){
		var f_size = jQuery(circle_item).data('icon-size');
		jQuery(jQuery(circle_item).find(".icon-circle-list .info-circle-icons")).each(function(i,icon){
			var icon_height, icon_width, icon_margin, icon_line_height;
			var is_icon_wo_back = (jQuery(icon).hasClass('info-circle-icon-without-background')) ? true : false;
			if(!is_icon_wo_back) {
				icon_height = icon_width = icon_line_height = (f_size*2);
				icon_margin = f_size;
			}
			else {
				icon_height = icon_width = icon_line_height = f_size;
				icon_margin = (f_size/2);
			}
			jQuery(circle_item).parent().css({'margin-top':(icon_margin+10)+'px','margin-bottom':(icon_margin+10)+'px'});
			jQuery(circle_item).find(".icon-circle-list .info-circle-icons").css({"font-size":f_size+'px','height':icon_height+'px','width':icon_width+'px','margin':'-'+(icon_margin+'px'),'line-height':icon_line_height+'px'});
		});
	});
	if(selector=='.info-c-full-br'){
		jQuery(selector).each(function(){
			jQuery(this).css('height',jQuery(this).width());
			jQuery(this).css('opacity','1');
		});
	}
	if(selector=='.info-c-semi-br'){
		jQuery(selector).each(function(){
			var widd = jQuery(this).width();
			jQuery(this).css('height',((parseInt(widd))/2)+'px');
			var widd = widd+'px '+widd+'px '+' 0 0';
			jQuery(this).css('border-radius',widd);
			var i_widd = jQuery(this).find('.info-c-full').width();
			i_widd = i_widd+'px '+i_widd+'px '+'0 0';
			jQuery(this).find('.info-c-full').css('border-radius',i_widd);
		});
	}
	setTimeout(function() {
		if(resized == resizedd){
			if(selector=='.info-c-full-br'){
				part_circle_icon(selector);
			}
			if(selector=='.info-c-semi-br'){
				semi_circle_icon(selector);
			}
		}
	}, 1000);
}
function part_circle_icon(selector) {
	jQuery(selector).each(function(){

		jQuery(this).bsf_appear(function(){
			if(jQuery(this).css('display')!='none'){
					var count = jQuery(this).find('.icon-circle-list .info-circle-icons').length;
					var p_arr=new Array();
					var r=(jQuery(this).outerWidth())/2;

					var custom_degree = 0;
					var temp_degree = jQuery(this).data('start-degree');

					if(typeof temp_degree !== 'undefined' || temp_degree != '')
						custom_degree = temp_degree;

					var alt= 180/count;
					var pos=jQuery(this).data('info-circle-angle');
					var dev = 	jQuery(this).data('divert');

					var temp_pos = '';

					if(pos == 'full')
					{
						temp_pos = pos;
						pos = 180;
						alt=90;
						r = -r;
					}
					//pos = 180; // del on all option

					var gap_required = 0;
					var less = false;
					for(i=1;i<=count;i++)
					{
						var angle = i * ((180+(2*alt))/count);
						if(temp_pos == 'full')
						{
							if(angle < custom_degree && i == 1)
							{
								gap_required = custom_degree - angle;
								less = false;
							}
							else if(angle > custom_degree && i == 1)
							{
								gap_required = angle - custom_degree;
								less = true;
							}

							if(less == true)
							{
								angle-=gap_required;
							}
							else
							{
								angle+=gap_required;
							}
						}
						else
						{
							angle = angle+pos-alt+dev;
						}

					    angle = (angle*0.0174532925);

					    p_arr.push( r * Math.cos(angle));
					    p_arr.push( r * Math.sin(angle));
					}
					var i=0, delay=0;
					var launch = jQuery(this).data('launch');
					var launch_duration = jQuery(this).data('launch-duration');
					var launch_delay = jQuery(this).data('launch-delay');
					/*if(!launch){
						launch='easeOutExpo';
					}*/
					if(!launch_duration){
						launch_duration = 1;
					}
					if(!launch_delay){
						launch_delay= .15;
					}
					if(launch!=''){
						delay = -(launch_delay*1000);
						jQuery(this).find('.icon-circle-list .info-circle-icons').each(function(){
							var el = jQuery(this);
							delay+=(launch_delay*1000);
							setTimeout(function() {
								 el.animate(
									{opacity:1,left:p_arr[i++],top:p_arr[i++]},
								 	{
					                    duration: (launch_duration)*1000,
					                     easing: launch
					                });
							}, delay);
						})
					}
					else{
						jQuery(this).find('.icon-circle-list .info-circle-icons').each(function(){
							var el = jQuery(this);
							//el.animate({opacity:1,left:p_arr[i++],top:p_arr[i++]},(launch_duration)*1000,launch);
							el.css({'opacity':'1','left':p_arr[i++],"top":p_arr[i++]});
						})
					}
			}
		});
	});
}
/*function semi_circle_icon(selector) {
	jQuery(selector).each(function(){
		if(jQuery(this).css('display')!='none'){
		var count = jQuery(this).find('.icon-circle-list .info-circle-icons').length;
		var p_arr=new Array();
		var r=(jQuery(this).width())/2;
		var alt= 180/count;
		var pos = 180;
		var dev = 	jQuery(this).data('divert');
		for(i=1;i<=count;i++)
		{
			var angle = i * ((180+(2*alt))/count);
		    angle = angle+pos-alt+dev;
		  	//Do not delete these Comments
		  	//var angle = i * (90)/count;
		    //angle = angle+270;
		    //var  angle = i* 360/count;
		    //angle = angle+90;
		    angle = (angle*0.0174532925);
		    p_arr.push( r * Math.cos(angle));
		    p_arr.push( r * Math.sin(angle));
		}
		var i=0, delay=0;
		var launch = jQuery(this).data('launch');
		var launch_duration = jQuery(this).data('launch-duration');
		var launch_delay = jQuery(this).data('launch-delay');
		if(!launch){
			launch='easeOutExpo';
		}
		if(!launch_duration){
			launch_duration = 1;
		}
		if(!launch_delay){
			launch_delay= .15;
		}
		delay = -(launch_delay*1000);
		jQuery(this).find('.icon-circle-list .info-circle-icons').each(function(){
			var el = jQuery(this);
			delay+=(launch_delay*1000);
			setTimeout(function() {
				el.animate({opacity:1,left:p_arr[i++],top:p_arr[i++]},(launch_duration)*1000,launch);
			}, delay);
		})
	}
	})
}*/
jQuery(window).load(function(){
	jQuery('.info-c-full-br').each(function(){
		if(jQuery(this).attr('data-slide-true')=='on'){
			jQuery(this).hover(function(){
				jQuery(this).attr('data-slide-true','off');
			},function(){
				jQuery(this).attr('data-slide-true','on');
				//info_circle_slide((jQuery(this).data('slide-duration'))*(1000),jQuery(this));
			})
		}
	})
});

jQuery(document).ready(function(e) {
    jQuery(".icon_list_item").each(function(index, element) {
        var $this = jQuery(this);
		var count = $this.find(".info-circle-img-icon").length;
		if(count >= 1 ){
			$this.closest("ul.smile_icon_list").addClass("ic-resp-img");
		}
    });
});