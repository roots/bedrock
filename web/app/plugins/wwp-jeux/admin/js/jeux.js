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
            this.registerLots();
        },
        registerLots: function () {
            var t = this;

            this.$wrap.find('.lot').each(function () {
                new Lot($(this));
            });

            /**
             * Add Lot
             */
            this.$wrap.find('#add-lot').on('click', function (e) {
                e.preventDefault();
                var newStepId = '_newlot_',
                    thisStepId = (t.$wrap.find('.form-group-lots .lot').length) + 1,
                    $clone = t.$wrap.find('#lots' + newStepId).clone(),
                    cloneMarkup = $clone[0].outerHTML.replace(/_newlot_/gi, '_newlot_'+thisStepId),
                    $cloneMarkup = $(cloneMarkup);

                $cloneMarkup.removeClass('nouveau-lot hidden').addClass('lot');
                $cloneMarkup.find('.lot-id').val('_newlot_'+thisStepId);
                $cloneMarkup.insertBefore($(this).parent());

                var $closeBtn = $('<button class="button remove-lot">Supprimer</button>');
                $cloneMarkup.after($closeBtn);

                new Lot($cloneMarkup);

            });

        },
        initIngredientPickers: function () {
            var t = this;
            /**
             * Ingredients pickers
             */
            this.$wrap.find('.form-group-ingredients legend').on('click', function () {
                t.$wrap.find('.ingredientsPicker').trigger("chosen:updated");
            });

            var chosenOpts = {
                width: "99%",
                search_contains: true
            };
            t.$wrap.find('#ingredients').chosen(chosenOpts);

            //Update other pickers when an ingredient is changed from the main picker
            t.$wrap.find('#ingredients').change(function (evt, changed) {
                var optionValue = null,
                    action = null;
                if (changed.selected) {
                    action = 'add';
                    optionValue = changed.selected;
                }
                if (changed.deselected) {
                    action = 'remove';
                    optionValue = changed.deselected;
                }

                if (action == 'add') {
                    var $selectedOption = $(this).find('option[value="' + optionValue + '"]');
                    t.$wrap.find('.ingredientsPicker').each(function () {
                        var $picker = $(this);
                        if ($picker.attr('id') !== 'ingredients') {
                            $picker.append($selectedOption[0].outerHTML);
                            var options = $picker.find('option');
                            var arr = options.map(function (_, o) {
                                return {
                                    t: $(o).text(),
                                    v: o.value
                                };
                            }).get();
                            arr.sort(function (o1, o2) {
                                return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
                            });
                            options.each(function (i, o) {
                                o.value = arr[i].v;
                                $(o).text(arr[i].t);
                            });
                            $picker.trigger("chosen:updated");
                        }
                    });
                }
                if (action == 'remove') {
                    t.$wrap.find('.ingredientsPicker').each(function () {
                        var $picker = $(this);
                        if ($picker.attr('id') !== 'ingredients') {
                            var $toRemove = $picker.find('option[value="' + optionValue + '"]');
                            if ($toRemove.length) {
                                $toRemove.remove();
                                $picker.trigger("chosen:updated");
                            }
                        }
                    });
                }
            });

        }
    };

    var Lot = function ($wrap) {
        this.$wrap = $wrap;
        this.id = $wrap.find('input.lot-id').val();
        this.init();
    }
    Lot.prototype = {
        init: function () {
            this.bindUiActions();
            this.registerIngredients();
            this.initIngredientPickers();
        },
        bindUiActions: function () {
            /**
             * Remove lot
             */
            this.$wrap.next('.remove-lot').on('click', function (e) {
                e.preventDefault();
                $(this).prev().slideUp('slow',function(){
                    $(this).remove();
                });
                $(this).remove();
            });
            /**
             * Image upload
             */
            new ns.mediaField(this.$wrap.find('.media-wrap'));
        },
        registerIngredients: function () {
            this.$wrap.find('.stepIngredients li').each(function () {
                new LotIngredient($(this), null, this.id);
            })
        },
        initIngredientPickers: function () {
            var t = this;
            /**
             * Ingredients pickers
             */
            var chosenOpts = {
                width: "99%",
                search_contains: true
            };
            t.$wrap.find('.ingredientsPicker').chosen(chosenOpts).on('change', function (evt, changed) {

                if (changed.selected) {
                    var optionValue = changed.selected;
                    var $selectedOption = $(this).find('option[value="' + optionValue + '"]');
                    console.log(optionValue, $selectedOption);

                    var ingredient = {id: optionValue, title: $selectedOption.html()};
                    var newLotIngredient = new LotIngredient(null,ingredient,t.id);
                    t.$wrap.find('.stepIngredients').append(newLotIngredient.$wrap);
                    newLotIngredient.$wrap.find('a').trigger('click');
                }
            });

        },
    };

    var LotIngredient = function ($wrap, ingredient, lotId) {
        if ($wrap && $wrap.length) {
            this.ingredient = {
                id: $wrap.find('.ingredient-id').val(),
                title: $wrap.find('.ingredient-id').data('name')
            };
            this.qty = $wrap.find('.ingredient-qty').val();
            this.unit = {
                id: $wrap.find('.ingredient-unit').val(),
                title: $wrap.find('.ingredient-unit').data('name')
            };
            this.$wrap = $wrap;
        } else {
            this.ingredient = ingredient || {id: 0, title: ''};
            this.qty = 0;
            this.unit = {id: 0, title: ''};
            this.createWrap();
        }
        this.lot = lotId;
        this.init();

        console.log();
    }
    LotIngredient.prototype = {
        init: function () {
            this.bindUiActions();
        },
        createWrap: function () {
            if(!this.$wrap){ this.$wrap = $('<li></li>'); }
            this.$wrap.removeClass('hasForm');
            this.$wrap.html(
                '<a href="#">' + (this.qty>0 ? this.qty : '') + ' ' + this.unit.title + ' ' + this.ingredient.title + '</a>' +
                '<input type="hidden" class="ingredient-qty" name="lots[' + this.lot + '][ingredients][' + this.ingredient.id + '][qty]" value="' + this.qty + '" />' +
                '<input type="hidden" class="ingredient-unit" data-name="' + this.unit.title + '" name="lots[' + this.lot + '][ingredients][' + this.ingredient.id + '][unit]" value="' + this.unit.id + '" />' +
                '<input type="hidden" class="ingredient-id" data-name="' + this.ingredient.title + '" name="lots[' + this.lot + '][ingredients][' + this.ingredient.id + '][id]" value="' + this.ingredient.id + '" />'+
                '<button class="button delete-wrap">&times;</button>'
            );
        },
        bindUiActions: function () {
            var t = this;
            t.$wrap.on('click', 'a', function (e) {
                e.preventDefault();
                t.openEditForm();
            });
            t.$wrap.on('click', '.delete-wrap', function(e){
                e.preventDefault();
                t.$wrap.remove();
            });
        },
        openEditForm: function () {
            var t = this;
            if(!t.$editForm) {
                var $unitPicker = $('#unit_picker').clone();
                $unitPicker.find('option[value='+t.unit.id+']').attr('selected','selected');
                t.$editForm = $('<div class="ingredientEditBox">' +
                    '<form>' +
                    //qty
                    '<input type="number" name="qty-editor" value="' + this.qty + '" />' +
                    //Unit
                    '<select name="unit-editor">'+$unitPicker.html()+'</select>' +
                    //Ingredient
                    '<span>' + this.ingredient.title + '</span>' +
                    '<button type="submit" class="button">OK</button>'+
                    '</form>' +
                    '</div>');
                t.$editForm.find('form').on('submit',function(e){
                    e.preventDefault();
                    console.log($(this).find('input[name=unit-editor]').val());
                    t.qty = $(this).find('input[name=qty-editor]').val();
                    var newUnitId = $(this).find('select[name=unit-editor]').val();
                    if(newUnitId>0) {
                        t.unit = {
                            id: newUnitId,
                            title: $(this).find('select[name=unit-editor] option:selected').text()
                        };
                    }
                    t.$editForm.slideUp(function(){ t.$editForm=null; t.createWrap() });
                });
                t.$editForm.appendTo(t.$wrap).slideDown();
                t.$wrap.addClass('hasForm');
            }
        }
    };

    ns.adminComponents = ns.adminComponents || {};
    ns.adminComponents.jeuxComponent = jeuxComponent;

})(jQuery, window.wonderwp);