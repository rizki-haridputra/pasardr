<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small>Kios Nomor: <strong><?= htmlspecialchars($id_kios) ?></strong></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('admin/pasarbaru') ?>">Denah Kios</a></li>
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
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?= form_open_multipart('admin/sewa/insert', ['class' => 'form-horizontal']) ?>
                        <div class="box-body">
                            <!-- Hidden input untuk menyimpan ID Kios -->
                            <input type="hidden" name="id_kios" value="<?= htmlspecialchars($id_kios) ?>">

                            <h4>Data Diri Penyewa</h4>
                            <hr>
                            <div class="form-group">
                                <label for="id_penyewa" class="col-sm-2 control-label">Nama Pedagang</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" name="id_penyewa" placeholder="Masukkan Nama Lengkap" value="<?= set_value('id_penyewa') ?>"> -->
                                  <select name="id" id="select" class="form-control" required>
                                                    <option value="">Pilih Pedagang</option>
                                                    <?php foreach ($user as $item) {
                                                    ?>
                                                        <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
                                                    <?php } ?>
                                                </select>

                                    <?= form_error('id_penyewa', '<small class="text-danger">', '</small>') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nib_penyewa" class="col-sm-2 control-label">NIB</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nib_penyewa" placeholder="16 Digit NIB" value="<?= set_value('nib_penyewa') ?>">
                                     <?= form_error('nib_penyewa', '<small class="text-danger">', '</small>') ?>
                                </div>
                            </div>
                            
                            <!--  //DATA INI SUDAH ADA PADA TABEL USER DI DATABASE
                            <div class="form-group">
                                <label for="alamat_penyewa" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="alamat_penyewa" rows="3" placeholder="Alamat sesuai KTP"><?= set_value('alamat_penyewa') ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp_penyewa" class="col-sm-2 control-label">No. HP (Aktif)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="no_hp_penyewa" placeholder="Contoh: 08123456789" value="<?= set_value('no_hp_penyewa') ?>">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="email_penyewa" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email_penyewa" placeholder="email@contoh.com (Opsional)" value="<?= set_value('email_penyewa') ?>">
                                </div>
                            </div> -->

                            <br>
                            <h4>Data Ahli Waris</h4>
                            <hr>
                            <div class="form-group">
                                <label for="nama_ahli_waris" class="col-sm-2 control-label">Nama Ahli Waris</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_ahli_waris" placeholder="Nama Lengkap Ahli Waris" value="<?= set_value('nama_ahli_waris') ?>">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="nik_ahli_waris" class="col-sm-2 control-label">NIK Ahli Waris</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nik_ahli_waris" placeholder="16 Digit NIK Ahli Waris" value="<?= set_value('nik_ahli_waris') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hubungan_ahli_waris" class="col-sm-2 control-label">Hubungan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="hubungan_ahli_waris" placeholder="Contoh: Anak, Istri, Suami, Orang Tua" value="<?= set_value('hubungan_ahli_waris') ?>">
                                </div>
                            </div>

                            <br>
                            <h4>Detail Sewa & Usaha</h4>
                            <hr>
                            <div class="form-group">
                                <label for="tanggal_mulai_sewa" class="col-sm-2 control-label">Tanggal Mulai Sewa</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="tanggal_mulai_sewa" value="<?= set_value('tanggal_mulai_sewa') ?>">
                                     <?= form_error('tanggal_mulai_sewa', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <!-- <label for="tanggal_akhir_sewa" class="col-sm-2 control-label">Tanggal Akhir Sewa</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="tanggal_akhir_sewa" value="<?= set_value('tanggal_akhir_sewa') ?>">
                                </div> -->
                            </div>
                            <div class="form-group">
                                <label for="jenis_dagangan" class="col-sm-2 control-label">Jenis Dagangan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jenis_dagangan" placeholder="Contoh: Pakaian, Sembako, Makanan" value="<?= set_value('jenis_dagangan') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="harga" class="col-sm-2 control-label">Harga Kios</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="harga" placeholder="Masukkan harga kios" value="<?= set_value('harga') ?>">
                                </div>
                            </div>

                             <br>
                            <h4>Unggah Dokumen</h4>
                            <hr>
                             <div class="form-group">
                                <label for="foto_nib" class="col-sm-2 control-label">Foto NIB</label>
                                <div class="col-sm-10">
                                    <input type="file" name="foto_nib" class="form-control">
                                    <small class="help-block">Tipe file yang diizinkan: JPG, PNG, PDF. Ukuran maks: 2MB.</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="foto_ktp_ahli_waris" class="col-sm-2 control-label">Foto KTP Ahli Waris</label>
                                <div class="col-sm-10">
                                    <input type="file" name="foto_ktp_ahli_waris" class="form-control">
                                     <small class="help-block">Tipe file yang diizinkan: JPG, PNG, PDF. Ukuran maks: 2MB.</small>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="<?= base_url('admin/pasarbaru') ?>" class="btn btn-default">Batal</a>
                            <button type="submit" class="btn btn-primary pull-right">Simpan Data Sewa</button>
                        </div>
                        <!-- /.box-footer -->
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>