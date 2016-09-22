/**
 * faq.js. Created by jeremydesvaux the 16 mai 2014
 */
(function($,ns) {

    "use strict";

    /**
     * init module scripts, relative to its context (multiple context of the same module may exist in a page)
     * @param jQuery $context wraper div of the module
     */
    var faq = function($context) {
        this.$context = $context;
        this.init();
    };

    faq.prototype = {
        init: function(){
            console.log(this.$context);
        }
    };

    ns.app.registerModule('faq',faq);

})(jQuery,window.wonderwp);