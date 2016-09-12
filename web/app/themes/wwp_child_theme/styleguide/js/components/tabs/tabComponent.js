(function ($, ns) {

    var tabComponent = {

        global: false,
        initiable: true,
        defaultSelector: '.js-tabs',


        init: function ($wrap) {

            var t = this;
            t.$wrap = $wrap || $(t.defaultSelector);

            if(t.$wrap.length){
                ns.initTabs(t.$wrap);
            }

        }
    };

    ns.app.registerComponent('tab', tabComponent, {initGlobal: true}); //si on passe { initGlobal:true } il sera meme auto instancie


})(jQuery, window.wonderwp);