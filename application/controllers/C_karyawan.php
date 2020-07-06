<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class c_karyawan extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */

    private $controller;
    private $view;
    protected $model;

    function __construct() {
        parent::__construct();
        $this->controller = 'c_karyawan';
        $this->view = 'v_karyawan';
        /* mulai load  di folder model */
        $this->load->model('m_karyawan', 'karyawan'); /* cara pemanggilan Mdepartment_model menjadi department */
        $this->load->model('m_jabatan', 'jabatan');
        $this->load->model('m_agama', 'agama');
        $this->load->model('m_pendidikan', 'pendidikan');
        $this->load->model('m_statusnikah', 'statusnikah');
        $this->load->model('m_bagian', 'bagian');

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
            "title" => 'Data Karyawan',
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
            "data" => $this->karyawan->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
                //"data" => $this->type->getGridData()->result() /* mengakses ke model department, ke fungsi getGridData, lalu hasilnya sebuah array assosiatif */
        ));
    }

    /* fungsi ini akan mengakses form untuk kebutuhan add 
     * data, lalu setting array terhadap inputannya
     */

    function add() {
        $data['title'] = 'Add - karyawan'; //setting judul, yang akan berubah di form.php

        $data['default']['jeniskelamin'][-1]['value'] = NULL;
        $data['default']['jeniskelamin'][-1]['display'] = '- Please Select -';
        $data['default']['jeniskelamin'][0]['value'] = 'L';
        $data['default']['jeniskelamin'][0]['display'] = 'Laki-laki';
        $data['default']['jeniskelamin'][1]['value'] = 'P';
        $data['default']['jeniskelamin'][1]['display'] = 'Perempuan';


        $resultjbtn = $this->jabatan->getAll();
        $i = 0;
        foreach ($resultjbtn as $rowjbt) {
            $data['default']['id_jabatan'][-1]['value'] = NULL;
            $data['default']['id_jabatan'][-1]['display'] = '- Please Select -';
            $data['default']['id_jabatan'][$i]['value'] = $rowjbt['id_jabatan'];
            $data['default']['id_jabatan'][$i]['display'] = $rowjbt['nama_jabatan'];
            $i++;
        }
        $resultsn = $this->statusnikah->getAll();
        $i = 0;
        foreach ($resultsn as $rowsn) {
            $data['default']['id_status'][-1]['value'] = NULL;
            $data['default']['id_status'][-1]['display'] = '- Please Select -';
            $data['default']['id_status'][$i]['value'] = $rowsn['id_status'];
            $data['default']['id_status'][$i]['display'] = $rowsn['nama_status'];
            $i++;
        }
        $resultagama = $this->agama->getAll();
        $i = 0;
        foreach ($resultagama as $rowagama) {
            $data['default']['id_agama'][-1]['value'] = NULL;
            $data['default']['id_agama'][-1]['display'] = '- Please Select -';
            $data['default']['id_agama'][$i]['value'] = $rowagama['id_agama'];
            $data['default']['id_agama'][$i]['display'] = $rowagama['nama_agama'];
            $i++;
        }
        $resultpendidikan = $this->pendidikan->getAll();
        $i = 0;
        foreach ($resultpendidikan as $rowpendidikan) {
            $data['default']['id_pendidikan'][-1]['value'] = NULL;
            $data['default']['id_pendidikan'][-1]['display'] = '- Please Select -';
            $data['default']['id_pendidikan'][$i]['value'] = $rowpendidikan['id_pendidikan'];
            $data['default']['id_pendidikan'][$i]['display'] = $rowpendidikan['nama_pendidikan'];
            $i++;
        }
        $resultbagian = $this->bagian->getAll();
        $i = 0;
        foreach ($resultbagian as $rowbagian) {
            $data['default']['id_bagian'][-1]['value'] = NULL;
            $data['default']['id_bagian'][-1]['display'] = '- Please Select -';
            $data['default']['id_bagian'][$i]['value'] = $rowbagian['id_bagian'];
            $data['default']['id_bagian'][$i]['display'] = $rowbagian['nama_bagian'];
            $i++;
        }

        $data['default']['nik'] = ''; // setting input dengan type properties namenya type, defaultnya kosong
        $data['default']['no_ktp'] = '';
        $data['default']['nama'] = '';
        $data['default']['tempat_lahir'] = '';
        $data['default']['tgl_lahir'] = '';
        $data['default']['alamat'] = '';
        $data['default']['telepon'] = '';

        $data['url_post'] = site_url($this->controller . '/addpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi addpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = 0; //pads saat add data, id dibuat menjadi 0
        $this->load->view($this->view . '/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan add data, fungsi ini akan masuk ke database */

    public function addpost() {
        $this->form_validation->set_rules('nik', 'NIK', 'required'); //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        $this->form_validation->set_rules('id_jabatan', 'JABATAN', 'required');
        $this->form_validation->set_rules('no_ktp', 'KTP', 'required|numeric');
        $this->form_validation->set_rules('nama', 'NAMA', 'required');
        $this->form_validation->set_rules('jeniskelamin', 'jeniskelamin', 'required');
        $this->form_validation->set_rules('id_status', 'statusnikah', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'TEMPAT', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'TANGGAL LAHIR', 'required');
        $this->form_validation->set_rules('id_agama', 'AGAMA', 'required');
        $this->form_validation->set_rules('alamat', 'ALAMAT', 'required');
        $this->form_validation->set_rules('telepon', 'TELPON', 'required|numeric');
        $this->form_validation->set_rules('id_pendidikan', 'PENDIDIKAN', 'required');
        $this->form_validation->set_rules('id_bagian', 'bagian', 'required');
        $this->form_validation->set_rules('nama_institusipendidikan', 'NAMA INSTITUSI PENDIDIKAN', 'required');

        if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $nik = $this->input->post('nik');
            $idjabatan = $this->input->post('id_jabatan');
            $no_ktp = $this->input->post('no_ktp');
            $no_npwp = $this->input->post('no_npwp');
            $nama = $this->input->post('nama');
            $jeniskelamin = $this->input->post('jeniskelamin');
            $statusnikah = $this->input->post('id_status');
            $tempat_lahir = $this->input->post('tempat_lahir');
            $tgl_lahir = $this->input->post('tgl_lahir');
            $idagama = $this->input->post('id_agama');
            $kewarganegaraan = $this->input->post('kewarganegaraan');
            $alamat = $this->input->post('alamat');
            $telepon = $this->input->post('telepon');
            $idpendidikan = $this->input->post('id_pendidikan');
            $idbagian = $this->input->post('id_bagian');
            $nama_institusipendidikan = $this->input->post('nama_institusipendidikan');
            // menangkap post dari form.php ketika add data, dengan properties namenya adalah type

            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                "nik" => $nik,
                "id_jabatan" => $idjabatan,
                "no_ktp" => $no_ktp,
                "no_npwp" => $no_npwp,
                "nama" => $nama,
                "jenis_kelamin" => $jeniskelamin,
                "tempat_lahir" => $tempat_lahir,
                "tgl_lahir" => date('Y-m-d', strtotime($tgl_lahir)),
                "id_agama" => $idagama,
                "alamat" => $alamat,
                "telepon" => $telepon,
                "id_pendidikan" => $idpendidikan,
                "id_status" => $statusnikah,
                "id_bagian" => $idbagian,
                "nama_institusipendidikan" => $nama_institusipendidikan,
            );

            $checkdata = $this->karyawan->checkdata($no_ktp); // melakukan pengecekan data
            if ($checkdata > 0) { /* jika data bernilai lebih dari 0, maka data tidak tersimpan, karena sudah ada */
                $valid = 'false';
                $message = 'data already exist';
                $err_name = "No ktp  sudah ada";
            } else { /* jika data belum ada,maka berhasil di simpan */
                $checkdatanik = $this->karyawan->checkdatanik($nik);
                if($checkdatanik >0){
                    $v = 'false';
                    $m = 'data already exist';
                    $e = " NIK  sudah ada";
                }else{
                    $this->karyawan->insert($record);
                    $v = 'true';
                    $m = 'Insert data sukses';
                    $e = "";
                }                
                $valid = $v;
                $message = $m;
                $err_nik = $e;
                $err_name = '';
            }

            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => $message,
                "hasil" => $valid,
                "err_no_ktp" => $err_name,
                "err_nik" => $err_nik,
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Insert Data Failed',
                "hasil" => 'false',
                "err_nik" => form_error('nik'),
                "err_nama_jabatan" => form_error('id_jabatan'),
                "err_no_ktp" => form_error('no_ktp'),
                "err_nama" => form_error('nama'),
                "err_jeniskelamin" => form_error('jenis_kelamin'),
                "err_tempat_lahir" => form_error('tempat_lahir'),
                "err_tgl_lahir" => form_error('tgl_lahir'),
                "err_id_status" => form_error('id_status'),
                "err_nama_agama" => form_error('id_agama'),
                "err_alamat" => form_error('alamat'),
                "err_telepon" => form_error('telepon'),
                "err_nama_pendidikan" => form_error('id_pendidikan'),
                "err_id_bagian" => form_error('id_bagian'),
                "err_nama_institusipendidikan" => form_error('nama_institusipendidikan'),
            );
        }

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi edit ini akan mensetting nilai-nilai di form ketika mengklik tombol edit */

    function edit($id) {
        $row = $this->karyawan->getby_id($id)->row(); /* mendapatkan nilai data berdasarkan id, dan berupa row, yaitu 1 data */
        $data['title'] = 'Edit - karyawan';

        $data['default']['jeniskelamin'][-1]['value'] = NULL;
        $data['default']['jeniskelamin'][-1]['display'] = '- Please Select -';
        $data['default']['jeniskelamin'][0]['value'] = 'L';
        $data['default']['jeniskelamin'][0]['display'] = 'Laki-laki';
        $data['default']['jeniskelamin'][1]['value'] = 'P';
        $data['default']['jeniskelamin'][1]['display'] = 'Perempuan';

        if ($row->jenis_kelamin == 'L') {
            $data['default']['jeniskelamin'][0]['selected'] = "SELECTED";
        } else if ($row->jenis_kelamin == 'P') {
            $data['default']['jeniskelamin'][1]['selected'] = "SELECTED";
        } else {
            $data['default']['jeniskelamin'][-1]['selected'] = "SELECTED";
        }


        $resultjbtn = $this->jabatan->getAll();
        $i = 0;
        foreach ($resultjbtn as $rowjbt) {
            $data['default']['id_jabatan'][-1]['value'] = NULL;
            $data['default']['id_jabatan'][-1]['display'] = '- Please Select -';
            $data['default']['id_jabatan'][$i]['value'] = $rowjbt['id_jabatan'];
            $data['default']['id_jabatan'][$i]['display'] = $rowjbt['nama_jabatan'];
            if ($row->id_jabatan == $rowjbt['id_jabatan']) {
                $data['default']['id_jabatan'][$i]['selected'] = "SELECTED";
            }
            $i++;
        }
        $resultsn = $this->statusnikah->getAll();
        $i = 0;
        foreach ($resultsn as $rowsn) {
            $data['default']['id_status'][-1]['value'] = NULL;
            $data['default']['id_status'][-1]['display'] = '- Please Select -';
            $data['default']['id_status'][$i]['value'] = $rowsn['id_status'];
            $data['default']['id_status'][$i]['display'] = $rowsn['nama_status'];
            if ($row->id_status == $rowsn['id_status']) {
                $data['default']['id_status'][$i]['selected'] = "SELECTED";
            }
            $i++;
        }
        $resultagama = $this->agama->getAll();
        $i = 0;
        foreach ($resultagama as $rowagama) {
            $data['default']['id_agama'][-1]['value'] = NULL;
            $data['default']['id_agama'][-1]['display'] = '- Please Select -';
            $data['default']['id_agama'][$i]['value'] = $rowagama['id_agama'];
            $data['default']['id_agama'][$i]['display'] = $rowagama['nama_agama'];
            if ($row->id_agama == $rowagama['id_agama']) {
                $data['default']['id_agama'][$i]['selected'] = "SELECTED";
            }
            $i++;
        }
        $resultpendidikan = $this->pendidikan->getAll();
        $i = 0;
        foreach ($resultpendidikan as $rowpendidikan) {
            $data['default']['id_pendidikan'][-1]['value'] = NULL;
            $data['default']['id_pendidikan'][-1]['display'] = '- Please Select -';
            $data['default']['id_pendidikan'][$i]['value'] = $rowpendidikan['id_pendidikan'];
            $data['default']['id_pendidikan'][$i]['display'] = $rowpendidikan['nama_pendidikan'];
            if ($row->id_pendidikan == $rowpendidikan['id_pendidikan']) {
                $data['default']['id_pendidikan'][$i]['selected'] = "SELECTED";
            }
            $i++;
        }
        $resultbagian = $this->bagian->getAll();
        $i = 0;
        foreach ($resultbagian as $rowbagian) {
            $data['default']['id_bagian'][-1]['value'] = NULL;
            $data['default']['id_bagian'][-1]['display'] = '- Please Select -';
            $data['default']['id_bagian'][$i]['value'] = $rowbagian['id_bagian'];
            $data['default']['id_bagian'][$i]['display'] = $rowbagian['nama_bagian'];
            if ($row->id_bagian == $rowbagian['id_bagian']) {
                $data['default']['id_bagian'][$i]['selected'] = "SELECTED";
            }
            $i++;
        }

        $data['default']['nik'] = $row->nik; /* setting isi properties type dengan datanya */

        $data['default']['no_ktp'] = $row->no_ktp;
        $data['default']['no_npwp'] = $row->no_npwp;
        $data['default']['nama'] = $row->nama;
        $data['default']['tempat_lahir'] = $row->tempat_lahir;
        $data['default']['tgl_lahir'] = date('d-m-Y', strtotime($row->tgl_lahir));

        $data['default']['alamat'] = $row->alamat;
        $data['default']['telepon'] = $row->telepon;

        $data['default']['nama_institusipendidikan'] = $row->nama_institusipendidikan;


        $data['url_post'] = site_url($this->controller . '/editpost'); //membuat url_post dengan parameter ke controllernya lalu ke fungsi editpost,dalam fungsi addpost akan menyisiplkan ke database
        $data['url_index'] = site_url($this->controller); //membuat url_index dengan parameter balik lagi ke controllernya, otomatis akan masuk ke fungsi index
        $data['id'] = $id; /* id akan bernilai sesuai data yang di edit */
        $this->load->view($this->view . '/form', $data); /* mengakses folder c_type, lalu ke file form.php, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi untuk post data ketika melakukan edit data, fungsi ini akan masuk ke database */

    function editpost() {
        $this->form_validation->set_rules('nik', 'NIK', 'required'); //pengecekan, jika properties input type kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        $this->form_validation->set_rules('id_jabatan', 'JABATAN', 'required');
        $this->form_validation->set_rules('no_ktp', 'KTP', 'required|numeric');
        $this->form_validation->set_rules('nama', 'NAMA', 'required');
        $this->form_validation->set_rules('jeniskelamin', 'jeniskelamin', 'required');
        $this->form_validation->set_rules('id_status', 'statusnikah', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'TEMPAT', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'TANGGAL LAHIR', 'required');
        $this->form_validation->set_rules('id_agama', 'AGAMA', 'required');
        $this->form_validation->set_rules('alamat', 'ALAMAT', 'required');
        $this->form_validation->set_rules('telepon', 'TELPON', 'required|numeric');
        $this->form_validation->set_rules('id_pendidikan', 'PENDIDIKAN', 'required');
        $this->form_validation->set_rules('id_bagian', 'bagian', 'required');
        $this->form_validation->set_rules('nama_institusipendidikan', 'NAMA INSTITUSI PENDIDIKAN', 'required');

        if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id
            // menangkap post dari form.php ketika add data, dengan properties namenya adalah type
            $nik = $this->input->post('nik');
            $idjabatan = $this->input->post('id_jabatan');
            $no_ktp = $this->input->post('no_ktp');
            $nama = $this->input->post('nama');
            $jeniskelamin = $this->input->post('jeniskelamin');
            $statusnikah = $this->input->post('id_status');
            $tempat_lahir = $this->input->post('tempat_lahir');
            $tgl_lahir = $this->input->post('tgl_lahir');
            $idagama = $this->input->post('id_agama');
            $kewarganegaraan = $this->input->post('kewarganegaraan');
            $alamat = $this->input->post('alamat');
            $telepon = $this->input->post('telepon');
            $idpendidikan = $this->input->post('id_pendidikan');
            $idbagian = $this->input->post('id_bagian');
            $nama_institusipendidikan = $this->input->post('nama_institusipendidikan');
            $no_npwp = $this->input->post('no_npwp');
            /* membuat record sebuah array, array ini akan masuk ke database */
            $record = array(
                "nik" => $nik,
                "id_jabatan" => $idjabatan,
                "no_ktp" => $no_ktp,
                "no_npwp" => $no_npwp,
                "nama" => $nama,
                "jenis_kelamin" => $jeniskelamin,
                "id_status" => $statusnikah,
                "tempat_lahir" => $tempat_lahir,
                "tgl_lahir" => date('Y-m-d', strtotime($tgl_lahir)),
                "id_agama" => $idagama,
                "alamat" => $alamat,
                "telepon" => $telepon,
                "id_pendidikan" => $idpendidikan,
                "id_bagian" => $idbagian,
                "nama_institusipendidikan" => $nama_institusipendidikan,
            );

            /* update ke database dengan memanggil model department, ke fungsi edit, dan mengirim parameter sebuah id, dan datanya berupa record */
            $this->karyawan->update($id, $record);

            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Update Data Success',
                "hasil" => 'true',
                "err_no_ktp" => null,
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Update Data Failed',
                "hasil" => 'false',
                "err_nik" => form_error('nik'),
                "err_nama_jabatan" => form_error('id_jabatan'),
                "err_no_ktp" => form_error('no_ktp'),
                "err_nama" => form_error('nama'),
                "err_jeniskelamin" => form_error('jenis_kelamin'),
                "err_id_status" => form_error('id_status'),
                "err_tempat_lahir" => form_error('tempat_lahir'),
                "err_id_status" => form_error('id_status'),
                "err_nama_agama" => form_error('id_agama'),
                "err_alamat" => form_error('alamat'),
                "err_telepon" => form_error('telepon'),
                "err_nama_pendidikan" => form_error('id_pendidikan'),
                "err_nama_institusipendidikan" => form_error('nama_institusipendidikan'),
            );
        }
        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

    /* fungsi untuk delete data */

    public function remove() {
        $id = $this->input->post('id'); // menangkap post dari form.php ketika edit data, dengan properties namenya adalah id_department
        $this->karyawan->delete($id); /* mengakses model department, lalu ke fungsi delete dengan parameter sebuah id */

        /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
        $jsonmsg = array(
            "msg" => 'Delete Data Succces',
            "hasil" => true
        );

        /* konversi array json, yang akan terkirim ke form.php */
        echo json_encode($jsonmsg);
    }

}
