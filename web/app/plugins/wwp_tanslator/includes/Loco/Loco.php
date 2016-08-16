<?php

namespace WonderWp\Plugin\Translator;

/**
 * Loco | bootstraps plugin when it's needed.
 * Top-level Loco class holds some basic utilities
 */
abstract class Loco {

    /** plugin namespace */
    const NS = 'wonderwp-trads';

    /** plugin version */ 
    const VERSION = '1.5.5';
    
    /* current plugin locale */
    private static $locale;

    /* whether to enable APC cache */
    public static $apc_enabled;

    /* whether to enable the cache at all  */
    public static $cache_enabled;

    /* call WordPress __ with our text domain  */
    public static function __( $msgid = '' ){
        return __( $msgid, self::NS );
    }

    /* call WordPress _n with our text domain  */
    public static function _n( $msgid = '', $msgid_plural = '', $n = 0 ){
        return _n( $msgid, $msgid_plural, $n, self::NS );
    }

    /* call WordPress _x with our text domain  */
    public static function _x( $msgid = '', $msgctxt = '', $n = 0 ){
        return _x( $msgid, $msgctxt, self::NS );
    }
    
    
    /**
     * Bootstrap localisation of self
     */
    public static function load_textdomain( $locale = null ){
        if( is_null($locale) ){
            $locale = get_locale();
        }
        if( ! $locale || 0 === strpos($locale,'en') ){
            self::$locale and unload_textdomain( Loco::NS );
            $locale = 'en_US';
        }
        else if( self::$locale !== $locale ){
            $plugin_rel_path = basename( self::basedir() );
            load_plugin_textdomain( Loco::NS, false, $plugin_rel_path.'/languages' );
        }
        // detect changes in plugin locale, binding once only
        isset(self::$locale) or add_filter( 'plugin_locale', array(__CLASS__,'filter_plugin_locale'), 10 , 2 );
        self::$locale = $locale;
    }
    
    
    
    /**
     * Listen for change in plugin locale
     */
    public static function filter_plugin_locale( $locale, $domain ){
        if( self::NS !== $domain && $locale !== self::$locale ){
            self::load_textdomain( $locale );
        }
        return $locale;
    }
    
    
    
    /**
     * Get path to this file, accounting for symlink problem
     */
    private static function __file(){
        $here = __FILE__;
        if( 0 !== strpos( WP_PLUGIN_DIR, $here ) ){
            // something along this path has been symlinked into the document tree
            $name = basename( dirname( dirname(dirname($here)) ) );
            $here = WP_PLUGIN_DIR.'/'.$name.'/lib/loco-boot.php';
        }
        return $here;
    }     
    
    
    /**
     * Get plugin local base directory in case __DIR__ isn't available (php<5.3)
     */
    public static function basedir(){
        static $dir;
        isset($dir) or $dir = dirname( dirname( self::__file() ) );
        return $dir;    
    }
    
    
    /**
     * Get plugin base URL path.
     */
    public static function baseurl(){
        static $url;
        isset($url) or $url = plugins_url( '', self::basedir().'/loco.php' );
        return $url;
    }
    

    /**
     * Simple template renderer
     */
    public static function render( $tpl, array $arguments = array() ){
        extract( $arguments );
        include Loco::basedir().'/admin/pages/'.$tpl.'.tpl.php';
    }

 
    /**
     * replacement for bloated esc_html function
     */ 
    public static function html( $text ){
        return htmlspecialchars( $text, ENT_COMPAT, 'UTF-8' );
    }
    
    
    /**
     * html output printer with printf built-in
     */
    public static function h( $text, $_ = null ){
        if( isset($_) ){
            $args = func_get_args();
            $text = call_user_func_array('sprintf', $args );
        }
        echo self::html( $text );
        return '';
    }    
    
    
    /**
     * Abstract enquement of JavaScript
     */
    public static function enqueue_scripts(){
        static $v, $i = 0;
        $stubs = func_get_args();
        if( ! isset($v) ){
            $v = WP_DEBUG ? time() : Loco::VERSION;
            // enqueue JavaScript translations once
            $trans = 'lang/dummy';
            $locale = get_locale() and
                0 !== strpos( $locale, 'en' ) and 
                    file_exists( Loco::basedir().'/pub/js/lang/'.Loco::NS.'-'.$locale.'.js' ) and
                        $trans = 'lang/'.Loco::NS.'-'.$locale;
            array_unshift( $stubs, $trans );
        }
        foreach( $stubs as $stub ){
            $js = Loco::baseurl().'/pub/js/'.$stub.'.js';
            $id = self::NS.'-js-'.( ++$i );
            wp_enqueue_script( $id, $js, array('jquery'), $v, true );
        }
    }
    
    
    
    /**
     * Abstract enquement of Stylesheets
     */
    public static function enqueue_styles(){
        static $v, $i = 0;
        isset($v) or $v = WP_DEBUG ? time() : Loco::VERSION;
        foreach( func_get_args() as $stub ){
            $css = Loco::baseurl().'/pub/css/'.$stub.'.css';
            wp_enqueue_style( self::NS.'-css-'.(++$i), $css, array(), $v );
        }
    }
    
    
    
    /**
     * 
     */
    public static function utm_query( $utm_medium ){
        $utm_campaign = 'wp';
        $utm_source = 'wp-admin';
        $utm_content = Loco::VERSION;
        return http_build_query( compact('utm_campaign','utm_medium','utm_content','utm_source') );
    }
    
    
    
    /**
     * Get actual postdata, not hacked postdata WordPress ruined with wp_magic_quotes
     * @return array
     */
    public static function postdata(){
        static $post;
        if( ! is_array($post) ){
            // Not using WordPress's hacked POST collection.
            $str = file_get_contents('php://input') or 
            // preferred way is to parse original data
            $str = isset($_SERVER['HTTP_RAW_POST_DATA']) ? $_SERVER['HTTP_RAW_POST_DATA'] : '';
            if( $str ){
                parse_str( $str, $post );
            }
            // fall back to undoing WordPress 'magic'
            else {
                $post = stripslashes_deep( $_POST );
            }
        }
        return $post;
    }    
    
    
    
    /**
     * Abstraction of cache retrieval, using apc where possible
     * @return mixed 
     */
    public static function cached( $key ){
        if( ! self::$cache_enabled ){
            return null;
        }
        $key = self::cache_key($key);
        if( self::$apc_enabled ){
            return apc_fetch( $key );
        }
        return get_transient( $key );
    } 



    /**
     * Abstraction of cache storage, using apc where possible
     * @return void
     */
     public static function cache( $key, $value, $ttl = 0 ){
        if( ! self::$cache_enabled ){
            return;
        }
        $key = self::cache_key($key);
        if( self::$apc_enabled ){
            apc_store( $key, $value, $ttl );
            return;
        }
        if( ! $ttl ){
            // WP would expire immediately as opposed to never
            $ttl = 31536000;
        }
        set_transient( $key, $value, $ttl );
    }    
     
     
    /**
     * Abstraction of cache removal
     * @return void
     */ 
    public static function uncache( $key ){
        $key = self::cache_key($key);
        if( self::$apc_enabled ){
            apc_delete( $key );
            return;
        }
        delete_transient( $key );
    }     

     
     
    /**
     * Sanitize a cache key
     */    
    private static function cache_key( $key ){
        static $prefix;
        if( ! isset($prefix) ){
            $prefix = 'loco_'.str_replace('.','_',Loco::VERSION).'_';
        }
        $key = $prefix.preg_replace('/[^a-z]+/','_', strtolower($key) );
        if( isset($key{45}) ){
            $key = 'loco_'.md5($key);
        }        
        return $key;
    }
    
    
    /**
     * Plugin option getter/setter
     */
    public static function config( array $update = array() ){
        static $conf;
        if( ! isset($conf) ){
            $conf = array (
                // whether to use external msgfmt command (1), or internal (default)
                'use_msgfmt' => false,
                // which external msgfmt command to use
                'which_msgfmt' => '',
                // whether to compile hash table into MO files
                'gen_hash' => '0',
                // whether to include Fuzzy strings in MO files
                'use_fuzzy' => '1',
                // number of backups to keep of PO and MO files
                'num_backups' => '1',
                // whether to enable core package translation
                'enable_core' => '0',
            );
            foreach( $conf as $key => $val ){
                $conf[$key] = get_option( Loco::NS.'-'.$key);
                if( ! is_string($conf[$key]) ){
                    $conf[$key] = $val;
                }
            }
        }
        foreach( $update as $key => $val ){
            if( isset($conf[$key]) ){
                update_option( Loco::NS.'-'.$key, $val );
                $conf[$key] = $val;
            }
        }
        // force msgfmt usage if path is set (legacy installs/upgrades)
        if( false === $conf['use_msgfmt'] ){
            $conf['use_msgfmt'] = $conf['which_msgfmt'] ? '1' : '0';
        }
        return $conf;
    }    


    /**
     * Get WordPress capability for all Loco Admin functionality
     */
    public static function admin_capablity(){
        return apply_filters( 'loco_admin_capability', 'manage_options' );
    }

}




// minimum config
Loco::$cache_enabled = apply_filters( 'loco_cache_enabled', ! WP_DEBUG ) and
Loco::$apc_enabled = function_exists('apc_fetch') && ini_get('apc.enabled');
Loco::load_textdomain();

