<?php
session_start();

// initializing variables
$adminname = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');


// LOGIN admin
if (isset($_POST['login_admin'])) {
  $adminname = mysqli_real_escape_string($db, $_POST['adminname']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($adminname)) {
  	array_push($errors, "admin name is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	//$password = md5($password);
  	//$query = "SELECT * FROM admins WHERE adminname='$adminname' AND password='$password'";
  	//$results = mysqli_query($db, $query);
  	//if (mysqli_num_rows($results) == 1) {
  	if ($adminname == "admin" and $password == "password") {
  	  $_SESSION['adminname'] = $adminname;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: dashboard_admin.php');
  	}else {
  		array_push($errors, "Wrong adminname/password combination");
  	}
  }
}




?>

