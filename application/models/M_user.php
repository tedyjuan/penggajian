<?php

/* membuat class dengan nama M_uom_model */

class M_user extends CI_Model {
    /* membuat encapsulasi untuk properties %table */

    private $table;
    private $role;
    private $prefix_id;

    public function __construct() {
        parent::__construct();
        $this->table = "userlogin"; //setting di dalam $this->table dalah nama tabel sesuai di databasenya
        $this->role = "m_role"; //setting di dalam $this->table dalah nama tabel sesuai di databasenya
        $this->prefix_id = "username"; //setting di dalam $this->prefix_id adalah primary key di tabel
    }

    /* mendapatkan semua data dan hasilnya sebuah array */

    public function getAll() {
        $this->db->order_by('username', 'asc');
        return $this->db->get($this->table)->result_array();
    }

    function checkData($param) {
        $this->db->where("username", $param);
        $result = $this->db->get($this->table)->num_rows();
        return $result;
    }

    function getGridData() {
        $query = "
                 SELECT a.*,b.role                        
                 FROM $this->table a   
                 LEFT JOIN $this->role b on a.role_id = b.role_id 
                 ";
        return $this->db->query($query);
    }
    function getdata_byusername($username) {
        $query = "
                 SELECT a.*,b.role                        
                 FROM $this->table a   
                 LEFT JOIN $this->role b on a.role_id = b.role_id 
                 WHERE 
                 a.username='$username'
                 ";
        return $this->db->query($query);
    }

    function insert($record) {
        $this->db->insert($this->table, $record);
    }

    function getalldata() {
        return $this->db->get($this->table);
    }

    function getby_id($id) {
        $this->db->where($this->prefix_id, $id);
        return $this->db->get($this->table);
    }

    function update($id, $record) {
        $this->db->where($this->prefix_id, $id);
        $this->db->update($this->table, $record);
    }

    function delete($id) {
        $this->db->delete($this->table, array($this->prefix_id => $id));
    }

}
