import {PewComponent} from "../../../../styleguide/js/components/pew-component";
import {Menu} from "./menu";

class headerComponent extends PewComponent {

    constructor(element, options) {
        let defaultOptions = {
            'classToToggleOnBody': 'has-opened-menu'
        };
        super(element, Object.assign(defaultOptions, options));
        this.menu = new Menu(this.element.find('.navigation-wrapper'));
    }

    init(){
        this.registerMenuToggler();
        this.registerSticky();
    }

    registerMenuToggler(){
        this.element.find('[data-menu-toggler]').on('click',(e)=>{
            $(e.currentTarget).toggleClass('is-active');
            $('body').toggleClass(this.options.classToToggleOnBody);
            this.menu.toggle();
        });
    }

    registerSticky(){

    }

}

window.pew.addRegistryEntry({key: 'header', domSelector: '#header', classDef: headerComponent});
