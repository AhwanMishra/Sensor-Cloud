<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
	$nid = $_GET['nid'];
	$query = "delete FROM Sensor_details_owner where node_id = '".$nid."'";
	
	$result = mysqli_query($db, $query); //everything is stored here
	header('location: dashboard_owner.php');
?>
