<?php

namespace WonderWp\Plugin\EspaceRestreint;
use WonderWp\API\Result;
use WonderWp\APlugin\AbstractPluginFrontendController;
use WonderWp\HttpFoundation\Request;
use WonderWp\Theme\ThemeQueryService;
use WonderWp\Theme\ThemeViewService;

/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/11/2016
 * Time: 17:00
 */
class ErPublicController extends AbstractPluginFrontendController
{

    public function loginAction(){

        /** @var ErGeneralService $erGleService */
        $erGleService = $this->_manager->getService('er');

        /** @var ErFormService $erService */
        $erFormService = $this->_manager->getService('erForm');
        $loginForm = $erFormService->getLoginForm();

        /** @var ErFormHandlerService $erFormHandlerService */
        $erFormHandlerService = $this->_manager->getService('erFormHandler');
        $formHandler = array($erFormHandlerService,'handleLoginForm');

        $viewOpts = array(
            'file'=>'default',
            'title'=>__('login',WWP_ER_TEXTDOMAIN),
            'params'=>[
                'registerUrl'=>$erGleService->getRegisterUrl(),
                'forgotPwdUrl'=>$erGleService->getForgotPwdUrl()
            ]
        );

        return $this->_abstractAction($loginForm,$formHandler,$viewOpts);

    }

    public function registerAction(){

        add_filter( 'body_class', function($classes){
            $classes[] = 'club-subscription';
            return $classes;
        });

        /** @var ErGeneralService $erGleService */
        $erGleService = $this->_manager->getService('er');

        /** @var ErFormService $erService */
        $erFormService = $this->_manager->getService('erForm');
        $registerForm = $erFormService->getRegisterForm();

        /** @var ErFormHandlerService $erFormHandlerService */
        $erFormHandlerService = $this->_manager->getService('erFormHandler');
        $formHandler = array($erFormHandlerService,'handleLoginForm');

        $viewOpts = array(
            'file'=>'register',
            'title'=>__('register',WWP_ER_TEXTDOMAIN),
            'params'=>[
                'loginUrl'=>$erGleService->getLoginUrl()
            ]
        );

        return $this->_abstractAction($registerForm,$formHandler,$viewOpts);
    }

    public function logoutAction(){
        $request = Request::getInstance();

        /** @var ErFormHandlerService $erFormHandlerService */
        $erFormHandlerService = $this->_manager->getService('erFormHandler');
        $result = $erFormHandlerService->handleLogout();
        if($request->isXmlHttpRequest()){
            header('Content-Type: application/json');
            echo $result;
            die();
        } else {
            $success = ($result->getCode()==200);
            $request->getSession()->getFlashbag()->add('er', [($success ? 'success' : 'error'), $result->getData('msg')]);
            /* @todo Decide where to go next */
            //\WonderWp\redirect('/');
        }
    }

    public function forgetPasswordAction(){
        /** @var ErGeneralService $erGleService */
        $erGleService = $this->_manager->getService('er');

        /** @var ErFormService $erService */
        $erFormService = $this->_manager->getService('erForm');
        $forgetPwdForm = $erFormService->getForgotPwdForm();

        /** @var ErFormHandlerService $erFormHandlerService */
        $erFormHandlerService = $this->_manager->getService('erFormHandler');
        $formHandler = array($erFormHandlerService,'handleForgotPwdForm');

        $viewOpts = array(
            'file'=>'default',
            'title'=>__('forgotpwd',WWP_ER_TEXTDOMAIN),
            'params'=>[
                'loginUrl'=>$erGleService->getLoginUrl()
            ]
        );

        return $this->_abstractAction($forgetPwdForm,$formHandler,$viewOpts);
    }

    public function resetPasswordAction(){
        /** @var ErFormService $erService */
        $erFormService = $this->_manager->getService('erForm');
        $loginForm = $erFormService->getResetPwdForm();

        /** @var ErFormHandlerService $erFormHandlerService */
        $erFormHandlerService = $this->_manager->getService('erFormHandler');
        $formHandler = array($erFormHandlerService,'handletResetPwdForm');

        $viewOpts = array(
            'file'=>'default',
            'title'=>__('resetpwd',WWP_ER_TEXTDOMAIN)
        );

        return $this->_abstractAction($loginForm,$formHandler,$viewOpts);
    }

    private function _abstractAction($form,$formHandler,$viewOpts){

        $request = Request::getInstance();
        if($request->getMethod()=='POST'){
            /** @var Result $result */
            $result = call_user_func_array($formHandler,array($form,$request->request->all()));
            if($request->isXmlHttpRequest()){
                header('Content-Type: application/json');
                echo $result;
                die();
            } else {
                $success = ($result->getCode()==200);
                $request->getSession()->getFlashbag()->add('er', [($success ? 'success' : 'error'), $result->getData('msg')]);
            }
        }

        /** @var ThemeViewService $viewService */
        $viewService = wwp_get_theme_service('view');
        $notifications = $viewService->flashesToNotifications('er');
        $defaultViewParams = ['formView'=>$form->renderView(),'notifications'=>$notifications];
        $viewParams = \WonderWp\array_merge_recursive_distinct($defaultViewParams,$viewOpts['params']);

        $post = new \stdClass();
        $post->ID = 0;
        $post->post_title = $viewOpts['title'];
        $post->post_name = sanitize_title($viewOpts['title']);
        $post->post_content = $this->renderView($viewOpts['file'], $viewParams);

        /** @var ThemeQueryService $qs */
        $qs = wwp_get_theme_service('query');
        return $qs->resetPost($post);
    }

}