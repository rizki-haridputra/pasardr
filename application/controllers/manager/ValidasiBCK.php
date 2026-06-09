<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class validasi extends CI_Controller {

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
		$data['title']		= 'Data sewa';
		$data['subtitle']	= 'Menampilkan semua data sewa';

		$data['collapse']	= 'No';

		$this->db->where('level', 's');
		$data['nasabah']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Nasabah') {
			$this->db->where('idPedagang', $this->session->userdata('id'));
		}
		$data['validasi']		= $this->m_model->get_data_validasi('tb_sewa');
		
		$this->load->view('manager/templates/header', $data);
		$this->load->view('manager/templates/sidebar');
		$this->load->view('manager/views/validasi');
		$this->load->view('manager/templates/footer');
    }

	public function update($id)
	{
        $catatan            = $_POST['catatan'];
		$StatusSewa			= $_POST['StatusSewa'];

		// 1. Dapatkan data sewa yang akan divalidasi
		$sewa_awal = $this->db->get_where('tb_sewa', array('id' => $id))->row_array();

		if (!$sewa_awal) {
			$this->session->set_flashdata('pesan', 'Data sewa tidak ditemukan!');
			redirect('manager/validasi');
		}

		// 2. Lakukan update pada data sewa yang pertama kali divalidasi
		$data_update_awal = array(
			'catatan'       => $catatan,
			'StatusSewa' 	=> $StatusSewa
		);
		$where_awal = array('id' => $id);
		$this->m_model->update($where_awal, $data_update_awal, 'tb_sewa');

		// 3. Jika status adalah 'validasi', buat data berulang
		if ($StatusSewa == 'validasi') {
			// Update status kios menjadi 'berisi'
			$data_update_kios = array(
				'status' => 'berisi'
			);
			$where_kios = array('idKios' => $sewa_awal['idKios']);
			$this->m_model->update($where_kios, $data_update_kios, 'tb_kios');

			// Logika untuk menyimpan data berulang setiap bulan
			$bulan_sekarang = (int)date('m');
			$tahun_sekarang = (int)date('Y');

			for ($bulan = $bulan_sekarang + 1; $bulan <= 12; $bulan++) {
				$data_sewa_baru = array(
					'idSewa' 			=> $sewa_awal['idSewa'], // Menggunakan No Sewa yang sama atau buat baru jika perlu
					'idPedagang' 		=> $sewa_awal['idPedagang'],
					'idKios' 			=> $sewa_awal['idKios'],
					'harga'				=> $sewa_awal['harga'],
					'tanggal' 			=> $tahun_sekarang . '-' . $bulan . '-' . date('d'), // Tanggal disesuaikan dengan bulan perulangan
					'StatusSewa'		=> 'validasi', // Status untuk bulan berikutnya
					'catatan'			=> 'Tagihan bulanan',
					'NIB'				=> $sewa_awal['NIB'],
					'namaAhliWaris'		=> $sewa_awal['namaAhliWaris'],
					'NIKahliWaris'		=> $sewa_awal['NIKahliWaris'],
					'Hubungan'			=> $sewa_awal['Hubungan'],
					'jenisDagang'		=> $sewa_awal['jenisDagang'],
					'fotoKTPahliWaris' => $sewa_awal['fotoKTPahliWaris'],
                	'fotoNIB' 			=> $sewa_awal['fotoNIB']
					// Tambahkan field lain yang relevan dari $sewa_awal
				);
				$this->m_model->insert($data_sewa_baru, 'tb_sewa'); // Gunakan fungsi insert dari m_model Anda
			}

			$this->session->set_flashdata('pesan', 'Data berhasil divalidasi dan tagihan bulanan telah dibuat!');
			
		} else { // Jika status adalah 'perbaikan' atau lainnya
			$this->session->set_flashdata('pesanPerbaharui', 'Data berhasil diperbaharui!');
		}

		redirect('manager/validasi');
	}
}