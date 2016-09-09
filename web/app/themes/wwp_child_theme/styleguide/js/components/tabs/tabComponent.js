(function ($,ns) {

    var tabsComponent = function ($tabsWrap) {
        this.$wrap = $tabsWrap || $('.tabs-wrap');
        this.init();
    };


    tabsComponent.prototype = {
        init: function () {
            ns.initTabs(this.$wrap);
        }
    };

})(jQuery, window.wonderwp);
