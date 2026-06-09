<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class verifikasi extends CI_Controller {

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
		$data['sewa']		= $this->m_model->get_data_verifikasi('tb_sewa');

		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/verifikasi');
		$this->load->view('admin/templates/footer');
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

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/form_sewa_view', $data);
		$this->load->view('admin/templates/footer');
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
        'tanggal'           => $tanggal,
        'jenisDagang' 		=> $jenisDagang,
        'status'            => $status
    ];

    $this->db->insert('tb_sewa', $datasewa);
    $idsewa = $this->db->insert_id();

    
    $idKios		 		= $this->input->post('id_kios');
    $status		 		= 'berisi';

		$data_update_kios = array(
			'idKios' 		=> $idKios,
			'status' 		=> $status,
            'idKios' 	    => $idKios,
		);

		$where = array('idKios' => $idKios);

	$this->m_model->update($where, $data_update_kios, 'tb_kios');

    // // Hitung berapa bulan tersisa dari tanggal ke akhir tahun
    // $bulanMulai = (int)date('m', strtotime($tanggal));
    // $tahunMulai = (int)date('Y', strtotime($tanggal));
    // $jumlahBulan = 12 - $bulanMulai + 1;

    // // Hitung angsuran per bulan
    // $angsuranPerBulan = $harga / $jumlahBulan;

    // // Simpan data angsuran tiap bulan ke tb_angsuran
    // for ($i = 0; $i < $jumlahBulan; $i++) {
    //     $bulan = $bulanMulai + $i;
    //     $tahun = $tahunMulai;
    //     if ($bulan > 12) {
    //         $bulan -= 12;
    //         $tahun += 1;
    //     }

    //     $tanggalAngsuran = date('Y-m-d', strtotime("$tahun-$bulan-01"));

    //     $this->db->insert('tb_angsuran', [
    //         'idsewa' => $idsewa,
    //         'tanggal' => $tanggalAngsuran,
    //         'nominal' => $angsuranPerBulan,
    //         'status' => 'Belum Lunas'
    //     ]);
    // }

    $this->session->set_flashdata('success', 'Data sewa dan angsuran berhasil disimpan!');
    redirect('admin/verifikasi');
}


	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_sewa');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/verifkasi');
	}

	public function update($id)
	{
		// $idPedagang		= $_POST['idPedagang'];
        $catatan            = $_POST['catatan'];
		// $idKios		    = $_POST['idKios'];
		$StatusSewa			= $_POST['StatusSewa'];

		$data = array(
			// 'idPedagang' 	=> $idPedagang,
			// 'idKios' 		=> $idKios,
            'catatan'       => $catatan,
			'StatusSewa' 	=> $StatusSewa
		);

        

		$where = array('id' => $id);

		 $this->m_model->update($where, $data, 'tb_sewa');
		// $this->session->set_flashdata('pesan', 'Data berhasil diverifikasi!');
		// redirect('admin/verifikasi');
         if($StatusSewa == 'verifikasi') {
		$this->session->set_flashdata('pesan', 'Data berhasil diverifikasi!');
		redirect('admin/verifikasi');
       
        }
     else{
        $this->session->set_flashdata('pesanPerbaharui', 'Data berhasil diperbaharui!');
        redirect('admin/verifikasi');
        }
	}
}