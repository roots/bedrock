<?php if(!defined('LS_ROOT_FILE')) {  header('HTTP/1.0 403 Forbidden'); exit; } ?>
<script type="text/html" id="tmpl-ls-add-slider-grid">
	<form method="post" id="ls-add-slider-template" class="preview">
		<?php wp_nonce_field('add-slider'); ?>
		<input type="hidden" name="ls-add-new-slider" value="1">
		<h3><?php _e('Name your new slider', 'LayerSlider') ?></h3>
		<div class="inner">
			<input type="text" name="title" placeholder="<?php _e('e.g. Homepage slider', 'LayerSlider') ?>">
			<button class="button button-primary">
				<?php _e('Add slider', 'LayerSlider') ?>
				<i class="dashicons dashicons-arrow-right-alt"></i>
			</button>
		</div>
	</form>
</script>