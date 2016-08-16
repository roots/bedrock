<?php
/**
 * Loco locale utilities
 */

namespace WonderWp\Plugin\Translator;

/**
 * Locale object
 */ 
final class LocoLocale {

    private $lang;
    private $region;
    private $label;
    private $plurals = array('one','other');
    private $nplurals = 2;
    private $pluraleq = 'n != 1';

    private function __construct( $lc, $cc ){
        $lc and $this->lang = strtolower($lc);
        $cc and $this->region = strtoupper($cc);
    }

    public function export(){
        $data = get_object_vars($this);
        $this->region or $data['region'] = self::default_region($this->lang);
        $data['icon'] = $this->icon_class();
        return $data;
    }
    
    public function __toString(){
        $str = $this->get_name();
        if( $code = $this->get_code() ){
            $str = $code.', '.$str;
        }
        return $str;
    }
    
    public function get_code(){
        return $this->lang && $this->region ? $this->lang.'_'.$this->region : ( $this->lang ? $this->lang : '' ) ;
    }
    
    public function icon_class(){
        $cc = $this->region or $cc = self::default_region($this->lang);
        if( $cc ){
            return 'flag flag-'.strtolower($cc).' lang-'.$this->lang;
        }
        return 'lang lang-'.$this->lang;
    }
    
    public function get_name(){
        return empty($this->label) ? Loco::__('Unknown language') : $this->label;
    }
    
    public function equal_to( LocoLocale $locale ){
        return $this->get_code() === $locale->get_code();
    }
    
    public function preg( $delimiter = '/' ){
        $lc = preg_quote( $this->lang, $delimiter );
        $cc = preg_quote( $this->region, $delimiter );
        return $lc.'(?:[\-_]'.$cc.')?';
    }



    /**
     * @return LocoLocale
     */
    public static function init( $lc, $cc ){
        extract( self::data() );
        if( ! $cc ){
            if( self::is_regionless($lc) ){
                // WordPress expects this locale to be regionless
                $cc = '';
            }
            else {
                $cc = self::default_region($lc);
            }
        }
        $label = '';
        $locale = new LocoLocale( $lc, $cc );
        // get locale name from official WordPress list
        if( isset($locales[$lc][$cc]) ){
            $locale->label = $locales[$lc][$cc];
        }
        // get plural rules from iso 639 language and set label if common locale wasn't known
        if( isset($langs[$lc]) ){
            list( $label, $pluraleq, $plurals ) = $langs[$lc];
            $locale->pluraleq = $pluraleq;
            $locale->plurals = $plurals;
            $locale->nplurals = count( $plurals );
        }
        // get country just for label if not already applied from common locale combo
        if( ! $locale->label ){
            if( $cc ){
                if( isset($regions[$cc]) ){
                    $label = $label ? $label.' ('.$regions[$cc].')' : $regions[$cc];
                }
                else {
                    $label = $label ? $label.' ('.$cc.')' : '';
                }
            }
            $locale->label = $label;
        }
        return $locale;
    }



    /**
     * @return array
     */
    private static function data(){
        static $data;
        if( ! isset($data) ){
            // this must be the first include of this file to ensure it returns
            $data = loco_require('build/locales-compiled');
        }
        return $data;
    }
    
    
    
    /**
     * Get names of all common locales indexed by xx_YY code
     * @return array
     */
    public static function get_names(){
        static $names = array();
        if( ! $names ){
            $data = self::data();
            foreach( $data['locales'] as $lc => $regions ){
                foreach( $regions as $cc => $label ){
                    if( '' === $cc ){
                        $names[$lc] = $label;
                    }
                    else {
                        $names[$lc.'_'.$cc] = $label;
                    }
                }
            }
            asort($names,SORT_ASC|SORT_STRING);
        }
        return $names;
    }
    
    
    
    /**
     * Test whether a language code is considered regionless by WordPress core. 
     * example: Thai is not "th_TH" but only "th"
     */
    public static function is_regionless( $lc ){
        $data = self::data();
        return isset($data['locales'][$lc]['']);
    }

    
    
    /**
     * Alias to loco_language_country
     */
    public static function default_region( $lang ){
        self::data();
        if( 'en' === $lang ){
            return 'US';
        }
        return loco_language_country( $lang );
    }
    
    
    /**
     * Test if locale code is strictly a valid WordPress locale
     */
    public static function is_valid_wordpress( $code ){
        if( ! preg_match('/^[a-z]{2,3}(?:_[A-Z]{2})?$/', $code, $r ) ){
            return false;
        }
        $names = self::get_names();
        return isset( $names[$r[0]] );
    }
    
    
    /**
     * Test if code is a valid language code
     * This includes all two character languages in ISO-639, plus any three character codes used by WordPress
     */
    public static function is_known_language( $code ){
        $data = self::data();
        $code = strtolower($code);
        return isset($data['langs'][$code]);
    }
    
    
    /**
     * Test if code is a known region
     * This includes all two character languages in ISO-3166
     */
    public static function is_known_region( $code ){
        $data = self::data();
        $code = strtoupper($code);
        return isset($data['regions'][$code]);
    }
         
}

 






 