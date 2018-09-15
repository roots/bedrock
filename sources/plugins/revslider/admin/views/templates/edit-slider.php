<?php if( !defined( 'ABSPATH') ) exit(); ?>
<input type="hidden" id="sliderid" value="<?php echo $sliderID; ?>"></input>

<?php
$is_edit = true;
require self::getPathTemplate('slider-main-options');
?>

<script type="text/javascript">
	var g_jsonTaxWithCats = <?php echo $jsonTaxWithCats?>;

	jQuery(document).ready(function(){			
		RevSliderAdmin.initEditSliderView();
	});
</script>