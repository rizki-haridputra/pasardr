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
            <form class="form-horizontal" action="<?= base_url('admin/laporan/rekap') ?>" method="GET">
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
    </section>
</div>