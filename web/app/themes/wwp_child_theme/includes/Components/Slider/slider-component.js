import {Slider} from "../../../styleguide/js/components/slider"

export const SliderDefaultSelector = '.wdf-slider';

export class SliderComponent {
    constructor(dom) {
        this.dom = dom;
        this.init();
    }
    init() {
        let options = {
            speed: 400
        };
        new Slider(this.dom, options);
    }
}
window.pew.addRegistryEntry({key: 'wdf-slider', domSelector: SliderDefaultSelector, classDef: SliderComponent});