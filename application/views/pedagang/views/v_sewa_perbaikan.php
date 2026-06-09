<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('pedagang/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('pedagang/sewa') ?>">Data Sewa</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Formulir Perbaikan Data Sewa (No: <?= $sewa->idSewa ?>)</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <!-- Arahkan form ke metode update yang akan kita buat -->
                        <form action="<?= base_url('pedagang/sewa/update_data_perbaikan/').$sewa->idSewa ?>" method="POST">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                            
                            <div class="form-group">
                                <label>Kode Kios</label>
                                <!-- Buat input ini read-only jika pedagang tidak boleh mengubah kios -->
                                <input type="text" name="idKios" class="form-control" value="<?= $sewa->idKios ?>" readonly>
                                <small class="text-muted">Kode Kios tidak dapat diubah.</small>
                            </div>

                            <div class="form-group">
                                <label>Harga Sewa</label>
                                <input type="number" name="harga" class="form-control" value="<?= $sewa->harga ?>" placeholder="Masukkan harga sewa" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Tanggal Pengajuan</label>
                                <input type="date" name="tanggal" class="form-control" value="<?= $sewa->tanggal ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Catatan dari Petugas</label>
                                <textarea class="form-control" rows="3" readonly><?= $sewa->catatan ?></textarea>
                                <small class="text-muted">Ini adalah alasan mengapa pengajuan Anda perlu diperbaiki.</small>
                            </div>
                            
                            <hr>
                            
                            <div class="form-group text-right">
                                <a href="<?= base_url('pedagang/sewa') ?>" class="btn btn-default">Batal</a>
                                <button type="submit" class="btn btn-primary"><div class="fa fa-save"></div> Kirim Ulang Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
