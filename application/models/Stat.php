<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get() {
		$sql = 'SELECT
					COUNT(*) AS `TotalCase`,
					(SUM(`simple`) + SUM(`fusion`) + SUM(`equal`) + SUM(`simple_d`) + SUM(`fusion_d`) + SUM(`equal_d`)) AS `TotalTest`,
					COUNT(CASE WHEN `simple` > `fusion` THEN TRUE ELSE NULL END) AS `UserSimpleCount`,
					COUNT(CASE WHEN `simple` < `fusion` THEN TRUE ELSE NULL END) AS `UserFusionCount`,
					COUNT(CASE WHEN `simple` = `fusion` THEN TRUE ELSE NULL END) AS `UserEqualCount`,
					COUNT(CASE WHEN `simple_d` > `fusion_d` THEN TRUE ELSE NULL END) AS `DesignerSimpleCount`,
					COUNT(CASE WHEN `simple_d` < `fusion_d` THEN TRUE ELSE NULL END) AS `DesignerFusionCount`,
					COUNT(CASE WHEN `simple_d` = `fusion_d` THEN TRUE ELSE NULL END) AS `DesignerEqualCount`,
					SUM(`simple`) AS `UserSimpleSum`,
					SUM(`fusion`) AS `UserFusionSum`,
					SUM(`equal`) AS `UserEqualSum`,
					SUM(`simple_d`) AS `DesignerSimpleSum`,
					SUM(`fusion_d`) AS `DesignerFusionSum`,
					SUM(`equal_d`) AS `DesignerEqualSum`
				FROM `record`';

		return $this->db->query($sql)->row();
	}
}
