=== NOTICE BOARD ===
Contributors: jitendriya14, sameerptnk
Donate link: http://jitendriya.net/portfolio/notice-board-wordpress-plugin/
Tags: notice, notice board, announcements, notice widget,plugins
Requires at least: 3.5
Tested up to: 4.3.1
Stable tag: 1.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Provides both widgets and shortcodes to help you display notices and special announcements on your website.

== Description ==

This plugin allows you to show off the notices and special announcements on your WordPress site. You can use the Notice Board widget to display recent notices and special announcements in a widget area. Or use a shortcode to display notices and special announcements within a table or as a list in the main content area for a post or page. This plugin registers a 'notice' slug for all notices as post, so don't create a page or post with 'notice' slug or set the parmalink to "http://yourwordpressdomain/notice". It would conflict with the permalinks.

== Installation ==

Notice Board plugin can be installed by using any of the methods below

= Upload Manually =

1. Download and unzip the plugin
2. Upload the 'msnb-notice-board' folder into the '/wp-content/plugins/' directory
3. Go to the Plugins admin page and activate the plugin

= Install Via Admin Area =

1. In the admin area go to Plugins > Add New and search for "Notice Board"
2. Click install and then click activate

= To Create & View Notices Via Admin Area  =

1. Go to Notices to View, Edit or Delete all Notices.
2. Go to Notices > Add New Notice to create a new notice .
3. Enter Title, Content, Notice url(Optional) and click on the publish button.
4. To add an external link or file for the notice, use Notice url field.
5. While adding file to a notice, first upload the file to your Media Library, and just copy the file URL to the "Notice url" Field. You do not have to insert any media to the notice itself. Just the link to the file is required in the "Notice url" field.  

= How to Use the Notice Board Widget =

1. Setup the Plugin (refer to above).
2. Go to Appearance > Widgets and drag the 'Notice Board' to your widget area.  
3. Enter a Title to appear above Notices list.  For example "Recent Notices".
4. Enter how many Notices you would like to display.
5. Choose the type of Notice Display(Static or Scroll). The scroll type will display a scrolling list of notices.
6. Choose the scroll direction of Notice Display(Upwards or Downwards), and save the widget.

= How to Use the Shortcode =

1. Navigate to the post or page you would like to add the notice table to
2. Enter in the shortcode [notice-board]
3. Customize the number of notices displayed by adding any of these parameters
	* count => Specify the number of notices you want to display. [notice-board count="10"].  By default, 10 notices are displayed.
	* format => table|list specify whether to output the notices in a table or unordered list [notice-board format="table"]. Default = 'table'.
	* class => Specify the wrapping class for the notices [notice-board class="table-bordered"]. Default = 'table'.

== Frequently Asked Questions ==

1. How can I display the notices in  my site?
	Ans:- You can use the 'Notice Board' widget to display a scrolling or static list of notices in your widget area or you can use the '[notice-board]' shortcode to display them in a post or page.
2. How do I change the default display of the notices in a page/post?
	Ans:- When using the notice board shortcode, You can Specify aditional options to controll its appearance. Refer to the installation instructions to know about the options available and their usages. 
3. How can I customize the CSS for the notices?
	Ans:- Both the shortcode and the widget are wrapped inside the css class 'msnb-notice' and 'widget_notice_board_widget'. You can target them using their respective classes in your theme's custom CSS code. 

== Screenshots ==

1. Once you have installed & activate the plugin, navigate to Notices in the admin area to Add,View, Edit & Delete the notices and special announcements.
2. To add a widget to your site go to Appearance > Widgets.  Look for the 'Notice Board' widget and drag to the appropraite widget area.  Enter a title to appear above the notices list, enter the number of notices you would like to appear, choose the type of Notice Display and scroll direction.
3. To display the notice in a table or list inside a post or page use the shortcode '[notice-board]'.  You can also use the some optional parameters with the shortcode to control its appearance.
	* count => Specify the number of notices you want to display. [notice-board count="10"].  By default, 10 notices are displayed.
	* format => table|list specify whether to output the notices in a table or unordered list [notice-board format="table"]. Default = 'table'.
	* class => Specify the wrapping class for the notices [notice-board class="table-bordered"].Default = 'table'.
4. A preview of the notices displaying frontend sidebar & pages within table using widget & shortcode respectively.

== Changelog ==

= 1.0 =

* Initial launch of the plugin

= 1.1 =

* Minor bug Fix
* Compatible with Wordpress-4.3.1

== Upgrade Notice ==

= 1.1 =

* Minor bug Fix
* Compatible with Wordpress-4.2.2