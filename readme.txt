=== search-into-subcategories ===
Plugin Name: search-into-subcategories
Plugin URI: http://wordpress.org/plugins/search-into-subcategories/
Description: search-into-subcategories
Author: lion2486
Version: 0.1.1
Author URI: http://codescar.eu 
Contributors: lion2486
Tags: search, subcategories 
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: 0.1.1
Text Domain: search-into-subcategories
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Search-Into-Subcategories plugin allows you to make a select-search shortcode for your own categories.

== Description ==

Search-Into-Subcategories plugin allows you to make a select-search shortcode for your own categories.

You can use if everywhere you want and make a tree structure for your categories.

[search-into-subcategories]

Arguments you can pass
	parent_category Default is 0
		You can list only sub categories of the category id you give here. With 0 lists alla categories
	max_depth Default is 2
		How many subcategories to display, at least 1.
	search_input Default is 1
		Display a text input for search.
	labels Default is <empty string>
		Labels for the inputs. Give them in the position you want with '|' as seperator. example: Category1|Category2|Text
	search_text Default is Search
		The text to display in search button
	hide_empty Default is 1
		hide categories without content, set to 0 to display all!
	exclude Default is <empty string>
		Category Ids to exlude from listing. Separate them with ','. Example: 6,7,13
		
Example:
[search-into-subcategories parent_category=0 max_depth=3 search_input=1 labels=cat1|cat2|cat3|Text search_text=Find hide_empty=0 exclude=7,6]

== Screenshots ==

1. Search Category Level 1
2. Search Category Level 2
3. Search Category Level 3 & Input

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `Search-into-subcategories-plugin` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the shortcode into your page/post you want.

== Changelog ==
= 0.1.1 =
*Javascript file loading only when shortcode used
*A label id fix
*screenshots name fix

= 0.1 =
* first version