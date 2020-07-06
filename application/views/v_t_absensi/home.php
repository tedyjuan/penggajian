<div class="x_panel">
    <div class="x_title">
        <h2><?php echo $title ?></h2>                 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <p class="text-muted font-13 m-b-30">
            <!-- for descriotion in here > <-->
        </p>
        <table id="datatable-t_absensi" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nama Karyawan</th>
					<th>Tanggal Absensi</th>
					<th>Status Kehadiran</th>
					
                    <th>Action</th>                   
                </tr>
            </thead>

        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        /* start datatable */
        var handleDataTableButtons = function () {
            if ($("#datatable-t_absensi").length) {
                $("#datatable-t_absensi").DataTable({
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
                            text: '+ Add',
                            key: '1',
                            className: "btn-sm",
                            action: function (e, dt, node, config) {
                                adddata();
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

                        {
                            extend: "print",
                            key: '5',
                            className: "btn-sm"
                        },
						
						 {
                            text: 'importabsensi',
                            key: '6',
                            className: "btn-sm",
                            action: function (e, dt, node, config) {
                                importabsensi();
                            }
                        },
                    ],
                    responsive: true,
                    "ajax": {
                        "url": '<?php echo $url_grid; ?>',
                        "type": 'POST',
                    },
                    "columns": [
                        {"data": "nama"},
						{"data": "tgl_absensi"},
						{"data": "status_kehadiran"},
						
                        {
                            "data": "id_absensi", "width": "100px", "sClass": "left",
                            "bSortable": false,
                            "mRender": function (data, type, row) {
                                var btn = "";
                                btn = btn + "<div class='btn-group'>";
                                btn = btn + " <button onClick='ParamFunc.editdata(" + row.id_absensi+ ")' class='btn btn-xs btn-info' type='button'><i class='fa fa-edit'></i></button>";
                                btn = btn + " <button onClick='ParamFunc.deletedata(" + row.id_absensi + ")' class='btn btn-xs btn-danger' type='button'><i class='fa fa-trash'></i></button>";
                                btn = btn + "</div>";
                                return btn;
                            }
                        }
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



    /*start edit, delete  function */
    var ParamFunc = {
        editdata: function (id) {
            load_form('<?php echo $url_edit; ?>' + '/' + id, 'Edit Data');
        },
        deletedata: function (id) {
            $('#confirmDelete').modal('show');
            $("#confirmDelete  input[name=id]").val(id);
        }
    }
    /*end edit, delete  function */

    //start delete data
    $("#confirmDelete button[action=delete]").click(function () {
        var url;
        url = '<?php echo $url_delete ?>';
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            cache: false,
            data: {
                id: $("#confirmDelete input[name=id]").val()
            },
            success: function (data) {
                $('#confirmDelete').modal('hide');
                $('#datatable-t_absensi').dataTable().fnReloadAjax();
            }
        });
    });
    //end delete data

    /*start add function */
    function adddata() {
        load_form('<?php echo $url_add; ?>', 'Add Data');
    }
    /*end add function */
	function importabsensi() {
        load_form('<?php echo $url_importabsensi; ?>', 'Import Absensi');
    }

   

</script>