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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nomor_spkl">Nomor SPKL<span class="err_nomor_spkl required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="nomor_spkl" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['nomor_spkl'])) ? $default['nomor_spkl'] : ''; ?>"
                           <?php echo (isset($default['readonly_nomor_spkl'])) ? $default['readonly_nomor_spkl'] : ''; ?>      
                           >
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal_kehadiran">Tanggal Kehadiran<span class="err_tanggal_kehadiran required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="tanggal_kehadiran" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['tanggal_kehadiran'])) ? $default['tanggal_kehadiran'] : ''; ?>"
                           <?php echo (isset($default['readonly_tanggal_kehadiran'])) ? $default['readonly_tanggal_kehadiran'] : ''; ?>      
                           >
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mulai_lembur">Mulai Lembur<span class="err_mulai_lembur required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="mulai_lembur" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['mulai_lembur'])) ? $default['mulai_lembur'] : ''; ?>"
                           <?php echo (isset($default['readonly_mulai_lembur'])) ? $default['readonly_mulai_lembur'] : ''; ?>      
                           >
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="selesai_lembur">Selesai Lembur<span class="err_selesai_lembur required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="selesai_lembur" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['selesai_lembur'])) ? $default['selesai_lembur'] : ''; ?>"
                           <?php echo (isset($default['readonly_selesai_lembur'])) ? $default['readonly_selesai_lembur'] : ''; ?>      
                           >
                </div>
            </div>
			
			
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catatan">Catatan<span class="err_catatan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="catatan" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['catatan'])) ? $default['catatan'] : ''; ?>"
                           <?php echo (isset($default['readonly_catatan'])) ? $default['readonly_catatan'] : ''; ?>      
                           >
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

	   $( "#tanggal_kehadiran" ).datepicker();
	   $('#mulai_lembur').datetimepicker();
	   $('#selesai_lembur').datetimepicker();
	
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
									nomor_spkl: $("#nomor_spkl").val(),
									tanggal_kehadiran: $("#tanggal_kehadiran").val(),
									mulai_lembur: $("#mulai_lembur").val(),
									selesai_lembur: $("#selesai_lembur").val(),
									catatan: $("#catatan").val(),
									
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.hasil == 'true') {
                                               load_form(urlindex);
                                            } else {
                                                $(".err_id_karyawan").html(data.err_id_karyawan).fadeIn('slow');
												$(".err_nomor_spkl").html(data.err_nomor_spkl).fadeIn('slow');
												$(".err_tanggal_kehadiran").html(data.err_tanggal_kehadiran).fadeIn('slow');
												$(".err_mulai_lembur").html(data.err_mulai_lembur).fadeIn('slow');
												$(".err_selesai_lembur").html(data.err_selesai_lembur).fadeIn('slow');
												$(".err_catatan").html(data.err_catatan).fadeIn('slow');
												

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