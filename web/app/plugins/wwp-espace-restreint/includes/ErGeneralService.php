<?php

namespace WonderWp\Plugin\EspaceRestreint;

use WonderWp\DI\Container;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\PasswordField;
use WonderWp\Forms\Form;
use WonderWp\Services\AbstractService;

class ErGeneralService extends AbstractService{

    public function isPostProtected($post){
        if(is_numeric($post)){
            $post = get_post($post);
        }

        if(!is_object($post)){ return false; }

        //Does this post have the er shortcode?
        $ErShortcode ="[wwpmodule slug='wwp-espace-restreint'  ]";
        $isProtected = strpos($post->post_content,$ErShortcode)!==false;

        //if no, check recursively if its parent have it
        if(!$isProtected && !empty($post->post_parent)){
            return $this->isPostProtected($post->post_parent);
        } else {
            return $isProtected;
        }
    }

    public function getLoginUrl(){
        return $this->getTypeUrl('login_url');
    }

    public function getRegisterUrl(){
        return $this->getTypeUrl('register_url');
    }

    public function getForgotPwdUrl(){
        return $this->getTypeUrl('forgotpwd_url');
    }

    public function getResetPwdUrl(){
        return $this->getTypeUrl('resetpwd_url');
    }

    public function getTypeUrl($type){
        $manager = Container::getInstance()->offsetGet('wwp-espace-restreint.Manager');
        if(is_array($manager->getConfig($type))){
            $locale = get_locale();
            $routes = $manager->getConfig($type);
            return !empty($routes[$locale]) ? $routes[$locale] : reset($routes);
        } else {
            return $manager->getConfig($type);
        }
    }

}