<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:22
 */

namespace WonderWp\Theme\Child\Components\Dropdown;

use WonderWp\Theme\Core\Component\TwigComponent;

class DropdownComponent extends TwigComponent
{
    protected $class;
    protected $content;

    public function __construct()
    {
        parent::__construct(__DIR__, 'dropdown');
    }
}