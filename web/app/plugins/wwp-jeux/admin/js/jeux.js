/**
 * Created by jeremydesvaux on 14/11/2016.
 */
(function ($, ns) {

    var jeuxComponent = function ($context, givenOptions) {
        var defaultOptions = {
            $wrap: $context.find('.jeux-form')
        };
        this.options = $.extend(defaultOptions, givenOptions);
        this.$wrap = this.options.$wrap;
        if (this.$wrap.length) {
            this.init();
        }

    };
    jeuxComponent.prototype = {

        init: function () {
            if (this.$wrap.length) {
                this.bindUiActions();
            }
        },
        bindUiActions: function () {
            this.registerRepeatables();
        },
        registerRepeatables: function () {
            var t = this;

            this.$wrap.find('.repeatable').each(function () {
                new Repeatable($(this));
            });

            /**
             * Add Repeatable
             */
            this.$wrap.find('.add-repeatable').on('click', function (e) {
                e.preventDefault();
                var newStepId = '_newrepeatable_',
                    cloneId = $(this).data('repeatable'),
                    thisStepId = ($('.repeatable').length) + 1,
                    $clone = t.$wrap.find('.'+cloneId).clone(),
                    re = new RegExp(cloneId,"g"),
                    cloneMarkup = $clone[0].outerHTML.replace(re, '_newrepeatable_'+thisStepId),
                    $cloneMarkup = $(cloneMarkup);
                console.log(cloneId);

                $cloneMarkup.removeClass('nouveau-repeatable hidden').addClass('repeatable');
                $cloneMarkup.find('.repeatable-id').val('_newrepeatable_'+thisStepId);
                $cloneMarkup.insertBefore($(this).parent());

                var $closeBtn = $('<button class="button remove-repeatable">Supprimer</button>');
                $cloneMarkup.after($closeBtn);

                new Repeatable($cloneMarkup);

            });

        }
    };

    var Repeatable = function ($wrap) {
        this.$wrap = $wrap;
        console.log($wrap);
        this.id = $wrap.find('input.repeatable-id').val();
        this.init();
    };
    Repeatable.prototype = {
        init: function () {
            this.bindUiActions();
        },
        bindUiActions: function () {
            /**
             * Remove repeatable
             */
            this.$wrap.next('.remove-repeatable').on('click', function (e) {
                e.preventDefault();
                $(this).prev().slideUp('slow',function(){
                    $(this).remove();
                });
                $(this).remove();
            });
            /**
             * Image upload
             */
            if(this.$wrap.find('.media-wrap').length) {
                new ns.mediaField(this.$wrap.find('.media-wrap'));
            }
        }
    };

    ns.adminComponents = ns.adminComponents || {};
    ns.adminComponents.jeuxComponent = jeuxComponent;

})(jQuery, window.wonderwp);