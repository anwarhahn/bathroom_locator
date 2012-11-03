<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | List</title>
		<?php
			require("header.php");
			include("../db/data.php");
			$db = new Data();
			$filtered = $db->filter(array("name", "latitude", "longitude"));
			$data = $db->all_json($filtered);
		?>

	</head>
	<body>
		<script type='text/javascript'>
			var b = <?= $data; ?>;
			var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);
			var list = [];	
			for(var i in b) {
				var bathroom = b[i];
				var loc = new google.maps.LatLng(bathroom.latitude, bathroom.longitude);
				var dist = google.maps.geometry.spherical.computeDistanceBetween(stanfordLatLng, loc);
				var li = document.createElement("li");
				var a = document.createElement("a");
				a.innerHTML = "<h3>" + bathroom.name + "</h3><p>Extra info</p>";
				li.appendChild(a);
				list.push(li);

				$(a).click((function(name) {
						return function() { window.location = "specificBathroom.php?origin=list&name=" + name; }
					})(escape(bathroom.name)));
			}
		
			$(document).bind('pageinit', function(event) {
				var ul = $("<ul>");
				$("#home").append(ul);
				$("#bathroom_list").append(list).listview();
			});			
		</script>


		<div data-role="page" id="home">
			<div data-role="header">
				
				<div class="ui-grid-a">
					<div class="ui-block-a">
						<a href="map.php" data-mini="true" data-inline="true" data-role="button">Map</a>
						Bathrooms
					</div>

					<div class="ui-block-b">
						<div data-role="controlgroup" data-type="horizontal">
							<a href="filter.php?origin=list" data-mini="true" data-inline="true" data-role="button">Filter</a>
							<a href="help.php?origin=list" data-mini="true" data-inline="true" data-role="button">Help</a>
						</div>
					</div>
				</div>
			</div>

			<div data-role="content">
				<ul  data-inset="true" data-split-icon="arrow-r" data-split-theme="a" id="bathroom_list">
					<li id="bathroom-divider" data-role="list-divider">Bathrooms</li>				
				</ul>
			</div>
		</div>
	</body>
</html>
