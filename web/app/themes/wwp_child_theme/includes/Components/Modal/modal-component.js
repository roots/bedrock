import {Modal} from "../../../styleguide/js/components/modal";

export const ModalSelector = '.wdf-modal';

export class ModalComponent extends Modal {

}
window.pew.addRegistryEntry({key: 'wdf-modal', domSelector: ModalSelector, classDef: ModalComponent});