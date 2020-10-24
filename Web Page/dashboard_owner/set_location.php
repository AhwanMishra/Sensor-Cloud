<!doctype html>
<html>

<head>
	<title>Set Location</title>
	
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
</script>  

<script>
$(document).ready(function() {
  $('img').click(function(e) {
    var offset = $(this).offset();
    var x = e.pageX - offset.left;
    var y = e.pageY - offset.top;
    alert("Location : IIT Kharagpur\n"+"X : " + parseInt(x) + "\nY : " + parseInt(y) ); //to keep it decimals only
    
    var x1 = window.opener.document.getElementById("x");
    x1.value = parseInt(x);
    var y1 = window.opener.document.getElementById("y");
    y1.value =  parseInt(y);
    window.close();
    
  });
});
</script>
</head>

<body bgcolor="#232f3e" cellpadding=5 >
<div align = "center" style = "background-color: #232f3e;"><font style="font-size: 40px; color: #FF9D00">Set Location</font></div>

<table width="100%"  bgcolor="#ffffff">
<tr><td colspan = 2 bgcolor = "#ffffff"></br></td></tr>
<tr>





<td  align = "center" style = "border-style: dotted; border-color : #000000;">

<a href="#">
    <img style = "cursor : crosshair; "src="mapnewfinal.jpg" alt="IIT Kharagpur Map" ismap></img>
</a>

 </td></tr>


<tr>
<td bgcolor="#ffffff" align = "center"> Image Source: Google Earth <br/> </td> </tr></table>
<br/>
</br>
</body>
</html>
