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
            <div class="box-header">
                <h3 class="box-title">Detail Laporan Pendapatan <?= ucfirst($periode) ?></h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pembayaran</th>
                            <th>ID Sewa</th>
                            <th>Nominal</th>
                            <!-- Tambahkan kolom lain jika perlu -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $total_pendapatan = 0;
                        foreach ($laporan as $row) :
                            $total_pendapatan += $row->nominal;
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d M Y', strtotime($row->tanggal)) ?></td>
                                <td><?= $row->idSewa ?></td>
                                <td><?= 'Rp. ' . number_format($row->nominal, 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align:right">Total Pendapatan:</th>
                            <th><?= 'Rp. ' . number_format($total_pendapatan, 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Pastikan Anda sudah memuat DataTables JS dan CSS di template footer Anda -->
<script>
  $(function () {
    $('#example1').DataTable()
  })
</script>