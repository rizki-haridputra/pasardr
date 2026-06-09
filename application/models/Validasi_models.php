<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasi_models extends CI_Model {

    // Fungsi ini kita biarkan karena berguna untuk mengisi dropdown filter.
    // Ini adalah satu-satunya interaksi di luar tb_angsuran.
    public function get_all_petugas()
    {
        // Pastikan nama tabel (tb_user) dan kolom (id, nama_user) ini benar.
        $this->db->select('id, nama');
        $this->db->order_by('nama', 'ASC'); 
        return $this->db->get('tb_user')->result();
    }

    // --- FUNGSI UTAMA YANG KITA SEDERHANAKAN ---
    // Fungsi dasar untuk mengambil data HANYA dari tb_angsuran
    private function _get_base_query()
    {
        $this->db->select('
            id,
            idUserinput,
            idSewa,
            tanggal,
            nominal,
            keterangan,
            terdaftar,
            validasi
        ');
        $this->db->from('tb_angsuran');
    }

    // Mengambil SEMUA data yang belum divalidasi
    public function get_all_unvalidated_data()
    {
        $this->_get_base_query(); // Panggil query dasar (tanpa join)

        // Kondisi hanya mencari yang belum divalidasi
        // (Kolom 'validasi' masih kosong atau NULL)
        $this->db->where('validasi IS NULL');
        $this->db->or_where('validasi', '');
        
        $this->db->order_by('tanggal', 'DESC');

        return $this->db->get()->result();
    }

    // Mengambil data yang difilter
    public function get_filtered_data_for_validation($tanggal, $id_user_input)
    {
        $this->_get_base_query(); // Panggil query dasar (tanpa join)

        // Kondisi filter
        if (!empty($tanggal)) {
            $this->db->where('tanggal', $tanggal);
        }
        if (!empty($id_user_input)) {
            $this->db->where('IdUserinput', $id_user_input);
        }

        // Kondisi hanya mencari yang belum divalidasi
        $this->db->where('validasi IS NULL');
        $this->db->or_where('validasi', '');
        
        return $this->db->get()->result();
    }

    // Fungsi update tidak berubah, sudah benar.
    public function update_status_validasi($id_angsuran)
    {
        $data = ['validasi' => 'validasi']; // Bisa ditambahkan tgl_validasi jika ada kolomnya
        $this->db->where('id', $id_angsuran); 
        return $this->db->update('tb_angsuran', $data);
    }
}