<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 17/06/2016
 * Time: 09:46
 */
namespace WonderWp\Theme;

class ThemePublicController{

    public function styleGuide(){
        get_template_part('/styleguide/index');
        die();
    }

}