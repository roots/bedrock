<?php
/** Development */
define('SAVEQUERIES', true);
define('WP_DEBUG', true);
define('SCRIPT_DEBUG', true);

if (!function_exists('dd')) {
  function dd() {
    $xdebug = ini_get('xdebug.overload_var_dump');
    $args = (array) func_get_args();
    echo $xdebug ? '' : '<pre>';
    echo call_user_func_array('_log', $args);
    die($xdebug ? '' : '</pre>');
  }
}
