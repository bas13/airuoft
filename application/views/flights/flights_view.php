
<?php

if(isset($errno)) {
	echo "<p>DB Error:  ($errno) $errmsg</p>";
}

echo "<h3>" . $title . "</h3>";
echo "<table>";
echo "<tr><th>Name</th><th>Time</th><th>Availability</th></tr>";

foreach ($flights as $flight) {
	echo "<tr>";
	//echo "<td>" . $flight->id . "</td>";
	echo "<td>" . $flight->name . "</td>";
	echo "<td>" . $flight->time . "</td>";
	echo "<td>" . $flight->available . "</td>";
	//echo "<td>" . anchor("seats/getseats/$flight->id",'Pick Seats') . "</td>";
	echo form_open('seats_controller');
	echo form_hidden('fid',$flight->id);
	echo "<td>" . form_submit('something',"Pick Seats") . "</td>";
	echo form_close();
	//echo "<td>" . anchor("seats",'Pick Seats') . "</td>";
	echo "</tr>";
	
}
echo "</table>";
?>