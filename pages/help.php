<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | Help</title>

		<?php
			require("header.php");
		?>

	</head>
	<body>
		<div data-role="page" class="help_home">
			<script type="text/javascript">

				var makeFooter = function() {
					var url = $(".help_home").data('url');
					//console.log(url);
					var originParams = get_params(url).originParams;
					//console.log(originParams);
					var query = unescape(originParams);
					//console.log(query);
					var links = [
					{name:"Map", url:"map.php" + query, icon:"custom"}, 
					{name:"List", url:"list.php" + query, icon:"custom"},
					{name:"Filter", url:"filter.php" + query, icon:"custom"}, 				
					{name:"Help", url:"#", icon:"custom"}];
					SetFooterLinks(".help_home", links);
				}

				$(document).delegate('.help_home', 'pagebeforecreate', function(event) {
					var params = get_params();
					makeFooter(unescape(params.originParams));
				});

				$(document).delegate('.help_home', 'pageshow', function(event) {
					disable_safari();
					
					$(".help_home #help_footer_link").addClass("ui-btn-active");
					var params = get_params();
					//console.log(params);
					if (params.originParams) {
						//console.log(params.originParams);
						params.originParams = unescape(params.originParams);
				
						$("#cancel_link").attr("href", params.origin + ".php" + params.originParams);
					}
					else {
						$("#cancel_link").attr("href", params.origin + ".php" + query_string(old_params(), {}));
					}
				});			
			</script>
			<div data-role="header">
				<h2>Help</h2>
				<a data-role="button" rel="external" data-mini="true" data-inline="true" id="cancel_link">Cancel</a>
			</div>

			<div data-role="content">
				<p>Welcome to <b>Flush</b>!  It's our goal to make it as easy as
					possible for you to find bathrooms, when and where you need them.</p>
				<h2>From the map view:</h2>
				<p>The map will automatically find your location and display the
					bathrooms nearby on the map.  Click on them for more information.
					Feel free to search for a new address or drag the map around.</p>
				<h2>From the list view:</h2>
				<p>The map will automatically find your location and display the
					bathrooms in a list, sorted by distance.  Click on them for more
					information.  Feel free to search for a new address as well.</p>
				<h2>Filtering:</h2>
				<p>You can filter your search by narrowing everything down baseed on
					the amenities they offer.  Click on the corresponding image to
					select it.  You can select as many as you want!</p>
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
		</div>		
	</body>
</html>