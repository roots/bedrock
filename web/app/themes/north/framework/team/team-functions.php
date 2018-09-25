<?php

//
// New Post Type
//


add_action('init', 'vntd_team_register');  

function vntd_team_register() {
    $args = array(
        'label' => __('Team Members', 'north'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => true,
        'supports' => array('title','thumbnail','editor')
       );  

    register_post_type( 'team' , $args );
}


//
// Thumbnail column
//

add_filter( 'manage_edit-team_columns', 'vntd_team_columns_settings' ) ;

function vntd_team_columns_settings( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __('Title', 'north'),
		'date' => __('Date', 'north'),
		'slider-thumbnail' => ''	
	);

	return $columns;
}

add_action( 'manage_team_posts_custom_column', 'vntd_team_columns_content', 10, 2 );

function vntd_team_columns_content( $column, $post_id ) {
	global $post;
	the_post_thumbnail('thumbnail', array('class' => 'column-img'));
}

//
// Team Title and Caption
//

add_action("admin_init", "vntd_team_title_settings");   

if(!function_exists('vntd_team_title_settings')) {

	function vntd_team_title_settings(){
	    add_meta_box("team_title_settings", "Team Member", "vntd_team_member_config", "team", "normal", "high");
	    add_meta_box("team_member_social", "Team Member Social", "vntd_team_member_social", "team", "normal", "high");
	}   
	
	function vntd_team_member_config(){
	        global $post;
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;	        
	        $custom = get_post_custom($post->ID);
	        $member_name = $member_position = $member_bio = '';
	        if(isset($custom["member_name"][0])) $member_name = $custom["member_name"][0];
	        if(isset($custom["member_position"][0])) $member_position = $custom["member_position"][0];
	        if(isset($custom["member_bio"][0])) $member_bio = $custom["member_bio"][0];
	
	?>	    
		<div class="metabox-options form-table fullwidth-metabox image-upload-dep">
			
			<div class="metabox-option">
				<h6><?php _e('Name', 'north') ?>:</h6>
				<input type="text" name="member_name" value="<?php echo $member_name; ?>">
			</div>		
			
			<div class="metabox-option">
				<h6><?php _e('Position', 'north') ?>:</h6>
				<input type="text" name="member_position" value="<?php echo $member_position; ?>">
			</div>
			
			<div class="metabox-option">
				<h6><?php _e('Short Bio', 'north') ?>:</h6>
				<textarea name="member_bio"><?php echo $member_bio; ?></textarea>
			</div>
			
		</div>
	<?php
	}
	
	function vntd_team_member_social(){
	        global $post;
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
	        $custom = get_post_custom($post->ID);	
	?>
	
		<div class="metabox-options form-table fullwidth-metabox image-upload-dep">
			
			<?php 
			
			$member_socials = array('facebook','twitter','pinterest','linkedin','instagram','email');
			
			foreach($member_socials as $member_social) {
				$current_val = '';
				if(isset($custom["member_".$member_social][0])) {
					$current_val = $custom["member_".$member_social][0];
				}
				
				echo '<div class="metabox-option">';
				echo '<h6>'.$member_social.'</h6>';
				echo '<input type="text" name="member_'.$member_social.'" value="'.$current_val.'">';
				echo '</div>';
			
			}
			
			?>					
			
		</div>
	
	<?php
	
	}
    
}  

	
	
// Save Slide
	
add_action('save_post', 'vntd_save_team_meta'); 

function vntd_save_team_meta(){
    global $post;  	
	
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
	
		$post_metas = array('member_name','member_position','member_bio');
		
		foreach($post_metas as $post_meta) {
			if(isset($_POST[$post_meta])) update_post_meta($post->ID, $post_meta, $_POST[$post_meta]);
		}
		
		$member_socials = array('twitter','facebook','instagram','pinterest','linkedin','email');
		
		foreach($member_socials as $member_social) {
			if(isset($_POST['member_'.$member_social])) update_post_meta($post->ID, 'member_'.$member_social, $_POST['member_'.$member_social]);
		}

    }

}