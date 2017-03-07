<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\ORM\Mapping as ORM;

/**
 * IngredientTrad
 *
 * @ORM\Table(name="ingredientTrad", indexes={@ORM\Index(name="IDX_C64585F2933FE08C", columns={"ingredient_id"})})
 * @ORM\Entity
 */
class IngredientTrad
{
    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=6, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=140, nullable=false)
     */
    private $title;

    /**
     * @var \Ingredient
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Ingredient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
     * })
     */
    private $ingredient;

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return \Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * @param \Ingredient $ingredient
     * @return $this
     */
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;
        return $this;
    }

}
