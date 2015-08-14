<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function index() {
		if (is_cli()) {
			$directory = dir("/var/www/simple/");
			$sql = 'INSERT INTO `record`(`ID`) VALUES (?)';

			while (($filename = $directory->read()) !== FALSE) {
				$ID = substr($filename, 0, strrpos($filename, '_'));
				if ($ID) {
					$this->db->query($sql, $ID);
					echo($ID . "\n");
				}
			}
			$directory->close();
		}
	}
}
