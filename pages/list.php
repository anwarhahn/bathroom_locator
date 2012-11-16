<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | List</title>
		<?php
			require("header.php");
			include("../db/data.php");
			$db = new Data();
			$db->refresh_all();
			#$filtered = $db->filter(array("name", "latitude", "longitude"));
			#$data = $db->all_json($filtered);
			$data = $db->all_json();
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
						var bathroom_list = showList(list);
						bathroom_list.listview();
					}

					if (navigator.geolocation) navigator.geolocation.getCurrentPosition(callback, callback);
					else callback(stanfordLatLng);
				}
				$(document).delegate(".list_home", 'pagebeforeshow', function(event) {
					//$("#bathroom_list");
				});
				$(document).delegate(".list_home", 'pageshow', function(event) {
		    		disable_safari();
		    		//loadPage();
		    		//$("#bathroom_list").listview();
		    		//$("#bathroom_list").listview('refresh');
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
					var bathroom_data = <?= $data; ?>;
					var bList = [];
					var filterHash = filter_from_params();
					for(var i in bathroom_data) {
						var bathroom = bathroom_data[i];
						//console.log(bathroom);
						if (!matches_filter_requirements(filterHash, bathroom)) continue;
						var loc = new google.maps.LatLng(bathroom.latitude, bathroom.longitude);
						bathroom.dist = google.maps.geometry.spherical.computeDistanceBetween(position, loc);
						bList.push(bathroom);
					}
					bList.sort(function(a, b) { return (a.dist - b.dist); });

					for(var i = 0; i < bList.length; i++) {
						var bathroom = bList[i];
						var li = document.createElement("li");
						var a = document.createElement("a");
						a.innerHTML = "<h3>" + (i+1) + ". " +bathroom.name + "</h3><p>"+bathroom.dist.toPrecision(4)+" meters away</p>";
						a.setAttribute('rel', 'external');
						li.appendChild(a);
						list.push(li);

						$(a).attr('href', (function(name) {
							return "specificBathroom.php" + query_string(old_params(), {origin:"list", bathroom_id:bathroom.bathroom_id});
						})(escape(bathroom.name)));
					}
					return list;
				}

				var showList = function(list) {
					$("#list_info").html("Showing "+list.length+" of <?= $db->table_size() ?>");
					if (list.length == 0) {
						var li = document.createElement("li");
						li.innerHTML = "No bathrooms match that criteria.";
						list.push(li);
					}
					var bathroom_list = $("#bathroom_list");
					bathroom_list.html('');
					bathroom_list.append("<li id='bathroom-divider' data-role='list-divider'>Bathrooms</li>");
					bathroom_list.append(list);
					return bathroom_list;
				}
			</script>

			<div data-role="header">
				<h2>Bathrooms</h2>
				<a data-role="button" data-mini="true" data-theme="b" rel="external" href="list.php">Show all</a>
			</div>


			<div data-role="content">
				<div id="list_info"></div>
				<ul  data-inset="true" data-split-icon="arrow-r" data-split-theme="a" id="bathroom_list">
									
				</ul>
			</div>

			<?php
				require ("footer.php");
			?>
		</div>
	</body>
</html>
