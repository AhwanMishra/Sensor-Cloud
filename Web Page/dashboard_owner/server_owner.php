<?php
session_start();

// initializing variables
$ownername = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');

// REGISTER owner
if (isset($_POST['reg_owner'])) {
  // receive all input values from the form
  $ownername = mysqli_real_escape_string($db, $_POST['ownername']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($ownername)) { array_push($errors, "Owner name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a owner does not already exist with the same ownername and/or email
  $owner_check_query = "SELECT * FROM owners WHERE ownername='$ownername' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $owner_check_query);
  $owner = mysqli_fetch_assoc($result);
  
  if ($owner) { // if owner exists
    if ($owner['ownername'] === $ownername) {
      array_push($errors, "Owner name already exists");
    }

    if ($owner['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register owner if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO owners (ownername, email, password) 
  			  VALUES('$ownername', '$email', '$password')";
  	mysqli_query($db, $query);
  	
  	
  	$_SESSION['ownername'] = $ownername;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: dashboard_owner.php');
  }
}





// LOGIN OWNER
if (isset($_POST['login_owner'])) {
  $ownername = mysqli_real_escape_string($db, $_POST['ownername']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($ownername)) {
  	array_push($errors, "Owner name is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM owners WHERE ownername='$ownername' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['ownername'] = $ownername;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: dashboard_owner.php');
  	}else {
  		array_push($errors, "Wrong ownername/password combination");
  	}
  }
}



// add_sensor_node


if (isset($_POST['add_sensor_node'])) {
	$sensor_type = "";
	$node_type = "";
	$loc_x = "";
	$loc_y = "";
	
  $sensor_type = mysqli_real_escape_string($db, $_POST['sensor_type']);
  $node_type = mysqli_real_escape_string($db, $_POST['node_type']);
  $loc_x = mysqli_real_escape_string($db, $_POST['loc_x']);
  $loc_y = mysqli_real_escape_string($db, $_POST['loc_y']);
  
  if (empty($sensor_type)) {
  	array_push($errors, "Sensor Type is required !");
  }

if (empty($node_type)) {
  	array_push($errors, "Node Type is required !");
  }


if (empty($loc_x)) {
  	array_push($errors, "Location X is required !");
  }
  
  if (empty($loc_y)) {
  	array_push($errors, "Location Y is required !");
  }

  if (count($errors) == 0) {
  	$ownername = $_SESSION['ownername'];
  	$query = "insert into Sensor_details_owner(node_type, owner_name, sensor_type, loc_x , loc_y) values('$node_type','$ownername', '$sensor_type', '$loc_x', '$loc_y')";
  	
  	mysqli_query($db, $query);
  	header('location: dashboard_owner.php');
  }
}



?>

