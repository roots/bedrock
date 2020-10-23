<?php
/**
 * Created by PhpStorm.
 * User: marclafay
 * Date: 05/02/2018
 * Time: 19:13
 */

namespace WonderWp\Theme\Child\Components\Timeline\TimelineItem;

use WonderWp\Theme\Core\Component\TwigComponent;

class TimelineItem extends TwigComponent
{

    /** @var string */
    protected $date;
    /** @var string */
    protected $text;
    /** @var string */
    protected $img;
    /** @var string */
    protected $alt;
    /** @var string */
    protected $link;
    /** @var string */
    protected $liClass;
    /** @var string */
    protected $timelineItems;

    /**
     * @param string $date
     *
     * @return static
     */
    public function setDate(string $date)
    {
        return parent::__set('date', $date);
    }

    /**
     * @param string $text
     *
     * @return static
     */
    public function setText(string $text)
    {
        return parent::__set('text', $text);
    }

    /**
     * @param string $img
     *
     * @return static
     */
    public function setImg(string $img)
    {
        return parent::__set('img', $img);
    }

    /**
     * @param string $alt
     *
     * @return static
     */
    public function setAlt(string $alt)
    {
        return parent::__set('alt', $alt);
    }

    /**
     * @param string $link
     *
     * @return static
     */
    public function setLink(string $link)
    {
        return parent::__set('link', $link);
    }

    /**
     * @param string $liClass
     *
     * @return static
     */
    public function setLiClass(string $liClass)
    {
        return parent::__set('liClass', $liClass);
    }

    /**
     * @param mixed $timelineItems
     *
     * @return static
     */
    public function setTimelineItems($timelineItems)
    {
        return parent::__set('timelineItems', $timelineItems);
    }

    public function __construct()
    {
        parent::__construct(__DIR__, 'timeline-item');
    }

}
