import {PewComponent} from "../pew-component";

export class Dropdown extends PewComponent {
    constructor(element) {
        console.log('DROPDOWN', element);

        super(element);
    }
    init() {
        /*this.element.find('.dropdown-trigger').on('click', function () {
            $(this).parent().addClass('is-active')
        });*/
    }
}