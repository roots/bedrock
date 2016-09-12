(function ($, ns) {

    var dropdownComponent = {

        global: false,
        initiable: true,
        defaultSelector: '.dropdown',


        init: function ($wrap) {

            var t = this;
            t.$wrap = $wrap || $(t.defaultSelector);

            t.$wrap.find('.dropdown-toggle').on('click', function (e) {
                $(this).parent().toggleClass('open');
            });
            $(document).on('mouseup', function (e) {
                if (!$(e.target).hasClass('dropdown-toggle')) {
                    t.$wrap.removeClass('open');
                }
            });

        }
    };

    ns.app.registerComponent('dropdown', dropdownComponent, {initGlobal: true}); //si on passe { initGlobal:true } il sera meme auto instancie


})(jQuery, window.wonderwp);