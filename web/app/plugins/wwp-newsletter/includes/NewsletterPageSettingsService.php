<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 01/09/2016
 * Time: 18:22
 */

namespace WonderWp\Plugin\Newsletter;

use Doctrine\ORM\EntityManager;
use WonderWp\DI\Container;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Plugin\PageSettings\AbstractPageSettingsService;

class NewsletterPageSettingsService extends AbstractPageSettingsService
{

    public function getSettingsFields()
    {
        $fields = array();

        $listSelect = new SelectField('list', null, ['label' => 'Liste de diffusion']);
        /** @var EntityManager $entityManager */
        $entityManager = Container::getInstance()->offsetGet('entityManager');
        $repo = $entityManager->getRepository(NewsletterEntity::class);
        $lists = $repo->findAll();
        $listOpts = array(''=>'Choisissez la liste dont on affichera le formulaire d\'inscription');
        if(!empty($lists)){ foreach ($lists as $list){
            /** @var $list NewsletterEntity */
            $listOpts[$list->getId()] = $list->getTitle();
        } }
        $listSelect->setOptions($listOpts);
        $fields[] = $listSelect;

        $formTitle = new InputField('form_title', null, ['label' => 'Titre du formulaire']);
        $fields[] = $formTitle;

        return $fields;
    }

}