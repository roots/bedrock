<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 20/09/2016
 * Time: 09:29
 */

namespace WonderWp\Theme\Components;

use WonderWp\Theme\Core\Component\AbstractComponent;

class ReseauxSociauxComponent extends AbstractComponent
{
    public function getMarkup(array $opts = [])
    {

        $markup = '';

        $reseauxOpts = [
            'facebook',
            'twitter',
            'youtube',
            'instagram',
            'pinterest',
            'flickr',
        ];

        $reseauxActifs = [];

        foreach ($reseauxOpts as $reseau) {
            $link = get_option('wonderwp_rs_' . $reseau);
            if (!empty($link)) {
                $reseauxActifs[] = '<li class="' . $reseau . '"><a href="' . $link . '" target="_blank">' . __('rs.follow.' . $reseau, WWP_THEME_TEXTDOMAIN) . '</a></li>';
            }
        }

        if (!empty($reseauxActifs)) {
            $markup = '<ul class="social-networks">
                ' . implode("\n", $reseauxActifs) . '
            </ul>';
        }

        return $markup;
    }
}
