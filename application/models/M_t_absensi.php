<?php

/* membuat class dengan nama M_uom_model */

class M_t_absensi extends CI_Model {
    /* membuat encapsulasi untuk properties %table */

    private $table;
	private $table_karyawan;

	private $prefix_id;

    public function __construct() {
        parent::__construct();
        $this->table = "t_absensi"; //setting di dalam $this->table dalah nama tabel sesuai di databasenya
        $this->prefix_id = "id_absensi"; //setting di dalam $this->prefix_id adalah primary key di tabel
		 $this->table_karyawan="m_karyawan";
		 
		 
    }

    /* mendapatkan semua data dan hasilnya sebuah array */

    public function getAll() {
        $this->db->order_by('id_karyawan','asc');
        return $this->db->get($this->table)->result_array();
    }

    function checkData($param,$param2) {
        $this->db->where("id_karyawan", $param);
		$this->db->where("tgl_absensi", date('Y-m-d',strtotime($param2)));
        $result = $this->db->get($this->table)->num_rows();
        return $result;
    }

    function getGridData() {
        $query = "
                 SELECT 
				 a.*,   
				 b.nama
			
                 FROM $this->table a   
				 LEFT JOIN $this->table_karyawan b ON a.id_karyawan = b.id_karyawan	
				 
				
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

    function checkimportdata($id_karyawan,$tanggal) {
        $this->db->where('id_karyawan', $id_karyawan);
		 $this->db->where('tgl_absensi', $tanggal);
        return $this->db->get($this->table)->num_rows();
    }

    function update($id, $record) {
        $this->db->where($this->prefix_id, $id);
        $this->db->update($this->table, $record);
    }

    function delete($id) {
        $this->db->delete($this->table, array($this->prefix_id => $id));
    }

}
