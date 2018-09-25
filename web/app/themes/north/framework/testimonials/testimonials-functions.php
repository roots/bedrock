<?php

//
// New Post Type
//


add_action('init', 'vntd_testimonial_register');  

function vntd_testimonial_register() {
    $args = array(
        'label' => __('Testimonials', 'north'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => true,
        'supports' => array('title','thumbnail')
       );  

    register_post_type( 'testimonials' , $args );
}


//
// Thumbnail column
//



//
// Testimonial Title and Caption
//

add_action("admin_init", "vntd_testimonial_title_settings");   

function vntd_testimonial_title_settings(){
    add_meta_box("testimonial_title_settings", "Testimonial", "vntd_testimonial_title_config", "testimonials", "normal", "high");
}   

function vntd_testimonial_title_config(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
		
		if(isset($custom["testimonial_content"][0])) $testimonial_content = $custom["testimonial_content"][0];
		if(isset($custom["role"][0])) $role = $custom["role"][0];
		if(isset($custom["name"][0])) $name = $custom["name"][0];
?>
	<div class="metabox-options form-table fullwidth-metabox image-upload-dep">
		
		<div class="metabox-option">
			<h6><?php _e('Name', 'north') ?>:</h6>
			<input type="text" name="name" value="<?php echo $name; ?>">
		</div>		
		
		<div class="metabox-option">
			<h6><?php _e('Role', 'north') ?>:</h6>
			<input type="text" name="role" value="<?php echo $role; ?>">
		</div>
		
		<div class="metabox-option">
			<h6><?php _e('Testimonial', 'north') ?>:</h6>
			<textarea name="testimonial_content"><?php echo $testimonial_content; ?></textarea>
		</div>
		
	</div>
<?php
    }	
	
	
// Save Slide
	
add_action('save_post', 'vntd_save_testimonial_meta'); 

function vntd_save_testimonial_meta(){
    global $post;  	
	
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
	
		$post_metas = array('name','role','testimonial_content');
		
		foreach($post_metas as $post_meta) {
			if(isset($_POST[$post_meta])) update_post_meta($post->ID, $post_meta, $_POST[$post_meta]);
		}
    }

}