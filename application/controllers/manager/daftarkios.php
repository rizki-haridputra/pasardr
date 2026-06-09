<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class daftarkios extends CI_Controller {

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
		}
	}

	public function index()
	{
		
		$data['title']		= 'Data Kios';
		$data['subtitle']	= 'Menampilkan semua data Kios';

		$data['collapse']	= 'No';

		$this->db->where('level', 'Nasabah');
		$data['nasabah']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Nasabah') {
			$this->db->where('idKios', $this->session->userdata('id'));
		}
		$data['Kios']		= $this->m_model->get_desc('tb_kios');
		
		$this->load->view('manager/templates/header', $data);
		$this->load->view('manager/templates/sidebar');
		$this->load->view('manager/views/daftarkios');
		$this->load->view('manager/templates/footer');
    }
}