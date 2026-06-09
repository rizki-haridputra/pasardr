<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('manager/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <form class="form-horizontal" action="<?= base_url('manager/angsuran/search') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Sewa</label>
                        <div class="col-sm-10">
                            <select name="idSewa" class="select2" style="width: 100%" required>
                                <option value="" disabled selected> -- Pilih Sewa -- </option>
                                <?php foreach ($sewa->result_array() as $row) { ?>
                                    <option value="<?= $row['id'] ?>">
                                        <?= $row['idSewa'] . ' - ' . $this->db->where('id', $row['idPedagang'])->get('tb_user')->row('nama') . ' - ' . $row['idKios'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <font color="red">
                        <small><i>NB : Hanya status Sewa belum lunas yang akan muncul</i></small>
                    </font>
                    <div class="pull-right">
                        <button type="reset" class="btn btn-danger">
                            <div class="fa fa-trash"></div> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <div class="fa fa-search"></div> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <?php if (!empty($angsuran)) : ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Angsuran</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Sewa</th>
                            <th>Nama Nasabah</th>
                            <th>Barang</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($angsuran as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['idSewa'] ?></td>
                                <td><?= $row['namaNasabah'] ?></td>
                                <td><?= $row['idKios'] ?></td>
                                <td><?= $row['tanggal'] ?></td>
                                <td><?= number_format($row['jumlah']) ?></td>
                                <td><?= $row['status'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
            <div class="alert alert-info">Belum ada data angsuran.</div>
        <?php endif; ?>
    </section>
</div>
