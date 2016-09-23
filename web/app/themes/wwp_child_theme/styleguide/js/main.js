(function($,ns){

    var styleguideJs = {

        //Chef d'orchestre, que veux faire mon theme?
        init: function(){
            var t = this;

            $(document).one('ready', function() {
                t.$wrap = $('body');
                t.initComponents(true);
                t.initComponents(false,$('.atoms-container'));
                t.addOpenLink();
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

        addOpenLink: function(){
            if(window.frameElement && window.frameElement.src) {
                var openLink = '<a class="btn btn-sm newWindowLink" href="' + window.frameElement.src + '" target="_blank" style="position: absolute; right: 20px; top: 0;">' +
                    'Ouvrir dans un nouvel onglet' +
                '</a>';
                $('body.base').prepend($(openLink));
            }
        }

    };

    styleguideJs.init();


})(jQuery,window.wonderwp);