<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

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
		} elseif($this->session->userdata('level') != 'Administrator') {
			redirect('home');
        }
	}

	public function index()
	{
		$data['title']		= 'Data Log';
		$data['subtitle']	= 'Semua log akan muncul disini';

		$data['collapse']	= 'No';
		
		$data['log']		= $this->m_model->get_desc('tb_log');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/log');
		$this->load->view('admin/templates/footer');
	}
}