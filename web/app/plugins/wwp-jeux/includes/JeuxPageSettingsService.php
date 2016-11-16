<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 13/09/2016
 * Time: 16:37
 */

namespace WonderWp\Plugin\Jeux;


use WonderWp\DI\Container;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Plugin\PageSettings\AbstractPageSettingsService;

class JeuxPageSettingsService extends AbstractPageSettingsService
{
    public function getSettingsFields()
    {
        $fields = array();

        //Choix du quizz
        $formSelect = new SelectField('jeux', null, ['label' => 'Jeux à brancher']);
        $container = Container::getInstance();
        $em = $container->offsetGet('entityManager');
        $repository = $em->getRepository(JeuxEntity::class);
        $forms = $repository->findAll();
        $opts = array(
            '' => 'Choisissez le jeux à afficher'
        );
        if (!empty($forms)) {
            foreach ($forms as $f) {
                /** @var JeuxEntity $f */
                $opts[$f->getId()] = $f->getTitre();
            }
        }
        $formSelect->setOptions($opts);
        $fields[] = $formSelect;

        //Choix de l'élément à afficher
        $presentation = new SelectField('presentation', null, ['label'=>'Partie du jeux à afficher']);
        $presentation->setOptions([
            'presentation' => 'Encart de présentation',
            'jeux' => 'Le jeux',
            'lots' => 'Les Lots',
            'gagnants' => 'Les gagnants'
        ]);
        $fields[] = $presentation;

        return $fields;
    }

}