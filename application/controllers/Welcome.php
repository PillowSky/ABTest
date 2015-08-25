<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->model('record');
	}

	public function index() {
		$ID = $this->input->post('ID');
		$choice = $this->input->post('choice');
		$designer = $this->input->cookie('designer');

		if ($ID && $choice) {
			if ($choice === 'delete') {
				$this->record->delete($ID);
			} else {
				$this->record->vote($ID, $choice, $designer);			
			}
		}

		$ID = $this->input->get('ID');
		if (!$ID) {
			$ID = $this->record->random()->ID;
		}

		$order = array('simple', 'fusion');
		shuffle($order);

		$data = array(
			'ID' => $ID,
			'case' => array(
				array(
					'ID' => $ID,
					'file' => "{$order[0]}/{$ID}_{$order[0]}.jpg",
					'type' => $order[0],
					'text' => '左边的好'
				),
				array(
					'ID' => $ID,
					'file' => "{$order[1]}/{$ID}_{$order[1]}.jpg",
					'type' => $order[1],
					'text' => '右边的好'
				)
			)
		);

		$this->parser->parse('welcome.html', $data);
	}
}
