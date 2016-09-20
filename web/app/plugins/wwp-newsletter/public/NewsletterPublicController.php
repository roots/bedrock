<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 10:08
 */

namespace WonderWp\Plugin\Newsletter;

use Doctrine\ORM\EntityRepository;
use Respect\Validation\Rules\In;
use Respect\Validation\Validator;
use WonderWp\APlugin\AbstractPluginFrontendController;
use WonderWp\DI\Container;
use WonderWp\Forms\Fields\EmailField;
use WonderWp\Forms\Fields\HiddenField;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Forms\Fields\TextAreaField;
use WonderWp\Forms\Form;
use WonderWp\Forms\FormValidator;
use WonderWp\HttpFoundation\Request;
use WonderWp\Plugin\Newsletter\NewsletterEntity;
use WonderWp\Plugin\Newsletter\PasserelleInterface;
use WonderWp\Theme\ThemeViewService;

class NewsletterPublicController extends AbstractPluginFrontendController
{

    public function defaultAction($atts)
    {
        return $this->showFormAction($atts);
    }

    public function showFormAction($atts)
    {

        if (empty($atts['list'])) {
            return false;
        }
        $formTitle = !empty($atts['form_title']) ? $atts['form_title'] : '';

        $passerelleClass = get_option("wwp-newsletter_passerelle");

        /** @var PasserelleInterface $passerelle */
        $passerelle = new $passerelleClass();

        $listItem = $this->_entityManager->find(NewsletterEntity::class, $atts['list']);

        $formView = $passerelle->getSignupForm($listItem);

        /** @var ThemeViewService $viewService */
        $viewService = wwp_get_theme_service('view');

        $notifications = $viewService->flashesToNotifications();

        //$opts = array('formStart'=>['action'=>'/contactFormSubmit']);
        $opts = array();
        return $this->renderView('form', [
            'formTitle'=>$formTitle,
            'formView' => $formView,
            'notifications' => $notifications
        ]);
    }

}