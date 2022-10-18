import {PewComponent} from "../../../assets/raw/js/components/pew-component";

export default class NoAjaxTransitionComponent extends PewComponent {

  init() {
    this.element.removeClass('transitionning');
    this.setupTransitionTriggers();
  }

  setupTransitionTriggers() {
    const exceptions = [
      '.no-transition',
      '.no-barba',
      '.module-actu .pagination a',
      '.module-faq .pagination a',
      '.module-event .pagination a',
      '.module-telechargements .pagination a',
      '.post-edit-link',
      '.timeline-component a',
      '.wdf-modal',
      '.page_item_has_children > a'
    ];
    $('a').not(exceptions.join(',')).on('click', (e) => {
      let $link = $(e.currentTarget);
      let href = $link.attr('href');
      if (
        (
          href.indexOf(window.location.host) !== -1 //on trouve bien l'url du site dans le lien
          || href.indexOf('?cat') !== -1 //Lien de cat
          || href.indexOf('./') !== -1 // Lien relatif
        )
        && href.indexOf('#') === -1 //Pas une ancre
        && (!$(e.currentTarget).attr('target') || $link.attr('target') !== '_blank') //Pas un target blank
        && !e.metaKey //Meta key is not pressed
      ) {
        console.log('[Transition] lien concerne');
        $('#content').addClass('transitionning');
      } else {
        console.log('[Transition] lien non concerne');

        if (href.indexOf('#') >= 0 && href !== '#') {
          //this is an anchored link
          //Clean up anchor
          let selector = href.split('#')[1];
          //test with id
          let $target = $('#' + selector);
          if ($target.length === 0) {
            //Test witch class
            $target = $('.' + selector);
          }
          if ($target.length) {
            e.preventDefault();
            let topPos = $target.offset().top;
            this.scrollTo(topPos);
          }
        }

      }
    });

    $(window).bind("pageshow", function (event) {
      if (event.originalEvent.persisted) {
        $('#content').removeClass('transitionning');
      }
    });
  }

  scrollTo(topPos) {
    if (window.smoothScrollMargin) {
      topPos -= window.smoothScrollMargin;
    }
    $('html,body').stop().animate({
      scrollTop: topPos
    }, 750);
  }

}

window.pew.addRegistryEntry({key: 'noajax-transition', domSelector: '#content', classDef: NoAjaxTransitionComponent});

