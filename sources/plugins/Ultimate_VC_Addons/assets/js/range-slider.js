/*range-slider js*/

jQuery(document).ready(function( $ ) {

    //////// Lighter darker script //////////

    /****************** How To Use ***************

        wp_enqueue_script( 'bsf-color-gradient' );

        var hex     = '#ffa039';
        var rgb     = 'rgb(255, 153, 0)';
        var rgba    = 'rgba(255, 153, 0, 0.3)';


        //  Convert colors
      
        var hex_light   = lighterColor( hex , .2);   //  Here .2 is ratio
        var hex_dark    = darkerColor( hex , .2);

        var rgb_light   = lighterColor( rgb , .2);
        var rgb_dark    = darkerColor( rgb , .2);

        var rgba_light  = lighterColor( rgba , .2);
        var rgba_dark   = darkerColor( rgba , .2);

    **********************************************/

    /* Helper function */
    var pad = function(num, totalChars) {
        var pad = '0';
        num = num + '';
        while (num.length < totalChars) {
            num = pad + num;
        }
        return num;
    };

    // Ratio is between 0 and 1
    var changeColor = function(color, ratio, darker) {
        // Trim trailing/leading whitespace
        color = color.replace(/^\s*|\s*$/, '');

        // Expand three-digit hex
        color = color.replace(
            /^#?([a-f0-9])([a-f0-9])([a-f0-9])$/i,
            '#$1$1$2$2$3$3'
        );

        // Calculate ratio
        var difference = Math.round(ratio * 256) * (darker ? -1 : 1),
            // Determine if input is RGB(A)
            rgb = color.match(new RegExp('^rgba?\\(\\s*' +
                '(\\d|[1-9]\\d|1\\d{2}|2[0-4][0-9]|25[0-5])' +
                '\\s*,\\s*' +
                '(\\d|[1-9]\\d|1\\d{2}|2[0-4][0-9]|25[0-5])' +
                '\\s*,\\s*' +
                '(\\d|[1-9]\\d|1\\d{2}|2[0-4][0-9]|25[0-5])' +
                '(?:\\s*,\\s*' +
                '(0|1|0?\\.\\d+))?' +
                '\\s*\\)$'
            , 'i')),
            alpha = !!rgb && rgb[4] != null ? rgb[4] : null,

            // Convert hex to decimal
            decimal = !!rgb? [rgb[1], rgb[2], rgb[3]] : color.replace(
                /^#?([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i,
                function() {
                    return parseInt(arguments[1], 16) + ',' +
                        parseInt(arguments[2], 16) + ',' +
                        parseInt(arguments[3], 16);
                }
            ).split(/,/),
            returnValue;

        // Return RGB(A)
        return !!rgb ?
            'rgb' + (alpha !== null ? 'a' : '') + '(' +
                Math[darker ? 'max' : 'min'](
                    parseInt(decimal[0], 10) + difference, darker ? 0 : 255
                ) + ', ' +
                Math[darker ? 'max' : 'min'](
                    parseInt(decimal[1], 10) + difference, darker ? 0 : 255
                ) + ', ' +
                Math[darker ? 'max' : 'min'](
                    parseInt(decimal[2], 10) + difference, darker ? 0 : 255
                ) +
                (alpha !== null ? ', ' + alpha : '') +
                ')' :
            // Return hex
            [
                '#',
                pad(Math[darker ? 'max' : 'min'](
                    parseInt(decimal[0], 10) + difference, darker ? 0 : 255
                ).toString(16), 2),
                pad(Math[darker ? 'max' : 'min'](
                    parseInt(decimal[1], 10) + difference, darker ? 0 : 255
                ).toString(16), 2),
                pad(Math[darker ? 'max' : 'min'](
                    parseInt(decimal[2], 10) + difference, darker ? 0 : 255
                ).toString(16), 2)
            ].join('');
    };
    var lighterColor = function(color, ratio) {
        return changeColor(color, ratio, false);
    };
    var darkerColor = function(color, ratio) {
        return changeColor(color, ratio, true);
    };

    /////////// End lighter darker script /////////////////////////////

    var range_slider = $('.ult-rs-wrapper');//$('.ult-rslider-container');
    count = 0;

range_slider.each(function() { 
    count = count +1;
    var title_width = 0,
        title_height = 0,
        desc_height = 0;

    
    var $this = $(this).find('.ult-rslider-container');
    var rs_create = 0;
    //alert($this);
    var slider_steps = $this.data('slider_steps');
    var slider_color = $this.data('slider_color');

        slider_color = ( !slider_color) ? '#3BF7D1' : slider_color
        var hex     = slider_color;
        //  Convert colors
        var hex_light   = lighterColor( hex , .2);
        var hex_dark    = darkerColor( hex , .2);

        var slider_active_color = hex_dark ,
            dragger_color = hex_dark;

    var title_background = $this.data('title-background');
    var title_box = $this.data('title-box');

    var slider_size = $this.data('slider_size');
    var adaptive_height = $this.data('adaptive_height');
        //dragger_size = $this.data('dragger_size');
    
    var arrow_style = $this.data('arrow');
    var arrow_background = 'border-top-color:'+title_background+';';
    if( arrow_style ){
        var style = document.createElement('style');
        style.type = 'text/css';
        style.innerHTML = '.ult-arrow'+ count +':before { '+ arrow_style +' }' + '.ult-arrow'+ count +':after { '+ arrow_background +' }';
        document.getElementsByTagName('head')[0].appendChild(style);
        var arrow_class = 'ult-arrow'+ count;
        $this.find('.ult-arrow').addClass( arrow_class );
        //alert();
    }
    var slider_container = $this;
    var slider_wrapper = $(this);
    var ult_slider = $this.find('.ult-rslider');

    var tooltip = "";
        
    var slider_function = function(event, ui) {

        var ult_handle = $this.find('.ui-slider-handle');

        var value = ui.value || 1 ;
        //alert(value);
        //var title_class_pre = ".ult-title"+ (parseInt(value) - 1);
        //var title_class_next = ".ult-title"+ (parseInt(value) + 1);
        var title_class = ".ult-title"+ value;

        //var desc_class_pre = ".ult-desc"+ (parseInt(value) - 1);
        //var desc_class_next = ".ult-desc"+ (parseInt(value) + 1);
        var desc_class = ".ult-desc"+ value;

       /* alert(r_class_pre);
        alert(r_class);
        alert(r_class_next);*/

                
        if( !slider_container.find('.ult-tooltip').hasClass("ult-done") ){
            slider_container.find('.ult-tooltip').each(function (index) {
                $(this).addClass("ult-done");
                ult_handle.append($(this));
            })
            rs_create = 1;
        }
            
        slider_container.find( title_class ).css( "visibility", "visible" );
        slider_container.find( title_class ).siblings().css( "visibility", "hidden" );
           
        slider_wrapper.find( desc_class ).css( 'display', 'block' );
        slider_wrapper.find( desc_class ).siblings().css( "display", "none" );

        ticks_slide (value);//, slider_container, slider_active_color, slider_color);
    }


    function ticks_slide (value){//(value, slider_container, slider_active_color, slider_color) {
        
        //var ult_slider_ticks_pre = '.ult-slider-ticks'+(value-1);
        var ult_slider_ticks = '.ult-slider-ticks'+value;
        //var ult_slider_ticks_next = '.ult-slider-ticks'+(value+1);

        //var ult_ticks_pre = slider_container.find(ult_slider_ticks_pre);
        var ult_ticks = slider_container.find(ult_slider_ticks);
        //var ult_ticks_next = slider_container.find(ult_slider_ticks_next);

         //alert(ult_ticks_next);
         //console.log(ult_ticks);
        /* console.log(slider_active_color);


        ult_ticks_pre.css('background', slider_active_color);
        ult_ticks.css('background', slider_color);
        ult_ticks_next.css('background', slider_color);*/

        //ult_ticks.css('background-color', slider_active_color);
        //ult_ticks.css('background', slider_color);
        ult_ticks.prevAll('.ui-slider-label-ticks').css( "background", slider_active_color );
        ult_ticks.nextAll('.ui-slider-label-ticks').css( "background", slider_color );


    }

    //jquery ui slider
	ult_slider.slider({
        range: "min",
		min: 1,
		max: slider_steps,
        step: 1,
        create: slider_function,
		slide: slider_function,
    });


    //ticks on slider
    ult_slider.labeledslider({ 
        max: slider_steps-1, 
        tickInterval: 1 
    });

    if(title_box == 'auto'){
        $this.find('.ult-tooltip').each(function (){
            var temp_w = $(this).outerWidth();
            var temp_h = $(this).outerHeight();
            temp_w = (temp_w/2) + 10; // half size as a padding
            title_width = ( title_width > temp_w ) ? title_width : temp_w;
            title_height = ( title_height > temp_h ) ? title_height : temp_h;
        });

        var padding_all = title_height+'px '+title_width+'px 35px';
        $this.css( "padding", padding_all );
    }

    if (adaptive_height == 'on') {
        slider_wrapper.find('.ult-description').each(function (){
            var temp_h = $(this).outerHeight();
            desc_height = ( desc_height > temp_h ) ? desc_height : temp_h;
        });

        desc_height = (desc_height+30)+'px';
        slider_wrapper.find('.ult-desc-wrap').css( "min-height", desc_height );
    };
    
    $this.find(".ui-slider-labels" ).children(".ui-slider-label-ticks").css( "background", slider_color );
    //alert(slider_color);
    /*if( !dragger_size ){
        dragger_size = '';
    }*/
    var custom_css = {};
    //var dragger_width = 'width',
    //    dragger_height = 'height',
    var dragger_background = 'background';

    //  custom_css[dragger_width] = dragger_size;
    //  custom_css[dragger_height] = dragger_size;
      custom_css[dragger_background] = dragger_color;
   
    
    var dragger = ult_slider.find('.ui-slider-handle');
    ult_slider.css( 'background', slider_color );
    dragger.css( custom_css );
    ult_slider.find('.ui-slider-range').css( 'background', slider_active_color );
    
    


});
});


/*var initialValue = 1955;

var sliderTooltip = function(event, ui) {
    var curValue = ui.value || initialValue;
    var tooltip = '<div class="tooltip"><div class="tooltip-inner">' + curValue + '</div><div class="tooltip-arrow"></div></div>';

    $('.ui-slider-handle').html(tooltip);

}

$("#slider").slider({
    
    
    min: 1955,
    max: 2015,
    value: initialValue,
    step: 10,
    create: sliderTooltip,
    slide: sliderTooltip
});*/