<?php

$options = [
    'url'                                      => 'http://local.wonderwp.com',
    'siteurl'                                  => 'http://local.wonderwp.com',
    'stylesheet'                               => 'wwp_child_theme',
    'wwp-espace-restreint_enable_registration' => 1,
];

foreach ($options as $key => $val) {
    add_filter('pre_option_' . $key, function () use ($key, $val) {
        return $val;
    });
}
