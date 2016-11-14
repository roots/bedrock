<?php

/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 14/11/2016
 * Time: 09:52
 */

namespace WonderWp\Plugin\Jeux\Mecaniques;

use WonderWp\Forms\Fields\FieldGroup;
use WonderWp\Forms\Fields\NumericField;
use WonderWp\Plugin\Jeux\JeuxLot;

class TirageAuSort extends AbstractMecanique
{
    public static function getEtiquette()
    {
        return 'Tirage au sort';
    }

    public static function generateLotMecanique(JeuxLot $lot, $prefix) {
        $g = new FieldGroup('mecaniqueGainLot');
        $mecanique = json_decode($lot->getMecaniqueGain());
        $stock = !empty($mecanique->stock) ? $mecanique->stock : null;

        //Nombre de lots
        $f = new NumericField($prefix.'[stock]',$stock,['label'=>'Quantité']);
        $g->addFieldToGroup($f);

        return $g;
    }
}