<?php include('server_owner.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Sensor Node | Sensor Cloud</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  
  
<style>
.button1 {
 
  font: bold 18px Arial;
  text-decoration: none;
  background-color: #232f3e;
  color: #ff9d00;
  padding: 4px 6px 4px 6px;
  border-top: 1px solid #CCCCCC;
  border-right: 1px solid #333333;
  border-bottom: 1px solid #333333;
  border-left: 1px solid #CCCCCC;
}
.button1:hover {
  font: bold 19px Arial;
}
</style>




</head>
<body style ="color: #232f3e;">
  <div class="header">
  	<h2>Add Sensor Node</h2>
  </div>
	
  <form method="post" action="add_sensor_node.php">

<div align = "center" style = "font-weight: normal; font-family: Arial;">
<table width="50%">

<tr><td>
	You are about to add a new sensor node. A new sensor id will be generated. You need to keep a note of it for your further usage.
	
	<br/>
	<?php include('errors_owner.php'); ?>
	<br/>
	
	<table width="100%" valign="top">
	<tr>
	<td width="50%">
  		  <label>Node Type:</label>
  	</td>
  	<td>
  		  <select style="min-width:100%; " name="node_type">
    	<option value="esp8286">ESP 8266</option>
    	<option value="esp8285">ESP 8285</option>
    	<option value="esp32">ESP 32</option>
    	<option value="ArduinoUno">Arduino Uno</option>
    	<option value="ArduinoMega">Arduino Mega</option>
    	<option value="ArduinoDue">Arduino Due</option>
    	<option value="RaspberryPi4">Raspberry Pi 4</option>
    	<option value="RaspberryPi3B+">Raspberry Pi 3 B+</option>
    	<option value="RaspberryPi3A+">Raspberry Pi 3 A+</option>
    	<option value="RaspberryPi2">Raspberry Pi 2</option>
  		</select>
	</td>
  	
  	</tr>
	
	
  	
	<tr>
	<td valign="top">
	<br/>
	<br/>
  	<label>Location: </label>
  	</td>
  	
  	<td>	
  		<br/>
  		
  		
   <script type="text/javascript">
    var popup;
    function SelectName() {
        popup = window.open("set_location.html", "Popup", "width='100%',height='100%'");
        popup.focus();
    }
</script>		
  		
  	<input style="min-width:100%;" type="text" id="x" name="loc_x" placeholder="x" > 
  <input style="min-width:100%; " type="text" id="y" name="loc_y" placeholder="y" >
  <input type="button"  value="Set Location (In Map)" onclick="SelectName()" />
  <br/>
  <a style = "text-decoration: none; color: #232f3e;"href="view_map.php" target="_blank">View Map</a>

		<br/>
		<br/>
	</td>
	</tr>
	
	<tr>
	<td>
  		  <label>Sensor Type:</label>
  	</td>
  	<td>
  		  <select name="sensor_type" style="min-width:100%; ">
    	<option value="MQ2">MQ2</option>
    	<option value="MQ3">MQ3</option>
    	<option value="MQ5">MQ5</option>
    	<option value="MQ9">MQ9</option>
    	</select>
	</td>
  	
  	</tr>
  	
	<tr>
 	<td align="center" colspan = 2>
		<br/>
  	  <button type="submit" class="button1" name="add_sensor_node">&nbsp;&nbsp;Add Sensor Node &nbsp;&nbsp;</button>
  	  </td></tr>
  	</table>
  	
  	</td>
  	</tr>
  	</table> </div>
  </form>
</body>
</html>
 
 
 
  
