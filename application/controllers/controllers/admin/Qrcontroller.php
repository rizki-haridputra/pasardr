<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcontroller extends CI_Controller {
 
    public function index()
    {
        $this->load->library('ciqrcode');

        $params['data']     = 'https://google.com';
        $params['level']    = 'H';
        $params['size']     = 5;
        $params['savename'] = 'assets/qrcode/qrcode-oscarstore.png';
        $this->ciqrcode->generate($params);

        echo '<img src="'.base_url('assets/qrcode/').'qrcode-oscarstore.png" />';
    }
}
