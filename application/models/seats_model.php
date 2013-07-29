<?php

/**
 * Seats model class
 */
class Seats_model extends CI_Model {
	
	/**
	 * Inherit contruct of CI_Model
	 */
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * Get the seat numbers of a given flight
	 * 
	 * @param int $id flight id
	 * @return query $query result of query
	 */
	function getSeats($id) {
		$query =  $this->db->query("select ticket.seat from ticket, flight WHERE
				 ticket.flight_id=$id AND flight.id=$id;");
		return $query;
	}
}
?>