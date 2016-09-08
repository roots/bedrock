/**
 * Created by jeremydesvaux on 06/09/2016.
 */
(function($,ns){

    var recetteComponent = function($context,givenOptions) {
        var defaultOptions = {
            $wrap: $context.find('.recette-form')
        };
        this.options = $.extend(defaultOptions,givenOptions);
        this.$wrap = this.options.$wrap;
        if(this.$wrap.length){
            this.init();
        }

    };
    recetteComponent.prototype = {

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
                //$(this).parents('tr').remove();
            });
            /**
             * Add Row
             */
            this.$wrap.find('#add-etape').on('click',function(e){
                e.preventDefault();
                var newStepId = '_newstep_',
                    thisStepId = (t.$wrap.find('.form-group-etapes .etape').length)+1,
                    $clone = t.$wrap.find('#etapes'+newStepId).clone(),
                    cloneMarkup = $clone[0].outerHTML.replace(/_newstep_/gi,thisStepId),
                    $cloneMarkup = $(cloneMarkup);

                $cloneMarkup.removeClass('nouvelle-etape hidden').addClass('etape');
                $cloneMarkup.insertBefore($(this).parent());
            });
        }

    };

    ns.adminComponents = ns.adminComponents || {};
    ns.adminComponents.recetteComponent = recetteComponent;

})(jQuery,window.wonderwp);