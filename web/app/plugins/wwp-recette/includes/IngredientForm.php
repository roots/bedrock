<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 08/09/2016
 * Time: 15:38
 */

namespace WonderWp\Plugin\Recette;

use Doctrine\Common\Collections\ArrayCollection;
use WonderWp\DI\Container;
use WonderWp\Entity\EntityRelation;
use WonderWp\Forms\Fields\FieldGroup;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\FormValidatorInterface;
use WonderWp\Forms\ModelForm;
use WonderWp\Plugin\Translator\LangEntity;

class IngredientForm extends ModelForm{

    public function newRelation(EntityRelation $relationAttr)
    {
        $fieldName = $relationAttr->getFieldName();
        if (method_exists($this, '_generate' . ucfirst($fieldName) . 'Group')) {
            call_user_func(array($this, '_generate' . ucfirst($fieldName) . 'Group'));
        }
    }

    public function _generateTranslationsGroup()
    {
        $container = Container::getInstance();
        $em = $container->offsetGet('entityManager');

        if(class_exists(LangEntity::class)) {

            /** @var ArrayCollection $translations */
            $translations = $this->_modelInstance->getTranslations();

            $repository = $em->getRepository(LangEntity::class);
            $languages = $repository->findAll();

            //Create translation group
            if(!empty($languages)){
                $displayRules = [
                    'label'=>'Traductions',
                    'labelAttributes'=>array(
                        'class'=>['trad-label']
                    )
                ];
                $tradform = new FieldGroup('translations',null,$displayRules);

                //Add one input per lang
                foreach($languages as $language){
                    /** @var $language LangEntity */
                    $displayRules = array(
                        'inputAttributes'=>array(
                            'placeholder'=>$language->getTitle(),
                            'name'=>'translations['.$language->getLocale().']'
                        )
                    );
                    /** @var $associatedTranslation IngredientTrad*/
                    $associatedTranslation = $translations->filter( function ($entry) use ($language) {
                        return $entry->getLocale()===$language->getLocale();
                    })->first();
                    $value = !empty($associatedTranslation) ? $associatedTranslation->getTitle() : null;

                    $f = new InputField('trad-'.$language->getLocale(),$value,$displayRules);
                    $tradform->addFieldToGroup($f);
                }
                $this->_formInstance->addField($tradform);
            }

        }
    }

    public function handleRequest(array $data, FormValidatorInterface $formValidator)
    {

        $postedData = $data;

        //Extract Translations
        $rawTranslationData = array();
        if (isset($data['translations'])) {
            $rawTranslationData = $data['translations'];
            unset($data['translations']);
        }

        $errors = parent::handleRequest($data, $formValidator);
        $this->_formInstance->fill($postedData);

        if (!empty($errors)) {
            return $errors;
        }

        $container = Container::getInstance();
        /** @var EntityManager $em */
        $this->_em = $container->offsetGet('entityManager');
        $em = $this->_em;

        //Process Translations
        $tradErrors = $this->_handleTranslations($rawTranslationData);
        $errors = $errors + $tradErrors;

        $em->flush();

        return $errors;

    }

    private function _handleTranslations(array $rawTranslationData)
    {
        $errors = array();

        /** @var Ingredient $ingredient */
        $ingredient = $this->_modelInstance;
        /** @var EntityManager $em */
        $em = $this->_em;

        //Remove old translations
        $currentTranslations = $ingredient->getTranslations();
        if (!empty($currentTranslations)) {
            foreach ($currentTranslations as $m) {
                $ingredient->removeTranslation($m);
                $em->remove($m);
            }
            $em->flush();
        }

        //Add new Translations
        if (!empty($rawTranslationData)) {
            foreach ($rawTranslationData as $locale => $val) {
                $trad = new IngredientTrad();
                $trad
                    ->setLocale($locale)
                    ->setTitle($val)
                    ->setIngredient($this->_modelInstance)
                ;
                if ($ingredient->addTranslation($trad)) {
                    $em->persist($trad);
                }
            }
        }
        return $errors;
    }

}