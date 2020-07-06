<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class c_t_absensi extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */
    private $controller;
    private $view;
    protected $model;

    function __construct() {
        parent::__construct();
		
        $this->controller = 'c_t_absensi';
        $this->view = 'v_t_absensi';
        /* mulai load  di folder model */
        $this->load->model('m_t_absensi', 't_absensi'); /* cara pemanggilan Mdepartment_model menjadi department */
		$this->load->model('m_karyawan', 'karyawan');
		$this->load->library("PHPExcel-1.8/Classes/PHPExcel");
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
             "title" =>'Transaksi Abensi',
            "base" => base_url(),
            "url_grid" => site_url($this->controller . '/grid'),
            "url_add" => site_url($this->controller . '/add'),
            "url_edit" => site_url($this->controller . '/edit'),
            "url_delete" => site_url($this->controller . '/remove'),
			"url_importabsensi" => site_url($this->controller . '/importabsensi'),
        );
        $this->load->view($this->view . '/home', $data); /* mengakses folder c_type, lalu ke file home.php, dengan mengirim variabel data yang isinya array */
        $this->load->view($this->view . '/confirm_delete', $data); /* mengakses folder c_type, lalu ke file confirm_delete.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk mendapatkan data dan menampilkan di tabel pada file home.php */
	public function importabsensi(){
	$data['url_post'] = site_url($this->controller. '/postdata_import');
	$data['url_index'] = site_url($this->controller. '/index');
	$this->load->view($this->view . '/home_import',$data);
	}
	public function postdata_import(){
	$config['upload_path'] = './public/uploads/';
        $config['allowed_types'] = 'xlsx|xls';
        
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload('file')){
            $error = array('error' => $this->upload->display_errors());
        }
        else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
             ini_set('memory_limit', '-1');
        $inputFileName = './public/uploads/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }
 
        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);
 
        for ($i=1; $i < ($numRows+1) ; $i++) { 
		
		$nik=$worksheet[$i]["A"];
		$tanggal= date('Y-m-d',strtotime($worksheet[$i]["B"]));
		$statusabsensi=$worksheet[$i]["C"];
		
               
		$datakaryawan = $this->karyawan->getdata_bynik($nik);              
		if(!empty($datakaryawan)){
			$rowdatakaryawan = $datakaryawan->row();                       
			$id_karyawan = $rowdatakaryawan->id_karyawan;
			
			$checkdata = $this->t_absensi->checkimportdata($id_karyawan,$tanggal);
			if($checkdata==0){
				$record = array(                
					"id_karyawan" => $id_karyawan,
					"status_kehadiran" => $statusabsensi,	
					"tgl_absensi" => date('Y-m-d',strtotime($tanggal)),				
				);
				$this->t_absensi->insert($record);
			
			}
		}
		
        }
		 /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
        $jsonmsg = array(
            "msg" => 'Import Data Succces',
            "hasil" => true
        );

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
		
		
      }
	}
    public function grid() {
        echo json_encode(array(
                "data" => $this->t_absensi->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
                //"data" => $this->type->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
        ));
    }

    /* fungsi ini akan mengakses form untuk kebutuhan add 
     * data, lalu setting array terhadap inputannya
     */

    function add() {
        $data['title'] = 'Add - Transaksi Absensi'; //setting judul, yang akan berubah di form.php
       
		$resultkaryawan = $this->karyawan->getAll();
        $i = 0;
        foreach ($resultkaryawan as $rowkaryawan) {
            $data['default']['id_karyawan'][-1]['value'] = NULL;
            $data['default']['id_karyawan'][-1]['display'] = '- Please Select -';
            $data['default']['id_karyawan'][$i]['value'] = $rowkaryawan['id_karyawan'];
            $data['default']['id_karyawan'][$i]['display'] = $rowkaryawan['nik']. ' - ' . $rowkaryawan['nama'];
            $i++;
        } 
		$data['default']['status_kehadiran'] = null;
		$data['default']['status_kehadiran'][0]['value'] = null;
		$data['default']['status_kehadiran'][0]['display'] = '- Please Select -';
		$data['default']['status_kehadiran'][1]['value'] = 'H';
		$data['default']['status_kehadiran'][1]['display'] = 'Hadir';
		$data['default']['status_kehadiran'][2]['value'] = 'TH';
		$data['default']['status_kehadiran'][2]['display'] = 'Tidak Hadir';
	
		
		 
		 
		 
		$data['url_post'] = site_url($this->controller . '/addpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi addpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = 0; //pads saat add data, id dibuat menjadi 0
        $this->load->view($this->view . '/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan add data, fungsi ini akan masuk ke database */

    public function addpost() {
         //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        $this->form_validation->set_rules('id_karyawan', 'nama karyawan', 'required');
		
		$this->form_validation->set_rules('status_kehadiran', 'status_kehadiran', 'required');
		$this->form_validation->set_rules('tgl_absensi', 'tgl_absensi', 'required');
		
		if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            // menangkap post dari form.php ketika add data, dengan properties namenya adalah type
			$id_karyawan = $this->input->post('id_karyawan');
			$status_kehadiran = $this->input->post('status_kehadiran');
			$tgl_absensi = $this->input->post('tgl_absensi');
			
            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                
				"id_karyawan" => $id_karyawan,
				"status_kehadiran" => $status_kehadiran,	
				"tgl_absensi" => date('Y-m-d',strtotime($tgl_absensi)),
				
				
				
            );

            $checkdata = $this->t_absensi->checkdata($id_karyawan,$tgl_absensi); // melakukan pengecekan data
            if ($checkdata > 0) { /* jika data bernilai lebih dari 0, maka data tidak tersimpan, karena sudah ada */
                $valid = 'false';
                $message = 'data already exist';
                $err_id_karyawan = "id karyawan sudah ada";
            } else { /* jika data belum ada,maka berhasil di simpan */
                $this->t_absensi->insert($record);
                $valid = 'true';
                $message = "Insert data, success";
                $err_id_karyawan = null;
            }

            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => $message,
                "hasil" => $valid,
                "err_id_karyawan" => $err_id_karyawan,
				
				
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Insert Data Failed',
                "hasil" => 'false',
                "err_id_karyawan" => form_error('id_karyawan'),
				"err_tgl_absensi" => form_error('tgl_absensi'),
				"err_status_kehadiran" => form_error('status_kehadiran)'),
				
            );
        }

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi edit ini akan mensetting nilai-nilai di form ketika mengklik tombol edit */

    function edit($id) {
        $row = $this->t_absensi->getby_id($id)->row(); /* mendapatkan nilai data berdasarkan id, dan berupa row, yaitu 1 data */
      //print_r($row);
	//exit;
	  $data['title'] = 'Edit - Transaksi Absensi';
		
		
		$resultkaryawan = $this->karyawan->getAll();
        $i = 0;
        foreach ($resultkaryawan as $rowkaryawan) {
            $data['default']['id_karyawan'][-1]['value'] = NULL;
            $data['default']['id_karyawan'][-1]['display'] = '- Please Select -';
            $data['default']['id_karyawan'][$i]['value'] = $rowkaryawan['id_karyawan'];
            $data['default']['id_karyawan'][$i]['display'] = $rowkaryawan['id_karyawan']. ' - ' . $rowkaryawan['nama'];
            if ($row->id_karyawan == $rowkaryawan['id_karyawan']) {
                $data['default']['id_karyawan'][$i]['selected'] = "SELECTED";
            }
			$i++;
        } 
		
		$data['default']['tgl_absensi'] =date('d-m-Y',strtotime($row->tgl_absensi));
		$data['default']['status_kehadiran'][-1]['value'] = NULL;
		$data['default']['status_kehadiran'][-1]['display'] = '- Please Select -';
		$data['default']['status_kehadiran'][0]['value'] = 'H';
		$data['default']['status_kehadiran'][0]['display'] = 'Hadir';
		$data['default']['status_kehadiran'][1]['value'] = 'TH';
		$data['default']['status_kehadiran'][1]['display'] = 'Tidak Hadir';
		
		if ($row->status_kehadiran == 'H') {
                $data['default']['status_kehadiran'][0]['selected'] = "SELECTED";
        } else if($row->status_kehadiran== 'TH'){
			 $data['default']['status_kehadiran'][1]['selected'] = "SELECTED";
		}else {
			 $data['default']['status_kehadiran'][-1]['selected'] = "SELECTED";
		}
		

        $data['url_post'] = site_url($this->controller.'/editpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi editpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = $id; /* id akan bernilai sesuai data yang di edit */
        $this->load->view($this->view.'/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan edit data, fungsi ini akan masuk ke database */

    function editpost() {
         //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
		$this->form_validation->set_rules('id_karyawan', 'nama karyawan', 'required');
		
		$this->form_validation->set_rules('status_kehadiran', 'status_kehadiran', 'required');
		$this->form_validation->set_rules('tgl_absensi', 'tgl_absensi', 'required');
		

	   if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id
			$id_karyawan = $this->input->post('id_karyawan');
			
			$status_kehadiran = $this->input->post('status_kehadiran');
			$tgl_absensi = $this->input->post('tgl_absensi');
			
            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                
				"id_karyawan" => $id_karyawan,
				
				"tgl_absensi" => date('Y-m-d',strtotime($tgl_absensi)),
				"status_kehadiran" =>$status_kehadiran,
				
            );

            /* update ke database dengan memanggil model department, ke fungsi edit, dan mengirim parameter sebuah id, dan datanya berupa record */
            $this->t_absensi->update($id, $record);

            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Update Data Success',
                "hasil" => 'true',
                "err_id_karyawan" => null,
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Update Data Failed',
                "hasil" => 'false',
                
				"err_id_karyawan" => form_error('id_karyawan'),
				"err_tgl_absensi" => form_error('tgl_absensi'),
				"err_status_kehadiran" => form_error('status_kehadiran)'),
				
				
            );
        }
        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi untuk delete data */

    public function remove() {
        $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id_department
        $this->t_absensi->delete($id); /* mengakses model department, lalu ke fungsi delete dengan parameter sebuah id */

        /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
        $jsonmsg = array(
            "msg" => 'Delete Data Succces',
            "hasil" => true
        );

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

}
