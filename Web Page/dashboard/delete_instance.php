<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
	$un = $_GET['un'];
	$st = $_GET['st'];
	$query = "delete FROM User_requirements where  User_name = '".$un."' and Sensor_Type = '".$st."'";
	
	$result = mysqli_query($db, $query); //everything is stored here
	header('location: dashboard.php');
?>
