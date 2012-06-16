<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */

function plugin_activate_db_1_0_0() {
    global $wpdb;

	// create table for show information
	$install_wpsp_show_sql =  "CREATE TABLE `{$wpdb->prefix}wpsp_show` (";
	$install_wpsp_show_sql .= "  `id` INT(20) NOT NULL AUTO_INCREMENT,";
	$install_wpsp_show_sql .= "  `show_id` INT(20) NOT NULL,";
	$install_wpsp_show_sql .= "  `category_id` INT(20),";
	$install_wpsp_show_sql .= "  `moderator` varchar(255),";
	$install_wpsp_show_sql .= "  `moderator_id` INT(20),";
	$install_wpsp_show_sql .= "  PRIMARY KEY (`id`)) ENGINE = MyISAM;";
	$wpdb->query($install_wpsp_show_sql);

	// create table for show shedule information
	$install_wpsp_show_sql =  "CREATE TABLE `{$wpdb->prefix}wpsp_shedule` (";
	$install_wpsp_show_sql .= "  `id` INT(20) NOT NULL AUTO_INCREMENT,";
	$install_wpsp_show_sql .= "  `show_id` INT(20) NOT NULL,";
	$install_wpsp_show_sql .= "  `starttime` time,";
	$install_wpsp_show_sql .= "  `endtime` time,";
	$install_wpsp_show_sql .= "  `startdate` date,";
	$install_wpsp_show_sql .= "  `repeat` boolean,";
	$install_wpsp_show_sql .= "  `repeatpattern` varchar(60),";
	$install_wpsp_show_sql .= "  PRIMARY KEY (`id`)) ENGINE = MyISAM;";
	$wpdb->query($install_wpsp_show_sql);
	
	// create table for show categories and
	// add some standard options for categories and others
	$install_wpsp_show_sql =  "CREATE TABLE `{$wpdb->prefix}wpsp_categories` (";
	$install_wpsp_show_sql .= "  `id` INT(20) NOT NULL AUTO_INCREMENT,";
	$install_wpsp_show_sql .= "  `category` varchar(255),";
	$install_wpsp_show_sql .= "  `description` text,";
	$install_wpsp_show_sql .= "  PRIMARY KEY (`id`)) ENGINE = MyISAM;";
	$wpdb->query($install_wpsp_show_sql);
	
}

?>