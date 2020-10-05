<?php

namespace WonderWp\Theme\Child\Components\Card;

use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;

/**
 * Class CardComponent
 * @package WonderWp\Theme\Child\Components\Card
 * @Block(title="Card Component")
 */
class CardComponent extends \WonderWp\Theme\Core\Component\CardComponent
{
    //Should the link in card be inside or around the component?
    //true : around
    //false : inside
    protected static $wrapLinkAroundDefault = true;
}
