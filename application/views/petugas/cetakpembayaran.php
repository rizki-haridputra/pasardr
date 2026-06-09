<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>

    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f4f4f4;
        }
        .receipt-container {
            width: 350px;
            margin: 20px auto;
            padding: 20px;
            border: 2px dashed #000;
            background-color: #fff;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header .logo {
            max-width: 150px; /* Atur lebar maksimum logo */
            height: auto;
            margin-bottom: 15px;
        }
        .receipt-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .receipt-header p {
            margin: 0;
            font-size: 12px;
        }
        .receipt-details, .receipt-summary {
            margin-bottom: 20px;
        }
        .receipt-details table, .receipt-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-details td, .receipt-summary td {
            padding: 2px 0;
            font-size: 14px;
        }
        .receipt-summary .total {
            font-weight: bold;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .item-table th, .item-table td {
            border-bottom: 1px solid #ccc;
            padding: 8px 4px;
            text-align: left;
            font-size: 14px;
        }
        .item-table th {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .receipt-footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<?php
    // Mengatur timezone dari database
    foreach ($this->db->get('tb_aplikasi')->result() as $timezone) {
        date_default_timezone_set($timezone->timezone);
    }
?>
<body>
    <div class="receipt-container">
        <?php
        // Loop ini akan berisi semua detail kwitansi, diasumsikan hanya ada satu data sewa per kwitansi.
        foreach ($sewa->result_array() as $row) {
        ?>
            <div class="receipt-header">
                <?php
                // Tampilkan logo jika field 'logo' pada data sewa tidak kosong
                if (!empty($row['logo'])) {
                ?>
                    <img src="<?= base_url('assets/logo/') . $row['logo'] ?>" alt="Logo" class="logo">
                <?php
                }
                ?>

                <h2><b>KWITANSI</b></h2>
                <p><?= strtoupper($title) ?></p>
            </div>

            <div class="receipt-details">
                <table>
                    <tr>
                        <td width="120px">No. Sewa</td>
                        <td width="10px">:</td>
                        <td><?= $row['idSewa'] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Transaksi</td>
                        <td>:</td>
                        <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                    </tr>
                    <tr>
                        <td>Nama Pedagang</td>
                        <td>:</td>
                        <td><?= $this->db->where('id', $row['idPedagang'])->get('tb_user')->row('nama') ?></td>
                    </tr>
                </table>
            </div>

            <p style="text-align:center; font-weight:bold; margin-bottom: 15px;">--- RINCIAN PEMBAYARAN ---</p>

            <div class="receipt-summary">
                <table>
                     <tr>
                        <td>Kode Kios</td>
                        <td>:</td>
                        <td class="text-right"><?= $row['idKios'] ?></td>
                    </tr>
                    <tr>
                        <td>Harga Sewa</td>
                        <td>:</td>
                        <td class="text-right"><?= 'Rp. ' . number_format($row['harga'],0,',','.') ?></td>
                    </tr>
                    <?php
                        $this->db->select('SUM(nominal) AS totalPembayaran');
                        $this->db->where('idSewa', $idSewa);
                        $tPem = $this->db->get('tb_angsuran')->row();
                    ?>
                    <tr>
                        <td>Total Terbayar</td>
                        <td>:</td>
                        <td class="text-right"><?= 'Rp. ' . number_format($tPem->totalPembayaran,0,',','.'); ?></td>
                    </tr>
                    <tr class="total">
                        <td>Sisa Pembayaran</td>
                        <td>:</td>
                        <td class="text-right"><?= 'Rp. ' . number_format($row['harga'] - $tPem->totalPembayaran,0,',','.') ?></td>
                    </tr>
                     <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td class="text-right"><b><?= $row['status'] ?></b></td>
                    </tr>
                </table>
            </div>
        <?php } ?>

        <hr style="border-top: 1px dashed #000;">

        <p style="text-align:center; font-weight:bold; margin-top:15px; margin-bottom: 15px;">--- RIWAYAT ANGSURAN ---</p>

        <table class="item-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th class="text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    foreach ($angsuran->result() as $ang) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($ang->tanggal)) ?></td>
                        <td class="text-right"><?= number_format($ang->nominal,0,',','.') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="receipt-footer">
            <p>Terima kasih atas pembayaran Anda.</p>
            <small><i>Dicetak pada <?= date('d F Y H:i:s') ?> oleh <?= $this->session->userdata('nama') ?></i></small>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>