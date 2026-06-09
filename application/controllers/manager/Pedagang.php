<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pedagang extends CI_Controller {

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
		$data['title']		= 'Data Pedagang';
		$data['subtitle']	= 'Semua data pedagang akan muncul disini';

		$data['collapse']	= 'No';
	
		$this->db->where('level', 'Pedagang');
		$data['user']       = $this->m_model->get_desc('tb_user');
		
		$this->load->view('manager/templates/header', $data);
		$this->load->view('manager/templates/sidebar');
		$this->load->view('manager/views/pedagang');
		$this->load->view('manager/templates/footer');
    }

    public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_user');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus');
		redirect('manager/views/pedagang');
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
		$level			= 'Pedagang';
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
			$this->session->set_flashdata('pesan', 'Data berhasil dibuat!');
			redirect('manager/views/managers');
		} else {
			$this->session->set_flashdata('pesanError', 'Username sudah ada!');
			redirect('manager/views/managers');
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
		redirect('manager/views/managers');
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
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('manager/views/pedagang');
	}
}