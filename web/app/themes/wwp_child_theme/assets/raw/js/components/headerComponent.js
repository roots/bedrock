import {PewComponent} from "./pew-component";
import {Menu} from "./menu";

class headerComponent extends PewComponent {

    constructor(element, options) {
        let defaultOptions = {
            'classToToggleOnBody': 'has-opened-menu'
        };
        super(element, Object.assign(defaultOptions, options));
        this.menu = null;
    }

    init(){
        this.registerMenuToggler();
        this.registerSticky();
    }

    registerMenuToggler(){
        this.element.find('[data-menu-toggler]').on('click',(e)=>{
            e.preventDefault();
            if (!window.matchMedia("(min-width: 767px)").matches) {
                if(this.menu===null) {
                    this.menu = new Menu(this.element.find('.navigation-wrapper'));
                }
            }
            $(e.currentTarget).toggleClass('is-active');
            $('body').toggleClass(this.options.classToToggleOnBody);
            this.menu.toggle();
        });
    }

    registerSticky(){

    }

}

window.pew.addRegistryEntry({key: 'header', domSelector: '#header', classDef: headerComponent});
