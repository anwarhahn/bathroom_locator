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
		<script type='text/javascript'>
			
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
					a.innerHTML = "<h3>" + bathroom.name + "</h3><p>"+bathroom.dist.toPrecision(4)+" meters</p>";
					li.appendChild(a);
					list.push(li);

					$(a).attr('href', (function(name) {
							return "specificBathroom.php" + query_string(old_params(), {origin:"list", bathroom_id:bathroom.bathroom_id});
						})(escape(bathroom.name)));
				}
				return list;
			}

			$(document).bind('pageinit', function(event) {
				if (navigator.geolocation) {
					var success = function(position) {
						latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
						var list = makeList(latLng);
						//console.log(list);
						var ul = $("<ul>");
						$("#home").append(ul);
						$("#bathroom_list").append(list).listview();
					}

					navigator.geolocation.getCurrentPosition(success, function() {});

				} else {
					var list = makeList(stanfordLatLng);
					//console.log(list);
					var ul = $("<ul>");
					$("#home").append(ul);
					$("#bathroom_list").append(list).listview();
				}
			});			

			
		</script>


		<div data-role="page" id="home">
			<div data-role="header">
				<h2>Bathrooms</h2>
				<!--//OLD-LAYOUT//
				<div class="ui-grid-a">
					<div class="ui-block-a">
						<a id="map_link" href="map.php" data-mini="true" data-inline="true" data-role="button">Map</a>
						Bathrooms
					</div>

					<div class="ui-block-b">
						<div data-role="controlgroup" data-type="horizontal">
							<a id="filter_link" href="filter.php?origin=list" data-mini="true" data-inline="true" data-role="button">Filter</a>
							<a id="help_link" href="help.php?origin=list" data-mini="true" data-inline="true" data-role="button">Help</a>
							<script type="text/javascript">
							$("#map_link").attr("href", "map.php" + query_string(old_params(), {origin:"list"}));
							var filterLink = document.getElementById("filter_link");
							var helpLink = document.getElementById("help_link");
							filterLink.href = "filter.php" + query_string(old_params(), {origin:"list"});
							//$("#help_link").attr("href", "help.php" + query_string({}, {origin:"list", originParams:originParams}));
							helpLink.href = "help.php" + query_string(old_params(), {origin:"list"});
							</script>

						</div>
					</div>
				</div>
				//OLD-LAYOUT//-->
			</div>

			<div data-role="content">
				<ul  data-inset="true" data-split-icon="arrow-r" data-split-theme="a" id="bathroom_list">
					<li id="bathroom-divider" data-role="list-divider">Bathrooms</li>				
				</ul>
			</div>

			<?php
				require ("footer.php");
			?>
			<script type="text/javascript">
				var links = [
				{name:"Map", url:"map.php" + query_string(old_params(), {origin:"list"}), icon:"custom"}, 
				{name:"Filter", url:"filter.php" + query_string(old_params(), {origin:"list"}), icon:"custom"},
				{name:"Help", url:"help.php" + query_string(old_params(), {origin:"list"}), icon:"custom"}];
				SetFooterLinks(links);
			</script>
		</div>
	</body>
</html>
