<?php
	$asset_path = "../assets/";

	echo "<link rel='apple-touch-icon' href='".$asset_path."/images/appicon.png' />";
	echo "<link rel='apple-touch-startup-image' href='startup.png'>";
	echo "<meta name='apple-mobile-web-app-capable' content='yes'>";
	echo "<meta name='apple-mobile-webapp-status-bar-style' content='black'>";
	echo "<meta name='viewport' content='width=device-width, user-scalable=no' />";

	
	$javascript_path = $asset_path."/javascript/";

	echo "<link rel='stylesheet' type='text/css' href='../assets/stylesheets/styles.css'>";
	echo "<script src='".$javascript_path."util.js'></script>";

	$jquery_path = $javascript_path."/jquery/";
#	echo "<link rel='stylesheet' href='".$jquery_path."jquery.mobile-1.2.0.css' />";
#	echo "<script src='".$jquery_path."jquery-1.8.2.js'></script>";
#	echo "<script src='".$jquery_path."jquery.mobile-1.2.0.js'></script>";
		
	require_once('../config/google_maps_config.php');
?>
