<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | Help</title>

		<?php
			require("header.php");
		?>

	</head>
	<body>
		<div data-role="page" id="home">
			<script type="text/javascript">
				$('#home').live('pageinit', function(event) {
					var params = get_params();
					if (params.escaped) {
						params.origin = unescape(params.origin);
						$("#cancel_link").attr("href", params.origin);
					}
					else {
						$("#cancel_link").attr("href", params.origin + ".php");
					}
				});			
			</script>
			<div data-role="header">
				<h1>Help</h1>
				<a data-role="button" data-mini="true" data-inline="true" id="cancel_link">Cancel</a>
			</div>

			<div data-role="content">
				<p>Welcome to [NAME OF APP HERE]!  It's our goal to make it as easy as possible for you to find bathrooms, when and where you need them.</p>
				<h2>From the map view:</h2>
				<p>The map will automatically find your location and display the bathrooms nearby on the map.  Click on them for more information.  Feel free to search for a new address or drag the map around.</p>
				<h2>From the list view:</h2>
				<p>The map will automatically find your location and display the bathrooms in a list, sorted by distance.  Click on them for more information.  Feel free to search for a new address as well.</p>
				<h2>Filtering:</h2>
				<p>You can filter your search by narrowing everything down baseed on the amenities they offer.  Click on the corresponding image to select it.  You can select as many as you want!</p>
				<table>
					<tr>
						<td>[add icon here]</td>
						<td>Male</td>
					</tr>
					<tr>
						<td>[add icon here]</td>
						<td>Female</td>
					</tr>
					<tr>
						<td>[add icon here]</td>
						<td>Handicap Accessible</td>
					</tr>
					<tr>
						<td>[add icon here]</td>
						<td>Changing Table</td>
					</tr>
				</table>
			</div>
			<?php
			require ("footer.php");
			?>
			<script type="text/javascript">
				var links = [{"name":"Help", "url":"help.php", "icon":"custom"}, 
							{"name":"Filter", "url":"filter.php", "icon":"custom"}, 
							{"name":"Map", "url":"map.php", "icon":"custom"}];
				SetFooterLinks(links);
			</script>
		</div>		
	</body>
</html>