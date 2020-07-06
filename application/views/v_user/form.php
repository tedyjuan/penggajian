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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username<span class="err_username required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="username" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['username'])) ? $default['username'] : ''; ?>"
                           <?php echo (isset($default['readonly_username'])) ? $default['readonly_username'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password<span class="err_password required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="password" id="password" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['password'])) ? $default['password'] : ''; ?>"
                           <?php echo (isset($default['readonly_password'])) ? $default['readonly_password'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullname">Fullname<span class="err_fullname required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fullname" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['fullname'])) ? $default['fullname'] : ''; ?>"
                           <?php echo (isset($default['readonly_fullname'])) ? $default['readonly_fullname'] : ''; ?>      
                           >
                </div>
            </div>
             <!-- START -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_id">Role<span class="err_role required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="role_id" name="role_id" >
                            <?php print_r($default['role_id']); foreach ($default['role_id'] as $row) { ?>
                                
                                <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                        <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                    <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                            <?php } ?>
                        </select>   
                </div>
            </div>   
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="err_email required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="email" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['email'])) ? $default['email'] : ''; ?>"
                           <?php echo (isset($default['readonly_email'])) ? $default['readonly_email'] : ''; ?>      
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
                                    id: $("#username").val(),
                                    username: $("#username").val(),
                                    password: $("#password").val(),
                                    fullname: $("#fullname").val(),
                                    role_id: $("#role_id").val(),
                                    email: $("#email").val(),
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.hasil == 'true') {
                                                content.fadeOut("slow", "linear");
                                                content.load(urlindex);
                                                content.fadeIn("slow");
                                            } else {
                                                $(".err_username").html(data.err_username).fadeIn('slow');
                                                $(".err_password").html(data.err_password).fadeIn('slow');
                                                $(".err_fullname").html(data.err_fullname).fadeIn('slow');
                                                $(".err_role").html(data.err_role).fadeIn('slow');

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
                    content.fadeOut("slow", "linear");
                    content.load(urlindex);
                    content.fadeIn("slow");

                });




    });

</script>