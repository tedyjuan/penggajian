<?php

/* membuat class dengan nama M_uom_model */

class M_karyawan extends CI_Model {
    /* membuat encapsulasi untuk properties %table */

    private $table;
	private $table_jabatan;
	private $table_statusnikah;
	private $table_bagian;
	private $table_pendidikan;
	private $table_agama;
    private $prefix_id;

    public function __construct() {
        parent::__construct();
        $this->table = "m_karyawan"; //setting di dalam $this->table dalah nama tabel sesuai di databasenya
        $this->prefix_id = "id_karyawan"; //setting di dalam $this->prefix_id adalah primary key di tabel
		$this->table_jabatan = "m_jabatan"; 
		$this->table_statusnikah = "m_statusnikah"; 
		$this->table_bagian = "m_bagian"; 
		$this->table_agama = "m_agama"; 
		$this->table_pendidikan = "m_pendidikan"; 
    }

    /* mendapatkan semua data dan hasilnya sebuah array */

    public function getAll() {
        $this->db->order_by('nama','asc');
        return $this->db->get($this->table)->result_array();
    }

    function checkData($param) {
        $this->db->where("no_ktp", $param);
        $result = $this->db->get($this->table)->num_rows();
        return $result;
    }
    function checkdatanik($param) {
        $this->db->where("nik", $param);
        $result = $this->db->get($this->table)->num_rows();
        return $result;
    }

    function getGridData() {
        $query = "
                 SELECT 
				 a.*,
				 b.nama_jabatan,
				 c.nama_agama,
				 d.nama_pendidikan,
				 e.nama_status,
				 f.nama_bagian
                 FROM $this->table a 
				 LEFT JOIN $this->table_jabatan b ON a.id_jabatan = b.id_jabatan
				 LEFT JOIN $this->table_agama c ON a.id_agama = c.id_agama
				 LEFT JOIN $this->table_pendidikan d ON a.id_pendidikan = d.id_pendidikan
				 LEFT JOIN $this->table_statusnikah e ON a.id_status = e.id_status
				 LEFT JOIN $this->table_bagian f ON a.id_bagian = f.id_bagian
				 
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
	function getdata_bynik($nik) {
        $this->db->where('nik', $nik);
        return $this->returndata($this->db->get($this->table));
    }

    function update($id, $record) {
        $this->db->where($this->prefix_id, $id);
        $this->db->update($this->table, $record);
    }

    function delete($id) {
        $this->db->delete($this->table, array($this->prefix_id => $id));
    }
    
    public function returndata($result){
        if($result->num_rows()>0){
            return $result;
        }else{
            return null;
        }
    }

}
