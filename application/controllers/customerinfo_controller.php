<?php

/*
 * To change this template, choose Tools | Templates
* and open the template in the editor.
*/

class Customerinfo_controller extends CI_Controller {


	//Do we need a constructor for start_session()?
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		session_start();
	}

	public function index() {
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('form_validation');

		$data['main'] = 'customerinfo/customerinfo_view';

		$this->load->view('main/template', $data);
	}

	function register() {
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		
		if ($this->form_validation->run('registerCustomerInfo') == FALSE) {
			$data['main'] = 'customerinfo/customerinfo_view';
		} else {
			echo "bam";
			echo "fid: " . $_SESSION['flight_id'];
			echo "seat" . $_SESSION['seat'];
			if (isset($_SESSION['flight_id']) && isset($_SESSION['seat'])) {
			 	echo "bam3";
				$flight_id = $_SESSION['flight_id'];
				$seat = $_SESSION['seat'];

				unset($_SESSION['flight_id']);
			    unset($_SESSION['seat']);

				$data['firstname'] = $this->input->post('firstname');
				$data['lastname'] = $this->input->post('lastname');
				$data['creditcard'] = $this->input->post('creditcard');
				$data['expirationdate'] = $this->input->post('expirationdate');
				echo "Bam4";
				// Add ticket to database
				if ($this->addTicket($flight_id, $seat, $data['firstname'], $data['lastname'], $data['creditcard'], substr($data['expirationdate'], 0, 2) . substr($data['expirationdate'], 3, 5))  == false) {
					$data['dberror'] = true;
					echo "db error: " . $data['dberror'];
				}
				echo "bam5";
				$resultarray = $this->getInfo($flight_id, $seat);
				echo "bam6";
				// Set up summary page;
				$data['from'] = $resultarray[0];
				$data['to'] = $resultarray[1];
				$data['date'] = $resultarray[2];
				$data['time'] = $resultarray[3];
	            $data['firstname'] = $resultarray[4];
				$data['lastname'] = $resultarray[5];
				$data['creditcard'] = $resultarray[6];
				$data['expirationdate'] =  substr($resultarray[7], 0, 2) + "/" + substr($resultarray[7], 2, 4);
				$data['seat'] = $resultarray[8];
				echo "bam7";

				if (isset($_SESSION['errno'])) {
					$data['errmsg'] = $_SESSION['errmsg'];
					$data['errno'] = $_SESSION['errno'];
					 
					unset($_SESSION['errmsg']);
					unset($_SESSION['errno']);
				}
			}
			$data['main'] = 'customerinfo/summary';
		}

		$this->load->view('main/template', $data);

	}

	function expirationDateCheck($date) {

		$datetrim = trim($date);
		$month = substr($datetrim, 0, 2);
		$year = substr($datetrim, 3, 2);

		$this->form_validation->set_message('expirationDateCheck',
				'Invalid expiration date format.');
		if (preg_match("/^[0-9]{2}\/[0-9]{2}$/", $datetrim) == 1
				&& intval($year) >= 0
				&& intval($month) > 0) {

			$this->form_validation->set_message('expirationDateCheck',
					'Credit card is expired.');

			if ($this->validDate($month, $year)) {
				return true;
			}
		}
		return false;
	}

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

	public function addTicket($flight_id, $seat, $first, $last, $credit_card, $expiry) {
		$this->load->model('flight_model');
		echo "baminticket"; 
		return $this->flight_model->insert_ticket(intval($flight_id), intval($seat), strval($first), strval($last), strval($credit_card), strval($expiry));
		echo "baminticketafter";
	}
	
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
