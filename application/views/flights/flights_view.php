<?php
// If db error encountered print error message
if(isset($errno)) {
	echo "<p>DB Error:  ($errno) $errmsg</p>";
}

echo "<h3>" . $title . "</h3>";
echo "<table>";
echo "<tr><th>Name</th><th>Time</th><th>Availability</th></tr>";

// Goes through every flight record and prints out info of flight
foreach ($flights as $flight) {
	echo "<tr>";

	echo "<td>" . $flight->name . "</td>";
	echo "<td>" . $flight->time . "</td>";
	echo "<td>" . $flight->available . "</td>";

	echo form_open('seats_controller');
	echo form_hidden('fid',$flight->id);
	echo "<td>" . form_submit('something',"Pick Seats") . "</td>";
	echo form_close();

	echo "</tr>";
}
echo "</table>";
?>