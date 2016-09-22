(function($,ns){

    var app = {
        components:{},
        modules: {},
        templates: null,
        init: function(){

        },

        //Components = js from styleguide elements (sliders, tabs ...)
        getComponents: function(){
          return this.components;
        },
        registerComponent: function(name,component,opts){
            this.components[name] = component;
        },
        getComponent: function(name){
            return this.components[name] || null;
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

        //Templates
        getTemplates: function(){
            this.templates = $.parseJSON($('#jsTemplates').html());
        },
        getTemplate: function(tplName){
            if(this.templates===null){ this.getTemplates(); }
            return this.templates[tplName] ? this.templates[tplName] : null;
        }
    };

    ns.app = app;
    ns.app.init();

})(jQuery,window.wonderwp);