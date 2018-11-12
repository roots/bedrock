import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export class Dropdown extends PewComponent {
    constructor(element) {

        super(element);
    }
    init() {
        this.element.find('.dropdown-trigger').on('click', function () {
            $(this).parent().addClass('is-active')
        });
    }
}
