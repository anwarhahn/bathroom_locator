<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style type="text/css">
			html { height: 100% }
			body { height: 100%; margin: 0; padding: 0 }
			#map_canvas { height: 100% }
		</style>
		<script type="text/javascript"
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZV1coyNyq2VQa11gXX6-DnysPyh1HN6M&libraries=places&sensor=false">
		</script>
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

			function createMap(options, knownlocation){
				var map = new google.maps.Map(document.getElementById("map_canvas"),
						options);

				var service = new google.maps.places.PlacesService(map);
				var markers = [];

				if(knownlocation!=null){
					var marker = new google.maps.Marker({
			    	position: knownlocation, 
			      	map: map, 
			      	title:"You are here!"
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

			function loadMap(){
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(success, notsuccess);
				} else {
					notsuccess();
				}
			}
			
		</script>
	</head>
	<body onload="loadMap()">
		<div id="search-panel">
			<a href="filter.php"><button type="button">Filter</button></a>
			<input id="target" type="text" placeholder="Search Box" autocomplete="off">
			<a href="list.php"><button type="button">List</button></a>
			
		</div>
		<div id="map_canvas" style="width:100%; height:95%"></div>
		<div style="position:absolute; top:95%; height:5%; width:100%; background-color:white; text-align:right; padding:0px 0px 20px 0px">
			<a href="specificBathroom.php">Specific Bathroom</a>
			<a style="margin:0px 20px 0px 0px;" href="help.php">Help</a>
		</div>
	</body>
</html>
