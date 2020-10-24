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
</style>	



</head>

<body bgcolor="#232f3e" cellpadding=5 >
<div align = "center" style = "background-color: #232f3e;"><font style="font-size: 40px; color: #FF9D00">View Map</font></div>

<table width="100%"  bgcolor="#ffffff">
<tr><td colspan = 2 bgcolor = "#ffffff"></br></td></tr>
<tr>


<td bgcolor="#ffffff" width = 10% valign="top" style = "padding-left : 5px;">
<br/><br/><br/>
<font style="color: #ec7211">Sensor Cloud Dashboard (Owner)</font>
<br/>
<br/>

    <!-- logged in owner information -->
    <?php  if (isset($_SESSION['ownername'])) : ?>
    	Welcome <strong><?php echo $_SESSION['ownername']; ?></strong>
    	<br/>
    	<a href="dashboard_owner.php?logout='1'">Sign out</a>
    <?php endif ?>




</td>



<td  align = "center" style = "border-style: groove; border-color : #000000;">


    <img style = "cursor : crosshair; "src="map_new.png" alt="IIT Kharagpur Map" ismap></img>

 </td></tr>


<tr>
<td></td>
<td bgcolor="#ffffff" align = "center"> Image Source: http://www1.iitkgp.ac.in/map/ <br/> </td> </tr></table>
<table width="100%" border=0 bgcolor="#ffffff">
<tr bgcolor = "#f2f2f2" valign = "top">

<td bgcolor = "#ffffff" width = "12%"></td>
<td>
<font face = "Arial" size ="3">
1    Administrative Offices<br/>1    Main Building<br/>2    Mathematics<br/>3    Electrical Engg.<br/>4    Physics<br/>5    Chemistry<br/>6    Netaji Auditorium<br/>7    Syndicate Bank<br/>7    Rubber Technology<br/>8    Humanities & Social Sc.<br/>9    Geology/Geophysics<br/>10    RCG Infra. Design<br/>10    School of Water Res.<br/>11    Arch.& Planning<br/>12    Biotechnology<br/>13    Cryogenic Eng.<br/>14    Industrial Eng.<br/>15    ERP<br/>16    Civil Engg.<br/>17    Mechanical Eng.<br/>18    Vinod Gupta School<br/>19    Chemical Engg<br/>20   Hijli Shaheed Bhavan<br/>20   Nehru Museum<br/>20   Reliability Engg<br/>20   Theoritical Studies<br/>
</font>
</td>





<td>
<font face = "Arial">
21   Hanger<br/>22   Workshops<br/>23   Science Block<br/>24   Materials Science<br/>25   Ocean Eng./ Naval<br/>26   Aerospace Eng.<br/>27   CRF<br/>28    KC Space Tech<br/>29    Metallurgical Eng.<br/>30    Steel Tech.Centre<br/>31    ATDC<br/>31    CORAL<br/>31    CWISS<br/>32    Telecom Centre<br/>33    Mining Eng.<br/>34    Water Works Sec.<br/>35    Electronics & ECE<br/>36    Central Library<br/>37    Post Office<br/>38    State Bank<br/>39    Rly Booking<br/>40    Tagore OAT<br/> 41    Computer Sc. Eng.<br/>42    Gargi Auditorium<br/>42    Kalidas Auditorium<br/>
</font>
</td>


<td>
</font face = "Arial">
42    Maitree Auditorium<br/>42    Vikramshila<br/>43    SMST<br/>44    RG Law School<br/>45   JCB Lab Complex<br/>46   Computer and Info.<br/>46   Education Tech<br/>46   Information Tech.<br/>46   G S Sanyal School<br/>46   Takshila<br/>47   Agri. & Food Eng.<br/>48   Nalanda Complex<br/>49   Central Stores<br/>50   Cen. Rly. Research<br/>51   Rural Develop.<br/>52    RMSEE<br/>52    STEP<br/>53    R P Hall<br/>54    B C Roy Hall<br/>55    A M Hall<br/>56    Gokhale Hall<br/>57    Billoo's<br/>58    R K Hall<br/>59    MS Hall<br/>60    V S Hall<br/>
</font>
</td>


<td>
<font face = "Arial">

61    L L R Hall<br/>62 H B Hall<br/>63 JCBHall<br/>64 MMM Hall<br/>65 L B S Hall<br/>66 Patel Hall<br/>67 Nehru Hall<br/>68 Azad Hall<br/>69 Krishna Travels<br/>70 Z H Hall<br/>71 B R A Hall<br/>72 NCC<br/>73 Swimming Pool<br/>74 Lake<br/>75 Gymkhana<br/>75 Axis Bank ATM<br/>76 Jnan Ghosh Stadium<br/>77 Vegeis<br/>78 CCD<br/>78 Heritage<br/>78 Saraj Travels<br/>79 HMC Office<br/>80 R L B Hall<br/>81 Police Out Post<br/>82 IG-SN-MT Halls<br/>
</font>
</td>

<td>
<font face = "Arial">
83 S Nivedita Hall<br/>84 Tech.Guest House<br/>85 Technology Club<br/>86 Director's Bunglow<br/>87 Hospital<br/>88 Kazi Nazrul Manch<br/>89 Staff Club<br/>90 SBI ATM<br/>90 Tech.Market<br/>90 PNB<br/>91 Hijli Tel. Exchange<br/>92 D AV Model School<br/>93 St.Agnes Shoo!<br/>94 Hijli High School<br/>95 Kendriya Vidyalaya<br/>96 Petrol Pump<br/>97 Dreamland<br/>98 Sahara<br/>99 V Guest House<br/>100 SBI ATM<br/>100 Tikka<br/>101 Tata Sports Complex<br/>102 VSRC<br/>103 Helipads<br/>104 BCR Medical Inst.

</font>
</td>


</tr>
</table>
</br>
</body>
</html>
