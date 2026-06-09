<?php
// --- PERSIAPAN DATA ---
// Ambil data sewa (kita asumsikan hanya ada 1 baris)
$dataSewa = $sewa->row_array();

// Hitung total pembayaran yang sudah ada
$totalPembayaran = 0;
$queryTotal = $this->db->select_sum('nominal', 'total')->where('idSewa', $idSewa)->get('tb_angsuran')->row();
if ($queryTotal) {
    $totalPembayaran = $queryTotal->total;
}

// Hitung sisa pembayaran
$sisaPembayaran = $dataSewa['harga'] - $totalPembayaran;

// Pastikan sisa tidak negatif (jaga-jaga)
$sisaPembayaran = ($sisaPembayaran < 0) ? 0 : $sisaPembayaran;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('manager/views/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header">
                        <button class="btn btn-primary" onclick="history.back(-1)">
                            <div class="fa fa-arrow-left"></div> Kembali
                        </button>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <td>No sewa</td>
                                    <td>:</td>
                                    <td><?= $dataSewa['idSewa'] ?></td>
                                </tr>
                                <tr>
                                    <td>Nasabah</td>
                                    <td>:</td>
                                    <td><?= $this->db->where('id', $dataSewa['idPedagang'])->get('tb_user')->row('nama') ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Barang</td>
                                    <td>:</td>
                                    <td><?= $dataSewa['idKios'] ?></td>
                                </tr>
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td><?= 'Rp. ' . number_format($dataSewa['harga'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td><?= date('d F Y', strtotime($dataSewa['tanggal'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Total Pembayaran</td>
                                    <td>:</td>
                                    <td><?= 'Rp. ' . number_format($totalPembayaran, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Sisa Pembayaran</td>
                                    <td>:</td>
                                    <td><?= 'Rp. ' . number_format($sisaPembayaran, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        <!-- Status akan mengikuti data terbaru dari DB setelah controller diupdate -->
                                        <div class="label label-<?= ($dataSewa['status'] == 'Lunas') ? 'success' : 'danger' ?>">
                                            <?= $dataSewa['status'] ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box">
                    <?php if ($this->session->userdata('level') == 'manager') { ?>
                        <div class="box-header">
                            <!-- Tombol Tambah hanya muncul jika belum lunas -->
                            <?php if ($dataSewa['status'] != 'Lunas') : ?>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                                    <div class="fa fa-plus"></div> Tambah Data
                                </button>
                            <?php endif; ?>
                            <a href="<?= base_url('manager/views/angsuran/cetakpembayaran/') . $idSewa ?>" class="btn btn-warning" target="blank">
                                <div class="fa fa-print"></div> Cetak Data
                            </a>
                        </div>
                    <?php } ?>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th>Tanggal</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                        <?php if ($this->session->userdata('level') == 'manager') { ?>
                                            <th>Aksi</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($angsuran->result() as $ang) {
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d F Y', strtotime($ang->tanggal)) ?></td>
                                            <td><?= 'Rp. ' . number_format($ang->nominal, 0, ',', '.') ?></td>
                                            <td><?= $ang->keterangan ?></td>
                                            <?php if ($this->session->userdata('level') == 'manager') { ?>
                                                <td>
                                                    <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $ang->id ?>">
                                                        <div class="fa fa-edit"></div> Edit
                                                    </button>
                                                    <a href="<?= base_url('manager/views/angsuran/delete/') . $ang->id . '/' . $idSewa ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Ingin menghapus data ini?">
                                                        <div class="fa fa-trash"></div> Delete
                                                    </a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah <?= $title ?></h4>
            </div>
            <form action="<?= base_url('manager/views/angsuran/insert/') . $idSewa ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <!-- PERBAIKAN: Tambahkan atribut max untuk membatasi input -->
                        <input type="number" name="nominal" class="form-control" placeholder="Nominal" max="<?= $sisaPembayaran ?>" required>
                        <small class="text-info">Maksimal pembayaran: <?= 'Rp. ' . number_format($sisaPembayaran, 0, ',', '.') ?></small>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" value="Pembayaran Angsuran" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger"><div class="fa fa-trash"></div> Reset</button>
                    <button type="submit" class="btn btn-primary"><div class="fa fa-save"></div> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php foreach ($angsuran->result() as $edit) {
    // Hitung batas maksimal untuk edit. Rumusnya: sisa pembayaran saat ini + nominal yang sedang diedit
    $maxUntukEdit = $sisaPembayaran + $edit->nominal;
?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title ?></h4>
                </div>
                <form action="<?= base_url('manager/views/angsuran/update/') . $idSewa . '/' . $edit->id ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="<?= $edit->tanggal ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                             <!-- PERBAIKAN: Tambahkan atribut max untuk membatasi input saat edit -->
                            <input type="number" name="nominal" class="form-control" placeholder="Nominal" value="<?= $edit->nominal ?>" max="<?= $maxUntukEdit ?>" required>
                            <small class="text-info">Maksimal pembayaran: <?= 'Rp. ' . number_format($maxUntukEdit, 0, ',', '.') ?></small>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" value="<?= $edit->keterangan ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger"><div class="fa fa-trash"></div> Reset</button>
                        <button type="submit" class="btn btn-primary"><div class="fa fa-save"></div> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>