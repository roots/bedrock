import {AbstractNotification} from "./AbstractNotification";

let NotificationOptions = {
  jsTemplates: '#jsTemplates',
  templateType: 'notification',
  delay: 4000
};

export default class DefaultNotification extends AbstractNotification {
  constructor() {
    super();
    this.options = NotificationOptions;
  }

  replaceTplWithMsg(type, msg) {
    let jsTemplates = document.querySelector(this.options.jsTemplates);
    jsTemplates = JSON.parse(jsTemplates.innerHTML);

    let tpl = jsTemplates[this.options.templateType]; // get "notification" template

    tpl = tpl
      .replace('{type}', type)
      .replace('{message}', msg);

    var d = document.createElement('div');
    d.innerHTML = tpl;
    return d.firstChild;
  }

  show(givenOpts) {

    let defaultOpts = {
      'dest': document.getElementsByTagName('body'),
      focus: true
    };

    let showOpts = $.extend(super.getAbstractOpts(), defaultOpts, givenOpts);

    this.dest = showOpts.dest[0];

    this.tpl = this.replaceTplWithMsg(showOpts.type, showOpts.msg);
    this.tpl.classList.add('alert-js');
    this.tpl.classList.add('active');

    this.dest.insertBefore(this.tpl, this.dest.firstChild);
    this.tpl.addEventListener('click', this.close.bind(this.dest), false);

    /*let self = this;
    setTimeout(function () {
        self.tpl.click();
    }, self.options.delay);*/

    if (showOpts.focus) {
      let topPos = $(this.tpl).offset().top;

      if (window.smoothScrollMargin) {
        topPos -= window.smoothScrollMargin;
      }

      let $adminBar = $('#wpadminbar');
      if ($adminBar.length) {
        topPos -= $adminBar.height();
      }

      const $scrollTarget = (showOpts.dest.parents('.modaal-wrapper').length)
        ? showOpts.dest.parents('.modaal-wrapper')
        : $('html,body');

      $scrollTarget.animate({
        scrollTop: topPos
      }, 750);
    }

  }

  close() { // scope : this.dest
    let node = this;
    setTimeout(function () {
      node.removeChild(node.firstChild);
    }, 1000);
  }
}
