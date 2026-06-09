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
        <div class="box">
            <!-- <div class="box-header"> ... </div> -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped dataTable">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>No Sewa</th>
                                <th>Pedagang</th>
                                <th>Kode Kios</th>
                                <th>Harga</th>
                                <th>Terbayar</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                // Mendapatkan tahun dan bulan saat ini untuk perbandingan
                                $bulanIni = date('Y-m');

                                foreach ($sewa->result_array() as $row) {
                                // --- AWAL BLOK LOGIKA OTOMATIS ---
                                
                                // 1. Hitung total yang sudah terbayar
                                $this->db->select_sum('nominal', 'total_terbayar');
                                $this->db->where('idSewa', $row['id']);
                                $query_angsuran = $this->db->get('tb_angsuran');
                                $hasil_angsuran = $query_angsuran->row();
                                $totalTerbayar = $hasil_angsuran->total_terbayar ?? 0;

                                // 2. Tentukan status berdasarkan perbandingan harga dan total terbayar
                                $hargaSewa = (float) $row['harga'];
                                if ($totalTerbayar >= $hargaSewa) {
                                    $statusText = 'Lunas';
                                    $statusClass = 'success';
                                } else {
                                    $statusText = 'Kurang Bayar';
                                    $statusClass = 'danger';
                                }
                                // --- AKHIR BLOK LOGIKA OTOMATIS ---

                                // --- AWAL LOGIKA FILTER ---
                                // Ambil tahun dan bulan dari data sewa
                                $bulanSewa = date('Y-m', strtotime($row['tanggal']));

                                // Tampilkan baris HANYA JIKA statusnya 'Kurang Bayar' DAN bulannya sebelum bulan ini
                                if ($statusText == 'Kurang Bayar' && $bulanSewa <= $bulanIni) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['idSewa'] ?></td>
                                    <td><?= $this->db->where('id', $row['idPedagang'])->get('tb_user')->row('nama') ?></td>
                                    <td><?= $row['idKios'] ?></td>
                                    <td><?= 'Rp. ' . number_format($hargaSewa, 0, ',', '.') ?></td>
                                    <td>Rp. <?= number_format($totalTerbayar, 0, ',', '.') ?></td>
                                    <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                                    <td>
                                        <div class="label label-<?= $statusClass ?>"><?= $statusText ?></div>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('petugas/angsuran/pembayaran/').$row['id'] ?>" class="btn btn-success btn-xs">
                                            <div class="fa fa-history"></div> History
                                        </a>
                                        <?php if($this->session->userdata('level') == 'Petugas') { ?>
                                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                <div class="fa fa-edit"></div> Edit
                                            </button>
                                            <a href="<?= base_url('petugas/Sewa/delete/').$row['id'] ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Ingin menghapus data ini?">
                                                <div class="fa fa-trash"></div> Delete
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php 
                                    } // --- AKHIR LOGIKA FILTER ---
                                } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Data (Tidak ada perubahan) -->
<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <!-- ... Konten modal ... -->
</div>

<!-- Modal Edit Data (Tidak ada perubahan) -->
<?php foreach ($sewa->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
       <!-- ... Konten modal ... -->
    </div>
<?php } ?>