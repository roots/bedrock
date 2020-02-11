const svg4Everybody = require('svg4everybody');

class App {
  init() {
    this.launchPew();
    this.launchSvg4Everybody();
  }

  launchPew() {
    if (window.pew) { window.pew.enhanceRegistry(document); }
  }

  launchSvg4Everybody() {
    svg4Everybody();
  }
}

let app = new App();
app.init();
