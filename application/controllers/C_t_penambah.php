<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class c_t_penambah extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */
    private $controller;
    private $view;
    protected $model;

    function __construct() {
        parent::__construct();
        $this->controller = 'c_t_penambah';
        $this->view = 'v_t_penambah';
        /* mulai load  di folder model */
        $this->load->model('m_t_penambah', 't_penambah'); /* cara pemanggilan Mdepartment_model menjadi department */
        $this->load->model('m_penambah', 'penambah');/* selesai load Mdepartment_model.php di folder model */
		$this->load->model('m_karyawan', 'karyawan');
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
             "title" =>'Transaksi Penambah',
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
                "data" => $this->t_penambah->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
                //"data" => $this->type->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
        ));
    }

    /* fungsi ini akan mengakses form untuk kebutuhan add 
     * data, lalu setting array terhadap inputannya
     */

    function add() {
        $data['title'] = 'Add - t_penambah'; //setting judul, yang akan berubah di form.php
       $resulttambah = $this->penambah->getAll();
        $i = 0;
        foreach ($resulttambah as $rowtambah) {
            $data['default']['id_penambah'][-1]['value'] = NULL;
            $data['default']['id_penambah'][-1]['display'] = '- Please Select -';
            $data['default']['id_penambah'][$i]['value'] = $rowtambah['id_penambah'];
            $data['default']['id_penambah'][$i]['display'] = $rowtambah['id_penambah'] . ' - ' . $rowtambah['nama_penambah'];
            $i++;
        } 
		
		$resultkaryawan = $this->karyawan->getAll();
        $i = 0;
        foreach ($resultkaryawan as $rowkaryawan) {
            $data['default']['id_karyawan'][-1]['value'] = NULL;
            $data['default']['id_karyawan'][-1]['display'] = '- Please Select -';
            $data['default']['id_karyawan'][$i]['value'] = $rowkaryawan['id_karyawan'];
            $data['default']['id_karyawan'][$i]['display'] = $rowkaryawan['nik']. ' - ' . $rowkaryawan['nama'];
            $i++;
        } 
		$data['default']['catatan'] = ''; 
		$data['default']['periode_gaji'] = '';
		 
		 
		$data['default']['periode_gaji']=date('m/01/Y');
		$data['url_post'] = site_url($this->controller . '/addpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi addpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = 0; //pads saat add data, id dibuat menjadi 0
        $this->load->view($this->view . '/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan add data, fungsi ini akan masuk ke database */

    public function addpost() {
        $this->form_validation->set_rules('id_penambah', '', 'required'); //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        $this->form_validation->set_rules('id_karyawan', '', 'required');
		$this->form_validation->set_rules('periode_gaji', '', 'required');
		$this->form_validation->set_rules('catatan', '', 'required');
		if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $id_penambah = $this->input->post('id_penambah'); // menangkap post dari form.php ketika add data, dengan properties namenya adalah type
			$id_karyawan = $this->input->post('id_karyawan');
			$periode_gaji = $this->input->post('periode_gaji');
			$catatan = $this->input->post('catatan');
			$nilai = $this->input->post('nilai');
            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                "id_penambah" => $id_penambah,
				"id_karyawan" => $id_karyawan,
				"periode_gaji" => date('Y-m-d',strtotime($periode_gaji)),
				"catatan" => $catatan,
				"nilai"=>$nilai
				
				
            );

            $checkdata = $this->t_penambah->checkdata($id_karyawan,$id_penambah,$periode_gaji); // melakukan pengecekan data
            if ($checkdata > 0) { /* jika data bernilai lebih dari 0, maka data tidak tersimpan, karena sudah ada */
                $valid = 'false';
                $message = 'data already exist';
                $err_id_karyawan = "id karyawan sudah ada";
            } else { /* jika data belum ada,maka berhasil di simpan */
                $this->t_penambah->insert($record);
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
				"err_id_penambah" => form_error('id_penambah'),
				"err_periode_gaji" => form_error('periode_gaji)'),
				"err_catatan" => form_error('catatan'),
            );
        }

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi edit ini akan mensetting nilai-nilai di form ketika mengklik tombol edit */

    function edit($id) {
        $row = $this->t_penambah->getby_id($id)->row(); /* mendapatkan nilai data berdasarkan id, dan berupa row, yaitu 1 data */
        $data['title'] = 'Edit - t_penambah';
		$resulttambah = $this->penambah->getAll();
      
        $i = 0;
        foreach ($resulttambah as $rowtambah) {
            $data['default']['id_penambah'][-1]['value'] = NULL;
            $data['default']['id_penambah'][-1]['display'] = '- Please Select -';
            $data['default']['id_penambah'][$i]['value'] = $rowtambah['id_penambah'];
            $data['default']['id_penambah'][$i]['display'] = $rowtambah['id_penambah'] . ' - ' . $rowtambah['nama_penambah'];
            if ($row->id_penambah == $rowtambah['id_penambah']) {
                $data['default']['id_penambah'][$i]['selected'] = "SELECTED";
            }
			$i++;
        } 
		
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
		$data['default']['catatan'] = $row->catatan; 
		$data['default']['periode_gaji'] = $row->periode_gaji;
		$data['default']['nilai'] = $row->nilai; 
		

        $data['url_post'] = site_url($this->controller.'/editpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi editpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = $id; /* id akan bernilai sesuai data yang di edit */
        $this->load->view($this->view.'/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan edit data, fungsi ini akan masuk ke database */

    function editpost() {
        $this->form_validation->set_rules('id_karyawan', '', 'required'); //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
		$this->form_validation->set_rules('id_penambah', '', 'required');
		$this->form_validation->set_rules('periode_gaji', '', 'required');
		$this->form_validation->set_rules('catatan', '', 'required');

	   if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id
            $id_karyawan = $this->input->post('id_karyawan'); // menangkap post dari form.php ketika add data, dengan properties namenya adalah type
			$id_penambah = $this->input->post('id_penambah');
			$periode_gaji = $this->input->post('periode_gaji');
			$catatan = $this->input->post('catatan');
			$nilai = $this->input->post('nilai');
            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                "id_karyawan" => $id_karyawan,
				"id_penambah" => $id_penambah,
				"periode_gaji" =>date('Y-m-d',strtotime($periode_gaji)),
				"catatan" => $catatan,
				"nilai" => $nilai,
            );

            /* update ke database dengan memanggil model department, ke fungsi edit, dan mengirim parameter sebuah id, dan datanya berupa record */
            $this->t_penambah->update($id, $record);

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
				"err_id_penambah" => form_error('id_penambah'),
				"err_periode_gaji" => form_error('periode_gaji'),
				"err_catatan" => form_error('catatan'),
            );
        }
        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi untuk delete data */

    public function remove() {
        $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id_department
        $this->t_penambah->delete($id); /* mengakses model department, lalu ke fungsi delete dengan parameter sebuah id */

        /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
        $jsonmsg = array(
            "msg" => 'Delete Data Succces',
            "hasil" => true
        );

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

}
