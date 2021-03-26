<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
	var $table = 'tbl_performance';

	public function posisi_today()
	{
		$query = "SELECT tgl_data, SUM(ospokok) as ospokok, SUM(plafond) as plafond, SUM(CASE WHEN kol_cif = 2 THEN ospokok END) as kol2, SUM(CASE WHEN kol_cif > 2 THEN ospokok END) as npf FROM tbl_performance WHERE tgl_data = (SELECT MAX(tgl_data) FROM tbl_performance)";

		$result = $this->db->query($query)->row_array();
		return $result;
	}

	public function posisi()
	{
		$query = "SELECT * FROM (SELECT tgl_data, sum(ospokok) as outstanding, sum(case when tgl_cair = tgl_data then plafond else 0 end) as plafond FROM " . $this->table . " WHERE tgl_data != '0000-00-00' GROUP BY tgl_data ORDER BY tgl_data DESC LIMIT 12) AS t1 ORDER BY tgl_data ASC";

		$result = $this->db->query($query)->result_array();
		return $result;
	}

	public function posisi_kol($cond)
	{
		$query = "SELECT tgl_data, kol_flag, sum(ospokok) as ospokok FROM " . $this->table . " where kol_flag = '" . $cond . "' and tgl_data = (SELECT MAX(tgl_data) FROM " . $this->table . ")";

		$result = $this->db->query($query)->row_array();
		return $result;
	}
}
