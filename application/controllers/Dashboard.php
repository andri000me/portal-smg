<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_dashboard', 'm_dash');

		if (!isset($_SESSION['is_login'])) {
			redirect(site_url('logout'));
		}
	}

	public function index()
	{
		$this->load->view('v_dashboard');
	}

	public function get_posisi()
	{
		$labels = array();
		$outstanding = array();
		$plafond = array();

		$result = $this->m_dash->posisi();
		foreach ($result as $res) {
			array_push($labels, tgl_indo($res['tgl_data']));
			array_push($outstanding, $res['outstanding']);
			array_push($plafond, $res['plafond']);
		}

		$chart = array(
			array(
				'name' => 'Outstanding',
				'type' => 'column',
				'data' => $outstanding
			),
			array(
				'name' => 'Realisasi Pencairan',
				'type' => 'line',
				'data' => $plafond
			)
		);

		$posisi = $this->m_dash->posisi_today();
		$info = array(
			'tgl_data' => tgl_indo($posisi['tgl_data']),
			'ospokok' => number_format($posisi['ospokok'] / 1000000000, 2),
			'plafond' => number_format($posisi['plafond'] / 1000000000, 2),
			'kol2' => number_format($posisi['kol2'] / 1000000000, 2),
			'npf' => number_format($posisi['npf'] / 1000000000, 2)
		);

		// echo json_encode(['data' => $chart, 'labels' => $labels]);
		echo json_encode(['data' => $chart, 'labels' => $labels, 'posisi' => $info]);
		exit;
	}
}
