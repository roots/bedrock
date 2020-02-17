import {PewComponent} from "../../../assets/raw/js/components/pew-component";
import {initVideoPlayer} from "./VideoLib";

export class VideoComponent extends PewComponent {
  init() {
    this.registerPlayerControls();
    this.registerVideoToggle();
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
}

window.pew.addRegistryEntry({key: 'video-component', domSelector: '[data-video-native-component]', classDef: VideoComponent});
