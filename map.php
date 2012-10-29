<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="styles.css">
		
		<?php
			require("google_maps_config.php");
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

				var service = new google.maps.places.PlacesService(map);
				var markers = [];

				function callback(places, status) {
					if(status == google.maps.places.PlacesServiceStatus.OK) {
						for (var i = 0; i < places.length; i++) {
							var place = places[i];
							var marker = new google.maps.Marker({
						  		map: map,
						  		title: place.name,
						  		position: place.geometry.location,
						  		visible: true
							});
							markers.push(marker);
						}
					}
				}

				function query(value) {
					var request = {
						location: stanfordLatLng,
						query: value,
						radius: 1000
					}
					for (var i = markers.length - 1; i >= 0; i--) {
						var marker = markers[i];
						marker.setMap(null);
						markers.splice(i,i);
					}
					service.textSearch(request, callback);
				};

				var input = document.getElementById('target');
				input.onchange = function(evt) {
					query(input.value);
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
