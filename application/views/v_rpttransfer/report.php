<html>
    <head>
        <title>Laporan biaya transfer ke Bank</title>
    </head>
    <body>
        Laporan Biaya Tranfer Bank
        <table width="100%" border="1">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No Rekening</th>
                <th>Nominal</th>
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
            $total_gaji = 0;
            $total_transfer = 0;
            foreach ($result as $row) {
                // echo '<pre/>';
                // print_r($row);                
                $rowpayrol = $modeldata->mastergaji_by_karyawanid($row['id_karyawan']);
                $rowkaryawan = $modeldata->masterkaryawan_by_karyawanid($row['id_karyawan']);
                $gaji_bersih = $row['gaji_bersih'];
                $jml_potongantransfer = $row['jml_potongantransfer'];

                $tgl_posting = $row['tgl_posting'];
                $month = date('m',strtotime("$tgl_posting -1 months"));                           
                $namabulan = $bulan[$month];
                
                $total_gaji += $gaji_bersih;
                $total_transfer += $jml_potongantransfer;

                $i++;
                $html = "<tr>";
                $html .= "<td>$i</td>";
                $html .= "<td>$rowkaryawan->nama</td>";
                $html .= "<td>$rowpayrol->no_rekening</td>";
                $html .= "<td>$gaji_bersih</td>";
                $html .= "<td>GAJI BULAN $namabulan</td>";
                $html .= "</tr>";
                echo $html;
            }
            ?>
            <tr>
                <td colspan="4">Sub Total</td>
                <td><?php echo number_format($total_gaji); ?></td>
            </tr>
            <tr>
                <td colspan="4">Total biaya jasa transfer @ <?php echo $jml_potongantransfer . ' x ' . $i . ' Orang' ?></td>
                <td><?php echo $total_transfer; ?></td>
            </tr>
            <tr>
                <td colspan="4">Grand Total</td>
                <td><?php echo number_format($total_gaji + $total_transfer); ?></td>
            </tr>
        </table>
    </body>
</html>