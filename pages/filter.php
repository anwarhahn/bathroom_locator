<!DOCTYPE html>
<html>	
	<head>
		<title>Filter</title>

		<?php
			require("header.php");
		?>
	
	</head>
	<body>

		<div data-role="page">

			<div data-role="header">
				<h1>Filter</h1>
			</div>
			<div data-role="content">
				<script type="text/javascript">
					var params = get_params();
					if (params.origin == 'map') {
						document.write("<a href='map.php'>Cancel</a>");
					}
					else if (params.origin == 'list') {
						document.write("<a href='list.php'>Cancel</a>");
					}
				</script>
				 <br />
				<p> The cancel that we use will depend on the page that was prior to this one. </p>
				<a href="help.php">Help</a> <br />
				<a href="map.php">Search(map)</a> <br />
				<a href="list.php">Search(list)</a> <br />
				<p> The search that we use will depend on the page that was prior to this one. </p>


			<form action='list.php' method='get'>
				<div data-role="fieldcontain">
		    		<fieldset data-role="options" data-type="horizontal">
				  		<input type="checkbox" name="checkbox-1" id="checkbox-1" class="custom" />
				   		<label for="checkbox-1">Male</label>
				   		<input type="checkbox" name="checkbox-2" id="checkbox-2" class="custom" />
				   		<label for="checkbox-2">Female</label>
				   		<input type="checkbox" name="checkbox-3" id="checkbox-3" class="custom" />
				   		<label for="checkbox-3">Accessible</label>
				   		<input type="checkbox" name="checkbox-4" id="checkbox-4" class="custom" />
				   		<label for="checkbox-4">Changing Table</label>
		   			 </fieldset>
		   		</div>

		   		<button type="submit" data-theme="a">Submit</button>
		   	</form>
		   	</div>
	   	</div>
</div>


	</body>
</html>