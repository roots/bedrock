jQuery(document).ready(function(a) {
    a(".ult_tabs").each(function() {
        function m() {
            clearTimeout(l), k++, k > j - 1 && (k = 0), l = setTimeout(function() {
                c.find("ul.ult_tabmenu li.ult_tab_li").each(function(b) {
                    k == b && a(this).find("a.ult_a").trigger("click")
                })
            }, 1e3 * i)
        }

        var c = a(this),
            d = a(this).data("tabsstyle"),
            e = a(this).data("titlecolor"),
            f = a(this).data("titlebg"),
            g = a(this).data("titlehovercolor"),
            h = a(this).data("titlehoverbg"),
            i = parseInt(a(this).data("rotatetabs")),

            j = a(this).find("ul.ult_tabmenu li.ult_tab_li").length,
            act_title = a(this).data("activetitle"),
            act_icon = a(this).data("activeicon"),
            act_bg = a(this).data("activebg"),
            ht_width=parseInt(a(this).find(".ult_tabcontent").outerWidth()),
             k = 0;
          var lastid=[];
            lastid.push(0);
        a(this).find("ul.ult_tabmenu").addClass("active").find("> li.ult_tab_li:eq(0)").addClass("current"), a(this).find("ul.ult_tabmenu li.ult_tab_li").each(function(b) {
           var iconh = a(this).data("iconhover"),
          iconc = a(this).data("iconcolor");
          if(act_icon==''){

                act_icon=iconh;
             }

            0 == b && ("style2" == d || "style1" == d ? (a(this).find("a.ult_a").css({
                background: act_bg,
                color: act_title
            }),a(this).find(".ult_tab_icon").css({
                color:act_icon
            })) : (a(this).find("a.ult_a").css({
                color: act_title,
            }), a(this).css({
                background: act_bg,
                color: act_title
            }),a(this).find(".ult_tab_icon").css({
                color:act_title
            })
            )),

             a(this).on("mouseover", function() {
               if(a(this).hasClass("current"))
                {

                }
                else{
                a(this).hasClass("current") || "style2" == d || "style1" == d ? (a(this).find("a.ult_a").css({
                    background: h,
                    color: g
                }) ,a(this).find(".ult_tab_icon").css({
                color:iconh
            })): (a(this).find("a.ult_a").css({
                    color: g
                }), a(this).css({
                    background: h,
                    color: g
                }) , a(this).find("a.ult_a").find(".ult_tab_icon").css({
                     color: iconh})
                )}
            }).on("mouseleave", function() {
                a(this).hasClass("current") || ("style2" == d || "style1" == d ? (a(this).find("a.ult_a").css({
                    background: f,
                    color: e
                }),a(this).find(".ult_tab_icon").css({
                color:iconc
            }) ): (a(this).find("a.ult_a").css({
                    color: e
                }), a(this).css({
                    background: f,
                    color: e
                }), a(this).find("a.ult_a").find(".ult_tab_icon").css({
                     color: iconc})
                ))
            })
        }), a(this).find("ul.ult_tabmenu li a.ult_a").click(function(b) {
            var c = a(this).closest(".ult_tabs"),
                j = a(this).closest("li.ult_tab_li").index();
            var p=a(this).parent().data("iconcolor");
            var icn=a(this).parent().data("iconhover");
            lastid.push(j);
             var current=lastid[lastid.length-1];
             var last=lastid[lastid.length-2];

            //console.log("current-"+j);
            //console.log("last-"+last);
            var anm=a(this).closest('.ult_tabs').data("animation");

            c.find("ul.ult_tabmenu > li.ult_tab_li").removeClass("current"), "style2" == d || "style1" == d ?( c.find("ul.ult_tabmenu > li.ult_tab_li").find("a").css({
                background: f,
                color: e
            }),
            c.find("ul.ult_tabmenu > li.ult_tab_li").find(".ult_tab_icon").css({
                color: p
            })) : (c.find("ul.ult_tabmenu > li.ult_tab_li").find("a.ult_a").css({
                color: e
            }), c.find("ul.ult_tabmenu > li.ult_tab_li").css({
                background: f,
                color: e
            })

             );

            var l = a(this).closest("li.ult_tab_li").addClass("current");


          if(anm =='Slide'){
                "style2" == d || "style1" == d ? (l.find("a.ult_a").css({
                background: act_bg,
                color: act_title
            }),l.find(".ult_tab_icon").css({
                color: act_icon
            }) ): (l.find("a.ult_a").css({
                color: act_title
            }), l.css({
                background: act_bg,
                color: act_title
            }))
           ,
           c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").stop().slideUp(500, function() {
                i > 0 && m();
                //console.log("prajakta");
               // var cnht=c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").outerHeight();
                //c.find(".ult_tabcontent").clearQueue().finish();
                //c.find(".ult_tabcontent").animate({height: cnht},300);
            }), c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").stop().slideDown(500, function(){
                        }), k = j, b.preventDefault();
          }
          else if(anm =='Fade'){
                "style2" == d || "style1" == d ? (l.find("a.ult_a").css({
                background: act_bg,
                color: act_title
            }),l.find(".ult_tab_icon").css({
                color: act_icon
            }) ): (l.find("a.ult_a").css({
                color: act_title
            }), l.css({
                background: act_bg,
                color: act_title
            }))
           ,

        c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").fadeOut(100, function() {
               i > 0 && m();


            }), c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").fadeIn(1200), k = j, b.preventDefault();

          }
           else if(anm =='Scale'){
            //alert("hi");
                "style2" == d || "style1" == d ? (l.find("a.ult_a").css({
                background: act_bg,
                    color: act_title
                }),l.find(".ult_tab_icon").css({
                    color: act_icon
                }) ): (l.find("a.ult_a").css({
                    color: act_title
                }), l.css({
                    background: act_bg,
                    color: act_title
                }))
               ,

            c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").fadeOut(100, function() {
                   i > 0 && m();
                  c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").addClass("scaleTabname");
                  c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").removeClass("scaleTabname2");

                }), c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").fadeIn(300,function(){
                   c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").removeClass("scaleTabname");
                    c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").addClass("scaleTabname2");

                }), k = j, b.preventDefault();

          }
          else if(anm =='Slide-Zoom'){

                "style2" == d || "style1" == d ? (l.find("a.ult_a").css({
                background: act_bg,
                color: act_title
            }),l.find(".ult_tab_icon").css({
                color: act_icon
            }) ): (l.find("a.ult_a").css({
                color: act_title
            }), l.css({
                background: act_bg,
                color: act_title
            }))
           ,
            c.find(".ult_tabcontent").find("div.ult_tabitemname").removeClass("ult_owl-backSlide-in");
            c.find(".ult_tabcontent").find("div.ult_tabitemname").removeClass("ult_owl-backSlide-out");
            c.find(".ult_tabcontent").find("div.ult_tabitemname").removeClass("ult_owl-backSlideright-in");
            c.find(".ult_tabcontent").find("div.ult_tabitemname").removeClass("ult_owl-backSlideright-out");

            c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").fadeOut(200, function() {
               c.find(".ult_tabcontent").find("div.ult_tab_min_contain").addClass("ult_owl-origin");
                    if(j<last){
                   c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").addClass("ult_owl-backSlide-in");
                   c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").removeClass(" ult_owl-backSlide-out");
                   c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + last + ")").addClass("ult_owl-backSlide-out");
                }
                else{
                   c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").addClass("ult_owl-backSlideright-in");
                   c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").removeClass(" ult_owl-backSlideright-out");
                   c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + last + ")").addClass("ult_owl-backSlideright-out");
                }
              i > 0 && m();

           }),

           c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").fadeIn(1500,function(){
                c.find(".ult_tabcontent").find("div.ult_tab_min_contain").removeClass("ult_owl-origin");
                if(j<last){
                    c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + last + ")").removeClass(" ult_owl-backSlide-in");
                    c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").removeClass(" ult_owl-backSlide-out");
                }
                else{
                    c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + last + ")").removeClass(" ult_owl-backSlideright-in");
                    c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").removeClass(" ult_owl-backSlideright-out");

                }
                }), k = j, b.preventDefault();


          }
           else if(anm =='Slide-Horizontal'){
                "style2" == d || "style1" == d ? (l.find("a.ult_a").css({
                background: act_bg,
                color: act_title
            }),l.find(".ult_tab_icon").css({
                color: act_icon
            }) ): (l.find("a.ult_a").css({
                color: act_title
            }), l.css({
                background: act_bg,
                color: act_title
            }))
           ,
           p=c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").hasClass("ult_active_tabnme");
          if(p==false){
                c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").hide(10, function() {
                  jQuery(this).addClass("ult_active_tabnme");
                c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").removeClass("ult_active_tabnme");
                c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").hide(10);

                          if(j>last){
                            jQuery(this).animate({left:"-"+ht_width+"px"},10);
                            //c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + last + ")").animate({left:"-"+ht_width+"px"},10);
                           }else{
                            jQuery(this).animate({left:""+ht_width+"px"},10);
                            //c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + last + ")").animate({left:""+ht_width+"px"},10);

                           }
                            i > 0 && m()
            }), c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").show(100,function(){
                jQuery(this).animate({left:"0px"},800)
              }), k = j,b.preventDefault();

        }else{

            c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").animate({opacity: 1}, 1, function() {
                                        i > 0 && m()
            }), c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").animate({opacity: 1}, 1,function(){
              }), k = j,b.preventDefault();
           }

          }
         else {
              "style2" == d || "style1" == d ? (l.find("a.ult_a").css({
                background: act_bg,
                color: act_title
            }),l.find(".ult_tab_icon").css({
                color: act_icon
            }) ): (l.find("a.ult_a").css({
                color: act_title
            }), l.css({
                background: act_bg,
                color: act_title
            }))
           ,

          c.find(".ult_tabcontent").find("div.ult_tabitemname").not("div.ult_tabitemname:eq(" + j + ")").hide(1, function() {
                i > 0 && m()
            }), c.find(".ult_tabcontent").find("div.ult_tabitemname:eq(" + j + ")").show(10), k = j, b.preventDefault();

          }

        });
        var l = 0;
        i > 0 && m()
    })
});

/*--- for height matching ----*/
jQuery(document).ready(function(a) {


    //for icon color changes on click event
    a(this).find("ul.ult_tabmenu li a.ult_a").click(function(b) {
        //location.hash = '';
        a(document).trigger('ultAdvancedTabClicked', a(this));
         jQuery("html,body").stop();


       a(this).closest("li.ult_tab_li").siblings().each(function(index,value){

            var iconcolor=a(this).data('iconcolor');

           a(this).find(".ult_tab_icon").css({color: iconcolor});

        });

    });

    a(document).on('ultAdvancedTabClicked', function(event, ele){
        if (typeof wpb_prepare_tab_content == 'function') {
          wpb_prepare_tab_content( event, { newPanel: jQuery('.ult_tabcontent') } );
        }
    });
 });

function setmytime(){
    var arr=[];
    var newarr=[];
    var flag=true;
    var styleflag=true;
   //console.log("praj");
   //for link and to tab
    var type = escape( window.location.hash.substr(1) );
    // console.log(type);
   //console.log(jQuery("#"+type).attr('class'));
    if(type!='')
    {
         //console.log($("a[href$='"+type+"']"));
      var maintab=jQuery("a[href$='"+type+"']");
      // console.log(maintab);
      //if(jQuery("#"+type).length > 0)
      //{
         if(maintab.parents(".ult_tabs").length > 0)
         {
              //maintab.parents(".ult_tabs").trigger("click");
              var bgcontain= maintab.parents(".ult_tabs");
              var actbgcolor=bgcontain.data('activebg');
              var normbgcolor=bgcontain.data('titlebg');
              var titlecolor=bgcontain.data('titlecolor');
              var activetitle=bgcontain.data('activetitle');
              var tabsstyle=bgcontain.data('tabsstyle');

              var aciveicon=bgcontain.data('activeicon');
              var iconcolor=bgcontain.find("li.ult_tab_li").data('iconcolor');
              if(aciveicon==''){
              var aciveicon=bgcontain.find("li.ult_tab_li").data('iconhover');
              }

              bgcontain.find("li.ult_tab_li").removeClass("current");
              maintab.parent().addClass("current");
               if(tabsstyle=='style1'||tabsstyle=='style2'){
                bgcontain.find("a.ult_a").css({'background-color':normbgcolor});
                maintab.css({'background-color':actbgcolor});
              }else{
                bgcontain.find("li.ult_tab_li").css({'background-color':normbgcolor});
                maintab.parent().css({'background-color':actbgcolor});
                //maintab.css({'background-color':normbgcolor});
              }
              bgcontain.find("a.ult_a").css({'color':titlecolor});

              maintab.css({'color':activetitle});

              bgcontain.find(".ult_tab_icon").css({'color':iconcolor});
              maintab.find(".ult_tab_icon").css({'color':aciveicon});
              if(tabsstyle=='style3'){

              }else{

              }
               var index=maintab.parent().index()+1;
              bgcontain.find(".ult_tabitemname" ).css({'display':'none'});
              bgcontain.find(".ult_tabitemname:nth-child("+index+")" ).css({'display':'block'});

              var off = bgcontain.offset().top;
              var left = bgcontain.offset().left;
             // console.log(off);
              //jQuery('html,body').animate({ scrollTop: off }, 2000);

              //window.scrollTo(off);

             if(!bgcontain.hasClass('ult_aniamte')){
              jQuery('html, body').animate({
                  scrollTop: bgcontain.offset().top
              }, 1000);
              }
              bgcontain.addClass('ult_aniamte');

              bgcontain.find("ul.ult_tabmenu li a.ult_a").click(function(b) {
                //location.hash = '';
                //alert("hi");
                b.preventDefault();
                  jQuery("html,body").clearQueue();
                 jQuery("html,body").stop();

               });
               //return false;
          }
      //}
    }

    jQuery(".ult_tabs").each(function() {

     //for fullheight
    var fullheight=jQuery(this).data('fullheight');
    //alert(fullheight);
    var mheight=0;
    if(fullheight=='on'){
       jQuery(this).find('.ult_tabitemname').each(function(){
                   if (mheight < jQuery(this).outerHeight()) {
                    mheight = jQuery(this).outerHeight();

                    jQuery(this).parents(".ult_tabcontent").css({"min-height":mheight+"px"});
                }
            });

    }

    var style=jQuery(this).data('tabsstyle');
    var width=jQuery( window ).width();
    var responsemode=jQuery(this).data('respmode');
    var respwidth=jQuery(this).data('respwidth');
    var showboth=jQuery(this).data('responsivemode');
    var animt=jQuery(this).closest('.ult_tabs').data("animation");

    if(animt=='Fade'|| animt =='Scale' || animt=='Slide-Zoom'){
        var cnwidth=jQuery(this).find("div.ult_tabcontent").outerHeight();
        jQuery(this).find('.ult_tabcontent').css({'height':cnwidth});
    }

    if(animt=='Slide-Horizontal'){
     var width=jQuery(this).find('div.ult_tabcontent').outerWidth();

    //jQuery(this).find('.ult_tabitemname').not("div.ult_tabitemname:eq(0)").css({left:"-"+width+"px"});
    jQuery(this).find(".ult_tabcontent").find("div.ult_tabitemname:eq(0)").addClass("ult_active_tabnme");
    }
    if(animt=='Scale'){
        jQuery(this).find('.ult_tabitemname').not("div.ult_tabitemname:eq(0)").addClass("scaleTabname");
        jQuery(this).find(".ult_tabcontent").find("div.ult_tabitemname:eq(0)").addClass("scaleTabname2");
    }
    if(animt=='Slide-Zoom'){
     jQuery(this).closest(".ult_tabs").find("div.ult_tabitemname").removeClass("owl-backSlide-in");
     jQuery(this).closest(".ult_tabs").find("div.ult_tabitemname").removeClass("owl-backSlide-in");
    }

    if(width>=respwidth){
     jQuery(this).parent().find(".ult_acord").css({display:"none"});
     jQuery(this).parent().find(".ult_tabs").css({display:"block"});

    }
    else{
         if(responsemode=='Accordion'){
            jQuery(this).parent().find(".ult_acord").css({display:"block"});
            jQuery(this).parent().find(".ult_tabs").css({display:"none"});
        }
    }

       if(jQuery(this).find('.ult_tabmenu').hasClass('Style_4')){

        }
        var maxheight = 0;
          flag='false';
            jQuery(this).find('.ult_tab_li').each(function(){
                if (maxheight < jQuery(this).outerHeight()) {
                    maxheight = jQuery(this).outerHeight();
                }
            });

        jQuery(this).find('.ult_a').addClass(flag);
        ht1=parseInt(maxheight);
        if(style=='style2'){
        ht1=parseInt(ht1/2);

          if(width>300 && width <660)
            {

                ht1=maxheight/2;


            }
            else{


            }

        }
        else{

                 if(style=='style1'){
                    if(jQuery(this).find('.ult_tabmenu').hasClass("Style_5")){

                    }else{

                    }

                 }
                 else{

                 }




        }
        if(width>300 && width <660)
            {
                 jQuery(this).find('.ult_a ').removeClass("false");
                 newarr.push(ht1);
                 if(showboth!='Both'){
                 if(jQuery(this).find('.aio-icon').hasClass('icon-top')){
                    jQuery(this).find('.aio-icon').removeClass('icon-top').addClass('ult_tab_resp_icon');
                  }
                 if(jQuery(this).find('.ult_tab_main').hasClass('ult_top')){
                    jQuery(this).find('.ult_tab_main').removeClass('ult_top').addClass('ult_tab_resp_ult_top');
                 }
                 }
            }

         if(jQuery(this).find('.ult_a ').hasClass("false")){
             arr.push(ht1);
         }




});


function setht(){
     var width=jQuery( window ).width();
    jQuery(".ult_tabs").each(function() {

    var style=jQuery(this).data('tabsstyle');
    var responsemode=jQuery(this).data('respmode');
    var respwidth=jQuery(this).data('respwidth');
    var showboth=jQuery(this).data('responsivemode');

   // console.log(width);
    if(width>=respwidth){

         jQuery(this).parent().find(".ult_acord").css({display:"none"});
         jQuery(this).parent().find(".ult_tabs").css({display:"block"});
           if(showboth!='Both'){
                     if(jQuery(this).find('.aio-icon').hasClass('ult_tab_resp_icon')){
                       jQuery(this).find('.aio-icon').removeClass('ult_tab_resp_icon').addClass('icon-top');
                     }
                     if(jQuery(this).find('.ult_tab_main').hasClass('ult_tab_resp_ult_top')){
                        jQuery(this).find('.ult_tab_main').removeClass('ult_tab_resp_ult_top').addClass('ult_top');
                       }
                    }

    }
    else{
         if(responsemode=='Accordion'){
        jQuery(this).parent().find(".ult_acord").css({display:"block"});
        jQuery(this).parent().find(".ult_tabs").css({display:"none"});

        }
             if(showboth!='Both'){
                  if(jQuery(this).find('.aio-icon').hasClass('icon-top')){
                    jQuery(this).find('.aio-icon').removeClass('icon-top').addClass('ult_tab_resp_icon');
                  }
                 if(jQuery(this).find('.ult_tab_main').hasClass('ult_top')){
                    jQuery(this).find('.ult_tab_main').removeClass('ult_top').addClass('ult_tab_resp_ult_top');
                 }
             }

    }
    if(width>300 && width <660)
            {
                 jQuery(this).find('.ult_a ').removeClass("false");
                 newarr.push(ht1);
                  if(showboth!='Both'){
                 if(jQuery(this).find('.aio-icon').hasClass('icon-top')){
                    jQuery(this).find('.aio-icon').removeClass('icon-top').addClass('ult_tab_resp_icon');
                  }
                 if(jQuery(this).find('.ult_tab_main').hasClass('ult_top')){
                    jQuery(this).find('.ult_tab_main').removeClass('ult_top').addClass('ult_tab_resp_ult_top');
                 }
               }
            }




});

    }

   jQuery(window).resize(function(e){
        setht();

    });

}






jQuery(document).ready(function(){

    setmytime();

/*--- for smooth fadein effect ------*/
jQuery(this).find("ul.ult_tabmenu li a.ult_a").click(function(b) {

    var animt=jQuery(this).closest('.ult_tabs').data("animation");
      j = jQuery(this).closest("li.ult_tab_li").index();
     if(animt =='Fade' ){
       var cwidth=jQuery(this).closest(".ult_tabs").find("div.ult_tabitemname:eq(" + j + ")").outerHeight();
       jQuery(this).closest(".ult_tabs").find(".ult_tabitemname").css({'position':"absolute","left":"0","right":"0"});
      // jQuery(this).closest(".ult_tabs").find('.ult_tabcontent').css({'height':cwidth});
       jQuery(this).closest(".ult_tabs").find('.ult_tabcontent').animate({'height':cwidth},"slow");


    }

     if(animt =='Slide-Horizontal' ){
       var cwidth=jQuery(this).closest(".ult_tabs").find("div.ult_tabitemname:eq(" + j + ")").outerHeight();
       jQuery(this).closest(".ult_tabs").find(".ult_tabcontent").css({"overflow":"hidden"});
       jQuery(this).closest(".ult_tabs").find('.ult_tabcontent').animate({'height':cwidth},"slow");

    }

    if(animt =='Slide'){

    }
});



});

jQuery(document).ready(function(){
 /*--- for advancedcarousal ------*/


jQuery(this).find("ul.ult_tabmenu li a.ult_a").click(function(b) {


       if(jQuery(".slick-slider").parents('.ult_tabitemname').length){
                setTimeout(function(){

                        jQuery('.slick-slider').slick('setPosition');
                        jQuery(window).trigger('resize');
                    },200);
           }else{

           }
    });

//for toggle
if(jQuery(".vc_toggle").parents('.ult_tabs')){

          jQuery( ".vc_toggle" ).click(function() {
          var prev_ht= jQuery(this).parents(".ult_tabitemname").height();
         // alert(prev_ht);
           jQuery(this).find(".vc_toggle_content").toggleClass("vc_toggle_for_tab");

            if(jQuery(this).find(".vc_toggle_content").hasClass("vc_toggle_for_tab")){
                setTimeout(function(){
                     var tab_ht= jQuery(".ult_tabitemname").height();
                   jQuery('.ult_tabcontent').animate({'height':tab_ht},100);

                },100);
             }else{

                setTimeout(function(){

                    var tab_ht= jQuery(".vc_toggle").parents('.ult_tabitemname').height();
                   jQuery('.ult_tabcontent').animate({'height':tab_ht},100);

                },200);
             }

        });
    }




    });