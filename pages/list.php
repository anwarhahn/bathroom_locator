<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | List</title>
		<?php
			require("header.php");
			include("../db/data.php");
			$db = new Data();
			$filter = $db->getFilter();
			$buildings = $db->all_buildings_that_match($filter);
			$data = $db->all_json($buildings);
		?>

	</head>
	<body>
		<div data-role="page" class="list_home">
			<script type="text/javascript">
				var updateList = function(position) {
					var pos = {
						lat: undefined,
						lng: undefined
					}
					if (!position.coords) {
						pos.lat = position.lat();
						pos.lng = position.lng();
					}
					else {
						pos.lat = position.coords.latitude;
						pos.lng = position.coords.longitude;
					}
					var latLng = new google.maps.LatLng(pos.lat, pos.lng);
					return makeList(latLng);
				}

				var loadPage = function() {
				    var callback = function(position) {
				    	var pos = (typeof position == 'undefined') ? stanfordLatLng : position;
	    				var list = updateList(pos);
						var building_list = showList(list);
						building_list.listview();
					}

					if (navigator.geolocation) navigator.geolocation.getCurrentPosition(callback, callback);
					else callback(stanfordLatLng);
				}
				$(document).delegate(".list_home", 'pagebeforeshow', function(event) {});
				$(document).delegate(".list_home", 'pageshow', function(event) {
		    		disable_safari();
		    		$(".list_home #list_footer_link").addClass("ui-btn-active");
				});			

			
				var makeFooter = function() {
					var originParams = escape("?" + stringify_params(get_params()));
					var links = [
					{name:"Map", url:"map.php" + query_string(old_params(), {origin:"list"}), icon:"custom"}, 
					{name:"List", url:"#", icon:"custom"}, 
					{name:"Filter", url:"filter.php" + query_string(old_params(), {origin:"list"}), icon:"custom"},
					{name:"Help", url:"help.php" + query_string(old_params(), {origin:"list", originParams:originParams}), icon:"custom"}];
					SetFooterLinks(".list_home", links);
				}

				$(document).delegate(".list_home", 'pagebeforecreate', function(event) {
					makeFooter();
					loadPage();
				});
				
				// default to stanford center
				var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);
				
				var makeList = function(position) {
					var list = [];	
					var building_data = <?= $data; ?>;
					
					var bList = [];
					var filterHash = filter_from_params();
					for(var i in building_data) {
						var building = building_data[i];
						var loc = new google.maps.LatLng(building.Latitude, building.Longitude);
						building.dist = google.maps.geometry.spherical.computeDistanceBetween(position, loc);
						bList.push(building);
					}
					bList.sort(function(a, b) { return (a.dist - b.dist); });

					for(var i = 0; i < bList.length; i++) {
						var building = bList[i];
						var li = document.createElement("li");
						var a = document.createElement("a");
						a.innerHTML = "<h3>" + (i+1) + ". " +building.Building_Name + "</h3><p>"+building.dist.toPrecision(4)+" meters away</p>";
						a.setAttribute('rel', 'external');
						li.appendChild(a);
						list.push(li);

						$(a).attr('href', (function(name) {
							return "specificBuilding.php" + query_string(old_params(), {origin:"list", Building_Number:building.Building_Number});
						})(escape(building.name)));
					}
					return list;
				}

				var showList = function(list) {
					$("#list_info").html("Showing "+list.length+" of <?= $db->table_size() ?>");
					if (list.length == 0) {
						var li = document.createElement("li");
						li.innerHTML = "No buildings match that criteria.";
						list.push(li);
					}
					var building_list = $("#building_list");
					building_list.html('');
					building_list.append("<li id='building-divider' data-role='list-divider'>buildings</li>");
					building_list.append(list);
					return building_list;
				}
			</script>

			<div data-role="header">
				<h2>Buildings</h2>
				<a data-role="button" data-mini="true" data-theme="b" rel="external" href="list.php">Show all</a>
			</div>


			<div data-role="content">
				<div id="list_info"></div>
				<ul  data-inset="true" data-split-icon="arrow-r" data-split-theme="a" id="building_list">
									
				</ul>
			</div>

			<?php
				require ("footer.php");
			?>
		</div>
		<script type="text/javascript">
			$("#home").bind('pageinit', function(event) {
	    		disable_safari();

    			var success = function(position, googleMaps) {
    				var latLng = null;
    				if (googleMaps) latLng = new google.maps.LatLng(position.lat(), position.lng());
    				else latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					var list = makeList(latLng);
					showList(list);
				}

				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(success, function() { success(stanfordLatLng, true); });
				} else {
					success(stanfordLatLng);
				}
			});			
		</script>
	</body>
</html>
