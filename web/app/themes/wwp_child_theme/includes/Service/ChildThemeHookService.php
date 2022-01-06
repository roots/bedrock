<?php

namespace WonderWp\Theme\Child\Service;

use Symfony\Component\HttpFoundation\Cookie;
use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\HttpFoundation\Request;
use WonderWp\Component\Media\Medias;
use WonderWp\Theme\Child\Components\Loader\Loadercomponent;
use WonderWp\Theme\Core\Component\NotificationComponent;
use WonderWp\Theme\Core\Service\ThemeHookService;
use WP_Customize_Manager;

class ChildThemeHookService extends ThemeHookService
{
    public function register()
    {
        parent::register();

        //$viewService = $this->manager->getService(ServiceInterface::VIEW_SERVICE_NAME);
        //add_action( 'wwp_after_footer', array($viewService,'prepareCookies'));
        add_filter('wwp.mailer.setBody', [$this, 'includeMailTemplate']);
        add_action('wp_footer', [$this, 'loadJsonTpls']);
        add_action('wp_loaded', [$this, 'setHasCookie']);
        add_filter('jsonAssetsExporter.json', [$this, 'mergeSassFiles']);
        add_filter('body_class', [$this, 'addBodyClassForPostThumb']);
        add_action('wp_footer', [$this, 'deregisterWpEmbed']);
        add_action('wwp_after_footer', [$this, 'injectFixedMobileMenu']);

        //Styleguide
        /** @var ChildThemeAssetsManipulator $assetManipulatorService */
        $assetManipulatorService = $this->manager->getService('asset_manipulator');
        add_action('wwp.styleguide.head', [$assetManipulatorService, 'enqueueCritical']);
        add_action('wwp.styleguide.head', [$assetManipulatorService, 'enqueueStyleGuideStyles']);
        add_action('wwp.styleguide.footer', [$assetManipulatorService, 'enqueueStyleGuideJavaScripts']);

        //Customizer
        $this->registerCustomizerHooks();
    }

    protected function registerCustomizerHooks()
    {
        $customizer = $this->manager->getService('customizer');
        add_action('customize_register', [$this, 'registerCustomizer']);
        add_filter('body_class', [$customizer, 'stickyHeaderHook']);
        add_filter('wwp-main-nav-class', [$customizer, 'mobileMenuVariationClassHook']);
        add_filter('wwp-header-logo', [$customizer, 'changeHeaderLogoHook']);
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
            $filesystem->put_contents(
                $pluginSassPath,
                $pluginSassContent,
                FS_CHMOD_FILE // predefined mode settings for WP files
            );

        }

        return $json;
    }

    public function addBodyClassForPostThumb($classes)
    {
        global $post;
        $featuredImg = is_object($post) ? Medias::getFeaturedImage($post->ID) : null;
        if (!empty($featuredImg)) {
            $classes[] = 'has-post-thumb';
        } else {
            $classes[] = 'has-no-post-thumb';
        }

        return $classes;
    }

    public function deregisterWpEmbed()
    {
        wp_deregister_script('wp-embed');
        wp_deregister_script('admin-bar');
    }

    public function registerCustomizer(WP_Customize_Manager $wp_customize)
    {
        /** @var ThemeCustomizerService $customizer */
        $customizer = $this->manager->getService('customizer');
        $customizer->setWpCustomize($wp_customize);
        $customizer->register();
    }

    public function injectFixedMobileMenu()
    {
        $locale   = get_locale();
        $menuName = 'Barre Menu Mobile ' . $locale;
        if (is_nav_menu($menuName)) {
            $defaultOpts = [
                'menu'       => $menuName,
                'container'  => 'nav',
                'container_class'=>'mobile-direct-links'
            ];

            $menuArgs = apply_filters('getBarreMenuMobile.menuArgs', $defaultOpts);

            wp_nav_menu($menuArgs);
        }
    }
}
