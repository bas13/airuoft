<?php

/**
 * Flights controller class
 */
class Flights_controller extends CI_Controller {

	/**
	 * Inherit contruct of CI_Controller
	 */
	function __construct() {
		parent::__construct();
		// Load libraries
		$this->load->database();
		$this->load->library('session');
		// Start session
		session_start();
	}

	/**
	 * Index/main function of flights controller, validates campus selection and selected date
	 */
	public function index() {
		// Load helpers and libraires
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		// Set validation rules
		$this->form_validation->set_rules('date','Date','required|callback_validDate');
		$this->form_validation->set_rules('campus','Campus','required|preg_match("/[12]{1}/",$campus)==1');

		// Check if validation for campus and date is fine
		if($this->form_validation->run() == FALSE) {
			// Set message for form validation
			$this->form_validation->set_message('required','Validate form BITCH!!!');
			// Set main body for template to index view
			$data['main'] = 'index';
		} else {
			// Getting data from the view.
			$data['campus'] = $this->input->post('campus');
			$dates = $this->input->post('date');
			$data['date'] = $this->convertDate($dates);

			$this->load->model('flight_model');
			$flights = $this->flight_model->getFlights($data['campus'],$data['date']);

			// Set flights data to database result to pass to the view
			$data['flights'] = $flights;
			$data['title'] = 'Flights Available';
			// Set main body of template to flights_view
			$data['main'] = 'flights/flights_view.php';
		}
		// Load template as view
		$this->load->view('main/template',$data);
	}

	/**
	 * Given a date, convert it from human readable to database readable
	 * @param string $date
	 * @return string $date_res formatted date
	 */
	public function convertDate($date) {
		// Load helpers
		$this->load->helper('date');

		// Convert the date and pass the converted date to the model.
		$date = trim($date);
		$months = array('Jan'=>'01','Feb'=>'02','Mar'=>'03','Apr'=>'04','May'=>'05',
				'Jun'=>'06','Jul'=>'07','Aug'=>'08','Sep'=>'09','Oct'=>'10','Nov'=>'11','Dec'=>'12');
		$month = substr($date,4,3);
		$day = substr($date,8,2);
		$year = substr($date,11,4);
		$date_res = $year . "-" . $months[$month] . "-" . $day;
		return $date_res;
	}

	/**
	 * Callback function to assist in form validation of dates.
	 */
	public function validDate($date) {
		return preg_match("/^(Sun|Mon|Tue|Wed|Thu|Fri|Sat) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) (0[1-9]|[12][0-9]|3[01]) 2013$/",$date) == 1;
	}
}
?>