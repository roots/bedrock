<?php
/**
 * Created by PhpStorm.
 * User: mathieudelafosse
 * Date: 05/01/2018
 * Time: 17:44
 */

namespace WonderWp\Theme\Child\Components\Tabs\TabItem;

use WonderWp\Theme\Core\Component\AbstractComponent;

class TabItem extends AbstractComponent
{
    public $id;
    public $class;
    public $title;
    public $content;

    public function getMarkup(array $opts = [])
    {
        return '';
    }
}
