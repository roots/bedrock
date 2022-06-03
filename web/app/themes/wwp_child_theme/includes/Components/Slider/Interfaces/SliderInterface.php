<?php

namespace WonderWp\Theme\Child\Components\Slider\Interfaces;

use WonderWp\Theme\Core\Component\ComponentInterface;

interface SliderInterface extends ComponentInterface
{
    /**
     * @param mixed $sliderItems
     *
     * @return static
     */
    public function setSliderItems($sliderItems);

    /**
     * @param mixed $class
     *
     * @return static
     */
    public function setClass($class);
}
