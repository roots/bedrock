<?php
/**
 * Created by PhpStorm.
 * User: mathieudelafosse
 * Date: 05/01/2018
 * Time: 17:44
 */

namespace WonderWp\Theme\Child\Components\Slider\SliderItem;


use WonderWp\Theme\Core\Component\TwigComponent;

class SliderItem extends TwigComponent
{

    protected $img;
    protected $title;
    protected $link;

    public function __construct()
    {
        parent::__construct(__DIR__, 'slider-item');
    }

}