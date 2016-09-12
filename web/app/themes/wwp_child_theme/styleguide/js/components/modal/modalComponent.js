(function ($, ns) {

    var modalComponent = {

        global: false,
        initiable: true,
        defaultSelector: '.modaal',

        init: function ($wrap,opts) {

            var t = this;
            t.$wrap = $wrap || $(t.defaultSelector);

            var single_modaal = t.$wrap;

            if ( single_modaal.length ) {
                single_modaal.each(function() {
                    var self = $(this);

                    // new empty options
                    var options = {};
                    var inline_options = false;

                    // option: type
                    if ( self.attr('data-modaal-type') ) {
                        inline_options = true;
                        options.type = self.attr('data-modaal-type');
                    }
                    if(self.hasClass('modaal-video')){
                        inline_options = true;
                        options.type = 'video';
                    }

                    // option: animation
                    if ( self.attr('data-modaal-animation') ) {
                        inline_options = true;
                        options.animation = self.attr('data-modaal-animation');
                    }

                    // option: animation_speed
                    if ( self.attr('data-modaal-animation-speed') ) {
                        inline_options = true;
                        options.animation_speed = self.attr('data-modaal-animation-speed');
                    }

                    // option: after_callback_delay
                    if ( self.attr('data-modaal-after-callback-delay') ) {
                        inline_options = true;
                        options.after_callback_delay = self.attr('data-modaal-after-callback-delay');
                    }

                    // option: after_callback_delay
                    if ( self.attr('data-modaal-is-locked') ) {
                        inline_options = true;
                        options.is_locked = (self.attr('data-modaal-is-locked') === 'true' ? true : false);
                    }

                    // option: hide_close
                    if ( self.attr('data-modaal-hide-close') ) {
                        inline_options = true;
                        options.hide_close = (self.attr('data-modaal-hide-close') === 'true' ? true : false);
                    }

                    // option: background
                    if ( self.attr('data-modaal-background') ) {
                        inline_options = true;
                        options.background = self.attr('data-modaal-background');
                    }

                    // option: overlay_opacity
                    if ( self.attr('data-modaal-overlay-opacity') ) {
                        inline_options = true;
                        options.overlay_opacity = self.attr('data-modaal-overlay-opacity');
                    }

                    // option: overlay_close
                    if ( self.attr('data-modaal-overlay-close') ) {
                        inline_options = true;
                        options.overlay_close = (self.attr('data-modaal-overlay-close') === 'false' ? false : true);
                    }

                    // option: accessible_title
                    if ( self.attr('data-modaal-accessible-title') ) {
                        inline_options = true;
                        options.accessible_title = self.attr('data-modaal-accessible-title');
                    }

                    // option: start_open
                    if ( self.attr('data-modaal-start-open') ) {
                        inline_options = true;
                        options.start_open = (self.attr('data-modaal-start-open') === 'true' ? true : false);
                    }

                    // option: fullscreen
                    if ( self.attr('data-modaal-fullscreen') ) {
                        inline_options = true;
                        options.fullscreen = (self.attr('data-modaal-fullscreen') === 'true' ? true : false);
                    }

                    // option: custom_class
                    if ( self.attr('data-modaal-custom-class') ) {
                        inline_options = true;
                        options.custom_class = self.attr('data-modaal-custom-class');
                    }

                    // option: close_text
                    if ( self.attr('data-modaal-close-text') ) {
                        inline_options = true;
                        options.close_text = self.attr('data-modaal-close-text');
                    }

                    // option: close_aria_label
                    if ( self.attr('data-modaal-close-aria-label') ) {
                        inline_options = true;
                        options.close_aria_label = self.attr('data-modaal-close-aria-label');
                    }

                    // option: background_scroll
                    if ( self.attr('data-modaal-background-scroll') ) {
                        inline_options = true;
                        options.background_scroll = (self.attr('data-modaal-background-scroll') === 'true' ? true : false);
                    }

                    // option: width
                    if ( self.attr('data-modaal-width') ) {
                        inline_options = true;
                        options.width = parseInt( self.attr('data-modaal-width') );
                    }

                    // option: height
                    if ( self.attr('data-modaal-height') ) {
                        inline_options = true;
                        options.height = parseInt( self.attr('data-modaal-height') );
                    }

                    // option: confirm_button_text
                    if ( self.attr('data-modaal-confirm-button-text') ) {
                        inline_options = true;
                        options.confirm_button_text = self.attr('data-modaal-confirm-button-text');
                    }

                    // option: confirm_cancel_button_text
                    if ( self.attr('data-modaal-confirm-cancel-button-text') ) {
                        inline_options = true;
                        options.confirm_cancel_button_text = self.attr('data-modaal-confirm-cancel-button-text');
                    }

                    // option: confirm_title
                    if ( self.attr('data-modaal-confirm-title') ) {
                        inline_options = true;
                        options.confirm_title = self.attr('data-modaal-confirm-title');
                    }

                    // option: confirm_content
                    if ( self.attr('data-modaal-confirm-content') ) {
                        inline_options = true;
                        options.confirm_content = self.attr('data-modaal-confirm-content');
                    }

                    // option: gallery_active_class
                    if ( self.attr('data-modaal-gallery-active-class') ) {
                        inline_options = true;
                        options.gallery_active_class = self.attr('data-modaal-gallery-active-class');
                    }

                    // option: loading_content
                    if ( self.attr('data-modaal-loading-content') ) {
                        inline_options = true;
                        options.loading_content = self.attr('data-modaal-loading-content');
                    }

                    // option: loading_class
                    if ( self.attr('data-modaal-loading-class') ) {
                        inline_options = true;
                        options.loading_class = self.attr('data-modaal-loading-class');
                    }

                    // option: ajax_error_class
                    if ( self.attr('data-modaal-ajax-error-class') ) {
                        inline_options = true;
                        options.ajax_error_class = self.attr('data-modaal-ajax-error-class');
                    }

                    // option: start_open
                    if ( self.attr('data-modaal-instagram-id') ) {
                        inline_options = true;
                        options.instagram_id = self.attr('data-modaal-instagram-id');
                    }

                    var computedOpts = $.extend(options,opts);

                    // now set it up for the trigger, but only if inline_options is true
                    if ( inline_options ) {
                        self.modaal(computedOpts);
                    }
                });
            }
        }
    };

    ns.app.registerComponent('modal', modalComponent, {initGlobal: true}); //si on passe { initGlobal:true } il sera meme auto instancie


})(jQuery, window.wonderwp);