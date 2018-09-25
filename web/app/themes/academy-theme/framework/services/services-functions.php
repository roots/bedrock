<?php

//
// New Post Type
//


add_action('init', 'vntd_services_register');  

function vntd_services_register() {
    $args = array(
        'label' => __('Services', 'north'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => true,
        'supports' => array('title','thumbnail')
       );  

    register_post_type( 'services' , $args );
}

//
// Services Title and Caption
//

add_action("admin_init", "vntd_services_title_settings");   

function vntd_services_title_settings(){
    add_meta_box("services_title_settings", "services", "vntd_services_title_config", "Services", "normal", "high");
}   

function vntd_services_title_config(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
		$title = $icon = $desc = '';
		if(isset($custom["title"][0])) $title = $custom["title"][0];
		if(isset($custom["icon"][0])) $icon = $custom["icon"][0];
		if(isset($custom["desc"][0])) $desc = $custom["desc"][0];
?>
	<div class="metabox-options form-table fullwidth-metabox image-upload-dep">
		
		<div class="metabox-option">
			<h6><?php _e('Title', 'north') ?>:</h6>
			<input type="text" name="title" value="<?php echo $title; ?>">
		</div>
		
		<div class="metabox-option">
			<h6><?php _e('Description', 'north') ?>:</h6>
			<textarea name="desc"><?php echo $desc; ?></textarea>
		</div>		
		
		<div class="metabox-option">
			<h6><?php _e('Font-Awesome Icon', 'north') ?>:</h6>
			<?php
			
			//vntd_create_dropdown( 'icon', vntd_fontawesome_array(), $icon );
			vntd_icon_select( 'icon', $icon );
			
			?>
		</div>
		
	</div>
<?php
    }	
	
	
// Save Slide
	
add_action('save_post', 'vntd_save_services_meta'); 

function vntd_save_services_meta(){
    global $post;  	
	
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
	
		$post_metas = array('title','desc','icon');
		
		foreach($post_metas as $post_meta) {
			if(isset($_POST[$post_meta])) update_post_meta($post->ID, $post_meta, $_POST[$post_meta]);
		}
    }

}