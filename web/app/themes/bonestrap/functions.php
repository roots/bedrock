<?php
/*
Developed by: Efeqdev Design and Web Development
URL: http://efeqdev.com
Adapted from brilliant work by:

Eddie Machado
URL: http://themble.com/bones/

Twitter Bootstrap
URL: http://getbootstrap.com

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bonestrap.php
    - head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
    - custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/bonestrap.php'); // if you remove this, bones will break
/*
2. library/custom-post-type.php
    - an example custom post type
    - example custom taxonomy (like categories)
    - example custom taxonomy (like tags)
*/
// require_once('library/custom-post-type.php'); // you can disable this if you like
/*
3. library/admin.php
    - removing some default WordPress dashboard widgets
    - an example custom dashboard widget
    - adding custom login css
    - changing text in footer of admin
*/
// require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
    - adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'thumb-600', 600, 150, true );
add_image_size( 'thumb-300', 300, 100, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bonestrap_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => __('Sidebar 1', 'bonestraptheme'),
    	'description' => __('The first (primary) sidebar.', 'bonestraptheme'),
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));

    /*
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call
    your new sidebar just use the following code:

    Just change the name to whatever your new
    sidebar's id is, for example:

    register_sidebar(array(
    	'id' => 'sidebar2',
    	'name' => __('Sidebar 2', 'bonestraptheme'),
    	'description' => __('The second (secondary) sidebar.', 'bonestraptheme'),
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));

    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php

    */
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bonestrap_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
			    <?php
			    /*
			        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
			        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			    */
			    ?>
			    <!-- custom gravatar call -->
			    <?php
			    	// create variable
			    	$bgauthemail = get_comment_author_email();
			    ?>
			    <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
			    <!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'bonestraptheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'bonestraptheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'bonestraptheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="alert info">
          			<p><?php _e('Your comment is awaiting moderation.', 'bonestraptheme') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
    <!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bonestrap_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'bonestraptheme') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestraptheme').'" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
} // don't remove this bracket!

// Remove WP upgrade notices
add_action('admin_menu','wphidenag');
function wphidenag() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}

/**
* Define a constant path to your single template folder in your configuration file - copy the line below:
* You can also uncomment the line below, but then you will receive error messages in debug mode. Constants should be established in your configuration file, not in your functions file.
* define(SINGLE_PATH, '/single');
*/

/**
* Filter the single_template with our custom function
*/
add_filter('single_template', 'my_single_template');

/**
* Single template function which will choose our template
*/
function my_single_template($single) {
    global $wp_query, $post;

    // You must declare a SINGLE_PATH constant in your configuration file: define(SINGLE_PATH, "/single");
    $theme_path = TEMPLATEPATH . SINGLE_PATH;
    /**
    * Checks for single template by ID
    */
    if(file_exists($theme_path . '/single-' . $post->ID . '.php'))
        return $theme_path . '/single-' . $post->ID . '.php';

    /**
    * Checks for single template by post type
    */
    if(file_exists($theme_path . '/single-' . $post->post_type . '.php'))
        return $theme_path . '/single-' . $post->post_type . '.php';

    /**
    * Checks for single template by category
    * Check by category slug and ID
    */
    foreach((array)get_the_category() as $cat) :

        if(file_exists($theme_path . '/single-cat-' . $cat->slug . '.php'))
            return $theme_path . '/single-cat-' . $cat->slug . '.php';

        elseif(file_exists($theme_path . '/single-cat-' . $cat->term_id . '.php'))
            return $theme_path . '/single-cat-' . $cat->term_id . '.php';

    endforeach;

    /**
    * Checks for single template by tag
    * Check by tag slug and ID
    */
    $wp_query->in_the_loop = true;
    if(get_the_tags()){
        foreach((array)get_the_tags() as $tag) :

            if(file_exists($theme_path . '/single-tag-' . $tag->slug . '.php'))
                return $theme_path . '/single-tag-' . $tag->slug . '.php';

            elseif(file_exists($theme_path . '/single-tag-' . $tag->term_id . '.php'))
                return $theme_path . '/single-tag-' . $tag->term_id . '.php';

        endforeach;
    }
    $wp_query->in_the_loop = false;

    /**
    * Checks for single template by author
    * Check by user nicename and ID
    */
    $curauth = get_userdata($wp_query->post->post_author);

    if(file_exists($theme_path . '/single-author-' . $curauth->user_nicename . '.php'))
        return $theme_path . '/single-author-' . $curauth->user_nicename . '.php';

    elseif(file_exists($theme_path . '/single-author-' . $curauth->ID . '.php'))
        return $theme_path  . '/single-author-' . $curauth->ID . '.php';

    /**
    * Checks for default single post files within the single folder
    */
    if(file_exists($theme_path . '/single.php'))
        return $theme_path . '/single.php';

    elseif(file_exists($theme_path . '/default.php'))
        return $theme_path . '/default.php';

    return $single;

}

?>
