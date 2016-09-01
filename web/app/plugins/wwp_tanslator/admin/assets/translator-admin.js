(function($,ns){

    var translatorComponent = function($context,givenOptions) {
        var defaultOptions = {
            $wrap: $context.find('.keyTableEditor')
        };
        this.options = $.extend(defaultOptions,givenOptions);
        this.$wrap = this.options.$wrap;
        this.init();
    };
    translatorComponent.prototype = {

        init: function(){
            if(this.$wrap.length) {
                this.bindUiActions();
            }
        },
        bindUiActions: function(){
            var t =this;
            /**
             * Delete row
             */
            this.$wrap.find('.rowDeleter').on('click',function(e){
               e.preventDefault();
                $(this).parents('tr').remove();
            });
            /**
             * Add Row
             */
            this.$wrap.find('.rowAdder').on('click',function(e){
                e.preventDefault();
                var lastRow = t.$wrap.find('table tr:last').clone(true);
                lastRow.find('input').each(function(){
                   $(this).val('');
                });
                t.$wrap.find('table').append(lastRow);

            });
        }

    };

    ns.adminComponents = ns.adminComponents || {};
    ns.adminComponents.translatorComponent = translatorComponent;

})(jQuery,window.wonderwp);