import "modaal/dist/js/modaal";
import {PewComponent} from "./pew-component";

// https://github.com/humaan/Modaal
const ModalOptions = {
    type: "inline",
    animation: "fade",
    animation_speed: 300,
    after_callback_delay : 350,
    is_locked: false,
    hide_close: false,
    background: "#000",
    overlay_opacity: 0.8,
    overlay_close: true,
    accessible_title: "Dialog Window",
    start_open: false,
    fullscreen: false,
    custom_class: '',
    background_scroll: false,
    should_open: true,
    close_text: 'Close',
    close_aria_label: 'Close (Press escape to close)',
    width: null,
    height: null,
    gallery_active_class: 'gallery_active_item',
    confirm_button_text: 'Confirm',
    confirm_cancel_button_text: 'Cancel',
    confirm_title: 'Confirm Title',
    confirm_content: '<p>This is the default confirm dialog content. Replace me through the options</p>',
    loading_content: 'Loading &hellip;',
    loading_class: 'is_loading',
    ajax_error_class: 'modaal-error',
    instagram_id: null
};

export class Modal extends PewComponent {
    constructor(element) {
        super(element, ModalOptions);
    }
    init() {
        this.element.modaal(this.options);
    }
}