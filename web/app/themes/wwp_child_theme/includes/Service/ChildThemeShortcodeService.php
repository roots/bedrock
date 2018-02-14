<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 09:46
 */

namespace WonderWp\Theme\Child\Service;

use WonderWp\Theme\Child\Components\Modal\ModalComponent;
use WonderWp\Theme\Child\Components\Slider\SliderComponent;
use WonderWp\Theme\Child\Components\Slider\SliderItem\SliderItem;
use WonderWp\Theme\Core\Service\ThemeShortcodeService;

class ChildThemeShortcodeService extends ThemeShortcodeService
{
    public function registerShortcodes()
    {
        parent::registerShortcodes();

        add_shortcode('slider', [$this, 'slider']);
        add_shortcode('slider-item', [$this, 'slideritem']);
        add_shortcode('modal', [$this, 'modal']);

        return $this;
    }

    public function slider($attr, $content)
    {
        $slider      = new SliderComponent();
        $slider->fillWith($attr);

        $sliderItems = [];

        $shortcodes = $this->extractShortcodes($content, 'slider-item');
        foreach ($shortcodes as $shortcode) {
            array_push($sliderItems, do_shortcode($shortcode)); // push slider item markup to slider component
        }
        $slider->sliderItems = $sliderItems;

        return $slider->getMarkup();

    }

    public function slideritem($attr, $content)
    {
        $slideritem = new SliderItem();
        $slideritem->fillWith($attr);

        if (isset($content) && !empty($content)) {
            $slideritem->content = $content;
        }

        return $slideritem->getMarkup();
    }

    public function modal($attr, $content) {
        $modal = new ModalComponent();
        $modal->fillWith($attr);

        if (isset($content) && !empty($content)) {
            $modal->content = $content;
        }

        return $modal->getMarkup();
    }
}
