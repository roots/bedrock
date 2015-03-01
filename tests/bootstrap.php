<?php

$tests_dir = getenv('WP_TESTS_DIR');

if (!$tests_dir) {
  $tests_dir = dirname(__DIR__) . '/tests-includes';
}

require_once $tests_dir . '/functions.php';

require $tests_dir . '/bootstrap.php';
