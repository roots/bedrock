<?php

/**
 * Theme Dynamic Stylesheet
 *
 * @package North
 * @since 1.0
 *
 */
 
header("Content-type: text/css;");

$current_url = dirname(__FILE__);
$wp_content_pos = strpos($current_url, 'wp-content');
$wp_content = substr($current_url, 0, $wp_content_pos);

require_once($wp_content . 'wp-load.php');

global $smof_data;
$prefix = "vntd_";

$vntd_accent_color = '#d71818';

if(array_key_exists('vntd_accent_color', $smof_data)) {
    if($smof_data['vntd_accent_color'] ) {
    	$vntd_accent_color = $smof_data['vntd_accent_color'];
    }   
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Typography
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

//$font_body = $smof_data[$prefix.'body_font'];
//$font_heading = $smof_data[$prefix.'heading_font'];
//
//if($font_body != 'Arial') echo 'body, #wrapper input, #wrapper textarea { font-family: '.$font_body.", 'HelveticaNeue', 'Helvetica Neue', Helvetica, Arial; }";
//
//if($font_heading != 'Arial') echo 'h1,h2,h3,h4,h5,h6 { font-family: '.$font_heading.", 'HelveticaNeue', 'Helvetica Neue', Helvetica, Arial !important; }";


?>

<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		General
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
?>

.separator div,
body {
	background-color:	<?php echo $smof_data[$prefix.'bg_color'] ?>;
	color:				<?php echo $smof_data[$prefix.'body_color'] ?>;
}

a,
.vntd-accent-color {
	color:				<?php echo $vntd_accent_color; ?>;
}



/* Navigation */

#navigation-sticky.white-nav,
.second-nav.white-nav,
.white-nav .nav-menu ul.dropdown-menu {
	background-color:	<?php echo $smof_data[$prefix.'header_bg_color'] ?>;
}

#navigation-sticky.white-nav,
.second-nav.white-nav .nav-menu,
.first-nav.white-nav .nav-menu ul.dropdown-menu li a {
	color:	<?php echo $smof_data[$prefix.'header_nav_color'] ?>;
}

.second-nav.white-nav .nav-inner .nav-menu ul li.active a,
.white-nav .nav-menu ul.dropdown-menu li a:hover,
.white-nav .nav-menu ul.dropdown-menu li.active a,
.nav>li>a:hover, .nav>li>a:focus {
	background-color:	<?php echo $smof_data[$prefix.'header_hover_bg_color'] ?> !important;
}

/* Page Title */

section.page_header {
	background-color:	<?php echo $smof_data[$prefix.'pagetitle_bg_color'] ?>;
	border-color:		<?php echo $smof_data[$prefix.'pagetitle_border_color'] ?>;
}

section.page_header .page_header_inner .p_head_left h1.p-header {
	color:	<?php echo $smof_data[$prefix.'pagetitle_color'] ?>;
}

section.page_header .page_header_inner .p_head_left p.p-desc {
	color:	<?php echo $smof_data[$prefix.'pagetitle_tagline_color'] ?>;
}

section.page_header .page_header_inner .p_head_right a.p-head-button {
	color:	<?php echo $smof_data[$prefix.'breadcrumbs_color'] ?>;
}

/* Footer Widgets */

<?php

if( $smof_data[$prefix.'footer_widgets_bg_color'] && $smof_data[$prefix.'footer_widgets_bg_color'] != '' ) { 
	echo 'body #footer-widgets { background-color:'.esc_attr($smof_data[$prefix.'footer_widgets_bg_color']).' !important; }';
}

if( $smof_data[$prefix.'footer_widgets_text_color'] && $smof_data[$prefix.'footer_widgets_text_color'] != '' ) { 
	echo 'body #footer-widgets { color:'.esc_attr($smof_data[$prefix.'footer_widgets_text_color']).' !important; }'; // Text Color
}

if( $smof_data[$prefix.'footer_widgets_heading_color'] && $smof_data[$prefix.'footer_widgets_heading_color'] != '' ) { 
	echo 'body #footer-widgets .bar.footer-widget h4 { color:' . esc_attr( $smof_data[$prefix.'footer_widgets_heading_color'] ) . ' !important; }';
}

if( $smof_data[$prefix.'footer_widgets_link_color'] && $smof_data[$prefix.'footer_widgets_link_color'] != '' ) { 
	echo '#footer-widgets .footer-widget.bar a { color:' . esc_attr( $smof_data[$prefix.'footer_widgets_link_color'] ) . '; }';
}

if( $smof_data[$prefix.'footer_widgets_borders_color'] && $smof_data[$prefix.'footer_widgets_borders_color'] != '' ) { 
	echo '#footer-widgets .bar ul li { border-color:' . esc_attr( $smof_data[$prefix.'footer_widgets_borders_color'] ) . '; }';
}

if( $smof_data[$prefix.'footer_widgets_link_hover_bg_color'] && $smof_data[$prefix.'footer_widgets_link_hover_bg_color'] != '' ) { 
	echo '#footer-widgets .bar ul li:hover { color:' . esc_attr( $smof_data[$prefix.'footer_widgets_link_hover_bg_color'] ) . '; }';
}

?>

/* Footer */

.footer.white-bg {
	background-color:	<?php echo $smof_data[$prefix.'footer_bg_color'] ?> !important;
	border-color:		<?php echo $smof_data[$prefix.'footer_border_color'] ?>;
	color:				<?php echo $smof_data[$prefix.'footer_color'] ?>;
}
<?php if($smof_data[$prefix.'footer_color'] != '#767676') echo '#page-content .footer p,#page-content .footer a,'; ?>
.footer.white-bg a,
.footer.white-bg p {
	color:				<?php echo $smof_data[$prefix.'footer_color'] ?>;
}

/* Typography */

<?php

if($smof_data[$prefix.'heading_color'] != '#3e3e3e') {
	echo ' h1,h2,h3,h4,h5,h6 { color:'.$smof_data[$prefix.'heading_color'].'; }';
}

?>

/* Text Colors */

	.colored,
	.testimonials li.text h1 span,
	#page-content .vntd-pricing-box.p-table.active h1,
	#page-content .vntd-pricing-box.p-table.active h3,
	#address .address-soft a.mail-text:hover,
	.white-nav .nav-menu ul.dropdown-menu li a:hover,
	.vntd-icon-box.box:hover .left-icon a,
	.white-nav .nav-menu ul.dropdown-menu li.active a,
	footer.footer a:hover,
	section.page_header .page_header_inner .p_head_right a.p-head-button:hover,
	body.dark-layout section.page_header .page_header_inner .p_head_right a.p-head-button:hover,
	#blog .details .post-info a.post-item:hover,
	.dark-nav .nav-menu ul.dropdown-menu li a:hover,
	.dark-nav .nav-menu ul.dropdown-menu li.active a,
	a.text-button:hover,
	.blog .details a.post-item:hover,
	span.post-item a:hover,
	.nav-menu ul li a:hover,
	.nav-menu ul li.active a,
	#page-content .color-accent,
	.blog .post a.read-more-post:hover,
	.address-soft a.mail-text:hover,
	.bar.widget_rss a.rsswidget:hover,
	.twitter-feed-icon:hover,
	.woocommerce ul.products li.product .price,
	#woo-nav-cart i.added,
	.woocommerce .star-rating span:before,
	.vntd-portfolio-carousel.blog-carousel .works .item h1.f-head a:hover
	{
		color: <?php echo $vntd_accent_color; ?>;
	}
	
	.current_page_item > a,
	.current-menu-ancestor > a,
	.current-menu-parent > a,
	.current-menu-parent .page_item > a,
	.current-menu-ancestor .page_item > a,
	.price  {
		color: <?php echo $vntd_accent_color; ?> !important;
	}

/* Background Colors */

	.colored-bg,
	a.page-content-button:hover,
	.feature-box:hover a.box-icon,
	.vntd-portfolio-carousel .works .item .featured-ball:hover,
	.vntd-cta-button:hover,
	.vntd-pricing-box.p-table.active a.p-button,
	.vntd-pricing-box.p-table a.p-button:hover,
	a.active-colored,
	.blocked,
	.modal .modal-inner a.close:hover,
	.portfolio a.portfolio-view-more:hover,
	body.dark-layout .portfolio a.portfolio-view-more:hover,
	#team .team .team-boxes .item .member-details .details a.member-detail-button:hover,
	.bar .tagcloud a:hover,
	#respond #submit:hover,
	ul.pagination li.active a,
	ul.pagination li.active a:hover,
	body.dark-layout ul.pagination li.active a,
	body.dark-layout ul.pagination li.active a:hover,
	.contact form button.contact-form-button:hover,
	.btn-accent,
	.vntd-list-bg i,
	.vntd-accent-bgcolor,
	.pagination .current,
	.contact .wpcf7-submit:hover,
	.blog .post.sticky .blog-head,
	.portfolio .portfolio-items div.colio-active-item .item-inner,
	#page-content .colio-navigation a:hover,
	#page-content .colio-close,
	.woocommerce ul.products li.product .button:hover,
	::selection,
	#woo-nav-cart .button:hover,
	.woocommerce #page-content .button:hover,
	.woocommerce #review_form #respond .form-submit input:hover,
	.woocommerce ul.products li.product .onsale,
	.woocommerce span.onsale,
	#page-content .woocommerce .button:hover,
	.woocommerce a.remove:hover,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
	.vntd-portfolio-carousel.blog-carousel .works .owl-controls .owl-buttons div:hover {
		background-color: <?php echo $vntd_accent_color; ?>;
	}
	
	a.page-content-button:hover {
		background-color:<?php echo $vntd_accent_color; ?>;
	}
	
	.contact .wpcf7-submit:hover {
		background-color:<?php echo $vntd_accent_color; ?>;
	}
	
	.vntd-portfolio-carousel .works .item .featured-ball:hover {
		background-color:<?php echo $vntd_accent_color; ?>;
	}

/* Border Colors */

	.colored-border,
	.feature-box:hover a.box-icon:after,
	a.text-button:hover,
	#team .team .team-boxes .item .member-details .details a.member-detail-button:hover,
	.bar .tagcloud a:hover,
	ul.pagination li.active a,
	ul.pagination li.active a:hover,
	.bs-callout-north,
	.vntd-icon-box.box:hover .left-icon a,
	.btn-accent,
	.pagination .current,
	.contact .wpcf7-submit:hover,
	blockquote,
	.nav-cart-products,
	.pulsed,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active  {
		border-color:<?php echo $vntd_accent_color; ?>;
	}
	
	

	.tabs .nav-tabs li.active a,
	.nav-menu ul.dropdown-menu{
		border-top-color:<?php echo $vntd_accent_color; ?>;
	}
	
	.vntd-tour .nav-tabs li.active a {
		border-left-color:<?php echo $vntd_accent_color; ?>;
	}
	
/* Font Sizes */

<?php 

if($smof_data[$prefix.'fs_body'] != 14) {
	echo 'body { font-size:'.$smof_data[$prefix.'fs_body'].'px; }';
}

if($smof_data[$prefix.'fs_navigation'] != 15) {
	echo ' .nav-menu ul li a { font-size:'.$smof_data[$prefix.'fs_navigation'].'px; }';
}

if($smof_data[$prefix.'fs_page_title'] != 30) {
	echo ' #page-title h1 { font-size:'.$smof_data[$prefix.'fs_page_title'].'px; }';
}

if($smof_data[$prefix.'fs_page_tagline'] != 14) {
	echo ' section.page_header .page_header_inner .p_head_left p.p-desc { font-size:'.$smof_data[$prefix.'fs_page_tagline'].'px; }';
}

if($smof_data[$prefix.'fs_breadcrumbs'] != 13) {
	echo ' section.page_header .page_header_inner .p_head_right a.p-head-button { font-size:'.$smof_data[$prefix.'fs_breadcrumbs'].'px; }';
}

if($smof_data[$prefix.'fs_special'] != 60) {
	echo ' .header { font-size:'.$smof_data[$prefix.'fs_special'].'px; }';
}

if($smof_data[$prefix.'fs_h1'] != 36) {
	echo ' h1 { font-size:'.$smof_data[$prefix.'fs_h1'].'px; }';
}

if($smof_data[$prefix.'fs_h2'] != 30) {
	echo ' h2 { font-size:'.$smof_data[$prefix.'fs_h2'].'px; }';
}

if($smof_data[$prefix.'fs_h3'] != 24) {
	echo ' h3 { font-size:'.$smof_data[$prefix.'fs_h3'].'px; }';
}

if($smof_data[$prefix.'fs_h4'] != 18) {
	echo ' h4 { font-size:'.$smof_data[$prefix.'fs_h4'].'px; }';
}

if($smof_data[$prefix.'fs_h5'] != 14) {
	echo ' h5 { font-size:'.$smof_data[$prefix.'fs_h5'].'px; }';
}

if($smof_data[$prefix.'fs_h6'] != 12) {
	echo ' h6 { font-size:'.$smof_data[$prefix.'fs_h6'].'px; }';
}

if($smof_data[$prefix.'fs_copyright'] != 11) {
	echo ' footer p, footer a { font-size:'.$smof_data[$prefix.'fs_copyright'].'px; }';
}


/* Font Family */

$font_primary = $smof_data[$prefix.'heading_font'];
$font_secondary = $smof_data[$prefix.'body_font'];

if($font_primary && $font_primary != 'Oswald') {
	echo ' h1,h2,h3,h4,h5,h6,.font-primary,.w-option-set,#page-content .wpb_content_element .wpb_tabs_nav li,.vntd-pricing-box .properties,#page-content .vc_single_bar .vc_label { font-family:"'.$font_primary.'", Open Sans, Helvetica, sans-serif; }';
}

if($font_secondary && $font_secondary != 'Raleway') {
	echo ' body,h2.description,.vntd-cta-style-centered h1,.home-fixed-text,.font-secondary,.wpcf7-not-valid-tip,.testimonials h1 { font-family:"'.$font_secondary.'", Open Sans, Helvetica, sans-serif; }';
}

// Text/Font Transform

if($smof_data[$prefix.'heading_font_transform'] && $smof_data[$prefix.'heading_font_transform'] == 'none') {
	echo " h1,h2,h3,h4,h5,h6,.font-primary,.uppercase { text-transform:".$smof_data[$prefix.'heading_font_transform']."; }";
}

if($smof_data[$prefix.'navigation_font_transform'] && $smof_data[$prefix.'navigation_font_transform'] == 'none') {
	echo " ul.nav { text-transform:".$smof_data[$prefix.'navigation_font_transform']."; }";
}

// Font Weight

if($smof_data[$prefix.'heading_font_weight'] && $smof_data[$prefix.'heading_font_weight'] != 400) {
	echo " h1,h2,h3,h4,h5,h6,.font-primary,.w-option-set,#page-content .wpb_content_element .wpb_tabs_nav li,.vntd-pricing-box .properties { font-weight:".$smof_data[$prefix.'heading_font_weight']."; }";
}

// Nav Font Weight

if($smof_data[$prefix.'navigation_font_weight'] && $smof_data[$prefix.'navigation_font_weight'] != 400) {
	echo " .semibold { font-weight:".$smof_data[$prefix.'navigation_font_weight']."; }";
}

// Custom CSS

if(isset($smof_data[$prefix.'custom_css'])) {
	echo $smof_data[$prefix.'custom_css'];
}

?>