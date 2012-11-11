<!DOCTYPE html>
<html>	
	<head>
		<?php
			require("header.php");
		?>

		<title id="title"></title>
		<script type="text/javascript">
			var params = get_params();
			params.name = unescape(params.name);
			$("#title").html("Flush | " + params.name);
		</script>
	</head>
	<body>
		<div data-role="page" id="home">
			<div data-role="header">
				<h2 id="h1_title"></h2>
				<a id="back_link" data-role="button" data-mini="true" data-inline="true">Back</a>
				<a id="help_link" data-role="button" data-mini="true" data-inline="true">Help</a>

				<?php
				include("../db/data.php");
				$db = new Data();
				$bathroom = $db->find_by_id($_GET["bathroom_id"]);
				$data = $db->all_json($bathroom);
				?>
				<script type="text/javascript">
					var bathroom = <?= $data; ?>;
					//console.log(bathroom);
					$("#h1_title").html(bathroom.name);
				</script>
			</div>

		<div data-role="content">
			

			<div>
				<ul data-inset='true' data-role='listview' id="address_list">
					<li data-role='list-divider'>Address</li>
					<script type="text/javascript">
					var address = human_readable_address(bathroom);
					//console.log(address);
					var link = "<a id='show_link' data-mini='true' data-inline='true' data-role='button' href='#' >Show on map</a>";
					$("#address_list").append("<li><span>"+address+"</span><span>"+ link +"</span></li>");
					</script>
				</ul>
			</div>
			<div>
				<script type="text/javascript">
				var amenities = bathroom_amenities(bathroom);
				//console.log(amenities);
				document.write("<ul data-inset='true' data-role='listview'>");
				document.write("<li data-role='list-divider'>Amenities</li>")
				for(var p in amenities) {
					//console.log(p);
					document.write("<li>" + p + "</li>");
				}
				document.write("</ul>");
				</script>
			</div>
		
			<script type="text/javascript">
				var params = get_params();
				$("#back_link").attr("href", params.origin + ".php" + query_string(old_params(), {origin:"specificBathroom"}));
				
				var originParams = escape("?" + stringify_params(params));
				$("#help_link").attr("href", "help.php" + query_string({}, {origin:"specificBathroom", originParams:originParams}));

				$("#show_link").attr("href", "map.php" + query_string({bathroom_id:params.bathroom_id}, {show:1}));

				$("#home").live('pageinit',function() {
        			disable_safari();
    			});

			</script>
	</body>
</html>