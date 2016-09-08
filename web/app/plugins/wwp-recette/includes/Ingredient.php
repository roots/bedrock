<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use WonderWp\DI\Container;
use WonderWp\Entity\AbstractEntity;

/**
 * Ingredient
 *
 * @Table(name="ingredient")
 * @Entity
 */
class Ingredient extends AbstractEntity
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
     * @Column(name="slug", type="string", length=45, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @Column(name="image", type="string", length=140, nullable=true)
     */
    private $image;



    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="RecetteEtape", inversedBy="ingredients")
     * @JoinTable(name="recetteetape_has_ingredient",
     *   joinColumns={
     *     @JoinColumn(name="ingredient_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="recetteEtape_id", referencedColumnName="id")
     *   }
     * )
     */
    private $recetteEtapes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="RecetteEntity", mappedBy="ingredients")
     */
    private $recettes;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @OneToMany(targetEntity="IngredientTrad", mappedBy="ingredient")
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recetteetape = new ArrayCollection();
        $this->recettes = new ArrayCollection();
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
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecetteEtapes()
    {
        return $this->recetteEtapes;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $recetteEtapes
     */
    public function setRecetteEtapes($recetteEtapes)
    {
        $this->recetteEtapes = $recetteEtapes;
    }

    /**
     * @return Collection
     */
    public function getRecettes()
    {
        return $this->recettes;
    }

    /**
     * @param Collection $recettes
     */
    public function setRecettes($recettes)
    {
        $this->recettes = $recettes;
    }

    /**
     * @return Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param Collection $translations
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    /**
     * @param RecetteEntity $recette
     */
    public function addRecette(RecetteEntity $recette)
    {
        if (!$this->recettes instanceof ArrayCollection) {
            $this->recettes = new ArrayCollection();
        }
        if ($this->recettes->contains($recette)) {
            return;
        }
        $this->recettes->add($recette);
        $recette->addIngredient($this);
    }

    /**
     * @param RecetteEntity $recette
     */
    public function removeRecette(RecetteEntity $recette)
    {
        if (!$this->recettes instanceof ArrayCollection) {
            $this->recettes = new ArrayCollection();
        }
        if (!$this->recettes->contains($recette)) {
            return;
        }
        $this->recettes->removeElement($recette);
        $recette->removeIngredient($this);
    }

    /**
     * @param RecetteEtape $recetteEtape
     */
    public function addRecetteEtape(RecetteEtape $recetteEtape)
    {
        if (!$this->recetteEtapes instanceof ArrayCollection) {
            $this->recetteEtapes = new ArrayCollection();
        }
        if ($this->recetteEtapes->contains($recetteEtape)) {
            return;
        }
        $this->recetteEtapes->add($recetteEtape);
        $recetteEtape->addIngredient($this);
    }

    /**
     * @param RecetteEtape $recette
     */
    public function removeRecetteEtape(RecetteEtape $recetteEtape)
    {
        if (!$this->recetteEtapes instanceof ArrayCollection) {
            $this->recetteEtapes = new ArrayCollection();
        }
        if (!$this->recetteEtapes->contains($recetteEtape)) {
            return;
        }
        $this->recetteEtapes->removeElement($recetteEtape);
        $recetteEtape->removeIngredient($this);
    }

    /**
     * @param IngredientTrad $trad
     * @return bool
     */
    public function addTranslation(IngredientTrad $trad)
    {
        if(is_null($this->translations)){
            $this->translations = new ArrayCollection();
        }
        if ($this->translations->contains($trad)) {
            return false;
        }
        $this->translations->add($trad);
        return true;
    }

    /**
     * @param IngredientTrad $trad
     * @return bool
     */
    public function removeTranslation(RecetteMeta $trad)
    {
        if(is_null($this->translations)){
            $this->translations = new ArrayCollection();
        }
        if (!$this->translations->contains($trad)) {
            return false;
        }
        $this->translations->removeElement($trad);
        return true;
    }

}
