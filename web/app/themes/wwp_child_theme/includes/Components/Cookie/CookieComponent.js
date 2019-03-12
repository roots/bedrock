import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export class CookieComponent extends PewComponent {

    //definition de la methode init
    init() {

        //On utilise this.element pour travailler, pas de selecteurs globaux.
        this.element.find('button').on('click', (e) => {
            e.preventDefault();
            this.element.removeClass('active');
            this.element.fadeOut(() => {
                this.element.remove();
            });
        });

        //------------------------
    }
}

window.pew.addRegistryEntry({key: 'cookie-component', domSelector: '.cookie-component', classDef: CookieComponent});
