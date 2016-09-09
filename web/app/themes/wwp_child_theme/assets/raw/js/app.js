(function($,ns){

    var app = {
        components:{},
        modules: {},
        init: function(){

        },

        //Components = js from styleguide elements (sliders, tabs ...)
        getComponents: function(){
          return this.components;
        },
        registerComponent: function(name,component,opts){
            this.components[name] = { component: component, opts:opts };
        },
        getComponent: function(name){
            var comp = this.components[name] || null;
            return comp ? comp.component : null;
        },

        //Modules = js from plugins
        getModules: function(){
            return this.modules;
        },
        registerModule: function(name,module){
            this.modules[name] = module;
        },
        getModule: function(name){
            return this.modules[name] || null;
        },
    };

    ns.app = app;
    ns.app.init();

})(jQuery,window.wonderwp);