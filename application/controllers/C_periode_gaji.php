<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class c_periode_gaji extends CI_Controller {
    /* fungsi construct ini akan di load terlebih dahulu, sebelum fungsi index
     * umumnya di dalam fungsi ini berupa settingan awal
     */

    private $controller;
    private $view;
    protected $model;

    function __construct() {
        parent::__construct();
        $this->controller = 'c_periode_gaji';
        $this->view = 'v_periode_gaji';
        /* mulai load  di folder model */
        $this->load->model('m_periode_gaji', 'periode_gaji'); /* cara pemanggilan Mdepartment_model menjadi department */
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
            "title" => 'Laporan periode gaji',
            "base" => base_url(),
            "url_index" => site_url($this->controller),
            "url_post" => site_url($this->controller . '/postingdata'),
        );
        $daritanggal = date('m/01/Y', strtotime('-1 months'));
        $sampaitanggal = date('m/t/Y', strtotime('-1 months'));


        $data['default']['tanggalposting'] = date('m/01/Y');
        $data['default']['daritanggal'] = $daritanggal;
        $data['default']['sampaitanggal'] = $sampaitanggal;
        $this->load->view($this->view . '/form', $data); /* mengakses folder c_type, lalu ke file home.php, dengan mengirim variabel data yang isinya array */
    }

    public function postingdata() {
        $param = $this->input->post();
        $daritanggal = date('Y-m-d', strtotime($param['daritanggal']));
        $sampaitanggal = date('Y-m-d', strtotime($param['sampaitanggal']));
        $tanggalposting = date('Y-m-d', strtotime($param['tanggalposting']));
        $this->prosesgajiharian($daritanggal, $sampaitanggal, $tanggalposting);
        $this->prosespotonganabsensi($daritanggal, $sampaitanggal, $tanggalposting);
        $this->prosespotongan($tanggalposting);
        $this->prosestambahan($tanggalposting);
        $this->prosesinsentif($daritanggal, $sampaitanggal, $tanggalposting);
        $this->prosesasuransi($tanggalposting);
        $this->proseslembur($daritanggal, $sampaitanggal, $tanggalposting);
        $this->proses_potonganbiayapph23($tanggalposting);
        $this->proses_potonganbiayatransfer($tanggalposting);
        $this->kalkulasi($tanggalposting);
        echo json_encode(array("valid" => true));
    }
    
    public function kalkulasi($tanggalposting) {
        $result = $this->periode_gaji->getpayroll_byposting($tanggalposting);
        if ($result) {
            foreach ($result->result_array() as $row) {
                $rowpayrol = $this->periode_gaji->mastergaji_by_karyawanid($row['id_karyawan']);
                $gajibersih = ($rowpayrol->gapok + $row['jml_tambahan'] + $row['jml_uangmakan'] + $row['jml_uangtransport'] + $row['jml_uanglembur']) - ($row['jml_potongantransfer'] + $row['jml_potonganabsensi'] + $row['jml_potongan'] + $row['asuransi']+$row['jml_potonganpph23']);
                $record = array(
                    'id_karyawan' => $row['id_karyawan'],
                    'tgl_posting' => $tanggalposting,
                    'gaji_bersih' => $gajibersih,
                );
                $this->periode_gaji->createdata($record);
            }
        }
    }

    public function proses_potonganbiayapph23($postingdate) {
        $result = $this->periode_gaji->getpayroll_byposting($postingdate);
        if ($result) {
            $last_employee = 0;
            $totallembur = 0;
            foreach ($result->result_array() as $row) {
                $rowpayrol = $this->periode_gaji->mastergaji_by_karyawanid($row['id_karyawan']);
                $rowptkp = $this->periode_gaji->ptkp_byid($rowpayrol->id_ptkp);
                $rowkaryawan = $this->periode_gaji->masterkaryawan_by_karyawanid($row['id_karyawan']);
                $rowprosesgaji = $this->periode_gaji->getpayroll_byposting($postingdate)->row();

                $gapok = $rowpayrol->gapok;
                if ($gapok > 4500000) {
                    $persentase = ($rowkaryawan->no_npwp == 0) ? 0.06 : 0.05;
                    //$pph23 = $rowptkp->nominal_bulanan * $persentase;
                    $totallembur = $rowprosesgaji->jml_uanglembur;
                    $gaji1tahun = ($gapok * 12)+$totallembur;
                    $ptkptahunan = $rowptkp->nominal_tahunan;
                    $pkp = $gaji1tahun - $ptkptahunan;
                    $pph23 = $pkp * $persentase;
                } else {
                    $pph23 = 0;
                }


                $record = array(
                    'id_karyawan' => $row['id_karyawan'],
                    'tgl_posting' => $postingdate,
                    'jml_potonganpph23' => $pph23/12,
                );
                $this->periode_gaji->createdata($record);
            }
        }
    }

    public function proses_potonganbiayatransfer($postingdate) {
        $result = $this->periode_gaji->getpayroll_byposting($postingdate);
        if ($result) {
            $last_employee = 0;
            $totallembur = 0;
            foreach ($result->result_array() as $row) {
                $rowpayrol = $this->periode_gaji->mastergaji_by_karyawanid($row['id_karyawan']);
                $record = array(
                    'id_karyawan' => $row['id_karyawan'],
                    'tgl_posting' => $postingdate,
                    'jml_potongantransfer' => $rowpayrol->biaya_transfer,
                );
                $this->periode_gaji->createdata($record);
            }
        }
    }

    

    public function proseslembur($daritanggal, $sampaitanggal, $postingdate) {
        $result = $this->periode_gaji->getalllembur($daritanggal, $sampaitanggal);
        if ($result) {
            $last_employee = 0;
            $totallembur = 0;
            $no=0;
            foreach ($result->result_array() as $row) {

                $rowpayrol = $this->periode_gaji->mastergaji_by_karyawanid($row['id_karyawan']);
                $lemburperjam = $rowpayrol->gapok/$rowpayrol->parameterlembur;

                $totaljamlembur = abs(((strtotime($row['selesai_lembur']) - strtotime($row['mulai_lembur'])) / 3600));
                $dayofweek = date('w', strtotime(date('Y-m-d', strtotime($row['mulai_lembur']))));
               // echo strtotime($row['mulai_lembur']);
                //echo date('Y-m-d', strtotime($row['mulai_lembur'])).'<br/>';
                if ($dayofweek == 0) {
                    //echo 'minggu';
                    $totaljamlembur = $totaljamlembur * 2;
                }

                $totallembur += $lemburperjam * $totaljamlembur;
                //$totallembur += $totaljamlembur;
                
                
                   $record = array(
                        'id_karyawan' => $row['id_karyawan'],
                        'tgl_posting' => $postingdate,
                        'jml_uanglembur' => $totallembur,
                    );
                    
                   
                    $this->periode_gaji->createdata($record);
                
               
               
                if ($row['id_karyawan'] !== $last_employee && $no >0) { 
                    $totallembur = 0;
                }
                $no++;
                $last_employee = $row['id_karyawan'];
            }
        }
    }

    public function prosesasuransi($tanggalposting) {
        $resultkaryawan = $this->periode_gaji->getAllAsuransi();
        if ($resultkaryawan) {
            foreach ($resultkaryawan->result_array() as $row) {
                $row['tgl_posting'] = $tanggalposting;
                $this->periode_gaji->createdata($row);
            }
        }
    }

    public function prosesinsentif($daritanggal, $sampaitanggal, $tanggalposting) {
        $resultkaryawan = $this->periode_gaji->getAllInsentif($daritanggal, $sampaitanggal);
        if ($resultkaryawan) {
            foreach ($resultkaryawan->result_array() as $row) {
                $row['tgl_posting'] = $tanggalposting;
                $this->periode_gaji->createdata($row);
            }
        }
    }

    public function prosestambahan($tanggalposting) {
        $resultkaryawan = $this->periode_gaji->getAllTambahan($tanggalposting);
        if ($resultkaryawan) {
            foreach ($resultkaryawan->result_array() as $row) {
                $row['tgl_posting'] = $tanggalposting;
                $this->periode_gaji->createdata($row);
            }
        }
    }

    public function prosespotongan($tanggalposting) {
        $resultkaryawan = $this->periode_gaji->getAllPotongan($tanggalposting);
        if ($resultkaryawan) {
            foreach ($resultkaryawan->result_array() as $row) {
                $row['tgl_posting'] = $tanggalposting;
                $this->periode_gaji->createdata($row);
            }
        }
    }

    public function prosesgajiharian($daritanggal, $sampaitanggal, $tanggalposting) {
        $resultkaryawan = $this->periode_gaji->getAllAbsensi($daritanggal, $sampaitanggal);
        if ($resultkaryawan) {

            foreach ($resultkaryawan->result_array() as $row) {
                $record = array(
                    "id_karyawan" => $row['id_karyawan'],
                    "jml_gajiharian" => $row['totalgajiharian'],
                    "tgl_posting" => $tanggalposting,
                );
                $this->periode_gaji->createdata($record);
            }
        }
    }

    public function prosespotonganabsensi($daritanggal, $sampaitanggal, $tanggalposting) {
        $resultkaryawan = $this->periode_gaji->getAllPotonganAbsensi($daritanggal, $sampaitanggal);
        if ($resultkaryawan) {

            foreach ($resultkaryawan->result_array() as $row) {
                $record = array(
                    "id_karyawan" => $row['id_karyawan'],
                    "jml_potonganabsensi" => $row['totalpotonganabsensi'],
                    "tgl_posting" => $tanggalposting,
                );
                $this->periode_gaji->createdata($record);
            }
        }
    }

}
