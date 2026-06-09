<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="<?= base_url('petugas/dashboard') ?>">
                    <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                </a>
            </li>
			<!-- <li class="treeview">
					  <?php if($this->session->userdata('level') == 'Petugas') { ?>
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Kios</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= base_url('petugas/daftarkios') ?>"><i class="fa fa-circle-o"></i> Manajemen Kios</a></li>
                        <li><a href="<?= base_url('petugas/kios') ?>"><i class="fa fa-circle-o"></i> Lihat Kios</a></li>
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
                        <li><a href="<?= base_url('petugas/daftarkios') ?>"><i class="fa fa-circle-o"></i> Manajemen Kios</a></li>
                        <li><a href="<?= base_url('petugas/kios') ?>"><i class="fa fa-circle-o"></i> Lihat Kios</a></li>
            <?php } ?>
                    </ul>
                </li> -->
            <?php if($this->session->userdata('level') == 'Petugas') { ?>
                <li>
                    <a href="<?= base_url('petugas/pasarbaru') ?>">
                        <i class="fa fa-users"></i> <span>Kios</span>
                    </a>
                </li>
            <?php } ?>            
                            <li>
                    <a href="<?= base_url('petugas/sewa') ?>">
                        <i class="fa fa-users"></i> <span>Pembayaran</span>
                    </a>
                </li>
            <?php if($this->session->userdata('level') == 'Petugas') { ?>
                <li>
                    <a href="<?= base_url('petugas/angsuran') ?>">
                        <i class="fa fa-book"></i> <span>Data Angsuran</span>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="<?= base_url('petugas/profil') ?>">
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