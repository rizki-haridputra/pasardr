<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="<?= base_url('pedagang/dashboard') ?>">
                    <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                </a>
            </li>
			<!-- <li class="treeview">
					  <?php if($this->session->userdata('level') == 'Pedagang') { ?>
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Kios</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= base_url('pedagang/daftarkios') ?>"><i class="fa fa-circle-o"></i> Manajemen Kios</a></li>
                        <li><a href="<?= base_url('pedagang/kios') ?>"><i class="fa fa-circle-o"></i> Lihat Kios</a></li>
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
                        <li><a href="<?= base_url('pedagang/daftarkios') ?>"><i class="fa fa-circle-o"></i> Manajemen Kios</a></li>
                        <li><a href="<?= base_url('pedagang/kios') ?>"><i class="fa fa-circle-o"></i> Lihat Kios</a></li>
            <?php } ?>
                    </ul>
                -->
            <?php if($this->session->userdata('level') == 'Pedagang') { ?>
                <li>
                    <a href="<?= base_url('pedagang/pasarbaru') ?>">
                    <i class="fa fa-cogs"></i> <span class="fa-fa-container">Data Kios</span>
                    </a>
                </li>
            <?php } ?>

            <?php if($this->session->userdata('level') == 'Pedagang') { ?>
                <li>
                    <a href="<?= base_url('pedagang/penyewaan') ?>">
                        <i class="fa fa-users"></i> <span>Sewa Kios</span>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="<?= base_url('pedagang/sewa') ?>">
                    <i class="fa fa-database"></i> <span>Data Sewa <?= ($this->session->userdata('level') == 'Pedagang') ? 'Saya' : '' ?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('pedagang/profil') ?>">
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