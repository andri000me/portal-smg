<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Performance extends CI_Controller
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
		$data['title'] = 'Daily Performance';

		$this->load->view('v_performance', $data);
	}

	public function list_nasional()
	{
		$tgl_awal = parse_tgl(input('tgl_awal'));
		$tgl_akhir = parse_tgl(input('tgl_akhir'));

		$query_awal = "SELECT tgl_data, sektor, sum(ospokok) as ospokok, sum(case when kol_cif = 1 then ospokok else 0 end) as kol1, sum(case when kol_cif = 2 then ospokok else 0 end) as kol2, sum(case when kol_cif > 2 then ospokok else 0 end) as npf FROM tbl_performance WHERE tgl_data = '{$tgl_awal}' GROUP BY sektor";
		$query_akhir = "SELECT tgl_data, sektor, sum(ospokok) as ospokok, sum(case when kol_cif = 1 then ospokok else 0 end) as kol1, sum(case when kol_cif = 2 then ospokok else 0 end) as kol2, sum(case when kol_cif > 2 then ospokok else 0 end) as npf FROM tbl_performance WHERE tgl_data = '{$tgl_akhir}' GROUP BY sektor";

		$result_awal = $this->db->query($query_awal)->result_array();
		$result_akhir = $this->db->query($query_akhir)->result_array();

		$dt_total = array();
		$dt_delta = array();
		$dt_tgl_awal = array();
		$dt_tgl_akhir = array();

		if (count($result_awal) > 0 && count($result_akhir) > 0) {
			$dt_total[] = 'Total';
			$dt_total[] = arr_sum($result_awal, 'ospokok') / 1000000000;
			$dt_total[] = arr_sum($result_awal, 'kol1') / 1000000000;
			$dt_total[] = (arr_sum($result_awal, 'kol1') / arr_sum($result_awal, 'ospokok')) * 100;
			$dt_total[] = arr_sum($result_awal, 'kol2') / 1000000000;
			$dt_total[] = (arr_sum($result_awal, 'kol2') / arr_sum($result_awal, 'ospokok')) * 100;
			$dt_total[] = arr_sum($result_awal, 'npf') / 1000000000;
			$dt_total[] = (arr_sum($result_awal, 'npf') / arr_sum($result_awal, 'ospokok')) * 100;

			$dt_total[] = arr_sum($result_akhir, 'ospokok') / 1000000000;
			$dt_total[] = arr_sum($result_akhir, 'kol1') / 1000000000;
			$dt_total[] = (arr_sum($result_akhir, 'kol1') / arr_sum($result_akhir, 'ospokok')) * 100;
			$dt_total[] = arr_sum($result_akhir, 'kol2') / 1000000000;
			$dt_total[] = (arr_sum($result_akhir, 'kol2') / arr_sum($result_akhir, 'ospokok')) * 100;
			$dt_total[] = arr_sum($result_akhir, 'npf') / 1000000000;
			$dt_total[] = (arr_sum($result_akhir, 'npf') / arr_sum($result_akhir, 'ospokok')) * 100;

			$dt_total[] = (arr_sum($result_akhir, 'ospokok') - arr_sum($result_awal, 'ospokok')) / 1000000000;
			$dt_total[] = (arr_sum($result_akhir, 'kol1') - arr_sum($result_awal, 'kol1')) / 1000000000;
			$dt_total[] = ((arr_sum($result_akhir, 'kol1') / arr_sum($result_akhir, 'ospokok')) - (arr_sum($result_awal, 'kol1') / arr_sum($result_awal, 'ospokok'))) * 100;
			$dt_total[] = (arr_sum($result_akhir, 'kol2') - arr_sum($result_awal, 'kol2')) / 1000000000;
			$dt_total[] = ((arr_sum($result_akhir, 'kol2') / arr_sum($result_akhir, 'ospokok')) - (arr_sum($result_awal, 'kol2') / arr_sum($result_awal, 'ospokok'))) * 100;
			$dt_total[] = (arr_sum($result_akhir, 'npf') - arr_sum($result_awal, 'npf')) / 1000000000;
			$dt_total[] = ((arr_sum($result_akhir, 'npf') / arr_sum($result_akhir, 'ospokok')) - (arr_sum($result_awal, 'npf') / arr_sum($result_awal, 'ospokok'))) * 100;

			foreach ($result_awal as $res) {
				$row = array();

				$row[] = $res['tgl_data'];
				$row[] = $res['sektor'];
				$row[] = $res['ospokok'] / 1000000000;
				$row[] = $res['kol1'] / 1000000000;
				$row[] = ($res['kol1'] / $res['ospokok']) * 100;
				$row[] = $res['kol2'] / 1000000000;
				$row[] = ($res['kol2'] / $res['ospokok']) * 100;
				$row[] = $res['npf'] / 1000000000;
				$row[] = ($res['npf'] / $res['ospokok']) * 100;

				$dt_tgl_awal[] = $row;
			}

			foreach ($result_akhir as $res) {
				$row = array();

				$row[] = $res['tgl_data'];
				$row[] = $res['sektor'];
				$row[] = $res['ospokok'] / 1000000000;
				$row[] = $res['kol1'] / 1000000000;
				$row[] = ($res['kol1'] / $res['ospokok']) * 100;
				$row[] = $res['kol2'] / 1000000000;
				$row[] = ($res['kol2'] / $res['ospokok']) * 100;
				$row[] = $res['npf'] / 1000000000;
				$row[] = ($res['npf'] / $res['ospokok']) * 100;

				$dt_tgl_akhir[] = $row;
			}

			for ($i = 0; $i < 2; $i++) {
				$row = array();
				for ($n = 2; $n <= 8; $n++) {
					$row[] = $dt_tgl_akhir[$i][$n] - $dt_tgl_awal[$i][$n];
				}
				$dt_delta[] = $row;
			}

			$result = array(
				'dt_tgl_awal' => $dt_tgl_awal,
				'dt_tgl_akhir' => $dt_tgl_akhir,
				'delta' => $dt_delta,
				'total' => $dt_total
			);

			echo json_encode(['status' => true, 'data' => $result]);
			exit;
		} else {
			echo json_encode(['status' => false, 'msg' => 'Data pada tanggal ' . input('tgl_awal') . ' atau ' . input('tgl_akhir') . ' tidak tersedia, silahkan pilih tanggal data yang tersedia']);
			exit;
		}
	}
}
