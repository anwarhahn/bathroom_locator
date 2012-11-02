<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | List</title>
		<?php
			require("header.php");
		?>

	</head>
	<body>
		<a data-role="button" id="filter_link">Filter</a> <br />
		<a data-role="button" id="help_link">Help</a> <br />
		<a data-role="button" id="map_link">Map</a> <br />


		<script type="text/javascript">
		$("#filter_link").click(function() {
			window.location = "filter.php?origin=list";
		});
		$("#help_link").click(function() {
			window.location = "help.php?origin=list";
		});
		$("#map_link").click(function() {
			window.location = "map.php";
		});

		</script>

		<?php
		include("../db/data.php");
		$db = new Data();
		$filtered = $db->filter(array("name", "latitude", "longitude"));
//		echo "<p>".$db->stringify($filtered)."</p>";
		$data = $db->all_json($filtered);
		?>

		<ul data-role="listview" id="list">
	
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
				var li = document.createElement("li");
				var a = document.createElement("a");
				a.innerHTML = bathroom.name;
				var id = bathroom.name.replace(/ /g, "_");
				a.id = id
				li.appendChild(a);
				l.appendChild(li);

				$("#"+id).click(function() {
					window.location = "specificBathroom.php?origin=list&name=" + bathroom.name;
				});
			}
		</script>


	</body>
</html>