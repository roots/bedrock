import {Slider} from "./slider";

export const SliderDefaultSelector = '.wdf-slider';

export class SliderHomeComponent extends Slider {
    setOptions() {
        const options = {
            speed: 1500
        }
        super.setOptions(options);
    }
}
window.pew.addRegistryEntry({key: 'wdf-slider-home', domSelector: SliderDefaultSelector, classDef: SliderHomeComponent});



export const SliderContent = '.wdf-slider-content';

export class SliderContentComponent extends Slider {
    setOptions() {
        const options = {
            pager: false
        }
        super.setOptions(options);
    }
}
window.pew.addRegistryEntry({key: 'wdf-slider-content', domSelector: SliderContent, classDef: SliderContentComponent});
