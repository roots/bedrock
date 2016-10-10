<?php
$value    = ( isset( $value ) ) ? $value : $this->settings[$key];
$class    = ( isset( $class ) ) ? 'class="' . $class . '"' : '';
$disabled = ( isset( $disabled ) && $disabled ) ? ' disabled' : '';
?>
<div id="<?php echo $key; ?>-wrap" data-checkbox="<?php echo $key; ?>" class="wpmdb-switch<?php echo $disabled . $value ? ' on' : ''; ?>">
	<span class="on <?php echo $value ? 'checked' : ''; ?>">ON</span>
	<span class="off <?php echo ! $value ? 'checked' : ''; ?>">OFF</span>
	<input type="hidden" name="<?php echo $key; ?>" value="0" />
	<input type="checkbox" name="<?php echo $key; ?>" value="1" id="<?php echo $key; ?>" <?php checked( $value ); ?> <?php echo $class ?>/>
</div>