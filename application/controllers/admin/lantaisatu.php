<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lantaisatu extends CI_Controller {

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
		
		$data['title']		= 'Data Kios Pasar Baru';
		$data['subtitle']	= 'Menampilkan semua data Kios Pasar Baru';

		$data['collapse']	= 'No';

		$this->db->where('level', 'Pedagang');
		$data['Pedagang']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Pedagang') {
			$this->db->where('idKios', $this->session->userdata('id'));
		}
		$data['Kios']		= $this->m_model->get_desc('tb_kios');
		
		
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/lantaisatu');
		$this->load->view('admin/templates/footer');
    }
}