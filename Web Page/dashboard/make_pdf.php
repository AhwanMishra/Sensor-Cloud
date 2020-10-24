<?php 

require('fpdf/fpdf.php'); 



// connect to the database
$db = mysqli_connect('localhost', 'newuser', 'password', 'sensor_cloud');
$un = $_GET['un'];
$st = $_GET['st'];






$pdf = new FPDF(); 
$pdf->AddPage(); 
$pdf->SetFont('Times', 'B', 20); 


$temp1 = "Sensor Data for sensor : ".$st;

$pdf->Cell(176, 5, $temp1, 0, 0, 'C'); 

$pdf->Ln(); 

if($st == "AIR_POLLUTION")
{
	$st = "ANALOG1";
}


$pdf->SetFont('Times', 'B', 12); 
$temp2 = "Username : ".$un.",  periodical data is listed below";
$pdf->Cell(176, 10, $temp2, 0, 0, 'C'); 



$query = "select data from ".$st;
$result = mysqli_query($db, $query);
	

$string1 = "";
if (mysqli_num_rows($result) > 0) 
{
	while($final_result = mysqli_fetch_assoc($result))  //fetch line by line
	{
		//echo $final_result['data'];

		$string1 = $string1." ".$final_result['data'];
	}
}

$pdf->Ln();
$pdf->SetFont('Times', '', 10); 
$pdf->MultiCell(176, 10, $string1, 1); 


$pdf->Output(); 

?> 
