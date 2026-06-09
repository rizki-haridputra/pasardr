<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Memuat model yang sudah kita buat
        $this->load->model('Sewa_model');
        
        // Menjalankan fungsi pembaruan otomatis setiap kali controller yang
        // mewarisi MY_Controller ini dipanggil.
        $this->Sewa_model->updateStatusSewaOtomatis();
    }
}