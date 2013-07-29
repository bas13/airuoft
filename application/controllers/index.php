<?php

/**
 * Index controller for main/first page
 */
class Index extends CI_Controller {

	/**
	 * Inherit construct from CI_Controller
	 */
	function __construct() {
		parent::__construct();
		// Load libraries
		$this->load->library('session');
		// Start session
		session_start();
	}

	/**
	 * Index/main function for Index controller
	 */
	function index() {
		// Load libraries and helpers
		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');

		// Set main body of template to main view
		$data['main'] = 'main/main_view';
		// Load template as a view
		$this->load->view('main/template', $data);
	}
}
?>