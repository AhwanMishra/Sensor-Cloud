<?php 
  /*session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }*/
?>


<!doctype html>
<html>

<head>
	<title>Sensor Cloud Dashboard (Admin)</title>
	
<style>	
.button1 {
 
  font: bold 16px Arial;
  text-decoration: none;
  /*background-color: #297ed3;*/
  background: linear-gradient(to bottom, #2e83d8, #1b70c5 ,  #2e83d8);
  color: #ffffff;
  padding: 4px 6px 4px 6px;
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
  font: bold 14px Arial;
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

<body bgcolor="" cellpadding=5 >
<div class="header">Sensor Cloud Dashboard (Admin)</div>



<div align="center" 
style="


width : 100%;

margin-top: 100px;
margin-left: 50px;
font-family: Arial;
font-size: 25px;
letter-spacing: 2px;
word-spacing: 2px;
color: #89899D;
font-weight: normal;
text-decoration: none;
font-style: normal;
font-variant: normal;
text-transform: none;
">

<table width = "50%">

<tr> <td>  Node_ID</td> <td>  Total Profit </td> </tr>
<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
	//$un = $_SESSION['username'];
	$query = "select *  from Profit";
	
	$result = mysqli_query($db, $query); //everything is stored here

	if (mysqli_num_rows($result) > 0) 
	{
		while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
		{
			$un_temp = $final_result['node_id'];
			$price_temp = $final_result['total_profit'];
			echo "<tr> <td>$un_temp </td> <td> $price_temp </td></tr>";
		}
	}
	

	 //echo "Hi $un !<br/> Total Price: <font style = 'color: black;'>$total_price </font>unit";
	 

?>
</table>
<br/><a href='dashboard_admin.php'><font style = 'font-size: 20px; color: #FF9905;'>Back to Dashboard</font></a>
</div>

<div class ="footer">Sensor Cloud</div>
</body>


</html>
