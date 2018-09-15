/*
  Vertical News Ticker 1.15

  Original by: Tadas Juozapaitis ( kasp3rito [eta] gmail (dot) com )
               http://www.jugbit.com/jquery-vticker-vertical-news-ticker/

  Forked/Modified by: Richard Hollis @richhollis - richhollis.co.uk
*/

(function($){

  var defaults = {
    speed: 700,
    pause: 4000,
    showItems: 1,
    mousePause: true,
    height: 0,
    animate: true,
    margin: 0,
    padding: 0,
    startPaused: false
  };

  var internal = {

    moveUp: function(state, attribs) {
      internal.animate(state, attribs, 'up');
    },

    moveDown: function(state, attribs){
      internal.animate(state, attribs, 'down');
    },

    animate: function(state, attribs, dir) {
      var height = state.itemHeight;
      var options = state.options;
      var el = state.element;
      var obj = el.children('ul');
      var selector = (dir === 'up') ? 'li:first' : 'li:last';

      el.trigger("vticker.beforeTick");

      var clone = obj.children(selector).clone(true);

      if(options.height > 0) height = obj.children('li:first').height();
      height += (options.margin) + (options.padding*2); // adjust for margins & padding

      if(dir==='down') obj.css('top', '-' + height + 'px').prepend(clone);

      if(attribs && attribs.animate) {
        if(state.animating) return;
        state.animating = true;
        var opts = (dir === 'up') ? {top: '-=' + height + 'px'} : {top: 0};
        obj.animate(opts, options.speed, function() {
            $(obj).children(selector).remove();
            $(obj).css('top', '0px');
            state.animating = false;
            el.trigger("vticker.afterTick");
          });
      } else {
        obj.children(selector).remove();
        obj.css('top', '0px');
        el.trigger("vticker.afterTick");
      }
      if(dir==='up') clone.appendTo(obj);
    },

    nextUsePause: function() {
      var state = $(this).data('state');
      var options = state.options;
      if(state.isPaused || state.itemCount < 2) return;
      methods.next.call( this, {animate:options.animate} );
    },

    startInterval: function() {
      var state = $(this).data('state');
      var options = state.options;
      var initThis = this;
      state.intervalId = setInterval(function(){
        internal.nextUsePause.call( initThis );
      }, options.pause);
    },

    stopInterval: function() {
      var state = $(this).data('state');
      if(!state) return;
      if(state.intervalId) clearInterval(state.intervalId);
      state.intervalId = undefined;
    },

    restartInterval: function() {
      internal.stopInterval.call(this);
      internal.startInterval.call(this);
    }
  };

  var methods = {

    init: function(options) {
      // if init called second time then stop first, then re-init
      methods.stop.call(this);
      // init
      var defaultsClone = jQuery.extend({}, defaults);
      var options = $.extend(defaultsClone, options);
      var el = $(this);
      var state = {
        itemCount: el.children('ul').children('li').length,
        itemHeight: 0,
        itemMargin: 0,
        element: el,
        animating: false,
        options: options,
        isPaused: (options.startPaused) ? true : false,
        pausedByCode: false
      };
      $(this).data('state', state);

      el.css({overflow: 'hidden', position: 'relative'})
        .children('ul').css({position: 'absolute', margin: 0, padding: 0})
        .children('li').css({margin: options.margin, padding: options.padding});

      if(isNaN(options.height) || options.height === 0)
      {
        el.children('ul').children('li').each(function(){
          var current = $(this);
          if(current.height() > state.itemHeight)
            state.itemHeight = current.height();
        });
        // set the same height on all child elements
        el.children('ul').children('li').each(function(){
          var current = $(this);
          current.height(state.itemHeight);
        });
        // set element to total height
        var box = (options.margin) + (options.padding * 2);
        el.height(((state.itemHeight + box) * options.showItems) + options.margin);
      }
      else
      {
        // set the preferred height
        el.height(options.height);
      }

      var initThis = this;
      if(!options.startPaused) {
        internal.startInterval.call( initThis );
      }

      if(options.mousePause)
      {
        el.bind("mouseenter", function () {
          //if the automatic scroll is paused, don't change that.
          if (state.isPaused === true) return;
          state.pausedByCode = true;
          // stop interval
          internal.stopInterval.call( initThis );
          methods.pause.call( initThis, true );
        }).bind("mouseleave", function () {
          //if the automatic scroll is paused, don't change that.
          if (state.isPaused === true && !state.pausedByCode) return;
          state.pausedByCode = false;
          methods.pause.call(initThis, false);
          // restart interval
          internal.startInterval.call( initThis );
        });
      }
    },

    pause: function(pauseState) {
      var state = $(this).data('state');
      if(!state) return undefined;
      if(state.itemCount < 2) return false;
      state.isPaused = pauseState;
      var el = state.element;
      if(pauseState) {
        $(this).addClass('paused');
        el.trigger("vticker.pause");
      }
      else {
        $(this).removeClass('paused');
        el.trigger("vticker.resume");
      }
    },

    next: function(attribs) {
      var state = $(this).data('state');
      if(!state) return undefined;
      if(state.animating || state.itemCount < 2) return false;
      internal.restartInterval.call( this );
      internal.moveUp(state, attribs);
    },

    prev: function(attribs) {
      var state = $(this).data('state');
      if(!state) return undefined;
      if(state.animating || state.itemCount < 2) return false;
      internal.restartInterval.call( this );
      internal.moveDown(state, attribs);
    },

    stop: function() {
      var state = $(this).data('state');
      if(!state) return undefined;
      internal.stopInterval.call( this );
    },

    remove: function() {
      var state = $(this).data('state');
      if(!state) return undefined;
      internal.stopInterval.call( this );
      var el = state.element;
      el.unbind();
      el.remove();
    }
  };

  $.fn.vTicker = function( method ) {
    if ( methods[method] ) {
      return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.vTicker' );
    }
  };
})(jQuery);