<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 09:46
 */

namespace WonderWp\Theme\Child;

use WonderWp\Framework\Shortcode\AbstractShortcodeService;

class ThemeShortcodeService extends AbstractShortcodeService{

    public function registerShortcodes()
    {
        add_shortcode( 'getSvgIcon', function($atts){
            if(!empty($atts['icon'])){
                return self::getSvgIcon($atts['icon']);
            }
        });
    }

    public static function getSvgIcon($iconName){
        $pathToSymbol = get_stylesheet_directory_uri().'/assets/final/svg/symbol/svg/sprite.symbol.svg';
        return '<svg class="shape-svg shape-'.$iconName.'">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$pathToSymbol.'#'.$iconName.'"></use>
        </svg>';
    }

}
