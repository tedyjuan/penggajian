<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_rpttransfer extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */

    private $controller;
    private $view;
    protected $model;

    function __construct() {
        parent::__construct();
        $this->controller = 'c_rpttransfer';
        $this->view = 'v_rpttransfer';
        /* mulai load  di folder model */
        $this->load->model('M_periode_gaji', 'gaji'); /* cara pemanggilan Mdepartment_model menjadi department */
        /* selesai load Mdepartment_model.php di folder model */

        /* mulai pengecekan login, apakah user benar melalui login form atau tidak, jika tidak
         * maka keluarkan dan arahkan ke conrroller login.php 
         */
        //  $this->is_logged();
    }

    /* fungsi pengecekan user login */

    function is_logged() {
        if ($this->session->userdata('ses_statuslogin') != TRUE) {
            redirect('c_login', 'refresh');
        }
    }

    /* fungsi index yang di load pertama pada saat controller Mdepartment di akses */

    public function index() {
        /* setting array key untuk di home.php agar urlnya dinamis, maka 
         * ketika copy home.php hanya mengubah parameternya di controller saja
         */
        $data = array(
            "title" => 'Data Agama',
            "base" => base_url(),
            "url_post" => site_url($this->controller . '/postdata'),
            "url_exceldata" => site_url($this->controller . '/exceldata'),
            "url_index" => site_url($this->controller),
        );
        $this->load->view($this->view . '/home', $data); /* mengakses folder c_type, lalu ke file home.php, dengan mengirim variabel data yang isinya array */
    }

    function postdata() {
        $tanggalproses = date('Y-m-d', strtotime($this->input->post('periode_gaji')));
        $checkdata = $this->gaji->checkData($tanggalproses);
        if ($checkdata > 0) {
            $valid = true;
            $msg = 'Data tersedia';
        } else {
            $valid = false;
            $msg = "Tidak ada data di periode " . $tanggalproses;
        }

        $jsondata = array('valid' => $valid, "message" => $msg, "tglproses" => $tanggalproses);
        echo json_encode($jsondata);
    }

    function exceldata($tanggalproses) {
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"biayatransferbank.xlsx\"");
        header("Cache-Control: max-age=0");
        $result = $this->gaji->getSlipData($tanggalproses)->result_array();
        $data['result'] = $result;
        $data['modeldata'] = $this->gaji;
        $html = $this->load->view($this->view . '/report', $data, true);
        echo $html;
    }

}
