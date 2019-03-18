import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export class DropdownComponent extends PewComponent {
    constructor(element) {
        super(element);
    }

    init() {
        this.element.find('.dropdown-trigger').on('click', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('open')
        });
    }
}

window.pew.addRegistryEntry({key: 'wdf-dropdown', domSelector: '.wdf-dropdown', classDef: DropdownComponent});
