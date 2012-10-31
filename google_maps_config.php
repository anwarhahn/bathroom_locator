<?php
	define("GOOGLE_MAPS_API_KEY", "AIzaSyAZV1coyNyq2VQa11gXX6-DnysPyh1HN6M");
	define("GOOGLE_MAPS_SENSOR", "false");
	define("GOOGLE_LIBRARIES", "places,geometry");

	$google_maps_src = "https://maps.googleapis.com/maps/api/js?key=".GOOGLE_MAPS_API_KEY."&libraries=".GOOGLE_LIBRARIES."&sensor=".GOOGLE_MAPS_SENSOR;

	echo "<script type='text/javascript' src='".$google_maps_src."'></script>";
?>