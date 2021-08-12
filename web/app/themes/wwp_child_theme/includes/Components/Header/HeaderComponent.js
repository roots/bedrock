import {PewComponent} from "../../../assets/raw/js/components/pew-component";
import {Menu} from "./Menu";

class headerComponent extends PewComponent {

  constructor(element, options) {
    let defaultOptions = {
      'classToToggleOnBody': 'has-opened-menu',
      'classToCheckIfHeaderShouldBeSticky': 'stickable',
      'classToToggleOnBodyWhenHeaderStuck': 'has-stuck-header',
      'stickyOffset': 'bottom'
    };
    super(element, Object.assign(defaultOptions, options));
    this.menu = null;
  }

  init() {
    this.registerMenuToggler();
    this.registerSticky();
  }

  registerMenuToggler() {
    this.element.find('[data-menu-toggler]').on('click', (e) => {
      e.preventDefault();
      if (!window.matchMedia("(min-width: 767px)").matches) {
        if (this.menu === null) {
          this.menu = new Menu(this.element.find('.navigation-wrapper'));
        }
      }
      $(e.currentTarget).toggleClass('is-active');
      $('body').toggleClass(this.options.classToToggleOnBody);
      this.menu.toggle();
    });
  }

  registerSticky() {
    if ($('body').hasClass(this.options.classToCheckIfHeaderShouldBeSticky)) {
      window.onscroll = function () {checkHeaderFixation()};
      const header = this.element[0];
      let stickTreshold = header.offsetTop;
      const classToToggleOnBodyWhenHeaderStuck = this.options.classToToggleOnBodyWhenHeaderStuck;

      if (this.options.stickyOffset === 'top') {
        stickTreshold += 0;
      } else if (this.options.stickyOffset === 'center') {
        stickTreshold += this.element.outerHeight() / 2;
      } else if (this.options.stickyOffset === 'bottom') {
        stickTreshold += this.element.outerHeight();
      } else {
        stickTreshold += this.options.stickyOffset;
      }

      checkHeaderFixation();

      function checkHeaderFixation() {
        let $body = $('body');
        if (window.pageYOffset > stickTreshold) {
          if (!$body.hasClass(classToToggleOnBodyWhenHeaderStuck)) {
            $body.addClass(classToToggleOnBodyWhenHeaderStuck);
          }
        } else {
          if ($body.hasClass(classToToggleOnBodyWhenHeaderStuck)) {
            $body.removeClass(classToToggleOnBodyWhenHeaderStuck);
          }
        }
      }

    }
  }

}

window.pew.addRegistryEntry({key: 'header', domSelector: '#header', classDef: headerComponent});
