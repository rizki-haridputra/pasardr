<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sewa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Memuat library database
    }

    /**
     * Fungsi ini memperbarui status di tb_sewa berdasarkan statusSewa di tb_kios
     * untuk sewa yang berada di bulan dan tahun saat ini.
     */
    public function updateStatusSewaOtomatis() {
        // Mendapatkan bulan dan tahun saat ini
        $bulan_sekarang = date('m');
        $tahun_sekarang = date('Y');

        // Menyiapkan query UPDATE dengan JOIN menggunakan Query Builder
        // CI3 tidak secara langsung mendukung UPDATE...JOIN melalui metode standar,
        // jadi menggunakan query manual lebih aman dan jelas.
        $sql = "UPDATE tb_sewa
                JOIN tb_kios ON tb_sewa.idKios = tb_kios.idKios
                SET tb_sewa.status = tb_kios.status
                WHERE MONTH(tb_sewa.tanggal) = ? AND YEAR(tb_sewa.tanggal) = ?";

        // Menjalankan query dengan binding untuk keamanan
        $this->db->query($sql, array($bulan_sekarang, $tahun_sekarang));
    }
}