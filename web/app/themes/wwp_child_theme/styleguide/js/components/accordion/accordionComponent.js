(function ($, ns) {

    var accordionComponent = {

        global: false,
        initiable: true,
        defaultSelector: '.js-accordion',


        init: function ($wrap) {

            var t = this;
            t.$wrap = $wrap || $(t.defaultSelector);

            if(t.$wrap.length){
                ns.initAccordion(t.$wrap);
            }

        }
    };

    ns.app.registerComponent('accordion', accordionComponent);


})(jQuery, window.wonderwp);