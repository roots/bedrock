<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderFunctionsWP {

	public static $urlSite;
	public static $urlAdmin;
	
	const SORTBY_NONE = "none";
	const SORTBY_ID = "ID";
	const SORTBY_AUTHOR = "author";
	const SORTBY_TITLE = "title";
	const SORTBY_SLUG = "name";
	const SORTBY_DATE = "date";
	const SORTBY_LAST_MODIFIED = "modified";
	const SORTBY_RAND = "rand";
	const SORTBY_COMMENT_COUNT = "comment_count";
	const SORTBY_MENU_ORDER = "menu_order";
	
	const ORDER_DIRECTION_ASC = "ASC";
	const ORDER_DIRECTION_DESC = "DESC";
	
	const THUMB_SMALL = "thumbnail";
	const THUMB_MEDIUM = "medium";
	const THUMB_LARGE = "large";
	const THUMB_FULL = "full";
	
	const STATE_PUBLISHED = "publish";
	const STATE_DRAFT = "draft";
	
	
	/**
	 * 
	 * init the static variables
	 */
	public static function initStaticVars(){
		
		self::$urlAdmin = admin_url();			
		if(substr(self::$urlAdmin, -1) != "/")
			self::$urlAdmin .= "/";
			
	}
	
	
	/**
	 * 
	 * get sort by with the names
	 */
	public static function getArrSortBy(){
		$arr = array();
		$arr[self::SORTBY_ID] = "Post ID"; 
		$arr[self::SORTBY_DATE] = "Date";
		$arr[self::SORTBY_TITLE] = "Title"; 
		$arr[self::SORTBY_SLUG] = "Slug"; 
		$arr[self::SORTBY_AUTHOR] = "Author";
		$arr[self::SORTBY_LAST_MODIFIED] = "Last Modified"; 
		$arr[self::SORTBY_COMMENT_COUNT] = "Number Of Comments";
		$arr[self::SORTBY_RAND] = "Random";
		$arr[self::SORTBY_NONE] = "Unsorted";
		$arr[self::SORTBY_MENU_ORDER] = "Custom Order";
		return($arr);
	}
	
	
	/**
	 * 
	 * get array of sort direction
	 */
	public static function getArrSortDirection(){
		$arr = array();
		$arr[self::ORDER_DIRECTION_DESC] = "Descending";
		$arr[self::ORDER_DIRECTION_ASC] = "Ascending";
		return($arr);
	}
	
	
	/**
	 * get blog id
	 */
	public static function getBlogID(){
		global $blog_id;
		return($blog_id);
	}
	
	
	/**
	 * 
	 * get blog id
	 */
	public static function isMultisite(){
		$isMultisite = is_multisite();
		return($isMultisite);
	}
	
	
	/**
	 * 
	 * check if some db table exists
	 */
	public static function isDBTableExists($tableName){
		global $wpdb;
		
		if(empty($tableName))
			RevSliderFunctions::throwError("Empty table name!!!");
		
		$sql = "show tables like '$tableName'";
		
		$table = $wpdb->get_var($sql);
		
		if($table == $tableName)
			return(true);
			
		return(false);
	}
	
	
	/**
	 * 
	 * get wordpress base path
	 */
	public static function getPathBase(){
		return ABSPATH;
	}
	
	/**
	 * 
	 * get wp-content path
	 */
	public static function getPathUploads(){	
		global $wpdb;
		if(self::isMultisite()){
			if(!defined("BLOGUPLOADDIR")){
				$pathBase = self::getPathBase();
				//$pathContent = $pathBase."wp-content/uploads/";
				$pathContent = $pathBase."wp-content/uploads/sites/{$wpdb->blogid}/";
			}else
			  $pathContent = BLOGUPLOADDIR;
		}else{
			$pathContent = WP_CONTENT_DIR;
			if(!empty($pathContent)){
				$pathContent .= "/";
			}
			else{
				$pathBase = self::getPathBase();
				$pathContent = $pathBase."wp-content/uploads/";
			}
		}
		
		return($pathContent);
	}
	
	/**
	 * 
	 * get content url
	 */
	public static function getUrlUploads(){
	
		if(self::isMultisite() == false){	//without multisite
			$baseUrl = content_url()."/";
		}
		else{	//for multisite
			$arrUploadData = wp_upload_dir();
			$baseUrl = $arrUploadData["baseurl"]."/";
		}
		
		return($baseUrl);
		
	}
	
	
	/**
	 * Check if current user is administrator
	 **/
	public static function isAdminUser(){
		return current_user_can('administrator');
	}
	
	
	/* Import media from url
	 *
	 * @param string $file_url URL of the existing file from the original site
	 * @param int $folder_name The slidername will be used as folder name in import
	 *
	 * @return boolean True on success, false on failure
	 */
	public static function import_media($file_url, $folder_name) {
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		
		$ul_dir = wp_upload_dir();
		$artDir = 'revslider/';
		
		//if the directory doesn't exist, create it	
		if(!file_exists($ul_dir['basedir'].'/'.$artDir)) mkdir($ul_dir['basedir'].'/'.$artDir);
		if(!file_exists($ul_dir['basedir'].'/'.$artDir.$folder_name)) mkdir($ul_dir['basedir'].'/'.$artDir.$folder_name);
		
		//rename the file... alternatively, you could explode on "/" and keep the original file name
		
		$filename = basename($file_url);
		//$siteurl = get_option('siteurl');
		
		if(@fclose(@fopen($file_url, "r"))){ //make sure the file actually exists
			
			$saveDir = $ul_dir['basedir'].'/'.$artDir.$folder_name.$filename;
			
			$atc_id = self::get_image_id_by_url($artDir.$folder_name.$filename);
			
			if($atc_id == false || $atc_id == NULL){
				copy($file_url, $saveDir);
				
				$file_info = getimagesize($saveDir);

				//create an array of attachment data to insert into wp_posts table
				$artdata = array(
					'post_author' => 1, 
					'post_date' => current_time('mysql'),
					'post_date_gmt' => current_time('mysql'),
					'post_title' => $filename, 
					'post_status' => 'inherit',
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'post_name' => sanitize_title_with_dashes(str_replace("_", "-", $filename)),
					'post_modified' => current_time('mysql'),
					'post_modified_gmt' => current_time('mysql'),
					'post_parent' => '',
					'post_type' => 'attachment',
					'guid' => $ul_dir['baseurl'].'/'.$artDir.$folder_name.$filename,
					'post_mime_type' => $file_info['mime'],
					'post_excerpt' => '',
					'post_content' => ''
				);
				//insert the database record
				$attach_id = wp_insert_attachment($artdata, $artDir.$folder_name.$filename);
			}else{
				$attach_id = $atc_id;
			}

			//generate metadata and thumbnails
			if($attach_data = wp_generate_attachment_metadata($attach_id, $saveDir)) wp_update_attachment_metadata($attach_id, $attach_data);
			if(!self::isMultisite()) $artDir = 'uploads/'.$artDir;
			return array("id" => $attach_id, "path" => $artDir.$folder_name.$filename);
		}else{
			return false;
		}
	}
	
	
	/**
	 * 
	 * register widget (must be class)
	 */
	public static function registerWidget($widgetName){
		add_action('widgets_init', create_function('', 'return register_widget("'.$widgetName.'");'));
	}

	/**
	 * get image relative path from image url (from upload)
	 */
	public static function getImagePathFromURL($urlImage){
		
		$baseUrl = self::getUrlUploads();
		$pathImage = str_replace($baseUrl, "", $urlImage);
		
		return($pathImage);
	}
	
	/**
	 * get image real path physical on disk from url
	 */
	public static function getImageRealPathFromUrl($urlImage){
		$filepath = self::getImagePathFromURL($urlImage);
		$realPath = RevSliderFunctionsWP::getPathUploads().$filepath;
		return($realPath);
	}
	
	
	/**
	 * 
	 * get image url from image path.
	 */
	public static function getImageUrlFromPath($pathImage){
		//protect from absolute url
		$pathLower = strtolower($pathImage);
		if(strpos($pathLower, "http://") !== false || strpos($pathLower, "https://") !== false || strpos($pathLower, "www.") === 0)
			return($pathImage);
		
		$urlImage = self::getUrlUploads().$pathImage;
		return($urlImage); 
	}
	
	
	/**	
	 * 
	 * get post categories list assoc - id / title
	 */
	public static function getCategoriesAssoc($taxonomy = "category"){
		
		if(strpos($taxonomy,",") !== false){
			$arrTax = explode(",", $taxonomy);
			$arrCats = array();
			foreach($arrTax as $tax){
				$cats = self::getCategoriesAssoc($tax);
				$arrCats = array_merge($arrCats,$cats);
			}
			
			return($arrCats);
		}	
		
		//$cats = get_terms("category");
		$args = array("taxonomy"=>$taxonomy);
		$cats = get_categories($args);
		
		$arrCats = array();
		foreach($cats as $cat){
			$numItems = $cat->count;
			$itemsName = "items";
			if($numItems == 1)
				$itemsName = "item";
				
			$title = $cat->name . " ($numItems $itemsName)";
			
			$id = $cat->cat_ID;
			$arrCats[$id] = $title;
		}
		return($arrCats);
	}
	
	
	/**
	 * 
	 * return post type title from the post type
	 */
	public static function getPostTypeTitle($postType){
		
		$objType = get_post_type_object($postType);
		
		if(empty($objType))
			return($postType);

		$title = $objType->labels->singular_name;
		
		return($title);
	}
	
	
	/**
	 * 
	 * get post type taxomonies
	 */
	public static function getPostTypeTaxomonies($postType){
		$arrTaxonomies = get_object_taxonomies(array( 'post_type' => $postType ), 'objects');
		
		$arrNames = array();
		foreach($arrTaxonomies as $key=>$objTax){			
			$arrNames[$objTax->name] = $objTax->labels->name;
		}
		
		return($arrNames);
	}
	
	/**
	 * 
	 * get post types taxonomies as string
	 */
	public static function getPostTypeTaxonomiesString($postType){
		$arrTax = self::getPostTypeTaxomonies($postType);
		$strTax = "";
		foreach($arrTax as $name=>$title){
			if(!empty($strTax))
				$strTax .= ",";
			$strTax .= $name;
		}
		
		return($strTax);
	}
	
	
	/**
	 * 
	 * get all the post types including custom ones
	 * the put to top items will be always in top (they must be in the list)
	 */
	public static function getPostTypesAssoc($arrPutToTop = array()){
		 $arrBuiltIn = array(
			"post"=>"post",
			"page"=>"page",
		 );
		 
		 $arrCustomTypes = get_post_types(array('_builtin' => false));
		 
		 //top items validation - add only items that in the customtypes list
		 $arrPutToTopUpdated = array();
		 foreach($arrPutToTop as $topItem){
			if(in_array($topItem, $arrCustomTypes) == true){
				$arrPutToTopUpdated[$topItem] = $topItem;
				unset($arrCustomTypes[$topItem]);
			}
		 }
		 
		 $arrPostTypes = array_merge($arrPutToTopUpdated,$arrBuiltIn,$arrCustomTypes);
		 
		 //update label
		 foreach($arrPostTypes as $key=>$type){
			$arrPostTypes[$key] = self::getPostTypeTitle($type);			 		
		 }
		 
		 return($arrPostTypes);
	}
	
	
	/**
	 * 
	 * get the category data
	 */
	public static function getCategoryData($catID){
		$catData = get_category($catID);
		if(empty($catData))
			return($catData);
			
		$catData = (array)$catData;			
		return($catData);
	}
	
	
	/**
	 * 
	 * get posts by coma saparated posts
	 */
	public static function getPostsByIDs($strIDs, $slider_id, $is_gal, $additional = array()){
		
		if(is_string($strIDs)){
			$arr = explode(",",$strIDs);
		}else{
			$arr = $strIDs;
		}

		$query = array(
			'post_type'=>"any",
			'ignore_sticky_posts' => 1,
			'post__in' => $arr
		);
		
		if($is_gal){
			$query['post_status'] = 'inherit';
			$query['orderby'] = 'post__in';
		}
		
		$query = array_merge($query, $additional);
		$query = apply_filters('revslider_get_posts', $query, $slider_id);
		
		$objQuery = new WP_Query($query);
		
		$arrPosts = $objQuery->posts;		

		//dmp($query);dmp("num posts: ".count($arrPosts));exit();
		foreach($arrPosts as $key=>$post){
				
			if(method_exists($post, "to_array"))
				$arrPosts[$key] = $post->to_array();
			else
				$arrPosts[$key] = (array)$post;
		}
		


		return($arrPosts);
	}
	
	
	/**
	 * 
	 * get posts by some category
	 * could be multiple
	 */
	public static function getPostsByCategory($slider_id,$catID,$sortBy = self::SORTBY_ID,$direction = self::ORDER_DIRECTION_DESC,$numPosts=-1,$postTypes="any",$taxonomies="category",$arrAddition = array()){
		
		//get post types
		if(strpos($postTypes,",") !== false){
			$postTypes = explode(",", $postTypes);
			if(array_search("any", $postTypes) !== false)
				$postTypes = "any";		
		}
		
		if(empty($postTypes))
			$postTypes = "any";
		
		if(strpos($catID,",") !== false)
			$catID = explode(",",$catID);
		else
			$catID = array($catID);
		
		if(RevSliderWpml::isWpmlExists()){ //translate categories to languages
			$newcat = array();
			foreach($catID as $id){
				//$newcat[] = icl_object_id($id, 'category', true);
				$newcat[] = apply_filters( 'wpml_object_id', $id, 'category', true );
			}
			$catID = $newcat;
		}
		
		$query = array(
			'order'=>$direction,
			'ignore_sticky_posts' => 1,
			'posts_per_page'=>$numPosts,
			'showposts'=>$numPosts,
			'post_type'=>$postTypes
		);		

		//add sort by (could be by meta)
		if(strpos($sortBy, "meta_num_") === 0){
			$metaKey = str_replace("meta_num_", "", $sortBy);
			$query["orderby"] = "meta_value_num";
			$query["meta_key"] = $metaKey;
		}else
		if(strpos($sortBy, "meta_") === 0){
			$metaKey = str_replace("meta_", "", $sortBy);
			$query["orderby"] = "meta_value";
			$query["meta_key"] = $metaKey;
		}else
			$query["orderby"] = $sortBy;
			
		//get taxonomies array
		$arrTax = array();
		if(!empty($taxonomies)){
			$arrTax = explode(",", $taxonomies);
		}
			
		if(!empty($taxonomies)){
		
			$taxQuery = array();
		
			//add taxomonies to the query
			if(strpos($taxonomies,",") !== false){	//multiple taxomonies
				$taxonomies = explode(",",$taxonomies);
				foreach($taxonomies as $taxomony){
					$taxArray = array(
						'taxonomy' => $taxomony,
						'field' => 'id',
						'terms' => $catID
					);			
					$taxQuery[] = $taxArray;
				}
			}else{		//single taxomony
				$taxArray = array(
					'taxonomy' => $taxonomies,
					'field' => 'id',
					'terms' => $catID
				);			
				$taxQuery[] = $taxArray;				
			}
			
			$taxQuery['relation'] = 'OR';
			
			$query['tax_query'] = $taxQuery;
		} //if exists taxanomies
		
		
		if(!empty($arrAddition))
			$query = array_merge($query, $arrAddition);
		
		$query = apply_filters('revslider_get_posts', $query, $slider_id);
		
		$objQuery = new WP_Query($query);

		$arrPosts = $objQuery->posts;

		
		foreach($arrPosts as $key=>$post){
			
			if(method_exists($post, "to_array"))
				$arrPost = $post->to_array();				
			else
				$arrPost = (array)$post;
			
			$arrPostCats = self::getPostCategories($post, $arrTax);
			$arrPost["categories"] = $arrPostCats;
			
			$arrPosts[$key] = $arrPost;
		}
		
		return($arrPosts);
	}
	
	/**
	 * 
	 * get post categories by postID and taxonomies
	 * the postID can be post object or array too
	 */
	public static function getPostCategories($postID,$arrTax){
		
		if(!is_numeric($postID)){
			$postID = (array)$postID;
			$postID = $postID["ID"];
		}
			
		$arrCats = wp_get_post_terms( $postID, $arrTax);
		$arrCats = RevSliderFunctions::convertStdClassToArray($arrCats);
		return($arrCats);
	}
	
	
	/**
	 * 
	 * get single post
	 */
	public static function getPost($postID){
		$post = get_post($postID);
		if(empty($post))
			RevSliderFunctions::throwError("Post with id: $postID not found");
		
		$arrPost = $post->to_array();
		return($arrPost);
	}

	
	/**
	 * 
	 * update post state
	 */
	public static function updatePostState($postID,$state){
		$arrUpdate = array();
		$arrUpdate["ID"] = $postID;
		$arrUpdate["post_status"] = $state;
		
		wp_update_post($arrUpdate);
	}
	
	/**
	 * 
	 * update post menu order
	 */
	public static function updatePostOrder($postID,$order){
		$arrUpdate = array();
		$arrUpdate["ID"] = $postID;
		$arrUpdate["menu_order"] = $order;
		
		wp_update_post($arrUpdate);
	}
	
	
	/**
	 * 
	 * get url of post thumbnail
	 */
	public static function getUrlPostImage($postID,$size = self::THUMB_FULL){
		
		$post_thumbnail_id = get_post_thumbnail_id( $postID );
		if(empty($post_thumbnail_id))
			return("");
		
		$arrImage = wp_get_attachment_image_src($post_thumbnail_id,$size);
		if(empty($arrImage))
			return("");
		
		$urlImage = $arrImage[0];
		return($urlImage);
	}
	
	/**
	 * 
	 * get post thumb id from post id
	 */
	public static function getPostThumbID($postID){
		$thumbID = get_post_thumbnail_id( $postID );
		return($thumbID);
	}
	
	
	/**
	 * 
	 * get attachment image array by id and size
	 */
	public static function getAttachmentImage($thumbID,$size = self::THUMB_FULL){
		
		$arrImage = wp_get_attachment_image_src($thumbID,$size);
		if(empty($arrImage))
			return(false);
		
		$output = array();
		$output["url"] = RevSliderFunctions::getVal($arrImage, 0);
		$output["width"] = RevSliderFunctions::getVal($arrImage, 1);
		$output["height"] = RevSliderFunctions::getVal($arrImage, 2);
		
		return($output);
	}
	
	
	/**
	 * 
	 * get attachment image url
	 */
	public static function getUrlAttachmentImage($thumbID,$size = self::THUMB_FULL){
		$arrImage = wp_get_attachment_image_src($thumbID,$size);
		
		if(empty($arrImage))
			return(false);
		
		$url = RevSliderFunctions::getVal($arrImage, 0);
		return($url);
	}
	
	
	/**
	 * 
	 * get link of edit slides by category id
	 */
	public static function getUrlSlidesEditByCatID($catID){
		
		$url = self::$urlAdmin;
		$url .= "edit.php?s&post_status=all&post_type=post&action=-1&m=0&cat=".$catID."&paged=1&mode=list&action2=-1";
		
		return($url);
	}
	
	/**
	 * 
	 * get edit post url
	 */
	public static function getUrlEditPost($postID){
		$url = self::$urlAdmin;
		$url .= "post.php?post=".$postID."&action=edit";
		
		return($url);
	}
	
	
	/**
	 * 
	 * get new post url
	 */
	public static function getUrlNewPost(){
		$url = self::$urlAdmin;
		$url .= "post-new.php";
		return($url);
	}
	
	
	/**
	 * 
	 * delete post
	 */
	public static function deletePost($postID){
		$success = wp_delete_post($postID,false);
		if($success == false)
			RevSliderFunctions::throwError("Could not delete post: $postID");
	}
	
	/**
	 * 
	 * update post thumbnail
	 */
	public static function updatePostThumbnail($postID,$thumbID){
		set_post_thumbnail($postID, $thumbID);
	}
	
	
	/**
	 * 
	 * get intro from content
	 */
	public static function getIntroFromContent($text){
		$intro = "";
		if(!empty($text)){
			$arrExtended = get_extended($text);
			$intro = RevSliderFunctions::getVal($arrExtended, "main");
			
			/*
			if(strlen($text) != strlen($intro))
				$intro .= "...";
			*/
		}
		
		return($intro);
	}

	
	/**
	 * 
	 * get excerpt from post id
	 */
	public static function getExcerptById($postID, $limit=55){
		
		 $post = get_post($postID);	
		 
		 $excerpt = $post->post_excerpt;
		 $excerpt = trim($excerpt);
		 
		 $excerpt = trim($excerpt);
		 if(empty($excerpt))
			$excerpt = $post->post_content;			 
		 
		 $excerpt = strip_tags($excerpt,"<b><br><br/><i><strong><small>");
		 
		 $excerpt = RevSliderFunctions::getTextIntro($excerpt, $limit);
		 
		 return $excerpt;
	}		
	
	
	/**
	 * 
	 * get user display name from user id
	 */
	public static function getUserDisplayName($userID){
		
		$displayName =  get_the_author_meta('display_name', $userID);
		
		return($displayName);
	}
	
	
	/**
	 * 
	 * get categories by id's
	 */
	public static function getCategoriesByIDs($arrIDs,$strTax = null){			
		
		if(empty($arrIDs))
			return(array());
			
		if(is_string($arrIDs))
			$strIDs = $arrIDs;
		else
			$strIDs = implode(",", $arrIDs);
		
		$args = array();
		$args["include"] = $strIDs;
		
		if(!empty($strTax)){
			if(is_string($strTax))
				$strTax = explode(",",$strTax);
			
			$args["taxonomy"] = $strTax;
		}
		
		$arrCats = get_categories( $args );
		
		if(!empty($arrCats))
			$arrCats = RevSliderFunctions::convertStdClassToArray($arrCats);			
		
		return($arrCats);
	}
	
	
	/**
	 * 
	 * get categories short 
	 */
	public static function getCategoriesByIDsShort($arrIDs,$strTax = null){
		$arrCats = self::getCategoriesByIDs($arrIDs,$strTax);
		$arrNew = array();
		foreach($arrCats as $cat){
			$catID = $cat["term_id"];
			$catName = $cat["name"];
			$arrNew[$catID] =  $catName;
		}
		
		return($arrNew);
	}
	
	
	/**
	 * get categories list, copy the code from default wp functions
	 */
	public static function getCategoriesHtmlList($catIDs,$strTax = null){
		global $wp_rewrite;
		
		//$catList = get_the_category_list( ",", "", $postID );
		
		$categories = self::getCategoriesByIDs($catIDs,$strTax);
		
		$arrErrors = RevSliderFunctions::getVal($categories, "errors");
		
		if(!empty($arrErrors)){
			foreach($arrErrors as $key=>$arr){
				$strErrors = implode($arr,",");				
			}
			
			RevSliderFunctions::throwError("getCategoriesHtmlList error: ".$strErrors);
		}
		
		$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';
		
		$separator = ',';
		
		$thelist = '';
					
		$i = 0;
		foreach ( $categories as $category ) {

			if(is_object($category))
				$category = (array)$category;
			
			if ( 0 < $i )
				$thelist .= $separator;
				
			$catID = $category["term_id"];
			$link = get_category_link($catID);
			$catName = $category["name"];
			
			if(!empty($link))
				$thelist .= '<a href="' . esc_url( $link ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'revslider'), $category["name"] ) ) . '" ' . $rel . '>' . $catName.'</a>';
			else
				$thelist .= $catName;
			
			++$i;
		}
		
		
		return $thelist;
	}
	
	
	/**
	 * 
	 * get post tags html list
	 */
	public static function getTagsHtmlList($postID){
		$tagList = get_the_tag_list("",",","",$postID);
		return($tagList);
	}
	
	/**
	 * 
	 * convert date to the date format that the user chose.
	 */
	public static function convertPostDate($date, $with_time = false){
		if(empty($date))
			return($date);
		if($with_time){
			$date = date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($date));
		}else{
			$date = date_i18n(get_option('date_format'), strtotime($date));
		}
			
		return($date);
	}
	
	/**
	 * 
	 * get assoc list of the taxonomies
	 */
	public static function getTaxonomiesAssoc(){
		$arr = get_taxonomies();
		unset($arr["post_tag"]);
		unset($arr["nav_menu"]);
		unset($arr["link_category"]);
		unset($arr["post_format"]);
		
		return($arr);
	}
	
	
	/**
	 * 
	 * get post types array with taxomonies
	 */
	public static function getPostTypesWithTaxomonies(){
		$arrPostTypes = self::getPostTypesAssoc();
		
		foreach($arrPostTypes as $postType=>$title){
			$arrTaxomonies = self::getPostTypeTaxomonies($postType);
			$arrPostTypes[$postType] = $arrTaxomonies;
		}
		
		return($arrPostTypes);
	}
	
	
	/**
	 * 
	 * get array of post types with categories (the taxonomies is between).
	 * get only those taxomonies that have some categories in it.
	 */
	public static function getPostTypesWithCats(){
		$arrPostTypes = self::getPostTypesWithTaxomonies();
		
		$arrPostTypesOutput = array();
		foreach($arrPostTypes as $name=>$arrTax){

			$arrTaxOutput = array();
			foreach($arrTax as $taxName=>$taxTitle){
				$cats = self::getCategoriesAssoc($taxName);
				if(!empty($cats))
					$arrTaxOutput[] = array(
							 "name"=>$taxName,
							 "title"=>$taxTitle,
							 "cats"=>$cats);
			}
			
			$arrPostTypesOutput[$name] = $arrTaxOutput;
			
		}
		
		return($arrPostTypesOutput);
	}
	
	
	/**
	 * 
	 * get array of all taxonomies with categories.
	 */
	public static function getTaxonomiesWithCats(){
		
		$arrTax = self::getTaxonomiesAssoc();
		$arrTaxNew = array();
		foreach($arrTax as $key=>$value){
			$arrItem = array();
			$arrItem["name"] = $key;
			$arrItem["title"] = $value;
			$arrItem["cats"] = self::getCategoriesAssoc($key);
			$arrTaxNew[$key] = $arrItem;
		}
		
		return($arrTaxNew);
	}

	
	/**
	 * 
	 * get content url
	 */
	public static function getUrlContent(){
	
		if(self::isMultisite() == false){	//without multisite
			$baseUrl = content_url()."/";
		}
		else{	//for multisite
			$arrUploadData = wp_upload_dir();
			$baseUrl = $arrUploadData["baseurl"]."/";
		}
		
		if(is_ssl()){
			$baseUrl = str_replace("http://", "https://", $baseUrl);
		}
		
		return($baseUrl);
	}

	/**
	 * 
	 * get wp-content path
	 */
	public static function getPathContent(){		
		if(self::isMultisite()){
			if(!defined("BLOGUPLOADDIR")){
				$pathBase = self::getPathBase();
				$pathContent = $pathBase."wp-content/";
			}else
			  $pathContent = BLOGUPLOADDIR;
		}else{
			$pathContent = WP_CONTENT_DIR;
			if(!empty($pathContent)){
				$pathContent .= "/";
			}
			else{
				$pathBase = self::getPathBase();
				$pathContent = $pathBase."wp-content/";
			}
		}
		
		return($pathContent);
	}

	/**
	 * 
	 * get cats and taxanomies data from the category id's
	 */
	public static function getCatAndTaxData($catIDs){
		
		if(is_string($catIDs)){
			$catIDs = trim($catIDs);
			if(empty($catIDs))
				return(array("tax"=>"","cats"=>""));
			
			$catIDs = explode(",", $catIDs);
		}
		
		$strCats = "";
		$arrTax = array();
		foreach($catIDs as $cat){
			if(strpos($cat,"option_disabled") === 0)
				continue;
			
			$pos = strrpos($cat,"_");
			if($pos === false)
				RevSliderFunctions::throwError("The category is in wrong format");
			
			$taxName = substr($cat,0,$pos);
			$catID = substr($cat,$pos+1,strlen($cat)-$pos-1);
			
			$arrTax[$taxName] = $taxName;
			if(!empty($strCats))
				$strCats .= ",";
				
			$strCats .= $catID;				
		}
		
		$strTax = "";
		foreach($arrTax as $taxName){
			if(!empty($strTax))
				$strTax .= ",";
				
			$strTax .= $taxName;
		} 
		
		$output = array("tax"=>$strTax,"cats"=>$strCats);
		
		return($output);
	}
	
	
	/**
	 * 
	 * get current language code
	 */
	public static function getCurrentLangCode(){
		$langTag = ICL_LANGUAGE_CODE;

		return($langTag);
	}

	
	/**
	 * 
	 * check the current post for the existence of a short code
	 */  
	public static function hasShortcode($shortcode = '') {  
	
		if(!is_singular())
			return false;
			
		$post = get_post(get_the_ID());  
		  
		$found = false; 
		
		if (empty($shortcode))   
			return $found;
			
			
		if (stripos($post->post_content, '[' . $shortcode) !== false )    
			$found = true;  
		   
		return $found;  
	}  		
	
	
	/**
	 * Check if shortcodes exists in the content
	 * @since: 5.0
	 */  
	public static function check_for_shortcodes($mid_content){
		if($mid_content !== null){ 
			if(has_shortcode($mid_content, 'gallery')){
				
				preg_match('/\[gallery.*ids=.(.*).\]/', $mid_content, $img_ids);
				
				if(isset($img_ids[1])){
					if($img_ids[1] !== '') return explode(',', $img_ids[1]);
				}
			}
		}
		return false;
	}
	
	
	/**
	 * retrieve the image id from the given image url
	 * @since: 5.0
	 */
	public static function get_image_id_by_url($image_url) {
		global $wpdb;
		
		$attachment_id = 0;
		
		if(function_exists('attachment_url_to_postid')){
			$attachment_id = attachment_url_to_postid($image_url); //0 if failed
		}
		if ( 0 == $attachment_id ){ //try to get it old school way
			//for WP < 4.0.0
			$attachment_id = false;

			// If there is no url, return.
			if ( '' == $image_url )
				return;

			// Get the upload directory paths
			$upload_dir_paths = wp_upload_dir();

			// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
			if ( false !== strpos( $image_url, $upload_dir_paths['baseurl'] ) ) {

				// If this is the URL of an auto-generated thumbnail, get the URL of the original image
				$image_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_url );

				// Remove the upload path base directory from the attachment URL
				$image_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $image_url );

				// Finally, run a custom database query to get the attachment ID from the modified attachment URL
				$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $image_url ) );

			}
		}
		
		return $attachment_id;
	}
	
	
	public static function update_option($handle, $value, $autoload = 'on'){ //on is on, false is 'off'
		
		if(!add_option($handle, $value, '', $autoload)){ //returns false if option is not existing
			delete_option($handle);
		}
		
		add_option($handle, $value, '', $autoload);
	}
	
}	//end of the class

//init the static vars
RevSliderFunctionsWP::initStaticVars();

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteFunctionsWPRev extends RevSliderFunctionsWP {}
?>