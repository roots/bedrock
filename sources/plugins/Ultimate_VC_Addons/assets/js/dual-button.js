(function(jQuery) {
    jQuery(document).ready(function(){

        //jQuery(window).on('resize', function() {

        var width=jQuery( window ).width();
        //alert(width);
        if(width>300 && width <768)
        {
            //alert('tsmall');
        var bshadow="inset 0px -200px 0px 0px ";
        var bshadow2=" inset 0px 200px 0px 0px ";
        }
        /*else if(width>400 && width <750)
        {
            //alert('small');
        var bshadow="inset -200px 0 0 0 ";
        var bshadow2="inset 200px 0 0 0";
        }*/
        else if( width>768 && width<1015){
            //alert('medi');
        var bshadow="inset 0px -200px 0px 0px ";
        var bshadow2=" inset 0px 200px 0px 0px ";
        }
        else{
            //alert('bgr');
        var bshadow="inset -200px 0 0 0 ";
        var bshadow2="inset 200px 0 0 0";
        }

    // }).trigger('resize');
        /*--- bt1 ----*/
        jQuery(document).on("mouseenter", ".ult_dual1", function() {

            var style=jQuery(this).find('.ult-dual-btn-1').attr('class');
            var arr=style.split(" ");
            var style=arr[1]+arr[2];

            if(style=='Style1')
            {
            var bghover = jQuery(this).find('.ult-dual-btn-1').data('bghovercolor');
            //jQuery(this).css({'background-color':bghover});
			jQuery(this)[0].style.setProperty( 'background-color', bghover, 'important' );
            }
            if(style=='Style2')
            {
            var bghover = jQuery(this).find('.ult-dual-btn-1').data('bghovercolor');
           // jQuery(this).css({'box-shadow':bshadow+bghover})
            }

            if(style=='Style3')
            {
            var bghover = jQuery(this).find('.ult-dual-btn-1').data('bghovercolor');
            jQuery(this).css({'box-shadow':' inset 0 0 20px 50px '+bghover})
            }

            if(style!='undefined')
            {
            var iconhover = jQuery(this).find('.ult-dual-btn-1').data('icon_hover_color');
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon').css({'color':iconhover});

            var iconbghover = jQuery(this).find('.ult-dual-btn-1').data('iconbghovercolor');
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon').css({'background':iconbghover});

            var iconborderhover = jQuery(this).find('.ult-dual-btn-1').data('iconhoverborder');
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon').css({'border-color':iconborderhover});

            //for image hover
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon-img').css({'background':iconbghover});
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon-img').css({'border-color':iconborderhover});

            var titlehover = jQuery(this).find('.ult-dual-btn-1').data('texthovercolor');
            jQuery(this).find('.ult-dual-btn-1').find('.ult-dual-button-title').css({'color':titlehover});
            }
        });

        jQuery(document).on("mouseleave", ".ult_dual1", function() {

            var style1=jQuery(this).find('.ult-dual-btn-1').attr('class');
            var arr=style1.split(" ");
            var style1=arr[1]+arr[2];
            if(style1=='Style1'){
            var bgcolor = jQuery(this).find('.ult-dual-btn-1').data('bgcolor');
            //jQuery(this).css({'background-color':bgcolor});
            jQuery(this)[0].style.setProperty( 'background-color', bgcolor, 'important' );
            }

            if(style1=='Style2')
            {
            var bgcolor = jQuery(this).find('.ult-dual-btn-1').data('bgcolor');
            //jQuery(this).css({'box-shadow':'inset 0px 0 0 0 '+bgcolor});

            }
            if(style1=='Style3')
            {
            var bgcolor = jQuery(this).find('.ult-dual-btn-1').data('bgcolor');
            jQuery(this).css({'box-shadow':'inset 0px 0 0 0 '+bgcolor});
            }
            if(style1!='undefined')
            {
            var iconcolor = jQuery(this).find('.ult-dual-btn-1').data('icon_color');
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon').css({'color':iconcolor});

            var titlecolor = jQuery(this).find('.ult-dual-btn-1').data('textcolor');
            jQuery(this).find('.ult-dual-btn-1').find('.ult-dual-button-title').css({'color':titlecolor});

            var iconbgcolor = jQuery(this).find('.ult-dual-btn-1').data('iconbgcolor');
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon').css({'background':iconbgcolor});

            var iconbordercolor = jQuery(this).find('.ult-dual-btn-1').data('iconborder');
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon').css({'border-color':iconbordercolor});

            //for image hover
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon-img').css({'background':iconbgcolor});
            jQuery(this).find('.ult-dual-btn-1').find('.aio-icon-img').css({'border-color':iconbordercolor});

            }
        });

        /*--- bt2 ----*/
        jQuery(document).on("mouseenter", ".ult_dual2", function() {

            var style1=jQuery(this).find('.ult-dual-btn-2').attr('class');
            var arr=style1.split(" ");
            var style1=arr[1]+arr[2];

            if(style1=='Style1'){
            var bghover = jQuery(this).find('.ult-dual-btn-2').data('bghovercolor');
            //jQuery(this).css({'background-color':bghover});
			jQuery(this)[0].style.setProperty( 'background-color', bghover, 'important' );

            }

            if(style1=='Style2')
            {
            var bghover = jQuery(this).find('.ult-dual-btn-2').data('bghovercolor');
           // jQuery(this).css({'box-shadow':bshadow2+bghover});
            }
            if(style1=='Style3')
            {
            var bghover = jQuery(this).find('.ult-dual-btn-2').data('bghovercolor');
            jQuery(this).css({'box-shadow':' inset 0 0 20px 50px '+bghover});
            }

            if(style1!='undefined')
            {
            var iconhover = jQuery(this).find('.ult-dual-btn-2').data('icon_hover_color');
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon').css({'color':iconhover});

            var titlehover = jQuery(this).find('.ult-dual-btn-2').data('texthovercolor');

            jQuery(this).find('.ult-dual-btn-2').find('.ult-dual-button-title').css({'color':titlehover});

            var iconbghover = jQuery(this).find('.ult-dual-btn-2').data('iconbghovercolor');
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon').css({'background':iconbghover});

            var iconborderhover = jQuery(this).find('.ult-dual-btn-2').data('iconhoverborder');
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon').css({'border-color':iconborderhover});

            //for image hover
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon-img').css({'background':iconbghover});
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon-img').css({'border-color':iconborderhover});

            }
        });

        jQuery(document).on("mouseleave", ".ult_dual2", function() {
            var style1=jQuery(this).find('.ult-dual-btn-2').attr('class');
            var arr=style1.split(" ");
            var style1=arr[1]+arr[2];
            if(style1=='Style1'){

            var bgcolor = jQuery(this).find('.ult-dual-btn-2').data('bgcolor');
            //jQuery(this).css({'background-color':bgcolor});
            jQuery(this)[0].style.setProperty( 'background-color', bgcolor, 'important' );
            }

            if(style1=='Style2')
            {
            var bgcolor = jQuery(this).find('.ult-dual-btn-2').data('bgcolor');
            //jQuery(this).css({'box-shadow':'inset 0px 0 0 0 '+bgcolor});

            }

            if(style1=='Style3')
            {
            var bgcolor = jQuery(this).find('.ult-dual-btn-2').data('bghovercolor');
            jQuery(this).css({'box-shadow':' inset 0 0 0 0 '+bgcolor});
            }

            if(style1!='undefined')
            {
            var iconcolor = jQuery(this).find('.ult-dual-btn-2').data('icon_color');
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon').css({'color':iconcolor});

            var titlecolor = jQuery(this).find('.ult-dual-btn-2').data('textcolor');
            jQuery(this).find('.ult-dual-btn-2').find('.ult-dual-button-title').css({'color':titlecolor});

            var iconbgcolor = jQuery(this).find('.ult-dual-btn-2').data('iconbgcolor');
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon').css({'background':iconbgcolor});

            var iconbordercolor = jQuery(this).find('.ult-dual-btn-2').data('iconborder');
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon').css({'border-color':iconbordercolor});

            //for image hover
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon-img').css({'background':iconbgcolor});
            jQuery(this).find('.ult-dual-btn-2').find('.aio-icon-img').css({'border-color':iconbordercolor});

            }
        });
    });
        /*---for button----*/

        jQuery(document).on("mouseenter", ".ult_main_dualbtn", function() {
            var mainhoverborder = jQuery(this).data('bhcolor');
            //jQuery(this).find('.ivan-button').css({'border-color':mainhoverborder});
        });

        jQuery(document).on("mouseleave", ".ult_main_dualbtn", function() {
            var mainborder = jQuery(this).data('bcolor');
            //jQuery(this).find('.ivan-button').css({'border-color':mainborder});
        });

}( jQuery ));

    jQuery(document).ready(function(e){
        //alert('hi');
        jQuery( ".ult_main_dualbtn" ).each(function( index ) {

			var ht1=jQuery(this).find('.ult_dual1').outerHeight();
			ht1=parseInt(ht1);

			var ht2=jQuery(this).find('.ult_dual2').outerHeight();
			ht2=parseInt(ht2);

			if(ht1>ht2)
			{
				jQuery(this).find('.ult_dual2').css({'height':ht1});
				jQuery(this).find('.ult_dual1').css({'height':ht1});

			}
			else if(ht1<ht2)
			{
				jQuery(this).find('.ult_dual1').css({'height':ht2});
				jQuery(this).find('.ult_dual2').css({'height':ht2});

			}
			else if(ht1==ht2)
			{
				jQuery(this).find('.ult_dual1').css({'height':ht2});
				jQuery(this).find('.ult_dual2').css({'height':ht2});

			}
    	});
    });

    function recallme(){
        jQuery( ".ult_dual_button" ).each(function( index ) {
             var id=jQuery(this).attr("id");
             var response=jQuery(this).data("response");
             if(response=='undefined' || response==''){
                response='on';
             }
                if(response=="on")
                {
                   var style =id;
                   style = document.createElement('style');
                   style.type = 'text/css';
                   style.innerHTML = "@media(min-width:300px) and (max-width:768px) {"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper { margin: 0px;float: none;position: relative}.ult_main_dualbtn { display: inline-block}.ult_dualbutton-wrapper { display: block }"+"#"+id+".ult_dual_button .middle-text {top: 100%;right: 50%}"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:first-child .ult_ivan_button { border-bottom-right-radius: 0!important; border-bottom-left-radius: 0!important; border-top-right-radius: inherit; border-bottom: 0px!important;}"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:last-child .ult_ivan_button { border-top-left-radius: 0!important;border-top-right-radius: 0!important}}@media(min-width:0px) and (max-width:0px) {"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper { float: left; position: relative}.ult_dual1 {     border-right: none!important } .ult_dualbutton-wrapper {display: block}"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:first-child .ult_ivan_button { border-top-right-radius: 0!important;  border-bottom-right-radius: 0!important}"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:last-child .ult_ivan_button { border-top-left-radius: 0!important;  border-bottom-left-radius: 0!important  }}@media(min-width:768px) and (max-width:970px) { "+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper { margin: -4px; float: none; position: relative }.ult_dualbutton-wrapper { display: block} "+"#"+id+".ult_dual_button .middle-text { top: 100%; right: 50% }"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:first-child .ult_ivan_button { border-bottom-right-radius: 0!important; border-bottom-left-radius: 0!important; border-top-right-radius: inherit }"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:last-child .ult_ivan_button {     border-top-left-radius: 0!important;   border-top-right-radius: 0!important  }}@media(min-width:970px){ "+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:first-child .ult_ivan_button { border-top-right-radius: 0!important; border-bottom-right-radius: 0!important}"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:last-child .ult_ivan_button { border-top-left-radius: 0!important; border-bottom-left-radius: 0!important }"+"#"+id+".ult_dual_button .ult_dual1 { border-right: none!important}}";
                   document.getElementsByTagName('head')[0].appendChild(style);
                   document.getElementsByTagName('head')[0].appendChild(style);

                   var width=jQuery( window ).width();
				   var b1w = jQuery(this).find('.ult_dual1').outerWidth();
				   var b2w = jQuery(this).find('.ult_dual2').outerWidth();
                    //alert(width);
                    if(width>300 && width <=768)
                    {
                        //alert('tsmall');
                    var bshadow="inset 0px -"+b1w+"px 0px 0px ";
                    var bshadow2=" inset 0px "+b2w+"px 0px 0px ";
                    }
                   /* else if(width>400 && width <750)
                    {
                        //alert('small');
                    var bshadow="inset -"+b1w+"px 0 0 0 ";
                    var bshadow2="inset "+b2w+"px 0 0 0";
                    }*/
                    else if( width>768 && width<1015){
                        //alert('medi');
                    var bshadow="inset 0px -"+b1w+"px 0px 0px ";
                    var bshadow2=" inset 0px "+b2w+"px 0px 0px ";
                    }
                    else{
                        //alert('bgr');
                    var bshadow="inset -"+b1w+"px 0 0 0 ";
                    var bshadow2="inset "+b2w+"px 0 0 0";
                    }

                    //change box shaddow of button1
                   jQuery("#"+id).find(".ult_dual1").mouseenter(function(){

                    var style=jQuery(this).find('.ult-dual-btn-1').attr('class');
                    var arr=style.split(" ");
                    var style=arr[1]+arr[2];

                      if(style=='Style2')
                        {
                       // var bshadow="inset 0px -200px 0px 0px ";
                        var bghover = jQuery(this).find('.ult-dual-btn-1').data('bghovercolor');
                        jQuery(this).css({'box-shadow':bshadow+bghover})
                        }

                });

                     jQuery("#"+id).find(".ult_dual1").mouseleave(function(){
                    var style=jQuery(this).find('.ult-dual-btn-1').attr('class');
                    var arr=style.split(" ");
                    var style=arr[1]+arr[2];

                     if(style=='Style2')
                        {
                        var bgcolor = jQuery(this).find('.ult-dual-btn-1').data('bgcolor');
                        jQuery(this).css({'box-shadow':'inset 0px 0 0 0 '+bgcolor});

                        }
                });

                 //change box shaddow of button2

               jQuery("#"+id).find(".ult_dual2").mouseenter(function(){
                    var style1=jQuery(this).find('.ult-dual-btn-2').attr('class');
                    var arr=style1.split(" ");
                    var style1=arr[1]+arr[2];
                    if(style1=='Style2')
                        {
                        //var bshadow2=" inset 0px 200px 0px 0px ";
                        var bghover = jQuery(this).find('.ult-dual-btn-2').data('bghovercolor');
                        jQuery(this).css({'box-shadow':bshadow2+bghover});
                        }

                });

                  jQuery("#"+id).find(".ult_dual2").mouseleave(function(){
                    var style1=jQuery(this).find('.ult-dual-btn-2').attr('class');
                    var arr=style1.split(" ");
                    var style1=arr[1]+arr[2];

                    if(style1=='Style2')
                    {
                    var bgcolor = jQuery(this).find('.ult-dual-btn-2').data('bgcolor');
                    jQuery(this).css({'box-shadow':'inset 0px 0 0 0 '+bgcolor});

                    }
                });

                }
                else{
                   var style =id;
                   style = document.createElement('style');
                   style.type = 'text/css';
                   style.innerHTML = "#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:first-child .ult_ivan_button { border-top-right-radius: 0!important; border-bottom-right-radius: 0!important }"+"#"+id+".ult_dual_button .ulitmate_dual_buttons .ult_dualbutton-wrapper:last-child .ult_ivan_button { border-top-left-radius: 0!important; border-bottom-left-radius: 0!important }"+"#"+id+".ult_dual_button .ult_dual1 { border-right: none!important}";
                   document.getElementsByTagName('head')[0].appendChild(style);

                   document.getElementsByTagName('head')[0].appendChild(style);

                //change box shaddow of button1

                    jQuery("#"+id).find(".ult_dual1").mouseenter(function(){

                    var style=jQuery(this).find('.ult-dual-btn-1').attr('class');
                    var arr=style.split(" ");
                    var style=arr[1]+arr[2];

					var wd = jQuery(this).outerWidth();

                      if(style=='Style2')
                        {
                        var bshadow="inset -"+wd+"px 0 0 0 ";
                        var bghover = jQuery(this).find('.ult-dual-btn-1').data('bghovercolor');
                        jQuery(this).css({'box-shadow':bshadow+bghover})
                        }

                });
                     jQuery("#"+id).find(".ult_dual1").mouseleave(function(){
                    var style=jQuery(this).find('.ult-dual-btn-1').attr('class');
                    var arr=style.split(" ");
                    var style=arr[1]+arr[2];

                     if(style=='Style2')
                        {
                        var bgcolor = jQuery(this).find('.ult-dual-btn-1').data('bgcolor');
                        jQuery(this).css({'box-shadow':'inset 0px 0 0 0 '+bgcolor});

                        }
                });
                 //change box shaddow of button2

               jQuery("#"+id).find(".ult_dual2").mouseenter(function(){
                    var style1=jQuery(this).find('.ult-dual-btn-2').attr('class');
                    var arr=style1.split(" ");
                    var style1=arr[1]+arr[2];
					var wd = jQuery(this).outerWidth();
                    if(style1=='Style2')
                        {
                        var bshadow2="inset "+wd+"px 0 0 0";
                        var bghover = jQuery(this).find('.ult-dual-btn-2').data('bghovercolor');
                        jQuery(this).css({'box-shadow':bshadow2+bghover});
                        }

                });

                  jQuery("#"+id).find(".ult_dual2").mouseleave(function(){
                    var style1=jQuery(this).find('.ult-dual-btn-2').attr('class');
                    var arr=style1.split(" ");
                    var style1=arr[1]+arr[2];

                    if(style1=='Style2')
                    {
                    var bgcolor = jQuery(this).find('.ult-dual-btn-2').data('bgcolor');
                    jQuery(this).css({'box-shadow':'inset 0px 0 0 0 '+bgcolor});

                    }
                });

                }
          });
    }

//responsive media query for button
jQuery(document).ready(function(p){
  recallme();
    jQuery( window ).load(function() {
      //console.log("hi");
        recallme();
    });
	jQuery( window ).resize(function() {
	  //console.log("hi");
		recallme();
	});
});