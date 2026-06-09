<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('licensing');
        $this->licensing->check_license();
		
		//Get Zona Waktu
        foreach ($this->db->get('tb_aplikasi')->result() as $timezone) {
            date_default_timezone_set($timezone->timezone);
        }

		if(!$this->session->userdata('level')){
			$this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
			redirect('home');
		} elseif($this->session->userdata('level') != 'Petugas') {
			redirect('home');
        }
	}

	public function index()
	{
		$data['title']		= 'Dashboard';
		$data['subtitle']	= 'Control Panel';

		$data['collapse']	= 'No';
		
		$id = $this->session->userdata('id');
		$data['jumlah_bayar_by_iduser'] = $this->m_model->jumlah_bayar_by_iduser('tb_angsuran',$id);
		

		// print_r($id);
		// print_r($data['jumlah_bayar_by_iduser']);
		// die();

		$this->load->view('petugas/templates/header', $data);
		$this->load->view('petugas/templates/sidebar');
		$this->load->view('petugas/dashboard');
		$this->load->view('petugas/templates/footer');
    }
}