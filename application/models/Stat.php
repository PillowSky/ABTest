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
					COUNT(CASE WHEN `simple` > `fusion` THEN TRUE ELSE NULL END) AS `UserSimpleCase`,
					COUNT(CASE WHEN `simple` < `fusion` THEN TRUE ELSE NULL END) AS `UserFusionCase`,
					COUNT(CASE WHEN `simple` = `fusion` THEN TRUE ELSE NULL END) AS `UserEqualCase`,
					COUNT(CASE WHEN `simple_d` > `fusion_d` THEN TRUE ELSE NULL END) AS `DesignerSimpleCase`,
					COUNT(CASE WHEN `simple_d` < `fusion_d` THEN TRUE ELSE NULL END) AS `DesignerFusionCase`,
					COUNT(CASE WHEN `simple_d` = `fusion_d` THEN TRUE ELSE NULL END) AS `DesignerEqualCase`,
					(SUM(`simple`) + SUM(`fusion`) + SUM(`equal`) + SUM(`simple_d`) + SUM(`fusion_d`) + SUM(`equal_d`)) AS `TotalTest`,
					(SUM(`simple`) + SUM(`fusion`) + SUM(`equal`)) AS `UserTest`,
					SUM(`simple`) AS `UserSimpleTest`,
					SUM(`fusion`) AS `UserFusionTest`,
					SUM(`equal`) AS `UserEqualTest`,
					(SUM(`simple_d`) + SUM(`fusion_d`) + SUM(`equal_d`)) AS `DesignerTest`,
					SUM(`simple_d`) AS `DesignerSimpleTest`,
					SUM(`fusion_d`) AS `DesignerFusionTest`,
					SUM(`equal_d`) AS `DesignerEqualTest`
				FROM `record`';

		return $this->db->query($sql)->row();
	}
}
