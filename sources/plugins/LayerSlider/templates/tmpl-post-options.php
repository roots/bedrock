<?php if(!defined('LS_ROOT_FILE')) {  header('HTTP/1.0 403 Forbidden'); exit; }

$queryArgs = array('post_status' => 'publish', 'limit' => 100, 'posts_per_page' => 100);

if(!empty($slider['properties']['post_orderby'])) {
	$queryArgs['orderby'] = $slider['properties']['post_orderby']; }

if(!empty($slider['properties']['post_order'])) {
	$queryArgs['order'] = $slider['properties']['post_order']; }

if(!empty($slider['properties']['post_type'])) {
	$queryArgs['post_type'] = $slider['properties']['post_type']; }

if(!empty($slider['properties']['post_categories'][0])) {
	$queryArgs['category__in'] = $slider['properties']['post_categories']; }

if(!empty($slider['properties'][0])) {
	$queryArgs['tag__in'] = $slider['properties']['post_tags']; }

if(!empty($slider['properties']['post_taxonomy']) && !empty($slider['properties']['post_tax_terms'])) {
	$queryArgs['tax_query'][] = array(
		'taxonomy' => $slider['properties']['post_taxonomy'],
		'field' => 'id',
		'terms' => $slider['properties']['post_tax_terms']
	);
}

$posts = LS_Posts::find($queryArgs)->getParsedObject();
?>
<script type="text/javascript" class="ls-hidden" id="ls-posts-json">window.lsPostsJSON = <?php echo $posts ? json_encode($posts) : '[]' ?>;</script>
<div id="ls-post-options">
	<div class="ls-box ls-modal ls-configure-posts-modal">
		<h2 class="header">
			<?php _e('Find posts with the filters above', 'LayerSlider') ?>
			<a href="#" class="dashicons dashicons-no"></a>
		</h2>
		<div class="inner clearfix">
			<div class="ls-post-filters clearfix">

				<!-- Post types -->
				<select data-param="post_type" name="post_type" class="multiple" multiple="multiple">
					<?php foreach($postTypes as $item) : ?>
					<?php if(isset($slider['properties']['post_type']) &&  in_array($item['slug'], $slider['properties']['post_type'])) : ?>
					<option value="<?php echo $item['slug'] ?>" selected="selected"><?php echo ucfirst($item['name']) ?></option>
					<?php else : ?>
					<option value="<?php echo $item['slug'] ?>"><?php echo ucfirst($item['name']) ?></option>
					<?php endif ?>
					<?php endforeach; ?>
				</select>

				<!-- Post categories -->
				<select data-param="post_categories" name="post_categories" class="multiple" multiple="multiple">
					<option value="0"><?php _e("Don't filter categories", "LayerSlider") ?></option>
					<?php foreach ($postCategories as $item): ?>
					<?php if(isset($slider['properties']['post_categories']) && in_array($item->term_id, $slider['properties']['post_categories'])) : ?>
					<option value="<?php echo $item->term_id ?>" selected="selected"><?php echo ucfirst($item->name) ?></option>
					<?php else : ?>
					<option value="<?php echo $item->term_id ?>"><?php echo ucfirst($item->name) ?></option>
					<?php endif ?>
					<?php endforeach ?>
				</select>

				<!-- Post tags -->
				<select data-param="post_tags" name="post_tags" class="multiple" multiple="multiple">
					<option value="0"><?php _e("Don't filter tags", "LayerSlider") ?></option>
					<?php foreach ($postTags as $item): ?>
					<?php if(isset($slider['properties']['post_tags']) && in_array($item->term_id, $slider['properties']['post_tags'])) : ?>
					<option value="<?php echo $item->term_id ?>" selected="selected"><?php echo ucfirst($item->name) ?></option>
					<?php else : ?>
					<option value="<?php echo $item->term_id ?>"><?php echo ucfirst($item->name) ?></option>
					<?php endif ?>
					<?php endforeach ?>
				</select>

				<!-- Post taxonomies -->
				<select data-param="post_taxonomy" name="post_taxonomy" class="ls-post-taxonomy">
					<option value="0"><?php _e("Don't filter taxonomies", "LayerSlider") ?></option>
					<?php foreach ($postTaxonomies as $key => $item): ?>
					<?php if(isset($slider['properties']['post_taxonomy']) && $slider['properties']['post_taxonomy'] == $key) : ?>
					<option value="<?php echo $item->name ?>" selected="selected"><?php echo $item->labels->name ?></option>
					<?php else : ?>
					<option value="<?php echo $item->name ?>"><?php echo $item->labels->name ?></option>
					<?php endif ?>
					<?php endforeach ?>
				</select>

				<!-- Taxonomy terms -->
				<?php if(!empty($slider['properties']['post_taxonomy'])) : ?>
				<?php $postTaxTerms = get_terms($slider['properties']['post_taxonomy']); ?>
				<?php else : ?>
				<?php $postTaxTerms = array(); ?>
				<?php endif ?>
				<select data-param="post_tax_terms" name="post_tax_terms" class="multiple" multiple="multiple">
					<?php foreach ($postTaxTerms as $item): ?>
					<?php if(isset($slider['properties']['post_tax_terms']) && in_array($item->term_id, $slider['properties']['post_tax_terms'])) : ?>
					<option value="<?php echo $item->term_id ?>" selected="selected"><?php echo $item->name ?></option>
					<?php else : ?>
					<option value="<?php echo $item->term_id ?>"><?php echo $item->name ?></option>
					<?php endif ?>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		<h3 class="subheader clearfix">
			<div class="half"><?php echo _e('Order results by', 'LayerSlider') ?></div>
			<div class="half"><?php echo _e('On this slide', 'LayerSlider') ?></div>
		</h3>
		<div class="ls-post-adv-settings clearfix">

			<!-- Order  -->
			<div class="half">
				<?php lsGetSelect($lsDefaults['slider']['postOrderBy'], $slider['properties'], array('data-param' => $lsDefaults['slider']['postOrderBy']['keys'])) ?>
				<?php lsGetSelect($lsDefaults['slider']['postOrder'], $slider['properties'], array('data-param' => $lsDefaults['slider']['postOrder']['keys'])) ?>
			</div>

			<!-- Post offset -->
			<div class="half">
				<?php _e('Get the ', 'LayerSlider') ?>
				<select data-param="post_offset" name="post_offset" class="offset">
					<option value="-1"><?php _e('following', 'LayerSlider') ?></option>
					<?php for($c = 0; $c < 30; $c++) : ?>
					<option value="<?php echo $c ?>"><?php echo ls_ordinal_number($c+1) ?></option>
					<?php endfor ?>
				</select>
				<?php _e('item in the set of matched selection', 'LayerSlider') ?>
			</div>
		</div>
		<h3 class="subheader preview-subheader"><?php echo _e('Preview from currenty matched elements', 'LayerSlider') ?></h3>
		<div class="ls-post-previews"><ul></ul></div>
	</div>
</div>
