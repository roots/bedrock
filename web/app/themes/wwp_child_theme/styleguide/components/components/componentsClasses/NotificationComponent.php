<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 16/09/2016
 * Time: 18:14
 */

namespace WonderWp\Theme\Components;


use WonderWp\Notification\AdminNotification;

class NotificationComponent extends AdminNotification implements ComponentInterface
{
    public static $template = '<div class="alert alert-{type}" role="alert">{message}</div>';

    public function getMarkup($opts=array())
    {
        $markup=str_replace(array('{type}','{message}'),array($this->_type,$this->_message),self::$template);

        return $markup;
    }

}