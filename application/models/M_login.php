<?php

/* membuat class dengan nama Login_model*/
class M_login extends CI_Model {

    /* membuat encapsulasi untuk properties %table */
    private $table;

    public function __construct() {
        parent::__construct();
        $this->table = "userlogin"; //setting di dalam $this->table dalah nama tabel sesuai di databasenya
    }

    /* mendapatkan semua data */
    public function getalldata() {
        return $this->db->get($this->table);
    }

     /* mendapatkan data dengan pengecekan berupa password */
    function checkuserdata($userlogin, $password) {
        $this->db->where("password", md5($userlogin . $password)); /* kondisi pengecekan dengan field password dan nilai parameternya */
        return $this->db->get($this->table)->num_rows(); //* nilai sebuah number
    }
    
    
     /* mendapatkan data dengan kondisi mengecek username dan passwordnya*/
    function getuserdata($userlogin, $password) {
        $this->db->where('username', $userlogin); /* kondisi pengecekan dengan field username dan nilai parameternya */
        $this->db->where('password', md5($userlogin . $password)); /* kondisi pengecekan dengan field password dan nilai parameternya */
        $this->db->limit(1); /* data di limit menjadi 1 */
        $query = $this->db->get($this->table); /* mendapatkan data di tabel */
        
        if ($query->num_rows() == 1) { /* pengecekan data jika nilainya ada maka kirimkan sebuah data 1 row */
            return $query->row();
        } else {
            return NULL;
        }
    }

}
