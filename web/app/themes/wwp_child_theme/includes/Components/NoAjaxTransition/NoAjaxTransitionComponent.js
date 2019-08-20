import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export default class NoAjaxTransitionComponent extends PewComponent {

    init() {
        this.element.removeClass('transitionning');
        this.setupTransitionTriggers();
    }

    setupTransitionTriggers() {
        $('a').not('.no-transition,.actu-list .pagination a,.post-edit-link').on('click', (e) => {
            let link = $(e.currentTarget).attr('href');
            if ((
                link.indexOf(window.location.host) !== -1
                || link.indexOf('?cat') !== -1
                || link.indexOf('./') !== -1
            ) && link.indexOf('#') === -1
            ) {
                console.log('lien concerne');
                $('#content').addClass('transitionning');
            } else {
                console.log('lien non concerne');
            }
        });
    }

}

window.pew.addRegistryEntry({key: 'noajax-transition', domSelector: '#content', classDef: NoAjaxTransitionComponent});

