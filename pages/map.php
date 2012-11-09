<!DOCTYPE html>
<html>
	<head>
		<title>Flush | Map</title>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />		
		<?php
			require("header.php");
		?>
		<script src="../assets/javascript/markers.js"></script>
		<script src="../assets/javascript/bathroomService.js"></script>
		<?php
		include("../db/data.php");
		$db = new Data();
		$db->refresh_all();
		#$data = $db->all_json($db->filter(array("name", "bathroom_id", "latitude", "longitude")));
		$data = $db->all_json();
		?>

		<script type="text/javascript">
			function success(position) { 
				var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			  	var myOptions = {
			    	zoom: 15,
			    	center: latlng,
				    mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				createMap(myOptions, latlng);
			}
				
			function notsuccess() {
				var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);
				var mapOptions = {
					center: stanfordLatLng,
					zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				createMap(mapOptions, null);
			}

			function createMap(options, knownlocation) {
				var map = new google.maps.Map(document.getElementById("map_canvas"),
						options);

				var manager = new MarkerManager(map);
				var json = <?= $data; ?>;
				//console.log(json);
				var filterHash = filter_from_params();
				var params = get_params();

				for(var i in json) {
					var bathroom = json[i];
					if (!matches_filter_requirements(filterHash, bathroom)) 
						delete json[i];
					if (params.show == 1) {
						if (params.bathroom_id != bathroom.bathroom_id)
							delete json[i];
						else map.panTo(new google.maps.LatLng(bathroom.latitude, bathroom.longitude));
					} 
				}

				manager.addMarkersFromJSON(json);
				

				var service = new BathroomService(manager);
				if(knownlocation!=null){
					var marker = new google.maps.Marker({
			    	position: knownlocation, 
			      	map: map, 
			      	title:"You are here!",
			      	icon: "../assets/images/bathroom_pin_30x62.png"
			  	});
			}

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

				/*var input = document.getElementById('target');
				input.onchange = function(evt) {
					var request = {
						location: stanfordLatLng,
						query: input.value,
						radius: 1000
					}
					service.textSearch(request);
				}
				*/
			}

			function loadMap(){
				disable_safari();

				var header = $("#search-panel").height();
				var footer = $("#footerlist").height();
				//console.log(document.height + " " + header + " " + footer);
				//console.log(document.height - footer - header);
				$("#map_canvas").height(document.height - header - footer - 42);
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(success, notsuccess);
				} else {
					notsuccess();
				}
			}
			
		</script>
	</head>
	<body onload="loadMap()">
		<div data-role="page" data-title="Map">
			<div data-role="header" id="search-panel">
				<h2>Map</h2>
				<a data-role="button" data-mini="true" data-inline="true" href="map.php">Show all</a>
				<!--//OLD-LAYOUT//
				<div class="ui-grid-b">
					<div class="ui-block-a"><a id="list_link" href="list.php" data-inline="true" data-role="button">List</a></div>
					<div class="ui-block-b"><input data-mini="true" id="target" type="search" placeholder="Search Box" autocomplete="off"></div>
					<div class="ui-block-c"><a id="filter_link" href="filter.php?origin=map" data-inline="true" data-role="button">Filter</a></div>
					
					<script type="text/javascript">
					var filterLink = document.getElementById("filter_link");
					var listLink = document.getElementById("list_link");
					filterLink.href = "filter.php" + query_string(old_params(), {origin:"map"});
					listLink.href = "list.php" + query_string(old_params(), {});
					</script>
				</div>
				//OLD-LAYOUT//-->
			</div>

			<div data-role="content" id="map_canvas"></div>

			<?php
				require ("footer.php");
			?>
			<script type="text/javascript">
				var links = [
				{name:"List", url:"list.php" + query_string(old_params(), {}), icon:"custom"},
				{name:"Filter", url:"filter.php" + query_string(old_params(), {origin:"map"}), icon:"custom"}, 				
				{name:"Help", url:"help.php" + query_string(old_params(), {origin:"map"}), icon:"custom"}];
				SetFooterLinks(links);
			</script>

			<!--//OLD-LAYOUT//
			<a id="help_link" href="help.php?origin=map">Help</a> 
			<script type="text/javascript">
				$("#help_link").attr("href", "help.php" + query_string(old_params(), {origin:"map"}));
			</script>
			//OLD-LAYOUT//-->
		</div>
	</body>
</html>
