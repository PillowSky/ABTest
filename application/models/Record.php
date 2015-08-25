<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Record extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function random() {
		$sql = 'SELECT * FROM `record` ORDER BY RAND() LIMIT 1';
		return $this->db->query($sql)->row();
	}

	public function vote($ID, $choice, $designer = FALSE) {
		if ($designer) {
			$sql = "UPDATE `record` SET `{$choice}_d` = `{$choice}_d` + 1 WHERE `ID` = ?";
			return $this->db->query($sql, $ID);
		} else {
			$sql = "UPDATE `record` SET `{$choice}` = `{$choice}` + 1 WHERE `ID` = ?";
			return $this->db->query($sql, $ID);		
		}
	}

	public function delete($ID) {
		$sql = "DELETE FROM `record` WHERE `ID` = ?";
		$this->db->query($sql, $ID);
		unlink("simple/{$ID}_simple.png");
		unlink("fusion/{$ID}_fusion.png");
	}
}
