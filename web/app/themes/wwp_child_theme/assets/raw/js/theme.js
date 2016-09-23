(function($,ns,app){

    var themeJs = {

        //Chef d'orchestre, que veux faire mon theme?
        init: function(){
            var t = this;

            $(document).one('ready', function() {
                t.$wrap = $('body');

                //appeler ici une fonction par fonctionnalite
                //Ex: this.registerMenuToggle()

                //Init Global Components
                t.initComponents(true);
                //Init Global Modules
                t.initGlobalModules();


                //Init current page js + components
                t.runCurrentPageJs();
            });
        },

        initComponents: function(global,$context){
          var registeredComponents = app.getComponents();

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

        initGlobalModules: function(){
            //var t = this;
            if (!ns.app.modules) return;
            var $defaultPageWrap = $('#content > article.hentry');

            for (var moduleSlug in ns.app.modules) {
                // init module script in each of its section in the page
                var $moduleSection = $('body').find('.module-' + moduleSlug);
                if ($moduleSection.length) {
                    $moduleSection.each(function (i, context) {
                        if(!$.contains($defaultPageWrap[0],context)) {
                            var module = new ns.app.modules[moduleSlug]($(context));
                            //t.modules.push(module);
                        }
                    });
                }
            }
        },

        runCurrentPageJs: function(){
            var $pageWrap = this.$wrap.find('#content > article.hentry');
            //does the page give instructions about the class to load?
            var potentialClassName = $pageWrap.data('name') ? 'Page'+$pageWrap.data('name') : 'Page';
            var potentialClass = ns[potentialClassName];

            //If yes, load it, otherwise, load ns.Page. This potential class should inherit from ns.Page
            var classtoCall = (typeof potentialClass == 'function') ? potentialClass : ns['Page'];

            //Init page class
            var p = new classtoCall($pageWrap).init();
            this.initComponents(false,$pageWrap);
            return this;
        }

    };

        themeJs.init();


})(jQuery,window.wonderwp,window.wonderwp.app);