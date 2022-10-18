export const DefaultAccordionOptions = {
  global: false,
  initiable: true,
  defaultSelector: '.js-accordion'
}

export class AccordionComponent {
  constructor(dom) {
    this.dom = (dom instanceof jQuery) ? dom : $(dom);
    this.init();
  }

  init() {
    let test = new AccordionWrap(this.dom);
  }
}

export class AccordionWrap {
  constructor($accordions) {
    this.init($accordions);
  }

  init($accordions) {
    /*
     * jQuery Accessible Accordion system, using ARIA
     * Website: http://a11y.nicolas-hoffmann.net/accordion/
     * License MIT: https://github.com/nico3333fr/jquery-accessible-accordion-aria/blob/master/LICENSE
     */
    // var $accordions = $( ".js-accordion" )

    if (!$accordions.length) { // if there are at least one :)
      return;
    }

    // init
    $accordions.each(function (index) {
      var $this = $(this);
      var $options = $this.data(),
        $accordions_headers = $this.children(".js-accordion__header"),
        $accordions_prefix_classes = $options.accordionPrefixClasses || '',
        $accordions_multiselectable = $options.accordionmultiselectable || true,
        $index_accordion = index + 1;

      $this.attr({
        "role": "tablist",
        "aria-multiselectable": $options.accordionmultiselectable,
        "class": $accordions_prefix_classes + ' ' + $this.attr('class')
      });

      $accordions_headers.each(function (index_h) {
        var $that = $(this),
          $text = $that.text(),
          $accordion_panel = $that.next(".js-accordion__panel"),
          $index_header = index_h + 1;

        $accordion_panel.prepend($that.removeClass("js-accordion__header").addClass($accordions_prefix_classes + "__title").attr("tabindex", "0"));

        var $accordion_header = $('<button class="js-accordion__header ' + $accordions_prefix_classes + '__header">' + $text + '</button>');
        $accordion_panel.before($accordion_header);

        var accordionId = $this.attr('id') || '',
          panelId = $accordion_panel.attr('id'),
          localIndex = accordionId + '_' + (panelId && panelId.length ? panelId : $index_accordion);

        let headerAttr = {
          "aria-controls": "accordion" + localIndex + "_panel" + $index_header,
          "aria-expanded": "false",
          "role": "tab",
          "id": "accordion" + localIndex + "_tab" + $index_header,
          "tabindex": "-1",
          "aria-selected": "false"
        };

        //Recup / override des options par data attribut
        const dataSet = $that.data();
        if (dataSet['class']) {
          $accordion_header.addClass(dataSet['class'])
        }
        if (dataSet['illustration']) {
          $accordion_header.addClass('has-illustration');
          $accordion_header.css('background', 'url(' + dataSet['illustration'] + ') center left no-repeat');
        }

        $accordion_header.attr(headerAttr);
        $accordion_panel.attr({
          "aria-labelledby": "accordion" + localIndex + "_tab" + $index_header,
          "role": "tabpanel",
          "id": "accordion" + localIndex + "_panel" + $index_header,
          "aria-hidden": "true"
        }).addClass($accordions_prefix_classes + "__panel");

        // if opened by default
        var shouldBeOpened = $that.attr("data-accordion-opened");
        if (shouldBeOpened == "true" || shouldBeOpened == "1") {
          $accordion_header.attr("aria-expanded", "true").removeAttr("data-accordion-opened");
          $accordion_panel.attr("aria-hidden", "false");
        }

        // init first one focusable
        if ($index_header === 1) {
          $accordion_header.removeAttr("tabindex");
        }

      });
    });

    /* Events ---------------------------------------------------------------------------------------------------------- */

    $("body")
      .off("focus.accordion")
      .off("click.accordion")
      .off("keydown.accordion1")
      .off("keydown.accordion2")
    ;

    /* click on a tab link */
    $("body").on("focus.accordion", ".js-accordion__header", function (event) {
      var $this = $(this),
        $accordion = $this.parent(),
        $all_accordion_headers = $accordion.find(".js-accordion__header");

      // selected
      $all_accordion_headers.attr({
        "tabindex": "-1",
        "aria-selected": "false"
      });
      $this.attr("aria-selected", "true").removeAttr("tabindex");

    })
      .on("click.accordion", ".js-accordion__header", function (event) {
        var $this = $(this),
          $this_panel = $("#" + $this.attr("aria-controls")),
          $accordion = $this.parent(),
          $accordion_multiselectable = $accordion.attr("aria-multiselectable"),
          $all_accordion_headers = $accordion.find(".js-accordion__header"),
          $all_accordion_panels = $accordion.find(".js-accordion__panel");

        $all_accordion_headers.attr("aria-selected", "false");
        $this.attr("aria-selected", "true");

        // opened or closed?
        if ($this.attr("aria-expanded") == "false") { // closed
          $this.attr("aria-expanded", "true");
          $this_panel.attr("aria-hidden", "false");
        } else { // opened
          $this.attr("aria-expanded", "false");
          $this_panel.attr("aria-hidden", "true");
        }

        if ($accordion_multiselectable == "false") {
          $all_accordion_panels.not($this_panel).attr("aria-hidden", "true");
          $all_accordion_headers.not($this).attr("aria-expanded", "false");
        }

        setTimeout(function () {
          $this.focus();
        }, 0);
        event.preventDefault();

      })
      .on("keydown.accordion1", ".js-accordion__header", function (event) {
        var $this = $(this),
          $accordion = $this.parent(),
          $all_accordion_headers = $accordion.find(".js-accordion__header"),
          $first_header = $accordion.find(".js-accordion__header").first(),
          $last_header = $accordion.find(".js-accordion__header").last(),
          $prev_header = $this.prevAll(".js-accordion__header").first(),
          $next_header = $this.nextAll(".js-accordion__header").first();

        // strike up or left in the tab => previous tab
        if ((event.keyCode == 37 || event.keyCode == 38) && !event.ctrlKey) {
          $all_accordion_headers.attr({
            "tabindex": "-1",
            "aria-selected": "false"
          });
          // if we are on first one, activate last
          if ($this.is($first_header)) {
            $last_header.attr("aria-selected", "true").removeAttr("tabindex");
            setTimeout(function () {
              $last_header.focus();
            }, 0);
          }
          // else activate previous
          else {
            $prev_header.attr("aria-selected", "true").removeAttr("tabindex");
            setTimeout(function () {
              $prev_header.focus();
            }, 0);
          }
          event.preventDefault();
        }
        // strike down or right in the tab => next tab
        else if ((event.keyCode == 40 || event.keyCode == 39) && !event.ctrlKey) {
          $all_accordion_headers.attr({
            "tabindex": "-1",
            "aria-selected": "false"
          });
          // if we are on last one, activate first
          if ($this.is($last_header)) {
            $first_header.attr("aria-selected", "true").removeAttr("tabindex");
            setTimeout(function () {
              $first_header.focus();
            }, 0);
          }
          // else activate next
          else {
            $next_header.attr("aria-selected", "true").removeAttr("tabindex");
            setTimeout(function () {
              $next_header.focus();
            }, 0);
          }
          event.preventDefault();
        }
        // strike home in the tab => 1st tab
        else if (event.keyCode == 36) {
          $all_accordion_headers.attr({
            "tabindex": "-1",
            "aria-selected": "false"
          });
          $first_header.attr("aria-selected", "true").removeAttr("tabindex");
          setTimeout(function () {
            $first_header.focus();
          }, 0);
          event.preventDefault();
        }
        // strike end in the tab => last tab
        else if (event.keyCode == 35) {
          $all_accordion_headers.attr({
            "tabindex": "-1",
            "aria-selected": "false"
          });
          $last_header.attr("aria-selected", "true").removeAttr("tabindex");
          setTimeout(function () {
            $last_header.focus();
          }, 0);
          event.preventDefault();
        }
      })
      .on("keydown.accordion2", ".js-accordion__panel", function (event) {
        var $this = $(this),
          $this_header = $("#" + $this.attr("aria-labelledby")),
          $accordion = $this.parent(),
          $first_header = $accordion.find(".js-accordion__header").first(),
          $prev_header = $this_header.prevAll(".js-accordion__header").first(),
          $next_header = $this_header.nextAll(".js-accordion__header").first(),
          $last_header = $accordion.find(".js-accordion__header").last();

        // strike up + ctrl => go to header
        if (event.keyCode == 38 && event.ctrlKey) {
          setTimeout(function () {
            $this_header.focus();
          }, 0);
          event.preventDefault();
        }
        // strike pageup + ctrl => go to prev header
        else if (event.keyCode == 33 && event.ctrlKey) {
          if ($this_header.is($first_header)) {
            setTimeout(function () {
              $last_header.focus();
            }, 0);
            event.preventDefault();
          } else {
            setTimeout(function () {
              $prev_header.focus();
            }, 0);
            event.preventDefault();
          }
        }
        // strike pagedown + ctrl => go to next header
        else if (event.keyCode == 34 && event.ctrlKey) {
          if ($this_header.is($last_header)) {
            setTimeout(function () {
              $first_header.focus();
            }, 0);
            event.preventDefault();
          } else {
            setTimeout(function () {
              $next_header.focus();
            }, 0);
            event.preventDefault();
          }
        }

      });

  }
}

window.pew.addRegistryEntry({
  key: 'wdf-accordion',
  domSelector: DefaultAccordionOptions.defaultSelector,
  classDef: AccordionComponent
});
