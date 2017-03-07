<?php

namespace WonderWp\Plugin\EspaceRestreint;

use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntities\AbstractUser;

/**
 * MembreEntity
 *
 * @ORM\Table(name="er_membre")
 * @ORM\Entity
 */
class MembreEntity extends AbstractUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="children", type="integer", nullable=true)
     */
    private $children;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=45, nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=45, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="code_parrain", type="string", length=45, nullable=true)
     */
    private $codeParrain;

    /**
     * @var integer
     *
     * @ORM\Column(name="conso_pommes", type="integer", nullable=true)
     */
    private $consoPommes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="register_nl", type="boolean", nullable=true)
     */
    private $registerNl;

    /**
     * Set children
     *
     * @param integer $children
     * @return MembreEntity
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return integer
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     * @return MembreEntity
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return MembreEntity
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set codeParrain
     *
     * @param string $codeParrain
     * @return MembreEntity
     */
    public function setCodeParrain($codeParrain)
    {
        $this->codeParrain = $codeParrain;

        return $this;
    }

    /**
     * Get codeParrain
     *
     * @return string
     */
    public function getCodeParrain()
    {
        return $this->codeParrain;
    }

    /**
     * Set consoPommes
     *
     * @param integer $consoPommes
     * @return MembreEntity
     */
    public function setConsoPommes($consoPommes)
    {
        $this->consoPommes = $consoPommes;

        return $this;
    }

    /**
     * Get consoPommes
     *
     * @return integer
     */
    public function getConsoPommes()
    {
        return $this->consoPommes;
    }

    /**
     * Set registerNl
     *
     * @param boolean $registerNl
     * @return MembreEntity
     */
    public function setRegisterNl($registerNl)
    {
        $this->registerNl = $registerNl;

        return $this;
    }

    /**
     * Get registerNl
     *
     * @return boolean
     */
    public function getRegisterNl()
    {
        return $this->registerNl;
    }
}
