<?php
namespace WonderWp\Plugin\Translator;

/**
 * Match locale to code at end of string.
 * @param string e.g. "something-fr_FR"
 * @return LocoLocale
 */
function loco_locale_resolve( $s ){
    $lc = '';
    $cc = '';
    if( preg_match('/(?:^|\W)([a-z]{2,3})(?:(?:-|_)([a-z]{2}))?$/i', $s, $r ) ){
        $lc = strtolower($r[1]);
        if( isset($r[2]) ){
            $cc = strtoupper($r[2]);
            // handle situation when short domain part looks like language
            if( ! LocoLocale::is_known_language($lc) && LocoLocale::is_known_language($cc) ){
                $lc = strtolower($cc);
                $cc = '';
            }
        }
    }
    return LocoLocale::init( $lc, $cc );
}

/**
 * Include a component from lib subdirectory
 * @param string $subpath e.g. "loco-admin"
 * @return mixed value from last included file
 */
function loco_require(){
    static $dir;
    isset($dir) or $dir = dirname(__FILE__);
    $ret = '';
    foreach( func_get_args() as $subpath ){
        $ret = require_once $dir.'/'.$subpath.'.php';
    }
    return $ret;
}