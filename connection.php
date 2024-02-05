<?php 

$db_user = "root";
$db_pass = "";
$db_name = "hotel_reservation";
date_default_timezone_set("Asia/Manila"); 

$connection = mysqli_connect("localhost", $db_user, $db_pass);

if (!$connection) {
	die("Unable to connect to dbhost: " . mysqli_error($connection));
} else {
		$selected_db = mysqli_select_db($connection, $db_name);
		if (!$selected_db) { 
			die("Unable to use the selected database: ". mysqli_error($connection)); 
		}
	}
?>
 