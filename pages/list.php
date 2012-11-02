<!DOCTYPE html>
<html>	
	<head>
		<?php
			require("header.php");
		?>
	</head>
	<body>
		<a href="filter.php?origin=list">Filter</a> <br />
		<a href="help.php?origin=list">Help</a> <br />
		<a href="map.php">Map</a> <br />
		<a href="specificBathroom.php?origin=list">Specific Bathroom 1</a> <br />
		<a href="specificBathroom.php?origin=list">Specific Bathroom 2</a> <br />
		<a href="specificBathroom.php?origin=list">Specific Bathroom 3</a> <br />
		<a href="specificBathroom.php?origin=list">Specific Bathroom 4</a> <br />
		<a href="specificBathroom.php?origin=list">Specific Bathroom 5</a> <br />

		<?php
		include("../db/data.php");
		$db = new Data();
		$filtered = $db->filter(array("name", "latitude", "longitude"));
		echo "<p>".$db->stringify($filtered)."</p>";
		$data = $db->all_json($filtered);
		?>

		<ul data-role="listview" id = "list">
	
		</ul>

		<script type='text/javascript'>
			var b = <?= $data; ?>;
			var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);
			var div = document.createElement("div");
			document.body.appendChild(div);
			for(var i in b) {
				var bathroom = b[i];
				var loc = new google.maps.LatLng(bathroom.latitude, bathroom.longitude);
				var dist = google.maps.geometry.spherical.computeDistanceBetween(stanfordLatLng, loc);
				var l = document.getElementById("list");
				div.appendChild(l);
				l.innerHTML =  "<li><a href='specificBathroom.php?origin=list'>" + bathroom.name + "</a></li> ";
			}
		</script>


	</body>
</html>