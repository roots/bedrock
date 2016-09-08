<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredienttrad
 *
 * @Table(name="ingredientTrad", indexes={@Index(name="IDX_C64585F2933FE08C", columns={"ingredient_id"})})
 * @Entity
 */
class IngredientTrad
{
    /**
     * @var string
     *
     * @Column(name="locale", type="string", length=6, nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $locale;

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var \Ingredient
     *
     * @Id
     * @GeneratedValue(strategy="NONE")
     * @OneToOne(targetEntity="Ingredient")
     * @JoinColumns({
     *   @JoinColumn(name="ingredient_id", referencedColumnName="id")
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
