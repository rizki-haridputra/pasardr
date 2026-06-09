<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small>Perbaiki data sewa untuk Kios <?= $sewa['idKios'] ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('pedagang/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('pedagang/sewa') ?>">Data Sewa</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Formulir Perbaikan Sewa</h3>
            </div>
            <!-- /.box-header -->

            <!-- Form Start -->
            <form role="form" action="<?= base_url('pedagang/sewa/proses_perbaikan') ?>" method="POST" enctype="multipart/form-data">
                <div class="box-body">

                    <!-- Tampilkan catatan perbaikan dari admin -->
                    <div class="callout callout-warning">
                        <h4><i class="fa fa-info-circle"></i> Catatan Perbaikan dari Admin</h4>
                        <p><?= !empty($sewa['catatan']) ? htmlspecialchars($sewa['catatan']) : 'Tidak ada catatan khusus.' ?></p>
                    </div>

                    <!-- Input tersembunyi untuk mengirim ID Sewa saat submit -->
                    <input type="hidden" name="idSewa" value="<?= $sewa['idSewa'] ?>">
                    <input type="hidden" name="idKios" value="<?= $sewa['idKios'] ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No Sewa</label>
                                <input type="text" class="form-control" value="<?= $sewa['idSewa'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Kios</label>
                                <input type="text" class="form-control" value="<?= $sewa['idKios'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Pedagang</label>
                                <input type="text" class="form-control" value="<?= $this->db->where('id', $sewa['idPedagang'])->get('tb_user')->row('nama') ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Sewa</label>
                                <input type="text" class="form-control" value="<?= 'Rp. ' . number_format($sewa['harga'], 0, ',', '.') ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="catatan_pedagang">Catatan Tambahan untuk Admin (Opsional)</label>
                        <textarea class="form-control" name="catatan_pedagang" id="catatan_pedagang" rows="3" placeholder="Contoh: Saya sudah mengunggah ulang bukti transfer sesuai permintaan."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="bukti_pembayaran">Upload Ulang Bukti Pembayaran</label>
                        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran">
                        <p class="help-block">Upload file baru jika bukti pembayaran sebelumnya ditolak. Kosongkan jika tidak ada perubahan file. Format yang diizinkan: JPG, PNG, PDF.</p>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Kirim Perbaikan</button>
                    <a href="<?= base_url('pedagang/sewa') ?>" class="btn btn-default">Batal</a>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
</div>