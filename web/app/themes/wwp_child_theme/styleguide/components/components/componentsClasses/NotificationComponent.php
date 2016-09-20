<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 16/09/2016
 * Time: 18:14
 */

namespace WonderWp\Theme\Components;


class NotificationComponent extends AbstractComponent
{
    private $_notif = array();

    /**
     * @param array $notif
     */
    public function setNotif($type,$message)
    {
        $this->_notif = ['type'=>$type,'msg'=>$message];
        return $this;
    }

    public function getMarkup()
    {
        $markup = '<div class="alert alert-'.$this->_notif['type'].'" role="alert">
          '.$this->_notif['msg'].'
        </div>';

        return $markup;
    }

}