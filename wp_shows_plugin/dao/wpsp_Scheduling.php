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
			$update_genre_sql =  "UPDATE `{$wpdb->prefix}".wpsp_Genre::$table_name."` SET `title` = '".$this->title."', `description` = '".$this->description."', `color` = '".$this->color."' WHERE `id` = '".$this->ID-"';";
			$wpdb->query($update_genre_sql);
		} else {
			$newid = $wpdb->get_var("SELECT MAX(id) FROM `{$wpdb->prefix}".wpsp_Genre::$table_name."`;") + 1;
			$this->ID = $newid;
			$insert_genre_sql =  "INSERT INTO `{$wpdb->prefix}".wpsp_Genre::$table_name."` VALUES ('".$this->ID."', '".$this->title."', '".$this->description."', '".$this->color."');";
			$wpdb->query($insert_genre_sql);
		}
	}
	
	public static function getAll() {
		global $wpdb;
		$returnArray = array();
		$resultArray = $wpdb->get_results("SELECT `id`, `title`, `description`, `color` FROM `{$wpdb->prefix}".wpsp_Genre::$table_name."`;", ARRAY_A);
		foreach ($resultArray as $result) {
			$newGenre = new wpsp_Genre();
			$newGenre->ID = $result['id'];
			$newGenre->title = $result['title'];
			$newGenre->description = $result['description'];
			$newGenre->color = $result['color'];
			$returnArray[$newGenre->ID] = $newGenre;
		}
		
		return $returnArray;
	}
	
	public static $table_name = "wpsp_scheduling";
}

?>
