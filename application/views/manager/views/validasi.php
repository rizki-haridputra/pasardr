<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('manager/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
             <div class="box-header">
                    
                </div>
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
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($validasi->result_array() as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['idSewa'] ?></td>
                                    <td><?= $this->db->where('id', $row['idPedagang'])->get('tb_user')->row('nama') ?></td>
                                    <td><?= $row['idKios'] ?></td>
                                    <td><?= $row['harga'] ?></td>
                                    <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                                    <td>
                                    <div class="label label-primary"><?= $row['StatusSewa'] ?></div>
                                    </td>
                                    <td>
                                        
                                        <?php if($this->session->userdata('level') == 'Manager') { ?>
                                            <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                <div class="fa fa-edit"></div> Validasi
                                            </button>
                                        
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Modal Edit Data -->
<?php foreach ($validasi->result() as $edit) : ?>
    <!-- Modal Edit Data -->
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?= $edit->id ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel<?= $edit->id ?>">Validasi Data</h4>
                </div>
                <form action="<?= base_url('manager/validasi/update/' . $edit->id) ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    
                    <div class="modal-body">
                        <div class="card border-light shadow-sm">
                            
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold" style="width: 150px;">Pedagang</td>
                                            <td>: <?= htmlspecialchars($edit->id) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">NIB</td>
                                            <td>: <?= htmlspecialchars($edit->NIB) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Ahli Waris</td>
                                            <td>: <?= htmlspecialchars($edit->namaAhliWaris) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Nik Waris</td>
                                            <td>: <?= htmlspecialchars($edit->NIKahliWaris) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Hubungan</td>
                                            <td>: <?= htmlspecialchars($edit->Hubungan) ?></td>

                                        <tr>
                                            <td class="fw-bold">Tanggal Sewa</td>
                                            <td>: <?= htmlspecialchars($edit->idKios) ?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Yang Akan Dijual</td>
                                            <td>: <?= htmlspecialchars($edit->jenisDagang) ?></td>
                                        </tr>                                        
                                        <tr>
                                            <td class="fw-bold">Harga</td>
                                            <td>: Rp <?= number_format($edit->harga, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tanggal</td>
                                            <td>: <?= date('d F Y', strtotime($edit->tanggal)) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
<!-- Baris untuk Berkas Gambar, dibuat berdampingan -->
<div class="row mb-3">

    <!-- Kolom 1: KTP Ahli Waris -->
    <div class="col-md-6">
        <div class="form-group">
            <!-- Header: Label dan Tombol Lihat -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="mb-0 fw-bold">1. KTP</label>
                <a href="<?= base_url('assets/NIB/' . htmlspecialchars($row['fotoKTPahliWaris'])) ?>" class="btn btn-outline-info btn-sm" target="_blank">
                    <i class="fa fa-eye"></i> Lihat Berkas
                </a>
            </div>
            <!-- Thumbnail Gambar -->
            <a href="<?= base_url('assets/NIB/' . htmlspecialchars($row['fotoKTPahliWaris'])) ?>" target="_blank">
                <img src="<?= base_url('assets/NIB/' . htmlspecialchars($row['fotoKTPahliWaris'])) ?>" alt="KTP Ahli Waris" class="img-fluid img-thumbnail" style="height: 200px; width: 100%; object-fit: cover;">
            </a>
        </div>
    </div>

    <!-- Kolom 2: Berkas NIB -->
    <div class="col-md-6">
        <div class="form-group">
            <!-- Header: Label dan Tombol Lihat -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="mb-0 fw-bold">2. Berkas NIB</label>
                <a href="<?= base_url('assets/NIB/' . htmlspecialchars($row['fotoNIB'])) ?>" class="btn btn-outline-info btn-sm" target="_blank">
                    <i class="fa fa-eye"></i> Lihat Berkas
                </a>
            </div>
            <!-- Thumbnail Gambar -->
            <a href="<?= base_url('assets/NIB/' . htmlspecialchars($row['fotoNIB'])) ?>" target="_blank">
                <img src="<?= base_url('assets/NIB/' . htmlspecialchars($row['fotoNIB'])) ?>" alt="Berkas NIB" class="img-fluid img-thumbnail" style="height: 200px; width: 100%; object-fit: cover;">
            </a>
        </div>
    </div>

</div> <!-- Akhir dari .row untuk gambar -->

<!-- Pemisah Visual untuk kerapian -->
<hr class="my-4">

<!-- Baris Baru untuk Input Status Sewa -->
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="StatusSewa_<?= $edit->id ?>" class="form-label fw-bold">3. Tindakan Validasi</label>
            <select id="StatusSewa_<?= $edit->id ?>" name="StatusSewa" class="form-control form-control-lg" required>
                <option value="" disabled selected>-- Pilih Status Tindakan --</option>
                <option value="validasi">Validasi Diterima</option>
                <option value="perbaikan">Butuh Perbaikan</option>
            </select>
            <div class="form-text">Pilih status untuk melanjutkan proses sewa.</div>
        </div>
    </div>
</div>

                        <div class="form-group">
                            <label for="catatan<?= $edit->id ?>">
                                Catatan Kekurangan
                                <small class="d-block">Kosongkan jika semua data lengkap!</small>
                            </label>
                            <textarea id="catatan<?= $edit->id ?>" name="catatan" class="form-control"></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Validasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>