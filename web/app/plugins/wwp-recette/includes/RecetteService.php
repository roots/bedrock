<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 13/10/2016
 * Time: 12:01
 */

namespace WonderWp\Plugin\Recette;


use WonderWp\DI\Container;
use WonderWp\Forms\Fields\CategoryRadioField;
use WonderWp\Forms\Fields\FieldGroup;
use WonderWp\Forms\Fields\RadioField;
use WonderWp\Forms\Form;
use WonderWp\Services\AbstractService;

class RecetteService extends AbstractService
{
    /**
     * @return Form
     */
    public function getFiltersForm($arome=null,$instant=null,$typePlat=null){

        $container = Container::getInstance();

        /** @var Form $form */
        $form = $container->offsetGet('wwp.forms.form');
        $form->setName('recette-filters-form');

        $fieldGroup = new FieldGroup('filters-wrap',null,['inputAttributes'=>['class'=>['grid-3']]]);

        //Add aromes
        $displayRules = [
            'label'=>__('quel_arome_filtre',WWP_RECETTE_TEXTDOMAIN)
        ];
        $aromeid = (is_object($arome) && !empty($arome->term_id)) ? $arome->term_id : null;
        $aromes = new CategoryRadioField('arome',$aromeid,$displayRules,[],4);
        $fieldGroup->addFieldToGroup($aromes);


        //add instant conso
        $displayRules = [
            'label'=>__('quel_instant_conso_filtre',WWP_RECETTE_TEXTDOMAIN)
        ];
        $instantId = (is_object($instant) && !empty($instant->term_id)) ? $instant->term_id : null;
        $instants = new CategoryRadioField('instant',$instantId,$displayRules,[],9);
        $fieldGroup->addFieldToGroup($instants);


        //add type plat
        $displayRules = [
            'label'=>__('quel_type_plat_filtre',WWP_RECETTE_TEXTDOMAIN)
        ];
        $typeId = (is_object($typePlat) && !empty($typePlat->term_id)) ? $typePlat->term_id : null;
        $typesPlats = new CategoryRadioField('typeplat',$typeId,$displayRules,[],13);
        $fieldGroup->addFieldToGroup($typesPlats);


        $form->addField($fieldGroup);

        return $form;

    }
}