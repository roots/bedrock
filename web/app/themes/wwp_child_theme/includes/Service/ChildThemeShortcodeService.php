<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 09:46
 */

namespace WonderWp\Theme\Child\Service;

use WonderWp\Theme\Child\Components\Card\CardComponent;
use WonderWp\Theme\Child\Components\Modal\ModalComponent;
use WonderWp\Theme\Child\Components\Slider\SliderComponent;
use WonderWp\Theme\Child\Components\Slider\SliderItem\SliderItem;
use WonderWp\Theme\Child\Components\Timeline\TimelineComponent;
use WonderWp\Theme\Child\Components\Timeline\TimelineItem\TimelineItem;
use WonderWp\Theme\Core\Service\ThemeShortcodeService;

class ChildThemeShortcodeService extends ThemeShortcodeService
{

    public function registerShortcodes()
    {
        parent::registerShortcodes();

        add_shortcode('slider', [$this, 'slider']);
        add_shortcode('slider-item', [$this, 'slideritem']);
        add_shortcode('modal', [$this, 'modal']);
        add_shortcode ('card', [$this, 'card']);
        add_shortcode ('timeline', [$this, 'timeline']);
        add_shortcode ('timeline-item', [$this, 'timelineitem']);

        return $this;
    }

    // Slider wrapper
    public function slider($attr, $content)
    {
        $slider = new SliderComponent();
        $slider->fillWith($attr);

        $sliderItems = [];

        $shortcodes = $this->extractShortcodes($content, 'slider-item');
        foreach ($shortcodes as $shortcode) {
            array_push($sliderItems, do_shortcode($shortcode)); // push slider item markup to slider component
        }
        $slider->sliderItems = $sliderItems;

        return $slider->getMarkup();

    }

    // Slider item
    public function slideritem($attr, $content)
    {
        $slideritem = new SliderItem();
        $slideritem->fillWith($attr);

        if (isset($content) && !empty($content)) {
            $slideritem->content = $content;
        }

        return $slideritem->getMarkup();
    }

    // Timeline wrapper
    public function timeline($attr, $content)
    {
        $timeline = new TimelineComponent();
        $timeline->fillWith($attr);

        $timelineItems = [];

        $shortcodes = $this->extractShortcodes($content, 'timeline-item');
        foreach ($shortcodes as $shortcode) {
            array_push($timelineItems, do_shortcode($shortcode)); // push timeline item markup to timeline component
        }
        $timeline->timelineItems = $timelineItems;

        return $timeline->getMarkup();
    }

    // Timeline item
    public function timelineitem($attr, $content)
    {
        $timelineitem = new TimelineItem();
        $timelineitem->fillWith ($attr);

        if (isset($content) && !empty($content)) {
            $timelineitem->content = $content;
        }

        return $timelineitem->getMarkup();
    }

    // Modale
    public function modal($attr, $content) {
        $modal = new ModalComponent();
        $modal->fillWith($attr);

        if (isset($content) && !empty($content)) {
            $modal->content = $content;
        }

        return $modal->getMarkup();
    }

    // Generic card
    public function card($attr) {
        $card = new CardComponent();
        $card->fillWith ($attr);

        return $card->getMarkup();
    }

}
