<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class c_penggajian extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */
    private $controller;
    private $view;
    protected $model;
	protected $param_bpjs_tng;
	protected $param_bpjs_kes;
	protected $param_lembur;

    function __construct() {
        parent::__construct();
        $this->controller = 'c_penggajian';
        $this->view = 'v_penggajian';
		$this->param_bpjs_kes =1; //dalam persen
		$this->param_bpjs_tng = 2;//dalam persen
		$this->param_lembur =173;
        /* mulai load  di folder model */
        $this->load->model('m_penggajian', 'penggajian');
		$this->load->model('m_bank', 'bank');		/* cara pemanggilan Mdepartment_model menjadi department */
		$this->load->model('m_karyawan', 'karyawan');/* selesai load Mdepartment_model.php di folder model */

        $this->load->model('m_ptkp', 'ptkp');/* selesai load m_ptkp.php di folder model */


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
             "title" =>'Data Penggajian',
            "base" => base_url(),
            "url_grid" => site_url($this->controller . '/grid'),
            "url_add" => site_url($this->controller . '/add'),
            "url_edit" => site_url($this->controller . '/edit'),
            "url_delete" => site_url($this->controller . '/remove'),
        );
        $this->load->view($this->view . '/home', $data); /* mengakses folder c_type, lalu ke file home.php, dengan mengirim variabel data yang isinya array */
        $this->load->view($this->view . '/confirm_delete', $data); /* mengakses folder c_type, lalu ke file confirm_delete.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk mendapatkan data dan menampilkan di tabel pada file home.php */

    public function grid() {
        echo json_encode(array(
                "data" => $this->penggajian->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
                //"data" => $this->type->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
        ));
    }

    /* fungsi ini akan mengakses form untuk kebutuhan add 
     * data, lalu setting array terhadap inputannya
     */

    function add() {
        $data['title'] = 'Add - Penggjian'; //setting judul, yang akan berubah di form.php
        $resultptkp = $this->ptkp->getAll();
        $i = 0;
        foreach ($resultptkp as $rowptkp) {
            $data['default']['id_ptkp'][-1]['value'] = NULL;
            $data['default']['id_ptkp'][-1]['display'] = '- Please Select -';
            $data['default']['id_ptkp'][$i]['value'] = $rowptkp['id_ptkp'];
            $data['default']['id_ptkp'][$i]['display'] =$rowptkp['status'];
            $i++;
        }

        $resultbank = $this->bank->getAll();
        $i = 0;
        foreach ($resultbank as $rowbank) {
            $data['default']['id_bank'][-1]['value'] = NULL;
            $data['default']['id_bank'][-1]['display'] = '- Please Select -';
            $data['default']['id_bank'][$i]['value'] = $rowbank['id_bank'];
            $data['default']['id_bank'][$i]['display'] =$rowbank['nama_bank'];
            $i++;
        }
		$resultkaryawan = $this->karyawan->getAll();
        $i = 0;
        foreach ($resultkaryawan as $rowkaryawan) {
            $data['default']['id_karyawan'][-1]['value'] = NULL;
            $data['default']['id_karyawan'][-1]['display'] = '- Please Select -';
            $data['default']['id_karyawan'][$i]['value'] = $rowkaryawan['id_karyawan'];
            $data['default']['id_karyawan'][$i]['display'] =$rowkaryawan['nik'].' - ' . $rowkaryawan['nama'];
            $i++;
        } 
        $data['default']['no_rekening'] = '';
		$data['default']['atas_nama'] = '';
		$data['default']['gapok'] = '';
		$data['default']['uang_makan'] = '';
		$data['default']['uang_transport'] = '';
		
		
		
		$data['url_post'] = site_url($this->controller . '/addpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi addpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = 0; //pads saat add data, id dibuat menjadi 0
        $this->load->view($this->view . '/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan add data, fungsi ini akan masuk ke database */

    public function addpost() {
        $this->form_validation->set_rules('id_bank', '', 'required'); //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
		$this->form_validation->set_rules('no_rekening', '', 'required');
		$this->form_validation->set_rules('gapok', '', 'required');
		$this->form_validation->set_rules('uang_makan', '', 'required');
		$this->form_validation->set_rules('id_karyawan', '', 'required');
		$this->form_validation->set_rules('atas_nama', '', 'required');
		$this->form_validation->set_rules('uang_transport', '', 'required');
	   if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $id_bank = $this->input->post('id_bank'); // menangkap post dari form.php ketika add data, dengan properties namenya adalah type
			$norekening = $this->input->post('no_rekening');
			$gapok = $this->input->post('gapok');
			$uangmakan = $this->input->post('uang_makan');
			$id_karyawan = $this->input->post('id_karyawan');
			$atas_nama = $this->input->post('atas_nama');
			$uangtransport = $this->input->post('uang_transport');
            $id_ptkp = $this->input->post('id_ptkp');
            $biaya_transfer = $this->input->post('biaya_transfer');

			$gajiharian = $gapok/30;
			
            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
				"id_karyawan" => $id_karyawan,
                "id_bank" => $id_bank,
				"no_rekening" => $norekening,
				"gapok" => $gapok,
				"uang_makan" => $uangmakan,
				"atas_nama" => $atas_nama,
				"uang_transport" => $uangtransport,
				"gaji_harian"=>$gajiharian,
				"parameter_bpjs_ketenagakerjaan"=>$this->param_bpjs_tng,
				"parameter_bpjs_kesehatan"=>$this->param_bpjs_kes,
				"parameterlembur"=>$this->param_lembur,
                "biaya_transfer"=>$biaya_transfer,
                "id_ptkp"=>$id_ptkp,
				
            );

            $checkdata = $this->penggajian->checkdata($id_karyawan); // melakukan pengecekan data
            if ($checkdata > 0) { /* jika data bernilai lebih dari 0, maka data tidak tersimpan, karena sudah ada */
                $valid = 'false';
                $message = 'data already exist';
                $err_id_karyawan = "Nama Karyawan sudah ada";
            } else { /* jika data belum ada,maka berhasil di simpan */
                $this->penggajian->insert($record);
                $valid = 'true';
                $message = "Insert data, success";
                $err_id_karyawan = null;
            }

            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => $message,
                "hasil" => $valid,
                "err_id_bank" => null,
				"err_id_karyawan" => $err_id_karyawan,
				"err_gapok" => null,
				"err_uang_makan" => null,
				"err_uang_transport" => null,
				"err_atas_nama" => null,
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Insert Data Failed',
                "hasil" => 'false',
                "err_id_bank" => form_error('id_bank'),
				"err_no_rekening" => form_error('no_rekening'),
				"err_gapok" => form_error('gapok'),
				"err_uang_makan" => form_error('uang_makan'),
				"err_uang_transport" => form_error('uang_transport'),
				"err_atas_nama" => form_error('atas_nama'),
            );
        }

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi edit ini akan mensetting nilai-nilai di form ketika mengklik tombol edit */

    function edit($id) {
        $row = $this->penggajian->getby_id($id)->row(); /* mendapatkan nilai data berdasarkan id, dan berupa row, yaitu 1 data */
        $data['title'] = 'Edit - Penggjian';
		
        $resultptkp = $this->ptkp->getAll();
        $i = 0;
        foreach ($resultptkp as $rowptkp) {
            $data['default']['id_ptkp'][-1]['value'] = NULL;
            $data['default']['id_ptkp'][-1]['display'] = '- Please Select -';
            $data['default']['id_ptkp'][$i]['value'] = $rowptkp['id_ptkp'];
            $data['default']['id_ptkp'][$i]['display'] =$rowptkp['status'];
            if ($row->id_ptkp == $rowptkp['id_ptkp']) {
                $data['default']['id_ptkp'][$i]['selected'] = "SELECTED";
            }
            $i++;
        }


        $resultkaryawan = $this->karyawan->getAll();
        $i = 0;
        foreach ($resultkaryawan as $rowkaryawan) {
            $data['default']['id_karyawan'][-1]['value'] = NULL;
            $data['default']['id_karyawan'][-1]['display'] = '- Please Select -';
            $data['default']['id_karyawan'][$i]['value'] = $rowkaryawan['id_karyawan'];
            $data['default']['id_karyawan'][$i]['display'] =$rowkaryawan['nama'];
			if ($row->id_karyawan == $rowkaryawan['id_karyawan']) {
                $data['default']['id_karyawan'][$i]['selected'] = "SELECTED";
            }
            $i++;
        }
       $resultbank = $this->bank->getAll();
        $i = 0;
        foreach ($resultbank as $rowbank) {
            $data['default']['id_bank'][-1]['value'] = NULL;
            $data['default']['id_bank'][-1]['display'] = '- Please Select -';
            $data['default']['id_bank'][$i]['value'] = $rowbank['id_bank'];
            $data['default']['id_bank'][$i]['display'] = $rowbank['id_bank'] . ' - ' . $rowbank['nama_bank'];
			if ($row->id_bank == $rowbank['id_bank']) {
                $data['default']['id_bank'][$i]['selected'] = "SELECTED";
            }
            $i++;
        } 
        $data['default']['biaya_transfer'] = $row->biaya_transfer;
		$data['default']['no_rekening'] = $row->no_rekening;
		$data['default']['atas_nama'] = $row->atas_nama;
		$data['default']['gapok'] = $row->gapok;
		$data['default']['uang_makan'] = $row->uang_makan;
		$data['default']['uang_transport'] = $row->uang_transport;
		
        $data['url_post'] = site_url($this->controller.'/editpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi editpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = $id; /* id akan bernilai sesuai data yang di edit */
        $this->load->view($this->view.'/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan edit data, fungsi ini akan masuk ke database */

    function editpost() {
        $this->form_validation->set_rules('id_bank', 'id_bank', 'required'); //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        $this->form_validation->set_rules('no_rekening', 'no_rekening', 'required'); 
		$this->form_validation->set_rules('gapok', 'gapok', 'required'); 
		$this->form_validation->set_rules('atas_nama', 'atas_nama', 'required'); 
		$this->form_validation->set_rules('uang_makan', 'uang_makan', 'required'); 
		$this->form_validation->set_rules('uang_transport', 'uang_transport', 'required'); 
		$this->form_validation->set_rules('id_karyawan', 'id_karyawan', 'required'); 
		
		
		
		if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id
            $id_bank= $this->input->post('id_bank'); // menangkap post dari form.php ketika add data, dengan properties namenya adalah type
			$no_rekening = $this->input->post('no_rekening');
			$id_karyawan = $this->input->post('id_karyawan');
			$atas_nama = $this->input->post('atas_nama');
			$gapok = $this->input->post('gapok');
			$uang_makan = $this->input->post('uang_makan');
			$uang_transport = $this->input->post('uang_transport');
            $id_ptkp = $this->input->post('id_ptkp');
            $biaya_transfer = $this->input->post('biaya_transfer');
			$gajiharian = $gapok/30;
            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                "id_bank" => $id_bank,
				"id_karyawan" => $id_karyawan,
				"no_rekening" => $no_rekening,
				"gapok" => $gapok,
				"uang_makan" => $uang_makan,
				"atas_nama" => $atas_nama,
				"uang_transport" => $uang_transport,
                "biaya_transfer"=>$biaya_transfer,
                "id_ptkp"=>$id_ptkp,
				"gaji_harian"=>$gajiharian,
				"parameter_bpjs_ketenagakerjaan"=>$this->param_bpjs_tng,
				"parameter_bpjs_kesehatan"=>$this->param_bpjs_kes,
				"parameterlembur"=>$this->param_lembur,

            );

            /* update ke database dengan memanggil model department, ke fungsi edit, dan mengirim parameter sebuah id, dan datanya berupa record */
            $this->penggajian->update($id, $record);

            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Update Data Success',
                "hasil" => 'true',
                "err_id_bank" => null,
				"err_no_rekening" => null,
				"err_id_karyawan" => null,
				"err_gapok" => null,
				"err_uang_makan" => null,
				"err_uang_transport" => null,
				"err_atas_nama" => null,
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Update Data Failed',
                "hasil" => 'false',
                "err_id_bank" => form_error('id_bank'),
				 "err_id_karyawan" => form_error('id_karyawan'),
				"err_no_rekening" => form_error('no_rekening'),
				"err_gapok" => form_error('gapok'),
				"err_uang_makan" => form_error('uang_makan'),
				"err_atas_nama" => form_error('atas_nama'),
				"err_uang_transport" => form_error('uang_transport'),
            );
        }
        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi untuk delete data */

    public function remove() {
        $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id_department
        $this->penggajian->delete($id); /* mengakses model department, lalu ke fungsi delete dengan parameter sebuah id */

        /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
        $jsonmsg = array(
            "msg" => 'Delete Data Succces',
            "hasil" => true
        );

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

}
