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
				<script type="text/javascript">
					$("#h1_title").html(params.name);
				</script>
			</div>

			<div data-role="content">
				<p>[Bathroom Address]</p>
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
				<a href="map.php?show=">Show on Map</a>

			</div>
			<?php
			require ("footer.php");
			?>
			<script type="text/javascript">
				var links = [{"name":"Help", "url":"help.php?origin=specificBathroom", "icon":"custom"}, 
							{"name":"Filter", "url":"filter.php?origin=specificBathroom", "icon":"custom"}, 
							{"name":"Map", "url":"map.php", "icon":"custom"}];
				SetFooterLinks(links);
			</script>
	</body>
</html>