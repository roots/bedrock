<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:22
 */

namespace WonderWp\Theme\Child\Components\Slider\SliderDefault;

use WonderWp\Plugin\Slider\Component\SliderComponentInterface;
use WonderWp\Plugin\Slider\Component\TwigSliderComponentTrait;
use WonderWp\Theme\Core\Component\TwigComponent;

class SliderComponent extends TwigComponent implements SliderComponentInterface
{
    use TwigSliderComponentTrait;

    protected $markups;

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

    public function __construct($templatesDir = null, $templateName = null)
    {
        parent::__construct(__DIR__, 'slider');
    }
}
