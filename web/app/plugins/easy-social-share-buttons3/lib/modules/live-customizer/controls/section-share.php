<?php

if (!class_exists('ESSBLiveCustomizerControls')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/controls.php');
}

global $post_id;
$custom = get_post_custom ( $post_id );
$shareoptimization_state = essb_options_bool_value ( 'opengraph_tags' );
$pinterest_sniff_disable = essb_options_bool_value('pinterest_sniff_disable');

$essb_post_og_desc = isset ( $custom ["essb_post_og_desc"] ) ? $custom ["essb_post_og_desc"] [0] : "";
$essb_post_og_title = isset ( $custom ["essb_post_og_title"] ) ? $custom ["essb_post_og_title"] [0] : "";
$essb_post_og_image = isset ( $custom ["essb_post_og_image"] ) ? $custom ["essb_post_og_image"] [0] : "";

$essb_post_twitter_hashtags = isset ( $custom ['essb_post_twitter_hashtags'] ) ? $custom ['essb_post_twitter_hashtags'] [0] : "";
$essb_post_twitter_username = isset ( $custom ['essb_post_twitter_username'] ) ? $custom ['essb_post_twitter_username'] [0] : "";
$essb_post_twitter_tweet = isset ( $custom ['essb_post_twitter_tweet'] ) ? $custom ['essb_post_twitter_tweet'] [0] : "";
$essb_post_pin_image = isset ( $custom ["essb_post_pin_image"] ) ? $custom ["essb_post_pin_image"] [0] : "";
$essb_post_share_message = isset ( $custom ["essb_post_share_message"] ) ? $custom ["essb_post_share_message"] [0] : "";

$sso_post_title = '';
$sso_post_desc = '';
$sso_post_image = '';

$settings_twitteruser = essb_option_value('twitteruser');
$settings_twitterhash = essb_option_value('twitterhashtags');

if ($shareoptimization_state) {
	$sso_post_title = get_the_title($post_id);
	$sso_post_desc = essb_core_get_post_excerpt($post_id);
	$sso_post_image = essb_core_get_post_featured_image($post_id);
	
	if (defined('WPSEO_VERSION')) {
			
		$yoast_title = get_post_meta( $post_id, '_yoast_wpseo_title', true);
		$yoast_description = get_post_meta( $post_id, '_yoast_wpseo_metadesc', true);
			
		if ($yoast_title != '') {
			$sso_post_title = $yoast_title;
		}
		if ($yoast_description != '') {
			$sso_post_desc = $yoast_description;
		}
	}
}

?>

<style type="text/css">
.essb-live-customizer .col1-2 { width: 48%; vertical-align: top; }
.essb-live-customizer .col1-2:nth-child(odd) { margin-right: 15px; }

</style>

<div class="section-share">
	<div class="customizer-inner-title"><span>Optimize Information That Social Networks Will Share for current post/page</span></div>
	
	<?php if (!$shareoptimization_state): ?>
	<div class="row">
		Social Share Optimization tags are not active on your site. To activate them visit plugin options menu Social Sharing and navigate to <b>Sharing Optimization</b>.
	</div>
	<div class="row">
		<a href="<?php echo admin_url('admin.php?page=essb_redirect_social&section=optimize-7'); ?>" class="essb-composer-button essb-composer-blue" target="_blank"><i class="fa fa-cog"></i> Open Required Settings</a>
	</div>
	
	<?php else:?>
	
	<div class="row">
		<div class="col1-2">
		<!-- first column -->
			<div class="row field">
		Share Image
	</div>
	<div class="row param">
		<div class="facebook-image-preview">
			<img src="<?php echo ($essb_post_og_image != '') ? $essb_post_og_image: $sso_post_image; ?>" class="facebook-image-preview-placeholder"/>
					
				<a href="#" class="essb-composer-button essb-composer-blue" id="essb_fileselect_og_image_button"><i class="fa fa-upload"></i></a>
		</div>

		<script type="text/javascript">

		jQuery(document).ready(function($){
			 
			 
		    var custom_uploader;
		 
			function essb_og_image_upload() {
				 //If the uploader object has already been created, reopen the dialog
		        if (custom_uploader) {
		            custom_uploader.open();
		            return;
		        }
		 
		        //Extend the wp.media object
		        custom_uploader = wp.media.frames.file_frame = wp.media({
		            title: 'Select File',
		            button: {
		                text: 'Select File'
		            },
		            multiple: false
		        });
		 
		        //When a file is selected, grab the URL and set it as the text field's value
		        custom_uploader.on('select', function() {
		            attachment = custom_uploader.state().get('selection').first().toJSON();
		            $('#essb_fileselect_og_image').val(attachment.url);

		            if ($('.facebook-image-preview-placeholder').length) {
			            $('.facebook-image-preview-placeholder').attr('src', attachment.url);
		            }
		        });
		 
		        //Open the uploader dialog
		        custom_uploader.open();
		    }

			 
		    $('#essb_fileselect_og_image').click(function(e) {
		 
		        e.preventDefault();
		 
		        essb_og_image_upload();
		 
		    });

		    $('#essb_fileselect_og_image_button').click(function(e) {
				 
		        e.preventDefault();
		 
		        essb_og_image_upload();
		 
		    });
		});
		
		</script>
		<input type="text" name="essb_fileselect_og_image" id="essb_fileselect_og_image" class="section-save" data-update="meta" data-field="essb_post_og_image" value="<?php echo $essb_post_og_image; ?>" placeholder="<?php echo $sso_post_image; ?>" style="display: none; " />
	</div>
	<div class="row description">
		Add an image that is optimized for maximum exposure on social networks. We recommend 1,200px by 628px.
	</div>
		<!-- end first column -->
	
		</div>
		<div class="col1-2">
		<!-- second column -->

	<div class="row field">
		Share Title
	</div>
	<div class="row param">
		<input type="text" name="sso_title" class="section-save" data-update="meta" data-field="essb_post_og_title" value="<?php echo $essb_post_og_title; ?>" placeholder="<?php echo $sso_post_title; ?>" />
	</div>
	<div class="row description">
		Fill in custom sharing title which will appear in Oper Graph Tags. 
	</div>

	
	<div class="row field">
		Share Description
	</div>
	<div class="row param">
		<textarea name="sso_title" class="section-save" data-update="meta" data-field="essb_post_og_desc" rows="4" placeholder="<?php echo $sso_post_desc; ?>"><?php echo $essb_post_og_desc; ?></textarea>
	</div>
	<div class="row description">
		Fill in custom sharing title which will appear in Oper Graph Tags. 
	</div>
		
		<!-- end second column -->
		</div>
	</div>
	

	
	
	<?php endif; ?>
	
	<div class="row">
		<div class="col1-2">
		<!-- first column -->
			<div class="customizer-inner-title"><span>Tweet Optimizations</span></div>

	<div class="row field">
		Hashtags
	</div>
	<div class="row param">
		<input type="text" class="section-save" name="sso_title" data-update="meta" data-field="essb_post_twitter_hashtags" value="<?php echo $essb_post_twitter_hashtags; ?>" placeholder="<?php echo $settings_twitterhash; ?>" />
	</div>
	<div class="row description">
		Personalize hashtags that will appear into Tweet. The default hashtags you can fill in Social Sharing -> Social Networks -> Additional Network Options
	</div>
	
	<div class="row field">
		Via Twitter User
	</div>
	<div class="row param">
		<input type="text" class="section-save" name="sso_title" data-update="meta" data-field="essb_post_twitter_username" value="<?php echo $essb_post_twitter_username; ?>" placeholder="<?php echo $settings_twitteruser; ?>" />
	</div>
	<div class="row description">
		Personalize via username that will appear into Tweet. The default username you can fill in Social Sharing -> Social Networks -> Additional Network Options
	</div>
	
	<div class="row field">
		Tweet
	</div>
	<div class="row param">
		<textarea name="sso_title" class="section-save" data-update="meta" data-field="essb_post_twitter_tweet" rows="4" placeholder="<?php echo $sso_post_title; ?>"><?php echo $essb_post_twitter_tweet; ?></textarea>
	</div>
	<div class="row description">
		Tweet is build using post title. Fill in here your own custom Tweet to get better social reach.
	</div>
		
		<!-- end: first column -->
		</div>

		<div class="col1-2">
		<!-- second column -->
			<div class="customizer-inner-title"><span>Share Message</span></div>
	<div class="row field">
		Customized shared message
	</div>
	<div class="row param">
		<textarea name="sso_title" class="section-save" data-update="meta" data-field="essb_post_share_message" rows="4" placeholder="<?php echo $sso_post_title; ?>"><?php echo $essb_post_share_message; ?></textarea>
	</div>
	<div class="row description">
		This is message is used by some social networks as option for the sharing. For example all mobile messanger applications, Pinterest as descriptio of Pin when you turn off option to Pin any image and etc. All major social
		networks read the sharing message from social sharing optimization tags which is why they are important to be active on site.
	</div>

	<div class="customizer-inner-title"><span>Pinterest</span></div>
	<div class="row field">
		Pin only selected image
	</div>
	<div class="row">
		<?php 
		ESSBLiveCustomizerControls::draw_switch_field2('pinterest_sniff_disable', $pinterest_sniff_disable, 'options', 'pinterest_sniff_disable');
		?>
	</div>
	<div class="row description">
		Default plugin setup allows to pin any image from your site. If you wish to change this you can do it here and set pin of only one image that you set.
	</div>
	<div class="pinterest-custom-image" <?php if ($pinterest_sniff_disable == '') { echo 'style="display: none;"'; } ?>>
		<div class="row field">
			Pinterest Image
		</div>
		<div class="row param">
			<?php ESSBLiveCustomizerControls::draw_image_select('pinterest-preview-image', 'essb_post_pin_image', 'meta', $essb_post_pin_image); ?>
		</div>
		<div class="row description">
			Choose optimized for pin image that plugin will use once user press Pinterest sharing button.
		</div>
	
	</div>
	
		<!-- end: second column -->
		</div>
		
	</div>

	
	
	<div class="row">
		<a href="#" class="essb-composer-button essb-composer-blue essb-section-save" data-section="section-share"><i class="fa fa-save"></i> Save Settings</a>
	</div>
</div>

<script type="text/javascript">

function essbLiveCustomizerPostLoad() {
	jQuery('.essb-live-customizer .switch').change(function(){
	    jQuery(this).toggleClass('checked');

	    if (jQuery(this).hasClass('pinterest_sniff_disable')) {
		    if (jQuery(this).hasClass('checked'))
		    	jQuery('.pinterest-custom-image').fadeIn();
		    else
		    	jQuery('.pinterest-custom-image').fadeOut();
	    }
	  });
	
	jQuery(".essb-switch.pinterest_sniff_disable .cb-enable").click(function(){
		jQuery('.pinterest-custom-image').fadeIn();
	});

	jQuery(".essb-switch.pinterest_sniff_disable .cb-disable").click(function(){
		jQuery('.pinterest-custom-image').fadeOut();
	});
}
		
</script>