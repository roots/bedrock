<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 31/10/2016
 * Time: 15:48
 */

namespace WonderWp\Theme\Components;


class PaginationComponent extends AbstractComponent
{

    public function getMarkup($opts=array())
    {

        $required = ['nbObjects','perPage','paginationUrl'];
        $errors = [];
        foreach($required as $item){
            if(!isset($opts[$item])){
                $errors[] = 'Option '.$item.' missing for the component to function properly';
            }
        }
        if(!empty($errors)){
            $notif = new NotificationComponent('error',implode('<br />',$errors));
            return $notif->getMarkup();
        }


        $defaultOptions = [
            'currentPage'=>1,
            'paginationSize'=>5,
            'addTrailingSlash'=>false,
            'nextLabel'=>__('next_page',WWP_THEME_TEXTDOMAIN),
            'prevLabel'=>__('prev_page',WWP_THEME_TEXTDOMAIN),
        ];

        $opts = \WonderWp\array_merge_recursive_distinct($defaultOptions,$opts);

        //\WonderWp\trace($opts);

        $maxpage = ceil($opts['nbObjects'] / $opts['perPage']);
        if($maxpage==1){ return ''; }

        $nav = "";
        $sl = 0;
        $sr = 0;
        if (($opts['currentPage'] == 1) && ($maxpage == 1)) {
            return $nav;
        }
        //Variable Initialisation
        $minpage = 1;
        $pm = $opts['currentPage'] - $opts['paginationSize']; //Left cursor
        $pp = $opts['currentPage'] + $opts['paginationSize']; //Right cursor
        $Mm = $maxpage - $opts['paginationSize']; //
        $mp = 0 + $opts['paginationSize'];
        if (($pm <= 0))
            $pm = 1;
        if ($pp > $maxpage)
            $pp = $maxpage;
        if ($pm > $minpage) {
            $m = $minpage;
            $sl = 1;
        }
        if ($pp < $maxpage) {
            $M = $maxpage;
            $sr = 1;
        }
        //echo 'Curpage->' . $opts['currentPage'] . ' | size->' . $opts['paginationSize'] . ' | pm->' . $pm . ' | pp->' . $pp . ' | M->' . $M . ' | max->' . $maxpage . '<br>';
        if ($opts['currentPage'] > 1)
            $nav.='<li><a href="' . $opts['paginationUrl'] . ($opts['currentPage'] - 1).($opts['addTrailingSlash'] ? '/':'') . '" class="navlink navclose navprev" ><span>' . $opts['prevLabel'] . '</span></a></li>';
        if (!empty($m))
            $nav.='<li><a href="' . $opts['paginationUrl'] . $m.($opts['addTrailingSlash'] ? '/':'') . '" class="navlink navclose"><span>' . $m . '</span></a></li>';
        if ($sl == 1)
            $nav.='<li>...</li>';
        for ($i = $pm; $i <= $pp; $i++) {
            if ($i == $opts['currentPage'])
                $nav.= '<li class="select"><a href="#" class="navlink navcurrent"><span>' . $i . '</span></a></li>';
            else {
                $nav.='<li><a href="' . $opts['paginationUrl'] . $i.($opts['addTrailingSlash'] ? '/':'') . '" class="navlink navclose"><span>' . $i . '</span></a></li>';
            }
        }
        if ($sr == 1)
            $nav.='<li>...</li>';
        if (!empty($M)) {
            $nav.= '<li><a href="' . $opts['paginationUrl'] . $M.($opts['addTrailingSlash'] ? '/':'') . '" class="navlink navclose"><span>' . $M . '</span></a></li>';
            if ($opts['currentPage'] != $M && $opts['currentPage']!=$maxpage){
                $nav.='<li><a href="' . $opts['paginationUrl'] . ($opts['currentPage'] + 1).($opts['addTrailingSlash'] ? '/':'') . '" class="navlink navclose navnext"><span>' . $opts['nextLabel'] . '</span></a></li>';
            }
        }
        return '<ul class="pagination">' . $nav . '</ul>';
    }
}