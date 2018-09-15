/*  ========================================================================
 *  Frosty.js v1.0
 *  https://github.com/owensbla/frosty
 *  http://labs.blakeowens.com/frosty
 *
 *  Plugin boilerplate provied by: http://jqueryboilerplate.com/
 *  ========================================================================
 *  Copyright 2013 Blake Owens
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 *  and associated documentation files (the "Software"), to deal in the Software without restriction,
 *  including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 *  and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 *  subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all copies or
 *  substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT
 *  LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 *  IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 *  WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 *  SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *  ======================================================================== */
;(function ($, window, document, undefined) {

    var pluginName = "frosty";
    var defaults = {
        attribute: 'title',
        className: 'tip',
        content: '',
        delay: 0,
        hasArrow: true,
        html: false,
        offset: 30,
        position: 'left',
        removeTitle: true,
        selector: false,
        trigger: 'hover,focus',
        onHidden: function() {},
        onShown: function() {},

    };


    function Frosty(anchor, options) {
        this.anchor = anchor;
        this.$anchor = $(anchor);
        this.options = $.extend({}, defaults, options, this.$anchor.data());
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Frosty.prototype = {
        init: function () {
            this._createTip();
            this._bindEvents();
        },

        show: function() {
            var _this = this,
                delay = typeof this.options.delay === 'object' ? parseInt(this.options.delay.show) : parseInt(this.options.delay);

            clearTimeout(this.timeout);
            this.timeout = delay === 0 ?
                this._setState('visible') :
                setTimeout(function() { _this._setState('visible'); }, delay);
        },

        hide: function() {
            var _this = this
                delay = typeof this.options.delay === 'object' ? parseInt(this.options.delay.hide) : parseInt(this.options.delay);

            clearTimeout(this.timeout);
            this.timeout = delay === 0 ?
                this._setState('hidden') :
                setTimeout(function() { _this._setState('hidden'); }, delay);
        },

        toggle: function() {
            this.state === 'visible' ? this.hide() : this.show();
        },

        addClass: function(klass) {
            console.log("in");
            if (typeof klass === 'string') { this.$el.addClass(klass); }
        },

        removeClass: function(klass) {
            if (typeof klass === 'string') { this.$el.removeClass(klass); }
        },

        _setState: function(state) {
            this.state = state;
            switch (state) {
                case 'visible':
                    this.$el.appendTo('body');
                    this._checkContent();
                    this._setPosition();
                    this.options.onShown.call(this);
                    this.$anchor.trigger('shown');
                    break;
                case 'hidden':
                    this.$el.detach();
                    this.options.onHidden.call(this);
                    this.$anchor.trigger('hidden');
                    break;
            }
        },

        _checkContent: function() {
            if (this.options.selector) {
                this.tipContent = $(this.options.selector).html();
                this.$el.html(this.tipContent);
            }
        },

        _createTip: function() {
            if (this.options.html) {
                this.tipContent = this.options.content;
            } else if (this.options.selector) {
                this.tipContent = $(this.options.selector).html();
            } else {
                this.tipContent = this.$anchor.attr(this.options.attribute);
                if (this.options.attribute === 'title' && this.options.removeTitle) {
                    this.$anchor.attr('data-original-title', this.tipContent);
                    this.$anchor.removeAttr('title');
                }
            }


            this.$el = $('<div />', {
                'class': this.options.className,
                html: '<span class="cp_tooltip_text">'+this.tipContent+'</span>'
            }).css({
                'z-index': '9999999999',
                'left': '-9999px',
                'position': 'absolute',

            });

            this.$el.appendTo('body');
            var coords = this.getPosition();
            this.$el.detach().css(coords);

            if (this.options.hasArrow) { this._addArrowClass(); }
        },

        _addArrowClass: function() {
            switch (this.options.position) {
                case 'left':
                    this.$el.addClass('arrow-right');
                    break;
                case 'right':
                    this.$el.addClass('arrow-left');
                    break;
                case 'bottom':
                    this.$el.addClass('arrow-top');
                    break;
                default:
                    this.$el.addClass('arrow-bottom');
            }
        },

        _bindEvents: function() {
            switch (this.options.trigger) {
                case 'click':
                    this.$anchor.click($.proxy(this.toggle, this));
                    break
                case 'manual':
                    break;
                case 'focus':
                    this.$anchor.focus($.proxy(this.show, this));
                    this.$anchor.blur($.proxy(this.hide, this));
                    break;
                default:
                    this.$anchor.hover($.proxy(this.show, this), $.proxy(this.hide, this));
            }

            //$(window).resize($.proxy(this._setPosition, this));
        },

        getPosition: function () {
            var coords = this.$anchor.offset();
            switch (this.options.position) {
                case 'left':
                    coords.left = coords.left - this.$el.outerWidth() - this.options.offset;
                    coords.top = coords.top + (this.$anchor.outerHeight() / 2) - (this.$el.outerHeight() / 2);
                    break;
                case 'right':
                    coords.left = coords.left + this.$anchor.outerWidth() + this.options.offset;
                    coords.top = coords.top + (this.$anchor.outerHeight() / 2) - (this.$el.outerHeight() / 2);
                    break;
                case 'bottom':
                    coords.top = coords.top + this.$anchor.outerHeight() + this.options.offset;
                    coords.left = coords.left + (this.$anchor.outerWidth() / 2) - (this.$el.outerWidth() / 2);
                    break;
                default:
                    coords.top = coords.top - this.$el.outerHeight() - this.options.offset;
                    var left = coords.left + (this.$anchor.outerWidth() / 2) - (this.$el.outerWidth() / 2);
                    if( left < 0 )
                        left = 0;
                    coords.left = left;
            }
            //console.log(coords);
            return coords;
        },

        _setPosition: function() {
            this.$el.css(this.getPosition());
        }
    };

    $.fn[pluginName] = function (options, args) {
        //console.log($.data(this, "plugin_" + pluginName));
        if (typeof options === 'string') {
            //console.log(options);
            switch (options) {
                case 'show':
                    this.each(function() { $.data(this, "plugin_" + pluginName)['show'](); });
                    break;
                case 'hide':
                    this.each(function() { $.data(this, "plugin_" + pluginName)['hide'](); });
                    break;
                case 'toggle':
                    this.each(function() { $.data(this, "plugin_" + pluginName)['toggle'](); });
                    break;
                case 'addClass':
                    this.each(function() { $.data(this, "plugin_" + pluginName)['addClass'](args); });
                    break;
                case 'removeClass':
                    this.each(function() { $.data(this, "plugin_" + pluginName)['removeClass'](args); });
                    break;
            }
        }
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Frosty(this, options));
            }
        });
    };
})(jQuery, window, document);

(function($){
    $(document).ready(function(){
        $('.bsf-has-tip, .has-tip').each(function(i,tip){
            $tip = $(tip);
            var attribute = (typeof $tip.attr('data-attribute') != 'undefined') ? $tip.attr('data-attribute') : 'title';
            var offset = (typeof $tip.attr('data-offset') != 'undefined') ? $tip.attr('data-offset') : 10;
            var position = (typeof $tip.attr('data-position') != 'undefined') ? $tip.attr('data-position') : 'top';
            var trigger = (typeof $tip.attr('data-trigger')) ? $tip.attr('data-trigger') : 'hover,focus';
            var className = (typeof $tip.attr('data-classes') != 'undefined') ? 'tip '+$tip.attr('data-classes') : 'tip';
            $tip.frosty({
                className : className,
                attribute: attribute,
                offset: offset,
                position: position,
                trigger: trigger
            });
        });
    });
})(jQuery);
