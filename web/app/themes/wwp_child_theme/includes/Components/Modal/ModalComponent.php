<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:22
 */

namespace WonderWp\Theme\Child\Components\Modal;

use WonderWp\Theme\Core\Component\TwigComponent;

class ModalComponent extends TwigComponent
{
    protected $class; // corresponds to the domSelector from PewJS
    protected $label;
    protected $content;

    public function __construct()
    {
        parent::__construct(__DIR__, 'modal');
    }
}