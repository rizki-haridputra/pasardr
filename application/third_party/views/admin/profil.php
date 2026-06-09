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

        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?= base_url('assets/profil/').$this->session->userdata('foto') ?>" style="width: 100px; height: 100px;" alt="User profile picture">

                        <h3 class="profile-username text-center"><?= $this->session->userdata('nama') ?></h3>

                        <p class="text-muted text-center"><?= $this->session->userdata('level') ?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Last Login</b> <a class="pull-right">
                                    <?php
                                        $this->db->limit('1');
                                        $this->db->order_by('id', 'DESC');
                                        $this->db->where('idUser', $this->session->userdata('id'));
                                        foreach ($this->db->get('tb_log')->result() as $dLast) {
                                            echo date('d F Y H:i:s', strtotime($dLast->terdaftar));
                                        }
                                    ?>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Lama Session</b> <a class="pull-right">
                                <p id="session_time"><?php echo $this->session->userdata('start_time'); ?></p>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Terdaftar</b> <a class="pull-right"><?= date('d F Y H:i:s', strtotime($this->session->userdata('terdaftar'))) ?></a>
                            </li>
                        </ul>

                        <a href="<?= base_url('admin/profil/nonaktif/').$this->session->userdata('id') ?>" class="btn btn-warning btn-block tombol-yakin" data-isidata="Akun akan dinonaktifkan">
                            <div class="fa fa-lock"></div> Nonaktifkan Akun
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#account" data-toggle="tab"><div class="fa fa-user"></div> Account</a></li>
                        <li><a href="#foto" data-toggle="tab"><div class="fa fa-image"></div> Foto</a></li>
                        <li><a href="#password" data-toggle="tab"><div class="fa fa-lock"></div> Password</a></li>
                        <li><a href="#log" data-toggle="tab"><div class="fa fa-history"></div> Log Status</a></li>
                    </ul>

                    <!-- Tab Account -->
                    <div class="tab-content">
                        <div class="active tab-pane" id="account">
                            <form class="form-horizontal" action="<?= base_url('admin/profil/updateaccount/').$this->session->userdata('id') ?>" method="POST">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Username</label>

                                        <div class="col-sm-10">
                                            <input type="text" name="username" class="form-control" value="<?= $this->session->userdata('username'); ?>" placeholder="Username" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Nama Lengkap</label>

                                        <div class="col-sm-10">
                                            <input type="text" name="nama" class="form-control" value="<?= $this->session->userdata('nama'); ?>" placeholder="Nama Lengkap" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Jenis Kelamin</label>

                                        <div class="col-sm-10">
                                            <select name="jenisKelamin" class="form-control" required>
                                                <option value="Laki-Laki" <?= ($this->session->userdata('jenisKelamin') == 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
                                                <option value="Perempuan" <?= ($this->session->userdata('jenisKelamin') == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tempat Lahir</label>

                                        <div class="col-sm-10">
                                            <input type="text" name="tptLahir" class="form-control" value="<?= $this->session->userdata('tptLahir'); ?>" placeholder="Tempat Lahir" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tanggal Lahir</label>

                                        <div class="col-sm-10">
                                            <input type="date" name="tglLahir" class="form-control" value="<?= $this->session->userdata('tglLahir'); ?>" placeholder="Tanggal Lahir" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">No. Telephone</label>

                                        <div class="col-sm-10">
                                            <input type="number" name="telp" class="form-control" value="<?= $this->session->userdata('telp'); ?>" placeholder="No. Telephone" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" value="<?= $this->session->userdata('email'); ?>" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Alamat</label>

                                        <div class="col-sm-10">
                                            <input type="text" name="alamat" class="form-control" value="<?= $this->session->userdata('alamat'); ?>" placeholder="Alamat" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Skin</label>

                                        <div class="col-sm-10">
                                            <select name="skin" class="form-control" required>
                                                <option value="yellow" <?= ($this->session->userdata('skin') == 'yellow') ? 'selected' : '' ?>>yellow</option>
                                                <option value="red" <?= ($this->session->userdata('skin') == 'red') ? 'selected' : '' ?>>red</option>
                                                <option value="green" <?= ($this->session->userdata('skin') == 'green') ? 'selected' : '' ?>>green</option>
                                                <option value="purple" <?= ($this->session->userdata('skin') == 'purple') ? 'selected' : '' ?>>purple</option>
                                                <option value="blue" <?= ($this->session->userdata('skin') == 'blue') ? 'selected' : '' ?>>blue</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="reset" class="btn btn-danger">
                                            <div class="fa fa-trash"></div> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <div class="fa fa-save"></div> Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab Foto -->
                        <div class="tab-pane" id="foto">
                            <form class="form-horizontal" action="<?= base_url('admin/profil/updatefoto/').$this->session->userdata('id') ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Ganti Foto</label>

                                        <div class="col-sm-10">
                                            <input type="file" name="foto" class="form-control-file" placeholder="New Password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <small><b><i><font color="red">Format foto yaitu PNG, JPG, dan JPEG!</font></i></b></small>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary">
                                            <div class="fa fa-save"></div> Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab Password -->
                        <div class="tab-pane" id="password">
                            <form class="form-horizontal" action="<?= base_url('admin/profil/updatepassword/').$this->session->userdata('id') ?>" method="POST">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">New Password</label>

                                        <div class="col-sm-10">
                                            <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="New Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Ulangi Password</label>

                                        <div class="col-sm-10">
                                            <input type="password" name="ulangiPassword" id="ulangiPassword" class="form-control" placeholder="Ulangi Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>

                                        <div class="col-sm-10">
                                            <div class="statusPassword"><font color="green"><div class="fa fa-check"></div> Password Sama</font></div>
                                            <div class="statusPassword"><font color="red"><div class="fa fa-close"></div> Password Tidak Sama</font></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="submit" id="updateButton" class="btn btn-primary">
                                            <div class="fa fa-save"></div> Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab Log Status -->
                        <div class="tab-pane" id="log">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>IP Address</th>
                                            <th>Device</th>
                                            <th>Status</th>
                                            <th>Terdaftar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($log->result_array() as $row) { ?>
                                            <tr>
                                                <td><?= $row['ipAddress'] ?></td>
                                                <td><?= $row['device'] ?></td>
                                                <td>
                                                    <?php
                                                        if($row['status'] == 'Login') {
                                                            echo '<div class="label label-success">'.$row['status'].'</div>';
                                                        } else {
                                                            echo '<div class="label label-danger">'.$row['status'].'</div>';
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>