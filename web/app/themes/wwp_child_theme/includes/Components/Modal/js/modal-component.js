import {Modal} from "./modal";

export class ModalExampleComponent extends Modal {
    setOptions() {
        const options = {

        }
        super.setOptions(options);
    }
}

window.pew.addRegistryEntry({key: 'wdf-modal-example', domSelector: '.wdf-modal', classDef: ModalExampleComponent});

