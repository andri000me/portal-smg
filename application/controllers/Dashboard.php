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
		$qry_posisi = "SELECT tgl_data, sum(ospokok) as outstanding, sum(case when tgl_cair = tgl_data then plafond else 0 end) as plafond FROM `tbl_performance` GROUP BY tgl_data";

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

		$this->load->view('v_dashboard', $data);
	}
}
