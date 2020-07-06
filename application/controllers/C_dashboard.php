<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->is_logged();
        $this->load->model('m_user', 'user'); /* cara pemanggilan Mdepartment_model menjadi department */
    }

    function is_logged() {
        if ($this->session->userdata('ses_statuslogin') != TRUE) {
            redirect('c_login', 'refresh');
        }
    }

    public function index() {
        $data = array(
            "base" => base_url(),
            "site" => site_url(),
        );

        $username = $this->session->userdata('ses_username');
        $rowuser = $this->user->getdata_byusername($username)->row();
		$data['role'] = $rowuser->role;
        $this->load->view("template/index", $data);
    }

}
