<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('licensing');
        $this->licensing->check_license();

		//Get Zona Waktu
        foreach ($this->db->get('tb_aplikasi')->result() as $timezone) {
            date_default_timezone_set($timezone->timezone);
        }
		
		if(!$this->session->userdata('level')){
			$this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
			redirect('home');
		} elseif($this->session->userdata('level') != 'manager') {
			redirect('home');
        }
	}

	public function index()
	{
		$data['title']		= 'Manajemen User';
		$data['subtitle']	= 'Semua user akan muncul disini';

		$data['collapse']	= 'No';
	
		$this->db->where('id !=', $this->session->userdata('id'));
		$this->db->where('level', 'manager');
		$data['user']       = $this->m_model->get_desc('tb_user');
		
		$this->load->view('manager/templates/header', $data);
		$this->load->view('manager/templates/sidebar');
		$this->load->view('manager/views/user');
		$this->load->view('manager/templates/footer');
    }

    public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_user');
		$this->session->set_flashdata('pesan', 'Account berhasil dihapus');
		redirect('manager/views/user');
	}

	public function insert()
	{
		$nama			= $_POST['nama'];
		$jenisKelamin	= $_POST['jenisKelamin'];
		$tptLahir		= $_POST['tptLahir'];
		$tglLahir		= $_POST['tglLahir'];
		$telp			= $_POST['telp'];
		$email			= $_POST['email'];
		$login			= $_POST['login'];
		$alamat			= $_POST['alamat'];
		$username		= $_POST['username'];
		$password		= $_POST['password'];
		$foto			= 'no-image.png';
		$skin			= 'blue';
		$level			= $_POST['level'];
		$terdaftar		= date('Y-m-d H:i:s');

		$where = array('username' => $username);
		$cekUsername	= $this->m_model->get_where($where, 'tb_user');
		if(empty($cekUsername->num_rows())) {
			$options = [
				'cost' => 10,
			];
	
			$enkripPassword = password_hash($password, PASSWORD_BCRYPT, $options);
	
			$data = array(
				'nama' 			=> $nama,
				'jenisKelamin'	=> $jenisKelamin,
				'tglLahir'		=> $tglLahir,
				'tptLahir'		=> $tptLahir,
				'telp' 			=> $telp,
				'email' 		=> $email,
				'login' 		=> $login,
				'alamat' 		=> $alamat,
				'username'		=> $username,
				'password'		=> $enkripPassword,
				'foto'			=> $foto,
				'skin'			=> $skin,
				'level'			=> $level,
				'terdaftar'		=> $terdaftar,
			);
	
			$this->m_model->insert($data, 'tb_user');
			$this->session->set_flashdata('pesan', 'Account berhasil dibuat!');
			redirect('manager/views/user');
		} else {
			$this->session->set_flashdata('pesanError', 'Username sudah ada!');
			redirect('manager/views/user');
		}
	}

	public function resetpassword($id)
	{
		$password	= $_POST['password'];

		$options = [
			'cost' => 10,
		];

		$enkripPassword = password_hash($password, PASSWORD_BCRYPT, $options);

		$data = array(
			'password'	=> $enkripPassword,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_user');
		$this->session->set_flashdata('pesan', 'Reset password berhasil!');
		redirect('manager/views/user');
	}

	public function update($id)
	{
		$nama			= $_POST['nama'];
		$jenisKelamin	= $_POST['jenisKelamin'];
		$tglLahir		= $_POST['tglLahir'];
		$tptLahir		= $_POST['tptLahir'];
		$telp			= $_POST['telp'];
		$email			= $_POST['email'];
		$login			= $_POST['login'];
		$alamat			= $_POST['alamat'];

		$where = array('id' => $id);

		$data = array(
			'nama' 			=> $nama,
			'jenisKelamin'	=> $jenisKelamin,
			'tglLahir'		=> $tglLahir,
			'tptLahir'		=> $tptLahir,
			'telp' 			=> $telp,
			'email' 		=> $email,
			'login' 		=> $login,
			'alamat' 		=> $alamat
		);

		$this->m_model->update($where, $data, 'tb_user');
		$this->session->set_flashdata('pesan', 'Account berhasil diubah!');
		redirect('manager/views/user');
	}

	public function importexcel()
	{
		$config['upload_path'] 		= './assets/file_excel/import/';
		$config['allowed_types'] 	= 'xlsx';
		$config['file_name'] 		= 'Import_Excel-' . time();

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {	
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('pesanError', 'Hanya format xlsx yang diizinkan');
			redirect('manager/views/user');
		} else {
			$file_data = $this->upload->data();
			$file_path = $file_data['full_path'];

			$this->load->library('PHPExcel');

			$objPHPExcel 	= PHPExcel_IOFactory::load($file_path);
			$worksheet 		= $objPHPExcel->getActiveSheet();

			$highest_row 	= $worksheet->getHighestRow();
			$highest_column = $worksheet->getHighestColumn();
			for ($row = 2; $row <= $highest_row; $row++) {

				$data = array();
				for ($col = 'A'; $col <= $highest_column; $col++) {
					$cell_value = $worksheet->getCell($col . $row)->getValue();
					$data[] = $cell_value;
				}

				$options = [
					'cost' => 10,
				];
		
				$enkripPassword = password_hash($data[6], PASSWORD_BCRYPT, $options);

				$this->db->insert('tb_user', array(
					'nama' 			=> $data[0],
					'jenisKelamin' 	=> $data[1],
					'telp' 			=> $data[2],
					'email' 		=> $data[3],
					'alamat' 		=> $data[4],
					'username' 		=> $data[5],
					'level' 		=> $data[7],
					'tptLahir' 		=> $data[8],
					'tglLahir' 		=> $data[9],
					'password' 		=> $enkripPassword,
					'foto' 			=> 'no-image.png',
					'skin' 			=> 'blue',
					'login' 		=> 'Ya',
					'terdaftar' 	=> date('Y-m-d H:i:s'),
				));
			}

			$this->session->set_flashdata('pesan', 'Import data berhasil');
			redirect('manager/views/user');
		}
	}
}