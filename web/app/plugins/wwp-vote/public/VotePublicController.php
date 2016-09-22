<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 10:08
 */

namespace WonderWp\Plugin\Vote;

use Doctrine\ORM\EntityRepository;
use Respect\Validation\Rules\In;
use Respect\Validation\Validator;
use WonderWp\API\Result;
use WonderWp\APlugin\AbstractPluginFrontendController;
use WonderWp\DI\Container;
use WonderWp\Forms\Fields\EmailField;
use WonderWp\Forms\Fields\HiddenField;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\RadioField;
use WonderWp\Forms\Fields\SelectField;
use WonderWp\Forms\Fields\TextAreaField;
use WonderWp\Forms\Form;
use WonderWp\Forms\FormValidator;
use WonderWp\HttpFoundation\Request;
use WonderWp\Plugin\Vote\Vote;
use WonderWp\Theme\ThemeViewService;

class VotePublicController extends AbstractPluginFrontendController
{

    public function defaultAction($atts)
    {
        return $this->showFormAction($atts);
    }

    public function showFormAction($atts)
    {

        if (empty($atts['entityname']) || empty($atts['entityid'])) {
            return false;
        }

        /** @var EntityRepository $repository */
        $repository = $this->_entityManager->getRepository(VoteEntity::class);
        $votes = $repository->findBy([
            "entityname" => $atts['entityname'],
            "entityid" => $atts['entityid']
        ]);
        $score = 0;
        if(!empty($votes)){ foreach($votes as $v){
         /** @var $v VoteEntity */
         $score += $v->getScore();
        }}

        $nbVotes = count($votes);
        if(empty($nbVotes)){ $nbVotes = 1; }
        $average = round($score / $nbVotes);
        $limit = 5;

        $form = $this->_getForm($atts, $average, $limit);

        /** @var ThemeViewService $viewService */
        $viewService = wwp_get_theme_service('view');
        $notifications = $viewService->flashesToNotifications('vote');

        $opts = array('formStart' => ['action' => '/voteFormSubmit','class'=>['voteForm']]);
        return $this->renderView('form', [
            'nbVotes' => $nbVotes,
            'formView' => $form->renderView($opts),
            'notifications' => $notifications
        ]);
    }

    private function _getForm($atts, $average=0, $limit=0)
    {
        global $post;

        /** @var Form $form */
        $form = Container::getInstance()->offsetGet('wwp.forms.form');

        $uid = $this->_getUid();

        if (!empty($atts['score'])) { //Pour validation
            $f = new HiddenField('score',$atts['score']);
        } else {
            $f = new RadioField('score', null, ['label' => __('add.your.vote', WWP_VOTE_TEXTDOMAIN)]);
            $opts = array();
            $passedGroupDisplayRules = array();
            for ($i = 1; $i <= $limit; $i++) {
                $opts[$i] = __('vote.note') . ' ' . $i . ' ' . __('vote.note.sur') . $limit;
                if ($i <= $average) {
                    $passedGroupDisplayRules[$i] = array('wrapAttributes' => ['class' => ['active']]);
                }
            }
            $f->setOptions($opts)->generateRadios($passedGroupDisplayRules);
        }
        $form->addField($f);

        $form->addField(new HiddenField('entityname', $atts['entityname']));
        $form->addField(new HiddenField('entityid', $atts['entityid']));
        $form->addField(new HiddenField('post', $post->ID));
        $form->addField(new HiddenField('entityChck', md5(sha1($atts['entityname'] . '/' . $atts['entityid'] . '/' . $post->ID))));
        $form->addField(new HiddenField('entityToken', $uid.md5(empty($uid))));
        $form->addField(new HiddenField('entityTokenTest', $uid));
        $form->addField(new HiddenField('entityTokenTest2', empty($uid)));
        $form->addField(new HiddenField('entityTokenTest3', md5(empty($uid))));

        if (!empty($atts['datetime'])) {
            $form->addField(new HiddenField('datetime', $atts['datetime']));
        }
        if (!empty($atts['ip'])) {
            $form->addField(new HiddenField('ip', $atts['ip']));
        }

        return $form;
    }

    public function handleFormAction()
    {
        $request = Request::getInstance();
        $data = $request->request->all();
        $data['datetime'] = new \DateTime();

        $formInstance = $this->_getForm($data);

        /** @var VoteHandlerService $voteHandlerService */
        $voteHandlerService = $this->_manager->getService('voteHandler');
        $voteHandlerResult = $voteHandlerService->handleSubmit($data,$formInstance);

        $success = $voteHandlerResult->getCode()===200;

        $prevPage = get_permalink($data['post']);
        if ($success) {
            $result = new Result(200,['msg'=>__('vote.success', WWP_CONTACT_TEXTDOMAIN)]);
        } else {
            $result = new Result(403,['msg'=>__('vote.error', WWP_CONTACT_TEXTDOMAIN)]);
        }

        if($request->isXmlHttpRequest()){
            header('Content-Type: application/json');
            echo $result;
            die();
        } else {
            $request->getSession()->getFlashbag()->add('vote', [($success ? 'success' : 'error'), $result->getData('msg')]);
            wp_redirect($prevPage);
        }
    }

    private function _getUid(){
        $uidKey = md5('wwp-vote');
        $uidKey2 = strrev($uidKey);

        $uid = null;

        $request = Request::getInstance();

        //Check in session
        $uid = $request->getSession()->get($uidKey);

        //Check in cookie
        if(empty($uid)) {
            $uid = $request->cookies->get($uidKey);
        }

        //Check in second cookie
        if(empty($uid)) {
            $uid = $request->cookies->get($uidKey2);
        }

        return $uid;
    }

}