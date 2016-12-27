=== Better Plugin Compatibility Control ===
Contributors: Alphawolf
Donate link: https://www.schloebe.de/donate/
Tags: admin, management, plugin, plugins, version, control, compatibility, compatible
Requires at least: 2.9
Tested up to: 4.7.9999
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds version compatibility info to the plugins page to inform the admin at a glance if a plugin is compatible with the current WP version.

== Description ==

**Better Plugin Compatibility Control** makes it easy for the blog administrator to **check compatibility of all installed plugins**. The plugin adds version compatibility info to the plugins page to inform the admin at a glance if a plugin is compatible with the current WP version. Until now you had to look it up on the respective plugin page. It's now up to the admin wether to deactivate a non-compatible plugin or not.

**Included languages:**

* English
* German (de_DE) (Thanks to me ;-))
* Finnish (fi_FI) (Thanks to C. Hellberg for contributing finnish language)
* Belorussian (by_BY) (Thanks for contributing belorussian language goes to [Marcis Gasuns](http://www.fatcow.com))
* Russian (ru_RU) (Thanks for contributing russian language goes to [iPower](http://www.ipower.com))
* Uzbek (uz_UZ) (Thanks for contributing uzbek language goes to [Alexandra Bolshova](http://www.comfi.com))
* French (fr_FR) (Thanks for contributing french language goes to [tolingo translations](http://www.tolingo.com))
* Spanish (es_ES) (Thanks for contributing spanish language goes to nomeconsumas.org)
* Hebrew (he_IL) (Thanks for contributing hebrew language goes to Atar4U / https://profiles.wordpress.org/ahrale/)
* Simplified Chinese (zh_CN) (Thanks for contributing simplified chinese language goes to 斌果)
* Italian (it_IT) (Thanks for contributing italian language goes to venerdi)

[Developer on Google+](https://plus.google.com/118074611982254715031 "Developer on Google+") | [Developer on Twitter](http://twitter.com/wpseek "Developer on Twitter")

**Looking for more WordPress plugins? Visit [www.schloebe.de/portfolio/](https://www.schloebe.de/portfolio/)**

== Frequently Asked Questions ==

= Why isn't this or that implemented to improve the plugin interface? =

If you have suggestions please let me know by dropping me a line via e-mail or the wp.org forums.

= History? =

Please visit [the official website](http://www.schloebe.de/wordpress/better-plugin-compatibility-control-plugin/#english "Better Plugin Compatibility Control") for the latest information on this plugin.

= Where can I get more information? =

Please visit [the official website](https://www.schloebe.de/wordpress/better-plugin-compatibility-control-plugin/#english "Better Plugin Compatibility Control") for the latest information on this plugin.

== Installation ==

1. Download the plugin and unzip it.
2. Upload the folder better-plugin-compatibility-control/ to your /wp-content/plugins/ folder.
3. Activate the plugin from your WordPress admin panel.
4. Installation finished.

== Changelog ==

= 4.7.0.1 =
* Fixed an `Undefined property: stdClass::$tested` issue

= 4.7.0 =
* WordPress 4.7 compatibility
* PHP 7 compatibility

= 4.6.1 =
* Fixed a small bug in version coloring

= 4.6.0 =
* Version bump

= 4.5.0 =
* Added italian localization (Thanks to venerdi!)
* Version bump

= 4.4.0.2 =
* Code and compatibility improvements (thanks AlfonsBerger!)

= 4.4.0.1 =
* Prepared for localization on wp.org
* Visual improvements (thanks Demetrio Mendozzi!)
* Fixed readme.txt typo (thanks Demetrio Mendozzi!)

= 4.4.0 =
* Version dump

= 4.1.1 =
* Added hebrew localization (Thanks to Atar4U!)

= 4.0.999 =
* Version dump
* Code cleanup and improvements

= 3.8.1.10 =
* Change of how version compatibility indications are handled (e.g., instead of indicating 3.8.1 as incompatible on an 3.8 install, it now indicates all 3.8.x versions as compatible, so if a plugin supports a major version, it's assumed to support all minor versions too) (props GermanKiwi!)

= 3.8.1.5 =
* Lowered the plugin's minimum WP requirement
* Improved multisite compatibility

= 3.8.1.1 =
* Fixed long line of unwrapped text in version info in some cases

= 3.8.1 =
* Code cleanup

= 3.8 =
* Version dump
* Code cleanup and improvements

= 3.6 =
* Code cleanup and improvements

= 3.5.1 =
* Version dump

= 3.5 =
* Readme.txt updated to be more compliant with the readme.txt standard
* Moved screenshots off the package to the assets/ folder

= 3.4.1 =
* Maintenance Release (Thanks a lot Gary Gale!)

= 3.4 =
* Maintenance Release

= 3.3 =
* Maintenance Release

= 1.1.1 =
* Now combines information from local readme.txt files and wordpress.org repository data, preferring local data
* Multisite support

= 1.1 =
* New min version set to WP 2.8
* Improved and more up-to-date compatibility info parsing by using `plugins_api` instead of parsing the plugin's local readme file
* Code cleanup

= 1.0.1 =
* WordPress 2.8 compatibility

= 1.0 =
* Plugin released

== Other Notes ==

= Licence =

This plugins is released under the GPL, you can use it free of charge on your personal or commercial blog.

== Screenshots ==

1. The added compatibility version information below plugin titles.