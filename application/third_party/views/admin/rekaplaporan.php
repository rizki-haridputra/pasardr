<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?= $title ?></title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?= base_url('assets') ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
        <![endif]-->
    </head>
    <?php
        foreach ($this->db->get('tb_aplikasi')->result() as $timezone) {
            date_default_timezone_set($timezone->timezone);
        }
    ?>
    <body>
        <div class="container">
            <h3><center><b><?= strtoupper($title) ?></b></center></h3>

            <br>

            <table>
                <tr>
                    <td width="100px">Tanggal</td>
                    <td width="10px">:</td>
                    <td><?= ($dariTanggal == $sampaiTanggal) ? date('d M Y', strtotime($dariTanggal)) : date('d M Y', strtotime($dariTanggal)) . ' s/d ' . date('d M Y', strtotime($sampaiTanggal)) ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>:</td>
                    <td>
                        <?php
                            foreach ($total->result() as $ttl) {
                                echo 'Rp. ' . number_format($ttl->nominal,0,',','.');
                            }
                        ?>
                    </td>
                </tr>
            </table>

            <br>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th>No Sewa</th>
                            <th>Nama</th>
                            <th>Telp</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach ($angsuran->result() as $ang) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $this->db->where('id', $ang->idSewa)->get('tb_Sewa')->row('idSewa') ?></td>
                                <td><?= $this->db->where('id', $this->db->where('id', $ang->idSewa)->get('tb_Sewa')->row('idNasabah'))->get('tb_user')->row('nama') ?></td>
                                <td><?= $this->db->where('id', $this->db->where('id', $ang->idSewa)->get('tb_Sewa')->row('idNasabah'))->get('tb_user')->row('telp') ?></td>
                                <td><?= date('d F Y', strtotime($ang->tanggal)) ?></td>
                                <td><?= 'Rp. ' . number_format($ang->nominal,0,',','.') ?></td>
                                <td><?= $ang->keterangan ?></td>
                                <td><?= date('d M Y H:i', strtotime($ang->terdaftar)) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <font style="position: fixed; bottom: 0">
                <small><i>Dicetak pada <?= date('d F Y H:i:s') ?> Oleh <?= $this->session->userdata('nama') ?>, <?= current_url() ?></i></small>
            </font>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?= base_url('assets') ?>/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?= base_url('assets') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
            window.print();
        </script>
    </body>
</html>