<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 20/09/2016
 * Time: 09:29
 */

namespace WonderWp\Theme\Components;


class ReseauxSociauxComponent extends AbstractComponent
{
    public function getMarkup()
    {

        $markup = '';

        $reseauxOpts = array(
            'facebook',
            'twitter',
            'youtube',
            'instagram',
            'pinterest',
            'flickr'
        );

        $reseauxActifs = array();

        foreach($reseauxOpts as $reseau){
            $link = get_option('wonderwp_rs_'.$reseau);
            if(!empty($link)){
                $reseauxActifs[] = '<li class="'.$reseau.'"><a href="'.$link.'" target="_blank">'.__('rs.follow.'.$reseau,WWP_THEME_TEXTDOMAIN).'</a></li>';
            }
        }

        if(!empty($reseauxActifs)){
            $markup = '<ul class="social-networks">
                '.implode("\n",$reseauxActifs).'
            </ul>';
        }

        return $markup;
    }
}