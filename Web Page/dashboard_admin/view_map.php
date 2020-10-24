<!doctype html>
<html>

<head>
	<title>View Map</title>
	
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

.button2 {
 width: 250px;
  font: bold 15px Arial;
  text-decoration: none;
  background-color: #297ed3;
  color: #ffffff;
  padding: 4px 6px 4px 6px;
  border-top: 1px solid #CCCCCC;
  border-right: 1px solid #333333;
  border-bottom: 1px solid #333333;
  border-left: 1px solid #CCCCCC;
}
.button2:hover {
  background-color: #232f3e;
  color: #ff9d00;
}




@keyframes example {
  from { width:90px;}
  to {width:85px;}
}

@keyframes example2 {
  from { 
  height: 25px;
  width: 25px;
  background-color: yellow;
  border-radius: 50%;
  position: absolute; top: 400px; left: 680px;}
  
  to {
  height: 35px;
  width: 45px;
  background-color: green;
  border-radius: 50%;
  position: absolute; top: 390px; left: 670px;}
}

@keyframes example3 {
  from { 
  height: 25px;
  width: 25px;
  background-color: green;
  border-radius: 50%;
  }
  
  to {
  height: 28px;
  width: 28px;
  background-color: yellow;
  border-radius: 50%;}
}

</style>	


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
</script>  

<script>
$(document).ready(function() {
  $('img').click(function(e) {
    var offset = $(this).offset();
    var x = e.pageX - offset.left;
    var y = e.pageY - offset.top;
    alert("Location : IIT Kharagpur\n"+"X : " + parseInt(x) + "\nY : " + parseInt(y) ); //to keep it decimals only
    
    /*var x1 = window.opener.document.getElementById("x");
    x1.value = parseInt(x);
    var y1 = window.opener.document.getElementById("y");
    y1.value =  parseInt(y);
    window.close();*/
    
  });
});

function spanFunction(id, nt, on, st) {
  alert("Node ID: "+ id +"\nNode Type: "+ nt +"\nOwner Name: "+ on+ "\nSensor Types: "+ st);
  
}


</script>
</head>

<body bgcolor="#232f3e" cellpadding=5 >
<div align = "center" style = "background-color: #232f3e;"><font style="font-size: 40px; color: #FF9D00">View Map</font></div>

<table width="100%"  bgcolor="#ffffff">
<tr><td colspan = 2 bgcolor = "#ffffff"></br></td></tr>
<tr>





<td  align = "center" style = "border-style: dotted; border-color : #000000;">

<a href="#">
    <img style = "cursor : crosshair; "src="images/mapnewfinal.jpg" alt="IIT Kharagpur Map" ></img>
    
       <span style =   " cursor : pointer;
  display: inline-block;
    animation-name: example2; animation-duration: 0.3s; animation-iteration-count : infinite;"></span>
    
    <img  style = "position: absolute; top: 380px; left: 650px;  animation-name: example;
  animation-duration: 0.3s; animation-iteration-count : infinite;" src = "images/gateway.png" alt="gateway" ismap></img>
  
  
  </a>
<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
	//$un = $_SESSION['username'];
	$query = "select *  from Sensor_details_owner";
	
	$result = mysqli_query($db, $query); //everything is stored here

	if (mysqli_num_rows($result) > 0) 
	{
		while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
		{
			$id_temp = $final_result['node_id'];
			$nt_temp = $final_result['node_type'];
			$on_temp = $final_result['owner_name'];
			$st_temp = $final_result['sensor_type'];
			$lx_temp = $final_result['loc_x'] + 5;
			$ly_temp = $final_result['loc_y'] + 80;
			//echo " $lx_temp &  $ly_temp ";
			
			echo "<span onclick='spanFunction($id_temp, \"$nt_temp\", \"$on_temp\", \"$st_temp\")' style = 'cursor : pointer;  display: inline-block;
    animation-name: example3; animation-duration: 0.4s; animation-iteration-count : infinite; position: absolute; top: $ly_temp"."px; left: $lx_temp"."px;'> $id_temp </span>";
    
    /*echo "<span onclick='spanFunction2("."\"$nt_temp\" ".")' style =   'display: inline-block;
    animation-name: example3; animation-duration: 0.5s; animation-iteration-count : infinite; position: absolute; top: $ly_temp"."px; left: $lx_temp"."px;'> $id_temp </span>";*/
		}
	}
?>

  
  
  
  



 </td></tr>


<tr>
<td bgcolor="#ffffff" align = "center"> Image Source: Google Earth <br/> </td> </tr> </table>
<br/>
</br>
</body>
</html>
