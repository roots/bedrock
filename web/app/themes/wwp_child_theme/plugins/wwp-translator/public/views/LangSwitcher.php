<?php

$switcher = '';

if (!empty($records)) {
    $toAdd    = [];
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    foreach ($records as $rec) {
        if ($rec->isActive()) { //Only return active languages
            $thisLocale = $rec->getLocale();
            $switchLink = !empty($rec->getDomain()) ? $protocol . $rec->getDomain() : $homeUrl;
            if (isset($hrefLangMetas[$thisLocale])) {
                $switchLink .= str_replace(
                    $homeUrl,
                    '',
                    is_numeric($hrefLangMetas[$thisLocale]) ? get_permalink(
                        $hrefLangMetas[$thisLocale]
                    ) : $hrefLangMetas[$thisLocale]
                );
            }
            if (empty($rec->getDomain())) {
                $switchLink .= '?locale=' . $thisLocale;
            }
            $localeFrags = explode('_', $thisLocale);
            $localeShort = @reset($localeFrags);
            $langline = '<li class="lang_' . $thisLocale . '"><a href="' . $switchLink . '" title="' . $rec->getTitle(
                ) . '" >' . (($fullName) ? $rec->getTitle()
                    : strtoupper($localeShort)) . '</a></li>';

            if ($curLangCode != $thisLocale) {
                $toAdd[] = $langline;
            }
        }
    }

    if (!empty($toAdd) && count($toAdd) > 1) {
        $switcher .= '<div class="lang-switcher">';
            $switcher .= '<button class="btn lang-switcher-current lang_'.$curLangCode.'" type="button" onClick="document.getElementsByClassName(\'lang-switcher-current\')[1].classList.toggle(\'active\');">'. $curLangCode . '</button>';
            $switcher .= '<ul class="lang-switcher-choices">' . implode('', $toAdd) . '</ul>';
        $switcher .= '</div>';
    }
}

echo $switcher;
