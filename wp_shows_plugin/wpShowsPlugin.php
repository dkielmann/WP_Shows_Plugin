<?php
/*
Plugin Name: WP Shows Plugin
Plugin URI: https://github.com/dkielmann/WP_Shows_Plugin
Description: A plugin for administration and sheduling of show plans for online radio stations
Author: Daniel Kielmann
Version: 0.2.0
Author URI: https://github.com/dkielmann
*/


// Derive the current path and load up Sanity
$plugin_path = dirname(__FILE__).'/';
if(class_exists('BasicPluginFramework') != true)
    require_once($plugin_path.'framework/basicpf.php');
if(class_exists('Smarty') != true)
    require_once($plugin_path.'framework/smarty/Smarty.class.php');


/*
*		Define your plugin class which extends the BasicPluginFramework
*		Make sure you skip down to the end of this file, as there are a few
*		lines of code that are very important.
*/ 
class WPSPlugin extends BasicPluginFramework {
	
	/*
	*	Some required plugin information
	*/
	var $version = '0.2.0';
	
	/*
	*		Required __construct() function that initalizes the Sanity Framework
	*/
	function __construct() {
		parent::__construct(__FILE__);
		$this->smarty->debugging = true;
		   
		// adding the AJAX actions
		$this->ajax_actions('admin') = array('genre_create','genre_get','genre_save','genre_delete');
	}

	/*
	 * AJAX Functions for Genre
	 */
	function genre_create() {
		$this->create_nonce('genre');
		
		$this->data = array(
			'labels' => array (
				'title' => __('Titel'),
				'description' => __('Beschreibung'),
				'color' => __('Farbe'),
				'save' => __('Hinzufügen'),
			),
			'nonce' => $this->nonce('genre'),
		);
		die();
	}
	
	/*
	*		Run during the activation of the plugin
	*/
	function activate() {
		global $wpdb;
		
		// create table for show categories and
		$install_wpsp_categories_sql =  "CREATE TABLE `{$wpdb->prefix}".wpsp_Genre::$table_name."` (";
		$install_wpsp_categories_sql .= "  `id` INT(20) NOT NULL AUTO_INCREMENT,";
		$install_wpsp_categories_sql .= "  `title` varchar(255),";
		$install_wpsp_categories_sql .= "  `description` text,";
		$install_wpsp_categories_sql .= "  `color` varchar(6),";
		$install_wpsp_categories_sql .= "  PRIMARY KEY (`id`)) ENGINE = MyISAM;";
		$wpdb->query($install_wpsp_categories_sql);
		
		// create table for show sheduling
		$install_wpsp_scheduling_sql =  "CREATE TABLE `{$wpdb->prefix}".wpsp_Scheduling::$table_name."` (";
		$install_wpsp_scheduling_sql .= "  `id` INT(20) NOT NULL AUTO_INCREMENT,";
		$install_wpsp_scheduling_sql .= "  `showID` INT(20),";
		$install_wpsp_scheduling_sql .= "  `ts_start` DATETIME,";
		$install_wpsp_scheduling_sql .= "  `ts_duration` INT(20),";
		$install_wpsp_scheduling_sql .= "  `repeatit` BOOLEAN,";
		$install_wpsp_scheduling_sql .= "  `repeatcount` INT(2),";
		$install_wpsp_scheduling_sql .= "  `repeatintervall` VARCHAR(2),";
		$install_wpsp_scheduling_sql .= "  `repeattimes` VARCHAR(2000),";
		$install_wpsp_scheduling_sql .= "  `repeatuntil` DATETIME,";
		$install_wpsp_scheduling_sql .= "  PRIMARY KEY (`id`)) ENGINE = MyISAM;";
		$wpdb->query($install_wpsp_scheduling_sql);
		
		// add some standard options for categories and others
		$genre1 = new wpsp_Genre('Black Music', 'Black Music', '000000');
		$genre1 = new wpsp_Genre('Schlager', 'Schlager', 'fff600');
		$genre1 = new wpsp_Genre('Klassik', 'Klassik', 'ffbf00');
		$genre1 = new wpsp_Genre('Jazz', 'Jazz', 'a4ff26');
		$genre1 = new wpsp_Genre('Dance & Electro', 'Dance & Electro', '00d8ff');
		$genre1 = new wpsp_Genre('Pop', 'Pop', 'd000ff');
		$genre1 = new wpsp_Genre('Rock', 'Rock', 'fc5858');
		$genre1 = new wpsp_Genre('Metal', 'Metal', '8e4d36');
	}
	
	/*
	*		Run during the deactivation of the plugin
	*/
	function deactivate() {
		global $wpdb;

		// drop table for show categories
		$uninstall_wpsp_categories_sql =  "DROP TABLE `{$wpdb->prefix}".wpsp_Genre::$table_name."`;";
		$wpdb->query($uninstall_wpsp_categories_sql);
		
		// drop table for show sheduling
		$uninstall_wpsp_scheduling_sql =  "DROP TABLE `{$wpdb->prefix}".wpsp_Scheduling::$table_name."` (";
		$wpdb->query($uninstall_wpsp_scheduling_sql);
	}
	
	/*
	*		Run during the normal initialization of Wordpress
	*/
	function initialize() {
	
	}
	
	/*
	*		Run during the admin initialization of Wordpress
	*/
	function admin_initialize() {
	
	}

	/*
	*		Run during administration menu creation of Wordpress
	*/
	function admin_menu() {
	
	}

}

// Initalize the plugin
$WPSPlugin = new WPSPlugin();

// Add an (de-)activation hook
register_activation_hook(__FILE__, array(&$WPSPlugin, 'activate'));
register_deactivation_hook(__FILE__, array(&$WPSPlugin, 'deactivate'));

// Run the plugins initialization method
add_action('init', array(&$WPSPlugin, 'initialize'));

// Run the plugins administration initialization method
add_action('admin_init', array(&$WPSPlugin, 'admin_initialize'));

// Run the plugins administration menu creation
add_action('admin_menu', array(&$WPSPlugin, 'admin_menu'));
?>