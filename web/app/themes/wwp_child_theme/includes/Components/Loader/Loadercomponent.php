<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 23/09/2016
 * Time: 15:12
 */

namespace WonderWp\Theme\Child\Components\Loader;

use WonderWp\Theme\Core\Component\AbstractComponent;

class Loadercomponent extends AbstractComponent
{
    private $_templates;

    public function __construct()
    {
        $this->_templates = array(
            'loader' => '<span class="loader"></span>',
            'loader-small' => '<span class="loader loader--small"></span>',
            'loader-alt' => '<span class="loader loader--alt"></span>',
            'loader-alt-small' => '<span class="loader loader--alt loader--small"></span>'
        );
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->_templates;
    }

    public function getMarkup(array $opts = array())
    {
        $tpl = !empty($opts['tpl']) ? $opts['tpl'] : 'loader';
        return $this->_templates[$tpl];
    }
}
