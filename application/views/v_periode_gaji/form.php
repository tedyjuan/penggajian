<div class="x_panel">
    <div class="x_title">
        <h2>Form <?php echo 'Proses penggajian' ?><small></small></h2>      
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />

        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggalposting">Posting Tanggal<span class="err_type required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="tanggalposting" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['tanggalposting'])) ? $default['tanggalposting'] : ''; ?>"
                           <?php echo (isset($default['readonly_tanggalposting'])) ? $default['readonly_tanggalposting'] : ''; ?>      
                           >
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="daritanggal">Dari Tanggal<span class="err_type required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="daritanggal" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['daritanggal'])) ? $default['daritanggal'] : ''; ?>"
                           <?php echo (isset($default['readonly_daritanggal'])) ? $default['readonly_daritanggal'] : ''; ?>      
                           >
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sampaitanggal">Sampai Tanggal<span class="err_type required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="sampaitanggal" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['sampaitanggal'])) ? $default['sampaitanggal'] : ''; ?>"
                           <?php echo (isset($default['readonly_sampaitanggal'])) ? $default['readonly_sampaitanggal'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="reset" id="cancel" class="btn btn-primary">Cancel</button>
                    <button type="submit" id ="submit" class="btn btn-success">Proses</button>
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

		 $("#daritanggal,#sampaitanggal,#tanggalposting" ).datepicker();

        buttonsave.click(
                function ()
                {

                    $.ajax(
                            {
                                type: "POST",
                                url: urlpost,
                                dataType: "json",
                                data: {
                                    daritanggal:  $("#daritanggal").val(),
                                    sampaitanggal: $("#sampaitanggal").val(),
									tanggalposting: $("#tanggalposting").val(),
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
										
											alert('proses selesai');
                                            
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