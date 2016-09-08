<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 09/08/2016
 * Time: 17:16
 */

namespace WonderWp\Plugin\Translator;

use WonderWp\Entity\EntityAttribute;
use WonderWp\Forms\Fields\BooleanField;
use WonderWp\Forms\Fields\HiddenField;

use WonderWp\Forms\ModelForm;

class LangForm extends ModelForm{

    public function newField(EntityAttribute $attr)
    {
        $fieldName = $attr->getFieldName();
        $entity = $this->getModelInstance();
        $val = $entity->$fieldName;

        switch($fieldName){
            case 'id':
                $f = new HiddenField($attr->getFieldName(),$val);
                break;
            case 'isActive':
                $f = $f = new BooleanField($attr->getFieldName(), $val , ['label'=>'Label '.$fieldName]);
                break;
            default:
                $f = parent::newField($attr);
                break;
        }
        return $f;
    }

}