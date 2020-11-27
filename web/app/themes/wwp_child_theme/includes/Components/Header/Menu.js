import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export class Menu extends PewComponent {

  constructor(element, options) {
    let defaultOptions = {
      classToToggle: 'is-opened',
      depth: 0
    };
    super(element, Object.assign(defaultOptions, options));
  }

  self($thisLi, subMenuOptions) {
    return new this.constructor($thisLi, subMenuOptions);
  }

  init() {
    //this.opened = this.element.css('display') !== 'none' && this.element.css('visibility') !== 'hidden';
    this.opened = this.element.hasClass(this.options.classToToggle);
    this.registerEvents();
    if (this.options.depth > 0) {
      this.addSubMenuNavTo(this.element);
    }
  }

  registerEvents() {
    this.registerSubMenuOpener();
  }

  toggle() {
    //console.log(this.opened);
    if (this.opened) {
      this.close()
    } else {
      this.open();
    }
  }

  toggleClasses() {
    if (this.opened) {
      this.element.addClass(this.options.classToToggle);
    } else {
      this.element.removeClass(this.options.classToToggle);
    }
  }

  open() {
    this.startOpen(() => {
      this.endOpen();
    });
  }

  startOpen(cb) {
    cb && cb();
  }

  endOpen() {
    this.opened = true;
    this.toggleClasses();
    this.checkIfSubMenuShouldBeOpened();
  }

  close() {
    this.startClose(() => {
      this.endClose();
    });
  }

  startClose(cb) {
    cb && cb();
  }

  endClose() {
    this.opened = false;
    this.toggleClasses();
  }

  registerSubMenuOpener() {
    this.element.find('> ul > li > a').on('click', (e) => {
      let $thisLink = $(e.currentTarget),
        $thisLi = $thisLink.parent();

      if ($thisLi.find('.children').length > 0) {
        e.preventDefault();
        this.handleSubMenu($thisLi);
      }
    });
  }

  handleSubMenu($thisLi) {
    this.toggleSubMenu($thisLi);
  }

  createSubMenu($thisLi) {
    var self = this;
    if (!$thisLi.data('menu')) {
      let subMenuOptions = {
        'depth': self.options.depth + 1
      };
      let thisMenu = this.self($thisLi, subMenuOptions);
      $thisLi.data('menu', thisMenu);
    }
  }

  toggleSubMenu($thisLi) {
    if (!$thisLi.data('menu')) {
      this.createSubMenu($thisLi);
    }
    $thisLi.data('menu').toggle();
  }

  addSubMenuNavTo($elt) {
    if ($elt.find('.mobile-nav-links').length <= 0) {
      let subMenuNav = '<ul class="mobile-nav-links">' +
        '<li class="back-btn"><button>Retour</button></li>' +
        '<li class="parent-page"><a href="' + this.element.find('> a').attr('href') + '"><span>' + this.element.find('> a').text() + '</span> <span>(Voir la page)</span></a></li>' +
        '</ul>';
      $elt.find('> ul').prepend(subMenuNav);
      $elt.find('> ul button').on('click', (e) => {
        this.close();
      });
    }
  }

  checkIfSubMenuShouldBeOpened() {
    let hasAlreadyDrilled = this.element.data('already-drilled');
    if (hasAlreadyDrilled !== 1) {
      let $activeSubMenu = this.element.find('> ul > li.current_page_ancestor');
      if ($activeSubMenu.length > 0) {
        this.createSubMenu($activeSubMenu);
        $activeSubMenu.data('menu').open();
      }
      this.element.data('already-drilled', 1);
    }
  }

}
