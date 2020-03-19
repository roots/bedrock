import "../../../../../../../node_modules/bxslider/dist/jquery.bxslider.js";
import {PewComponent} from "../../../assets/raw/js/components/pew-component";

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
  stopAutoOnClick: true,
  adaptiveHeight: true,
  touchEnabled: (window.innerWidth<1025 && window.wonderwp.FeatureDetector.has('touch'))
};

export class SliderComponent extends PewComponent {
  constructor(element) {
    super(element, SliderOptions);
  }

  init() {
    this.slider = this.element.bxSlider(this.options);
    $(document).on('ready', () => {
      this.reloadSlider('domready');
    });
    setTimeout(() => {
      this.reloadSlider('timeout');
    }, 1000);
  }

  reloadSlider(origin) {
    this.slider.reloadSlider(this.options);
  }
}

window.pew.addRegistryEntry({key: 'wdf-slider', domSelector: '.wdf-slider', classDef: SliderComponent});
