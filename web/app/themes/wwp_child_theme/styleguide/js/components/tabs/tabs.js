import {PewComponent} from "../pew-component";
import {JQueryAccessibleTabsAria} from "./jquery-accessible-tabs-aria";

export class TabsComponent extends PewComponent {
    constructor(element) {
        super(element);
    }
    init() {
        let tabs = new JQueryAccessibleTabsAria();
        tabs.initTabs(this.element);
    }
}