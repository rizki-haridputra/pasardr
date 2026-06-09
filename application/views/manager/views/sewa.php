<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/views/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <!-- <?php if($this->session->userdata('level') == 'manager') { ?>
                <div class="box-header">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                        <div class="fa fa-plus"></div> Tambah Data
                    </button>
                </div>
            <?php } ?> -->
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
                                foreach ($sewa->result_array() as $row) {
                                // --- AWAL BLOK LOGIKA OTOMATIS ---
                                
                                // 1. Hitung total yang sudah terbayar
                                $this->db->select_sum('nominal', 'total_terbayar');
                                $this->db->where('idSewa', $row['id']);
                                $query_angsuran = $this->db->get('tb_angsuran');
                                $hasil_angsuran = $query_angsuran->row();
                                $totalTerbayar = $hasil_angsuran->total_terbayar ?? 0; // Jika belum ada angsuran, nilainya 0

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
                                        <a href="<?= base_url('admin/views/angsuran/pembayaran/').$row['id'] ?>" class="btn btn-success btn-xs">
                                            <div class="fa fa-history"></div> History
                                        </a>
                                        <?php if($this->session->userdata('level') == 'manager') { ?>
                                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                <div class="fa fa-edit"></div> Edit
                                            </button>
                                            <?php if($statusText == 'Kurang Bayar') { // Kondisi disesuaikan dengan status otomatis ?>
                                                <a href="<?= base_url('admin/views/Sewa/delete/').$row['id'] ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Ingin menghapus data ini?">
                                                    <div class="fa fa-trash"></div> Delete
                                                </a>
                                            <?php } ?>
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah <?= $title ?></h4>
            </div>
            <form action="<?= base_url('admin/views/Sewa/insert') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nasabah</label>
                        <select name="idPedagang" class="select2" style="width: 100%" required>
                            <option value="" disabled selected> -- Pilih Nasabah -- </option>
                            <?php foreach ($nasabah->result() as $iNsb) { ?>
                                <option value="<?= $iNsb->id ?>"><?= $iNsb->nama . ' - ' . $iNsb->jenisKelamin . ' - ' . $iNsb->telp ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kode Kios</label>
                        <input type="text" name="idKios" class="form-control" placeholder="Id Kiios" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Harga" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" required>
                    </div>
                    <!-- Input Status dihapus karena sudah otomatis -->
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
<?php foreach ($sewa->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title ?></h4>
                </div>
                <form action="<?= base_url('admin/views/Sewa/update/').$edit->id ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nasabah</label>
                            <select name="idPedagang" class="select2" style="width: 100%" required>
                                <?php
                                    $this->db->where('id', $edit->idPedagang);
                                    foreach ($this->db->get('tb_user')->result() as $sNsb) { ?>
                                    <option value="<?= $sNsb->id ?>" selected><?= $sNsb->nama . ' - ' . $sNsb->jenisKelamin . ' - ' . $sNsb->telp ?></option>
                                <?php } ?>
                                <option value="" disabled> -- Pilih Nasabah Lain -- </option>
                                <?php foreach ($nasabah->result() as $iNsb) { ?>
                                    <option value="<?= $iNsb->id ?>"><?= $iNsb->nama . ' - ' . $iNsb->jenisKelamin . ' - ' . $iNsb->telp ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kios</label>
                            <input type="text" name="idKios" class="form-control" value="<?= $edit->idKios ?>" placeholder=Id Kios" required>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" value="<?= $edit->harga ?>" placeholder="Harga" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= $edit->tanggal ?>" placeholder="Tanggal" required>
                        </div>
                         <!-- Input Status dihapus karena sudah otomatis -->
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