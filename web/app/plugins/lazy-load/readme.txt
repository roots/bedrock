=== Lazy Load ===
Contributors: batmoo, automattic, jakemgold, 10up
Tags: lazy load, images, front-end optimization
Requires at least: 3.2
Tested up to: 4.6
Stable tag: 0.6.1

Lazy load images to improve page load times and server bandwidth. Images are loaded only when visible to the user.

== Description ==

Lazy load images to improve page load times. Uses jQuery.sonar to only load an image when it's visible in the viewport.

This plugin is an amalgamation of code written by the WordPress.com VIP team at Automattic, the TechCrunch 2011 Redesign team, and Jake Goldman (10up LLC).

Uses <a href="http://www.artzstudio.com/files/jquery-boston-2010/jquery.sonar/ ">jQuery.sonar</a> by Dave Artz (AOL).

== Installation ==

1. Upload the plugin to your plugins directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Enjoy!

== Screenshots ==

No applicable screenshots

== Frequently Asked Questions ==

= How do I change the placeholder image =

`
add_filter( 'lazyload_images_placeholder_image', 'my_custom_lazyload_placeholder_image' );
function my_custom_lazyload_placeholder_image( $image ) {
	return 'http://url/to/image';
}
`

= How do I lazy load other images in my theme? =

You can use the lazyload_images_add_placeholders helper function:

`
if ( function_exists( 'lazyload_images_add_placeholders' ) )
	$content = lazyload_images_add_placeholders( $content );
`

Or, you can add an attribute called "data-lazy-src" with the source of the image URL and set the actual image URL to a transparent 1x1 pixel.

You can also use output buffering, though this isn't recommended:

`
if ( function_exists( 'lazyload_images_add_placeholders' ) )
	ob_start( 'lazyload_images_add_placeholders' );
`

This will lazy load <em>all</em> your images.

== Changelog ==

= 0.6.1 =

* Security: XSS fix (reported by <a href="https://klikki.fi/">Jouko Pynnöne</a>

= 0.6 =

* Filter to control when lazy loading is enabled

= 0.5 =

* Fix lazyload_images_add_placeholders by adding missing return, props Kevin Smith
* Lazy load avatars, props i8ramin
* Don't lazy load images in the Dashboard
* Better compatibility with Jetpack Carousel

= 0.4 =

* New helper function to lazy load non-post content
* Prevent circular lazy-loading

= 0.3 =

* Make LazyLoad a static class so that it's easier to change its hooks
* Hook in at a higher priority for content filters

= 0.2 =

* Adds noscript tags to allow the image to show up in no-js contexts (including crawlers), props smub
* Lazy Load post thumbnails, props ivancamilov

= 0.1 =

* Initial working version
