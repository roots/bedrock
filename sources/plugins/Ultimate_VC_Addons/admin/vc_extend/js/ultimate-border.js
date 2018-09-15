/* Transparent - Color Picker */
!function(r,a,e,o){"use strict";typeof Color.fn.toString!==o&&(Color.fn.toString=function(){if(this._alpha<1)return this.toCSS("rgba",this._alpha).replace(/\s+/g,"");var r=parseInt(this._color,10).toString(16);if(this.error)return"";if(r.length<6)for(var a=6-r.length-1;a>=0;a--)r="0"+r;return"#"+r}),r.cs_ParseColorValue=function(r){var a=r.replace(/\s+/g,""),e=-1!==a.indexOf("rgba")?parseFloat(100*a.replace(/^.*,(.+)\)/,"$1")):100,o=100>e?!0:!1;return{value:a,alpha:e,rgba:o}},r.fn.cs_wpColorPicker=function(){return this.each(function(){var a=r(this);if(a.data("rgba")!==!1){var e=r.cs_ParseColorValue(a.val());a.wpColorPicker({clear:function(){a.trigger("keyup")},change:function(r,e){var o=e.color.toString();a.closest(".wp-picker-container").find(".cs-alpha-slider-offset").css("background-color",o),a.val(o).trigger("change")},create:function(){var o=a.data("a8cIris"),c=a.closest(".wp-picker-container"),l=r('<div class="cs-alpha-wrap"><div class="cs-alpha-slider"></div><div class="cs-alpha-slider-offset"></div><div class="cs-alpha-text"></div></div>').appendTo(c.find(".wp-picker-holder")),i=l.find(".cs-alpha-slider"),t=l.find(".cs-alpha-text"),n=l.find(".cs-alpha-slider-offset");i.slider({slide:function(r,e){var c=parseFloat(e.value/100);o._color._alpha=c,a.wpColorPicker("color",o._color.toString()),t.text(1>c?c:"")},create:function(){var s=parseFloat(e.alpha/100),p=1>s?s:"";t.text(p),n.css("background-color",e.value),c.on("click",".wp-picker-clear",function(){o._color._alpha=1,t.text(""),i.slider("option","value",100).trigger("slide")}),c.on("click",".wp-picker-default",function(){var e=r.cs_ParseColorValue(a.data("default-color")),c=parseFloat(e.alpha/100),l=1>c?c:"";o._color._alpha=c,t.text(l),i.slider("option","value",e.alpha).trigger("slide")}),c.on("click",".wp-color-result",function(){l.toggle()}),r("body").on("click.wpcolorpicker",function(){l.hide()})},value:e.alpha,step:1,min:1,max:100})}})}else a.wpColorPicker({clear:function(){a.trigger("keyup")},change:function(r,e){a.val(e.color.toString()).trigger("change")}})})},r(e).ready(function(){r(".cs-wp-color-picker").cs_wpColorPicker()})}(jQuery,window,document);

/*  Get alpha values   */
;(function ( $, window, undefined ) {
  $.cs_ParseColorValue = function( val ) {
    var value = val.replace(/\s+/g, ''),
        alpha = ( value.indexOf('rgba') !== -1 ) ? parseFloat( value.replace(/^.*,(.+)\)/, '$1') * 100 ) : 100,
        rgba  = ( alpha < 100 ) ? true : false;
    return { value: value, alpha: alpha, rgba: rgba };
  };
}(jQuery, window));

/* Ultimate Border - Param  */
;(function ( $, window, undefined ) {

  function update_visibility(t) {
    var status = t.find(".ultimate-border-style-selector option:selected").val() || 'none';     // set data status
    if( status === 'none' ) {
      t.find('.ultimate-four-input-section, .ultimate-border-radius-block, .ultimate-colorpicker-section').hide();
    } else {
      t.find('.ultimate-four-input-section, .ultimate-border-radius-block, .ultimate-colorpicker-section').show();
    }
  }

  //  Enable chosen
  if(typeof $.fn.chosen !== 'undefined') {
	  $('.ultimate-border-style-selector').chosen({
		  allow_single_deselect: true,
		  width: "100%"
	  });
  }

  $(".ultimate-border").each(function(index, element) {
    var t = $(element);
      init(t);
      get_hidden_with_border_style(t);
      //set_hidden_with_border_style(t);
  });
  function init(t) {
    //  Hide {all}
    t.find('.ultb-width-all, .ultb-radius-all').attr('data-status', 'hide-all');
    t.find('.ultb-width-single, .ultb-radius-single').hide();
    t.find('.ultb-width-section .ult-expand, .ultb-radius-section .ult-expand').addClass('ult-collapse');

    //  border-width
    t.find('.ultb-width-section .ult-expand').click(function(event) {
      t.find('.ultb-width-all, .ultb-width-single').toggle();

      //  UPDATE STATUS
      var status = t.find('.ultb-width-all').attr('data-status') || 'hide-me';
      if( status === 'hide-me' ) {
        t.find('.ultb-width-section .ult-expand').addClass('ult-collapse');
        t.find('.ultb-width-all').attr('data-status', 'hide-all');
      } else {
        t.find('.ultb-width-section .ult-expand').removeClass('ult-collapse');
        t.find('.ultb-width-all').attr('data-status', 'hide-me');
      }
      set_hidden_with_border_style(t);
    });


    //  border-radius
    t.find('.ultb-radius-section .ult-expand').click(function(event) {
      t.find('.ultb-radius-all, .ultb-radius-single').toggle();

      //  UPDATE STATUS
      var status = t.find('.ultb-radius-all').attr('data-status') || 'hide-me';
      if( status === 'hide-me' ) {
        t.find('.ultb-radius-section .ult-expand').addClass('ult-collapse');
        t.find('.ultb-radius-all').attr('data-status', 'hide-all');
      } else {
        t.find('.ultb-radius-section .ult-expand').removeClass('ult-collapse');
        t.find('.ultb-radius-all').attr('data-status', 'hide-me');
      }
      set_hidden_with_border_style(t);
    });

    //  unit change
    t.find('.ult-unit-border-width, .ult-unit-border-radius').change(function(event) {
      set_hidden_with_border_style(t);
    });
    
    //  Clear the color
    t.find('.wp-picker-clear').click(function(event) {
      var hxcolor = 'transparent';
      set_hidden_with_border_style(t, hxcolor);
    });

    /* = Color Picker  
     ----------------------------------------*/
    t.find(".ultimate-colorpicker").wpColorPicker();
  }

  function get_hidden_with_border_style(t) {
      var l = t.find(".ultimate-border-style-selector").length;
      var mv = t.find(".ultimate-border-value").val();

      if (mv != "") {
        if(l) {
          var vals = mv.split("|");
            // set border style 
            var splitval = vals[0].split(":");
            var bstyle = splitval[1].split(";");
            t.find(".ultimate-border-style-selector").val(bstyle[0]);
            t.find(".ultimate-border-style-selector").trigger("chosen:updated");
            
            // Disable inputs if border-style - {none}
            if(typeof bstyle[0] != 'undefined' && bstyle[0] != null) {
              if(bstyle[0]==='none') {
                update_visibility(t);
              }
            }

            //  set border widths
            var bw = vals[1].split(";");
        }

        $.each(bw, function(i, vl) {
            if (vl != "") {
                t.find(".ultimate-border-inputs").each(function(input_index, elem) {
                  var splitval = vl.split(":");
                  var dataid = $(elem).attr("data-id");

                  if( typeof splitval[0] != 'undefined' && splitval[0] != null ) {

                    //  Collapse / Expand - {border width}
                    /*if( splitval[0] === 'border-width') {
                    }*/

                    //  Collapse / Expand - {border radius}
                    /*if( splitval[0] === 'border-radius') {
                    }*/

                    switch(splitval[0]) {
                      case 'border-width':
                                            t.find('.ultb-width-all').show();
                                            t.find('.ultb-width-all').attr('data-status', 'hide-all');
                                            t.find('.ultb-width-single').hide();
                                            t.find('.ultb-width-section .ult-expand').addClass('ult-collapse');
                                    break;

                      case 'border-top-width':
                      case 'border-right-width':
                      case 'border-bottom-width':
                      case 'border-left-width':
                                            t.find('.ultb-width-all').hide();
                                            t.find('.ultb-width-all').attr('data-status', 'hide-me');
                                            t.find('.ultb-width-single').show();
                                            t.find('.ultb-width-section .ult-expand').removeClass('ult-collapse');
                        break;

                      case 'border-radius':
                                            t.find('.ultb-radius-all').show();
                                            t.find('.ultb-radius-all').attr('data-status', 'hide-all');
                                            t.find('.ultb-radius-single').hide();
                                            t.find('.ultb-radius-section .ult-expand').addClass('ult-collapse');
                                    break;
                      case 'border-top-left-radius':
                      case 'border-top-right-radius':
                      case 'border-bottom-right-radius':
                      case 'border-bottom-left-radius':
                                            t.find('.ultb-radius-all').hide();
                                            t.find('.ultb-radius-all').attr('data-status', 'hide-me');
                                            t.find('.ultb-radius-single').show();
                                            t.find('.ultb-radius-section .ult-expand').removeClass('ult-collapse');
                        break;
                    }



                    switch(splitval[0]) {
                      case 'border-width':
                      case 'border-top-width':
                      case 'border-right-width':
                      case 'border-bottom-width':
                      case 'border-left-width':
                        var val = splitval[1].match(/\d+/);
                        var b = splitval[1].split(val);
                        var unit = 'px';
                        if(typeof b[1] != 'undefined' && b[1] != null) {
                          unit = b[1];
                        }
                        t.find(".ult-unit-border-width").val(unit);     // set border select unit
                        if( dataid==splitval[0] ) {
                          mval = splitval[1].split(unit);
                          $(elem).val(mval[0]);
                        }
                        break;

                      case 'border-radius':
                      case 'border-top-left-radius':
                      case 'border-top-right-radius':
                      case 'border-bottom-right-radius':
                      case 'border-bottom-left-radius':
                        var val = splitval[1].match(/\d+/);
                        var b = splitval[1].split(val);
                        var unit = 'px';
                        if(typeof b[1] != 'undefined' && b[1] != null) {
                          unit = b[1];
                        }
                        t.find(".ult-unit-border-radius").val(unit);     // set border select unit
                        if( dataid==splitval[0] ) {
                          mval = splitval[1].split(unit);
                          $(elem).val(mval[0]);
                        }
                        break;
                    }

                  }
               });
            }
        });

        // set color 
        var splitcols = mv.split("|");
        if(typeof splitcols[2] != 'undefined' || splitcols[2] != null){
          var sp = splitcols[2].split(":");
          var nd = sp[1].split(";");
          var did = t.find(".ultimate-colorpicker").attr("data-id");
          if(sp[0]==did) {
            if( nd[0] !== 'transparent') {
              t.find(".ultimate-colorpicker").val(nd[0]).trigger('change');
              //t.find("a.wp-color-result").css({"background-color": nd[0]});
              //   set alpha value
              var picker = $.cs_ParseColorValue( nd[0] );
              var sl_value = parseFloat( picker.alpha / 100 );
              var alpha_val = sl_value < 1 ? sl_value : '';
              t.find('.cs-alpha-text').text( alpha_val );
              //  drag position
              if(alpha_val == '') {
                t.find('.cs-alpha-slider .ui-slider-handle').css('left', '100%');
              } else {
                alpha_val = parseFloat(alpha_val * 100);
                t.find('.cs-alpha-slider .ui-slider-handle').css('left', alpha_val+'%');
              }
              t.find('.wp-picker-container').find('.cs-alpha-slider-offset').css('background-color', nd[0]);
              t.find('.iris-strip').css('background-image', '-webkit-linear-gradient(top, '+nd[0]+', rgb(197, 197, 197))');
            }
          }
        }
      } else {
        update_visibility(t);
        t.find(".ultimate-border-inputs").each(function(input_index, elem) {
          var d = $(elem).attr("data-default");
          $(elem).val(d);
        });
      }
  }

  // [2]  On change - input / select
  $(".ultimate-border-input, .ultimate-border-style-selector, .ultimate-colorpicker").on('change', function(e){
    var t = $(this).closest('.ultimate-border');
    var v = t.find('.ultimate-border-value').val();

    update_visibility(t);
    set_hidden_with_border_style(t);
  });

  function set_hidden_with_border_style(t, hxcolor) {
    var nval = "";
    var l = t.find(".ultimate-border-style-selector").length;
    //  check border style is avai. then add border style
    if(l) {
      var sv = t.find(".ultimate-border-style-selector option:selected").val();
      t.find(".ultimate-border-value").val(nval);
      var nval = "border-style:" +sv+ ";|";
    } 
    
    //  border
    var wd = t.find('.ultb-width-all').attr('data-status') || 'hide-all';
    var border = '';
    if( wd === 'hide-all' ) {
      border = 'ultb-width-all'; }
    else {
      border = 'ultb-width-single';
    }
    t.find('.'+border+' .ultimate-border-input').each(function(index, elm) {
      var unit = t.find(".ult-unit-border-width option:selected").val() || t.find(".ultimate-border-value").attr("data-unit");
      var ival = $(elm).val();
      if ($.isNumeric(ival)) {
          if (ival.match(/^[0-9]+$/))
              var item = $(elm).attr("data-id") + ":" + $(elm).val() + unit + ";";
          nval += item;
      }
    });

    //  radius
    var rd = t.find('.ultb-radius-all').attr('data-status') || 'hide-all';
    var radius = '';
    if( rd === 'hide-all' ) {
      radius = 'ultb-radius-all'; }
    else {
      radius = 'ultb-radius-single';
    }
    t.find('.'+radius+' .ultimate-border-input').each(function(index, elm) {
      var unit = t.find(".ult-unit-border-radius option:selected").val() || t.find(".ultimate-border-value").attr("data-unit");
      var ival = $(elm).val();
      if ($.isNumeric(ival)) {
          if (ival.match(/^[0-9]+$/))
              var item = $(elm).attr("data-id") + ":" + $(elm).val() + unit + ";";
          nval += item;
      }
    });
    
    //  colors
    if(typeof hxcolor != "undefined" || hxcolor != null) {
      var nval = nval + "|border-color:" +hxcolor+ ";";
    } else {
      var va = t.find(".ultimate-colorpicker").val();
      if(va!='') {
        var nval = nval + "|border-color:" +va+ ";";
      }
    }
    t.find(".ultimate-border-value").val(nval);
  }

}(jQuery, window));