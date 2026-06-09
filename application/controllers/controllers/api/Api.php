<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    public function data($table) {
        $data = $this->m_model->getAllData($table)->result();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
