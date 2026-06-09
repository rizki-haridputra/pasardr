<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title; ?>
        </h1>
        <p>Data dikelompokkan berdasarkan tanggal dan ID Petugas. Satu kali validasi akan menyelesaikan semua transaksi di grup yang sama.</p>
    </section>

    <section class="content">
        <!-- Hasil Data -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Data Grup Angsuran untuk Divalidasi</h3>
            </div>
            <div class="box-body table-responsive">
                <?= $this->session->flashdata('message'); ?>
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Setor</th>
                            <th>ID Petugas</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Nominal</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($grouped_transaksi)) : ?>
                            <?php $no = 1; foreach ($grouped_transaksi as $grup) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d M Y', strtotime($grup->tanggal)); ?></td>
                                <td><?= htmlspecialchars($grup->IdUserinput, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= $grup->jumlah_transaksi; ?> Transaksi</td>
                                <td>Rp. <?= number_format($grup->total_nominal, 0, ',', '.'); ?></td>
                                <td>
                                    <!-- Link proses menggunakan tanggal dan IdUserinput -->
                                    <a href="<?= base_url('admin/validasis/proses_grup/' . $grup->tanggal . '/' . urlencode($grup->IdUserinput)); ?>" class="btn btn-success btn-sm" onclick="return confirm('Anda yakin ingin memvalidasi semua (<?= $grup->jumlah_transaksi; ?>) transaksi untuk petugas ini di tanggal <?= date('d M Y', strtotime($grup->tanggal)); ?>?')">
                                        <i class="fa fa-check"></i> Validasi Grup
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <p class="text-muted" style="padding: 15px 0;">
                                        Tidak ada data yang perlu divalidasi.
                                    </p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>