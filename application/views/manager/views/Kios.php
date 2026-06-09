<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('manger/views/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
	<div class="box">
            <div class="box-body">
                <?php if($this->session->userdata('level') == 'manager') { ?>
                    	<a href="<?= base_url('manger/views/kios') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->get('tb_kios')->num_rows() ?></span>
                        <i class="fa fa-university"></i> Data Kios
                    </a>
					<a href="<?= base_url('manger/views/pasarbaru') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->where('level', 'pedagang')->get('tb_user')->num_rows() ?></span>
                        <i class="fa fa-university"></i> Pasar Baru
                    </a>
					<a href="<?= base_url('manger/views/lantaisatu') ?>" class="btn btn-app">
                        <span class="badge bg-<?= $this->session->userdata('skin') ?>"><?= $this->db->where('level', 'pedagang')->get('tb_user')->num_rows() ?></span>
                        <i class="fa fa-university"></i> Daftar Kios
                    </a>
                <?php } ?>
            </div>
        </div>
        <div class="box">
            <?php if($this->session->userdata('level') == 'manger/viewsistrator') { ?>
                <div class="box-header">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                        <div class="fa fa-plus"></div> Tambah Data
                    </button>
                </div>
            <?php } ?>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped dataTable">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>Id Kios</th>
                                <th>Jenis Kios</th>
                                <th>Harga Sewa</th>
                                <th>Gambar</th>
                                <th>Status Sewa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($Kios->result_array() as $row) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['idKios'] ?></td>
                                    <td><?= $row['jKios'] ?></td>
                                    <td><?= $row['hKios'] ?></td>
                                    <td><?= $row['gambar'] ?></td>
                                    <td>
                                   
                                    <?php if ($row['status'] == ''){ ?>
                                        
                                        <a href="#" class="btn btn-primary btn-xs">Kosong</a>

                                    <?php } else if($row['status'] == 1){ ?>

                                        <a href="#" class="btn btn-success btn-xs">Berisi</a>

                                    <?php } else { ?>
                         
                                        <a href="#" class="btn btn-danger btn-xs">Error</a>
                                    
                                    <?php }    ?>
                                    </td>

                                    <td>
                                        <?php if($this->session->userdata('level') == 'manager'OR $this->session->userdata('level') == 'Petugas') { ?>
                                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                <div class="fa fa-edit"></div> Edit
                                            </button>
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah <?= $title ?></h4>
            </div>
            <form action="<?= base_url('manger/views/kios/insert') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Id Kios</label>
                        <input type="text" name="idKios" class="form-control" placeholder="Id Kios" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kios</label>
                        <input type="text" name="jKios" class="form-control" placeholder="Jenis Kios" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Sewa</label>
                        <input type="text" name="hKios" class="form-control" placeholder="Harga Sewa" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="text" name="gambar" class="form-control" placeholder="Gambar" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" name="status" class="form-control" placeholder="Status" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger"><div class="fa fa-trash"></div> Reset</button>
                    <button type="submit" class="btn btn-primary"><div class="fa fa-save"></div> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php foreach ($Kios->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title ?></h4>
                </div>
                <form action="<?= base_url('manger/views/kios/update/').$edit->idKios ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="modal-body">
                       <div class="form-group">
                        <label>Id Kios</label>
                        <input type="text" name="idKios" class="form-control" placeholder="Id Kios" value="<?= $edit->idKios ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kios</label>
                        <input type="text" name="jKios" class="form-control" placeholder="Jenis Kios" value="<?= $edit->jKios ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Sewa</label>
                        <input type="text" name="hKios" class="form-control" placeholder="Harga Sewa" value="<?= $edit->hKios ?> " required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="text" name="gambar" class="form-control" placeholder="Gambar" value="<?= $edit->gambar ?> " required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" name="status" class="form-control" placeholder="Status" value="<?= $edit->status ?> " required>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger"><div class="fa fa-trash"></div> Reset</button>
                        <button type="submit" class="btn btn-primary"><div class="fa fa-save"></div> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	
	<?php } ?>