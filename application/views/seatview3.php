<html>
<head>
<title>Pick Your Seat</title>
<style type="text/css">
	.seats {background-color:rgb(255, 255, 255)}
</style>
<script src="http://code.jquery.com/jquery-1.10.1.min.js">


if($("#seat1").css('color')=="rgb(255, 255, 255)") {
	
}
/*function selectSeat() {
	var s1 = document.getElementById("seat1");
	var s2 = document.getElementById("seat2");
	var s3 = document.getElementById("seat3");

	
	
	//s1.style.backgroundColor="#FFFFFF";
	//var css = document.defaultView.getComputedStyle(sl,null).getPropertyValue("background-color");
	var css = window.getComputedStyle(sl).backgroundColor;

	alert(css);
	document.getElementById("test").innerHTML=css;
	/*if (s1.style.backgroundColor=="rgb(255, 255, 255)") {
		s1.style.backgroundColor="green";
	}

	if (s2.style.backgroundColor == "rgb(255, 255, 255)") {
		s2.style.backgroundColor = "green";
	}

	if (s3.style.backgroundColor == "rgb(255, 255, 255)") {
		s3.style.backgroundColor = "green";
	}
}*/


</script>
</head>
<body>
<div id="planeseat" >
	<input type="button" id="seat1" class="seats" onclick="selectSeat()"/> 
	<input type="button" id="seat2" class="seats" onclick="selectSeat()"/> 
	<input type="button" id="seat3" class="seats" onclick="selectSeat()"/>
	<p id="test">hi</p>
</div>
</body>
</html>
<?php
if(isset($errno)) {
	echo "<p>DB Error:  ($errno) $errmsg</p>";
}

foreach ($seats as $seat) {
	switch($seat->seat) {
		case 1:
			echo "<style>" . "#seat1 {background-color:yellow}" . "</style>";
			break; 
		case 2:
			echo "<style>" . "#seat2 {background-color:yellow}" . "</style>";
			break;
		case 3:
			echo "<style>" . "#seat3 {background-color:yellow}"  . "</style";
			break;
	}
}
//class="<?= $seat3 "
?>