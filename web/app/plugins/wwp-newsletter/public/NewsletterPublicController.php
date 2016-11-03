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
use WonderWp\API\Result;
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
        $form = $passerelle->getSignupForm($listItem);

        $opts = array(
            'formStart'=>array(
                'action'=>'/newsletterFormSubmit',
                'class'=>'nlForm form-inline'
            )
        );
        $formView = $form->renderView($opts);

        /** @var ThemeViewService $viewService */
        $viewService = wwp_get_theme_service('view');
        $notifications = $viewService->flashesToNotifications('newsletter');

        return $this->renderView('form', [
            'formTitle'=>$formTitle,
            'formView' => $formView,
            'notifications' => $notifications
        ]);
    }

    public function handleFormAction(){
        $passerelleClass = get_option("wwp-newsletter_passerelle");

        /** @var PasserelleInterface $passerelle */
        $passerelle = new $passerelleClass();

        $request = Request::getInstance();

        $data = $request->request->all();

        $container = Container::getInstance();
        $listItem = $this->_entityManager->find(NewsletterEntity::class, $request->request->get('listid'));
        $form = $passerelle->getSignupForm($listItem);

        //Form Validation
        $formValidator = $container->offsetGet('wwp.forms.formValidator');
        $formValidator->setFormInstance($form);
        $errors = $formValidator->validate($data);

        if(!empty($errors)){
            $result = new Result(403,['msg'=>__('newsletter.form.error', WWP_NEWSLETTER_TEXTDOMAIN),'errors'=>$errors]);
        } else {
            $result = $passerelle->handleFormSubmit($data);
        }

        if($request->isXmlHttpRequest()){
            header('Content-Type: application/json');
            echo $result;
            die();
        } else {
            $prevPage = $_SERVER['HTTP_REFERER'];
            $notifType = 'error';
            if($result->getCode()===200){ $notifType='success'; }
            if($result->getCode()===202){ $notifType='info'; }
            $notif = [$notifType, $result->getData('msg')];
            $request->getSession()->getFlashbag()->add('newsletter', $notif);
            wp_redirect($prevPage);
            die();
        }
    }

}