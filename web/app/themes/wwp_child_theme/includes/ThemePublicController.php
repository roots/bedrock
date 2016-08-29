<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 17/06/2016
 * Time: 09:46
 */
namespace WonderWp\Theme;

class ThemePublicController{

    /**
     * Style guide
     */
    public function styleGuide(){
        get_template_part('/styleguide/index');
        die();
    }

    /**
     * Sitemap
     */
    public function siteMap(){
        get_template_part('/templates/sitemap');
        die();
    }

}