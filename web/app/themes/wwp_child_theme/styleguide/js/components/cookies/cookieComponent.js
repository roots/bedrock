(function ($,ns) { //Fonction auto appelante avec les parametres definis dans l'ordre en bas

    //Objet reinstanciable, c'est donc une fonction, pas un objet statique
    //On lui passe un wrapper en parametre, c'est dans cette boite que l'on va travailler
    var cookieComponent = function ($cookieWrap) {

        //On assigne le wrap a l'objet, sinon la variable $cookieWrap ne serait pas disponible en dehors de cette fonction
        //On peut utiliser || pour specifier un selecteur par defaut au cas ou $cookieWrap n'aurait pas ete envoye
        this.$wrap = $cookieWrap || $('.cookies-wrap');

        //On appelle ensuite la methode init (a defnir dans prototype)
        this.init();
    };



    //Etant donne qu'on a cree un objet reinstanciable, on definie les methodes sur prototype.
    cookieComponent.prototype = {

        //definition de la methode init
        init: function () {
            var t = this;

            //C'est vraiment ici qu'on va travailler ----------------------

            //On utilise this.$wrap pour travailler, pas de selecteurs globaux.
            this.$wrap.find('button').on('click', function (e) {
                e.preventDefault();
                t.$wrap.removeClass('active');
                $(t.$wrap).bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function () {
                    t.$wrap.remove();
                });
            });

            //------------------------
        }
    };

    ns.app.registerComponent('cookie',cookieComponent,{ initGlobal:true });

})(jQuery, window.wonderwp);
//On passe en bas de la fonction auto appelante les objet que l'on avoir avoir de disponible en son sein.
// Ici jQuery et window.wonderwp (le namespace), donc en haut de la fonction auto appelante $=jQuery et ns=window.wonderwp