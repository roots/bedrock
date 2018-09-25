<?php 

/**
 * Envato Theme Upgrader class to extend the WordPress Theme_Upgrader class.
 *
 * @package     Envato WordPress Updater
 * @author      Arman Mirkazemi, Derek Herman <derek@valendesigns.com>
 * @since       1.0
 */

include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
if ( !class_exists( 'Envato_Protected_API' ) ) {
    include_once( 'class-envato-protected-api.php' );
}

if ( class_exists( 'Theme_Upgrader' ) && ! class_exists( 'Envato_WordPress_Theme_Upgrader' ) ) {

    /**
     * Envato Wordpress Theme Upgrader class to extend the WordPress Theme_Upgrader class.
     *
     * @package     Envato WordPress Theme Upgrader Library
     * @author      Derek Herman <derek@valendesigns.com>, Arman Mirkazemi
     * @since       1.0
     */
    class Envato_WordPress_Theme_Upgrader extends Theme_Upgrader 
    {
        protected $api_key;
        protected $username;
        protected $api;
        protected $installation_feedback;
        
        public function __construct( $username, $api_key ) 
        {
            parent::__construct(new Envato_Theme_Installer_Skin($this));
        
            $this->constants();
        
            $this->installation_feedback = array();
            $this->username              = $username;
            $this->api_key               = $api_key;
            $this->api                   = new Envato_Protected_API( $this->username, $this->api_key );
        }
        
        /**
         * Checks for theme updates on ThemeForest marketplace
         *
         * @since   1.0
         * @access  public
         *
         * @param   string        Name of the theme. If not set checks for updates for the current theme. Default ''.
         * @param   bool          Allow API calls to be cached. Default true.
         * @return  object        A stdClass object.
         */ 
        public function check_for_theme_update( $theme_name = '', $allow_cache = true ) 
        {
            $result           = new stdClass();
            $purchased_themes = $this->api->wp_list_themes( $allow_cache );

            if ( $errors = $this->api->api_errors() ) 
            {
                $result->errors = array();
                foreach( $errors as $k => $v ) {
                    array_push( $result->errors , $v);
                }
            
                return $result;
            }
            
            if ( empty($theme_name) ) {
                $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme()->Name : get_current_theme();
            }
            
            $purchased_themes             = $this->filter_purchased_themes_by_name($purchased_themes, $theme_name);
            if ( function_exists( 'wp_get_themes' ) )
            	$themes_list = wp_get_themes();
            else
            	$themes_list = get_themes();
            $result->updated_themes       = $this->get_updated_themes($themes_list, $purchased_themes);
            $result->updated_themes_count = count($result->updated_themes);
            
            return $result; 
        }
      
        /**
         * Upgrades theme to its latest version
         *
         * @since   1.0
         * @access  public
         *
         * @param   string        Name of the theme. If not set checks for updates for the current theme. Default ''.
         * @param   bool          Allow API calls to be cached. Default true.
         * @return  object        A stdClass object.
         */ 
        public function upgrade_theme( $theme_name = '', $allow_cache = true ) 
        {
            $result          = new stdClass();
            $result->success = false;

            if ( empty($theme_name) ) {
                $theme_name = get_current_theme();
            }

            $installed_theme = $this->is_theme_installed($theme_name);
            
            if ($installed_theme == null) {
                $result->errors = array("'$theme_name' theme is not installed");
                return $result;  
            }

            $purchased_themes = $this->api->wp_list_themes( $allow_cache );
            $marketplace_theme_data = null;

            if ( $errors = $this->api->api_errors() ) 
            {
                $result->errors = array();
                foreach( $errors as $k => $v ) {
                    array_push( $result->errors , $v);
                }
            
                return $result;
            }
            
            foreach( $purchased_themes as $purchased ) {
                if ( $this->is_matching_themes( $installed_theme, $purchased ) && $this->is_newer_version_available( $installed_theme['Version'], $purchased->version ) ) {
                    $marketplace_theme_data = $purchased;
                    break;
                }
            }
            
            if ( $marketplace_theme_data == null ) {
                $result->errors = array( "There is no update available for '$theme_name'" );
                return $result;  
            }
            
            $result->success               = $this->do_upgrade_theme( $installed_theme['Title'], $marketplace_theme_data->item_id);
            $result->installation_feedback = $this->installation_feedback;
            
            return $result;
        }
      
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Void.
         */ 
        public function set_installation_message($message)
        {
            $this->installation_feedback[] = $message;
        }
        
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Array.
         */ 
        protected function filter_purchased_themes_by_name( $all_purchased_themes, $theme_name )
        {
            $result = $all_purchased_themes;
        
            if ( empty($theme_name) )
                return $result;
            
            for ( $i = count($result) - 1; $i >= 0; $i-- ) {
                $entry = $result[$i];
                if ( $entry->theme_name != $theme_name )
                    unset($result[$i]);
            }
            
            return $result;
        }
      
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Void.
         */ 
        protected function constants() 
        {
            define( 'ETU_MAX_EXECUTION_TIME' , 60 * 5);
        }
      
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Array.
         */ 
        protected function get_updated_themes($installed_themes, $purchased_themes)
        {
            $result = array();
        
            if ( count( $purchased_themes ) <= 0 ) {
                return $result;
            }
                
            foreach( $purchased_themes as $purchased ) 
            {
                foreach( $installed_themes as $installed => $installed_theme ) 
                {
                    if ( $this->is_matching_themes( $installed_theme, $purchased ) && $this->is_newer_version_available( $installed_theme['Version'], $purchased->version ) )
                    {
                        $installed_theme['envato-theme'] = $purchased;
                        array_push($result, $installed_theme);
                    }
                }
            }
            
            return $result;
        }
      
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Boolean.
         */ 
        protected function is_matching_themes($installed_theme, $purchased_theme)
        {
            return $installed_theme['Title'] == $purchased_theme->theme_name AND $installed_theme['Author Name'] == $purchased_theme->author_name;
        }
      
        protected function is_newer_version_available($installed_vesion, $latest_version)
        {
            return version_compare($installed_vesion, $latest_version, '<');
        }  

        protected function is_theme_installed($theme_name) 
        {
        	if ( function_exists( 'wp_get_themes' ) )
        		$installed_themes = wp_get_themes();
        	else
	            $installed_themes = get_themes();
            foreach($installed_themes as $entry) 
            {
                if (strcmp($entry['Name'], $theme_name) == 0) {
                    return $entry;
                }
            }
            return null;
        }

        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Boolean.
         */ 
        protected function do_upgrade_theme( $installed_theme_name, $marketplace_theme_id ) 
        {
            $result   = false;
            $callback = array( &$this , '_http_request_args' );

            add_filter( 'http_request_args', $callback, 10, 1 );
            $result = $this->upgrade( $installed_theme_name, $this->api->wp_download( $marketplace_theme_id ) );
            remove_filter( 'http_request_args', $callback );
            
            return $result;
        }
      
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Array.
         */ 
        public function _http_request_args($r) 
        {
            if ((int)ini_get("max_execution_time") <  ETU_MAX_EXECUTION_TIME)
            {
                set_time_limit( ETU_MAX_EXECUTION_TIME );
            }

            $r['timeout'] = ETU_MAX_EXECUTION_TIME;
            return $r;
        }    
        
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Void.
         */ 
        public function upgrade_strings() {
            parent::upgrade_strings();
            $this->strings['downloading_package'] = __( 'Downloading upgrade package from the Envato API&#8230;', 'north' );
        }
  
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Void.
         */ 
        public function install_strings() {
            parent::install_strings();
            $this->strings['downloading_package'] = __( 'Downloading install package from the Envato API&#8230;', 'north' );
        }
    
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Boolean.
         */ 
        public function upgrade( $theme, $package ) {
  
            $this->init();
            $this->upgrade_strings();
  
            $options = array(
                'package' => $package,
                'destination' => WP_CONTENT_DIR . '/themes',
                'clear_destination' => true,
                'clear_working' => true,
                'hook_extra' => array(
                    'theme' => $theme
                )
            );
  
            $this->run( $options );
  
            if ( ! $this->result || is_wp_error($this->result) )
                return $this->result;
  
            return true;
        }
    }

    /**
     * Envato Theme Installer Skin class to extend the WordPress Theme_Installer_Skin class.
     *
     * @package     Envato WordPress Theme Upgrader Library
     * @author      Arman Mirkazemi
     * @since       1.0
     */
    class Envato_Theme_Installer_Skin extends Theme_Installer_Skin {
      
        protected $envato_theme_updater;
      
        function __construct($envato_theme_updater) 
        {
            parent::__construct();
            $this->envato_theme_updater = $envato_theme_updater;
        }
      
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Void.
         */ 
        function feedback($string) 
        {
            if ( isset( $this->upgrader->strings[$string] ) )
                $string = $this->upgrader->strings[$string];
      
            if ( strpos($string, '%') !== false ) {
                $args = func_get_args();
                $args = array_splice($args, 1);
                if ( !empty($args) )
                    $string = vsprintf($string, $args);
            }
            
            if ( empty($string) )
                return;
      
            $this->envato_theme_updater->set_installation_message($string);
        }
      
        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Void.
         */ 
        function header(){}

        /**
         * @since   1.0
         * @access  internal
         *
         * @return  array         Void.
         */ 
        function footer(){}
    }
    
}

