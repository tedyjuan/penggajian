<?php

/* membuat class dengan nama M_uom_model */

class M_periode_gaji extends CI_Model {
    /* membuat encapsulasi untuk properties %table */

    private $table;
    private $tableabsensi;
    private $prefix_id;

    public function __construct() {
        parent::__construct();
        $this->table = "m_prosesgaji"; //setting di dalam $this->table dalah nama tabel sesuai di databasenya
        $this->prefix_id = "id_posting"; //setting di dalam $this->prefix_id adalah primary key di tabel
        $this->tableabsensi = 't_absensi';
        $this->m_payroll = 'm_penggajian';
    }


     function getGridSlipData() {
        $query = "
                 SELECT a.*,b.nik,b.nama                        
                 FROM $this->table a  
                 INNER JOIN m_karyawan b on a.id_karyawan=b.id_karyawan 
                 ";
        return $this->db->query($query);
    }

     function getSlipData($tgl_posting) {
        $query = "
                 SELECT a.*,b.nik,b.nama                        
                 FROM $this->table a  
                 INNER JOIN m_karyawan b on a.id_karyawan=b.id_karyawan 
                 WHERE 
                    a.tgl_posting='$tgl_posting'
                 ";
        return $this->db->query($query);
    }

    /* mendapatkan semua data dan hasilnya sebuah array */

    public function tanggalposting() {
        $this->db->order_by('tgl_posting', 'desc');
        $this->db->limit(1);
        return $this->db->get($this->table)->row();
    }
    public function getAll() {
        $this->db->order_by('tgl_posting', 'asc');
        return $this->db->get($this->table)->result_array();
    }
	
	public function getpayroll_byposting($postingdate) {
        $this->db->where("tgl_posting", $postingdate);
        return $this->db->get('m_prosesgaji');
    }
	public function getpersonal_payroll($id_karyawan) {
        $this->db->where("id_karyawan", $id_karyawan);
        return $this->db->get($this->m_payroll)->row();
    }
	
    public function getalllembur($dari,$sampai) {
        $this->db->where('tanggal_kehadiran >=', $dari);
        $this->db->where('tanggal_kehadiran <=', $sampai);
        return $this->db->get('t_lembur');
    }

    public function mastergaji_by_karyawanid($id_karyawan) {
        $this->db->where("id_karyawan", $id_karyawan);
        return $this->db->get('m_penggajian')->row();
    }
    public function ptkp_byid($id) {
        $this->db->where("id_ptkp", $id);
        return $this->db->get('m_ptkp')->row();
    }
    public function masterkaryawan_by_karyawanid($id_karyawan) {
        $this->db->where("id_karyawan", $id_karyawan);
        return $this->db->get('m_karyawan')->row();
    }
	
	public function getAllAsuransi() {
        $sql = "
				SELECT 
					a.id_karyawan,
					a.gapok * (a.parameter_bpjs_ketenagakerjaan+a.parameter_bpjs_kesehatan)/100 AS asuransi					
					FROM m_penggajian a
					
					
					";

		//echo $sql;
		//exit;
        return $this->db->query($sql);
    }
	
	public function getAllInsentif($dari, $sampai) {
        $sql = "
				SELECT 
					a.id_karyawan,
					count(a.status_kehadiran) * b.uang_transport as jml_uangtransport,
					count(a.status_kehadiran)*  b.uang_makan as jml_uangmakan
					FROM t_absensi a
					LEFT JOIN m_penggajian b on a.id_karyawan = b.id_karyawan
					WHERE
					a.tgl_absensi >='$dari' AND a.tgl_absensi <='$sampai'
					AND a.status_kehadiran='H'
					GROUP BY a.id_karyawan
					";

		//echo $sql;
		//exit;
        return $this->db->query($sql);
    }


    public function getAllAbsensi($dari, $sampai) {
        $sql = "
				SELECT 
					a.id_karyawan,sum(b.gaji_harian) as totalgajiharian 
					FROM t_absensi a
					LEFT JOIN m_penggajian b on a.id_karyawan = b.id_karyawan
					WHERE
					a.tgl_absensi >='$dari' AND a.tgl_absensi <='$sampai'
					AND a.status_kehadiran='H'
					GROUP BY a.id_karyawan
					";


        return $this->db->query($sql);
    }
    public function getAllPotonganAbsensi($dari, $sampai) {
        $sql = "
				SELECT 
					a.id_karyawan,sum(b.gaji_harian) as totalpotonganabsensi 
					FROM t_absensi a
					LEFT JOIN m_penggajian b on a.id_karyawan = b.id_karyawan
					WHERE
					a.tgl_absensi >='$dari' AND a.tgl_absensi <='$sampai'
					AND a.status_kehadiran='TH'
					GROUP BY a.id_karyawan
					";


        return $this->db->query($sql);
    }

    public function getAllPotongan($postingdate) {
        $sql = "
				SELECT 
					a.id_karyawan,sum(a.nilai) as jml_potongan 
					FROM t_pengurang a
					WHERE
					a.periode_gaji ='$postingdate'
					GROUP BY a.id_karyawan
					";
        //echo $sql;
        //exit;


        return $this->db->query($sql);
    }
    public function getAllTambahan($postingdate) {
        $sql = "
				SELECT 
					a.id_karyawan,sum(a.nilai) as jml_tambahan
					FROM t_penambah a
					WHERE
					a.periode_gaji ='$postingdate'
					GROUP BY a.id_karyawan
					";


        return $this->db->query($sql);
    }

    public function createdata($param) {
        $table = 'm_prosesgaji';
        $this->db->where("id_karyawan", $param['id_karyawan']);
        $this->db->where("tgl_posting", $param['tgl_posting']);
        $check = $this->db->get($table)->num_rows();
        if ($check == 0) {
            //print_r($param);
            //exit;
            $this->db->insert($table, $param);
        } else {
            $this->db->where("id_karyawan", $param['id_karyawan']);
            $this->db->where("tgl_posting", $param['tgl_posting']);
            unset($param['id_karyawan']);
            unset($param['tgl_posting']);
            $this->db->update($table, $param);
        }
    }

    function checkData($param) {
        $this->db->where("tgl_posting", $param);
        $result = $this->db->get($this->table)->num_rows();
        return $result;
    }

    function getGridData() {
        $query = "
                 SELECT a.*                        
                 FROM $this->table a   
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
