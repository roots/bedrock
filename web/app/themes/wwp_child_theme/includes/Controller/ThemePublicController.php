<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 17/06/2016
 * Time: 09:46
 */
namespace WonderWp\Theme\Child\Controller;

use stdClass;

class ThemePublicController{

    /**
     * Style guide
     */
    public function styleGuide(){
        $title              = "Styleguide";
        $post               = new stdClass();
        $post->ID           = 0;
        $post->post_title   = $title;
        $post->post_name    = sanitize_title($title);
        $post->ancestors    = [];

        /* @var \WonderWp\Theme\Core\Service\ThemeQueryService $queryService */
        $queryService = wwp_get_theme_service('query');
        $queryService->resetPost($post);
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
