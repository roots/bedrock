<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

 
if( !defined( 'ABSPATH') ) exit();

$is_edit = false;

require self::getPathTemplate('slider-main-options');
?>

<script type="text/javascript">
	var g_jsonTaxWithCats = <?php echo $jsonTaxWithCats?>;

	jQuery(document).ready(function(){
		RevSliderAdmin.initAddSliderView();
	});
</script>

