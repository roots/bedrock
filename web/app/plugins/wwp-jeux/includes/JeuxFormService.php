<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/11/2016
 * Time: 12:08
 */

namespace WonderWp\Plugin\Jeux;


use WonderWp\API\Result;
use WonderWp\DI\Container;
use WonderWp\Forms\Fields\FieldGroup;
use WonderWp\Forms\Form;
use WonderWp\Forms\ModelForm;
use WonderWp\Services\AbstractService;

class JeuxFormService extends AbstractService
{
    public function getJeuxFrontForm(JeuxEntity $jeux)
    {
        $container = Container::getInstance();
        /** @var Form $form */
        $form = $container->offsetGet('wwp.forms.form');
        $form->setName('jeux-form');

        //Add each question and each response
        $questions = $jeux->getQuestions();
        if (!empty($questions)) {
            foreach ($questions as $q) {
                /* @var $q \WonderWp\Plugin\Jeux\JeuxQuestion */

                $reponses = $q->getReponses();

                $nbCorrect = 0;
                if (!empty($reponses)) {
                    foreach ($reponses as $r) {
                        /* @var $r \WonderWp\Plugin\Jeux\JeuxReponse */
                        if ($r->getIsActive() && $r->getIsCorrect()) {
                            $nbCorrect++;
                        }
                    }
                }
                $fieldType = ($nbCorrect <= 1) ? \WonderWp\Forms\Fields\RadioField::class : \WonderWp\Forms\Fields\CheckBoxesField::class;
                $qField = new $fieldType('question-' . $q->getId(), null, ['label' => $q->getTitre(),'wrapAttributes'=>array( 'class'=>['question-wrap'] )]);
                $options = [];
                if (!empty($reponses)) {
                    foreach ($reponses as $r) {
                        /* @var $r \WonderWp\Plugin\Jeux\JeuxReponse */
                        if ($r->getIsActive()) {
                            $options[$r->getId()] = $r->getTitre();
                        }
                    }
                    $qField->setOptions($options);
                    if($fieldType==\WonderWp\Forms\Fields\RadioField::class){
                        $qField->generateRadios();
                    } else {
                        $qField->generateCheckBoxes();
                    }
                }

                $form->addField($qField);
            }
        }

        //add registration form
        $manager = $container->offsetGet('wwp-jeux.Manager');
        $userEntityName = $manager->getConfig('userEntityName');
        $item = new $userEntityName();

        $modelFormName = $manager->getConfig('userFormName');
        /** @var ModelForm $modelForm */
        $modelForm = new $modelFormName();
        $modelForm->setTextDomain(WWP_JEUX_TEXTDOMAIN);
        $modelForm->setModelInstance($item);
        $modelForm->setFormInstance($form)->buildForm();
        $form = $modelForm->getFormInstance();

        return $form;
    }

    public function handleRequest($jeux,$data){
        $errors = array();
        $container = Container::getInstance();
        $manager = $container->offsetGet('wwp-jeux.Manager');
        $userEntityName = $manager->getConfig('userEntityName');

        //\WonderWp\trace($data);

        //Check if player already played before
        if (!empty($data['email'])) {
            $repository = $container->offsetGet('entityManager')->getRepository($userEntityName);
            $query = $repository->findBy(['email' => $data['email']]);
            if(count($query)>0){
                $errors[] = __('already.played',WWP_JEUX_TEXTDOMAIN);
            }
        }

        if (!empty($data['dob'])) {
            $data['dob'] = \DateTime::createFromFormat('Y-m-d', $data['dob']);
        } else {
            $data['dob'] = new \DateTime();
        }

        $form = $this->getJeuxFrontForm($jeux);

        $item = new $userEntityName();

        $modelFormName = $manager->getConfig('userFormName');
        /** @var ModelForm $modelForm */
        $modelForm = new $modelFormName();
        $modelForm->setTextDomain(WWP_JEUX_TEXTDOMAIN);
        $modelForm->setModelInstance($item);
        $modelForm->setFormInstance($form);

        $formValidator = $container->offsetGet('wwp.forms.formValidator');
        $errors = !empty($errors) ? $errors : $modelForm->handleRequest($data, $formValidator);

        if (empty($errors)) {
            $result = new Result(200,['msg'=>__('signup.success',WWP_JEUX_TEXTDOMAIN)]);
        } else {
            $result = new Result(403,['msg'=>__('signup.error',WWP_JEUX_TEXTDOMAIN).implode('<br />',$errors)]);
        }

        return $result;
    }
}