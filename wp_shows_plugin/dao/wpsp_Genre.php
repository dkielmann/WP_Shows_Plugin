<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */
class wpsp_Genre
{
    // property declaration
    public $ID;
    public $title;
    public $description;
    public $color;

	public function __construct() {
		$numargs = func_num_args();
		$attr = func_get_args ();
		if ($numargs == 1) {
			$this->set_from_DB($attr[0]);
		} else if ($numargs == 3) {
			$this->title = $attr[0];
			$this->description = $attr[1];
			$this->color = $attr[2];
			$this->save_to_DB();
		}
	}
	
	public function set_from_DB($genre_id) {
		global $wpdb;
		$resultArray = $wpdb->get_results("SELECT `id`, `title`, `description`, `color` FROM `{$wpdb->prefix}".wpsp_Genre::$table_name."` WHERE id = '$genre_id'", ARRAY_A);
		if (count($resultArray) > 0) {
			$result = $resultArray[0];
			$this->ID = $result['id'];
			$this->title = $result['title'];
			$this->description = $result['description'];
			$this->color = $result['color'];
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
	
	public static $table_name = "wpsp_categories";
}

?>
