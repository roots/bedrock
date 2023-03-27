<?php

namespace WonderWp\Theme\Child\Components\ToggleContentViaFilter;

use WonderWp\Theme\Core\Component\AbstractComponent;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;
use function WonderWp\Functions\paramsToHtml;

/**
 * @Block(title="TCVF Item")
 *
 */
class TcvfItemComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Titre"})
     */
    protected $title;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Texte"})
     */
    protected $text;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"placeholder":"Image"})
     */
    protected $image;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Couleur de fond"})
     */
    protected $background;

    /**
     * @var string
     * @BlockAttributes(component="InnerBlocks",type="string",componentAttributes={"placeholder":"Contenu libre"})
     */
    protected $subComponents;

    /**
     * @param string $title
     * @return TcvfItemComponent
     */
    public function setTitle(string $title): TcvfItemComponent
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $text
     * @return TcvfItemComponent
     */
    public function setText(string $text): TcvfItemComponent
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $image
     * @return TcvfItemComponent
     */
    public function setImage(string $image): TcvfItemComponent
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param string $background
     * @return TcvfItemComponent
     */
    public function setBackground(string $background): TcvfItemComponent
    {
        $this->background = $background;
        return $this;
    }

    /**
     * @param string $subComponents
     * @return TcvfItemComponent
     */
    public function setSubComponents(string $subComponents): TcvfItemComponent
    {
        $this->subComponents = $subComponents;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<div class="tcvf-item-component ';
        if (!empty($this->background)) {
            $markup .= 'is-' . $this->background;
        }
        $markup .= ' ">';

        $markup .= '<a href="" data-trigger>';
        if (!empty($this->title)) {
            $markup .= '<p class="title h3-like"><span>' . $this->title . '</span></p>';
        }
        if (!empty($this->text)) {
            $markup .= '<p class="text">' . $this->text . '</p>';
        }
        $markup .= '</a>';

        if (!empty($this->image) || !empty($this->subComponents)) {
            $contentAttributes = [
                'data-content' => '',
                'class'        => ['content']
            ];
            if (!empty($this->background)) {
                $contentAttributes['class'][]                     = $this->background;
                $contentAttributes['data-content-part-attribute'] = $this->background;
            }
            if (!empty($this->image)) {
                $markup .= '<div ' . paramsToHtml($contentAttributes) . '>' . $this->image . '</div>';
            }
            if (!empty($this->subComponents)) {
                $markup .= '<div ' . paramsToHtml($contentAttributes) . '>' . $this->subComponents . '</div>';
            }
        }

        $markup .= '</div>';

        return $markup;
    }
}
