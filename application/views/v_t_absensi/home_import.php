<div class="panel">
<div class="panel_body">
 <h3 class="title-hero">
		Form Import</h3>
		<div class="example-box-wrapper">
  <form id="formdata"> 
         <div class="ln_solid"></div>
            <div class="form-group row">
				<label for="import" class="col-3 col-lg-2 col-form-label text-right">Import Excel</label>
				<input type="file" name="file">
			</div>
                <div class="col-sm-6>
				<p class="text-right">
                    <button type="submit"  class="btn btn-space btn-primary">Submit</button>
                    <button type="reset"  class="btn btn-space btn-secondary">Cancel</button>
					</p>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var form, formdata, url_index, url_post, id, actiondata;
        url_post = '<?php echo $url_post; ?>';
        url_index = '<?php echo $url_index; ?>';
       
        $("#formdata").on('submit', function (e) {
            e.preventDefault();
            
            $.ajax({
                url: url_post,
                type: "post",
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success:
                        function (data, text)
                        {
							load_form(url_index);
                            
                        },
                error: function (request, status, error) {
                    alert(request.responseText + " " + status + " " + error);
                }
            });
            return false;


        });
        $("#formdata").on('reset', function (e) {
            e.preventDefault();
            load_form(url_index);
        });
    });
</script>