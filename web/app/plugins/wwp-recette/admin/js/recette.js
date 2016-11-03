/**
 * Created by jeremydesvaux on 06/09/2016.
 */
(function ($, ns) {

    var recetteComponent = function ($context, givenOptions) {
        var defaultOptions = {
            $wrap: $context.find('.recette-form')
        };
        this.options = $.extend(defaultOptions, givenOptions);
        this.$wrap = this.options.$wrap;
        if (this.$wrap.length) {
            this.init();
        }

    };
    recetteComponent.prototype = {

        init: function () {
            if (this.$wrap.length) {
                this.bindUiActions();
            }
        },
        bindUiActions: function () {
            this.checkSlug();
            this.registerEtapes();
            this.initIngredientPickers();
        },
        checkSlug: function () {
            /**
             * Check slug
             */
            var t = this;
            this.$wrap.find('.title-wrap input.text').on('change', function () {
                var newTitle = $(this).val(),
                    newSlug = ns.adminApp.stringToSlug(newTitle);
                t.$wrap.find('#slug').val(newSlug);
            });
        },
        registerEtapes: function () {
            var t = this;

            this.$wrap.find('.etape').each(function () {
                new Etape($(this));
            });

            /**
             * Add Etape
             */
            this.$wrap.find('#add-etape').on('click', function (e) {
                e.preventDefault();
                var newStepId = '_newstep_',
                    thisStepId = (t.$wrap.find('.form-group-etapes .etape').length) + 1,
                    $clone = t.$wrap.find('#etapes' + newStepId).clone(),
                    cloneMarkup = $clone[0].outerHTML.replace(/_newstep_/gi, '_newstep_'+thisStepId),
                    $cloneMarkup = $(cloneMarkup);

                $cloneMarkup.removeClass('nouvelle-etape hidden').addClass('etape');
                $cloneMarkup.find('.chosen-container').remove();
                $cloneMarkup.find('.etape-id').val('_newstep_'+thisStepId);
                $cloneMarkup.insertBefore($(this).parent());

                var $closeBtn = $('<button class="button remove-etape">Supprimer</button>');
                $cloneMarkup.after($closeBtn);

                new Etape($cloneMarkup);

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

    var Etape = function ($wrap) {
        this.$wrap = $wrap;
        this.id = $wrap.find('input.etape-id').val();
        this.init();
    }
    Etape.prototype = {
        init: function () {
            this.bindUiActions();
            this.registerIngredients();
            this.initIngredientPickers();
        },
        bindUiActions: function () {
            /**
             * Remove etape
             */
            this.$wrap.next('.remove-etape').on('click', function (e) {
                e.preventDefault();
                $(this).prev().slideUp('slow',function(){
                    $(this).remove();
                });
                $(this).remove();
            });
        },
        registerIngredients: function () {
            this.$wrap.find('.stepIngredients li').each(function () {
                new EtapeIngredient($(this), null, this.id);
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
                    var newEtapeIngredient = new EtapeIngredient(null,ingredient,t.id);
                    t.$wrap.find('.stepIngredients').append(newEtapeIngredient.$wrap);
                    newEtapeIngredient.$wrap.find('a').trigger('click');
                }
            });

        },
    };

    var EtapeIngredient = function ($wrap, ingredient, etapeId) {
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
        this.etape = etapeId;
        this.init();

        console.log();
    }
    EtapeIngredient.prototype = {
        init: function () {
            this.bindUiActions();
        },
        createWrap: function () {
            if(!this.$wrap){ this.$wrap = $('<li></li>'); }
            this.$wrap.removeClass('hasForm');
            this.$wrap.html(
                '<a href="#">' + (this.qty>0 ? this.qty : '') + ' ' + this.unit.title + ' ' + this.ingredient.title + '</a>' +
                '<input type="hidden" class="ingredient-qty" name="etapes[' + this.etape + '][ingredients][' + this.ingredient.id + '][qty]" value="' + this.qty + '" />' +
                '<input type="hidden" class="ingredient-unit" data-name="' + this.unit.title + '" name="etapes[' + this.etape + '][ingredients][' + this.ingredient.id + '][unit]" value="' + this.unit.id + '" />' +
                '<input type="hidden" class="ingredient-id" data-name="' + this.ingredient.title + '" name="etapes[' + this.etape + '][ingredients][' + this.ingredient.id + '][id]" value="' + this.ingredient.id + '" />'+
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
    ns.adminComponents.recetteComponent = recetteComponent;

})(jQuery, window.wonderwp);