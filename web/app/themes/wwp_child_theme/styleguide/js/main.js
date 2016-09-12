(function($,ns){

    var styleguideJs = {

        //Chef d'orchestre, que veux faire mon theme?
        init: function(){
            var t = this;

            $(document).one('ready', function() {
                t.$wrap = $('body');
                t.initComponents(true);
                t.initComponents(false,$('.atoms-container'));
            });
        },

        initComponents: function(global,$context){
            var registeredComponents = ns.app.getComponents();

            if(registeredComponents){ for(var i in registeredComponents){
                var component = registeredComponents[i];

                if(component.initiable && component.global === global && component.init){
                    if(global) {
                        component.init();
                    } else {
                        component.init($context.find(component.defaultSelector));
                    }
                }
            }}
        },

    };

    styleguideJs.init();


})(jQuery,window.wonderwp);