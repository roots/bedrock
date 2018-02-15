<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:22
 */

namespace WonderWp\Theme\Child\Components\Slider;

use WonderWp\Theme\Core\Component\TwigComponent;

class SliderComponent extends TwigComponent
{
    protected $sliderItems;
    protected $markups;
    protected $class; // add Check to add "wdf-slider" by default

    public function __construct()
    {
        parent::__construct(__DIR__, 'slider');
    }
}