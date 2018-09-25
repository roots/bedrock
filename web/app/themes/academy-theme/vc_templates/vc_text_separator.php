<?php
extract(shortcode_atts(array(
    'title' => '',
    'title_align' => '',
    'el_width' => '',
    'style' => '',
    'color' => '',
    'accent_color' => '',
    'el_class' => ''
), $atts));
$class = "vc_separator wpb_content_element";

//$el_width = "90";
//$style = 'double';
//$title = '';
//$color = 'blue';

$class .= ($title_align!='') ? ' vc_'.$title_align : '';
$class .= ($el_width!='') ? ' vc_el_width_'.$el_width : ' vc_el_width_100';
$class .= ($style!='') ? ' vc_sep_'.$style : '';
$class .= ($color!='') ? ' vc_sep_color_'.$color : '';
$class .= ($color!='') ? ' vc_sep_color_'.$color : '';

$inline_css = ($accent_color!='') ? ' style="'.vc_get_css_color('border-color', $accent_color).'"' : '';

$class .= $this->getExtraClass($el_class);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base']);

?>
<div class="<?php echo esc_attr(trim($css_class)); ?>">
	<span class="vc_sep_holder vc_sep_holder_l"><span<?php echo $inline_css; ?> class="vc_sep_line"></span></span>
	<?php if($title!=''): ?><h4><?php echo $title; ?></h4><?php endif; ?>
	<span class="vc_sep_holder vc_sep_holder_r"><span<?php echo $inline_css; ?> class="vc_sep_line"></span></span>
</div>
<?php echo $this->endBlockComment('separator')."\n";