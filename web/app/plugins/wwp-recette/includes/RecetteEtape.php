<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntity;

/**
 * Recetteetape
 *
 * @ORM\Table(name="recetteEtape", indexes={@ORM\Index(name="fk_recetteEtape_recette1_idx", columns={"recette_id"})})
 * @ORM\Entity
 */
class RecetteEtape extends AbstractEntity
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
     * @ORM\Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=140, nullable=true)
     */
    private $media;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=true)
     */
    private $content;

    /**
     * @var \Recette
     *
     * @ORM\ManyToOne(targetEntity="RecetteEntity", fetch="EXTRA_LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recette_id", referencedColumnName="id")
     * })
     */
    private $recette;

    /**
     * @ORM\OneToMany(targetEntity="EtapeIngredient", mappedBy="recetteEtape", cascade={"persist", "remove"}, orphanRemoval=TRUE))
     */
    private $etapeIngredients;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etapeIngredients = new ArrayCollection();
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
     * @return mixed
     */
    public function getEtapeIngredients()
    {
        return $this->etapeIngredients;
    }

    /**
     * @param mixed $etapeIngredients
     */
    public function setEtapeIngredients($etapeIngredients)
    {
        $this->etapeIngredients = $etapeIngredients;
        return $this;
    }

    public function addEtapeIngredient(EtapeIngredient $etapeIngredient)
    {
        if (!$this->etapeIngredients->contains($etapeIngredient)) {
            $this->etapeIngredients->add($etapeIngredient);
            $etapeIngredient->setRecetteEtape($this);
        }

        return $this;
    }

    public function removeEtapeIngredient(EtapeIngredient $etapeIngredient)
    {
        if ($this->etapeIngredients->contains($etapeIngredient)) {
            $this->etapeIngredients->removeElement($etapeIngredient);
            $etapeIngredient->setRecetteEtape(null);
        }

        return $this;
    }    

}
