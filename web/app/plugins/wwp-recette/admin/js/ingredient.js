/**
 * Created by jeremydesvaux on 06/09/2016.
 */
(function($,ns){

    var ingredientComponent = function($context,givenOptions) {
        var defaultOptions = {
            $wrap: $context.find('.ingredient-form')
        };
        this.options = $.extend(defaultOptions,givenOptions);
        this.$wrap = this.options.$wrap;

        if(this.$wrap.length){
            this.init();
        }

    };
    ingredientComponent.prototype = {

        init: function(){
            if(this.$wrap.length) {
                this.bindUiActions();
            }
        },
        bindUiActions: function(){
            var t =this;

            /**
             * Check slug
             */
            console.log(this.$wrap.find('.translations-wrap .input-wrap'));
            this.$wrap.find('.translations-wrap .input-wrap:first input.text').on('change',function(){
               var newTitle = $(this).val(),
                   newSlug = ns.adminApp.stringToSlug(newTitle);
                t.$wrap.find('#slug').val(newSlug);
            });

        }

    };

    ns.adminComponents = ns.adminComponents || {};
    ns.adminComponents.ingredientComponent = ingredientComponent;

})(jQuery,window.wonderwp);