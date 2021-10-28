import "modaal/dist/js/modaal";
import {PewComponent} from "../../../assets/raw/js/components/pew-component";

// https://github.com/humaan/Modaal

export class ModalComponent extends PewComponent {
  constructor(element, passedOptions) {

    let defaultOptions = {
      //background: "#E4E4E4",
      //overlay_opacity: .9,
      fullscreen: false,
      close_text: "Fermer",
      source: ($triggeringElement, source) => {
        const triggerModalType = $triggeringElement.data('modaal-type');
        if (triggerModalType && (triggerModalType === 'ajax' || triggerModalType === 'iframe')) {
          if (source.indexOf('?') < 0) {
            source += '?forceajax=1';
          } else {
            source += '&forceajax=1';
          }
        }
        return source;
      }
    };

    //Recup / override des options par data attribut
    const dataSet = $(element).data();
    if (dataSet) {
      for (let i in dataSet) {
        if (i.includes("modaal")) {
          let optIndex = i.replace('modaal', '').toLowerCase();
          defaultOptions[optIndex] = dataSet[i];
        }
      }
    }

    defaultOptions['ajax_success'] = ($modal_wrapper) => {
      this.initLoadedContent($modal_wrapper);
    };

    if (defaultOptions['type'] && defaultOptions['type'] === 'inline') {
      defaultOptions.after_open = ($modal_wrapper) => {
        this.initLoadedContent($modal_wrapper);
      }
    }

    if (window && window.wonderwp && window.wonderwp.i18n && window.wonderwp.i18n['close.trad']) {
      defaultOptions.close_text = window.wonderwp.i18n['close.trad'];
    }

    let opts = Object.assign(defaultOptions, passedOptions);

    super(element, opts);
  }

  init() {
    this.element.modaal(this.options);
  }

  initLoadedContent($modal_wrapper) {
    window.pew.enhanceRegistry($modal_wrapper[0]);
    $modal_wrapper.find('.transitionning').removeClass('transitionning');
  }
}

// Default
window.pew.addRegistryEntry({key: "wdf-modal", domSelector: ".wdf-modal", classDef: ModalComponent});
