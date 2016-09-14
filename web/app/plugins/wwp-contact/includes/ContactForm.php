<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 09/08/2016
 * Time: 17:16
 */

namespace WonderWp\Plugin\Contact;


use WonderWp\Entity\EntityAttribute;
use WonderWp\Forms\Fields\BooleanField;
use WonderWp\Forms\Fields\HiddenField;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Forms\ModelForm;

/**
 * Class ContactForm
 * @package WonderWp\Plugin\Contact
 * Class that defines the form to use when adding / editing the entity
 */
class ContactForm extends ModelForm{

    public function newField(EntityAttribute $attr)
    {
        $fieldName = $attr->getFieldName();
        $entity = $this->getModelInstance();
        $val = $entity->$fieldName;

        //Add here particular cases for your different fields
        switch($fieldName){
            default:
                $f = parent::newField($attr);
                break;
        }
        return $f;
    }

}