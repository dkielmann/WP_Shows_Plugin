<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */

function plugin_deactivate_db_1_0_0() {
    global $wpdb;

	// drop table for show information
	$uninstall_wpsp_show_sql =  "DROP TABLE `{$wpdb->prefix}wpsp_show`;";
	$wpdb->query($install_wpsp_show_sql);

	// drop table for show shedule information
	$uninstall_wpsp_show_sql =  "DROP TABLE `{$wpdb->prefix}wpsp_shedule`;";
	$wpdb->query($install_wpsp_show_sql);
	
	// drop table for show categories
	$uninstall_wpsp_show_sql =  "DROP TABLE `{$wpdb->prefix}wpsp_categories`;";
	$wpdb->query($install_wpsp_show_sql);
}

?>