// JavaScript Document
$ult = jQuery.noConflict();

$ult(".ultimate-responsive-wrapper").each(function(index, element) {
  var t = $ult(element);
    get_responsive_values_in_input(t);
    set_responsive_values_in_hidden(t);
});

/*
 *   Get hidden field values
 *---------------------------------------------------*/
function get_responsive_values_in_input(t) {
    var mv = t.find(".ultimate-responsive-value").val();

    /* TOGGLE */
    var toggleMedia = new Object();

    if (mv != "") {
      var vals = mv.split(";");
      $ult.each(vals, function(i, vl) {
          if (vl != "") {
              t.find(".ult-responsive-input").each(function(input_index, elem) {
                var splitval = vl.split(":");
                var dataid = $ult(elem).attr("data-id");

                if( dataid==splitval[0] ) {
                  var unit = $ult(elem).attr("data-unit");
                  mval = splitval[1].split(unit);
                  $ult(elem).val(mval[0]);

                  /* TOGGLE */
                  toggleMedia[dataid] = mval[0];
                }
             });
          }
      });
    
      /* TOGGLE */
      Object.size = function(obj) {
          var size = 0, key;
          for (key in obj) {
              if (obj.hasOwnProperty(key)) size++;
          }
          return size;
      };
      var size = Object.size(toggleMedia);
      if(size>=2) {     // set toggle data attributes
        t.find('.simplify').attr('ult-toggle', 'expand');
        t.find('.ult-responsive-item.optional, .ultimate-unit-section').show();
      } else {
        t.find('.simplify').attr('ult-toggle', 'collapse');
        t.find('.ult-responsive-item.optional, .ultimate-unit-section').hide();
      }
    } else {
      var i=0;      // set default - Values
      t.find(".ult-responsive-input").each(function(input_index, elem) {
        var d = $ult(elem).attr("data-default");
        if(d!='') { $ult(elem).val(d); i=i+1; }
      });
      if(i<=1) {    // set default - Collapse
       t.find('.simplify').attr('ult-toggle', 'collapse');
       t.find('.ult-responsive-item.optional, .ultimate-unit-section').hide();        
      }
    }
}

/*  TOGGLE CLICK */
$ult(".simplify").on('click', function(e){
  var      t = $ult(this).closest('.ultimate-responsive-wrapper'),
      status = $ult(this).attr('ult-toggle');
  switch(status) {
    case 'expand':    t.find('.simplify').attr('ult-toggle', 'collapse');
                      t.find('.ult-responsive-item.optional, .ultimate-unit-section').hide();
                      break;
    case 'collapse':  t.find('.simplify').attr('ult-toggle', 'expand');
                      t.find('.ult-responsive-item.optional, .ultimate-unit-section').show();
                      break;
    default:          t.find('.simplify').attr('ult-toggle', 'collapse');
                      t.find('.ult-responsive-item.optional, .ultimate-unit-section').hide();
                      break;
  }
});

/*
 *   Set hidden field values
 *---------------------------------------------------*/
//  On change - input / select
$ult(".ult-responsive-input").on('change', function(e){
    var t = $ult(this).closest('.ultimate-responsive-wrapper');
    //alert(t.attr("id"));
    set_responsive_values_in_hidden(t);
});

function set_responsive_values_in_hidden(t) {
  var nval = "";

  //  add all spacing widths, margins, paddings
  t.find(".ult-responsive-input").each(function(index, elm) {
    var unit = $ult(elm).attr("data-unit");

    var ival = $ult(elm).val();
    if ($ult.isNumeric(ival)) {
        if (ival.match(/^[0-9]+$/))
            var item = $ult(elm).attr("data-id") + ":" + $ult(elm).val() + unit + ";";
        nval += item;
    }
  });
  t.find(".ultimate-responsive-value").val(nval);
}