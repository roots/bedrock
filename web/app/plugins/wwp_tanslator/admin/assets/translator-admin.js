(function($){

    var translator = {

        init: function(){
            this.$wrap = $('.keyTableEditor');
            this.bindUiActions();
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

    translator.init();

})(jQuery);