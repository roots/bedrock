<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 10:08
 */

namespace WonderWp\Plugin\Contact;

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
use WonderWp\Theme\ThemeViewService;

class ContactPublicController extends AbstractPluginFrontendController
{

    public function defaultAction($atts)
    {
        return $this->showFormAction($atts);
    }

    public function showFormAction($atts)
    {

        if (empty($atts['form'])) {
            return false;
        }

        $formItem = $this->_entityManager->find(ContactFormEntity::class, $atts['form']);
        $formInstance = $this->_getFormInstanceFromItem($formItem);
        /** @var ThemeViewService $viewService */
        $viewService = wwp_get_theme_service('view');

        $notifications = $viewService->flashesToNotifications('contact');

        $opts = array('formStart'=>['action'=>'/contactFormSubmit','class'=>['contactForm']]);
        return $this->renderView('form', ['formView' => $formInstance->renderView($opts), 'notifications'=>$notifications]);
    }

    public function handleFormAction(){
        $request = Request::getInstance();
        $container = Container::getInstance();
        $data = $request->request->all();
        $formItem = $this->_entityManager->find(ContactFormEntity::class, $data['form']);
        $formInstance = $this->_getFormInstanceFromItem($formItem);

        /** @var ContactHandlerService $contactHandlerService */
        $contactHandlerService = $this->_manager->getService('contactHandler');
        $mailSent = $contactHandlerService->handleSubmit($data,$formInstance,$formItem);
        if ($mailSent) {
            $result = new Result(200,['msg'=>__('mail.sent',WWP_CONTACT_TEXTDOMAIN)]);
        } else {
            $result = new Result(403,['msg'=>__('mail.notsent',WWP_CONTACT_TEXTDOMAIN)]);
        }

        if($request->isXmlHttpRequest()){
            header('Content-Type: application/json');
            echo $result;
            die();
        } else {
            $prevPage = get_permalink($data['post']);
            $request->getSession()->getFlashbag()->add('contact', [($mailSent ? 'success' : 'error'), $result->getData('msg')]);
            wp_redirect($prevPage);
            die();
        }
    }

    /**
     * @param ContactFormEntity $formItem
     * @return Form
     */
    private function _getFormInstanceFromItem($formItem)
    {
        global $post;
        $formInstance = Container::getInstance()->offsetGet('wwp.forms.form');

        //Add configured fields
        $data = json_decode($formItem->getData());
        if (!empty($data)) {
            foreach ($data as $fieldName => $fieldData) {
                $field = $this->_generateDefaultField($fieldName, $fieldData);
                $formInstance->addField($field);
            }
        }

        //Add other necessary field
        $f = new HiddenField('form',$formItem->getId());
        $formInstance->addField($f);

        $f = new HiddenField('post',$post->ID);
        $formInstance->addField($f);

        return $formInstance;
    }

    private function _generateDefaultField($fieldName, $fieldData)
    {

        $f = null;
        $label = __($fieldName . '.trad', WWP_CONTACT_TEXTDOMAIN);
        $displayRules = ['label' => $label];
        $validationRules = array();
        if (!empty($fieldData->required) && $fieldData->required == 1) {
            $validationRules[] = Validator::notEmpty();
        }
        switch ($fieldName) {
            case 'message':
                $f = new TextAreaField($fieldName, null, $displayRules, $validationRules);
                break;
            case 'email':
                $f = new EmailField($fieldName, null, $displayRules, $validationRules);
                break;
            case 'sujet':
                $f = new SelectField($fieldName, null, $displayRules, $validationRules);
                $opts = array('' => __('choose.subject.trad', WWP_CONTACT_TEXTDOMAIN));
                $currentLocale = get_locale();
                if (!empty($fieldData->sujets)) {
                    foreach ($fieldData->sujets as $i => $sujet) {
                        if (!empty($sujet->locale) && $sujet->locale == $currentLocale) {
                            $opts[$i] = $sujet->text;
                        }
                    }
                }
                $f->setOptions($opts);
                break;
            default:
                $f = new InputField($fieldName, null, $displayRules, $validationRules);
                break;
        }
        return $f;
    }

}