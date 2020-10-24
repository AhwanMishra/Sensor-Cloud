<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration | Sensor Cloud</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group extra1">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group extra1">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group extra1">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group extra1">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div align="center"  class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p align="center">
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>

