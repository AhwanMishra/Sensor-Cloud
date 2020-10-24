<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
	$un = $_GET['un'];
	$st = $_GET['st'];

	
	//echo "Sensor data for ".$un." & ".$st." will be printed here soon."
	$query = "select state from User_requirements  where User_name = '".$un. "'and Sensor_Type = '".$st."'";
	$result = mysqli_query($db, $query);
	
	if($st == "AIR_POLLUTION")
	{
		$st = "ANALOG1";
	}

	
	if (mysqli_num_rows($result) > 0) 
	{
		while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
		{
			if($final_result['state'] == "active")
			{
				//$query = "select data from sensor_data where id =1";
				$query = "select ".$st." from latest_values where sl_no  = 1";
				//echo $query;
				$result = mysqli_query($db, $query);
				if (mysqli_num_rows($result) > 0) 
				{
					while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
					{
				
						#echo $final_result['data'];
						echo $final_result[$st];
					}
				}
			}
			else echo 0;
		}
	}
	
	$query = "UPDATE Price SET  total_price = total_price + 1 where username= '".$un. "'";
	$result = mysqli_query($db, $query);
	
?>
