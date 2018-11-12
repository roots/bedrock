import {Modal} from "./modal";

export class ModalHomeComponent extends Modal {
    setOptions() {
        const options = {
            background: "#acb3c2"
        }
        super.setOptions(options);
    }
}

window.pew.addRegistryEntry({key: 'wdf-modal-home', domSelector: '.wdf-modal-home', classDef: ModalHomeComponent});
