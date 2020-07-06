<div class="x_panel">
    <div class="x_title">
        <h2>Laporan PPH23<small></small></h2>      
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
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

        $("#periode_gaji").datepicker();

        buttonsave.click(
                function ()
                {

                    $.ajax(
                            {
                                type: "POST",
                                url: urlpost,
                                dataType: "json",
                                data: {
                                    periode_gaji: $("#periode_gaji").val(),
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.valid == true) {
                                                window.open('<?php echo $url_exceldata; ?>' + '/' + data.tglproses);
                                            } else {
                                                alert(data.message);
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