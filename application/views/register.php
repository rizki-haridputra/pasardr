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
    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <?php foreach ($aplikasi->result_array() as $row) { ?>
                    <center><img src="<?= base_url('assets/logo/').$row['logo'] ?>" alt="" class="img-responsive" width="50%" style="margin-bottom: 15px"></center>
                    <a href="<?= base_url('home') ?>"><b><?= $row['nama'] ?></b></a>
                <?php } ?>
            </div>

            <div class="register-box-body">
                <p class="login-box-msg">Daftarkan akun baru</p>

                <!-- Arahkan form ke method controller untuk proses registrasi -->
                <form action="<?= base_url('home/proses_register') ?>" method="POST">
                    <!-- Jangan lupa CSRF protection -->
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="number" class="form-control" name="telp" placeholder="Telepon" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="alamat" placeholder="alamat" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password2" id="password2" placeholder="Ulangi password" required>
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                          <input type="checkbox" id="checkbox"> Show Password
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                <i class="fa fa-user-plus"></i> Daftar
                            </button>
                        </div>
                    </div>
                </form>

                <hr>
                <a href="<?= base_url('home') ?>" class="text-center">Saya sudah punya akun</a>
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
            // Notifikasi (jika ada pesan dari controller)
            const flashData = $('.flash-data').data('flashdata');
            if (flashData){
                swal({
                  title: "Gagal!",
                  text: flashData,
                  icon: "pesan",
                });
            }

            // Show Password untuk kedua field password
            $(document).ready(function() {
                $('#checkbox').click(function() {
                    if($(this).is(':checked')){
                      $('#password').attr('type','text');
                      $('#password2').attr('type','text');
                    } else {
                      $('#password').attr('type','password');
                      $('#password2').attr('type','password');
                    }
                });
            });
        </script>
    </body>
</html>