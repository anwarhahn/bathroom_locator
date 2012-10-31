<?php
require_once('google_maps_config.php');
require("config.php");
class Data {
	private $keys = array();
	private $array = array();
	private $query = "select * from bathrooms";

	function __construct() {
		$this->refresh();
	}

	function refresh() {
		$result = mysql_query($this->query);
		$myarray = new ArrayObject();
		while ($row = mysql_fetch_assoc($result)) {
			$myarray->append($row);
		}
		$this->keys = array_keys($myarray[0]);
		$this->array = $myarray;
	}

	function all() {
		return $this->$array;
	}

	function all_json($arr) {
		if (!$arr) $arr = $this->array;
		return json_encode($arr);
	}

	function stringify($arr) {
		$output = "";
		for($i = 0; $i < count($arr); $i++) {
			$a = (array) $arr[$i];
			$elem = "{".implode(", ", $a)."} ";
			$output = $output.$elem;
		}
		return $output;
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
}
?>