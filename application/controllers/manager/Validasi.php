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

		// 1. Dapatkan data sewa awal yang akan divalidasi
		$sewa_awal = $this->db->get_where('tb_sewa', array('id' => $id))->row_array();

		if (!$sewa_awal) {
			$this->session->set_flashdata('pesan', 'Data sewa tidak ditemukan!');
			redirect('manager/validasi');
		}

		// 2. Jika status adalah 'validasi', terapkan semua logika penagihan
		if ($StatusSewa == 'validasi') {
			
			// --- BAGIAN 1: PROSES TAGIHAN BULAN PERTAMA (PRORATA) ---
			$tanggal_mulai = new DateTime($sewa_awal['tanggal']);
			$harga_normal = (float)$sewa_awal['harga'];

			$hari_mulai = (int)$tanggal_mulai->format('d');
			$jumlah_hari_dalam_bulan = (int)$tanggal_mulai->format('t');
			$sisa_hari = $jumlah_hari_dalam_bulan - $hari_mulai + 1;
			
			// Hitung harga prorata: (Harga Normal / Total Hari Sebulan) * Sisa Hari
			$harga_prorata = ($jumlah_hari_dalam_bulan > 0) ? ($harga_normal / $jumlah_hari_dalam_bulan) * $sisa_hari : 0;

			// Update data sewa pertama dengan harga prorata
			$data_update_awal = array(
				'harga'         => round($harga_prorata),
				'catatan'       => 'Biaya prorata untuk sisa ' . $sisa_hari . ' hari. ' . $catatan,
				'StatusSewa' 	=> $StatusSewa
			);
			$where_awal = array('id' => $id);
			$this->m_model->update($where_awal, $data_update_awal, 'tb_sewa');

			// Update status kios menjadi 'berisi'
			$data_update_kios = array('status' => 'berisi');
			$where_kios = array('idKios' => $sewa_awal['idKios']);
			$this->m_model->update($where_kios, $data_update_kios, 'tb_kios');


			// --- BAGIAN 2: BUAT TAGIHAN UNTUK SEMUA SISA BULAN DI TAHUN YANG SAMA ---
			$bulan_mulai_sewa = (int)$tanggal_mulai->format('m');
			$jumlah_bulan_tersisa = 12 - $bulan_mulai_sewa;

			// Hanya jalankan jika ada bulan tersisa di tahun ini
			if ($jumlah_bulan_tersisa > 0) {
				$tanggal_tagihan_berikutnya = clone $tanggal_mulai;
				// Setel tanggal ke tanggal 1 bulan berikutnya sebagai titik awal
				$tanggal_tagihan_berikutnya->modify('first day of next month');

				// Loop ini akan berjalan sebanyak sisa bulan.
				// Contoh: Sewa bulan 9 (September), sisa bulan = 12-9=3. Loop berjalan 3 kali.
				for ($i = 1; $i <= $jumlah_bulan_tersisa; $i++) {
					$data_sewa_baru = array(
						'idSewa' 			=> $sewa_awal['idSewa'],
						'idPedagang' 		=> $sewa_awal['idPedagang'],
						'idKios' 			=> $sewa_awal['idKios'],
						'harga'				=> $harga_normal, // Harga Normal untuk bulan selanjutnya
						'tanggal' 			=> $tanggal_tagihan_berikutnya->format('Y-m-d'), // Tanggal 1 setiap bulan
						'status'			=> 'Kurang Bayar',
						'StatusSewa'		=> 'validasi', // Status untuk tagihan baru
						'catatan'			=> 'Tagihan bulan ' . $tanggal_tagihan_berikutnya->format('F Y'),
						'NIB'				=> $sewa_awal['NIB'],
						'namaAhliWaris'		=> $sewa_awal['namaAhliWaris'],
						'NIKahliWaris'		=> $sewa_awal['NIKahliWaris'],
						'Hubungan'			=> $sewa_awal['Hubungan'],
						'jenisDagang'		=> $sewa_awal['jenisDagang'],
						'fotoKTPahliWaris'  => $sewa_awal['fotoKTPahliWaris'],
						'fotoNIB' 			=> $sewa_awal['fotoNIB']
					);
					// Membuat record BARU di database
					$this->m_model->insert($data_sewa_baru, 'tb_sewa');
					
					// Pindahkan tanggal ke tanggal 1 bulan berikutnya untuk iterasi selanjutnya
					$tanggal_tagihan_berikutnya->modify('+1 month');
				}
			}

			$this->session->set_flashdata('pesan', 'Data berhasil divalidasi! Tagihan prorata dan tagihan bulanan hingga akhir tahun telah dibuat.');
			
		} else { // Jika status adalah 'perbaikan'
			$data_update_lain = array(
				'catatan'       => $catatan,
				'StatusSewa' 	=> $StatusSewa
			);
			$where_lain = array('id' => $id);
			$this->m_model->update($where_lain, $data_update_lain, 'tb_sewa');
			$this->session->set_flashdata('pesanPerbaharui', 'Data berhasil diperbaharui!');
		}

		redirect('manager/validasi');
	}
}