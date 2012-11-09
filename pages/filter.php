<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | Filter</title>

		<?php
			require("header.php");
		?>
	
	</head>
	<body>

		<div data-role="page">

			<div data-role="header">
				<h1>Filter</h1>
				<a data-role="button" data-mini="true" data-inline="true" id="cancel_link">Cancel</a>
				<a href="help.php?origin=filter" data-role="button" data-mini="true" data-inline="true">Help</a>
			</div>
			<div data-role="content">
					


				<script type="text/javascript">
				var params = get_params();
				$("#cancel_link").attr("href", (function() {
					if (params.origin == 'list') {
						return "list.php";	
					}
					else return "map.php";
				})());

				</script>
				


			<form id="filter_form" action='map.php' method='get'>
				<div data-role="controlgroup" data-type="horizontal">
		    		<fieldset data-role="options">
				  		<input type="checkbox" name="Male" id="checkbox-1" class="custom" />
				   		<label for="checkbox-1">Male</label>
				   		<input type="checkbox" name="Female" id="checkbox-2" class="custom" />
				   		<label for="checkbox-2">Female</label>
				   		<input type="checkbox" name="Accessible" id="checkbox-3" class="custom" />
				   		<label for="checkbox-3">Accessible</label>
				   		<input type="checkbox" name="Changing" id="checkbox-4" class="custom" />
				   		<label for="checkbox-4">Changing Table</label>
		   			 </fieldset>
		   		</div>

		   		<button type="submit" data-theme="a">Submit</button>
		   	</form>

		   	<script type="text/javascript">
				var form = document.getElementById("filter_form");
				//form.action = params.origin + ".php";
			</script>
		   	</div>
	   	<?php
			require ("footer.php");
			?>

			<script type="text/javascript">
				var links = [{"name":"Help", "url":"help.php?origin=filter", "icon":"custom"}, 
							{"name":"List", "url":"filter.php?origin=filter", "icon":"custom"}, 
							{"name":"Map", "url":"map.php?origin=filter", "icon":"custom"}];
				SetFooterLinks(links);
			</script>

	   	</div>
</div>


	</body>
</html>