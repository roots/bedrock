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

//force the js file to be included
wp_enqueue_script('essential-grid-item-editor-script', EG_PLUGIN_URL.'admin/assets/js/grid-editor.js', array('jquery'), Essential_Grid::VERSION );
	
?>
<h2 class="topheader"><?php _e('Overview', EG_TEXTDOMAIN); ?></h2>

<div id="eg-grid-even-item-skin-wrapper">
	
	<?php
	$skins_c = new Essential_Grid_Item_Skin();
	$navigation_c = new Essential_Grid_Navigation();
	$grid_c = new Essential_Grid();
	
	$grid['id'] = '1';
	$grid['name'] = __('Overview', EG_TEXTDOMAIN);
	$grid['handle'] = 'overview';
	$grid['postparams'] = array();
	$grid['layers'] = array();
	$grid['params'] = array('layout' => 'masonry',
							'navigation-skin' => 'backend-flat',
							'filter-arrows' => 'single',
							'navigation-padding' => '0 0 0 0',
							'force_full_width' => 'off',
							'rows-unlimited' => 'off',
							'rows' => 3,
							'columns' => array(4,3,3,2,2,2,1),
							'columns-width' => array(1400,1170,1024,960,778,640,480),
							'spacings' => 15,
							'grid-animation' => 'fade',
							'grid-animation-speed' => 800,
							'grid-animation-delay' => 5,
							'x-ratio' => 4,
							'y-ratio' => 3,
						   );
	
	$skins_html = '';
	$skins_css = '';
	$filters = array();


	$skins = $skins_c->get_essential_item_skins();
	
	$demo_img = array();
	for($i=1; $i<=4; $i++){
		$demo_img[] = 'demoimage'.$i.'.jpg';
	}
	
	if(!empty($skins) && is_array($skins)){
		$src = array();
		
		foreach($skins as $skin){
			if(empty($src)) $src = $demo_img;
				
			$item_skin = new Essential_Grid_Item_Skin();
			$item_skin->init_by_data($skin);
			
			//set filters
			$item_skin->set_demo_filter();
			
			//add skin specific css
			$item_skin->register_skin_css();
			
			//set demo image
			$img_key = array_rand($src);
			$item_skin->set_image($src[$img_key]);
			unset($src[$img_key]);
			
			$item_filter = $item_skin->get_filter_array();
			
			$filters = array_merge($item_filter, $filters);
			
			ob_start();
			$item_skin->output_item_skin('overview');
			$skins_html.= ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			ob_start();
			$item_skin->generate_element_css('overview');
			$skins_css.= ob_get_contents();
			ob_clean();
			ob_end_clean();
		}
	}
	
	$grid_c->init_by_data($grid);
	?>
	<div class="postbox eg-postbox eg-transbackground" >
		<h3><span class="eg-element-setter"><?php _e('Skin Templates', EG_TEXTDOMAIN); ?></span></h3>
		<div class="inside" style="margin:0; padding:0;">
			<?php 
			$grid_c->output_wrapper_pre();
			
			$filters = array_map("unserialize", array_unique(array_map("serialize", $filters))); //filter to unique elements
			
			$navigation_c->set_special_class('esg-fgc-'.$grid['id']);
			$navigation_c->set_filter($filters);
			$navigation_c->set_style('padding', $grid['params']['navigation-padding']);
			echo $navigation_c->output_filter(true);
			
			$grid_c->output_grid_pre();

			//output elements
			echo $skins_html;

			$grid_c->output_grid_post();
			
			echo '<div style="text-align: center;">';
			echo $navigation_c->output_pagination(true);
			echo '</div>';
			
			$grid_c->output_wrapper_post();
			
			?>
		</div>
	</div>
	
	<?php
	$grid_c->output_grid_javascript(false, true);
	
	echo $skins_css;
	
	Essential_Grid_Global_Css::output_global_css_styles_wrapped();

	if(empty($skins)){
		_e('No Item Skins found!', EG_TEXTDOMAIN);
	}
	?>
</div>
<a class='button-primary revblue' style="margin-top:15px !important;" href='<?php echo $this->getViewUrl(Essential_Grid_Admin::VIEW_ITEM_SKIN_EDITOR, 'create=true'); ?>'><?php _e('Create New Item Skin', EG_TEXTDOMAIN); ?></a>

<script type="text/javascript">
	jQuery(function(){
		GridEditorEssentials.initOverviewItemSkin();
	});
</script>