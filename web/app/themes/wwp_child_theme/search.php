<?php
$request = \WonderWp\Component\HttpFoundation\Request::getInstance();
if (false === $request->isXmlHttpRequest()) {
    get_header();
}

echo do_shortcode('[wwpmodule slug="wwp-search"]');

if (false === $request->isXmlHttpRequest()) {
    get_footer();
}
