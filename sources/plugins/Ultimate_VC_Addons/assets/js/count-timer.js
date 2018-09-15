jQuery(window).load(function(){

    var responsive = function (){

        /**
         *  init variables
         */
         var    large_screen        = '',
                desktop             = '',
                tablet              = '',
                tablet_portrait     = '',
                mobile_landscape    = '',
                mobile              = '';

        /**
         *  generate responsive @media css
         *------------------------------------------------------------*/
        jQuery(".ult-responsive").each(function(index, element) {

            var t                       = jQuery(element),
                n                       = t.attr('data-responsive-json-new'),
                target                  = t.data('ultimate-target'),
                temp_large_screen       = '',
                temp_desktop            = '',
                temp_tablet             = '',
                temp_tablet_portrait    = '',
                temp_mobile_landscape   = '',
                temp_mobile             = '';

            if( typeof n != "undefined" || n != null ) {
                jQuery.each(jQuery.parseJSON(n), function (i, v) {
                    // set css property
                    var css_prop = i;
                    if (typeof v != "undefined" && v != null) {
                        var vals = v.split(";");
                        jQuery.each(vals, function(i, vl) {
                            if (typeof vl != "undefined" || vl != null) {
                                var splitval = vl.split(":");
                                switch(splitval[0]) {
                                    case 'large_screen':    temp_large_screen       += css_prop+":"+splitval[1]+";"; break;
                                    case 'desktop':         temp_desktop            += css_prop+":"+splitval[1]+";"; break;
                                    case 'tablet':          temp_tablet             += css_prop+":"+splitval[1]+";"; break;
                                    case 'tablet_portrait': temp_tablet_portrait    += css_prop+":"+splitval[1]+";"; break;
                                    case 'mobile_landscape':temp_mobile_landscape   += css_prop+":"+splitval[1]+";"; break;
                                    case 'mobile':          temp_mobile             += css_prop+":"+splitval[1]+";"; break;
                                }
                            }
                        });
                    }
                });
            }

            if(temp_mobile!='') {           mobile              += target+ '{'+temp_mobile+'}'; }
            if(temp_mobile_landscape!='') { mobile_landscape    += target+ '{'+temp_mobile_landscape+'}'; }
            if(temp_tablet_portrait!='') { tablet_portrait      += target+ '{'+temp_tablet_portrait+'}'; }
            if(temp_tablet!='') {           tablet              += target+ '{'+temp_tablet+'}'; }
            if(temp_desktop!='') {          desktop             += target+ '{'+temp_desktop+'}'; }
            if(temp_large_screen!='') {     large_screen        += target+ '{'+temp_large_screen+'}'; }
        });

        /*
         *      REMOVE Comments for TESTING
         *-------------------------------------------*/
        var UltimateMedia      = '<style>\n/** Ultimate: CountDown Responsive **/ ';
         UltimateMedia   += desktop;
         UltimateMedia   += "\n@media (min-width: 1824px) { "+ large_screen      +"\n}";
         UltimateMedia   += "\n@media (max-width: 1199px) { "+ tablet            +"\n}";
         UltimateMedia   += "\n@media (max-width: 991px)  { "+ tablet_portrait   +"\n}";
         UltimateMedia   += "\n@media (max-width: 767px)  { "+ mobile_landscape  +"\n}";
         UltimateMedia   += "\n@media (max-width: 479px)  { "+ mobile            +"\n}";
         UltimateMedia   += '\n/** Ultimate: Tooltipster Responsive - **/</style>';
         jQuery('head').append(UltimateMedia);

    }
    responsive();
    jQuery('.ult_countdown-dateAndTime').each(function(){
        var t = new Date(jQuery(this).html());
        var tz = jQuery(this).data('time-zone')*60;
        var tfrmt = jQuery(this).data('countformat');
		var labels_new = jQuery(this).data('labels');
		var new_labels = labels_new.split(",");
		var labels_new_2 = jQuery(this).data('labels2');
		var new_labels_2 = labels_new_2.split(",");
        var server_time = function(){
          return new Date(jQuery(this).data('time-now'));
        }
        
        var ticked = function (a){
            var json_responsive = jQuery('.ult_countdown-dateAndTime').attr('data-responsive-json-new');
            var target_responsive = jQuery('.ult_countdown-dateAndTime').attr('data-ultimate-target');
            var json_responsive_sep = jQuery('.ult_countdown').attr('data-responsive-json-new');
            var json_target_sep = jQuery('.ult_countdown').attr('data-ultimate-target');
            jQuery('.ult_countdown-period').addClass('ult-responsive');
            jQuery(this).find('.ult_countdown-amount').attr({
                'data-ultimate-target': target_responsive,
                'data-responsive-json-new': json_responsive
            });
            jQuery(this).find('.ult_countdown-period').attr({
                'data-ultimate-target': json_target_sep,
                'data-responsive-json-new': json_responsive_sep
            });
            // jQuery(this).find('.ult_countdown-period').attr(tick_p_size);
            jQuery(this).find('.ult_countdown-amount').css({'color':jQuery(this).data('tick-col')})
            jQuery(this).find('.ult_countdown-amount').addClass('ult-responsive');
            jQuery(this).find('.ult_countdown-period').css({'font-size':jQuery(this).data('tick-p-size'),'color':jQuery(this).data('tick-p-col')})
            jQuery(this).find('.ult_countdown-amount').css({'border-color':jQuery(this).data('br-color'),'border-width':jQuery(this).data('br-size'),'border-style':jQuery(this).data('br-style'),'border-radius':jQuery(this).data('br-radius'), 'background':jQuery(this).data('bg-color'),'padding':jQuery(this).data('padd'),})
            if(jQuery(this).data('tick-style')=='bold'){
                jQuery(this).find('.ult_countdown-amount').css('font-weight','bold');
            }
            else if (jQuery(this).data('tick-style')=='italic'){
                jQuery(this).find('.ult_countdown-amount').css('font-style','italic');
            }
            else if (jQuery(this).data('tick-style')=='boldnitalic'){
                jQuery(this).find('.ult_countdown-amount').css('font-weight','bold');
                jQuery(this).find('.ult_countdown-amount').css('font-style','italic');
            }
            if(jQuery(this).data('tick-p-style')=='bold'){
                jQuery(this).find('.ult_countdown-period').css('font-weight','bold');
            }
            else if (jQuery(this).data('tick-p-style')=='italic'){
                jQuery(this).find('.ult_countdown-period').css('font-style','italic');
            }
            else if (jQuery(this).data('tick-p-style')=='boldnitalic'){
                jQuery(this).find('.ult_countdown-period').css('font-weight','bold');
                jQuery(this).find('.ult_countdown-period').css('font-style','italic');
        }
    }

    if(jQuery(this).hasClass('ult-usrtz')){
        jQuery(this).ult_countdown({labels: new_labels, labels1: new_labels_2, until : t, format: tfrmt, padZeroes:true,onTick:ticked});
    }else{
        jQuery(this).ult_countdown({labels: new_labels, labels1: new_labels_2, until : t, format: tfrmt, padZeroes:true,onTick:ticked , serverSync:server_time});
    }
    });
    /* jQuery('body').click(function(){
        jQuery('.ult_countdown-dateAndTime').ult_countdown('destroy')  ;
        jQuery('.ult_countdown-dateAndTime').ult_countdown({until: new Date()})  ;
    })
   */
});
