<?php

/* membuat class dengan nama M_uom_model */

class M_penggajian extends CI_Model {
    /* membuat encapsulasi untuk properties %table */

    private $table;
	private $table_karyawan;
	private $table_bank;
    private $prefix_id;

    public function __construct() {
        parent::__construct();
        $this->table = "m_penggajian"; //setting di dalam $this->table dalah nama tabel sesuai di databasenya
        $this->table_karyawan = "m_karyawan"; 
		$this->table_bank = "m_bank"; 
		$this->prefix_id = "id_penggajian"; //setting di dalam $this->prefix_id adalah primary key di tabel
    }

    /* mendapatkan semua data dan hasilnya sebuah array */

    public function getAll() {
        $this->db->order_by('no_rekening','asc');
        return $this->db->get($this->table)->result_array();
    }

    function checkData($param) {
        $this->db->where("id_karyawan", $param);
        $result = $this->db->get($this->table)->num_rows();
        return $result;
    }

    function getGridData() {
        $query = "
                 SELECT 
				 a.*,
				 b.nama,
				 c.nama_bank,
                 d.status				
                 FROM $this->table a 
				 LEFT JOIN $this->table_karyawan b ON a.id_karyawan = b.id_karyawan	
				 LEFT JOIN $this->table_bank c ON a.id_bank = c.id_bank	
                 LEFT JOIN m_ptkp d on a.id_ptkp = d.id_ptkp
				
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
