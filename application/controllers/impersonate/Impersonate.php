<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impersonate extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('licensing');
        $this->licensing->check_license();
		
		//Get Zona Waktu
        foreach ($this->db->get('tb_aplikasi')->result() as $timezone) {
            date_default_timezone_set($timezone->timezone);
        }
	}

	public function index()
	{
		$data['title']		= 'Impersonate User';
		$data['subtitle']	= 'Anda dapat login dengan aman';

		$data['aplikasi'] 	= $this->m_model->get_desc('tb_aplikasi');
		$data['user'] 		= $this->m_model->get_desc('tb_user');

		$this->load->view('impersonate/home', $data);
    }

	public function login()
	{
		$where = array('id' => $_POST['idUser']);
		foreach ($this->m_model->get_where($where, 'tb_user')->result_array() as $row) {
			$datauser = array(
				'id'            => $row['id'], 
				'nama'          => $row['nama'],  
				'jenisKelamin'  => $row['jenisKelamin'],
				'tptLahir'      => $row['tptLahir'],
				'tglLahir'      => $row['tglLahir'],
				'telp'          => $row['telp'],   
				'email'         => $row['email'],
				'login'         => $row['login'],
				'alamat'        => $row['alamat'],
				'username'      => $row['username'],
				'skin'          => $row['skin'],
				'level'         => $row['level'],
				'foto'          => $row['foto'],
				'terdaftar'     => $row['terdaftar'],
				'start_time'    => date('Y-m-d H:i:s'),
			);

			$this->session->set_userdata($datauser);

			redirect('admin/dashboard');
		}
    }

	public function logout()
    {
        $this->session->sess_destroy();
        redirect('impersonate/impersonate');
    }
}