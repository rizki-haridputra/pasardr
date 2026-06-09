<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pendapatan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Pastikan hanya manager yang bisa mengakses
        if($this->session->userdata('level') != 'manager'){
            redirect('manager/views/dashboard');
        }
        // Load model yang dibutuhkan jika ada, misalnya model angsuran
        // $this->load->model('Angsuran_model');
    }

    public function index($periode = 'harian') // default ke harian
    {
        $data['title'] = 'Laporan Pendapatan';
        $data['periode'] = $periode;

        if ($periode == 'harian') {
            $data['subtitle'] = 'Harian (' . date('d M Y') . ')';
            $this->db->where('tanggal', date('Y-m-d'));
        } elseif ($periode == 'bulanan') {
            $data['subtitle'] = 'Bulanan (' . date('M Y') . ')';
            $this->db->where('MONTH(tanggal)', date('m'));
            $this->db->where('YEAR(tanggal)', date('Y'));
        } elseif ($periode == 'tahunan') {
            $data['subtitle'] = 'Tahunan (' . date('Y') . ')';
            $this->db->where('YEAR(tanggal)', date('Y'));
        }

        // Ambil data angsuran berdasarkan periode
        $data['laporan'] = $this->db->get('tb_angsuran')->result();

        // Load view untuk menampilkan laporan// ... bagian atas fungsi index() ...

        // Load view untuk menampilkan laporan (INI YANG BENAR)
        $this->load->view('manager/templates/header', $data); // Gunakan 'templates'
        $this->load->view('manager/templates/sidebar');       // Tambahkan ini agar layout tidak rusak
        $this->load->view('manager/views/laporan_pendapatan_view', $data);
        $this->load->view('manager/templates/footer');       // Gunakan 'templates'
            }
}