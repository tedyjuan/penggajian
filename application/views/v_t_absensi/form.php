<div class="x_panel">
    <div class="x_title">
        <h2>Form <?php echo $title ?><small></small></h2>      
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />

        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
            <!-- START -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_karyawan">Nama Karyawan<span class="err_id_karyawan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_karyawan" name="id_karyawan" >
                        <?php foreach ($default['id_karyawan'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
			<div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_absensi">Tanggal Absensi<span class="err_tgl_absensi required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="tgl_absensi" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['tgl_absensi'])) ? $default['tgl_absensi'] : ''; ?>"
                           <?php echo (isset($default['readonly_tgl_absensi'])) ? $default['readonly_tgl_absensi'] : ''; ?>      
                           >
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status_kehadiran">Status kehadiran<span class="err_status_kehadiran required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="status_kehadiran" name="status_kehadiran" >
                        <?php foreach ($default['status_kehadiran'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
			
			
			
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="reset" id="cancel" class="btn btn-primary">Cancel</button>
                    <button type="submit" id ="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        var buttonsave, buttoncancel, urlpost, urlindex, content;

        buttonsave = $('#submit');
        buttoncancel = $('#cancel');
        urlpost = '<?php echo $url_post; ?>';
        urlindex = '<?php echo $url_index; ?>';
        content = $("#contentdata");

	   $( "#tgl_absensi" ).datepicker();
	   
        buttonsave.click(
                function ()
                {

                    $.ajax(
                            {
                                type: "POST",
                                url: urlpost,
                                dataType: "json",
                                data: {
                                    id: $("#id").val(),
                                    
									id_karyawan: $("#id_karyawan").val(),
									tgl_absensi: $("#tgl_absensi").val(),
									status_kehadiran: $("#status_kehadiran").val(),
									
									
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.hasil == 'true') {
                                               load_form(urlindex);
                                            } else {
                                                $(".err_id_karyawan").html(data.err_id_karyawan).fadeIn('slow');
												$(".err_tgl_absensi").html(data.err_tgl_absensi).fadeIn('slow');
												$(".err_status_kehadiran").html(data.err_status_kehadiran).fadeIn('slow');
												
												

                                            }
                                        },
                                error: function (request, status, error) {
                                    alert(request.responseText + " " + status + " " + error);
                                }
                            });
                    return false;

                });

        buttoncancel.click(
                function ()
                {
                   load_form(urlindex);
                });




    });

</script>