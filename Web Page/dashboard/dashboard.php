<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
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

<body bgcolor="" cellpadding=0 >
<div class="header">Sensor Cloud Dashboard</div>
<!---<div align = "center" style = "background-color: #232f3e;"><font style="font-size: 40px; color: #FF9D00">Sensor Cloud Dashboard</font></div>--->

<table width="100%" style="margin-top: 50px; " border=0 bgcolor="#ffffff">
<tr margin-left: 0px;>

<td width = 12% valign="top" style = "padding-left : 5px; ">
<br/><br/><br/>
<font style="color: #ec7211">Sensor Cloud Dashboard</font>
<br/>
<br/>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	Welcome <strong><?php echo $_SESSION['username']; ?></strong>
    	<br/>
    	<br/>
    	<a href="price.php">Pricing</a>
    	<br/>
    	<br/>
    	<a href="dashboard.php?logout='1'">Sign out</a>
    	
    <?php endif ?>




</td>


<td>
<br/>
<a class="button1" href="add_requirements.php">Create Virtual Sensor</a>
<br/>
<br/>


	<table width="100%"   cellpadding=10>
	<tr style = "background: linear-gradient(to bottom,#ececec, #e0e0e0); font: bold 14px Arial;  color: #44444e" >
		
		<td>
		Sensor_Type
		</td>
		
		
		<td>
		Location
		</td>
		
		<td>
		State
		</td>
		
		<td>
		Pricing
		</td>
		
		<td align="center">
		Action
		</td>
	</tr>
	
	<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
	$un = $_SESSION['username'];
	$query = "SELECT * FROM User_requirements where  User_name = '".$un."'";
	
	$result = mysqli_query($db, $query); //everything is stored here

	if (mysqli_num_rows($result) > 0) 
	{
		while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
		{
			echo "<tr>";
			echo "<td style = 'background-color: #f2f2f2'>".$final_result['Sensor_Type']."</td>";
			echo "<td style = 'background-color: #f2f2f2'> Kharagpur </td>";
			
			if($final_result['state'] == "active")
				echo "<td style = 'background-color: #f2f2f2'> <font color='#52c229'> &#9679 </font>" .$final_result['state']. "</td>";
			else
				echo "<td style = 'background-color: #f2f2f2'> <font color='red'> &#9679 </font>" .$final_result['state']. "</td>";
			echo "<td style = 'background-color: #f2f2f2'>".$final_result['Plan']."</td>";
			
			$url_delete = "delete_instance.php?un=".$un."&st=".$final_result['Sensor_Type'];
			$url_stop = "stop_instance.php?un=".$un."&st=".$final_result['Sensor_Type'];
			$url_start = "start_instance.php?un=".$un."&st=".$final_result['Sensor_Type'];
			$url_visualize = "visualize.php?un=".$un."&st=".$final_result['Sensor_Type'];
			
				
			if($final_result['state'] == "Inactive")	
				echo "<td align = 'center' style = 'background-color: #f2f2f2'> 
				<form method='post' action=$url_start> 
						<button type='submit' class='button2' name='start'>
							Start Instance
						</button>
					</form>";
				
			
			else
				echo "<td align = 'center' style = 'background-color: #f2f2f2'> 
					<form method='post' action=$url_stop> 
						<button type='submit' class='button2' name='stop'>
							Stop Instance
						</button>
					</form>";
					
					
			echo " <form method='post' action=$url_visualize target = '_blank'> 
					<button type='submit' class='button2' name='visualize'>
						Visualize
					</button>
				</form>";
						
					
			echo " <form method='post' action=$url_delete> 
					<button type='submit' class='button2' name='delete'>
						Delete Instance
					</button>
				</form></td>";
				
			echo "<tr/>";
		}
	}
	else
	{
		echo "<tr style = 'background-color: #EAF3FE'><td  bgcolor = '#f2f2f2' style='height:300px;' colspan = 5 align = 'center' valign = 'center'> 
		<br/>
		
		<font size='6' face = 'Arial' color = '#737373'>Currently there is no active virtual sensor! <br/>
		Click to create a virtual sensor.</font></td></tr>";
	}
	?>



<?php




echo "  
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'> </script>  
<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
";





// connect to the database
$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
$un = $_SESSION['username'];
$query = "SELECT * FROM User_requirements where  User_name = '" . $un . "'";

$result = mysqli_query($db, $query); //everything is stored here


$sensor_section = 1;


echo"
<script type='text/javascript' >
var all_data = [];
var sensor_data = [];
</script>";


if (mysqli_num_rows($result) > 0)
{
    while ($final_result = mysqli_fetch_assoc($result)) //fetch line by line
    
    {
    
    	$td_id2 = 'chart_div2_' . $sensor_section;
        $td_id1 = 'chart_div_' . $sensor_section;
        
        $fun1_name = 'drawLogScales'.$sensor_section;
        $fun2_name = 'drawChart'.$sensor_section;
        
        $url_sensor_data = 'latest_sensor_value.php?un='.$_SESSION['username'].'&st='.$final_result['Sensor_Type'];
    	
    	$st = $final_result['Sensor_Type'];
    	
    	$plan = $final_result['Plan'];
    	
    	if($plan == "Diamond")
    	{
    		$time_to_refresh = 1000; 
    	}
    	else if($plan == "Gold")
    	{
    		$time_to_refresh = 2000;
    	}
    	else
    	{
    		$time_to_refresh = 3000;
    	}
    	echo "
		<tr style='height:200px;'>
		<td id = $td_id2 align = 'center'> .. </td>
		<td id = $td_id1 colspan = 4 align = 'center'> ..</td>
		</tr>
 	 ";
 	 
 	 
 echo"

<script type='text/javascript' >

google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback($fun1_name);



all_data.push([
        [0, 0],    [1, 0],   [2, 0],  [3, 0],   [4, 0],  [5, 0],
        [6, 0],   [7, 0],  [8, 0],  [9, 0],  [10, 0], [11, 0],   [12, 0],  [13, 0],   [14, 0],  [15, 0],
        [16, 0],   [17, 0],  [18, 0],  [19, 0],  [20, 0] ,  [21, 0],   [22, 0],  [23, 0],   [24, 0],  [25, 0],
        [26, 0],   [27, 0],  [28, 0],  [29, 0], [30,0]]);

sensor_data.push(0);


function $fun1_name() {
	  
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', '$st');


		

		var i;
		for(i=0; i<29; i++)
		{
			all_data[$sensor_section-1][i][1] = all_data[$sensor_section-1][i+1][1];
		}
		
    		
    		
    		
    		 
    		 $.ajax({url: '$url_sensor_data', success: function(result){

      		sensor_data[$sensor_section-1] = parseInt(result);
    		}});
    		

		all_data[$sensor_section-1][29] = [30, sensor_data[$sensor_section-1]];
	
	
      data.addRows(all_data[$sensor_section-1]);



      var options = {
        hAxis: {
          title: 'Time',
          logScale: false
        },
        vAxis: {
          title: 'Value',
          logScale: true
        },
        colors: ['black']
      };

      var chart = new google.visualization.LineChart(document.getElementById('$td_id1'));
      chart.draw(data, options);
      
      setTimeout ($fun1_name,$time_to_refresh);
    }
    
    

      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback($fun2_name);

      function $fun2_name() {

		
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Sensor Data', sensor_data[$sensor_section-1]],
        ]);

        var options = {
          width: 400, height: 120,
          greenFrom: 0,
          greenTo: 1500,
          greenColor: '#52c354',
          redFrom: 5000, redTo: 6000,
          yellowFrom:3000, yellowTo: 5000,
          minorTicks: 5,
          max: 6000,
        };

        var chart = new google.visualization.Gauge(document.getElementById('$td_id2'));

        chart.draw(data, options);
      
       setTimeout ($fun2_name,$time_to_refresh);
       }
    </script>
    ";	 
 	 
 	 $sensor_section = $sensor_section + 1;
 	 
    }
}




?>





 	 
	</table>


</td>


</tr>
</table>

<div class ="footer">Sensor Cloud</div>


</body>


</html>
