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
					if (params.origin == 'list') {
						document.write("<a href='list.php'>Cancel</a>");
					}
					else {
						document.write("<a href='map.php'>Cancel</a>");
					}
				</script>
				 <br />
				<a href="help.php">Help</a> <br />


			<form id="filter_form" action='map.php' method='get'>
				<div data-role="fieldcontain">
		    		<fieldset data-role="options" data-type="horizontal">
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
	   	</div>
</div>


	</body>
</html>