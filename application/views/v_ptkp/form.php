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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status<span class="err_status required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="status" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['status'])) ? $default['status'] : ''; ?>"
                           <?php echo (isset($default['readonly_status'])) ? $default['readonly_status'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="keterangan">Keterangan<span class="err_keterangan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="keterangan" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['keterangan'])) ? $default['keterangan'] : ''; ?>"
                           <?php echo (isset($default['readonly_keterangan'])) ? $default['readonly_keterangan'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nominal_tahunan">Biaya per 1 tahun<span class="err_nominal_tahunan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="nominal_tahunan" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['nominal_tahunan'])) ? $default['nominal_tahunan'] : ''; ?>"
                           <?php echo (isset($default['readonly_nominal_tahunan'])) ? $default['readonly_nominal_tahunan'] : ''; ?>      
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
                                    status: $("#status").val(),
                                    keterangan: $("#keterangan").val(),
                                    nominal_tahunan: $("#nominal_tahunan").val(),
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.hasil == 'true') {
                                                load_form(urlindex);
                                            } else {
                                                $(".err_status").html(data.err_status
                                                        ).fadeIn('slow');

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