<?php

	if(!defined('LS_ROOT_FILE')) {
		header('HTTP/1.0 403 Forbidden');
		exit;
	}

	// Get all skins
	$skins = LS_Sources::getSkins();
	$skin = (!empty($_GET['skin']) && strpos($_GET['skin'], '..') === false) ? $_GET['skin'] : '';
	if(empty($skin)) {
		$skin = reset($skins);
		$skin = $skin['handle'];
	}
	$skin = LS_Sources::getSkin($skin);
	$file = $skin['file'];

	// Get screen options
	$lsScreenOptions = get_option('ls-screen-options', '0');
	$lsScreenOptions = ($lsScreenOptions == 0) ? array() : $lsScreenOptions;
	$lsScreenOptions = is_array($lsScreenOptions) ? $lsScreenOptions : unserialize($lsScreenOptions);

	// Defaults
	if(!isset($lsScreenOptions['showTooltips'])) {
		$lsScreenOptions['showTooltips'] = 'true';
	}

?>

<div id="ls-screen-options" class="metabox-prefs hidden">
	<div id="screen-options-wrap" class="hidden">
		<form id="ls-screen-options-form" method="post">
			<h5><?php _e('Show on screen', 'LayerSlider') ?></h5>
			<label>
				<input type="checkbox" name="showTooltips"<?php echo $lsScreenOptions['showTooltips'] == 'true' ? ' checked="checked"' : ''?>> <?php _e('Tooltips', 'LayerSlider') ?>
			</label>
		</form>
	</div>
	<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
		<button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false"><?php _e('Screen Options', 'LayerSlider') ?></button>
	</div>
</div>

<div class="wrap">

	<!-- Page title -->
	<h2>
		<?php _e('LayerSlider Skin Editor', 'LayerSlider') ?>
		<a href="?page=layerslider" class="add-new-h2"><?php _e('Back to the list', 'LayerSlider') ?></a>
	</h2>

	<!-- Error messages -->
	<?php if(isset($_GET['edited'])) : ?>
	<div class="ls-notification updated">
		<div><?php _e('Your changes has been saved!', 'LayerSlider') ?></div>
	</div>
	<?php endif; ?>
	<!-- End of error messages -->

	<!-- Editor box -->
	<form method="post" class="ls-box ls-skin-editor-box">
		<input type="hidden" name="ls-user-skins" value="1">
		<?php wp_nonce_field('save-user-skin'); ?>
		<h3 class="header medium">
			<?php _e('Skin Editor', 'LayerSlider') ?>
			<figure><span>|</span><?php _e('Ctrl+Q to fold/unfold a block', 'LayerSlider') ?></figure>
			<p>
				<span><?php _e('Choose a skin:', 'LayerSlider') ?></span>
				<select name="skin" class="ls-skin-editor-select">
					<?php foreach($skins as $item) : ?>
					<?php if($item['handle'] == $skin['handle']) { ?>
					<option value="<?php echo $item['handle'] ?>" selected="selected"><?php echo $item['name'] ?></option>
					<?php } else { ?>
					<option value="<?php echo $item['handle'] ?>"><?php echo $item['name'] ?></option>
					<?php } ?>
					<?php endforeach; ?>
				</select>
			</p>
		</h3>
		<p class="inner"><?php _e('Built-in skins will be overwritten by plugin updates. Making changes should be done through the Custom Styles Editor.', 'LayerSlider') ?></p>
		<div class="inner">
			<textarea rows="10" cols="50" name="contents" class="ls-codemirror"><?php echo htmlentities(file_get_contents($file)); ?></textarea>
			<p class="footer">
				<?php if(!is_writable($file)) { ?>
				<?php _e('You need to make this file writable in order to save your changes. See the <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">Codex</a> for more information.', 'LayerSlider') ?>
				<?php } else { ?>
				<button class="button-primary"><?php _e('Save changes', 'LayerSlider') ?></button>
				<?php _e("Modifying a skin with invalid code can break your sliders' appearance. Changes cannot be reverted after saving.", "LayerSlider") ?>
				<?php } ?>
			</p>
		</div>
	</form>
</div>
<script type="text/javascript">
	// Screen options
	var lsScreenOptions = <?php echo json_encode($lsScreenOptions) ?>;
</script>
