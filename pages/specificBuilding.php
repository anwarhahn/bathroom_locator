<!DOCTYPE html>
<html>	
	<head>
		<?php
			require("header.php");
		?>

		<title>Flush</title>
	</head>
	<body>
		<div data-role="page" class="building_home">
			<script type="text/javascript">
				var makeFooter = function() {
					var originParams = escape("?" + stringify_params(get_params()));
					var links = [
					{name:"Map", url:"map.php" + query_string(old_params(), {origin:"specificBuilding"}), icon:"custom"}, 
					{name:"List", url:"list.php" + query_string(old_params(), {origin:"specificBuilding"}), icon:"custom"},
					{name:"Filter", url:"filter.php" + query_string(old_params(), {origin:"specificBuilding"}), icon:"custom"}, 				
					{name:"Help", url:"help.php" + query_string({}, {origin:"specificBuilding", originParams:originParams}), icon:"custom"}];
					SetFooterLinks(".building_home", links);
				}

				$(document).delegate(".building_home", 'pagebeforecreate', function(event) {
					makeFooter();
				});

				$(document).delegate(".building_home", 'pageshow', function(event) {
        			disable_safari();
        			var params = get_params();
					$("#back_link").attr("href", params.origin + ".php" + query_string(old_params(), {origin:"specificBuilding"}));
					$("#show_link").attr("href", "map.php" + query_string({Building_Number:params.Building_Number}, {show:1}));

					var bathroomsList = $("#bathrooms_list");
					for(var bathroomIndex in building.bathrooms) {
						var bathroom = building.bathrooms[bathroomIndex];
						var location = "<p>"+"Floor: " + bathroom.Floor + ", Room: " + bathroom.Room_Number + "</p>";


						var male = "<p class='man_icon_building'></p>";
						var female = "<p class='woman_icon_building'></p>";
						var gender = "";
						if (bathroom.Gender == "MENS") {
							gender += male;
						}
						else if (bathroom.Gender == "WOMENS") {
							gender += female;
						}
						else if (bathroom.Gender == "UNISEX") {
							gender += male + female;
						}

						var handicap = "";
						if (bathroom.Handicap == "1") {
							handicap = "<p class='handicap_icon_building'></p>";
						}

						gender = "<p class='icons'>" + gender + "</p>";
						bathroomsList.append("<li>" + gender + handicap + location + "</li>");
					}
					bathroomsList.listview();
					bathroomsList.listview('refresh');

    				var address = building.Address;
    				if (address.length > 0) {
						$("#address_goes_here").html(address);
					}
					else {
						$("#address_goes_here").html("There is no address at this time.");
					}
					
    			});
			</script>

			<div data-role="header">
				<h2>Building</h2>
				<a id="back_link" data-rel="back" data-role="button" data-mini="true">Back</a>
				

				<?php
				include("../db/data.php");
				$db = new Data();
				$building = $db->find_building_by_id($_GET["Building_Number"]);
				$bathrooms = $db->find_bathrooms_by_building_id($_GET["Building_Number"]);
				$building["bathrooms"] = $bathrooms;
				$data = $db->all_json($building);
				?>
				<script type="text/javascript">
					var building = <?= $data; ?>;
				</script>
			</div>

			<div data-role="content">
				<div>
					<ul data-inset='true' data-role='listview'>
						<li data-role='list-divider'>Name</li>
						<li><div><?= $building['Building_Name'] ?></div></li>
					</ul>
				</div>

				<div>
					<ul data-inset='true' data-role='listview' id="address_list">
						<li data-role='list-divider'>Address</li>
						<li>
							<div id="address_goes_here"></div>
							<div>
								<a id='show_link' data-mini='true' data-inline='true' data-role='button' href='#' >Show on map</a>
							</div>
						</li>
					</ul>
				</div>
				<div>
					<ul id="bathrooms_list" data-inset='true' data-role='listview'>
						<li data-role='list-divider'>Bathrooms</li>
					</ul>
				</div>			
			</div>

			<?php
				require ("footer.php");
			?>
		</div>
	</body>
</html>