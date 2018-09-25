<?php

// Shortcode init

function vntd_sc_toggle()
{
	add_action('cs_init_bilder', 'vntd_toggle_init_info');
	add_action('cs_init_shortcode','vntd_toggle_init_bilder');
}

add_action('wp_cs_init','vntd_sc_toggle');


// Shortcode Builder


function vntd_toggle_init_info()
{
	cs_show_bilder(
		'toggle',
		'Toggle',
		'Just a toggle. What else can I say?',
		''
	);
}

function vntd_toggle_init_bilder($id)
{
	if($id == 'toggle' || $id == 'accordion'):
		$out = '';
		ob_start(); 
		vntd_toggle_builder();
		$out .= ob_get_contents(); 
		ob_end_clean();
		cs_show_shortcode($id,$out,'toggle');
	endif;
}
	
function vntd_toggle_builder()
{

$element_title = "Toggle Title";
?>

<div>

<div class="toggle-left cs-c-left">
		
	<script type="text/javascript">
	(function($){
	
		function ToggleCallback(){
			console.log('Toggle Callback');
		}
		
		carretaSetData('toggle','callback',ToggleCallback);
		
		$('.add-new-element').click(function() {
		
		    //create an element
		    
		    var element = $('<li class="toggle">\
		    	<div class="toggle-title"><div class="toggle-icon"></div><span><?php echo $element_title ?></span></div><div class="toggle-content">\
		    		<div><label>Title</label>\
		    		<input type="text" class="toggle-title-input" value="<?php echo $element_title ?>" placeholder="Type in the title here..">\
		    		</div><div><label>Content</label>\
		    		<textarea class="toggle-content-input" placeholder="Enter your content here.."></textarea></div>\
		    	</div><div class="remove-toggle"></div></li>');
		    
		    //append the new element with a fade animation
		    
		    element.hide().appendTo(".cs-toggles-list").fadeIn(250);

			$('.toggle > .toggle-title').unbind('toggle');
			$('.remove-toggle').unbind('click');
			toggle();
			
			$('.toggle-title-input').unbind('on');
		    live_title_update();
		    return false;
		});	
						
		$(".cs-toggles-list").sortable({
			placeholder: 'placeholder',
			forcePlaceholderSize: true
		});
		
		
		function toggle() {	
			jQuery('.toggle > .toggle-title').toggle(function() {
				jQuery(this).addClass("toggle-active");
				jQuery(this).next().slideDown(250);
			}, function() {
				jQuery(this).removeClass("toggle-active");
				jQuery(this).next().slideUp(250);
			});	
			
			$('.remove-toggle').click(function() {
				$(this).closest(".toggle").remove();
			});	
		}
		
		toggle();
		
		function live_title_update(){
		
			$('.toggle-title-input').on('keyup change', function() {
				$(this).closest('.toggle').find('.toggle-title span').text($(this).val());
			});		
		}
		
		live_title_update();
			
	})(jQuery)
	</script>
	
	<style>
		.cs-toggles-list .placeholder {
			border: 2px dashed #ccc;
			background-color: #f9f9f9;
			max-width: 800px;
			box-sizing: border-box;
		}
	</style>
	
	<div class="element-buttons">
		<div class="add-new-element">Add new</div>
	</div>
	
	<div class="cs-p-l-wrap">
		<ul class="cs-toggles-list">
		
			<li class="toggle">
				<div class="toggle-title"><div class="toggle-icon"></div><span><?php echo $element_title ?></span></div>
				
				<div class="toggle-content">
					<div>
						<label><?php echo $element_title ?></label>
						<input type="text" class="toggle-title-input" value="<?php echo $element_title ?>" placeholder="Type in the title here..">
					</div>
					<div>
						<label>Content</label>
						<textarea class="toggle-content-input" placeholder="Enter your content here.."></textarea>
					</div>					
				</div>
				<div class="remove-toggle"></div>
			</li>
			
		</ul>
	</div>
	
</div>

<br clear="both"/>
</div>
<?php			
}


// Shortcode Processing


function vntd_toggle($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => ''
	), $atts));
	
	return '<div class="vntd-toggle"><h4 class="vntd-toggle-title">'.$title.'</h4><div class="vntd-toggle-content">'.vntd_do_shortcode($content).'</div></div>';
}
remove_shortcode('toggle');
add_shortcode('toggle', 'vntd_toggle'); 