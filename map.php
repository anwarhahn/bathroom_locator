<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />		
		<?php
			require("header.php");
		?>
		<script src="markers.js"></script>
		<script src="bathroomService.js"></script>
		<?php
		include("data.php");
		$db = new Data();
		$data = $db->all_json($db->filter(array("name", "latitude", "longitude")));
		?>

		<script type="text/javascript">
			function initialize() {
				var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);
				var mapOptions = {
					center: stanfordLatLng,
					zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById("map_canvas"),
						mapOptions);

				var manager = new MarkerManager(map);
				var json = <?= $data; ?>;
				manager.addMarkersFromJSON(json);
				

				var service = new BathroomService(manager);

				var input = document.getElementById('target');
				input.onchange = function(evt) {
					var request = {
						location: stanfordLatLng,
						query: input.value,
						radius: 1000
					}
					service.textSearch(request);
				}
			}
		</script>
	</head>
	<body onload="initialize()">

		<div id="search-panel">
			<a href="filter.php"><button type="button">Filter</button></a>
			<input id="target" type="text" placeholder="Search Box" autocomplete="off">
			<a href="list.php"><button type="button">List</button></a>
		</div>

		<div id="map_canvas"></div>
		<?php
			require("footer.php");
		?>
	</body>
</html>
