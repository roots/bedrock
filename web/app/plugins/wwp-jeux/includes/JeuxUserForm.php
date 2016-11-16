<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 09/08/2016
 * Time: 17:16
 */

namespace WonderWp\Plugin\Jeux;


use WonderWp\Entity\AbstractEntities\AbstractUser;
use WonderWp\Entity\AbstractEntities\AbstractUserModelForm;
use WonderWp\Entity\EntityAttribute;
use WonderWp\Forms\Fields\BooleanField;
use WonderWp\Forms\Fields\CategoryField;
use WonderWp\Forms\Fields\CategoryRadioField;
use WonderWp\Forms\Fields\DateField;
use WonderWp\Forms\Fields\EmailField;
use WonderWp\Forms\Fields\HiddenField;
use WonderWp\Forms\Fields\PasswordField;
use WonderWp\Forms\Fields\RadioField;
use WonderWp\Forms\Fields\SelectField;

/**
 * Class MembreForm
 * @package WonderWp\Plugin\EspaceRestreint
 * Class that defines the form to use when adding / editing the entity
 */
class JeuxUserForm extends AbstractUserModelForm{

    public function newField(EntityAttribute $attr)
    {
        $fieldName = $attr->getFieldName();
        $entity = $this->getModelInstance();
        $val = $entity->$fieldName;
        $label = __($fieldName . '.trad', $this->_textDomain);

        //Add here particular cases for your different fields
        switch($fieldName){

            case'civilite':
                $parentCat = 0; //change here the civilite cat id
                $f = new CategoryField($fieldName,$val,['label' => $label],[],$parentCat);
                break;

            case'country':
                $parentCat = 0; //change here the country cat id
                $f = new CategoryField($fieldName,$val,['label' => $label],[],$parentCat);
                break;

            default:
                $f = parent::newField($attr);
                break;
        }
        return $f;
    }

}