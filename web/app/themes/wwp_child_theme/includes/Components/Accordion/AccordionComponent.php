<?php

namespace WonderWp\Theme\Child\Components\Accordion;

use WonderWp\Theme\Core\Component\AbstractComponent;
use function WonderWp\Functions\array_merge_recursive_distinct;
use function WonderWp\Functions\paramsToHtml;

/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 09:52
 */
class AccordionComponent extends AbstractComponent
{
    private $_blocks;

    public function addBlock($title, $content, $id = '', $opened = false)
    {
        $this->_blocks[] = ['title' => $title, 'content' => $content, 'id' => $id, 'opened' => $opened];
    }

    public function getMarkup(array $opts = [])
    {
        if (empty($opts['id'])) {
            $opts['id'] = 'accordion-' . uniqid();
        }
        $markup = '';
        if (!empty($this->_blocks)) {
            $defaultClass      = 'js-accordion';
            $defaultAttributes = [
                'class'                         => [$defaultClass],
                'data-accordion-prefix-classes' => "my-accordion-name",
            ];
            if (isset($opts['class'])) {
                if (is_string($opts['class'])) {
                    $opts['class'] = $defaultClass . ' ' . $opts['class'];
                } elseif (is_array($opts['class'])) {
                    array_unshift($opts['class'], $defaultClass);
                }
            }
            $params = array_merge_recursive_distinct($defaultAttributes, $opts);

            $markup .= '<div ' . paramsToHtml($params) . '>';
            foreach ($this->_blocks as $block) {
                $idAttr = !empty($block['id']) ? 'id="' . $block['id'] . '"' : '';
                $markup .= '
                <span class="js-accordion__header" ' . (!empty($block['opened']) ? 'data-accordion-opened="true"' : '') . '>' . $block['title'] . '</span>
                <div class="js-accordion__panel" ' . $idAttr . '>
                    ' . $block['content'] . '
                </div>
                ';
            }
            $markup .= '</div>';
        }

        return $markup;
    }

}
