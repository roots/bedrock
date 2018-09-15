<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

if (!isset($wp_rewrite))
	$wp_rewrite = new WP_Rewrite();

if(!class_exists('PunchPost')) {
	class PunchPost {
		
		// Variables for Post Data
		public $TP_title;
		public $TP_type;
		public $TP_content;
		public $TP_category;
		public $TP_taxonomy;
		public $TP_terms;
		public $TP_template;
		public $TP_slug;
		public $TP_date;
		public $TP_post_tags;
		public $TP_meta;
		public $TP_auth_id;
		public $TP_status = "publish";
		
		// Variables for Post Updating
		public $TP_current_post;
		public $TP_current_post_id;
		public $TP_current_post_permalink;
		
		// Error Array
		public $TP_errors;
		
		// Creation functions
		public function create() {
			$cat = apply_filters('essgrid_PunchPost_category', 'essential_grid_category');
			
			$error_obj = "";
			if(isset($this->TP_title) ) {
				if ($this->TP_type == 'page') 
					$post = get_page_by_title( $this->TP_title, 'OBJECT', $this->TP_type );
				else 
					$post = get_page_by_title( $this->TP_title, 'OBJECT', $this->TP_type );
					
				$post_data = array(
					'post_title'    => wp_strip_all_tags($this->TP_title),
					'post_name'     => $this->TP_slug,
					'post_content'  => $this->TP_content,
					'post_status'   => $this->TP_status,
					'post_type'     => $this->TP_type,
					'post_author'   => $this->TP_auth_id,
					'post_category' => $this->TP_category,
					'page_template' => $this->TP_template,
					'post_date'		=> $this->TP_date
				);

				if(!isset($post)){
					
					$this->TP_current_post_id = wp_insert_post( $post_data, $error_obj );
					$this->TP_current_post = get_post((integer)$this->TP_current_post_id, 'OBJECT');
					$this->TP_current_post_permalink = get_permalink((integer)$this->TP_current_post_id);
					
					$terms = array();
					$terms_array = explode(',', $this->TP_terms);
					foreach($terms_array as $singleterm){
						$term = get_term_by('slug', $singleterm, $cat);	
						$terms[]=$term->term_id;
					}
					wp_set_post_terms( $this->TP_current_post_id, $terms, $cat);
					
					if(!empty($this->TP_post_tags)){
						wp_set_post_terms( $this->TP_current_post_id, $this->TP_post_tags,'post_tag');
					}
					
					foreach($this->TP_meta as $meta_key => $meta_value){
						if($meta_key == 'eg-clients-icon' && !empty($meta_value)){
							$attach_id = $this->create_image('client.png');
							$meta_value = $attach_id;
						}
						if($meta_key == 'eg-clients-icon-dark' && !empty($meta_value)){
							$attach_id = $this->create_image('client_dark.png');
							$meta_value = $attach_id;
						}
						update_post_meta($this->TP_current_post_id, $meta_key, $meta_value);
					}
					
					global $imagenr;
					if($imagenr==4) $imagenr = 1;
					$attach_id = $this->create_image('demoimage'.$imagenr++.'.jpg');
					set_post_thumbnail( $this->TP_current_post_id, $attach_id );
					
					
					return $this->TP_current_post_id;
				}
				else {
					//$this->update();
					$this->errors[] = 'That page already exists. Try updating instead. Control passed to the update() function.';
					return FALSE;
				}
			} 
			else {
				$this->errors[] = 'Title has not been set.';
				return FALSE;
			}
		}
		
		public function create_image($file){
			$image_url = EG_PLUGIN_PATH . 'admin/assets/images/'.$file;
			$upload_dir = wp_upload_dir();
			$image_data = file_get_contents($image_url);
			$filename = basename($image_url);
			if(wp_mkdir_p($upload_dir['path']))
				$file = $upload_dir['path'] . '/' . $filename;
			else
				$file = $upload_dir['basedir'] . '/' . $filename;
			file_put_contents($file, $image_data);
			
			$wp_filetype = wp_check_filetype($filename, null );
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => sanitize_file_name($filename),
				'post_content' => '',
				'post_status' => 'inherit'
			);
			$attach_id = wp_insert_attachment( $attachment, $file, $this->TP_current_post_id );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			return $attach_id;
		}
		
		// SET POST'S TITLE	
		public function set_title($name){
			$this->TP_title = $name;	
			return $this->TP_title;
		}
		
		// SET POST'S TYPE	
		public function set_type($type){
			$this->TP_type = $type;	
			return $this->TP_type;
		}
		
		// SET POST'S CONTENT	
		public function set_content($content){
			$this->TP_content = $content;	
			return $this->TP_content;
		}
		
		// SET POST'S AUTHOR ID	
		public function set_author_id($auth_id){
			$this->TP_auth_id = $auth_id;	
			return $this->TP_auth_id;
		}

		
		// SET POST'S STATE	
		public function set_post_state($content){
			$this->TP_status = $content;
			return $this->TP_status;
		}
		
		public function set_post_meta($option_array){
			$this->TP_meta = $option_array;
			return $this->TP_meta;
		}
		
		public function set_date($date){
			$this->TP_date = $date;
			return $this->TP_date;
		}
		
		// SET POST SLUG
		public function set_post_slug($slug){
			$args = array('name' => $slug);
			$posts_query = get_posts( $args );
			if( !get_posts( $args ) && !get_page_by_path( $this->TP_slug ) ) {
				$this->TP_slug = $slug;	
				return $this->TP_slug;	
			}
			else {
				$this->errors[] = 'Slug already in use.';
				return FALSE;
			}
		}
		
		// SET PAGE TEMPLATE
		public function set_page_template($content){
			if ($this->TP_type == "page") {
				$this->TP_template = $content;
				return $this->TP_template;
			}
			else {
				$this->errors[] = 'You can only use templates for pages.';
				return FALSE;
			}
		}
		
		// SET POST'S TAXONOMY	
		public function set_tax($tax){
			$this->TP_taxonomy = $tax;	
			return $this->TP_taxonomy;
		}
		
		public function set_tax_terms($terms){
			$this->TP_terms = $terms;
			return $this->TP_terms;
		}
		
		public function set_post_tags($tags){
			$this->TP_post_tags = $tags;
			return $this->TP_post_tags;
		}
		
		public function import_taxonomies($terms){
			$cat = apply_filters('essgrid_PunchPost_category', 'essential_grid_category');
			
			$terms = json_decode($terms,true);	
			//print_r($terms);die;
			foreach($terms as $term){		
				if( !term_exists( $term['name'], $cat ) ){
					wp_insert_term( $term['name'], $cat, array( 'description'	=> $term['category_description'],'slug' => $term['slug'] ) );
				}
			}
		}
		
		// ADD CATEGORY IDs TO THE CATEGORIES ARRAY
		public function add_category($IDs){
			if(is_array($IDs)) {
				foreach ($IDs as $id) {
					if (is_int($id)) {
						$this->TP_category[] = $id;
					} else {
						$this->errors[] = '<b>' .$id . '</b> is not a valid integer input.';
						return FALSE;
					}
				}
			} else {
				$this->errors[] = 'Input specified is not a valid array.';
				return FALSE;
			}
		}
		
		public function prettyprint($content){
			echo "<pre>";
			print_r($content);
			echo "</pre>";
		}
		
		
	}

}

if(!class_exists('PunchPort')) {
	class PunchPort {
		public $TP_pages;
		public $TP_posts;
		public $TP_posts_categories;
		public $TP_tags;
		public $TP_thumbnail;
		public $TP_post_ID;
		public $TP_import_posts;
				
		// Error Array
		public $TP_errors;
		
		public function set_tp_import_posts($json){
			$this->TP_import_posts = $json;
		}
		
		public function import_custom_posts(){
			$cat = apply_filters('essgrid_PunchPost_category', 'essential_grid_category');
			$type = apply_filters('essgrid_PunchPost_custom_post_type', 'essential_grid');
			
			$posts_json = $this->TP_import_posts;
			$posts_array = json_decode($this->TP_import_posts,true);
			foreach ($posts_array as $post){
				$newPost = new PunchPost;
				//Standards
					$newPost->set_title( $post["post_title"] );
					$newPost->set_type( $type );
					$newPost->set_content( $post["post_content"] );
					$newPost->set_post_state( "publish" );
				//Categories	
					$newPost->set_tax($cat);
					$newPost->set_tax_terms($post['post_categories']);
				//Tags
					if(!empty($post['post_tags'])) $newPost->set_post_tags($post['post_tags']);	
				//Meta
					$newPost->set_post_meta( $post["post_options"]);
				
					
				$post_id = $newPost->create();
				
			}
		}
		
		
		// Creation functions
		public function export_pages() {
			$pages = get_pages(); 
			foreach ($pages as $page_data) { 
				$this->TP_pages_array[$page_data->ID]['post_title'] = $page_data->post_title; 
				$this->TP_pages_array[$page_data->ID]['post_author'] = $page_data->post_author;
				$this->TP_pages_array[$page_data->ID]['post_date'] = $page_data->post_date;
				$this->TP_pages_array[$page_data->ID]['post_excerpt'] = $page_data->post_excerpt;
				$this->TP_pages_array[$page_data->ID]['post_status'] = $page_data->post_status;
				$this->TP_pages_array[$page_data->ID]['post_parent'] = $page_data->post_parent;
				$this->TP_pages_array[$page_data->ID]['post_content'] = apply_filters('the_content', $page_data->post_content);
			}
			$this->TP_pages = json_encode($this->TP_pages_array);
		}
		
		public function export_post_categories(){
			$categories = get_categories();
			foreach($categories as $category) { 
				$this->TP_categories_array[$category->term_id]['name'] = $category->name;
				$this->TP_categories_array[$category->term_id]['slug'] = $category->slug;
				$this->TP_categories_array[$category->term_id]['term_group'] = $category->term_group;
				$this->TP_categories_array[$category->term_id]['term_taxonomy_id'] = $category->term_taxonomy_id;
				$this->TP_categories_array[$category->term_id]['taxonomy'] = $category->taxonomy;
				$this->TP_categories_array[$category->term_id]['description'] = $category->description;
				$this->TP_categories_array[$category->term_id]['parent'] = $category->parent;
				$this->TP_categories_array[$category->term_id]['count'] = $category->count;
				$this->TP_categories_array[$category->term_id]['cat_ID'] = $category->cat_ID;
				$this->TP_categories_array[$category->term_id]['category_count'] = $category->category_count;
				$this->TP_categories_array[$category->term_id]['category_description'] = $category->category_description;
				$this->TP_categories_array[$category->term_id]['cat_name'] = $category->cat_name;
				$this->TP_categories_array[$category->term_id]['category_nicename'] = $category->category_nicename;
				$this->TP_categories_array[$category->term_id]['category_parent'] = $category->category_parent;
			} 
			$this->TP_posts_categories = json_encode($this->TP_categories_array);
		}
		
		public function export_tags(){
			$tags = get_tags();
			foreach($tags as $tag) { 
				$this->TP_tags_array[$tag->term_id]['name'] = $tag->name;
				$this->TP_tags_array[$tag->term_id]['slug'] = $tag->slug;
				$this->TP_tags_array[$tag->term_id]['term_group'] = $tag->term_group;
				$this->TP_tags_array[$tag->term_id]['term_taxonomy_id'] = $tag->term_taxonomy_id;
				$this->TP_tags_array[$tag->term_id]['taxonomy'] = $tag->taxonomy;
				$this->TP_tags_array[$tag->term_id]['description'] = $tag->description;
				$this->TP_tags_array[$tag->term_id]['parent'] = $tag->parent;
			}
			$this->TP_tags = json_encode($this->TP_tags_array);
		}
		
		public function export_custom_posts($custom_post_type){
			$args=array(
				'post_type' => $custom_post_type,
				'posts_per_page' => 99999,
				'suppress_filters' => 0
			);
			$list = get_posts($args);
			foreach ($list as $post_data) :
				$this->TP_posts_array[$post_data->ID]['post_title'] = $post_data->post_title; 
				$this->TP_posts_array[$post_data->ID]['post_author'] = $post_data->post_author;
				$this->TP_posts_array[$post_data->ID]['post_date'] = $post_data->post_date;
				$this->TP_posts_array[$post_data->ID]['post_excerpt'] = $post_data->post_excerpt;
				$this->TP_posts_array[$post_data->ID]['post_status'] = $post_data->post_status;
				$this->TP_posts_array[$post_data->ID]['post_parent'] = $post_data->post_parent;
				$this->TP_posts_array[$post_data->ID]['post_content'] = apply_filters('the_content', $post_data->post_content);
				$this->TP_posts_array[$post_data->ID]['post_options'] = $this->all_get_options($post_data->ID);
			endforeach;
			$this->TP_posts = json_encode($this->TP_posts_array);
			//$this->TP_posts = $this->array_to_xml($this->TP_posts_array);
		}
		
		public function all_get_options($id = 0){
			if ($id == 0) :
				global $wp_query;
				$content_array = $wp_query->get_queried_object();
				if(isset($content_array->ID)){
					$id = $content_array->ID;
				}
			endif;   
		
			$first_array = get_post_custom_keys($id);
		
			if(isset($first_array)){
				foreach ($first_array as $key => $value) :
					   $second_array[$value] =  get_post_meta($id, $value, FALSE);
						foreach($second_array as $second_key => $second_value) :
								   $result[$second_key] = $second_value[0];
						endforeach;
				 endforeach;
			 }
			
			if(isset($result)){
				return $result;
			}
		}
		
		public function export_posts() {
			$args=array(
				'posts_per_page' => 99999,
				'suppress_filters' => 0
			);
			$posts = get_posts($args); 
			$counter=1;
			foreach ($posts as $post_data) { 
				if($counter++>30){
					$this->TP_posts_array[$post_data->ID]['post_title'] = $post_data->post_title; 
					$this->TP_posts_array[$post_data->ID]['post_author'] = $post_data->post_author;
					$this->TP_posts_array[$post_data->ID]['post_date'] = $post_data->post_date;
					$this->TP_posts_array[$post_data->ID]['post_excerpt'] = $post_data->post_excerpt;
					$this->TP_posts_array[$post_data->ID]['post_status'] = $post_data->post_status;
					$this->TP_posts_array[$post_data->ID]['post_parent'] = $post_data->post_parent;
					$this->TP_posts_array[$post_data->ID]['post_content'] = apply_filters('the_content', $post_data->post_content);
					//Categories
						$categories = get_the_category($post_data->ID);
						$separator = ',';
						$output = '';
						if($categories){
							foreach($categories as $category) {
								$output .= $category->slug . $separator;
							}
							$this->TP_posts_array[$post_data->ID]['post_categories'] = trim($output, $separator);
						}
					//Tags
						$posttags = get_the_tags($post_data->ID);
						$count=0;
						$output = '';
						if ($posttags) {
						  foreach($posttags as $tag) {
							  $output .= $tag->slug . $separator;
						  }
						  $this->TP_posts_array[$post_data->ID]['post_tags'] = trim($output, $separator);
						}
					//Options
						$this->TP_posts_array[$post_data->ID]['post_options'] = $this->all_get_options($post_data->ID);
				}
			}
			$this->TP_posts = json_encode($this->TP_posts_array);
		}
		
		public function save_export(){
			
		}
		
		public function pretty_print($content){
			echo "<pre><code>";
			print_r($content);
			echo "</code></pre>";
			echo "<hr>";
		}
		
		
	}
}
?>