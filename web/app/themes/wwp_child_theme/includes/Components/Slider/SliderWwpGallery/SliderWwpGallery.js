import {SliderComponent} from "../SliderDefault/SliderComponent";

const wwpGallerySliderOptions = {
  autoControlsCombine: true,
  keyboardEnabled: true,
  easing: 'ease-in-out',
  speed: 700,
  auto: true,
  controls: true,
  pager: false,
  stopAutoOnClick: true,
  touchEnabled: true,
  adaptiveHeight: false,
  minSlides: 1,
  maxSlides: 4,
  moveSlides: 1,
  slideWidth: 220,
  slideMargin: 20
}

export class SliderWwpGalleryComponent extends SliderComponent {

  constructor(element, passedOptions) {
    super(element, wwpGallerySliderOptions);
    this.$imgPreview = $('.img-preview');
    this.setOptions({
      onSliderLoad: (currentIndex) => {
        const $slideElement = this.getSlideByIndex(currentIndex);
        this.updateMainImg($slideElement, currentIndex);
      },
      onSlideNext: ($slideElement, oldIndex, newIndex) => {
        this.updateMainImg($slideElement, newIndex);
      },
      onSlidePrev: ($slideElement, oldIndex, newIndex) => {
        this.updateMainImg($slideElement, newIndex);
      }
    });
  }

  updateMainImg($slideElement, newIndex) {
    let $img = $slideElement.find('.slider-img img').clone();
    $img.attr('data-index', newIndex);
    console.log($slideElement, $img, newIndex);
    if (!this.$imgPreview.find('img[data-index=' + newIndex + ']').length) {
      this.$imgPreview.append($img);
    }
    this.$imgPreview.find('.active').removeClass('active');
    this.$imgPreview.find('img[data-index=' + newIndex + ']').addClass('active');
  }

}

window.pew.addRegistryEntry({key: 'wdf-slider-wwp-gallery', domSelector: '.wwp-galerie-slider', classDef: SliderWwpGalleryComponent});
