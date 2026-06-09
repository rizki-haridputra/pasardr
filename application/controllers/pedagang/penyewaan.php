<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class penyewaan extends CI_Controller {

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

		$this->db->where('level', 'Nasabah');
		$data['nasabah']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Nasabah') {
			$this->db->where('idPedagang', $this->session->userdata('id'));
		}
        
        $id = $this->session->userdata('id');
        $data['sewa']		= $this->m_model->get_sewa_user('tb_sewa', $id);
		
		$this->load->view('pedagang/templates/header', $data);
		$this->load->view('pedagang/templates/sidebar');
		$this->load->view('pedagang/views/penyewaan');
		$this->load->view('pedagang/templates/footer');
    }

	public function form($id)
	{
		$data['title']		= 'Data sewa';
		$data['subtitle']	= 'Menampilkan semua data sewa';
		$data['collapse']	= 'No';
		$data['id_kios']	= $id;

		$this->db->where('level', 'Nasabah');
		$data['nasabah']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Nasabah') {
			$this->db->where('idNasabah', $this->session->userdata('id'));
		}
		$data['sewa']		= $this->m_model->get_desc('tb_sewa');
		$data['user']		= $this->m_model->get_user('tb_user');

		$this->load->view('pedagang/templates/header', $data);
		$this->load->view('pedagang/templates/sidebar');
		$this->load->view('pedagang/form_sewa_view', $data);
		$this->load->view('pedagang/templates/footer');
    }

    // =================================================================================
    // KODE UNTUK PROSES PERBAIKAN SEWA (SUDAH DIPERBAIKI)
    // =================================================================================

    /**
     * FUNGSI #1: Menampilkan halaman/form untuk PERBAIKAN SEWA.
     * Fungsi ini dipanggil saat pedagang menekan tombol "Perbaikan".
     * URL: /pedagang/penyewaan/perbaikan/[id_kios]
     */
    public function perbaikan($idKios)
    {
        $data['sewa'] = $this->db->get_where('tb_sewa', [
            'idKios' => $idKios,
            'idPedagang' => $this->session->userdata('id'),
            'StatusSewa' => 'perbaikan'
        ])->row_array();

        if (empty($data['sewa'])) {
            $this->session->set_flashdata('error', 'Data sewa tidak valid atau tidak memerlukan perbaikan.');
            redirect('pedagang/penyewaan');
        }

        $data['title'] = 'Perbaikan Data Sewa';
        $this->load->view('pedagang/templates/header', $data); // Sesuaikan path template jika perlu
        $this->load->view('pedagang/templates/sidebar');     // Sesuaikan path template jika perlu
        $this->load->view('pedagang/v_sewa_update', $data); // Pastikan nama view ini benar
        $this->load->view('pedagang/templates/footer');     // Sesuaikan path template jika perlu
    }

    /**
     * FUNGSI #2: Memproses data yang dikirim dari form perbaikan.
     * Ini adalah tujuan dari 'action' di form perbaikan.
     */
    public function proses_perbaikan()
    {
        $idSewa = $this->input->post('idSewa');
        $idKios = $this->input->post('idKios'); // Ambil idKios untuk redirect jika gagal

        // Data untuk diupdate ke database
        $data_update = [
            'catatan' => $this->input->post('catatan_pedagang'),
            'StatusSewa' => 'verifikasi', // Status berubah kembali menjadi 'verifikasi'
            'tanggal' => date('Y-m-d H:i:s')
        ];

        // Konfigurasi untuk upload file
        $config['upload_path']   = './uploads/bukti_pembayaran/'; // Pastikan folder ini ada
        $config['allowed_types'] = 'jpg|png|jpeg|pdf';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        // Cek jika ada file baru yang diupload
        if (!empty($_FILES['bukti_pembayaran']['name'])) {
            if ($this->upload->do_upload('bukti_pembayaran')) {
                $upload_data = $this->upload->data();
                $data_update['bukti_pembayaran'] = $upload_data['file_name']; // Ganti nama kolom jika perlu
            } else {
                // Jika upload gagal, kembali ke form dengan pesan error
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('pedagang/penyewaan/perbaikan/' . $idKios);
                return; // Hentikan eksekusi
            }
        }

        // Lakukan update ke database
        $this->db->where('idSewa', $idSewa);
        $this->db->update('tb_sewa', $data_update);

        $this->session->set_flashdata('success', 'Data perbaikan berhasil dikirim. Silakan tunggu proses verifikasi selanjutnya.');
        redirect('pedagang/penyewaan');
    }

	public function insert()
	{	
		$idpengguna = $this->session->userdata();

		$foto_nib    = $_FILES['foto_nib'];

		if($foto_nib != ''){
			$config['upload_path']      = './assets/NIB/';
			$config['allowed_types']    = 'png|jpg|jpeg';
			$config['file_name']        = 'FotoNIB-' . time();

			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('foto_nib')){
				$foto_nib = 'no-image.png';
				$this->session->set_flashdata('pesanError', 'Format tidak diijinkan!');
			} else {
				$foto_nib = $this->upload->data('file_name');
				$this->session->set_flashdata('pesan', 'foto nib berhasil diupload!');
			}
		}

		$foto_ktp_ahli_waris    = $_FILES['foto_ktp_ahli_waris'];

		if($foto_ktp_ahli_waris != ''){
			$config['upload_path']      = './assets/KTP/';
			$config['allowed_types']    = 'png|jpg|jpeg';
			$config['file_name']        = 'FotoKTP-' . time();

			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('foto_ktp_ahli_waris')){
				$foto_ktp_ahli_waris = 'no-image.png';
				$this->session->set_flashdata('pesanError', 'Format tidak diijinkan!');
			} else {
				$foto_ktp_ahli_waris = $this->upload->data('file_name');
				$this->session->set_flashdata('pesan', 'foto ktp berhasil diupload!');
			}
		}
		
		// Ambil data dari form
		$idUserinput 		= $idpengguna['id'];
		$idPedagang  		= $this->input->post('id');
		$idSewa		 		= 'KRD-' . time();
		$idKios		 		= $this->input->post('id_kios');
		$NIB    	 		= $this->input->post('nib_penyewa');
		$fotoNIB     		= $foto_nib;
		$namaAhliWaris  	= $this->input->post('nama_ahli_waris');
		$NIKahliWaris   	= $this->input->post('nik_ahli_waris');
		$Hubungan     	 	= $this->input->post('hubungan_ahli_waris');
		$fotoKTPahliWaris   = $foto_ktp_ahli_waris;
		$terdaftar   		= date('Y-m-d H:i:s');
		$tanggal    		= $this->input->post('tanggal_mulai_sewa');
		$harga    			= $this->input->post('harga');
		$jenisDagang   		= $this->input->post('jenis_dagangan');
		$status      		= 'Belum Lunas';

		// Simpan data sewa dulu
		$datasewa = [
			'idUserinput' 	    => $idUserinput,
			'idPedagang'	    => $idPedagang,
			'idSewa'            => $idSewa,
			'idKios' 		    => $idKios,
			'NIB' 			    => $NIB,
			'fotoNIB' 		    => $fotoNIB,
			'namaAhliWaris'     => $namaAhliWaris,
			'NIKahliWaris' 	    => $NIKahliWaris,
			'Hubungan' 		    => $Hubungan,
			'fotoKTPahliWaris'  => $fotoKTPahliWaris,
			'terdaftar' 		=> $terdaftar,
			'tanggal'           => $tanggal,
			'harga' 			=> $harga,
			'jenisDagang' 		=> $jenisDagang,
			'status'            => $status
		];

		$this->db->insert('tb_sewa', $datasewa);
		
		$idKios		 		= $this->input->post('id_kios');
		$status		 		= 'berisi';

		$data_update_kios = array(
			'status' 		=> $status,
		);

		$where = array('idKios' => $idKios);
		$this->m_model->update($where, $data_update_kios, 'tb_kios');

		$this->session->set_flashdata('success', 'Data sewa dan angsuran berhasil disimpan!');
		redirect('admin/sewa');
	}


	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_sewa');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/sewa');
	}

	/**
	 * Fungsi ini untuk update data sewa secara umum (kemungkinan oleh Admin)
	 * Kita biarkan nama 'update' karena mungkin terhubung dengan sistem lain.
	 */
	public function update($id)
	{
		$idPedagang		    = $_POST['idPedagang'];
		$idKios		        = $_POST['idKios'];
		$NIB			    = $_POST['NIB'];
		$fotoNIB		    = $_POST['fotoNIB'];
		$namaAhliWaris	    = $_POST['namaAhliWaris'];
		$NIKahliWaris	    = $_POST['NIKahliWaris'];
		$Hubungan			= $_POST['Hubungan'];
		$fotoKTPahliWaris	= $_POST['fotoKTPahliWaris'];
		$jenisDagang		= $_POST['jenisDagang'];

		$data = array(
			'idPedagang' 	    => $idPedagang,
			'idKios' 		    => $idKios,
			'NIB' 		        => $NIB,
			'fotoNIB' 		    => $fotoNIB,
			'namaAhliWaris'     => $namaAhliWaris,
			'NIKAhliWaris' 	    => $NIKahliWaris,
			'Hubungan' 		    => $Hubungan,
			'fotoKTPahliWaris' 	=> $fotoKTPahliWaris,
			'jenisDagang' 		=> $jenisDagang
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_sewa');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/penyewaan');
	}
}