<?php
/**
 * Main object for controls
 *
 * @package vas_map
 */

if (!class_exists('VcTemplateManager')) {
    Class VcTemplateManager
    {
        protected $dir;
        protected static $post_type = "north";
        protected static $meta_data_name = "north";
        protected $settings_tab = o;
        protected $filename = r;
        protected $themes_dir = 'css/themes';
        protected $init = false;
        protected $themes = array();
        protected $settings = array(
            'assets_dir' => 'assets',
            'templates_dir' => 'templates',
            'template_extension' => 'tpl.php'
        );

        function __construct($dir)
        {
            $this->dir = empty($dir) ? dirname(dirname(__FILE__)) : $dir; // Set dir or find by current file path.
            $this->plugin_dir = basename($this->dir); // Plugin directory name required to append all required js/css files.
        	add_filter('wpb_vc_js_status_filter', array(&$this, 'setJsStatusValue'));
		}

        /**
         * @static
         * Singleton
         * @param string $dir
         * @return VcTemplateManager
         */
        public static function getInstance($dir = '')
        {
            static $instance = null;
            if ($instance === null)
                $instance = new VcTemplateManager($dir);
            return $instance;
        }

        /**
         * @static
         * Install plugins.
         * Migrate default templates into templatera
         * @return void
         */
        public static function install()
        {
            $migrated = get_option('templatera_migrated_templates'); // Check is migration already performed
            if ($migrated !== 'yes') {
                $templates = (array)get_option('wpb_js_templates');
                foreach ($templates as $template) {
                    self::create($template['name'], $template['template']);
                }
                update_option('templatera_migrated_templates', 'yes');
            }
        }

        /**
         * Initialize plugin data
         * @return VcTemplateManager
         */
        function init()
        {
            if ($this->init) return $this; // Disable double initialization.
            $this->init = true;

            if (isset($_GET['action']) && $_GET['action'] === 'export_templatera') {
                add_action('wp_loaded', array(&$this, 'export'));
            } elseif (isset($_GET['action']) && $_GET['action'] === 'import_templatera') {
                add_action('wp_loaded', array(&$this, 'import'));
            }
            $this->createPostType();
            $this->initPluginLoaded();
            // Add vc template post type into the list of allowed post types for visual composer.
            if ((isset($_GET['post']) && get_post_type($_GET['post']) === self::$post_type) || (isset($_GET['post_type']) && $_GET['post_type'] == self::$post_type)) {
                $pt_array = get_option('wpb_js_content_types');
                if (!is_array($pt_array) || empty($pt_array)) {
                    $pt_array = array(self::$post_type, 'page');
                    update_option('wpb_js_content_types', $pt_array);
                } elseif (!in_array(self::$post_type, $pt_array)) {
                    $pt_array[] = self::$post_type;
                    update_option('wpb_js_content_types', $pt_array);
                }
                add_action('admin_init', array(&$this, 'createMetaBox'), 1);
            } else {
                add_action('wp_loaded', array($this, 'createShortcode'));

            }
            return $this; // chaining.
        }

        /**
         * Create tab on VC settings page.
         * @param $tabs
         * @return array
         */
        public function addTab($tabs)
        {
            $tabs[$this->settings_tab] = __('Templatera', "north");
            return $tabs;
        }

        /**
         * Create tab fields.
         * @param $settings
         */
        public function buildTab($settings)
        {
            $settings->addSection($this->settings_tab);
            add_filter('vc_setting-tab-form-' . $this->settings_tab, array(&$this, 'settingsFormParams'));
            //$settings->addField($this->settings_tab, __('CSS Themes', "north"), "themes", array(&$this, 'settingsFieldThemesSanitize'), array(&$this, 'settingsFieldThemes'));
            $settings->addField($this->settings_tab, __('Export VC Templates', "north"), 'export', array(&$this, 'settingsFieldExportSanitize'), array(&$this, 'settingsFieldExport'));
            $settings->addField($this->settings_tab, __('Import VC Templates', "north"), 'import', array(&$this, 'settingsFieldImportSanitize'), array(&$this, 'settingsFieldImport'));
        }

        /**
         * Custom attributes for tab form.
         * @param $params
         * @return string
         */
        public function settingsFormParams($params)
        {
            $params .= ' enctype="multipart/form-data"';
            return $params;
        }

        /**
         * Sanitize theme value.
         * @param $theme
         * @return string
         */
        public function settingsFieldThemesSanitize($theme)
        {
            $this->getThemes();
            return in_array($theme, array_keys($this->themes)) ? $theme : ' ';
        }

        /**
         * Build theme dropdown
         */
        public function settingsFieldThemes()
        {
            $this->getThemes();
            $value = ($value = get_option(WPBakeryVisualComposerSettings::getFieldPrefix() . 'themes')) ? $value : '';
            echo '<select name="' . WPBakeryVisualComposerSettings::getFieldPrefix() . 'themes' . '">';
            echo '<option value=""></option>';
            foreach ($this->themes as $key => $title) {
                echo '<option value="' . $key . '"' . ($value === $key ? ' selected="true"' : '') . '>' . __($title, "north") . '</option>';
            }
            echo '</select>';
            echo '<p class="description indicator-hint">' . __('Select CSS Theme to change content elements visual appearance.', "north") . '</p>';

        }

        /**
         * Create themes list. Checks filesystem for existing css files in theme directory.
         */
        public function getThemes()
        {
            $paths = glob($this->assetPath($this->themes_dir . '/*.css'));
            foreach ($paths as $path) {
                $filename = basename($path);
                $this->themes[$filename] = ucwords(preg_replace(array('/(\.css)$/', '/_/', '/\-/'), array('', ' ', ' '), $filename));
            }
        }

        /**
         * Sanitize export field.
         * @return bool
         */
        public function settingsFieldExportSanitize()
        {
            return false;
        }

        /**
         * Builds export link in settings tab.
         */
        public function settingsFieldExport()
        {
            echo '<a href="export.php?page=wpb_vc_settings&action=export_templatera" class="button">' . __('Download Export File', "north") . '</a>';
        }

        /**
         * Export existing template in XML format.
         *
         */
        public function export()
        {
            $templates = get_posts();
            $templates = get_posts(array(
                'post_type' => self::$post_type,
                'numberposts' => -1
            ));
            $xml = '<?xml version="1.0"?><templates>';
            foreach ($templates as $template) {
                $id = $template->ID;
                $meta_data = get_post_meta($id, self::$meta_data_name, true);
                $post_types = isset($meta_data['post_type']) ? $meta_data['post_type'] : false;
                $user_roles = isset($meta_data['user_role']) ? $meta_data['user_role'] : false;
                $xml .= '<template>';
                $xml .= '<title>' . apply_filters('the_title_rss', $template->post_title) . '</title>'
                    . '<content>' . $this->wxr_cdata(apply_filters('the_content_export', $template->post_content)) . '</content>';
                if ($post_types !== false) {
                    $xml .= '<post_types>';
                    foreach ($post_types as $t) {
                        $xml .= '<post_type>' . $t . '</post_type>';
                    }
                    $xml .= '</post_types>';
                }
                if ($user_roles !== false) {
                    $xml .= '<user_roles>';
                    foreach ($user_roles as $u) {
                        $xml .= '<user_role>' . $u . '</user_role>';
                    }
                    $xml .= '</user_roles>';
                }

                $xml .= '</template>';
            }
            $xml .= '</templates>';
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . $this->filename . '_' . date('dMY') . '.xml');
            header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
            echo $xml;
            die();
        }

        /**
         * Import templates from file to the database by parsing xml file
         * @return bool
         */
        public function settingsFieldImportSanitize()
        {
            $file = isset($_FILES['import']) ? $_FILES['import'] : false;
            if ($file === false || !file_exists($file['tmp_name'])) {
                return false;
            } else {
                $post_types = get_post_types(array('public' => true));
                $roles = get_editable_roles();
                $templateras = simplexml_load_file($file['tmp_name']);
                foreach ($templateras as $t) {
                    $template_post_types = $template_user_roles = $meta_data = array();
                    $content = (string)$t->content;
                    $id = $this->create((string)$t->title, $content);
                    $this->contentMediaUpload($id, $content);
                    foreach ($t->post_types as $type) {
                        $post_type = (string)$type->post_type;
                        if (in_array($post_type, $post_types)) $template_post_types[] = $post_type;
                    }
                    if (!empty($template_post_types)) $meta_data['post_type'] = $template_post_types;
                    foreach ($t->user_roles as $role) {
                        $user_role = (string)$role->user_role;
                        if (in_array($user_role, $roles)) $template_user_roles[] = $user_role;
                    }
                    if (!empty($template_user_roles)) $meta_data['user_role'] = $template_user_roles;
                    update_post_meta((int)$id, self::$meta_data_name, $meta_data);
                }
                @unlink($file['tmp_name']);
            }
            return false;
        }

        /**
         * Build import file input.
         */
        public function settingsFieldImport()
        {
            echo '<input type="file" name="import">';
        }

        /**
         * Upload external media files in a post content to media library.
         * @param $post_id
         * @param $content
         * @return bool
         */
        protected function contentMediaUpload($post_id, $content)
        {
            preg_match_all('/<img|a[^>]* src|href=[\'"]?([^>\'" ]+)/', $content, $matches);
            foreach ($matches[1] as $match) {
                if (!empty($match)) {
                    $file_array = array();
                    $file_array['name'] = basename($match);
                    $tmp_file = download_url($match);
                    $file_array['tmp_name'] = $tmp_file;
                    if (is_wp_error($tmp_file)) {
                        @unlink($file_array['tmp_name']);
                        $file_array['tmp_name'] = '';
                        return false;
                    }
                    $desc = $file_array['name'];
                    $id = media_handle_sideload($file_array, $post_id, $desc);
                    if (is_wp_error($id)) {
                        @unlink($file_array['tmp_name']);
                        return false;
                    } else {
                        $src = wp_get_attachment_url($id);
                    }
                    $content = str_replace($match, $src, $content);
                }
            }
            wp_update_post(array('ID' => $post_id, 'post_content' => $content));
        }

        /**
         * CDATA field type for XML
         * @param $str
         * @return string
         */
        function wxr_cdata($str)
        {
            if (seems_utf8($str) == false)
                $str = utf8_encode($str);

            // $str = ent2ncr(esc_html($str));
            $str = '<![CDATA[' . str_replace(']]>', ']]]]><![CDATA[>', $str) . ']]>';

            return $str;
        }

        /**
         * Create post type "north" and item in the admin menu.
         * @return void
         */
        function createPostType()
        {
            register_post_type(self::$post_type,
                array(
                    'labels' => array(
                        'add_new_item' => __('Add template', "north"),
                        'name' => __('VC Templates', "north"),
                        'singular_name' => __('Template', "north"),
                        'edit_item' => __('Edit Template', "north"),
                        'view_item' => __('View Template', "north"),
                        'search_items' => __('Search Templates', "north"),
                        'not_found' => __('No Templates found', "north"),
                        'not_found_in_trash' => __('No Templates found in Trash', "north"),
                    ),
                    'public' => false,
                    'has_archive' => false,
                    'show_in_nav_menus' => true,
                    'exclude_from_search' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'menu_position' => null,
                    'menu_icon' => $this->assetUrl('images/icon.gif')
                )
            );
        }
        function initPluginLoaded() {
            load_plugin_textdomain( "north", false, basename($this->dir).'/locale' );
            add_action('wp_enqueue_scripts', array(&$this, 'enqueueThemeFiles'));
            add_action('vc_frontend_editor_render', array(&$this, 'addEditorTemplates'));
			if($this->isNewVcVersion()) {
				add_action('vc_backend_editor_render', array(&$this, 'addEditorTemplates'));
				add_filter('vc_nav_controls', array(&$this, 'createFrontButton'));
			} else {
				add_filter('vc_nav_controls', array(&$this, 'createButton'));
			}
			add_filter('vc_nav_front_controls', array(&$this, 'createFrontButton'));
            add_filter('vc_settings_tabs', array(&$this, 'addTab'));
            add_action('vc_settings_tab-' . $this->settings_tab, array(&$this, 'buildTab'));
            add_action('admin_enqueue_scripts', array(&$this, 'assets'));
            add_action('wp_ajax_templatera_plugin_load', array(&$this, 'load'));
            add_action('wp_ajax_templatera_plugin_load_inline', array(&$this, 'loadInline'));
            add_action('wp_ajax_templatera_plugin_save', array(&$this, 'save'));
            add_action('wp_ajax_templatera_plugin_delete', array(&$this, 'delete'));
            add_action('wp_ajax_wpb_templatera_load_html', array(&$this, 'loadHtml'));
            add_filter('body_class', array(&$this, 'addThemeBodyClass'));
            add_action('save_post', array(&$this, 'saveMetaBox'));
        }
		function isNewVcVersion() {
			return defined('WPB_VC_VERSION') && version_compare('4.2.3', WPB_VC_VERSION) < 0;
		}
        /**
         * Maps Frozen row shortcode
         */
        function createShortcode()
        {
            vc_map(array(
                "name" => __("north", "north"),
                "base" => "north",
                "icon" => "icon-templatera",
                "category" => __('Content', "north"),
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => __("Select template", "north"),
                        "param_name" => "id",
                        "value" => $this->getTemplateList(),
                        "description" => __("Choose which template to load for this location.", "north")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra class name", "north"),
                        "param_name" => "el_class",
                        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "north")
                    )
                ),
                "js_view" => 'VcTemplatera'
            ));
            add_shortcode('templatera', array(&$this, 'outputShortcode'));
        }

        /**
         * Frozen row shortcode hook.
         * @param $atts
         * @param string $content
         * @return string
         */
        public function outputShortcode($atts, $content = '')
        {
            $id = $el_class = $output = '';
            extract(shortcode_atts(array(
                'el_class' => '',
                'id' => ''
            ), $atts));
            if (empty($id)) return $output;
            $post = get_post($id);
            if ($post) {
                $output .= '<div class="templatera_shortcode' . ($el_class ? ' ' . $el_class : '') . '">';
                if($post->post_type===self::$post_type) $output .= apply_filters('the_content', $post->post_content);
                $output .= '</div>';
            }
            wp_enqueue_style('templatera_inline', $this->assetUrl('css/front_style.css'), false, '2.1');
            return $output;
        }

        public function createMetaBox()
        {
            add_meta_box('vas_template_settings_metabox', __('Template Settings', "north"), array(&$this, 'sideOutput'), self::$post_type, 'side', 'high');
        }

        public function sideOutput()
        {
            $data = get_post_meta(get_the_ID(), self::$meta_data_name, true);
            $data_post_types = isset($data['post_type']) ? $data['post_type'] : array();
            $post_types = get_post_types(array('public' => true));
            echo '<div class="misc-pub-section">
            <div class="templatera_title"><b>' . __('Post types', "north") . '</b></div>
            <div class="input-append">
                ';
            foreach ($post_types as $t) {
                if ($t != 'attachment' && $t != self::$post_type) echo '<label><input type="checkbox" name="' . self::$meta_data_name . '[post_type][]" value="' . $t . '"' . (in_array($t, $data_post_types) ? ' checked="true"' : '') . '> ' . ucfirst($t) . '</label><br/>';
            }
            echo '</div><p>'.__('Select for which post types this template should be available. Default: Available for all post types.', "north").'</p></div>';
            $groups = get_editable_roles();
            $data_user_role = isset($data['user_role']) ? $data['user_role'] : array();
            echo '<div class="misc-pub-section vc_user_role">
            <div class="templatera_title"><b>' . __('Roles', "north") . '</b></div>
            <div class="input-append">
                ';
            foreach ($groups as $key => $g) {
                echo '<label><input type="checkbox"name="' . self::$meta_data_name . '[user_role][]" value="' . $key . '"' . (in_array($key, $data_user_role) ? ' checked="true"' : '') . '> ' . $g['name'] . '</label><br/>';
            }
            echo '</div><p>'.__('Select for user roles this template should be available. Default: Available for all user roles.', "north").'</p></div>';
        }

        /**
         * Url to js/css or image assets of plugin
         * @param $file
         * @return string
         */
        public function assetUrl($file)
        {
            return plugins_url($this->plugin_dir . '/assets/' . $file);
        }

        /**
         * Absolute path to assets files
         * @param $file
         * @return string
         */
        public function assetPath($file)
        {
            return $this->dir . '/assets/' . $file;
        }

        /**
         * Load required js and css files
         */
        public function assets()
        {
            wp_register_script('vc_plugin_templates', $this->assetURL('js/templates.js'), array(), time(), true);
            wp_localize_script('vc_plugin_templates', 'VcTemplateI18nLocale', array(
                'please_enter_templates_name' => __('Please enter template name', "north")
            ));
            wp_register_style('vc_plugin_template_css', $this->assetURL('css/style.css'), false, '1.0.0');
            wp_enqueue_style('vc_plugin_template_css');
        }

        /**
         * Include theme files and css classes
         */
        public function enqueueThemeFiles()
        {
            $theme = ($theme = get_option(WPBakeryVisualComposerSettings::getFieldPrefix() . 'themes')) ? $theme : '';
            if (!empty($theme)) {
                wp_register_style('vc_plugin_template_theme_css', $this->assetURL($this->themes_dir . '/' . $theme), array('js_composer_front'), 'templatera_1');
                wp_enqueue_style('vc_plugin_template_theme_css');
            }

        }

        /**
         * Adds themes css class to body tag.
         * @param $classes
         * @return array
         */
        public function addThemeBodyClass($classes)
        {
            if(!class_exists('WPBakeryVisualComposerSettings')) return $classes;
            $theme = ($theme = get_option(WPBakeryVisualComposerSettings::getFieldPrefix() . 'themes')) ? $theme : '';
            if (!empty($theme)) {
                $classes[] = 'vct_' . preg_replace('/\.css$/', '', $theme);
            }
            return $classes;
        }

        /**
         * Create templates button on navigation bar of the Visual Composer
         * @param $buttons
         * @return array
         */
        public function createButton($buttons)
        {
            $new_buttons = array();
            foreach ($buttons as $button) {
                if ($button[0] != 'templates') {
                    $new_buttons[] = $button;
                } else {
                    if (get_post_type() == self::$post_type) {

                    } else {
                        $new_buttons[] = array('custom_templates', '<ul class="vc_nav">
                                <li class="vc_dropdown">
                                    <a class="wpb_templates button"><i class="icon"></i>' . __('Templates', "north") . ' <b class="caret"></b></a>
                                    <ul class="vc_dropdown-menu wpb_templates_ul">
                                        ' . $this->getTemplateMenu() . '
                                    </ul>
                                </li>
                            </ul>');
                    }

                }
            }
            return $new_buttons;
        }

        /**
         * Create templates button on navigation bar of the Front editor.
         * @param $buttons
         * @return array
         */
        public function createFrontButton($buttons) {
            $new_buttons = array();
            foreach ($buttons as $button) {
                if ($button[0] != 'templates') {
                    $new_buttons[] = $button;
                } else {
                    if (get_post_type() == self::$post_type) {

                    } else {
                        $new_buttons[] = array('custom_templates', '
                                <li class="vc_navbar-border-right"><a href="#" class="vc_icon-btn vc_templatera_button"  id="vc-templatera-editor-button" title="'.__('Templates', 'north').'"></a></li>');
                    }

                }
            }
            return $new_buttons;
        }
        public function addEditorTemplates() {
			$dependency = vc_is_frontend_editor() ? array('vc_inline_js') : array('wpb_js_composer_js_view');
            wp_enqueue_script('vc_plugin_inline_templates', $this->assetURL('js/inline.js'), $dependency, time(), true);
			add_action('admin_footer', array(&$this, 'renderEditorTemplate'));
        }
        public function renderEditorTemplate() {
			wp_enqueue_script('vc_plugin_templates');
			$this->render($this->isNewVcVersion() ? 'new_editor' : 'editor');
        }
        /**
         * Get template path
         * @param $name - template name
         * @return string
         */
        function template($name) {
            return $this->dir.'/templates/'.$name.'.'.$this->settings['template_extension'];
        }
        /**
         * Load template
         * @param $template - get template path.
         * */
        function render($template) {
            $template = $this->template($template);
            require $template;
        }

        /**
         * List of existing templates
         * @return string
         */
        public function getList() {
            global $current_user;
            wp_get_current_user();
            $current_user_role = $current_user->roles[0];
            $output = '';
            $post = get_post(isset($_POST['post_id']) ? $_POST['post_id'] : null);
            $is_empty = true;
            $templates = get_posts(array(
                'post_type' => self::$post_type,
                'numberposts' => -1
            ));
            foreach ($templates as $template) {
                $id = $template->ID;
                $meta_data = get_post_meta($id, self::$meta_data_name, true);
                $post_types = isset($meta_data['post_type']) ? $meta_data['post_type'] : false;
                $user_roles = isset($meta_data['user_role']) ? $meta_data['user_role'] : false;
                if (
                    (!$post_types || in_array($post->post_type, $post_types))
                    && (!$user_roles || in_array($current_user_role, $user_roles))
                ) {
                    $name = $template->post_title;
                    $output .= $this->getRow($id, $name);
                    $is_empty = false;
                }
            }
            if ($is_empty) $output .= '<li class="wpb_no_templates"><span>' . __('No custom templates yet.', "north") . '</span></li>';
            return $output;
        }
        /**
         * Builds templates menu on navigation bar of the Visual Composer
         * @param bool $list_only
         * @return string
         */
        public function getTemplateMenu($list_only = false)
        {
            wp_enqueue_script('vc_plugin_templates');
            $output = '';
            if (!$list_only) $output .= '<li><ul><li class="nav-header">' . __('Save', "north") . '</li>
                        <li id="templatera_save_button"><a href="#">' . __('Save current page as a Template', "north") . '</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">' . __('Load Template', "north") . '</li>
                        </ul></li>
                        <li>
                        <ul class="wpb_templates_list" data-vc-template="list">';
            $output .= $this->getList();
            if (!$list_only) $output .= '</ul></li>';
            return $output;

        }

        /**
         * Get template content.
         */
        public function load()
        {
            $post = !empty($_POST['template_id']) ? get_post($_POST['template_id']) : false;
            if (!$post || $post->post_type!==self::$post_type) {
                die('');
            }
            echo $post->post_content;
            die();
        }
        public function loadInline() {
            $post = !empty($_POST['template_id']) ? get_post($_POST['template_id']) : false;
            if (!$post || $post->post_type!==self::$post_type) {
                die();
            }
            set_vc_is_inline();
            new_vc()->enqueueRequired();
            new_vc()->setTemplateContent($post->post_content);
            new_vc()->render('template');
            die();
        }
        /**
         * Saves new template.
         */
        public function save()
        {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $this->create($title, $content);
            echo $this->getTemplateMenu(true);
            die();
        }
        public function delete() {
            $post_id = isset($_POST['template_id']) ? $_POST['template_id'] : null;
            if(!is_null($post_id)) {
                wp_delete_post($post_id);
            }
            die();
        }
        /**
         * Saves post data in databases after publishing or updating template's post.
         * @param $post_id
         * @return bool
         */
        public function saveMetaBox($post_id)
        {
            if (get_post_type($post_id) !== self::$post_type) return true;
            if (isset($_POST[self::$meta_data_name])) {
                $options = isset($_POST[self::$meta_data_name]) ? (array)$_POST[self::$meta_data_name] : Array();
                update_post_meta((int)$post_id, self::$meta_data_name, $options);
            } else {
                delete_post_meta((int)$post_id, self::$meta_data_name);
            }

            return true;
        }

        public function loadHtml()
        {
            $id = $_POST['id'];
            $post = get_post((int)$id);
            if($post->post_type==self::$post_type) echo $post->post_content;
            die();
        }

        /**
         * Returns one template representation row.
         * @param $id
         * @param $name
         * @return string
         */
        protected function getRow($id, $name)
        {
            return '<li class="wpb_template_li"><a data-templatera_id="' . $id . '" href="#">' . $name . '</a>'
                .'<span class="wpb_remove_template" rel="' . $id . '" title="'.__('Delete template', 'north').'"><i class="icon wpb_template_delete_icon"> </i></span>'
                .'<a href="'.htmlspecialchars(admin_url('post.php?post='.$id.'&action=edit')).'" target="_blank" class="wpb_edit_template" title="'.__('Edit template', 'north').'"><i class="icon wpb_template_edit_icon"> </i></a></li>';
        }

        /**
         * Gets list of existing templates. Checks access rules defined by template author.
         * @return array
         */
        protected function getTemplateList()
        {
            global $current_user;
            get_currentuserinfo();
            $current_user_role = isset($current_user->roles[0]) ? $current_user->roles[0] : false;
            $list = array();
            $templates = get_posts(array(
                'post_type' => self::$post_type,
                'numberposts' => -1
            ));
            $post = !empty($_POST['post_id']) ? get_post($_POST['post_id']) : false;
            foreach ($templates as $template) {
                $id = $template->ID;
                $meta_data = get_post_meta($id, self::$meta_data_name, true);
                $post_types = isset($meta_data['post_type']) ? $meta_data['post_type'] : false;
                $user_roles = isset($meta_data['user_role']) ? $meta_data['user_role'] : false;
                if (
                    (!$post || !$post_types || in_array($post->post_type, $post_types))
                    && (!$current_user_role || !$user_roles || in_array($current_user_role, $user_roles))
                ) {
                    $list[$template->post_title] = $id;
                }
            }
            return $list;
        }

		/**
		 *
		 */
		public function setJsStatusValue($value) {
			$post_type = get_post_type();
			return $post_type === self::$post_type ? 'true' : $value;
		}
		/**
         * Creates new template.
         * @static
         * @param $title
         * @param $content
         * @return int|WP_Error
         */
        protected static function create($title, $content)
        {
            return wp_insert_post(array(
                'post_title' => $title,
                'post_content' => $content,
                'post_status' => 'publish',
                'post_type' => self::$post_type
            ));
        }
    }
}