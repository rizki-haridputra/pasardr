<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

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
		$data['title']		= 'Data Laporan';
		$data['subtitle']	= 'Menampilkan semua data laporan';

		$data['collapse']	= 'No';
		
		$this->load->view('manager/templates/header', $data);
		$this->load->view('manager/templates/sidebar');
		$this->load->view('manager/views/laporan');
		$this->load->view('manager/templates/footer');
    }

	public function rekap()
	{
		$data['title']	= 'Rekap Laporan Angsuran';

		$dariTanggal	= $_GET['dariTanggal'];
		$sampaiTanggal	= $_GET['sampaiTanggal'];

		$data['dariTanggal']	= $dariTanggal;
		$data['sampaiTanggal']	= $sampaiTanggal;

		$this->db->where('tanggal BETWEEN "'.$dariTanggal.'" AND "'.$sampaiTanggal.'"');
		$data['angsuran']	= $this->m_model->get_desc('tb_angsuran');
		$this->db->where('tanggal BETWEEN "'.$dariTanggal.'" AND "'.$sampaiTanggal.'"');
		$this->db->select_sum('nominal');
		$data['total']	= $this->m_model->get_desc('tb_angsuran');

		$this->load->view('manager/views/rekaplaporan', $data);
	}
}