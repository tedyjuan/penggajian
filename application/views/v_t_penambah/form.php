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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="periode_gaji">Periode Gaji<span class="err_periode_gaji required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="periode_gaji" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['periode_gaji'])) ? $default['periode_gaji'] : ''; ?>"
                           <?php echo (isset($default['readonly_periode_gaji'])) ? $default['readonly_periode_gaji'] : ''; ?>      
                           >
                </div>
            </div>
			<!-- START -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_penambah">Parameter<span class="err_id_penambah required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_penambah" name="id_penambah" >
                        <?php foreach ($default['id_penambah'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nilai">Nilai<span class="err_catatan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" id="nilai" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['nilai'])) ? $default['nilai'] : ''; ?>"
                           <?php echo (isset($default['readonly_nilai'])) ? $default['readonly_nilai'] : ''; ?>      
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

	   $( "#periode_gaji" ).datepicker();
	
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
                                    id_penambah: $("#id_penambah").val(),
									id_karyawan: $("#id_karyawan").val(),
									periode_gaji: $("#periode_gaji").val(),
									catatan: $("#catatan").val(),
									nilai: $("#nilai").val(),
									
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.hasil == 'true') {
                                               load_form(urlindex);
                                            } else {
                                                $(".err_id_karyawan").html(data.err_id_karyawan).fadeIn('slow');
												$(".err_id_penambah").html(data.err_id_penambah).fadeIn('slow');
												$(".err_periode_gaji").html(data.err_periode_gaji).fadeIn('slow');
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