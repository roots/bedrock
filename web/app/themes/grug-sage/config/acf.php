<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Field Type Settings
    |--------------------------------------------------------------------------
    |
    | Here you can set default field group and field type configuration that
    | is then merged with your field groups when they are composed.
    |
    | This allows you to avoid the repetitive process of setting common field
    | configuration such as `ui` on every `trueFalse` field or your
    | preferred `instruction_placement` on every `fieldGroup`.
    |
    */

    'defaults' => [
        'fieldGroup' => ['instruction_placement' => 'acfe_instructions_tooltip'],
        'repeater' => ['layout' => 'block', 'acfe_repeater_stylised_button' => 1],
        'trueFalse' => ['ui' => 1],
        'select' => ['ui' => 1],
        'postObject' => ['ui' => 1, 'return_format' => 'object'],
        'accordion' => ['multi_expand' => 1],
        'group' => ['layout' => 'table', 'acfe_group_modal' => 1],
        'tab' => ['placement' => 'left'],
        'sidebar_selector' => ['default_value' => 'sidebar-primary', 'allow_null' => 1]
    ],
];
