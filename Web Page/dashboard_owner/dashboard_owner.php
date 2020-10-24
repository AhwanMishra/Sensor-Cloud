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
	<title>Sensor Cloud Dashboard (Owner)</title>
	
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

<body bgcolor="#ffffff" cellpadding=5 >
<div class="header">Sensor Cloud Dashboard (Owner)</div>

<table  style="margin-top: 50px; " width="100%" border=0 bgcolor="#ffffff">
<tr>

<td width = 12% valign="top" style = "padding-left : 5px;">
<br/><br/><br/>
<font style="color: #ec7211">Sensor Cloud Dashboard (Owner)</font>
<br/>
<br/>

    <!-- logged in owner information -->
    <?php  if (isset($_SESSION['ownername'])) : ?>
    	Welcome <strong><?php echo $_SESSION['ownername']; ?></strong>
    	<br/></br>
    	<a href="dashboard_owner.php?logout='1'">Sign out</a>
    	<br/>
    	<br/>
    	<a href="rules.php">Communication Rules</a>
    	<br/>
    	<br/>
    	<a href="profit.php">Profit</a>
    	
    <?php endif ?>




</td>


<td>
<br/>

<a class="button1" href="add_sensor_node.php">Add new Sensor Node</a>
<br/>
<br/>


	<table width="100%" cellpadding=10>
	<tr style = "background-color: #e5e5e5; font: bold 14px Arial;" >
		<td>
		Node_ID
		</td>
		
		
		<td>
		Location
		</td>
		


		<td>
		Node Type
		</td>
		

		<td>
		Sensor Type
		</td>
		
		<td align="center">
		Action
		</td>
	</tr>
	
	<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
	$on = $_SESSION['ownername'];
	$query = "SELECT * FROM Sensor_details_owner where  owner_name = '".$on."'";
	
	$result = mysqli_query($db, $query); //everything is stored here

	if (mysqli_num_rows($result) > 0) 
	{
		while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
		{
			echo "<tr>";
			echo "<td style = 'background-color: #f2f2f2'>".$final_result['node_id']."</td>";
			echo "<td style = 'background-color: #f2f2f2'>".$final_result['loc_x']." , ".$final_result['loc_y']."</td>";
			echo "<td style = 'background-color: #f2f2f2'>".$final_result['node_type']."</td>";
			echo "<td style = 'background-color: #f2f2f2'>".$final_result['sensor_type']."</td>";
			$url_delete = "delete_sensor_node.php?nid=".$final_result['node_id'];
			
			echo " <td style = 'background-color: #f2f2f2' align = 'center'> <form method='post' action=$url_delete> 
					<button type='submit' class='button2' name='delete'>
						Delete Node
					</button>
				</form></td>";
			echo "</tr>";
		}
		echo " </table> ";
		echo "<br/><font face = 'Arial' >Follow the instructions as given below to connect your node to cloud with MQTT(S).</font><br/><br/>";
		echo "<font face = 'Arial' >
			Host ID : a3c3q60w5n9zit-ats.iot.us-east-1.amazonaws.com  </br>
			Port : 8883 <br/> 
			<table><tr>
			<td>Root_CA_Certificate_Name : </td> <td><a href='Root_CA_Certificate.crt'>Download</a> </td><tr/> 
			<td>Thing_Name.cert.pem : </td> <td><a href='Thing_Name.cert.pem'>Download</a> </td><tr/>
			<td>Thing_Name.private.key : </td> <td><a href='Thing_Name.private.key'>Download</a></font> </td><tr/></table>
			</font></br>";
			
	}
	else
	{
		echo "<tr style = 'background-color: #EAF3FE'><td  bgcolor = '#f2f2f2' style='height:300px;' colspan = 5 align = 'center' valign = 'center'> 
		<br/>
		
		<font size='6' face = 'Arial' color = '#737373'>Currently there is no sensor node owned by you ! <br/>
		Click to add a new Sensor Node.</font></td></tr></table>";
	}
	?>


</td>


</tr>
</table>

<div class ="footer">Sensor Cloud</div>

</body>


</html>
