import {SliderComponent} from "../SliderDefault/SliderComponent";

export class SliderGalleryComponent extends SliderComponent {
  constructor(element, options) {
    // see http://ganlanyuan.github.io/tiny-slider/#options
    let defaultOptions = {
      mode: 'carousel',
      items: 2,
      autoWidth: true,
      gutter: 20,
      center: true,
      slideBy: 1,
      speed: 400,
      mouseDrag: true,
      loop: true,
      autoplay: false,
      freezable: false,
      lazyload: true
    };
    super(element, Object.assign(defaultOptions,options));
  }

  init() {
    super.init();
    setTimeout(()=>{
      const {isOn} = this.slider.getInfo();
      if(!isOn){
        this.slider.destroy();
        this.slider.rebuild();
      }
    },1000);
  }
}


window.pew.addRegistryEntry({key: 'wwp-galerie-slider', domSelector: '.wwp-galerie-slider', classDef: SliderGalleryComponent});
