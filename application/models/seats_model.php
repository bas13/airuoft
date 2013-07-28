<?php
class Seats_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function getSeats($id) {
		$query =  $this->db->query("select ticket.seat from ticket, flight WHERE
				 ticket.flight_id=$id AND flight.id=$id;");
		return $query;
	}
	
}
?>