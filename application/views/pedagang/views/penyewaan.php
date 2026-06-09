<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('pedagang/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <!-- Tampilkan pesan sukses/error dari session -->
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error')) { ?>
                     <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>

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
                                <th>Status Sewa</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($sewa->result_array() as $row) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['idSewa'] ?></td>
                                    <td><?= $this->db->where('id', $row['idPedagang'])->get('tb_user')->row('nama') ?></td>
                                    <td><?= $row['idKios'] ?></td>
                                    <td><?= 'Rp. ' . number_format($row['harga'], 0, ',', '.') ?></td>
                                    <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                                    <td>
                                        <?php if($row['StatusSewa']=='perbaikan'){ ?>
                                            <div class="label label-warning"><?= ucfirst($row['StatusSewa']) ?></div>
                                        <?php } else if($row['StatusSewa']=='verifikasi'){ ?>
                                            <div class="label label-primary"><?= ucfirst($row['StatusSewa']) ?></div>
                                        <?php } else if($row['StatusSewa']=='validasi'){ ?>
                                            <div class="label label-info"><?= ucfirst($row['StatusSewa']) ?></div>
                                        <?php } else { ?>
                                            <div class="label label-success"><?= ucfirst($row['StatusSewa']) ?></div> 
                                        <?php } ?>
                                    </td>
                                    <td><?= $row['catatan'] ?></td>
                                    <td>
                                        <?php if($row['StatusSewa'] == 'perbaikan') { ?>
                                            <a href="<?= base_url('pedagang/sewa/formu/').$row['idSewa'] ?>" class="btn btn-primary btn-xs">
                                                <div class="fa fa-wrench"></div> Perbaikan
                                            </a>
                                        <?php } ?> 
                                        <?php if($row['StatusSewa'] == 'validasi') { ?>
                                            <a href="<?= base_url('pedagang/sewa/cetakkontrak/').$row['idSewa'] ?>" class="btn btn-success btn-xs">
                                                <div class="fa fa-print"></div> Cetak Kontrak
                                            </a>
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