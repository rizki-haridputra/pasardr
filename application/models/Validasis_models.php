<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasis_models extends CI_Model {

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

      public function get_grouped_unvalidated_data()
    {
        $this->db->select('tanggal, IdUserinput, COUNT(id) as jumlah_transaksi, SUM(nominal) as total_nominal');
        $this->db->from('tb_angsuran'); // Pastikan nama tabel sudah benar
        $this->db->where('validasi',''); // Asumsi 0 = belum divalidasi
        $this->db->group_by(['tanggal', 'IdUserinput']);
        $this->db->order_by('tanggal', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_all_validated_data()
    {
        // Kita gunakan lagi fungsi _get_base_query yang sudah ada
        // jika Anda ingin menampilkan nama, bukan hanya ID
        $this->_get_base_query_with_joins(); // Ganti nama fungsi ini agar lebih jelas

        // Kondisi where untuk mencari data yang sudah divalidasi
        $this->db->where('tb_angsuran.validasi', 'validasi');
        
        // Urutkan berdasarkan tanggal validasi jika ada, atau tanggal angsuran
        // Ganti 'tgl_validasi' dengan kolom Anda, atau biarkan 'tanggal'
        $this->db->order_by('tb_angsuran.tgl_validasi', 'DESC'); 

        return $this->db->get()->result();
    }


    /**
     * Mengubah status validasi untuk semua transaksi dalam satu grup
     * (berdasarkan tanggal dan id petugas).
     */
    public function validate_by_group($tanggal, $id_petugas)
    {
        $data_update = ['validasi' => validasi]; // Asumsi 1 = sudah divalidasi

        $this->db->where('tanggal', $tanggal);
        $this->db->where('IdUserinput', $id_petugas);
        $this->db->where('validasi', ''); // Hanya update yang belum tervalidasi
        
        return $this->db->update('tb_angsuran', $data_update);
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