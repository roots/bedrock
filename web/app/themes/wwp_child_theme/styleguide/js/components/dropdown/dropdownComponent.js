export const DefaultDropdownOptions = {
    selector: '.dropdown',
    dropdownPanelSelector : '.dropdown-toggle',
    openCssClass : 'open'
}

export class DropdownWrap {
    constructor(dom, options) {
        this.$dom = jQuery(dom);
        this.options = Object.assign(DefaultDropdownOptions, options);
        this.init();
    }

    init() {
        var self = this;
        this.$dom.find(self.options.dropdownPanelSelector).on('click', function (e) {
            jQuery(this).parent().toggleClass(self.options.openCssClass);
        });
        jQuery(document).on('mouseup', function (e) {
            if (!jQuery(e.target).hasClass(self.options.dropdownPanelSelector)) {
                self.$dom.removeClass(self.options.openCssClass);
            }
        });
    }
}



////////////////////////////////
/// IMPORT Default & Dropdown

export class Dropdown {
    constructor(dom) {
        this.dom = dom;
        this.init();
    }
    init() {
        new DropdownWrap(this.dom);
    }
}

window.pew.addRegistryEntry('wdf-dropdown', {selector: DefaultDropdownOptions.selector, classDef: Dropdown});