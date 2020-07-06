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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pendidikan">Nama pendidikan<span class="err_type required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="nama_pendidikan" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['nama_pendidikan'])) ? $default['nama_pendidikan'] : ''; ?>"
                           <?php echo (isset($default['readonly_nama_pendidikan'])) ? $default['readonly_nama_pendidikan'] : ''; ?>      
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
                                    nama_pendidikan: $("#nama_pendidikan").val(),
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.hasil == 'true') {
                                               load_form(urlindex);
                                            } else {
                                                $(".err_nama_pendidikan").html(data.err_type).fadeIn('slow');

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