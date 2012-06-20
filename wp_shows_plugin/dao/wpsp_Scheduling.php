<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */
class wpsp_Scheduling
{
    // property declaration
    public $ID;
	public $showID;
	public $ts_start;
	public $ts_duration;
	public $repeatit;
	public $repeatcount;
	public $repeatintervall;
	public $repeattimes;
	public $repeatuntil;
	
	public function __construct() {
		$numargs = func_num_args();
		$attr = func_get_args ();
		if ($numargs == 1) {
			$this->set_from_DB($attr[0]);
		} else if ($numargs == 8) {
			$this->showID = $attr[0];
			$this->ts_start = $attr[1];
			$this->ts_duration = $attr[2];
			$this->repeatit = $attr[3];
			$this->repeatcount = $attr[4];
			$this->repeatintervall = $attr[5];
			$this->repeattimes = $attr[6];
			$this->repeatuntil = $attr[7];
			$this->save_to_DB();
		}
	}
	
	public function set_from_DB($sched_id) {
		global $wpdb;
		$sqlSelect = "SELECT".
		               "`id`, ".
					   "`showID`, ".
					   "`ts_start`, ".
					   "`ts_duration`, ".
					   "`repeatit`, ".
					   "`repeatcount`, ".
					   "`repeatintervall`, ".
					   "`repeattimes` ".
					   "`repeatuntil` ".
					   "FROM `{$wpdb->prefix}".wpsp_Scheduling::$table_name."` WHERE id = '$sched_id'";
					   
		$resultArray = $wpdb->get_results($sqlSelect, ARRAY_A);
		if (count($resultArray) > 0) {
			$result = $resultArray[0];
			$this->ID = $result['id'];
			$this->showID = $result['showID'];
			$this->ts_start = $result['ts_start'];
			$this->ts_duration = $result['ts_duration'];
			$this->repeatit = $result['repeatit'];
			$this->repeatcount = $result['repeatcount'];
			$this->repeatintervall = $result['repeatintervall'];
			$this->repeattimes = $result['repeattimes'];
			$this->repeatuntil = $result['repeatuntil'];
			return true;
		} else {
			return false;
		}
	}
	
	public function save_to_DB() {
		global $wpdb;
		if ($this->ID) {
			$update_scheduling_sql =  "UPDATE `{$wpdb->prefix}".wpsp_Scheduling::$table_name."` SET ".
				"`showID` = '".$this->showID."', ".
				"`ts_start` = '".$this->ts_start."', ".
				"`ts_duration` = '".$this->ts_duration."', ".
				"`repeatit` = '".$this->repeatit."', ".
				"`repeatcount` = '".$this->repeatcount."', ".
				"`repeatintervall` = '".$this->repeatintervall."', ".
				"`repeattimes` = '".$this->repeattimes."', ".
				"`repeatuntil` = '".$this->repeatuntil."' ".
				"WHERE `id` = '".$this->ID-"';";
			$wpdb->query($update_scheduling_sql);
		} else {
			$newid = $wpdb->get_var("SELECT MAX(id) FROM `{$wpdb->prefix}".wpsp_Scheduling::$table_name."`;") + 1;
			$this->ID = $newid;
			$insert_scheduling_sql =  "INSERT INTO `{$wpdb->prefix}".wpsp_Scheduling::$table_name."` VALUES ('".
				$this->ID."', '".
				$this->showID."', '".
				$this->ts_start."', '".
				$this->ts_duration."', '".
				$this->repeatit."', '".
				$this->repeatcount."', '".
				$this->repeatintervall."', '".
				$this->repeattimes."', '".
				$this->repeatuntil."');";
			$wpdb->query($insert_scheduling_sql);
		}
	}
	
	public static function getAll() {
		global $wpdb;
		$returnArray = array();
		$resultArray = $wpdb->get_results("SELECT ".
			"`id`, ".
			"`showID`, ".
			"`ts_start`, ".
			"`ts_duration`, ".
			"`repeatit`, ".
			"`repeatcount`, ".
			"`repeatintervall`, ".
			"`repeattimes`, ".
			"`repeatuntil` ".
			"FROM `{$wpdb->prefix}".wpsp_Scheduling::$table_name."`;", ARRAY_A);
		foreach ($resultArray as $result) {
			$newSchedule = new wpsp_Scheduling();
			$newSchedule->ID = $result['id'];
			$newSchedule->showID = $result['showID'];
			$newSchedule->ts_start = $result['ts_start'];
			$newSchedule->ts_duration = $result['ts_duration'];
			$newSchedule->repeatit = $result['repeatit'];
			$newSchedule->repeatcount = $result['repeatcount'];
			$newSchedule->repeatintervall = $result['repeatintervall'];
			$newSchedule->repeattimes = $result['repeattimes'];
			$newSchedule->repeatuntil = $result['repeatuntil'];
			$returnArray[$newSchedule->ID] = $newSchedule;
		}
		
		return $returnArray;
	}
	
	public static function getAllForShow( $showID ) {
		global $wpdb;
		$returnArray = array();
		$resultArray = $wpdb->get_results("SELECT ".
			"`id`, ".
			"`showID`, ".
			"`ts_start`, ".
			"`ts_duration`, ".
			"`repeatit`, ".
			"`repeatcount`, ".
			"`repeatintervall`, ".
			"`repeattimes`, ".
			"`repeatuntil` ".
			"FROM `{$wpdb->prefix}".wpsp_Scheduling::$table_name."`".
			"WHERE `showID` = $showID;", ARRAY_A);
		foreach ($resultArray as $result) {
			$newSchedule = new wpsp_Scheduling();
			$newSchedule->ID = $result['id'];
			$newSchedule->showID = $result['showID'];
			$newSchedule->ts_start = $result['ts_start'];
			$newSchedule->ts_duration = $result['ts_duration'];
			$newSchedule->repeatit = $result['repeatit'];
			$newSchedule->repeatcount = $result['repeatcount'];
			$newSchedule->repeatintervall = $result['repeatintervall'];
			$newSchedule->repeattimes = $result['repeattimes'];
			$newSchedule->repeatuntil = $result['repeatuntil'];
			$returnArray[$newSchedule->ID] = $newSchedule;
		}
		
		return $returnArray;
	}
	
	public static $table_name = "wpsp_scheduling";
}

?>
