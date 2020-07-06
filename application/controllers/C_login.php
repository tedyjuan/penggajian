<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* class dengan nama Login */

class C_login extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */

    function __construct() {
        parent::__construct();
        /* mulai load Login_model.php di folder model */
        $this->load->model('m_login', 'login'); /* cara pemanggilan Login_model menjadi login */
    }

    /* fungsi index yang di load pertama pada saat controller Login di akses */

    public function index() {

        /* setting array key untuk di home.php agar urlnya dinamis, maka 
         */
        $data = array(
            
            "base" => base_url(),
            "site" => site_url(),
            "url_post" => site_url('c_login/validationlogin'), //membuat variable url_post dengan teknik array key, dengan isinya ke controller login, ke fungsi validationlogin
        );
        $this->load->view('v_login', $data);   /* mengakses file login.php di folder view, dengan mengirim variabel data yang isinya array */
    }

    /* fungsi ini bertujuan pengecekan ketika tombol login di klik */

    function validationlogin() {
        $this->form_validation->set_rules('username', 'Username', 'required'); //pengecekan, jika properties input username kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        $this->form_validation->set_rules('password', 'password', 'required'); //pengecekan, jika properties input password kosong, data tidak akan tersimpan,dan field tersebut harus diisi
        if ($this->form_validation->run() == TRUE) { // jika field yang dibutuhkan telah terisi maka nilai true
            $username = $this->input->post('username'); // menangkap post dari login.php ketika post data, dengan properties namenya adalah username
            $password = $this->input->post('password'); // menangkap post dari login.php ketika post data, dengan properties namenya adalah password
            $rowlogin = $this->login->getuserdata($username, $password);  //masuk ke login model, lalu ke fungsi getuserdata dengan mengirim parameternya
            $checkdata = $this->login->checkuserdata($username, $password); //masuk ke login model, lalu ke fungsi checkuserdata dengan mengirim parameternya      

            if ($checkdata > 0) { // ketika nilainya lebih dari 0, maka user tersebut ada di database

                /* membuuat array untuk kebutuhan session */
                $session = array(
                    'ses_statuslogin' => TRUE,
                    'ses_username' => $username,
                    'ses_name' => $rowlogin->fullname,
                    'ses_email' => $rowlogin->email,
                    'ses_base_url' => base_url()
                );

                /* fungsi membuat session */
                $this->session->set_userdata($session);
                $valid = 'true';
                $redir = site_url();
                $message = 'Login success';
            } else {

                /* membuuat array untuk kebutuhan session */
                $session = array(
                    'ses_statuslogin' => FALSE,
                );
                /* fungsi membuat session */
                $this->session->set_userdata($session);
                $valid = 'false';
                $redir = site_url("c_login");
                $message = "Login Failed, check your username or password";
            }
            $valid = $valid;
            $message = $message;


            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => $message,
                "hasil" => $valid,
                "err_username" => null,
                "err_password" => null,
                "redirecto" => $redir
            );
        } else {
            /* membuat array, yang akan dikonversi menjadi json untuk kebutuhan ajax */
            $jsonmsg = array(
                "msg" => 'Insert Data Failed',
                "hasil" => 'false',
                "err_username" => form_error('username'),
                "err_password" => form_error('password'),
                "redirecto" => site_url("c_login")
            );
        }
        /* konversi array json, yang akan terkirim ke login.php di folder view */
        echo json_encode($jsonmsg);
    }

    /* fungsi logout, dengan mematikan session yang sudah dibuat ketika login berhasil */

    function logout() {
        $this->session->sess_destroy(); //fungsi menghapus session
        redirect('c_login', 'refresh'); //fungsi redirect ke login controller
    }

}
