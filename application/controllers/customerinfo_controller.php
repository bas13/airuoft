<?php

/**
 * Customerinfo controller
 */
class Customerinfo_controller extends CI_Controller {


	/**
	 * Inherit construct from CI_Controller
	 */
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		// Start Session
		session_start();
	}

	/**
	 * Index/main function for customerinfo controller
	 */
	public function index() {
		// Load helpers and libraries
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		// Set main body of template to customerinfo view
		$data['main'] = 'customerinfo/customerinfo_view';

		// Load the template
		$this->load->view('main/template', $data);
	}

	/**
	 * Register customer info while validating it before inputting it into
	 * the database
	 */
	function register() {
		// Load helpers and libraries
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		// Run form validation registerCustomerInfo
		if ($this->form_validation->run('registerCustomerInfo') == FALSE) {
			// Set main body of template to customerinfo view, redirect to same page
			$data['main'] = 'customerinfo/customerinfo_view';
		} else {
			// Check if flight_id and seat number set before entering customer info
			// into database
			if (isset($_SESSION['flight_id']) && isset($_SESSION['seat'])) {
				// Set local variables for flight_id and seat
				$flight_id = $_SESSION['flight_id'];
				$seat = $_SESSION['seat'];

				// Unset flight_id and seat session variables
				unset($_SESSION['flight_id']);
			    unset($_SESSION['seat']);

			    // Retrive customer info from form
				$data['firstname'] = $this->input->post('firstname');
				$data['lastname'] = $this->input->post('lastname');
				$data['creditcard'] = $this->input->post('creditcard');
				$data['expirationdate'] = $this->input->post('expirationdate');
				
				// Add ticket to database
				if ($this->addTicket($flight_id, $seat, $data['firstname'], $data['lastname'], $data['creditcard'], 
						substr($data['expirationdate'], 0, 2) . substr($data['expirationdate'], 3, 5))  == false) {
					// If problem with adding ticket set db error
					$data['dberror'] = true;
				}

				$resultarray = $this->getInfo($flight_id, $seat);
				
				if ($resultarray == false) {
					// If problem with getting info set db error
					$data['dberror'] = true;
				}

				// Set up customer info for summary page;
				$data['from'] = $resultarray[0];
				$data['to'] = $resultarray[1];
				$data['date'] = $resultarray[2];
				$data['time'] = $resultarray[3];
	            $data['firstname'] = $resultarray[4];
				$data['lastname'] = $resultarray[5];
				$data['creditcard'] = $resultarray[6];
				$data['expirationdate'] =  substr($resultarray[7], 0, 2) + "/" + substr($resultarray[7], 2, 4);
				$data['seat'] = $resultarray[8];

				// Check if any error variables were set from database for database transactions/modifications
				if (isset($_SESSION['errno'])) {
					// Set error message and error number from session
					$data['errmsg'] = $_SESSION['errmsg'];
					$data['errno'] = $_SESSION['errno'];
					 
					// Unset errmsg and errno session variables
					unset($_SESSION['errmsg']);
					unset($_SESSION['errno']);
				}
			}
			// Set main body of template to summary 
			$data['main'] = 'customerinfo/summary';
		}
        // Load the template as a view
		$this->load->view('main/template', $data);

	}

	/**
	 * Callback function for validation
	 * Given a credit card expiration date check if it is in the correct format
	 * and if it is expired or not, return true otherwise
	 * 
	 * @param Date $date
	 * @return boolean whether date if valid or not
	 */
	function expirationDateCheck($date) {
		$datetrim = trim($date);
		$month = substr($datetrim, 0, 2);
		$year = substr($datetrim, 3, 2);

		// Set message for expiration date for improper format
		$this->form_validation->set_message('expirationDateCheck',
				'Invalid expiration date format.');
		
		// Check proper frommating
		if (preg_match("/^[0-9]{2}\/[0-9]{2}$/", $datetrim) == 1
				&& intval($year) >= 0
				&& intval($month) > 0) {

			// Set message for expired date
			$this->form_validation->set_message('expirationDateCheck',
					'Credit card is expired.');

			if ($this->validDate($month, $year)) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Checks if given date is expired (before current date)
	 * @param string $month
	 * @param string $year
	 * @return boolean whether date is expired or not
	 */
	public function validDate($month, $year) {
		date_default_timezone_set('America/Toronto');
		if (intval($year) > intval(date('y'))) {
			return true;
		} else if (intval($year) == intval(date('y'))
				&& intval($month) >= intval(date('m'))) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Given customer info, add this info to the database
	 * 
	 * @param int $flight_id
	 * @param int $seat
	 * @param string $first
	 * @param string $last
	 * @param string $credit_card
	 * @param string $expiry
	 */
	public function addTicket($flight_id, $seat, $first, $last, $credit_card, $expiry) {
		// Load flight model
		$this->load->model('flight_model');
		
		// Call db model function to insert ticket given customer info
		return $this->flight_model->insert_ticket(intval($flight_id), intval($seat), 
				strval($first), strval($last), strval($credit_card), strval($expiry));
	}
	
	/**
	 * Return customer info that is stored from the database in an array otherwise
	 * return false
	 * 
	 * @param int $fid
	 * @param int $seat
	 * @return boolean| array of customer info
	 */
	public function getInfo($fid, $seat) {
		$this->load->model('flight_model');
		
		$inforesult = $this->flight_model->getInfoDB($fid, $seat);
		
		$infoarray = array();
		
		if ($inforesult->num_rows() > 0) {
			$row = $inforesult->row();
				$infoarray[] = $row->depart;
				$infoarray[] = $row->arrive;
				$infoarray[] = $row->date;
				$infoarray[] = $row->time;
				$infoarray[] = $row->first;
				$infoarray[] = $row->last;
				$infoarray[] = $row->creditcardnumber;
				$infoarray[] = $row->creditcardexpiration;
				$infoarray[] = $row->seat; 
		}
		else {
		   return false;	
		} 
		return $infoarray;
	}
}
?>
