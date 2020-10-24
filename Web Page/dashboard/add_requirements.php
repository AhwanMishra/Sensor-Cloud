<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Requirements | Sensor Cloud</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  
  
<style>
.button1 {
 
  font: bold 18px Arial;
  text-decoration: none;
  background-color: #297ed3;
  color: #ffffff;
  padding: 4px 6px 4px 6px;
  border-top: 1px solid #CCCCCC;
  border-right: 1px solid #333333;
  border-bottom: 1px solid #333333;
  border-left: 1px solid #CCCCCC;
}
.button1:hover {
  background-color: #232f3e;
  color: #ff9d00;
}
</style>
</head>
<body>
  <div class="header">
  	<h2>Add requirements</h2>
  </div>
	
  <form method="post" action="add_requirements.php">

<div align = "center"><table width="50%">

<tr><td>
  	<div  class="input-group">
  		  <label>Sensor Type</label>
  		  <select name="Sensor_Type">
    	<option value="CO">CO</option>
    	<option value="LPG">LPG</option>
    	<option value="SMOKE">SMOKE</option>
    	<option value="AIR_POLLUTION">Air Pollution</option>
  		</select>
  	</div>

  	<div class="input-group">
  		  <label>Plan</label>
  		  <select name="Plan">
    	<option value="Diamond">Diamond</option>
    	<option value="Gold">Gold</option>
    	<option value="Silver">Silver</option>
  		</select>
  	</div>
<br/>
  	<div   class="input-group">
  	  <button type="submit" class="button1" name="add_requirement">&nbsp;&nbsp;Add Requirement &nbsp;&nbsp;</button>
  	</div>
  	
  	</td>
  	</tr>
  	</table> </div>
  </form>
</body>
</html>
 
 
 
  
