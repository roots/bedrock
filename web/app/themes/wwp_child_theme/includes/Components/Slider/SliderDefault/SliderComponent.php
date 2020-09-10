<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:22
 */

namespace WonderWp\Theme\Child\Components\Slider\SliderDefault;

use WonderWp\Theme\Child\Components\Slider\Interfaces\SliderInterface;
use WonderWp\Theme\Core\Component\TwigComponent;

class SliderComponent extends TwigComponent implements SliderInterface
{
    protected $sliderItems;
    protected $markups;
    protected $class;

    /** @inheritDoc */
    public function setSliderItems($sliderItems)
    {
        $this->__set('sliderItems', $sliderItems);

        return $this;
    }

    /**
     * @param mixed $markups
     *
     * @return static
     */
    public function setMarkups($markups)
    {
        $this->__set('markups', $markups);

        return $this;
    }

    /** @inheritDoc */
    public function setClass($class)
    {
        $this->__set('class', $class);

        return $this;
    } // add Check to add "wdf-slider" by default

    public function __construct($templatesDir = null, $templateName = null)
    {
        parent::__construct(__DIR__, 'slider');
    }
}
