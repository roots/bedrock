jQuery(document).ready(function(a) {
    a(".cq-accordion").each(function() {
        a(this), a(this).find("li").each(function() {
            a(this).find("i").css("margin-top", .5 * (a(this).outerHeight() - 9))
        })
    }), a(".ult-tabto-accordion").each(function() {
        a(this);

        var c = a(this).data("titlebg"),
            d = a(this).data("titlecolor"),
            e = a(this).data("titlehoverbg"),
            f = a(this).data("titlehovercolor");
            var  act_title = a(this).data("activetitle"),
            act_icon = a(this).data("activeicon"),
            scroll_type = a(this).data("scroll"),
            act_bg = a(this).data("activebg");
            if(act_icon==''){
               var act_icon=a(this).find('.aio-icon').data('iconhover');
            }


        a(this).find(".ult-tabto-actitle").each(function() {
            var iconcolor=a(this).find('.aio-icon').data('iconcolor');
            var iconhover=a(this).find('.aio-icon').data('iconhover');

            a(this).css("background-color", c).on("mouseover", function() {
                if(a(this).hasClass('ult-tabto-actitleActive')){

                   }
                   else{
                    a(this).css({
                    "background-color": e,
                    color: f
                      }),
                      a(this).find('.aio-icon').css({
                          color: iconhover
                      })
                    }

            }).on("mouseleave", function() {
                a(this).hasClass("ult-tabto-actitleActive") || a(this).css({
                    "background-color": c,
                    color: d
                });
                var flag=a(this).hasClass("ult-tabto-actitleActive");

                if(flag==true){

                }
                else{
                   a(this).find('.aio-icon').css({
                    color: iconcolor
                });
                }

            });

        }), a(this).on("click", function(b) {
            var c;

              if (c = a(b.target).is("i") ? a(b.target).parent() : a(b.target), c.hasClass("ult-tabto-actitle")) {
                var d = c.parent().next();
               //console.log('1');
                var animation=c.parents('.ult-tabto-accordion').data('animation');
               // console.log(d);

               if(d.nextAll('dd').hasClass("cq-animateIn")){
                   d.nextAll('dd').removeClass("cq-animateIn").addClass(" cq-animateOut ult-tabto-accolapsed");

                }
                if(d.prevAll('dd').hasClass("cq-animateIn")){
                   d.prevAll('dd').removeClass("cq-animateIn").addClass("ult-tabto-accolapsed");
                }

                if(d.nextAll('dd').hasClass("ult-ac-slidedown")){
                   d.nextAll('dd').removeClass("ult-ac-slidedown").addClass(" ult-ac-slideup ult-tabto-accolapsed");

                }
                if(d.prevAll('dd').hasClass("ult-ac-slidedown")){
                   d.prevAll('dd').removeClass("ult-ac-slidedown").addClass("ult-tabto-accolapsed");
                }


                 if(d.prevAll('dt').find('.ult-tabto-actitle').hasClass("ult-tabto-actitleActive")){
                 d.prevAll('dt').find('.ult-tabto-actitle').removeClass("ult-tabto-actitleActive").addClass("ult-acc-normal");
                 }
                 if(d.nextAll('dt').find('.ult-tabto-actitle').hasClass("ult-tabto-actitleActive")){
                  d.nextAll('dt').find('.ult-tabto-actitle').removeClass("ult-tabto-actitleActive").addClass("ult-acc-normal");
                 }


                c.removeClass('ult-acc-normal');
                jQuery(this).find(".ult-acc-normal").each(function() {
                   var icn=jQuery(this).find('.aio-icon').data('iconcolor');
                   var ich=jQuery(this).find('.aio-icon').data('iconhover');
                   var bgcolor=jQuery(this).parents('.ult-tabto-accordion').data("titlebg");
                   var titlecolor = jQuery(this).parents('.ult-tabto-accordion').data("titlecolor");
                   jQuery(this).css({background: bgcolor,color:titlecolor});
                   jQuery(this).find('.aio-icon').css({color: icn});

                });


                c.css({
                    color: act_title,
                    "background-color": act_bg,
                });
                c.find('.aio-icon').css({
                    color: act_icon

                });

               var iconcolor=c.find('.aio-icon').data('iconcolor');
               var iconhover=c.find('.aio-icon').data('iconhover');


                 if(animation=='Fade'){
                   c.toggleClass("ult-tabto-actitleActive"), d.hasClass("ult-tabto-accolapsed") ? (d.hasClass("cq-animateOut") && d.removeClass("cq-animateOut"), d.addClass("cq-animateIn")) : (d.removeClass("cq-animateIn"), d.addClass("cq-animateOut")), d.toggleClass("ult-tabto-accolapsed"), b.preventDefault();

                 }
                 else{
                    c.toggleClass("ult-tabto-actitleActive"), d.hasClass("ult-tabto-accolapsed") ? (d.hasClass("ult-ac-slideup") && d.removeClass("ult-ac-slideup"), d.addClass("ult-ac-slidedown")) : (d.removeClass("ult-ac-slidedown"), d.addClass("ult-ac-slideup")), d.toggleClass("ult-tabto-accolapsed"), b.preventDefault();

                }

            if( d.hasClass("ult-tabto-accolapsed")){
                c.removeClass("ult-tabto-actitleActive")
             }


            }
            else if (c = a(b.target).is("span.ult-span-text.ult_acordian-text") ? a(b.target).parent().parent() : a(b.target), c.hasClass("ult-tabto-actitle")) {
                var d = c.parent().next();
                var animation=c.parents('.ult-tabto-accordion').data('animation');
              //console.log('2');
                   if(d.nextAll('dd').hasClass("cq-animateIn")){
                   d.nextAll('dd').removeClass("cq-animateIn").addClass(" ult-ac-slideup ult-tabto-accolapsed");

                }

                 if(d.prevAll('dd').hasClass("cq-animateIn")){
                   d.prevAll('dd').removeClass("cq-animateIn").addClass("ult-tabto-accolapsed");
                }

                if(d.nextAll('dd').hasClass("ult-ac-slidedown")){
                   d.nextAll('dd').removeClass("ult-ac-slidedown").addClass(" ult-ac-slideup ult-tabto-accolapsed");

                }
                if(d.prevAll('dd').hasClass("ult-ac-slidedown")){
                   d.prevAll('dd').removeClass("ult-ac-slidedown").addClass("ult-tabto-accolapsed");
                }

                 if(d.prevAll('dt').find('.ult-tabto-actitle').hasClass("ult-tabto-actitleActive")){
                 d.prevAll('dt').find('.ult-tabto-actitle').removeClass("ult-tabto-actitleActive").addClass("ult-acc-normal");
                 }
                 if(d.nextAll('dt').find('.ult-tabto-actitle').hasClass("ult-tabto-actitleActive")){
                  d.nextAll('dt').find('.ult-tabto-actitle').removeClass("ult-tabto-actitleActive").addClass("ult-acc-normal");
                 }


                c.removeClass('ult-acc-normal');
                jQuery(this).find(".ult-acc-normal").each(function() {
                   var icn=jQuery(this).find('.aio-icon').data('iconcolor');
                   var ich=jQuery(this).find('.aio-icon').data('iconhover');
                   var bgcolor=jQuery(this).parents('.ult-tabto-accordion').data("titlebg");
                   var titlecolor = jQuery(this).parents('.ult-tabto-accordion').data("titlecolor");
                   jQuery(this).css({background: bgcolor,color:titlecolor});
                   jQuery(this).find('.aio-icon').css({color: icn});

                });


                 var iconcolor=c.find('.aio-icon').data('iconcolor');
                 var iconhover=c.find('.aio-icon').data('iconhover');

                 c.css({
                    color: act_title,
                    "background-color": act_bg,
                });
                c.find('.aio-icon').css({
                    color: act_icon

                });

                 if(animation=='Fade'){
                   c.toggleClass("ult-tabto-actitleActive"), d.hasClass("ult-tabto-accolapsed") ? (d.hasClass("cq-animateOut") && d.removeClass("cq-animateOut"), d.addClass("cq-animateIn")) : (d.removeClass("cq-animateIn"), d.addClass("cq-animateOut")), d.toggleClass("ult-tabto-accolapsed"), b.preventDefault();
                 }
                 else{
                 c.toggleClass("ult-tabto-actitleActive"), d.hasClass("ult-tabto-accolapsed") ? (d.hasClass("ult-ac-slideup") && d.removeClass("ult-ac-slideup"), d.addClass("ult-ac-slidedown")) : (d.removeClass("ult-ac-slidedown"), d.addClass("ult-ac-slideup")), d.toggleClass("ult-tabto-accolapsed"), b.preventDefault();
                }

                 if( d.hasClass("ult-tabto-accolapsed")){
                c.removeClass("ult-tabto-actitleActive")
                }

            }
            else if (c = a(b.target).is("i") ? a(b.target).parent().parent() : a(b.target), c.hasClass("ult-tabto-actitle")) {
                var d = c.parent().next();
                var animation=c.parents('.ult-tabto-accordion').data('animation');
                console.log('3');
                    if( d.nextAll('dd').hasClass("cq-animateIn")){
                   d.nextAll('dd').removeClass("cq-animateIn").addClass(" cq-animateOut ult-tabto-accolapsed");

                }

                 if(d.prevAll('dd').hasClass("cq-animateIn")){
                   d.prevAll('dd').removeClass("cq-animateIn").addClass("ult-tabto-accolapsed");
                }

                if(d.nextAll('dd').hasClass("ult-ac-slidedown")){
                   d.nextAll('dd').removeClass("ult-ac-slidedown").addClass(" ult-ac-slideup ult-tabto-accolapsed");

                }
                if(d.prevAll('dd').hasClass("ult-ac-slidedown")){
                   d.prevAll('dd').removeClass("ult-ac-slidedown").addClass("ult-tabto-accolapsed");
                }

                 if(d.prevAll('dt').find('.ult-tabto-actitle').hasClass("ult-tabto-actitleActive")){
                 d.prevAll('dt').find('.ult-tabto-actitle').removeClass("ult-tabto-actitleActive").addClass("ult-acc-normal");
                 }
                 if(d.nextAll('dt').find('.ult-tabto-actitle').hasClass("ult-tabto-actitleActive")){
                  d.nextAll('dt').find('.ult-tabto-actitle').removeClass("ult-tabto-actitleActive").addClass("ult-acc-normal");
                 }


                c.removeClass('ult-acc-normal');
                jQuery(this).find(".ult-acc-normal").each(function() {
                   var icn=jQuery(this).find('.aio-icon').data('iconcolor');
                   var ich=jQuery(this).find('.aio-icon').data('iconhover');
                   var bgcolor=jQuery(this).parents('.ult-tabto-accordion').data("titlebg");
                   var titlecolor = jQuery(this).parents('.ult-tabto-accordion').data("titlecolor");
                   jQuery(this).css({background: bgcolor,color:titlecolor});
                   jQuery(this).find('.aio-icon').css({color: icn});

                });

                 var iconcolor=c.find('.aio-icon').data('iconcolor');
                 var iconhover=c.find('.aio-icon').data('iconhover');

                c.css({
                    color: act_title,
                    "background-color": act_bg,
                });
                c.find('.aio-icon').css({
                    color: act_icon

                });


                if(animation=='Fade'){
                   c.toggleClass("ult-tabto-actitleActive"), d.hasClass("ult-tabto-accolapsed") ? (d.hasClass("cq-animateOut") && d.removeClass("cq-animateOut"), d.addClass("cq-animateIn")) : (d.removeClass("cq-animateIn"), d.addClass("cq-animateOut")), d.toggleClass("ult-tabto-accolapsed"), b.preventDefault();
                 }
                 else{
                 c.toggleClass("ult-tabto-actitleActive"), d.hasClass("ult-tabto-accolapsed") ? (d.hasClass("ult-ac-slideup") && d.removeClass("ult-ac-slideup"), d.addClass("ult-ac-slidedown")) : (d.removeClass("ult-ac-slidedown"), d.addClass("ult-ac-slideup")), d.toggleClass("ult-tabto-accolapsed"), b.preventDefault();
                }

                 if( d.hasClass("ult-tabto-accolapsed")){
                c.removeClass("ult-tabto-actitleActive")
                }


            }

              else if (c = a(b.target).is("i") ? a(b.target).parent().parent().parent() : a(b.target), c.hasClass("ult-tabto-actitle")) {
                var d = c.parent().next();
                var animation=c.parents('.ult-tabto-accordion').data('animation');
                console.log('4');
                if( d.nextAll('dd').hasClass("cq-animateIn")){
                   d.nextAll('dd').removeClass("cq-animateIn").addClass(" cq-animateOut ult-tabto-accolapsed");

                }

                if(d.prevAll('dd').hasClass("cq-animateIn")){
                   d.prevAll('dd').removeClass("cq-animateIn").addClass("ult-tabto-accolapsed");
                }

                if(d.nextAll('dd').hasClass("ult-ac-slidedown")){
                   d.nextAll('dd').removeClass("ult-ac-slidedown").addClass(" ult-ac-slideup ult-tabto-accolapsed");

                }
                if(d.prevAll('dd').hasClass("ult-ac-slidedown")){
                   d.prevAll('dd').removeClass("ult-ac-slidedown").addClass("ult-tabto-accolapsed");
                }

                 if(d.prevAll('dt').find('.ult-tabto-actitle').hasClass("ult-tabto-actitleActive")){
                 d.prevAll('dt').find('.ult-tabto-actitle').removeClass("ult-tabto-actitleActive").addClass("ult-acc-normal");
                 }
                 if(d.nextAll('dt').find('.ult-tabto-actitle').hasClass("ult-tabto-actitleActive")){
                  d.nextAll('dt').find('.ult-tabto-actitle').removeClass("ult-tabto-actitleActive").addClass("ult-acc-normal");
                 }


                c.removeClass('ult-acc-normal');
                jQuery(this).find(".ult-acc-normal").each(function() {
                   var icn=jQuery(this).find('.aio-icon').data('iconcolor');
                   var ich=jQuery(this).find('.aio-icon').data('iconhover');
                   var bgcolor=jQuery(this).parents('.ult-tabto-accordion').data("titlebg");
                   var titlecolor = jQuery(this).parents('.ult-tabto-accordion').data("titlecolor");
                   jQuery(this).css({background: bgcolor,color:titlecolor});
                   jQuery(this).find('.aio-icon').css({color: icn});

                });

                 var iconcolor=c.find('.aio-icon').data('iconcolor');
                 var iconhover=c.find('.aio-icon').data('iconhover');

                c.css({
                    color: act_title,
                    "background-color": act_bg,
                });
                c.find('.aio-icon').css({
                    color: act_icon

                });


                if(animation=='Fade'){
                   c.toggleClass("ult-tabto-actitleActive"), d.hasClass("ult-tabto-accolapsed") ? (d.hasClass("cq-animateOut") && d.removeClass("cq-animateOut"), d.addClass("cq-animateIn")) : (d.removeClass("cq-animateIn"), d.addClass("cq-animateOut")), d.toggleClass("ult-tabto-accolapsed"), b.preventDefault();
                 }
                 else{
                 c.toggleClass("ult-tabto-actitleActive"), d.hasClass("ult-tabto-accolapsed") ? (d.hasClass("ult-ac-slideup") && d.removeClass("ult-ac-slideup"), d.addClass("ult-ac-slidedown")) : (d.removeClass("ult-ac-slidedown"), d.addClass("ult-ac-slideup")), d.toggleClass("ult-tabto-accolapsed"), b.preventDefault();
                }

                 if( d.hasClass("ult-tabto-accolapsed")){
                c.removeClass("ult-tabto-actitleActive")
                }


            }
            
            if(scroll_type=='on'){
              jQuery('html, body').animate({
                scrollTop: a(this).offset().top-100
              }, 1200);
            }
        })
    })
});