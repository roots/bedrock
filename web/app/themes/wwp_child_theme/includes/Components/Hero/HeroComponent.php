<?php
/**
 * Created by PhpStorm.
 * User: marclafay
 * Date: 23/09/2021
 */

namespace WonderWp\Theme\Child\Components\Hero;

use WonderWp\Theme\Core\Component\AbstractComponent;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockOptions;

/**
 * @Block(title="Hero")
 */
class HeroComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Titre"})
     */
    protected $title;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Chapo"})
     */
    protected $chapo;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Texte"})
     */
    protected $text;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Lien"})
     */
    protected $link;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Label lien"})
     */
    protected $label;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"placeholder":"Image","size":"large"})
     */
    protected $image;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Opacité image (50 par défaut"})
     */
    protected $imageopacity;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Couleur de fond hexadécimale"})
     */
    protected $color;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Mix blend mode (valeur css)"})
     */
    protected $mixblendmode;

    /**
     * @var string
     * @BlockAttributes(component="InnerBlocks",type="string",componentAttributes={"placeholder":"Contenu libre"})
     */
    protected $subComponents;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Contenu à gauche"})
     */
    protected $alignleft;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Petit contenu"})
     */
    protected $smallcontent;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Mobile petite hauteur"})
     */
    protected $smallmobile;

    /**
     * @param string $title
     * @return HeroComponent
     */
    public function setTitle(string $title): HeroComponent
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $text
     * @return HeroComponent
     */
    public function setText(string $text): HeroComponent
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $link
     * @return HeroComponent
     */
    public function setLink(string $link): HeroComponent
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @param string $label
     * @return HeroComponent
     */
    public function setlabel(string $label): HeroComponent
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string $image
     * @return HeroComponent
     */
    public function setImage(string $image): HeroComponent
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param string $imageopacity
     * @return HeroComponent
     */
    public function setImageopacity(string $imageopacity): HeroComponent
    {
        $this->imageopacity = $imageopacity;
        return $this;
    }

    /**
     * @param string $color
     * @return HeroComponent
     */
    public function setColor(string $color): HeroComponent
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @param string $mixblendmode
     * @return HeroComponent
     */
    public function setMixblendmode(string $mixblendmode): HeroComponent
    {
        $this->mixblendmode = $mixblendmode;
        return $this;
    }

    /**
     * @param string $subComponents
     * @return HeroComponent
     */
    public function setSubComponents(string $subComponents): HeroComponent
    {
        $this->subComponents = $subComponents;
        return $this;
    }

    /**
     * @param bool $alignleft
     * @return HeroComponent
     */
    public function setAlignleft(bool $alignleft): HeroComponent
    {
        $this->alignleft = $alignleft;
        return $this;
    }

    /**
     * @param bool $smallcontent
     * @return HeroComponent
     */
    public function setSmallcontent(bool $smallcontent): HeroComponent
    {
        $this->smallcontent = $smallcontent;
        return $this;
    }

    /**
     * @param string $chapo
     * @return HeroComponent
     */
    public function setChapo(string $chapo): HeroComponent
    {
        $this->chapo = $chapo;
        return $this;
    }

    /**
     * @param bool $smallmobile
     * @return HeroComponent
     */
    public function setSmallmobile(bool $smallmobile): HeroComponent
    {
        $this->smallmobile = $smallmobile;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<div class="hero-component';

        if (!empty($this->image)) {
            $markup .= ' has-image ';
        }
        if ($this->alignleft == true) {
            $markup .= ' is-textleft ';
        }
        if ($this->smallcontent == true) {
            $markup .= ' is-small-content ';
        }
        if ($this->smallmobile == true) {
            $markup .= ' is-small-mobile-height ';
        }
        if (!empty($this->imageopacity)) {
            $markup .= ' image-opacity-'.$this->imageopacity.' ';
        }
        $markup .= '">';

        if (!empty($this->image)) {
            $markup .= '<div class="image-wrapper"';
                if (!empty($this->color)) {
                    $markup .= 'style="background-color:'.$this->color.'"';
                }
            $markup .= '>
                <div class="mix-blend-mode"';
                    if (!empty($this->mixblendmode)) {
                        $markup .= 'style="mix-blend-mode:'.$this->mixblendmode.'"';
                    }
                $markup .= '>' . $this->image . '</div>
            </div>';
        }

        $markup .= '<div class="hero-content container">';
        if (!empty($this->title)) {
            $markup .= '<h2 class="title">' . $this->title . '</h2>';
        }
        if (!empty($this->chapo)) {
            $markup .= '<p class="chapo">' . $this->chapo . '</p>';
        }
        if (!empty($this->text)) {
            $markup .= '<p>' . $this->text . '</p>';
        }
        if (!empty($this->link)) {
            $markup .= '<a class="btn--cta" href="' . $this->link . '">' . $this->label . '</a>';
        }
        if (!empty($this->subComponents)) {
            $markup .= $this->subComponents;
        }
        $markup .= '</div>';

        $markup .= '</div>';

        return $markup;
    }
}
