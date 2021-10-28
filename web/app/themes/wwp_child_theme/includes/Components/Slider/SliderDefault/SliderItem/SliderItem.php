<?php
/**
 * Created by PhpStorm.
 * User: mathieudelafosse
 * Date: 05/01/2018
 * Time: 17:44
 */

namespace WonderWp\Theme\Child\Components\Slider\SliderDefault\SliderItem;

use WonderWp\Plugin\Slider\Component\SlideComponentInterface;
use WonderWp\Plugin\Slider\Component\TwigSlideComponentTrait;
use WonderWp\Theme\Core\Component\TwigComponent;

class SliderItem extends TwigComponent implements SlideComponentInterface
{
    use TwigSlideComponentTrait;

    public function __construct($templatesDir = null, $templateName = null)
    {
        if (empty($templatesDir)) {
            $templatesDir = __DIR__;
        }
        if (empty($templateName)) {
            $templateName = 'slider-item';
        }
        parent::__construct($templatesDir, $templateName);
    }

}
