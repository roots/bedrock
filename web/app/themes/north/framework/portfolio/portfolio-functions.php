<?php

//
// New Post Type
//

add_action('init', 'vntd_portfolio_register');  

function vntd_portfolio_register() {
    $args = array(
        'label' => __('Portfolio', 'north'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => true,
        'supports' => array('title','editor','thumbnail')
       );  

    register_post_type( 'portfolio' , $args );
    
    register_taxonomy(
    	"project-type", 
    	array("portfolio"), 
    	array(
    		"hierarchical" => true, 
    		"context" => "normal", 
    		'show_ui' => true,
    		"label" => "Portfolio Categories", 
    		"singular_label" => "Portfolio Category", 
    		"rewrite" => true
    	)
    );
}

//
// New Columns
//

add_filter( 'manage_edit-portfolio_columns', 'vntd_portfolio_columns_settings' ) ;

function vntd_portfolio_columns_settings( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __('Title', 'north'),
		'category' => __( 'Category', 'north'),
		'date' => __('Date', 'north'),
		'thumbnail' => ''	
	);

	return $columns;
}

add_action( 'manage_portfolio_posts_custom_column', 'vntd_portfolio_columns_content', 10, 2 );

function vntd_portfolio_columns_content( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'category' :

			$taxonomy = "project-type";
			$post_type = get_post_type($post_id);
			$terms = get_the_terms($post_id, $taxonomy);
		 
			if ( !empty($terms) ) {
				foreach ( $terms as $term )
					$post_terms[] = "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
				echo join( ', ', $post_terms );
			}
			else echo '<i>No categories.</i>';

			break;

		/* If displaying the 'genre' column. */
		case 'thumbnail' :

			the_post_thumbnail('thumbnail', array('class' => 'column-img'));

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
	

// Additional Settings

add_action("admin_init", "vntd_portfolio_extra_settings");   

function vntd_portfolio_extra_settings(){
    add_meta_box("portfolio_extra_settings", "Portfolio Post Settings", "vntd_portfolio_extra_settings_config", "portfolio", "normal", "high");
}   

function vntd_portfolio_extra_settings_config(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $link_type = $home_button = $home_button_link = $portfolio_external_url = '';
		if(isset($custom["link_type"][0])) $link_type = $custom["link_type"][0];
		if(isset($custom["portfolio_external_url"][0])) $portfolio_external_url = $custom["portfolio_external_url"][0];
?>

	<div class="metabox-options form-table fullwidth-metabox image-upload-dep">
		
		<div class="metabox-option">
			<h6><?php _e('Thumbnail Link Type', 'north') ?>:</h6>
			
			<?php 
			
			$link_type_arr = array('Default - content loaded with Ajax' => 'default', 'Direct Link - post opens in new page' => 'direct', 'External Link - thumbnail links to external URL' => 'external'); 
			
			vntd_create_dropdown('link_type',$link_type_arr,$link_type, true);
			
			?>
			<p class="description">Choose if the post content should be loaded dynamically with Ajax or opened in a new tab/window.</p>
		</div>
		
		<div class="metabox-option fold fold-link_type fold-external" <?php if($link_type != "external") echo 'style="display:none;"'; ?>>
			<h6><?php _e('External URL','north'); ?>:</h6>
			
			<input type="text" name="portfolio_external_url" value="<?php echo $portfolio_external_url; ?>">
			
		</div>
		
		
	</div>

<?php

}
	
// Save Custom Fields
	
add_action('save_post', 'vntd_save_portfolio_post_settings'); 

function vntd_save_portfolio_post_settings(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
		if(isset($_POST["title_disable"])) update_post_meta($post->ID, "title_disable", $_POST["title_disable"]);	
		if(isset($_POST["tagline"])) update_post_meta($post->ID, "tagline", $_POST["tagline"]);	
		if(isset($_POST["thumb_lightbox"])) update_post_meta($post->ID, "thumb_lightbox", $_POST["thumb_lightbox"]);		
		if(isset($_POST["link_type"])) update_post_meta($post->ID, "link_type", $_POST["link_type"]);
		if(isset($_POST["home_button"])) update_post_meta($post->ID, "home_button", $_POST["home_button"]);
		if(isset($_POST["home_button_link"])) update_post_meta($post->ID, "home_button_link", $_POST["home_button_link"]);
		if(isset($_POST["related_work"])) update_post_meta($post->ID, "related_work", $_POST["related_work"]);
		if(isset($_POST["post_layout"])) update_post_meta($post->ID, "post_layout", $_POST["post_layout"]);
		if(isset($_POST["gallery_images"])) update_post_meta($post->ID, "gallery_images", $_POST["gallery_images"]);
		if(isset($_POST["gallery_type"])) update_post_meta($post->ID, "gallery_type", $_POST["gallery_type"]);
		if(isset($_POST["post_video_url"])) update_post_meta($post->ID, "post_video_url", $_POST["post_video_url"]);
		if(isset($_POST["portfolio_external_url"])) update_post_meta($post->ID, "portfolio_external_url", $_POST["portfolio_external_url"]);
		
    }

}

//
// Filtering Menu
//

function vntd_portfolio_item_class(){
	
	global $post;
	$output = '';
    $terms = wp_get_object_terms($post->ID, "project-type");
	foreach ( $terms as $term ) {
		$output .= $term->slug . " ";
	}		
	
	return $output;
	
}

function vntd_portfolio_overlay_categories(){
	
	global $post;
    $terms = wp_get_object_terms($post->ID, "project-type");
	foreach ( $terms as $term ) {
		echo $term->name;
		if(end($terms) !== $term){
			echo ", ";
		}
	}	
	
}

function vntd_portfolio_holder_class(){
	
	global $post;
	
	if(get_post_meta($post->ID, 'portfolio_post_type', true) == "direct" || get_post_meta($post->ID, 'video_post_type', true) == "direct")
	
	echo "gallery clearfix";	
}

function vntd_portfolio_navigation(){
	
	global $post,$smof_data;
	
	// Check if Portfolio Navigation isn't disabled
	if(!get_post_meta($post->ID, 'nav_disabled', true)){
			
		echo '<div id="portfolio-navigation" class="page-title-side">';
		if(get_permalink(get_adjacent_post(false,'',false)) != get_permalink($post->ID)){
			echo '<a href="'.get_permalink(get_adjacent_post(false,'',false)).'" class="portfolio-prev fa fa-angle-left"></a>';
		}
		// Check if Parent Portfolio Page is set
		if(get_post_meta($post->ID, 'home_button', true) == 'enabled' && get_post_meta($post->ID, 'home_button_link', true)){
		
			$home_url = get_permalink(get_post_meta($post->ID, 'home_button_link', true));
			if(!$home_url) {
				$home_url = $smof_data['vntd_portfolio_url'];
			}
			if($home_url) {
				echo '<a href="'.$home_url.'" class="portfolio-home fa fa-th"></a>';
			}			
		}
		
		if(get_permalink(get_adjacent_post(false,'',true)) != get_permalink($post->ID)){
			echo '<a href="'.get_permalink(get_adjacent_post(false,'',true)).'" class="portfolio-next fa fa-angle-right"></a>';
		}
		
		echo '</div>';
	}
}


//
// Retrieve Custom Values
//


function vntd_portfolio_overlay_icon(){

	global $post;	
	$post_type = get_post_meta($post->ID, 'portfolio_post_type', true);
	
	if($post_type == "direct"){
		echo "resize-full";
	}else{
		echo "link";
	}
				
}	

function vntd_portfolio_zoom_icon($page_id = NULL, $type = NULL) {
	
	global $post;
	
	$rel = 'prettyPhoto';
	$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
	
	if($page_id) {
		$rel = 'gallery[gallery'.$page_id.']'; // If Portfolio Page, create a global gallery
	}

	if(!get_post_meta($post->ID, 'lightbox_disabled', true)) {
		echo '<a href="'.$thumb_url[0].'" rel="'.$rel.'"><span class="hover-icon hover-icon-zoom"></span></a>';
	}	

}


function vntd_portfolio_hidden_images() {

	global $post;	
	
	$gallery_images = get_post_meta($post->ID, 'gallery_images', true);

	if(get_post_meta($post->ID, 'on_click', true) == "lightbox" && $gallery_images){
		echo '<div class="lightbox-hidden">';				
		$ids = explode(",", $gallery_images);		
		foreach(array_slice($ids,1) as $id){
			$imgurl = wp_get_attachment_image_src($id, "large");
			echo '<a href="'.$imgurl[0].'" rel="gallery[gallery'. $post->ID .']"></a>';
		}
		echo '</div>';	
	}

}

function vntd_lightbox_gallery_images() {
	
	global $post;
	$gallery_images = get_post_meta($post->ID, 'gallery_images', true);
	
	if($gallery_images){
	
		echo '<div class="lightbox-hidden">';				
		$ids = explode(",", $gallery_images);				
		foreach($ids as $id){
			echo '<a href="'.wp_get_attachment_url($id).'" rel="gallery[gallery'. $post->ID .']"></a>';
		}
		echo '</div>';
					
	}

}

function vntd_portfolio_filters($cats) {
		
	if(!$cats) {
		$portfolios_cats = get_categories('taxonomy=project-type');
		$cats = '';		
		foreach($portfolios_cats as $portfolio_cat) {
			$cats .= $portfolio_cat->slug.',';
		}		
	}
	?>
	<div id="options" class="filter-menu fullwidth">
		<ul id="filters" class="option-set relative normal font-primary uppercase" data-option-key="filter">
			<li><a href="#filter" data-option-value="*" class="selected"><?php _e('Show All', 'north'); ?></a></li>
			<?php	 
			
			$categories = explode(",", $cats);   
			
			foreach ($categories as $value){
				$term = get_term_by('slug', $value, 'project-type');
				if(isset($term->name)) {
					echo '<li><a href="#filter" data-option-value=".'. $value .'"><span>' . $term->name . "</span></a></li>";	
				} 
			}
			?>
		</ul>
	</div>
	<?php
}


function vntd_related_work() {
	global $post;
	
	$cols = 4;
	$title = $nav_style = $url = '';
	$thumb_size = 'portfolio-square';
	
	echo '<div id="related-work" class="vntd-carousel portfolio-carousel vntd-carousel-nav-side portfolio-style-default vntd-cols-'.$cols.'" data-cols="'.$cols.'">';
	echo '<h3>'.__('Related Work','north').'</h3>';
		
		vntd_carousel_heading($title,$nav_style,$url);
		echo '<div class="carousel-overflow"><div class="carousel-holder vntd-row"><ul>';
					
			wp_reset_postdata();
			
			$args = array(
				'posts_per_page' => 8,
				'project-type'		=> $cats,
				'post_type' => 'portfolio',
				'post__not_in' => array($post->ID)
			);
			$the_query = new WP_Query($args); 
			
			if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
			
			echo '<li class="carousel-item span'.vntd_carousel_get_cols($cols).'">';			
			
			?>	
						
				<div class="portfolio-thumbnail-holder thumbnail-default hover-item">
					<a href="<?php echo get_permalink(); ?>" class="noSwipe portfolio-thumbnail">
						<img src="<?php echo vntd_thumb(460,345); ?>" alt>			    
						<span class="hover-icon hover-icon-link"></span>
					</a>
					
					<div class="portfolio-thumbnail-caption">
					    <h4 class="caption-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h4>
					    <span class="caption-categories"><?php vntd_portfolio_overlay_categories(); ?></span>					    
					</div>			
				</div>
			
			<?php

			echo '</li>';
			
			endwhile; endif; wp_reset_postdata();		
		
		echo '</ul></div></div></div>';

}