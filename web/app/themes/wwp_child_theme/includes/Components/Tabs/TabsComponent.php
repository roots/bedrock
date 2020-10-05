<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 11:36
 */

namespace WonderWp\Theme\Child\Components\Tabs;

use WonderWp\Theme\Child\Components\Tabs\TabItem\TabItem;
use WonderWp\Theme\Child\Service\ChildThemeShortcodeService;
use WonderWp\Theme\Core\Component\TwigComponent;

class TabsComponent extends TwigComponent
{
    protected $class;
    protected $content;
    private   $tabs;

    private function setTabItems($tabItems)
    {
        $this->tabItems = $tabItems;

        return $this;
    }

    public function __construct()
    {
        parent::__construct(__DIR__, 'tabs');
    }

    public function addTab($title, $content, $id = "", $class = "", $shortcode = "")
    {
        $tab          = new TabItem();
        $tab->title   = $title;
        $tab->content = $this->extractContent($content, $shortcode);
        $tab->id      = $id;
        $tab->class   = $class;
        $this->tabs[] = $tab;
    }

    private function extractContent($content, $shortcode = "")
    {
        if (!empty($shortcode)) {
            $shortcodes = ChildThemeShortcodeService::extractShortcode($content, $shortcode);
            $markup     = do_shortcode($shortcodes[0]);
        } else {
            $markup = $content;
        }

        return $markup;
    }

    public function getMarkup(array $opts = [])
    {
        $this->setTabItems($this->tabs);

        return parent::getMarkup($opts);
    }
}
