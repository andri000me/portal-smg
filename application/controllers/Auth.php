<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		$this->load->view('v_login');
	}

	public function login()
	{
		$username = input('username');
		$password = input('password');

		$cek_user = $this->db->get_where('tbl_user', ['username' => $username]);
		if($cek_user->num_rows() > 0){
			$user = $cek_user->row_array();

			if($user['password'] == md5($password)){
				$sess = array(
					'username' => $username,
					'nm_user' => $user['nm_user'],
					'lv_user' => $user['lv_user'],
					'is_login' => true
				);

				$this->session->set_userdata($sess);
				redirect(site_url('dashboard'));
			} else {
				$msg = 'Incorrect username or password.';

				$this->session->set_flashdata('msg', $msg);

				redirect(base_url());
			}
		} else {
			$msg = 'User cannot be found';

			$this->session->set_flashdata('msg', $msg);

			redirect(base_url());
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();

		redirect(base_url());
	}
}
