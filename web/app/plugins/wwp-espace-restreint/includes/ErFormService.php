<?php

namespace WonderWp\Plugin\EspaceRestreint;

use WonderWp\DI\Container;
use WonderWp\Forms\Fields\EmailField;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\PasswordField;
use WonderWp\Forms\Form;
use WonderWp\Services\AbstractService;

class ErFormService extends AbstractService{

    /**
     * @return Form
     */
    public function getLoginForm(){
        $container = Container::getInstance();

        /** @var Form $form */
        $form = $container->offsetGet('wwp.forms.form');
        $form->setName('er-login-form');

        $f1 = new InputField('er-login',null,['label'=>__('username',WWP_ER_TEXTDOMAIN)]);
        $form->addField($f1);

        $f2 = new PasswordField('er-pwd',null,['label'=>__('password',WWP_ER_TEXTDOMAIN)]);
        $form->addField($f2);

        return $form;
    }

    public function getRegisterForm(){
        $container = Container::getInstance();

        /** @var Form $form */
        $form = $container->offsetGet('wwp.forms.form');
        $form->setName('er-signup-form');



        return $form;
    }

    public function getForgotPwdForm(){
        $container = Container::getInstance();

        /** @var Form $form */
        $form = $container->offsetGet('wwp.forms.form');
        $form->setName('er-forgotpwd-form');

        $f1 = new EmailField('er-email',null,['label'=>__('your_email',WWP_ER_TEXTDOMAIN)]);
        $form->addField($f1);

        return $form;
    }

    public function getResetPwdForm(){
        $container = Container::getInstance();

        /** @var Form $form */
        $form = $container->offsetGet('wwp.forms.form');
        $form->setName('er-resetpwd-form');

        $f1 = new PasswordField('er-pwd',null,['label'=>__('password',WWP_ER_TEXTDOMAIN)]);
        $form->addField($f1);

        $f2 = new PasswordField('er-pwd-confirm',null,['label'=>__('password_again',WWP_ER_TEXTDOMAIN)]);
        $form->addField($f2);

        return $form;
    }

}