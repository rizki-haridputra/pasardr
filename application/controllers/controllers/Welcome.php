<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data['title']		= 'Beranda';

		$data['aplikasi']	= $this->m_model->get_desc('tb_aplikasi');

		$this->load->view('beranda', $data);
	}

	public function carikios()
	{
		$data['title']		= 'Pencarian : ' . $_GET['nama'];
		$data['subtitle']	= 'Ditampilkan berdasarkan nama pencarian kios';

		$data['aplikasi']	= $this->m_model->get_desc('tb_aplikasi');

		$data['kios']	= $this->db->query('SELECT * FROM tb_kios WHERE nama LIKE "%'.$_GET['idKios'].'%"');
		
		$this->load->view('resultberanda', $data);
    }
}
