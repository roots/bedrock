<?php

namespace WonderWp\Plugin\Recette;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * RecetteEntity
 *
 * @Table(name="recette")
 * @Entity
 */
class RecetteEntity extends \WonderWp\Entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="media", type="string", length=140, nullable=true)
     */
    private $media;

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=6, nullable=false)
     */
    private $locale;

    //-----------------------------------------------------------------------------//

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @OneToMany(targetEntity="RecetteMeta", mappedBy="recette")
     */
    private $metas;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Ingredient", inversedBy="recettes")
     * @JoinTable(name="recette_has_ingredient",
     *   joinColumns={
     *     @JoinColumn(name="recette_id", referencedColumnName="id")
     *
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="ingredient_id", referencedColumnName="id")
     *   }
     * )
     */
    private $ingredients;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @OneToMany(targetEntity="RecetteEtape", mappedBy="recette")
     */
    private $etapes;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }


    /**
     * - Getters and setters ------------------------------------------------------
     */


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set media
     *
     * @param string $media
     * @return RecetteEntity
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return RecetteEntity
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return RecetteEntity
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * @param mixed $metas
     */
    public function setMetas($metas)
    {
        $this->metas = $metas;
    }

    public function getMeta($metaKey){
        if(!empty($this->metas)){
            return $this->metas->get();
        }
    }

    /**
     * @return mixed
     */
    public function getEtapes()
    {
        if(is_null($this->etapes)){
            $this->etapes = new ArrayCollection();
        }
        return $this->etapes;
    }

    /**
     * @param mixed $etapes
     */
    public function setEtapes($etapes)
    {
        $this->etapes = $etapes;
    }

    /**
     * @return Collection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param Collection $ingredients
     */
    public function setIngredient($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * - Relation management ------------------------------------------------------
     */

    /**
     * RecetteMeta $meta
     */
    public function addMeta(RecetteMeta $meta)
    {
        if(is_null($this->metas)){
            $this->metas = new ArrayCollection();
        }
        if ($this->metas->contains($meta)) {
            return false;
        }
        $this->metas->add($meta);
        return true;
    }

    public function removeMeta(RecetteMeta $meta)
    {
        if(is_null($this->metas)){
            $this->metas = new ArrayCollection();
        }
        if (!$this->metas->contains($meta)) {
            return false;
        }
        $this->metas->removeElement($meta);
        return true;
    }

    /**
     * @param Ingredient $ingredient
     * @return bool,
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
        $ingredient->addRecette($this);
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
        $ingredient->removeRecette($this);
        return true;
    }

    /**
     * @param RecetteEtape $etape
     * @return bool
     */
    public function addEtape(RecetteEtape $etape)
    {
        if(is_null($this->etapes)){
            $this->etapes = new ArrayCollection();
        }

        $colIngredienIds = $this->etapes->map(function ($entity) {
            return $entity->getId();
        })->toArray();

        if (in_array($etape->getId(),$colIngredienIds)) {
            return false;
        }

        $this->etapes->add($etape);
        return true;
    }
    /**
     * @param RecetteEtape $etape
     * @return bool
     */
    public function removeEtape(RecetteEtape $etape)
    {
        if(is_null($this->etapes)){
            $this->etapes = new ArrayCollection();
        }

        $colIngredientIds = $this->etapes->map(function ($entity) {
            return $entity->getId();
        })->toArray();

        if (!in_array($etape->getId(),$colIngredientIds)) {
            return false;
        }

        $this->etapes->removeElement($etape);
        return true;
    }
}
