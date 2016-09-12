(function ($,ns) {

    var accordionComponent = function ($accordionWrap) {
        this.$wrap = $accordionWrap || $('.accordion-wrap');
        this.init();
    };


    accordionComponent.prototype = {
        init: function () {
            ns.initTabs(this.$wrap);
        }
    };

})(jQuery, window.wonderwp);


// var $accordions = $( ".js-accordion" );