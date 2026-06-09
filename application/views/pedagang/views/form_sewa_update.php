<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small>Id Sewa: <strong><?= htmlspecialchars($sewa->idSewa) ?></strong></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('pedagang/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('pedagang/pasarbaru') ?>">Denah Kios</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Isi Data Penyewa</h3>
                    </div>
                        <div class="box-body">
                            <!-- Arahkan action form ke fungsi update_perbaikan yang baru dibuat -->
                            <form method="POST" action="<?= base_url('pedagang/sewa/perbaikan/'.$sewa->idSewa); ?>" >
                                
                                <input type="hidden" name="idSewa" value="<?= $sewa->idSewa; ?>">
                                
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIB Penyewa</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" name="nib_penyewa" class="form-control" value="<?= $sewa->NIB; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto NIB</label>
                                    <div class="col-sm-12 col-md-7">
                                        <img src="<?= base_url('assets/NIB/' . $sewa->fotoNIB); ?>" width="150" class="mb-2">
                                        <input type="file" name="foto_nib" class="form-control">
                                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto NIB.</small>
                                    </div>
                                </div>
                                
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Ahli Waris</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" name="nama_ahli_waris" class="form-control" value="<?= $sewa->namaAhliWaris; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIK Ahli Waris</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" name="nik_ahli_waris" class="form-control" value="<?= $sewa->NIKahliWaris; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Hubungan Ahli Waris</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" name="hubungan_ahli_waris" class="form-control" value="<?= $sewa->Hubungan; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto KTP Ahli Waris</label>
                                    <div class="col-sm-12 col-md-7">
                                        <img src="<?= base_url('assets/KTP/' . $sewa->fotoKTPahliWaris); ?>" width="150" class="mb-2">
                                        <input type="file" name="foto_ktp_ahli_waris" class="form-control">
                                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto KTP.</small>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Dagangan</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" name="jenis_dagangan" class="form-control" value="<?= $sewa->jenisDagang; ?>" required>
                                    </div>
                                </div>
                                
                                <!-- INI ADALAH BAGIAN UTAMA UNTUK EDIT STATUS SEWA -->
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Pengajuan</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select name="StatusSewa" class="form-control" required>
                                            <option value="proses" <?= ($sewa->StatusSewa == 'proses') ? 'selected' : ''; ?>>Ajukan Ulang (Proses)</option>
                                            <option value="perbaikan" <?= ($sewa->StatusSewa == 'perbaikan') ? 'selected' : ''; ?>>Simpan sebagai Draft (Perbaikan)</option>
                                            <!-- Tambahkan opsi lain jika diperlukan -->
                                        </select>
                                        <small class="form-text text-muted">Ubah status untuk mengajukan ulang data perbaikan.</small>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button type="submit" class="btn btn-primary">Update Data</button>
                                        <a href="<?= base_url('pedagang/sewa'); ?>" class="btn btn-danger">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>