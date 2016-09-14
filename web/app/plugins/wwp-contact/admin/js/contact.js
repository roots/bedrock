/**
 * Created by jeremydesvaux on 13/09/2016.
 */

(function($,ns){

    var contactComponent = function($context,givenOptions) {
        var defaultOptions = {
            $wrap: $context.find('.contact-form')
        };
        this.options = $.extend(defaultOptions,givenOptions);
        this.$wrap = this.options.$wrap;
        if(this.$wrap.length){
            this.init();
        }

    };
    contactComponent.prototype = {

        init: function(){
            if(this.$wrap.length) {
                this.bindUiActions();
            }
        },
        bindUiActions: function(){
            var t =this;

            /**
             * Add subject Line
             */
            this.$wrap.find('#add-subject').on('click',function(e){
                e.preventDefault();
                var newStepId = '_newSub_',
                    thisStepId = (t.$wrap.find('.sujet').length)+1,
                    $clone = t.$wrap.find('#subject'+newStepId).clone(),
                    cloneMarkup = $clone[0].outerHTML.replace(/_newSub_/gi,thisStepId),
                    $cloneMarkup = $(cloneMarkup);

                $cloneMarkup.removeClass('nouveau-sujet hidden').addClass('sujet');
                $cloneMarkup.insertBefore($(this).parent());
            });

            /**
             * Remove subject line
             */
            this.$wrap.find('.remove-subject').on('click',function(e){
                e.preventDefault();
                $(this).parent().remove();
            });

            /**
             * Enable sorting
             */
            this.$wrap.find( "#data" ).sortable({
                axis: 'y',
                containment: 'parent',
                handle: '.dragHandle',
                tolerance: 'pointer'
            });
        }

    };

    ns.adminComponents = ns.adminComponents || {};
    ns.adminComponents.contactComponent = contactComponent;

})(jQuery,window.wonderwp);