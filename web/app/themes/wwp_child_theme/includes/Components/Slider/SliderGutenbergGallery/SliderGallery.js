import {SliderComponent} from "../SliderDefault/SliderComponent";

export default class SliderGallery extends SliderComponent {

  init() {
    setTimeout(() => {
      const $firstElt = this.element.find('>*:first');
      const slideWidth = $firstElt.width();
      const slideMargin = $firstElt.css('margin-right').replace('px', '');

      let $parent = this.element.parent();
      let numOfSlides = 1;
      for (let i = 1; i <= 4; i++) {
        if ($parent.hasClass('columns-' + i)) {
          numOfSlides = i;
        }
      }

      console.log(this.element, $firstElt, slideWidth, slideMargin, numOfSlides);

      this.setOptions({
        slideWidth: Math.floor(slideWidth),
        slideMargin: slideMargin,
        minSlides: 1,
        maxSlides: numOfSlides,
        moveSlides: 1
      });
      super.init();
    }, 400);
  }
}

window.pew.addRegistryEntry({key: 'wdf-slider-gallery', domSelector: '.wp-block-gallery.gallery-slider .blocks-gallery-grid', classDef: SliderGallery});
