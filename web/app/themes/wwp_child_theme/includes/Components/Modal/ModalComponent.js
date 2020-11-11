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

    //Recup / override des options par data attribut
    const dataSet = $(element).data();
    if (dataSet) {
      for (let i in dataSet) {
        if (i.includes("modaal")) {
          let optIndex = i.replace('modaal', '').toLowerCase();
          ModalOptions[optIndex] = dataSet[i];
        }
      }
    }

    super(element, ModalOptions);
  }

  init() {
    this.element.modaal(this.options);
  }
}

// Default
window.pew.addRegistryEntry({key: "wdf-modal", domSelector: ".wdf-modal", classDef: ModalComponent});
