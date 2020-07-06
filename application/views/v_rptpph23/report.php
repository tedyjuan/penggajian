<html>
    <head>
        <title>Laporan biaya transfer ke Bank</title>
    </head>
    <body>
        Laporan PPH23
        <table width="100%" border="1">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Gapok</th>
                <th>NPWP</th>
                <th>Status PTKP</th>
                <th>Nilai Pajak PPH23</th>
                <th>Keterangan</th>
            </tr>
            <?php
            $i = 0;
            $bulan = array(
                '01' => 'JANUARI',
                '02' => 'FEBRUARI',
                '03' => 'MARET',
                '04' => 'APRIL',
                '05' => 'MEI',
                '06' => 'JUNI',
                '07' => 'JULI',
                '08' => 'AGUSTUS',
                '09' => 'SEPTEMBER',
                '10' => 'OKTOBER',
                '11' => 'NOVEMBER',
                '12' => 'DESEMBER',
            );
            $total_pph23 = 0;
            foreach ($result as $row) {
                // echo '<pre/>';
                // print_r($row);                
                $rowpayrol = $modeldata->mastergaji_by_karyawanid($row['id_karyawan']);
                $rowptkp = $modeldata->ptkp_byid($rowpayrol->id_ptkp);
                $rowkaryawan = $modeldata->masterkaryawan_by_karyawanid($row['id_karyawan']);
                $jml_potonganpph23 = $row['jml_potonganpph23'];

                $gaji_bersih = $row['gaji_bersih'];
                $jml_potongantransfer = $row['jml_potongantransfer'];

                $tgl_posting = $row['tgl_posting'];
                $month = date('m',strtotime("$tgl_posting -1 months"));                           
                $namabulan = $bulan[$month];
                $total_pph23 += $jml_potonganpph23;

                $i++;
                $html = "<tr>";
                $html .= "<td>$i</td>";
                $html .= "<td>$rowkaryawan->nama</td>";
                $html .= "<td>$rowpayrol->gapok</td>";
                $html .= "<td>$rowkaryawan->no_npwp</td>";
                $html .= "<td>$rowptkp->status</td>";
                $html .= "<td>$jml_potonganpph23</td>";
                $html .= "<td>GAJI BULAN $namabulan</td>";
                $html .= "</tr>";
                echo $html;
            }
            ?>
            <tr>
                <td colspan="5">Total PPH23</td>
                <td><?php echo $total_pph23; ?></td>
            </tr>           
        </table>
    </body>
</html>