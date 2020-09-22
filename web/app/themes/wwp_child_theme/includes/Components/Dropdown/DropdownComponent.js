import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export class DropdownComponent extends PewComponent {
  constructor(element) {
    super(element);
  }

  init() {
    if ("ontouchstart" in document.documentElement) {

      this.element.find('.dropdown-hover-trigger').on('click', function (e) {

        let $openedElt = $('.wdf-dropdown.open');
        let $parentElt = $(this).parents('.wdf-dropdown');
        if ($openedElt.index('.wdf-dropdown') === $parentElt.index('.wdf-dropdown')) {
          $parentElt.toggleClass('open');
        } else {
          $openedElt.removeClass('open');
          $parentElt.addClass('open');
        }

        $(document).click(function (event) {
          let $target = $(event.target);
          if (!$target.closest('.wdf-dropdown.open').length && $('.wdf-dropdown.open').length) {
            $('.wdf-dropdown.open').removeClass('open');
          }
        });

      });

    } else {
      this.element.find('.dropdown-hover-trigger').hover(function (e) {
        $(this).parents('.wdf-dropdown').addClass('open')
      }, function () {
        $(this).parents('.wdf-dropdown').removeClass('open')
      });
      this.element.find('.dropdown-hover-trigger button').focus(function (e) {
        $(this).parents('.wdf-dropdown').addClass('open')
      });
      this.element.find('.dropdown-hover-trigger button').blur(function (e) {
        $(this).parents('.wdf-dropdown').removeClass('open')
      });
    }

  }
}

window.pew.addRegistryEntry({key: 'wdf-dropdown', domSelector: '.wdf-dropdown', classDef: DropdownComponent});
