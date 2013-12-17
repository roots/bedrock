<?php
if (!is_blog_installed()) { return; }

function is_first_run() {
  'http://' . $_SERVER['SERVER_NAME'] . '/wp' === get_option('home');
}

if ((WP_ENV === 'development') || is_first_run()) {
  update_option('upload_path', $_SERVER['DOCUMENT_ROOT'] . '/app/uploads');
  update_option('upload_url_path', 'http://' . $_SERVER['SERVER_NAME'] . '/app/uploads');
  update_option('permalink_structure', '/%postname%/');
}
