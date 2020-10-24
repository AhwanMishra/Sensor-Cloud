<?php 
  session_start(); 

  if (!isset($_SESSION['ownername'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login_owner.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['ownername']);
  	header("location: login_owner.php");
  }
?>


<!doctype html>
<html>

<head>
	<title>Sensor Cloud Dashboard</title>
	
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
<div class="header">Sensor Cloud Dashboard</div>



<div align="center" 
style="


width : 100%;

margin-top: 150px;
font-family: Arial;
font-size: 35px;
letter-spacing: 2px;
word-spacing: 2px;
color: #89899D;
font-weight: normal;
text-decoration: none;
font-style: normal;
font-variant: normal;
text-transform: none;
">
<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
	$un = $_SESSION['ownername'];
	//$query = "select total_price  from Price where username = '".$un."'";
	
	$query = "select Sensor_details_owner.node_id, Profit.total_profit from Profit, Sensor_details_owner where Profit.node_id = Sensor_details_owner.node_id and Sensor_details_owner.owner_name = '".$un."'";
	$result = mysqli_query($db, $query); //everything is stored here

	echo "Hi $un !<br/><br/>";
	echo"<table  width='40%' style='font-size: 25px;' border='1'>";
	$toal_profit = 0;
	echo"<tr > <td align='center'> Node_id</td> <td align='center'> Profit</td></tr>";
	if (mysqli_num_rows($result) > 0) 
	{
		while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
		{
			echo "<tr><td align='center'>";
			echo $final_result['node_id'];
			echo "</td>";
			echo "<td align='center'>";
			echo $final_result['total_profit'];
			echo "</td></tr>";
			
			$toal_profit = $toal_profit + $final_result['total_profit'];
		}
	}
	echo"</table><br/><br/>";

	  echo "Total Proft: <font style = 'color: black;'>$toal_profit </font>unit";
	 echo "<br/><a href='dashboard_owner.php'><font style = 'font-size: 20px; color: #FF9905;'>Back to Dashboard</font></a>"

?>
</div>

<div class ="footer">Sensor Cloud</div>
</body>


</html>
