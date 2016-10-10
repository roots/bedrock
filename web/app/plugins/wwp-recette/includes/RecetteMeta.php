<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntity;

/**
 * RecetteMeta
 *
 * @Table(name="recetteMeta", indexes={@Index(name="IDX_8820A19189312FE9", columns={"recette_id"})})
 * @Entity
 */
class RecetteMeta extends AbstractEntity
{
    /**
     * @var string
     *
     * @Column(name="name", type="string", length=45, nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $name;

    /**
     * @var string
     *
     * @Column(name="val", type="string", length=65535, nullable=true)
     */
    private $val;

    /**
     * @var \Recette
     *
     * @Id
     * @GeneratedValue(strategy="NONE")
     * @OneToOne(targetEntity="RecetteEntity")
     * @JoinColumns({
     *   @JoinColumn(name="recette_id", referencedColumnName="id")
     * })
     */
    private $recette;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * @param string $val
     * @return $this
     */
    public function setVal($val)
    {
        $this->val = $val;
        return $this;
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
     * @return $this
     */
    public function setRecette($recette)
    {
        $this->recette = $recette;
        return $this;
    }

}
