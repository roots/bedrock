<div id="vc-templatera-editor" class="vc_panel vc_templates-editor" style="display: none;">
	<div class="vc_panel-heading">
		<a title="<?php _e( 'Close panel', 'north' ); ?>" href="#" class="vc_close" data-dismiss="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a>
		<a title="<?php _e( 'Hide panel', 'north' ); ?>" href="#" class="vc_transparent" data-transparent="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a>

		<h3 class="vc_panel-title"><?php _e('Templates', 'north') ?></h3>
	</div>
	<div class="vc_panel-body wpb-edit-form vc_templates-body vc_properties-list vc_with-tabs">
		<div class="vc_row wpb_edit_form_elements">
			<div class="vc_column">
				<div id="vc_tabs-templatera" class="vc_panel-tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
					<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
						<li><a href="#tabs-templatera-tabs-1"><?php _e('My templates','north'); ?></a></li>
						<li><a href="#tabs-templatera-tabs-2"><?php _e('Default templates','north'); ?></a></li>
					</ul>
					<div id="tabs-templatera-tabs-1">
						<div class="vc_col-md-12 vc_column inside">
							<div class="wpb_element_label"><?php _e('Save current layout as a template', 'north') ?></div>
							<div class="edit_form_line">
								<input name="padding" class="wpb-textinput vc_title_name" type="text" value="" id="vc-templatera-name"
									   placeholder="<?php _e( 'Template name', 'north' ) ?>">
								<button id="vc-templatera-save"
										class="vc_btn vc_btn-primary vc_btn-sm"><?php _e( 'Save template', 'north' ) ?></button>
							</div>
								<span
								  class="vc_description"><?php _e( 'Save your layout and reuse it on different sections of your website', 'north' ) ?></span>
						</div>
						<div class="vc_col-md-12 vc_column">
							<div class="wpb_element_label"><?php _e('Load Template', 'north') ?></div>
								<span
								  class="vc_description"><?php _e( 'Append previosly saved template to the current layout', 'north' ) ?></span>
							<ul class="wpb_templates_list" id="vc-templatera-list">
								<?php echo $this->getList() ?>
							</ul>
						</div>
					</div>
					<div id="tabs-templatera-tabs-2">
						<div class="vc_col-md-12 vc_column inside">
							<?php $templates = visual_composer()->templatesEditor()->loadDefaultTemplates(); ?>
							<div class="wpb_element_label"><?php _e('Load Template','north'); ?></div>
							<span class="description"><?php _e('Append default template to the current layout','north'); ?></span>
							<ul id="vc_default-template-list" class="wpb_templates_list">
								<?php foreach($templates as $template): ?>
								<li class="wpb_template_li"><a href="#" data-template_name="<?php echo str_replace('.json','',basename($template['filename'])); ?>"><?php _e($template['name'],'north'); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="vc_panel-footer">
		<button type="button" class="vc_btn vc_btn-default vc_close"
				data-dismiss="panel"><?php _e( 'Close', 'north' ) ?></button>
	</div>
</div>