<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('manager/viewss/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <?php if($this->session->userdata('level') == 'Manager') { ?>
                    <a href="<?= base_url('manager/viewss/user') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->where('level', 'Manager')->get('tb_user')->num_rows() ?></span>
                        <div class="fa fa-user-secret"></div> Data manager
                    </a>
					<a href="<?= base_url('manager/viewss/Kios') ?>" class="btn btn-app">
                         <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->get('tb_kios')->num_rows() ?></span>
                        <div class="fa fa-users"></div> Data Kios
                    </a>
					<a href="<?= base_url('manager/viewss/lihatkios') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->where('level', 'Manager')->get('tb_user')->num_rows() ?></span>
                        <div class="fa fa-users"></div> Lihat Kios
                    </a>
					<a href="<?= base_url('manager/viewss/pedagang') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->where('level', 'Manager')->get('tb_user')->num_rows() ?></span>
                        <div class="fa fa-users"></div> Data Pedagang
                    </a>
                    <a href="<?= base_url('manager/viewss/verifikasi') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>">
                            <?php
                                $whereNsblk = array('status' => 'Belum Lunas', 'StatusSewa' => 'proses');
                                echo $this->db->where($whereNsblk)->get('tb_sewa')->num_rows();
                            ?>
                        </span>
                        <div class="fa fa-book"></div> Permohonan Sewa
                    </a>
                    
                <?php } else { ?>
                    <a href="<?= base_url('manager/viewss/sewa') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->where('idPedagang', $this->session->userdata('id'))->get('tb_sewa')->num_rows() ?></span>
                        <div class="fa fa-database"></div> Data sewa Saya
                    </a>
                    <a href="<?= base_url('manager/viewss/sewa') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->where('idPedagang', $this->session->userdata('id'))->where('status', 'Belum Lunas')->get('tb_sewa')->num_rows() ?></span>
                        <div class="fa fa-close"></div> sewa Belum Lunas
                    </a>
                    <a href="<?= base_url('manager/viewss/sewa') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->where('idPedagang', $this->session->userdata('id'))->where('status', 'Lunas')->get('tb_sewa')->num_rows() ?></span>
                        <div class="fa fa-check"></div> sewa Belum Lunas
                    </a>
                <?php } ?>
            </div>
        </div>
        <?php if($this->session->userdata('level') == 'Manager') { ?>
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>
                                <?php
                                    $this->db->where('tanggal', date('Y-m-d'));
                                    $this->db->select_sum('nominal');
                                    foreach ($this->db->get('tb_angsuran')->result() as $thariIni) {
                                        echo 'Rp. ' . number_format($thariIni->nominal,0,',','.');
                                    }
                                ?>
                            </h3>

                            <p>Pembayaran <?= date('d M Y') ?></p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-money"></div>
                        </div>
                                    <a href="<?= base_url('manager/viewss/laporan_pendapatan/') ?>" class="small-box-footer">
                        <!-- <a href="<?= base_url('manager/viewss/angsuran') ?>" class="small-box-footer"> -->
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>
                                <?php
                                    $this->db->where('MONTH(tanggal)="'.date('m').'" AND YEAR(tanggal)="'.date('Y').'"');
                                    $this->db->select_sum('nominal');
                                    foreach ($this->db->get('tb_angsuran')->result() as $tBln) {
                                        echo 'Rp. ' . number_format($tBln->nominal,0,',','.');
                                    }
                                ?>
                            </h3>

                            <p>Pembayaran Bulan <?= date('M Y') ?></p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-level-up"></div>
                        </div>
                                <a href="<?= base_url('manager/viewss/laporan/') ?>" class="small-box-footer">
                        <!-- <a href="<?= base_url('manager/viewss/angsuran') ?>" class="small-box-footer"> -->
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                <?php
                                    $this->db->where('YEAR(tanggal)="'.date('Y').'"');
                                    $this->db->select_sum('nominal');
                                    foreach ($this->db->get('tb_angsuran')->result() as $tThn) {
                                        echo 'Rp. ' . number_format($tThn->nominal,0,',','.');
                                    }
                                ?>
                            </h3>

                            <p>Pembayaran Tahun <?= date('Y') ?></p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-calendar"></div>
                        </div>
                        <a href="<?= base_url('manager/viewss/laporan_pendapatan/tahunan') ?>" class="small-box-footer">
                        <!-- <a href="<?= base_url('manager/viewss/angsuran') ?>" class="small-box-footer"> -->
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
		<?php if($this->session->userdata('level') == 'Manager') {
    // Siapkan data angsuran per bulan
    $this->db->select("MONTH(tanggal) as bulan, SUM(nominal) as total");
    $this->db->where("YEAR(tanggal)", date('Y'));
    $this->db->group_by("MONTH(tanggal)");
    $this->db->order_by("MONTH(tanggal)");
    $query = $this->db->get("tb_angsuran");

    $bulan = [];
    $total = [];

    foreach ($query->result() as $row) {
        $bulan[] = date('F', mktime(0, 0, 0, $row->bulan, 10));
        $total[] = $row->total;
    }

    $bulan_chart = json_encode($bulan);
    $total_chart = json_encode($total);
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Grafik Pembayaran Angsuran Tahun <?= date('Y') ?></h3>
    </div>
    <div class="box-body">
        <canvas id="angsuranChart" height="100"></canvas>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('angsuranChart').getContext('2d');
    const chart = new Chart(ctx, {
        // 1. Mengubah tipe grafik menjadi 'line'
        type: 'line', 
        data: {
            labels: <?= $bulan_chart ?>,
            datasets: [{
                label: 'Total Pembayaran (Rp)',
                data: <?= $total_chart ?>,
                
                // 2. Mengatur warna untuk grafik garis
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna area di bawah garis
                borderColor: 'rgba(75, 192, 192, 1)',     // Warna garis utama
                borderWidth: 2,                          // Ketebalan garis
                fill: true,                              // Mengisi area di bawah garis
                tension: 0.1                             // Membuat garis sedikit melengkung (opsional)
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Fungsi callback untuk format Rupiah pada sumbu Y tetap sama
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    // Fungsi callback untuk format Rupiah pada tooltip tetap sama
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
<?php } ?>

    </section>
</div>