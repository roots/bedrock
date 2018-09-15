<?php if(!defined('LS_ROOT_FILE')) { header('HTTP/1.0 403 Forbidden'); exit; } ?>
<script type="text/html" id="ls-layer-item-template">
	<li>
		<span class="ls-sublayer-sortable-handle dashicons dashicons-menu"></span>
		<span class="ls-sublayer-controls">
			<span class="ls-icon-eye dashicons dashicons-visibility" data-help="<?php _e('Hide layer in the editor.', 'LayerSlider') ?>"></span>
			<span class="ls-icon-lock dashicons dashicons-lock disabled" data-help="<?php _e('Prevent layer from dragging in the editor.', 'LayerSlider') ?>"></span>
		</span>
		<div class="ls-sublayer-thumb"></div>
		<input type="text" name="subtitle" class="ls-sublayer-title" value="Layer #1">
		<a href="#" title="<?php _e('Duplicate this layer', 'LayerSlider') ?>" class="dashicons dashicons-admin-page duplicate"></a>
		<a href="#" title="<?php _e('Remove this layer', 'LayerSlider') ?>" class="dashicons dashicons-trash remove"></a>
	</li>
</script>
