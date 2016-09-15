<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:22
 */

namespace WonderWp\Theme\Components;


class GridComponent extends AbstractComponent
{

    private $_cards = array();

    public function addCard(CardComponent $card)
    {
        $this->_cards[] = $card;
    }

    public function getMarkup()
    {
        $markup='';
        if (!empty($this->_cards)) {
            $markup.='<div class="grid">';
            foreach ($this->_cards as $card) {
                /** @var $card CardComponent */
                $markup.= $card->getMarkup();
            }
            $markup.='</div>';
        }
        return $markup;
    }

}