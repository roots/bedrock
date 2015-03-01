<?php

$tests_dir = getenv('WP_TESTS_DIR');

if (!$tests_dir) {
  $tests_dir = '../test-includes';
}

require_once $tests_dir . '/includes/functions.php';

require $tests_dir . '/includes/bootstrap.php';
