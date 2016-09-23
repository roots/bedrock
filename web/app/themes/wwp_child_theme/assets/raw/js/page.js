/**
 * page.js. Created by jeremydesvaux the 30 sept. 2014
 */
(function ($, $w, ns, $b) {

    "use strict";

    var pageJs = function ($el, initiable) {
        this.$el = $el || $('#content > article');
        this.initiable = initiable || true;
        this.inited = false;
        this.modules = [];
        this.appeared = false;

        this.transitionClassHidden = 'page-transition-hidden';
        this.transitionClassAppear = 'page-transition-appear';
        this.transitionClassDisappear = 'page-transition-disappear';

        return this;
    };

    pageJs.prototype = {

        init: function () {
            if (this.inited) {
                $w.trigger('resize'); // update bx sliders
            } else {
                this.inited = true;
                this.initComponents();
                this.initModules();
                this.bindUiActions();
                this.initPage();
            }
        },
        /**
         * Init registered and initiable JavaScript components activated by the SiteConfig
         */
        initComponents: function () {
            //ns.app.initComponents(false,this.$el);
        },
        /**
         * init modules script for current page
         */
        initModules: function () {

            var scope = this;
            if (!ns.app.modules) return;

            for (var moduleSlug in ns.app.modules) {
                // init module script in each of its section in the page
                var $moduleSection = scope.$el.find('.module-' + moduleSlug);
                if ($moduleSection.length) {
                    $moduleSection.each(function (i, context) {
                        var module = new ns.app.modules[moduleSlug]($(context));
                        scope.modules.push(module);
                    });
                }
            }


        },
        bindUiActions: function () {
            this.registerAnchors();
            this.registerReadmore();
        },
        /**
         * Smooth scroll to anchors instead of jumping to it
         */
        registerAnchors: function () {
            var scope = this;
            ns.app.registerAnchors && ns.app.registerAnchors(scope.$el);
        },
        /**
         * When you have a .readmore link and a .readmore-content in the same parent,
         * we change the link behaviour so it slide toggles the .readmore-content
         */
        registerReadmore: function () {
            var scope = this;
            var formerText; // Contiendra la valeur initiale du texte (ex: "Lire la suite")
            scope.$el.find('.readmore').on('click', function (e) {
                var $el = $(this).siblings('.readmore-content');
                var $link = $('a', this);

                if (typeof formerText === 'undefined') {
                    formerText = {readless: $link.text()};
                }

                if ($el.length > 0) {
                    e.preventDefault();
                    $el.slideToggle();
                    $(this).toggleClass('active');
                    // S'il n'y a pas d'attribut data-readless="", on ne fait aucune modification
                    if ($(this).data('readless') && typeof formerText !== 'undefined') {
                        if ($(this).hasClass('active')) {
                            $link.text($(this).data('readless'));
                        } else {
                            $link.text(formerText.readless);
                        }
                    }

                    $el.trigger('readmore-toggle', [$(this).hasClass('active')]);
                }
            });
        },

        /**
         * remove page from dom
         */
        remove: function () {
            var scope = this;
            scope.$el && scope.$el.remove();
        },

        /**
         * add transition classes to animate appear / disappear
         * @param {boolean} appear is it appear or disappear transition
         */
        addTransitionClasses: function (appear) {
            var scope = this;
            scope.$el.removeClass(scope.transitionClassHidden + ' ' + scope.transitionClassAppear + ' ' + scope.transitionClassDisappear);

            if (appear) {
                scope.$el.addClass(scope.transitionClassHidden + ' ' + scope.transitionClassAppear);
                setTimeout(function () {
                    scope.$el.removeClass(scope.transitionClassHidden + ' ' + scope.transitionClassAppear);
                }, 20);
            } else {
                scope.$el.addClass(scope.transitionClassHidden + ' ' + scope.transitionClassDisappear);
            }
        },

        /**
         * called when page appear on dom
         */
        appear: function () {
            if (!this.appeared) {
                this.appeared = true;
                this.notifyModules();
            }
        },

        /**
         * called when page disappear from dom
         */
        disappear: function () {
            if (this.appeared) {
                this.appeared = false;
                this.notifyModules();
            }
        },

        /**
         * call appear / disappear function on modules
         */
        notifyModules: function () {
            var scope = this;
            var i = scope.modules.length,
                functionName = this.appeared ? 'appear' : 'disappear';
            if (i !== 0) {
                while (i--) {
                    scope.modules[i][functionName] && scope.modules[i][functionName]();
                }
            }
        },

        /**
         * function to override in your specific pages
         */
        initPage: function () {

        }

    };

    ns.Page = pageJs;

})(jQuery, jQuery(window), window.wonderwp, jQuery('body'));