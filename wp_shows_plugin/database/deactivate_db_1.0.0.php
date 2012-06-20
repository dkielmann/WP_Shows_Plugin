<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */

function plugin_deactivate_db_1_0_0() {
    global $wpdb;

	// drop table for show categories
	$uninstall_wpsp_categories_sql =  "DROP TABLE `{$wpdb->prefix}".wpsp_Genre::$table_name."`;";
	$wpdb->query($uninstall_wpsp_categories_sql);
	
	// drop table for show sheduling
	$uninstall_wpsp_scheduling_sql =  "DROP TABLE `{$wpdb->prefix}".wpsp_Scheduling::$table_name."` (";
	$wpdb->query($uninstall_wpsp_scheduling_sql);

}

?>