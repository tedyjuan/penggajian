<html>
    <head>
        <title>slip gaji</title>
    </head>
    <body">
        <table width="100%" border="0" cellpadding="4" cellspacing="2" style="border-collapse:collapse;">
            <tr>
                <td><strong>SLIP GAJI</strong></td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" style="border-collapse:collapse;">
                         <tr>
                            <td width="12%">PT</td>
                            <td width="2%">:</td>
                            <td width="37%">Usaha Saudara Mandiri</td>
                        </tr>
                        <tr>
                            <td width="12%">Periode</td>
                            <td width="2%">:</td>
                            <td width="37%"><?php echo date('d-m-Y', strtotime($tgl_posting)); 
                            
                            $month = date('F',strtotime("$tgl_posting -1 months"));
                            $year = date('Y',strtotime("$tgl_posting -1 months"));
                            echo ' - Penggajian Bulan '.$month.' '.$year;
                            
                            ?></td>
                        </tr>
                        <tr>
                            <td width="12%">Pegawai</td>
                            <td width="2%">:</td>
                            <td width="37%"><?php echo $nik; ?> - <?php echo $nama; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td width="35%" align="left" valign="top">&nbsp;
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                    <tr>
                                        <td width="35%" align="left"><strong>Pendapatan</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">Upah Pokok</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($gapok); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">Uang Makan & Transport</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($jml_uangmakan + $jml_uangtransport); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">Lembur</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($jml_uanglembur); ?></td>
                                    </tr>                           
                                    <tr>
                                        
                                        <td width="40%" align="left">Tunjangan Lain-Lain</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($jml_tambahan); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">&nbsp;</td>
                                        <td width="10%" align="right">&nbsp;</td>
                                        <td width="40%" align="right">--------------------</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">Total Pendapatan</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($gapok + $jml_uangmakan + $jml_uangtransport + $jml_uanglembur + $jml_tambahan); ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="5%" align="center">&nbsp;
                            </td>
                            <td width="35%" align="left" valign="top">&nbsp;
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                    <tr>
                                        <td width="35%" align="left"><strong>Potongan</strong></td>
                                    </tr>   
                                    <tr>
                                        <td width="40%" align="left">Absensi</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($jml_potonganabsensi); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">Asuransi</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($asuransi); ?></td>
                                    </tr>                           
                                    <tr>
                                        <td width="40%" align="left">Potongan Lain-lain</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($jml_potongan); ?></td>
                                    </tr>                            
                                    <tr>
                                        <td width="40%" align="left">Potongan PPH</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($jml_potonganpph23); ?></td>
                                    </tr>                            
                                    <tr>
                                        <td width="40%" align="left">Biaya Transfer</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($jml_potongantransfer); ?></td>
                                    </tr>                            
                                    <tr>
                                        <td width="40%" align="left">&nbsp;</td>
                                        <td width="10%" align="center">&nbsp;</td>
                                        <td width="40%" align="right">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">&nbsp;</td>
                                        <td width="10%" align="center">&nbsp;</td>
                                        <td width="40%" align="right">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">&nbsp;</td>
                                        <td width="10%" align="right">&nbsp;</td>
                                        <td width="40%" align="right">--------------------</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="left">Total Potongan</td>
                                        <td width="10%" align="center">:</td>
                                        <td width="40%" align="right"><?php echo number_format($jml_potonganabsensi + $asuransi + $jml_potongan+jml_potongantransfer+$jml_potonganpph23); ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="5%" align="center">&nbsp;
                            </td>
                            <td width="20%" align="left" valign="top">&nbsp;
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                    <tr>
                                        <td width="35%" align="left"><strong>TAKE HOME PAY</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="center"><?php echo number_format(($gapok + $jml_uangmakan + $jml_uangtransport + $jml_uanglembur + $jml_tambahan) - ($jml_potongantransfer + $jml_potonganabsensi + $asuransi + $jml_potongan + $jml_potonganpph23)); ?></td>
                                        <td width="30%" align="left">&nbsp;</td>
                                        <td width="30%" align="right">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="center">====================</td>
                                        <td width="10%" align="center">&nbsp;</td>
                                        <td width="40%" align="right">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="center">TTD</td>
                                        <td width="10%" align="center">&nbsp;</td>
                                        <td width="40%" align="right">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr >
                        <!-- TOTAL -->                
                    </table>	
                </td>
            </tr>

        </table>
    </body>
</html>

