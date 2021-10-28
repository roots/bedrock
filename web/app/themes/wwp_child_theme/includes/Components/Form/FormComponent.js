//import "jquery-validation";
import "selectric";
import {PewComponent} from "../../../assets/raw/js/components/pew-component";
//import "pikaday/plugins/pikaday.jquery";


// Do not modify this class for child theme customization reasons. See inheritance example below instead.
export class FormComponent extends PewComponent {
  constructor(element) {
    super(element);
  }

  init() {
    this.addFormDataMark();
    //this.setDefaultValidators();
    this.setDefaultInputStyles();
    //this.addCustomValidators();
    //this.validate();
    this.registerResetEvent();
  }

  addFormDataMark() {
    this.element.attr('data-form-component-mark', Date.now());
  }

  addCustomValidators() {
  }

  setCustomMessages() {
    //more informations : https://www.pierrefay.fr/blog/jquery-validate-formulaire-validation-tutoriel.html

    /* i18n format example to feed with jsConfig
    window.wonderwp.i18n.validator = {
        'validator.message.required' : "votre message",
        'validator.message.minlength': "votre message {0} caractéres.",
        'validator.message.regex': 'TOTOOTOT'
    };*/

    let i18n = (window.wonderwp.i18n && window.wonderwp.i18n.validator) ? window.wonderwp.i18n.validator : null;
    if (i18n) {
      let keys = Object.keys(i18n);
      let messages = {};
      keys.forEach((key) => {
        let validatorKey = key.replace('validator.message.', '');
        let value = i18n[key];
        messages[validatorKey] = value;
      });

      $.extend($.validator.messages, messages);
    }
  }

  addValidationRule(key, rule) {
    if (!this.rules) {
      this.rules = {};
    }
    this.rules[key] = rule;
  }

  validate() {
    let form = $(this.element[0]);
    form.validate({
      rules: this.rules
    });
  }

  setDefaultValidators() {
    this.addValidatorPhone();
    this.addValidatorDateFr();
    this.setCustomMessages();
  }

  setDefaultInputStyles() {
    this.improveSelectInput();
    //this.improveDateInput();
  }

  addValidatorPhone() {
    $.validator.addMethod(
      "regex",
      function (value, element, regexp) {
        if (regexp.constructor != RegExp)
          regexp = new RegExp(regexp);
        else if (regexp.global)
          regexp.lastIndex = 0;
        return this.optional(element) || regexp.test(value);
      }, 'Format invalide'
    );
    this.addValidationRule('telephone', {
      required: true,
      regex: /^(\+33\.|0)[0-9]{9}$/
    });
  }

  addValidatorDateFr() {
    $.validator.addMethod(
      "date_fr",
      function (value, element) {
        // put your own logic here, this is just a (crappy) example
        return value.match(/^\d\d?-\d\d?-\d\d\d\d$/);
      },
      "Please enter a date in the format dd-mm-yyyy."
    );
    this.addValidationRule('date', {
      date_fr: true,

    });
  }

  improveSelectInput() {
    let select = this.element.find('select');
    select.each((index, item) => {

      $(item).selectric();
      let $wrappers = $('.selectric-wrapper');

      let label = document.createElement('label');
      label.classList.add('error');
      label.setAttribute('for', item.id);
      label.setAttribute('id', item.id + '-error');
      $(label).insertBefore($wrappers[index]);
    });
  }

  improveDateInput() {
    let div = document.createElement('div');
    div.classList.add('date-picker');
    $(div).insertAfter("#date");
    $('#date').pikaday({
      firstDay: 1,
      format: 'DD-MM-YYYY',
      container: div
    });
  }

  reset() {
    this.element[0].reset();
    //Reset js enhanced fields like selects for example
    //Reset selects`
    let $selectsToReset = this.element.find('select');
    $($selectsToReset).each((i, select) => {
      let selectricInstance = $(select).data('selectric');
      if (selectricInstance) {
        selectricInstance.close();
        selectricInstance.refresh();
      }
    });
  }

  registerResetEvent() {
    const EventManager = window.EventManager || $(document);
    EventManager.on('form-reset', (event, eventData) => {
      const $formToReset = eventData.form;
      if ($formToReset && $formToReset.data('form-component-mark') && $formToReset.data('form-component-mark') === this.element.data('form-component-mark')) {
        this.reset();
      }
    });
  }
}

window.pew.addRegistryEntry({key: 'wdf-form-manager', domSelector: '.wwpform', classDef: FormComponent});

/*
Override example to use wherever you want :

export class CustomFormManager extends FormManager {
    constructor(element) {
        super(element);
    }

    addCustomValidators() {
        this.addValidatorDateEn();
    }

    addValidatorDateEn() {
        $.validator.addMethod(
            "date_en",
            function(value, element) {
                // put your own logic here, this is just a (crappy) example
                return value.match(/^\d\d?-\d\d?-\d\d\d\d$/);
            },
            "Please enter a date in the format dd-mm-yyyy LULULULUL."
        );
        this.addValidationRule('date', {
            date_en: true
        });
    }
}

window.pew.addRegistryEntry({key: 'wdf-form-manager', domSelector: '.validate-form', classDef: CustomFormManager});
*/
