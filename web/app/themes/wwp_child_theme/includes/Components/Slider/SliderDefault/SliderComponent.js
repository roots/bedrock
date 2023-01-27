import {tns} from "tiny-slider/dist/tiny-slider";
import {PewComponent} from "../../../../assets/raw/js/components/pew-component";

export class SliderComponent extends PewComponent {

  constructor(element, options) {
    // see http://ganlanyuan.github.io/tiny-slider/#options
    let defaultOptions = {
      mode: 'carousel',
      slideBy: 'page',
      autoplay: false,
      autoplayPosition: 'bottom',
      nav: true,
      autoHeight: true,
      speed: 500,
      autoplayTimeout: 3000
    };
    super(element, Object.assign(defaultOptions,options));
  }

  init() {
    if (!this.options.container) {
      this.options.container = this.element[0];
    }
    this.slider = tns(this.options);
  }
}

window.pew.addRegistryEntry({key: 'wdf-slider', domSelector: '[class$="wdf-slider"]', classDef: SliderComponent});
