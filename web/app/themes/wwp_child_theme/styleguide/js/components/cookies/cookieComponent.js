import jQuery from "jquery";

(function ($, ns) { //Fonction auto appelante avec les parametres definis dans l'ordre en bas

    var cookieComponent = {

            global: true,
            initiable: true,
            defaultSelector: '.cookies-wrap',

            //Etant donne qu'on a cree un objet reinstanciable, on definie les methodes sur prototype.

            //definition de la methode init
            init: function ($wrap) {

                var t = this;
                t.$wrap = $wrap || $(t.defaultSelector);

                //C'est vraiment ici qu'on va travailler ----------------------

                //On utilise this.$wrap pour travailler, pas de selecteurs globaux.
                this.$wrap.find('button').on('click', function (e) {
                    e.preventDefault();
                    t.$wrap.removeClass('active');
                    t.$wrap.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function () {
                        t.$wrap.remove();
                    });
                });

                //------------------------
            }
        };

    //Enregistrement du composant aupres de l'application pour etre auto loade
   // ns.app.registerComponent('cookie', cookieComponent, {initGlobal: true}); //si on passe { initGlobal:true } il sera meme auto instancie

})(jQuery, window.wonderwp);
//On passe en bas de la fonction auto appelante les objet que l'on avoir avoir de disponible en son sein.
// Ici jQuery et window.wonderwp (le namespace), donc en haut de la fonction auto appelante $=jQuery et ns=window.wonderwp