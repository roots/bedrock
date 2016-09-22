(function ($, ns) {

    var notificationComponent = {

        global: false,
        initiable: false,

        show: function (type, message, $dest, delay) {
            $dest = $dest || $('body');
            delay = delay || 4000;
            var notifTpl = ns.app.getTemplate('notification');

            if (notifTpl) {
                var notif = notifTpl
                        .replace('{type}', type)
                        .replace('{message}', message)
                    ;
                var $notif = $(notif);
                $notif.addClass('alert-js active').prependTo($dest);

                setTimeout(function(){
                    $notif.removeClass('active');
                    $notif.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function () {
                        $notif.remove();
                    });
                },delay);
            }
        }

    };

    ns.app.registerComponent('notification', notificationComponent); //si on passe { initGlobal:true } il sera meme auto instancie


})(jQuery, window.wonderwp);