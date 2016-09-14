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
use WonderWp\APlugin\AbstractPluginFrontendController;
use WonderWp\Forms\Fields\EmailField;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Forms\Fields\TextAreaField;
use WonderWp\Forms\Form;

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

        return $this->renderView('form', ['formView' => $formInstance->renderView()]);
    }

    /**
     * @param ContactFormEntity $formItem
     * @return Form
     */
    private function _getFormInstanceFromItem($formItem)
    {
        $formInstance = new Form();

        $data = json_decode($formItem->getData());

        if (!empty($data)) {
            foreach ($data as $fieldName => $fieldData) {
                $field = $this->_generateDefaultField($fieldName, $fieldData);
                $formInstance->addField($field);
            }
        }

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