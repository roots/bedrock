<?php
/**
 * Object representing a theme, plugin or domain within core code.
 * Packages are identified uniquely by a type (e.g. "theme") and internal wordpress name, e.g. "loco-translate".
 */

namespace WonderWp\Plugin\Translator;

abstract class LocoPackage {
    
    /**
     * Internal identifier, could be name, or path, or anything in future
     * @var string
     */    
    private $handle;
    
    /**
     * Default text domain, e.g. "loco"
     * @var string
     */    
    private $domain;

    /**
     * Default domain path relative to package root, e.g. "/languages"
     * @var string
     */    
    protected $domainpath = '/languages';
    
    /**
     * Nice descriptive name, e.g. "Loco Translate"
     * @var string
     */    
    private $name;
    
    /**
     * Locales with available translations
     * @var array 
     */    
    private $locales = array();     
    
    /**
     * POT files, per domain
     * @var array
     */            
    private $pot = array();
    
    /**
     * PO files, per domain, per locale
     * @var array
     */    
    private $po = array();
    
    /**
     * Paths under which there may be source code in any of our domains
     * @var array
     */    
    private $src = array();
    
    /** 
     * Directories last modification times, used for cache invalidation
     * @var array
     */    
    private $dirs = array();
    
    /**
     * @var int
     */    
    private $mtime = 0;
    
    /**
     * number of PO or POT files present
     * @var int
     */    
    private $nfiles = 0;

    /**
     * Cached meta data 
     * @var array
     */    
    private $_meta;    

    /**
     * Get package subclass type
     * @return string theme, plugin or core
     */
    abstract public function get_type();

    /**
     * Get original data about package stored in WordPress
     */
    abstract public function get_original( $header );

    /**
     * Get primary file containing package headers 
     */
    abstract public function get_default_file();


    /**
     * Construct package from name, root and domain
     */    
    protected function __construct( $name_or_path, $domain, $name, $dpath = '' ){
        $this->handle = $name_or_path;
        $this->domain = $domain;
        $this->name = $name or $this->name = $domain;
        if( $dpath ){
            $this->domainpath = '/'.trim($dpath,'/');
        }
    }


    /**
     * Get translatable header tags
     */
    public function get_headers(){
        return array();
    }

    
    /**
     * Get default system languages directory
     */    
    public function global_lang_dir(){
        return WP_LANG_DIR;
    }


    /**
     * Test if provided path is under global lang dir 
     */    
    public function is_global_path($path){
        return 0 === strpos( $path, $this->global_lang_dir() );
    }


    /**
     * Test if package has a writable global lang dir 
     */    
    public function is_global_writable(){
        $dir = $this->global_lang_dir();
        return $dir && is_dir($dir) && is_writable( $dir );
    }

    
    /**
     * Get identifying pair of arguments for fetching this object
     * @return array
     */
    public function get_query(){
        return array (
            'name' => $this->handle,
            'type' => $this->get_type(),
        );        
    }    
    
    
    /**
     * Get package handle used for retreiving theme or plugin via wordpress functions 
     */
    public function get_handle(){
        return $this->handle;
    }    
    
    
    /**
     * Get descriptive package name
     */
    public function get_name(){
        return $this->name;
    }
    
    
    /**
     * Get all text domains with PO or POT files.
     */    
    private function get_domains(){     
        return array_unique( array_merge( array_keys($this->pot), array_keys($this->po) ) );
    }
    
    
    /**
     * Get default text domain
     */
    public function get_domain(){
        if( ! $this->domain ){
            $this->domain = $this->handle;
        }
        if( $this->domain === $this->handle ){
            // if text domain defaulted and existing files disagree, try to correct primary domain
            $candidates = $this->get_domains();
            if( $candidates && ! in_array( $this->domain, $candidates, true ) ){
                $this->domain = $candidates[0];
            }
        }
        return $this->domain;
    }    

    
    /**
     * Get time most recent PO/POT file was updated
     */
    public function get_modified(){
        return $this->mtime;
    }    
    

    /**
     * Add PO or POT file and set modified state
     */
    private function add_file( $path ){
        if( filesize($path) ){
            $this->mtime = max( $this->mtime, filemtime($path) );
            $this->nfiles++;
            $this->add_dir( dirname($path) );
            return true;
        }
    }

    
    /**
     * Add directory and remember last modification time
     */
    private function add_dir( $path ){
        if( ! isset($this->dirs[$path]) ){
            $this->dirs[$path] = filemtime($path);
        }
    }
    
    
    /**
     * find additional plugin PO under WP_LANG_DIR
     */
    private function add_lang_dir( $langdir, $domain ){      
        $pattern = $langdir.'/'.$domain.'{-*.po,.pot}';
        $nfiles = $this->nfiles;
        $files = LocoAdmin::find_grouped( $pattern, GLOB_NOSORT|GLOB_BRACE ) and
        $this->add_po( $files, $domain );
        // add $langdir if files added
        if( $nfiles !== $this->nfiles ){
            $this->add_dir( $langdir );
        }
    }
     

    
    /**
     * Add multiple locations from found PO and POT files
     * @param array file paths collected with LocoAdmin::find_po
     * @param string specific text domain to add
     * @return LocoPackage
     */
    private function add_po( array $files, $domain ){
        if( isset($files['pot']) && is_array($files['pot']) ){
            foreach( $files['pot'] as $path ){
                $key = LocoAdmin::resolve_file_domain($path) or $key = $this->get_domain();
                if( ( ! $domain || $key === $domain ) && $this->add_file($path) ){
                    $this->pot[$key] = $path;
                }
            }
        }
        if( isset($files['po']) && is_array($files['po']) ){
            foreach( $files['po'] as $path ){
                // catch namings like "default.po", "en.po" etc..
                $name = basename($path);
                if( false === strpos($name,'-') ){
                    // PO file has no locale suffix, we might need to use this as a POT if there is none
                    if( 'default' === $domain ){
                        $key = 'default'; // <- core
                    }
                    else {
                        $key = $this->get_domain();
                        if( ! isset($this->pot[$key]) ){
                            $this->pot[$key] = $path;
                            continue;
                        }
                    }
                }
                else {
                    $key = LocoAdmin::resolve_file_domain($path) or $key = $this->get_domain();
                }
                if( ! $domain || $key !== $domain ){
                    continue;
                }
                $locale = LocoAdmin::resolve_file_locale($path);
                $code = $locale->get_code() or $code = 'xx_XX';
                if( $this->add_file($path) ){
                    $this->po[ $key ][ $code ] = $path;
                }
            }
        }
        return $this;
    }    
    
    
    
    /**
     * Add any MO files for which PO files are missing
     */ 
    private function add_mo( array $files, $domain = '' ){
        foreach( $files as $mo_path ){
            $domain or $domain = LocoAdmin::resolve_file_domain($mo_path) or $domain = $this->get_domain();
            $locale = LocoAdmin::resolve_file_locale($mo_path);
            $code = $locale->get_code() or $code = 'xx_XX';
            if( isset($this->po[$domain][$code]) ){
                // PO matched, ignore this MO
                // @todo better matching as PO may not be in same location as MO
                continue;
            }
            // add MO in place of PO, but only if locale code is valid
            if( 'xx_XX' !== $code ){
                $this->add_file($mo_path) and $this->po[$domain][$code] = $mo_path;
            }
        }
    }    
    
    
    
    /**
     * Add a location under which there may be PHP source files for one or more of our domains
     * @return LocoPackage
     */        
    private function add_source( $path ){
        $this->src[] = $path;
        return $this;
    }    
    
    
    /**
     * Get most likely intended language folder
     */    
    public function lang_dir( $domain = '', $skip_global = false ){
        $dirs = array();
        // check location of POT in domain
        foreach( $this->pot as $d => $path ){
            if( ! $domain || $d === $domain ){
                if( $skip_global && $this->is_global_path($path) ){
                    continue;
                }
                $path = dirname($path);
                if( is_writable($path) ){
                    return $path;
                }
                $dirs[] = $path;
            }
        }
        // check location of all PO files in domain
        foreach( $this->po as $d => $paths ){
            if( ! $domain || $d === $domain ){
                foreach( $paths as $path ){
                    if( $skip_global && $this->is_global_path($path) ){
                        continue;
                    }
                    $path = dirname($path);
                    if( is_writable($path) ){
                        return $path;
                    }
                    $dirs[] = $path;
                }
            }
        }
        // check languages subfolder of all source file locations
        foreach( $this->src as $path ){
            if( $skip_global && $this->is_global_path($path) ){
                continue;
            }
            $pref = $path.$this->domainpath;
            if( is_writable($pref) ){
                return $pref;
            }
            if( is_writable($path) ){
                return $path;
            }
            if( is_dir($pref) ){
                $dirs[] = $pref;
            }
            else {
                $dirs[] = $path;
            }
        }
        // check global languages location
        if( ! $skip_global ){
            $path = $this->global_lang_dir();
            if( is_writable($path) ){
                return $path;
            }
            $dirs[] = $path;
        }
        // failed to get writable directory, so we'll just return the highest priority
        return array_shift( $dirs );
    }


    /**
     * Build name of PO file for given or default domain
     */
    public function create_po_path( LocoLocale $locale, $domain = '', $force_global = null ){
        if( ! $domain ){
            $domain = $this->get_domain();
        }
        // get best directory
        if( is_null($force_global) ){
            $dir = $this->lang_dir( $domain );
            $force_global = $this->is_global_path( $dir );
        }
        // else use global directory by force
        else if( $force_global ){
            $dir = $this->global_lang_dir();
        }
        // else use best, but skipping global directory
        else {
            $dir = $this->lang_dir( $domain, true );
        }
        $name = $locale->get_code().'.po';
        // core default package has no file prefix
        $type = $this->get_type();
        if( 'core' === $type && 'default' === $domain ){
            $prefix = '';
        }
        // only prefix with text domain for plugins and files in global lang directory
        else if( 'plugin' === $type || $force_global ){
            $prefix = $domain.'-';
        }
        else {
            $prefix = '';
        }
        // if PO files exist, copy their naming format and use location if writable
        if( is_null($force_global) && ! empty($this->po[$domain]) ){
            foreach( $this->po[$domain] as $code => $path ){
                $info = pathinfo( $path );
                $prefix = str_replace( $code.'.'.$info['extension'], '', $info['basename'] );
                if( is_writable($info['dirname']) ){
                    $dir = $info['dirname'];
                    break;
                }
            }
        }
        return $dir.'/'.$prefix.$name;
    }
        
    
    /**
     * Get root of package
     */
    public function get_root(){
        foreach( $this->src as $path ){
            return $path;
        }
        return WP_LANG_DIR;        
    }   
    
    
    /**
     * Get all PO an POT files
     */
    public function get_gettext_files(){
        $files = array();
        foreach( $this->pot as $domain => $path ){
            $files[] = $path;
        }
        foreach( $this->po as $domain => $paths ){
            foreach( $paths as $path ){
                $files[] = $path;
            }
        }
        return $files;
    }
     
    
    /**
     * Check PO/POT paths are writable.
     * Called when generating root list view for simple error indicators.
     */    
    public function check_permissions(){
        $dirs = array();
        foreach( $this->pot as $path ){
            $dirs[ dirname($path) ] = 1;
            if( ! is_writable($path) ){
                throw new \Exception( Loco::__('Some files not writable') );
            }
        }
        foreach( $this->po as $paths ){
            foreach( $paths as $path ){
                $dirs[ dirname($path) ] = 1;
                if( ! is_writable($path) ){
                    throw new \Exception( Loco::__('Some files not writable') );
                }
                if( ! file_exists( preg_replace('/\.po$/', '.mo', $path) ) ){
                    throw new \Exception( Loco::__('Some files missing') );
                }
            }
        }
        $dir = $this->lang_dir();
        if( ! is_writable($dir) ){
            throw new \Exception( sprintf( Loco::__('"%s" folder not writable'), basename($dir) ) );
        }
        foreach( array_keys($dirs) as $path ){
            if( ! is_writable($path) ){
                throw new \Exception( sprintf( Loco::__('"%s" folder not writable'), basename($dir) ) );
            }
        }
    }    
    
    
    /**
     * Get file permission for every important file path in package 
     */
    public function get_permission_errors(){
        $dirs = array();
        // add common directories
        $base = $this->get_root();
        $dirs[ $base ] = 1;
        $dirs[ $base.$this->domainpath ] = 1;
        $dirs[ $this->lang_dir() ] = 1;
        $dirs[ $this->global_lang_dir() ] = 1;
        // add and check files, collecting additional directories along the way
        $paths = array();
        foreach( $this->pot as $path ){
            $dirs[ dirname($path) ] = 1;
            $paths[$path] = is_writable($path) ? '' : Loco::__('POT file not writable');
        }
        foreach( $this->po as $pos ){
            foreach( $pos as $path ){
                $dirs[ dirname($path) ] = 1;
                $paths[$path] = is_writable($path) ? '' : Loco::__('PO file not writable');
                $path = preg_replace('/\.po$/', '.mo', $path );
                $paths[$path] = file_exists($path) ? ( is_writeable($path) ? '' : Loco::__('MO file not writable') ) : Loco::__('MO file not found');
            }
        }
        // run directory checks and sort final list alphabetically
        foreach( array_keys($dirs) as $dir ){
            $paths[$dir] = is_writable($dir) ? '' : ( is_dir($dir) ? Loco::__('Folder not writable') : Loco::__('Folder not found') );
        }
        ksort( $paths );
        return $paths;    
    }   


    /**
     * Get package errors, or things that may cause problems displaying translations
     */
    public function get_author_warnings(){
        $warn = array();
        $type = $this->get_type();
        if( 'core' !== $type ){
            $camelType = strtoupper($type{0}).substr($type,1);
            // check package declares Text Domain
            $domain = $this->get_original('TextDomain');
            if( ! $domain ){
                $domain = $this->get_domain();
                $warn[] = sprintf(Loco::__('%s does not declare a "Text Domain"'),$camelType).' .. '.sprintf(Loco::__('Loco has guessed "%s"'), $domain );
            }
            // check package declares "Domain Path"
            $path = $this->get_original('Domain Path');
            if( ! $domain ){
                $warn[] = sprintf(Loco::__('%s does not declare a "Domain Path"'),$camelType).' .. '.sprintf(Loco::__('Loco has guessed "%s"'), $this->domainpath );
            }
            // check POT exists and looks correct
            $path = $this->get_pot($domain);
            if( ! $path ){
                $warn[] = sprintf( Loco::__('%s has no POT file. Create one at "%s/%s.pot" if you need one.'), $camelType, $this->domainpath, $domain );
            }
            else if( $domain.'.pot' !== basename($path) ){
                $warn[] = sprintf(Loco::__('%s has a strange POT file name (%s). A better name would be "%s.pot"'), $camelType, basename($path), $domain );
            }
            // TODO check references to other domains in xgettext
        }
        // Check if any locale codes are not an official WordPress languages
        $meta = $this->meta();
        foreach( $meta['po'] as $po_data ){
            $wplang = $po_data['locale']->get_code() or $wplang = $po_data['locale']->get_name();
            if( ! LocoLocale::is_valid_wordpress($wplang) ){
                $warn[] = sprintf( Loco::__('%s is not an official WordPress language'), $wplang );
            }
        }
        return $warn;
    }     
    
    
    /**
     * Fetch POT file for given, or default domain
     * @return string
     */    
    public function get_pot( $domain = '' ){
        if( ! $domain ){
            $domain = $this->get_domain();
        }
        if( ! empty($this->pot[$domain]) ){
            return $this->pot[$domain];
        }
        // no POT, but some authors may use PO files incorrectly as a template
        if( isset($this->po[$domain]) ){
            foreach( array('','xx_XX','en_US','en_GB','en_EN') as $try ){
                if( isset($this->po[$domain][$try]) ){
                    $pot = $this->po[$domain][$try];
                    unset( $this->po[$domain][$try] );
                    return $this->pot[$domain] = $pot;
                }
            }
        }
        // no template candidate
        return '';
    }
    

    /**
     * Check if given path is one of the package's POT files
     * @return string related text domain if valid POT, else false
     */    
    public function is_pot( $path ){
        return array_search( $path, $this->pot, true );
    }    
    
    
    
    /**
     * Fetch PO paths indexed by locale for given, or default domain
     * @return array
     */
    public function get_po( $domain = '' ){
        if( ! $domain ){
            $domain = $this->get_domain();
        }
        return isset($this->po[$domain]) ? $this->po[$domain] : array();
    }
    
    

    /**
     * Find all source files, currently only PHP
     */    
    public function get_source_files(){
        $found = array();
        foreach( $this->src as $dir ){
            foreach( LocoAdmin::find_php($dir) as $path ){
                $found[] = $path;
            }
        }
        return $found;
    }    
    
    
    /**
     * Get all source root directories
     */
    public function get_source_dirs( $relative_to = '' ){
        if( ! $relative_to ){
            return $this->src;
        }
        // calculate path from location of given file (which may not exist)
        if( pathinfo($relative_to,PATHINFO_EXTENSION) ){
            $relative_to = dirname($relative_to);
        }
        $dirs = array();
        foreach( $this->src as $target_dir ){
            $dirs[] = loco_relative_path( $relative_to, $target_dir );
        }
        return $dirs;
    }
    
    
    /**
     * Test if package has any source directories
     */
    public function has_source_dirs(){
        return ! empty( $this->src );
    }
    
    
    /**
     * Export meta data used by templates.
     * @return array
     */
    public function meta(){
        if( ! is_array($this->_meta) ){
            $pot = $po = array();
            // get POT files for all domains, fixing incorrect PO usage
            foreach( $this->get_domains() as $domain ){
                $path = $this->get_pot( $domain ) and
                $pot[] = compact('domain','path');
            }
            // get progress and locale for each PO file
            foreach( $this->po as $domain => $locales ){
                foreach( $locales as $code => $path ){
                    try {
                        unset($headers);    
                        $export = LocoAdmin::parse_po_with_headers( $path, $headers );
                        $po[] = array (
                            'path'   => $path,
                            'domain' => $domain,
                            'name'   => trim( str_replace( array('.po','.mo',$domain), array('','',''), basename($path) ), '-_'),
                            'stats'  => loco_po_stats( $export ),
                            'length' => count( $export ),
                            'locale' => loco_locale_resolve($code),
                            'projid' => trim( $headers->{'project-id-version'} ),
                        );
                    }
                    catch( \Exception $Ex ){
                        continue;
                    }
                }
            }
            $this->_meta = compact('po','pot') + array(
                'name' => $this->get_name(),
                'root' => $this->get_root(),
                'domain' => $this->get_domain(),
            );
        }
        return $this->_meta;
    }    



    /**
     * Clear this package from the cache. Called to invalidate when something updates
     * @return LocoPackage
     */
    public function uncache(){
        $key = $this->get_type().'_'.$this->handle;
        Loco::uncache( $key );
        $this->_meta = null;
        return $this;
    }


    /**
     * Invalidate cache based on last modification of directories
     * @return bool whether cache should be invalidated
     */
    private function invalidate(){
        foreach( $this->dirs as $path => $mtime ){
            if( ! is_dir($path) || filemtime($path) !== $mtime ){
                return true;
            }
        }
    }


    /**
     * Construct package object from theme data
     * @return LocoPackage
     */
    private static function get_theme( $handle ){
        $theme = wp_get_theme( $handle );
        if( $theme && $theme->exists() ){
            $name = $theme->get('Name');
            $domain = $theme->get('TextDomain') or $domain = $handle;
            // create theme package with text domain defaulting to template name
            $package = new LocoThemePackage( $handle, $domain, $name, $theme->get('DomainPath') );
            $root = $theme->get_theme_root().'/'.$handle;
            $package->add_source( $root );
            // add PO and POT under theme root
            if( $pofiles = LocoAdmin::find_po($root) ){
                $package->add_po( $pofiles, $domain );
            }
            // pick up any MO files that have missing PO
            if( $mofiles = LocoAdmin::find_mo($root) ){
                $package->add_mo( $mofiles, $domain );
            }
            // find additional theme PO under WP_LANG_DIR/themes unless a child theme
            $package->add_lang_dir(  WP_LANG_DIR.'/themes', $domain );
            // child theme inherits parent, but keeps its own domain
            if( $parent = $theme->get_template() ){
                if( $parent !== $handle ){
                    $package->inherit( $parent );
                }
            }
            // fall back to all POT matches if no exact domain match
            if( ! $package->pot ){
                unset( $pofiles['po'] );
                $package->add_po( $pofiles, null );
            }
            return $package;
        }
    }    
    
    
    /**
     * Construct package object from plugin array
     * note that handle is file path for plugins in WordPress
     */
    private static function get_plugin( $handle ){
        $plugins = get_plugins();
        if( isset($plugins[$handle]) && is_array($plugins[$handle]) ){
            $plugin = $plugins[$handle];
            $domain = $plugin['TextDomain'] or $domain = str_replace('/','-',dirname($handle));
            if( '.' === $domain ){
                // single-file plugin has no directory to take a domain from 
                $domain = substr( basename($handle),0,-4);
            }
            $package = new LocoPluginPackage( $handle, $domain, $plugin['Name'], $plugin['DomainPath'] );
            // single-file plugins have no root, or anywhere to save POT file.
            if( false !== strpos($handle,'/') ){
                $root = WP_PLUGIN_DIR.'/'.dirname($handle);
                $package->add_source( $root );
                // add PO and POT under plugin root
                if( $pofiles = LocoAdmin::find_po($root) ){
                    $package->add_po( $pofiles, $domain );
                }
                // pick up any MO files that have missing PO
                if( $mofiles = LocoAdmin::find_mo($root) ){
                    $package->add_mo( $mofiles, $domain );
                }
            }
            // find additional plugin PO under WP_LANG_DIR/plugin
            $package->add_lang_dir(  WP_LANG_DIR.'/plugins', $domain );
            // fall back to all POT matches if no exact domain match
            if( ! $package->pot && isset($pofiles) ){
                unset( $pofiles['po'] );
                $package->add_po( $pofiles, null );
            }
            return $package;
        }
    }


    /**
     * construct a core package object from name
     * @return LocoPackage
     */
    private static function get_core( $handle ){
        static $grouped;
        if( ! isset($grouped) ){
            $grouped = array();
            foreach( LocoAdmin::find_grouped( WP_LANG_DIR.'/*{.po,.pot}', GLOB_NOSORT|GLOB_BRACE ) as $ext => $files ){
                foreach( $files as $path ){
                    $domain = LocoAdmin::resolve_file_domain( $path );
                    $grouped[ $domain ][ $ext ][] = $path;
                }
            }
        }
        $domain = $handle or $domain = 'default';
        $package = new LocoCorePackage( $handle, $domain, '' );
        if( isset($grouped[$handle]) ){
            // add PO file and POT files for this component          
            $package->add_po( $grouped[$handle], $domain );
            // get name from po file
            $meta = $package->meta();
            foreach( $meta['po'] as $pmeta ){
                if( $pmeta['projid'] ){
                    $package->name = $pmeta['projid'];
                }
            }
            // disable source directories as Core packages cannot be synced
            $package->src = array();
        }
        return $package;
    }



    /**
     * Get all core pseudo packages
     */
    public static function get_core_packages(){
        static $names = array( '', 'admin', 'admin-network', 'continents-cities', 'ms' );
        $packages = array();
        foreach( $names as $handle ){
            $packages[$handle] = self::get( $handle, 'core' );
        }
        return $packages;
    }   
     
    
    
    /**
     * Get a package - from cache if possible
     * @param string unique name or identifier known to WordPress
     * @param string "core", "theme" or "plugin"
     * @return LocoPackage
     */
    public static function get( $handle, $type ){
        $key = $type.'_'.$handle;
        $package = Loco::cached($key);
        if( $package instanceof LocoPackage ){
            if( $package->invalidate() ){
                $package = null;
            }
        }
        if( ! $package instanceof LocoPackage ){
            $getter = array( __CLASS__, 'get_'.$type );
            $package = call_user_func( $getter, $handle );
            if( $package ){
                $package->meta();
                Loco::cache( $key, $package );
            }
        }
        return $package;
    }    
    
    
    
    /**
     * @internal
     */
    private static function _sort_modified( LocoPackage $a, LocoPackage $b ){
        $a = $a->get_modified();
        $b = $b->get_modified();
        if( $a > $b ){
            return -1;
        }
        if( $b > $a ){
            return 1;
        }
        return 0;
    }      
    
    
    /**
     * Sort packages according to most recently updated language files
     */    
    public static function sort_modified( array $packages ){
        static $sorter = array( __CLASS__, '_sort_modified' );
        usort( $packages, $sorter );        
        return $packages;
    }    
    
    
    
}


/**
 * Extended package class for themes
 */
class LocoThemePackage extends LocoPackage {
    private $parent;
    public function global_lang_dir(){
        return WP_LANG_DIR.'/themes';
    }
    protected function inherit( $template ){
        $parent = wp_get_theme( $template );
        if( $parent && $parent->exists() ){
            $this->parent = $template;
        }
    }
    protected function is_child(){
        return ! empty($this->parent);
    }
    protected function get_parent(){
        return $this->parent ? LocoPackage::get( $this->parent, 'theme' ) : null;
    }
    public function meta(){
        $meta = parent::meta();
        if( $parent = $this->get_parent() ){
            $pmeta = $parent->meta();
            $meta['parent'] = $parent->get_name();
            // merge parent resources unless child has its own domain
            if( $meta['domain'] === $pmeta['domain'] ){
                $meta['po'] = array_merge( $meta['po'], $pmeta['po'] );
                $meta['pot'] = array_merge( $meta['pot'], $pmeta['pot'] );
            }
        }
        return $meta;
    }
    public function check_permissions(){
        parent::check_permissions();
        if( $parent = $this->get_parent() ){
            $parent->check_permissions();
        }
    }
    public function get_permission_errors(){
        $paths = parent::get_permission_errors();
        // check parent theme if exists
        if( $parent = $this->get_parent() ){
            // recurse if child theme uses same domain as parent
            if( $this->get_domain() === $parent->get_domain() ){
                $paths += $parent->get_permission_errors( true );
            }
        }
        return $paths;
    }
    public function get_pot( $domain = '' ){
        if( ( $parent = $this->get_parent() ) && ( $pot = $parent->get_pot($domain) ) ){
            return $pot;
        }
        return parent::get_pot( $domain );
    }
    public function get_type(){
        return 'theme';
    }      
    public function get_original( $tag ){
        $theme = wp_get_theme( $this->get_handle() );
        return $theme->get( $tag );
    }
    public function get_headers(){
        $headers = array();
        $theme = wp_get_theme( $this->get_handle() );
        foreach( array('Name','ThemeURI','Description','Author','AuthorURI') as $tag ){
            $headers[$tag] = $theme->get($tag) or $headers[$tag] = '';
        }
        return $headers;
    }
    public function get_default_file(){
        return $this->get_root().'/style.css';
    }
}


/**
 * Extended package class for plugins
 */
class LocoPluginPackage extends LocoPackage {
    public function global_lang_dir(){
        return WP_LANG_DIR.'/plugins';
    }
    public function get_type(){
        return 'plugin';
    }      
    public function get_original( $tag ){
        $plugins = get_plugins();
        $plugin = $plugins[ $this->get_handle() ];
        return isset($plugin[$tag]) ? $plugin[$tag] : '';
    }
    public function get_headers(){
        $headers = array();
        $plugins = get_plugins();
        $plugin = $plugins[ $this->get_handle() ];
        foreach( array('Name','PluginURI','Description','Author','AuthorURI') as $tag ){
            $headers[$tag] = isset($plugin[$tag]) ? $plugin[$tag] : '';
        }
        return $headers;
    }
    public function get_default_file(){
        return WP_PLUGIN_DIR.'/'.$this->get_handle();
    }
}


/**
 * Extended package class for core pseudo packages
 */
class LocoCorePackage extends LocoPackage {
    protected $domainpath = '';
    public function get_type(){
        return 'core';
    }      
    public function get_original( $header ){
        return null;
    }
    public function get_default_file(){
        return null;
    }
}

