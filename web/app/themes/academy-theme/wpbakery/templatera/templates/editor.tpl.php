<div id="vc-templatera-editor" class="panel" style="display: none;">
    <div class="panel-heading">
        <a href="#" class="vc-close" data-dismiss="panel" aria-hidden="true"><i class="icon"></i></a>
        <a href="#" class="vc-transparent" data-transparent="panel" aria-hidden="true"><i class="icon"></i></a>

        <h3 class="panel-title"><?php _e('Templates', 'north') ?></h3>
    </div>
    <div class="panel-body wpb-edit-form vc-templates-body">
        <div class="row vc-row wpb_edit_form_elements">
            <div class="col-md-12 vc-column">
                <div class="wpb_element_label"><?php _e('Save current layout as a template', 'north') ?></div>
                <div class="edit_form_line">
                    <input name="padding" class="wpb-textinput vc_title_name" type="text" value="" id="vc-templatera-name" placeholder="<?php _e('Template name', 'north') ?>"> <button id="vc-template-save" class="btn btn-primary"><?php _e('Save template', 'north') ?></button>
                </div>
                <span class="description"><?php _e('Save your layout and reuse it on different sections of your website', 'north') ?></span>
            </div>
            <div class="col-md-12 vc-column">
                <div class="wpb_element_label"><?php _e('Load Template', 'north') ?></div>
                <span class="description"><?php _e('Append previosly saved template to the current layout', 'north') ?></span>
                <ul class="wpb_templates_list" id="vc-templatera-list">
                    <?php echo $this->getList() ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <button type="button" class="btn btn-default vc-close" data-dismiss="panel"><?php _e('Close', 'north') ?></button>
    </div>
</div>