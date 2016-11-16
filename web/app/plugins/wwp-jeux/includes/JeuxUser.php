<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/11/2016
 * Time: 17:32
 */

namespace WonderWp\Plugin\Jeux;

use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntities\AbstractUser;

/**
 * JeuxUser
 *
 * @ORM\Table(name="jeuxUser")
 * @ORM\Entity
 */
class JeuxUser extends AbstractUser
{

}