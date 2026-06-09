<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kios extends CI_Controller {

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
		
		$this->load->view('petugas/templates/header', $data);
		$this->load->view('petugas/templates/sidebar');
		$this->load->view('petugas/Kios');
		$this->load->view('petugas/templates/footer');
    }

	public function insert()
	{
		$id			= $this->session->userdata('id');
		$idKios		= $_POST['idKios'];
		$jKios		= $_POST['jKios'];
		$hKios		= $_POST['hKios'];
		$gambar		= $_POST['gambar'];
		$penyewa	= $_POST['penyewa'];

		$data = array(
			'idKios' 		=> $idKios,
			'jKios' 		=> $jKios,
			'hKios' 		=> $hKios,
			'gambar' 		=> $gambar,
			'penyewa' 		=> $penyewa,
		);

		$this->m_model->insert($data, 'tb_kios');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		redirect('petugas/kios');
	}

	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_kios');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('petugas/kios');
	}

	public function update($id)
	{
		$id			= $this->session->userdata('id');
		$idKios		= $_POST['idKios'];
		$jKios		= $_POST['jKios'];
		$hKios		= $_POST['hKios'];
		$gambar		= $_POST['gambar'];
		$penyewa	= $_POST['penyewa'];

		$data = array(
			'id' 			=> $id,
			'idKios' 		=> $idKios,
			'jKios' 		=> $jKios,
			'hKios' 		=> $hKios,
			'gambar' 		=> $gambar,
			'penyewa' 		=> $penyewa,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_kios');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('petugas/kios');
	}
}