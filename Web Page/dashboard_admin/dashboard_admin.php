<?php 
 session_start(); 

  if (!isset($_SESSION['adminname'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login_admin.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['adminname']);
  	header("location: login_admin.php");
  }
?>


<!doctype html>
<html>

<head>
	<title>Sensor Cloud Dashboard (Admin)</title>
	
<style>	
.button1 {
 
  font: bold 20px Arial;
  text-decoration: none;
  /*background-color: #297ed3;*/
  background: linear-gradient(to bottom, #2e83d8, #1b70c5 ,  #2e83d8);
  color: #ffffff;
  padding: 6px 8px 8px 6px;
  border-top: 1px solid #CCCCCC;
  border-right: 1px solid #333333;
  border-bottom: 1px solid #333333;
  border-left: 1px solid #CCCCCC;
}
.button1:hover {
  /*background-color: #232f3e;*/
  background: linear-gradient(to bottom, #232f3e, #232f3e);
  color: #ff9d00;
}

.button2 {
 width: 250px;
  font: bold 20px Arial;
  text-decoration: none;
  /*background-color: #297ed3;*/
  background: linear-gradient(to bottom, #f1f1f1, #d0d0d0);
  color: #44444e;
  padding: 4px 6px 4px 6px;
  border-top: 1px solid #CCCCCC;
  border-right: 1px solid #CCCCCC;
  border-bottom: 1px solid #CCCCCC;
  border-left: 1px solid #CCCCCC;
  cursor : pointer
}
.button2:hover {
	background: linear-gradient(to bottom, #232f3e, #232f3e);
  /*background-color: #232f3e;*/
  color: #ff9d00;
}

.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #232f3e;
   color: #FF9D00;
   text-align: center;
   padding-top: 5px;
   padding-bottom: 5px;
   
}

.header {
   position: fixed;
   left: 0;
   top: 0;
   width: 100%;
   background-color: #232f3e;
   color: #FF9D00;
   text-align: center;
   /*font-family: Arial;*/
   font-size: 40px;
}
</style>	
</head>

<body bgcolor="#ffffff" cellpadding=5 >
<div class="header">Sensor Cloud Dashboard (Admin)</div>

<table  style="margin-top: 50px; " width="100%" border=0 bgcolor="#ffffff">
<tr>

<td width = 12% valign="top" style = "padding-left : 5px;">
<br/><br/><br/>
<font style="color: #ec7211">Sensor Cloud Dashboard (Admin)</font>
<br/>
<br/>

    <!-- logged in owner information -->
    <?php  if (isset($_SESSION['adminname'])) : ?>
    	Welcome <strong><?php echo $_SESSION['adminname']; ?></strong>
    	<br/>
    	<a href="dashboard_admin.php?logout='1'">Sign out</a>
    <?php endif ?>
  
  <!--Welcome <br/><strong> admin ! </strong><br/><br/>
<a href="dashboard_admin.php?logout='1'">Sign out</a> -->
</td>



<td>
<br/>
<a class="button1" href="view_map.php"  target="_blank"> View Map</a>
<br/>
<br/>
<table width="100%" cellpadding=10>

<tr style = "background: linear-gradient(to bottom,#ececec, #e0e0e0); font: bold 14px Arial;  color: #44444e" >
<td align = "center">
Entity
</td>
<td align = "center">

Actions

</td>
</tr>

<tr style="font: bold 20px Arial;" >
<td align = "center" style = 'background-color: #f2f2f2; color: #44444e;'>
Users
</td>


<td  align = 'center' style = 'background-color: #f2f2f2'> 
	<form method='post' action="list_users.php"> 
		<button type='submit' class='button2' name='stop'>
							List Users
		</button>
	</form>

	<form method='post' action="user_requirements.php"> 
		<button type='submit' class='button2' name='stop'>
							User_requirements
		</button>
	</form>

	<form method='post' action = "price.php"> 
		<button type='submit' class='button2' name='stop'>
							Price
		</button>
	</form>

</td>


</tr>




<tr style="font: bold 20px Arial;">
<td align = "center" style = 'background-color: #f2f2f2; color: #44444e;'>
Owners
</td>



<td align = 'center' style = 'background-color: #f2f2f2'> 
	<form method='post' action="list_owners.php"> 
		<button type='submit' class='button2' name='stop'>
							List Owners
		</button>
	</form>

	<form method='post' action="owner_details.php"> 
		<button type='submit' class='button2' name='stop'>
							Owner details
		</button>
	</form>

	<form method='post' action="profits.php"> 
		<button type='submit' class='button2' name='stop'>
							Owner Profits
		</button>
	</form>

</td>
</tr>



<tr style="font: bold 20px Arial;" >
<td align = "center" style = 'background-color: #f2f2f2; color: #44444e;'>
Logs
</td>



<td align = 'center' style = 'background-color: #f2f2f2 ; color: #44444e;'> 
Last Picked Nodes:
<br/>
<div style="font: normal 18px Arial;">
<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');

	
	$query = "select text from Logs where type = 'picked_nodes'";
	$result = mysqli_query($db, $query);
	
	
	if (mysqli_num_rows($result) > 0) 
	{
		while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
		{
			echo $final_result['text'];
		}
	}
	
?>
</div>
</td>

<tr style="font: bold 20px Arial;">
<td width="30%" align = "center" style = 'background-color: #f2f2f2; color: #44444e;'>
Logs
</td>
<td  align = 'left' style = 'background-color: #f2f2f2 ; color: #44444e;'> 
<div align = "center">Last packet from gateway:</div>
<br/>
<div align = "left" style = "font: normal 10px Arial;">
<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');

	
	
	$query = "select text from Logs where type = 'gateway_message'";
	$result = mysqli_query($db, $query);
	
	if (mysqli_num_rows($result) > 0) 
	{
		while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
		{
						echo $final_result['text'];
		}
	}

?>
</div>
</td>
</tr>

</tr>



</td>


</tr>
</table>

<div class ="footer">Sensor Cloud</div>

</body>


</html>
