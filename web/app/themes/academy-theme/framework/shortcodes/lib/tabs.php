<?php

function vntd_sc_tabs()
{
	add_action('cs_init_bilder', 'vntd_tabs_init_info');
	add_action('cs_init_shortcode','vntd_tabs_init_bilder');
}

add_action('wp_cs_init','vntd_sc_tabs');


// Shortcode Builder


function vntd_tabs_init_info()
{
	cs_show_bilder(
		'tabs',
		'Tabs',
		'Just tabs. What else can I say?',
		''
	);
}

function vntd_tabs_init_bilder($id)
{
	if($id == 'tabs'):
		$out = '';
		ob_start(); 
		vntd_tabs_builder();
		$out .= ob_get_contents(); 
		ob_end_clean();
		cs_show_shortcode($id,$out,'tabs');
	endif;
}
	
function vntd_tabs_builder()
{

?>
<div>

	<div class="tabs-left cs-c-left">
		
		<script type="text/javascript">
		(function($){
		
			function TabsCallback(){
				console.log('Tabs Callback');
			}
			
			carretaSetData('tabs','callback',TabsCallback);
		
			$('.add-new-element').click(function() {			
		    
		    	var new_tab = $('<div class="tab-content">\
		    		<div>\
		    			<label>Title</label>\
		    			<input type="text" class="tab-title-input" value="" placeholder="Type in the title here..">\
		    		</div>\
		    		<div>\
		    			<label>Content</label>\
		    			<textarea class="tab-content-input" placeholder="Enter your content here.."></textarea>\
		    		</div>\
		    	</div>');
			    //append the new element with a fade animation
			    
			    $('<li>New tab</li>').hide().appendTo(".tabs-nav").fadeIn(250);
			    new_tab.hide().appendTo(".tabs-content");
			    
			    
			    $(".tabs-nav li").unbind('click');
			    tabs();
			    
			    $('.tab-title-input').unbind('on');
			    live_title_update();
			    
			    return false;
			});	
			
			$('.remove-element').click(function() {			
			
				var length = $("ul.tabs-nav li").length;
				
				if(length > 1){
			    	$(".tabs-nav li.tab-active, .tab-content:visible").remove();
				    $(".tab-content:first-child").show();
				    
				    $(".tabs-nav li").unbind('click');
				    tabs();
			    }
			    return false;
			});	
			
			$(".tabs-nav").sortable({
				placeholder: 'placeholder',
				forcePlaceholderSize: true
			});
			
			//var forcePlaceholderSize = $( ".cs-tabs-list" ).sortable( "option", "forcePlaceholderSize" );
			
			function tabs() {	
				jQuery('.tabs-nav li:first-child').addClass('tab-active');
				jQuery('.tabs-nav li').click(function(){
					jQuery(this).addClass("tab-active").siblings().removeClass("tab-active");
				    jQuery('.tabs-content > .tab-content:eq(' + jQuery(this).index() + ')').fadeIn().siblings().hide();
				});
			}
			
			tabs();
			
			function live_title_update(){
			
				$('.tab-title-input').on('keyup change', function() {
					
					var index = $(this).closest('.tab-content').index()+1;
					$('.tabs-nav').find('li:nth-child('+index+')').text($(this).val());
				});		
			}
			
			live_title_update();
				
		})(jQuery)
		</script>
		
		<style>
		
				
		</style>
		
		<div class="element-buttons">
			<div class="add-new-element">Add new tab</div>
			<div class="remove-element">Remove current tab</div>
		</div>
		
		<div class="cs-p-l-wrap">
		
			<div class="tabs">
				<ul class="tabs-nav">				
					<li>Tab 1</li>	
					<li>Tab 2</li>	
				</ul>
				<div class="tabs-content">
					<div class="tab-content">
						<div>
							<label>Title</label>
							<input type="text" class="tab-title-input" value="" placeholder="Type in the title here..">
						</div>
						<div>
							<label>Content</label>
							<textarea class="tab-content-input" placeholder="Enter your content here.."></textarea>
						</div>
					</div>
					<div class="tab-content">
						<div>
							<label>Title</label>
							<input type="text" class="tab-title-input" value="" placeholder="Type in the title here..">
						</div>
						<div>
							<label>Content</label>
							<textarea class="tab-content-input" placeholder="Enter your content here.."></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	<br clear="both"/>
</div>
<?php			
}


// Shortcode Processing


function vntd_tabs( $atts, $content ){
	$GLOBALS['tab_count'] = 0;
	$i = 0;
	
	do_shortcode( $content );
	
	if( is_array( $GLOBALS['tabs'] ) ){
	foreach( $GLOBALS['tabs'] as $tab ){
	$count = $i++;
	$tabs[] = '<li>'.$tab['title'].'</li>';
	$panes[] = '<div class="vntd-tab-content">'.$tab['content'].'</div>';
	}
	$return = "\n".'<div class="vntd-tabs"><ul class="vntd-tabs-nav">'.implode( "\n", $tabs ).'</ul>'."\n".'<div class="vntd-tabs-content">'.implode( "\n", $panes ).'</div></div>'."\n";
	unset($GLOBALS['tabs']);
	}
	return $return;
}
remove_shortcode('tabs');
add_shortcode( 'tabs', 'vntd_tabs' );

function vntd_tab( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => 'Tab %d'
	), $atts));
	
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );
	
	$GLOBALS['tab_count']++;
}
remove_shortcode('tab');
add_shortcode( 'tab', 'vntd_tab' );