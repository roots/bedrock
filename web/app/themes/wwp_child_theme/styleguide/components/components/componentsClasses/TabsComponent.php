<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 11:36
 */

namespace WonderWp\Theme\Components;

use WonderWp\Theme\Core\Component\AbstractComponent;

class TabsComponent extends AbstractComponent
{

    private $_blocks;

    public function addBlock($title, $content)
    {
        $this->_blocks[] = ['title' => $title, 'content' => $content];
    }

    public function getMarkup(array $opts = [])
    {
        $markup     = '';
        $listMarkup = '';
        $tabsMarkup = '';
        if (!empty($this->_blocks)) {
            $markup .= '<div class="js-tabs">';
            $listMarkup .= '<ul class="js-tablist">';
            foreach ($this->_blocks as $i => $block) {
                $listMarkup .= '<li class="js-tablist__item">
                    <a href="#tab' . $i . '" class="js-tablist__link">' . $block['title'] . '</a>
                </li>';
                $tabsMarkup .= '<div id="tab' . $i . '" class="js-tabcontent">' . $block['content'] . '</div>';
            }
            $listMarkup .= '</ul>';
            $markup .= $listMarkup;
            $markup .= $tabsMarkup;
            $markup .= '</div>';
        }

        return $markup;
    }

}
