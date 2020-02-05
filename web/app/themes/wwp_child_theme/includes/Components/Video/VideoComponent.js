import {PewComponent} from "../../../assets/raw/js/components/pew-component";
import {initVideoPlayer} from "./VideoLib";

export class VideoComponent extends PewComponent {
  init() {
    this.registerPlayerControls();
  }

  registerPlayerControls() {
    initVideoPlayer(this.element);
  }
}

window.pew.addRegistryEntry({key: 'video-component', domSelector: '.video-wrapper', classDef: VideoComponent});
