<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?= base_url('assets') ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('assets') ?>/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= base_url('assets') ?>/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/iCheck/square/blue.css">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Pasar Modern Jaya Selalu</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- File CSS Kustom -->
    <link rel="stylesheet" href="style.css">
    
    </head>
        <!-- 1. Navigasi / Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="assets/kios/logo-pasar.png" alt="Logo Pasar Modern" width="30" class="d-inline-block align-text-top me-2">
                Pasar Datuk Rubiah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homednms">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.html">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="berita.html">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pasar">Kios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galeri.html">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <?php foreach ($aplikasi->result_array() as $row) { ?>
                    <!-- <center><img src="<?= base_url('assets/logo/').$row['logo'] ?>" alt="" class="img-responsive" width="50%" style="margin-bottom: 10px"></center> -->
                    <!-- <a href="<?= base_url('login') ?>"><b><?= $row['nama'] ?></b></a> -->
                <?php } ?>
                <td><p class="psnj" >PASAR DATUK RUBIAH - ROKAN HILIR</p></td>

            </div>
            <div class="login-box-body">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('pesan') ?>"></div>
                <p class="login-box-msg">Masukkan username dan password</p>

                <form action="<?= base_url('home/auth') ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="form-group has-feedback"> 
                        <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <hr>
                    <?php if($row['captcha'] == 'Ya') { ?>
                        <?= $captcha ?>
                        <div class="form-group">
                            <input type="text" class="form-control" name="jawaban" placeholder="Hitung angka diatas">
                        </div>
                    <?php } elseif($row['captcha'] == 'Tidak') { ?>
                        <div class="form-group hidden">
                            <input type="text" class="form-control" name="jawaban" value="<?= $this->session->userdata('captcha') ?>" placeholder="Hitung angka diatas">
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-xs-8">
                          <input type="checkbox" id="checkbox"> Show Password
                        </div>
                        <div class="col-xs-4">
                          <button type="submit" class="btn btn-primary btn-block btn-flat">
                            <div class="fa fa-sign-in"></div> Sign In
                          </button>
                        </div>
                    </div>
                </form>

                <!-- ============ BAGIAN YANG DITAMBAHKAN ============ -->
                <hr>
                <a href="<?= base_url('home/register') ?>" class="text-center">Belum punya akun? Daftar disini</a>
                <!-- =============================================== -->

            </div>
        </div>

        <!-- Sweet Alert -->
        <script src="<?= base_url('assets') ?>/bower_components/sweetalert/sweetalert.min.js"></script>
        <!-- jQuery 3 -->
        <script src="<?= base_url('assets') ?>/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?= base_url('assets') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?= base_url('assets') ?>/plugins/iCheck/icheck.min.js"></script>
        <script>
            // Notifikasi
            const flashData = $('.flash-data').data('flashdata');
            if (flashData){
                swal({
                  title: "Failed!",
                  text: flashData,
                  icon: "error",
                });
            }

            // Show Password
            $(document).ready(function() {
                $('#checkbox').click(function() {
                    if($(this).is(':checked')){
                      $('#password').attr('type','text');
                    } else {
                      $('#password').attr('type','password');
                    }
                });
            });
        </script>
    </body>
</html>