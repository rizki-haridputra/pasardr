<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Angsuran extends CI_Controller {

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
		$data['title']		= 'Data Angsuran';
		$data['subtitle']	= 'Menampilkan semua data angsuran';

		$data['collapse']	= 'No';

		$this->db->where('status', 'Belum Lunas');
		$data['sewa']		= $this->m_model->get_desc('tb_sewa');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/angsuran');
		$this->load->view('admin/templates/footer');
    }

	public function search()
	{
		$idSewa	= $_POST['idSewa'];

		redirect("admin/angsuran/pembayaran/$idSewa");
	}

	public function pembayaran($idSewa)
	{
		$data['title']		= 'Pembayaran Angsuran';
		$data['subtitle']	= 'Menampilkan semua data angsuran';

		$data['collapse']	= 'No';

		$this->db->where('id', $idSewa);
		$data['sewa']		= $this->m_model->get_desc('tb_sewa');
		$this->db->where('idSewa', $idSewa);
		$data['angsuran']	= $this->m_model->get_desc('tb_angsuran');

		$data['idSewa']	= $idSewa;
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/pembayaran');
		$this->load->view('admin/templates/footer');
	}

	public function insert($idSewa)
	{
		$idUserinput	= $this->session->userdata('id');
		$idSewa		= $idSewa;
		$tanggal		= $_POST['tanggal'];
		$nominal		= $_POST['nominal'];
		$keterangan		= $_POST['keterangan'];
		$terdaftar		= date('Y-m-d H:i:s');

		$data = array(
			'idUserinput' 	=> $idUserinput,
			'idSewa' 		=> $idSewa,
			'tanggal' 		=> $tanggal,
			'nominal' 		=> $nominal,
			'keterangan' 	=> $keterangan,
			'terdaftar' 	=> $terdaftar
		);

		$this->m_model->insert($data, 'tb_angsuran');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		redirect("admin/angsuran/pembayaran/$idSewa");
	}

	public function delete($id, $idSewa)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_angsuran');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect("admin/angsuran/pembayaran/$idSewa");
	}

	public function update($idSewa, $idData)
	{
		$idSewa		= $idSewa;
		$tanggal		= $_POST['tanggal'];
		$nominal		= $_POST['nominal'];
		$keterangan		= $_POST['keterangan'];

		$data = array(
			'idSewa' 		=> $idSewa,
			'tanggal' 		=> $tanggal,
			'nominal' 		=> $nominal,
			'keterangan' 	=> $keterangan
		);

		$where = array('id' => $idData);

		$this->m_model->update($where, $data, 'tb_angsuran');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect("admin/angsuran/pembayaran/$idSewa");
	}

	public function cetakpembayaran($idSewa)
	{
		$data['title']		= 'Cetak Pembayaran Angsuran';
		$data['subtitle']	= 'Cetak Angsuran Pembayaran';

		$data['collapse']	= 'No';

		$this->db->where('id', $idSewa);
		$data['sewa']		= $this->m_model->get_desc('tb_sewa');
		$this->db->where('idSewa', $idSewa);
		$data['angsuran']	= $this->m_model->get_desc('tb_angsuran');

		$data['idSewa']	= $idSewa;

		$this->load->view('admin/cetakpembayaran', $data);
	}
}