<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Validasi_models');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = "Validasi Setoran (Mode Sederhana)";

        $tanggal = $this->input->post('tanggal');
        $id_user_input = $this->input->post('IdUserinput');

        $data['petugas_list'] = $this->Validasi_models->get_all_petugas();
        
        $data['selected_tanggal'] = $tanggal;
        $data['selected_petugas'] = $id_user_input;

        // Cek apakah ada proses POST (tombol "Cari" ditekan)
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data['transaksi'] = $this->Validasi_models->get_filtered_data_for_validation($tanggal, $id_user_input);
            $data['is_filtered'] = true;
        } else {
            // Halaman pertama kali dibuka, tampilkan semua
            $data['transaksi'] = $this->Validasi_models->get_all_unvalidated_data();
            $data['is_filtered'] = false;
        }

        $this->load->view('admin/templates/header', $data); 
        $this->load->view('admin/templates/sidebar'); 
        $this->load->view('admin/form_validasi_view', $data); // Arahkan ke view di bawah
        $this->load->view('admin/templates/footer'); 
    }

    public function proses($id_angsuran)
    {
        if (empty($id_angsuran)) {
            redirect('admin/validasi');
        }

        $this->Validasi_models->update_status_validasi($id_angsuran);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil divalidasi!</div>');
        redirect($_SERVER['HTTP_REFERER'] ?? 'admin/validasi');
    }
}