<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2016 ThemePunch
 */
 
 
if( !defined( 'ABSPATH') ) exit();

class RevSliderObjectLibrary {
	
	private $library_url		= 'http://library.themepunch.tools/';
	private $library_list		= 'library.php';
	private $library_download	= 'download.php';
	
	private $object_thumb_path	= '/revslider/objects/thumbs/';
	private $object_orig_path	= '/revslider/objects/';
	
	private $curl_check	= null;
	
	const LIBRARY_VERSION		= '1.0.0';
	
	
	/**
	 * get list of objects
	 * @since: 5.3.0
	 */
	public function _get_list($force = false){
		global $wp_version;
		
		$last_check = get_option('revslider-library-check');
		
		if($last_check == false){ //first time called
			$last_check = 1296001;
			update_option('revslider-library-check',  time());
		}
		
		// Get latest object list
		if(time() - $last_check > 1296000 || $force == true){ //30 days
			
			update_option('revslider-library-check',  time());
			
			$code = get_option('revslider-code', '');
			$library_version = self::LIBRARY_VERSION;
			
			$validated = get_option('revslider-valid', 'false');
			if($validated == 'false'){
				$code = '';
			}
			
			$rattr = array(
				'code' => urlencode($code),
				'library_version' => urlencode($library_version),
				'version' => urlencode(RevSliderGlobals::SLIDER_REVISION),
				'product' => urlencode('revslider')
			);
			$request = wp_remote_post($this->library_url.$this->library_list, array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body' => $rattr
			));
			
			if(!is_wp_error($request)) {
				if($response = maybe_unserialize($request['body'])) {
					
					$library = json_decode($response, true);
					
					if(is_array($library)) {
						update_option('rs-library', $library, false);
					}
				}
			}
		}
	}
	
	
	public function _get_object_data($object_handle){
		$data = array('thumb' => $object_handle, 'orig' => $object_handle);
		
		$upload_dir = wp_upload_dir(); // Set upload folder
		$file = $upload_dir['basedir'] . $this->object_thumb_path . $object_handle;
		if(file_exists($file)){
			$url_file = $upload_dir['baseurl'] . $this->object_thumb_path . $object_handle;
			$data['thumb'] = $url_file;
		}
		
		$file = $upload_dir['basedir'] . $this->object_orig_path . $object_handle;
		if(file_exists($file)){
			$url_file = $upload_dir['baseurl'] . $this->object_orig_path . $object_handle;
			$data['orig'] = $url_file;
			//check 
		}
		
		return $data;
	}
	
	
	/**
	 * check if given URL is an object from object library
	 * @since: 5.3.0
	 */
	public function _is_object($url){
		$is_object = false;
		
		$upload_dir				  = wp_upload_dir(); // Set upload folder
		//$upload_directory         = $upload_dir['basedir'] . $this->object_orig_path;
		$upload_url         	  = $upload_dir['baseurl'] . $this->object_orig_path;
		$file_name = explode('/', $url);
		$file_name = $file_name[count($file_name) - 1];
		
		if(strpos($url, $upload_url) !== false){
			//check now if handle is inside of the array of objects
			$obj = $this->load_objects();
			$online = $obj['online']['objects'];
			
			foreach($online as $object){
				if($object['handle'] == $file_name){
					$is_object = true;
					break;
				}
			}
		}
		
		return $is_object;
	}
	
	
	/**
	 * check if given URL is existing in the object library
	 * @since: 5.3.0
	 */
	public function _does_exist($url){
		$does_exist = false;
		
		$upload_dir				  = wp_upload_dir(); // Set upload folder
		$upload_directory         = $upload_dir['basedir'] . $this->object_orig_path;
		$upload_url         	  = $upload_dir['baseurl'] . $this->object_orig_path;
		
		$url = str_replace($upload_url, '', $url);
		
		if(file_exists($upload_directory.$url)){
			$does_exist = true;
		}
		
		return $does_exist;
	}
	
	
	/**
	 * check if certain object needs to be redownloaded
	 * @since: 5.3.0
	 */
	public function _check_object_exist($object_url){
		
		//first check if it is an object
		$is_obj = $this->_is_object($object_url);
		
		//then check if it is existing
		if($is_obj){
			if($this->_does_exist($object_url)){
				//all cool
			}else{ //if not, redownload if allowed
				//need to redownload
				
				$file_name_with_ending    = explode("/", $object_url);
				$file_name_with_ending    = $file_name_with_ending[count($file_name_with_ending) - 1];
				$this->_get_object_thumb($file_name_with_ending, 'orig');
			}
		}
	}
	
	
	/**
	 * get certain objects thumbnail, download if needed and if not, simply return path
	 * @since: 5.3.0
	 */
	public function _get_object_thumb($object_handle, $type){
		global $wp_version;
		
		$error = '';
		
		if($type == 'thumb'){
			$path = $this->object_thumb_path;
		}else{
			$path = $this->object_orig_path;
		}
		$download = false;
		
		$upload_dir = wp_upload_dir(); // Set upload folder
		$file = $upload_dir['basedir'] . $path . $object_handle;
		$url_file = $upload_dir['baseurl'] . $path . $object_handle;
	
		//check if object thumb is already downloaded
		$download = (!file_exists($file)) ? true : false;
		
		//check if new version of object thumb is available
		
		// Check folder permission and define file location
		if($download && wp_mkdir_p( $upload_dir['basedir'].$path ) ) {
			
			$curl = ($this->check_curl_connection()) ? new WP_Http_Curl() : false;
			
			$file = $upload_dir['basedir'] . $path . $object_handle;
			
			if(!file_exists($file) || isset($temp['push_image'])){
				$image_data = false;
				if($curl !== false){
					$validated = get_option('revslider-valid', 'false');
					
					if($validated == 'false' && $type != 'thumb'){
						$error = __('Plugin not activated', 'revslider');
					}else{
						$code = ($validated == 'false') ? '' : get_option('revslider-code', '');
						
						$image_data = wp_remote_post($this->library_url.$this->library_download, array(
							'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
							'body' => array(
								'code' => urlencode($code),
								'library_version' => urlencode(self::LIBRARY_VERSION),
								'version' => urlencode(RevSliderGlobals::SLIDER_REVISION),
								'handle' => urlencode($object_handle),
								'download' => urlencode($type),
								'product' => urlencode('revslider')
							),
							'timeout' => 45 
						));
						
						if(!is_wp_error($image_data) && isset($image_data['body']) && isset($image_data['response']) && isset($image_data['response']['code']) && $image_data['response']['code'] == '200'){
							$image_data = $image_data['body'];
							//check body for errors in here
							$check = json_decode($image_data, true);
							if(!empty($check)){
								if(isset($check['error'])){
									$image_data = false;
									$error = $check['error'];
								}
							}elseif(trim($image_data) == ''){
								$error = __('No data received', 'revslider');
							}
						}else{
							$image_data = false;
							$error = __('Error downloading object', 'revslider');
						}
					}
				}else{
					//cant download file
				}
				if($image_data !== false){
					@mkdir(dirname($file));
					@file_put_contents( $file, $image_data );
					
					$this->create_image_dimensions($object_handle);
					
				}else{//could not connect to server
					$error = __('Error downloading object', 'revslider');
				}
			}else{//use default image
				$error = __('Error downloading object', 'revslider');
			}
		}else{//use default images
			$error = __('Error downloading object', 'revslider');
		}
		
		if($error !== ''){
			return array('error' => true);
		}
		
		$width = false;
		$height = false;
		//get dimensions of image
		$imgsize = getimagesize( $file );
		if($imgsize !== false){
			$width = $imgsize['0'];
			$height = $imgsize['1'];
		}
		
		return array('error' => false, 'url' => $url_file, 'width' => $width, 'height' => $height);
		
	}
	
	
	/**
	 * import object to media library
	 * @since: 5.3.0
	 */
	public function _import_object($file_path){
		$curl = ($this->check_curl_connection()) ? new WP_Http_Curl() : false;
		
		$upload_dir = wp_upload_dir(); // Set upload folder
		$path = $this->object_orig_path;
		$object_handle = basename($file_path);
		$file = $upload_dir['basedir'] . $path . $object_handle;
		$url_file = $upload_dir['baseurl'] . $path . $object_handle;
		
		$image_handle = @fopen($file_path, "r");
		
		if($image_handle != false){
			$image_data = stream_get_contents($image_handle);
			if($image_data !== false){
				@mkdir(dirname($file));
				@file_put_contents( $file, $image_data );
				
				$this->create_image_dimensions($object_handle);
				
				return array('path' => $url_file);
			}
		}
		
		return false;
	}
	
	
	public function write_markup(){
		?>
		<!-- THE OBJECT LIBRARY DIALOG WINDOW -->
		<div id="dialog_addobj" class="dialog-addobj" title="<?php _e("Add Object Layer",'revslider'); ?>" style="display:none">
			<div class="addobj-dialog-inner">
				<div id="addobj-list-of-items">
					<div id="addobj-dialog-header">
						<div class="object_library_search_wrapper">
							<input type="text" id="obj_library_search" placeholder="<?php _e("Search for Objects...",'revslider'); ?>" /><span id="obj_library_search_trigger"><i class="eg-icon-search"></i></span>
						</div>												
						<div id="object_library_type_list_new">
							<span id="obj_lib_main_cat_filt_all" data-value="all" class="obj_library_cats_filter"><?php _e("ALL",'revslider'); ?></span>
							<span id="obj_lib_main_cat_filt_allimages" data-value="allimages" class="obj_library_cats_filter all_img_cat"><?php _e("ALL IMAGES",'revslider'); ?></span>
							<span id="obj_lib_main_cat_filt_svg" data-value="svg" class="obj_library_cats_filter svg_cat"><?php _e("SVG",'revslider'); ?></span>
							<span id="obj_lib_main_cat_filt_icon" data-value="icon" class="obj_library_cats_filter fonticon_cat"><?php _e("ICON",'revslider'); ?></span>							
							<span id="obj_lib_main_cat_filt_image" data-value="image" class="obj_library_cats_filter png_cat"><?php _e("PNG",'revslider'); ?></span>
							<span id="obj_lib_main_cat_filt_bgimage" data-value="bgimage" class="obj_library_cats_filter jpg_cat"><?php _e("JPG",'revslider'); ?></span>
						</div>			
						<div id="up-lic-ob-lib">																
							<div id="licence_obect_library"><i class="fa-icon-copyright"></i><?php _e("License Info",'revslider'); ?></div>
							<div id="update_obect_library"><i class="eg-icon-arrows-ccw"></i><?php _e("Update Object Library",'revslider'); ?></div>
						</div>
						<div id="object-tag-list" class="object-tag-list"><span id="obj_library_cats_favorite" class="obj_library_cats" data-tag="favorite" data-image="true" data-bgimages="true" data-svg="true"><i class="fa-icon-star-o" style="margin-right: 5px;"></i><?php _e("Favorite",'revslider'); ?></span><span id="obj_library_cats_allico" class="obj_library_cats" data-tag="allicon" data-icon="true" data-bgimages="false" data-svg="false"><i class="fa-icon-folder-o" style="margin-right: 5px;"></i><?php _e("All Icons",'revslider'); ?></span><span id="obj_library_cats_allpng" class="obj_library_cats" data-tag="allpng" data-image="true" data-bgimages="false" data-svg="false"><i class="fa-icon-folder-o" style="margin-right: 5px;"></i><?php _e("All PNG",'revslider'); ?></span><span id="obj_library_cats_alljpg" class="obj_library_cats" data-tag="alljpg" data-image="false" data-bgimages="true" data-svg="false"><i class="fa-icon-folder-o" style="margin-right: 5px;"></i><?php _e("All JPG",'revslider'); ?></span><span id="obj_library_cats_allsvg" class="obj_library_cats" data-tag="allsvg" data-image="false" data-bgimages="false" data-svg="true"><i class="fa-icon-folder-o" style="margin-right: 5px;"></i><?php _e("All SVG",'revslider'); ?></span></div>
					</div>
					<div id="object_library_results">
						<div id="object_library_results-inner">
						</div>
					</div>
				</div>
			</div>
			<div id="bg-vs-layer-wrapper">
				<span id="add_objimage_as_layer"><?php _e("As Layer",'revslider'); ?></span><span class="addthisasbg" id="obj-layer-bg-switcher"></span><span id="add_objimage_as_slidebg"><?php _e("As Slide BG",'revslider'); ?></span>
			</div>
			
			<?php
			$this->write_scripts();
			?>
		</div>
		<?php
	}
	

	
	
	public function write_scripts(){
		?>
		<script>
			var obj_libraries = [];

			jQuery('body').on('click','.object_library_itemfavorit',function() {
				var t = jQuery(this),
					item = t.parent(),
					d = item.data(),
					ic = t.find('i');

				if (ic.hasClass("fa-icon-star")) {
					ic.addClass("fa-icon-star-o");
					ic.removeClass("fa-icon-star");
					var newtags = item.data('tags');					
					item.data('tags', newtags.replace(',favorite',''));
					favoriteObjectsList = jQuery.grep(favoriteObjectsList,function(value) { return value != d.src});

				} else {
					ic.removeClass("fa-icon-star-o");
					ic.addClass("fa-icon-star");
					var newtags = item.data('tags')+",favorite";					
					item.data('tags', newtags);
					favoriteObjectsList.push(d.src);
				}				
				
				return false;

			});
			
			// HOVER OVER SINGLE IMAGES
			jQuery('body').on('mouseenter','.obj_lib_container_img',function() {
				var _t = jQuery(this),
					typ = _t.data('type');				
				if (typ==="2" || typ===2)
					jQuery('#bg-vs-layer-wrapper').appendTo(_t.find('.obj-item-size-selectors'));

			});

			// LOAD OBJECTS ON DEMAND WHEN THEY BECOME VISIBLE
			function loadObjNow(d) {
				d.data('loaded',true);

				var src = d.data('src'),
					ty = d.data('type');										
				if (ty==="svg") {

					jQuery.get(src, function(data) {
						  var div = document.createElement("div");						  
						  div.innerHTML = new XMLSerializer().serializeToString(data.documentElement);
						  d.find('.obj_item_media_holder').append(div);
						  jQuery('#object_library_results').perfectScrollbar("update");
					});
				} else
				if (ty==="img" || ty==="1" || ty==="2" || ty===1 || ty===2) {
					if (src.indexOf("/") === -1) {
						getObjectUrl(src,d,'thumb');
					} else {
						d.find('.obj_item_media_holder').append('<div class="rs-obj-img-mediainner" style="background-image:url('+src+');"></div>');
						//jQuery('#object_library_results').perfectScrollbar("update");
					}					
				} else 
				if (ty==="icon") {					
					 d.find('.obj_item_media_holder').append('<i class="'+src+'"></i>');
				}
				
			}

			function ol_itemVisible(o,st) {
				var t = o.position().top,
					ch = jQuery('#object_library_results').height();
				if (t-st>-170 && t-st<ch && !o.data('loaded')) 
					loadObjNow(o);
			}

			function ol_checkVisibilityOfItems() {
				var c = jQuery('#object_library_results-inner'),
					st = c.scrollTop();
					
				if (jQuery('#dialog_addobj').parent().css("display")==="block") {
					jQuery('#object_library_results-inner .obj_library_item').each(function() {
						var o = jQuery(this);
						if (o.hasClass("showit")) 
							ol_itemVisible(o,st);
						
					});
				}
			}

			function createFontIcons() {

				jQuery('#waitaminute .waitaminute-message').append('<br>Loading Font Icons');
				var sheets = document.styleSheets,
					obj = new Object(),
					fi = 1;
				obj.handle = "FontIcons-"+fi;
				obj.list = new Array();

				if (sheets)
					jQuery.each(sheets,function(index,sheet) {
						var found = false,
							markup = "";	
						if (sheet && sheet.href && sheet.href.indexOf("plugins/revslider/public/assets/fonts/")>=0) {							
							try{
								if (sheet.cssRules !==null & sheet.cssRules!=undefined)									
									jQuery.each(sheet.cssRules, function(index,rule) {									
										if (rule && rule!==null && rule !=="null" && rule.selectorText!=undefined) {
											jQuery.each(rs_icon_sets,function(j,prefix){
												if (rule.selectorText.split(prefix).length>1 && rule.cssText.split("content").length>1) {																							
													var csname = rule.selectorText.split("::before")[0].split(":before")[0];												
													if (csname!=undefined)  {
														csname = csname.split(".")[1];	
														
														if (csname!=undefined) {
															found = true;
															var iconobj = new Object();
															iconobj.name = csname;
															iconobj.group = "icon";
															iconobj.tags="fonticon"+fi+","+csname.replace(/\-/g,",");
															iconobj.type="icon";
															iconobj.src=csname;
															obj.list.push(iconobj);
														}													
													}
												}							
											})
										}
									});
							} catch(e) {
								
							}						
							if (found) {
								found = false;
								if (obj.list.length>0) obj_libraries.push(obj);
								obj = new Object();
								jQuery('#object-tag-list').append('<span id="obj_library_cats_fonticon_'+fi+'" class="obj_library_cats" data-tag="fonticon'+fi+'" data-icon="true">Font Icons '+fi+'</span>')
								fi++;
								obj.handle="FontIcons"+fi;
								obj.list=new Array(); 
							}
						}
					});
					
				
			}

			// ADD THE ITEMS TO THE MAIN CONTAINER (ONLY EMPTY PLACEHOLDERS FIRST)		
			function push_objects_to_library(){
				var c = jQuery('#object_library_results-inner'),
					svgi = 0,
					pngi = 0,
					jpgi = 0,
					iconi = 0,
					taggroups = {},
					counter = 0;

				if (favoriteObjectsList !==undefined && favoriteObjectsList.length>0) {
					svgi=5;
					pngi=5;
					jpgi=5;
					iconi=5;
				} else {
					favoriteObjectsList = new Array();
				}
				
				createFontIcons();				
				//console.time("Create Markups");
				for (var i=0;i<obj_libraries.length;i++) {
					var library = obj_libraries[i];
					//console.time("Library Handle:"+library.handle);					
					for (var j=0;j<library.list.length;j++) {					
						var item = library.list[j],
							ref = 'obj-item-'+library.handle+'-'+i,
							titl = item.name!==undefined ? item.name : item.src,
							short = "SVG",
							color = "purple",
							classext = "",
							tt = '',
							favclass = "fa-icon-star-o";
							
							sizes = item.type==="svg" ? "" : '<div class="obj-item-size-selectors"><div class="sizetooltip"></div><div data-s="xs" class="obj-item-size-selector nfbg">XS</div><div data-s="s" class="obj-item-size-selector nfbg">S</div><div data-s="m" class="obj-item-size-selector">M</div><div data-s="l" class="obj-item-size-selector">L</div><div data-s="o" class="obj-item-size-selector">O</div></div>';
						switch (item.type) {
							case "svg":
								short = "SVG";
								color = "purple";
								classext = "svg";
								item.tags = item.tags+",allsvg";
								if (svgi<3) {
									item.tags = item.tags+",favorite";
									favclass = "fa-icon-star";
									svgi++;
									favoriteObjectsList.push(item.src);
								}

							break;
							case 1:
							case "1":
								short = "PNG";
								color = "green";
								classext = "img";
								item.tags = item.tags+",allpng";
								if (pngi<3) {
									item.tags = item.tags+",favorite";
									favclass = "fa-icon-star";
									pngi++;
									favoriteObjectsList.push(item.src);
								}
							break;
							case 2:
							case "2":
								short = "JPG";
								color = "blue";
								classext = "img";
								item.tags = item.tags+",alljpg";
								if (jpgi<3) {
									item.tags = item.tags+",favorite";
									favclass = "fa-icon-star";
									jpgi++;
									favoriteObjectsList.push(item.src);
								}
							break;
							case "icon":
								short = "ICON";
								color = "red";
								classext = "icon";
								item.tags = item.tags+",allicon";
								if (iconi<3) {
									item.tags = item.tags+",favorite";
									favclass = "fa-icon-star";
									iconi++;
									favoriteObjectsList.push(item.src);
								}
							break;
						}
						
						if (favoriteObjectsList !==undefined && favoriteObjectsList.length>0 && jQuery.inArray(item.src,favoriteObjectsList)>=0){
							item.tags = item.tags+",favorite";
							favclass = "fa-icon-star";
						}

						tt = '<div class="obj_library_item_type_'+color+' ">'+short+'</div>';
						
						if (titl.indexOf("/") !== -1) {						
							titl = titl.split("/");
							titl = titl[titl.length-1].split(".")[0]; 												
						} else {
							titl =  titl.split(".")[0];
						}					
						
						titl = titl.replace(/\_/g," ");
						titl = titl.replace(/\-/g," ");
						item.title = titl.toLowerCase().split(" ");	
						item.tags_array = item.tags.toLowerCase().split(",");	
						item.idref = ref+"_"+counter;
						counter++;
						var el = '<div id="'+item.idref+'" data-title="'+titl+'" data-origsrc="'+item.origsrc+'" data-type="'+item.type+'" data-group="'+item.group+'" data-src="'+item.src+'" data-mediawidth="'+item.width+'" data-mediaheight="'+item.height+'" data-tags="'+item.tags+'" class="obj_lib_container_'+classext+' obj_library_item objadd-single-item "><div class="object_library_itemfavorit"><i class="'+favclass+'"></i></div><div  class="objadd-single-item_holder obj_item_media_holder"></div><div class="obj_lib_item_title">'+titl+'</div>'+tt+sizes+'</div>';
						c.append(el);						
						item.ref = el;

						var otags = item.tags.split(",");
						
						for (var k=0;k<otags.length;k++) {
							if (taggroups[item.group]===undefined) 
								taggroups[item.group] = new Object();
							taggroups[item.group][otags[k]] = true;																				
						}
						

					};
					//console.timeEnd("Library Handle:"+library.handle);
				};
				
				
				jQuery.each(taggroups, function(key,value) {
					jQuery.each(value,function(tag){
						jQuery('#obj_library_cats_'+tag).data(key,true);
					})
					
				});
				//console.timeEnd("Create Markups");
			}
			
			
			jQuery('body').on('mouseenter','.obj-item-size-selector',function() {
				var _t = jQuery(this),
					_i = _t.closest('.obj_library_item'),
					_ttip = _i.find('.sizetooltip'),
					size = 1;
				
				switch (_t.data('s')) {
					case "xs": size = 0.1;break;
					case "s": size = 0.25;break;
					case "m": size = 0.50;break;
					case "l": size = 0.75;break;
					case "o": size = 1;break;
				};

				_ttip.html(Math.round(_i.data('mediawidth')*size)+' x '+Math.round(_i.data('mediaheight')*size))
			});
			jQuery('body').on('mouseleave','.obj-item-size-selector',function() {				
				var _t = jQuery(this),
					_i = _t.closest('.obj_library_item'),
					_ttip = _i.find('.sizetooltip');
				_ttip.html("");
			});

			jQuery('#add_objimage_as_layer').click(function() {
				jQuery('#obj-layer-bg-switcher').removeClass("addthisasbg");
			});

			jQuery('#add_objimage_as_slidebg').click(function() {
				jQuery('#obj-layer-bg-switcher').addClass("addthisasbg");
			});

			jQuery('#obj-layer-bg-switcher').click(function() {
				var _t = jQuery(this);
				if (_t.hasClass("addthisasbg"))		
					_t.removeClass("addthisasbg");	
				else
					_t.addClass("addthisasbg");
			});

			
			ol_checkVisibilityOfItems();

			// TAKE CARE ABOUT SCROLL OF THE LIBRARY CONTAINER
			jQuery('#object_library_results').perfectScrollbar({wheelPropagation:false,suppressScrollX:true});
			jQuery('#object_library_results').perfectScrollbar("update");
			document.addEventListener('ps-scroll-y', function (e) {
				if (jQuery(e.target).closest('#object_library_results').length>0) {
					ol_checkVisibilityOfItems();
				}
			});


			// CHANGING THE TAGS SHOULD CHANGE THE LIST OF ITEMS
			jQuery('body').on('click','.obj_library_cats',function() {
				jQuery('.obj_library_cats').removeClass("selected");
				jQuery('#obj_library_cats_searchresult').remove();
				jQuery(this).addClass("selected");
				jQuery('#obj_library_search').val("");
				searchForCatsAndGroups();
			});

			jQuery('body').on('click','.obj_library_cats_filter',function() {

				var op = jQuery(this),
					gr = op.data('value'),
					fv = 0,
					sv = 0;
				jQuery('.obj_library_cats_filter').removeClass("selected");
				op.addClass("selected");

				jQuery('.obj_library_cats').each(function() {
					var _t = jQuery(this);
					
					
					if (_t.data(gr) || gr==="all" || (gr==="allimages" && (_t.data("image") || _t.data("bgimage")))) {
						_t.show();
						if (fv===0)
							fv=_t;
						else
						if (sv===0)
							sv=_t;
					}
					else
						_t.hide();
				});		
				if (gr==="all") {
					jQuery('#obj_library_cats_allico').hide();
					jQuery('#obj_library_cats_allpng').hide();
					jQuery('#obj_library_cats_alljpg').hide();
					jQuery('#obj_library_cats_allsvg').hide();
				}		
				searchForCatsAndGroups();
				searchForObjects();				
				if (jQuery('.obj_library_cats.selected').is(":visible")===false || (fv!==0 && jQuery('.obj_library_cats.selected').data('tag')==="favorite" && gr!=="all")) {
					jQuery('.obj_library_cats.selected').removeClass("selected");
					if(fv !== 0){						
						if (gr==="all")
							fv.click();
						if (gr!=="all" && sv !== 0)
							sv.click();
					}
				}
			});
			
			
			// SHOW ONLY ELEMENTS WITH SELECTED TAGS
			function searchForCatsAndGroups() {
				jQuery('#object_library_results').scrollTop(0);				
				jQuery('.obj_library_cats.selected').each(function() {
					var searched_lib = jQuery(this).data('tag'),
						group = jQuery('.obj_library_cats_filter.selected').data('value');

					jQuery('.obj_library_item').each(function() {						
						var o = jQuery(this),
							otags = o.data('tags').split(","),
							gr = o.data('group'),
							ty = o.data('type'),
							afo = false;
						if (group==="all" || group===gr || (group=="allimages" && (ty===2 || ty===1))) {
							for (var ti =0;ti<otags.length;ti++) {										
								if (otags[ti]===searched_lib || afo || searched_lib==="all") {
									o.addClass("showit");
									afo=true;
								}
								else {
									o.removeClass("showit");
								}
							}												
						} else {
							o.removeClass("showit");
						}
					});
				});
				ol_checkVisibilityOfItems();
			}

			// SEARCH FOR OBJECTS
			function searchForObjects() {
				jQuery('#object_library_results').scrollTop(0);
				jQuery('#obj_library_cats_searchresult').remove();
				var searchfor = jQuery('#obj_library_search').val(),
					res = 0,
					group = jQuery('.obj_library_cats_filter.selected').data('value');
				if (searchfor.length<3) return;
				searchfor = searchfor.replace(/\ /g,",");
				searchfor = searchfor.split(",");
				
				jQuery.each(obj_libraries, function(i,library) {
					jQuery.each(library.list,function(i,item) {
						var found = false;
							
						
						if (group==="all" || item.group === group) 
						jQuery.each(searchfor, function(i,sf){
							if (sf.length>2) {
								// CHECK TITLE
								if (jQuery.isArray(item.title)) {
									if (jQuery.inArray(sf.toLowerCase(),item.title)>=0) {
											jQuery('#'+item.idref).addClass("showit");
											res++;
											found = true;
											return true;
									} else {
										jQuery.each(item.title,function(i,tt){
											if (tt.indexOf(sf)>=0) {
												jQuery('#'+item.idref).addClass("showit");
												res++;
												found = true;
												return true;
											}		
										});
									}
								} else {
									if (sf.toLowerCase() === item.title) {
										jQuery('#'+item.idref).addClass("showit");
										res++;
										found = true;
										return true;
									}

								}

								//CHECK ITME TAGS
								if (jQuery.isArray(item.tags_array)) {
									if (jQuery.inArray(sf.toLowerCase(),item.tags_array)>=0) {
											jQuery('#'+item.idref).addClass("showit");
											res++;
											found = true;
											return true;
									} else {
										jQuery.each(item.tags_array,function(i,tt){
											if (tt.indexOf(sf)>=0) {
												jQuery('#'+item.idref).addClass("showit");
												res++;
												found = true;
												return true;
											}		
										});
									}
								} else {
									if (sf.toLowerCase() === item.tags_array) {
										jQuery('#'+item.idref).addClass("showit");
										res++;
										found = true;
										return true;
									}

								}

								item.tags_array
							}
						});
						
						if (!found) jQuery('#'+item.idref).removeClass("showit");
					});					
				});

				jQuery('.obj_library_cats').removeClass("selected");
				jQuery('.object-tag-list').prepend('<span class="obj_library_cats selected" id="obj_library_cats_searchresult">Found ('+res+') elements</span>');					
				ol_checkVisibilityOfItems();
			}

			var objl_keyuprefresh;
			jQuery("#obj_library_search").keyup(function(){
				clearTimeout(objl_keyuprefresh);
				var v = jQuery(this).val();
				objl_keyuprefresh = setTimeout(function() {
					if (v.length>2)
						searchForObjects();
				},150);
			});
			jQuery('#obj_library_search_trigger').click(searchForObjects);

			
			function getObjectUrl(handle, el, type){
				UniteAdminRev.ajaxRequest('load_library_object', {'handle': handle, 'type': type}, function(response){
					if(response.success){
						el.find('.obj_item_media_holder').append('<div class="rs-obj-img-mediainner" style="background-image:url('+response.url+');"></div>');
						jQuery('#object_library_results').perfectScrollbar("update");
					} else {
						
					}
				});
			}
			
			jQuery('#update_obect_library').click(function(){
				if(confirm(rev_lang.unsaved_data_will_be_lost_proceed)){
					jQuery('#dialog_addobj').dialog("close");
					showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});					
					location.href = window.location.href+'&update_object_library';
				}
			});
			
			var favoriteObjectsList = [];
			<?php
			$obj_favs = $this->get_favorites();
			if(!empty($obj_favs)){
				foreach($obj_favs as $fav){
					?>favoriteObjectsList.push("<?php echo $fav; ?>");
			<?php
				}
			}
			?>
		</script>
		<?php
	}
	
	
	public function load_objects(){
		$obj = array();
		
		$svgs = RevSliderBase::get_svg_sets_full();
		
		$obj['svg'] = $svgs;
		
		$online = get_option('rs-library', array());
		if(!empty($online)){
			$obj['online'] = $online;
		}
		
		return $obj;
	}
	
	
	public function create_image_dimensions($handle, $force = false){
		$img_editor_test = wp_image_editor_supports(array('methods' => array('resize', 'save')));
		if($img_editor_test !== true){
			return false;
		}
		
		$upload_dir				  = wp_upload_dir(); // Set upload folder
		$upload_directory         = $upload_dir['basedir'] . $this->object_orig_path;
		$upload_url         	  = $upload_dir['baseurl'] . $this->object_orig_path;

		$image_path               = $upload_directory.$handle;

		$file_name_with_ending    = explode("/", $image_path);
		$file_name_with_ending    = $file_name_with_ending[count($file_name_with_ending) - 1];
		$file_name_without_ending = explode(".", $file_name_with_ending);
		$file_ending              = $file_name_without_ending[count($file_name_without_ending) - 1];
		$file_name_without_ending = $file_name_without_ending[count($file_name_without_ending) - 2];

		$sizes = array('75', '50', '25', '10');

		$image = wp_get_image_editor($image_path);
		$imgsize = getimagesize($image_path);
		
		if(!is_wp_error($image) && $imgsize !== false) {
			$orig_width = $imgsize['0'];
			$orig_height = $imgsize['1'];
			
			foreach($sizes as $size){
				$modified_file_name_without_ending = $file_name_without_ending . '-' . $size;
				if(!file_exists($upload_directory.$modified_file_name_without_ending.'.'.$file_ending) || $force) {
					
					$width = round($orig_width / 100 * $size, 0);
					$height = round($orig_height / 100 * $size, 0);
					
					$image->resize($width, $height);
					$image->save($upload_directory.$modified_file_name_without_ending.'.'.$file_ending);
				}
			}
		}else{ //cant create images
			return false;
		}
		
		return true;
	}
	
	/**
	 * Check if Curl can be used
	 */
	public function check_curl_connection(){
		
		if($this->curl_check !== null) return $this->curl_check;
		
		$curl = new WP_Http_Curl();
		
		$this->curl_check = $curl->test();
		
		return $this->curl_check;
	}
	
	
	/**
	 * Returns an URL if it is an object library image, depending on the choosen width/height or the chosen image size
	 */
	public function get_correct_size_url($image_path, $imgres, $library_size = array()){
		
		if(!is_array($imgres)){
			//wordpress full, medium ect
			//or check current device and change depending on device
			$img_sizes = get_intermediate_image_sizes();
			if(isset($img_sizes[$imgres]) && isset($img_sizes[$imgres]['width']) && isset($img_sizes[$imgres]['height'])){
				$imgres = array($img_sizes[$imgres]['width'], $img_sizes[$imgres]['height']);
			}
		}else{
			/**
			 * check if we have a % and if yes, turn the image back to what was selected in the beginning instead of how it was scaled
			 * as it is already an array, it can be the following:
			 * px
			 * %
			 * empty, then this means auto
			 * if %, then always get the image that was selected
			 **/
			if(isset($library_size['width']) && isset($library_size['height'])){
				foreach($imgres as $res){
					if(strpos($res, '%') !== false || $res == 'SET'){
						$imgres = array($library_size['width'], $library_size['height']);
						break;
					}
				}
			}
		}
		
		if(is_array($imgres)){
			//check if file exists
			if(!file_exists($image_path)) return $image_path;
			
			$upload_dir				  = wp_upload_dir(); // Set upload folder
			$upload_directory         = $upload_dir['basedir'] . $this->object_orig_path;
			$upload_url         	  = $upload_dir['baseurl'] . $this->object_orig_path;
			
			//we got width and high, lets check which one to use
			$file_name_with_ending    = explode("/", $image_path);
			$file_name_with_ending    = $file_name_with_ending[count($file_name_with_ending) - 1];
			$file_name_without_ending = explode(".", $file_name_with_ending);
			$file_ending              = $file_name_without_ending[count($file_name_without_ending) - 1];
			$file_name_without_ending = $file_name_without_ending[count($file_name_without_ending) - 2];
			
			$sizes = array('75', '50', '25', '10');
			$imgsize = getimagesize($image_path);
			
			if($imgsize !== false) {
				$orig_width = $imgsize['0'];
				$orig_height = $imgsize['1'];
				
				foreach($sizes as $size){
					$width = round($orig_width / 100 * $size, 0);
					$height = round($orig_height / 100 * $size, 0);
					
					if($width >= $imgres[0] && $height >= $imgres[1]){
						$modified_file_name_without_ending = $file_name_without_ending . '-' . $size;
						if(file_exists($upload_directory.$modified_file_name_without_ending.'.'.$file_ending)) {
							$image_path = $upload_url.$modified_file_name_without_ending.'.'.$file_ending;
						}
					}
				}
			}
		}
		
		return $image_path;
	}
	
	
	public function retrieve_all_object_data(){
		$obj = $this->load_objects();
		
		$data = array('html' => array(), 'list' => array());
		$svgs = $obj['svg'];
		if(!empty($svgs) && is_array($svgs)){
			foreach($svgs as $svghandle => $svgfiles){
				$data['html'][] = array('type' => 'tag', 'handle' => $svghandle, 'name' => $svghandle);
				$data['html'][] = array('type' => 'inner');
				
				$data['list'][$svghandle] = array();
				foreach($svgfiles as $svgfile => $svgpath){
					$data['list'][$svghandle][] = array(
						'src' => $svgpath,
						'origsrc' => '',
						'type' => 'svg',
						'group' => 'svg',
						'tags' => $svghandle,
					);
				}
			}
		}
		
		if(isset($obj['online']) && isset($obj['online']['objects'])){
			$online = $obj['online']['objects'];
			if(!empty($online) && is_array($online)){					
				if(isset($obj['online']['tags'])){
					foreach($obj['online']['tags'] as $t){
						$data['html'][] = array('type' => 'tag', 'handle' => $t['handle'], 'name' => $t['name']);
					}
				}
				$data['html'][] = array('type' => 'inner');
				
				$data['list']['png'] = array();				

				foreach($online as $online_file){
					$my_data = $this->_get_object_data($online_file['handle']);
					$my_tags = array();
					$group = "image";
					if ($online_file['type']==='2') $group="bgimage";
					if(isset($online_file['tags']) && !empty($online_file['tags'])){
						foreach($online_file['tags'] as $t){
							$my_tags[] = $t['handle'];
						}
					}
					$data['list']['png'][] = array(
						'src' => $my_data['thumb'],
						'origsrc' => $my_data['orig'],
						'type' => $online_file['type'],
						'group' => $group,
						'width' => $online_file['width'],
						'height' => $online_file['height'],
						'tags' => implode(',', $my_tags),
						'name' => $online_file['name']
					);
				}
			}
		}
		
		return $data;
	}
	
	
	/**
	 * get list of favorites
	 * @since: 5.3.0
	 */
	public function get_favorites(){
		return get_option('rs_obj_favorites', array());
	}
	
	
	/**
	 * save list of favorites
	 * @since: 5.3.0
	 */
	public function save_favorites($favourites){
		update_option('rs_obj_favorites', $favourites);
	}
	
}

?>