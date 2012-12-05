<?php
require_once('../config/google_maps_config.php');
require("../config/config.php");

class Data {
	private $keys = array();
	private $array = array();
	private $table_name = "bathrooms";
	private $query_all = "select * from bathrooms";
	private $query = "select * from bathrooms";
	private $num_rows = 0;
	private $counts = array();

	function __construct() {
		//do nothing
	}

	function refresh($sql_query) {
		$result = mysql_query($sql_query);
		if ($result) {
			$this->num_rows = mysql_num_rows($result);
			$myarray = new ArrayObject();
			while ($row = mysql_fetch_assoc($result)) {
				$myarray->append($row);
			}
			if (count($myarray) > 0)
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

	function all_json($arr = array()) {
		if ($arr == array()) $arr = $this->array;
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
		$this->refresh($sql_query);
		return $this->array[0];
	}

	function table_size() {
		return $this->num_rows;
	}

	function count_features($name, $id) {
		$keyExists = array_key_exists($id, $this->counts);
		if ($keyExists) return $this->counts[$id];

		$handicap_query = "select count(*) from Bathrooms where Building_Number='{$id}' and Handicap='1'";
		$handicap_result = mysql_query($handicap_query);
		$handicap_count = 0;
		if ($handicap_result) {
			$handicap_count = intval(mysql_fetch_assoc($handicap_result)['count(*)']);
		}

		$male_query = "select count(*) from Bathrooms where Building_Number='{$id}' and (Gender='UNISEX' or Gender='MENS')";
		$male_result = mysql_query($male_query);
		$male_count = 0;
		if ($male_result) {
			$male_count = intval(mysql_fetch_assoc($male_result)['count(*)']);
		}


		$female_query = "select count(*) from Bathrooms where Building_Number='{$id}' and (Gender='UNISEX' or Gender='WOMENS')";
		$female_result = mysql_query($female_query);
		$female_count = 0;
		if ($female_result) {
			$female_count = intval(mysql_fetch_assoc($female_result)['count(*)']);
		}

		
		$specific_counts = array();
		$specific_counts["handicap"] = $handicap_count;
		$specific_counts["male"] = $male_count;
		$specific_counts["female"] = $female_count;
				
		$this->counts[$id] = $specific_counts;
		return $specific_counts;
	}

	function all_buildings_that_match($properties) {
		$sql_query = "select distinct Buildings.Building_Number, Buildings.Building_Name, Buildings.Address, Buildings.Latitude, Buildings.Longitude from Buildings";
		if (count($properties) > 0) {
			$add_on = ", Bathrooms where ";
			$constraints = array();
			$ismale = array_key_exists("male", $properties);
			$isfemale = array_key_exists("female", $properties);
			$ishandicap = array_key_exists("handicap", $properties);

			//echo var_dump($properties);

			if ($isfemale && $ismale) {
				// don't constrain gender
			}
			else {
				if ($isfemale && !$ismale) {
					$constraints[] = "(Bathrooms.Gender='WOMENS' or Bathrooms.Gender='UNISEX')";	
				}
				if (!$isfemale && $ismale) {
					$constraints[] = "(Bathrooms.Gender='MENS' or Bathrooms.Gender='UNISEX')";	
				}
			}
			if ($ishandicap) {
				$constraints[] = "(Bathrooms.Handicap='1')";
			}


			if (count($constraints) > 0) {
				$constraints[] = "(Buildings.Building_Number=Bathrooms.Building_Number)";
			}		
			
			if (count($constraints) > 0) {
				$sql_query .= $add_on.implode(" and ", $constraints);	
			}

		}

		//echo $sql_query;
		$this->refresh($sql_query);
		return $this->array;
	}

	function find_building_by_id($id) {
		$sql_query = "select * from Buildings building where building.Building_Number='{$id}'";
		$this->refresh($sql_query);
		return $this->array[0];
	}

	function find_bathrooms_by_building_id($id) {
		$sql_query = "select * from Bathrooms where Building_Number='{$id}' ".
			"order by Floor, Room_Number ";
		$this->refresh($sql_query);
		return $this->array;
	}

	function getFilter() {
		$filter = array();
		$urldecoded = "";
		foreach ($_GET as $key => $value) {
			if ($key == "form") {
				$form = urldecode($value);
				$form = str_replace("\\", "", $form);
				
				$filter = json_decode($form, true);
				break;
			}
		}
		return $filter;
	}
}
?>