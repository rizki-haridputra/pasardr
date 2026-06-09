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
		} elseif($this->session->userdata('level') != 'Manager') {
			redirect('home');
        }
	}

	public function index()
	{
		$data['title']		= 'Dashboard';
		$data['subtitle']	= 'Control Panel';

		$data['collapse']	= 'No';
		
		$this->load->view('manager/templates/header', $data);
		$this->load->view('manager/templates/sidebar');
		$this->load->view('manager/views/dashboard');
		$this->load->view('manager/templates/footer');
    }
}