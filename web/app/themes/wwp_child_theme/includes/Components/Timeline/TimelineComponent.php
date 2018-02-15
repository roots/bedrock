<?php
/**
 * Created by PhpStorm.
 * User: marclafay
 * Date: 05/02/2018
 * Time: 18:37
 */

namespace WonderWp\Theme\Components;


use WonderWp\Theme\Core\Component\AbstractComponent;

class TimelineComponent extends AbstractComponent
{
    /**
     * @var TimelineItemComponent[]
     */
    private $items;

    /**
     * @var string
     */
    private $itemsMarkup;

    /**
     * @return mixed
     */
    public function getItemsMarkup()
    {
        return $this->itemsMarkup;
    }

    /**
     * @param mixed $itemsMarkup
     */
    public function setItemsMarkup($itemsMarkup)
    {
        $this->itemsMarkup = $itemsMarkup;
    }

    /**
     * @return TimelineItemComponent[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param TimelineItemComponent[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }


    public function getMarkup(array $opts = [])
    {
        $items = $this->getItems ();
        $itemsMarkup = $this->getItemsMarkup ();

        if (empty($itemsMarkup) && !empty($items)) {
            $itemsMarkup = '';
            foreach ($items as $item) {
                $itemsMarkup .= $item->getMarkup ();
            }
        }

        if (!empty($itemsMarkup)) {
            $classes = !empty($opts['classes']) ? $opts['classes'] : [];
            $markup = '<ul class="timeline ' . implode (' ', $classes) . '">'
                . $itemsMarkup .
                '</ul>';
        }

        return $markup;
    }

}