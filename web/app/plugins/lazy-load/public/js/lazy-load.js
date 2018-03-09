import "jquery-lazy";
import {PewComponent} from "../../../../themes/wwp_child_theme/styleguide/js/components/pew-component";

export class LazyLoad extends PewComponent {
	constructor(element) {
		super(element);
	}
	init() {
        $(this.element).lazy();
	}
}

window.pew.addRegistryEntry({key: 'wdf-lazy-loading', domSelector: 'img[data-src]', classDef: LazyLoad});