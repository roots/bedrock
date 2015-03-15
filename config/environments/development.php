<?php
/* Development */
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');

define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

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
