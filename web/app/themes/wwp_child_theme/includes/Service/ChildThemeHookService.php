<?php

namespace WonderWp\Theme\Child\Service;

use Symfony\Component\HttpFoundation\Cookie;
use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\HttpFoundation\Request;
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
        add_filter('wwp.mailer.setBody', [$this, 'includeMailTemplate']);
        add_action('wp_footer', [$this, 'loadJsonTpls']);
        //Disable visual editor
        add_filter('user_can_richedit', '__return_false', 50);
        add_action('wp_loaded', [$this, 'setHasCookie']);

        add_filter('jsonAssetsExporter.json', [$this, 'mergeSassFiles']);
    }

    public function includeMailTemplate($mailBody)
    {
        $templateContent = '<body>##MAIL_CONTENT##</body>';
        $templatePath    = locate_template(['/templates/mail/default.php'], false, false);
        if (file_exists($templatePath)) {
            ob_start();
            include($templatePath);
            $templateContent = ob_get_contents();
            ob_end_clean();
        }
        $mailContent = str_replace('##MAIL_CONTENT##', $mailBody, $templateContent);

        return $mailContent;
    }

    public function loadJsonTpls()
    {
        $templates = [];

        //Notifications
        $templates['notification'] = NotificationComponent::$template;

        //Loaders
        $loaderComp           = new Loadercomponent();
        $templates['loaders'] = $loaderComp->getTemplates();

        echo '<script type="content/json" id="jsTemplates">' . json_encode($templates) . '</script>';
    }

    public function setHasCookie()
    {
        $request    = Request::getInstance();
        $cookieName = 'AcceptsCookie';
        $setCookie  = $request->getSession()->get($cookieName);

        if (!empty($setCookie)) {
            $cookie = new Cookie($cookieName, true, time() + (60 * 60 * 24 * 30 * 6), '/'); //Expires in 6 months
            setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath());
            $request->getSession()->set($cookieName, '');
        }
    }

    public function mergeSassFiles($json)
    {

        if (isset($json['css']['plugins'])) {
            $pluginSassFiles = $json['css']['plugins'];
            unset($json['css']['plugins']);

            $pluginSassContent = '';
            if (!empty($pluginSassFiles)) {
                foreach ($pluginSassFiles as $pluginSassFile) {
                    $pluginSassContent .= '@import "' . str_replace(['./web/app', '//', '.scss'], ['../../../../../..', '/', ''], $pluginSassFile) . '";' . "\n";
                }
            }

            /** @var \WP_Filesystem_Direct $filesystem */
            $pluginSassPath = get_stylesheet_directory() . '/assets/raw/scss/plugins/_vendors.scss';
            $filesystem     = Container::getInstance()->offsetGet('wwp.fileSystem');
            $written        = $filesystem->put_contents(
                $pluginSassPath,
                $pluginSassContent,
                FS_CHMOD_FILE // predefined mode settings for WP files
            );

        }

        return $json;
    }
}