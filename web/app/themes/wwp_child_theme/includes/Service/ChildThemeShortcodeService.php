<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 09:46
 */

namespace WonderWp\Theme\Child\Service;

use WonderWp\Theme\Child\Components\Card\CardComponent;
use WonderWp\Theme\Child\Components\Dropdown\DropdownComponent;
use WonderWp\Theme\Child\Components\Modal\ModalComponent;
use WonderWp\Theme\Child\Components\Slider\SliderDefault\SliderComponent;
use WonderWp\Theme\Child\Components\Slider\SliderDefault\SliderItem\SliderItem;
use WonderWp\Theme\Child\Components\Tabs\TabsComponent;
use WonderWp\Theme\Child\Components\Tabs\TabItem\TabItem;
use WonderWp\Theme\Child\Components\Timeline\TimelineComponent;
use WonderWp\Theme\Child\Components\Timeline\TimelineItem\TimelineItem;
use WonderWp\Theme\Core\Service\ThemeShortcodeService;

class ChildThemeShortcodeService extends ThemeShortcodeService
{

    public function register()
    {
        parent::register();

        add_shortcode('slider', [$this, 'slider']);
        add_shortcode('slider-item', [$this, 'slideritem']);
        add_shortcode('modal', [$this, 'modal']);
        add_shortcode('card', [$this, 'card']);
        add_shortcode('timeline', [$this, 'timeline']);
        add_shortcode('timeline-item', [$this, 'timelineitem']);
        add_shortcode('dropdown', [$this, 'dropdown']);
        add_shortcode('tabs', [$this, 'tabs']);
        add_shortcode('tab-item', [$this, 'tabitem']);
        //add_shortcode(MapSearchShortcodeHandler::$shortCode, [MapSearchShortcodeHandler::class, 'handle']);
        add_shortcode('social-share', [$this, 'socialShare']);

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

    // Modale
    public function modal($attr, $content)
    {
        $modal = new ModalComponent();
        $modal->fillWith($attr);

        if (isset($content) && !empty($content)) {
            $modal->content = $content;
        }

        return $modal->getMarkup();
    }

    // Generic card
    public function card($attr)
    {
        $card = new CardComponent();
        $card->fillWith($attr);

        if (!empty($attr['image'])) {
            $card->setImage('<img src="' . $attr['image'] . '" />');
        }

        return $card->getMarkup();
    }

    // Timeline wrapper
    public function timeline($attr, $content)
    {
        $timeline = new TimelineComponent();
        $timeline->fillWith($attr);

        $timelineItems = [];

        $shortcodes = $this->extractShortcodes($content, 'timeline-item');
        foreach ($shortcodes as $shortcode) {
            array_push($timelineItems, do_shortcode($shortcode));
        }
        $timeline->timelineItems = $timelineItems;

        return $timeline->getMarkup();
    }

    // Timeline item
    public function timelineitem($attr)
    {
        $timelineitem = new TimelineItem();
        $timelineitem->fillWith($attr);

        return $timelineitem->getMarkup();
    }

    public function dropdown($attr)
    {
        $modal = new DropdownComponent();
        $modal->fillWith($attr);

        return $modal->getMarkup();
    }

    public function tabs($attr, $content)
    {
        $tabComponent = new TabsComponent();

        $shortcodes = $this->extractShortcodes($content, 'tab-item');
        $nbTabs     = count($shortcodes);

        for ($i = 1; $i <= $nbTabs; $i++) {
            $res = json_decode(do_shortcode($shortcodes[$i - 1]));
            $tabComponent->addTab($res->title, $res->content, $res->id, $res->class);
        }

        return $tabComponent->getMarkup();
    }

    public function tabitem($attr, $content)
    {
        $tabitem = new TabItem();
        $tabitem->fillWith($attr);

        if (isset($content) && !empty($content)) {
            $tabitem->content = $content;
        }

        return json_encode($tabitem, true);
    }

    public static function extractShortcode($content, $element)
    {
        $results = [];

        $pattern = get_shortcode_regex();

        if (preg_match_all('/' . $pattern . '/s', $content, $matches)
            && array_key_exists(2, $matches)
            && in_array($element, $matches[2])) {
            $results = $matches[0];
        }

        return $results;
    }
}
