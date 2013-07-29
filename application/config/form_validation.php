<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Form validation rules
$config = array(
		'registerCustomerInfo' => array(
				array(
						'field' => 'firstname',
						'label' => 'First Name',
						'rules' => 'required'
				),
				array(
						'field' => 'lastname',
						'label' => 'Last Name',
						'rules' => 'required'
				),
				array(
						'field' => 'creditcard',
						'label' => 'Credit Card Number',
						'rules' => 'required|exact_length[16]|numeric'
				),
				array(
						'field' => 'expirationdate',
						'label' => 'Credit Card Expiration Date',
						'rules' => 'required|callback_expirationDateCheck'
				)
		) ,
		'seatValidation' => array(
				array(
						'field' => 'seatnumber',
						'label' => 'Seat Selection',
						'rules' => 'callback_seatCheck'
				)
		)
);



