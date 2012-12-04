<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | Filter</title>

		<?php
			require("header.php");
		?>
	
	</head>
	<body>
		<div data-role="page" class="filter_home">
			<script type="text/javascript">
				var makeFooter = function() {
					var originParams = escape("?" + stringify_params(get_params()));
					var links = [
					{name:"Map", url:"map.php" + query_string(old_params(), {origin:"filter"}), icon:"custom"}, 
					{name:"List", url:"list.php" + query_string(old_params(), {origin:"filter"}), icon:"custom"},
					{name:"Filter", url:"#", icon:"custom"}, 				
					{name:"Help", url:"help.php" + query_string({}, {origin:"filter", originParams:originParams}), icon:"custom"}];
					SetFooterLinks(".filter_home", links);
				}

				$(document).delegate(".filter_home", 'pagebeforecreate', function(event) {
					makeFooter();
					var params = get_params();
					$("#cancel_link").attr("href", params.origin + ".php" + query_string(old_params(), {origin:"filter"}));

					var form = document.getElementById("filter_form");
					form.action = (params.origin == "map" || params.origin == 'list') ? params.origin + '.php' : "list.php";
				});

				$(document).delegate(".filter_home", 'pageshow', function(event) {
        			disable_safari();
        			$(".filter_home #filter_footer_link").addClass("ui-btn-active");
    			});
    			$(document).delegate(".filter_home", 'pageshow', function(event) {
					var form = document.getElementById("filter_form");
					var inputs = form.getElementsByTagName("input");

					var filterHash = filter_from_params();
					for(var i = 0; i < inputs.length; i++) {
						var checkbox = inputs[i];
						if(filterHash[checkbox.name]) {
							$("#" + checkbox.id).attr("checked", true).checkboxradio("refresh");
						}
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
						var action = (form.action == undefined) ? 'list.php': form.action;
						console.log(action);
						var url = action + "?form=" + urlEncoded;
						//console.log(urlEncoded);
						//console.log(url);
						window.location = url;
						return false; // stop form submit
					};

					$("#uncheck_all").click(function() {
						$("#filter_form input[type=checkbox]").attr("checked", false).checkboxradio("refresh");
					});
					$("#check_all").click(function() {
						$("#filter_form input[type=checkbox]").attr("checked", true).checkboxradio("refresh");
					});
				});

			</script>

			<div data-role="header">
				<h2>Filter</h2>
				<a data-role="button" data-rel="back" data-mini="true" data-inline="true" id="cancel_link">Cancel</a>
			</div>
			<div data-role="content">
				<div data-type="controlgroup">
					<button data-mini="true" data-inline="true" id="uncheck_all" type="button" data-theme="a">Uncheck all</button>
					<button data-mini="true" data-inline="true" id="check_all" type="button" data-theme="a">Check all</button>
				</div>

				<form id="filter_form" action='map.php' method='get'>
					<div data-role="controlgroup" data-type="vertical">
			    		<fieldset data-role="options">
					  		<input type="checkbox" name="male" value="1" id="checkbox-1" class="custom" />
					   		<label for="checkbox-1">Male</label>
					   		<input type="checkbox" name="female" value="1" id="checkbox-2" class="custom" />
					   		<label for="checkbox-2">Female</label>
					   		<input type="checkbox" name="handicap" value="1" id="checkbox-3" class="custom" />
					   		<label for="checkbox-3">Accessible</label>
					   	
			   			 </fieldset>
			   		</div>
			   		<button id="submit_button" type="button" data-theme="a">Filter Bathrooms</button>
			   	</form>
		   	</div>

	   		<?php
				require ("footer.php");
			?>
	   	</div>
	</body>
</html>