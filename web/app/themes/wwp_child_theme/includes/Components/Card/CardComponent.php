<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:22
 */

namespace WonderWp\Theme\Child\Components\Card;

use WonderWp\Theme\Core\Component\TwigComponent;

class CardComponent extends TwigComponent
{
    protected $title;
    protected $text;
    protected $img;
    protected $link;
    protected $button;
    protected $color = '';
    protected $background = '';
    protected $class = '';

    public function __construct()
    {
        parent::__construct(__DIR__, 'Card');
    }
}