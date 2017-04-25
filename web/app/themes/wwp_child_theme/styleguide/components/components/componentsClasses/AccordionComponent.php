<?php

namespace WonderWp\Theme\Components;

use WonderWp\Theme\Core\Component\AbstractComponent;

/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 09:52
 */
class AccordionComponent extends AbstractComponent
{
    private $_blocks;

    public function addBlock($title,$content){
        $this->_blocks[] = ['title'=>$title,'content'=>$content];
    }

    public function getMarkup(array $opts=array())
    {
        $markup = '';
        if(!empty($this->_blocks)){
            $markup.='<div class="js-accordion" data-accordion-prefix-classes="my-accordion-name">';
            foreach($this->_blocks as $block){
                $markup.='<h2 class="js-accordion__header">'.$block['title'].'</h2>
                <div class="js-accordion__panel">
                    '.$block['content'].'
                </div>';
            }
            $markup.='</div>';
        }
        return $markup;
    }

}
