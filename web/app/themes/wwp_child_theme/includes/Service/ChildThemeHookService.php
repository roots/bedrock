<?php

namespace WonderWp\Theme\Child\Service;

use Symfony\Component\HttpFoundation\Cookie;
use WonderWp\Framework\HttpFoundation\Request;
use WonderWp\Theme\Child\Components\Loader\Loadercomponent;
use WonderWp\Theme\Core\Component\NotificationComponent;
use WonderWp\Theme\Core\Service\ThemeHookService;

class ChildThemeHookService extends ThemeHookService
{
    public function run()
    {
        parent::run();

        //$viewService = $this->manager->getService(ServiceInterface::VIEW_SERVICE_NAME);
        //add_action( 'wwp_after_footer', array($viewService,'prepareCookies'));
        add_filter('wwp.mailer.setBody', array($this,'includeMailTemplate'));
        add_action( 'wp_footer', array($this,'loadJsonTpls'));
        //Disable visual editor
        add_filter('user_can_richedit', '__return_false', 50);
        add_action('wp_loaded', [$this, 'setHasCookie']);
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
        $loaderComp = new Loadercomponent();
        $templates['loaders'] = $loaderComp->getTemplates();

        echo'<script type="content/json" id="jsTemplates">'.json_encode($templates).'</script>';
    }

    public function setHasCookie()
    {
        $request    = Request::getInstance();
        $cookieName = 'AcceptsCookie';
        $setCookie  = $request->getSession()->get($cookieName);

        if (!empty($setCookie)) {
            $cookie = new Cookie($cookieName, true, time() + (60 * 60 * 24 * 7 * 30 * 6)); //Expires in 6 months
            setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime());
            $request->getSession()->set($cookieName, '');
        }
    }
}
