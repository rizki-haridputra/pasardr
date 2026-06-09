<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="<?= base_url('manager/dashboard') ?>">
                    <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                </a>
            </li>
			<li class="treeview">
					  <?php if($this->session->userdata('level') == 'Manager') { ?>
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Kios</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= base_url('manager/daftarkios') ?>"><i class="fa fa-circle-o"></i> Manajemen Kios</a></li>
                        <li><a href="<?= base_url('manager/pasarbaru') ?>"><i class="fa fa-circle-o"></i> Lihat Kios</a></li>
            <?php } ?>
			<?php if($this->session->userdata('level') == 'Petugas') { ?>
			<li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Kios</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= base_url('manager/daftarkios') ?>"><i class="fa fa-circle-o"></i> Manajemen Kios</a></li>
                        <li><a href="<?= base_url('manager/kios') ?>"><i class="fa fa-circle-o"></i> Lihat Kios</a></li>
            <?php } ?>
                    </ul>
                </li>
            <?php if($this->session->userdata('level') == 'Manager') { ?>
                <li>
                    <a href="<?= base_url('manager/pedagang') ?>">
                        <i class="fa fa-users"></i> <span>Data Pedagang</span>
                    </a>
                </li>
            <?php } ?>
            <?php if($this->session->userdata('level') == 'Manager') { ?>
                <li>
                    <a href="<?= base_url('manager/validasi') ?>">
                        <i class="fa fa-users"></i> <span>Data Sewa Masuk</span>
                        <?php
                                $whereNsPr = array('StatusSewa' => 'verifikasi');
                                echo $this->db->where($whereNsPr)->get('tb_sewa')->num_rows();
                            ?>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="<?= base_url('manager/sewa') ?>">
                    <i class="fa fa-database"></i> <span>Data Sewa <?= ($this->session->userdata('level') == 'Pedagang') ? 'Saya' : '' ?></span>
                </a>
            </li>
            <?php if($this->session->userdata('level') == 'Manager') { ?>
                <li>
                    <a href="<?= base_url('manager/angsuran') ?>">
                        <i class="fa fa-book"></i> <span>Data Angsuran</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('manager/laporan') ?>">
                        <i class="fa fa-pencil"></i> <span>Data Laporan</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Pengaturan</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= base_url('manager/user') ?>"><i class="fa fa-circle-o"></i> Manajemen User</a></li>
                        <li><a href="<?= base_url('manager/aplikasi') ?>"><i class="fa fa-circle-o"></i> Tentang Aplikasi</a></li>
                        <li><a href="<?= base_url('manager/backupdatabase') ?>"><i class="fa fa-circle-o"></i> Backup Database</a></li>
                        <li><a href="<?= base_url('manager/log') ?>"><i class="fa fa-circle-o"></i> Log Status</a></li>
                    </ul>
                </li>
            <?php } ?>
            <li>
                <a href="<?= base_url('manager/profil') ?>">
                    <i class="fa fa-user"></i> <span>Profil</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('home/logout') ?>" class="tombol-yakin" data-isidata="Ingin keluar dari sistem ini?">
                    <i class="fa fa-sign-out"></i> <span>Sign Out</span>
                </a>
            </li>
        </ul>
    </section>
</aside>