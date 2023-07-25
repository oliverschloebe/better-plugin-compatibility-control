<?php
/**
 * The main plugin file
 *
 * @package WordPress_Plugins
 * @subpackage BetterPluginCompatibilityControl
 */
 
/*
Plugin Name: Better Plugin Compatibility Control
Version: 6.3.0
Plugin URI: https://www.schloebe.de/wordpress/better-plugin-compatibility-control-plugin/
Description: Adds version compatibility info to the plugins page to inform the admin at a glance if a plugin is compatible with the current WP version.
Author: Oliver Schl&ouml;be
Author URI: https://www.schloebe.de/
Text Domain: better-plugin-compatibility-control
Domain Path: /languages


Copyright 2008-2023 Oliver Schlöbe (email : scripts@schloebe.de)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Define the plugin version
 */
define("BPCC_VERSION", "6.3.0");

/**
 * Define the global var BPCCISWP29, returning bool if at least WP 2.9 is running
 */
define('BPCCISWP29', version_compare($GLOBALS['wp_version'], '2.8.999', '>='));

/**
 * Define the plugin path slug
 */
define("BPCC_PLUGINPATH", "/" . plugin_basename( dirname(__FILE__) ) . "/");

/**
 * Define the plugin full url
 */
define("BPCC_PLUGINFULLURL", WP_PLUGIN_URL . BPCC_PLUGINPATH );

/**
 * Define the plugin full directory
 */
define("BPCC_PLUGINFULLDIR", WP_PLUGIN_DIR . BPCC_PLUGINPATH );


/** 
* The BetterPluginCompatibilityControl class
*
* @package WordPress_Plugins
* @subpackage BetterPluginCompatibilityControl
* @since 1.0
* @author scripts@schloebe.de
*/
class BetterPluginCompatibilityControl {
	private static $instance = null;

	/**
	 * The locale info array
	 *
	 * @since 1.0
	 * @var array
	 */
	private $localeInfo = null;

	/**
	 * Creates or returns an instance of this class.
	 */
	public static function get_instance() {
		if( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	/**
 	* The BetterPluginCompatibilityControl class constructor
 	* initializing required stuff for the plugin
 	*
 	* @since 1.0
 	* @author scripts@schloebe.de
 	*/
	function __construct() {
		if ( !BPCCISWP29 ) {
			add_action('admin_notices', array(&$this, 'wpVersionFailed'));
			return;
		}
		
		$this->localeInfo = localeconv();
		
		add_action('plugins_loaded', array(&$this, 'bpcc_load_textdomain'));
		add_action('admin_init', array(&$this, 'bpcc_init'));
	}
	
	
	/**
 	* Initialize and load the plugin stuff
 	*
 	* @since 1.0
 	* @uses $pagenow
 	* @author scripts@schloebe.de
 	*/
	function bpcc_init() {
		global $pagenow;
		if ( !function_exists("add_action") ) return;
		
		
		if((defined('WP_ALLOW_MULTISITE') && WP_ALLOW_MULTISITE || defined('MULTISITE') && MULTISITE) && function_exists('is_network_admin') && is_network_admin()) {
			add_filter('network_admin_plugin_action_links', array(&$this, 'bpcc_pluginversioninfo'), 10, 2);
			if( current_user_can( 'manage_network_plugins' ) ) {
				add_filter('plugin_action_links', array(&$this, 'bpcc_pluginversioninfo'), 10, 2);
			}
		} else {
			if( current_user_can( 'install_plugins' ) ) {
				add_filter('plugin_action_links', array(&$this, 'bpcc_pluginversioninfo'), 10, 2);
			}
		}
		
		if( $pagenow == 'plugins.php' ) {
			add_action('admin_head', array(&$this, 'bpcc_css_admin_header'));
		}
	}


	/**
	 * Writes the css stuff into page header needed for the plugin to look good
	 *
	 * @since 1.0
	 * @author scripts@schloebe.de
	 */
	function bpcc_css_admin_header() {
		echo '
<style type="text/css">
.bpcc_minversion {
	color: #aaa;
	text-shadow: 0 1px 0 #FFFFFF;
	cursor: help;
	padding: 0px;
	text-decoration: none;
	font-weight: 200;
}

.bpcc_maxversion {
	border-left-width: 0;
	color: #aaa;
	text-shadow: 0 1px 0 #FFFFFF;
	cursor: help;
	padding: 0px;
	text-decoration: none;
	font-weight: 200;
}

.bpcc_red {
	color: #a00;
	padding: 1px 2px;
	font-weight: bold;
}

.bpcc_green {
	color: #0a0;
	padding: 1px 2px;
}
</style>' . "\n";
	}
	
	
	/**
 	* Add plugin version dependency info
 	*
 	* @since 1.0
 	* @author scripts@schloebe.de
 	*/
	function bpcc_pluginversioninfo( $links, $file ) {
		$_wpversion = str_replace($this->localeInfo["decimal_point"], ".", floatval($GLOBALS['wp_version'])) . ''; // Only get x.y.0 from WP version string
		
		$minpluginver = $maxpluginver = $minpluginvermajor = '';
		$bpcc_readme = WP_PLUGIN_DIR . '/' . dirname( $file ) . '/' . 'readme.txt';
		if( file_exists( $bpcc_readme ) ) {
			$pluginver_data = get_file_data( $bpcc_readme, array('requires' => 'Requires at least', 'tested' => 'Tested up to') );
			$minpluginver = $pluginver_data['requires'];
			$minpluginvermajor = str_replace($this->localeInfo["decimal_point"], ".", floatval($minpluginver)) . '';
			$maxpluginver = $pluginver_data['tested'];
			if( !empty($pluginver_data['tested']) ) $maxpluginver = $pluginver_data['tested'];
		} else {
			require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
			$info = plugins_api('plugin_information', array('fields' => array('tested' => true, 'requires' => true, 'rating' => false, 'downloaded' => false, 'downloadlink' => false, 'last_updated' => false, 'homepage' => false, 'tags' => false, 'sections' => false, 'compatibility' => false, 'author' => false, 'author_profile' => false, 'contributors' => false, 'added' => false), 'slug' => dirname( $file ) ));
			if (!is_wp_error($info)) {
				if( !empty($info->requires) ) {
					$minpluginver = $info->requires;
					$minpluginvermajor = str_replace($this->localeInfo["decimal_point"], ".", floatval($minpluginver)) . '';
				}
				if( !empty($info->tested) ) $maxpluginver = $info->tested;
			}
		}
		
		if( $minpluginver != '' || $maxpluginver != '' ) {
			$addminverclass = ( version_compare(trim( $minpluginvermajor ), $_wpversion, '>') ) ? ' bpcc_red' : ' bpcc_green';
			$addminvertitle = ( version_compare(trim( $minpluginvermajor ), $_wpversion, '>') ) ? __('Warning: This plugin has not been tested with your current version of WordPress.', 'better-plugin-compatibility-control') : __('This plugin has been tested successfully with your current version of WordPress.', 'better-plugin-compatibility-control');
			$addminverinfo = ( $minpluginver ) ? '<span class="bpcc_minversion' . $addminverclass . '" title="' . $addminvertitle . '">' . trim( $minpluginver ) . '</span>' : '<span class="bpcc_minversion" title="' . __('No compatibility info for this plugin available.', 'better-plugin-compatibility-control') . '">' . __('N/A', 'better-plugin-compatibility-control') . '</span>';
			
			$addmaxverclass = ( version_compare(trim( $maxpluginver ), $_wpversion, '<') ) ? ' bpcc_red' : ' bpcc_green';
			$addminvertitle = ( version_compare(trim( $maxpluginver ), $_wpversion, '<') ) ? __('Warning: This plugin has not been tested with your current version of WordPress.', 'better-plugin-compatibility-control') : __('This plugin has been tested successfully with your current version of WordPress.', 'better-plugin-compatibility-control');
			$addmaxverinfo = ( $maxpluginver ) ? '<span class="bpcc_maxversion' . $addmaxverclass . '" title="' . $addminvertitle . '">' . trim( $maxpluginver ) . '</span>' : '<span class="bpcc_maxversion" title="' . __('No compatibility info for this plugin available.', 'better-plugin-compatibility-control') . '">' . __('N/A', 'better-plugin-compatibility-control') . '</span>';
			
			$addverinfo = '<span class="bpcc_wrapper" style="white-space: normal;">' . $addminverinfo . '&ndash;' . $addmaxverinfo . '';
		} else {
			$addverinfo = '<span class="bpcc_wrapper" style="white-space: normal;"><span class="bpcc_maxversion" title="' . __('No readme.txt file for this plugin found. Contact the plugin author!', 'better-plugin-compatibility-control') . '">' . __('No compatibility data found', 'better-plugin-compatibility-control') . '</span></span>';
		}
		
		$links = array_merge( $links, array( $addverinfo ) );
		
		return $links;
	}
	
	
	/**
 	* Initialize and load the plugin textdomain
 	*
 	* @since 1.0
 	* @author scripts@schloebe.de
 	*/
	function bpcc_load_textdomain() {
		load_plugin_textdomain('better-plugin-compatibility-control', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
	}
	
	
	/**
 	* Checks for the version of WordPress,
 	* and adds a message to inform the user
 	* if required WP version is less than 2.9
 	*
 	* @since 3.8.1.15
 	* @author scripts@schloebe.de
 	*/
	function wpVersionFailed() {
		echo "<div id='wpversionfailedmessage' class='error fade'><p>" . __('Better Plugin Compatibility Control requires at least WordPress 2.9!', 'better-plugin-compatibility-control') . "</p></div>";
	}
	
}

if( is_admin() && class_exists('BetterPluginCompatibilityControl') && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
	add_action( 'plugins_loaded', array( 'BetterPluginCompatibilityControl', 'get_instance' ) );
}
?>
