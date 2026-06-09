<?php

namespace App\Controllers;

class Cron extends BaseController
{
    /**
     * Metode ini akan dipanggil oleh Cron Job.
     * URL: http://domain-anda.com/cron/updateKiosStatus
     */
    public function updateKiosStatus()
    {
        // --- SEKURITI PENTING! ---
        // Pastikan hanya cron job yang bisa menjalankan ini, bukan pengunjung biasa.
        // Cara 1: Cek apakah dijalankan dari Command Line (CLI)
        if (!is_cli()) {
            // Jika bukan dari CLI, bisa juga cek token rahasia dari URL
            $token = $this->request->getGet('token');
            if ($token !== 'RAHASIA_SUPER_AMAN_GANTI_INI') {
                echo "Akses ditolak!";
                return; // Hentikan eksekusi
            }
        }

        // Hubungkan ke database
        $db = \Config\Database::connect();
        
        // Gunakan Query Builder untuk keamanan dan kemudahan
        $builder = $db->table('tb_kios');
        
        // Set nilai status menjadi string kosong
        $builder->set('tb_kios.status', '');

        // Gabungkan dengan tb_sewa
        $builder->join('tb_sewa', 'tb_kios.idKios = tb_sewa.idKios');

        // Kondisi WHERE
        $builder->where('tb_kios.status <> tb_sewa.status');
        $builder->where('MONTH(tb_sewa.tanggal_sewa)', date('m')); // Bulan saat ini
        $builder->where('YEAR(tb_sewa.tanggal_sewa)', date('Y'));  // Tahun saat ini

        // Eksekusi query UPDATE
        $builder->update();
        
        // (Opsional) Beri output untuk logging atau debugging
        echo "Proses update status kios selesai. " . $db->affectedRows() . " baris diperbarui.";
    }
}