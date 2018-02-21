<?php
add_action( 'widgets_init', 'essb_social_share_widget3' );
function essb_social_share_widget3() {
	register_widget( 'EasySocialShareButtons_Widget3' );
}
class EasySocialShareButtons_Widget3 extends WP_Widget {

	protected $widget_slug = "easy-social-share-buttons3";
	
	public function __construct() {
		$options = array( 'description' => __( 'Social Share Buttons' , 'essb' ), 'classname' => $this->widget_slug."-class" );
		
		parent::__construct( false , __( 'Easy Social Share Buttons: Share Buttons' , 'essb' ) , $options );
	}
	


	function widget( $args, $instance ) {
		global $essb_networks;
		extract( $args );

		$essb_w_counter = $instance['essb_w_counter'] ;
		$essb_w_totalcounter =  $instance['essb_w_totalcounter'] ;
		$essb_w_fixed =  $instance['essb_w_fixed'] ;
		$essb_w_style =  $instance['essb_w_style'] ;
		$essb_w_width =  $instance['essb_w_width'] ;
		$essb_w_template = isset($instance['essb_w_template']) ? $instance['essb_w_template'] : '';		
		$essb_w_nospace = isset($instance['essb_w_nospace']) ? $instance['essb_w_nospace'] : '';
		$essb_w_native = isset($instance['essb_w_native']) ? $instance['essb_w_native'] : '';
		
		$essb_w_align = isset($instance['essb_w_align']) ? $instance['essb_w_align'] : 'left';
		$title = isset($instance['title']) ? $instance['title'] : '';
		$custom_list = isset($instance['custom_list']) ? $instance['custom_list'] : '';
		$essb_w_force = $instance['essb_w_force'];
		
		$options = array();//get_option ( EasySocialShareButtons::$plugin_settings_name );
		$buttons = "";
		
		if (is_array($essb_networks)) {			
		
			foreach ( $essb_networks as $k => $v ) {
				$display_name = isset ( $v ['name'] ) ? $v ['name'] : $k;
		
				if (trim($display_name) == "") {
					$display_name = $k;
				}
		
				$is_active = ( isset($instance['essb_w_'.$k]) ) ? esc_attr($instance['essb_w_'.$k]): '';
				
				if ($is_active == "1") {
					if ($buttons != '') { $buttons .= ","; }
					$buttons .= $k;
				}
			}
		}
		
		if ($custom_list != '') {
			$buttons = $custom_list;
		}

		$native_state = "no";
		
		if ($essb_w_native) {
			$native_state = "yes";
		}
		
		$shortcode = '[easy-social-share buttons="'.$buttons.'" native="'.$native_state.'"';
		
		if ($essb_w_counter == "no") {
			$shortcode .= " counters=0";
		}
		else {
			$shortcode .= " counters=1";
		}
		
		if ($essb_w_force) {
			$shortcode .= ' forceurl="yes"';
		}
		$shortcode .= ' counters_pos="'.$essb_w_counter.'"';
		$shortcode .= ' total_counter_pos="'.$essb_w_totalcounter.'"';
		
		if ($essb_w_nospace != '') {
			$shortcode .= ' nospace="'.$essb_w_nospace.'"';
		}
		
		if ($essb_w_totalcounter == "no") {
			$shortcode .= ' hide_total="yes"';
		}			
		
		if (!empty($essb_w_style)) {
			$shortcode .= ' style="'.$essb_w_style.'"';
		}
		
		
		if ($essb_w_fixed) {
			$shortcode .= ' fixedwidth="yes"';
		}
		
		if ($essb_w_width != '') {
			$shortcode .= ' fixedwidth_px="'.$essb_w_width.'"';
		}
		if ($essb_w_template != '') {
			$shortcode .= ' template="'.$essb_w_template.'"';
		}
		
		$shortcode .= ']';
		
		//echo $before_widget;
		if (!empty($title)) {
			echo $before_widget . $before_title . $title . $after_title;
		}

		if ($essb_w_align != 'left') {
			echo '<div style="text-align: '.$essb_w_align.'; width: 100%;">';
		}
		
		$generated = do_shortcode($shortcode);
		echo $generated;
		
		if ($essb_w_align != 'left') {
			echo '</div>';
		}
		
		if (!empty($title)) {
			echo $after_widget;
		}

		//if( empty($box_only) )	echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		global $essb_networks;
		
		$instance = $old_instance;
		$instance['essb_w_counter'] = $new_instance['essb_w_counter'] ;
		$instance['essb_w_totalcounter'] =  $new_instance['essb_w_totalcounter'] ;
		$instance['essb_w_fixed'] =  $new_instance['essb_w_fixed'] ;
		$instance['essb_w_style'] =  $new_instance['essb_w_style'] ;
		$instance['essb_w_width'] =  $new_instance['essb_w_width'] ;
		$instance['essb_w_align'] =  $new_instance['essb_w_align'];
		$instance['essb_w_template'] = $new_instance['essb_w_template'];
		$instance['essb_w_nospace'] = $new_instance['essb_w_nospace'];
		$instance['title'] = $new_instance['title'];
		$instance['essb_w_native'] = $new_instance['essb_w_native'];
		$instance['custom_list'] = $new_instance['custom_list'];
		$instance['essb_w_force'] = $new_instance['essb_w_force'];
		
		$options = array();//get_option ( EasySocialShareButtons::$plugin_settings_name );
		
		if (is_array($essb_networks)) {
			
			foreach ( $essb_networks as $k => $v ) {
				$display_name = isset ( $v ['name'] ) ? $v ['name'] : $k;
		
				if (trim($display_name) == "") {
					$display_name = $k;
				}
				
				$instance['essb_w_'.$k] =  $new_instance['essb_w_'.$k] ;		
			}
		}
		
		return $instance;
	}

	function form( $instance ) {
		global $essb_networks;
		
		$counter_pos = essb_avaliable_counter_positions();
		$counter_pos['no'] = "No social counters";
		
		$network_list = array();
		$options = array();//get_option ( EasySocialShareButtons::$plugin_settings_name );	
		
		$counter = ( isset($instance['essb_w_counter']) ) ? esc_attr($instance['essb_w_counter']): 'no';
		$total_counter = ( isset($instance['essb_w_totalcounter']) ) ? esc_attr($instance['essb_w_totalcounter']): 'no';
		$fixed = ( isset($instance['essb_w_fixed']) ) ? esc_attr($instance['essb_w_fixed']): '';
		$style = ( isset($instance['essb_w_style']) ) ? esc_attr($instance['essb_w_style']): '';
		$align = (isset($instance['essb_w_align'])) ? esc_attr($instance['essb_w_align']) : 'left';
		$template = (isset($instance['essb_w_template'])) ? esc_attr($instance['essb_w_template']) : 'left';
		$nospace = isset($instance['essb_w_nospace']) ? esc_attr($instance['essb_w_nospace']) : '';
		$native_buttons = isset($instance['essb_w_native']) ? esc_attr($instance['essb_w_native']) : '';
		$title = isset($instance['title']) ? $instance['title'] : '';
		$custom_list = isset($instance['custom_list']) ? $instance['custom_list'] : '';
		$essb_w_force = isset($instance['essb_w_force']) ? $instance['essb_w_force'] : '';
		?>
		
		<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title' , 'essb' ); ?>:</label>
  <input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" value="<?php echo $title ?>" />
  <br /><small><?php _e( 'Fill that field if you wish your widget to have title' , 'essb' ) ?></small>
</p>
		
				<p>
  <label for="<?php echo $this->get_field_id( 'custom_list' ); ?>"><?php echo __( 'Custom network ordered list' , 'essb' ); ?>:</label>
  <input type="text" name="<?php echo $this->get_field_name( 'custom_list' ); ?>" id="<?php echo $this->get_field_id( 'custom_list' ); ?>" class="widefat" value="<?php echo $custom_list ?>" />
  <br /><small><?php _e( 'Fill social network keys to get custom order (no need to activate checks below). Example: facebook,twitter,pinterest' , 'essb' ) ?></small>
</p>
		
		<?php 
		
		if (is_array($essb_networks)) {
			
			foreach ($essb_networks as $k => $v ) {
				$display_name = isset ( $v ['name'] ) ? $v ['name'] : $k;
				
				if (trim($display_name) == "") { $display_name = $k; } 
				
				$is_active = ( isset($instance['essb_w_'.$k]) ) ? esc_attr($instance['essb_w_'.$k]): '';
				
				?>
							<p>
			<input id="<?php echo $this->get_field_id('essb_w_'.$k); ?>" name="<?php echo $this->get_field_name('essb_w_'.$k); ?>" type="checkbox" value="1" <?php checked( '1', $is_active ); ?> />
			<label for="<?php echo $this->get_field_id('essb_w_'.$k); ?>"><?php echo $display_name; ?></label>
			</p>
			
				
				<?php 
			}
		}
		?>
		
			<p>
		<label for="<?php echo $this->get_field_id( 'essb_w_style' ); ?>"><?php _e( 'Button display style:' , 'essb' ) ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'essb_w_style' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_style' ); ?>" >
					<option value="icon" <?php if( $style == 'icon' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Display share buttons only as icon without network names' , 'essb' ) ?></option>
					<option value="icon_hover" <?php if( $style == 'icon_hover' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Display share buttons as icon with network name appear when button is pointed' , 'essb' ) ?></option>
					<option value="button" <?php if( $style == 'button' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Display as share button with icon and network name' , 'essb' ) ?></option>
					<option value="button_name" <?php if( $style == 'button_name' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Display as share button with network name and without icon' , 'essb' ) ?></option>
					<option value="vertical" <?php if( $style == 'vertical' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Display vertical button' , 'essb' ) ?></option>
					</select>
		</p>
			<p>
		<label for="<?php echo $this->get_field_id( 'essb_w_align' ); ?>"><?php _e( 'Buttons align:' , 'essb' ) ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'essb_w_align' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_align' ); ?>" >
					<option value="left" <?php if( $align == 'left' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Left' , 'essb' ) ?></option>
					<option value="right" <?php if( $align == 'right' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Right' , 'essb' ) ?></option>
					<option value="center" <?php if( $align == 'center' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Center' , 'essb' ) ?></option>
					</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'essb_w_counter' ); ?>"><?php _e( 'Display Counter:' , 'essb' ) ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'essb_w_counter' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_counter' ); ?>" >
					<?php 
			
			foreach ($counter_pos as $position => $text) {
				$is_active = ($position == $counter) ? " selected=\"selected\"" : "";
				
				echo '<option value="'.$position.'" '.$is_active.'>'.$text.'</option>';
			}
			
			?>
					</select>
		</p>
		
			<p>
		<label for="<?php echo $this->get_field_id( 'essb_w_totalcounter' ); ?>"><?php _e( 'Display Total Counter:' , 'essb' ) ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'essb_w_totalcounter' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_totalcounter' ); ?>" >
			
			<?php 
			
			foreach (essb_avaiable_total_counter_position() as $position => $text) {
				$is_active = ($position == $total_counter) ? " selected=\"selected\"" : "";
				
				echo '<option value="'.$position.'" '.$is_active.'>'.$text.'</option>';
			}
			
			?>
					</select>
		</p>
		
			<p>
			<label for="<?php echo $this->get_field_id( 'essb_w_fixed' ); ?>"><?php _e( 'Fixed width buttons:' , 'essb' ) ?></label>
			<input id="<?php echo $this->get_field_id( 'essb_w_fixed' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_fixed' ); ?>" value="true" <?php if( $fixed ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small><?php _e( 'This option will generate buttons with equal width' , 'essb' ) ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'essb_w_width' ); ?>"><?php _e( 'Fixed width buttons value :' , 'essb' ) ?></label>
			<input id="<?php echo $this->get_field_id( 'essb_w_width' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_width' ); ?>" value="<?php if(isset( $instance['essb_w_width'] )) echo $instance['essb_w_width']; ?>" style="width:40px;" type="text" /> <?php _e( 'px' , 'essb' ) ?>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'essb_w_template' ); ?>"><?php _e( 'Template:' , 'essb' ) ?></label>
<select class="widefat" id="<?php echo $this->get_field_id( 'essb_w_template' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_template' ); ?>">
							<?php 
							
	foreach (essb_available_tempaltes4(true) as $position => $text) {
				$is_active = ($position == $template) ? " selected=\"selected\"" : "";
				
				echo '<option value="'.$position.'" '.$is_active.'>'.$text.'</option>';
			}
			?>
														</select>		
		</p>		

					<p>
			<label for="<?php echo $this->get_field_id( 'essb_w_nospace' ); ?>"><?php _e( 'Remove space between buttons:' , 'essb' ) ?></label>
			<input id="<?php echo $this->get_field_id( 'essb_w_nospace' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_nospace' ); ?>" value="true" <?php if( $nospace ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small><?php _e( 'This option will remove space between buttons' , 'essb' ) ?></small>
		</p>
					<p>
			<label for="<?php echo $this->get_field_id( 'essb_w_native' ); ?>"><?php _e( 'Include native social buttons:' , 'essb' ) ?></label>
			<input id="<?php echo $this->get_field_id( 'essb_w_native' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_native' ); ?>" value="true" <?php if( $native_buttons ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small><?php _e( 'This option will include native buttons' , 'essb' ) ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'essb_w_force' ); ?>"><?php _e( 'Force get of correct page:' , ESSB3_TEXT_DOMAIN ) ?></label>
			<input id="<?php echo $this->get_field_id( 'essb_w_force' ); ?>" name="<?php echo $this->get_field_name( 'essb_w_force' ); ?>" value="true" <?php if( $essb_w_force ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small><?php _e( 'Activate this option if the widget cannot detect correct sharing address' , ESSB3_TEXT_DOMAIN ) ?></small>
		</p>
		<?php 
	}
}

?>