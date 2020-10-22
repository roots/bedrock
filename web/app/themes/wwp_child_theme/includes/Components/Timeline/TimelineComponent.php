<?php

namespace WonderWp\Theme\Child\Components\Timeline;

use WonderWp\Theme\Core\Component\TwigComponent;

class TimelineComponent extends TwigComponent
{
    protected $timelineItems;
    protected $markups;
    protected $class;

    /**
     * @param mixed $timelineItems
     *
     * @return static
     */
    public function setTimelineItems($timelineItems)
    {
        return parent::__set('timelineItems', $timelineItems);
    }

    /**
     * @param mixed $markups
     *
     * @return static
     */
    public function setMarkups($markups)
    {
        return parent::__set('markups', $markups);
    }

    /**
     * @param mixed $class
     *
     * @return static
     */
    public function setClass($class)
    {
        return parent::__set('class', $class);
    }

    public function __construct()
    {
        parent::__construct(__DIR__, 'timeline');
    }
}
