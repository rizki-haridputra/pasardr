<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            
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
                                    <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                                    <td>
                                    <div class="label label-warning"><?= $row['StatusSewa'] ?></div>
                                    </td>
                                    <td>
                                        <?php if($this->session->userdata('level') == 'Administrator') { ?>
                                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                <div class="fa fa-edit"></div> Verifikasi
                                            </button>
                                         <!--    <?php if($this->session->userdata('level') == 'Administrator') { ?>
                                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                <div class="fa fa-edit"></div> Perbaikan
                                            </button>
                                            
                                             <?php if($statusText == 'Kurang Bayar') { // Kondisi disesuaikan dengan status otomatis ?>
                                                <a href="<?= base_url('admin/Sewa/delete/').$row['id'] ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Ingin menghapus data ini?">
                                                    <div class="fa fa-trash"></div> Delete
                                                </a>
                                            <?php } ?> -->
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
            <form action="<?= base_url('admin/Sewa/insert') ?>" method="POST">
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
                    <h4 class="modal-title" id="myModalLabel">Verifikasi <?= $title ?></h4>
                </div>
                <form action="<?= base_url('admin/verifikasi/update/').$edit->id ?>" method="POST">
                       
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
<!--                     
                    
                    <div class="modal-body">                        
                        <div class="form-group">
                            <label>Pedagang</label>
                            <input type="text" name="nama" class="form-control" value="<?= $edit->id ?>"  readonly required>
                        </div>
                        <div class="form-group">
                            <label>Kios</label>
                            <input type="text" name="idKios" class="form-control" value="<?= $edit->idKios ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" value="<?= $edit->harga ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= $edit->tanggal ?>" readonly  required>
                        </div>
                        
                        <div class="form-group">
                            <label>KTP Ahli Waris</label>
                          <img src="<?= base_url('assets/NIB/' . htmlentities($row['fotoKTPahliWaris']) )?>"  style="width: 200px; height: 200s0px;" >
                        </div>

                        
                        <div class="form-group">
                            <label>Berkas NIB</label>
                          <img src="<?= base_url('assets/NIB/' . htmlentities($row['fotoNIB']) )?>"  style="width: 200px; height: 200s0px;" >
                        </div>
                        -->

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


                         <div class="form-group">  
                        <label>Status Sewa</label>
                        <select  name="StatusSewa"  class="form-control" required>
                              <option value="verifikasi">Verifikasi</option>
                              <option value="perbaikan">Perbaikan</option>
                        </select>
                        </div>

                        <div class="form-group">  
                        <label>Catatan Kekurangan
                            <br> <h6>Kosongkan jika semua data lengkap!</h6>
                        </label>
                        <textarea name="catatan"  class="form-control" >
                        </textarea>
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