=== Apply Online ===
Contributors: farhan.noor
Donate link: http://spiderteams.com
Tags: apply, application, course, course registration, online registration, academic, admission, advertisement, ad, ads, advertisement board, ad board, job board, career, job, vacancy, career page, career portal, job portal, resume, cv, resume, job ad
Requires at least: 3.5
Tested up to: 4.6
Stable tag: 1.5.1
License: GPLv2 or later

Powerful & intuitive plugin to post ads and start receiving applications online.

== Description ==
= Are you looking for a page on your website to start receiving applications? =
With this plugin you can create a job board, advertisement board or open online registration of courses & classes and start receiving applications right from your website.

= Simplest Implementation =
1. After installations, locate the menu **Apply Online** in admin panel and create few ads.
1. Now open link on your website with **ads** slug i.e. yourdomain.com/**ads**.

= Or =
1. After installations, locate the menu **Apply Online** in admin panel and create few ads.
1. From Wordpress admin panel, add a page i. e. **Careers** or **New Admissions**
1. Place **[aol]** shortcode into this page and let the magic begin.

= Powerful Features =
* Standard Wordpress interface to add, categorize and manage ads.
* Show description, features and application form on individual advertisement page.
* Get email notifications when an application is received.
* List all ads, multiple ads or categories on any web page.
* Receive resume/CV along with online application.
* Hooks and functions for advancements and customization.

For demo, please check [WP Reloaded](http://wpreloaded.com/plugins/apply-online "Your favorite plugin"). Your suggestions and error reports can really help to improve this plugin.

* Created with love by [Spider Teams](http://spiderteams.com "We create the web!")

== Installation ==

1. Download plugin.
1. Upload downloaded zip file to the /wp-content/plugins/ directory of your web server.
1. Activate plugin through the 'Plugins' menu in WordPress dashboard.
1. Locate the menu **Apply Online** in admin panel and create few ads here.
1. Now open link of your website similar to **yourdomain.com/ads**.

= Method 2 =
1. After installations, locate the menu **Apply Online** in admin panel and create few ads there.
1. From Wordpress admin panel, add a page i. e. **Careers** or **New Admissions**
1. Place **[aol]** shortcode into this page and let the magic begin.

== Screenshots ==

1. Write shortcode in a page editor. 
2. Ads listing.
3. Ad edit/add page. 
4. All received applications.
5. A received application detailed page.
6. Front-end view of Ads listing on "Careers" page.
7. Front-end detailed single page of an ad.

== Frequently Asked Questions ==

= How to create an ad? =
In your WordPress admin panel, go to "Apply Online" menu and add a new ad listing.

= How to show ad listings on the front-end? =
Add [aol] shortcode in an existing page or add a new page and write shortcode anywhere in the page editor. Now click on VIEW to see all of your ads on front-end.

= Can I show few ads on front-end? =
Yes, you can show any number of ads on your website by using shortcode with "ads" attribute. Ad ids must be separated with commas i.e. [aol ads="1,2,3"].

= Can I show ads from particular category only? =
Yes, you can show ads from any category / categories using "categories" attribute. Categories' ids must be separated with commas i.e. [aol categories="1,2,3"].

= Can I show ads without excerpt/summary? =
Yes, use shortcode with "excerpt" attribute i.e. [aol excerpt="no"]

= What attributes can i use in the shortcode? =
Default shortcode with all attributes is [aol categories="1,2,3" ads="1,2,3" excerpt="no"]. Use only required attributes.

= How can i get the id of a category or ad? =
In admin panel, move your mouse pointer on an item in categories or ads table. Now you can view item ID in the info bar of the browser.

= Does this plugin have hooks for customization of plugin behavior? =
Yes, This plugin have a filter hook **aol_content** to modify the content of the application form.

== Changelog ==

= 1.5.1 =
* Fixed: Removed odd alert at the time of application submission.

= 1.5 =
* Fixed: Default file field issue in settings. 
* New: aol_content filter hook introduced to control the output of [aol] shortcode.
* New: aol_features function added to show application featres in custom template.
* New: aol_application function added to show application form in custom template.

= 1.4 =
* Fixed: Email issue. 
* New: Custom file upload field in ad editor introduced.
* Overall enhancement.

= 1.3 =
* Fixed: Application Form Fields delete issue. 
* Fixed: Delete button disappears in application form fields in post editor.
* New: Templates/Default Fields introduced.


= 1.2.1 =
Fixed: Link to new application in email alert.

= 1.2 =
* **Plugin Settings** introduced.
* Add emails to get application alerts.
* Overall enhancement. 

= 1.1 =
* **Categories** introduced.
* **Shortcode** updated.
* Bug fixed for CV / resume attachment in application form.

= 1.0 =
* Plugin launched.

== Upgrade Notice ==

= 1.5.1 =
Bug Fixes, patches and new features. Upgrade recommended.

= 1.4 =
Bug Fixes, patches and new features. Upgrade immediately.

= 1.3 =
Fixes, patches and new features. Upgrade immediately.

= 1.2.1 =
Link to new application in email alert fixed. Upgrade recommended.

= 1.2 =
New hot features added. Upgrade immediately.

= 1.1 =
This version fixes bugs in shortcode, and file attachment with application form. Upgrade immediately.

= 1.0 =
Plugin launched.