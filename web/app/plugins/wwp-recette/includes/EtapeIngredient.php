<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtapeIngredient
 *
 * @ORM\Table(name="etape_ingredient", indexes={@ORM\Index(name="IDX_137D1A32933FE08C", columns={"ingredient_id"}), @ORM\Index(name="IDX_137D1A323CAFBFC", columns={"recetteEtape_id"})})
 * @ORM\Entity
 */
class EtapeIngredient
{
    /**
     * @var Ingredient
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     *
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="etapeIngredients")
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id", nullable=FALSE)
     *
     */
    private $ingredient;

    /**
     * @var RecetteEtape
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @ORM\ManyToOne(targetEntity="RecetteEtape", inversedBy="etapeIngredients")
     * @ORM\JoinColumn(name="recetteEtape_id", referencedColumnName="id", nullable=FALSE)
     *
     */
    private $recetteEtape;

    /**
     * @var integer
     *
     * @ORM\Column(name="qty", type="integer", nullable=true)
     */
    private $qty;

    /**
     * @var integer
     *
     * @ORM\Column(name="unit", type="integer", nullable=true)
     */
    private $unit;

    /**
     * @return Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * @return RecetteEtape
     */
    public function getRecetteEtape()
    {
        return $this->recetteEtape;
    }

    /**
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @return int
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param Ingredient $ingredient
     * @return $this
     */
    public function setIngredient(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
        return $this;
    }

    /**
     * @param RecetteEtape $recetteEtape
     * @return $this
     */
    public function setRecetteEtape(RecetteEtape $recetteEtape)
    {
        $this->recetteEtape = $recetteEtape;
        return $this;
    }

    /**
     * @param int $qty
     * @return $this
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
        return $this;
    }

    /**
     * @param int $unit
     * @return $this
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
        return $this;
    }


}
