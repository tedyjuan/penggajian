<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class c_agama extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */
    private $controller;
    private $view;
    protected $model;

    function __construct() {
        parent::__construct();
        $this->controller = 'c_agama';
        $this->view = 'v_agama';
        /* mulai load  di folder model */
        $this->load->model('m_agama', 'agama'); /* cara pemanggilan Mdepartment_model menjadi department */
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
             "title" =>'Data Agama',
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
                "data" => $this->agama->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
                //"data" => $this->type->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
        ));
    }

    /* fungsi ini akan mengakses form untuk kebutuhan add 
     * data, lalu setting array terhadap inputannya
     */

    function add() {
        $data['title'] = 'Add - agama'; //setting judul, yang akan berubah di form.php
        $data['default']['nama_agama'] = ''; // setting input dengan type properties namenya type, defaultnya kosong
        $data['url_post'] = site_url($this->controller . '/addpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi addpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = 0; //pads saat add data, id dibuat menjadi 0
        $this->load->view($this->view . '/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan add data, fungsi ini akan masuk ke database */

    public function addpost() {
        $this->form_validation->set_rules('nama_agama', '', 'required'); //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $agama = $this->input->post('nama_agama'); // menangkap post dari form.php ketika add data, dengan properties namenya adalah type

            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                "nama_agama" => $agama,
            );

            $checkdata = $this->agama->checkdata($agama); // melakukan pengecekan data
            if ($checkdata > 0) { /* jika data bernilai lebih dari 0, maka data tidak tersimpan, karena sudah ada */
                $valid = 'false';
                $message = 'data already exist';
                $err_name = "Name agama sudah ada";
            } else { /* jika data belum ada,maka berhasil di simpan */
                $this->agama->insert($record);
                $valid = 'true';
                $message = "Insert data, success";
                $err_name = null;
            }

            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => $message,
                "hasil" => $valid,
                "err_nama_agama" => $err_name,
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Insert Data Failed',
                "hasil" => 'false',
                "err_nama_agama" => form_error('nama_agama'),
            );
        }

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi edit ini akan mensetting nilai-nilai di form ketika mengklik tombol edit */

    function edit($id) {
        $row = $this->agama->getby_id($id)->row(); /* mendapatkan nilai data berdasarkan id, dan berupa row, yaitu 1 data */
        $data['title'] = 'Edit - agama';
        $data['default']['nama_agama'] = $row->nama_agama; /* setting isi properties type dengan datanya */

        $data['url_post'] = site_url($this->controller.'/editpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi editpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = $id; /* id akan bernilai sesuai data yang di edit */
        $this->load->view($this->view.'/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan edit data, fungsi ini akan masuk ke database */

    function editpost() {
        $this->form_validation->set_rules('nama_agama', 'nama_agama', 'required'); //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id
            $agama = $this->input->post('nama_agama'); // menangkap post dari form.php ketika add data, dengan properties namenya adalah type

            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                "nama_agama" => $agama,
            );

            /* update ke database dengan memanggil model department, ke fungsi edit, dan mengirim parameter sebuah id, dan datanya berupa record */
            $this->agama->update($id, $record);

            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Update Data Success',
                "hasil" => 'true',
                "err_nama_agama" => null,
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Update Data Failed',
                "hasil" => 'false',
                "err_nama_agama" => form_error('nama_agama'),
            );
        }
        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi untuk delete data */

    public function remove() {
        $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id_department
        $this->agama->delete($id); /* mengakses model department, lalu ke fungsi delete dengan parameter sebuah id */

        /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
        $jsonmsg = array(
            "msg" => 'Delete Data Succces',
            "hasil" => true
        );

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

}
