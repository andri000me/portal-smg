<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dbs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_dbs', 'dbs');

		if (!isset($_SESSION['is_login'])) {
			redirect(site_url('logout'));
		}
	}

	private function _validasi()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['error'] = array();
		$data['status'] = true;

		$post = array('tgl_data', 'module');

		foreach ($post as $post) {
			if (input($post) == '') {
				$data['inputerror'][] = $post;
				$data['error'][] = 'Bagian ini harus diisi';
				$data['status'] = false;
			}
		}

		if ($_FILES['file_upload']['name'] == '') {
			$data['inputerror'][] = 'file_upload';
			$data['error'][] = 'Bagian ini harus diisi';
			$data['status'] = false;
		}

		if ($data['status'] === false) {
			echo json_encode($data);
			exit();
		}
	}

	public function index()
	{
		$data['title'] = 'DBS Performance';

		$this->load->view('v_dbs', $data);
	}

	public function get_list()
	{
		$list = $this->dbs->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $dbs) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dbs['module'];
			$row[] = $dbs['file_name'];
			$row[] = tgl_indo($dbs['tgl_data']);
			$row[] = format_size($dbs['file_size']);
			$row[] = $dbs['upload_time'];

			$opsi = '<a class="btn btn-xs btn-warning" href="' . site_url('dbs/download/' . $dbs['id']) . '" title="Download"><i class="fa fa-download"></i></a>';
			if ($_SESSION['lv_user'] == 'admin') {
				if ($dbs['update_posisi'] == 0) {
					$opsi .= '<span class="btn btn-xs btn-success" onclick="update_posisi(\'' . $dbs['id'] . '\')" title="Sync"><i class="fa fa-sync-alt"></i></span>';
				}
				$opsi .= '<span class="btn btn-xs btn-danger" onclick="hapus_file(\'' . $dbs['id'] . '\')" title="Delete"><i class="fa fa-trash"></i></span>';
			}
			$row[] = $opsi;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->dbs->count_all(),
			"recordsFiltered" => $this->dbs->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	// Module management file
	public function upload_file()
	{
		$this->_validasi();

		$data = array(
			'tgl_data' => parse_tgl(input('tgl_data')),
			'module' => input('module'),
			'update_posisi' => 0
		);

		$config = array(
			'upload_path' => './assets/upload/',
			// 'allowed_types' => 'xlsx|xls|csv|txt'
			'allowed_types' => 'csv|txt'
		);

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file_upload')) {
			$fileData = $this->upload->data();

			$data['file_size'] = $fileData['file_size'];
			$data['file_name'] = $fileData['file_name'];

			$this->db->insert('tbl_dbs', $data);

			header('Content-Type: application/json');
			echo json_encode(['status' => true, 'title' => 'Sukses', 'text' => 'File telah berhasil di upload', 'icon' => 'success']);
			exit;
		} else {
			echo json_encode(['status' => true, 'title' => 'Oops!', 'text' => strip_tags($this->upload->display_errors()), 'icon' => 'error']);
			exit;
		}
	}

	public function hapus_file($id)
	{
		$file = $this->db->get_where('tbl_dbs', ['id' => $id])->row_array();
		unlink('./assets/upload/' . $file['file_name']);

		$this->db->trans_start();
		$this->db->delete('tbl_dbs', ['id' => $id]);
		$this->db->delete('tbl_performance', ['tgl_data' => $file['tgl_data']]);
		$this->db->trans_complete();

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();

			$msg['title'] = 'Oops!';
			$msg['icon'] = 'error';
			$msg['text'] = 'Terjadi kesalahan, data gagal dihapus';
		} else {
			$this->db->trans_commit();

			$msg['title'] = 'Sukses';
			$msg['icon'] = 'success';
			$msg['text'] = 'Data berhasil dihapus';
		}

		echo json_encode(['status' => true, 'msg' => $msg]);
		exit;
	}

	public function download($id)
	{
		$this->load->helper('download');

		$path = './assets/upload/';

		$file = $this->db->get_where('tbl_dbs', ['id' => $id])->row_array();

		force_download($path . $file['file_name'], NULL);
		echo json_encode(['status' => true]);
		exit;
	}
	// End of Module management file

	// update data posisi
	private function upd_realiasi_pencairan($file)
	{
		$msg = array();
		$file_path = FCPATH . $file;

		$qry = "LOAD DATA LOCAL INFILE '". str_replace("\\", "/", $file_path) . "' ";
		$qry .= "INTO TABLE `tbl_gross` ";
		$qry .= "FIELDS TERMINATED BY '|' ";
		$qry .= "LINES TERMINATED BY '\\n' ";
		$qry .= "IGNORE 1 LINES ";
		$qry .= "(area, region, kode_bsi, @tgl_rekap, no_rek, no_cif, nm_debitur, cabang_bsi, prod_name, jns_penggunaan_kode, sekon_kode, @tgl_cair, nom_pencairan, bln_pencairan, binaan, bank_legacy, time_sparate, perusahaan_final) ";
		$qry .= "SET tgl_rekap = DATE_FORMAT(STR_TO_DATE(@tgl_rekap, '%d/%m/%Y'), '%Y-%m-%d'), ";
		$qry .= "tgl_cair = DATE_FORMAT(STR_TO_DATE(@tgl_cair, '%d/%m/%Y'), '%Y-%m-%d')";

		$this->db->trans_start();
		$this->db->query($qry);
		$this->db->trans_complete();

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();

			$msg['title'] = 'Oops!';
			$msg['icon'] = 'error';
			$msg['text'] = 'Terjadi kesalahan, data posisi gagal diperbarui';
		} else {
			$this->db->trans_commit();

			$msg['title'] = 'Sukses';
			$msg['icon'] = 'success';
			$msg['text'] = 'Data posisi berhasil diperbarui';
		}

		echo json_encode(['status' => true, 'msg' => $msg]);
	}

	private function upd_performance($file)
	{
		$msg = array();
		$file_path = FCPATH . $file;

		$qry = "LOAD DATA LOCAL INFILE '" . str_replace("\\", "/", $file_path) . "' ";
		$qry .= "INTO TABLE `tbl_performance` ";
		$qry .= "FIELDS TERMINATED BY '|' ";
		$qry .= "LINES TERMINATED BY '\\n' ";
		$qry .= "IGNORE 1 LINES ";
		$qry .= "(index_bank, nm_bank, @tgl_data, noloan, no_cif, nm_nasabah, kd_cabang, nm_cabang, area, region, leg_loantype, loantype, skim, sub_loantype, kd_sub_sektor, sektor_ekonomi, @tgl_cair, @tgl_jt_tempo, dpd, sektor, segment, restru_flag, @tgl_restru, tenor, @skip, kol_dpd, kol_loan, kol_lalu, kol_vs, flag_dg, kol_flag, kol_cif, ospokok, tungg_pokok_adj, tungg_pokok, tungg_margin, plafond, desc_prod, model_bsi, tgl_jt_angsuran, rek_afiliasi) ";
		$qry .= "SET tgl_data = DATE_FORMAT(STR_TO_DATE(@tgl_data, '%d/%m/%Y'), '%Y-%m-%d'), ";
		$qry .= "tgl_cair = DATE_FORMAT(STR_TO_DATE(@tgl_cair, '%d/%m/%Y'), '%Y-%m-%d'), ";
		$qry .= "tgl_jt_tempo = DATE_FORMAT(STR_TO_DATE(@tgl_jt_tempo, '%d/%m/%Y'), '%Y-%m-%d'), ";
		$qry .= "tgl_restru = DATE_FORMAT(STR_TO_DATE(@tgl_restru, '%d/%m/%Y'), '%Y-%m-%d')";

		// (index_bank, nm_bank, @tgl_data, noloan, no_cif, nm_nasabah, kd_cabang, nm_cabang, area, region, leg_loantype, loantype, skim, sub_loantype, kd_sub_sektor, sektor_ekonomi, @tgl_cair, @tgl_jt_tempo, dpd, sektor, segment, restru_flag, @tgl_restru, tenor, kol_dpd, kol_loan, kol_lalu, kol_vs, flag_dg, kol_flag, kol_cif, ospokok, tungg_pokok_adj, tungg_pokok, tungg_margin, plafond, desc_prod, model_bsi, tgl_jt_angsuran, rek_afiliasi)

		$msg = array();

		$this->db->trans_start();
		$this->db->query($qry);
		$this->db->trans_complete();

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();

			$msg['title'] = 'Oops!';
			$msg['icon'] = 'error';
			$msg['text'] = 'Terjadi kesalahan, data posisi gagal diperbarui';
		} else {
			$this->db->trans_commit();

			$msg['title'] = 'Sukses';
			$msg['icon'] = 'success';
			$msg['text'] = 'Data posisi berhasil diperbarui';
		}

		echo json_encode(['status' => true, 'msg' => $msg]);
	}

	public function update_posisi($id)
	{
		$file = $this->db->get_where('tbl_dbs', ['id' => $id])->row_array();
		$path = './assets/upload/';

		try {
			if ($file['module'] == 'Performance') {
				$this->upd_performance($path . $file['file_name']);
			} else {
				$this->upd_realiasi_pencairan($path . $file['file_name']);
			}

			$this->db->update('tbl_dbs', ['update_posisi' => 1], ['id' => $id]);
		} catch (Exception $e) {
			$msg = array(
				'title' => 'Oops!',
				'icon' => 'error',
				'text' => $e->getMessage()
			);

			echo json_encode(['status' => true, 'msg' => $msg]);
			exit;
		}
	}
}
