<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class c_slipgaji extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */

    private $controller;
    private $view;
    protected $model;

    function __construct() {
        parent::__construct();
        $this->controller = 'c_slipgaji';
        $this->view = 'v_slipgaji';
        /* mulai load  di folder model */
        $this->load->model('m_periode_gaji', 'gaji'); /* cara pemanggilan Mdepartment_model menjadi department */
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
            "title" => 'Data Bank ',
            "base" => base_url(),
            "url_grid" => site_url($this->controller . '/grid'),
            "url_slipgaji" => site_url($this->controller . '/slipgaji'),
            "url_index" => site_url($this->controller),
            "url_post" => site_url($this->controller . '/postdata'),
        );
        $data['terakhir_posting'] = $this->gaji->tanggalposting();
        $this->load->view($this->view . '/home', $data); /* mengakses folder c_type, lalu ke file home.php, dengan mengirim variabel data yang isinya array */
    }

     public function grid() {
        echo json_encode(array(
                "data" => $this->gaji->getGridSlipData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
                //"data" => $this->type->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
        ));
    }

    function slipgaji(){

        $data['title'] = 'Form Cetak Slip Gaji'; //setting judul, yang akan berubah di form.php

        $data['url_post'] = site_url($this->controller . '/prosesslipgaji'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi addpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['url_iframe']=site_url($this->controller.'/iframedata'); 
        $this->load->view($this->view . '/form', $data); /* mengakses folder */
    }

    function prosesslipgaji(){
        $tanggalproses = date('Y-m-d', strtotime($this->input->post('periode_gaji')));
        $checkdata = $this->gaji->checkData($tanggalproses);
        if($checkdata > 0 ){
            $valid=true;
            $msg='Data tersedia';    

        }else{
            $valid=false;
            $msg ="Tidak ada data di periode ".$tanggalproses;
        }

        $jsondata =  array('valid' => $valid,"message"=>$msg,"tglproses"=>$tanggalproses);
        echo json_encode($jsondata);

    }

    function iframedata($tanggalproses) {
        $posting = date('Y-m-d', strtotime($tanggalproses));        
        $data['url'] = site_url($this->controller.'/printslip/' . $posting);
        $this->load->view($this->view.'/iframe', $data);
    }

    public function printslip($tanggalproses){
        $result = $this->gaji->getSlipData($tanggalproses)->result_array();
		
        set_time_limit(0);
        error_reporting(0);
        ob_clean();
		header('Content-type:application/pdf');
		header('Content-Disposition:inline;filename=slipgaji');
		header('Content-Transfer-Encoding:binary');
		header('Accept-Ranges:bytes');
        $this->load->library('mpdf54/mpdf');
        $mpdf=new mPDF('c', array(210, 135), '9', 'dejavusans', 10, 10, 10, 10, 0, 0); 
        foreach ($result as $row) {
                $rowpayroll = $this->gaji->getpersonal_payroll($row['id_karyawan']);
                $row['gapok'] = $rowpayroll->gapok;
                $html = $this->load->view($this->view.'/slipgaji', $row, TRUE);
                $this->output->set_output($html);
                $mpdf->WriteHTML($html);
                $mpdf->WriteHTML('<pagebreak sheet-size=210 135;/>');
        }

        $mpdf->Output();

      

    }


}
