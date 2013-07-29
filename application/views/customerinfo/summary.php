<h3>Purchase Summary</h3> 
<?php
    // If error encountered print error
	if (isset($errno) || (isset($dberror) && $dberror == true)) {
	    echo "<p>DB ERROR</p>";

	    if(isset($errno)) {
	    	echo "<p>Error $errno, $errmsg</p>";
	    }
		
	} else {
		// Display summary of customer purchase
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
