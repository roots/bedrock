<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 09/08/2016
 * Time: 17:16
 */

namespace WonderWp\Plugin\Faq;

use WonderWp\AbstractDefinitions\EntityAttribute;
use WonderWp\Forms\Fields\BooleanField;
use WonderWp\Forms\Fields\HiddenField;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Forms\ModelForm;

class FaqForm extends ModelForm{

    public function newField(EntityAttribute $attr)
    {
        $fieldName = $attr->getFieldName();
        $entity = $this->getModelInstance();
        $val = $entity->$fieldName;
        $label = __($fieldName.'.trad',$this->_textDomain);

        switch($fieldName){
            case 'id':
                $f = new HiddenField($attr->getFieldName(),$val, ['label'=>$label]);
                break;
            case 'lang':
                $f = new SelectField($attr->getFieldName(),$val, ['label'=>$label]);
                $opts = array(
                    'en_EN'=>'Anglais',
                    'fr_FR'=>'Français'
                );
                $f->setOptions($opts);
                break;
            case 'isActive':
                $f = $f = new BooleanField($attr->getFieldName(), $val, ['label'=>$label]);
                break;
            default:
                $f = parent::newField($attr);
                break;
        }
        return $f;
    }

}