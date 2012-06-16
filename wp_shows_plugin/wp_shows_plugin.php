<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */
 
/*
Plugin Name: WP_Show_Plugin (wpsp)
Plugin URI: https://github.com/dkielmann/WP_Shows_Plugin/wiki
Description: A plugin for administration and sheduling of show plans for online radio stations
Author: Daniel Kielmann
Version: 0.1.0
Author URI: http://www.autoscout24.de
*/

// register functions for activation and deactivation of plugin
register_activation_hook(__FILE__, 'sendeplan_activation');
register_deactivation_hook(__FILE__, 'sendeplan_deactivation');

// set some basic path variables
$wpsp_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$wpsp_path_lang = dirname( plugin_basename( __FILE__ ) ) ."/";

// include the database activation and deactivation steps
include "database/activate_db_1.0.0.php";
include "database/deactivate_db_1.0.0.php";

function sendeplan_activation() {
	plugin_activate_db_1_0_0(); // to find under plugin database activation scripts
}


function sendeplan_deactivation() {
	plugin_deactivate_db_1_0_0(); // to find under plugin database deactivation scripts
}

?>