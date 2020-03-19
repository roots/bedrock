import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export class DropdownComponent extends PewComponent {
    constructor(element) {
        super(element);
    }

    init() {
        this.element.find('.dropdown-trigger').on('click', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('open')
        });


      /*
      //Code si on veut du hover à la place du click :

      if (wonderwp.FeatureDetector.has('touch')) {

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
      } */
    }
}

window.pew.addRegistryEntry({key: 'wdf-dropdown', domSelector: '.wdf-dropdown', classDef: DropdownComponent});
