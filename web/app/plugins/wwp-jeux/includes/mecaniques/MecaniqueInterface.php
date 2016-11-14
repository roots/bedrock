<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 14/11/2016
 * Time: 09:53
 */

namespace WonderWp\Plugin\Jeux\Mecaniques;

use WonderWp\Plugin\Jeux\JeuxLot;

interface MecaniqueInterface{

    public static function getEtiquette();

    public static function generateLotMecanique(JeuxLot $lot, $prefix);

}