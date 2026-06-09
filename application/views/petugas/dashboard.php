<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('petugas/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
      
        <?php 
        // Hanya jalankan blok ini jika levelnya 'Petugas'
        if($this->session->userdata('level') == 'Petugas') { 
            // Ambil ID petugas yang sedang login dari session menggunakan key 'id'
            $id_petugas_login = $this->session->userdata('id'); 

            // --- PERUBAHAN DIMULAI DI SINI ---

            // 1. Tentukan tanggal yang akan ditampilkan
            // Jika ada tanggal dari input form (method GET), gunakan tanggal itu.
            // Jika tidak ada, gunakan tanggal hari ini sebagai default.
            $tanggal_laporan = $this->input->get('tanggal') ? $this->input->get('tanggal') : date('Y-m-d');

            // 2. Query untuk mengambil total pembayaran pada tanggal yang dipilih
            $this->db->where('idUserinput', $id_petugas_login); 
            $this->db->where('tanggal', $tanggal_laporan);
            $this->db->select_sum('nominal');
            $query_harian = $this->db->get('tb_angsuran')->row();
            $total_harian_terpilih = $query_harian->nominal ? $query_harian->nominal : 0;
        ?>
            <!-- KOTAK LAPORAN HARIAN DENGAN PEMILIH TANGGAL -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Laporan Pembayaran Harian</h3>
                </div>
                <div class="box-body">
                    <!-- Form untuk memilih tanggal -->
                    <form action="<?= base_url('petugas/dashboard') ?>" method="get" class="form-inline" style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label for="tanggal">Pilih Tanggal:</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $tanggal_laporan ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>

                    <!-- Tampilan hasil laporan -->
                    <p style="font-size: 16px;">
                        Total Pembayaran Saya pada tanggal <strong><?= date('d F Y', strtotime($tanggal_laporan)) ?></strong>
                    </p>
                    <h3 style="margin-top: 0;">
                        <strong>Rp. <?= number_format($total_harian_terpilih, 0, ',', '.') ?></strong>
                    </h3>
                </div>
                <div class="box-footer">
                    <a href="<?= base_url('petugas/dashboard') ?>">Reset ke Hari Ini</a>
                </div>
            </div>

           <style>
    .info-card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
        color: white;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .info-card .inner {
        padding: 20px;
    }
    
    .info-card h3 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .info-card p {
        font-size: 1rem;
    }

    .info-card .icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 70px;
        opacity: 0.3;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .info-card:hover .icon {
        opacity: 0.5;
        transform: scale(1.1);
    }

    .info-card .small-box-footer {
        background: rgba(0, 0, 0, 0.15);
        display: block;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        color: white;
        transition: background 0.3s ease;
    }

    .info-card .small-box-footer:hover {
        background: rgba(0, 0, 0, 0.3);
    }
    
    /* Variasi Warna Gradient */
    .bg-gradient-blue { background: linear-gradient(45deg, #3a7bd5, #00d2ff); }
    .bg-gradient-green { background: linear-gradient(45deg, #1d976c, #93f9b9); }
    .bg-gradient-orange { background: linear-gradient(45deg, #f2994a, #f2c94c); }
    .bg-gradient-purple { background: linear-gradient(45deg, #6a3093, #a044ff); }

</style>

<div class="row">
    <!-- PEMBAYARAN BULAN INI -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="info-card bg-gradient-blue">
            <div class="inner">
                <h3>
                    <?php
                        $this->db->where('idUserinput', $id_petugas_login); 
                        $this->db->where('MONTH(tanggal)', date('m'));
                        $this->db->where('YEAR(tanggal)', date('Y'));
                        $this->db->select_sum('nominal');
                        $query_bulanan = $this->db->get('tb_angsuran')->row();
                        $total_bulanan = $query_bulanan->nominal ? $query_bulanan->nominal : 0;
                        echo 'Rp ' . number_format($total_bulanan, 0, ',', '.');
                    ?>
                </h3>
                <p>Pembayaran Bulan Ini (<?= date('F Y') ?>)</p>
            </div>
            <div class="icon">
                <i class="fa fa-line-chart"></i>
            </div>
            <a href="<?= base_url('petugas/dashboard/monthly-report') ?>" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <!-- PEMBAYARAN TAHUN INI (TOTAL) -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="info-card bg-gradient-green">
            <div class="inner">
                <h3>
                    <?php
                        $this->db->where('idUserinput', $id_petugas_login); 
                        $this->db->where('YEAR(tanggal)', date('Y'));
                        $this->db->select_sum('nominal');
                        $query_tahunan = $this->db->get('tb_angsuran')->row();
                        $total_tahunan = $query_tahunan->nominal ? $query_tahunan->nominal : 0;
                        echo 'Rp ' . number_format($total_tahunan, 0, ',', '.');
                    ?>
                </h3>
                <p>Total Pembayaran Tahun Ini (<?= date('Y') ?>)</p>
            </div>
            <div class="icon">
                <i class="fa fa-calendar-check-o"></i>
            </div>
            <a href="<?= base_url('petugas/dashboard/yearly-report') ?>" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- PEMBAYARAN BELUM DISERAHKAN -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="info-card bg-gradient-orange">
            <div class="inner">
                <h3>
                    <?php
                        $this->db->where('idUserinput', $id_petugas_login); 
                        $this->db->where('YEAR(tanggal)', date('Y'));
                        $this->db->where('validasi', '');
                        $this->db->select_sum('nominal');
                        $query_belum_valid = $this->db->get('tb_angsuran')->row();
                        $total_belum_valid = $query_belum_valid->nominal ? $query_belum_valid->nominal : 0;
                        echo 'Rp ' . number_format($total_belum_valid, 0, ',', '.');
                    ?>
                </h3>
                <p>Belum Diserahkan (<?= date('Y') ?>)</p>
            </div>
            <div class="icon">
                <i class="fa fa-hourglass-half"></i>
            </div>
            <a href="<?= base_url('petugas/unvalidated-payments') ?>" class="small-box-footer">
                Validasi Sekarang <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- PEMBAYARAN SUDAH DISERAHKAN -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="info-card bg-gradient-purple">
            <div class="inner">
                <h3>
                    <?php
                        $this->db->where('idUserinput', $id_petugas_login); 
                        $this->db->where('YEAR(tanggal)', date('Y'));
                        $this->db->where('validasi', 'validasi');
                        $this->db->select_sum('nominal');
                        $query_valid = $this->db->get('tb_angsuran')->row();
                        $total_valid = $query_valid->nominal ? $query_valid->nominal : 0;
                        echo 'Rp ' . number_format($total_valid, 0, ',', '.');
                    ?>
                </h3>
                <p>Sudah Diserahkan (<?= date('Y') ?>)</p>
            </div>
            <div class="icon">
                <i class="fa fa-check-square-o"></i>
            </div>
            <a href="<?= base_url('petugas/validated-payments') ?>" class="small-box-footer">
                Lihat Riwayat <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
            <!-- --- PERUBAHAN SELESAI --- -->
        <?php } ?>

		<?php 
        // Blok untuk grafik (Tidak ada perubahan di sini, tetap sama)
        if($this->session->userdata('level') == 'Petugas') {
            $id_petugas_login = $this->session->userdata('id');
            $this->db->select("MONTH(tanggal) as bulan, SUM(nominal) as total");
            $this->db->where('idUserinput', $id_petugas_login); 
            $this->db->where("YEAR(tanggal)", date('Y'));
            $this->db->group_by("MONTH(tanggal)");
            $this->db->order_by("MONTH(tanggal)");
            $query_chart = $this->db->get("tb_angsuran");

            $bulan = [];
            $total = [];
            foreach ($query_chart->result() as $row) {
                $bulan[] = date('F', mktime(0, 0, 0, $row->bulan, 10));
                $total[] = $row->total;
            }
            $bulan_chart = json_encode($bulan);
            $total_chart = json_encode($total);
        ?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Grafik Pembayaran Saya Tahun <?= date('Y') ?></h3>
                </div>
                <div class="box-body">
                    <canvas id="angsuranChart" height="100"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Script chart tidak perlu diubah
                const ctx = document.getElementById('angsuranChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line', 
                    data: {
                        labels: <?= $bulan_chart ?>,
                        datasets: [{
                            label: 'Total Pembayaran Saya (Rp)',
                            data: <?= $total_chart ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true, ticks: { callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); } } } },
                        plugins: { tooltip: { callbacks: { label: function(context) { let label = context.dataset.label || ''; if (label) { label += ': '; } if (context.parsed.y !== null) { label += 'Rp ' + context.parsed.y.toLocaleString('id-ID'); } return label; } } } }
                    }
                });
            </script>
        <?php } ?>

    </section>
</div>