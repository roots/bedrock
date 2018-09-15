<?php if(!defined('LS_ROOT_FILE')) {  header('HTTP/1.0 403 Forbidden'); exit; } ?>
<?php if(strpos(LS_PLUGIN_VERSION, 'b') !== false) : ?>
<div class="ls-version-number">
	<?php _e('Using beta version', 'LayerSlider') ?> (<?php echo LS_PLUGIN_VERSION ?>)
	<a href="mailto:support@kreaturamedia.com?subject=LayerSlider WP (v<?php echo LS_PLUGIN_VERSION ?>) Feedback"><?php _e('Send feedback', 'LayerSlider') ?></a>
</div>
<?php endif; ?>
