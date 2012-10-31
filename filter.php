<!DOCTYPE html>
<html>	
	<head>
		<title>Filter</title>
		<link rel="apple-touch-icon" href="appicon.png" />
		<link rel="apple-touch-startup-image" href="startup.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-webapp-status-bar-style" content="black">
		<meta name="viewport" content="width=device-width, user-scalable=no" />
		<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />

		<script src="jquery-1.8.2.js"></script>
		<script src="jquery.mobile-1.2.0.js"></script>
	
	</head>
	<body>

		<div data-role="page">

			<div data-role="header">
				<h1>Filter</h1>
			</div>
			<div data-role="content">
				<a href="map.php">Cancel(map)</a> <br />
				<a href="list.php">Cancel(list)</a> <br />
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