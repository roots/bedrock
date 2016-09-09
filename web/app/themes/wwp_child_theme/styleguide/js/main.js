(function($,ns){

    var themeJs = {

        //Chef d'orchestre, que veux faire mon theme?
        init: function(){
            var t = this;

            $(document).one('ready', function() {
                t.$wrap = $('body');
                t.initGlobalComponents();
            });
        },

        initGlobalComponents: function(){
            var registeredComponents = ns.app.getComponents();
            if(registeredComponents){ for(var i in registeredComponents){
                var thisRegisteredComp = registeredComponents[i];
                if(thisRegisteredComp && thisRegisteredComp.opts && thisRegisteredComp.opts.initGlobal){
                    new thisRegisteredComp.component();
                }
            }}
        }

    };

    themeJs.init();


})(jQuery,window.wonderwp);