<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */
function plugin_activate_db_1_0_0() {
    global $wpdb;
	
	// create table for show categories and
	// add some standard options for categories and others
	$install_wpsp_categories_sql =  "CREATE TABLE `{$wpdb->prefix}".wpsp_Genre::$table_name."` (";
	$install_wpsp_categories_sql .= "  `id` INT(20) NOT NULL AUTO_INCREMENT,";
	$install_wpsp_categories_sql .= "  `title` varchar(255),";
	$install_wpsp_categories_sql .= "  `description` text,";
	$install_wpsp_categories_sql .= "  `color` varchar(6),";
	$install_wpsp_categories_sql .= "  PRIMARY KEY (`id`)) ENGINE = MyISAM;";
	$wpdb->query($install_wpsp_categories_sql);
	
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