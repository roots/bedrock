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
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Surtitre"})
     */
    protected $subtitle;

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
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Couleur de thème"})
     */
    protected $color;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"placeholder":"Image de fond","size":"large"})
     */
    protected $image;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"placeholder":"Image","size":"small"})
     */
    protected $logo;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"placeholder":"Icônes","size":"small"})
     */
    protected $icons;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Opacité image (50 par défaut)"})
     */
    protected $imageOpacity;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Couleur de fond hexadécimale"})
     */
    protected $bgColor;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Mix blend mode (valeur css)"})
     */
    protected $mixBlendMode;

    /**
     * @var string
     * @BlockAttributes(component="InnerBlocks",type="string",componentAttributes={"placeholder":"Contenu libre"})
     */
    protected $subComponents;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Taille du titre réduite"})
     */
    protected $titleSmall;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Contenu aligné à gauche"})
     */
    protected $alignLeft;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Contenu aligné en bas"})
     */
    protected $alignBottom;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Petit contenu"})
     */
    protected $smallContent;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Hauteur du bloc réduite"})
     */
    protected $smallHeight;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Hauteur du bloc réduite sur mobile"})
     */
    protected $smallMobileHeight;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Lien sortant"})
     */
    protected $externalLink;

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
     * @param string $subtitle
     * @return HeroComponent
     */
    public function setSubtitle(string $subtitle): HeroComponent
    {
        $this->subtitle = $subtitle;
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
    public function setLabel(string $label): HeroComponent
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
     * @param string $logo
     * @return HeroComponent
     */
    public function setLogo(string $logo): HeroComponent
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * @param string $icons
     * @return HeroComponent
     */
    public function setIcons(string $icons): HeroComponent
    {
        $this->icons = $icons;
        return $this;
    }

    /**
     * @param string $imageOpacity
     * @return HeroComponent
     */
    public function setimageOpacity(string $imageOpacity): HeroComponent
    {
        $this->imageOpacity = $imageOpacity;
        return $this;
    }

    /**
     * @param string $mixBlendMode
     * @return HeroComponent
     */
    public function setmixBlendMode(string $mixBlendMode): HeroComponent
    {
        $this->mixBlendMode = $mixBlendMode;
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
     * @param string $bgColor
     * @return HeroComponent
     */
    public function setbgColor(string $bgColor): HeroComponent
    {
        $this->bgColor = $bgColor;
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
     * @param bool $alignLeft
     * @return HeroComponent
     */
    public function setalignLeft(bool $alignLeft): HeroComponent
    {
        $this->alignLeft = $alignLeft;
        return $this;
    }

    /**
     * @param bool $alignBottom
     * @return HeroComponent
     */
    public function setalignBottom(bool $alignBottom): HeroComponent
    {
        $this->alignBottom = $alignBottom;
        return $this;
    }

    /**
     * @param bool $smallContent
     * @return HeroComponent
     */
    public function setsmallContent(bool $smallContent): HeroComponent
    {
        $this->smallContent = $smallContent;
        return $this;
    }

    /**
     * @param bool $smallHeight
     * @return HeroComponent
     */
    public function setSmallHeight(bool $smallHeight): HeroComponent
    {
        $this->smallHeight = $smallHeight;
        return $this;
    }

    /**
     * @param bool $smallMobileHeight
     * @return HeroComponent
     */
    public function setsmallMobileHeight(bool $smallMobileHeight): HeroComponent
    {
        $this->smallMobileHeight = $smallMobileHeight;
        return $this;
    }

    /**
     * @param bool $titleSmall
     * @return HeroComponent
     */
    public function setTitleSmall(bool $titleSmall): HeroComponent
    {
        $this->titleSmall = $titleSmall;
        return $this;
    }

    /**
     * @param bool $externalLink
     * @return HeroComponent
     */
    public function setExternalLink(bool $externalLink): HeroComponent
    {
        $this->externalLink = $externalLink;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<div class="hero-component';

        if (!empty($this->color)) {
            $markup .= ' is-color-'.$this->color.' ';
        }

        if (!empty($this->logo)) {
            $markup .= ' has-logo ';
        }

        if (!empty($this->image)) {
            $markup .= ' has-image ';
        }
        if ($this->titleSmall == true) {
            $markup .= ' is-smalltitle ';
        }
        if ($this->alignLeft == true) {
            $markup .= ' is-textleft ';
        }
        if ($this->alignBottom == true) {
            $markup .= ' is-textbottom ';
        }
        if ($this->smallContent == true) {
            $markup .= ' is-small-content ';
        }
        if ($this->smallHeight == true) {
            $markup .= ' is-small-height ';
        }
        if ($this->smallMobileHeight == true) {
            $markup .= ' is-small-mobile-height ';
        }
        if (!empty($this->imageOpacity)) {
            $markup .= ' image-opacity-'.$this->imageOpacity.' ';
        }
        $markup .= '">';

        if (!empty($this->image)) {
            $markup .= '<div class="image-wrapper"';
                if (!empty($this->bgColor)) {
                    $markup .= 'style="background-color:'.$this->bgColor.'"';
                }
            $markup .= '>
                <div class="mix-blend-mode"';
                    if (!empty($this->mixBlendMode)) {
                        $markup .= 'style="mix-blend-mode:'.$this->mixBlendMode.'"';
                    }
                $markup .= '>' . $this->image . '</div>
            </div>';
        }

        $markup .= '<div class="hero-content container">';
        if (!empty($this->subtitle)) {
            $markup .= '<p class="subtitle">' . $this->subtitle . '</p>';
        }
        if (!empty($this->title)) {
            $markup .= '<h2 class="title">' . $this->title . '</h2>';
        }
        if (!empty($this->chapo)) {
            $markup .= '<p class="chapo">' . $this->chapo . '</p>';
        }
        if (!empty($this->icons)) {
            $markup .= '<div class="icons-wrapper">' . $this->icons . '</div>';
        }
        if (!empty($this->text)) {
            $markup .= '<p class="text">' . $this->text . '</p>';
        }
        if (!empty($this->subComponents)) {
            $markup .= '<div class="content-text">'.$this->subComponents.'</div>';
        }
        if (!empty($this->link)) {
            $markup .= '<a class="btn--cta ';
            if (!empty($this->color)) {
                $markup .= ' btn--'.$this->color;
            }
            $markup .= '" href="' . $this->link . '"';
            if (!empty($this->externalLink)){
                $markup .= 'target="_blank"';
            }
            $markup .='>' . $this->label . '</a>';
        }
        if (!empty($this->logo)) {
            $markup .= '<div class="logo-wrapper">' . $this->logo . '</div>';
        }
        $markup .= '</div>';

        $markup .= '</div>';

        return $markup;
    }
}
