<?php include('server_owner.php') ?>
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
	
  <form method="post" action="register_owner.php">
  	<?php include('errors_owner.php'); ?>
  	<div class="input-group extra1">
  	  <label>Owner name</label>
  	  <input type="text" name="ownername" value="<?php echo $ownername; ?>">
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
  	  <button type="submit" class="btn" name="reg_owner">Register</button>
  	</div>
  	<p align="center">
  		Already a member? <a href="login_owner.php">Sign in</a>
  	</p>
  </form>
</body>
</html>

