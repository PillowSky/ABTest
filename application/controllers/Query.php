<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('stat');
	}

	public function index() {
		$this->output->set_json($this->stat->get());
	}
}
