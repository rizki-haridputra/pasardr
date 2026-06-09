<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_model extends CI_Model {

	// $table = 'kios';
    // $allowedFields = ['blok', 'nomor_kios', 'status', 'nama_pedagang', 'zona_tambahan'];

     
    // public function getBlok($namaBlok) {
    //     return $this->where('blok', $namaBlok)->orderBy('id', 'ASC')->findAll();
    // }

	public function get_where($where, $table)
	{
		return $this->db->get_where($table, $where);
	}

	public function insert($data, $table)
	{
		$this->db->insert($table, $data);
	}

	public function get_desc($table)
	{
		$this->db->ORDER_BY('id', 'desc');
		return $this->db->get($table);
	}
	
	
	public function get_harga($id_kios,$table)
	{	
		
		$this->db->select('hKios');
		$this->db->where('idKios', $id_kios);
		return $this->db->get($table)->row();
	}	
	
	
	public function get_data_kios($id,$table)
	{			
		$this->db->select('idKios');
		$this->db->where('id', $id);
		return $this->db->get($table)->result_array();
	}
	

	public function get_data_verifikasi($table)
	{
		$this->db->where('StatusSewa', 'proses');
		$this->db->ORDER_BY('id', 'desc');
		return $this->db->get($table);
	}
	
	public function get_data_validasi($table)
	{
		$this->db->where('StatusSewa', 'verifikasi');
		$this->db->ORDER_BY('id', 'desc');
		return $this->db->get($table);
	}
	
	public function get_data_penyewaan($table)
	{
		$this->db->where('StatusSewa', 'verifikasi');
		$this->db->ORDER_BY('id', 'desc');
		return $this->db->get($table);
	}

	public function get_status_sewa($table,$id)
	{	
		$this->db->where('idPedagang', $id);
		$this->db->where('StatusSewa', 'validasi');
		$this->db->ORDER_BY('id', 'asc');
		return $this->db->get($table);
	}


	public function get_sewa_user($table,$id)
	{	
		$this->db->where('idPedagang', $id);
		$this->db->ORDER_BY('id', 'asc');
		return $this->db->get($table);
	}

	public function get_data_perbaikan($table,$idSewa)
	{	
		$this->db->where('idSewa', $idSewa);;
		$this->db->ORDER_BY('id', 'asc');
		return $this->db->get($table)->row();
	}
	

	public function get_user($table)
	{	
		$level = 'Pedagang';
		$this->db->where('level','Pedagang');
		return $this->db->get($table)->result_array();
	}

	public function delete($where, $table)
	{
		$this->db->delete($table, $where);
	}

	public function update($where, $data, $table)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	//Get Data Kios Atas
	public function get_kios_atas_kiri1($table)
	{
		$this->db->where('posisiKios','ataskiri1');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_atas_kanan1($table)
	{
		$this->db->where('posisiKios','ataskanan1');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_atas_kiri2($table)
	{
		$this->db->where('posisiKios','ataskiri2');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_atas_kanan2($table)
	{
		$this->db->where('posisiKios','ataskanan2');
		return $this->db->get($table)->result_array();
	}

	//Get Data Kios Blok kiri
	public function get_kios_blok_kiri1($table)
	{
		$this->db->where('posisiKios','blokkiri1');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_blok_kiri2($table)
	{
		$this->db->where('posisiKios','blokkiri2');
		return $this->db->get($table)->result_array();
	}

	//Get Data Kios Tengah

	public function get_kios_tengah1($table)
	{
		$this->db->where('posisiKios','tengah-tengah-1');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah2($table)
	{
		$this->db->where('posisiKios','tengah-tengah-2');
		return $this->db->get($table)->result_array();
	}
	

	public function get_kios_tengah3($table)
	{
		$this->db->where('posisiKios','tengah-tengah-3');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah4($table)
	{
		$this->db->where('posisiKios','tengah-tengah-4');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah5($table)
	{
		$this->db->where('posisiKios','tengah-tengah-5');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah6($table)
	{
		$this->db->where('posisiKios','tengah-tengah-6');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah7($table)
	{
		$this->db->where('posisiKios','tengah-tengah-7');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah8($table)
	{
		$this->db->where('posisiKios','tengah-tengah-8');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah9($table)
	{
		$this->db->where('posisiKios','tengah-tengah-9');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah10($table)
	{
		$this->db->where('posisiKios','tengah-tengah-10');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah11($table)
	{
		$this->db->where('posisiKios','tengah-tengah-11');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah12($table)
	{
		$this->db->where('posisiKios','tengah-tengah-12');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah13($table)
	{
		$this->db->where('posisiKios','tengah-tengah-13');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah14($table)
	{
		$this->db->where('posisiKios','tengah-tengah-14');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah15($table)
	{
		$this->db->where('posisiKios','tengah-tengah-15');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah16($table)
	{
		$this->db->where('posisiKios','tengah-tengah-16');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah17($table)
	{
		$this->db->where('posisiKios','tengah-tengah-17');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah18($table)
	{
		$this->db->where('posisiKios','tengah-tengah-18');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah19($table)
	{
		$this->db->where('posisiKios','tengah-tengah-19');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah20($table)
	{
		$this->db->where('posisiKios','tengah-tengah-20');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah21($table)
	{
		$this->db->where('posisiKios','tengah-tengah-21');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah22($table)
	{
		$this->db->where('posisiKios','tengah-tengah-22');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah23($table)
	{
		$this->db->where('posisiKios','tengah-tengah-23');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah24($table)
	{
		$this->db->where('posisiKios','tengah-tengah-24');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah25($table)
	{
		$this->db->where('posisiKios','tengah-tengah-25');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah26($table)
	{
		$this->db->where('posisiKios','tengah-tengah-26');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah27($table)
	{
		$this->db->where('posisiKios','tengah-tengah-27');
		return $this->db->get($table)->result_array();
	}
	public function get_kios_tengah28($table)
	{
		$this->db->where('posisiKios','tengah-tengah-28');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah29($table)
	{
		$this->db->where('posisiKios','tengah-tengah-29');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah30($table)
	{
		$this->db->where('posisiKios','tengah-tengah-30');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah31($table)
	{
		$this->db->where('posisiKios','tengah-tengah-31');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_tengah32($table)
	{
		$this->db->where('posisiKios','tengah-tengah-32');
		return $this->db->get($table)->result_array();
	}

	//Get Data Kios Blok kanan
	public function get_kios_blok_kanan1($table)
	{
		$this->db->where('posisiKios','blokkanan1');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_blok_kanan2($table)
	{
		$this->db->where('posisiKios','blokkanan2');
		return $this->db->get($table)->result_array();
	}

	//Get Data Kios Bawah
	public function get_kios_bawah_kiri1($table)
	{
		$this->db->where('posisiKios','bawahkiri1');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_bawah_kanan1($table)
	{
		$this->db->where('posisiKios','bawahkanan1');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_bawah_kiri2($table)
	{
		$this->db->where('posisiKios','bawahkiri2');
		return $this->db->get($table)->result_array();
	}

	public function get_kios_bawah_kanan2($table)
	{
		$this->db->where('posisiKios','bawahkanan2');
		return $this->db->get($table)->result_array();
	}

	//Khusus API
	public function getAllData($table) {
        return $this->db->get($table);
    }

	public function get($table) {
        return $this->db->get($table);
    }

	public function jumlah_bayar_by_iduser($table,$id)
	{
		$this->db->where('idUserinput',$id);
		$this->db->select_sum('nominal');
		return $this->db->get($table)->row();
	}




}