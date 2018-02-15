export class PewComponent {
    constructor(element, options) {
        this.element = (element instanceof jQuery) ? element : $(element);
        this._options = Object.assign({}, options);
        this.options = {};
        this.setOptions();
        this.init();
    }
    setOptions(options) {
        this.options = Object.assign(this._options, options);
    }
    init() {
        console.info('Override this in parent.');
    }
}