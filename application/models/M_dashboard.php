<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
	var $table = 'tbl_performance';
	var $max_tgl = 'SELECT MAX(tgl_data) FROM tbl_performance';

	public function posisi_today()
	{
		$query = "SELECT tgl_data, SUM(ospokok) as ospokok, SUM(IF(tgl_cair = ($this->max_tgl), plafond, 0)) as plafond, SUM(IF(kol_cif = 2, ospokok, 0)) as kol2, SUM(IF(kol_cif > 2, ospokok, 0)) as npf FROM tbl_performance WHERE tgl_data = ($this->max_tgl)";

		$result = $this->db->query($query)->row_array();
		return $result;
	}

	public function posisi()
	{
		$query = "SELECT * FROM (SELECT tgl_data, SUM(ospokok) as outstanding, SUM(IF(tgl_cair = tgl_data, plafond, 0)) as plafond FROM $this->table WHERE tgl_data != '0000-00-00' GROUP BY tgl_data ORDER BY tgl_data DESC LIMIT 12) AS t1 ORDER BY tgl_data ASC";

		$result = $this->db->query($query)->result_array();
		return $result;
	}

	public function posisi_kol($cond)
	{
		$query = "SELECT tgl_data, kol_flag, SUM(ospokok) as ospokok FROM $this->table where kol_flag = $cond and tgl_data = ($this->max_tgl)";

		$result = $this->db->query($query)->row_array();
		return $result;
	}
}
