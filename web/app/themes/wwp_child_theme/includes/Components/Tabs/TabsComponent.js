import {JQueryAccessibleTabsAria} from "./jquery-accessible-tabs-aria";
import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export class TabsComponent extends PewComponent {
    constructor(element) {
        super(element);
    }
    init() {
        let tabs = new JQueryAccessibleTabsAria();
        tabs.initTabs(this.element);
    }
}

window.pew.addRegistryEntry({key: 'wdf-tabs', domSelector: '.wdf-tabs', classDef: TabsComponent});
