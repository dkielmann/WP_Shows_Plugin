<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */

function plugin_deactivate_db_1_0_0() {
    global $wpdb;

	// drop table for show categories
	$uninstall_wpsp_categories_sql =  "DROP TABLE `{$wpdb->prefix}wpsp_categories`;";
	$wpdb->query($uninstall_wpsp_categories_sql);
}

?>