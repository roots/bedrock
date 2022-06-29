<?php

namespace WonderWp\Theme\Child\Components\Accordion;

use WonderWp\Plugin\GutenbergUtils\Bloc\AccordionBlock\AccordionRow;
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
    /** @var AccordionRow [] */
    private $blocks = [];

    public function addBlock(AccordionRow $accordionRow)
    {
        $this->blocks[] = $accordionRow;
    }

    public function getMarkup(array $opts = [])
    {
        if (empty($opts['id'])) {
            $opts['id'] = 'accordion-' . uniqid();
        }
        $markup = '';
        if (!empty($this->blocks)) {
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
            $wrapParams = array_merge_recursive_distinct($defaultAttributes, $opts);

            $markup .= '<div ' . paramsToHtml($wrapParams) . '>';

            foreach ($this->blocks as $block) {
                $className     = $block->getClasses() ?? 'default';
                $headerParams  = $this->getHeaderParams($block, $className);
                $contentParams = $this->getContentParams($block, $className);

                $markup .= '
                <span ' . paramsToHtml($headerParams) . '>
                    ' . $block->getTitle() . '
                </span>
                <div ' . paramsToHtml($contentParams) . '>
                    ' . $block->getContent() . '
                </div>
                ';
            }
            $markup .= '</div>';
        }

        return $markup;
    }

    protected function getHeaderParams(AccordionRow $block, $className)
    {
        $headerParams = [
            'class'      => ['js-accordion__header', $className . '__header'],
            'data-class' => $className . '__header'
        ];
        if ($block->isOpened()) {
            $headerParams['data-accordion-opened'] = true;
        }
        if (!empty($block->getIllustration())) {
            $headerParams['data-illustration'] = $block->getIllustration()[0];
        }
        return $headerParams;
    }

    protected function getContentParams(AccordionRow $block, $className)
    {
        $contentParams = [
            'class' => ['js-accordion__panel', $className . '__panel']
        ];
        if (!empty($block->getId())) {
            $contentParams['id'] = $block->getId();
        }

        return $contentParams;
    }

}
