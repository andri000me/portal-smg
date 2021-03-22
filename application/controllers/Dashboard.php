<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['is_login'])) {
			redirect(site_url('logout'));
		}
	}

	public function index()
	{
		$qry_posisi = "SELECT * FROM (SELECT tgl_data, sum(ospokok) as outstanding, sum(case when tgl_cair = tgl_data then plafond else 0 end) as plafond FROM `tbl_performance` WHERE tgl_data != '0000-00-00' GROUP BY tgl_data ORDER BY tgl_data DESC LIMIT 12) AS t1 ORDER BY tgl_data ASC";
		$kol2 = "SELECT tgl_data, kol_flag, sum(ospokok) as ospokok FROM tbl_performance where kol_flag = 2 and tgl_data = (SELECT MAX(tgl_data) FROM tbl_performance)";
		$npf = "SELECT tgl_data, kol_flag, sum(ospokok) as ospokok FROM tbl_performance where kol_flag = 'NPF' and tgl_data = (SELECT MAX(tgl_data) FROM tbl_performance)";

		$labels = array();
		$outstanding = array();
		$plafond = array();
		$nett = array();

		$result = $this->db->query($qry_posisi)->result_array();
		foreach ($result as $res) {
			array_push($labels, tgl_indo($res['tgl_data']));
			array_push($outstanding, $res['outstanding']);
			array_push($plafond, $res['plafond']);
		}

		$data['labels'] = json_encode($labels);
		$data['outstanding'] = json_encode($outstanding);
		$data['plafond'] = json_encode($plafond);

		$data['posisi'] = end($labels);
		$data['performance'] = end($outstanding);
		$data['pencairan'] = end($plafond);
		$data['kol2'] = $this->db->query($kol2)->row_array();
		$data['npf'] = $this->db->query($npf)->row_array();

		$this->load->view('v_dashboard', $data);
	}
}
