<?php

/**
 * Seats controller class
 */
class Seats_controller extends CI_Controller {
	
	/**
	 * Inherit construct from CI_Controller
	 */
	function __construct() {
		parent::__construct();
		// Load libraries
		$this->load->library('session');
		$this->load->database();
		// Start session
		session_start();
	}

	/**
	 * Index/main function for seats controller, sets up seat colors to be displayed on view
	 * which will be modified by jquery functions
	 */
	public function index() {
		// Load helpers
		$this->load->helper('url');
		// Check if post var for fid is set
		if ($this->input->post('fid')) {
			// Set the session variable flight_id to the post variable fid
			$_SESSION['flight_id'] = $this->input->post('fid');
			// Set a local flight_id variable to the session variable
			$flight_id = $_SESSION['flight_id'];
			// Unset the post variable fid
			unset($_POST['fid']);
			// Get occupied for a given flight
			$seats = $this->getSeats($flight_id);
			// Preset all seats to white/unoccupied
			$data['seat1'] = "white";
			$data['seat2'] = "white";
			$data['seat3'] = "white";

			// Set all occupied seats to yellow
			foreach($seats as $seat) {
				if ($seat==1) {
					$data['seat1'] = "yellow";
				} else if($seat==2) {
					$data['seat2'] = "yellow";
				} else if($seat==3) {
					$data['seat3'] = "yellow";
				}
			}

			// Set main body of template to seats view
			$data['main'] = 'seats/seats_view';
			$this->load->view('main/template',$data);
		}
	}

	/**
	 * 
	 * @param int $fid flight id
	 * @return array, array of occupied seats
	 */
	public function getSeats($fid) {
		// Load helper and model
		$this->load->helper('url');
		$this->load->model('seats_model');
		// Run db model function getSeats to obtain occupied seats
		$seats = $this->seats_model->getSeats($fid);
		$seat_array = array();

		// Transfer db query result to array to be returned
		foreach ($seats->result() as $seat) {
			$seat_array[] = $seat->seat;
			var_dump($seat->seat);
		}
		return $seat_array;
	}

	/**
	 * Callback function used for validation
	 * Check if the user has selected a seat on a flight otherwise return false
	 * 
	 * @param int $seatnumber
	 * @return boolean whether a seat has been selected or not
	 */
	public function seatCheck($seatnumber) {
		echo $seatnumber;
		if (intval($seatnumber) == 1 || intval($seatnumber) == 2 || intval($seatnumber) == 3) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Runs a validation to check if the user has selected a seat and if so loads up the customerinfo view
	 * with seat and flight_id session variables set
	 */
	public function selectseats() {
        // Form validation to check whether user has selected a seat
		if ($this->form_validation->run('seatValidation') == FALSE) {
			// Check if flight_id session variable is set
			if (isset($_SESSION['flight_id'])) {

				// Set local flight_id to session variable
				$flight_id = $_SESSION['flight_id'];
				// Get occupied seats from database
				$seats = $this->getSeats($flight_id);

				// Preset all seats to white or unoccupied
				$data['seat1'] = "white";
				$data['seat2'] = "white";
				$data['seat3'] = "white";

				// Set all occupied seats to yellow
				foreach($seats as $seat) {
					if ($seat==1) {
						$data['seat1'] = "yellow";
					} else if($seat==2) {
						$data['seat2'] = "yellow";
					} else if($seat==3) {
						$data['seat3'] = "yellow";
					}
				}
			}
				
			// Set variable to know that user did not select a seat yet
			$data['seatChose'] = true;
			// Set seats view as main body for template
			$data['main'] = 'seats/seats_view';
				
		} else {
            // Check if seatnumber post variable is set
			if (isset($_POST['seatnumber'])) {
				// Set seat session variable to seatnumber post variable
				$_SESSION['seat'] = $this->input->post('seatnumber');
				// Unset the seatnumber post variable
				unset($_POST['seatnumber']);
			}
			// Set the main body for template to customerinfo view
			$data['main'] = 'customerinfo/customerinfo_view';
		}
        // Load the template as a view
		$this->load->view('main/template', $data);
	}
}
?>