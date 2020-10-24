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
