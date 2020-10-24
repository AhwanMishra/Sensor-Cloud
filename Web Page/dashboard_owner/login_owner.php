<?php include('server_owner.php') ?>
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
	 
  <form method="post" action="login_owner.php">
  	<?php include('errors_owner.php'); ?>
  	<div class="input-group extra1">
  		<label>Owner name</label>
  		<input type="text" name="ownername" >
  	</div>
  	<div class="input-group extra1">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group" align="center">
  		<button type="submit" class="btn" name="login_owner">&nbsp;&nbsp;Sign In &nbsp;&nbsp;</button>
  	</div>
  	<p align="center">
  		Not yet a member? <a href="register_owner.php">Sign up</a>
  		<br/><br/><a href = "/"><font face="Arial">Back</font></a>
  	</p>
  </form>
</body>
</html>

