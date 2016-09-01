<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 01/09/2016
 * Time: 18:22
 */

namespace WonderWp\Plugin\Newsletter;

use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Plugin\PageSettings\AbstractPageSettingsService;

class NewsletterPageSettingsService extends AbstractPageSettingsService
{

    public function getSettingsFields()
    {
        $fields = array();

        $listSelect = new SelectField('list', null, ['label' => 'Liste de diffusion']);
        $listSelect->setOptions([
            '1' => 'Liste 1',
            '2' => 'Liste 2',
            '3' => 'Liste 3',
        ]);
        $fields[] = $listSelect;

        $formTitle = new InputField('form_title', null, ['label' => 'Titre du formulaire']);
        $fields[] = $formTitle;

        return $fields;
    }

}