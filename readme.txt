=== WP TypeIt ===

Contributors: alexmacarthur
Donate link: paypal.me/alexmacarthur
Tags: typewriter effect, text effect, text animation
Requires at least: 4.0
Tested up to: 4.9.6
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
This is the official free WordPress plugin for [TypeIt](https://typeitjs.com), the most versatile animated typing utility on the planet. WP TypeIt allows you to easily generate typewriter effects for your website by use of a single easy-to-configure shortcode. Place this shortcode on any post or page, and the effect will be live.

= The Perks =
* *Unobtrusive* - All this plugin does is register a shortcode you can use in your posts. 
* *Lightweight* - TypeIt is 100% vanilla JavaScript, so it won't load any dependencies like jQuery.
* *Performance in Mind* - TypeIt will only be enqueued if it's actually needed on the page. 
* *The Real Deal* - This plugin is created and maintained by the creator of TypeIt itself. 

= Heads Up for WP TypeIt Pro =
If you're looking to generate more advanced typewriter effects, keep an eye out for WP TypeIt Pro, which will allow you to write multiple strings per instance, build effects with a custom post type and friendly UI, and more. Stay tuned...

== Installation ==
s
1. Download the plugin and upload to your plugins directory, or install the plugin through the WordPress plugins page.
2. Activate the plugin through the 'Plugins' page.

== Using the Plugin ==

= Make an Effect Using Shortcode Attributes =
You can generate a typewriter effect by using a variation of the following shortcode in a post or page, passing each setting as a shortcode attribute. 

At bare minimum, you need to pass a `strings` attribute:

`
[typeit strings="Look, I'm typing a string!"]
`

There also exists a wide set of attributes you may use to customize the typing effects. For example, setting speed (in milliseconds): 

`
<h2>[typeit strings="Look, I'm typing a string!" speed="500"]</h2>
`

Or, making an effect continuously loop:

`
<h2>[typeit strings="This is a string that will loop!" speed="100" loop="true"]</h2>
`

= Defing Strings in an SEO-Friendly Way = 
As demonstrated, you can define a string to be typed by passing it in as a "strings" attribute. However, you may also define them by passing them inside of two enclosing shortcode tags:

`
[typeit speed="300"]This string will exist in your HTML, and when the page is loaded, TypeIt will take over and animate it.[/typeit]
`

When the tag is rendered, that string will be hard-coded on the page, rather than stored in memory on page load. The advantage to this approach is that web crawlers will be able to parse the text without JavaScript, making the content a bit more SEO-friendly.

= View All Available Options = 
For the full list of options you may pass, refer to the documentation at [typeitjs.com/docs#options](https://typeitjs.com/docs#options). 

== Frequently Asked Questions ==

= The TypeIt JS library requires a paid license to use commercially. Do I need one with this plugin? =
Nope! Using this free plugin doesn't require a paid license to use, regardless of the project. However, if you wish to take advantage of the full feature set TypeIt offers, you'll need to purchase a license and implement the JS library on your own. Or, you may [hire me to help](https://macarthur.me/contact).

= Do I need to worry about other JavaScript dependencies (like jQuery) for this to work? = 
Nope! TypeIt uses vanilla JavaScript with no external dependencies, so you're good to go.

== Screenshots ==

== Changelog ==

= 1.0.0 =
* Initial release.

= 1.0.1 =
* Improve documentation.
* Add unit testing for increased code reliability.
* Fix bug causing camel-cased shortcode attributes to work improperly.

== Feedback ==

You like it? [Email](mailto:alex@macarthur.me) or [tweet](http://www.twitter.com/amacarthur) me. You hate it? [Email](mailto:alex@macarthur.me) or [tweet](http://www.twitter.com/amacarthur) me.

Regardless of how you feel, your review would be greatly appreciated!

