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
 * @ORM\Table(name="ingredient")
 * @ORM\Entity
 */
class Ingredient extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=140, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=140, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="EtapeIngredient", mappedBy="ingredient", cascade={"persist", "remove"}, orphanRemoval=TRUE))
     */
    private $etapeIngredients;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="RecetteEntity", mappedBy="ingredients", fetch="EXTRA_LAZY")
     */
    private $recettes;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="IngredientTrad", mappedBy="ingredient", cascade={"persist", "remove"}, orphanRemoval=TRUE))
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etapeIngredients = new ArrayCollection();
        $this->recettes = new ArrayCollection();
        $this->translations = new ArrayCollection();
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

    public function getTranslation($locale){
        $trad=null;
        $translations = $this->getTranslations();
        if (!empty($translations)) {
            $trad = $translations->filter(function ($item) use ($locale) {
                return $item->getLocale() == $locale;
            })->first();
        }
        return $trad;
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
    public function removeTranslation(IngredientTrad $trad)
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

    /**
     * @return mixed
     */
    public function getEtapeIngredients()
    {
        return $this->etapeIngredients;
    }

    public function addEtapeIngredient(EtapeIngredient $etapeIngredient)
    {
        if (!$this->etapeIngredients->contains($etapeIngredient)) {
            $this->etapeIngredients->add($etapeIngredient);
            $etapeIngredient->setIngredient($this);
        }

        return $this;
    }

    public function removeEtapeIngredient(EtapeIngredient $etapeIngredient)
    {
        if ($this->etapeIngredients->contains($etapeIngredient)) {
            $this->etapeIngredients->removeElement($etapeIngredient);
            $etapeIngredient->setIngredient(null);
        }

        return $this;
    }


}
