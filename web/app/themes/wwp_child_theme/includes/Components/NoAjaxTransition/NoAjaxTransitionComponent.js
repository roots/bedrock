import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export default class NoAjaxTransitionComponent extends PewComponent {

  init() {
    this.element.removeClass('transitionning');
    this.setupTransitionTriggers();
  }

  setupTransitionTriggers() {
    $('a').not('.no-transition,.actu-list .pagination a,.post-edit-link').on('click', (e) => {
      let $link = $(e.currentTarget);
      let href = $link.attr('href');

      if (
        (
          href.indexOf(window.location.host) !== -1 //on trouve bien l'url du site dans le lien
          || href.indexOf('?cat') !== -1 //Lien de cat
          || href.indexOf('./') !== -1 // Lien relatif
        )
        && href.indexOf('#') === -1 //Pas une ancre
        && ( !$(e.currentTarget).attr('target') || $link.attr('target') !== '_blank') //Pas un target blank
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

