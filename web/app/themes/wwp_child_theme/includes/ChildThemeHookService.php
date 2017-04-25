<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 22/09/2016
 * Time: 11:42
 */

namespace WonderWp\Theme\Child;


use WonderWp\Theme\Core\Component\NotificationComponent;
use WonderWp\Theme\Core\ThemeHookService;

class ChildThemeHookService extends ThemeHookService
{
    public function run()
    {
        parent::run();

        //$viewService = $this->manager->getService(ServiceInterface::VIEW_SERVICE_NAME);
        //add_action( 'wwp_after_footer', array($viewService,'prepareCookies'));
        add_filter('wwp.mailer.setBody', array($this,'includeMailTemplate'));
        add_action( 'wp_footer', array($this,'loadJsonTpls'));
    }

    public function includeMailTemplate($mailBody){
        $templateContent='<body>##MAIL_CONTENT##</body>';
        $templatePath = locate_template(['/templates/mail/default.php'],false,false);
        if(file_exists($templatePath)){
            ob_start();
            include($templatePath);
            $templateContent = ob_get_contents();
            ob_end_clean();
        }
        $mailContent = str_replace('##MAIL_CONTENT##', $mailBody, $templateContent);

        return $mailContent;
    }

    public function loadJsonTpls(){
        $templates = array();

        //Notifications
        $templates['notification'] = NotificationComponent::$template;

        //Loaders
        $loaderComp = new \WonderWp\Theme\Components\Loadercomponent();
        $templates['loaders'] = $loaderComp->getTemplates();

        echo'<script type="content/json" id="jsTemplates">'.json_encode($templates).'</script>';
    }
}
