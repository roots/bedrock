<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

$tooltips = get_option('tp_eg_tooltips', 'true');

?>

</div>

<script type="text/javascript">
	var token = '<?php echo wp_create_nonce("Essential_Grid_actions"); ?>';
	var es_do_tooltipser = <?php echo $tooltips; ?>;
	
	jQuery(document).ready(function() {
		
		AdminEssentials.initAccordion();
		
		<?php
		if($tooltips == 'true'){
		?>
        AdminEssentials.initToolTipser();
		<?php
		}
		?>
	});
</script>

<div id="waitaminute">
	<div class="waitaminute-message"><i class="eg-icon-coffee"></i><br><?php _e("Please Wait...", EG_TEXTDOMAIN); ?></div>
</div>

<div id="eg-error-box">
	
</div>
