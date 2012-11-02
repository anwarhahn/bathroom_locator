<!DOCTYPE html>
<html>	
	<head>
		<?php
			require("header.php");
		?>

		<title id="title"></title>
		<script type="text/javascript">
			var params = get_params();
			$("#title").innerHTML = "Flush | " + params.name;
		</script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header">
				<h1>[Bathroom Name]</h1>
			</div>

		<div data-role="content">
			<p>[Bathroom Address]</p>
			<p>[Bathroom Amenities]</p>
		
			<script type="text/javascript">
				var params = get_params();
				document.write("<a href='" + params.origin + ".php'>Back</a>");
			</script>


		<a href="help.php">Help</a> <br />
		<a href="map.php">Show on Map</a> <br />
	</body>
</html>