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
		<div data-role="page">
			<div data-role="header">
				<h1 id="h1_title"></h1>
				<?php
				include("../db/data.php");
				$db = new Data();
				$bathroom = $db->find_by_id($_GET["bathroom_id"]);
				$data = $db->all_json($bathroom);
				?>
				<script type="text/javascript">
					var bathroom = <?= $data; ?>;
					console.log(bathroom);
					$("#h1_title").html(bathroom.name);
				</script>
			</div>

		<div data-role="content">
			<p>
				<script type="text/javascript">
				var address = bathroom.address.split(",");
				//console.log(address);
				var len = address.length;
				address[len-2] = address[len-2] + address[len-1];
				address.splice(len-1,1);
				address = address.join("<br />");
				
				//console.log(address);
			
				document.write(address);
				</script>
			</p>
			<p>[Bathroom Amenities]</p>
		
			<script type="text/javascript">
				var params = get_params();
				document.write("<a href='" + params.origin + ".php'>Back</a>");
			</script>


		<a id="help_link" href="help.php?origin=specificBathroom">Help</a>
		<script type="text/javascript">
		var origin = escape("specificBathroom.php?origin="+params.origin+"&name="+params.name);
		var returnURL = "help.php?escaped=1&origin="+origin;
		$("#help_link").attr("href", returnURL);
		</script>
		<a href="map.php?show=<?= $bathroom['bathroom_id'] ?>">Show on Map</a>
	</body>
</html>