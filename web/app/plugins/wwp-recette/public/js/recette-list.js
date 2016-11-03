/**
 * Created by jeremydesvaux on 03/10/2016.
 */
(function($,ns) {

    "use strict";

    /**
     * init module scripts, relative to its context (multiple context of the same module may exist in a page)
     * @param jQuery $context wraper div of the module
     */
    var recetteList = function($context) {
        this.$context = $context;
        this.init();
    };

    recetteList.prototype = {
        init: function(){
            this.registerFormToggle();
        },
        /**
         * open share dialogs in a popup
         */
        registerFormToggle: function() {
            var t = this;
            this.$context.find('.filters-toggler').on('click', function(e){
                e.preventDefault();
                $('.hideWhenFiltersOpened').slideToggle();
                t.$context.find('.recipes-filter-open').slideToggle();
            });
        },
    };

    ns.app.registerModule('recetteList',recetteList);

})(jQuery,window.wonderwp);