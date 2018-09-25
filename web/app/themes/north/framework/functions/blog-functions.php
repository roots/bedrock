<?php
//
// Blog Post Settings
//


add_action("admin_init", "vntd_blog_post_settings");   

// Add Blog Metaboxes
function vntd_blog_post_settings(){   
    add_meta_box("blog_gallery_post_format", __("Gallery Settings",'north'), "vntd_blog_gallery_settings_config", "post", "normal", "high");
    add_meta_box("blog_video_post_format", __("Video Settings",'north'), "vntd_blog_video_settings_config", "post", "normal", "high");
    //add_meta_box("blog_post_settings", __("Post Thumbnail",'north'), "vntd_blog_post_settings_config", "post", "normal", "high");
}

function vntd_blog_post_settings_config(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
		$thumb_setting = $thumb_height = $thumb_lightbox = '';
		if(isset($custom["thumb_setting"][0])) $thumb_setting = $custom["thumb_setting"][0];	
		if(isset($custom["thumb_height"][0])) $thumb_height = $custom["thumb_height"][0];
		if(isset($custom["thumb_lightbox"][0])) $thumb_lightbox = $custom["thumb_lightbox"][0];
?>
    <div class="form-table custom-table fullwidth-metabox">
    	<div class="metabox-option">
    	    		
    	    <h6><?php _e('Thumbnail Display', 'north') ?>:</h6>
    	    <div class="metabox-option-side">    	    
    	    <?php 
    	    
    	    $thumb_setting_arr = array("Display thumbnail on single post page" => "on", "Do NOT display the thumbnail on post page" => "off");
    	    
    	    vntd_create_dropdown('thumb_setting',$thumb_setting_arr,$thumb_setting);
    	    
    	    ?>   	    
    	    </div>
    	</div>
    	<div class="metabox-option">    		
    	    <h6><?php _e('Thumbnail Lightbox', 'north') ?>: <span class="form-caption">(<?php _e('standard post format', 'north') ?>)</span></h6>
    	    <div class="metabox-option-side">   	    
    	    <?php 
    	    
    	    $thumb_lightbox_arr = array("Disable lightbox" => "off","Enable lightbox zoom of thumbnail image" => "on");
    	    
    	    vntd_create_dropdown('thumb_lightbox',$thumb_lightbox_arr,$thumb_lightbox);
    	    
    	    ?>    

    	    </div>
    	</div>
    	<div class="metabox-option">  
            <h6><?php _e('Thumbnail Height', 'north') ?>:</h6>
            <div class="metabox-option-side">            
        	<?php 
        	
        	$thumb_heights = array("Landscape" => "landscape", "Original Aspect Ratio" => "auto");
        	
        	vntd_create_dropdown('thumb_height',$thumb_heights,$thumb_height);
        	
        	?>        
            </div> 
       </div> 
        
    </div> 
<?php
}	

// Gallery Metabox

function vntd_blog_gallery_settings_config(){	
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $gallery_type = $gallery_images = '';
		if(isset($custom["gallery_type"][0])) $gallery_type = $custom["gallery_type"][0];
		if(isset($custom["gallery_images"][0])) $gallery_images = $custom["gallery_images"][0];
?>
    <div class="form-table custom-table fullwidth-metabox">
    	<!--<div class="metabox-option">
    		<h6><?php _e('Gallery Type', 'north') ?>:</h6>
    	    <div class="metabox-option-side">
    	    <?php 
    	    
    	    $gallery_types = array("Lightbox" => "lightbox", "Slider" => "slider");
    	    
    	    vntd_create_dropdown('gallery_type',$gallery_types,$gallery_type);
    	    
    	    ?>
    	    </div>
    	</div>-->
    	<div class="metabox-option">
    		<h6><?php _e('Gallery Images', 'north') ?>:</h6> 
    		
    		<div class="metabox-option-side">
    		<?php vntd_gallery_metabox($gallery_images); ?>	 
    		</div>  
    	</div>   
    </div>
<?php
}


// Video Metabox


function vntd_blog_video_settings_config(){	
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $video_site_url = '';
		if(isset($custom["video_site_url"][0])) $video_site_url = $custom["video_site_url"][0];
?>
    <div class="form-table custom-table fullwidth-metabox">
    	<div class="metabox-option">
    		<h6><?php _e('Video URL', 'north') ?>:<span class="form-caption">(<a target="_blank" href="https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F"> <?php _e('List of supported sites', 'north') ?></a>)</span></h6>
    		
    		<div class="metabox-option-side">
    	    <td class="description-textarea">
    	    	<input type="text" name="video_site_url" value="<?php echo $video_site_url; ?>">
    	    </td>
    	    </div>
    	</div>      
    </div>
<?php
}

	
// Save Custom Fields
	
add_action('save_post', 'vntd_save_post_settings'); 

function vntd_save_post_settings(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
		if(isset($_POST["page_title"])) update_post_meta($post->ID, "page_title", $_POST["page_title"]);	
		if(isset($_POST["tagline"])) update_post_meta($post->ID, "tagline", $_POST["tagline"]);	
		if(isset($_POST["page_layout"])) update_post_meta($post->ID, "page_layout", $_POST["page_layout"]);
		if(isset($_POST["page_sidebar"])) update_post_meta($post->ID, "page_sidebar", $_POST["page_sidebar"]);
		if(isset($_POST["thumb_setting"])) update_post_meta($post->ID, "thumb_setting", $_POST["thumb_setting"]);
		if(isset($_POST["thumb_height"])) update_post_meta($post->ID, "thumb_height", $_POST["thumb_height"]);
		if(isset($_POST["thumb_lightbox"])) update_post_meta($post->ID, "thumb_lightbox", $_POST["thumb_lightbox"]);
		if(isset($_POST["gallery_type"])) update_post_meta($post->ID, "gallery_type", $_POST["gallery_type"]);	
		if(isset($_POST["gallery_images"])) update_post_meta($post->ID, "gallery_images", $_POST["gallery_images"]);
		if(isset($_POST["video_site_url"])) update_post_meta($post->ID, "video_site_url", $_POST["video_site_url"]);
		if(isset($_POST["video_file_url"])) update_post_meta($post->ID, "video_file_url", $_POST["video_file_url"]);
    }

}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Comments Layout
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   global $post;
   ?>
   
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	
		<!-- Comment -->
		<div class="comment">
			<!-- Image -->
			<div class="c-image">
				<?php echo get_avatar($comment,$size='54'); ?>
			</div>
			<!-- Description -->
			<div class="comment-text">
				<!-- Reply Button -->
						
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'],'reply_text' => '<i class="fa fa-reply"></i> '.__('Reply','north')))); ?>		
				<!-- Name -->
				<h1 class="comment-name uppercase font-primary">
					<?php echo get_comment_author(); ?>
				</h1>
				<!-- Date -->
				<h3 class="comment-date font-secondary">
					<?php  echo get_comment_date('d m Y'); ?>
				</h3>
				<!-- Description -->
				<?php comment_text(); ?>
			</div>
			<!-- End Description -->
		</div>
		<!-- End Comment -->
		
	</li>
	
<?php
}

// Blog Comments Script

function vntd_comments_script() {
	if(is_singular())
	wp_enqueue_script('comment-reply');
}
add_action('wp_enqueue_scripts', 'vntd_comments_script');


function vntd_blog_post_tags(){
	if(has_tag()){
	?>
	<p class="post-tags"><?php the_tags('<span>'.__('Tags','north').': </span>', ', ', '<br />'); ?></p>
	<?php
	}
}

function vntd_blog_post_nav(){
	?>	
	<div class="divider line"></div>
	<div id="blog-post-nav" class="blog-navigation">
		<div class="newer-posts boxed-link"><?php previous_post_link('%link'); ?></div>
		<div class="older-posts boxed-link"><?php next_post_link('%link'); ?></div>
	</div>
	<?php
}

function north_meta_enabled() {

	if( !( !is_single() && north_option('blog_meta') == false ) && !( is_single() && north_option('blog_single_meta') == false ) ) {
		return true;
	}
	
	return false;
	
}

function vntd_post_meta() {
	global $post;
	
	?>
	<div class="classic-meta-section">
		<?php if( north_option( 'blog_meta_date' ) ) { ?>
		<span class="vntd-meta-date"><?php the_time('F d, Y'); ?></span>
		<?php
		}
		?>
		<span class="vntd-meta-love"><i class="fa fa-heart-o"></i> 17</span>
		<?php
		if( north_option( 'blog_meta_comments' ) ) {
		?>
		<span class="vntd-meta-comments"><a href="<?php echo get_permalink($post->ID).'#comments'?>" title="<?php _e('View comments','north');?>"><i class="fa fa-comments-o"></i> <?php comments_number('0', '1', '%'); ?></a></span>
		<?php
		}
		if( north_option( 'blog_meta_categories' ) ) {
		?>
		<span class="vntd-meta-categories"><?php the_category(', '); ?></span>		
		<?php 
		}
		?>
	</div> 
	<?php

}

function vntd_post_tags(){

	$posttags = get_the_tags();
	
	if($posttags == NULL) return false;
	
	if ($posttags) {
		echo '<span class="post-meta-tags">';
		$i = 0;
		$len = count($posttags);
		foreach($posttags as $tag) {	
		  echo '<a href="'. get_tag_link($tag->term_id) .'">'; 
		  echo $tag->name;	 
		  echo "</a>";
		   $i++;
		  if($i != $len) echo ', ';		 
		}
		echo '</span>';
	}	
}

function vntd_blog_post_content() {

	global $post;
	
	$post_format = get_post_format($post->ID);
	
	if(!$post_format) {
		$post_format = 'standard';
	}
	
	$blog_head_class = '';
	if(has_post_thumbnail($post->ID) && $post_format != 'video') {
		$blog_head_class = ' inner-head t-shadow';
	}
	
	?>
	
	<div <?php post_class(); ?>>
		<!-- Post Header -->
		<div class="blog-head clearfix<?php echo $blog_head_class; ?>">
			<!-- Post Date -->
			<div class="blog-head-left t-center">
				<!-- Day -->
				<h1 class="uppercase bigger font-primary">
					<?php the_time('d'); ?>
				</h1>
				<!-- Month, Year -->
				<p class="uppercase font-primary">
					<?php the_time('M Y'); ?>
				</p>
			</div>
			<!-- End Post Date -->
			<!-- Post Header -->
			<a href="<?php echo get_permalink($post->ID); ?>" class="blog-head-right ex-link t-left">
				<!-- Header -->
				<h1 class="uppercase font-primary">
					<?php echo get_the_title($post->ID); ?>
				</h1>
				<?php
				if(get_post_meta($post->ID,'page_subtitle',TRUE)) {
					echo '<p>'.get_post_meta($post->ID,'page_subtitle',TRUE).'</p>';
				}
				?>
			</a>
			<!-- Post Header -->
		</div>
		<!-- Post Header -->
		
		<?php if( has_post_thumbnail() ) vntd_post_media(); ?>	

		<!-- Post Details -->
		<div class="details">
		
			<?php if( north_meta_enabled() ) { // if meta section enabled ?>
			<!-- Post Infos -->
			<div class="post-info">
				<?php if( north_option( 'blog_meta_author' ) ) { // if author enabled ?>
				<!-- Post Item -->
				<a href="<?php echo get_the_author_meta( 'user_url'); ?>" class="post-item">
					<i class="fa fa-user"></i>
					<?php the_author(); ?>
					
				</a>
				<?php 
				}
				if( north_option( 'blog_meta_categories' ) ) { // If tags enabled
				?>
				<!-- Post Item -->
				<span class="post-item">
					<i class="fa fa-tags"></i>
					<?php the_category(', '); ?>
				</span>
				<?php
				}
				if( north_option( 'blog_meta_comments' ) ) { // if comments count enabled
				?>
				<!-- Post Item -->
				<a href="<?php echo get_permalink($post->ID).'#comments'?>" title="<?php _e('View comments','north');?>" class="post-item">
					<i class="fa fa-comments"></i>
					<?php comments_number('0', '1', '%'); echo ' '; _e('Comments','north'); ?>
				</a>
				<?php
				}
				?>
			</div>
			<!-- End Post Infos -->
			<?php } ?>
			<!-- Post Description -->
			<?php 
			
			if(!is_single()) { 				
				echo vntd_excerpt(240,true,'post-text'); 			
			} 
			 
			?>		
		</div>
		<!-- End Post Details -->
		
		
		<?php 
		
		if(is_single()) { 
		
			the_content();
		
		}
		
		?>
		
	</div>
		
	<?php

}

function vntd_post_media() {
	
	global $post;
	
	$post_format = get_post_format($post->ID);
	
	if(!$post_format || $post_format == 'standard' || $post_format == 'gallery' && !get_post_meta($post->ID,'gallery_images',TRUE)) {
	wp_enqueue_script('magnific-popup', '', '', '', true);
	wp_enqueue_style('magnific-popup');
	$imgurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
	
	?>
	<div class="single_item mp-gallery">
		<a href="<?php echo $imgurl[0]; ?>" title="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true); ?>">
			<img src="<?php echo $imgurl[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true); ?>">
		</a>
	</div>
	<?php
	} elseif($post_format == 'gallery') {
	
	wp_enqueue_script('magnific-popup', '', '', '', true);
	wp_enqueue_style('magnific-popup');
	
	?>

	<div class="custom_slider">

		<ul class="image_slider clearfix mp-gallery">
		
			<?php
			
			$gallery_images = get_post_meta($post->ID,'gallery_images',TRUE);
			
			if($gallery_images) {
			
				$ids = explode(",", $gallery_images);
				
				foreach($ids as $id) {
					$imgurl = wp_get_attachment_image_src($id, 'full');
					echo '<li class="slide"><a href="'.$imgurl[0].'" title="'.get_post_meta($id, '_wp_attachment_image_alt', true).'"><img src="'.$imgurl[0].'" alt="'.get_post_meta($id, '_wp_attachment_image_alt', true).'"></a></li>';
				}
			
			}	
			
			
			?>
		</ul>
	</div>
	
	<?php
	
	} elseif($post_format == 'video') {
	
		if(!get_post_meta($post->ID, 'video_site_url', true)) echo 'No video URL inserted!';
		 
		echo '<div class="video-containers single_item">'.wp_oembed_get(get_post_meta($post->ID, 'video_site_url', true)).'</div>';
	}

}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Post Views Count
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function vntd_setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}