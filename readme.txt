=== AdPlugg WordPress Ad Plugin ===
Contributors: adplugg
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: ads, advertising, banners, ad rotator, ad server, ad manager, adsense
Requires at least: 3.3
Tested up to: 5.0.2
Requires PHP: 5.2.4
FBIA tested up to: 4.2.0
AMP tested up to: 0.7.2
Stable tag: 1.9.30

Advertising is easy with AdPlugg. The AdPlugg WordPress Ad Plugin and ad server 
allow you to easily manage, schedule, rotate and track your ads.

== Description ==
The AdPlugg WordPress Ad Plugin works in conjunction with the <strong>FREE</strong> 
[adplugg.com](https://www.adplugg.com?utm_source=wpo-listing&utm_campaign=desc-l1) ad service.

= Plugin Features =
The AdPlugg WordPress Ad Plugin includes the following awesome features:

* Ability to add your AdPlugg ads to your WordPress site from the WordPress Administrator with no access to the underlying source code required.
* Ability to add you AdPlugg ads to any Widget Area on your site by dragging the AdPlugg Widget into that area.
* Support for Zones allowing you to put different ads in different locations on a page.
* Support for Facebook Instant Articles allowing you to include ads in your FBIA feed.
* Support for AMP (Accelerated Mobile Pages) allowing you to include ads in your AMP pages.
* GDPR compliant.
* Works with AdPlugg's Free and Pro versions.

<strong>PS: You'll need a free [adplugg.com Access Code](https://www.adplugg.com/apusers/signup?utm_source=wpo-listing&utm_campaign=feat-l1) in order to use the plugin.</strong>

= AdPlugg Service Features =

The FREE AdPlugg Ad Service includes the following amazing features:

* Ad Rotating - Rotate which ads are displayed or the relative positioning of multiple ads.
* Ad Scheduling - Set the start and stop dates for an individual ad or group of ads.
* Ad Tracking - Track ad impressions and ad clicks.
* Analytics - View daily, monthly or yearly graphs of your impressions and clicks.
* Zones - Break your site up into different zones such as the top bar or side bar.
* Placements - Group your ads into placements to simplify management and tracking.
* Easy Setup - Easily create and setup your ads.
* Timed Rotate - Set your ads to rotate after a set interval.
* GDPR compliant - Serve ads while adhering to the privacy rules of the GDPR.

The PRO AdPlugg Ad Service adds the following additional features:

* Downloadable PDF, Excel and CSV Reports
* Unlimited Scaling
* Additional ad formats including Custom/HTML5, Flash, JavaScript, bar, dialog, interstitial, slide-in, text, and more.
* Additional targeting options (such as targeting ads by on-page meta tags).
* Ability to serve ad tags from third party systems such as Google AdSense.

== Installation ==

1. Upload the AdPlugg WordPress Ad Plugin to your blog.
2. Activate it.
3. Enter your [adplugg.com Acccess Code](https://www.adplugg.com/apusers/signup?utm_source=wpo-listing&utm_campaign=inst-l1).
4. Drag the AdPlugg Ad Widget to the Widget Area where you want your ads to display.
5. Optionally add the Zone machine name into the widget. This will make it so that the AdPlugg server only loads ads designated for the zone into the widget.
6. Optionally Enable Facebook Instant Articles integration and drag AdPlugg widgets into your FBIA header.

== Frequently Asked Questions ==

For questions and answers, visit the [AdPlugg Question/Answer System at AdPlugg.com](https://www.adplugg.com/support/question-answer?utm_source=wpo-listing&utm_campaign=faq-l1).

== Screenshots ==

1. The AdPlugg WordPress Ad Plugin makes it easy to place ads on your WordPress site.

== Changelog ==

= 1.9.30 =
* Updated the readme.txt to reflect that the plugin is tested and working with WordPress 5.0.2.
* Updated the copyright date to 2019.
* Linted the main adplugg.php file to meet all WP coding standards.
* Linted the functions.php file to meet all WP coding standards.
* Linted the AdPlugg_Options class to meet all WP coding standards.
* Linted the AdPlugg_Facebook class to meet all WP coding standards.

= 1.9.29 =
* Updated the readme.txt to reflect that the plugin is tested and working with WordPress 5.0.1.

= 1.9.28 =
* Moved the AdPlugg general options page help to a class (instead of a global function).
* Moved the AdPlugg widgets page help to a class (instead of a global function). 
* Got rid of the no-longer-used AdPlugg_Help_Dispatch class.

= 1.9.27 =
* Updated the readme.txt to reflect that the plugin has been tested with up to v4.2.0 of the FBIA plugin.
* Updated the readme.txt to reflect that the plugin has been tested with up to v0.7.2 of the AMP plugin.

= 1.9.26 =
* Fixed a bug with how the widget was being rendered (introduced in 1.9.24).

= 1.9.25 =
* Fixed a bug with the Test_AMP_Options_Page_Help class where it was adding help to all wp-admin pages (introduced in 1.9.23).

= 1.9.24 =
* Updated the readme.txt to reflect that the plugin has been tested with up to WordPress 5.0.
* Updated the copyright date from 2017 to 2018.
* Fixed an inconsequential error message that was showing when saving the widget. 
* Linted the entire AdPlugg_Widget class to meet all WP coding standards.

= 1.9.23 =
* Moved the Facebook Options page help to a class (instead of a global function).

= 1.9.22 =
* Linted all admin page classes to meet WP coding standards.

= 1.9.21 =
* Linted the AdPlugg_Notice class to meet all WP coding standards.

= 1.9.20 =
* Removed the use of the deprecated 'create_function' when registering the widget.

= 1.9.19 =
* Linted the AdPlugg_Notice_Controller class. 
* Added CSRF protection to the notice system.

= 1.9.18 =
* Moved the AMP Options page help to a class (instead of a global function).

= 1.9.17 =
* Moved the help system includes to the main plugin file.
* Linted the widgets-page-help.php file to meet the WP coding standards.

= 1.9.16 =
* Updated the visibility on the 'instance' property of all singletons to 'private'.

= 1.9.15 =
* Linted the options-page-help.php file.

= 1.9.14 =
* Added unit testing to the Test_Help_Dispatch class for testing the contextual help for the AMP settings page.

= 1.9.13 =
* Linted the facebook-options-page-help.php file to meet all of the WP coding standards.

= 1.9.12 =
* Renamed and linted the class-adplugg-help-dispatch.php file to meet all of the WP coding standards.

= 1.9.11 =
* Updated the readme.txt to reflect that the plugin has been tested with up to v4.1.1 of the FBIA plugin.

= 1.9.10 =
* Added Composer (for installing our dev dependencies).
* Added a phpcs.xml file (for checking our code against the WP coding standards).
* Linted the amp-options-page-help.php file to meet all of the WP coding standards.

= 1.9.9 =
* Updated the readme.txt to reflect that the plugin has been tested with up to WP 4.9.8.

= 1.9.8 =
* Converted the AdPlugg_Options_Page class to a singleton to match the rest of our admin pages.

= 1.9.7 =
* Fixed the PHPDoc on the get_instance method on several classes.

= 1.9.6 =
* Updated the readme.txt to reflect that the plugin has been tested with up to WP 4.9.7

= 1.9.5 =
* Fixed some issues with the PHPDoc on the AdPlugg_Notice_Controller class.

= 1.9.4 =
* Restructured the admin contextual help dispatch system for better OOP design.

= 1.9.3 =
* Added a new AdPlugg icon font.
* Now using the AdPlugg icon font for the admin menu (instead of an embedded SVG).

= 1.9.2 =
* Cleaned up the test_admin_init test function in the Test_Options_Page class.
* Now fully testing the admin_init method of the AdPlugg_Facebook_Options_Page class.

= 1.9.1 =
* Fixed a testing bug with the test-facebook-options-page-help.php when run in isolation.

= 1.9.0 =
* Added info regarding GDPR compliance to the readme.txt.
* Updated the readme.txt to reflect that the plugin has been tested and is compatible with up to WP v4.9.6.
* Now displaying suggested privacy policy text in the privacy policy settings screen in the wp-admin.

= 1.8.9 =
* Misc fixes for WP coding standards (spaces after while and foreach, snake_case variables).

= 1.8.8 =
* Added help for using AdPlugg for Facebook Instant Articles to the contextual help on the widgets page in the admin.

= 1.8.7 =
* Updated styling of all 'if' statements to match WP coding standards.

= 1.8.6 =
* Updated the incorrect PHPDoc on some of the FBIA related methods.

= 1.8.5 =
* Updated the label text on the FBIA automatic placement option to be more clear and consistent.
* Updated the readme.txt to remove "New" from the timed rotate feature.

= 1.8.4 =
* Updated the readme to reflect that the plugin has been test up to WordPress 4.9.5.

= 1.8.3 =
* Fixed an issue with the option validation.

= 1.8.2 =
* AMP ad bottom margin now properly matches its top margin.

= 1.8.1 =
* Now inserts an ad at the bottom of any short AMP posts.

= 1.8.0 =
* Now backwards compatible down to PHP 5.2.4.

= 1.7.0 =
* AMP (Accelerated Mobile Pages) support added.

= 1.6.24 =
* Updated the readme.txt to reflect that the plugin has been tested with up to v4.0.6 of the FBIA plugin.

= 1.6.23 =
* Fixed an error in the Facebbook Instant Articles contextual help.

= 1.6.22 =
* Updated the readme to reflect that the plugin has been tested with up to WP 4.9.4.

= 1.6.21 =
* Made the notice controller into a singleton.

= 1.6.20 =
* Updated the readme.txt to reflect that the plugin has been tested with up to WP 4.9.2.

= 1.6.19 =
* Updated all indentation to use tabs instead of spaces to match the WordPress Coding Standards.

= 1.6.18 =
* Added unit testing for the AdPlugg_Facebook_Instant_Articles->insert_ads method.

= 1.6.17 =
* Added unit testing for the AdPlugg_Facebook_Instant_Articles->header_injector method.

= 1.6.16 =
* Now checks to make sure an access code is entered before trying to serve ads into Facebook Instant Articles.

= 1.6.15 =
* Added unit testing for the render and get_rendered methods of the Notice class.

= 1.6.14 =
* Added CTA buttons to notices to make setup easier.

= 1.6.13 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.9.1.

= 1.6.12 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.9.0.

= 1.6.11 =
* Refactored global notice functions into the notice controller.

= 1.6.10 =
* Added a new AdPlugg_Options class for better OOP design.

= 1.6.9 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.8.3.

= 1.6.8 =
* Fixed a comment typo. 
* Now explicitly declaring visibility for all methods in the AdPlugg_Notice class.

= 1.6.7 =
* Added additional testing on the AdPlugg access code retrieval function.

= 1.6.6 =
* Added unit testing for the AdPlugg_Facebook_Instant_Articles class.

= 1.6.5 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.8.2.

= 1.6.4 =
* Explicitly declared visibility for all methods in the AdPlugg_Notice_Controller class.

= 1.6.3 =
* Renamed some test files to match our file naming conventions.

= 1.6.2 =
* Added 'Requires PHP: 5.3' tag to the readme.txt file.

= 1.6.1 =
* Updated tests/test-adplugg.php for WP coding standards.

= 1.6.0 =
* Updated the endpoint for FBIA ads to www.adplugg.io (with temporary allowance for staying on www.adplugg.com).

= 1.5.18 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.8.1.

= 1.5.17 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v4.0.4 of the FBIA plugin.
* Updated tests/functions.php for WP coding standards.

= 1.5.16 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v4.0.3 of the FBIA plugin.
* Updated bootstrap.php for WP coding standards.

= 1.5.15 =
* Updated the options page tests to add testing that ensures that the access code is stored correctly.
* Added unit testing for the AdPlugg_Options_Page->admin_init() method.

= 1.5.14 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v4.0.2 of the FBIA plugin.
* Updated the tags and description in the readme.txt file.
* Updated the readme.txt file to include info regarding the new Open Graph targeting functionality.

= 1.5.13 =
* Updated test-functions.php for WP coding standards.

= 1.5.12 =
* Updated the copyright date.
* Updated link params.

= 1.5.11 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.8.0.

= 1.5.10 =
* Made the adplugg sdk functions into a class.

= 1.5.9 =
* Updated test-class-adplugg-widget.php for WP coding standards.

= 1.5.8 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.7.5.

= 1.5.7 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v3.3.5 of the FBIA plugin.

= 1.5.6 =
* Updated the widget help and made 'adplugg.com' references into links.

= 1.5.5 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.7.4.

= 1.5.4 =
* Updated the names of our enqueued script and stylesheet to 'adplugg-admin'.

= 1.5.3 =
* Updated test-sdk.php for WP coding standards.

= 1.5.2 =
* Notices are now dismissible (using built in WP is-dismissible functionality).

= 1.5.1 =
* Fixed some typos/issues with the options page help.

= 1.5.0 =
* Moved the SDK to the top of the head section for faster loading.

= 1.4.19 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.7.3.

= 1.4.18 =
* Optimized the dash icon to hopefully fix the flashing issue.

= 1.4.17 =
* Updated test-class-adplugg-admin.php for WP coding standards.

= 1.4.16 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v3.3.3 of the FBIA plugin.
* Updated the install-wp-tests.sh script to fix test errors.

= 1.4.15 =
* Updated all links to adplugg.com to use https.

= 1.4.14 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v3.3.1 of the FBIA plugin.

= 1.4.13 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.7.2.

= 1.4.12 =
* Removed non-working .travis.yml file.

= 1.4.11 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.7.1.

= 1.4.10 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v3.3.0 of the FBIA plugin.

= 1.4.9 =
* Updated the README.md file to reflect changes to the git repo.

= 1.4.8 =
* Updated the review link for changes at wordpress.org.

= 1.4.7 =
* Fixed bug with the path to the admin assets (css, js).
* Updated/fixed the link for writing a review.
* Removed some JavaScript under development that was erroneously released.
* Updated the admin tests to use the new top level AdPlugg menu.

= 1.4.6 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with up to v3.2.2 of the FBIA plugin.

= 1.4.5 =
* Updated the readme.txt file to reflect that the plugin is fully tested and working with WP 4.7.0.

= 1.4.4 =
* Updated deprecated constructor (as of php 7) in the AdPlugg_Widget class.

= 1.4.3 =
* Standardized the file and class names in the test suite.

= 1.4.2 =
* Renamed class files to accurately reflect the full name of the contained class as per WP coding standards.

= 1.4.1 =
* Updated test-options-page.php for WP coding standards.

= 1.4.0 =
* Major refactoring - moved all includes to a new includes directory.

= 1.3.29 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v3.2.0 of the FBIA plugin.

= 1.3.28 =
* Moved the css and js files to a new assets folder.

= 1.3.27 =
* Updated test-notice-functions.php for WP coding standards.

= 1.3.26 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v3.1.3 of the FBIA plugin.

= 1.3.25 =
* Updated the notice classes for changes to the WP notice system.

= 1.3.24 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to WP 4.6.1.

= 1.3.23 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v3.1.2 of the FBIA plugin.

= 1.3.22 =
* Updated class-admin.php to use generic function names.

= 1.3.21 =
* Updated the settings link in the plugin listing.

= 1.3.20 =
* Updated test-notice-controller-class.php for WP coding standards.

= 1.3.19 =
* Fixed comments on validation function for main options page.

= 1.3.18 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to WP 4.6.

= 1.3.17 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v3.0.1 of the FBIA plugin.

= 1.3.16 =
* Made the configure notice dismissible.

= 1.3.15 =
* Updated test-notice-class.php for WP coding standards.

= 1.3.14 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to WP 4.5.3.

= 1.3.13 =
* Fixed the webkit-appearance issue with the widget checkboxes in chrome.

= 1.3.12 =
* Updated test-widgets-page-help.php for WP coding standards.

= 1.3.11 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to v2.11 of the FBIA plugin.

= 1.3.9 =
* Added "Quick Start" help videos.

= 1.3.8 =
* Fixed the configure notice link so that it goes to the new top level AdPlugg settings page.

= 1.3.7 =
* Added FAQ section to the help.

= 1.3.6 =
* Updated the readme.txt file to reflect that the plugin is tested and working with up to WP 4.5.2.

= 1.3.5 =
* Fixed a bug where the save messages weren't showing on the options page.
* Updated the readme.txt file to reflect that the plugin is tested and working with up to WP 4.5.1 and FBIA up to 2.10.

= 1.3.4 =
* Updated the readme.txt to reflect that the plugin is tested and working with up to v2.9 of the FBIA plugin.

= 1.3.3 =
* Fixed some buginess with the FBIA automatic placement enable field.
* Updated the readme.txt to reflect that the plugin is tested and working with up to v2.8 of the FBIA plugin.

= 1.3.2 =
* Added support for fb-instant-articles 0.3 - 2.5.
* Updated the readme.txt to reflect that WP 4.5 if fully tested and working.

= 1.3.1 =
* Bumping the version for auto updaters (initial post of 1.3.0 to wordpress.org had a failed merge).

= 1.3.0 =
* Added support for Facebook Instant Articles.
* Moved AdPlugg to a top level menu.

= 1.2.50 =
* Updated test-options-page-help.php for WP coding standards.

= 1.2.49 =
* Modified the ad tag filter for feeds to handle nested div tags.

= 1.2.48 =
* Now filtering in-content AdPlugg Ad Tags out of feeds.

= 1.2.47 =
* Updated test-help-dispatch.php for WP coding standards.

= 1.2.46 =
* Added data-cfasync="false" attribute to the SDK script tag.

= 1.2.45 =
* Fixed some typos in the phpdoc in the AdPlugg_Notice class.

= 1.2.44 =
* Updated the description/help on the plugin listing in the WP admin.

= 1.2.43 =
* Added a custom footer to the settings screen.

= 1.2.42 =
* Updated the readme.txt file to reflect that WP 4.4.2 is fully tested and working.

= 1.2.41 =
* Truncated the Changelog in readme.txt and provided link to changelog.txt

= 1.2.40 =
* Removed debug messages from admin.js

= 1.2.39 =
* Updated the comments on the AdPlugg_Notice_Controller's admin_notices() function.

= 1.2.38 =
* Updated the readme.txt file to reflect that WP 4.4.1 is fully tested and working.

= 1.2.37 =
* Updated class-options-page.php to use generic function names.

= 1.2.36 =
* Updated sdk.php for WP coding standards.

= 1.2.35 =
* Updated class-admin.php for WP coding standards.

= 1.2.34 =
* Updated the readme.txt file to reflect that WP 4.4 is fully tested and working.

= 1.2.33 =
* Updated class-notice-controller.php to use generic function names.

= 1.2.32 =
* Updated class-options-page.php for WP coding standards.

= 1.2.31 =
* Updated notice-functions.php for WP coding standards.

= 1.2.30 =
* Updated class-notice.php for WP coding standards.

= 1.2.29 =
* Widget title in the admin now includes the zone (if one is set).

= 1.2.28 =
* Updated class-notice-controller.php for WP coding standards.

= 1.2.27 =
* Added Ad Tag info to the help.

= 1.2.26 =
* Added unit test for widget registration.

= 1.2.25 =
* Updated install-wp-tests.sh for compatibility with latest WP.

= 1.2.24 =
* Updated widgets-page-help.php for WP coding standards.

= 1.2.23 =
* Updated options-page-help.php for WP coding standards.

= 1.2.22 =
* Updated the readme.txt file to reflect that WP 4.3.1 is fully tested and working.

= 1.2.21 =
* Updated the readme.txt to show Pro features.

= 1.2.20 =
* Updated help-dispatch.php for WP coding standards.

= 1.2.19 =
* Updated all "API" references to "SDK".

= 1.2.18 =
* Increased the size of the Access Code field.
* Fixed a bug with the help link on WP 4.3.

= 1.2.17 =
* Fixed cosmetic spacing issue with the widget fieldset.

= 1.2.16 =
* Updated the readme.txt file to reflect that WP 4.3 is fully tested and working.

= 1.2.15 =
* Updated the readme.txt file to reflect that WP 4.2.4 is fully tested and working.

= 1.2.14 =
* Updated functions.php for WP coding standards.

= 1.2.13 =
* Updated adplugg.php for WP coding standards.

= 1.2.12 =
* Added PHPUnit test for the AdPlugg_Widget constructor.

= 1.2.11 =
* Fixed the PHPDoc in the notice controller class.

= 1.2.10 =
* Fixed the PHPDoc in the admin class.

= 1.2.9 =
* Updated the copyright date.

= 1.2.8 =
* Fixed issue causing the help link to not display.

= 1.2.7 =
* Renamed several class files to adhere to WP coding standards.

= 1.2.6 =
* Updated QUnit tests for timed rotate config changes.

= 1.2.5 =
* Updated readme.txt to include timed rotate feature.

= 1.2.4 =
* Fixed the markup in the options page help.

= 1.2.3 =
* Fixed the QUnit styling.

= 1.2.2 =
* Updated the readme.txt file to reflect that WP 4.2.1 is fully tested and working.

= 1.2.1 =
* Updated the readme.txt file to reflect that WP 4.2 is fully tested and working.

= 1.2 =
* Added an advanced notices system with dismissible notices.

[See changelog.txt for more](http://plugins.svn.wordpress.org/adplugg/trunk/changelog.txt).
