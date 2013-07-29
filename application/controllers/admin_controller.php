<?php

/**
 * Admin controller class
 */
class Admin_controller extends CI_Controller {

	/**
	 * Inherit contruct of CI_Controller
	 */
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		// Start the session
		session_start();
	}

	/**
	 * Index/main function for controller that loads admin_view page
	 */
	function index() {
		// Set admin links as main body of admin_view
		$data['main'] = 'admin/adminlinks';
		$this->load->view('admin/admin_view', $data);
	}

	/**
	 * Populate the flight table with flight infos from the current day till
	 * 14 days after
	 */
	function populate() {
		// Load flight model
		$this->load->model('flight_model');
		// Call db model function to populate flights table
		$this->flight_model->populate();

		// Redirect to the index page
		redirect('', 'refresh');
	}

	/**
	 * Delete all records from the flight table
	 */
	function delete() {
		// Load flight model
		$this->load->model('flight_model');
		// Call db model function to delete all flights from table
		$this->flight_model->delete();

		// Redirect to the index page
		redirect('', 'refresh');
	}

	function showTickets() {
		// Load the library and flight model
		$this->load->library('table');
		$this->load->model('flight_model');

		// Call db model function to obtain all tickets from db
		$flights = $this->flight_model->get_tickets();

		// Check if there are tickets in the database
		if ($flights->num_rows() > 0) {
			// Set heading for table
			$this->table->set_heading('Flight Date', 'Seat Number', 'First Name',
					'Last Name', 'Credit Card Number', 'Expiration Date');

			// Add ticket info to table
			foreach ($flights->result() as $row) {
				if (strlen(strval($row->creditcardexpiration)) == 3) {
					$expiry_date_format = '0' . substr($row->creditcardexpiration, 0, 1) .
					'/' . substr($row->creditcardexpiration, 1, 3);
				}
				else {
					$expiry_date_format = substr($row->creditcardexpiration, 0, 2) .
					'/' . substr($row->creditcardexpiration, 2, 4);
				}
				$this->table->add_row($row->date, $row->seat, $row->first,
						$row->last, $row->creditcardnumber, $expiry_date_format);
			}

			// Set table to be passed into view
			$data['flights'] = $this->table;
		} else {
			$data['flights'] = null;
		}

		// Set main body of admin view to listTickets
		$data['main'] = 'admin/listTickets';
		// Load admin view
		$this->load->view('admin/admin_view', $data);
	}
}
?>
