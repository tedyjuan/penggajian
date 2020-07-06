<div class="x_panel">
    <div class="x_title">
        <h2><?php echo $title ?></h2>                 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <p class="text-muted font-13 m-b-30">
            <!-- for descriotion in here > <-->
        </p>
        <table id="datatable-slipgaji" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Periode Gaji</th>
                    <th>Total Gaji Harian</th>
                    <th>Total Potongan PPH</th>
                    <th>Total Biaya Transfer</th>
                    <th>Total Potongan</th>
                    <th>Total Penambahan</th>  
                    <th>Biaya Asuransi</th>  
                    <th>Total Uang Makan</th>  
                    <th>Total Uang Transport</th>      
                    <th>Total Uang Lembur</th>
                    <th>Take Home Pay</th>                   
                </tr>
            </thead>

        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        /* start datatable */
        var handleDataTableButtons = function () {
            if ($("#datatable-slipgaji").length) {
                $("#datatable-slipgaji").DataTable({
                    'order': [[0, 'asc']],
                    keys: true,
                    fixedHeader: true,
                    deferRender: true,
                    scrollY: 380,
                    scrollCollapse: true,
                    scroller: false,
                    dom: "Bfrtip",
                    "bRetrieve": true,
                    "bDestroy": true,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        ['10 rows', '25 rows', '50 rows', 'Show all']
                    ],
                    buttons: [
                       {
                            text: 'Print Slip Gaji',
                            key: '1',
                            className: "btn-sm",
                            action: function (e, dt, node, config) {
                                printslipgaji();
                            }
                        },                       
                        {
                            extend: "copy",
                            key: '2',
                            className: "btn-sm"
                        },
                        {
                            extend: "csv",
                            key: '3',
                            className: "btn-sm"
                        },


                    ],
                    responsive: true,
                    "ajax": {
                        "url": '<?php echo $url_grid; ?>',
                        "type": 'POST',
                    },
                    "columns": [
                        {"data": "nik"},
                        {"data": "nama"},
                        {"data": "tgl_posting"},
                        {"data": "jml_gajiharian"},
                        {"data": "jml_potonganpph23"},
                        {"data": "jml_potongantransfer"},
                        {"data": "jml_potongan"},
                        {"data": "jml_tambahan"},
                        {"data": "asuransi"},
                        {"data": "jml_uangmakan"},
                        {"data": "jml_uangtransport"},
                        {"data": "jml_uanglembur"},
                        {"data": "gaji_bersih"},
    
                    ]
                });
            }
        };
        TableManageButtons = function () {
            "use strict";
            return {
                init: function () {
                    handleDataTableButtons();
                }
            };
        }();
        TableManageButtons.init();
    });
    /* end datatable */


function printslipgaji(){

load_form('<?php echo $url_slipgaji; ?>');

}
   

</script>