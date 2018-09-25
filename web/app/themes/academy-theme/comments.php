<?php
global $post;

	if (have_comments()){	
?>
	
	<div id="comments" class="single-blog-post-comments">
		
		<ul class="comments">
		<?php 
		wp_list_comments('type=comment&callback=vntd_comment');				
		?>				
		</ul>
		<div class="pagination"><div class="pagination-inner">
		<?php 
		paginate_comments_links(array(
			'prev_text' => '',
			'next_text' => ''
		)); 
		?>
		</div></div>	
	
	</div>		
	
	<?php } // Comments list end ?>		
	
	<div id="respond">
		
		<div class="post-respond-holder post-form clearfix">
			
		<?php 
		
		$args = array(
			 'title_reply'	=> '',
			 'comment_field' =>  '<div class="comment-form-comment col-xs-12"><label>'.__('Your Message','north').' *</label><textarea name="comment" id="comment" class="form textarea light-form" aria-required="true"></textarea></div>',
			 'fields' => apply_filters( 'comment_form_default_fields', array(
			 
			 	'author' 	=> '<div class="col-xs-6 comment-form-author"><label>'.__('Your Name','north').' *</label><input id="author" name="author" type="text" required="required" class="form light-form"/></div>',
			 	'email' 	=> '<div class="col-xs-6 comment-form-email"><label>'.__('Your E-Mail','north').' *</label><input id="email" name="email" type="email" required="required" class="form light-form"/></div>',
			   )),
		);
					
		comment_form($args); 		
		
		?>			   

		</div>
	</div>