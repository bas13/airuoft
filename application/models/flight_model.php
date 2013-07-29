<?php

/**
 * Flight Model Class
 */
class Flight_model extends CI_Model {

	/**
	 * Inherit contruct of CI_Model
	 */
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Insert flight table values into the table flight for days from the current date
	 * till 14 days after
	 */
	function populate() {
		for ($i = 1; $i < 15; $i++) {
			for ($j = 1; $j < 9; $j++) {
				$this->db->query("insert into flight (timetable_id, date, available)
						values ($j,adddate(current_date(), interval $i day),3)");
			}
		}
	}

	/**
	 * Delete all records from the flight table
	 */
	function delete() {
		$this->db->query("delete from flight");
	}

	/**
	 * Get date, seat, firstname, lastname, credit card number, and credit card expiration date
	 * from the database
	 * 
	 * @return $query
	 */
	function get_tickets() {
		$query = $this->db->query(
				"select f.date, t.seat, t.first, t.last, t.creditcardnumber, t.creditcardexpiration
				from flight f, ticket t
				where f.id = t.flight_id");
		return $query;
	}

	/**
	 * Insert customer info, flight number and seat number into the tickets table
	 * 
	 * @param int $flight_id
	 * @param int $seat
	 * @param string $first
	 * @param string $last
	 * @param string $credit_card
	 * @param string $expiry
	 * @return boolean $result
	 */
	function insert_ticket($flight_id, $seat, $first, $last, $credit_card, $expiry) {
		$result = false;
		$seats_available = $this->db->query("select f.id, f.available
				from flight f
				where $flight_id = f.id and
				f.available > 0");

		// Check if there are seats available for a flight
		if ($seats_available->num_rows() > 0) {
			// Begin transaction
			$this->db->trans_begin();
			// Insert ticket into database
			$this->db->query("insert into ticket (first, last, creditcardnumber, creditcardexpiration, flight_id, seat)
					values ('$first', '$last', '$credit_card', '$expiry', '$flight_id', '$seat')");
			// Update seats available for particular flight by decrementing it
			$this->db->query("update flight set available = available - 1 where id = $flight_id");

			// Check if transaction was a success
			if ($this->db->trans_status() == FALSE) {
				// Set up error messages
				$_SESSION['errmsg'] = $this->db->_error_message();
				$_SESSION['errno'] = $this->db->_error_number();
				$this->db->trans_rollback();
			}
			else {
				// Transaction success so return true
				$this->db->trans_commit();
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * Retrieve info for flight(s) given a specific departure campus and flight date
	 * 
	 * @param int $c departure campus
	 * @param DATE $d flight date
	 * @return array $query->result()
	 */
	public function getFlights($c,$d) {
		$query = $this->db->query("SELECT f.id, c1.name, t.time, f.available FROM campus AS c1,
				campus AS c2, timetable AS t, flight AS f WHERE f.timetable_id = t.id AND
				t.leavingfrom = c1.id AND t.goingto = c2.id AND f.available > 0 AND
				f.date='$d' AND c1.id=$c;");

		return $query->result();
	}

	/**
	 * Retrieve customer info from the database
	 * 
	 * @param int $fid flight id
	 * @param int $seat seat number
	 * @return query $query result from query else return false if no result
	 */
	public function getInfoDB($fid, $seat) {
		$query = $this->db->query("SELECT c1.name as depart, c2.name as arrive, f.date as date, t.time as time, tick.first as first, tick.last as last, 
				tick.creditcardnumber as creditcardnumber, tick.creditcardexpiration as creditcardexpiration, tick.seat as seat 
				FROM flight AS f, timetable AS t, ticket as tick, campus as c1, campus as c2 
				WHERE t.leavingfrom = c1.id AND t.goingto = c2.id AND f.id = tick.flight_id AND t.id = f.timetable_id and f.id = $fid and tick.seat = $seat;");
		 
		if ($query->num_rows() > 0) {
			return $query;
		}
		return false;
	}
}
?>
