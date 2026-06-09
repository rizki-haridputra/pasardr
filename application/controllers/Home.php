<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->library('licensing');
        $this->load->library('login_attempt');
        $this->load->library('form_Validation');
        $this->licensing->check_license();
        //Get Zona Waktu
        foreach ($this->db->get('tb_aplikasi')->result() as $timezone) {
            date_default_timezone_set($timezone->timezone);
        }
	}

    public function index()
    {
        if ($this->session->userdata('level') == 'Administrator' OR $this->session->userdata('level') == 'Pedagang') {
            redirect('admin/dashboard');
        } else {
            $data['title']  = 'Login';
            $digit1 = mt_rand(1, 20);
            $digit2 = mt_rand(1, 20);
            
            $captcha = array('captcha' => $digit1+$digit2);

            $this->session->set_userdata($captcha);
            $data['captcha'] = "$digit1 + $digit2 = ?";

            $data['aplikasi'] = $this->m_model->get_desc('tb_aplikasi');

            $this->load->view('login', $data);
        }
    }
    
    public function auth()
    {
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $jawaban    = $_POST['jawaban'];

        if(!empty($jawaban)) {

            if($jawaban == $this->session->userdata('captcha')) {
       
                $where = array( 'username' => $username );

                $cek = $this->m_model->get_where($where, 'tb_user');
    
                if ($cek->num_rows() > 0) {
                    
                    // Check if login attempts exceeded
                    if ($this->login_attempt->is_max_login_attempts_exceeded($username)) {
                        // Block account
                        $this->session->set_flashdata('pesan', 'Kesempatan login sudah habis, silahkan coba lagi nanti!');
                        redirect('home');
                    }
                    
                    foreach ($cek->result_array() as $row) {

                        if(password_verify($password, $row['password'])) {

                            if($row['login'] == 'Ya') {
                                $datauser = array(
                                    'id'            => $row['id'], 
                                    'nama'          => $row['nama'],  
                                    'jenisKelamin'  => $row['jenisKelamin'],
                                    'tptLahir'      => $row['tptLahir'],
                                    'tglLahir'      => $row['tglLahir'],
                                    'telp'          => $row['telp'],   
                                    'email'         => $row['email'],
                                    'login'         => $row['login'],
                                    'alamat'        => $row['alamat'],
                                    'username'      => $row['username'],
                                    'skin'          => $row['skin'],
                                    'level'         => $row['level'],
                                    'foto'          => $row['foto'],
                                    'terdaftar'     => $row['terdaftar'],
                                    'start_time'    => date('Y-m-d H:i:s'),
                                );
    
                                $this->session->set_userdata($datauser);
    
                                $insertLog = array(
                                    'idUser'    => $row['id'],
                                    'status'    => 'Login',
                                    'ipAddress' => $_SERVER['REMOTE_ADDR'],
                                    'device'    => $_SERVER['HTTP_USER_AGENT'],
                                    'terdaftar' => date('Y-m-d H:i:s'),
                                );
    
                                $this->m_model->insert($insertLog, 'tb_log');

                                $this->login_attempt->reset_login_attempts($username);
                                
                                if($row['level'] == 'Administrator') {
                                    redirect('admin/dashboard');
                                }elseif($row['level'] == 'Administrator') {
                                    redirect('admin/dashboard');
                                }elseif($row['level'] == 'Pedagang') {
                                    redirect('pedagang/dashboard');
                                }elseif($row['level'] == 'Petugas') {
                                    redirect('petugas/dashboard');
                                }elseif($row['level'] == 'Manager') {
                                    redirect('manager/dashboard');
                                }
                                
                            } else {
                                $this->session->set_flashdata('pesan', 'Tidak ada akses login, silahkan hubungi administrator!');
                                redirect('home');
                            }
                            
                        } else {
                            $this->login_attempt->increment_login_attempts($username);

                            $this->session->set_flashdata('pesan', 'Password anda salah!');
                            redirect('home');
                        }
                    }
                } else {
                    $this->session->set_flashdata('pesan', 'Username tidak ditemukan!');
                    redirect('home');
                }
            } else {
                $this->session->set_flashdata('pesan', 'Hitung dengan benar!');
                redirect('home');
            }
        } else {
            $this->session->set_flashdata('pesan', 'Captcha harap diisi!');
            redirect('home');
        }
    }

    public function logout()
    {
        $insertLog = array(
            'idUser'    => $this->session->userdata('id'),
            'status'    => 'Logout',
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'device'    => $_SERVER['HTTP_USER_AGENT'],
            'terdaftar' => date('Y-m-d H:i:s'),
        );

        $this->m_model->insert($insertLog, 'tb_log');

        $this->session->sess_destroy();
        redirect('home');
    }
	
	public function register()
{
    // Ambil data aplikasi (logo, nama) seperti di halaman login
    // $data['tb_user)'] = $this->db->get('tb_user');
    $data['title'] = 'Halaman Pendaftaran';
    $data['aplikasi'] = $this->m_model->get_desc('tb_aplikasi');
    
    // Tampilkan view registrasi
    $this->load->view('register', $data);
    
   
}

public function proses_register()
{
    // 1. Atur aturan validasi untuk form
    // $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
    // $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
    // $this->form_validation->set_rules('password2', 'Confirm Password', 'required|matches[password]');

    // // 2. Jalankan validasi
    // if ($this->form_validation->run() == FALSE) {
    //     // Jika validasi gagal, kembali ke halaman registrasi dengan pesan error
    //     $this->register();
    // } else {
        // 3. Jika validasi berhasil, ambil data dari POST
        // $data = [
        //     'nama'         => $this->input->post('nama'),
        //     'username'     => $this->input->post('username'),
        //     'email'        => $this->input->post('email'),
        //     'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT), // Enkripsi password
        //     // field lain...
        // ];
    
        // // 4. Simpan data ke database
        // $this->m_model->insert('tb_user', $data);
    
        // // 5. Beri notifikasi sukses dan redirect ke halaman login
        // $this->session->set_flashdata('pesan', 'Pendaftaran berhasil, silahkan login.');
        // redirect('home');
        $nama			= $_POST['nama'];
		$email			= $_POST['email'];
        $telp           = $_POST['telp'];
        $alamat         = $_POST['alamat'];
		$login			= 'Ya';
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
				'email' 		=> $email,
				'login' 		=> $login,
				'username'		=> $username,
				'password'		=> $enkripPassword,
				'foto'			=> $foto,
				'skin'			=> $skin,
				'level'			=> $level,
				'terdaftar'		=> $terdaftar,
			);
	
			$this->m_model->insert($data, 'tb_user');
			$this->session->set_flashdata('pesan', 'Pendaftaran berhasil, silahkan login!');
			redirect('home');
		} else {
			$this->session->set_flashdata('pesanError', 'Username sudah ada!');
			redirect('home/register');
		}
   // }
}
}