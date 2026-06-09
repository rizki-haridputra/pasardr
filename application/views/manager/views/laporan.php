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
        <div class="box">
            <form class="form-horizontal" action="<?= base_url('manager/views/laporan/rekap') ?>" method="GET">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Dari Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" name="dariTanggal" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Sampai Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" name="sampaiTanggal" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="reset" class="btn btn-danger">
                            <div class="fa fa-trash"></div> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <div class="fa fa-calendar"></div> Rekap
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tampilan Langsung Pembayaran -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Tampilan Langsung Pembayaran</h3>
            </div>
            <div class="box-body">
                <!-- Formulir filter tetap ada untuk digunakan nanti -->
                <form class="form-horizontal" action="<?= base_url('manager/views/pembayaran/filter_langsung') ?>" method="GET">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Pilih Tanggal</label>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Pilih Petugas</label>
                                <div class="col-sm-8">
                                    <select name="petugas" class="form-control">
                                        <option value="">-- Semua Petugas --</option>
                                        <?php foreach ($petugas as $p): ?>
                                            <option value="<?= $p->id_petugas ?>"><?= $p->nama_petugas ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-info">
                                <div class="fa fa-search"></div> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Tabel untuk menampilkan data pembayaran langsung -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah Bayar</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pembayaran_langsung)) : ?>
                            <?php $no = 1; foreach ($pembayaran_langsung as $data) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($data->nama_pelanggan, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($data->tanggal_bayar, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>Rp <?= number_format($data->jumlah_bayar, 0, ',', '.'); ?></td>
                                    <td><?= htmlspecialchars($data->nama_petugas, ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pembayaran yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->