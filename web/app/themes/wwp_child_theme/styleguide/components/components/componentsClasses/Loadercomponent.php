<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 23/09/2016
 * Time: 15:12
 */

namespace WonderWp\Theme\Components;


class Loadercomponent extends AbstractComponent
{
    private $_templates;

    public function __construct()
    {
        $this->_templates = array(
            'loader' => '<span class="loader"></span>',
            'loader-small' => '<span class="loader small"></span>',
            'loader-alt' => '<span class="loader-alt"></span>',
            'loader-alt-small' => '<span class="loader-alt small"></span>'
        );
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->_templates;
    }

    public function getMarkup($opts = array())
    {
        $tpl = !empty($opts['tpl']) ? $opts['tpl'] : 'loader';
        return $this->_templates[$tpl];
    }
}