<?php

namespace WonderWp\Theme\Child\Components\ReseauxSociaux;

use WonderWp\Theme\Core\Component\AbstractComponent;
use function WonderWp\Functions\array_merge_recursive_distinct;
use function WonderWp\Functions\paramsToHtml;

class ReseauxSociauxComponent extends AbstractComponent
{
    public function getMarkup(array $opts = [])
    {

        $markup = '';

        $reseauxOpts = !empty($opts['reseaux'])
            ? $opts['reseaux']
            : [
                'facebook',
                'twitter',
                'youtube',
                'vimeo',
                'instagram',
                'pinterest',
                'flickr',
                'linkedin',
                'tiktok',
                'snapchat'
            ];

        $reseauxActifs = [];

        foreach ($reseauxOpts as $reseau) {
            $link = get_option('wonderwp_rs_' . $reseau);
            if (!empty($link)) {
                $reseauxActifs[] = '<li class="' . $reseau . '"><a href="' . $link . '" target="_blank" aria-label="' . __('rs.follow.' . $reseau, WWP_THEME_TEXTDOMAIN) . ' (nouvelle fenêtre)">' . getSvgIcon($reseau) . '<span>' . __('rs.follow.' . $reseau, WWP_THEME_TEXTDOMAIN) . '<span></a></li>';
            }
        }

        if (!empty($reseauxActifs)) {
            $params       = [
                'class' => ['social-networks'],
            ];
            $passedParams = !empty($opts['listParams']) ? $opts['listParams'] : [];
            $markup       = '<ul ' . paramsToHtml(array_merge_recursive_distinct($params, $passedParams)) . '>
                ' . implode("\n", $reseauxActifs) . '
            </ul>';
        }

        return $markup;
    }
}
