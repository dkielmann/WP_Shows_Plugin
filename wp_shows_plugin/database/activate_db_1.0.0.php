<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */
function plugin_activate_db_1_0_0() {

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

?>