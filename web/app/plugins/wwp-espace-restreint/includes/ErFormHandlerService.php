<?php

namespace WonderWp\Plugin\EspaceRestreint;

use WonderWp\API\Result;
use WonderWp\DI\Container;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\PasswordField;
use WonderWp\Forms\Form;
use WonderWp\Services\AbstractService;

class ErFormHandlerService extends AbstractService{


    public function handleLoginForm(Form $loginForm, $data){
        $errors = array();

        if (empty($errors)) {
            $result = new Result(200,['msg'=>__('login.success',WWP_ER_TEXTDOMAIN)]);
        } else {
            $result = new Result(403,['msg'=>__('login.error',WWP_ER_TEXTDOMAIN)].implode('<br />',$errors));
        }
        return $result;
    }

    public function handleSignupForm(Form $signupForm, $data){
        $errors = array();

        if (empty($errors)) {
            $result = new Result(200,['msg'=>__('signup.success',WWP_ER_TEXTDOMAIN)]);
        } else {
            $result = new Result(403,['msg'=>__('signup.error',WWP_ER_TEXTDOMAIN)].implode('<br />',$errors));
        }
        return $result;
    }

    public function handleForgotPwdForm(Form $forgotPwdForm, $data){
        $errors = array();

        if (empty($errors)) {
            $result = new Result(200,['msg'=>__('forgotpwd.success',WWP_ER_TEXTDOMAIN)]);
        } else {
            $result = new Result(403,['msg'=>__('forgotpwd.error',WWP_ER_TEXTDOMAIN)].implode('<br />',$errors));
        }
        return $result;
    }

    public function handletResetPwdForm(Form $resetPwdForm, $data){
        $errors = array();

        if (empty($errors)) {
            $result = new Result(200,['msg'=>__('resetpwd.success',WWP_ER_TEXTDOMAIN)]);
        } else {
            $result = new Result(403,['msg'=>__('resetpwd.error',WWP_ER_TEXTDOMAIN)].implode('<br />',$errors));
        }
        return $result;
    }

}