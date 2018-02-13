import "bxslider"

var SliderOptions = {
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

export class Slider {
    constructor(element, options) {
        this.element = (element instanceof jQuery) ? element : $(element);
        this.options = (options) ? Object.assign(SliderOptions, options) : SliderOptions;
        this.init();
    }
    init() {
        var self = this;
        this.element.each(function(){
            var $sliderWrap = $(this);
            $sliderWrap.bxSlider(self.options);
        })
    }
}