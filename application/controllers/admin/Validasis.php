<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Validasis_models');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = "Validasi Penerimaan (Mode Grup)";

        // Panggil fungsi baru dari model untuk mendapatkan data yang sudah dikelompokkan
        $data['grouped_transaksi'] = $this->Validasis_models->get_grouped_unvalidated_data();

        $this->load->view('admin/templates/header', $data); 
        $this->load->view('admin/templates/sidebar'); 
        // Arahkan ke view yang akan kita buat/modifikasi
        $this->load->view('admin/form_validasi_view_s', $data); 
        $this->load->view('admin/templates/footer'); 
    }

    // Fungsi baru untuk memproses validasi per grup
    public function proses_grup($tanggal, $id_petugas)
    {
        if (empty($tanggal) || empty($id_petugas)) {
            redirect('admin/validasis'); // Gunakan nama controller
        }
        
        // Dekode ID Petugas jika mengandung karakter khusus dari URL
        $decoded_id_petugas = urldecode($id_petugas);

        $this->Validasis_models->validate_by_group($tanggal, $decoded_id_petugas);
        
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Satu grup data berhasil divalidasi!</div>');
        redirect('admin/validasis'); // Redirect kembali ke halaman utama validasi
    }

    /**
     * Fungsi proses per-item ini bisa Anda simpan jika masih dibutuhkan
     * untuk keperluan lain, atau bisa dihapus jika tidak lagi digunakan.
     */
    public function proses($id_angsuran)
    {
        if (empty($id_angsuran)) {
            redirect('admin/validasis');
        }

        $this->Validasis_models->update_status_validasi($id_angsuran);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil divalidasi!</div>');
        redirect($_SERVER['HTTP_REFERER'] ?? 'admin/validasis');
    }
}