<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

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
        }
    }

	public function index()
	{
        $data['title']      = 'Profil';
        $data['subtitle']   = 'Atur profil anda disini';

        $data['collapse']	= 'No';
        
        $this->db->limit('20');
        $this->db->where('idUser', $this->session->userdata('id'));
        $this->db->order_by('terdaftar', 'DESC');
        $data['log']    = $this->db->get('tb_log');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/profil');
		$this->load->view('admin/templates/footer');
    }

    public function updateaccount($id)
    {
        $nama           = $_POST['nama'];
        $jenisKelamin   = $_POST['jenisKelamin'];
        $tptLahir       = $_POST['tptLahir'];
        $tglLahir       = $_POST['tglLahir'];
        $telp           = $_POST['telp'];
        $email          = $_POST['email'];
        $alamat         = $_POST['alamat'];
        $username       = $_POST['username'];
        $skin           = $_POST['skin'];

        $this->db->select('username');
        $this->db->where('id', $this->session->userdata('id'));
        $cekUsername    = $this->db->get('tb_user');
        foreach ($cekUsername->result() as $usr) {
            $where = array('id' => $id);

            $data = array(
                'nama'          => $nama,
                'jenisKelamin'  => $jenisKelamin,
                'tptLahir'      => $tptLahir,
                'tglLahir'      => $tglLahir,
                'alamat'        => $alamat,
                'telp'          => $telp,
                'email'         => $email,
                'username'      => $username,
                'skin'          => $skin,
            );

            if($username == $usr->username) {    
                $this->m_model->update($where, $data, 'tb_user');
                $this->session->set_userdata($data);
                $this->session->set_flashdata('pesan', 'Profil berhasil diubah!');
                redirect('admin/profil');
            } else {
                //Cek Username Lain
                $this->db->where('username', $username);
                $cekUsernameLain    = $this->db->get('tb_user');
                if(empty($cekUsernameLain->num_rows())) {
                    $this->m_model->update($where, $data, 'tb_user');
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('pesan', 'Profil berhasil diubah!');
                    redirect('admin/profil');
                } else {
                    $this->session->set_flashdata('pesanError', 'Username tidak tersedia!');
                    redirect('admin/profil');
                }
            }
        }
    }

    public function updatepassword($id)
    {
        $password    = $_POST['newPassword'];

        $options = [
            'cost' => 10,
        ];

        $enkripPassword = password_hash($password, PASSWORD_BCRYPT, $options);

        $where = array('id' => $id);

        $data = array(
            'password'  => $enkripPassword,
        );

        $this->m_model->update($where, $data, 'tb_user');
        $this->session->set_flashdata('pesan', 'Password berhasil diubah!');
        redirect('admin/profil');
    }

    public function updatefoto($id)
    {
        $foto    = $_FILES['foto'];

        if($foto != ''){
            $config['upload_path']      = './assets/profil/';
            $config['allowed_types']    = 'png|jpg|jpeg';
            $config['file_name']        = 'Profil-' . time();

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('foto')){
                $foto = 'no-image.png';
                $this->session->set_flashdata('pesanError', 'Format tidak diijinkan!');
            } else {
                $foto = $this->upload->data('file_name');
                $this->session->set_flashdata('pesan', 'Foto berhasil diubah!');
            }
        }

        $where = array('id' => $id);

        $data = array(
            'foto'  => $foto,
        );

        $this->m_model->update($where, $data, 'tb_user');
        $this->session->set_userdata($data);
        redirect('admin/profil');
    }

    public function nonaktif($id)
    {
        $where = array('id' => $id);
        $data = array('login' => 'Tidak');

        $this->m_model->update($where, $data, 'tb_user');
        
        $this->session->sess_destroy();
        redirect('home');
    }
}