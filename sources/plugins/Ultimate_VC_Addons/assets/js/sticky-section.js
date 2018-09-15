//(function ($) {
jQuery(document).ready(function($){

var _window = $(window);
var _windowsize = _window.width();
var resize_flag = -1;
var top_for_row = 0;

inside_row_();
sticky_relocate();
  
_window.resize(function() {
  resize_flag = 0;
  _windowsize = _window.width();
    sticky_relocate();
    //inside_row_();
});

_window.bind('scroll', function() {
    sticky_relocate();
});

function inside_row_(){

  var row_elements = $('div.ult-sticky-anchor');

    row_elements.each(function(){


      var $this = $(this);
      var ult_row_spacer = $this.closest('.ult_row_spacer');
      var ult_sticky = $this.find('.ult-sticky');
      var stick_behaviour = ult_sticky.data('stick_behaviour');
      var support = ult_sticky.data('support');

      if ( stick_behaviour != 'stick_with_scroll_row' && support == 'no' ){
        return;
      }

      /*var fullwidth_row = false; //for Browser full width row
      
      if ( $this.parents('.upb-background-text').length ){ // has parent
        fullwidth_row = true;
      }*/
      var global_height = 0; //for resize
      var gutter = ult_sticky.data('gutter');
      
      var gutter_class = ult_sticky.data('sticky_gutter_class');
      var gutter_id = ult_sticky.data('sticky_gutter_id');
      var mobile = ult_sticky.data('mobile');
      //if ( stick_behaviour == 'stick_with_scroll_row' ) {

        gutter = ult_explode_offset( global_height, gutter, gutter_class, gutter_id );
        var parent = $this.closest(".wpb_column").closest('.vc_row');//parent();//$this.closest('.vc_row');

        var self_offset = $this.parent().offset().top;
        //alert(parent_offset);
        $this.addClass("ult_stick_to_row");
        
        parent.addClass("ult_s_container");
        //alert(parent);
        //alert(mobile);
        if (support == 'yes') {
          parent = 'body';
        }
        if( _windowsize < 768 && mobile == 'no'){
          return;
        }else{
            $this.fixTo(parent, {
            //className : 'is-stuck',
            //zIndex: 10,
            top: gutter,
            useNativeSticky: false
          });

       }
        
    });

}

/***** inside row ******/
/*function inside_row () {
    var row_elements = $('div.ult-sticky-anchor');

    row_elements.each(function(){


      var $this = $(this);
      var ult_row_spacer = $this.closest('.ult_row_spacer');
      var ult_sticky = $this.find('.ult-sticky');
      var stick_behaviour = ult_sticky.data('stick_behaviour');

      if ( stick_behaviour != 'stick_with_scroll_row' ){
        return;
      }

      var fullwidth_row = false; //for Browser full width row
      
      if ( $this.parents('.upb-background-text').length ){ // has parent
        fullwidth_row = true;
      }
      var global_height = 0; //for resize
      var gutter = ult_sticky.data('gutter');
      
      var gutter_class = ult_sticky.data('sticky_gutter_class');
      var gutter_id = ult_sticky.data('sticky_gutter_id');
      var mobile = ult_sticky.data('mobile');
      //if ( stick_behaviour == 'stick_with_scroll_row' ) {

        gutter = ult_explode_offset( global_height, gutter, gutter_class, gutter_id );
        var parent = $this.closest(".wpb_column").parent();//$this.closest('.vc_row');

        var self_offset = $this.parent().offset().top;
        //alert(parent_offset);
        $this.addClass("ult_stick_to_row");
        
        parent.addClass("ult_s_container");
        //alert(parent);
        //alert(mobile);
        if( _windowsize < 768 && mobile == 'no'){
          $this.trigger("sticky_kit:detach")
          return;
        }else{
          $this.trigger("sticky_kit:recalc")

          $this.stick_in_parent({parent:".ult_s_container", offset_top:gutter, spacer: ult_row_spacer})
            .on("sticky_kit:stick", function(e) {
              //console.log("has stuck!", e.target);
              //console.log( $(e.target).closest(".wpb_column").parent().css("display", "flex") );
              $(e.target).css("top", "0");
              //console.log($(e.target).offset().top);
              $(e.target).closest(".wpb_column").parent().css("display", "flex");
            })
            .on("sticky_kit:unstick", function(e) {
              //console.log("has unstuck!", e.target);
              //$(e.target).closest(".vc_row").css("display", "")

              $(e.target).closest(".wpb_column").parent().css("display", "")
            })
            .on("sticky_kit:bottom", function(e) {
              //console.log("has stuck!", e.target);
              $(e.target).addClass("is_bottom");
              $(e.target).css("bottom","");
              // var s = $(window).scrollTop();
              // var y = $(e.target).parent().offset().top;
              // var z = s-y+50;
              $(e.target).css('top', top_for_row + 'px');

            })
            .on("sticky_kit:unbottom", function(e) {
              //console.log("has unstuck!", e.target);
              $(e.target).removeClass("is_bottom");

            });
       }
    });
}*/

/****** inside row end *******/
 

  function sticky_relocate() {

    
    elements = $('div.ult-sticky-anchor');

    elements.each(function() { 

      var $this = $(this);
      var ult_sticky = $this.find('.ult-sticky');
      //var fullwidth_row = false; //for Browser full width row
      
      // if ( $this.parents('.upb-background-text').length ){ // has parent
      //   fullwidth_row = true;
      // }
      
      var mobile = ult_sticky.data('mobile');
      var ult_space = $this.find('.ult-space');
      if ( _windowsize < 768 && mobile == 'no' ){
        ult_sticky.removeClass("ult-stick");
        ult_space.css('height', '')
        $this.removeClass('ult-permanent-flag');
        return;
      }

      var window_top = _window.scrollTop();
      var div_top = $this.offset().top;
      var win_height = _window.height();
      var stick_behaviour = ult_sticky.data('stick_behaviour');
      var support = ult_sticky.data('support');

      // if( fullwidth_row = true && $this.hasClass( "is_stuck" ) ){
      //   var s = _window.scrollTop();
      //   var parent_height = $this.closest(".wpb_column").parent().parent().innerHeight();
      //   var parent_offset = $this.closest(".wpb_column").parent().parent().offset().top;
      //   var parent_offset_height = parseInt(parent_offset) + parseInt(parent_height);
      //   var y = $this.parent().offset().top;
      //   var z = s-y+50;
      //   var anchor_height = s + 50 + $this.outerHeight();

      //   console.log(parent_offset);
      //   console.log(window_top);
        
      //   if( anchor_height < parent_offset_height  ){
      //     top_for_row = z;
      //     $this.css('position','absolute');
      //     $this.css('top',z + 'px');
      //   }
      //   return;
      // }
      if( stick_behaviour == 'stick_with_scroll_row' || support == 'yes'){
        return;
      }

      var div_width = $this.parent().width();
      var div_height = ult_sticky.height();//$(this).parents(".vc_row").height();
      
      var global_height = 0; //for resize
      var gutter = ult_sticky.data('gutter');
      
      var gutter_class = ult_sticky.data('sticky_gutter_class');
      var gutter_id = ult_sticky.data('sticky_gutter_id');

      var lr_position = ult_sticky.data('lr_position');
      var lr_value = ult_sticky.data('lr_value');

      var sticky_customwidth = ult_sticky.data('sticky_customwidth');
      var sticky_width = ult_sticky.data('sticky_width');
      var sticky_position = ult_sticky.data('sticky_position');
      var flag = -1; //for bottom position
      //var sticky_element = $(this).find('ult-sticky');
      
      
      gutter = ult_explode_offset( global_height, gutter, gutter_class, gutter_id );

      if( sticky_position == 'top'){
        window_top = parseInt(window_top) + parseInt(gutter);
      }else{
        window_top = parseInt(window_top)+ parseInt(win_height)-parseInt(div_height)-parseInt(gutter);
        div_top = parseInt(div_top); //+ parseInt(div_height);
        
      }

      if(sticky_width == 'fullwidth' ){
        div_width = '100%';
      }else if( sticky_width == 'customwidth' ) {
        div_width = sticky_customwidth ;
      }
      


      var custom_css = {};
      var div_width_pro = 'width';

      custom_css[sticky_position] = gutter;
      custom_css[div_width_pro] = div_width;
      // for permanent
      if ( stick_behaviour == 'stick_permanent') {
        custom_css[lr_position] = lr_value;
      }

      
      var custom_css_t = {};
      custom_css_t[sticky_position] = "";
      custom_css_t[div_width_pro] = "";

     if ( stick_behaviour == 'stick_permanent' && !$this.hasClass('ult-permanent-flag') ) {
        $this.addClass('ult-permanent-flag');
        ult_sticky.addClass('ult-stick').css(custom_css);
        //$this.parents('.wpb_column').css('min-height', '0px');
      }
      //alert(stick_behaviour);

      if ( stick_behaviour == 'stick_with_scroll' && window_top > div_top ) {
        //alert(resize_flag);
        flag=0;
        if( !$this.hasClass('ult-flag') || resize_flag == 0){
          $this.addClass('ult-flag');
          //resize_flag = -1;
         
          if ( sticky_width == 'fullwidth' ) {
           
            ult_sticky.addClass('ult-stick-full-width').css(custom_css);
            //div_height = $(this).find('.ult-sticky').height();

              $this.find('.ult-space').css('height', div_height);
              flag=1;  
          }else{

            ult_sticky.addClass('ult-stick').css(custom_css);
            //div_height = $(this).find('.ult-sticky').height();

               $this.find('.ult-space').css('height', div_height);
               flag=1; 
          } // checked fullwidth end else
        } //checked ult flag end if
      } else if( stick_behaviour == 'stick_with_scroll' ) {
        if( $this.hasClass('ult-flag') ){
          $this.removeClass('ult-flag');

          if ( sticky_width == 'fullwidth' ) {
            ult_sticky.removeClass('ult-stick-full-width').css( custom_css_t );
            
               $this.find('.ult-space').css('height', ''); 
          }else{
            ult_sticky.removeClass('ult-stick').css( custom_css_t );
            
               $this.find('.ult-space').css('height', ''); 
          }
        }//checked ult flag if end
      }// scroll top else end

      /* if( sticky_position == 'bottom' && flag != 1 && !$this.hasClass('ult-permanent-flag') )
          {
            //var scroll_flag = -1;
            var temp_top = "";
            if( window_top > div_top) { 
              //scroll_flag = 0;
              temp_top = window_top-div_top; 
            } else { 
             // alert();
              temp_top = 0;
            }
            if( window_top > div_top ) { div_height = ult_sticky.height(); }
            else { div_height = $this.find('.ult-space').height();}


            if( div_height - temp_top <= 0 ){
              div_height = 0;
            } else{
              div_height = div_height - temp_top;
            }
            
            $this.find('.ult-space').css('height', div_height);
          }*/
    });
    resize_flag = -1;
  }
  
  function ult_explode_offset (global_height, gutter, gutter_class, gutter_id ) {
     // gutter class and id height calculate
      if( !gutter_class ){
        gutter_class = 'null';
      }
      else{
        var gutter_class_arr = gutter_class.split(' ');
        jQuery.each( gutter_class_arr, function( i, val ) {
          global_height = parseInt(global_height) + $( val ).outerHeight();
 
        });
      }

      if( !gutter_id ){
        gutter_id = 'null';
      }
      else{
        var gutter_id_arr = gutter_id.split(' ');
        jQuery.each( gutter_id_arr, function( i, val ) {
          global_height = parseInt(global_height) + $( val ).outerHeight();
 
        });
      }

      if ( !gutter ){
        gutter = global_height;
      }else{
        gutter = parseInt(gutter) + parseInt(global_height)
      }

      return gutter;
  }
  

  //$(window).scroll(sticky_relocate);
  //sticky_relocate();
});

//})(jQuery);