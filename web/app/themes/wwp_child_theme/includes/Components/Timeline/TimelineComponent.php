<?php

namespace WonderWp\Theme\Child\Components\Timeline;

use WonderWp\Theme\Core\Component\TwigComponent;

class TimelineComponent extends TwigComponent
{
    protected $timelineItems;
    protected $markups;
    protected $class;

    public function __construct()
    {
        parent::__construct(__DIR__, 'timeline');
    }
}