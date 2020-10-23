import "modaal/dist/js/modaal";
import {PewComponent} from "../../../assets/raw/js/components/pew-component";

// https://github.com/humaan/Modaal
const ModalOptions = {
  background: "#E4E4E4",
  overlay_opacity: .9,
  fullscreen: false
};

export class ModalComponent extends PewComponent {
  constructor(element) {
    if ($(element).data('modaal-type')) {
      ModalOptions['type'] = $(element).data('modaal-type');
    }
    ModalOptions['ajax_success'] = function ($modal_wrapper) {
      window.pew.enhanceRegistry($modal_wrapper[0]);
      $modal_wrapper.find('.transitionning').removeClass('transitionning');
    };
    super(element, ModalOptions);
  }

  init() {
    this.element.modaal(this.options);
  }
}

// Default
window.pew.addRegistryEntry({key: "wdf-modal", domSelector: ".wdf-modal", classDef: ModalComponent});
