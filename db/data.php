<?php
require_once('../config/google_maps_config.php');
require("../config/config.php");

class Data {
	private $keys = array();
	private $array = array();
	private $table_name = "bathrooms";
	private $query_all = "select * from bathrooms";
	private $query = "select * from bathrooms";

	function __construct() {
		//do nothing
	}

	function refresh($sql_query) {
		$result = mysql_query(mysql_real_escape_string($sql_query));
		if ($result) {
			$myarray = new ArrayObject();
			while ($row = mysql_fetch_assoc($result)) {
				$myarray->append($row);
			}
			$this->keys = array_keys($myarray[0]);
			$this->array = $myarray;
		}
	}

	function refresh_all() {
		$this->refresh($this->query_all);
	}

	function all() {
		return $this->$array;
	}

	function all_json($arr) {
		if (!$arr) $arr = $this->array;
		return json_encode($arr);
	}

	function filter($properties) {
		$return = new ArrayObject();
		for($i = 0; $i < count($this->array); $i++) {
			$bathroom = $this->array[$i];
			$subset = new ArrayObject();
			for($j = 0; $j < count($properties); $j++) {
				$p = $properties[$j];
				$subset[$p] = $bathroom[$p];
			}
			$return->append($subset);
		}
		return $return;
	}

	function find_by_id($id) {
		$sql_query = "select * from bathrooms where bathroom_id={$id}";
		#echo gettype($sql_query);
		$this->refresh($sql_query);
		return $this->array[0];
	}
}
?>