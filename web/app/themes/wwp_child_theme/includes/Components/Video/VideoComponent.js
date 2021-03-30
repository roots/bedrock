import {PewComponent} from "../../../assets/raw/js/components/pew-component";
import {initVideoPlayer} from "./VideoLib";

export class VideoComponent extends PewComponent {
  init() {
    if (!this.element.data('video-lazy')) {
      this.registerPlayerControls();
      this.registerVideoToggle();
    }
    this.element.data('video-component', this);
  }

  registerPlayerControls() {
    initVideoPlayer(this.element.find('.video-player'));
  }

  registerVideoToggle() {
    const $videoWrapper = this.element.find('.video-player');
    const $videoTrigger = this.element.find('.video-trigger');
    const video = $videoWrapper.find('.video')[0];
    const playpause = $videoWrapper.find('.playpause')[0];
    const progress = $videoWrapper.find('.progress')[0];

    if ($videoTrigger.length) {

      $videoTrigger.on('click', (e) => {
        e.preventDefault();
        console.log('click');
        if (this.element.hasClass('video-active')) {
          this.element.removeClass('video-active');
          //stop video
          playpause.setAttribute('data-state', 'play');
          video.pause();
        } else {
          this.element.addClass('video-active');
          //play video
          playpause.setAttribute('data-state', 'pause');
          video.play();
          progress.setAttribute('max', video.duration);
        }
      });
    }
  }
  initLazy() {
    const varName = this.element.data('var-name');
    if (varName && window[varName]) {
      const template = window[varName].template;
      const data = window[varName].data;
      const markup = template.replaceArray(Object.keys(data), Object.values(data));
      this.element.append(markup);
      this.registerPlayerControls();
      const $videoWrapper = this.element.find('.video-player');
      const video = $videoWrapper.find('.video')[0];
    }
  }
}

window.pew.addRegistryEntry({key: 'video-component', domSelector: '[data-video-native-component]', classDef: VideoComponent});
