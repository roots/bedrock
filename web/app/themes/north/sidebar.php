<?php

$sidebar_id = get_post_meta(vntd_get_id(), 'page_sidebar', true);

if( is_archive() || is_search() ) {
	$sidebar_id = 'archives';
} elseif(is_404()) {
	global $smof_data;
	$sidebar_id = $smof_data['vntd_404_sidebar'];
}

if( !$sidebar_id ) {
	$sidebar_id = 'default_sidebar';
}

if ( class_exists('Woocommerce') ) {
    if(is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page()) {        
    	$sidebar_id = 'woocommerce_shop';        
    } elseif(is_product()) {
    	$sidebar_id = 'woocommerce_product'; 
    }

}
?>

<div id="sidebar" class="page_sidebar">
	<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar_id)) ?>
</div>