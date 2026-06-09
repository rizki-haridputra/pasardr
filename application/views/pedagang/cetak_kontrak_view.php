<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kontrak Sewa - <?= htmlspecialchars($kontrak['idSewa'], ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20mm; /* Margin standar untuk cetak */
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        /* Style untuk Kop Surat */
        .kop-surat {
            width: 100%;
            border-bottom: 4px solid #000; /* Garis bawah tebal */
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .kop-surat table {
            width: 100%;
            border: 0;
        }
        .kop-surat .logo {
            width: 100px; /* Sesuaikan ukuran logo */
            text-align: left;
        }
        .kop-surat .logo img {
            width: 90px; /* Sesuaikan ukuran gambar logo */
            height: auto;
        }
        .kop-surat .info-instansi {
            text-align: center;
            vertical-align: middle;
        }
        .kop-surat .info-instansi h1,
        .kop-surat .info-instansi h2,
        .kop-surat .info-instansi p {
            margin: 0;
            padding: 0;
        }
        .kop-surat .info-instansi h1 {
            font-size: 18pt;
            font-weight: bold;
        }
        .kop-surat .info-instansi h2 {
            font-size: 16pt;
            font-weight: bold;
        }
        .kop-surat .info-instansi p {
            font-size: 11pt;
        }
        h1.judul-surat, h2.nomor-surat {
            text-align: center;
            font-weight: bold;
        }
        h1.judul-surat {
            font-size: 16pt;
            text-decoration: underline;
            margin-top: 20px;
            margin-bottom: 5px;
        }
        h2.nomor-surat {
            font-size: 14pt;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            text-align: justify;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        td {
            padding: 5px;
            vertical-align: top;
        }
        .td-label {
            width: 150px;
        }
        .pasal {
            margin-top: 20px;
        }
        .pasal-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .signature-section {
            margin-top: 60px;
            width: 100%;
        }
        .signature {
            width: 45%;
            float: left;
            text-align: center;
        }
        .signature-right {
            float: right;
        }
        .signature-space {
            height: 80px; /* Ruang untuk tanda tangan */
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }

        @media print {
            .no-print {
                display: none; /* Sembunyikan tombol saat mencetak */
            }
            body {
                padding: 0; /* Hapus padding body saat print */
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Tombol Cetak -->
        <div class="no-print">
            <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
                Cetak Dokumen
            </button>
            <hr>
        </div>

        <!-- ================= BAGIAN KOP SURAT ================= -->
        <div class="kop-surat">
            <table>
                <tr>
                    <td class="logo">
                        <!-- Ganti 'nama_logo_anda.png' dengan nama file logo Anda -->
                        <img src="<?= base_url('assets/logo/Logo-1748768103.png') ?>" alt="Logo Perusahaan">
                    </td>
                    <td class="info-instansi">
                        <h1>PERUSAHAAN UMUM DAERAH ROKAN HULU JAYA</h1>
                        <h2>PASAR MODERN PASIR PENGARAIAN</h2>
                        <p>Jl. Raya Komplek Perkantoran Pemda, Rokan Hulu, Kode Pos: 28557</p>
                        <p>Email: pasmodrohuljaya@rokanhulukab.go.id | Telp: (0762) 123-4567</p>
                    </td>
                </tr>
            </table>
        </div>
        <!-- ================= AKHIR KOP SURAT ================= -->

        <!-- Header Kontrak -->
        <h1 class="judul-surat">SURAT PERJANJIAN SEWA MENYEWA KIOS</h1>
        <h2 class="nomor-surat">Nomor: <?= htmlspecialchars($kontrak['idSewa'], ENT_QUOTES, 'UTF-8') ?></h2>

        <!-- Isi Kontrak -->
        <p>Pada hari ini, <?= strftime('%A, %d %B %Y', strtotime($kontrak['tanggal'])) ?>, kami yang bertanda tangan di bawah ini:</p>

        <table>
            <tr>
                <td class="td-label"><strong>Nama</strong></td>
                <td>: <strong>Arianto, SE,Ak</strong></td>
            </tr>
            <tr>
                <td class="td-label"><strong>Jabatan</strong></td>
                <td>: Manager</td>
            </tr>
            <tr>
                <td class="td-label"><strong>Alamat</strong></td>
                <td>: Pasar Modern Pasir Pengaraian</td>
            </tr>
        </table>
        <p>Dalam hal ini bertindak untuk dan atas nama Pengelola Pasar, yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.</p>
        
        <table>
            <tr>
                <td class="td-label"><strong>Nama</strong></td>
                <td>: <strong><?= htmlspecialchars($nama_pedagang, ENT_QUOTES, 'UTF-8') ?></strong></td>
            </tr>
            <tr>
                <td class="td-label"><strong>No. Identitas</strong></td>
                <td>: <?= htmlspecialchars($kontrak['NIB'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td class="td-label"><strong>Alamat</strong></td>
                <td>: Pasir Pengaraian</td>
            </tr>
        </table>
        <p>Dalam hal ini bertindak untuk dan atas nama diri sendiri, yang selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.</p>

        <p>Dengan ini kedua belah pihak sepakat untuk mengikatkan diri dalam perjanjian sewa menyewa kios dengan ketentuan dan syarat-syarat sebagai berikut:</p>

        <!-- Pasal-pasal Perjanjian -->
        <div class="pasal">
            <div class="pasal-title">Pasal 1: Objek Sewa</div>
            <p>PIHAK PERTAMA setuju untuk menyewakan kepada PIHAK KEDUA, dan PIHAK KEDUA setuju untuk menyewa dari PIHAK PERTAMA, sebuah unit kios dengan rincian sebagai berikut:</p>
            <table>
                <tr>
                    <td style="width: 120px;">Kode Kios</td>
                    <td>: <?= htmlspecialchars($kontrak['idKios'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>: Blok A</td>
                </tr>
                 <tr>
                    <td>Berjualan</td>
                    <td>: <?= htmlspecialchars($kontrak['jenisDagang'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
            </table>
        </div>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>

        <div class="pasal">
            <div class="pasal-title">Pasal 2: Jangka Waktu</div>
            <p>Perjanjian sewa menyewa ini berlaku untuk jangka waktu 1 (satu) tahun yang sama dari penyewaan, terhitung sejak tanggal ditandatanganinya surat perjanjian ini, yaitu dari tanggal <?= date('d F Y', strtotime($kontrak['tanggal'])) ?> sampai dengan 31 Desember 2025.</p>
        </div>

        <div class="pasal">
            <div class="pasal-title">Pasal 3: Harga Sewa</div>
            <p>Harga sewa untuk jangka waktu sebagaimana dimaksud dalam Pasal 2 adalah sebesar <strong><?= 'Rp. ' . number_format($kontrak['harga'], 0, ',', '.') . ',-' ?> (<?= ucwords(terbilang($kontrak['harga'])) ?> Rupiah)</strong>, yang telah dilunasi oleh PIHAK KEDUA kepada PIHAK PERTAMA.</p>
        </div>

        <p>Demikian surat perjanjian ini dibuat rangkap 2 (dua), masing-masing bermeterai cukup dan mempunyai kekuatan hukum yang sama, untuk dapat dipergunakan sebagaimana mestinya.</p>

       <!-- Tanda Tangan -->
<div class="signature-section clearfix">
    <div class="signature">
        <p><strong>PIHAK KEDUA,</strong><br><td>Pedagang</td></p>
         <div class="signature-space" style="height: 100px; display: flex; align-items: center; justify-content: center;">
            <?php
                // Data unik untuk QR Code (contoh: Nomor Kontrak)
                $qrData = 'Nomor Kontrak: ' . htmlspecialchars($kontrak['idSewa'], ENT_QUOTES, 'UTF-8');
                // Encode data agar aman untuk URL
                $encodedQrData = urlencode($qrData);
            ?>
            <!-- Gunakan API dari goqr.me untuk membuat QR Code -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=<?= $encodedQrData ?>" 
                 alt="QR Code Verifikasi" 
                 style="width: 90px; height: 90px;">
        </div>
        <p><strong>( <u><?= htmlspecialchars($nama_pedagang, ENT_QUOTES, 'UTF-8') ?></u> )</strong></p>
    </div>
    <div class="signature signature-right">
        <p><strong>PIHAK PERTAMA,</strong><br>Manager</p>
        <div class="signature-space" style="height: 100px; display: flex; align-items: center; justify-content: center;">
            <?php
                // Data unik untuk QR Code (contoh: Nomor Kontrak)
                $qrData = 'Nomor Kontrak: ' . htmlspecialchars($kontrak['idSewa'], ENT_QUOTES, 'UTF-8');
                // Encode data agar aman untuk URL
                $encodedQrData = urlencode($qrData);
            ?>
            <!-- Gunakan API dari goqr.me untuk membuat QR Code -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=<?= $encodedQrData ?>" 
                 alt="QR Code Verifikasi" 
                 style="width: 90px; height: 90px;">
        </div>
        <p><strong>( <u>Aianto SE,Ak</u> )</strong></p>
    </div>
</div>

    <?php
        // Fungsi helper untuk mengubah angka menjadi terbilang
        function terbilang($nilai) {
            $nilai = abs($nilai);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " ". $huruf[$nilai];
            } else if ($nilai <20) {
                $temp = terbilang($nilai - 10). " belas";
            } else if ($nilai < 100) {
                $temp = terbilang($nilai/10)." puluh". terbilang($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " seratus" . terbilang($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = terbilang($nilai/100) . " ratus" . terbilang($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " seribu" . terbilang($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = terbilang($nilai/1000) . " ribu" . terbilang($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = terbilang($nilai/1000000) . " juta" . terbilang($nilai % 1000000);
            }
            return trim($temp);
        }
    ?>
</body>
</html>