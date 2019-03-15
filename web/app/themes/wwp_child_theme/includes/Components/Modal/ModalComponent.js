import "modaal/dist/js/modaal";
import {PewComponent} from "../../../assets/raw/js/components/pew-component";

// https://github.com/humaan/Modaal
const ModalOptions = {

};

export class ModalComponent extends PewComponent {
    constructor(element) {
        super(element, ModalOptions);
    }
    init() {
        this.element.modaal(this.options);
    }
}

window.pew.addRegistryEntry({key: 'wdf-modal', domSelector: '.wdf-modal', classDef: ModalComponent});
