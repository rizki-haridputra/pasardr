<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pasarbaru extends CI_Controller {

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
		
		$data['title']		= 'Data Kios Pasar Baru';
		$data['subtitle']	= 'Menampilkan semua data Kios Pasar Baru';

		$data['collapse']	= 'No';

		$this->db->where('level', 'Pedagang');
		$data['Pedagang']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Pedagang') {
			$this->db->where('idKios', $this->session->userdata('id'));
		}
		
		// $data['dataDenah']		= $this->m_model->get_desc('tb_kios');
		$data['data_kios_atas_kiri1']		= $this->m_model->get_kios_atas_kiri1('tb_kios');
		$data['data_kios_atas_kanan1']		= $this->m_model->get_kios_atas_kanan1('tb_kios');
		$data['data_kios_atas_kiri2']		= $this->m_model->get_kios_atas_kiri2('tb_kios');
		$data['data_kios_atas_kanan2']		= $this->m_model->get_kios_atas_kanan2('tb_kios');

		$data['blok_kiri1']					= $this->m_model->get_kios_blok_kiri1('tb_kios');
		$data['blok_kiri2']					= $this->m_model->get_kios_blok_kiri2('tb_kios');

		//.tengah baris pertama satu
		$data['data_kios_tengah1']			= $this->m_model->get_kios_tengah1('tb_kios');
		$data['data_kios_tengah2']			= $this->m_model->get_kios_tengah2('tb_kios');
		$data['data_kios_tengah3']			= $this->m_model->get_kios_tengah3('tb_kios');
		$data['data_kios_tengah4']			= $this->m_model->get_kios_tengah4('tb_kios');

		//.tengah baris pertama dua
		$data['data_kios_tengah5']			= $this->m_model->get_kios_tengah5('tb_kios');
		$data['data_kios_tengah6']			= $this->m_model->get_kios_tengah6('tb_kios');
		$data['data_kios_tengah7']			= $this->m_model->get_kios_tengah7('tb_kios');
		$data['data_kios_tengah8']			= $this->m_model->get_kios_tengah8('tb_kios');

		//.tengah baris pertama dua
		$data['data_kios_tengah9']			= $this->m_model->get_kios_tengah9('tb_kios');
		$data['data_kios_tengah10']			= $this->m_model->get_kios_tengah10('tb_kios');
		$data['data_kios_tengah11']			= $this->m_model->get_kios_tengah11('tb_kios');
		$data['data_kios_tengah12']			= $this->m_model->get_kios_tengah12('tb_kios');

		//.tengah baris pertama dua
		$data['data_kios_tengah13']			= $this->m_model->get_kios_tengah13('tb_kios');
		$data['data_kios_tengah14']			= $this->m_model->get_kios_tengah14('tb_kios');
		$data['data_kios_tengah15']			= $this->m_model->get_kios_tengah15('tb_kios');
		$data['data_kios_tengah16']			= $this->m_model->get_kios_tengah16('tb_kios');

		//.tengah baris pertama dua
		$data['data_kios_tengah17']			= $this->m_model->get_kios_tengah17('tb_kios');
		$data['data_kios_tengah18']			= $this->m_model->get_kios_tengah18('tb_kios');
		$data['data_kios_tengah19']			= $this->m_model->get_kios_tengah19('tb_kios');
		$data['data_kios_tengah20']			= $this->m_model->get_kios_tengah20('tb_kios');

		//.tengah baris pertama dua
		$data['data_kios_tengah21']			= $this->m_model->get_kios_tengah21('tb_kios');
		$data['data_kios_tengah22']			= $this->m_model->get_kios_tengah22('tb_kios');
		$data['data_kios_tengah23']			= $this->m_model->get_kios_tengah23('tb_kios');
		$data['data_kios_tengah24']			= $this->m_model->get_kios_tengah24('tb_kios');

		//.tengah baris pertama dua
		$data['data_kios_tengah25']			= $this->m_model->get_kios_tengah25('tb_kios');
		$data['data_kios_tengah26']			= $this->m_model->get_kios_tengah26('tb_kios');
		$data['data_kios_tengah27']			= $this->m_model->get_kios_tengah27('tb_kios');
		$data['data_kios_tengah28']			= $this->m_model->get_kios_tengah28('tb_kios');

		//.tengah baris pertama dua
		$data['data_kios_tengah29']			= $this->m_model->get_kios_tengah29('tb_kios');
		$data['data_kios_tengah30']			= $this->m_model->get_kios_tengah30('tb_kios');
		$data['data_kios_tengah31']			= $this->m_model->get_kios_tengah31('tb_kios');
		$data['data_kios_tengah32']			= $this->m_model->get_kios_tengah32('tb_kios');

		
		$data['blok_kanan1']				= $this->m_model->get_kios_blok_kanan1('tb_kios');
		$data['blok_kanan2']				= $this->m_model->get_kios_blok_kanan2('tb_kios');

		$data['data_kios_bawah_kiri1']			= $this->m_model->get_kios_bawah_kiri1('tb_kios');
		$data['data_kios_bawah_kanan1']			= $this->m_model->get_kios_bawah_kanan1('tb_kios');
		$data['data_kios_bawah_kiri2']			= $this->m_model->get_kios_bawah_kiri2('tb_kios');
		$data['data_kios_bawah_kanan2']			= $this->m_model->get_kios_bawah_kanan2('tb_kios');
	
		
		$this->load->view('manager/templates/header', $data);
		$this->load->view('manager/templates/sidebar');
		$this->load->view('manager/views/pasarbaru');
		$this->load->view('manager/templates/footer');
    }
}