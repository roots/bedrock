/**
 * Created by jeremydesvaux on 03/10/2016.
 */
(function($,ns) {

    "use strict";

    /**
     * init module scripts, relative to its context (multiple context of the same module may exist in a page)
     * @param jQuery $context wraper div of the module
     */
    var recette = function($context) {
        this.$context = $context;
        this.init();
    };

    recette.prototype = {
        init: function(){
            this.registerSocialLinks();
        },
        /**
         * open share dialogs in a popup
         */
        registerSocialLinks: function() {
            // facebook, twitter
            this.$context.on('click', '.social-networks-share a:not(.direct-link)', function(e){
                e.preventDefault();
                window.open($(this).attr('href'),"share","menubar=1,resizable=1,width=600,height=300,top="+($(window).height() / 2 - 150)+",left="+($(window).width() / 2 - 300)+"");
                return false;
            });
        },
    };

    ns.app.registerModule('recette',recette);

})(jQuery,window.wonderwp);