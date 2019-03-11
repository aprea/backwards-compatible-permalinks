=== Backwards Compatible Permalinks ===
Contributors: aprea
Tags: permalink,permalinks,url,urls
Requires at least: 4.8
Tested up to: 5.1
Requires PHP: 5.6
Stable tag: trunk
License: GPL v3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Provides a degree of backwards compatibility when switching between permalink structures.

== Description ==
Backwards Compatible Permalinks helps prevent 404 errors when switching between permalink structures.

It achieves this by appending a set of backwards compatible post rewrite rules. This ensures posts are still accessible at their previous permalink after the permalink structure is updated.

#### Example

Let's say your permalink structure is set to "Month and name" and you have a post titled "I Love WordPress." That particular post would live at "https://your-site.com/2019/03/i-love-wordpress/".

But what if you wanted to switch to the "Post name" permalink structure and have your post live at "https://your-site.com/i-love-wordpress/" instead?

You could but this would result in the existing post permalink 404ing when visited. Which is problematic if the previous URL was bookmarked or shared on social media.

With Backwards Compatible Permalinks installed your post would be accessible at both the old and new permalink structures:

* https://your-site.com/2019/03/i-love-wordpress/
* https://your-site.com/i-love-wordpress/

#### Caveats

* This plugin does not work retroactively. i.e. you must have the plugin installed and activated prior to switching permalink structures before backwards compatibility will work.
* Currently only standard posts are supported.
* Backwards compatibility is not supported between certain permalink structure updates. This is due to a clash between permalink structure regex matching.
* Backwards compatibility is only provided between the most recent permalink structure update. i.e. you cannot change your permalink structure 3 times and have backwards compatibility across all 3 structures.

#### Deactivate or uninstall

After deactivating or uninstalling this plugin please ensure you visit Settings > Permalinks in the WordPress admin area to flush your rewrite rules.

#### Contributing

Contributions are [welcomed on GitHub](https://github.com/aprea/backwards-compatible-permalinks).

== Installation ==
=== From within WordPress ===

1. Visit 'Plugins > Add New'.
1. Search for 'Backwards Compatible Permalinks'.
1. Activate Backwards Compatible Permalinks from your Plugins page.

=== Manually ===

1. Upload the `backwards-compatible-permalinks` folder to the `/wp-content/plugins/` directory.
1. Activate the Backwards Compatible Permalinks plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==
= Why is my old post URL not redirecting to the new URL? =
This is currently not supported, the post will be accessible at both URLs. I agree that this isn't the ideal behaviour but it was too tricky to support redirects while also ensuring query parameters and "/page/xx" and "/comment-page-xx" modifiers were respected during the redirect. The good news is that the canonical tag will always point to the new URL so there shouldn't be any SEO ramifications.

= Does this plugin provide access to any actions/filters? =

A single filter is available. You may use the `aprea_back_compat_permalink_structure` filter to provide a backwards compatible permalink structure, e.g. `/%year%/%monthnum%/%day%/%postname%/`.

This is helpful if you updated the permalink structure prior to installing this plugin.

= The plugin is not working for me! =
I'm terribly sorry! You may want to check the caveats section to see if any apply to your situation. Otherwise feel free to post in the support forums.

== Changelog ==
= 0.1.0 =
Initial release.
