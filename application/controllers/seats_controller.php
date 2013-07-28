<?php
class Seats_controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		session_start();
	}

	public function index() {
		$this->load->helper('url');
		if ($this->input->post('fid')) {
			$_SESSION['flight_id'] = $this->input->post('fid');
			$flight_id = $_SESSION['flight_id'];
			unset($_POST['fid']);
			$seats = $this->getSeats($flight_id);
			$data['seat1'] = "white";
			$data['seat2'] = "white";
			$data['seat3'] = "white";

			foreach($seats as $seat) {
				if ($seat==1) {
					$data['seat1'] = "yellow";
				} else if($seat==2) {
					$data['seat2'] = "yellow";
				} else if($seat==3) {
					$data['seat3'] = "yellow";
				}
			}

			$data['main'] = 'seats/seats_view';
			$this->load->view('main/template',$data);
		}
	}

	public function getSeats($fid) {
		$this->load->helper('url');
		$this->load->model('seats_model');
		$seats = $this->seats_model->getSeats($fid);
		$seat_array = array();

		foreach ($seats->result() as $seat) {
			$seat_array[] = $seat->seat;
			var_dump($seat->seat);
		}

		return $seat_array;
	}

	public function seatCheck($seatnumber) {
		//var_dump($this->input->post('seatnumber'));
		echo $seatnumber;
		if (intval($seatnumber) == 1 || intval($seatnumber) == 2 || intval($seatnumber) == 3) {
			return true;
		} else {
			return false;
		}

	}

	public function selectseats() {
        echo "hello1";
		if ($this->form_validation->run('seatValidation') == FALSE) {
			echo "hello2";
			if (isset($_SESSION['flight_id'])) {
				echo "hello3";
				$flight_id = $_SESSION['flight_id'];
				$seats = $this->getSeats($flight_id);
				
				$data['seat1'] = "white";
				$data['seat2'] = "white";
				$data['seat3'] = "white";
				
				foreach($seats as $seat) {
					if ($seat==1) {
						$data['seat1'] = "yellow";
					} else if($seat==2) {
						$data['seat2'] = "yellow";
					} else if($seat==3) {
						$data['seat3'] = "yellow";
					}
				}
				echo "hello4";
			}
            $data['seatChose'] = true;
			$data['main'] = 'seats/seats_view';
			
		} else {
			echo "hello5";
			$data['main'] = 'customerinfo/customerinfo_view';
		}
		echo "hello6>";

		$this->load->view('main/template', $data);
	}

}
?>