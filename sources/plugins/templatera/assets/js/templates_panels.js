/* global vc */
var templatera_editor;
(function ( $ ) {
	'use strict';
	var templateraOptions, templateraPanelSelector, TemplateraPanelEditorBackend, TemplateraPanelEditorFrontend;
	templateraOptions = {
		save_template_action: 'vc_templatera_save_template',
		appendedClass: 'templatera_templates',
		appendedTemplateType: 'templatera_templates',
		delete_template_action: 'vc_templatera_delete_template'
	};
	if ( window.vc && window.vc.TemplateWindowUIPanelBackendEditor ) {
		TemplateraPanelEditorBackend = vc.TemplateWindowUIPanelBackendEditor.extend( templateraOptions );
		TemplateraPanelEditorFrontend = vc.TemplateWindowUIPanelFrontendEditor.extend( templateraOptions );
		templateraPanelSelector = '#vc_ui-panel-templates';
	} else {
		TemplateraPanelEditorBackend = vc.TemplatesPanelViewBackend.extend( templateraOptions );
		TemplateraPanelEditorFrontend = vc.TemplatesPanelViewFrontend.extend( templateraOptions );
		templateraPanelSelector = '#vc_templates-panel';
	}
	if ( window.pagenow && 'templatera' === window.pagenow ) {
		if ( window.vc_user_access && window.vc &&  window.vc.visualComposerView ) {
			window.vc.visualComposerView.prototype.initializeAccessPolicy = function () {
				this.accessPolicy = {
					be_editor: vc_user_access().editor( 'backend_editor' ),
					fe_editor: false,
					classic_editor: ! vc_user_access().check( 'backend_editor', 'disabled_ce_editor', undefined, true )
				};
			}
		}
		vc.events.on( 'vc:access:backend:ready', function(access) {
			access.add( 'fe_editor', false );
			$( '.wpb_switch-to-front-composer, .vc_control-preview' ).remove();
			$( '#wpb-edit-inline' ).parent().remove();
			$( '.vc_spacer:last-child' ).remove();
		} );
	}
	$( document ).ready( function () {
		// we need to update currect template panel to new one (extend functionality)
		if ( window.vc_mode && window.vc_mode === 'admin_page' ) {
			if ( vc.templates_panel_view ) {
				vc.templates_panel_view.undelegateEvents(); // remove is required to detach event listeners and clear memory
				vc.templates_panel_view = templatera_editor = new TemplateraPanelEditorBackend( { el: templateraPanelSelector } );

				$( '#vc-templatera-editor-button' ).click( function ( e ) {
					e && e.preventDefault && e.preventDefault();
					vc.templates_panel_view.render().show(); // make sure we show our window :)
				} );
			}
		}
	} );

	$( window ).on( 'vc_build', function () {
		if ( window.vc && window.vc.templates_panel_view ) {
			vc.templates_panel_view.undelegateEvents(); // remove is required to detach event listeners and clear memory
			vc.templates_panel_view = templatera_editor = new TemplateraPanelEditorFrontend( { el: templateraPanelSelector } );

			$( '#vc-templatera-editor-button' ).click( function ( e ) {
				e && e.preventDefault && e.preventDefault();
				vc.templates_panel_view.render().show(); // make sure we show our window :)
			} );
		}
	} );
})( window.jQuery );
