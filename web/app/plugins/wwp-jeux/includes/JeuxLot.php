<?php

namespace WonderWp\Plugin\Jeux;

use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntity;

/**
 * Jeuxlot
 *
 * @ORM\Table(name="jeuxLot", indexes={@ORM\Index(name="fk_jeuxLot_jeux1_idx", columns={"jeux_id"})})
 * @ORM\Entity
 */
class JeuxLot extends AbstractEntity
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
     * @ORM\Column(name="visuel", type="string", length=255, nullable=true)
     */
    private $visuel;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=140, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="mecanique_gain", type="string", length=45, nullable=true)
     */
    private $mecaniqueGain;

    /**
     * @var \Jeux
     *
     * @ORM\ManyToOne(targetEntity="JeuxEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jeux_id", referencedColumnName="id")
     * })
     */
    private $jeux;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return JeuxLot
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisuel()
    {
        return $this->visuel;
    }

    /**
     * @param string $visuel
     * @return JeuxLot
     */
    public function setVisuel($visuel)
    {
        $this->visuel = $visuel;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return JeuxLot
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     * @return JeuxLot
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
    }

    /**
     * @return string
     */
    public function getMecaniqueGain()
    {
        return $this->mecaniqueGain;
    }

    /**
     * @param string $mecaniqueGain
     * @return JeuxLot
     */
    public function setMecaniqueGain($mecaniqueGain)
    {
        $this->mecaniqueGain = $mecaniqueGain;
        return $this;
    }

    /**
     * @return JeuxEntity
     */
    public function getJeux()
    {
        return $this->jeux;
    }

    /**
     * @param JeuxEntity $jeux
     * @return JeuxLot
     */
    public function setJeux($jeux)
    {
        $this->jeux = $jeux;
        return $this;
    }

}
