export class PewComponent {
    constructor(element, options) {
        this.element = (element instanceof jQuery) ? element : $(element);

        this.options = {};
        this.setOptions(options);

        this.init();
    }
    setOptions(options) {
        this.options = Object.assign(this.options, options);
    }
    init() {
        console.info('Override this in parent.');
    }
}
