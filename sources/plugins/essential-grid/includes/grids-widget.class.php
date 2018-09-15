<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grids_Widget extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_ess_grid', 'description' => __('Displays certain Essential Grid on the page', EG_TEXTDOMAIN) );
        parent::__construct('ess-grid-widget', __('Essential Grid', EG_TEXTDOMAIN), $widget_ops);
    }
 
 
    /**
     * the form
     */
    public function form($instance) {
		
    	$arrGrids = Essential_Grid::get_grids_short();
		
		if(empty($arrGrids)){
			echo __("No Essential Grids found, Please create at least one!", EG_TEXTDOMAIN);
		}else{
			
			$field = "ess_grid";
			$fieldPages = "ess_grid_pages";
			$fieldCheck = "ess_grid_homepage";
			$fieldTitle = "ess_grid_title";
			
	    	$gridID = @$instance[$field];
	    	$homepage = @$instance[$fieldCheck];
	    	$pagesValue = @$instance[$fieldPages];
	    	$title = @$instance[$fieldTitle];
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$fieldID_check = $this->get_field_id( $fieldCheck );
			$fieldName_check = $this->get_field_name( $fieldCheck );
			$checked = "";
			if($homepage == "on")
				$checked = "checked='checked'";

			$fieldPages_ID = $this->get_field_id( $fieldPages );
			$fieldPages_Name = $this->get_field_name( $fieldPages );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID; ?>"><?php _e('Title', EG_TEXTDOMAIN); ?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name; ?>" id="<?php echo $fieldTitle_ID; ?>" value="<?php echo $title; ?>" class="widefat">
			
			<br><br>
			
			<?php _e('Choose Essential Grid', EG_TEXTDOMAIN); ?>:
			<select name="<?php echo $fieldName; ?>" id="<?php echo $fieldID; ?>">
				<?php
				foreach($arrGrids as $id => $name){
					?>
					<option value="<?php echo $id; ?>"<?php echo ($gridID == $id) ? ' selected="selected"' : ''; ?>><?php echo $name; ?></option>
					<?php
				}
				?>
			</select>
			
			<div style="padding-top:10px;"></div>
			
			<label for="<?php echo $fieldID_check; ?>"><?php _e('Home Page Only', EG_TEXTDOMAIN); ?>:</label>
			<input type="checkbox" name="<?php echo $fieldName_check; ?>" id="<?php echo $fieldID_check; ?>" <?php echo $checked; ?> >
			<br><br>
			<label for="<?php echo $fieldPages_ID; ?>"><?php _e('Pages: (example: 3,8,15)', EG_TEXTDOMAIN); ?></label>
			<input type="text" name="<?php echo $fieldPages_Name; ?>" id="<?php echo $fieldPages_ID; ?>" value="<?php echo $pagesValue; ?>">
			
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		 
    }
	
 
    /**
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * widget output
     */
    public function widget($args, $instance) {

    	$grid_id = $instance["ess_grid"];
		$title = apply_filters( 'widget_title', empty($instance['ess_grid_title']) ? '' : $instance['ess_grid_title'], $instance ); //needed for WPML translation
		
		$homepageCheck = @$instance["ess_grid_homepage"];
		$homepage = "";
		if($homepageCheck == "on")
			$homepage = "homepage";
		
		$pages = $instance["ess_grid_pages"];
		if(!empty($pages)){
			if(!empty($homepage))
				$homepage .= ",";
			$homepage .= $pages;
		}
				
		if(empty($grid_id))
			return(false);
			
		//widget output
		$beforeWidget = $args["before_widget"];
		$afterWidget = $args["after_widget"];
		$beforeTitle = $args["before_title"];
		$afterTitle = $args["after_title"];
		
		echo $beforeWidget;
		
		if(!empty($title))
			echo $beforeTitle.$title.$afterTitle;
		
		
		$caching = get_option('tp_eg_use_cache', 'false');
		$use_cache = $caching == 'true' ? true : false;

		// Enqueue Scripts
		wp_enqueue_script( 'tp-tools' );
		wp_enqueue_script( 'essential-grid-essential-grid-script' );
		
		// Enqueue Lightbox Style/Script
		if($use_cache){ 
			wp_enqueue_script( 'themepunchboxext' );
		}
		
		$grid = new Essential_Grid();
		$grid->output_essential_grid($grid_id,$homepage);
		
		echo $afterWidget;						
    }
 
}


/**
 * Handles the Essential based Widget Areas
 * @since 1.0.6
 */
class Essential_Grid_Widget_Areas {
	
	
	/**
	 * Return all custom Widget Areas created by Essential Grid
	 * @since 1.0.6
	 */
	public function get_all_sidebars(){
		
		$sidebars = get_option('esg-widget-areas', false);
		return $sidebars;
		
	}
	
	
	/**
	 * Add new Widget Area
	 * @since 1.0.6
	 */
	public function add_new_sidebar($new_area){
		
		if(!isset($new_area['handle']) || strlen($new_area['handle']) < 3) return __('Wrong Handle received', EG_TEXTDOMAIN);
		if(!isset($new_area['name']) || strlen($new_area['name']) < 3) return __('Wrong Name received', EG_TEXTDOMAIN);
		
		$sidebars = $this->get_all_sidebars();
		
		//check if exists
		if($sidebars !== false){
			foreach($sidebars as $handle => $name){
				if($handle == $new_area['handle']) return __('Widget Area with handle already exist, choose a different handle', EG_TEXTDOMAIN);
			}
		}
		
		$sidebars[$new_area['handle']] = $new_area['name'];
		
		$do = update_option('esg-widget-areas', $sidebars);
		
		return true;
	}
	
	
	/**
	 * change Widget Area by handle
	 * @since 1.0.6
	 */
	public function edit_widget_area_by_handle($edit_widget){
		
		if(!isset($edit_widget['handle']) || strlen($edit_widget['handle']) < 3) return __('Wrong Handle received', EG_TEXTDOMAIN);
		if(!isset($edit_widget['name']) || strlen($edit_widget['name']) < 3) return __('Wrong Name received', EG_TEXTDOMAIN);
		
		$sidebars = $this->get_all_sidebars();
		
		if($sidebars == false || !is_array($sidebars)) return __('No Ess. Grid Widget Areas exist', EG_TEXTDOMAIN);
		
		foreach($sidebars as $handle => $name){
			if($handle == $edit_widget['handle']){
				$sidebars[$handle] = $edit_widget['name'];
				$do = update_option('esg-widget-areas', $sidebars);
				return true;
			}
		}
		
		return false;
	}
	
	
	/**
	 * Remove Widget Area
	 * @since 1.0.6
	 */
	public function remove_widget_area_by_handle($del_handle){
		
		$sidebars = $this->get_all_sidebars();
		
		foreach($sidebars as $handle => $name){
			if($handle == $del_handle){
				unset($sidebars[$handle]);
				$do = update_option('esg-widget-areas', $sidebars);
				return true;
			}
		}
		
		return __('Widget Area not found! Wrong handle given.', EG_TEXTDOMAIN);
	}
	
	
	/**
	 * Retrieve all registered Widget Areas from WordPress
	 * @since 1.0.6
	 */
	public function get_all_registered_sidebars(){
		global $wp_registered_sidebars;
		
		if(empty($wp_registered_sidebars))
			return false;
		
		//print_r($wp_registered_sidebars);
		/*foreach( $wp_registered_sidebars as $sidebar ){
			if( $current ) 
				if($sidebar['name'] == $current)
					$selected = "selected";
				else
				$selected = "";
			echo "<option value='".$sidebar['name']."' $selected>";
			echo $sidebar['name'];
			echo "</option>";
		}
		echo "</select><!--<br>-->";
		*/
	}
}


/**
 * Adds Filter Widgets
 * @since 1.0.6
 */
class Essential_Grids_Widget_Filter extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_ess_grid_filter', 'description' => __('Display the filter of a certain Grid (Grid Navigation Settings in Navigations tab of the Grid has to be set to Widget)', EG_TEXTDOMAIN) );
        parent::__construct('ess-grid-widget-filter', __('Essential Grid Filter', EG_TEXTDOMAIN), $widget_ops);
    }
 
 
    /**
     * the form
     */
    public function form($instance) {
		
    	$arrGrids = Essential_Grid::get_grids_short();
		
		if(empty($arrGrids)){
			echo __("No Essential Grids found, Please create at least one!", EG_TEXTDOMAIN);
		}else{
			
			$field = "ess_grid";
			$fieldTitle = "ess_grid_title";
			
	    	$gridID = @$instance[$field];
	    	$title = @$instance[$fieldTitle];
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID; ?>"><?php _e('Title', EG_TEXTDOMAIN); ?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name; ?>" id="<?php echo $fieldTitle_ID; ?>" value="<?php echo $title; ?>" class="widefat">
			
			<br><br>
			
			<?php _e('Choose Essential Grid', EG_TEXTDOMAIN); ?>:
			<select name="<?php echo $fieldName; ?>" id="<?php echo $fieldID; ?>">
				<?php
				foreach($arrGrids as $id => $name){
					?>
					<option value="<?php echo $id; ?>"<?php echo ($gridID == $id) ? ' selected="selected"' : ''; ?>><?php echo $name; ?></option>
					<?php
				}
				?>
			</select>
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		
    }
	
 
    /**
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * widget output
     */
    public function widget($args, $instance) {
    	
		$grid_id = $instance["ess_grid"];
		$title = @$instance["ess_grid_title"];
		
		if(empty($grid_id))
			return(false);
			
		$base = new Essential_Grid_Base();
		$grid = new Essential_Grid();
		
		$grids = $grid->get_grids_short_widgets();
		if(!isset($grids[$grid_id]))
			return false;
		
		$grid_handle = $grids[$grid_id];
		
		//widget output
		$beforeWidget = $args["before_widget"];
		$afterWidget = $args["after_widget"];
		$beforeTitle = $args["before_title"];
		$afterTitle = $args["after_title"];
		
		echo $beforeWidget;
		
		if(!empty($title))
			echo $beforeTitle.$title.$afterTitle;
		
		if($base->is_shortcode_with_handle_exist($grid_handle)){
			$my_grid = $grid->init_by_id($grid_id);
			if(!$my_grid) return false; //be silent
			
			$grid->output_grid_filter();
		}
		
		echo $afterWidget;						
    }
 
}


/**
 * Adds Pagination Widgets
 * @since 1.0.6
 */
class Essential_Grids_Widget_Pagination extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_ess_grid_pagination', 'description' => __('Display the pagination of a certain Grid (Grid Navigation Settings in Navigations tab of the Grid has to be set to Widget)', EG_TEXTDOMAIN) );
        parent::__construct('ess-grid-widget-pagination', __('Essential Grid Pagination', EG_TEXTDOMAIN), $widget_ops);
    }
 
 
    /**
     * the form
     */
    public function form($instance) {
		
    	$arrGrids = Essential_Grid::get_grids_short();
		
		if(empty($arrGrids)){
			echo __("No Essential Grids found, Please create at least one!", EG_TEXTDOMAIN);
		}else{
			
			$field = "ess_grid";
			$fieldTitle = "ess_grid_title";
			
	    	$gridID = @$instance[$field];
	    	$title = @$instance[$fieldTitle];
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID; ?>"><?php _e('Title', EG_TEXTDOMAIN); ?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name; ?>" id="<?php echo $fieldTitle_ID; ?>" value="<?php echo $title; ?>" class="widefat">
			
			<br><br>
			
			<?php _e('Choose Essential Grid', EG_TEXTDOMAIN); ?>:
			<select name="<?php echo $fieldName; ?>" id="<?php echo $fieldID; ?>">
				<?php
				foreach($arrGrids as $id => $name){
					?>
					<option value="<?php echo $id; ?>"<?php echo ($gridID == $id) ? ' selected="selected"' : ''; ?>><?php echo $name; ?></option>
					<?php
				}
				?>
			</select>
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		
    }
	
 
    /**
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * widget output
     */
    public function widget($args, $instance) {
    	
		$grid_id = $instance["ess_grid"];
		$title = @$instance["ess_grid_title"];
		
		if(empty($grid_id))
			return(false);
		
		$base = new Essential_Grid_Base();
		$grid = new Essential_Grid();
		
		$grids = $grid->get_grids_short_widgets();
		if(!isset($grids[$grid_id]))
			return false;
		
		$grid_handle = $grids[$grid_id];

		
		//widget output
		$beforeWidget = $args["before_widget"];
		$afterWidget = $args["after_widget"];
		$beforeTitle = $args["before_title"];
		$afterTitle = $args["after_title"];
		
		echo $beforeWidget;
		
		if(!empty($title))
			echo $beforeTitle.$title.$afterTitle;
		
		if($base->is_shortcode_with_handle_exist($grid_handle)){
			$eg_nav = new Essential_Grid_Navigation();
			echo $eg_nav->output_pagination();
		}
		
		
		echo $afterWidget;						
    }
 
}


/**
 * Adds Pagination Widgets
 * @since 1.0.6
 */
class Essential_Grids_Widget_Pagination_Left extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_ess_grid_pagination_left', 'description' => __('Display the Left Icon for pagination of a certain Grid (Grid Navigation Settings in Navigations tab of the Grid has to be set to Widget)', EG_TEXTDOMAIN) );
        parent::__construct('ess-grid-widget-pagination-left', __('Essential Grid Pagination Left', EG_TEXTDOMAIN), $widget_ops);
    }
 
 
    /**
     * the form
     */
    public function form($instance) {
		
    	$arrGrids = Essential_Grid::get_grids_short();
		
		if(empty($arrGrids)){
			echo __("No Essential Grids found, Please create at least one!", EG_TEXTDOMAIN);
		}else{
			
			$field = "ess_grid";
			$fieldTitle = "ess_grid_title";
			
	    	$gridID = @$instance[$field];
	    	$title = @$instance[$fieldTitle];
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID; ?>"><?php _e('Title', EG_TEXTDOMAIN); ?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name; ?>" id="<?php echo $fieldTitle_ID; ?>" value="<?php echo $title; ?>" class="widefat">
			
			<br><br>
			
			<?php _e('Choose Essential Grid', EG_TEXTDOMAIN); ?>:
			<select name="<?php echo $fieldName; ?>" id="<?php echo $fieldID; ?>">
				<?php
				foreach($arrGrids as $id => $name){
					?>
					<option value="<?php echo $id; ?>"<?php echo ($gridID == $id) ? ' selected="selected"' : ''; ?>><?php echo $name; ?></option>
					<?php
				}
				?>
			</select>
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		
    }
	
 
    /**
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * widget output
     */
    public function widget($args, $instance) {
    	
		$grid_id = $instance["ess_grid"];
		$title = @$instance["ess_grid_title"];
		
		if(empty($grid_id))
			return(false);
		
		$base = new Essential_Grid_Base();
		$grid = new Essential_Grid();
		
		$grids = $grid->get_grids_short_widgets();
		if(!isset($grids[$grid_id]))
			return false;
		
		$grid_handle = $grids[$grid_id];
		
		//widget output
		$beforeWidget = $args["before_widget"];
		$afterWidget = $args["after_widget"];
		$beforeTitle = $args["before_title"];
		$afterTitle = $args["after_title"];
		
		echo $beforeWidget;
		
		if(!empty($title))
			echo $beforeTitle.$title.$afterTitle;
			
		if($base->is_shortcode_with_handle_exist($grid_handle)){
			$eg_nav = new Essential_Grid_Navigation();
			echo $eg_nav->output_navigation_left();
		}
		
		echo $afterWidget;						
    }
 
}


/**
 * Adds Pagination Widgets
 * @since 1.0.6
 */
class Essential_Grids_Widget_Pagination_Right extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_ess_grid_pagination_right', 'description' => __('Display the Right Icon for pagination of a certain Grid (Grid Navigation Settings in Navigations tab of the Grid has to be set to Widget)', EG_TEXTDOMAIN) );
        parent::__construct('ess-grid-widget-pagination-right', __('Essential Grid Pagination Right', EG_TEXTDOMAIN), $widget_ops);
    }
 
 
    /**
     * the form
     */
    public function form($instance) {
		
    	$arrGrids = Essential_Grid::get_grids_short();
		
		if(empty($arrGrids)){
			echo __("No Essential Grids found, Please create at least one!", EG_TEXTDOMAIN);
		}else{
			
			$field = "ess_grid";
			$fieldTitle = "ess_grid_title";
			
	    	$gridID = @$instance[$field];
	    	$title = @$instance[$fieldTitle];
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID; ?>"><?php _e('Title', EG_TEXTDOMAIN); ?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name; ?>" id="<?php echo $fieldTitle_ID; ?>" value="<?php echo $title; ?>" class="widefat">
			
			<br><br>
			
			<?php _e('Choose Essential Grid', EG_TEXTDOMAIN); ?>:
			<select name="<?php echo $fieldName; ?>" id="<?php echo $fieldID; ?>">
				<?php
				foreach($arrGrids as $id => $name){
					?>
					<option value="<?php echo $id; ?>"<?php echo ($gridID == $id) ? ' selected="selected"' : ''; ?>><?php echo $name; ?></option>
					<?php
				}
				?>
			</select>
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		
    }
	
 
    /**
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * widget output
     */
    public function widget($args, $instance) {
    	
		$grid_id = $instance["ess_grid"];
		$title = @$instance["ess_grid_title"];
		
		if(empty($grid_id))
			return(false);
		
		$base = new Essential_Grid_Base();
		$grid = new Essential_Grid();
		
		$grids = $grid->get_grids_short_widgets();
		if(!isset($grids[$grid_id]))
			return false;
		
		$grid_handle = $grids[$grid_id];
		
		//widget output
		$beforeWidget = $args["before_widget"];
		$afterWidget = $args["after_widget"];
		$beforeTitle = $args["before_title"];
		$afterTitle = $args["after_title"];
		
		echo $beforeWidget;
		
		if(!empty($title))
			echo $beforeTitle.$title.$afterTitle;
		
		if($base->is_shortcode_with_handle_exist($grid_handle)){
			$eg_nav = new Essential_Grid_Navigation();
			echo $eg_nav->output_navigation_right();
		}
		
		echo $afterWidget;						
    }
 
}


/**
 * Adds Pagination Widgets
 * @since 1.0.6
 */
class Essential_Grids_Widget_Sorting extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_ess_grid_sorting', 'description' => __('Display the Sorting of a certain Grid (Grid Navigation Settings in Navigations tab of the Grid has to be set to Widget)', EG_TEXTDOMAIN) );
        parent::__construct('ess-grid-widget-sorting', __('Essential Grid Sorting', EG_TEXTDOMAIN), $widget_ops);
    }
 
 
    /**
     * the form
     */
    public function form($instance) {
		
    	$arrGrids = Essential_Grid::get_grids_short();
		
		if(empty($arrGrids)){
			echo __("No Essential Grids found, Please create at least one!", EG_TEXTDOMAIN);
		}else{
			
			$field = "ess_grid";
			$fieldTitle = "ess_grid_title";
			
	    	$gridID = @$instance[$field];
	    	$title = @$instance[$fieldTitle];
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID; ?>"><?php _e('Title', EG_TEXTDOMAIN); ?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name; ?>" id="<?php echo $fieldTitle_ID; ?>" value="<?php echo $title; ?>" class="widefat">
			
			<br><br>
			
			<?php _e('Choose Essential Grid', EG_TEXTDOMAIN); ?>:
			<select name="<?php echo $fieldName; ?>" id="<?php echo $fieldID; ?>">
				<?php
				foreach($arrGrids as $id => $name){
					?>
					<option value="<?php echo $id; ?>"<?php echo ($gridID == $id) ? ' selected="selected"' : ''; ?>><?php echo $name; ?></option>
					<?php
				}
				?>
			</select>
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		
    }
	
 
    /**
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * widget output
     */
    public function widget($args, $instance) {
    	
		$grid_id = $instance["ess_grid"];
		$title = @$instance["ess_grid_title"];
		
		if(empty($grid_id))
			return(false);
		
		$base = new Essential_Grid_Base();
		$grid = new Essential_Grid();
		
		$grids = $grid->get_grids_short_widgets();
		if(!isset($grids[$grid_id]))
			return false;
		
		$grid_handle = $grids[$grid_id];
		
		//widget output
		$beforeWidget = $args["before_widget"];
		$afterWidget = $args["after_widget"];
		$beforeTitle = $args["before_title"];
		$afterTitle = $args["after_title"];
		
		echo $beforeWidget;
		
		if(!empty($title))
			echo $beforeTitle.$title.$afterTitle;
		
		if($base->is_shortcode_with_handle_exist($grid_handle)){
			$my_grid = $grid->init_by_id($grid_id);
			if(!$my_grid) return false; //be silent
			
			$grid->output_grid_sorting();
		}
		
		echo $afterWidget;						
    }
 
}


/**
 * Adds Pagination Widgets
 * @since 1.0.6
 */
class Essential_Grids_Widget_Cart extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_ess_grid_cart', 'description' => __('Display the WooCommerce Cart of a certain Grid (Grid Navigation Settings in Navigations tab of the Grid has to be set to Widget)', EG_TEXTDOMAIN) );
        parent::__construct('ess-grid-widget-cart', __('Essential Grid WooCommerce Cart', EG_TEXTDOMAIN), $widget_ops);
    }
 
 
    /**
     * the form
     */
    public function form($instance) {
		
    	$arrGrids = Essential_Grid::get_grids_short();
		
		if(empty($arrGrids)){
			echo __("No Essential Grids found, Please create at least one!", EG_TEXTDOMAIN);
		}else{
			
			$field = "ess_grid";
			$fieldTitle = "ess_grid_title";
			
	    	$gridID = @$instance[$field];
	    	$title = @$instance[$fieldTitle];
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID; ?>"><?php _e('Title', EG_TEXTDOMAIN); ?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name; ?>" id="<?php echo $fieldTitle_ID; ?>" value="<?php echo $title; ?>" class="widefat">
			<br><br>
			<?php _e('Choose Essential Grid', EG_TEXTDOMAIN); ?>:
			<select name="<?php echo $fieldName; ?>" id="<?php echo $fieldID; ?>">
				<?php
				foreach($arrGrids as $id => $name){
					?>
					<option value="<?php echo $id; ?>"<?php echo ($gridID == $id) ? ' selected="selected"' : ''; ?>><?php echo $name; ?></option>
					<?php
				}
				?>
			</select>
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		
    }
	
 
    /**
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * widget output
     */
    public function widget($args, $instance) {
    	
		$grid_id = $instance["ess_grid"];
		$title = @$instance["ess_grid_title"];
		
		if(empty($grid_id))
			return(false);
			
		$base = new Essential_Grid_Base();
		$grid = new Essential_Grid();
		
		$grids = $grid->get_grids_short_widgets();
		if(!isset($grids[$grid_id]))
			return false;
		
		$grid_handle = $grids[$grid_id];
		
		//widget output
		$beforeWidget = $args["before_widget"];
		$afterWidget = $args["after_widget"];
		$beforeTitle = $args["before_title"];
		$afterTitle = $args["after_title"];
		
		echo $beforeWidget;
		
		if(!empty($title))
			echo $beforeTitle.$title.$afterTitle;
		
		if($base->is_shortcode_with_handle_exist($grid_handle)){
			$eg_nav = new Essential_Grid_Navigation();
			echo $eg_nav->output_cart();
		}
		
		echo $afterWidget;						
    }
 
}

?>