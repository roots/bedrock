<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 01/09/2016
 * Time: 18:22
 */

namespace WonderWp\Plugin\Faq;

use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Plugin\Forms\Fields\LocaleField;
use WonderWp\Plugin\PageSettings\AbstractPageSettingsService;

class FaqPageSettingsService extends AbstractPageSettingsService
{

    public function getSettingsFields()
    {
        $fields = array();

        //locale
        $fields[] = LocaleField::getInstance();

        //Presentation
        $presField = (new SelectField('vue',null,['label'=>'Présentation']))->setOptions([
            ''=>'Choisissez une présentation',
            'list'=>'Vue liste',
            'accordion'=>'Accordéon'
        ]);
        $fields[] = $presField;

        return $fields;
    }

}