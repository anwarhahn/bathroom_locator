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
				<h2>Filter</h2>
				<a data-role="button" data-mini="true" data-inline="true" id="cancel_link">Cancel</a>
				<a id="help_link" href="help.php?origin=filter" data-role="button" data-mini="true" data-inline="true">Help</a>
			</div>
			<div data-role="content">
					


				<script type="text/javascript">
				var params = get_params();
				$("#cancel_link").attr("href", params.origin + ".php" + query_string(old_params(), {origin:"filter"}));
				var originParams = escape("?" + stringify_params(params));
				$("#help_link").attr("href", "help.php" + query_string({}, {origin:"filter", originParams:originParams}));
				</script>
				


			<form id="filter_form" action='map.php' method='get'>
				<div data-role="controlgroup" data-type="vertical">
		    		<fieldset data-role="options">
				  		<input type="checkbox" name="male" value="1" id="checkbox-1" class="custom" />
				   		<label for="checkbox-1">Male</label>
				   		<input type="checkbox" name="female" value="1" id="checkbox-2" class="custom" />
				   		<label for="checkbox-2">Female</label>
				   		<input type="checkbox" name="handicap" value="1" id="checkbox-3" class="custom" />
				   		<label for="checkbox-3">Accessible</label>
				   		<input type="checkbox" name="babychanging" value="1" id="checkbox-4" class="custom" />
				   		<label for="checkbox-4">Changing Table</label>
		   			 </fieldset>
		   		</div>

		   		<button id="submit_button" type="button" data-theme="a">Submit</button>
		   	</form>

		   	<script type="text/javascript">
				var form = document.getElementById("filter_form");
				//console.log(form);
				form.action = params.origin + ".php";

				var inputs = form.getElementsByTagName("input");
				
				var filterHash = filter_from_params();
				for(var i = 0; i < inputs.length; i++) {
					var checkbox = inputs[i];
					if(filterHash[checkbox.name]) checkbox.checked = true;
				}
				//console.log(filterHash);
				

				var button = document.getElementById("submit_button");
				button.onclick = function() {
					//console.log(inputs);
					var formValue = {}
					for(var i = 0; i < inputs.length; i++) {
						var child = inputs[i];
						if (child.checked) {
							//console.log(child.name);
							formValue[child.name] = child.value;
						}
					}

					var urlEncoded = escape(JSON.stringify(formValue));
					var url = form.action + "?form=" + urlEncoded;
					//console.log(urlEncoded);
					//console.log(url);
					window.location = url;
					return false; // stop form submit
				};
			</script>
		   	</div>

	   		<?php
				require ("footer.php");
			?>
			<script type="text/javascript">
				var links = []
				SetFooterLinks(links);
			</script>
	   	</div>
	</body>
</html>