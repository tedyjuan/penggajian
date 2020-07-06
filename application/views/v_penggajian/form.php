<div class="x_panel">
    <div class="x_title">
        <h2>Form <?php echo $title ?><small></small></h2>      
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />

        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_ptkp">Status PTKP<span class="err_id_ptkp required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_ptkp" name="id_ptkp" >
                        <?php foreach ($default['id_ptkp'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_bank">Nama Bank<span class="err_id_bank required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_bank" name="id_bank" >
                        <?php foreach ($default['id_bank'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_rekening">No Rekening<span class="err_no_rekening required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="no_rekening" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['no_rekening'])) ? $default['no_rekening'] : ''; ?>"
                           <?php echo (isset($default['readonly_no_rekening'])) ? $default['readonly_no_rekening'] : ''; ?>      
                           >
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="atas_nama">Atas Nama<span class="err_atas_nama required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="atas_nama" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['atas_nama'])) ? $default['atas_nama'] : ''; ?>"
                           <?php echo (isset($default['readonly_atas_nama'])) ? $default['readonly_atas_nama'] : ''; ?>      
                           >
                </div>
				</div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gapok">Gaji Pokok<span class="err_gapok required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="gapok" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['gapok'])) ? $default['gapok'] : ''; ?>"
                           <?php echo (isset($default['readonly_gapok'])) ? $default['readonly_gapok'] : ''; ?>      
                           >
                </div>
				</div>
				<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uang_makan">Uang Makan<span class="err_uang_makan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="uang_makan" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['uang_makan'])) ? $default['uang_makan'] : ''; ?>"
                           <?php echo (isset($default['readonly_uang_makan'])) ? $default['readonly_uang_makan'] : ''; ?>      
                           >
                </div>
				</div>
				<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uang_transport">Uang Transport<span class="err_uang_transport required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="uang_transport" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['uang_transport'])) ? $default['uang_transport'] : ''; ?>"
                           <?php echo (isset($default['readonly_uang_transport'])) ? $default['readonly_uang_transport'] : ''; ?>      
                           >
                </div>
				</div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="biaya_transfer">Biaya Transfer Bank<span class="err_biaya_transfer required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="biaya_transfer" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['biaya_transfer'])) ? $default['biaya_transfer'] : ''; ?>"
                           <?php echo (isset($default['readonly_biaya_transfer'])) ? $default['readonly_biaya_transfer'] : ''; ?>      
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
		$('#atas_nama').prop('readonly', true);
$("#id_karyawan").change(function(){
        var selecteddata = $("#id_karyawan option:selected").text();
        //alert("You have selected the country - " + selectedCountry);
	
		$("#atas_nama").val($.trim(selecteddata));
    });

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
                                    id_bank: $("#id_bank").val(),
									id_karyawan: $("#id_karyawan").val(),
									atas_nama:$("#atas_nama").val(),
									no_rekening: $("#no_rekening").val(),
									gapok: $("#gapok").val(),
									uang_makan: $("#uang_makan").val(),
									uang_transport: $("#uang_transport").val(),
                                    biaya_transfer:$("#biaya_transfer").val(),
                                    id_ptkp:$("#id_ptkp").val()
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.hasil == 'true') {
                                               load_form(urlindex);
                                            } else {
                                                $(".err_id_bank").html(data.err_id_bank).fadeIn('slow');
												$(".err_id_karyawan").html(data.err_id_karyawan).fadeIn('slow');
												$(".err_atas_nama").html(data.err_id_karyawan).fadeIn('slow');
												$(".err_no_rekening").html(data.err_no_rekening).fadeIn('slow');
												$(".err_gapok").html(data.err_gapok).fadeIn('slow');
												$(".err_uang_makan").html(data.err_uang_makan).fadeIn('slow');
												$(".err_uang_transport").html(data.err_uang_transport).fadeIn('slow');

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