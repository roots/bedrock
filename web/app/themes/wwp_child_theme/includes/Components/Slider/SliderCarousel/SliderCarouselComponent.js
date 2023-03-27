import {SliderComponent} from "../SliderDefault/SliderComponent";

export class SliderCarouselComponent extends SliderComponent {
  constructor(element, options) {
    // see http://ganlanyuan.github.io/tiny-slider/#options
    let defaultOptions = {
      mode: 'carousel',
      items: 3,
      gutter: 20,
      autoplay: false,
      prevButton: false,
      nav: true
    };
    super(element, Object.assign(defaultOptions,options));
    this.slider = null;
  }
}


window.pew.addRegistryEntry({key: 'wdf-slider-carousel', domSelector: '.wdf-slider-carousel', classDef: SliderCarouselComponent});
