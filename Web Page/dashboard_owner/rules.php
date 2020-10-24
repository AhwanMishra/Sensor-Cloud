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
    	<br/><br/>
    	<a href="dashboard_owner.php?logout='1'">Sign out</a>
    	<br/><br/>
    	<a href="dashboard_owner.php">Dashboard</a>
    <?php endif ?>




</td>


<td style= "border: 2px solid #f2f2f2;">
<div style = "padding-left: 50px; padding-top:50px; font:  18px Arial; color: #737373;">
Follow the specified format to communicate with the cloud using MQTT(S).

<ul>

<br/>
<br/>
<li>The packet should come only in the form of a json string.</li>
<br/>
<br/>
<li>Allowed format for status:</li>
<br/>
{"packet" : {}, type : {"status"}}
<br/>
<br/>
<li>Allowed format data:</li>
<br/>
{"packet" : {}, type : {"data"}}
<br/>
<br/>
<li>Sample format for data packet:</li><br/>
{"sensor_type1": x, "sensor_type2": y, ......, "through" : z}<br/>
(The "through" parameter is optional, it should be added if it is a multihop path, all the intermediate nodes should be added while passing through)<br/><br/>

Ex: 
{"packet": {"26": {"LPG": 1, "type": "data", "from": "26", "ANALOG1": 124, "SMOKE": 3, "CO": 4}, "37": {"LPG": 2, "type": "data", "from": "37", "ANALOG1": 280, "SMOKE": 9, "CO": 14, "through": "26"}, "38": {"LPG": 534, "type": "data", "from": "38", "ANALOG1": 337, "SMOKE": 1, "CO": 23919, "through": "27"}}, "type": "data"} <br/><br/>

<li>Sample format for sensor status:</li><br/>
Sensor status : {'node5': {'type': 'status', 'VOLT': 65535, 'from': 'node5', 'CRT': 9, 'through': 'node3', 'WIFI': -48}, 'node2': {'CRT': 3}, 'node4' : {}.......}
</ul>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
</div>
</td>


</tr>
</table>

<div class ="footer">Sensor Cloud</div>

</body>


</html>
