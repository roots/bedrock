import {PewComponent} from "../../../../styleguide/js/components/pew-component";

export class Menu extends PewComponent {

    constructor(element, options) {
        let defaultOptions = {
            classToToggle: 'is-opened',
            depth: 0
        };
        super(element, Object.assign(defaultOptions, options));
    }

    init() {
        this.opened = this.element.css('display') !== 'none' && this.element.css('visibility') !== 'hidden';
        this.registerEvents();
        if (this.options.depth > 0) {
            this.addSubMenuNav();
        }
    }

    registerEvents() {
        this.registerSubMenuOpener();
    }

    toggle() {
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
        this.startOpen();
        this.endOpen();
    }

    startOpen() {

    }

    endOpen() {
        this.opened = true;
        this.toggleClasses();
    }

    close() {
        this.startClose();
        this.endClose();
    }

    startClose() {

    }

    endClose() {
        this.opened = false;
        this.toggleClasses();
    }

    registerSubMenuOpener() {
        //register link clicks that open sub menus
        this.element.find('> ul > li > a').on('click', (e) => {
            e.preventDefault();
            let $thisLink = $(e.currentTarget),
                $thisLi   = $thisLink.parent();

            if ($thisLi.find('.children').length > 0) {
                e.preventDefault();
                this.openSubMenu($thisLi);
            }
        });
    }

    openSubMenu($thisLi) {
        if ($thisLi.data('menu')) {
            $thisLi.data('menu').open();
        } else {
            let subMenuOptions = {
                'depth': this.options.depth + 1
            };
            let thisMenu       = new Menu($thisLi, subMenuOptions);
            $thisLi.data('menu', thisMenu);
            thisMenu.open();
        }
    }

    addSubMenuNav() {
        let subMenuNav = '<ul class="mobile-nav-links">' +
            '<li><button>Retour</button></li>' +
            '<li><a href="' + this.element.find('> a').attr('href') + '">Voir la page</a></li>' +
            '</ul>';
        this.element.find('> ul').prepend(subMenuNav);
        this.element.find('> ul button').on('click', (e) => {
            this.close();
        });
    }

}


