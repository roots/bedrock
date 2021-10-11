<?php

namespace WonderWp\Theme\Child\Components\Citation;

use WonderWp\Theme\Core\Component\AbstractComponent;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;

/**
 * @Block(title="Citation")
 *
 */
class CitationComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Citation"})
     */
    protected $blockquote;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Nom de l'auteur"})
     */
    protected $author;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Fonction de l'auteur"})
     */
    protected $function;

    /**
     * @param string $blockquote
     * @return CitationComponent
     */
    public function setBlockquote(string $blockquote): CitationComponent
    {
        $this->blockquote = $blockquote;
        return $this;
    }

    /**
     * @param string $author
     * @return CitationComponent
     */
    public function setAuthor(string $author): CitationComponent
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @param string $function
     * @return CitationComponent
     */
    public function setFunction(string $function): CitationComponent
    {
        $this->function = $function;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<div class="blockquote-wrapper">';

        if(!empty($this->blockquote)) {
            $markup .= '<blockquote class="citation">'.$this->blockquote.'</blockquote>';
        }

        if(!empty($this->author)) {
            $markup .= '<span class="cite-name">'.$this->author.'</span>';
        }

        if(!empty($this->function)) {
            $markup .= '<span class="cite-function">'.$this->function.'</span>';
        }
        $markup .= '</div>';

        return $markup;
    }
}
