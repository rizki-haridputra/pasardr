<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sewa extends CI_Controller {

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
		$data['title']		= 'Data sewa';
		$data['subtitle']	= 'Menampilkan semua data sewa';

		$data['collapse']	= 'No';

		$this->db->where('level', 'Pedagang');
		$data['pedagang']	= $this->m_model->get_desc('tb_user');
		if($this->session->userdata('level') == 'Pedagang') {
			$this->db->where('idPedagang', $this->session->userdata('id'));
		}
		$data['sewa']		= $this->m_model->get_desc('tb_sewa');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/sewa');
		$this->load->view('admin/templates/footer');
    }

public function insert()
{
    $idPedagang = $this->input->post('idPedagang');
    $idKios = $this->input->post('idKios');
    $harga = $this->input->post('harga');
    $tanggal = $this->input->post('tanggal');
    $status = $this->input->post('status');
    $idUserinput = $this->session->userdata('id');

    $start = new DateTime($tanggal);
    $year = $start->format('Y');
    $start->modify('first day of this month');
    $end = new DateTime($year . '-12-01');

    $dataInsert = [];

    while ($start <= $end) {
        // Cek apakah data sudah ada untuk bulan dan tahun ini
        $bulanTahun = $start->format('Y-m'); // contoh "2025-06"

        $this->db->where('idPedagang', $idPedagang);
        $this->db->where('idKios', $idKios);
        $this->db->like('tanggal', $bulanTahun, 'after'); // cari tanggal yang mulai dengan 'YYYY-MM'

        $exists = $this->db->get('tb_sewa')->row();

        if ($exists) {
            // Data sudah ada untuk bulan ini, skip insert bulan ini
            $start->modify('+1 month');
            continue; 
        }

        // Generate kode idSewa otomatis
        $prefix = 'SEWA';
        $ym = $start->format('Ym'); // contoh "202506"

        // Cari kode terakhir yg sudah ada dengan format SEWA202506____
        $this->db->like('idSewa', $prefix . $ym, 'after');
        $this->db->order_by('idSewa', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get('tb_sewa')->row();

        if ($last) {
            $lastNumber = intval(substr($last->idSewa, -4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $nextNumberFormatted = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $newIdSewa = $prefix . $ym . $nextNumberFormatted;

        $dataInsert[] = [
            'idSewa' => $newIdSewa,
            'idPedagang' => $idPedagang,
            'idKios' => $idKios,
            'harga' => $harga,
            'tanggal' => $start->format('Y-m-d'),
            'status' => $status,
            'idUserinput' => $idUserinput,
        ];

        $start->modify('+1 month');
    }

    if (count($dataInsert) == 0) {
        $this->session->set_flashdata('error', 'Data sewa untuk bulan dan tahun tersebut sudah ada semua.');
        redirect('admin/Sewa');
        return;
    }

    $this->db->insert_batch('tb_sewa', $dataInsert);

    $this->session->set_flashdata('success', 'Data sewa berhasil ditambahkan.');
    redirect('admin/Sewa');
}






	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_sewa');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/sewa');
	}

	public function update($id)
	{
		$idPedagang		= $_POST['idPedagang'];
		$idKios		= $_POST['idKios'];
		$harga			= $_POST['harga'];
		$status			= $_POST['status'];
		$tanggal		= $_POST['tanggal'];

		$data = array(
			'idPedagang' 	=> $idPedagang,
			'idKios' 		=> $idKios,
			'harga' 		=> $harga,
			'tanggal' 		=> $tanggal,
			'status' 		=> $status
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_sewa');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/sewa');
	}
}