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
        super(element, ModalOptions);
    }

    init() {
        this.element.modaal(this.options);
    }
}

// Default
window.pew.addRegistryEntry({key: "wdf-modal", domSelector: ".wdf-modal", classDef: ModalComponent});