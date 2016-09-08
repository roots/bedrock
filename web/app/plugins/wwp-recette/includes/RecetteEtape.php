<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntity;

/**
 * Recetteetape
 *
 * @Table(name="recetteEtape", indexes={@Index(name="fk_recetteEtape_recette1_idx", columns={"recette_id"})})
 * @Entity
 */
class RecetteEtape extends AbstractEntity
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @Column(name="media", type="string", length=140, nullable=true)
     */
    private $media;

    /**
     * @var string
     *
     * @Column(name="content", type="text", length=65535, nullable=true)
     */
    private $content;

    /**
     * @var \Recette
     *
     * @ManyToOne(targetEntity="RecetteEntity")
     * @JoinColumns({
     *   @JoinColumn(name="recette_id", referencedColumnName="id")
     * })
     */
    private $recette;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Ingredient", mappedBy="recetteEtapes")
     */
    private $ingredients;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param string $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return \Recette
     */
    public function getRecette()
    {
        return $this->recette;
    }

    /**
     * @param \Recette $recette
     */
    public function setRecette($recette)
    {
        $this->recette = $recette;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIngredients()
    {
        if(is_null($this->ingredients)){
            $this->ingredients = new ArrayCollection();
        }
        return $this->ingredients;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * @param Ingredient $ingredient
     * @return bool
     */
    public function addIngredient(Ingredient $ingredient)
    {
        if(is_null($this->ingredients)){
            $this->ingredients = new ArrayCollection();
        }

        $colIngredienIds = $this->ingredients->map(function ($entity) {
            return $entity->getId();
        })->toArray();

        if (in_array($ingredient->getId(),$colIngredienIds)) {
            return false;
        }

        $this->ingredients->add($ingredient);
        $ingredient->addRecetteEtape($this);
        return true;
    }

    /**
     * @param Ingredient $ingredient
     * @return bool
     */
    public function removeIngredient(Ingredient $ingredient)
    {
        if(is_null($this->ingredients)){
            $this->ingredients = new ArrayCollection();
        }

        $colIngredientIds = $this->ingredients->map(function ($entity) {
            return $entity->getId();
        })->toArray();

        if (!in_array($ingredient->getId(),$colIngredientIds)) {
            return false;
        }

        $this->ingredients->removeElement($ingredient);
        $ingredient->removeRecetteEtape($this);
        return true;
    }

}
