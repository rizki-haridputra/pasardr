<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sewa extends CI_Controller {

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
		} elseif($this->session->userdata('level') != 'Pedagang') {
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
      //  $where = array('id' => $id);
      //  $data['sewa']		= $this->m_model->get_sewa_user('tb_sewa',$id);
        
        $data['sewa']		= $this->m_model->get_status_sewa('tb_sewa',$id);

        // print_r($data['sewa']);
        // die();
		
		$this->load->view('pedagang/templates/header', $data);
		$this->load->view('pedagang/templates/sidebar');
		$this->load->view('pedagang/views/sewa');
		$this->load->view('pedagang/templates/footer');
    }

	public function form($id)
	{
		$data['title']		= 'Data sewa';
		$data['subtitle']	= 'Menampilkan semua data sewa';

		$data['collapse']	= 'No';
		
		$data['id_kios']	= $id;

        $id_kios = $id;

		$this->db->where('level', 'Nasabah');
		$data['nasabah']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Nasabah') {
			$this->db->where('idNasabah', $this->session->userdata('id'));
		}
		$data['sewa']		= $this->m_model->get_desc('tb_sewa');
		$data['kios']		= $this->m_model->get_harga($id_kios,'tb_kios');

        // print_r($data['kios']);
        // print_r($id_kios);        
        // die();
        
		$data['user']		= $this->m_model->get_user('tb_user');

		$this->load->view('pedagang/templates/header', $data);
		$this->load->view('pedagang/templates/sidebar');
		$this->load->view('pedagang/views/form_sewa_view', $data);
		$this->load->view('pedagang/templates/footer');
    }

    

	public function perbaikan($idSewa)
{	
     $idSewa = 'KRD-1753004926';
		$data['sewa']		= $this->m_model->get_data_perbaikan('tb_sewa', $idSewa);
        print_r($data['sewa']);
       die(); 
       
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
                // $this->session->set_flashdata('pesan', 'foto nib berhasil diupload!');
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
                // $this->session->set_flashdata('pesan', 'foto ktp berhasil diupload!');
            }
        }
	
    // $idPedagang  		= $this->session->userdata('id');
    // $idSewa		 		= 'KRD-' . time();
    // $idKios		 		= $this->input->post('id_kios');
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
    $StatusSewa      	= 'proses';

    
    // Simpan data sewa dulu
    $data_update_sewa = array(
        
        // 'idPedagang'	    => $idPedagang,
        // 'idSewa'            => $idSewa,
        // 'idKios' 		    => $idKios,
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
        'status'            => $status,
        'StatusSewa'        => $StatusSewa
    );



   		$where_sewa = array('idSewa' => $idSewa);

	
     $data['sewa'] =   $this->m_model->update($where_sewa, $data_update_sewa, 'tb_sewa');
    

    
    // $idKios		 		= $this->input->post('id_kios');
    // $status		 		= 'proses';

	// 	$data_update_kios = array(
	// 		'idKios' 		=> $idKios,
	// 		'status' 		=> $status
	// 	);

	// 	$where = array('idKios' => $idKios);

	// $this->m_model->update($where, $data_update_kios, 'tb_kios');

    // // // Hitung berapa bulan tersisa dari tanggal ke akhir tahun
    // // $bulanMulai = (int)date('m', strtotime($tanggal));
    // // $tahunMulai = (int)date('Y', strtotime($tanggal));
    // // $jumlahBulan = 12 - $bulanMulai + 1;

    // // // Hitung angsuran per bulan
    // // $angsuranPerBulan = $harga / $jumlahBulan;

    // // // Simpan data angsuran tiap bulan ke tb_angsuran
    // // for ($i = 0; $i < $jumlahBulan; $i++) {
    // //     $bulan = $bulanMulai + $i;
    // //     $tahun = $tahunMulai;
    // //     if ($bulan > 12) {
    // //         $bulan -= 12;
    // //         $tahun += 1;
    // //     }

    // //     $tanggalAngsuran = date('Y-m-d', strtotime("$tahun-$bulan-01"));

    // //     $this->db->insert('tb_angsuran', [
    // //         'idsewa' => $idsewa,
    // //         'tanggal' => $tanggalAngsuran,
    // //         'nominal' => $angsuranPerBulan,
    // //         'status' => 'Belum Lunas'
    // //     ]);
    // // }

    $this->session->set_flashdata('success', 'Data sewa berhasil diajukan!');
    redirect('pedagang/penyewaan');
}


public function formu($idSewa)
	{
		$data['title']		= 'Data sewa';
		$data['subtitle']	= 'Menampilkan semua data sewa';

		$data['collapse']	= 'No';
		
		//$data['id_kios']	= $id;
		
		$this->db->where('level', 'Nasabah');
		$data['nasabah']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Nasabah') {
			$this->db->where('idNasabah', $this->session->userdata('id'));
		}

		$data['sewa']		= $this->m_model->get_data_perbaikan('tb_sewa', $idSewa);
        
    //    print_r($data['sewa']);
    //    die();  

		$this->load->view('pedagang/templates/header', $data);
		$this->load->view('pedagang/templates/sidebar');
		$this->load->view('pedagang/views/form_sewa_update', $data);
		$this->load->view('pedagang/templates/footer');
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
                // $this->session->set_flashdata('pesan', 'foto nib berhasil diupload!');
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
                // $this->session->set_flashdata('pesan', 'foto ktp berhasil diupload!');
            }
        }
	
    // Ambil data dari form
	//$idUserinput 		= $idpengguna['id'];

    

    $idPedagang  		= $this->session->userdata('id');
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
    $StatusSewa      	= 'proses';


    
    // Simpan data sewa dulu
    $datasewa = [
        // 'idUserinput' 	    => $idUserinput,
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
        'status'            => $status,
        'StatusSewa'        => $StatusSewa
    ];

    $this->db->insert('tb_sewa', $datasewa);
    $idsewa = $this->db->insert_id();

    
    $idKios		 		= $this->input->post('id_kios');
    $status		 		= 'proses';

		$data_update_kios = array(
			'idKios' 		=> $idKios,
			'status' 		=> $status
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

    $this->session->set_flashdata('success', 'Data sewa berhasil diajukan!');
    redirect('pedagang/penyewaan');
}



 public function cetakkontrak($idSewa)
    {
        // Set locale ke bahasa Indonesia untuk format tanggal
        setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian_indonesia.1252');

        // 1. Ambil data sewa berdasarkan idSewa dari database
        //    Gantilah 'tb_sewa' dengan nama tabel sewa Anda
        $kontrak = $this->db->where('idSewa', $idSewa)->get('tb_sewa')->row_array();

        if (!$kontrak) {
            // Jika data tidak ditemukan, redirect atau tampilkan error
            $this->session->set_flashdata('error', 'Data kontrak tidak ditemukan.');
            redirect('pedagang/sewa'); // Arahkan kembali ke halaman daftar sewa
        }

        // 2. Ambil nama pedagang berdasarkan idPedagang dari data kontrak
        //    Ini sama seperti yang Anda lakukan di halaman daftar
        $nama_pedagang = $this->db->where('id', $kontrak['idPedagang'])->get('tb_user')->row('nama');
        $NIB = $this->db->where('id', $kontrak['idSewa'])->get('tb_sewa')->row('NIB');
        
        // 3. Siapkan data untuk dikirim ke view
        $data['title'] = 'Cetak Kontrak';
        $data['kontrak'] = $kontrak;
        $data['nama_pedagang'] = $nama_pedagang;
        $data['NIB'] = $NIB;

        // 4. Muat view cetak kontrak
        //    Karena halaman ini standalone (tidak perlu template dashboard), 
        //    kita hanya memuat file view-nya saja.
        $this->load->view('pedagang/cetak_kontrak_view', $data);
    }

	// public function update($id)
	// {
	// 	$idPedagang		= $_POST['idPedagang'];
	// 	$idKios		= $_POST['idKios'];
	// 	$harga			= $_POST['harga'];
	// 	$status			= $_POST['status'];
	// 	$tanggal		= $_POST['tanggal'];

	// 	$data = array(
	// 		'idPedagang' 	=> $idPedagang,
	// 		'idKios' 		=> $idKios,
	// 		'harga' 		=> $harga,
	// 		'tanggal' 		=> $tanggal,
	// 		'status' 		=> $status
	// 	);

	// 	$where = array('id' => $id);

	// 	$this->m_model->update($where, $data, 'tb_sewa');
	// 	$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
	// 	redirect('pedagang/sewa');
	// }
}