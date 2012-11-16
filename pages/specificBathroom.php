<!DOCTYPE html>
<html>	
	<head>
		<?php
			require("header.php");
		?>

		<title>Flush</title>
	</head>
	<body>
		<div data-role="page" class="bathroom_home">
			<script type="text/javascript">
				var makeFooter = function() {
					var originParams = escape("?" + stringify_params(get_params()));
					var links = [
					{name:"Map", url:"map.php" + query_string(old_params(), {origin:"specificBathroom"}), icon:"custom"}, 
					{name:"List", url:"list.php" + query_string(old_params(), {origin:"specificBathroom"}), icon:"custom"},
					{name:"Filter", url:"filter.php" + query_string(old_params(), {origin:"specificBathroom"}), icon:"custom"}, 				
					{name:"Help", url:"help.php" + query_string({}, {origin:"specificBathroom", originParams:originParams}), icon:"custom"}];
					SetFooterLinks(".bathroom_home", links);
				}

				$(document).delegate(".bathroom_home", 'pagebeforecreate', function(event) {
					makeFooter();
				});

				$(document).delegate(".bathroom_home", 'pageshow', function(event) {
        			disable_safari();
        			var params = get_params();
					$("#back_link").attr("href", params.origin + ".php" + query_string(old_params(), {origin:"specificBathroom"}));
					$("#show_link").attr("href", "map.php" + query_string({bathroom_id:params.bathroom_id}, {show:1}));

					var amenities = bathroom_amenities(bathroom);
					var amentitiesList = $("#amenities_list");
					for(var p in amenities) {
						amentitiesList.append("<li>" + p + "</li>");
					}
					amentitiesList.listview();
					amentitiesList.listview('refresh');

    				var address = human_readable_address(bathroom);
    				if (address.length > 0) {
						$("#address_goes_here").html(address);
					}
					else {
						$("#address_goes_here").html("There is no address at this time.");
					}
    			});
			</script>

			<div data-role="header">
				<h2>Bathroom</h2>
				<a id="back_link" data-rel="back" data-role="button" data-mini="true">Back</a>
				

				<?php
				include("../db/data.php");
				$db = new Data();
				$bathroom = $db->find_by_id($_GET["bathroom_id"]);
				$data = $db->all_json($bathroom);
				?>
				<script type="text/javascript">
					var bathroom = <?= $data; ?>;
				</script>
			</div>

			<div data-role="content">
				<div>
					<ul data-inset='true' data-role='listview'>
						<li data-role='list-divider'>Name</li>
						<li><div><?= $bathroom['name'] ?></div></li>
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
					<ul id="amenities_list" data-inset='true' data-role='listview'>
						<li data-role='list-divider'>Amenities</li>
					</ul>
				</div>			
			</div>

			<?php
				require ("footer.php");
			?>
		</div>
	</body>
</html>