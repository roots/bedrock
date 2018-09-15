<?php
/**
 * Main object for controls
 *
 * @package vas_map
 */
if ( ! class_exists( 'VcTemplateManager' ) ) {
	class VcTemplateManager {
		protected $dir;
		protected static $post_type = "templatera";
		protected static $meta_data_name = "templatera";
		protected $settings_tab = 'templatera';
		protected $filename = 'templatera';
		protected $init = false;
		protected $current_post_type = false;
		protected static $template_type = 'templatera_templates';
		protected $settings = array(
			'assets_dir' => 'assets',
			'templates_dir' => 'templates',
			'template_extension' => 'tpl.php'
		);
		protected static $vcWithTemplatePreview = '4.8';

		function __construct( $dir ) {
			$this->dir = empty( $dir ) ? dirname( dirname( __FILE__ ) ) : $dir; // Set dir or find by current file path.
			$this->plugin_dir = basename( $this->dir ); // Plugin directory name required to append all required js/css files.
			add_filter( 'wpb_vc_js_status_filter', array(
				&$this,
				'setJsStatusValue'
			) );
		}

		/**
		 * @static
		 * Singleton
		 *
		 * @param string $dir
		 *
		 * @return VcTemplateManager
		 */
		public static function getInstance( $dir = '' ) {
			static $instance = null;
			if ( $instance === null ) {
				$instance = new VcTemplateManager( $dir );
			}

			return $instance;
		}

		/**
		 * @static
		 * Install plugins.
		 * Migrate default templates into templatera
		 * @return void
		 */
		public static function install() {
			$migrated = get_option( 'templatera_migrated_templates' ); // Check is migration already performed
			if ( $migrated !== 'yes' ) {
				$templates = (array) get_option( 'wpb_js_templates' );
				foreach ( $templates as $template ) {
					self::create( $template['name'], $template['template'] );
				}
				update_option( 'templatera_migrated_templates', 'yes' );
			}
		}

		/**
		 * @return string
		 */
		public static function postType() {
			return self::$post_type;
		}

		/**
		 * Initialize plugin data
		 * @return VcTemplateManager
		 */
		function init() {
			if ( $this->init ) {
				return $this;
			} // Disable double initialization.
			$this->init = true;

			if ( current_user_can( 'manage_options' ) && isset( $_GET['action'] ) && $_GET['action'] === 'export_templatera' ) {
				$id = ( isset( $_GET['id'] ) ? $_GET['id'] : null );
				add_action( 'wp_loaded', array_map( array(
					&$this,
					'export'
				), array( $id ) ) );
			} elseif ( current_user_can( 'manage_options' ) && isset( $_GET['action'] ) && $_GET['action'] === 'import_templatera' ) {
				add_action( 'wp_loaded', array( &$this, 'import' ) );
			}
			$this->createPostType();
			$this->initPluginLoaded(); // init filters/actions and hooks
			// Add vc template post type into the list of allowed post types for visual composer.
			if ( $this->isValidPostType() ) {
				$pt_array = get_option( 'wpb_js_content_types' );
				if ( ! is_array( $pt_array ) || empty( $pt_array ) ) {
					$pt_array = array( self::postType(), 'page' );
					update_option( 'wpb_js_content_types', $pt_array );
				} elseif ( ! in_array( self::postType(), $pt_array ) ) {
					$pt_array[] = self::postType();
					update_option( 'wpb_js_content_types', $pt_array );
				}
				vc_set_default_editor_post_types( array(
					'page',
					'templatera'
				) );
				vc_editor_set_post_types( vc_editor_post_types() + array( 'templatera' ) );
				add_action( 'admin_init', array( &$this, 'createMetaBox' ), 1 );
				add_filter( 'vc_role_access_with_post_types_get_state', '__return_true' );
				add_filter( 'vc_role_access_with_backend_editor_get_state', '__return_true' );
				add_filter( 'vc_role_access_with_frontend_editor_get_state', '__return_true' );
				add_filter( 'vc_check_post_type_validation', '__return_true' );
			}
			add_action( 'wp_loaded', array( $this, 'createShortcode' ) );

			return $this; // chaining.
		}

		/**
		 * Create tab on VC settings page.
		 *
		 * @param $tabs
		 *
		 * @return array
		 */
		public function addTab( $tabs ) {
			if ( $this->isUserRoleAccessVcVersion() && ! vc_user_access()
					->part( 'templates' )
					->can()
					->get()
			) {
				return $tabs;
			}
			$tabs[ $this->settings_tab ] = __( 'Templatera', "templatera" );

			return $tabs;
		}

		/**
		 * Create tab fields. in Visual composer settings page options-general.php?page=vc_settings
		 *
		 * @param Vc_Settings $settings
		 */
		public function buildTab( Vc_Settings $settings ) {
			$settings->addSection( $this->settings_tab );
			add_filter( 'vc_setting-tab-form-' . $this->settings_tab, array(
				&$this,
				'settingsFormParams'
			) );
			$settings->addField( $this->settings_tab, __( 'Export VC Templates', "templatera" ), 'export', array(
				&$this,
				'settingsFieldExportSanitize'
			), array( &$this, 'settingsFieldExport' ) );
			$settings->addField( $this->settings_tab, __( 'Import VC Templates', "templatera" ), 'import', array(
				&$this,
				'settingsFieldImportSanitize'
			), array( &$this, 'settingsFieldImport' ) );
		}

		/**
		 * Custom attributes for tab form.
		 * @see VcTemplateManager::buildTab
		 *
		 * @param $params
		 *
		 * @return string
		 */
		public function settingsFormParams( $params ) {
			$params .= ' enctype="multipart/form-data"';

			return $params;
		}

		/**
		 * Sanitize export field.
		 * @return bool
		 */
		public function settingsFieldExportSanitize() {
			return false;
		}

		/**
		 * Builds export link in settings tab.
		 */
		public function settingsFieldExport() {
			echo '<a href="export.php?page=wpb_vc_settings&action=export_templatera" class="button">' . __( 'Download Export File', "templatera" ) . '</a>';
		}

		/**
		 * Convert template/post to xml for export
		 *
		 * @param $template Template object
		 *
		 * @return string
		 */
		private function templateToXml( $template ) {
			$id = $template->ID;
			$meta_data = get_post_meta( $id, self::$meta_data_name, true );
			$post_types = isset( $meta_data['post_type'] ) ? $meta_data['post_type'] : false;
			$user_roles = isset( $meta_data['user_role'] ) ? $meta_data['user_role'] : false;
			$xml = '';
			$xml .= '<template>';
			$xml .= '<title>' . apply_filters( 'the_title_rss', $template->post_title ) . '</title>'
			        . '<content>' . $this->wxr_cdata( apply_filters( 'the_content_export', $template->post_content ) ) . '</content>';
			if ( $post_types !== false ) {
				$xml .= '<post_types>';
				foreach ( $post_types as $t ) {
					$xml .= '<post_type>' . $t . '</post_type>';
				}
				$xml .= '</post_types>';
			}
			if ( $user_roles !== false ) {
				$xml .= '<user_roles>';
				foreach ( $user_roles as $u ) {
					$xml .= '<user_role>' . $u . '</user_role>';
				}
				$xml .= '</user_roles>';
			}

			$xml .= '</template>';

			return $xml;
		}

		/**
		 * Export existing template in XML format.
		 *
		 * @param int $id (optional) Template ID. If not specified, export all templates
		 */
		public function export( $id = null ) {
			if ( $id ) {
				$template = get_post( $id );
				$templates = $template ? array( $template ) : array();
			} else {
				$templates = get_posts( array(
					'post_type' => self::postType(),
					'numberposts' => - 1
				) );
			}

			$xml = '<?xml version="1.0"?><templates>';
			foreach ( $templates as $template ) {
				$xml .= $this->templateToXml( $template );
			}
			$xml .= '</templates>';
			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=' . $this->filename . '_' . date( 'dMY' ) . '.xml' );
			header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
			echo $xml;
			die();
		}

		/**
		 * Import templates from file to the database by parsing xml file
		 * @return bool
		 */
		public function settingsFieldImportSanitize() {
			$file = isset( $_FILES['import'] ) ? $_FILES['import'] : false;
			if ( $file === false || ! file_exists( $file['tmp_name'] ) ) {
				return false;
			} else {
				$post_types = get_post_types( array( 'public' => true ) );
				$roles = get_editable_roles();
				$templateras = simplexml_load_file( $file['tmp_name'] );
				foreach ( $templateras as $t ) {
					$template_post_types = $template_user_roles = $meta_data = array();
					$content = (string) $t->content;
					$id = $this->create( (string) $t->title, $content );
					$this->contentMediaUpload( $id, $content );
					foreach ( $t->post_types as $type ) {
						$post_type = (string) $type->post_type;
						if ( in_array( $post_type, $post_types ) ) {
							$template_post_types[] = $post_type;
						}
					}
					if ( ! empty( $template_post_types ) ) {
						$meta_data['post_type'] = $template_post_types;
					}
					foreach ( $t->user_roles as $role ) {
						$user_role = (string) $role->user_role;
						if ( in_array( $user_role, $roles ) ) {
							$template_user_roles[] = $user_role;
						}
					}
					if ( ! empty( $template_user_roles ) ) {
						$meta_data['user_role'] = $template_user_roles;
					}
					update_post_meta( (int) $id, self::$meta_data_name, $meta_data );
				}
				@unlink( $file['tmp_name'] );
			}

			return false;
		}

		/**
		 * Build import file input.
		 */
		public function settingsFieldImport() {
			echo '<input type="file" name="import">';
		}

		/**
		 * Upload external media files in a post content to media library.
		 *
		 * @param $post_id
		 * @param $content
		 *
		 * @return bool
		 */
		protected function contentMediaUpload( $post_id, $content ) {
			preg_match_all( '/<img|a[^>]* src|href=[\'"]?([^>\'" ]+)/', $content, $matches );
			foreach ( $matches[1] as $match ) {
				if ( ! empty( $match ) ) {
					$file_array = array();
					$file_array['name'] = basename( $match );
					$tmp_file = download_url( $match );
					$file_array['tmp_name'] = $tmp_file;
					if ( is_wp_error( $tmp_file ) ) {
						@unlink( $file_array['tmp_name'] );
						$file_array['tmp_name'] = '';

						return false;
					}
					$desc = $file_array['name'];
					$id = media_handle_sideload( $file_array, $post_id, $desc );
					if ( is_wp_error( $id ) ) {
						@unlink( $file_array['tmp_name'] );

						return false;
					} else {
						$src = wp_get_attachment_url( $id );
					}
					$content = str_replace( $match, $src, $content );
				}
			}
			wp_update_post( array(
				'ID' => $post_id,
				'post_content' => $content
			) );

			return true;
		}

		/**
		 * CDATA field type for XML
		 *
		 * @param $str
		 *
		 * @return string
		 */
		function wxr_cdata( $str ) {
			if ( seems_utf8( $str ) == false ) {
				$str = utf8_encode( $str );
			}

			// $str = ent2ncr(esc_html($str));
			$str = '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', $str ) . ']]>';

			return $str;
		}

		/**
		 * Create post type "templatera" and item in the admin menu.
		 * @return void
		 */
		function createPostType() {
			register_post_type( self::postType(),
				array(
					'labels' => self::getPostTypesLabels(),
					'public' => false,
					'has_archive' => false,
					'show_in_nav_menus' => true,
					'exclude_from_search' => true,
					'publicly_queryable' => false,
					'show_ui' => true,
					'query_var' => true,
					'capability_type' => 'post',
					'hierarchical' => false,
					'menu_position' => null,
					'menu_icon' => $this->assetUrl( 'images/icon.gif' ),
					'show_in_menu' => ! WPB_VC_NEW_MENU_VERSION,
				)
			);
		}

		public static function getPostTypesLabels() {
			return array(
				'add_new_item' => __( 'Add template', "templatera" ),
				'name' => __( 'Templates', "templatera" ),
				'singular_name' => __( 'Template', "templatera" ),
				'edit_item' => __( 'Edit Template', "templatera" ),
				'view_item' => __( 'View Template', "templatera" ),
				'search_items' => __( 'Search Templates', "templatera" ),
				'not_found' => __( 'No Templates found', "templatera" ),
				'not_found_in_trash' => __( 'No Templates found in Trash', "templatera" ),
			);
		}

		/**
		 * Init filters / actions hooks
		 */
		function initPluginLoaded() {
			load_plugin_textdomain( 'templatera', false, basename( $this->dir ) . '/locale' );

			// Check for nav controls
			add_filter( 'vc_nav_controls', array(
					&$this,
					'createButtonFrontBack'
			) );
			add_filter( 'vc_nav_front_controls', array(
				&$this,
				'createButtonFrontBack'
			) );

			// add settings tab in visual composer settings
			add_filter( 'vc_settings_tabs', array( &$this, 'addTab' ) );
			// build settings tab @ER
			add_action( 'vc_settings_tab-' . $this->settings_tab, array(
				&$this,
				'buildTab'
			) );

			add_action( 'wp_ajax_vc_templatera_save_template', array(
				&$this,
				'saveTemplate'
			) );
			add_action( 'wp_ajax_vc_templatera_delete_template', array(
				&$this,
				'delete'
			) );
			add_filter( 'vc_templates_render_category', array(
				&$this,
				'renderTemplateBlock'
			), 10, 2 );
			add_filter( 'vc_templates_render_template', array(
				&$this,
				'renderTemplateWindow'
			), 10, 2 );

			if ( $this->getPostType() !== 'vc_grid_item' ) {
				add_filter( 'vc_get_all_templates', array(
					&$this,
					'replaceCustomWithTemplateraTemplates'
				) );
			}
			add_filter( 'vc_templates_render_frontend_template', array(
				&$this,
				'renderFrontendTemplate'
			), 10, 2 );
			add_filter( 'vc_templates_render_backend_template', array(
				&$this,
				'renderBackendTemplate'
			), 10, 2 );
			add_action( 'vc_templates_render_backend_template_preview', array(
				&$this,
				'getTemplateContentPreview'
			), 10, 2 );
			add_filter( 'vc_templates_show_save', array(
				&$this,
				'addTemplatesShowSave'
			) );
			add_action( 'wp_ajax_wpb_templatera_load_html', array(
				&$this,
				'loadHtml'
			) ); // used in changeShortcodeParams in templates.js, todo make sure we need this?
			add_action( 'save_post', array( &$this, 'saveMetaBox' ) );


			add_action( 'vc_frontend_editor_enqueue_js_css', array(
				&$this,
				'assetsFe'
			) );
			add_action( 'vc_backend_editor_enqueue_js_css', array(
				&$this,
				'assetsBe'
			) );

		}

		/**
		 * This used to detect what version of nav_controls use, and panels/modals js/template
		 *
		 * @param string $version
		 *
		 * @return bool
		 */
		function isNewVcVersion( $version = '4.4' ) {
			return defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, $version ) >= 0;
		}

		/**
		 * Removes save block if we editing templatera page
		 * In add templates panel window
		 * @since 4.4
		 * @return bool
		 */
		public function addTemplatesPanelShowSave( $show_save ) {
			if ( $this->isSamePostType() ) {
				$show_save = false; // we don't need "save" block if we editing templatera page.
			}

			return $show_save;
		}

		/**
		 * @since 4.4 we implemented new panel windows
		 * @return bool
		 */
		function isPanelVcVersion() {
			return $this->isNewVcVersion( '4.7' );
		}

		/**
		 * @since 4.8 we implemented new user roles part checks
		 * @return bool
		 */
		function isUserRoleAccessVcVersion() {
			return $this->isNewVcVersion( '4.8' );
		}

		/**
		 * Used to render template for backend
		 * @since 4.4
		 *
		 * @param $template_id
		 * @param $template_type
		 *
		 * @return string|int
		 */
		public function renderBackendTemplate( $template_id, $template_type ) {
			if ( self::$template_type === $template_type ) {
				WPBMap::addAllMappedShortcodes();
				// do something to return output of templatera template
				$post = get_post( $template_id );
				if ( $this->isSamePostType( $post->post_type ) ) {
					echo $post->post_content;
					die();
				}
			}

			return $template_id;
		}

		/**
		 * Get template content for preview.
		 * @since 4.5
		 *
		 * @param $template_id
		 * @param $template_type
		 *
		 * @return string
		 */
		public function getTemplateContentPreview( $template_id, $template_type ) {
			if ( self::$template_type === $template_type ) {
				WPBMap::addAllMappedShortcodes();
				// do something to return output of templatera template
				$post = get_post( $template_id );
				if ( $this->isSamePostType( $post->post_type ) ) {
					return $post->post_content;
				}
			}

			return $template_id;
		}

		/**
		 * Used to render template for frontend
		 * @since 4.4
		 *
		 * @param $template_id
		 * @param $template_type
		 *
		 * @return string|int
		 */
		public function renderFrontendTemplate( $template_id, $template_type ) {
			if ( self::$template_type === $template_type ) {
				WPBMap::addAllMappedShortcodes();
				// do something to return output of templatera template
				$post = get_post( $template_id );
				if ( $this->isSamePostType( $post->post_type ) ) {
					vc_frontend_editor()->enqueueRequired();
					vc_frontend_editor()->setTemplateContent( $post->post_content );
					vc_frontend_editor()->render( 'template' );
					die();
				}
			}

			return $template_id;
		}

		public function renderTemplateBlock( $category ) {
			if ( self::$template_type === $category['category'] ) {
				if ( ! $this->isUserRoleAccessVcVersion() || ( $this->isUserRoleAccessVcVersion() && vc_user_access()
							->part( 'templates' )
							->checkStateAny( true, null )
							->get() )
				) {
					$category['output'] = '
				<div class="vc_column vc_col-sm-12" data-vc-hide-on-search="true">
					<div class="vc_element_label">' . esc_html( 'Save current layout as a template', 'js_composer' ) . '</div>
					<div class="vc_input-group">
						<input name="padding" class="vc_form-control wpb-textinput vc_panel-templates-name" type="text" value=""
						       placeholder="' . esc_attr( 'Template name', 'js_composer' ) . '">
						<span class="vc_input-group-btn"> <button class="vc_btn vc_btn-primary vc_btn-sm vc_template-save-btn">' . esc_html( 'Save template', 'js_composer' ) . '</button></span>
					</div>
					<span class="vc_description">' . esc_html( 'Save your layout and reuse it on different sections of your website', 'js_composer' ) . '</span>
				</div>';
				}
				$category['output'] .= '<div class="vc_col-md-12">';
				if ( isset( $category['category_name'] ) ) {
					$category['output'] .= '<h3>' . esc_html( $category['category_name'] ) . '</h3>';
				}
				if ( isset( $category['category_description'] ) ) {
					$category['output'] .= '<p class="vc_description">' . esc_html( $category['category_description'] ) . '</p>';
				}
				$category['output'] .= '</div>';
				$category['output'] .= '
			<div class="vc_column vc_col-sm-12">
			<ul class="vc_templates-list-my_templates">';
				if ( ! empty( $category['templates'] ) ) {
					foreach ( $category['templates'] as $template ) {
						$category['output'] .= visual_composer()->templatesPanelEditor()->renderTemplateListItem($template);
					}
				}
				$category['output'] .= '</ul></div>';
			}

			return $category;
		}

		/**
		 * Hook templates panel window rendering, if template type is templatera_templates render it
		 * @since 4.4
		 *
		 * @param $template_name
		 * @param $template_data
		 *
		 * @return string
		 */
		public function renderTemplateWindow( $template_name, $template_data ) {
			if ( self::$template_type === $template_data['type'] ) {
				return $this->renderTemplateWindowTemplateraTemplates( $template_name, $template_data );
			}

			return $template_name;
		}

		/**
		 * Rendering templatera template for panel window
		 * @since 4.4
		 *
		 * @param $template_name
		 * @param $template_data
		 *
		 * @return string
		 */
		public function renderTemplateWindowTemplateraTemplates( $template_name, $template_data ) {
			ob_start();
			if ( $this->isNewVcVersion( self::$vcWithTemplatePreview ) ) {
				$template_id = esc_attr( $template_data['unique_id'] );
				$template_id_hash = md5( $template_id ); // needed for jquery target for TTA
				$template_name = esc_html( $template_name );
				$delete_template_title = esc_attr( 'Delete template', 'templatera' );
				$preview_template_title = esc_attr( 'Preview template', 'templatera' );
				$add_template_title = esc_attr( 'Add template', 'templatera' );
				$edit_template_title = esc_attr( 'Edit template', 'templatera' );
				$template_url = esc_attr( admin_url( 'post.php?post=' . $template_data['unique_id'] . '&action=edit' ) );
				$edit_tr_html = '';
				if ( ! $this->isUserRoleAccessVcVersion() || ( $this->isUserRoleAccessVcVersion() && vc_user_access()
							->part( 'templates' )
							->checkStateAny( true, null )
							->get() )
				) {
					$edit_tr_html = <<<EDTR
				<a href="$template_url"  class="vc_general vc_ui-control-button" title="$edit_template_title" target="_blank">
					<i class="vc_ui-icon-pixel vc_ui-icon-pixel-control-edit-dark"></i>
				</a>
				<button type="button" class="vc_general vc_ui-control-button" data-vc-ui-delete="template-title" title="$delete_template_title">
					<i class="vc_ui-icon-pixel vc_ui-icon-pixel-control-trash-dark"></i>
				</button>
EDTR;
				}

				echo <<<HTML
			<button type="button" class="vc_ui-list-bar-item-trigger" title="$add_template_title"
					 	data-template-handler=""
						data-vc-ui-element="template-title">$template_name</button>
			<div class="vc_ui-list-bar-item-actions">
				<button type="button" class="vc_general vc_ui-control-button" title="$add_template_title"
					 	data-template-handler="">
					<i class="vc_ui-icon-pixel vc_ui-icon-pixel-control-add-dark"></i>
				</button>$edit_tr_html
				<button type="button" class="vc_general vc_ui-control-button" title="$preview_template_title"
					data-vc-container=".vc_ui-list-bar" data-vc-preview-handler data-vc-target="[data-template_id_hash=$template_id_hash]">
					<i class="vc_ui-icon-pixel vc_ui-preview-icon"></i>
				</button>
			</div>
HTML;
			} else {
				?>
				<div class="vc_template-wrapper vc_input-group"
				     data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>">
					<a data-template-handler="true" class="vc_template-display-title vc_form-control"
					   data-vc-ui-element="template-title"
					   href="javascript:;"><?php echo esc_html( $template_name ); ?></a>
			<span class="vc_input-group-btn vc_template-icon vc_template-edit-icon"
			      title="<?php esc_attr_e( 'Edit template', 'templatera' ); ?>"
			      data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>"><a
					href="<?php echo esc_attr( admin_url( 'post.php?post=' . $template_data['unique_id'] . '&action=edit' ) ); ?>"
					target="_blank" class="vc_icon"></i></a></span>
			<span class="vc_input-group-btn vc_template-icon vc_template-delete-icon"
			      title="<?php esc_attr_e( 'Delete template', 'templatera' ); ?>"
			      data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>"><i
					class="vc_icon"></i></span>
				</div>
				<?php
			}

			return ob_get_clean();
		}

		/**
		 * Function used to replace old my templates with new templatera templates
		 * @since 4.4
		 *
		 * @param array $data
		 *
		 * @return array
		 */
		public function replaceCustomWithTemplateraTemplates( array $data ) {
			$templatera_templates = $this->getTemplateList();
			$templatera_arr = array();
			foreach ( $templatera_templates as $template_name => $template_id ) {
				$templatera_arr[] = array(
					'unique_id' => $template_id,
					'name' => $template_name,
					'type' => 'templatera_templates',
					// for rendering in backend/frontend with ajax);
				);
			}

			if ( ! empty( $data ) ) {
				$found = false;
				foreach ( $data as $key => $category ) {
					if ( $category['category'] == 'my_templates' ) {
						$found = true;
						$data[ $key ]['templates'] = $templatera_arr;
					}
				}
				if ( ! $found ) {
					$data[] = array(
						'templates' => $templatera_arr,
						'category' => 'my_templates',
						'category_name' => __( 'My Templates', 'js_composer' ),
						'category_description' => __( 'Append previously saved template to the current layout', 'js_composer' ),
						'category_weight' => 10,
					);
				}
			} else {
				$data[] = array(
					'templates' => $templatera_arr,
					'category' => 'my_templates',
					'category_name' => __( 'My Templates', 'js_composer' ),
					'category_description' => __( 'Append previously saved template to the current layout', 'js_composer' ),
					'category_weight' => 10,
				);
			}

			return $data;
		}

		/**
		 * Maps Frozen row shortcode
		 */
		function createShortcode() {
			vc_map( array(
				"name" => __( "Templatera", "templatera" ),
				"base" => "templatera",
				"icon" => "icon-templatera",
				"category" => __( 'Content', "templatera" ),
				"params" => array(
					array(
						"type" => "dropdown",
						"heading" => __( "Select template", "templatera" ),
						"param_name" => "id",
						"value" => array( __( 'Choose template', 'js_composer' ) => '' ) + $this->getTemplateList(),
						"description" => __( "Choose which template to load for this location.", "templatera" )
					),
					array(
						"type" => "textfield",
						"heading" => __( "Extra class name", "templatera" ),
						"param_name" => "el_class",
						"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "templatera" )
					)
				),
				"js_view" => 'VcTemplatera'
			) );
			add_shortcode( 'templatera', array( &$this, 'outputShortcode' ) );
		}

		/**
		 * Frozen row shortcode hook.
		 *
		 * @param $atts
		 * @param string $content
		 *
		 * @return string
		 */
		public function outputShortcode( $atts, $content = '' ) {
			$id = $el_class = $output = '';
			extract( shortcode_atts( array(
				'el_class' => '',
				'id' => ''
			), $atts ) );
			if ( empty( $id ) ) {
				return $output;
			}
			$my_query = new WP_Query( array( 'post_type' => self::postType(), 'p' => (int)$id ) );
			WPBMap::addAllMappedShortcodes();
			while ( $my_query->have_posts() ) {
				$my_query->the_post();
				if( get_the_ID() === (int)$id ) {
					$output .= '<div class="templatera_shortcode' . ( $el_class ? ' ' . $el_class : '' ) . '">';
					ob_start();
					visual_composer()->addFrontCss();
					$content = get_the_content();
					echo $content;
					$output .= ob_get_clean();
					$output .= '</div>';
					$output = do_shortcode( $output );
				}
			}
			wp_reset_query();
			wp_enqueue_style( 'templatera_inline', $this->assetUrl( 'css/front_style.css' ), false, '2.1' );
			return $output;
		}

		/**
		 * Create meta box for self::$post_type, with template settings
		 */
		public function createMetaBox() {
			add_meta_box( 'vas_template_settings_metabox', __( 'Template Settings', "templatera" ), array(
				&$this,
				'sideOutput'
			), self::postType(), 'side', 'high' );
		}

		/**
		 * Used in meta box VcTemplateManager::createMetaBox
		 */
		public function sideOutput() {
			$data = get_post_meta( get_the_ID(), self::$meta_data_name, true );
			$data_post_types = isset( $data['post_type'] ) ? $data['post_type'] : array();
			$post_types = get_post_types( array( 'public' => true ) );
			echo '<div class="misc-pub-section">
            <div class="templatera_title"><b>' . __( 'Post types', "templatera" ) . '</b></div>
            <div class="input-append">
                ';
			foreach ( $post_types as $type ) {
				if ( $type != 'attachment' && ! $this->isSamePostType( $type ) ) {
					echo '<label><input type="checkbox" name="' . esc_attr( self::$meta_data_name ) . '[post_type][]" value="' . esc_attr( $type ) . '"' . ( in_array( $type, $data_post_types ) ? ' checked="true"' : '' ) . '> ' . ucfirst( $type ) . '</label><br/>';
				}
			}
			echo '</div><p>' . __( 'Select for which post types this template should be available. Default: Available for all post types.', "templatera" ) . '</p></div>';
			$groups = get_editable_roles();
			$data_user_role = isset( $data['user_role'] ) ? $data['user_role'] : array();
			echo '<div class="misc-pub-section vc_user_role">
            <div class="templatera_title"><b>' . __( 'Roles', "templatera" ) . '</b></div>
            <div class="input-append">
                ';
			foreach ( $groups as $key => $g ) {
				echo '<label><input type="checkbox" name="' . self::$meta_data_name . '[user_role][]" value="' . $key . '"' . ( in_array( $key, $data_user_role ) ? ' checked="true"' : '' ) . '> ' . $g['name'] . '</label><br/>';
			}
			echo '</div><p>' . __( 'Select for user roles this template should be available. Default: Available for all user roles.', "templatera" ) . '</p></div>';
		}

		/**
		 * Url to js/css or image assets of plugin
		 *
		 * @param $file
		 *
		 * @return string
		 */
		public function assetUrl( $file ) {
			return plugins_url( $this->plugin_dir . '/assets/' . $file, plugin_dir_path( dirname( __FILE__ ) ) );
		}

		/**
		 * Absolute path to assets files
		 *
		 * @param $file
		 *
		 * @return string
		 */
		public function assetPath( $file ) {
			return $this->dir . '/assets/' . $file;
		}

		public function isValidPostType() {
			$type = get_post_type();
			$post = ( isset( $_GET['post'] ) && $this->compareType( get_post_type( $_GET['post'] ) ) );
			$post_type = ( isset( $_GET['post_type'] ) && $this->compareType( $_GET['post_type'] ) );
			$post_type_id = ( isset( $_GET['post_id'] ) && $this->compareType( get_post_type( (int) $_GET['post_id'] ) ) );
			$post_vc_type_id = ( isset( $_GET['vc_post_id'] ) && $this->compareType( get_post_type( (int) $_GET['vc_post_id'] ) ) );

			return (
				( $type && $this->compareType( $type ) ) ||
				( $post ) ||
				( $post_type ) ||
				( $post_type_id )||
				( $post_vc_type_id )
			);
		}

		public function compareType( $type ) {
			return in_array( $type, array_merge( vc_editor_post_types(), array( 'templatera' ) ) );
		}

		/**
		 * Load required js and css files
		 */
		public function assets() {
			if ( $this->isValidPostType() ) {
				$this->assetsFe();
				$this->assetsBe();
			}
		}

		public function assetsFe() {
			if ( $this->isValidPostType() && ( vc_user_access()
						->part( 'frontend_editor' )
						->can()
						->get() )
			) {
				$this->addGridScripts();
				$dependency = array( 'vc-frontend-editor-min-js', );
				wp_register_script( 'vc_plugin_inline_templates', $this->assetURL( 'js/templates_panels.js' ), $dependency, WPB_VC_VERSION, true );
				wp_register_script( 'vc_plugin_templates', $this->assetURL( 'js/templates.js' ), array(), time(), true );
				wp_localize_script( 'vc_plugin_templates', 'VcTemplateI18nLocale', array(
					'please_enter_templates_name' => __( 'Please enter template name', "templatera" )
				) );
				wp_register_style( 'vc_plugin_template_css', $this->assetURL( 'css/style.css' ), false, '1.1.0' );
				wp_enqueue_style( 'vc_plugin_template_css' );
				$this->addTemplateraJs();
			}
		}

		public function assetsBe() {
			if ( $this->isValidPostType() && ( vc_user_access()
						->part( 'backend_editor' )
						->can()
						->get() || $this->isSamePostType() )
			) {
				$this->addGridScripts();
				$dependency = array( 'vc-backend-min-js' );
				wp_register_script( 'vc_plugin_inline_templates', $this->assetURL( 'js/templates_panels.js' ), $dependency, WPB_VC_VERSION, true );
				wp_register_script( 'vc_plugin_templates', $this->assetURL( 'js/templates.js' ), array(), time(), true );
				wp_localize_script( 'vc_plugin_templates', 'VcTemplateI18nLocale', array(
					'please_enter_templates_name' => __( 'Please enter template name', "templatera" ),
				) );
				wp_register_style( 'vc_plugin_template_css', $this->assetURL( 'css/style.css' ), false, '1.1.0' );
				wp_enqueue_style( 'vc_plugin_template_css' );
				$this->addTemplateraJs();
			}
		}

		public function getPostType() {
			if ( $this->current_post_type ) {
				return $this->current_post_type;
			}
			$post_type = false;
			if ( isset( $_GET['post'] ) ) {
				$post_type = get_post_type( $_GET['post'] );
			} else if ( isset( $_GET['post_type'] ) ) {
				$post_type = $_GET['post_type'];
			}
			$this->current_post_type = $post_type;

			return $this->current_post_type;
		}

		/**
		 * Create templates button on navigation bar of the Front/Backend editor.
		 *
		 * @param $buttons
		 *
		 * @return array
		 */
		public function createButtonFrontBack( $buttons ) {
			if ( $this->isUserRoleAccessVcVersion() && ! vc_user_access()
					->part( 'templates' )
					->can()
					->get()
			) {
				return $buttons;
			}
			if ( $this->getPostType() == "vc_grid_item" ) {
				return $buttons;
			}

			$new_buttons = array();

			foreach ( $buttons as $button ) {
				if ( $button[0] != 'templates' ) {
					// disable custom css as well but only in templatera page
					if ( ! $this->isSamePostType() || ( $this->isSamePostType() && $button[0] != 'custom_css' ) ) {
						$new_buttons[] = $button;
					}
				} else {
					if ( $this->isPanelVcVersion() ) {
						// @since 4.4 button is available but "Save" Functionality in form is disabled in templatera post.
						$new_buttons[] = array(
							'custom_templates',
							'<li class="vc_navbar-border-right"><a href="#" class="vc_icon-btn vc_templatera_button"  id="vc-templatera-editor-button" title="' . __( 'Templates', 'js_composer' ) . '"></a></li>'
						);
					} else {
						if ( $this->isSamePostType() ) {
							// in older version we doesn't need to display templates window in templatera post
						} else {
							$new_buttons[] = array(
								'custom_templates',
								'<li class="vc_navbar-border-right"><a href="#" class="vc_icon-btn vc_templatera_button"  id="vc-templatera-editor-button" title="' . __( 'Templates', 'js_composer' ) . '"></a></li>'
							);
						}
					}

				}
			}

			return $new_buttons;
		}

		/**
		 * Add javascript to extend functionality of templates editor panel or new panel(since 4.4)
		 */
		public function addEditorTemplates() {
			return;
		}

		/**
		 * Used to add js in backend/frontend to init template UI functionality
		 */
		public function addTemplateraJs() {
			wp_enqueue_script( 'vc_plugin_inline_templates' );
			wp_enqueue_script( 'vc_plugin_templates' );
		}

		/**
		 * Used to save new template from ajax request in new panel window
		 * @since 4.4
		 *
		 */
		public function saveTemplate() {
			if ( ! vc_verify_admin_nonce() || ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) ) {
				die();
			}
			$title = vc_post_param( 'template_name' );
			$content = vc_post_param( 'template' );
			$template_id = $this->create( $title, $content );
			$template_title = get_the_title( $template_id );
			if ( $this->isNewVcVersion( self::$vcWithTemplatePreview ) ) {
				echo visual_composer()
					->templatesPanelEditor()
					->renderTemplateListItem( array(
						'name' => $template_title,
						'unique_id' => $template_id,
						'type' => self::$template_type
					) );
			} else {
				echo $this->renderTemplateWindowTemplateraTemplates( $template_title, array( 'unique_id' => $template_id ) );
			}
			die();
		}

		/**
		 * Gets list of existing templates. Checks access rules defined by template author.
		 * @return array
		 */
		protected function getTemplateList() {
			global $current_user;
			wp_get_current_user();
			$current_user_role = isset( $current_user->roles[0] ) ? $current_user->roles[0] : false;
			$list = array();
			$templates = get_posts( array(
				'post_type' => self::postType(),
				'numberposts' => - 1
			) );
			$post = get_post( isset( $_POST['post_id'] ) ? $_POST['post_id'] : null );
			foreach ( $templates as $template ) {
				$id = $template->ID;
				$meta_data = get_post_meta( $id, self::$meta_data_name, true );
				$post_types = isset( $meta_data['post_type'] ) ? $meta_data['post_type'] : false;
				$user_roles = isset( $meta_data['user_role'] ) ? $meta_data['user_role'] : false;
				if (
					( ! $post || ! $post_types || in_array( $post->post_type, $post_types ) )
					&& ( ! $current_user_role || ! $user_roles || in_array( $current_user_role, $user_roles ) )
				) {
					$list[ $template->post_title ] = $id;
				}
			}

			return $list;
		}

		/**
		 * Creates new template.
		 * @static
		 *
		 * @param $title
		 * @param $content
		 *
		 * @return int|WP_Error
		 */
		protected static function create( $title, $content ) {
			return wp_insert_post( array(
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_type' => self::postType()
			) );
		}

		/**
		 * Used to delete template by template id
		 *
		 * @param int $template_id - if provided used, if not provided used vc_post_param('template_id')
		 */
		public function delete( $template_id = null ) {
			if ( ! vc_verify_admin_nonce() || ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) ) {
				die();
			}
			$post_id = $template_id ? $template_id : vc_post_param( 'template_id' );
			if ( ! is_null( $post_id ) ) {
				$post = get_post( $post_id );

				if ( ! $post || ! $this->isSamePostType( $post->post_type ) ) {
					die( 'failed to delete' );
				} else if( wp_delete_post( $post_id ) ) {
					die( 'deleted' );
				}
			}
			die( 'failed to delete' );
		}

		/**
		 * Saves post data in databases after publishing or updating template's post.
		 *
		 * @param $post_id
		 *
		 * @return bool
		 */
		public function saveMetaBox( $post_id ) {
			if ( ! $this->isSamePostType() ) {
				return true;
			}
			if ( isset( $_POST[ self::$meta_data_name ] ) ) {
				$options = isset( $_POST[ self::$meta_data_name ] ) ? (array) $_POST[ self::$meta_data_name ] : Array();
				update_post_meta( (int) $post_id, self::$meta_data_name, $options );
			} else {
				delete_post_meta( (int) $post_id, self::$meta_data_name );
			}

			return true;
		}

		/**
		 * @param $value
		 *
		 * @todo make sure we need this?
		 * @return string
		 */
		public function setJsStatusValue( $value ) {
			return $this->isSamePostType() ? 'true' : $value;
		}

		/**
		 * Used in templates.js:changeShortcodeParams
		 * @todo make sure we need this
		 * Output some template content
		 * @todo make sure it is secure?
		 */
		public function loadHtml() {
			if ( ! vc_verify_admin_nonce() || ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) ) {
				die();
			}
			$id = vc_post_param( 'id' );
			$post = get_post( (int) $id );
			if ( ! $post ) {
				die( __( 'Wrong template', 'templatera' ) );
			}
			if ( $this->isSamePostType( $post->post_type ) ) {
				echo $post->post_content;
			}
			die();
		}

		public function addGridScripts() {
			if ( $this->isSamePostType() ) {
				wp_enqueue_script( 'wpb_templatera-grid-id-param-js',
					$this->assetURL( 'js/templatera-grid-id-param.js' ),
					array( 'wpb_js_composer_js_listeners' ), WPB_VC_REQUIRED_VERSION, true );
			}
		}

		/**
		 * @return bool
		 */
		protected function isSamePostType( $type = '' ) {
			return $type ? $type === self::postType() : get_post_type() === self::postType();
		}
	}
}
