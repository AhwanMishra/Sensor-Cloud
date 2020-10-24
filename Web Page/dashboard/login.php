<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign in to Sensor Cloud</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Sign In</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group extra1">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group extra1">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group" align="center">
  		<button type="submit" class="btn" name="login_user">&nbsp;&nbsp;Sign In &nbsp;&nbsp;</button>
  	</div>
  	<p align="center">
  		Not yet a member? <a href="register.php">Sign up</a>
  		<br/><br/><a href = "/">Back</a>
  	</p>
  </form>
</body>
</html>

