<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title; ?>
        </h1>
    </section>

    <section class="content">
                    <!-- Hasil Data -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Angsuran untuk Divalidasi</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <?= $this->session->flashdata('message'); ?>
                        
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>ID Sewa</th> <!-- Menampilkan ID -->
                                    <th>ID Petugas</th> <!-- Menampilkan ID -->
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transaksi)) : ?>
                                    <?php $no = 1; foreach ($transaksi as $trx) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= date('d M Y', strtotime($trx->tanggal)); ?></td>
                                        <td><?= htmlspecialchars($trx->idSewa, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars($trx->idUserinput, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>Rp. <?= number_format($trx->nominal, 0, ',', '.'); ?></td>
                                        <td><?= htmlspecialchars($trx->keterangan, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <!-- Link proses menggunakan PK 'id' dari tb_angsuran -->
                                            <a href="<?= base_url('admin/validasi/proses/' . $trx->id); ?>" class="btn btn-success btn-xs" onclick="return confirm('Anda yakin ingin memvalidasi data ini?')">
                                                <i class="fa fa-check"></i> Validasi
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
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

            </div>
        </div>
    </section>
</div>