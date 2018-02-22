import "bxslider"
import {PewComponent} from "../pew-component";

// see https://bxslider.com/options/
const SliderOptions = {
    mode: 'horizontal',
    autoControlsCombine: true,
    keyboardEnabled: true,
    easing: 'ease-in-out',
    speed: 700,
    auto: true,
    autoControls: false,
    pager: true,
    stopAutoOnClick: true
};

export class Slider extends PewComponent {
    constructor(element) {
        super(element, SliderOptions);
    }
    init() {
        this.element.bxSlider(this.options);
    }
}