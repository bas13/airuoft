<h3>Purchase Summary</h3> 
<?php
    echo "seat " . $_POST['seatnumber'];
    echo "seatNumber " . $this->input->post('seatnumber');
    echo "flight " . $_SESSION['flight_id'];
	if (isset($errno) || isset($dberror)) {
	    echo "<p>DB ERROR</p>";

	    if(isset($errno)) {
	    	echo "<p>Error $errno, $errmsg</p>";
	    }
		
	} else {
		if (isset($from) && isset($to) && isset($date) && isset($time) &&
	            isset($firstname) &&
				isset($lastname) &&
				isset($creditcard) &&
				isset($expirationdate) &&
				isset($seat)) {
			
			echo "<h4>First Name: " . $firstname . "</h4>";
			echo "<h4>Last Name: " . $lastname . "</h4>";
			echo "<h4>Credit card number : " . $creditcard . "</h4>";
			echo "<h4>From: " . $from . "</h4>";
			echo "<h4>To: " . $to . "</h4>";
			echo "<h4>Date: " . $date . "</h4>";
			echo "<h4>Time: " . $time . "</h4>";
			echo "<h4>Seat: " . $seat . "</h4>";
			echo "<h4>Cost: $20</h4>";
		}
	}

?>

<button type="button" onclick="window.print();" >Print Page</button>
